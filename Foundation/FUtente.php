<?php
/**
 *
 * Classe FUtente che gestisce i rapporti con il database che hanno per oggetto gli utenti
 * @package Foundation
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
Class FUtente extends Fdb {
	/**
	 * Costruttore di FUtente
	 */
	public function __construct()
	{   

		$this->db = USingleton::getInstance('Fdb');
	    $this->table="utente";
	    $this->keydb="(username,password,id_immagine,nome,cognome,email,codice_attivazione,stato_attivazione,tipo_utente)";
	    $this->bind="(:username,:password,:id_immagine,:nome,:cognome,:email,:codice_attivazione,:stato_attivazione,:tipo_utente)";
	}
	/**
	 * Inserisce un'utente nel database
	 * @param EUtente $_object Utente da inserire
	 * @param string|NULL $_id_immagine Nome dell'immagine di profilo dell'utente
	 * @return bool TRUE se l'inserimento va a buon fine
	 */
	public function inserisciUtente(EUtente $_object,$_id_immagine = NULL)
	{   
		$dati=$_object->getAsArray();
		$dati['id_immagine'] = $_id_immagine;
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		return $this->db->inserisci($dati);
	
	}
	/**
	 * Restituisce l'utente con l'email passata per parametro
	 * @param string $_email Email dell'utente da restituire
	 * @return array Array contenente l'utente
	 */
	public function getUtenteByEmail($_email)
	{ 
	     $this->db->setParam($this->table,"email",":email");
	     return $this->db->queryGenerica("*","=",$_email);
	}
	/**
	 * Aggiorna lo stato di un utente
	 * @param array $dati Array così fatto "attributo da modificare" => "valore"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
	public function updateUtente($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	/**
	 * Cancella un'utente nel database
	 * @param array $dati Array così fatto "email dell'utente" => "valore dell'email"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
	public function deleteUtente($dati) {
		$keydb = array_keys($dati);
		$keydb = $keydb[0];
		$bind = ":".$keydb;
		$valori = $dati[$keydb];
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}
}
?>
