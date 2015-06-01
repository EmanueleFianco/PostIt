<?php

Class FPartecipante extends Fdb {	

	public function __construct()
	{   
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
	    $this->table="partecipante";
	    $this->keydb="(email,username,immagine,tipologia)";
	    $this->bind="(:email,:username,:immagine,:tipologia)";
	}
	
	public function inserisciPartecipante(EPartecipante $_object)
	{   
		$dati=$_object->getAsArray();
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	
	}
	
	public function getPartecipanteByEmail($_email)
	{
	     
	     $this->db->setParam($this->table,"email",":email");
	     return $this->db->loadAsArray("*",$_email);
	
	}
	
	public function getPartecipantiByIdCartella($_id_cartella) {
		$tables = "partecipante,partecipano";
		$keydb = array("email","email_partecipante","id_cartella");
		$bind = ":id_cartella";
		$this->db->setParam($tables,$keydb,$bind);
		return $this->db->queryJoin("partecipante.*",$_id_cartella);
	
	}
	
	public function getPartecipantiByIdNota($_id_nota) {
		$tables = "partecipante,condividono";
		$keydb = array("email","email_partecipante","id_nota");
		$bind = ":id_nota";
		$this->db->setParam($tables,$keydb,$bind);
		$valori = $_id_nota;
		return $this->db->queryJoin("partecipante.*",$_id_nota);
	}
	
	public function updatePartecipante($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	
	public function deletePartecipante($dati) {
		$keydb = array_keys($dati);
		$keydb = $keydb[0];
		$bind = ":".$keydb;
		$valori = $dati[$keydb];
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}
}
?>
