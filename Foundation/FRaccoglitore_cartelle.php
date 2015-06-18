<?php

class FRaccoglitore_cartelle extends Fdb {
	
	public function __construct()
	{
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="raccoglitore_cartelle";
		$this->keydb="(id_cartella,email_utente,posizione)";
		$this->bind="(:id_cartella,:email_utente,:posizione)";
	}
	
	public function aggiungiAlRaccoglitoreCartelle($dati) {
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}
	
	public function getCartelleByUtente($_email_utente,$_posizione_finale = NULL,$_posizione_iniziale = NULL,$_tipo_ordinamento = NULL) {
		$table = 'raccoglitore_cartelle, utente';
		if (!isset($_posizione_iniziale)) {
			$keydb = array("email_utente",'email','email_utente');
			$bind = array(":".$keydb[2]);
			$_paragone = array('=','=');
			$_parametri = array($_email_utente);
			$_operatori = array('AND');
		} else {
			$keydb = array("email_utente","email","email_utente","posizione","posizione","posizione");
			$bind = array(":".$keydb[2],":posizione_iniziale",":posizione_finale");
			$_paragone = array('=','=','>','<=');
			$_parametri = array($_email_utente,$_posizione_iniziale,$_posizione_finale);
			$_operatori = array("AND","AND","AND","ORDER BY");
			if (isset($_tipo_ordinamento)) {
				$keydb[6] = strtoupper($_tipo_ordinamento);
			} else {
				$keydb[6] = "DESC";
			}
		}
		$this->db->setParam($table,$keydb,$bind);
		return $this->db->queryGenerica("*",$_paragone,$_parametri,$_operatori);
	}
	
	public function getMaxPosizioneCartellaByUtente($_email_utente) {
		$keydb = array("email_utente");
		$bind = array(":email_utente");
		$this->db->setParam($this->table,"email_utente",":email_utente");
		return $this->db->queryGenerica("max(posizione)","=",$_email_utente);
	}
	
	
}


?>