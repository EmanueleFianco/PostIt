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
			case 'inviaInfo':
				return $this->inviaInfo();
		}
	}
	/**
	 * Restituisce tutte le cartelle (private e condivise) di un utente
	 */
	public function getCartelle(){
		$VCartella=USingleton::getInstance('VCartella');
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_cartelle');
		$futente=USingleton::getInstance('FUtente');
		$session=USingleton::getInstance('USession');
		$fdb=USingleton::getInstance('Fdb');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$cartelle=$fraccoglitore->getCartelleByUtente($session->getValore("email"));
			foreach ($cartelle as $key => $valore) {
				$tipo_cart = $valore['tipo'];
				if ($tipo_cart == "gruppo") {
					$cartelle[$key]['partecipanti'] = $this->inviaPartecipanti($valore['id_cartella']);
				}
			}
			$VCartella->invia($cartelle);
			$query->commit();
		} catch (Exception $e) {
			$query->rollback();
			throw new Exception($e->getMessage());
		}
	}
	/**
	*Funzione che restituisce l'immagine associata all'utente
	**/
	public function getImmagine(){
		$FImmagine=USingleton::getInstance('FImmagine');
		if ($_REQUEST['file'] == NULL) {
			$file = "./tmp/utenteDefault.png";
			echo file_get_contents($file);
		} else {
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
	/**
	*Funzione che permette la visualizzazione delle informazioni relative all'utente
	**/
	public function inviaInfo() {
		$session = USingleton::getInstance('USession');
		$View = USingleton::getInstance('View');
		$info = array("username" => $session->getValore('username'),
					  "nome" => $session->getValore("nome"),
					  "cognome" => $session->getValore("cognome"),
					  "email" => $session->getValore("email"),
					  "tipo_utente" => $session->getValore("tipo_utente"),
					  "path" => $session->getValore("path"));
		$View->invia($info);
	}
	/**
	*Funzione che restituisce un array contenente i partecipanti alla cartella con Id passato per parametro
	*@param int $_id_cartella Id della cartella
	*@return array Array contenente i partecipanti alla cartella
	**/
	public function inviaPartecipanti($_id_cartella) {
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_cartelle');
		$session = USingleton::getInstance('USession');
		$futente=USingleton::getInstance('FUtente');
		$raccoglitore = $fraccoglitore->getTupleByIdCartella($_id_cartella);
		$condiviso = array();
		foreach ($raccoglitore as $key => $valore) {
			if ($valore['email_utente'] != $session->getValore("email")) {
				$utente = $futente->getUtenteByEmail($valore['email_utente']);
				$utente = $utente[0];
				$condiviso[$key]["email"] = $valore['email_utente'];
				$condiviso[$key]["path"] = "Home.php?controller=utente&lavoro=getImmagine&file=".$utente['id_immagine'];
			}
		}
		return $condiviso;
	}
}
?>