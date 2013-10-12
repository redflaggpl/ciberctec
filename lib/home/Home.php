<?php

/** 
 * @author redflag
 * 
 * 
 */
class Home extends Elfic {
	
	function Home() {
		$this->getHome();
	}
	
	public function getHome()
	{
		$this->_creaModulo('Asistencia Tutores', $this->_getCursos(), 
		                   'Cursos', 'asistencia', 'asistenciaTutores');
		/*$this->_creaModulo('Asistencia', $this->_getRegistrosInOut(), 
		                   'Asistencia', 'asistencia' );*/
	}
	
	private function _creaModulo($nombre, $data, $mensaje='', $link='', $tpl = '')
	{
		$smarty = new Elfic_Smarty();
		$smarty->assign('nombre', $nombre);
		$smarty->assign('data', $data);
		$smarty->assign('mensaje', $mensaje);
		$smarty->assign('link', $link);
		$smarty->display('home/modulo'.$tpl.'.tpl');
	}
	
	/**
	 * Objeto de cursos asociados a un tutor
	 * 
	 */
	private function _getCursos()
	{
		global $uid;
		
		$periodo = CatManUtils::getPeriodoActual();
		
		$db = new DB();
		$sql = "SELECT ct.id, c.nombre FROM " .TBL_CURSOS . " ct "
		     . "INNER JOIN " . TBL_CATEDRAS . " c ON c.id = ct.catedra_id "
		     . "WHERE periodo_id = $periodo";
		$res = $db->query($sql);
		$data = array();
		while($line = $db->fetchNextObject($res))
		{
			$data[$line->id] = $line->nombre;
		}
		return $data;
	}
	
	public function encuestasRecientes()
	{
		
	}
	
	public function getEncuestas()
	{
		
	}
	
    public function eventosHoy()
	{
		global $uid;
		
		$hoy = Utils::nowDate();
		$where = "DATE(fechaini) <= '$hoy' AND DATE(fechafin) >= '$hoy' AND funcionario_id = $uid";
		$db = new DB();
		return $db->countOf('eventos', $where);
	}
}
