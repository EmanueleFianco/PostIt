<?php

Class FPartecipante extends Fdb {
	
	private $table1 = "partecipano";
	private $keydb1 = "(id_cartella,email_partecipante)";
	private $bind1 = "(:id_cartella,:email_partecipante)";
	private $table2 = "condividono";
	private $keydb2 = "(id_nota,email_partecipante)";
	private $bind2 = "(:id_nota,:email_partecipante)";
	

	public function __construct()
	{   
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
	    $this->table="partecipante";
	    $this->keydb="(email,username,immagine,tipologia)";
	    $this->bind="(:email,:username,:immagine,:tipologia)";
	}
	
	public function inserisciPartecipante($dati)
	{   
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	
	}
	
	public function getPartecipanteByEmail($_email)
	{
	     
	     $this->db->setParam($this->table,"email",":email");
	     return $this->db->loadAsArray("*",$_email);
	
	}
	
	public function AggiungiAlGruppo($dati) {
		$this->db->setParam($this->table1,$this->keydb1,$this->bind1);
		$this->db->inserisci($dati);
	}
	
	public function AggiungiAllaCondivisione($dati) {
		$this->db->setParam($this->table2,$this->keydb2,$this->bind2);
		$this->db->inserisci($dati);
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
}
?>
