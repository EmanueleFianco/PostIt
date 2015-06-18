<?php
require_once("../Foundation/Utility/USingleton.php");

class CUtente {
	
	public function __construct() {
		
	}
	
	public function mux(){
		$VUtente=USingleton::getInstance('VUtente');
		switch ($VUtente->getTask()) {
			case 'getCartelle':
				return $this->getCartelle();
		}
	}
	
	public function getCartelle(){
		$VCartella=USingleton::getInstance('VCartella');
		$dati = $VCartella->getDati();
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_Cartelle');
		$cartelle=$fcartella->getCartelleByUtente('emanuele.fianco@gmail.com');
		$VCartella->invia($cartelle);
	}
}