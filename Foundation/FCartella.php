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

	public function inserisciCartella(ECartella $_object,$_tipo,$_email_utente)
	{
		$dati=$_object->getAsArray();
		$dati['tipo']=$_tipo;
		$dati['email_utente']=$_email_utente;
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}

	public function getCartellaById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
	     return $this->db->loadAsArray("*",$_id);
	}
	
	public function getCartelleByUtente($_email_utente,$_posizione_iniziale = NULL,$_posizione_finale = NULL,$_tipo_ordinamento = NULL) {
		if (!isset($_posizione_iniziale)) {
			$keydb = "email_utente";
			$bind = ":".$keydb;
		} else {
			$keydb = array("email_utente","posizione");
			$bind = array(":".$keydb[0],":posizione_iniziale",":posizione_finale");
			if (isset($_tipo_ordinamento)) {
				$keydb[2] = strtoupper($_tipo_ordinamento);
			}
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->loadAsArray("*",$_email_utente,$_posizione_iniziale,$_posizione_finale,$_tipo_ordinamento);
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
