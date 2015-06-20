<?php
/**
 *
 * Classe FImmagine che gestisce i rapporti con il database che hanno come oggetto le immagini
 * @package Foundation
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class FImmagine extends Fdb {
	/**
	 * Costruttore di FImmagine
	 */
	public function __construct()
	{
		$this->auto_increment = FALSE;
		$this->db = USingleton::getInstance('Fdb');
		$this->table="immagine";
		$this->keydb="(nome,size,type,immagine_piccola,immagine_media,immagine_grande,immagine_originale)";
		$this->bind="(:nome,:size,:type,:immagine_piccola,:immagine_media,:immagine_grande,:immagine_originale)";
	}
	/**
	 * Inserisce un'immagine nel database
	 * @param EImmagine $_object Immagine da inserire
	 * @return bool TRUE se l'inserimento va a buon fine
	 */
	public function inserisciImmagine(EImmagine $_object)
	{
		$dati=$_object->getAsArray();
		$this->db->auto_increment = $this->auto_increment;
		$this->db->setParam($this->table,$this->keydb,$this->bind);
		return $this->db->inserisci($dati);
	}
	/**
	 * Restituisce l'immagine con il nome passato per parametro
	 * @param string $_nome Nome dell'immagine da restituire
	 * @return array Array contenente l'immagine
	 */
	public function getImmagineByNome($_nome)
	{
		$this->db->setParam($this->table,"nome",":nome");
		return $this->db->queryGenerica("*","=",$_nome);
	}
	/**
	 * Cancella un'immagine nel database
	 * @param array $dati Array così fatto "Nome dell'immagine" => "Valore del nome dell'immagine"
	 * @return int 1 se andata a buon fine, 0 altrimenti
	 */
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