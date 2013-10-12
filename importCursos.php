<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CATMAN - FUSM</title>
</head>
<BODY>
<?php
define('APP_PATH', dirname(__FILE__) );

define( 'DS', '/' );

include ('includes/elfic.ini.php');

function getCatedraId($catedra)
{
	$db = new DB();
	$sql = "SELECT id FROM catedra WHERE nombre = '$catedra'";
	return $db->queryUniqueValue($sql);
}

function getTutorId($cedula)
{
	$db = new DB();
	$sql = "SELECT id FROM usuarios "
	     . "WHERE login = '$cedula'";
	return $db->queryUniqueValue($sql);
}

function getDia($dia)
{
	switch($dia)
	{
		case 'LUNES': return 1;
		break;
		case 'MARTES': return 2;
		break;
		case 'MIERCOLES': return 3;
		break;
		case 'JUEVES': return 4;
		break;
		case 'VIERNES': return 5;
		break;
		case 'SABADO': return 6;
		break;
		case 'DOMINGO': return 7;
		
	}
}

$row = 1; 
$f = fopen ("cursos.csv","r"); 
$i = 1;
$j = 1;
while ($data = fgetcsv ($f, 1000, ";")) 
{ 
	$cid =  getCatedraId(isset($data[0]) ? $data[0]: 0);
	$tid = getTutorId(isset($data[2]) ? $data[2] : 0);
	
	if($cid > 0 && $tid > 0)
	{
		$p['catedra_id'] = $cid;
		$p['grupo'] = isset($data[1]) ? $data[1] : "" ;
		$p['tutor_id'] = $tid;
		$p['periodo_id'] = 2;
		$p['dia'] = getDia(isset($data[3]) ? $data[3] : "");
		$p['hora'] = $data[4];
		$p['estado'] = 1;
		
		$db = new DB();
		if(!$db->perform('cursos', $p))
		{
			//echo "Error creando curso " .$data[0];
			//echo "\n<br>";
		}
		else
		{
			//echo "Se creó el curso " . $data[0];
			//echo "\n<br>";

			$i++;
		}
		
	}
	else
	{
		echo "$j - <span style='color: red;'>";
		if(!$cid)
		{
			echo "No se recupero id de catedra $data[0]";
			echo "\n<br>";
		}
		if(!$tid)
		{
			echo "No se recupero tutor $data[2]";
			echo "\n<br>";
		}
		echo "</span>";
		$j++;
	}
}
fclose ($f);
echo "TOTAL IMPORTADOS: $i";
?>
</BODY>
</html>

