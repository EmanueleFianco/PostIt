<?php
/**
 *
 * Classe FCartella che gestisce i rapporti con il database che hanno per oggetto le cartelle
 * @package Foundation
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class FCartella extends Fdb {
	/**
	 * Costruttore di FCartella
	 */
	public function __construct()
	{
		$this->auto_increment = TRUE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="cartella";
		$this->keydb="(amministratore,tipo,nome,colore)";
		$this->bind="(:amministratore,:tipo,:nome,:colore)";
	}
	/**
	 * Inserisce una cartella nel database
	 * @param ECartella $_object Cartella da inserire
	 * @param string $_tipo Per impostare la tipologia della cartella [privata/gruppo]
	 * @param string $_amministratore Email dell'amministratore della cartella
	 * @return bool TRUE se l'inserimento va a buon fine
	 */
	public function inserisciCartella(ECartella $_object,$_tipo,$_amministratore)
	{
		$dati=$_object->getAsArray();
		unset($dati['posizione']);
		$dati['tipo']=$_tipo;
		$dati['amministratore']=$_amministratore;
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		return $this->db->inserisci($dati);
	}
	/**
	 * Restituisce la cartella con l'id passato per parametro
	 * @param int $_id Id della cartella da restituire
	 * @return array Array contenente la cartella
	 */
	public function getCartellaById($_id)
	{
		$this->db->setParam($this->table,"id",":id");
	    return $this->db->queryGenerica("*","=",$_id);
	}
	
	public function getCartellaByNomeEAmministratore($_nome,$_amministratore) {
		$column = "*";
		$keydb = array("nome","amministratore");
		$bind = array(":nome",":amministratore");
		$_paragone = array("=","=");
		$_parametri = array($_nome,$_amministratore);
		$_operatori = array("AND");
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->queryGenerica($column,$_paragone,$_parametri,$_operatori);
	}
	/**
	 * Aggiorna lo stato della cartella
	 * @param array $dati Array così fatto "attributo da modificare" => "valore", "id della cartella" => "valore dell'id"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
	public function updateCartella($dati) {
		foreach ($dati as $key => $value) {
			$keydb[]=$key;
			$bind[]=":".$key;
			$valori[]=$value;
		}
		$this->db->setParam($this->table,$keydb,$bind);
		return $this->db->update($valori);
	}
	/**
	 * Cancella una cartella nel database
	 * @param array $dati Array così fatto "id della cartella" => "valore dell'id"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
	public function deleteCartella($dati) {
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