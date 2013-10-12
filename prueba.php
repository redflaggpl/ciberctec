<?php
date_default_timezone_set('America/Bogota');
function sumaTiempo($horas)
{
	$t = explode(":", $horas);
	return $t[0] + 12 .":".$t[1];
}

echo sumaTiempo('6:30');