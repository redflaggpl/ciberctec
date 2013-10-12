<?php
/**
 * @Package: BELLUM (Elfic Framework)
 * @subpackage Encuestas
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.ins.net.co
 * @Date: Septiembre 13, 2011
 * @File: encuestas.php
 * @Version: 1.0
 * 
 * Controlador de eventos encuentas
 */

include_once (APP_PATH.DS.'lib'.DS.'encuestas'.DS.'Encuestas.php');
include_once (APP_PATH.DS.'lib'.DS.'encuestas'.DS.'Preguntas.php');
include_once (APP_PATH.DS.'lib'.DS.'encuestas'.DS.'Respuestas.php');
include_once (APP_PATH.DS.'lib'.DS.'encuestas'.DS.'Resultados.php');

$smarty = new Elfic_Smarty();
$smarty->display('start_menubar.tpl');


$msg	= isset($_GET['msg']) ? $msg : '';
$_do = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'list';
$_do_save = isset($_REQUEST['do_save']) ? $_REQUEST['do_save'] : null;
$_eid = isset($_REQUEST['eid']) ? $_REQUEST['eid'] : null;
$_pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : null;

switch($_do) {
    case 'list':
    	$smarty->display('encuestas'.DS.'encuestas_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['encuestas_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$e = new Encuestas();
    		$e->listEncuestas();
    	}
    break;
    case 'new':
    	$smarty->display('encuestas'.DS.'encuestas_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['encuestas_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == "do"){
    			$e = new Encuestas();
    			$e->setEncuesta($_eid);
    		} else {
    			$e = new Encuestas();
    			$e->newEncuesta($_eid);
    		}
    	}
    break;
    case 'add':
    	$smarty->display('encuestas'.DS.'encuestas_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['encuestas_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == "do"){
    			$e = new Encuestas();
    			$e->setAddEncuesta();
    		} else {
    			$e = new Encuestas();
    			$e->addEncuesta();
    		}
    	}
    break;
    case 'edit':
    	$smarty->display('encuestas'.DS.'encuestas_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['encuestas_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == "do"){
    			$e = new Encuestas();
    			$e->setUpdateEncuesta($_eid);
    		} else {
    			$e = new Encuestas();
    			$e->editEncuesta($_eid);
    		}
    	}
    break;
    case 'addpregunta':
    	if(!$uperms['encuestas_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$p = new Preguntas();
    		$pid = $p->setPregunta($_eid);
    		$r = new Respuestas();
    		$r->setRespuestas($pid);
    		Elfic::cosRedirect('index2.php?com=encuestas&do=edit&eid='.$_eid);
    	}
    break;
    case 'deletepregunta':
    	if(!$uperms['encuestas_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if($_pid){
    			$p = new Preguntas();
    	        $p->deletePregunta($_pid);
    		}
    		Elfic::cosRedirect('index2.php?com=encuestas&do=edit&eid='.$_eid);
    	}
    break;
    case 'resultados':
    	$smarty->assign('eid', $_eid);
    	$smarty->display('encuestas'.DS.'encuestas_resultados_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['encuestas_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if($_eid){
    			$r = new Resultados($_eid);
    	        $r->getInforme($_eid);
    		}
    	}
    break;
}