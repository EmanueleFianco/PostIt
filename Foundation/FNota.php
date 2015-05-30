<?php

class FNota extends Fdb {

	public function __construct()
	{ 
		$this->table="nota";
		$this->keydb="id,id_cartella,titolo,testo,immagine,posizione,colore,tipo,condiviso,ultimo_a_modificare,ora_data_avviso";
		$this->bind=":id,:id_cartella,:titolo,:testo,:immagine,:posizione,:colore,:tipo,:condiviso,:ultimo_a_modificare,:ora_data_avviso";
	}

	public function InserisciNota($dati)
	{
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}

	public function CercaNota($_value)
	{
		$this->db->setParam($this->table,"id",":id");
	     return $this->db->loadAsArray("*",$_value);
	
	}

}
