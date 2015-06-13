<?php
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/FImmagine.php");
require_once("../Entity/EImmagine.php");
require_once("../Foundation/Utility/USingleton.php");

class Ccartella{
	
	public function __construct(){
	
	}
	
	public function mux(){
		$VNota=USingleton::getInstance('VCartella');
		switch ($VNota->getTask()) {
			case 'nuova':
				return $this->Nuova();
			case 'cancella':
				return $this->Cancella();
			case 'getCartelle':
				return $this->getCartelle();
		}
	}
	
	
	
	public function Nuova(){
		
		
	}
	public function Cancella(){
		
		
	}
	public function getCartelle(){
		$VCartella=USingleton::getInstance('VCartella');
		$dati = $VCartella->getDati();
		$fcartella=USingleton::getInstance('FCartella');
		$fdb=USingleton::getInstance('Fdb');
		$query=$fdb->getDb();
		$cartelle=$fcartella->getCartelleByUtente($dati['email']);
		$VCartella->invia($cartelle);
	}
}





?>