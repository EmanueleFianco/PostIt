<?php
/**
 *
 * Classe ENotaCondivisa che estende la classe Enota
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class ENotaCondivisa extends ENota {
	/**
	*
	* @var EPartecipante $ultimo_a_modificare indica l'ultimo utente partecipante che ha modificato la nota condivisa.
	*
	*/
	private $ultimo_a_modificare;
	/**
	*
	* @var array $partecipanti array che contiene gli utenti che condividono la nota.
	*/
	private $partecipanti = array();
	
	/**
    * Costruttore di ENotaCondivisa, eredita il costruttore di ENota
    *
    * @param string $_titolo
    * @param string $_testo
    * @param string $_immagine
    * @param int $_posizione
    * @param string $_colore
    * @param EPartecipante $_ultimo_a_modificare
    * @param array $_partecipanti
    * 
    */
	public function __construct($_titolo, $_testo, $_posizione, $_colore,$_ultimo_a_modificare, $_immagine = NULL, $_partecipanti = NULL) {
		parent::__construct($_titolo, $_testo, $_posizione, $_colore, $_immagine);
		$this->setUltimoAModificare($_ultimo_a_modificare);
		if (isset($_partecipanti)) {
			if (is_array($_partecipanti)) {
				$this->setPartecipanti($_partecipanti);
			} else {
				$this->Push($_partecipanti);
			}
		}	
	}
	
	/**
	*
	*Setta l'ultimo utente partecipante che ha modificato la nota condivisa.
	* @param EPartecipanti $_ultimo_a_modificare
	*
	*/
	public function setUltimoAModificare($_ultimo_a_modificare) {
		$this->ultimo_a_modificare = $_ultimo_a_modificare;
	}
	

	/**
	*
	*Setta il contenuto dell'array che contiene tutti gli utenti partecipanti alla nota condivisa.
	* @param array $_partecipanti 
	*
	**/
	public function setPartecipanti(array $_partecipanti) {
		$this->partecipanti = $_partecipanti;
	}
	

	 /**
	*
	* Inserisci un partecipante nell'array dei partecipanti alla nota condivisa.
	* @param EPartecipante $_partecipante
	*
	**/
	public function Push(EPartecipante $_partecipante) {
		$this->partecipanti[] = $_partecipante;
	}
	

	 /**
	*
	* @return EPartecipante Utente partecipante che ha modificato per ultimo la nota condivisa.
	*
	*/
	public function getUltimoAModificare() {
		return $this->ultimo_a_modificare;
	}
	
	/**
	*
	* @return array Array che contiene tutti gli utenti partecipanti alla nota condivisa.
	*
	*/
	public function getPartecipanti() {
		return $this->partecipanti;
	}
	
}
?>