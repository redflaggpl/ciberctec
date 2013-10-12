<?php

/**
 * @Package: Sistema de Información de Metabastos (SIMBA)
 * @subpackage Reportes - fincas
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.ins.net.co
 * @Date: Enero 14, 2011
 * @source : Reportes_Usuarios_List.php
 * @Version: 1.0
 */

class Reportes_Asistencia extends Reportes {
	
	private $anchors;
	
	private $total;
	
	function __construct(){
		
	}
	
	function getReport($search)
	{
		$tpl = new Elfic_Smarty();
		$tpl->assign('data', $this->getCursos($search));
		$tpl->assign('anchors',$this->anchors);
		$tpl->assign('total',$this->total);
		$tpl->display('reportes'.DS.'reportesAsistenciaCursos.tpl');
	}
	
	private function getCursos($filtro = "")
	{
		$and = "";
		
		if($filtro != "")
		{
			$and .= "AND CONCAT(u.nombres, ' ', u.apellidos) LIKE '%$filtro%' ";
		}
		
		$db = new DB();
		$sql = "SELECT c.id, ct.nombre as curso, ct.horas, "
		     . "CONCAT(p.anio,'-',p.semestre) AS periodo, "
		     . "CONCAT(u.nombres, ' ', u.apellidos) AS tutor "
		     . "FROM cursos c INNER JOIN catedra ct ON c.catedra_id = ct.id "
		     . "INNER JOIN usuarios u ON c.tutor_id = u.id "
		     . "INNER JOIN periodos p ON c.periodo_id = p.id "
		     . "WHERE c.estado = 1 $and ORDER BY c.id DESC";
		$res = $db->query($sql);
		$data = array();
		$i = 0;
		while($line = $db->fetchNextObject($res))
		{
			$data[$i]['id'] = $line->id;
			$data[$i]['curso'] = $line->curso;
			$data[$i]['periodo'] = $line->periodo;
			$data[$i]['tutor'] = $line->tutor;
			$data[$i]['acumulado'] = $this->_getAcumulado($line->id);
			$data[$i]['programado'] = $line->horas;
			$data[$i]['porcentaje'] = $this->_getPorcentaje(
					$this->_getAcumulado($line->id), $line->horas);
			$i++;
		}
		return $data;
	}
	
	
	function _buildReport(){
		
		
	}
	
	private function _getAcumulado($cid)
	{
		$acumulado = 0;
		$db = new DB();
		$sql = "SELECT a.id, a.usuario_id, a.entrada, a.salida FROM asistencias a "
		     . "INNER JOIN asistencias_tutores t ON a.id = t.asistencias_id "
		     . "WHERE t.curso_id = $cid ";
		$res = $db->query($sql);
		while($line = $db->fetchNextObject($res))
		{
			if($line->entrada != "" || $line->salida != ""){
				$acumulado += $this->_getTime($line->entrada, $line->salida);
			}
				
		}
		return number_format($acumulado, 2);
	}
	
	private function _getPorcentaje($acumulado, $programado)
	{
		return number_format((($acumulado * $programado) / 100), 2);
	}
	
	private function _getTime($past, $now)
	{
	    $past = is_string($past)? strtotime($past): (int) $past;
	    $now = is_string($now)? strtotime($now): (int) $now;
	    $now = $now <= 0? time(): $now;// --
	
	    // restamos..
	    $diff = $now - $past;
	
	    if ($diff > 12600)
	    {
	        //return 'hace menos de un minuto';
	        $diff = (12600/60/60);
	    }
	    else
	    {
	    	$diff = ($diff/60/60);
	    }
	    
	    return $diff;
	}
	
	function export($cid="")
	{
		$r = $this->getCursos($cid);
		$this->createExcel("asistencia_cursos.xls", $r);
	}
}