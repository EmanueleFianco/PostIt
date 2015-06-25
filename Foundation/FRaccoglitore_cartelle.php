<?php
/**
 *
 * Classe FRaccoglitore_cartelle che gestisce i rapporti con il database che hanno per oggetto le cartelle e le posizioni relative agli utenti
 * @package Foundation
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class FRaccoglitore_cartelle extends Fdb {
	/**
	 * Costruttore di FRaccoglitore_cartelle
	 */
	public function __construct()
	{
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="raccoglitore_cartelle";
		$this->keydb="(id_cartella,email_utente,posizione)";
		$this->bind="(:id_cartella,:email_utente,:posizione)";
	}
	/**
	 * Inserisce una tupla al raccoglitore in modo da mantenere le associazioni necessarie
	 * @param array $dati Array Contenente i parametri con cui fare il bind all'interno dell'insert
	 * @return bool TRUE se l'inserimento va a buon fine
	 */
	public function aggiungiAlRaccoglitoreCartelle($dati) {
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		return $this->db->inserisci($dati);
	}
	/**
	 * Restituisce le tuple con l'email dell'utente passata per parametro
	 * @param string $_email_utente Email dell'utente delle tuple da restituire
	 * @param string|NULL $_posizione_finale Posizione tetto delle tuple da estrarre
	 * @param string|NULL $_posizione_iniziale Posizione minima delle tuple da estrarre
	 * @param string|NULL $_tipo_ordinamento Tipo di ordinamento richiesto (DESC/ASC) DEFAULT : DESC
	 * @return array Array contenente le tuple
	 */
	public function getCartelleByUtente($_email_utente,$_posizione_finale = NULL,$_posizione_iniziale = NULL,$_tipo_ordinamento = NULL) {
		$column = "r.id_cartella,r.email_utente,c.tipo,c.nome,r.posizione,c.colore";
		$table = 'raccoglitore_cartelle as r, utente, cartella as c';
		if (!isset($_posizione_iniziale)) {
			$keydb = array("email_utente",'email','email_utente','id','id_cartella');
			$bind = array(":".$keydb[2],-1);
			$_paragone = array('=','=','=');
			$_parametri = array($_email_utente);
			$_operatori = array('AND','AND');
		} else {
			$keydb = array("email_utente","email","email_utente","posizione","posizione","id","id_cartella","posizione");
			$bind = array(":".$keydb[2],":posizione_iniziale",":posizione_finale",-1);
			$_paragone = array('=','=','=','>','<=');
			$_parametri = array($_email_utente,$_posizione_iniziale,$_posizione_finale);
			$_operatori = array("AND","AND","AND","AND","ORDER BY");
			if (isset($_tipo_ordinamento)) {
				$keydb[6] = strtoupper($_tipo_ordinamento);
			} else {
				$keydb[6] = "DESC";
			}
		}
		$this->db->setParam($table,$keydb,$bind);
		return $this->db->queryGenerica($column,$_paragone,$_parametri,$_operatori);
	}
	/**
	 * Restituisce la posizione massima delle cartelle di una determinato utente
	 * @param string $_email_utente Email dell'utente condizione della query
	 * @return array Array contenente la max(posizione) delle cartelle dell'utente
	 */
	public function getMaxPosizioneCartellaByUtente($_email_utente) {
		$this->db->setParam($this->table,"email_utente",":email_utente");
		return $this->db->queryGenerica("max(posizione)","=",$_email_utente);
	}
	/**
	 * Restituisce tutte le tuple con un determinato id cartella
	 * @param int $_id_cartella Id della cartella condizione della query
	 * @return array Array contenente le tuple risultanti
	 */
	public function getTupleByIdCartella($_id_cartella) {
		$this->db->setParam($this->table,"id_cartella",":id_cartella");
		return $this->db->queryGenerica("email_utente,posizione,id_cartella", "=",$_id_cartella);				
	}
	/**
	 * Aggiorna lo stato del raccoglitore
	 * @param array $dati Array così fatto "attributo da modificare" => "valore attributo"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
	public function updateRaccoglitore($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	/**
	 * Cancella una tupla dal raccoglitore nel database
	 * @param array $dati Array così fatto "id della cartella" => "valore dell'id"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
	public function deleteRaccoglitore($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}
	
}


?>