<?php
/**
 * @package Elfic Framework
 * @subpackage Bellum
 * Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * Date: Abril 20th, 2009
 * File: consultas.ajax.php
 * Version: 1.0
 */
define('APP_PATH', dirname(__FILE__) );
define( 'DS', '/' );
require_once "includes".DS."elfic.ini.php";
include (APP_PATH.DS.'includes'.DS.'auth.inc.php'); //incluye control de autenticación

$_action = isset($_REQUEST['act'])? $_REQUEST['act'] : false;
$email = isset($_REQUEST['q'])? $_REQUEST['q'] : null;
$rut = isset($_REQUEST['rut'])? $_REQUEST['rut'] : null;
$_eid = isset($_REQUEST['eid'])? $_REQUEST['eid'] : null;
$_id = isset($_REQUEST['id'])? $_REQUEST['id'] : null;
$_tel = isset($_REQUEST['tel'])? $_REQUEST['tel'] : null;

switch($_action){
	case 'getEvent':
		getEvent($_eid);
	break;
	case 'telencuesta':
		$e = new Encuestas();
		$e->telefonoEncuesta($_tel, $_eid);
	break;
}

if (isset($email)){
	chk_email($email);
}

if (isset($rut)){
	chk_rut($rut);
}

function chk_rut($rut){
	$db = new DB();
		$sql = "SELECT customers_id FROM customers WHERE nit = '$rut'";
		$result = $db->queryUniqueValue($sql);
		if($result){
			/*$div = "<input name=\"email_address\" type=\"text\" id=\"email_address\" size=\"30\" ";
			$div .= "maxlength=\"50\" class=\"required email\" value=\"\" >";*/
			echo "El rut existe en el sistema";
		}
}

function chk_email($email){
	$db = new DB();
		$sql = "SELECT customers_id FROM customers WHERE customers_email_address = '$email'";
		$result = $db->queryUniqueValue($sql);
		if($result){
			/*$div = "<input name=\"email_address\" type=\"text\" id=\"email_address\" size=\"30\" ";
			$div .= "maxlength=\"50\" class=\"required email\" value=\"\" >";*/
			echo "El email existe en el sistema";
		}
}

/**
 * @desc construye un arreglo con las ciudaddes de un departamento
 * @param int $id_depto
 * @return array
 */
function getEvent($eid)
{
	$db = new DB();
	$sql  = "SELECT * FROM eventos WHERE id= $eid";
	$e = $db->queryUniqueObject($sql);
	$data = "<table class=\"admintable\"><tr>";
	$data  .= "<th colspan=\"2\">".utf8_encode($e->titulo)."</th></tr>";
	$data .= "<tr><td>Descripción:</td><td>".utf8_encode($e->descrip)."</td></tr>";
	$data .= "<tr><td>Fecha Inicial:</td><td>$e->fechaini</td></tr>";
	$data .= "<tr><td>Fecha Final:</td><td>$e->fechafin</td></tr>";
	$data .= "<tr><td>Lugar:</td><td>".utf8_encode($e->lugar)."</td></tr>";
	$data .= "<tr><td>Tipo:</td><td>$e->tipo</td></tr>";
	$data .= "<tr><td>Funcionario:</td><td>$e->funcionario_id</td></tr>";
	$data .= "</table";
	echo $data;
}
?>