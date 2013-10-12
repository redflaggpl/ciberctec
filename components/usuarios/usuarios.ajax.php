<?php
/**
 * @package Elfic
 * @subpackage Elfic usuarios
 * @Author edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @filesource usuarios.ajax.php
 * @version 1.0
 */

$_action = isset($_REQUEST['act'])? $_REQUEST['act'] : false;
$_uid = isset($_REQUEST['uid'])? $_REQUEST['uid'] : NULL; //id usuario
$_grupo_id = isset($_REQUEST['gid'])? $_REQUEST['gid'] : NULL; //id grupo
$_programas_id = isset($_REQUEST['pid'])? $_REQUEST['pid'] : NULL; //id grupo

if(!$uperms['usuarios_w']){
	Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
}

switch($_action) {
    case 'setGroup':
    	if(!$_grupo_id || !$_uid){
    		echo "error, contacte al administrador";
    	}
    	else {
    		$grupo = new Grupos();
    		$grupo->setUsuario($_uid, $_grupo_id);
    	}
    break;
    case 'unsetGroup':
		if(!$_grupo_id || !$_uid){
    		echo "error, contacte al administrador";
    	}
    	else {
    		$grupo = new Grupos();
    		$grupo->unsetUsuario($_uid, $_grupo_id);
    	}
    break;
    case 'getCursosPrograma':
    	if(!$_programas_id){
    		//echo "error, contacte al administrador";
    	}
    	else {
    		$c = new Cursos();
    		$c->getCursos($_programas_id);
    	}
    break;
}