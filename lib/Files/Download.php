<?php
/**
 * @package Elfic
 * @subpackage Files - Download
 * @Author edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: 2011 Mayo 9 
 * @File: Download.php
 * @Version: 1.0
 */
class Download extends Elfic {
	
	private $path = PATH_FILES;
	
	private $file = null;
	
	private $id = null;
	
    function __construct()
    {
  
    }
    
    public function getFile($id, $consecu)
    {
    	global $uid;
    	$db = new DB();
    	$sql = "SELECT a.id, a.url, a.consecu, d.consecu, d.documto_id "
    	     . "FROM mensattach a INNER JOIN destimens d "
    	     . "ON a.consecu = d.consecu WHERE d.documto_id = $uid AND a.id=$id";
    	$res = $db->queryUniqueObject($sql);
    	if(!$res){
    		$sql = "SELECT a.id, a.url, a.consecu, m.consecu, m.documto_id "
    	     . "FROM mensattach a INNER JOIN mensajes m "
    	     . "ON a.consecu = m.consecu WHERE m.documto_id = $uid AND a.id=$id";
    		$res = $db->queryUniqueObject($sql);
    	}
    	
    	if($res){
    		$this->_setDownload($res->url);
    	} else {
    		echo "Error al recuperar el archivo. Contacte al administrador";
    	}
    }
    

	function _setDownload($file)
	{
		$enlace = FILES_PATH."/".$file;
		header("Content-type: application/force-download"); 
        header("Content-Disposition: attachment; filename=".basename($file)); 
        header("Content-Transfer-Encoding: binary"); 
        header("Content-Length: ".filesize($enlace)); 
        readfile($enlace);
	}
	
	
}