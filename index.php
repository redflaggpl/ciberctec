<?php
/**
 * @Package: FUSM
 * @subpackage catMan
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> INS Ltda.
 * @Date: Enero 15, 2011
 * @File: index.php
 * @Version: 1.0
 */
define('APP_PATH', dirname(__FILE__) );

define( 'DS', '/' );
include_once ('includes'.DS.'elfic.ini.php');

$smarty = new Elfic_Smarty();

$auth = new AuthUser();

$msg	= isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
// set the current action and do
$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$_task = isset($_REQUEST['task']) ? $_REQUEST['task'] : '';
$login = isset($_REQUEST['login']) ? $_REQUEST['login'] : false;
$passwd = isset($_REQUEST['passwd']) ? $_REQUEST['passwd'] : false;
$action = isset($_REQUEST['login']) ? $_REQUEST['login'] : false;

if(!$auth->isLoggedIn()) {
	$auth->login($login, $passwd);
}

$utils = new Utils();

switch($_action) {
    case 'submit':
	if($auth->isLoggedIn()) {
		$utils->cosRedirect('index2.php');
	} else {
	    $utils->cosRedirect('index.php', NO_LOGIN);
	}
	break;
    case 'login':
    	if($auth->isLoggedIn()) {
    		$utils->cosRedirect('index2.php');
    	} else {
	    	$smarty->assign('msg',$msg);
	    	$smarty->display('loginForm.tpl');
    	}
	break;
	case 'logout':
    	$auth->logout();
    	$msg = "Sesión cerrada.";
	    $smarty->assign('msg',$msg);
	    $smarty->display('loginForm.tpl');
	break;
}