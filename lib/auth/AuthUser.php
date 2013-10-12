<?php

/**
 * 
 * @author redflag
 *
 */

class AuthUser extends Utils {
	
	private $user; //session login
	
	private $passwd;
	
	private $user_id;
	
	private $user_group;
	
	private $user_full_name;
	
	private $user_email;
	
	private $restrictGoTo = "index.php?action=logout";
	
	private $mainpage = "index.php";
	
	private $loginpage = "index.php?action=login";
	
	function __construct (){
		
		if (!isset($_SESSION)) {
	  		session_start();
		}
	
	}
	
	function login($user, $passwd){
	  		
		if ($user != "" && $passwd != "") {
			$this->user = $user;
			$this->passwd = $passwd;
			$db = new DB();
			$query  = "SELECT password FROM ".TBL_USUARIOS." WHERE login='$user'";
	  		$encrypt = $db->queryUniqueValue($query);
	  		
	  		if (!$this->validate_password($passwd, $encrypt)){
		  		$msg = "La combinaci&oacute;n de usuario y password que ingreso no es correcta";
		  	 	Utils::cosRedirect('index.php?logout=true',$msg);
			} else { 
			 	$password = $encrypt;
			} 
	  
			$db = new DB();
			$query = "SELECT id FROM ".TBL_USUARIOS." WHERE login='$user' AND password='$password' ";
			$query .= "AND activo = '1'";   
			$result = $db->queryUniqueValue($query);
			if ($result > 0) {
				$this->user_id = $result;
				$this->set_user();
			} else {
				$msg = "Error. No es posible validar el ingreso";
				Utils::cosRedirect('index.php?logout=true',$msg);
			}
		} 
	}
	
	/**
	 * @desc incia variables de sesion. registra fecha de visita del usuario
	 * @param void
	 * @return void
	 */
	function set_user() {
			
		$_SESSION['login'] = $this->user;
		$_SESSION['passwd'] = $this->passwd;
		$_SESSION['uid'] = $this->user_id;
		
		$now = date("Y-n-j"." "."H:i:s");
		$db = new DB();
		$sql = "UPDATE ".TBL_USUARIOS." SET ultimoingreso='$now' WHERE id='$this->user_id'";
		$db->execute($sql);
	}
	
	
	/**
	 * @desc destruye variables de sesión
	 * @param void
	 * @return void
	 */
	function logout() {
		unset($_SESSION['user']);
		unset($_SESSION['passwd']);
		unset($_SESSION['uid']);
		$msg = "Se ha cerrado correctamente la sesi&oacute;n";
		Utils::cosRedirect('index.php?action=login',$msg);
	} 
	
	/**
	 * @desc true si usuario esta logeado
	 * @param void
	 * @return boolean
	 */
	function isLoggedIn(){
		if(!isset($_SESSION['login']) || !isset($_SESSION['passwd']) || !isset($_SESSION['uid'])){
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * @desc true si usuario es admin
	 * @param int $uid id usuario
	 * @return boolean
	 */
	private function is_admin($uid){
		$db  = new DB();
		$sql  = "SELECT esadmin FROM ".TBL_USUARIOS." WHERE id = '$uid'";
		if($db->queryUniqueValue($sql) == '1'){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @desc true si usuario tiene permiso
	 * @param string $perm
	 * @return boolean
	 */
	function checkRight($perm){
		global $uid;
		//$uid = $_SESSION['uid'];
		$groups = $this->get_groups($uid);
		$perm_id = $this->get_id_perm($perm);
		
		if($this->is_admin($uid)){
			return true;
		}
		
		if(!$groups){
			return false;
		} else {
			$x = count($groups);
			while ($x>0){
				$db = new DB();
				$sql  = "SELECT * FROM ".TBL_AUTHS." WHERE usuarios_grupo_id = '$groups[$x]' ";
				$sql .= "AND usuarios_permiso_id = '$perm_id'";
				$res = $db->query($sql);
				if($db->numRows($res)>0){
					return true;
				}
				$x--;
			}
		}
		
		return false;
	}
	
	private function get_id_perm($perm){
		$db = new DB();
		$sql  = "SELECT usuarios_permiso_id FROM ".TBL_PERMISOS." ";
		$sql .= "WHERE usuarios_permiso_nombre = '$perm'";
		return $db->queryUniqueValue($sql);
	}
	
	/**
	 * @desc grupos a los que pertenece usuario
	 * @param int $uid user id
	 * @return array
	 */
	private function get_groups($uid){
		$db = new DB();
		$sql = "SELECT usuarios_grupo_id FROM ".TBL_GRUPOS_LINKS." WHERE usuario_id = '$uid'";
		$res = $db->query($sql);
		if($db->numRows($res)>0){
			$x = 1;
			while ($line = $db->fetchNextObject($res)){
				$groups[$x] = $line->usuarios_grupo_id;
				$x++;
			}
		} else {
			return false;
		}
		return $groups;
	}
	
	/**
	 * @desc compara cadena limpia enviada por usuario con encriptada de la db
	 * @param string $plain
	 * @param string $encrypted
	 * @return boolean
	 */
    function validate_password($plain, $encrypted) {
	    
	// split apart the hash / salt
	      $stack = explode(':', $encrypted);
	
	      if (sizeof($stack) != 2) return false;
	
	      if (md5($stack[1] . $plain) == $stack[0]) {
	        return true;
	      }
	
	    return false;
	  }
  
	
	/**
	 * @desc Hace un password encriptado de un password en texto plano
	 * @param strin $plain
	 * @return string md5
	 */
    function encrypt_password($plain) {
	    $password = '';
	
	    for ($i=0; $i<10; $i++) {
	      $password .= Elfic::Rand();
	    }
	
	    $salt = substr(md5($password), 0, 2);
	
	    $password = md5($salt . $plain) . ':' . $salt;
	
	    return $password;
	 }

}

?>