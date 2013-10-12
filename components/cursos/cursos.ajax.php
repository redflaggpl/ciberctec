<?php
/**
 * @package Elfic
 * @subpackage Elfic usuarios
 * @Author edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @filesource cursos.ajax.php
 * @version 1.0
 */

$_action = isset($_REQUEST['act'])? $_REQUEST['act'] : false;
$_curso_id = isset($_REQUEST['cid'])? $_REQUEST['cid'] : NULL; //id usuario
$_programa_id = isset($_REQUEST['programa_id'])? $_REQUEST['programa_id'] : NULL;
$_semestre = isset($_REQUEST['semestre'])? $_REQUEST['semestre'] : NULL;

if(!$uperms['cursos_w']){
	Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
}

switch($_action) {
    case 'getCatedras':
    	if(!$_programa_id){
    		echo "error, contacte al administrador";
    	}
    	else {
    		$c = new Cursos();
    		$c->getCatedrasCombo($_programa_id, $_semestre);
    	}
    break;
}