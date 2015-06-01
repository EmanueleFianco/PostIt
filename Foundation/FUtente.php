<?php

Class FUtente extends Fdb {

	public function __construct()
	{   

		$this->db = USingleton::getInstance('Fdb');
	    $this->table="utente";
	    $this->keydb="(username,password,immagine,nome,cognome,email,codice_attivazione,stato_attivazione,tipo_utente)";
	    $this->bind="(:username,:password,:immagine,:nome,:cognome,:email,:codice_attivazione,:stato_attivazione,:tipo_utente)";
	}
	
	public function inserisciUtente(EUtente $_object)
	{   
		$dati=$_object->getAsArray();
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	
	}
	
	public function getUtenteByEmail($_email)
	{
	     
	     $this->db->setParam($this->table,"email",":email");
	     return $this->db->loadAsArray("*",$_email);
	}
	
	public function updateUtente($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	
	public function deleteUtente($dati) {
		$keydb = array_keys($dati);
		$keydb = $keydb[0];
		$bind = ":".$keydb;
		$valori = $dati[$keydb];
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}
}
?>
