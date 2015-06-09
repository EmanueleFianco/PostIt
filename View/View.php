<?php
require_once("../Foundation/Utility/USingleton.php");
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
}