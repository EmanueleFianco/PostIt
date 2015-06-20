<?php
/**
 *
 * Classe CUtente che gestisce l'utente
 * @package Controller
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class CUtente {
	/**
	 * Smista le varie richieste delegando i metodi corrispondenti.
	 */
	public function mux(){
		$VUtente=USingleton::getInstance('VUtente');
		switch ($VUtente->getTask()) {
			case 'getCartelle':
				return $this->getCartelle();
		}
	}
	/**
	 * Restituisce tutte le cartelle (private e condivise) di un utente
	 */
	public function getCartelle(){
		$VCartella=USingleton::getInstance('VCartella');
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_cartelle');
		$cartelle=$fraccoglitore->getCartelleByUtente('emanuele.fianco@gmail.com');
		$VCartella->invia($cartelle);
	}
}
?>