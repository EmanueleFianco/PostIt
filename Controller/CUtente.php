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
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_Cartelle');
		$cartelle=$fraccoglitore->getCartelleByUtente('emanuele.fianco@gmail.com');
		$VCartella->invia($cartelle);
	}
}