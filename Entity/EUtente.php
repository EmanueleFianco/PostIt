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


    public function __construct($user,$pass,$_nome,$_cognome,$immag,$_email)
    {
    	$this->setUser($user);
    	$this->setPass($pass);
    	$this->setImmagine($immag);
    	$this->setNome($_nome);
    	$this->setCognome($_cognome);
    	$this->setEmail($_email);
    	$this->codice_attivazione=EUtente::generaCodice();
        $this->stato_attivazione=false;

    }

    public function setUser($user)
    {
    	$pattern='/^[[:alpha:]]{5,10}/';
        if(preg_match($pattern,$user))
        {
            $this->username=$user;
        }
        else
            {
	       throw new Exception("Username non valida");
            }
    }
    
    public function setPass($pass)
    {
        $this->password=md5($pass);
        
    }
    
    public function setImmagine($immag)
    {
    	$this->immagine=$immag;
    }
    
    public function setEmail($_email) 
    {
        if(filter_var($_email,FILTER_VALIDATE_EMAIL))
        {
            $this->email=$_email;
        }
        else
        {
            throw new Exception("email non valida");
        }
    }
    
    public function setNome($_nome)
    {
        $this->nome=$_nome;
    }
    
    public function setCognome($_cognome)
    {
        $this->cognome=$_cognome;
    }
    /**
    * la funzione uniqid genera un codice casuale calcolato con i millisec attuali di 13 caratteri
    **/
    
    public static function generaCodice()
    {
        return uniqid();
    }
    
    public function setStato($stato)
    {
        $this->stato_attivazione=$stato;
    }
    
    
  //***************************************************************************//
    
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
    
    
    
    

}



?>