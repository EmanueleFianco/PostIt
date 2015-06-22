<?php
/**
 *
 * Classe Utente che descrive l'entità Utente
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class EUtente
{   /**
     *
	 * @var string $username username dell'utente [minimo 5, massimo 15 caratteri] definito in fase di registrazione.
	 * 
	 */
    private $username;
    /**
     *
	 * @var string $password password definita dall'utente [minimo 6, massimo 20 caratteri; caratteri ammessi: lettere, numeri] .
	 * 
	 */    
    private $password;
    /**
     *
     * @var string $nome nome dell'utente definito in fase di registrazione.
     * 
     */
    private $nome;
     /**
     *
     * @var string $cognome cognome dell'utente definito in fase di registrazione.
     * 
     */
    private $cognome;
     /**
     *
     * @var string $email email dell'utente definito in fase di registrazione.
     * 
     */
    private $email;
     /**
     *
     * @var string $codice_attivazione sequenza di 13 caratteri generata dalla funzione uniqid() necessaria nella fase di attivazione dell'account dell'utente.
     * 
     */ 
    private $codice_attivazione;
     /**
     *
     * @var string $stato_attivazione variabile che informa se l'account è attivato o meno [valori possibili: ATTIVATO/NON ATTIVATO].
     * 
     */
    private $stato_attivazione;
     /**
     *
     * @var string $tipo_utente variabile che informa sulla tipologia dell'utente registrato [valori possibili: ADMIN/NORMALE].
     * 
     */
    private $tipo_utente;
     /**
     *
     * @var array $cartelle array che contiene gli oggetti cartella.
     * 
     */
    private $cartelle = array();

     /**
    * Costruttore di Utente
    *
    * @param string $_username
    * @param string $_password
    * @param string $_nome
    * @param string $_cognome
    * @param string $_email
    * @param string $_stato_attivazione
    * @param string $_tipo_utente
    * @param array $_cartelle
    *
    */
    public function __construct($_username,$_password,$_nome,$_cognome,$_email,$_stato_attivazione,$_tipo_utente,$_cartelle = NULL)
    {
    	$this->setUsername($_username);
    	$this->setPassword($_password);
    	$this->setNome($_nome);
    	$this->setCognome($_cognome);
    	$this->setEmail($_email);
        $this->setStatoAttivazione($_stato_attivazione);
        $this->setTipoUtente($_tipo_utente);
        if (isset($_cartelle)) {
        	if (is_array($_cartelle)) {
        		$this->setCartelle($_cartelle);
        	} else {
        		$this->Push($_cartelle);
        	}
        }
    }

    


     /**
     * Setta $_username come username dell'utente
     * @param string $_username
     *
     */  
    public function setUsername($_username) {
            $this->username=$_username;
    }
    

    
     /**
     * Setta $_password come password dell'utente
     * @param string $_password
     *
     */  
    public function setPassword($_password) {
    		$this->password = md5($_password);
    }
     /**
     * Setta $_email come email associata all'utente
     * @param string $_email
     *
     */  
  
    public function setEmail($_email) {
            $this->email=$_email;
    }
    
    

     /**
     * Setta $_nome come nome dell'utente
     * @param string $_nome
     *
     */  
    public function setNome($_nome) {
    	$_nome = trim(ucwords(strtolower($_nome)));
    	$this->nome = $_nome;
    }

     /**
     * Setta $_cognome come cognome dell'utente
     * @param string $_cognome
     *
     */  
    public function setCognome($_cognome){
    	$_nome = trim(ucwords(strtolower($_cognome)));
    	$this->cognome = $_cognome;
    }

     /**
     * Associa a $cartelle l'array contenuto in $_cartelle
     * @param array $_cartelle
     *
     */  
    public function setCartelle(array $_cartelle) {
    	$this->cartelle = $_cartelle;
    }

     /**
     * Aggiunge una cartella all'array $cartelle
     * @param ECartella $_cartella
     *
     */  
    public function Push(ECartella $_cartella) {
    	$this->cartelle[] = $_cartella;
    }
    
   /**
    * La funzione uniqid genera un codice casuale calcolato con i millisec attuali di 13 caratteri
    **/
    public function setCodiceAttivazione() {
    	if (!isset($this->codice_attivazione)) {
        	$this->codice_attivazione = uniqid();
    	}
    }

     /**
     * Setta $_stato_attivazione come lo stato di attivazione dell'utente
     * @param string $_stato_attivazione
     *
     */  
     public function setStatoAttivazione($_stato_attivazione) {
        $this->stato_attivazione=$_stato_attivazione;
     }

     /**
     * Setta $_tipo_utente come il tipo dell'utente
     * @param string $_tipo_utente
     *
     */  
    public function setTipoUtente($_tipo_utente) {
    	$this->tipo_utente = $_tipo_utente;
    }
    

     /**
     * 
     * @return string Stringa contenente il nome dell'utente.
     *
     */
    public function getNome() {
        return $this->nome;
     }


     /**
     * 
     * @return string Stringa contenente il cognome dell'utente
     *
     */
    public function getCognome()
     {
        return $this->cognome;
     }

     /**
     * 
     * @return string Stringa contenente l'email dell'utente.
     *
     */
    public function getEmail()
    {
        return $this->email;
    }
     /**
     * 
     * @return string Stringa contenente la password dell'utente.
     */
    public function getPassword()
    {
        return $this->password;
    }
     /**
     * 
     * @return string Stringa contenente l'username dell'utente.
     *
     */    
    public function getUsername()
    {
        return $this->username;
    }
   
     /**
     * 
     * @return string Stringa contenente il codice attivazione dell'utente.
     *
     */    
    public function getCodiceAttivazione()
    {
        return $this->codice_attivazione;
    }

     /**
     * 
     * @return string Stringa contenente lo stato di attivazione dell'utente.
     *
     */
    public function isActive()
    {
        return $this->stato_attivazione;
    }
    
     /**
     * 
     * @return string Stringa contenente il tipo dell'utente.
     *
     */    
    public function getTipoUtente() {
    	return $this->tipo_utente;
    }

     /**
     * 
     * @return array Array contenente le cartelle dell'utente
     *
     */    
    public function getCartelle() {
    	return $this->cartelle;
    }
    
    /**
     *
     * @return array Trasforma l'oggetto in una array associativo
     *
     */
    public function getAsArray(){
    	$result=array();
    	foreach($this as $key => $value) {
    		if (!is_array($value) && !is_object($value)) {
    			$result[$key]= $value;
    		}
    	}
    	return $result;
    }
}
?>
