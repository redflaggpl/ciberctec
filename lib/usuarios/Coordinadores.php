<?php

class Coordinadores extends Usuarios {
	
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
	function setPrograma($programa_id){
		$db = new DB();
		$data['coordinador_id'] = $this->_id;
		$data['programa_id'] = $programa_id;
		$db->perform('coordinadores_programas', $data);
		$url = "index2.php?com=usuarios&do=view&uid=".$this->_id;
		Elfic::cosRedirect($url);
	}
	
	/**
	 * Registra en DB, Asigna un curso a un estudiante
	 * @param int $curso_id
	 */
	function unsetPrograma($programa_id){
		$db = new DB();
		$sql = "DELETE FROM coordinadores_programas "
		     . "WHERE coordinador_id = $this->_id AND programa_id = $programa_id";
		$db->execute($sql);
		$url = "index2.php?com=usuarios&do=view&uid=".$this->_id;
		Elfic::cosRedirect($url);
	}
	
	function getProgramasArray($cid)
	{
		$db = new DB();
		$sql = "SELECT cp.programa_id, p.programa FROM coordinadores_programas cp "
		     . "INNER JOIN programas p ON p.id = cp.programa_id "
		     . "WHERE cp.coordinador_id = $cid";
		$res = $db->query($sql);
		$data = array();
		$i = 0;
		while($line = $db->fetchNextObject($res))
		{
			$data[$i]['id'] = $line->programa_id;
			$data[$i]['programa'] = $line->programa;
			$i++;
		}
		return $data;
	}
	

}

?>