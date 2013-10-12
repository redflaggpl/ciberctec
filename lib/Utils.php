<?php

/**
 * Project: Elfic Framework
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: 24 de Marzo, 2010
 * @File: Utils.php
 * @Version: 1.0
 */

class Utils extends DB {

	
	function getIcon($id){
		if($id=='s' || $id=='1'){ 
			return "<img src='images/iconos/ok.png' border='0'>";
		}
		return "<img src='images/iconos/button_fewer.png' border='0'>";
	}
	
	function getBlockIcon($id){
		if($id=='1'){ 
			return  "<img src='images/iconos/button_fewer.png' border='0'>";
		}
		return "<img src='images/iconos/ok.png' border='0'>";
	}
	
	/**
	 * @desc Limita la salida de la cadena a numero tope de caracteres
	 * @param string
	 * @param int $limit. Número máximo de caracteres de salida
	 * @return string
	 */
	function truncate($string, $limit)
	{
		
		if (strlen($string) <= $limit) {
	    $string = $string; //do nothing
		}
		else {
		    $string = wordwrap($string, $limit);
		    $string = substr($string, 0, strpos($string, "\n"));
		}
		return $string;
	}
	
	function getNombre($id, $tabla, $campoid, $camponombre){
		$db = new DB();
		$sql = "SELECT $camponombre FROM $tabla WHERE $campoid = '$id'";
		return $db->queryUniqueValue($sql);
	}
	
	/**
	 * @desc Devuelve el nombre de un usuario
	 * @param int $id
	 * @return string
	 */
	function getNombreUsuario($id)
	{
		$db = new DB();
		$sql = "SELECT CONCAT(nombres, ' ', apellidos) as nombre ";
		$sql .= "FROM usuarios WHERE id = '$id'";
	    return $db->queryUniqueValue($sql);
	}

	
	/**
	 * @desc Un arreglo con estados de registro aprobado o pendiente
	 * @param void
	 * @return array
	 */
	function getEstados()
	{
		$estado = array();
		$estado['1']="Aprobado";
		$estado['0']="Pendiente";
		return $estado;
	}
	
	/**
	* Utility function redirect the browser location to another url
	* Can optionally provide a message.
	* @param string The file system path
	* @param string A filter for the names
	*/
	function cosRedirect( $url, $msg='' )
	{
	
	    if (trim( $msg )) {
	        if (strpos( $url, '?' )) {
	            $url .= '&msg=' . urlencode( $msg );
	        } else {
	            $url .= '?msg=' . urlencode( $msg );
	        }
	    }
	
	    if (headers_sent()) {
	        echo "<script>document.location.href='$url';</script>\n";
	    } else {
	        @ob_end_clean(); // clear output buffer
	        header( 'HTTP/1.1 301 Moved Permanently' );
	        header( "Location: ". $url );
	    }
	    exit();
	}
	
	/**
	 * @desc fecha y hora actual
	 * @return datetime
	 */
	function now()
	{
		return date("Y-m-d"." "."H:i:s");
	}
	
    /**
	 * @desc fecha actual
	 * @return date
	 */
	function nowDate()
	{
		return date("Y-m-d");
	}
	
	/**
	 * parentescos entre usuarios
	 * @param void
	 * @return array
	 */
	function getLogicArray()
	{
		$option = array();
		$option['s']="Si";
		$option['n']="No";
		return $option;
	}
	
	
	function getMesesArray()
	{
		$meses = array();
		$meses[1] = "Enero";
		$meses[2] = "Febrero";
		$meses[3] = "Marzo";
		$meses[4] = "Abril";
		$meses[5] = "Mayo";
		$meses[6] = "Junio";
		$meses[7] = "Julio";
		$meses[8] = "Agosto";
		$meses[9] = "Septiembre";
		$meses[10] = "Octubre";
		$meses[11] = "Noviembre";
		$meses[12] = "Diciembre";
		return $meses;
	}
	
