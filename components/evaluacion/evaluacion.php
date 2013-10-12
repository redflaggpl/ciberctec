<?php
/**
 * @Package: CATMAN
 * @subpackage EvaluacionTutores
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: Mayo 10, 2012
 * @File: evaluacion.php
 * @Version: 1.0
 */

$smarty = new Elfic_Smarty();
$smarty->display('start_menubar.tpl');


$msg	= isset($_GET['msg']) ? $msg : '';
if($uperms['evaluacion_w']) $_do = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'list';
else $_do = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'cursos';
$_do_save = isset($_REQUEST['do_save']) ? $_REQUEST['do_save'] : null;
$_eid = isset($_REQUEST['eid']) ? $_REQUEST['eid'] : null;
$_pid = isset($_REQUEST['pid']) ? $_REQUEST['pid'] : null;
$_cid = isset($_REQUEST['cid']) ? $_REQUEST['cid'] : null;
$_eid = isset($_REQUEST['eid']) ? $_REQUEST['eid'] : null;
$_curso = isset($_REQUEST['curso']) ? $_REQUEST['curso'] : "";
$_tutor = isset($_REQUEST['tutor']) ? $_REQUEST['tutor'] : "";

switch($_do) {
    case 'list':
    	$smarty->display('evaluacion'.DS.'evaluacion_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['evaluacion_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$e = new Evaluacion();
    		$e->listar($_curso, $_tutor);
    	}
    break;
    case 'set':
    	$smarty->display('evaluacion'.DS.'evaluacion_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['evaluacion_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == "do"){
    			$e = new Evaluacion();
    			$e->setEvaluacion();
    		} else {
    			$e = new Evaluacion();
    			$e->newEvaluacion($_cid);
    		}
    	}
    break;
    case 'getEval':
    	$smarty->display('evaluacion'.DS.'evaluacion_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	if(!$uperms['evaluacion_w']){
    		Elfic::cosRedirect('index2.php?com=evaluacion', MSG_NOPERM_ACC);
    	} else {
    		$e = new Evaluacion($_eid);
    		$e->viewEvaluacion();
    	}
    	break;
    case 'cursos':
    	$smarty->display('evaluacion'.DS.'evaluacion_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	if(!$uperms['evaluacion_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$e = new Evaluacion();
    		$e->listarCursos();
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