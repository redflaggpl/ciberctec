<?php
define('APP_PATH', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
include ('includes'.DS.'creatur.ini.php');
require(APP_PATH.DS.'lib'.DS.'DB.php');
include_once (APP_PATH.DS.'lib'.DS.'media'.DS.'Media.php');
include_once (APP_PATH.DS.'lib'.DS.'Upload'.DS.'class.upload.php');

$fb = new Filebrowser();
$m = $fb->getTask();

class Filebrowser {
	
	
	public function getTask()
	{
		$action = isset($_REQUEST['action'])? $_REQUEST['action'] : null;

		switch($action) {
		    case 'upload':
		    	$this->setImg();
		    break;
		    case 'drop':
		    	$img = isset($_REQUEST['img'])? $_REQUEST['img'] : null;
		    	$this->unsetImg($img);
		    break;
		    default:
		    	$this->setInterface();
		}
	}
	
	public function setInterface()
	{
		$tpl = new Creatur_Smarty();
		$tpl->assign('path_img', IMG_WEB_PATH);
		$tpl->assign('media', $this->_getMedia());
		$tpl->display('mediaView.tpl');
	}
	
	private function _getMedia()
	{
		return Media::loadImages('', '', IMAGES);
	}
	
	public function setImg()
	{
		$msg = $this->imgUpload();
		$url = "filebrowser.php";
		Creatur::cosRedirect($url, $msg);
	}
	/**
	 * @desc sube una imagen jpg, png o gif al servidor
	 * @param void
	 * @return void
	 */
	private function imgUpload()
	{
		$msg = "";
		$dir = IMG_LOCAL_PATH;
		$dirweb = IMG_WEB_PATH;
		
		$handle = new Upload($_FILES['imagen']);
		
		if ($handle->uploaded) {
	
	        // movemos de temp a dir final
	        $handle->Process($dir);
	
	        // we check if everything went OK
	        if ($handle->processed) {
	            // everything was fine !
	            $msg .= '!Carga exitosa!: 
	            <a href="'.$dirweb.'/' . $handle->file_dst_name . '">'
	            .$handle->file_dst_name . '</a>';
	        } else {
	            // one error occured
	            $msg .= '<fieldset>';
	            $msg .= '  <legend>No es posible mover la imagen en la ruta indicada</legend>';
	            $msg .= '  Error: ' . $handle->error . '';
	            $msg .= '</fieldset>';
	        }
			
	        // we delete the temporary files
	        $handle->Clean();
	
	    } else {
	        // if we're here, the upload file failed for some reasons
	        // i.e. the server didn't receive the file
	        $msg .= '<fieldset>';
	        $msg .= '  <legend>No es posible cargar la imagen al servidor.</legend>';
	        $msg .= '  Error: ' . $handle->error . '';
	        $msg .= '</fieldset>';
	    }
	    
	    return $msg;
	}
	
	function unsetImg($img)
	{
		$path = IMG_LOCAL_PATH.$img;
		
		if(!unlink($path)){
			$msg = "Error al borrar el archivo. Contacte al administrador";
		
		} else {
			$msg = "Borrado exitoso!";
		}
		Creatur::cosRedirect('filebrowser.php', $msg);
	}
}