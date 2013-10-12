<?php

class Respuestas {
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param int $pid id de pregunta que asocia las respuestas
	 */
	public function setRespuestas($pid)
	{
		$lista = $_POST['respuestas'];
		if($lista != '')
		{
			$db = new DB();
			foreach($lista as $respuesta)
			{
			  if(!empty($respuesta)){
				  $r['respuesta'] = $respuesta;
				  $r['preguntas_id'] = $pid;
				  $db->perform('opciones_resp', $r);
			  }
			}
		}
	}
	
	public function deleteRespuestas($pid)
	{
		$db = new DB();
		$sql = "DELETE FROM opciones_resp WHERE preguntas_id = '$pid'";
		return $db->execute($sql);
	}

}

?>