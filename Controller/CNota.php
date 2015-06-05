<?php
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/Utility/USingleton.php");

class Cnota{
	

	public function __construct(){
		
	}
	
	public function mux(){
		$VHome=USingleton::getInstance('VHome');
	
		
		switch ($VHome->getTask()) {
			case 'aggiorna':
				return $this->Aggiorna();
		
			}
	}
	
	public function Aggiorna(){
		$VNota=USingleton::getInstance('VNota');
		
		$Dati = $VNota->getDati();
		
		$db=USingleton::getInstance('Fdb');
		$fnota=USingleton::getInstance('FNota');
		
		$fnota->updateNota($Dati);
		
		var_dump($Dati);
		
	}
	

}

?>