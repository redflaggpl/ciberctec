<?php
/**
 * @Package: Sistema de Gestión Educativa (Elfic)
 * @subpackage Usuarios
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.ins.net.co
 * @Date: Enero 15, 2011
 * @File: usuarios.php
 * @Version: 1.0
 */

include_once (APP_PATH.DS.'lib'.DS.'usuarios'.DS.'Usuarios.php');

$smarty = new Elfic_Smarty();
if($tpl != "clean") $smarty->display('start_menubar.tpl');


$msg	= isset($_GET['msg']) ? $msg : '';

$_do = isset($_REQUEST['do']) ? $_REQUEST['do'] : 'search';
$_auth = isset($_REQUEST['auth'])? $_REQUEST['auth'] : null; //si esta o no activo
$do_edit = isset($_REQUEST['do_edit']) ? $_REQUEST['do_edit'] : null;
$_uid = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : null; //id del cliente cuando viene de contacto
$_search = isset($_REQUEST['search'])? $_REQUEST['search'] : null;
$_filter = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;
$email = isset($_REQUEST['email'])? $_REQUEST['email'] : null;
$_add_id = isset($_REQUEST['add_id'])? $_REQUEST['add_id'] : null; //id direccion a editar o borrar
$_p_id = isset($_REQUEST['p_id'])? $_REQUEST['p_id'] : null; //id persona contacto social a editar o borrar
$_do_save = isset($_REQUEST['do_save'])? $_REQUEST['do_save'] : null;
$_grupo = isset($_REQUEST['grupo_id'])? $_REQUEST['grupo_id'] : null;
$_cursos_id = isset($_REQUEST['cursos_id'])? $_REQUEST['cursos_id'] : null;
$_programa_id = isset($_REQUEST['programa_id'])? $_REQUEST['programa_id'] : null;

switch($_do) {
    	case 'search':
    	$smarty->display('usuarios/usrlist_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['usuarios_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$usrs = new Usuarios();
    		$usrs->listAll($_search, $_grupo);
    	}
    break;
    case 'new':
		$smarty->assign('id', $_uid);
		$smarty->display('usuarios/users_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['usuarios_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($_do_save) && $_do_save == "do"){
    			$usr = new Usuarios();
    			if(!$usr->prepare()){
    				$usr->save('new');
    			}
    		} else {
    			$usr = new Usuarios();
    			$usr->nuevo();
    		}
    	}
    break;
	case 'view':
		$smarty->assign('id', $_uid);
		$smarty->display('usuarios/users_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['usuarios_r']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		if(isset($do_edit) && $do_edit == "do"){
	    		$usr = new Usuarios($_uid);
	    		if(!$usr->prepare($_uid)){
	    			$usr->save();
	    		}
	    	} else {
	    		$usr = new Usuarios($_uid);
	    		$usr->edit();
   
    		}
    	}
    break;
    case 'chpass':
		$smarty->assign('id', $_uid);
		$smarty->display('usuarios/users_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['usuarios_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$usr = new Usuarios($_uid);
    		$usr->chpasswd();
    	}
    break;
    case 'permisos':
    	$smarty->display('end_menubar.tpl');
		if(!$uperms['usuarios_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$per = new Permisos();
    		$per->getMatrizPermisos();
    	}
    break;
    case 'asignarprograma':
    	$smarty->assign('id', $_uid);
    	$smarty->display('usuarios/users_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	if(!$uperms['usuarios_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$usr = new Coordinadores($_uid);
    		$usr->setPrograma($_programa_id);
    	}
    	break;
    case 'asignarcurso':
    	$smarty->assign('id', $_uid);
    	$smarty->display('usuarios/users_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	if(!$uperms['usuarios_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$usr = new Estudiantes($_uid);
    		$usr->setCurso($_cursos_id);
    	}
    break;
    case 'unsetcurso':
    	$smarty->assign('id', $_uid);
    	$smarty->display('usuarios/users_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	if(!$uperms['usuarios_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$usr = new Estudiantes($_uid);
    		$usr->unsetCurso($_cursos_id);
    	}
    break;
    case 'unsetprograma':
    	$smarty->assign('id', $_uid);
    	$smarty->display('usuarios/users_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	if(!$uperms['usuarios_w']){
    		Elfic::cosRedirect('index2.php', MSG_NOPERM_COM);
    	} else {
    		$usr = new Coordinadores($_uid);
    		$usr->unsetPrograma($_programa_id);
    	}
    	break;
    case 'ajax':
    	include 'usuarios.ajax.php';
    break;
    case 'cpanel':
    	$smarty->display('usuarios/usrlist_menubar.tpl');
    	$smarty->display('end_menubar.tpl');
    	$tpl = new Elfic_Smarty();
   		$tpl->display('usuariosCpanel.tpl');
    break;
}