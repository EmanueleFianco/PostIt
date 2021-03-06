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
	* @var string $ultimo_a_modificare Indica l'ultimo utente che ha modificato la nota condivisa.
	*
	*/
	private $ultimo_a_modificare;
	
	/**
    * Costruttore di ENotaCondivisa, eredita il costruttore di ENota
    *
    * @param string $_titolo
    * @param string $_testo
    * @param int $_posizione
    * @param string $_colore
    * @param string $_ultimo_a_modificare
    * @param string $_immagine
    * 
    */
	public function __construct($_titolo, $_testo, $_posizione, $_colore,$_ultimo_a_modificare, $_immagine = NULL) {
		parent::__construct($_titolo, $_testo, $_posizione, $_colore, $_immagine);
		$this->setUltimoAModificare($_ultimo_a_modificare);
	}
	
	/**
	*
	*Setta la mail dell'ultimo utente che ha modificato la nota condivisa.
	* @param string $_ultimo_a_modificare
	*
	*/
	public function setUltimoAModificare($_ultimo_a_modificare) {
		$this->ultimo_a_modificare = $_ultimo_a_modificare;
	}

	/**
	*Funzione che restituisce l'ultimo utente che ha modificato la nota condivisa
	* @return string Email dell'utente che ha modificato per ultimo la nota condivisa.
	*
	*/
	public function getUltimoAModificare() {
		return $this->ultimo_a_modificare;
	}
	
}
?>