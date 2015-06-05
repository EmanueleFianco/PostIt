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
	 * @var int $id numero intero di massimo 11 cifre associato alla nota in maniera univoca, valore gestito tramite database.
	 * 
	 */    
	private $id;
	/**
     *
	 * @var string $titolo titolo della nota definito dall'utente composto da una stringa di massimo 40 caratteri.
	 * 
	 */
	private $titolo;
	/**
     *
	 * @var string $testo testo contenuto nella nota di massimo 40 caratteri.
	 * 
	 */
	private $testo;
	/**
     *
	 * @var string $immagine percorso relativo all'immagine associata alla nota.
	 * 
	 */
	private $immagine = array();
	/**
     *
	 * @var int $posizione posizione della nota all'interno della cartella.
	 * 
	 */
	private $posizione;
	/**
     *
	 * @var string $colore colore dello sfondo della nota.
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
     * @throws exception Se il titolo contiene più di 40 caratteri.
     * @param string $_titolo
     *
     */
	public function setTitolo($_titolo) {
		$pattern = '/[.]{0,40}/';   //Vedere se è meglio mettere $pattern = '/[[:alnum:]\']{0,40}/';
		if (preg_match($pattern, $_titolo)) {
			$this->titolo = $_titolo;
		} else {
			throw new Exception("Titolo non valido!");
		}
	}
	 



	 /**
     * Setta $_testo come testo contenuto all'interno della nota.
     * @throws exception Se il testo della nota contiene più di 600 caratteri.
     * @param string $_testo
     *
     */
	public function setTesto($_testo) {
		$pattern = '/[.]{0,3000}/';
		if (preg_match($pattern, $_testo)) {
			$this->testo = $_testo;
		} else {
			throw new Exception("Testo non valido!");
		}
	}
     



     /**
     * Setta $_immagine come immagine associata alla nota.
     * @param string $_immagine
     *
     */
    public function setImmagine($_immagine) {
		$this->immagine = $_immagine;
	}




     /**
     * Setta $_posizione come posizione della nota all'interno della cartella.
     * @throws exception se inserisco una posizione non valida per la nota.
     * @param int $_posizione
     *
     */
	public function setPosizione($_posizione) {
		$pattern = '/^[0-9]{0,11}$/';
		if (preg_match($pattern,$_posizione)) {
			$this->posizione = $_posizione;
		} else {
			throw new Exception("Posizione non valida!");
		}
	}
	
	




     /**
     * Setta $_colore come colore dello sfondo della nota.
     * @throws exception Se il colore associato allo sfondo non è valido
     * @param string $_colore
     *
     */
	public function setColore($_colore) {
	$pattern='/^#([a-f]|[0-9]){6}$/';
		if(preg_match($pattern, $_colore)){
			$this->colore=$_colore;
		} else {
			throw new Exception("Colore Cartella Non Valido!");
		}
	}
	
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
     * @return int numero che rappresenta la posizione della nota nella cartella.
     */
	public function getPosizione() {
		return $this->posizione;
	}
	
	public function getAsArray(){
    	$result=array();
    	foreach($this as $key => $value) {
    		if (!is_array($value)) {
    			$result[$key]= $value;
    		}
    	}
    	return $result;
    }
}
?>