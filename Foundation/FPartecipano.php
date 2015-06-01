<?php

class FPartecipano extends Fdb {
	
	public function __construct() {
		
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table = "partecipano";
		$this->keydb = "(id_cartella,email_partecipante)";
		$this->bind = "(:id_cartella,:email_partecipante)";
	}
	
	public function AggiungiAlGruppo($dati) {
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}
	
}
