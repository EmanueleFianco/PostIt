<?php
/**
 *
 * Classe VCartella che recupera i dati delle cartelle e controlla se sono conformi alle aspettative
 * @package View
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class VCartella extends View {
	/**
	 * Controlla i dati arrivati
	 * @param string $_chiave Chiave da controllare
	 * @param string $_valore Valore associato alla chiave
	 * @throws Exception $e Se i parametri non sono conformi alle aspettative
	 */
	static function controllaInput($_chiave, $_valore) {
		if($_chiave == "email" || $_chiave == "amministratore" || $_chiave == "email_utente") {
			if (!filter_var($_valore,FILTER_VALIDATE_EMAIL)) {
				throw new Exception(ucwords($_chiave)." errato!");
			}
		} else {
			$tipo = '/^(privata|gruppo)$/';
			$id_cartella = '/^[[:digit:]]{1,11}$/';
			$id = $id_cartella;
			$nome_cartella = '/^[[:alpha:]]{3,30}$/';
			$colore = '/^#([A-F]|[0-9]){6}$/';
			if (!preg_match($$_chiave, $_valore)) {
				throw new Exception(ucwords($_chiave)." errato!");
			}
		}
	}
}


?>