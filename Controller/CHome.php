<?php
class CHome {
	
	public function __construct(){
		$contenuto=$this->mux();
		echo $contenuto;
	}
	
	
	public function mux(){
		
		$VHome=USingleton::getInstance('VHome');
		switch ($VHome->getController()) {
        	case 'nota':
        		$CNota=USingleton::getInstance('CNota');
        		return $CNota->mux();
		}
	}		
}


?>