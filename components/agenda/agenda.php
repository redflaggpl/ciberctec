<?php
/**
 * @Package: ELFIC FRAMEWORK
 * @subpackage Agenda Bellum
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.ins.net.co
 * @Date: Enero 15, 2011
 * @File: agenda.php
 * @Version: 1.0
 */

include_once (APP_PATH.DS.'lib'.DS.'agenda'.DS.'Agenda_Elfic.php');

$smarty = new Elfic_Smarty();
$smarty->display('start_menubar.tpl');

$msg	= isset($_GET['msg']) ? $msg : '';

$_do = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'list';
$_w = isset($_REQUEST['w']) ? $_REQUEST['w'] : null;
$_m = isset($_REQUEST['m']) ? $_REQUEST['m'] : date('m');
$_y = isset($_REQUEST['y']) ? $_REQUEST['y'] : date('Y');
$_d = isset($_REQUEST['d']) ? $_REQUEST['d'] : date('d');
$_do_save = isset($_REQUEST['do_save']) ? $_REQUEST['do_save'] : null;
    		

switch($_do) {
    	case 'month':
    	$smarty->display('agenda'.DS.'agenda_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['agenda_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$agda = new Agenda_Elfic();
    		$agda->monthView();
    	}
    break;
    case 'week':
		$smarty->display('agenda'.DS.'agenda_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['agenda_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$agda = new Agenda_Elfic();
    		$agda->weekView();
    	}
    break;
    case 'day':
		$smarty->display('agenda/agenda_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['agenda_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$agda = new Agenda_Elfic();
    		$agda->dayView($_d);
    	}
    break;
    case 'addevent':
		$smarty->display('agenda/agenda_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['agenda_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == 'do')
    		{
    			$agda = new Agenda_Elfic();
    			$agda->setEvent();
    		}
    	}
    break;
}