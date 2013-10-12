<?php
/**
 * @Package: CATMAN
 * @subpackage Reportes
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @date: Junio 10, 2012
 * @filesource: reportes.php
 * @Version: 1.0
 */

$smarty = new Elfic_Smarty();
$msg	= isset($_GET['msg']) ? $msg : '';

$_do = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'resumen';
$_search = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
$_periodo_id = isset($_REQUEST['periodo_id']) ? $_REQUEST['periodo_id'] : '';

switch($_do) {
    case 'resumen':
    	$smarty->display('start_menubar.tpl');
    	$smarty->display('reportes'.DS.'reportes_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['reportes']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$r = new Reportes();
    		$r->resumen();
    	}
    break;
    case 'asistencia':
    	$smarty->display('start_menubar.tpl');
    	$smarty->display('reportes'.DS.'reportes_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['reportes']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$r = new Reportes_Asistencia();
    		$r->getReport($_search);
    	}
    break;
    case 'listtoexcel':
    	if(!$uperms['reportes']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$r = new Reportes_Asistencia();
    		$r->export();
    	}
    	Elfic::cosRedirect('index2.php?com=reportes');
    break;
    case 'evaluacion':
    	$smarty->display('start_menubar.tpl');
    	$smarty->display('reportes'.DS.'reportes_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	if(!$uperms['reportes']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$r = new Reportes_Evaluacion();
    		$r->getReport($_search, $_periodo_id);
    	}
    	break;
}