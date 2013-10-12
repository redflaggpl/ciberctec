<?php

class CatManUtils extends Elfic {
	
	public function getPeriodoActual()
	{
		$db = new DB();
		$y = date("Y");
		$m = date("n");
		$semestre = 1;
		
		if( $m > 6 ) $semestre = 2;
		
		$sql = "SELECT id FROM periodos WHERE semestre = '$semestre' "
		     . "AND anio = '$y'";
		return $db->queryUniqueValue($sql);
	}
	
	public function getPeriodoVigente()
	{
		$db = new DB();
		$sql = "SELECT id FROM periodos WHERE vigente='1'";
		return $db->queryUniqueValue($sql);
	}
	
	public function getHorasArray()
	{
		$horas['06:00:00'] = "6:00";
		$horas['06:30:00'] = "6:30";
		$horas['07:00:00'] = "7:00";
		$horas['07:30:00'] = "7:30";
		$horas['08:00:00'] = "8:00";
		$horas['08:30:00'] = "8:30";
		$horas['09:00:00'] = "9:00";
		$horas['09:30:00'] = "9:30";
		$horas['10:00:00'] = "10:00";
		$horas['10:30:00'] = "10:30";
		$horas['11:00:00'] = "11:00";
		$horas['11:30:00'] = "11:30";
		$horas['12:00:00'] = "12:00";
		$horas['12:30:00'] = "12:30";
		$horas['13:00:00'] = "13:00";
		$horas['13:30:00'] = "13:30";
		$horas['14:00:00'] = "14:00";
		$horas['14:30:00'] = "14:30";
		$horas['15:00:00'] = "15:00";
		$horas['15:30:00'] = "15:30";
		$horas['16:00:00'] = "16:00";
		$horas['16:30:00'] = "16:30";
		$horas['17:00:00'] = "17:00";
		$horas['17:30:00'] = "17:30";
		$horas['18:00:00'] = "18:00";
		$horas['18:30:00'] = "18:30";
		$horas['19:00:00'] = "19:00";
		$horas['19:30:00'] = "19:30";
		$horas['20:00:00'] = "20:00";
		$horas['20:30:00'] = "20:30";
		
		return $horas;
	}
	
	function getDiasArray()
	{
		$data = array();
		$data[1] = "Lunes";
		$data[2] = "Martes";
		$data[3] = "Miércoles";
		$data[4] = "Jueves";
		$data[5] = "Viernes";
		$data[6] = "Sábado";
		$data[7] = "Domingo";
		return $data;
	}
	
	function getSemestresArray()
	{
		$data = array();
		$data[1] = "1";
		$data[2] = "2";
		$data[3] = "3";
		$data[4] = "4";
		$data[5] = "5";
		$data[6] = "6";
		$data[7] = "7";
		$data[8] = "8";
		$data[9] = "9";
		$data[10] = "10";
		$data[11] = "11";
		return $data;
	}
	
	/**
	 * Arreglo con programas que ofrece el CAT
	 * @return array()
	 */
	public function getProgramasArray()
	{
		$db = new DB();
		$sql = "SELECT * FROM programas";
		$res = $db->query($sql);
		$data = array();
		while($line = $db->fetchNextObject($res))
		{
			$data[$line->id] = $line->programa;
		}
		return $data;
	}
	
	public function getPeriodosArrayCombo()
	{
		$db = new DB();
		$sql = "SELECT id, CONCAT(anio, '-', semestre) as periodo FROM periodos";
		$res = $db->query($sql);
		$data = array();
		while($line = $db->fetchNextObject($res))
		{
			$data[$line->id] = $line->periodo;
		}
		return $data;
	}
}

?>