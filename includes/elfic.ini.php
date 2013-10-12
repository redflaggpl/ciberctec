<?php
/**
 * @Package: ELFIC FRAMEWORK
 * @Author: edison <edison [DOT] galindo [AT] gmail [DOT] com> www.elficsoft.com
 * @Date: Enero 15, 2011
 * @name elfic.ini.php
 * @version: 1.0
 */

date_default_timezone_set('America/Bogota');

define('SMARTY_DIR', APP_PATH.DS.'lib'.DS.'smarty'.DS);
// define smarty templates dir
define('SMARTY_TPLS_DIR', APP_PATH.DS.'smarty_tpls'.DS.'elfic'.DS);
//ruta imagenes local
define("IMG_PATH", APP_PATH.DS."images".DS);
//ruta imagenes local
define("FILES_PATH", APP_PATH.DS."files".DS);

//Titulo de la aplicación
define("APP_TITULO", "eAcademyControl - CIBERCTEC");

require_once(APP_PATH.DS."includes".DS."config.php");
require_once(SMARTY_DIR.'Smarty.class.php');
require_once(APP_PATH.DS.'lib'.DS.'DB.php');
require_once(APP_PATH.DS.'lib'.DS.'Utils.php');
require_once(APP_PATH.DS.'lib'.DS.'Elfic.php');
require_once(APP_PATH.DS.'lib'.DS.'CatManUtils.php');
require_once(APP_PATH.DS.'lib'.DS.'home'.DS.'Home.php');
require_once(APP_PATH.DS. 'lib'.DS.'auth'.DS.'AuthUser.php');
require_once(APP_PATH.DS.'lib'.DS.'Elfic_Smarty.php');
require_once(APP_PATH.DS.'includes'.DS.'lang.es.php');
require_once(APP_PATH.DS.'includes'.DS.'tables.inc.php');
require_once(APP_PATH.DS.'lib'.DS.'phpMailer'.DS.'class.phpmailer.php');
require_once(APP_PATH.DS.'lib'.DS.'Pagination.php');
require_once(APP_PATH.DS.'lib'.DS.'usuarios'.DS.'Usuarios.php');
require_once(APP_PATH.DS.'lib'.DS.'usuarios'.DS.'Estudiantes.php');
require_once(APP_PATH.DS.'lib'.DS.'usuarios'.DS.'Coordinadores.php');
require_once(APP_PATH.DS.'lib'.DS.'cursos'.DS.'Cursos.php');
require_once(APP_PATH.DS.'lib'.DS.'catedras'.DS.'Catedras.php');
require_once(APP_PATH.DS.'lib'.DS.'evaluacion'.DS.'Evaluacion.php');
require_once(APP_PATH.DS.'lib'.DS.'HTMLCleaner.php');
require_once(APP_PATH.DS. 'lib'.DS.'agenda'.DS.'Agenda.php');
require_once(APP_PATH.DS. 'lib'.DS.'Upload'.DS.'class.upload.php');
require_once(APP_PATH.DS. 'lib'.DS.'usuarios'.DS.'Permisos.php');
require_once(APP_PATH.DS. 'lib'.DS.'Files'.DS.'Download.php');
require_once(APP_PATH.DS. 'lib'.DS.'evaluacion'.DS.'Evaluacion.php');
require_once(APP_PATH.DS. 'lib'.DS.'evaluacion'.DS.'Preguntas.php');
require_once(APP_PATH.DS. 'lib'.DS.'jpgraph'.DS.'src'.DS.'jpgraph.php');
require_once(APP_PATH.DS. 'lib'.DS.'jpgraph'.DS.'src'.DS.'jpgraph_pie.php');

/* Componente Reportes */
require_once(APP_PATH.DS. 'lib'.DS.'reportes'.DS.'Reportes.php');
require_once(APP_PATH.DS. 'lib'.DS.'reportes'.DS.'Reportes_Asistencia.php');
require_once(APP_PATH.DS. 'lib'.DS.'reportes'.DS.'Reportes_Evaluacion.php');
require_once(APP_PATH.DS. 'lib'.DS.'Excel.php');