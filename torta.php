<?php
date_default_timezone_set('America/Bogota');
require_once ("lib/jpgraph/src/jpgraph.php");
require_once ("lib/jpgraph/src/jpgraph_pie.php");
	 
	// Se define el array de valores y el array de la leyenda
	if(isset($_GET['datos']) && isset($_GET['textos']))
	{
		$d=stripslashes ($_GET['datos']);
		$datos = unserialize($d);
		$t=stripslashes ($_GET['textos']);
		$textos = unserialize($t);
		//$titulo = $_GET['titulo'];
		
		//Se define el grafico
		$grafico = new PieGraph(380,200);
		
		//Definimos el titulo 
		$grafico->title->Set("Grafica");
		$grafico->title->SetFont(FF_FONT1,FS_BOLD);
		 
		//AâÂ±adimos el titulo y la leyenda
		$p1 = new PiePlot($datos);
		$p1->SetLegends($textos);
		$p1->SetCenter(0.2);
		 
		//Se muestra el grafico
		$grafico->Add($p1);
		$grafico->Stroke();
	}
	