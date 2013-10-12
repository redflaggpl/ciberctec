<?php

class Resultados extends Encuestas {
    
	private $_encuesta_id;
	
	private $_titulo;
	
	private $_total_resp;
	
	private $_fecha;
	
	private $_usuarios_id;
	
	public function __construct($id)
	{
		$this->_encuesta_id = $id;
		
		$data = $this->getEncuestaData($id);
		$this->_titulo = $data->titulo;
		$this->_fecha = $data->fecha;
		$this->_usuarios_id = $data->usuarios_id;
		$this->_total_resp = $this->getNumRespuestasEncuesta();
	}
	
	public function getInforme($eid, $tipo = "", $mun = '')
	{
	    $db = new DB();
		$preguntas = $this->_getPreguntasEncuesta($eid);
		
		//$resultado = array();
		$html = "";
		
		while ($line = $db->fetchNextObject($preguntas))
		{
			$opc_resp = $this->_getOpcionesRespuesta($line->id);
			//$resultado[$line->id]['pregunta'] = $line->pregunta;
			$html .= "<table width='100%'>\n";
			$html .= "<tr><th>".$line->pregunta."</th>\n";
			$html .= "<th with='80'>Total</th>\n";
			//$html .= "<th with='80'>%</th></tr>\n";
			$datos = array();
			$textos = array();
			while ( $row = $db->fetchNextObject($opc_resp))
			{
				$html .= "<tr>\n";
				$html .= "<td>".$row->respuesta."</td>";
				$html .= "<td>".$this->getResultsPregunta($line->id, $row->id, $mun)."</td>";
				//$html .= "<td>".
				                $this->porcentaje(
				                                 $this->getResultsPregunta($line->id, $row->id), 
				                                 $this->_total_resp)
				      . "%</td>";
				$html .= "</tr>\n";
				array_push($datos, $this->getResultsPregunta($line->id, $row->id));
				array_push($textos, $this->truncate($row->respuesta, 40));
			}
			//$html .= "<tr><td colspan='3'><img src='".$this->_getTorta($datos, $textos)."'></td></tr>";
			$d = serialize($datos);
			$t = serialize($textos);
			$cd = urlencode($d);
			$ct = urlencode($t);
			$titulo = $this->truncate($line->pregunta, 60);
			$html .= "<tr><td colspan='3'><img src='torta.php?datos=$cd&textos=$ct&titulo=$titulo'></td></tr>";
			$html .= "</table><br>";
		}
		
		$tpl = new Elfic_Smarty();
		$usuario = $this->_usuarios_id;
		$tpl->assign('titulo', $this->_titulo);
		$tpl->assign('fecha', $this->_fecha);
		$tpl->assign('total_resp', $this->_total_resp);
		$tpl->assign('usuario', Elfic::getNombreUsuario($this->_usuarios_id));
		$tpl->assign('data_res', $html);
		if($tipo == 'print')
		{
			$tpl->display('reportes/encuestasBasicReportPrint.tpl');
		} else 
		{
			$tpl->display('encuestas/encuestasBasicReport.tpl');
		}
		
	}
	
	
	public function getResultsPregunta($pid, $opcrid, $municipio = 'Villavicencio')
	{
		/*$and = "";
		if($municipio != '') $and = "AND t.municipio = '$municipio' ";
		$db = new DB();
		$sql = "SELECT COUNT(er.id), t.municipio  FROM encuestas_resultados er "
		     . "INNER JOIN respuestas r ON er.respuestas_id = r.id "
		     . "INNER JOIN telefonos t ON r.telefono = t.telefono "
		     . "WHERE er.opciones_resp_id = $opcrid AND er.preguntas_id = $pid "
		     . $and; 
		//$res = $db->query($sql);
		//return $db->numRows($res);
		return $db->queryUniqueValue($sql);*/
		
		
		$db = new DB();
		$where = "opciones_resp_id = $opcrid AND preguntas_id = $pid";
		return $db->countOf('encuestas_resultados', $where);
		
	}
	
    public function _getPreguntasEncuesta($eid)
	{
		$db = new DB();
		//return $db->countOf('preguntas', 'encuesta_id = '.$eid);
		$sql = "SELECT id, pregunta FROM preguntas WHERE encuesta_id = $eid";
		return $db->query($sql);
	}
	
	public function _getOpcionesRespuesta($pid)
	{
		$db = new DB();
		//$sql = "SELECT COUNT(*) FROM opciones_resp WHERE preguntas_id = $pid";
		//return $db->countOf('opciones_resp', 'preguntas_id = '.$pid);
		$sql = "SELECT id, respuesta FROM opciones_resp WHERE preguntas_id = $pid";
		return $db->query($sql);
	}
	
	public function getEncuestaData($id)
	{
		$db = new DB();
		$sql = "SELECT titulo, observaciones, fecha, publicado, usuarios_id "
		     . "FROM encuestas WHERE id = $id";
		return $db->queryUniqueObject($sql);
	}
	
	public function getNumRespuestasEncuesta()
	{
		$db = new DB();
		return $db->countOf('respuestas', 'encuestas_id='.$this->_encuesta_id);
	}
    /*public function getNumRespuestasEncuesta($mun = 'Villavicencio')
	{
		$db = new DB();
		$sql = "SELECT count(*) FROM respuestas r "
		     . "INNER JOIN telefonos t ON t.telefono = r.telefono "
		     . "AND r.encuestas_id = $this->_encuesta_id "
		     . "AND t.municipio = '$mun'";
		return $db->queryUniqueValue($sql);
	}*/
	
	public function porcentaje($votos, $total)
	{
		$res=0;
		if($total != 0){
			$pc=($votos/$total)*100;
			if(!is_int($pc))
			{ 
				$res=number_format($pc, 2);
			} else 
			{
				$res=$pc;
			}
		} else {
			return 0;
		}
		return $res;
	}
	
	private function _getTorta($datos, $textos)
	{
		//Se define el grafico
		$grafico = new PieGraph(450,300);
		
		//Definimos el titulo 
		$grafico->title->Set("Mi primer grafico de tarta");
		$grafico->title->SetFont(FF_FONT1,FS_BOLD);
		 
		//A√±adimos el titulo y la leyenda
		$p1 = new PiePlot($datos);
		$p1->SetLegends($textos);
		$p1->SetCenter(0.4);
		 
		//Se muestra el grafico
		$grafico->Add($p1);
		$grafico->Stroke();
	}
	
}

?>