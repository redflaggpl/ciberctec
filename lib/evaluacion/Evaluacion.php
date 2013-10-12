<?php
/**
 * @Package: CATMAN
 * @subpackage EvaluacionTutores
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: Mayo 10, 2012
 * @File: Evaluacion.php
 * @Version: 1.0
 */
class Evaluacion {
	
	private $id;

	private $estudiante_id;
	
	private $tutor_id;
	
	private $curso_id;
	
	private $concepto_tutor;
	
	private $curso;
	
	public function Evaluacion($eid = ""){
		
		if($eid != "")
		{
			$e = $this->getEvaluacion($eid);
			$this->id = $e->id;
			$this->estudiante_id = $e->estudiante_id;
			$this->tutor_id = $e->tutor_id;
			$this->curso_id = $e->curso_id;
			$this->curso = $e->curso;
			$this->concepto_tutor = $e->concepto_tutor;
		}
		
	}
	
	/**
	 * Retorna un objeto con datos básicos de un registro de evaluación
	 * @param int $eid
	 * @return object
	 */
	public function getEvaluacion($eid)
	{
		$db = new DB();
		$sql = "SELECT 	e.id, e.estudiante_id, e.tutor_id, e.curso_id, e.concepto_tutor, "
		     . "c.catedra_id, ct.nombre AS curso "
		     . "FROM eval_tutores_estu e "
		     . "INNER JOIN cursos c ON e.curso_id = c.id "
		     . "INNER JOIN catedra ct ON c.catedra_id = ct.id "
		     . "WHERE e.id = $eid";
		return $db->queryUniqueObject($sql);
	}
	
