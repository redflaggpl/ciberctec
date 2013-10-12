<?php

/**
 * @Package: Sistema de Información de Metabastos (SIMBA)
 * @subpackage Reportes - fincas
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.ins.net.co
 * @Date: Enero 14, 2011
 * @source : Reportes_Usuarios_List.php
 * @Version: 1.0
 */

include_once (ADMIN_DIR."/lib/reportes/Reportes.php");

class Reportes_Usuarios_List extends Reportes {
	
	private $anchors;
	
	private $total;
	
	function __construct(){
		
	}
	
	function getReport()
	{
		$tpl = new MB_Smarty();
		$tpl->assign('u',$this->_buildReport());
		$tpl->assign('anchors',$this->anchors);
		$tpl->assign('total',$this->total);
		$tpl->display('reportesUsuariosList.tpl');
	}
	
	
	function _buildReport($mid = "", $full = 0){
		
		if($mid != ""){
			$and = "AND u.municipio_id = $mid ";
		}
		
		$sql  = "SELECT u.id, u.name, u.username, u.email, u.usertype, u.block, u.sendEmail, ";
		$sql .= "u.gid, u.registerDate, u.lastvisitDate, u.cedula, u.perfil, u.pais, ";
		$sql .= "u.departamento, u.id_municipio, vereda, u.direccion, u.info_dir, ";
		$sql .= "u.telefono, u.celular, u.fax, u.visito, u.aprobo, m.municipio, d.departamento ";
		$sql .= "FROM mmb_users u ";
		$sql .= "INNER JOIN municipio m ON m.id_municipio = u.id_municipio ";
		$sql .= "INNER JOIN departamento d ON d.id_departamento = u.departamento ";
		$sql .= "WHERE u.perfil IN(2,4,6,7) ".$and;
		$sql .= " ORDER BY u.registerDate DESC";
		
		if(isset($_GET['starting'])){
			$starting=$_GET['starting'];
		}else{
			$starting=0;
		}
		
		$objpag = new Pagination($sql, $starting, 100, 'index2.php?com=reportes&do=usuarios');		
		$res = $objpag->result;
		
		if($full == 1){
			$db = new DB();
			$res = $db->query($sql);
		}
		
		$d = array();
		$x = 0;
		$line = "";
		while($line = $objpag->fetchNextObject($res)){
			$d[$x]['id'] = $line->id;
			$d[$x]['name'] = $line->name;
			$d[$x]['username'] = $line->username;
			$d[$x]['perfil'] = Usuarios::getNombrePerfil($line->perfil);
			$d[$x]['municipio'] = $line->municipio;
			$d[$x]['departamento'] = $line->departamento;
			$d[$x]['productos'] = $this->getProductos($line->id);
			$d[$x]['registerDate'] = $line->registerDate;
			$x++;
		}
		$this->anchors = $objpag->anchors;
		$this->total = $objpag->total;
		return $d;
	}
	
	function getProductos($id){
		$html = "";
		$db = new DB();
		$sql  = "SELECT up.producto_id, p.producto_nombre AS nombre ";
		$sql .= "FROM mmb_usuarios_productos up ";
		$sql .= "INNER JOIN mmb_productos p ON up.producto_id = p.producto_id ";
		$sql .= "WHERE up.usuario_id = '$id'";
		$result = $db->query($sql);
		while ($line = $db->fetchNextObject($result)) {
			$html .= $line->nombre.", ";
		}
		return $html;
		
	}
	
	function export()
	{
		$r = $this->_buildReport('', 1);
		$this->createExcel("total_usuarios.xls", $r);
	}
}