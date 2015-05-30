<?php

class FCartella extends Fdb {

	public function __construct()
	{
		$this->auto_increment = TRUE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="cartella";
		$this->keydb="(email_utente,tipo,nome,posizione,colore)";
		$this->bind="(:email_utente,:tipo,:nome,:posizione,:colore)";
	}

	public function inserisciCartella($dati)
	{
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}

	public function getCartellaById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
	     return $this->db->loadAsArray("*",$_id);
	}
	
	public function getCartelleByUtente($_email_utente) {
		$this->db->setParam($this->table,"email_utente",":email_utente");
		return $this->db->loadAsArray("*",$_email_utente);
	}

}