	function getDiasArray()
	{
		$dias = array();
		$dias[1] = "1";
		$dias[2] = "2";
		$dias[3] = "3";
		$dias[4] = "4";
		$dias[5] = "5";
		$dias[6] = "6";
		$dias[7] = "7";
		$dias[8] = "8";
		$dias[9] = "9";
		$dias[10] = "10";
		$dias[11] = "11";
		$dias[12] = "12";
		$dias[13] = "13";
		$dias[14] = "14";
		$dias[15] = "15";
		$dias[16] = "16";
		$dias[17] = "17";
		$dias[18] = "18";
		$dias[19] = "19";
		$dias[20] = "20";
		$dias[21] = "21";
		$dias[22] = "22";
		$dias[23] = "23";
		$dias[24] = "24";
		$dias[25] = "25";
		$dias[26] = "26";
		$dias[27] = "27";
		$dias[28] = "28";
		$dias[29] = "29";
		$dias[30] = "30";
		$dias[31] = "31";
		return $dias;
	}
	
	/**
	 * devuelve el valor de el id de un array
	 * @param int $id
	 * @param array $array
	 * @return string
	 */
	function getValueArray($id, $array)
	{
		foreach($array as $indice => $valor) { 
   			if($indice == $id){
   				return $valor;
   			}
		} 
		return false;
	}
	
	/**
	 * @desc Un arreglo con horas 00 a 23
	 * @param void
	 * @return array
	 */
	function getHorasArray()
	{
		$hora = array();
		for($i=0;$i<24;$i++){
			$hora[$i]=$i;
		}
		return $hora;
	}
	
	
	
	/**
	 * @desc Un arreglo valores cada 15 minutos
	 * @param void
	 * @return array
	 */
	function getMinutosArray()
	{
		$min = array();
		$min['00']="00";
		$min['05']="05";
		$min['10']="10";
		$min['15']="15";
		$min['20']="20";
		$min['25']="25";
		$min['30']="30";
		$min['35']="35";
		$min['40']="40";
		$min['45']="45";
		$min['50']="50";
		$min['55']="55";
		return $min;
	}
	
	/**
	 * @desc retorna string mes a partir de numero
	 * @param int $mes
	 * @return srting
	 */
	public function getMes($mes)
	{
		switch($mes){
			case 1:
				return "Ene";
			break;
			case 2:
				return "Feb";
			break;
			case 3:
				return "Mar";
			break;
			case 4:
				return "Abr";
			break;
			case 5:
				return "May";
			break;
			case 6:
				return "Jun";
			break;
			case 7:
				return "Jul";
			break;
			case 8:
				return "Ago";
			break;
			case 9:
				return "Sep";
			break;
			case 10:
				return "Oct";
			break;
			case 11:
				return "Nov";
			break;
			case 12:
				return "Dic";
			break;
		}
	}
	
	/**
	 * @desc retorna string mes a partir de numero
	 * @param int $mes
	 * @return srting
	 */
	public function getDiaNombre($dia)
	{
		switch($dia){
			case 1:
				return "Lunes";
				break;
			case 2:
				return "Martes";
				break;
			case 3:
				return "Miércoles";
				break;
			case 4:
				return "Jueves";
				break;
			case 5:
				return "Viernes";
				break;
			case 6:
				return "Sábado";
				break;
			case 7:
				return "Domingo";
				break;
		}
	}
	
	/**
	 * Elimina acentos, espacios y mayusculas de una cadena
	 * Usada para crear rutas UNIX.
	 * @param string $string
	 */
	
	function builtpath($string)
	{
		$path0 = str_replace(' ', '_', $string);
		$path1 = strtolower($path0);
		$path = utf8_encode($this->elimina_acentos($path1));
		return $path;
	}
	
	/**
	 * Suprime acentos de una cadena
	 * @param string $cadena
	 */
	
	function stripAcentos($cadena){
		$tofind = "�����������������������������������������������������";
		$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
		return(strtr($cadena,$tofind,$replac));
	}
	
	function Rand($min = null, $max = null)
	{
    	static $seeded;

	    if (!$seeded) {
	      mt_srand((double)microtime()*1000000);
	      $seeded = true;
	    }
	
	    if (isset($min) && isset($max)) {
	      if ($min >= $max) {
	        return $min;
	      } else {
	        return mt_rand($min, $max);
	      }
	    } else {
	      return mt_rand();
	    }
  }
	  
}

?>