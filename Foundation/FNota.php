<?php
/**
 *
 * Classe FNota che gestisce i rapporti con il database che hanno per oggetto le note
 * @package Foundation
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class FNota extends Fdb {
	/**
	 * Costruttore di FNota
	 */
	public function __construct()
	{
		$this->auto_increment = TRUE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="nota";
		$this->keydb="(titolo,testo,colore,tipo,condiviso,creata_da,ultimo_a_modificare,ora_data_avviso)";
		$this->bind="(:titolo,:testo,:colore,:tipo,:condiviso,:creata_da,:ultimo_a_modificare,:ora_data_avviso)";
	}
	/**
	 * Inserisce una nota nel database
	 * @param ENota $_object Nota da inserire
	 * @param string $_creata_da Email del creatore della nota
	 * @return bool TRUE se l'inserimento va a buon fine
	 */
	public function inserisciNota(ENota $_object, $_creata_da)
	{
		$dati=$_object->getAsArray();
		unset($dati['posizione']);
		$dati['condiviso']=FALSE;
		$dati['ora_data_avviso'] = FALSE;
		$dati['creata_da'] = $_creata_da;
		$dati['ultimo_a_modificare'] = $_creata_da;
		$classe=get_class($_object);
		if ($classe == 'ENota' || $classe == 'ENotaCondivisa') {
			$dati['tipo'] = 'nota';
		} else {
			$dati['tipo'] = 'promemoria';
		}
		if ($classe == 'ENotaCondivisa' || $classe == 'EPromemoriaCondiviso') {
			$dati['condiviso'] = TRUE;
		}
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		return $this->db->inserisci($dati);
	}
	/**
	 * Restituisce la nota con l'id passato per parametro
	 * @param int $_id Id della nota da restituire
	 * @return array Array contenente la nota
	 */
	public function getNotaById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
	    return $this->db->queryGenerica("*","=",$_id);
	}
	/**
	 * Aggiorna lo stato della nota
	 * @param array $dati Array così fatto "attributo da modificare" => "valore", "id della nota" => "valore dell'id"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
	public function updateNota($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	/**
	 * Cancella una nota nel database
	 * @param array $dati Array così fatto "id della nota" => "valore dell'id"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
	public function deleteNota($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->delete($valori);
	}

}
?>