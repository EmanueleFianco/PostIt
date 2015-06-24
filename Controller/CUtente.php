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
			case 'getImmagine':
				return $this->getImmagine();
		}
	}
	/**
	 * Restituisce tutte le cartelle (private e condivise) di un utente
	 */
	public function getCartelle(){
		$VCartella=USingleton::getInstance('VCartella');
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_cartelle');
		$session=USingleton::getInstance('USession');
		$cartelle=$fraccoglitore->getCartelleByUtente($session->getValore("email"));
		$VCartella->invia($cartelle);
	}
	/**
	*Restituisce l'immagine associata all'utente
	*/
	public function getImmagine(){
		$FImmagine=USingleton::getInstance('FImmagine');
		$image = $FImmagine->getImmagineByNome($_REQUEST['file']);
		$handle = fopen("./tmp/".$_REQUEST['file'],"w+");
		fwrite($handle,$image[0]['immagine_originale']);
		$file = "./tmp/".$_REQUEST['file'];
		header('Content-Type: image/'.basename($image[0]['type']));
		header('Content-Length: ' . $image[0]['size']);
		echo file_get_contents($file);
		unlink($file);
	}
}
?>