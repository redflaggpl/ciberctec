<?php

class Estudiantes extends Usuarios {
	
	private $_id;
	
	public function __construct($uid)
	{
		parent::__construct($uid);
		$this->_id = $uid;
	}
	
	/**
	 * Registra en DB, Asigna un curso a un estudiante
	 * @param int $curso_id
	 */
	function setCurso($curso_id){
		$db = new DB();
		$data['estudiante_id'] = $this->_id;
		$data['curso_id'] = $curso_id;
		$db->perform('estudiantes_cursos', $data);
		$url = "index2.php?com=usuarios&do=view&uid=".$this->_id;
		Elfic::cosRedirect($url);
	}
	
	/**
	 * Registra en DB, Asigna un curso a un estudiante
	 * @param int $curso_id
	 */
	function unsetCurso($curso_id){
		$db = new DB();
		$sql = "DELETE FROM estudiantes_cursos "
		     . "WHERE estudiante_id = $this->_id AND curso_id = $curso_id";
		$db->execute($sql);
		$url = "index2.php?com=usuarios&do=view&uid=".$this->_id;
		Elfic::cosRedirect($url);
	}
	

}

?>