<?php
/**
 *
 * Classe CHome
 * @package Controller
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class CHome {
	/**
	 * Imposta la pagina e verifica anche l'autenticazione.
	 */
	public function __construct(){
		try {
			$contenuto=$this->mux();
			echo $contenuto;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/**
	 * Smista le richieste delegando i corrispondenti controller.
	 */
	public function mux(){
		$VHome=USingleton::getInstance('VHome');
		switch ($VHome->getController()) {
        	case 'nota':
        		$CNota=USingleton::getInstance('CNota');
        		return $CNota->mux();
        	case 'cartella':
        		$CCartella=USingleton::getInstance('CCartella');
        		return $CCartella->mux();
        	case 'utente':
        		$CUtente=USingleton::getInstance('CUtente');
        		return $CUtente->mux();
        	case 'registrazione':
        		$CRegistrazione=USingleton::getInstance('CRegistrazione');
        		return $CRegistrazione->mux();
		}
	}		
}


?>