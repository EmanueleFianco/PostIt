<?php

class EPartecipante{
	
	private $username;
	private $email;
	private $immagine;
	private $amministratore = FALSE;
	
	
	public function __construct($_user,$_immag,$_email, $_amministratore = NULL)
	{
		$this->setUsername($_user);
		$this->setImmagine($_immag);
		$this->setEmail($_email);
		if (isset($_amministratore)) {
			$this->setAmministratore($_amministratore);
		}

	}
	
	public function setUsername($_user)
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
	
	public function setAmministratore($_amministratore) {
		if (is_bool($_amministratore)) {
		$this->amministratore = $_amministratore;
		} else {
			throw new Exception("Valore di amministratore non valido");
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
	
	public function getAmministratore() {
		return $this->amministratore;
	}
}

?>