<?php 
date_default_timezone_set('America/Bogota');
$datos = array();
array_push($datos, $_GET['a']);
array_push($datos, $_GET['p']);
$textos = array("Acumulado","Programado");

$cd = urlencode(serialize($datos));
$ct = urlencode(serialize($textos));

echo "<img src='torta.php?datos=$cd&textos=$ct'>";
?>