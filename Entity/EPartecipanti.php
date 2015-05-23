<?php

public class EPartecipanti{
	
	private $username;
	private $email;
	private $immagine;
	
	
	public function __construct($_user,$_immag,$_email)
	{
		$this->setUser($_user);
		$this->setImmagine($_immag);
		$this->setEmail($_email);
	
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
	
	public function setImmagine($_immag)
	{
		if(filter_var($_immag, FILTER_VALIDATE_URL))
		{
			$this->immagine=$_immag;
		}
		else
		{
			throw new Exception("indirizzo immagine non valido");
		}
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
	
	/***********************************************************/
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
}

?>