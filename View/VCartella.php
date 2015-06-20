<?php

class VCartella extends View {
	
	
	static function controllaInput($_chiave, $_valore) {
		if($_chiave == "email" && !filter_var($_valore,FILTER_VALIDATE_EMAIL)) {
			throw new Exception(ucwords($_chiave)." errato!");
		} else {
			$id_cartella = '/^[[:digit:]]{1,11}$/';
			if (!preg_match($$_chiave, $_valore)) {
				throw new Exception(ucwords($_chiave)." errato!");
			}
		}
	}
}


?>