<?php

Class FUtente {

	private $db;
	private $table;
	private $keydb;
	private $bind;

public function __construct()
{   
    $this->table="utente";
    $this->keydb="(username,password,immagine,nome,cognome,email,codice_attivazione,stato_attivazione,tipo_utente)";
    $this->bind="(:username,:password,:immagine,:nome,:cognome,:email,:codice_attivazione,:stato_attivazione,:tipo_utente)";
    $this->db=USingleton::getInstance('Fdb');
    
   

    
}

public function storeUtente($dati)
{   
	$this->db->setParam($this->table,$this->keydb,$this->bind);
	$this->db->store($dati);

}

public function searchUtente($_value)
{
     
     $this->db->setParam($this->table,"email",":email");
     return $this->db->loadAsArray("*",$_value);

}



}
?>
