<?php
/**
 * @package CATMAN Usuario, Auth
 * @subpackage Perfiles
 * @Author edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: Mayo 6 de 2010
 * @File: Perfiles.php
 * @Version: 1.0
 * 
 */

class Perfiles extends Elfic {

	
	/**
	 * @desc consulta los perfiles disponibles
	 * @param void
	 * @return object
	 */
	function getPerfiles()
	{
		$db = new DB();
		$sql  = "SELECT * FROM perfiles ";
		$res = $db->query($sql);
		$data = array();
		while($line = $db->fetchNextObject($res))
		{
			$data[$line->codigo] = $line->descrip;
		}
		return $data;
	}

	
	function getGruposArray()
	{
		$grupos = $this->getGroups();
		$db = new DB();
		while($line = $db->fetchNextObject($grupos)){
			$gps[$line->usuarios_grupo_id] = $line->usuarios_grupo_nombre;
		}
		return $gps;
	}
}

?>