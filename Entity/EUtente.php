<?php
class EUtente
{
    private $username;
    private $password;
    private $immagine;
    private $nome;
    private $cognome;
    private $email;
    private $codice_attivazione;
    private $stato_attivazione;
    private $tipo_utente;


    public function __construct($_username,$_password,$_nome,$_cognome,$_immagine,$_email,$_tipo_utente)
    {
    	$this->setUsername($_username);
    	$this->setPassword($_password);
    	$this->setImmagine($_immagine);
    	$this->setNome($_nome);
    	$this->setCognome($_cognome);
    	$this->setEmail($_email);
    	$this->codice_attivazione=EUtente::generaCodice();
        $this->stato_attivazione=false;
        $this->setTipoUtente($_tipo_utente);

    }

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
    
    public function setPassword($_password) {
		$pattern = '/^[[:alnum:][:punct:]]{6,20}$/';   
    	if (preg_match( $pattern, $_password )) {
    		$this->password = md5($_password);
    	} else {
    		throw new Exception("Password non valida!");
    	}
    }
    
    public function setImmagine($_immag)
    {
    	$this->immagine=$_immag;

    }
    
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
    
    public function setNome($_nome) {
		$pattern = '/^[[:alpha:] \']{2,30}$/';   
    	if (preg_match( $pattern, $_nome )) {
    		$this->nome = ucwords($_nome);
    	} else {
    		throw new Exception("Nome non valido!");
    	}
    }
    
    public function setCognome($_cognome){
    	$pattern = '/^[[:alpha:] \']{2,30}$/';
    	if (preg_match( $pattern, $_cognome )) {
    		$this->cognome = ucwords($_cognome);
    	} else {
    		throw new Exception("Cognome non valido!");
    	}
    }
    /**
    * la funzione uniqid genera un codice casuale calcolato con i millisec attuali di 13 caratteri
    **/
    
    public static function generaCodice()
    {
        return uniqid();
    }
    
    public function setStato($_stato)
    {
        $this->stato_attivazione=$_stato;
    }
    
    public function setTipoUtente($_tipo_utente) {
    	if (($_tipo_utente == 'admin') || ($_tipo_utente == 'normale')) {
    		$this->tipo_utente = $_tipo_utente;
    	} else {
    		throw new Exception("Valore di tipo utente non valido");
    	}
    	
    }
    
    
    public function getNome()
    {
        return $this->nome;
    }
    
    public function getCognome()
    {
        return $this->cognome;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getImmagine()
    {
        return $this->immagine;
    }
    
    public function getPass()
    {
        return $this->password;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getCodice()
    {
        return $this->codice_attivazione;
    }
    
    public function isActive()
    {
        return $this->stato_attivazione;
    }
    
    public function getTipoUtente() {
    	return $this->tipo_utente;
    }
    
    
    
    

}



?>
