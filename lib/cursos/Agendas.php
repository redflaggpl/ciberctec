<?php

class Agendas extends Cursos {
	
	
	
	public function cargarAgenda($cid = "", $tutor_id = "")
	{
		global $uid, $uperms;
		
		$tpl = new Elfic_Smarty();
		if(!$uperms['cursos_w']) {
			$tpl->assign('tutores', "false");
			$tpl->assign('tutor', Elfic::getNombreUsuario($tutor_id));
		} else {
			$tpl->assign('tutores', Grupos::getUsuariosGrupo(4));
		}
		$tpl->assign('tutor_id', $tutor_id);
		if(!$uperms['cursos_w']) {
			$cursos = Cursos::getCursosTutorArray($uid);
		} else {
			$cursos = Cursos::getCursosTutorArray();
		}
		$tpl->assign('cursos', $cursos);
		$tpl->assign('curso', $cid);
		$tpl->display('cursos/agendasNew.tpl');
	}
	
	public function registrarAgenda()
	{
		$data = array();
		$data['curso_id'] = isset($_REQUEST['curso_id'])? $_REQUEST['curso_id'] : null;
		$data['tutor_id'] = isset($_REQUEST['tutor_id'])? $_REQUEST['tutor_id'] : null;
		$data['comentarios'] = isset($_REQUEST['comentarios'])? $_REQUEST['comentarios'] : null;
		$data['fecha'] = Elfic::now();
		
		$db = new DB();
	    $up = $this->upload($data['curso_id']);
		if($up == 1){
			$db = new DB();
			$db->perform('agendas', $data);
			$msg = MSG_AGENDA_REG_OK;
		} else {
			Elfic::cosRedirect('index2.php?com=cursos', $up);
		}
		Elfic::cosRedirect('index2.php?com=cursos', $msg);
	}
		
    public function upload($curso_id)
	{
	
		$msg = false;
		$handle = new Upload($_FILES['agenda']);
	
		if ($handle->uploaded) {
	
			$handle->Process('files');
		
			if ($handle->processed) {
				rename(FILES_PATH . $handle->file_dst_name, FILES_PATH . $curso_id.".pdf");
				return 1;
					 
			} else {
				$msg = $handle->error;
			}
			$handle-> Clean();
		
		} else {
			$msg = $handle->error;
		}
			 
		return $msg;
	}
	
	public function borrarAgenda($cid)
	{
		$sql = "DELETE FROM agendas WHERE curso_id = $cid";
		$db = new DB();
		if($db->execute($sql)){
			@unlink('files/'.$cid.".pdf");
		}
	}
	
	

}

?>