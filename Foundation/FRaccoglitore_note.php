<?php

class FRaccoglitore_note extends Fdb {
	
	public function __construct()
	{
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="raccoglitore_note";
		$this->keydb="(id_nota,email_utente,id_cartella,posizione)";
		$this->bind="(:id_nota,:email_utente,:id_cartella,:posizione)";
	}
	
	public function aggiungiAlRaccoglitoreNote($dati) {
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}
	
	public function getNoteByCartella($_id_cartella,$_posizione_finale = NULL,$_posizione_iniziale = NULL,$_tipo_ordinamento = NULL) {
		$table = "nota as n, raccoglitore_note as r";
		$column = "id_nota,posizione,titolo,testo,ora_data_avviso,colore,creata_da,ultimo_a_modificare";
		if (!isset($_posizione_iniziale)) {
			$keydb = array("id","id_nota","id_cartella");
			$bind = ":".$keydb[2];
			$_paragone = array('=','=');
			$_parametri = array($id_cartella);
		} else {
			$keydb = array("id","id_nota","id_cartella","posizione","posizione","posizione");
			$bind = array(":".$keydb[2],":posizione_iniziale",":posizione_finale");
			$_paragone = array('=','=','>','<=');
			$_parametri = array($_id_cartella,$_posizione_iniziale,$_posizione_finale);
			$_operatori = array("AND","AND","AND","ORDER BY");
			if (isset($_tipo_ordinamento)) {
				$keydb[6] = strtoupper($_tipo_ordinamento);
			} else {
				$keydb[6] = "DESC";
			}
		}
		$this->db->setParam($table,$keydb,$bind);
		return $this->db->queryGenerica($column,$_paragone,$_parametri,$_operatori);
	}
	
	public function getMaxPosizioneNotaByCartellaEUtente($_email_utente,$_id_cartella) {
		$column = "max(posizione),id_nota";
		$keydb = array("email_utente","id_cartella");
		$bind = array(":email_utente",":id_cartella");
		$_paragone = array("=","=");
		$_parametri = array($_email_utente,$_id_cartella);
		$_operatori = array("AND");
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->queryGenerica($column,$_paragone,$_parametri,$_operatori);				
	}
	
	public function updateRaccoglitore($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	
}


?>