<?php

class FNota extends Fdb {

	public function __construct()
	{
		$this->auto_increment = TRUE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="nota";
		$this->keydb="(id_cartella,titolo,testo,immagine,posizione,colore,tipo,condiviso,ultimo_a_modificare,ora_data_avviso)";
		$this->bind="(:id_cartella,:titolo,:testo,:immagine,:posizione,:colore,:tipo,:condiviso,:ultimo_a_modificare,:ora_data_avviso)";
	}

	public function inserisciNota($dati)
	{
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}

	public function getNotaById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
	    return $this->db->loadAsArray("*",$_id);
	}
	
	public function getNoteByCartella($_id_cartella) {
		$this->db->setParam($this->table,"id_cartella",":id_cartella");
		return $this->db->loadAsArray("*",$_id_cartella);
	}

}
