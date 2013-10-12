<?php

class Catedras extends Elfic {
	
	/**
	 * Id de catedra.
	 *
	 * @var string
	 */
	private $_id;
	
	
	/**
	 * Si envia id al constructor inicializa catedra.
	 *
	 * @param int $id
	 */
	function __construct($id = ''){
		if($id != ''){
			$this->_id = $id;
		}
	}
	
	/**
	 * @desc retorna objeto con datos básicos de catedra
	 * @param $id 
	 * @return object
	 */
	function getCatedra($id){
		$db = new DB();
		$sql  = "SELECT * FROM catedra WHERE id = '$id'";
		return $db->queryUniqueObject($sql);
	}
	
	/**
	 * Imprime vista de creación de curso
	 *
	 */
	public function nuevo(){
		global $uid;
	
		$tpl = new Elfic_Smarty();
		$tpl->assign('programas', CatManUtils::getProgramasArray());
		$tpl->assign('semestres', CatManUtils::getSemestresArray());
		$tpl->assign('estados',$this->getEstadosArray());
		$tpl->display('catedras/catedrasNew.tpl');
	}
	
	/**
	 * @desc Form de edición de curso
	 */
	public function edit(){
		global $uid;
	
		$tpl = new Elfic_Smarty();
		$data = $this->getCatedra($this->_id);
		$tpl->assign('cid',$data->id);
		$tpl->assign('nombre',$data->nombre);
		$tpl->assign('programas_id',$data->programas_id);
		$tpl->assign('programas', CatManUtils::getProgramasArray());
		$tpl->assign('semestre',$data->semestre);
		$tpl->assign('semestres', CatManUtils::getSemestresArray());
		$tpl->assign('horas', $data->horas);
		$tpl->assign('estado', $data->estado);
		$tpl->assign('estados',$this->getEstadosArray());
		$tpl->display('catedras/catedrasEdit.tpl');
	}
	
	/**
	 * @desc Registra datos básicos de un Usuario. Insert o Update
	 * @param string $action "new" para nuevo
	 * @return void
	 */
	public function save($action=null){
		
		$db = new DB();
		$data = array();
		
		$data['nombre'] = strtoupper($db->sqlInput($_REQUEST['nombre'], 'text'));
		$data['programas_id'] = $db->sqlInput($_REQUEST['programas_id'], 'int');
		$data['semestre'] = $db->sqlInput($_REQUEST['semestre'], 'int');
		$data['horas'] = $db->sqlInput($_REQUEST['horas'], 'text');
		$data['estado'] = $db->sqlInput($_REQUEST['estado'], 'int');
	
		if($action == "new"){
			$db->perform('catedra', $data);
			$id = $db->lastInsertedId();
			$msg = MSG_CATEDRA_CREADA;
		} else {
			$id	= $db->sqlInput($_REQUEST['cid'], 'int');
			$db->perform('catedra', $data, 'update', 'id='.$id);
			$msg = MSG_CATEDRA_UPDATE;
		}
		$url = "index2.php?com=catedras&do=view&cid=".$id;
		Elfic::cosRedirect($url, $msg);
	}
	
	public function listAll($catedra = "")
	{
		global $uid, $uperms;
		
		$and = "";
		
		if($catedra != "")
		{
			$and .= "AND c.nombre LIKE '%$catedra%' ";
		}
		
		$db = new DB();
		$sql = "SELECT c.id, c.nombre, c.semestre, c.horas, c.estado, p.programa, p.descripcion "
		     . "FROM catedra c INNER JOIN programas p ON c.programas_id = p.id "
	 	     . "WHERE c.id > 0 $and";
		
		if(isset($_GET['starting'])){
			$starting=$_GET['starting'];
		}else{
			$starting=0;
		}
		
		$objpag = new Pagination($sql, $starting, 20, 'index2.php?com=catedras&do=search');
		$res = $objpag->result;
		
		$data = array();
		$x = 0;
		while($line = $objpag->fetchNextObject($res)){
			$data[$x]['id'] = $line->id;
			$data[$x]['nombre'] = $line->nombre;
			$data[$x]['programa'] = $line->programa;
			$data[$x]['descripcion'] = $line->descripcion;
			$data[$x]['semestre'] = $line->semestre;
			$data[$x]['horas'] = $line->horas;
			$data[$x]['estado'] = Elfic::getBlockIcon($line->estado);
			$x++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Elfic_Smarty();
		$tpl->assign('data',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		$tpl->display('catedras/catedrasList.tpl');
	}
	
	
	 private function _getPeriodos()
	 {
	 	$sql = "SELECT id, CONCAT(anio, '-', semestre) AS periodo FROM periodos ORDER BY id DESC";
	 	$db = new DB();
	 	$res = $db->query($sql);
	 	while($line = $db->fetchNextObject($res))
	 	{
	 		$data[$line->id] = $line->periodo;
	 	}
	 	return $data;
	 }
	 
	 /**
	  * @desc Un arreglo con estados de activo o inactivo
	  * @param void
	  * @return array
	  */
	 function getEstadosArray()
	 {
	 	$estado = array();
	 	$estado['1']="Activo";
	 	$estado['0']="Inactivo";
	 	return $estado;
	 }
	 
}

?>