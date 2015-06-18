<?php

class FNota extends Fdb {

	public function __construct()
	{
		$this->auto_increment = TRUE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="nota";
		$this->keydb="(titolo,testo,colore,tipo,condiviso,creata_da,ultimo_a_modificare,ora_data_avviso)";
		$this->bind="(:titolo,:testo,:colore,:tipo,:condiviso,:creata_da,:ultimo_a_modificare,:ora_data_avviso)";
	}

	public function inserisciNota(ENota $_object, $_creata_da)
	{
		$dati=$_object->getAsArray();
		unset($dati['posizione']);
		$dati['condiviso']=FALSE;
		$dati['ora_data_avviso'] = NULL;   //Da levare in futuro
		$dati['ultimo_a_modificare'] = NULL;    //Da levare in futuro
		$dati['creata_da'] = $_creata_da;
		$classe=get_class($_object);
		if ($classe == 'ENota' || $classe == 'ENotaCondivisa') {
			$dati['tipo'] = 'nota';
		} else {
			$dati['tipo'] = 'promemoria';
			$dati['ora_data_avviso'] = '2015-06-09 18:37:00';   //Da levare in futuro
			//Da vedere come prendere l'ora e la data di avviso
		}
		if ($classe == 'ENotaCondivisa' || $classe == 'EPromemoriaCondiviso') {
			$dati['condiviso'] = TRUE;
			$dati['ultimo_a_modificare'] = 'emanuele.fianco@gmail.com';   //Da levare in futuro
			//Da vedere come prendere l'ultimo a modificare
		}
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		$this->db->inserisci($dati);
	}

	public function getNotaById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
	    return $this->db->queryGenerica("*","=",$_id);
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
?>