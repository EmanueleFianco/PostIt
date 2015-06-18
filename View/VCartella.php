<?php
require_once("../Foundation/Utility/USingleton.php");
require_once("View.php");

class VCartella extends View {
	
	
	static function controllaInput($_chiave, $_valore) {
		if($_chiave == "email" && !filter_var($_valore,FILTER_VALIDATE_EMAIL)) {
			throw new Exception(ucwords($_chiave)." errato!");
		}
		
	}
	
	
}


?>