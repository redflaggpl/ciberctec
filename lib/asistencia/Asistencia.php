<?php

class Asistencia extends Elfic {
     
	function listAsistenciaTutores($tutor = "", $curso = "", $fini="", $ffin="")
	{
		global $uid, $uperms;
		$and = "";
		
		if(!$uperms['asistencia_w'])
		{
			$and = "AND usuario_id = $uid ";
		}
		
		if($tutor != '') $and .= "AND a.usuario_id = $tutor ";
		if($curso != '') $and .= "AND c.id = $curso ";
		//if($fini != '') $and .= "AND a.entrada BETWEEN '$fini' AND '$ffin' ";
		if($fini != '') $and .= "AND a.entrada >= '".$fini." 00-00-01' ";
		if($ffin != '') $and .= "AND a.entrada <= '".$ffin." 23-59-59' ";
		
		$db = new DB();
		$sql = "SELECT  a.id, a.usuario_id, a.entrada, a.salida, "
		     . "c.grupo, c.dia, "
		     . "at.curso_id, a.comentarios, ct.id AS catedraId, "
		     . "CONCAT(u.nombres, ' ', u.apellidos) AS tutor, ct.nombre AS catedra "
		     . "FROM ".TBL_ASISTENCIA." a INNER JOIN " . TBL_ASIST_TUT 
		     . " at ON at.asistencias_id = a.id "
		     . "INNER JOIN " . TBL_CURSOS . " c ON at.curso_id = c.id "
		     . "INNER JOIN " . TBL_USUARIOS . " u ON u.id = a.usuario_id "
		     . "INNER JOIN " . TBL_CATEDRAS . " ct ON c.catedra_id = ct.id "
		     . "WHERE a.id > 0 $and";
		//$sql = "SELECT * FROM ".TBL_ASIST_TUT;
		
		if(isset($_GET['starting'])){
			$starting=$_GET['starting'];
		}else{
			$starting=0;
		}
		$url = "index2.php?com=asistencia"
		     . "&fini=$fini&ffin=$ffin&catedra=$curso&tutor=$tutor";
		$objpag = new Pagination($sql, $starting, 20, $url);		
		$res = $objpag->result;
		
		$data = array();
		$x = 0;
		while($line = $objpag->fetchNextObject($res)){
			$data[$x]['id'] = $line->id;
			$data[$x]['usuario_id'] = $line->usuario_id;
			$data[$x]['tutor'] = $line->tutor;
			$data[$x]['entrada'] = $line->entrada;
			$data[$x]['salida'] = $line->salida;
			$data[$x]['curso_id'] = $line->curso_id;
			$data[$x]['catedra'] = $line->catedra;
			$data[$x]['grupo'] = $line->grupo;
			$data[$x]['dia'] = Elfic::getDiaNombre($line->dia);
			$data[$x]['comentarios'] = $line->comentarios;
			$x++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Elfic_Smarty();
		$tpl->assign('tutores', Grupos::getUsuariosGrupo(4));
		$tpl->assign('sel_tutor', $tutor);
		$tpl->assign('cursos', Cursos::getCursosTutorArray($tutor));
		$tpl->assign('sel_curso', $curso);
		$tpl->assign('lista',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		$tpl->display('asistencia/asistenciaTutoresList.tpl');
		
	}
	
	function listAsistenciaFuncionarios($funcionario = "")
	{
		global $uid, $uperms;
		$and = "";
	
		if(!$uperms['asistencia_w'])
		{
			$and = "AND usuario_id = $uid ";
		}
	
		if($funcionario != '') $and .= "AND a.usuario_id = $funcionario ";
	
		$db = new DB();
		$sql = "SELECT  a.id, a.usuario_id, a.entrada, a.salida, a.comentarios, "
		. "CONCAT(u.nombres, ' ', u.apellidos) AS funcionario "
		. "FROM ".TBL_ASISTENCIA." a INNER JOIN " . TBL_USUARIOS . " u ON u.id = a.usuario_id "
		. "WHERE a.id > 0 $and AND a.id NOT IN (SELECT asistencias_id FROM asistencias_tutores "
		. "WHERE asistencias_id = a.id)";
	
		if(isset($_GET['starting'])){
		$starting=$_GET['starting'];
		}else{
		$starting=0;
		}
	
		$objpag = new Pagination($sql, $starting, 20,
				'index2.php?com=asistencia&do=list_fun');
				$res = $objpag->result;
	
				$data = array();
		$x = 0;
		while($line = $objpag->fetchNextObject($res)){
		$data[$x]['id'] = $line->id;
		$data[$x]['usuario_id'] = $line->usuario_id;
		$data[$x]['funcionario'] = $line->funcionario;
		$data[$x]['entrada'] = $line->entrada;
		$data[$x]['salida'] = $line->salida;
		$data[$x]['comentarios'] = $line->comentarios;
		$x++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Elfic_Smarty();
		$tpl->assign('funcionarios', Grupos::getUsuariosGrupo(3));
		$tpl->assign('sel_func', $funcionario);
		$tpl->assign('lista',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		$tpl->display('asistencia/asistenciaFuncionariosList.tpl');
	
	}
	
	
	function setAsistenciaTutor()
	{
	    global $uid;
		
	    $curso = (int) $_REQUEST['curso_id'];
		$data['usuario_id'] = $uid;
		$data['tipo_registro'] = $this->getTipoRegistro($uid, $curso);
		$data['fecha_hora'] = Utils::now();
		$data['curso_id'] = $curso;
		$data['comentarios'] = "";
		$data['agendas_tutorias_id'] = 1;
		
		//$this->_prepareRegistro($data);
		$db = new DB();
		$db->perform(TBL_ASIST_TUT, $data);
	}
	
	
	/**
	 * @desc Verifica el tipo de registro anterior, entrada o salida
	 * Falso si el registro corresponde al mismo tipo del anterior
	 * @param char tipo e=entrada, s=salida
	 * @return boolean
	 */
	function check($tipo, $usuario)
	{
		$db = new DB();
		$sql = "SELECT tipo_registro FROM ".TBL_ASIST_TUT
		     . " WHERE usuario_id = $usuario ORDER BY id DESC ";
		$res = $db->queryUniqueObject($sql);
		if($res->tipo_registro != $tipo)
		{
			return true;
		}
		
		return false;
	}
	
	
	private function getTipoRegistro($usuario, $curso = "")
	{
	    $db = new DB();
	    $iniHoy = date("Y-m-d"). " 00:00:00";
	    $finHoy = date("Y-m-d"). " 23:59:59";
	    $now = Elfic::now();
	    
		$sql = "SELECT tipo_registro FROM ".TBL_ASIST_TUT
		     . " WHERE usuario_id = $usuario AND fecha_hora > '$iniHoy' "
		     . " AND curso_id = $curso ORDER BY id DESC ";
		$res = $db->queryUniqueObject($sql);
		
		if(!$res->tipo_registro || $res->tipo_registro == 's')
		{
			return 'e';
		} else {
			return 's';
		}
		return 'e';
	}
	
	private function _getIconAsistencia($tipo)
	{
		if($tipo == 'e') $icon = "door_in.png";
		else $icon = "door_out.png";
		
		return $icon;
	}
	
	
}

?>