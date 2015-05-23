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


    public function __construct($_user,$_pass,$_nome,$_cognome,$_immagine,$_email)
    {
    	$this->setUser($_user);
    	$this->setPass($_pass);
    	$this->setImmagine($_immagine);
    	$this->setNome($_nome);
    	$this->setCognome($_cognome);
    	$this->setEmail($_email);
    	$this->codice_attivazione=EUtente::generaCodice();
        $this->stato_attivazione=false;

    }

    public function setUser($_user)
    {
    	$pattern='/^[[:alpha:]]{5,10}/';
        if(preg_match($pattern,$_user))
        {
            $this->username=$_user;
        }
        else
            {
	       throw new Exception("Username non valida");
            }
    }
    
    public function setPass($_pass)
    {
        $this->password=md5($_pass);
        
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
    
    public function setStato($_stato)
    {
        $this->stato_attivazione=$_stato;
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
