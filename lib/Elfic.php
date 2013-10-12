<?php

/**
 * @package: ELFIC Framework
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: 25 Octubre, 2010
 * @File: Elfic.php
 * @Version: 1.0
 * Provee de utilidades al framework
 */

class Elfic extends Utils {
	
	/**
	 * @desc Devuelve el nombre de un usuario
	 * @param int $id
	 * @return string
	 */
	function getNombreUsuario($id)
	{
		$db = new DB();
		$sql = "SELECT CONCAT(nombres,' ',apellidos) as name FROM usuarios WHERE id = '$id'";
		return $db->queryUniqueValue($sql);
	}
	
	/**
	 * @desc Un arreglo con estados de registro aprobado o pendiente
	 * @param void
	 * @return array
	 */
	function getEstados()
	{
		$estado = array();
		$estado['s']="Si";
		$estado['n']="No";
		return $estado;
	}
	
	/**
	 * @desc Un arreglo con estados de registro aprobado o pendiente
	 * @param void
	 * @return array
	 */
	function getBooleanVal($val)
	{
		switch ($val)
		{
			case '1': return "Si";
			break;
			default: return 'No';
		}
	}
	
	/**
	 * @desc Hace un password encriptado de un password en texto plano
	 * @param string $plaintext
	 * @return string md5
	 */
	 function getCryptedPassword($plaintext, $salt="", $show_encrypt = false) {
	   $encrypted = ($salt) ? md5($plaintext.$salt) : md5($plaintext);
		return ($show_encrypt) ? '{MD5}'.$encrypted : $encrypted;
	 }
	
	/**
	 * @desc Un arreglo de muncipios (categorias principales)
	 * @param void
	 * @return Array
	 */
	public function getMunicipiosCatsArray()
	{
		$db = new DB();
		$sql  = "SELECT id, nombre FROM municipios_cats WHERE publicado='s' AND borrado='n'";
		$res = $db->query($sql);
		while($line = $db->fetchNextObject($res)){
			$m[$line->id] = $line->nombre;
		}
		return $m;
	}
	
	function getUsuariosArray(){
		global $uid;
		$auth = new AuthUser();
		$db = new DB();
		$u = array();	
		if(!$auth->is_admin($uid)){
			$sql  = "SELECT name FROM jos_users ";
			$sql .= "WHERE id = $uid ";
			$u[$uid] = $db->queryUniqueValue($sql);
		} else {
			$sql  = "SELECT id, name FROM jos_users ";
			$sql .= "WHERE block='0' ";
			$res = $db->query($sql);
			while($line = $db->fetchNextObject($res)){
				$u[$line->id] = $line->name;
			}
		}
		return $u;		
	}
	
    
	/**
	 * Arreglo de clave valor para tablas de la forma codigo - descrip
	 * 
	 * @param string $table
	 * @return array $data
	 */
	function getDescripArray($table)
    {
    	$db = new DB();
    	$sql = "SELECT * FROM $table";
    	$res = $db->query($sql);
    	$data = array();
    	while($line = $db->fetchNextObject($res))
    	{
    		$data[$line->codigo] = $line->descrip;
    	}
    	return $data;
    }
	
}

?>