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
	 * @var int $posizione numero intero che indica la posizione della cartella.
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
    * @throws Exception Se i parametri non sono tutti stringhe formattate secondo le regole descritte in SetNome(),SetPosizione(),SetColore() 
    * @param string $_nome
    * @param int $_posizione
    * @param string $_colore
    * @param array $_contenuto
    * 
    */
	
	public function __construct($_nome,$_posizione,$_colore,$_contenuto){
	   $this->setNome($_nome);
	   $this->setPosizione($_posizione);
	   $this->setColore($_colore);
	   $this->setContenuto($_contenuto);
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
     * @throws exception Se il contenuto di $_nome non contiene solo alfanumerici ed ha lunghezza ]2,30[.
     * @param string $_nome
     *
     */	
	public function setNome($_nome){
		$_nome = trim($_nome);
		$pattern = '/[[:alpha:] \']{2,30}/';
	if(preg_match($pattern, $_nome)){
			$this->nome=$_nome;
		}
		else {
			throw new Exception("Nome Cartella Non Valido");
		}
	}



	 /**
     * Setta $_posizione come posizione della cartella.
     * @throws exception Se $_posizione contiene un valore non valido.
     * @param string $_posizione
     *
     */	
	public function setPosizione($_posizione){
		$pattern='/^[0-9]{0,11}$/';
		if(preg_match($pattern, $_posizione)){
			$this->posizione=$_posizione;
		}
		else {
			throw new Exception("Posizione cartella non valida");
		}
	}
	



	 /**
     * Setta $_colore come colore della cartella.
     * @throws exception Se $_colore contiene un valore non valido.
     * @param string $_colore
     *
     */	
	public function setColore($_colore){
		$pattern='/^#([a-f]|[0-9]){6}$/';
		if(preg_match($pattern, $_colore)){
			$this->colore=$_colore;
		} else {
			throw new Exception("Colore cartella non valido!");
		}
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
     * Preleva la prima nota contenuta all'interno dell'array $_contenuto.
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
}
?>