<?php
/**
 *
 * Classe ENota che descrive l'entità Nota
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class ENota {
	 /**
     *
	 * @var int $id Numero intero di massimo 11 cifre associato alla nota in maniera univoca, valore gestito tramite database.
	 * 
	 */    
	private $id;
	/**
     *
	 * @var string $titolo Titolo della nota definito dall'utente composto da una stringa di massimo 40 caratteri.
	 * 
	 */
	private $titolo;
	/**
     *
	 * @var string $testo Testo contenuto nella nota di massimo 40 caratteri.
	 * 
	 */
	private $testo;
	/**
     *
	 * @var array $immagine Array contenente i nome delle immagini associate alla nota.
	 * 
	 */
	private $immagine = array();
	/**
     *
	 * @var int $posizione Posizione della nota all'interno della cartella.
	 * 
	 */
	private $posizione;
	/**
     *
	 * @var string $colore Colore dello sfondo della nota.
	 * 
	 */
	private $colore;

	 /**
    * Costruttore di Nota
    *
    * @throws Exception Se i parametri non sono tutti stringhe formattate secondo le regole descritte in SetTitolo(),SetTesto(),SetPosizione(),SetColore(). 
    * @param string $_titolo
    * @param string $_testo
    * @param string $_immagine
    * @param int $_posizione
    * @param string $_colore
    *
    */
	 public function __construct($_titolo, $_testo, $_posizione, $_colore, $_immagine = NULL) {
		$this->setTitolo($_titolo);
		$this->setTesto($_testo);
		$this->setPosizione($_posizione);
		$this->setColore($_colore);
		if (isset($_immagine)) {
			if (is_array($_immagine)) {
				$this->setImmagine($_immagine);
			} else {
				$this->Push($_immagine);
			}	
		}
	}
	
	 /**
     * Setta $_id come id della nota.
     * @param int $_id 
     *
     */
	public function setId($_id) {
		$this->id = $_id;
	}

	 /**
     * Setta $_titolo come titolo della nota.
     * @param string $_titolo
     *
     */
	public function setTitolo($_titolo) {
		$this->titolo = $_titolo;
	}
	 
	 /**
     * Setta $_testo come testo contenuto all'interno della nota.
     * @param string $_testo
     *
     */
	public function setTesto($_testo) {
		$this->testo = $_testo;
	}

     /**
     * Setta $_immagine come immagini associate alla nota.
     * @param array $_immagine
     *
     */
    public function setImmagine(array $_immagine) {
		$this->immagine = $_immagine;
	}

     /**
     * Setta $_posizione come posizione della nota all'interno della cartella.
     * @param int $_posizione
     *
     */
	public function setPosizione($_posizione) {
			$this->posizione = $_posizione;
	}

     /**
     * Setta $_colore come colore dello sfondo della nota.
     * @param string $_colore
     *
     */
	public function setColore($_colore) {
		$this->colore= trim(strtoupper($_colore));
	}
	
	/**
	 * Aggiunge un'immagine all'interno dell'array $immagine.
	 * @param EImmagine $_immagine 
	 */
	public function Push(EImmagine $_immagine){
		$this->immagine[]=$_immagine;
	}
	
     /**
     * 
     * @return int Numero intero che indica il numero identificativo della nota.
     *
     */
	public function getId() {
		return $this->id;
	}

	 /**
     * 
     * @return string Stringa contenente il titolo della nota.
     *
     */
	public function getTitolo() {
		return $this->titolo;
	}

	 /**
     * 
     * @return string Testo contenuto all'interno della nota.
     *
     */
	public function getTesto() {
		return $this->testo;
	}

	 /**
     * 
     * @return string Stringa contenente il percorso relativo dell'immagine associata alla nota.
     *
     */
	public function getImmagine() {
		return $this->immagine;
	}

	 /**
     * 
     * @return string Stringa contenente il colore dello sfondo della nota.
     *
     */
	public function getColore() {
		return $this->colore;
	}

	 /**
     * 
     * @return int Numero che rappresenta la posizione della nota nella cartella.
     */
	public function getPosizione() {
		return $this->posizione;
	}
	
	/**
	 *
	 * @return array Trasforma l'oggetto in una array associativo
	 *
	 */
	public function getAsArray() {
	$result=array();
    	foreach($this as $key => $value) {
    		if (!is_array($value) && !is_object($value)) {
    			$result[$key] = $value;
    		}
    	}
    return $result;
	}
}
?>