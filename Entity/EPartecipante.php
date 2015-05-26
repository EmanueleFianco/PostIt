<?php

class EPartecipante{
	
	private $username;
	private $email;
	private $immagine;
	private $tipologia;
	
	
	public function __construct($_username,$_immagine,$_email, $_tipologia)
	{
		$this->setUsername($_username);
		$this->setImmagine($_immagine);
		$this->setEmail($_email);
		$this->setTipologia($_tipologia);

	}
	
	public function setUsername($_username)
	{
		$pattern='/^[[:alnum:]]{5,15}$/';
		if(preg_match($pattern,$_username))
		{
			$this->username=$_username;
		}
		else
		{
			throw new Exception("Username non valida");
		}
	}
	
	public function setImmagine($_immagine)
	{
			$this->immagine=$_immagine;
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
	
	public function setTipologia($_tipologia) {
		if (($_tipologia == 'admin') || ($_tipologia == 'partecipante')) {
		$this->tipologia = $_tipologia;
		} else {
			throw new Exception("Valore di tipologia non valido");
		}
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getImmagine()
	{
		return $this->immagine;
	}
	
	public function getTipologia() {
		return $this->tipologia;
	}
}
?>