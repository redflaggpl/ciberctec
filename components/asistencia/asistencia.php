<?php
/**
 * @Package: CATMAN - FUSM (Elfic Framework)
 * @subpackage Asistencia
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: Enero 29, 2011
 * @File: asistencia.php
 * @Version: 1.0
 * 
 * Controlador de eventos asistencia
 */

include_once (APP_PATH.DS.'lib'.DS.'asistencia'.DS.'Asistencia.php');

$smarty = new Elfic_Smarty();
if($tpl != "clean")
{
	$smarty->display('start_menubar.tpl');
}

$msg	= isset($_GET['msg']) ? $msg : '';
$_do = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'list_tut';
$_do_save = isset($_REQUEST['do_save']) ? $_REQUEST['do_save'] : null;
$_tutor = isset($_REQUEST['tutor']) ? $_REQUEST['tutor'] : "";
$_catedra = isset($_REQUEST['catedra']) ? $_REQUEST['catedra'] : "";
$_funcionario = isset($_REQUEST['funcionario']) ? $_REQUEST['funcionario'] : "";
$_fini = isset($_REQUEST['fini']) ? $_REQUEST['fini'] : "";
$_ffin = isset($_REQUEST['ffin']) ? $_REQUEST['ffin'] : "";

switch($_do) {
    case 'list_tut':
    	$smarty->display('asistencia'.DS.'asistencia_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['asistencia_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$a = new Asistencia();
    		$a->listAsistenciaTutores($_tutor, $_catedra, $_fini, $_ffin);
    	}
    break;
    case 'list_fun':
    	$smarty->display('asistencia'.DS.'asistencia_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['asistencia_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$a = new Asistencia();
    		$a->listAsistenciaFuncionarios($_funcionario);
    	}
    break;
    case 'setInTutor':
    	$smarty->display('asistencia'.DS.'asistencia_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['asistencia_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$a = new Asistencia();
    		$a->setAsistenciaTutor();
    	}
    break;
    case 'ajax':
    	if(!$uperms['asistencia_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		include 'asistencia.ajax.php';
    	}
    	break;
}