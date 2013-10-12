<?php
/**
 * Project: Erudio
 * Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * Date: Abril 20th, 2009
 * File: consultas.ajax.php
 * Version: 1.0
 */
define( 'DS', '/' );
require_once "..".DS."includes".DS."erudio.ini.php";
require_once "..".DS."lib".DS."DB.php";

$_action = isset($_REQUEST['act'])? $_REQUEST['act'] : false;
$email = isset($_REQUEST['q'])? $_REQUEST['q'] : null;
$rut = isset($_REQUEST['rut'])? $_REQUEST['rut'] : null;
$_eid = isset($_REQUEST['eid'])? $_REQUEST['eid'] : null;

switch($_action){
	case 'getEvent':
		utf8_encode(getEvent($_eid));
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
 * @desc una cadena html con detalle de un evento
 * Retorna por ajax
 * @param int $eid
 * @return string
 */
function getEvent($eid)
{
	$db = new DB();
	$sql  = "SELECT * FROM eventos WHERE id= $eid";
	$e = $db->queryUniqueObject($sql);
	$data = "<table class=\"admintable\"><tr>";
	$data  .= "<th colspan=\"2\">$line->titulo</th></tr>";
	$data .= "<tr><td>Descripción:</td><td>$line->descrip</td></tr>";
	$data .= "<tr><td>Fecha Inicial:</td><td>$line->fechaini</td></tr>";
	$data .= "<tr><td>Fecha Final:</td><td>$line->fechafin</td></tr>";
	$data .= "<tr><td>Lugar:</td><td>$line->lugar</td></tr>";
	$data .= "<tr><td>Tipo:</td><td>$line->tipo</td></tr>";
	$data .= "<tr><td>Funcionario:</td><td>$line->funcionario</td></tr>";
	$data .= "</table";
	return $data;
}
?>