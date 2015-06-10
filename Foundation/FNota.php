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

	public function inserisciNota(ENota $_object,$_id_cartella)
	{
		$dati=$_object->getAsArray();
		$dati['id_cartella']=$_id_cartella;
		$dati['condiviso']=FALSE;
		$classe=get_class($_object);
		if ($classe == 'ENota' || $classe == 'ENotaCondivisa') {
			$dati['tipo'] = 'nota';
			$dati['ora_data_avviso'] = '2015-06-09 18:37:00';   //Da levare in futuro
			$dati['ultimo_a_modificare'] = 'emanuele.fianco@gmail.com';    //Da levare in futuro
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
	    return $this->db->queryParametro("*",$_id);
	}
	
	public function getNoteByCartella($_id_cartella,$_posizione_finale = NULL,$_posizione_iniziale = NULL,$_tipo_ordinamento = NULL) {
	if (!isset($_posizione_finale)) {
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
		return $this->db->loadAsArray("*",$_id_cartella,$_posizione_finale,$_posizione_iniziale);
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
	
	public function getMaxPosizioneNotaByCartella($_id_cartella) {
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,"id_cartella",":id_cartella");
		return $this->db->queryParametro("max(posizione)", $_id_cartella);
	}
	
	public function getNotaByParametri($_parametri) {
		foreach ($_parametri as $key => $valore) {
			$keydb[] = $key;
			$bind[] = ":".$key;
			$valori[]=$valore;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->queryParametro("*",$valori);
	}

}
