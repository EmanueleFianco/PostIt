<?php
/**
 *
 * Classe EPromemoriaCondiviso che estende la classe EPromemoria
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class EPromemoriaCondiviso extends EPromemoria {
	/**
	*
	* @var EPartecipante $ultimo_a_modificare Ultimo partecipante che ha modificato il promemoria condiviso.
	*
	*/
	private $ultimo_a_modificare;
	/**
	*
	* @var Array $partecipanti Array che contiene tutti i partecipanti al promemoria condiviso.
	*
	*/
	private $partecipanti = array();
	
	/**
    * Costruttore di EPromemoriaCondiviso, eredita il costruttore di EPromemoria
    *
    * @param string $_titolo
    * @param string $_testo
    * @param string $_immagine
    * @param int $_posizione
    * @param string $_colore
    * @param EPartecipante $_ultimo_a_modificare
    * @param DateTime $_ora_data_avviso
    * @param array $_partecipanti
    * 
    */
    public function __construct($_titolo, $_testo, $_immagine, $_posizione, $_colore,EPartecipante $_ultimo_a_modificare, $_ora_data_avviso, $_partecipanti) {
		parent::__construct($_titolo, $_testo, $_immagine, $_posizione, $_colore, $_ora_data_avviso);
		$this->setUltimoAModificare($_ultimo_a_modificare);
		$this->setPartecipanti($_partecipanti);
	}
	

	 /**
	*
	*Setta $_ultimo_a_modificare come il partecipante che ha modificato per ultimo il promemoria condiviso.
	* @param EPartecipante $_ultimo_a_modificare
	*
	*/
	public function setUltimoAModificare(EPartecipante $_ultimo_a_modificare) {
		$this->ultimo_a_modificare = $_ultimo_a_modificare;
	}
	 /**
	 *
	 *Setta $_partecipanti come il contenuto dell'array che contiene tutti i partecipanti al promemoria condiviso.
	 * @param array $_partecipanti
	 *
	 */
	public function setPartecipanti(array $_partecipanti) {
		$this->partecipanti = $_partecipanti;
	}
	 /**
	 *
	 *Inserisci un partecipante nell'array dei partecipanti al promemoria condiviso.
	 * @param EPartecipante $_partecipante
	 *
	 */
	public function Push(EPartecipante $_partecipante) {
		$this->partecipanti[] = $_partecipante;
	}
	 /**
	 *
	 * @return EPartecipante Ultimo partecipante che ha modificato il promemoria condiviso.
	 *
	 */
	
	public function getUltimoAModificare() {
		return $this->ultimo_a_modificare;
	}	
	
	 /**
	 *
	 * @return array Array che contiene tutti i partecipanti al promemoria condiviso.
	 *
	 */
	public function getPartecipanti() {
		return $this->partecipanti;
	}
}