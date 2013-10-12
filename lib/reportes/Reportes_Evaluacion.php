<?php

/**
 * @Package: Sistema de Información de Metabastos (SIMBA)
 * @subpackage Reportes - fincas
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.ins.net.co
 * @Date: Enero 14, 2011
 * @source : Reportes_Usuarios_List.php
 * @Version: 1.0
 */

class Reportes_Evaluacion extends Reportes {
	
	private $anchors;
	
	private $total;
	
	private $_numEvaluaciones = 0;
	
	function __construct(){
		
	}
	
	function getReport($search, $periodo)
	{
		$tpl = new Elfic_Smarty();
		$tpl->assign('periodos', CatManUtils::getPeriodosArrayCombo());
		$tpl->assign('data', $this->getTutores($search, $periodo));
		$tpl->assign('anchors',$this->anchors);
		$tpl->assign('total',$this->total);
		$tpl->display('reportes'.DS.'reportesEvaluacionList.tpl');
	}
	
	private function getTutores($filtro = "", $periodo_id = "")
	{
		$and = "";
		
		if($filtro != "")
		{
			$and .= "AND CONCAT(u.nombres, ' ', u.apellidos) LIKE '%$filtro%' ";
		}
		
		if($periodo_id != "")
		{
			$and .= "AND e.periodo_id = $periodo_id ";
		}
		
		$db = new DB();
		$sql = "SELECT DISTINCT e.tutor_id, CONCAT(u.nombres,'-',u.apellidos) AS tutor "
			 . "FROM eval_tutores_estu e INNER JOIN usuarios u ON e.tutor_id = u.id "
		     . "WHERE e.id > 0 $and ORDER BY CONCAT(u.nombres,'-',u.apellidos) DESC";
		$res = $db->query($sql);
		$data = array();
		$i = 0;
		while($line = $db->fetchNextObject($res))
		{
			$data[$i]['tutor_id'] = $line->tutor_id;
			$data[$i]['tutor'] = $line->tutor;
			$data[$i]['concepto'] = $this->getConcepto(
					                $this->getConceptoProm($line->tutor_id, $periodo_id));
			$data[$i]['numeval'] = $this->_numEvaluaciones;
			$i++;
		}
		return $data;
	}
	
	public function getConceptoProm($tutor_id, $periodo_id = "")
	{
		$and = "";
		
		if($periodo_id != "") $and .= "AND periodo_id = $periodo_id";
		
		$db = new DB();
		$sql = "SELECT SUM(concepto_tutor) as suma FROM eval_tutores_estu "
		     . "WHERE tutor_id = $tutor_id $and";
		$sum = $db->queryUniqueValue($sql);
		
		$where = "tutor_id = $tutor_id $and";
		
		$num = $db->countOf('eval_tutores_estu', $where);
		
		$this->_numEvaluaciones = $num;
		
		if($num != 0) 
		{
			return round($sum / $num);
		}
		else
		{
			return 0;
		}
	}
	
	function getConcepto($prom)
	{
		switch($prom)
		{
			case '0': return "No se han registrado evaluaciones para este tutor";
			case '1': return "Malo";
			case '2': return "Regular";
			case '3': return "Bueno";
			case '4': return "Excelente";
		}
	}
	
	
	function _buildReport(){
		
		
	}
	
	private function _getPorcentaje($acumulado, $programado)
	{
		return number_format((($acumulado * $programado) / 100), 2);
	}
	
	function export($cid="")
	{
		$r = $this->getCursos($cid);
		$this->createExcel("asistencia_cursos.xls", $r);
	}
}