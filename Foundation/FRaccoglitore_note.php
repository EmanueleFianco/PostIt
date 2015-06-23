<?php
/**
 *
 * Classe FRaccoglitore_note che gestisce i rapporti con il database che hanno per oggetto le note e le posizioni relative agli utenti
 * @package Foundation
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class FRaccoglitore_note extends Fdb {
	/**
	 * Costruttore di FRaccoglitore_note
	 */
	public function __construct()
	{
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="raccoglitore_note";
		$this->keydb="(id_nota,email_utente,id_cartella,posizione)";
		$this->bind="(:id_nota,:email_utente,:id_cartella,:posizione)";
	}
	/**
	 * Inserisce una tupla al raccoglitore in modo da mantenere le associazioni necessarie
	 * @param array $dati Array Contenente i parametri con cui fare il bind all'interno dell'insert
	 * @return bool TRUE se l'inserimento va a buon fine
	 */
	public function aggiungiAlRaccoglitoreNote($dati) {
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		return $this->db->inserisci($dati);
	}
	/**
	 * Restituisce le tuple con id_cartella passata per parametro
	 * @param string $_id_cartella Id della cartella delle tuple da restituire
	 * @param string $_email_utente Email dell'utente condizione della query
	 * @param string|NULL $_posizione_finale Posizione tetto delle tuple da estrarre
	 * @param string|NULL $_posizione_iniziale Posizione minima delle tuple da estrarre
	 * @param string|NULL $_tipo_ordinamento Tipo di ordinamento richiesto (DESC/ASC) DEFAULT : DESC
	 * @return array Array contenente le tuple
	 */
	public function getNoteByCartella($_id_cartella,$_email_utente,$_posizione_finale = NULL,$_posizione_iniziale = NULL,$_tipo_ordinamento = NULL) {
		$table = "nota as n, raccoglitore_note as r";
		$column = "id_nota,posizione,titolo,testo,ora_data_avviso,colore,creata_da,ultimo_a_modificare";
		if (!isset($_posizione_iniziale)) {
			$keydb = array("id","id_nota","id_cartella","email_utente");
			$bind = array(":".$keydb[2],":".$keydb[3]);
			$_paragone = array('=','=','=');
			$_parametri = array($id_cartella,$_email_utente);
			$_operatori = array("AND","AND","AND");
		} else {
			$keydb = array("id","id_nota","id_cartella","email_utente","posizione","posizione","posizione");
			$bind = array(":".$keydb[2],":".$keydb[3],":posizione_iniziale",":posizione_finale");
			$_paragone = array('=','=','=','>','<=');
			$_parametri = array($_id_cartella,$_email_utente,$_posizione_iniziale,$_posizione_finale);
			$_operatori = array("AND","AND","AND","AND","ORDER BY");
			if (isset($_tipo_ordinamento)) {
				$keydb[7] = strtoupper($_tipo_ordinamento);
			} else {
				$keydb[7] = "DESC";
			}
		}
		$this->db->setParam($table,$keydb,$bind);
		return $this->db->queryGenerica($column,$_paragone,$_parametri,$_operatori);
	}
	/**
	 * Restituisce la posizione massima delle note di una determinato utente e se settato $_max anche l'id_nota relativa
	 * @param string $_email_utente Email dell'utente condizione della query
	 * @param int $_id_cartella Id della cartella condizione della query
	 * @param int $_max Valore massimo nella cartella
	 * @return array Array contenente la max(posizione) delle note in una cartella dell'utente e anche dell'id_nota se $_max è settato
	 */
	public function getMaxPosizioneNotaByCartellaEUtente($_email_utente,$_id_cartella,$_max = NULL) {
		if (isset($_max)) {
			$column = "posizione, id_nota";
			$keydb = array("email_utente","id_cartella","posizione");
			$bind = array(":email_utente",":id_cartella",":posizione");
			$_paragone = array("=","=","=");
			$_parametri = array($_email_utente,$_id_cartella,$_max);
			$_operatori = array("AND","AND");
		} else {
			$column = "max(posizione)";
			$keydb = array("email_utente","id_cartella");
			$bind = array(":email_utente",":id_cartella");
			$_paragone = array("=","=");
			$_parametri = array($_email_utente,$_id_cartella);
			$_operatori = array("AND",);
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->queryGenerica($column,$_paragone,$_parametri,$_operatori);				
	}
	/**
	 * Restituisce la posizione massima delle note di una determinato utente e anche l'id_nota relativa
	 * @param string $_email_utente Email dell'utente condizione della query
	 * @param int $_id_cartella Id della cartella condizione della query
	 * @return array Array contenente la max(posizione) e anche dell'id_nota corrispondente
	 */
	public function getMaxPosizione($_email_utente,$_id_cartella) {
		$column = "max(posizione)";
		$keydb = array("email_utente","id_cartella");
		$bind = array(":email_utente",":id_cartella");
		$_paragone = array("=","=");
		$_parametri = array($_email_utente,$_id_cartella);
		$_operatori = array("AND");
		$this->db->setParam($this->table,$keydb,$bind);
		$_max = $this->db->queryGenerica($column,$_paragone,$_parametri,$_operatori);
		$_max = $_max[0]['max(posizione)'];
		return $this->getMaxPosizioneNotaByCartellaEUtente($_email_utente, $_id_cartella, $_max);
	}
	
	public function getNotaByIdEUtente($_id_nota,$_email_utente) {
		$column = "*";
		$keydb = array("id_nota","email_utente");
		$bind = array(":id_nota",":email_utente");
		$_paragone = array("=","=");
		$_parametri = array($_id_nota,$_email_utente);
		$_operatori = array("AND");
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->queryGenerica($column,$_paragone,$_parametri,$_operatori);
	}
	
	public function getRaccoglitoreByIdNota($_id_nota) {
		$column = "*";
		$this->db->setParam($this->table,"id_nota",":id_nota");
		return $this->db->queryGenerica("*","=",$_id_nota);
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
	 * @param array $dati Array così fatto "id della nota" => "valore dell'id"
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