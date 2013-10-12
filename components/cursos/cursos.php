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
$_cid = isset($_REQUEST['cid']) ? $_REQUEST['cid'] : null; //id del curso
$_curso = isset($_REQUEST['curso'])? $_REQUEST['curso'] : null;
$_filter = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;
$_do_save = isset($_REQUEST['do_save'])? $_REQUEST['do_save'] : null;
$_catedra_id = isset($_REQUEST['catedra_id'])? $_REQUEST['catedra_id'] : null;
$_periodo_id = isset($_REQUEST['periodo_id'])? $_REQUEST['periodo_id'] : null;
$_tutor_id = isset($_REQUEST['tutor_id'])? $_REQUEST['tutor_id'] : null;
$_aid = isset($_REQUEST['aid'])? $_REQUEST['aid'] : null;

switch($_do) {
    case 'search':
    	$smarty->display('cursos/cursoslist_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['cursos_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$c = new Cursos();
    		$c->listAll($_curso);
    	}
    break;
    case 'new':
    	$smarty->assign('id', $_cid);
		$smarty->display('cursos/cursos_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['cursos_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == "do"){
    			$c = new Cursos();
    			//if(!$c->chkCurso($_catedra_id, $_periodo_id, $_tutor_id)){
    				$c->save('new');
    			//}
    		} else {
    			$c = new Cursos();
    			$c->nuevo();
    		}
    	}
    break;
    case 'cargarAgenda':
    	$smarty->display('cursos/cursos_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	if(!$uperms['cursos_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == "do"){
    			$a = new Agendas();
    			$a->registrarAgenda();
    		} else {
    			$a = new Agendas();
    			$a->cargarAgenda($_cid, $_tutor_id);
    		}
    	}
    break;
    case 'borrarAgenda':
    	if(!$uperms['cursos_w']){
    		Elfic::cosRedirect('index2.php?com=cursos', MSG_NOPERM_ACC);
    	} else {
    		if($uperms['superusuario'] || (Cursos::getTutor($_cid) == $uid))
    		{
    			$a = new Agendas();
    			$a->borrarAgenda($_cid);
    			Elfic::cosRedirect('index2.php?com=cursos&do=view&cid='.$_cid);
    		} else {
    			Elfic::cosRedirect('index2.php?com=cursos', MSG_NOPERM_ACC);
    		}
    	}
    break;
	case 'view':
		$smarty->assign('id', $_cid);
		$smarty->display('cursos/cursos_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['cursos_w']){
    		Elfic::cosRedirect('index2.php?com=cursos', MSG_NOPERM_ACC);
    	} else {
    		if(isset($do_edit) && $do_edit == "do"){
	    		$c = new Cursos($_cid);
	    		$c->save();
	    	} else {
	    		$c = new Cursos($_cid);
	    		$c->edit();
   
    		}
    	}
    break;
    case 'ajax':
    	include 'cursos.ajax.php';
    break;
}