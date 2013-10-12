<?php

class Cursos extends Elfic {
	
	/**
	 * Id del usuario.
	 *
	 * @var string
	 */
	private $_id;
	
	
	/**
	 * Si envia id al constructor inicializa usuario.
	 *
	 * @param int $id
	 */
	function __construct($id = ''){
		if($id != ''){
			$this->_id = $id;
		}
	}
	
	/**
	 * @desc retorna objeto con datos básicos de usuario
	 * @param $id id del usuario
	 * @return object
	 */
	function getCurso($id){
		$db = new DB();
		$sql  = "SELECT * FROM cursos WHERE id = '$id'";
		return $db->queryUniqueObject($sql);
	}
	
	/**
	 * Imprime vista de creación de curso
	 *
	 */
	public function nuevo(){
		global $uid;
	
		$tpl = new Elfic_Smarty();
		$tpl->assign('tutores', Grupos::getUsuariosGrupo(4));
		$tpl->assign('programas', CatManUtils::getProgramasArray());
		//$tpl->assign('catedras',$this->_getCatedras());
		$tpl->assign('grupos',$this->_getGrupos());
		$tpl->assign('periodos',$this->_getPeriodos());
		$tpl->assign('dias',CatManUtils::getDiasArray());
		$tpl->assign('horas',CatManUtils::getHorasArray());
		$tpl->assign('estados',$this->getEstadosArray());
		$tpl->display('cursos/cursosNew.tpl');
	}
	
	/**
	 * @desc Form de edición de curso
	 */
	public function edit(){
		global $uid;
	
		$tpl = new Elfic_Smarty();
		$data = $this->getCurso($this->_id);
		$tpl->assign('cid',$data->id);
		$tpl->assign('tutores',Grupos::getUsuariosGrupo(4));
		$tpl->assign('tutor_id',$data->tutor_id);
		$tpl->assign('catedras',$this->_getCatedras());
		$tpl->assign('catedra_id',$data->catedra_id);
		$tpl->assign('grupos',$this->_getGrupos());
		$tpl->assign('grupo',$data->grupo);
		$tpl->assign('periodos',$this->_getPeriodos());
		$tpl->assign('periodo_id',$data->periodo_id);
		$tpl->assign('dias',CatManUtils::getDiasArray());
		$tpl->assign('dia', $data->dia);
		$tpl->assign('horas',CatManUtils::getHorasArray());
		$tpl->assign('hora',$data->hora);
		$tpl->assign('estados',$this->getEstadosArray());
		$tpl->assign('estado',$data->estado);
		$tpl->assign('agenda',$this->_getAgenda($this->_id));
		$tpl->display('cursos/cursosEdit.tpl');
	}
	
	/**
	 * @desc Registra datos básicos de un Usuario. Insert o Update
	 * @param string $action "new" para nuevo
	 * @return void
	 */
	public function save($action=null){
		
		$db = new DB();
		$data = array();
		
		$data['catedra_id'] = $db->sqlInput($_REQUEST['catedra_id'], 'int');
		$data['grupo'] = $db->sqlInput($_REQUEST['grupo'], 'text');
		$data['tutor_id'] = $db->sqlInput($_REQUEST['tutor_id'], 'int');
		$data['periodo_id'] = $db->sqlInput($_REQUEST['periodo_id'], 'int');
		$data['dia'] = $db->sqlInput($_REQUEST['dia'], 'int');
		$data['hora'] = $db->sqlInput($_REQUEST['hora'], 'text');
		$data['estado'] = $db->sqlInput($_REQUEST['estado'], 'int');
	
		if($action == "new"){
			$db->perform('cursos', $data);
			$id = $db->lastInsertedId();
			$msg = MSG_CURSO_CREADO;
		} else {
			$id	= $db->sqlInput($_REQUEST['cid'], 'int');
			$db->perform('cursos', $data, 'update', 'id='.$id);
			$msg = MSG_CURSO_UPDATE;
		}
		$url = "index2.php?com=cursos&do=view&cid=".$id;
		Elfic::cosRedirect($url, $msg);
		var_dump($data);
	}
		
