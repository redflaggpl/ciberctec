<?php

/** 
 * @author redflag
 * 
 * 
 */
class Permisos extends Elfic {
    
	/**
	 * Matriz de permisos - perfiles
	 * @return string html
	 */
	public function getMatrizPermisos()
	{
		
		$dataop = "";
		
		$db = new DB();
		$sql = "SELECT * FROM perfiles";
		$perfiles = $db->query($sql);
		
		$sql = "SELECT * FROM opciones";
		$opciones = $db->query($sql);
		
		/* Cadena con encabezado de opciones (componentes)  */
		while($row = $db->fetchNextObject($opciones))
		{
			$dataop .= "<th>$row->descrip</th>";
		}
		
		$data = "<table class='adminlist'>";
		$data .= "<tr><th></th>".$dataop."</tr>";
			
		while($line = $db->fetchNextObject($perfiles))
		{
			$data .= "<tr><td class='headlines'>".$line->descrip."</td>";
			/* Trae de nuevo consulta de opciones para construir */
			$opciones = $db->query($sql);
			while($row = $db->fetchNextObject($opciones))
			{
				$sql1 = "SELECT perfil_cd, opcion_cd, lectura, escritura "
				. "FROM permisos WHERE perfil_cd = $line->codigo "
				. "AND opcion_cd = $row->codigo";
				$res = $db->queryUniqueObject($sql1);
				$data .= '<td>Lectura: <input type="checkbox" id="" name="" value="" />';
				$data .= 'Escritura: <input type="checkbox" id="" name="" value="" /></td>';
			}
			$data .= "</tr>";
		}
		$data .= "</table>";
		
		$tpl = new Erudio_Smarty();
		$tpl->assign('matriz', $data);
		$tpl->display('usuarios/matrizPermisos.tpl');
	}
}

?>