<?php

/**
 * @Package: Erudio Backend
 * @subpackage: Tareas
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> INS Ltda.
 * @File: Tareas.php
 * @Version: 1.0
 */
class Tareas extends Erudio {
	
	private $consecu;
	
	private $fecha;
	
	private $asunto;
	
	private $mensaje;
	
	private $tipmens;
	
	private	$fecvence;
	
	private $categoria;
	
	/**
	 * Lista de tareas dirigido a usuario en sesión (INBOX)
	 * @param string $cat filtro por categoria
	 * @param string $tipo filtro por tipo
	 */
	
	function listTareas($cat='', $tipo='', $borrado = 0)
	{
		global $uid;
		
		$db = new DB();
		$sql = "SELECT m.consecu, m.fecha, m.asunto, m.mensaje, m.tipmens, m.fecvence, ";
		$sql .= "m.categoria, m.documto_id as remitente, d.consecu, d.documto_id, d.leido, d.mensresp ";
		$sql .= "FROM mensajes m INNER JOIN destimens d ON m.consecu = d.consecu ";
		$sql .= "WHERE d.documto_id = '$uid' AND d.borrado = $borrado ORDER BY m.consecu DESC ";
		
		
		if(isset($_GET['starting'])){
			$starting=$_GET['starting'];
		}else{
			$starting=0;
		}
		
		$objpag = new Pagination($sql, $starting, 20, 'index2.php?com=comunicados&do=list');		
		$res = $objpag->result;
		
		$data = array();
		$x = 0;
		while($line = $objpag->fetchNextObject($res)){
			$data[$x]['consecu'] = $line->consecu;
			$data[$x]['fecha'] = $line->fecha;
			$data[$x]['asunto'] = $line->asunto;
			$data[$x]['adjuntos'] = $this->_tieneAdjuntos($line->consecu);
			$data[$x]['mensaje'] = $line->mensaje;
			$data[$x]['tipmens'] = $line->tipmens;
			$data[$x]['fecvence'] = $line->fecvence;
			$data[$x]['categoria'] = $line->categoria;
			$data[$x]['leido'] = $line->leido;
			$data[$x]['documto_id'] = Erudio::getNombreUsuario($line->remitente);
			$x++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Erudio_Smarty();
		$tpl->assign('com',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		if($borrado == 1){
			$tpl->assign('tipo', 'Borrados');
		}
		$tpl->display('comunicados/comunicadosList.tpl');
		
	}
	
    /**
	 * Lista de comunicados enviados (SENT)
	 */
	
	function listEnviados()
	{
		global $uid;
		
		$db = new DB();
		$sql = "SELECT consecu, fecha, asunto, tipmens, fecvence, categoria, documto_id, borrado ";
		$sql .= "FROM mensajes WHERE documto_id = '$uid' AND borrado = '0' ORDER BY consecu DESC ";
		
		
		if(isset($_GET['starting'])){
			$starting=$_GET['starting'];
		}else{
			$starting=0;
		}
		
		$objpag = new Pagination($sql, $starting, 20, 'index2.php?com=comunicados&do=list');		
		$res = $objpag->result;
		
		$data = array();
		$x = 0;
		while($line = $objpag->fetchNextObject($res)){
			$data[$x]['consecu'] = $line->consecu;
			$data[$x]['fecha'] = $line->fecha;
			$data[$x]['asunto'] = $line->asunto;
			$data[$x]['tipmens'] = $line->tipmens;
			$data[$x]['fecvence'] = $line->fecvence;
			$data[$x]['categoria'] = $line->categoria;
			$x++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Erudio_Smarty();
		$tpl->assign('com',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		$tpl->display('comunicados/comunicadosEnviados.tpl');
		
	}
	
	/**
	 * 
	 * Imprime form para nuevo comunicado
	 */
	public function newCom()
	{
		global $uid;
		
		$tpl = new Erudio_Smarty();
		$tpl->assign('uid', $uid);
		$tpl->assign('cats', $this->_getCategorias());
		$tpl->assign('tipos', $this->_getTipos());
		$tpl->assign('dest_est', $this->_getDestinatarios(3));
		$tpl->assign('dest_prof', $this->_getDestinatarios(2));
		$tpl->display('comunicados/comunicadosNew.tpl');
	}
	
	/**
	 * 
	 * Registra en DB nuevo comunicado
	 * @params globals
	 */
	public function setCom()
	{
		global $uid;
		$com = array();
		$com['fecha'] = Erudio::now();
		$com['asunto'] = $_POST['asunto'];
		$com['mensaje'] = $_POST['mensaje'];
		$com['tipmens'] = $_POST['tipmens'];
		$com['fecvence'] = $_POST['fecvence'];
		$com['categoria'] = $_POST['categoria'];
		$com['documto_id'] = $uid;
		$db = new DB();
		$db->perform('mensajes', $com);
		$this->consecu = $db->lastInsertedId();
		$dest_est = $_POST['dest_est'];
		$dest_prof = $_POST['dest_prof'];
		$this->_setDestinatarios($this->consecu, $dest_est);
		$this->_setDestinatarios($this->consecu, $dest_prof);
		$this->uploadDoc();
		Erudio::cosRedirect('index2.php?com=comunicados');
	}
	
	/**
	 * construye objeto con un comunicado
	 * @param int $consecu //id consecutivo del mensaje o comunicado
	 * @return object
	 */
	private function _getCom($consecu)
	{
		global $uid;
		
		$db = new DB();
		$sql  = "SELECT m.consecu, m.fecha, m.asunto, m.mensaje, m.tipmens, m.fecvence, ";
		$sql .= "m.categoria, m.documto_id, tm.codigo, tm.descrip as tipomensaeje ";
		$sql .= "FROM mensajes m INNER JOIN tipmens tm ON tm.codigo = m.tipmens ";
		$sql .= "WHERE m.consecu = $consecu";
		return $db->queryUniqueObject($sql);
	}

	/**
	 * visualiza un comunicado
	 * @param int $consecu //id consecutivo del mensaje o comunicado
	 * @return object
	 */
	public function viewCom($consecu)
	{
		global $uid;
		
		$this->consecu=$consecu;
		
		$this->_setLeido($consecu);
		
		$com = $this->_getCom($consecu);
		$tpl = new Erudio_Smarty();
		$tpl->assign('consecu', $com->consecu);
		$tpl->assign('fecha', $com->fecha);
		$tpl->assign('asunto', $com->asunto);
		$tpl->assign('mensaje', $com->mensaje);
		$tpl->assign('tipmens', $com->tipomensaje);
		$tpl->assign('fecvence', $com->fecvence);
		$tpl->assign('categoria', $com->categoriamensaje);
		$tpl->assign('documto_id', $com->documto_id);
		$tpl->assign('adjuntos', $this->_getAdjuntos());
		$tpl->display('comunicados/comunicadosView.tpl');
	}
	
	/**
	 * Lista adjuntos
	 * @param void
	 * @return array
	 */
	private function _getAdjuntos()
	{
		$db = new DB();
		$data = array();
		
		$sql = "SELECT * FROM mensattach WHERE consecu = $this->consecu";
		$res = $db->query($sql);
		$i=0;
		while($line = $db->fetchNextObject($res)){
			$data[$i]['id'] = $line->id;
			$data[$i]['path'] = "files".DS;
			$data[$i]['url'] = $line->url;
			$data[$i]['consecu'] = $line->consecu;
			$i++;
		}
		return $data;
	}
	
	/**
	 * marca mensaje como leido
	 * @param int $consecu id consecutivo del comunicado
	 * @return void
	 */
	private function _setLeido($consecu)
	{
	    global $uid;
	    $fecha = Erudio::now();
	    $db = new DB();
	    $sql = "SELECT leido FROM destimens WHERE consecu = '$consecu' AND documto_id = '$uid'";
	    if($db->queryUniqueValue($sql) == '0')
	    {
	    	$sql  = "UPDATE destimens SET leido = '1', fechalect = '$fecha' ";
	    	$sql .= "WHERE consecu = '$consecu' AND documto_id = '$uid'";
	    	$db->execute($sql);
	    }
	}
	
	/**
	 * registra destinatarios
	 * @params int $consecu consecutivo del mensaje
	 * @params string $lista arreglo de documentos de los destinatarios
	 */
	private function _setDestinatarios($consecu, $lista = '')
	{
		if($lista != '')
		{
			$db = new DB();
			foreach($lista as $dest) {
			  $d['consecu'] = $consecu;
			  $d['documto_id'] = $dest;
			  $d['leido'] = 0;
			  $d['borrado'] = 0;
			  $d['mensresp'] = 0;
			  $db->perform('destimens', $d);
			}
		}
	}
	
	/**
	 * 
	 * Arreglo con categorias de mensajes
	 * @access private
	 * @param void
	 * @return array
	 */
	private function _getCategorias()
	{
		$db = new DB();
		$sql = "SELECT * from categmens ORDER BY descrip ASC";
		$res = $db->query($sql);
		$data = array();
		while ($line = $db->fetchNextObject($res)){
			$data[$line->codigo] = $line->descrip;
		}
		return $data;
	}
	
	/**
	 * Arreglo con tipos de mensaje
	 * @access private
	 * @params void
	 * @return array
	 */
	private function _getTipos()
	{
		$db = new DB();
		$sql = "SELECT * from tipmens ORDER BY descrip ASC";
		$res = $db->query($sql);
		$data = array();
		while ($line = $db->fetchNextObject($res)){
			$data[$line->codigo] = $line->descrip;
		}
		return $data;
	}
	
	private function _getDestinatarios($tipo)
	{
		global $uid;
		
		$db = new DB();
		$sql = "SELECT documto_id, priape, segape, prinom, segnom, login ";
		$sql .= "FROM personas WHERE tippers = $tipo AND documto_id != $uid";
		$res = $db->query($sql);
		$data = array();
		$i=0;
		while ($line = $db->fetchNextObject($res)){
			$fullname = $line->priape." ".$line->segape." ".$line->prinom." ".$line->segnom;
			//$data[$line->documto_id] = $fullname;
			$data[$i]['documto_id'] = $line->documto_id;
			$data[$i]['fullname'] = $fullname;
			$i++;
		}
		return $data;
	}
	
	/**
	 * Borrado múltiple de mensajes
	 */
	public function delMul()
	{
		global $uid;
		
		$aLista=array_keys($_POST['cb']);
  		$sql  = "UPDATE destimens SET borrado = '1' WHERE consecu ";
  		$sql .= "IN (".implode(',',$aLista).") AND documto_id = $uid";
  		$db = new DB();
  		$db->execute($sql);
        Erudio::cosRedirect('index2.php?com=comunicados', 'Mensajes borrados correctamente');
	}
	
   /**
	 * Borrado múltiple de mensajes enviados
	 */
	public function delMulEnv()
	{
		global $uid;
		
		$aLista=array_keys($_POST['cb']);
  		$sql  = "UPDATE mensajes SET borrado = '1' WHERE consecu ";
  		$sql .= "IN (".implode(',',$aLista).") AND documto_id = $uid";
  		$db = new DB();
  		$db->execute($sql);
        Erudio::cosRedirect('index2.php?com=comunicados&do=enviados', 'Mensajes borrados correctamente');
	}
	
	
	/**
	 * Regitra doc adjunto en db
	 * @param array $data
	 * @return void
	 */
	private function _setDoc($data)
	{
		$db = new DB();
		$db->perform('mensattach', $data);
	}
	
    /**
	 * @desc adjunta ficheros a comunicado
	 * @param void global
	 * @return void
	 */
	private function uploadDoc()
	{
		$dir = APP_PATH.DS."files";
		$dirweb = DS."files";
		$data = array();
		
		$files = array();
	    foreach ($_FILES['archivos'] as $k => $l) {
	        foreach ($l as $i => $v) {
	            if (!array_key_exists($i, $files))
	                $files[$i] = array();
	            $files[$i][$k] = $v;
	        }
	    }
	    
	   foreach ($files as $file)
	    {
			$handle = new Upload($file);
		
			if ($handle->uploaded) {
		
		        // movemos de temp a dir final
		        $handle->Process($dir);
		
		        // we check if everything went OK
		        if ($handle->processed) {
		            // everything was fine !
		            echo '<fieldset>';
		            echo '  <legend>file uploaded with success</legend>';
		            echo '  <p>' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB</p>';
		            echo '  link to the file just uploaded: <a href="'.$dirweb.'/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a>';
		            echo '</fieldset>';
		            $data['url'] = $handle->file_dst_name;
		            $data['consecu'] = $this->consecu;
		            $this->_setDoc($data);
		        } else {
		            // one error occured
		            echo '<fieldset>';
		            echo '  <legend>file not uploaded to the wanted location</legend>';
		            echo '  Error: ' . $handle->error . '';
		            echo '</fieldset>';
		        }
		
		        // we delete the temporary files
		        $handle->Clean();
		
		    } else {
		        // if we're here, the upload file failed for some reasons
		        // i.e. the server didn't receive the file
		        echo '<fieldset>';
		        echo '  <legend>file not uploaded on the server</legend>';
		        echo '  Error: ' . $handle->error . '';
		        echo '</fieldset>';
		    }
	    } 
	}
	
	/**
	 * Si tiene adjuntos
	 * @param $consecu id del comunicado
	 * @return string
	 */
	private function _tieneAdjuntos($consecu)
	{
		$icon = "";
		$db = new DB();
		if(($db->countOf('mensattach', 'consecu = '.$consecu)) > 0)
		{
			$icon = '<img src="images/iconos/22/attach.png">';
		}
		return $icon;
	}
}

?>