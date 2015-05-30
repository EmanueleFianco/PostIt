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
	 * @var string $immagine percorso relativo all'immagine scelta dall'utente associata al suo account.
	 * 
	 */
    private $immagine;
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
    * @throws Exception Se i parametri non sono tutte stringhe formattate secondo le regole descritte in SetUsername(),SetPassword(),SetNome(),SetCognome(),SetEmail(),SetTipoUtente(). 
    * @param string $_username
    * @param string $_password
    * @param string $_nome
    * @param string $_cognome
    * @param string $_immagine
    * @param string $_email
    * @param string $_stato_attivazione
    * @param string $_tipo_utente
    * @param array $_cartelle
    *
    */
    public function __construct($_username,$_password,$_nome,$_cognome,$_immagine,$_email,$_stato_attivazione,$_tipo_utente,$_cartelle)
    {
    	$this->setUsername($_username);
    	$this->setPassword($_password);
    	$this->setImmagine($_immagine);
    	$this->setNome($_nome);
    	$this->setCognome($_cognome);
    	$this->setEmail($_email);
        $this->setStatoAttivazione($_stato_attivazione);
        $this->setTipoUtente($_tipo_utente);
        $this->setCartelle($_cartelle);

    }

    


     /**
     * Setta $_username come username dell'utente
     * @throws Exception Se la stringa contenuta in $_username non contiene solo caratteri alfanumerici ed ha lunghezza ]5,15[
     * @param string $_username
     *
     */  
    public function setUsername($_username)
    {
    	$pattern='/^[[:alnum:]]{5,15}$/'; //Si deve aggiungere anche la possibilità di inserire caratteri come -_
        if(preg_match($pattern,$_username))
        {
            $this->username=$_username;
        }
        else
            {
	       throw new Exception("Username non valida");
            }
    }
    

    
     /**
     * Setta $_password come password dell'utente
     * @throws Exception Se la stringa contenuta in $_password non contiene solo caratteri alfanumerici ed ha lunghezza ]6,20[
     * @param string $_password
     *
     */  
    public function setPassword($_password) {
		$pattern = '/^[[:alnum:][:punct:]]{6,20}$/';   
    	if (preg_match( $pattern, $_password )) {
    		$this->password = md5($_password);
    	} else {
    		throw new Exception("Password non valida!");
    	}
    }
    
    

     

     /**
     * Setta $_immag come immagine associata all'utente
     * @param string $_immag
     *
     */  
    public function setImmagine($_immag)
    {
    	$this->immagine=$_immag;

    }
    



     /**
     * Setta $_email come email associata all'utente
     * @throws Exception Se $_email non rispetta le condizioni descritte in filter_var()
     * @param string $_email
     *
     */  
  
    public function setEmail($_email) 
    {
        if(filter_var($_email,FILTER_VALIDATE_EMAIL))
        {
            $this->email=$_email;
        }
        else
        {
            throw new Exception("Email non valida");
        }
    }
    
    

     /**
     * Setta $_nome come nome dell'utente
     * @throws Exception Se la stringa contenuta in $_nome non contiene solo caratteri alfanumerici ed ha lunghezza ]2,30[
     * @param string $_nome
     *
     */  
    public function setNome($_nome) {
		$pattern = '/^[[:alpha:] \']{2,30}$/';   
    	if (preg_match( $pattern, $_nome )) {
    		$this->nome = ucwords($_nome);
    	} else {
    		throw new Exception("Nome non valido!");
    	}
    }
    
    
    

     /**
     * Setta $_cognome come cognome dell'utente
     * @throws Exception Se la stringa contenuta in $_cognome non contiene solo caratteri alfanumerici ed ha lunghezza ]2,30[
     * @param string $_cognome
     *
     */  
    public function setCognome($_cognome){
    	$pattern = '/^[[:alpha:] \']{2,30}$/';
    	if (preg_match( $pattern, $_cognome )) {
    		$this->cognome = ucwords($_cognome);
    	} else {
    		throw new Exception("Cognome non valido!");
    	}
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
    * la funzione uniqid genera un codice casuale calcolato con i millisec attuali di 13 caratteri
    **/
    public function setCodiceAttivazione()
    {
    	if (!isset($this->codice_attivazione)) {
        	$this->codice_attivazione = uniqid();
    	}
    }
    
    



     /**
     * Setta $_stato_attivazione come lo stato di attivazione dell'utente
     * @param string $_stato_attivazione
     *
     */  
     public function setStatoAttivazione($_stato_attivazione)
    {
        $this->stato_attivazione=$_stato_attivazione;
    }
    
    



     /**
     * Setta $_tipo_utente come il tipo dell'utente
     * @throws Exception Se $_tipo_utente non assume valori validi [admin/normale]
     * @param string $_tipo_utente
     *
     */  
    public function setTipoUtente($_tipo_utente) {
    	if (($_tipo_utente == 'admin') || ($_tipo_utente == 'normale')) {
    		$this->tipo_utente = $_tipo_utente;
    	} else {
    		throw new Exception("Valore di tipo utente non valido");
    	}
    }
    
    

    
     /**
     * 
     * @return string Stringa contenente il nome dell'utente.
     *
     */
    public function getNome()
     {
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
     * @return string Stringa contenente il percorso relativo all'immagine definita dall'utente associata al suo account.
     *
     */
     public function getImmagine()
    {
        return $this->immagine;
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
