<?php

class Media extends Creatur {
	
	function loadImages($dir='', $com='')
	{
		$img = "";
		if($dir != "" || $com != ""){
			$path =  IMAGES.$com."/".$dir."/";
		} else {
			$path = IMAGES;
		}
		
		$imagenes=glob("{".$path."*.*}",GLOB_BRACE);
		$totalImg=count($imagenes);
	
		for($x=0; $x<$totalImg; $x++)
		{
			$imagen = str_replace($path,"",$imagenes[$x]);
			//$imagen  = str_replace(".jpg","",$imagen1);
			/*$img .= "<div id='image_box'>
					<img src='".$path.$imagen."' 
					width=\"80\" height=\"60\"	name=\"".$imagen."\" 
					onClick=\"cambiar('".$imagen."')\">
					<div id='img_name'>$imagen</div>
					</div>";*/
			$img[$x]['path'] = $path;
			$img[$x]['imagen'] = $imagen;
		}
		return $img;
	}

}

?>