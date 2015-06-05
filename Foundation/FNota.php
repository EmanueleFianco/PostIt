<?php

class FNota extends Fdb {

	public function __construct()
	{
		$this->auto_increment = TRUE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="nota";
		$this->keydb="(id_cartella,titolo,testo,posizione,colore,tipo,condiviso,ultimo_a_modificare,ora_data_avviso)";
		$this->bind="(:id_cartella,:titolo,:testo,:posizione,:colore,:tipo,:condiviso,:ultimo_a_modificare,:ora_data_avviso)";
	}

	public function inserisciNota(ENota $_object,$_id_cartella,$_tipo,$_condiviso)
	{
		$dati=$_object->getAsArray();
		$dati['id_cartella']=$_id_cartella;
		$dati['tipo']=$_tipo;
		$dati['condiviso']=$_condiviso;
		$classe=get_class($_object);
		if ($classe == 'ENotaCondivisa') {
			//Qui andrà ricavata l'email del partecipante ultimo a modificare
		} elseif ($classe == 'EPromemoriaCondiviso') {
			//Qui andrà ricavata l'email del partecipante ultimo a modificare
			//Qui andrà ricavata l'ora e la data di avviso
		} elseif ($classe == 'EPromemoria') {
			//Qui andrà ricavata l'ra e la data di avviso
		}
		$dati['ora_data_avviso']=NULL;   // Da togliere in futuro insieme alla riga 30
		$dati['ultimo_a_modificare']=NULL;
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}

	public function getNotaById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
	    return $this->db->loadAsArray("*",$_id);
	}
	
	public function getNoteByCartella($_id_cartella,$_posizione_iniziale = NULL,$_posizione_finale = NULL,$_tipo_ordinamento = NULL) {
	if (!isset($_posizione_iniziale)) {
			$keydb = "id_cartella";
			$bind = ":".$keydb;
		} else {
			$keydb = array("id_cartella","posizione");
			$bind = array(":".$keydb[0],":posizione_iniziale",":posizione_finale");
			if (isset($_tipo_ordinamento)) {
				$keydb[2] = strtoupper($_tipo_ordinamento);
			}
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->loadAsArray("*",$_id_cartella,$_posizione_iniziale,$_posizione_finale,$_tipo_ordinamento);
	}
	
	public function updateNota($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	
	public function deleteNota($dati) {
		$keydb = array_keys($dati);
		$keydb = $keydb[0];
		$bind = ":".$keydb;
		$valori = $dati[$keydb];
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}

}
