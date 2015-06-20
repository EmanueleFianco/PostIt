<?php

class FImmagine extends Fdb {
	
	public function __construct()
	{
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="immagine";
		$this->keydb="(nome,size,type,immagine_piccola,immagine_media,immagine_grande,immagine_originale)";
		$this->bind="(:nome,:size,:type,:immagine_piccola,:immagine_media,:immagine_grande,:immagine_originale)";
	}
	
	public function inserisciImmagine(EImmagine $_object)
	{
		$dati=$_object->getAsArray();
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}
	
	public function getImmagineByNome($_nome)
	{
		$this->db->setParam($this->table,"nome",":nome");
		return $this->db->queryGenerica("*","=",$_nome);
	}
	
	public function deleteImmagine($dati) {
		$keydb = array_keys($dati);
		$keydb = $keydb[0];
		$bind = ":".$keydb;
		$valori = $dati[$keydb];
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}
}
?>