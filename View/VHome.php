<?php
require_once("../Foundation/Utility/USingleton.php");

class VHome {
	
	public function getController() {
		if (isset($_POST['Nota']))
			return $_POST['Nota'];
		else
			return false;
	}
	
	public function getTask() {
		if (isset($_POST['Lavoro']))
			return $_POST['Lavoro'];
		else
			return false;
	}
	
}


?>