<?php
/**
 * @Package: ELFIC FRAMEWORK
 * @subpackage CATMAN FUSM
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: Enero, 2011
 * @File: index2.php
 * @Version: 1.0
 */

define('APP_PATH', dirname(__FILE__) );
define( 'DS', '/' );
include ('includes'.DS.'elfic.ini.php');
include (APP_PATH.DS.'includes'.DS.'auth.inc.php'); //incluye control de autenticación

$msg	= isset($_REQUEST['msg']) ? $_REQUEST['msg'] : ''; //mensajes retornados por url
$tpl	= isset($_REQUEST['tpl']) ? $_REQUEST['tpl'] : null; //
$starting	= isset($_REQUEST['starting']) ? $_REQUEST['starting'] : 0; //offset paginador de resultados

$smarty = new Elfic_Smarty();

$smarty->assign('title',APP_TITULO);
$smarty->display('html_top.tpl');
$smarty->assign('login',$login);
if($tpl != "clean")
{
	$smarty->display('html_header.tpl');
	$smarty->display('top_menu.tpl');
	$smarty->assign('msg',$msg);
	$smarty->display('containTop.tpl');
}


$_com = isset($_REQUEST['com']) ? $_REQUEST['com'] : 'home';
$pid = isset($_REQUEST['pid']);

switch($_com) {
    case 'usuarios':
    	if(!$uperms['usuarios_r']){
    		Utils::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
			require_once 'components'.DS.'usuarios'.DS.'usuarios.php';
    	}
    break;
    case 'evaluacion':
    	if(!$uperms['evaluacion_r']){
    		Utils::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
			require_once 'components'.DS.'evaluacion'.DS.'evaluacion.php';
    	}
    break;
    case 'agenda':
    	if(!$uperms['agenda_r']){
    		Utils::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
			require_once 'components'.DS.'agenda'.DS.'agenda.php';
    	}
    break;
    case 'asistencia':
    	if(!$uperms['asistencia_r']){
    		Utils::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
			require_once 'components'.DS.'asistencia'.DS.'asistencia.php';
    	}
    break;
    case 'cursos':
    	if(!$uperms['cursos_r']){
    		Utils::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		require_once 'components'.DS.'cursos'.DS.'cursos.php';
    	}
    break;
    case 'catedras':
    	if(!$uperms['catedras_r']){
    		Utils::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		require_once 'components'.DS.'catedras'.DS.'catedras.php';
    	}
    	break;
    case 'reportes':
    	if(!$uperms['reportes']){
    		Utils::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		require_once 'components'.DS.'reportes'.DS.'reportes.php';
    	}
    break;
    case 'home':
    	doCpanel();
}
if($tpl != "clean") $smarty->display('containBottom.tpl');

function doCpanel(){
	global $uid, $uperms;
    
	$tpl = new Elfic_Smarty();
	$tpl->assign('usuario', Elfic::getNombreUsuario($uid));
	
	$tpl->assign('usuarios', $uperms['usuarios_r']);
	$tpl->assign('agenda', $uperms['agenda_r']);
	$tpl->assign('asistencia', $uperms['asistencia_r']);
	$tpl->assign('cursos', $uperms['cursos_r']);
	$tpl->assign('catedras', $uperms['catedras_r']);
	$tpl->assign('evaluacion', $uperms['evaluacion_r']);
	$tpl->assign('reportes', $uperms['reportes']);
	
    $tpl->display('featCpanel.tpl');
    //$home = new Home();
    
}