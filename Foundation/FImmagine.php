<?php

class FImmagine extends Fdb {
	
	public function __construct()
	{
		$this->auto_increment = TRUE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="immagine";
		$this->keydb="(id_nota,nome,size,type,immagine)";
		$this->bind="(:id_nota,:nome,:size,:type,:immagine)";
	}
	
	public function inserisciImmagine(EImmagine $_object,$_id_nota = NULL)
	{
		$dati=$_object->getAsArray();
		$dati['immagine'] = addslashes($dati['immagine']);
		$dati['id_nota'] = $_id_nota;
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}
	
	public function getImmagineById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
		return $this->db->loadAsArray("*",$_id);
	}
	
	public function getImmaginiByNota($_id_nota,$_posizione_iniziale = NULL,$_posizione_finale = NULL,$_tipo_ordinamento = NULL) {
		if (!isset($_posizione_iniziale)) {
			$keydb = "id_nota";
			$bind = ":".$keydb;
		} else {
			$keydb = array("id_nota","posizione");
			$bind = array(":".$keydb[0],":posizione_iniziale",":posizione_finale");
			if (isset($_tipo_ordinamento)) {
				$keydb[2] = strtoupper($_tipo_ordinamento);
			}
		}
		$this->db->setParam($this->table,$keydb,$bind);
		$column = "count(*) as posizione, immagine.*";
		return $this->db->loadAsArray($_column,$_id_nota,$_posizione_iniziale,$_posizione_finale,$_tipo_ordinamento);
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