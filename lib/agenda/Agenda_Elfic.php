<?php

class Agenda_Elfic extends Agenda {
	
	public function monthView()
	{
		
		$tpl = new Elfic_Smarty();
		$_w = isset($_REQUEST['w']) ? $_REQUEST['w'] : null;
		$_m = isset($_REQUEST['m']) ? $_REQUEST['m'] : null;
		$_y = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
		$this->setWeek($_w);
		$this->setMonth($_m);
		$this->setYear($_y);
		$tpl->assign('cal', $this->calendarMonth());
		$tpl->assign('tipo', $this->_getTiposEventos());
		$tpl->display('agenda/agendaMes.tpl');
	}
	
	public function weekView()
	{
		$tpl = new Elfic_Smarty();
		$_w = isset($_REQUEST['w']) ? $_REQUEST['w'] : null;
		$_m = isset($_REQUEST['m']) ? $_REQUEST['m'] : null;
		$_y = isset($_REQUEST['y']) ? $_REQUEST['y'] : null;
		$this->setWeek($_w);
		$this->setMonth($_m);
		$this->setYear($_y);
		$tpl->assign('cal', $this->calendarWeek($_w, $_m, $_y));
		$tpl->display('agenda/agendaSemana.tpl');
	}
	
	public function dayView($d)
	{
		$e = $this->_getEvents($d);
		$tpl = new Elfic_Smarty();
		$_m = isset($_REQUEST['m']) ? $_REQUEST['m'] : date(m);
		$_y = isset($_REQUEST['y']) ? $_REQUEST['y'] : date(Y);
		$tpl->assign('events', $e );
		$tpl->assign('fecha', $_y."-".$_m."-".$d);
		$tpl->display('agenda/agendaDia.tpl');
	}
	
	public function setEvent()
	{
		global $uid;
		$e['titulo'] = $_REQUEST['titulo'];
		$e['descrip'] = $_REQUEST['descrip'];
		$e['fechaini'] = $_REQUEST['fechaini'];
		$e['funcionario_id'] = $uid;
		$e['fechafin'] = $_REQUEST['fechafin'];
		$e['tipo'] = $_REQUEST['tipo'];
		$e['lugar'] = $_REQUEST['lugar'];
		$db = new DB();
		$db->perform('eventos', $e);
		Elfic::cosRedirect('index2.php?=agenda');
	}
	
	/**
	 * Arreglo con tipos de eventos
	 */
	private function _getTiposEventos()
	{
		$db = new DB();
		$sql = "SELECT codigo, descrip FROM tipevent";
		$res = $db->query($sql);
		$data = array();
		while($line = $db->fetchNextObject($res))
		{
			$data[$line->codigo] = $line->descrip;
		}
		return $data;
	}

}

?>