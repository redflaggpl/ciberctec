<?php

class Preguntas {
	
	public function setPregunta($eid)
	{
		$db = new DB();
		$data['pregunta'] = $_POST['pregunta'];
		$data['encuesta_id'] = $eid;
		$db->perform('preguntas', $data);
		return $db->lastInsertedId();
	}
	
    public function deletePregunta($pid)
	{
		$r = new Respuestas();
		$r->deleteRespuestas($pid);
		$db = new DB();
		$sql = "DELETE FROM preguntas WHERE id='$pid'";
		$db->execute($sql);
	}
	
	/*
    function getPreguntasEscuesta($id)
	{
	    $db = new DB();
		$sql = "SELECT * FROM preguntas WHERE encuesta_id = $id";
		$res = $db->query($sql);
		$data = "";
		while($line = $db->fetchNextObject($res))
		{
			$data .= "<tr><td colspan='4'><strong>";
			$data .= $line->pregunta."</strong> ";
			$data .= "<a href='index2.php?com=encuestas&do=deletepregunta&pid=$line->id&eid=$id' ";
			$data .= "onclick=\"return confirm('Confirma borrar?')\";>";
			$data .= "<img src='images/iconos/remove.png'></a></td></tr>";
			$data .= $this->getOpcionesRespuesta($line->id);
			$data .= "<tr><td colspan='4'></td></tr>";
		}
		return $data;
	} */
	
	public function getPreguntas()
	{
		$db = new DB();
		$sql = "SELECT * FROM eval_tutores_preg ORDER BY id ASC";
		return $db->query($sql);
	}

}

?>