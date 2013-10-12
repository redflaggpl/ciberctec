<?php
/**
 * @package Elfic
 * @subpackage Elfic usuarios
 * @Author edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @filesource asistencia.ajax.php
 * @version 1.0
 */

$_action = isset($_REQUEST['act'])? $_REQUEST['act'] : false;
$_tutor = isset($_REQUEST['tutor'])? $_REQUEST['tutor'] : NULL; //id tutor

if(!$uperms['usuarios_w']){
	Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
}

switch($_action) {
    case 'getCursosTutor':
    	if(!$_tutor){
    		//echo "error, contacte al administrador";
    	}
    	else {
    		$c = new Cursos();
    		$c->getCursosTutor($_tutor);
    	}
    break;
}