	/**
	 * Verifica si combinación catedra-periodo-tutor existe
	 * @param String $login
	 * @param int $id
	 * @return boolean
	 */
	function chkCurso($catedra_id, $periodo_id, $tutor_id)
	{
		$where = "catedra_id = $catedra_id AND tutor_id = $tutor_id AND periodo_id = $periodo_id ";
		
		$db = new DB();
		
		if($db->countOf('cursos', $where) > 0){
			return true;
		}
		return false;
	}

	public function listAll($curso = "")
	{
		global $uid, $uperms;
		
		$and = "";
		
		if(!$uperms['cursos_w'])
		{
			$and .= "AND c.tutor_id = '$uid' ";
		}
		
		if($curso != "")
		{
			$and .= "AND ct.nombre LIKE '%$curso%' ";
		}
		
		$db = new DB();
		$sql = "SELECT c.id, c.grupo, c.dia, c.hora, c.estado, ct.nombre, c.tutor_id, "
		     . "CONCAT(p.anio,'-',p.semestre) AS periodo, "
		     . "pr.programa, CONCAT(u.nombres, ' ', u.apellidos) AS tutor FROM cursos c "
	 	     . "INNER JOIN catedra ct ON c.catedra_id = ct.id "
	 	     . "INNER JOIN periodos p ON c.periodo_id = p.id "
	 	     . "INNER JOIN programas pr ON ct.programas_id = pr.id "
	 	     . "INNER JOIN usuarios u ON c.tutor_id = u.id "
	 	     . "WHERE c.id > 0 $and";
		
		if(isset($_GET['starting'])){
			$starting=$_GET['starting'];
		}else{
			$starting=0;
		}
		
		$objpag = new Pagination($sql, $starting, 20, 'index2.php?com=cursos&do=search');
		$res = $objpag->result;
		
		$data = array();
		$x = 0;
		while($line = $objpag->fetchNextObject($res)){
			$data[$x]['id'] = $line->id;
			$data[$x]['programa'] = $line->programa;
			$data[$x]['grupo'] = $line->grupo;
			$data[$x]['curso'] = $line->nombre;
			$data[$x]['periodo'] = $line->periodo;
			$data[$x]['tutor'] = $line->tutor;
			$data[$x]['tutor_id'] = $line->tutor_id;
			$data[$x]['dia'] = CatManUtils::getDiaNombre($line->dia);
			$data[$x]['hora'] = $line->hora;
			$data[$x]['agenda'] = $this->siTieneAgenda($line->id);
			$data[$x]['estado'] = Elfic::getBlockIcon($line->estado);
			$x++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Elfic_Smarty();
		$tpl->assign('data',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		$tpl->display('cursos/cursosList.tpl');
	}
	
	
	/*
	 * @desc imprime cadena con options para combo de cursos de un tutor
	 *       para consultas ajax
	 * @param int $tutor id del tutor
	 * @return void
	 */ 
	public function getCursosTutor($tutor)
	 {
	 	$sql = "SELECT c.id, c.grupo, c.dia, ct.nombre, ct.semestre, "
	 	     . "CONCAT(p.anio,'-',p.semestre) as periodo "
	 	     . "FROM cursos c "
	 	     . "INNER JOIN catedra ct ON c.catedra_id = ct.id "
	 	     . "INNER JOIN periodos p ON c.periodo_id = p.id "
	 	     . "WHERE c.tutor_id = '$tutor'";
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	$output = "Curso: <select name=\"catedra\" id=\"catedra\" >"
	 	        . "    <option value=\"\">--</option>";
	 	        
	 	while ($line = $db->fetchNextObject($res))
	 	{
	 		$output .= "<option value='".$line->id."'>".$line->nombre ." ($line->semestre) "
	 		        . " $line->grupo - " . Elfic::getDiaNombre($line->dia) . " | " 
	 		        . " (" . $line->periodo . ")</option>";
	 	}
	 	$output .= "</select>";
	 	echo $output;
	 }
	 
	 /*
	  * @desc arreglo para combo de cursos de un tutor
	  * @param int $tutor id del tutor
	  * @return void
	 */
	 public function getCursosTutorArray($tutor = "")
	 {
	 	$where = "";
	 	
	 	if($tutor != "")
	 	{
	 		$where = "WHERE c.tutor_id = '$tutor'";
	 	}
	 	
	 	$sql = "SELECT c.id, ct.nombre, p.anio, p.semestre FROM cursos c "
	 	. "INNER JOIN catedra ct ON c.catedra_id = ct.id "
	 	. "INNER JOIN periodos p ON c.periodo_id = p.id "
	 	. $where . " ORDER BY c.id DESC ";
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	$data = array();
	 	while ($line = $db->fetchNextObject($res))
	 	{
		 	$data[$line->id] = $line->nombre. " | " . $line->anio . "-" . $line->semestre;
	 	}
	 	
	 	return $data;
	 }
	 
	 /**
	  * Arreglo de cursos activos asociados a un estudiante
	  * @param int $id id del estudiante
	  */
	 public function getCursosEstudianteArray($eid = "")
	 {
	 	
	 	$sql = "SELECT c.id, ct.nombre, p.anio, p.semestre FROM cursos c "
	 	. "INNER JOIN catedra ct ON c.catedra_id = ct.id "
	 	. "INNER JOIN periodos p ON c.periodo_id = p.id "
	 	. "WHERE c.id IN(SELECT curso_id FROM estudiantes_cursos WHERE estudiante_id = $eid) "
	 	. "ORDER BY c.id DESC ";
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	$data = array();
	 	$i = 0;
	 	while ($line = $db->fetchNextObject($res))
	 	{
	 		$data[$i]['id'] = $line->id;
	 		$data[$i]['curso'] = $line->nombre. " | " . $line->anio . "-" . $line->semestre;
	 		$i++;
	 	}
	 	 
	 	return $data;
	 }
	 
	 /*
	  * Arreglo de catedras activas, para creación de cursos
	  * @return array id->nombre
	  */
	 private function _getCatedras()
	 {
	 	
	 	$sql = "SELECT c.id, c.nombre, p.programa, c.semestre FROM catedra c "
	 	     . "INNER JOIN programas p ON c.programas_id = p.id "
	 	     . "WHERE c.estado = 1 ORDER BY c.semestre ASC";
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	$data = array();
	 	while($line = $db->fetchNextObject($res))
	 	{
	 		$data[$line->id] = $line->nombre . "(" . $line->semestre. "-". $line->programa ." )";
	 	}
	 	return $data;
	 }
	 
	 private function _getPeriodos()
	 {
	 	$sql = "SELECT id, CONCAT(anio, '-', semestre) AS periodo FROM periodos ORDER BY id DESC";
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	while($line = $db->fetchNextObject($res))
	 	{
	 		$data[$line->id] = $line->periodo;
	 	}
	 	return $data;
	 }
	 
	 /**
	  * @desc Un arreglo con estados de activo o inactivo
	  * @param void
	  * @return array
	  */
	 function getEstadosArray()
	 {
	 	$estado = array();
	 	$estado['1']="Activo";
	 	$estado['0']="Inactivo";
	 	return $estado;
	 }
	 
	 private function siTieneAgenda($curso_id)
	 {
	 	$db = new DB();
	 	return $db->countOf('agendas', 'curso_id='.$curso_id);
	 }
	 
	 /**
	  * Carga los datos de agenda del curso
	  */
	 private function _getAgenda($cid)
	 {
	 	$db = new DB();
	 	$sql = "SELECT a.id, a.comentarios, a.fecha "
	 	     . "FROM agendas a WHERE a.curso_id = $cid";
	 	$res = $db->queryUniqueObject($sql);
	 	if(!$res)
	 	{
	 		return 0;
	 	} else {
	 		$data = array();
	 		$data['id'] = $res->id;
	 		$data['comentarios'] = $res->comentarios;
	 		$data['fecha'] = $res->fecha;
	 		return $data;
	 	}
	 	
	 }
	 
	 /*
	  * Retorna el id del tutor asignado a un curso
	  * @param int $cid id del curso
	  * @return int id del tutor
	  */
	 public function getTutor($cid)
	 {
	 	$sql = "SELECT tutor_id FROM cursos WHERE id = $cid";
	 	$db = new DB();
	 	return $db->queryUniqueValue($sql);
	 }
	 
	 /**
	  * Cadena options cursos para combo ajax
	  * Si parametro $programas id != 0, filtra por programa
	  * @param int $programas_id
	  * @return array
	  */
	 public function getCursos($programas_id)
	 {
	 	$where = "";
	 	
	 	if($programas_id != "")
	 	{
	 		$where = "WHERE ct.programas_id = '$programas_id'";
	 	}
	 	
	 	$sql = "SELECT c.id, ct.nombre, p.anio, p.semestre FROM cursos c "
		 	. "INNER JOIN catedra ct ON c.catedra_id = ct.id "
		 	. "INNER JOIN periodos p ON c.periodo_id = p.id "
		// 	. "INNER JOIN programas pr ON c.programas_id = $programas_id "
		 	. $where . " ORDER BY c.id DESC ";
	 	
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	$output = "";
	 	$output = '<select name="cursos_id" id="cursos_id" class="required">';
	 	$output .= '<option value="">-- Seleccione --</option>';
		while ($line = $db->fetchNextObject($res))
	 	{
		 	$output .= '<option value="'.$line->id.'">';
		 	$output .= $line->id . " : " .$line->nombre. " | " . $line->anio . "-" . $line->semestre . '</option>';
			
	 	}
	 	$output .= "</select> ";
	 	echo $output;
	 }
	 
	 /**
	  * Arreglo de cursos
	  * Si parametro $programas id != 0, filtra por programa
	  * @param int $programas_id
	  * @return array
	  */
	 public function getCursosArray($programas_id="", $semestre="")
	 {
	 	$and = "";
	 	 
	 	if($programas_id != "")
	 	{
	 		$and .= "WHERE ct.programas_id = '$programas_id'";
	 	}
	 	
	 	if($semestre != "")
	 	{
	 		$and .= "WHERE p.semestre = '$semestre'";
	 	}
	 	 
	 	$sql = "SELECT c.id, ct.nombre, p.anio, p.semestre FROM cursos c "
		 	. "INNER JOIN catedra ct ON c.catedra_id = ct.id "
		 	. "INNER JOIN periodos p ON c.periodo_id = p.id "
		 	// 	. "INNER JOIN programas pr ON c.programas_id = $programas_id "
		 	. "WHERE c.id > 0 "
		 	. $and . " ORDER BY c.id DESC ";
	 	 
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	$data = array();
	 	while ($line = $db->fetchNextObject($res))
	 	{
	 		$data[$line->id] = $line->nombre. " | " . $line->anio . "-" . $line->semestre;
	 	}
	 	 
	 	return $data;
	 }
	 
	 /**
	  * Combo ajax catedras por programa y semestre
	  * @param int $programa_id
	  * @param $semestre
	  * @return String
	  */
	 public function getCatedrasCombo($programa_id = "", $semestre = "")
	 {
	 	
	 	$and = "";
	 	if($programa_id != "") 	$and .= "AND c.programas_id = $programa_id ";
	 	if($semestre != "")		$and .= "AND c.semestre = $semestre ";
	 	
	 	$sql = "SELECT c.id, c.nombre, p.programa, c.semestre FROM catedra c "
	 	     . "INNER JOIN programas p ON c.programas_id = p.id "
	 	     . "WHERE c.estado = 1 $and ORDER BY c.semestre ASC";
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	$out = "";
	 	$out .= '<select id="catedra_id" name="catedra_id">';
	 	while($line = $db->fetchNextObject($res))
	 	{
			$out .= '	<option value="'.$line->id.'">'. $line->nombre 
			     . " (" . $line->semestre . ')</option>';
	 	}
	 	$out .= "</select>";
	 	echo $out;
	 }
	 
	 public function _getGrupos()
	 {
	 	$data = array();
	 	$data['A'] = "A";
	 	$data['B'] = "B";
	 	$data['C'] = "C";
	 	return $data;
	 }
	 
}

?>