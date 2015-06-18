<?php

class FRaccoglitore_note extends Fdb {
	
	public function __construct()
	{
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="raccoglietore_note";
		$this->keydb="(id_nota,email_utente,id_cartella,posizione)";
		$this->bind="(:id_nota,:email_utente,:id_cartella,:posizione)";
	}
	
	public function aggiungiAlRaccoglitoreNote($dati) {
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}
	
	public function getNoteByCartella($_id_cartella,$_posizione_finale = NULL,$_posizione_iniziale = NULL,$_tipo_ordinamento = NULL) {
		if (!isset($_posizione_iniziale)) {
			$keydb = array("id_cartella");
			$bind = ":".$keydb[0];
			$_paragone = '=';
			$_parametri = $id_cartella;
		} else {
			$keydb = array("id_cartella","posizione","posizione","posizione");
			$bind = array(":".$keydb[0],":posizione_iniziale",":posizione_finale");
			$paragone = array('=','>','<=');
			$_parametri = array($_email_utente,$_posizione_iniziale,$_posizione_finale);
			$_operatori = array("AND","AND","ORDER BY");
			if (isset($_tipo_ordinamento)) {
				$keydb[6] = strtoupper($_tipo_ordinamento);
			} else {
				$keydb[6] = "DESC";
			}
		}
		$this->db->setParam($table,$keydb,$bind);
		return $this->db->queryGenerica("*",$_paragone,$_parametri,$_operatori);
	}
	
	public function getMaxPosizioneNotaByCartellaEUtente($_email_utente,$_id_cartella) {
		$column = "max(posizione)";
		$keydb = array("email_utente","id_cartella");
		$bind = array(":email_utente",":id_cartella");
		$_paragone = array("=","=");
		$_parametri = array($_email_utente,$_id_cartella);
		$_operatori = array("AND");
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->queryParametro($column,$_paragone,$_parametri,$_operatori);				
	}
	
}


?>