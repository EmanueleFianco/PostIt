<?php
/**
 *
 * Classe ECartella che descrive l'entità Cartella
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class ECartella{
	 /**
     *
	 * @var int $id numero intero identificativo della cartella di 11 cifre, gestito da Database.
	 * 
	 */
	 private $id;
	 /**
     *
	 * @var string $nome Nome della cartella.
	 * 
	 */
	 private $nome;
	 /**
     *
	 * @var int $posizione Numero intero che indica la posizione della cartella.
	 * 
	 */
	 private $posizione;
	 /**
     *
	 * @var string $colore Colore della cartella.
	 * 
	 */
	 private $colore;
	 /**
     *
	 * @var array $contenuto Array che contiene gli id delle note contenute nella cartella.
	 * 
	 */
	 private $contenuto = array();
	
	 /**
    * Costruttore di Cartella
    *
    * @param string $_nome
    * @param int $_posizione
    * @param string $_colore
    * @param array $_contenuto
    * 
    */
	
	public function __construct($_nome,$_posizione,$_colore,$_contenuto = NULL){
	   $this->setNome($_nome);
	   $this->setPosizione($_posizione);
	   $this->setColore($_colore);
	   if (isset($_contenuto)) {
	   	if (is_array($_contenuto)) {
	   		$this->setContenuto($_contenuto);
	   	} else {
	   		$this->Push($_contenuto);
	   	}
	   }
	}


	 /**
     * Setta $_id come id della cartella.
     * @param int $_id
     *
     */
	public function setId($_id){
			$this->id=$_id;
	}



	 /**
     * Setta $_nome come nome della cartella.
     * @param string $_nome
     *
     */	
	public function setNome($_nome){
		$_nome = trim(ucwords(strtolower($_nome)));
		$this->nome=$_nome;
	}

	 /**
     * Setta $_posizione come posizione della cartella.
     * @param int $_posizione
     *
     */	
	public function setPosizione($_posizione){
			$this->posizione=$_posizione;
	}

	 /**
     * Setta $_colore come colore della cartella.
     * @throws exception Se $_colore contiene un valore non valido.
     * @param string $_colore
     *
     */	
	public function setColore($_colore){
		$_colore = trim(strtoupper($_colore));
		$this->colore=$_colore;
	}
	
	 /**
     * Setta $_contenuto come array che contiene gli id delle note contenute all'interno della cartella.
     * @param array $_contenuto
     *
     */	
	public function setContenuto($_contenuto) {
		$this->contenuto = $_contenuto;
	}
	
	 /**
     * Aggiunge una nota all'interno dell'array $_contenuto.
     * @param Enota $_contenuto
     *
     */	
	public function Push(ENota $_contenuto){
		$this->contenuto[]=$_contenuto;
	}
	
     /**
     * 
     * @return int Numero intero che indica il numero identificativo della cartella.
     *
     */
    public function getId(){
		return $this->id;
	}

 	 /**
     * 
     * @return string Stringa che contiene il nome della cartella.
     *
     */
	public function getNome(){
		return $this->nome;
	}
	
	 /**
     * 
     * @return int Numero che indica la posizione della cartella.
     *
     */
	public function getPosizione(){
		return $this->posizione;
	}

	 /**
     * 
     * @return string Stringa che contiene il colore della cartella.
     *
     */
	public function getColore(){
		return $this->colore;
	}

	 /**
     * 
     * @return array Array che contiene gli identificativi delle note contenute nella cartella.
     *
     */
	public function getContenuto(){
		return $this->contenuto;
	}
	
	/**
	 * 
	 * @return array Trasforma l'oggetto in una array associativo
	 * 
	 */
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