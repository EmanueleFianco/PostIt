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
	
	public function getMaxPosizioneCartellaByUtente($_email_utente) {
		$this->db->setParam($this->table,"email_utente",":email_utente");
		return $this->db->queryGenerica("max(posizione)","=",$_email_utente);
	}
	
	public function getTupleByIdCartella($_id_cartella) {
		$this->db->setParam($this->table,"id_cartella",":id_cartella");
		return $this->queryGenerica("email_utente,posizione", "=",$_id_cartella);				
	}
	
	public function deleteRaccoglitore($dati) {
		$keydb = array_keys($dati);
		$keydb = $keydb[0];
		$bind = ":".$keydb;
		$valori = $dati[$keydb];
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}
	
}


?>