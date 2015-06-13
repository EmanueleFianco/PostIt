<?php
require_once("../Foundation/Utility/USingleton.php");
require_once("View.php");

class VCartella extends View {
	
	
	static function controllaInput($_chiave, $_valore) {
		if($_chiave == "email" && !filter_var($_valore,FILTER_VALIDATE_EMAIL)) {
			throw new Exception(ucwords($_chiave)." errato!");
		}
		
	}
	
	
	public function getDati(){
		unset($_REQUEST["lavoro"]);
		unset($_REQUEST["controller"]);
		foreach ($_REQUEST as $key => $valore) {
			self::controllaInput($key, $valore);
			$dati[$key] = $valore;
		}
		return $dati;
	}
	
	
}


?>