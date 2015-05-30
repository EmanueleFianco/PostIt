<?php

Class FUtente extends Fdb {

	public function __construct()
	{   
		$this->db = USingleton::getInstance('Fdb');
	    $this->table="utente";
	    $this->keydb="(username,password,immagine,nome,cognome,email,codice_attivazione,stato_attivazione,tipo_utente)";
	    $this->bind="(:username,:password,:immagine,:nome,:cognome,:email,:codice_attivazione,:stato_attivazione,:tipo_utente)";
	}
	
	public function inserisciUtente($dati)
	{   
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	
	}
	
	public function carcaUtente($_value)
	{
	     
	     $this->db->setParam($this->table,"email",":email");
	     return $this->db->loadAsArray("*",$_value);
	
	}
}
?>
