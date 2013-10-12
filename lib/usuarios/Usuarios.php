<?php
/**
 * @package Elfic
 * @subpackage Elfic usuarios
 * @Author edison <edison [DOT] galindo [AT] gmail [DOT] com>
 * @Date: Noviembre de 2010
 * @File: Usuarios.php
 * @Version: 1.0
 * 
 * Esta clase define las propiedades y metodos de un Usuario
 */
include_once (APP_PATH.DS.'lib'.DS.'usuarios'.DS.'Grupos.php');

class Usuarios extends Elfic {
	
	/**
     * Id del usuario.
     *
     * @var string
     */
	private $_id;
	
	
	/**
     * Si envia id al constructor inicializa usuario.
     *
     * @param int $id
     */
	function __construct($id = ''){
		if($id != ''){
			$this->_id = $id;
		}
	}
	
	/**
	 * @desc retorna objeto con datos básicos de usuario
	 * @param $id id del usuario
	 * @return object
	 */
	function getUser($id){
		$db = new DB();
		$sql  = "SELECT * FROM usuarios WHERE id = '$id'";
		return $db->queryUniqueObject($sql);
	}
	
	/**
	 * @desc Construye listado de usuarios e imprime template
	 * @param $search
	 * @return void (imprime plantilla)
	 */
	function listAll($search="", $grupo=""){
		
		$where = "";
		
		if($search != ""){
			$where .= "AND nombres LIKE '%$search%' OR apellidos LIKE '%$search%' ";
		}
		
		if($grupo != ""){
			$where .= "AND id IN (SELECT usuario_id "
			       . "FROM usuarios_grupos_links WHERE usuarios_grupo_id = $grupo) ";
		}
		
		$db = new DB();
		$sql  = "SELECT * FROM usuarios ";
		$sql .= "WHERE id > 0 ". $where;
		$sql .= " ORDER BY nombres ASC";
		
		
		if(isset($_GET['starting'])){
			$starting=$_GET['starting'];
		}else{
			$starting=0;
		}
		
		$objpag = new Pagination($sql, $starting, 20, 'index2.php?com=usuarios&do=search');		
		$res = $objpag->result;
		
		$data = array();
		$i = 0;
		while($line = $objpag->fetchNextObject($res)){
			$data[$i]['id'] = $line->id;
			$data[$i]['nombres'] = $line->nombres;
			$data[$i]['apellidos'] = $line->apellidos;
			$data[$i]['email'] = $line->email;
			$data[$i]['creado'] = $line->creado;
			$data[$i]['modificado'] = $line->modificado;
			$data[$i]['ultimoingreso'] = $line->ultimoingreso;
			$data[$i]['activo'] = $this->getIcon($line->activo);
			$data[$i]['esadmin'] = $this->getIcon($line->esadmin);
			$i++;
		}
		$anchors = $objpag->anchors;
		$total = $objpag->total;
		$tpl = new Elfic_Smarty();
		$g = new Grupos();
		$tpl->assign('grupos',$g->getGruposArray());
		$tpl->assign('grupo_id',$grupo);
		$tpl->assign('u',$data);
		$tpl->assign('anchors',$anchors);
		$tpl->assign('total',$total);
		$tpl->display('usuarios/usuariosList.tpl');
	}
	
    /**
	 * Imprime vista de creación de usuario
	 * 
	 */
	public function nuevo(){
		global $uid;
		
		$tpl = new Elfic_Smarty();
		$tpl->assign('activo',$this->getEstadosArray());
		$tpl->assign('esadmin',$this->getEstadosArray());
	    $tpl->display('usuarios/usuariosNew.tpl');
	}
	
	/**
	 * @desc Form de edición de usuario, perfiles, estado
	 */
	public function edit(){
		global $uid;
		
		$tpl = new Elfic_Smarty();
		$data = $this->getUser($this->_id);
		$tpl->assign('uid',$data->id);
		$tpl->assign('nombres',$data->nombres);
		$tpl->assign('apellidos',$data->apellidos);
		$tpl->assign('login',$data->login);
		$tpl->assign('email',$data->email);
		$tpl->assign('creado', $data->creado);
		$tpl->assign('ultimoingreso', $data->ultimoingreso);
		$tpl->assign('activo_combo',$this->getEstadosArray());
		$tpl->assign('esadmin_combo',$this->getEstadosArray());
		$tpl->assign('activo', $data->activo);
		$tpl->assign('esadmin', $data->esadmin);
		
		$grp = new Grupos();
		$tpl->assign('grupos', $grp->chkUserGroup($this->_id));
		
		/* Pestañas por tipo de usuario usuario */
		/* coordinador */
		if($grp->siUsuarioEnGrupo($this->_id, 2) > 0)
		{
			$coordinador = 1;
			$programas = CatManUtils::getProgramasArray();
			$tpl->assign('programas', $programas);
			$tpl->assign('coordinador', $coordinador);
			$tpl->assign('progdata', Coordinadores::getProgramasArray($this->_id));
		}
		
		/* pestaña estudiante */
		if($grp->siUsuarioEnGrupo($this->_id, 5) > 0)
		{
			$estudiante = 1;
			$programas = CatManUtils::getProgramasArray();
			//$cursos = Cursos::getCursos()
			$tpl->assign('programas', $programas);
			$tpl->assign('estudiante', $estudiante);
			$tpl->assign('cursos', Cursos::getCursosEstudianteArray($this->_id));
		}
		
		
	    $tpl->display('usuarios/usuarioEdit.tpl');
	}
	
