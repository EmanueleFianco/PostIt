<?php
/**
 *
 * Classe EGruppo che estende la classe ECartella
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class EGruppo extends ECartella {
	/**
	*
	* @var array $partecipanti array che contiene tutti i componenti del gruppo
	*
	*/
	private $partecipanti = array();
	 /**
    * Costruttore di EGruppo che eredita il costruttore di ECartella.
    *
    * @param string $_nome
    * @param int $_posizione
    * @param string $_colore
    * @param string $_contenuo
    * @param array $_partecipanti
    *
    */
	public function __construct($_nome,$_posizione,$_colore,$_contenuto,$_partecipanti) {
		parent::__construct($_nome,$_posizione,$_colore,$_contenuto);
		$this->setPartecipanti($_partecipanti);
	}
	
	 /**
     * Setta $_partecipanti come il contenuto dell'array che contiene tutti i partecipanti del gruppo.
     * @param array $_partecipanti
     *
     */
	public function setPartecipanti($_partecipanti) {
		$this->partecipanti = $_partecipanti;
	}
	 /**
     * Preleva il primo elemento dell'array partecipanti[]
     * @param EPartecipante $_partecipante
     *
     */
	public function Push(EPartecipante $_partecipante) {
		$this->partecipanti[] = $_partecipante;
	}
	
	/**
	*
	* @return array Array che contiene tutti i partecipanti del gruppo.
	*
	*/
	public function getPartecipanti() {
		return $this->partecipanti;
	}
	
}