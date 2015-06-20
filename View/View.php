<?php
class View {
	
	public function invia($dati) {
		echo json_encode($dati);
	}
	
	public function getController() {
		if (isset($_REQUEST['controller']))
			return $_REQUEST['controller'];
		else
			return false;
	}
	
	public function getTask() {
		if (isset($_REQUEST['lavoro']))
			return $_REQUEST['lavoro'];
		else
			return false;
	}
	
	public function getDati(){
		unset($_REQUEST["lavoro"]);
		unset($_REQUEST["controller"]);
		foreach ($_REQUEST as $key => $valore) {
			$this::controllaInput($key, $valore);
			$dati[$key] = $valore;
		}
		return $dati;
	}
}
?>