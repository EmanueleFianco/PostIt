<?php
require_once("../Foundation/Utility/USingleton.php");
class View {
	
	
	public function getController() {
		if (isset($_REQUEST['Controller']))
			return $_REQUEST['Controller'];
		else
			return false;
	}
	
	public function getTask() {
		if (isset($_REQUEST['Lavoro']))
			return $_REQUEST['Lavoro'];
		else
			return false;
	}
}