	public function listar($curso = "", $tutor = "")
	{
		global $uid, $uperms, $starting;
		
		$and = "";
		
		if(!$uperms['evaluacion_w'])
		{
			$and .= "AND e.estudiante_id = '$uid'";
		}
		
		if($curso != "")
		{
			$and .= "AND ct.nombre LIKE  '%$curso%' ";
		}
		
		if($tutor != "")
		{
			$and .= "AND t.nombres LIKE  '%$tutor%' OR t.apellidos LIKE '%$tutor%' ";
		}
		
		$db = new DB();
		$sql = "SELECT e.id, e.estudiante_id, e.tutor_id, e.curso_id, e.concepto_tutor, "
		     . "CONCAT(u.nombres, ' ', u.apellidos) AS estudiante, ct.nombre, ct.nombre AS catedra, "
		     . "CONCAT(t.nombres, ' ', t.apellidos) AS tutor "
		     . "FROM  eval_tutores_estu e "
	 	     . "INNER JOIN usuarios u ON e.estudiante_id = u.id "
	 	     . "INNER JOIN usuarios t ON e.tutor_id = t.id "
	 	     . "INNER JOIN cursos c ON e.curso_id = c.id "
	 	     . "INNER JOIN catedra ct ON c.catedra_id = ct.id "
	 	     . $and
	 	     . " ORDER BY e.id DESC";
		$objpag = new Pagination($sql, $starting, 20, 'index2.php?com=evaluacion');
		$res = $objpag->result;
		
		$data = array();
		$x = 0;
		while($line = $objpag->fetchNextObject($res)){
			$data[$x]['id'] = $line->id;
			$data[$x]['estudiante_id'] = $line->estudiante_id;
			$data[$x]['estudiante'] = $line->estudiante;
			$data[$x]['curso_id'] = $line->curso_id;
			$data[$x]['curso'] = $line->catedra;
			$data[$x]['tutor_id'] = $line->tutor_id;
			$data[$x]['tutor'] = Utils::getNombreUsuario($line->tutor_id);
			$data[$x]['concepto'] = $line->concepto_tutor;
			$x++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Elfic_Smarty();
		$tpl->assign('data',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		$tpl->display('evaluacion'.DS.'evaluacionList.tpl');
	}
	
	/**
	 * arreglo de cursos del periodo vigente, en los que esta inscrito un estudiante
	 * @param int $id id de usuario del estudiante
	 * @return array();
	 */
	public function getCursosArray($id)
	{
		$pv = CatManUtils::getPeriodoVigente();
		$db = new DB();
		$sql = "SELECT 	ec.curso_id, c.catedra_id, c.tutor_id, ct.nombre AS catedra, "
		     . "CONCAT(nombres,  ' ', apellidos) AS tutor "
		     . "FROM estudiantes_cursos ec INNER JOIN cursos c ON ec.curso_id = c.id "
		     . "INNER JOIN catedra ct ON ct.id = c.catedra_id "
		     . "INNER JOIN usuarios u ON c.tutor_id = u.id "
		     . "WHERE ec.estudiante_id = $id AND c.periodo_id = $pv AND c.estado = '1'";
		$res = $db->query($sql);
		$data = array();
		while($line = $db->fetchNextObject($res))
		{
			$data[$line->curso_id] = $line->catedra." (".$line->tutor.")";
		}
		
		return $data;
	}
	
	/**
	 * @desc imprime plantilla con listado de cursos-tutores
	 *  que puede evaluar un estudiante
	 */
	public function listarCursos()
	{
		global $uid;
		
		$cursos = Evaluacion::getCursosArray($uid);
		$data = array();
		$i = 0;
		foreach($cursos as $id => $curso){
			$data[$i]['id'] = $id;
			$data[$i]['curso'] = $curso;
			$data[$i]['evaluado'] = $this->evaluado($id, $uid);
			$i++;
		}
		$tpl = new Elfic_Smarty();
		$tpl->assign('data',$data);
		$tpl->display('evaluacion'.DS.'cursosList.tpl');
	}
	
	/**
	 * Imprime formulario para que estudiante realice evaluación de tutor
	 */
	public function newEvaluacion($curso_id)
	{
		global $uid;
		$tpl = new Elfic_Smarty();
		//$tpl->assign('cursos', Evaluacion::getCursosArray($uid));
		$curso = $this->getCursoData($curso_id);
		$tpl->assign('curso', $curso->curso);
		$tpl->assign('cid', $curso_id);
		$tpl->assign('tutor', $curso->tutor);
		$tpl->assign('tutor_id', $curso->tutor_id);
		$p = $this->getPreguntas();
		$tpl->assign('data', $p);
		$tpl->display('evaluacion'.DS.'evaluacionNew.tpl');
	}
	
	
	/**
	 * Objeto con info básica de un curso
	 * @param int $id
	 * @return object
	 */
	private function getCursoData($id)
	{
		$sql = "SELECT c.catedra_id, c.tutor_id, ct.nombre as curso, "
		     . "CONCAT(nombres, ' ', apellidos) AS tutor "
		     . "FROM cursos c INNER JOIN catedra ct ON c.catedra_id = ct.id "
		     . "INNER JOIN usuarios u ON c.tutor_id  = u.id "
		     . "WHERE c.id = $id AND c.estado = 1 ";
		$db = new DB();
		return $db->queryUniqueObject($sql);
	}
	
	/**
	 * Arreglo de preguntas
	 * @return array
	 */
	public function getPreguntas()
	{
		$pr = new Preguntas();
		$p = $pr->getPreguntas();
		$data = array();
		$db = new DB();
		$i = 0;
		while($line = $db->fetchNextObject($p))
		{
			$data[$i]['id'] = $line->id;
			$data[$i]['pregunta']= $line->pregunta;
			$i++;
		}
		return $data;
	}
	
	public function setEvaluacion()
	{
		global $uid;
		
		$data['estudiante_id'] = $uid;
		$data['tutor_id'] = $_POST['tutor_id'];
		$data['curso_id'] = $_POST['curso_id'];
		$data['concepto_tutor'] = $_POST['concepto_tutor'];
		$data['periodo_id'] = CatManUtils::getPeriodoVigente();
		
		$db = new DB();
		if(!$db->perform('eval_tutores_estu', $data))
		{
			Elfic::cosRedirect('index2.php?com=evaluacion', 'Error en el registro. Contacte al administrador');
		} else {
			$eval_id  = $db->lastInsertedId();
			
			$valores = $_POST['respuesta'];
			$aLista=array_keys($_POST['respuesta']);
			foreach ($aLista as $indice){
				$val = $valores[$indice];
				$sql  = "INSERT INTO eval_tutores_resp (eval_id, pregunta_id, respuesta)"
				. "VALUES ('$eval_id', '$indice', '$val' )";
				$db = new DB();
				$db->execute($sql);
			}
			Elfic::cosRedirect('index2.php?com=evaluacion', 'Los resultados se grabaron satisfactoriamente');
		}
		
		
	}
	
	/**
	 * Su estudiante ya evaluo tutor - curso
	 * @param int $curso_id
	 * @param int $estudiante_id
	 * @return int boolean; 
	 */
	public function evaluado($curso_id, $estudiante_id)
	{
		$where = "estudiante_id = $estudiante_id AND curso_id = $curso_id ";
		
		$db = new DB();
		$res = $db->countOf('eval_tutores_estu', $where);
		if($res > 0)
		{
			return 1;
		} else {
			return 0;
		}
	}
	
	/**
	 * Un arreglo con las resultados de una evaluación de tutor
	 * @return array $data
	 */
	private function _getResultadosEvaluacion()
	{
		$db = new DB();
		$sql = "SELECT r.id, r.eval_id, r.pregunta_id, r.respuesta, p.pregunta "
		     . "FROM eval_tutores_resp r INNER JOIN eval_tutores_preg p ON r.pregunta_id = p.id "
		     . "WHERE r.eval_id = $this->id";
		$res = $db->query($sql);
		
		$data = array();
		$i = 0;
		while($line = $db->fetchNextObject($res))
		{
			$data[$i]['id'] = $line->id;
			$data[$i]['pregunta_id'] = $line->pregunta_id;
			$data[$i]['pregunta'] = $line->pregunta;
			$data[$i]['respuesta'] = Elfic::getIcon($line->respuesta); //Elfic::getBooleanVal($line->respuesta);
			$i++;
		}
		return $data;
	}
	
	public function viewEvaluacion()
	{
		$r = $this->_getResultadosEvaluacion();
		$tpl = new Elfic_Smarty();
		
		$tpl->assign('estudiante', Elfic::getNombreUsuario($this->estudiante_id));
		$tpl->assign('curso', $this->curso);
		$tpl->assign('tutor', Elfic::getNombreUsuario($this->tutor_id));
		$tpl->assign('concepto', $this->concepto_tutor);
		$tpl->assign('data', $this->_getResultadosEvaluacion());
		$tpl->display('evaluacion'.DS.'evaluacionView.tpl');
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getEstudianteId()
	{
		return $this->estudiante_id;
	}
	
	public function getTutorId()
	{
		return $this->tutor_id;
	}
	
	public function getCursoId()
	{
		return $this->curso_id;
	}
	
	public function getConceptoTutor()
	{
		return $this->concepto_tutor;
	}

}
?>