<?php

class CHome {
	
	public function __construct(){
		$contenuto=$this->mux();
		echo $contenuto;
	}
	
	
	public function mux(){
		
		$VHome=USingleton::getInstance('VHome');
		$CNota=USingleton::getInstance('CNota');
			switch ($VHome->getController()) {
        		case 'nota':
        		return $CNota->mux();
				}

		 }		
}


?>