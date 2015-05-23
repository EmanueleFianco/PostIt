<?php

class EPartecipante{
	
	private $username;
	private $email;
	private $immagine;
	private $amministratore;
	
	
	public function __construct($_username,$_immagine,$_email, $_amministratore = FALSE)
	{
		$this->setUsername($_username);
		$this->setImmagine($_immagine);
		$this->setEmail($_email);
		if (isset($_amministratore)) {
			$this->setAmministratore($_amministratore);
		}

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
	
	public function setAmministratore($_amministratore) {
		if (is_bool($_amministratore)) {
		$this->amministratore = $_amministratore;
		} else {
			throw new Exception("Valore di amministratore non valido");
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
	
	public function getAmministratore() {
		return $this->amministratore;
	}
}

?>