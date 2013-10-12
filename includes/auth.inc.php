<?php 
$auth = new AuthUser();

//user id como globlal
$uid = $_SESSION['uid'];
//login como global
$login = $_SESSION['login'];

if(!$auth->isLoggedIn()) {
	Elfic::cosRedirect('index.php?action=login');
}

$uperms['usuarios_r'] = $auth->checkRight('USUARIOS_R');
$uperms['usuarios_w'] = $auth->checkRight('USUARIOS_W');
$uperms['agenda_r'] = $auth->checkRight('AGENDA_R');
$uperms['agenda_w'] = $auth->checkRight('AGENDA_W');
$uperms['asistencia_r'] = $auth->checkRight('ASISTENCIA_R');
$uperms['asistencia_w'] = $auth->checkRight('ASISTENCIA_W');
$uperms['cursos_r'] = $auth->checkRight('CURSOS_R');
$uperms['cursos_w'] = $auth->checkRight('CURSOS_W');
$uperms['catedras_r'] = $auth->checkRight('CATEDRAS_R');
$uperms['catedras_w'] = $auth->checkRight('CATEDRAS_W');
$uperms['evaluacion_r'] = $auth->checkRight('EVALUACION_R');
$uperms['evaluacion_w'] = $auth->checkRight('EVALUACION_W');
$uperms['reportes'] = $auth->checkRight('REPORTES');
$uperms['superusuario'] = $auth->checkRight('superusuario');

?>