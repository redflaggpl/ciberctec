<?php
define('APP_PATH', dirname(__FILE__) );

define( 'DS', '/' );

include ('includes/elfic.ini.php');

$row = 1; 
$f = fopen ("usuarios.csv","r"); 
$i = 1;
while ($data = fgetcsv ($f, 1000, ";")) 
{ 
	$p['nombres'] = $data[0];
	$p['apellidos'] = $data[1];
	$p['login'] = $data[2];
	$p['password'] = Elfic::getCryptedPassword($data[2]);
	$p['email'] = $data[3];
	$p['creado'] = Elfic::now();
	$p['modificado'] = Elfic::now();
	$p['ultimoingreso'] = "";
	$p['activo'] = "1";
	$p['esadmin'] = "0";
	
	$db = new DB();
	if(!$db->perform('usuarios', $p))
	{
		echo "Error creando usuario " .$p['nombres'] . " " .$p['apellidos'];
		echo "\n<br>";
	}
	else
	{
		
		echo "Se creó el usuario " . $p['nombres'] . " " .$p['apellidos'];
		$id = $db->lastInsertedId();
		
		$db2 = new DB();
		$up['usuario_id'] = $id;
		$up['usuarios_grupo_id'] = 4;
		$db2->perform('usuarios_grupos_links', $up);
		
		echo " - ";
		echo "Se agreg&oacute; al grupo";
		
		echo "\n<br>";
	}
	
	
}

fclose ($f);