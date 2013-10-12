<?php

/**
 * @package Elfic
 * @subpackage Elfic Grupos
 * @Author edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: Abril, 2012
 * @filesource Grupos.php
 * @Version: 1.0
 * 
 * Esta clase define las propiedades y metodos de un Usuario
 */

class Grupos extends Elfic {

	/**
	 * @desc Imprime tabla de checkbox con permisos de usuario
	 * @param int $id_usuario
	 * @return string $matriz
	 */
	function chkUserGroup($id_usuario){
		$matriz = "<table cellpadding=0 cellspacing=0>";
		$db = new DB();
		$groups = $this->getGroups();
		while($line = $db->fetchNextObject($groups)){
			$sql  = "SELECT * FROM usuarios_grupos_links ";
			$sql .= "WHERE usuario_id = '$id_usuario' ";
			$sql .= "AND usuarios_grupo_id = '$line->usuarios_grupo_id'";
			$matriz .= "<tr><td>".$line->usuarios_grupo_nombre."</td>";
			$checked = "";
			if($db->queryUniqueValue($sql))
			{
				$checked = "checked";
			}
			$matriz .= '<td><input type="checkbox" id="grupos['.$line->usuarios_grupo_id.']" ';
			$matriz .= 'value="'.$line->usuarios_grupo_id.'" '.$checked;
			$matriz .= ' onChange="setGroup('.$id_usuario.', '.$line->usuarios_grupo_id.');"/>';
			$matriz .= '</td></tr>';
		}
		$matriz .= "</table>";
		return $matriz;
	}

	/**
	 * @desc consulta los grupos creados en la db
	 * @param void
	 * @return object
	 */
	function getGroups()
	{
		$db = new DB();
		$sql  = "SELECT usuarios_grupo_id, usuarios_grupo_nombre ";
		$sql .= "FROM usuarios_grupos";
		return  $db->query($sql);
	}

	/**
	 * @desc registra relación usuario-grupo
	 * @param int $uid id del usuario
	 * @param int $gid id del grupo
	 */
	function setUsuario($uid, $gid)
	{
		$link['usuario_id'] = $uid;
		$link['usuarios_grupo_id'] = $gid;
		$db = new DB();
		if(!$db->perform('usuarios_grupos_links', $link)){
			echo "<strong>Error, no se ha incluido el usuario en grupo </strong>";
		} else {
			echo "<strong>Se ha incluido el usuario en grupo "
			     . utf8_encode($this->_getNombreGrupo($gid)) . "</strong>";
		}
	}

	/**
	 * @param borra realción usuario-grupo
	 * @param int $uid
	 * @param int $gid
	 */
	function unsetUsuario($uid, $gid)
	{
		$db = new DB();
		$sql = "DELETE FROM usuarios_grupos_links ";
		$sql .= "WHERE usuario_id = $uid AND usuarios_grupo_id = $gid";
		if($db->execute($sql) == true){
			echo "<strong>Se ha removido el usuario del grupo "
			     . utf8_encode($this->_getNombreGrupo($gid)) . "</strong>";
		} else {
			echo "<strong>Error, no se ha removido el usuario del grupo</strong>";
		}
	}

	/**
	 * Arreglo de grupos de usuarios
	 * @return array
	 */
	function getGruposArray()
	{
		$grupos = $this->getGroups();
		$db = new DB();
		while($line = $db->fetchNextObject($grupos)){
			$gps[$line->usuarios_grupo_id] = $line->usuarios_grupo_nombre;
		}
		return $gps;
	}
	
	private function _getNombreGrupo($id)
	{
		$sql = "SELECT usuarios_grupo_nombre FROM usuarios_grupos "
		     . "WHERE usuarios_grupo_id = $id";
		$db = new DB();
		return $db->queryUniqueValue($sql);
	}
	
	/*
	 * Un arreglo con los usuarios de un grupo en particular
	 * @param int $gid id del grupo
	 * @return array
	 */
	public function getUsuariosGrupo($gid)
	{
		$data = array();
		
		$sql = "SELECT u.id, CONCAT(u.nombres, ' ', u.apellidos) as nombre "
		     . "FROM usuarios u INNER JOIN usuarios_grupos_links l "
		     . "ON l.usuario_id = u.id WHERE u.activo = 1 AND l.usuarios_grupo_id = $gid "
		     . "ORDER BY u.nombres ASC";
		$db = new DB();
		$res = $db->query($sql);
		while($line = $db->fetchNextObject($res))
		{
			$data[$line->id] = $line->nombre;
		}
		return $data;
	}
	
	/**
	 * Si usuario esta asignado a grupo perfil
	 * @param int $uid Id del usuario
	 * @param int $gid Id del grupo
	 * @return boolean
	 */
	public function siUsuarioEnGrupo($uid, $gid)
	{
		$where = "usuario_id = $uid AND usuarios_grupo_id = $gid";
		$db = new DB();
		return $db->countOf('usuarios_grupos_links', $where);
	}
}