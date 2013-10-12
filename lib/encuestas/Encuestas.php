<?php

class Encuestas extends Utils {
	
    /**
	 * Lista de encuestas 
	 */
	
	function getEncuesta($id)
	{
		$db = new DB();
		$sql = "SELECT * FROM encuestas WHERE id='$id'";
		return $db->queryUniqueObject($sql);
	}
	
	function listEncuestas()
	{
		global $uid, $uperms;
		$where = "";
		
		if(!$uperms['encuestas_w'])
		{
			$where = "WHERE publicado = 's'";
		}
		
		$db = new DB();
		$sql = "SELECT  * FROM encuestas $where";
		
		
		if(isset($_GET['starting'])){
			$starting=$_GET['starting'];
		}else{
			$starting=0;
		}
		
		$objpag = new Pagination($sql, $starting, 20, 'index2.php?com=encuestas&do=list');		
		$res = $objpag->result;
		
		$data = array();
		$x = 0;
		while($line = $objpag->fetchNextObject($res)){
			$data[$x]['id'] = $line->id;
			$data[$x]['titulo'] = $line->titulo;
			$data[$x]['observaciones'] = $line->observaciones;
			$data[$x]['fecha'] = $line->fecha;
			$x++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Elfic_Smarty();
		$tpl->assign('lista',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		$tpl->display('encuestas/encuestasList.tpl');
		
	}
	
	/**
	 * Carga interfaz para llenar una encuesta
	 * 
	 * @param int $id
	 */
	public function newEncuesta($id)
	{
		global $uid;
		
		$tpl = new Elfic_Smarty();
		$tpl->assign('uid', $uid);
		$tpl->assign('cursos', Cursos::getCursosEstudiante($uid));
		$tpl->assign('data', $this->_getPreguntasEscuesta($id));
		$tpl->display('encuestas/encuestasNew.tpl');
	}
	
	public function setEncuesta($id)
	{
		global $uid;
		
		$data['encuestas_id'] = $id;
		$data['nombre'] = $_POST['nombre'];
		$data['fecha_hora'] = Utils::now();
		$data['usuarios_id'] = $uid;
		$data['telefono'] = $_POST['telefono'];
		$db = new DB();
		$db->perform('respuestas', $data);
		$rep_id  = $db->lastInsertedId();
		
		$valores = $_POST['pregunta'];
		$aLista=array_keys($_POST['pregunta']);
		foreach ($aLista as $indice){
			$val = $valores[$indice];
			$sql  = "INSERT INTO encuestas_resultados (opciones_resp_id, respuestas_id, preguntas_id)"
			      . "VALUES ('$val', '$rep_id', '$indice' )";
  		    $db = new DB();
  		    $db->execute($sql);
		}
  		
        Elfic::cosRedirect('index2.php?com=encuestas', 'Los resultados se grabaron satisfactoriamente');
	}
	
	private function _getPreguntasEscuesta($id)
	{
	    $db = new DB();
		$sql = "SELECT * FROM preguntas WHERE encuesta_id = $id";
		$res = $db->query($sql);
		$data = "";
		while($line = $db->fetchNextObject($res))
		{
			$data .= "<tr><td colspan='4'><strong>";
			$data .= $line->pregunta."</strong></td></tr>";
			$data .= $this->getOpcionesRespuesta($line->id);
			$data .= "<tr><td colspan='4'></td></tr>";
		}
		return $data;
	}
	
	/**
	 * Crea opciones de respuesta para cada pregunta de una encuesta
	 * 
	 * @param int $id id de la pregunta
	 * @return String cadena con radios de opciones de respuesta asociados
	 * a una pregunta
	 */
	public function getOpcionesRespuesta($id)
	{
	    $db = new DB();
		$sql = "SELECT id, respuesta FROM opciones_resp WHERE preguntas_id = $id";
		$res = $db->query($sql);
		while($line = $db->fetchNextObject($res))
		{
			$data .= "<tr ><td colspan='4'>";
			$data .= "<input name=\"pregunta[$id]\" type='radio' value='$line->id' class=\"required\"/>";
			$data .= $line->respuesta."</td></tr>";
			
		}
		return $data;
	}
	
	public function getTelefonos($id)
	{
		global $uid;
		
		$db = new DB();
		$sql = "SELECT telefono FROM telefonos WHERE usuarios_id = $uid AND encuestas_id=$id";
		//FROM telefonos t "
		    // . "LEFT OUTER JOIN respuestas r ON t.telefono=r.telefono ";
		     //. "WHERE r.encuestas_id = $id";
		$res = $db->query($sql);
		
		$data = array();
		while($line = $db->fetchNextObject($res))
		{
			if(!$this->siTelefonoRespuesta($line->telefono, $id))
			{
				$data[$line->telefono] = $line->telefono;
			}
		}
		return $data;
	}
	
	/**
	 * 
	 * Retorna true si un telefono ya esta asociado a una encuesta, si ya la respondio
	 * @param string $tel
	 * @param int $eid
	 * @return boolean
	 * 
	 */
	private function siTelefonoRespuesta($tel, $eid)
	{
		$db = new DB();
		$sql = "SELECT COUNT(*) FROM respuestas "
		     . "WHERE encuestas_id = $eid AND telefono = '$tel'";
		$res = $db->queryUniqueValue($sql);
		if($res > 0){
			return true;
		}
		return false;
	}
	
    /**
	 * Carga interfaz para crear una nueva encuesta
	 * 
	 * @param int $id
	 */
	public function addEncuesta()
	{
		global $uid;
		
		$tpl = new Elfic_Smarty();
		$tpl->assign('uid', $uid);
		$tpl->display('encuestas/encuestasAdd.tpl');
	}
	
	public function setAddEncuesta()
	{
		global $uid;
		
		$data['titulo'] = $_POST['titulo'];
		$data['observaciones'] = $_POST['observaciones'];
		$data['fecha'] = Utils::now();
		$data['publicado'] = $_POST['publicado'];
		$data['usuarios_id'] = $uid;
		$db = new DB();
		$db->perform('encuestas', $data);
		$eid = $db->lastInsertedId();
  		
        Elfic::cosRedirect('index2.php?com=encuestas&do=edit&eid='.$eid);
	}
	
    public function setUpdateEncuesta($id)
	{
		global $uid;
		
		$data['titulo'] = $_POST['titulo'];
		$data['observaciones'] = $_POST['observaciones'];
		if($this->cuentaPreguntas($id)>0)
		{
		    $data['publicado'] = $_POST['publicado'];
		}
		$db = new DB();
		$db->perform('encuestas', $data, 'update', 'id='.$id);
  		
        Elfic::cosRedirect('index2.php?com=encuestas&do=edit&eid='.$id);
	}
	
    /**
	 * Carga interfaz para edición de encuesta
	 * 
	 * @param int $id
	 */
	public function editEncuesta($id)
	{
		global $uid;
		
		$e = $this->getEncuesta($id);
		
		$tpl = new Elfic_Smarty();
		$tpl->assign('uid', $uid);
		$tpl->assign('eid', $id);
		$tpl->assign('titulo', $e->titulo);
		$tpl->assign('observaciones', $e->observaciones);
		$tpl->assign('publicado', array('n'=>'No', 's'=>'Si'));
		$tpl->assign('sel_pub', $e->publicado);
		$tpl->assign('data', Preguntas::getPreguntasEscuesta($id));
		$tpl->display('encuestas/encuestasEdit.tpl');
	}
	
	/**
	 * Si un telefono esta asociado a la respuesta a una encuesta
	 * @param String @telefono 
	 * @param String @encuesta id de la encuesta
	 * @return boolean true si telefono ya respondio la encuesta
	 */
	public function telefonoEncuesta($telefono, $encuesta)
	{
		$db = new DB();
		$where = "telefono='$telefono' AND encuestas_id='$encuesta'";
		
		if($db->countOf('respuestas', $where ) > 0)
		{
			echo "<div id='error'>Alguien en este telefono ya particip&oacute; en esta encuesta</div>";
		}
	}
	
	public function cuentaPreguntas($eid)
	{
		$db = new DB();
		return $db->countOf('preguntas', 'encuesta_id='.$eid);
	}
	
	
}

?>