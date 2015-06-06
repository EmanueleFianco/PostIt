<?php
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/Utility/USingleton.php");

class Cnota {
	

	public function __construct(){
		
	}
	
	public function mux(){
		$VNota=USingleton::getInstance('VNota');
	
		
		switch ($VNota->getTask()) {
			case 'aggiorna':
				return $this->Aggiorna();
		
			}
	}
	
	public function Aggiorna(){
		$VNota=USingleton::getInstance('VNota');
		
		$dati = $VNota->getDati();
		
		$db=USingleton::getInstance('Fdb');
		$fnota=USingleton::getInstance('FNota');
		
		$fnota->updateNota($dati);
	}
	

}

?>