<?php
class FCondividono extends Fdb {
	
	public function __construct() {
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table = "condividono";
		$this->keydb = "(id_nota,email_partecipante)";
		$this->bind = "(:id_nota,:email_partecipante)";
	}
	
	public function AggiungiAllaCondivisione($dati) {
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}
}