<?php

class FCartella extends Fdb {

	public function __construct()
	{
		$this->auto_increment = TRUE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="cartella";
		$this->keydb="(amministratore,tipo,nome,colore)";
		$this->bind="(:amministratore,:tipo,:nome,:colore)";
	}

	public function inserisciCartella(ECartella $_object,$_tipo,$_amministratore)
	{
		$dati=$_object->getAsArray();
		unset($dati['posizione']);
		$dati['tipo']=$_tipo;
		$dati['amministratore']=$_amministratore;
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}

	public function getCartellaById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
	    return $this->db->queryGenerica("*","=",$_id);
	}
	
	public function updateCartella($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	
	public function deleteCartella($dati) {
		$keydb = array_keys($dati);
		$keydb = $keydb[0];
		$bind = ":".$keydb;
		$valori = $dati[$keydb];
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}
}

?>