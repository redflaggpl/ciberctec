<?php
/**
 * @Package: FUSM CATMAN (Elfic)
 * @subpackage Cursos
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.ins.net.co
 * @Date: Abril 29, 2012
 * @filesource: cursos.php
 * @Version: 1.0
 */

include_once (APP_PATH.DS.'lib'.DS.'cursos'.DS.'Agendas.php');

$smarty = new Elfic_Smarty();
if($tpl != "clean") $smarty->display('start_menubar.tpl');


$msg	= isset($_GET['msg']) ? $msg : '';

$_do = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'search';
$_auth = isset($_REQUEST['auth'])? $_REQUEST['auth'] : null; //si esta o no activo
$do_edit = isset($_REQUEST['do_edit']) ? $_REQUEST['do_edit'] : null;
$_cid = isset($_REQUEST['cid']) ? $_REQUEST['cid'] : null; //id de catedra
$_catedra = isset($_REQUEST['catedra']) ? $_REQUEST['catedra'] : null; //id de catedra
$_filter = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;
$_do_save = isset($_REQUEST['do_save'])? $_REQUEST['do_save'] : null;
$_programa_id = isset($_REQUEST['programa_id'])? $_REQUEST['programa_id'] : null;

switch($_do) {
    case 'search':
    	$smarty->display('catedras/catedraslist_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['catedras_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$c = new Catedras();
    		$c->listAll($_catedra);
    	}
    break;
    case 'new':
    	$smarty->assign('id', $_cid);
		$smarty->display('catedras/catedras_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['catedras_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == "do"){
    			$c = new Catedras();
    			//if(!$c->chkCurso($_catedra_id, $_periodo_id, $_tutor_id)){
    				$c->save('new');
    			//}
    		} else {
    			$c = new Catedras();
    			$c->nuevo();
    		}
    	}
    break;
	case 'view':
		$smarty->assign('id', $_cid);
		$smarty->display('catedras/catedras_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['catedras_w']){
    		Elfic::cosRedirect('index2.php?com=catedras', MSG_NOPERM_ACC);
    	} else {
    		if(isset($do_edit) && $do_edit == "do"){
	    		$c = new Catedras($_cid);
	    		$c->save();
	    	} else {
	    		$c = new Catedras($_cid);
	    		$c->edit();
   
    		}
    	}
    break;
}