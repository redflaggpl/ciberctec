<?php

/**
 * @Package: Sistema de Información de Metabastos (SIMBA)
 * @subpackage Reportes - fincas
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.ins.net.co
 * @Date: diciembre 8, 2010
 * @source : Reportes.php
 * @Version: 1.0
 */

class Reportes extends Utils {
	
	/* Sumatoria total de has */
	private $_has;
	
	/* Sumatoria total de produccion en toneladas */
	private $_ton;
	
	/**
	 * Imprime cuadro resumen con total de predios inscritos
	 * Hectareas cultivadas por producto
	 * Toneladas en producción por producto
	 * Totales
	 */
	function resumen()
	{
		$tpl = new Elfic_Smarty();
		//$tf = Reportes::totalFincas();
		//$tpl->assign('total', $tf);
		//$tpl->assign('p', Reportes::_getPorProducto());
		$tpl->assign('total_has', $this->_has);
		$tpl->assign('total_ton', $this->_ton);
		$tpl->display('reportes'.DS.'reportesResumen.tpl');
	}
	
	
	/**
	 * Exporta consulta a excel y genera descarga
	 * @param $export_file
	 */
	 function createExcel($filename, $arrydata)
	 {
		$excelfile = "xlsfile://tmp/".$filename;  
		$fp = fopen($excelfile, "wb");  
		if (!is_resource($fp)) {  
			die("Error al crear $excelfile");  
		}  
		fwrite($fp, serialize($arrydata));  
		fclose($fp);
		Elfic::cosRedirect('export.php?filename='. $filename);
	 }
}