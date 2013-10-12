<?php
define('APP_PATH', dirname(__FILE__) );

define( 'DS', '/' );

include ('includes/elfic.ini.php');

$row = 1; 
$f = fopen ("catedras.csv","r"); 
$i = 1;
while ($data = fgetcsv ($f, 1000, ";")) 
{ 
	if(!$data[0])
	{
		$p['nombre'] = $data[0];
		$p['programas_id'] = $data[1];
		$p['semestre'] = $data[2];
		$p['horas'] = $data[3];
		$p['estado'] = 1;
		
		$db = new DB();
		if(!$db->perform('catedra', $p))
		{
			echo "Error creando catedra " .$p['nombre'];
			echo "\n<br>";
		}
		else
		{
			echo "Se creó la catedra " . $p['nombre'];
			echo "\n<br>";
		}
	}
}

function catedraExiste($catedra)
{
	$db = new DB();
	
	if($db->countOf('catedra', 'nombre='.$catedra) > 0) return true;
	
	return false;
}

fclose ($f);