	/**
	 * @desc Registra datos básicos de un Usuario. Insert o Update
	 * @param string $action "new" para nuevo
	 * @return void
	 */
	public function save($action=null){
		global $uid;
		
		$db = new DB();
		$data = array();
		$data['nombres'] = $db->sqlInput($_REQUEST['nombres'], 'string');
		$data['apellidos'] = $db->sqlInput($_REQUEST['apellidos'], 'string');
		$data['login'] = $db->sqlInput($_REQUEST['login'], 'string');
		$data['email'] = $db->sqlInput($_REQUEST['email'], 'string');
		$data['modificado'] = Elfic::now();
		$data['activo'] = $db->sqlInput($_REQUEST['activo'], 'string');
		$data['esadmin'] = $db->sqlInput($_REQUEST['esadmin'], 'string');
		
		if($action == "new"){
			$data['creado'] = Elfic::now();
			$data['password'] 	= AuthUser::encrypt_password($_REQUEST['password']);
			$db->perform('usuarios', $data);
			$id = $db->lastInsertedId();
			$msg = MSG_USR_CREATE;				
		} else {
			if(isset($_REQUEST['password']) && $_REQUEST['password'] != ""){
				$data['password'] 	= $db->sqlInput($_REQUEST['password'], 'string');
			}
			$id	= $db->sqlInput($_REQUEST['uid'], 'int');
			$db->perform('usuarios', $data, 'update', 'id='.$id);
			$msg = MSG_USR_UPDATE;
		}
		$url = "index2.php?com=usuarios&do=view&uid=".$id;
		Elfic::cosRedirect($url, $msg);
	}
	
	/**
	 * cambia contraseña de usuario
	 */
	
	function chpasswd(){
		$id = $_REQUEST['uid'];
		$cleanpasswd = $_REQUEST['password'];
		$passwdenc = AuthUser::encrypt_password($cleanpasswd);
		$db = new DB();
		$sql  = "UPDATE usuarios SET password = '$passwdenc' ";
		$sql .= "WHERE id = '$id'";
		$db->execute($sql);
		$url = "index2.php?com=usuarios&do=view&uid=".$id;
		Elfic::cosRedirect($url);
	}
	
	function prepare($id=""){
		
		$username = $_REQUEST['login'];
		$email = $_REQUEST['email'];
		$error = null;
		if(usuarios::chkUser($username, $id)){
			$error = "El nombre de usuario ya existe en el sistema.";
		} 
		if(Usuarios::chkEmail($email, $id)){
			$error .= " El Email ya existe en el sistema";
		}
		if(isset($error)){
			if($id != ""){
				Elfic::cosRedirect('index2.php?com=usuarios&&do=view&uid='.$id, $error);
			} else {
				Elfic::cosRedirect('index2.php?com=usuarios&do=new', $error);
			}
		} else {
			return false;
		}
	}
	
	/**
	 * Verifica si un email ya ha sido registrado por algún usuario
	 * @param String $email
	 * @param int $id
	 * @return boolean
	 */
	function chkEmail($email, $id = '')
	{
		$and = '';
		if($id != ''){
			$and = "AND id != $id";
		}
		$db = new DB();
		$sql = "SELECT id FROM usuarios WHERE email = '$email' ".$and;
		$result = $db->queryUniqueValue($sql);
		if($result){
			return true;
		}
		return false;
	}
	
	/**
	 * Verifica si un login (cédula) ya ha sido registrado por algún usuario
	 * @param String $login
	 * @param int $id
	 * @return boolean
	 */
	function chkUser($login, $id = '')
	{
		$and = '';
		if($id != ''){
			$and = "AND id != $id";
		}
		$db = new DB();
		$sql = "SELECT id FROM usuarios WHERE login = '$login' ".$and;
		$result = $db->queryUniqueValue($sql);
		if($result){
			return true;
		}
		return false;
	}
	
	/**
	 * @desc los 5 más recientes registros de usuario
	 */
	public function last($n)
	{
		$db = new DB();
		$sql  = "SELECT id, login, nombres, apellidos, creado ";
		$sql .= "FROM usuarios ORDER BY creado DESC LIMIT $n ";
		$res =$db->query($sql);
		$i = 0;
		$u = array();
		while($line = $db->fetchNextObject($res))
		{
			$u[$i]['id'] = $line->id;
			$u[$i]['login'] = $line->login;
			$u[$i]['username'] = $line->nombres . " " . $line->apellidos;
			$u[$i]['creado'] = $line->creado;
			$i++;
		}
		return $u;
	}
	
	/**
	 * @desc Un arreglo con estados de activo o inactivo
	 * @param void
	 * @return array
	 */
	function getEstadosArray()
	{
		$estado = array();
		$estado['1']="Si";
		$estado['0']="No";
		return $estado;
	}
	
	
}
?>