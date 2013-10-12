<?php
include ('../../../../includes/erudio.ini.php');
include_once (ADMIN_DIR.'lib/media/Media.php');
include_once (ADMIN_DIR.'lib/Upload/class.upload.php');

$fb = new Filebrowser();
$m = $fb->setInterface();

class Filebrowser {
	
	private $media;
	
	public function setInterface()
	{
		$tpl = new Creatur_Smarty();
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
		$url = "index2.php?com=eventos&do=view&eid=".$this->_event_id;
		Creatur::cosRedirect($url, $msg);
	}
	/**
	 * @desc sube una imagen jpg al servidor
	 * @param void
	 * @return void
	 */
	private function imgUpload()
	{
		$msg = "";
		$dir = IMG_LOCAL_PATH."eventos/".$this->_event_id;
		$dirweb = IMG_WEB_PATH."eventos/".$this->_event_id;
		
		$handle = new Upload($_FILES['urlfoto']);
		
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
	        $msg .= '  <legend>No es pposible cargar la imagen al servidor.</legend>';
	        $msg .= '  Error: ' . $handle->error . '';
	        $msg .= '</fieldset>';
	    }
	    
	    return $msg;
	}
	
	function unsetImg($img)
	{
		$path = IMG_LOCAL_PATH."eventos/".$this->_event_id."/".$img;
		
		if(!unlink($path)){
			$msg = "Error al borrar el archivo. Contacte al administrador";
		
		} else {
			$msg = "Borrado exitoso!";
		}
		Creatur::cosRedirect('index2.php?com=eventos&do=view&eid='.$this->_event_id, $msg);
	}
}