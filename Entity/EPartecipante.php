<?php
/**
 *
 * Classe Partecipante che descrive l'entità Partecipante
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class EPartecipante{
	/**
	*
	* @var string $username Username del partecipante [minimo 5, massimo 15 caratteri alfanumerici]
	*
	*/
	private $username;
	/**
	*
	* @var string $email Email del partecipante
	*
	*/
	private $email;
	/**
	*
	* @var string $immagine percorso relativo all'immagine associata al partecipante
	*
	*/
	private $immagine;
	/**
	*
	* @var string $tipologia Tipologia del partecipante [Valori ammissibili admin/partecipante]
	*
	*/
	private $tipologia;
	
	/**
    * Costruttore di Partecipante
    *
    * @throws Exception Se i parametri non sono tutte stringhe formattate secondo le regole descritte in SetUsername(), SetEmail(),SetTipologia(). 
    * @param string $_username
    * @param string $_immagine
    * @param string $_email
    * @param string $_tipologia
    *
    */
	public function __construct($_username,$_immagine,$_email, $_tipologia)
	{
		$this->setUsername($_username);
		$this->setImmagine($_immagine);
		$this->setEmail($_email);
		$this->setTipologia($_tipologia);

	}
	

	/**
     * Setta $_username come username del partecipante.
     * @throws Exception Se la stringa contenuta in $_username non contiene solo caratteri alfanumerici ed ha lunghezza ]5,15[
     * @param string $_username
     *
     */
	
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
	
	/**
     * Setta $_immagine come percorso relativo all'immagine associata al partecipante.
     * @param string $_immagine
     *
     */
	public function setImmagine($_immagine)
	{
			$this->immagine=$_immagine;
	}
	
	
	 /**
     * Setta $_email come email del partecipante.
     * @throws Exception Se la stringa contenuta in $_email non verifica le condizioni descritte in filter_var().
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
     * Setta $_tipologia come tipologia del partecipante.
     * @throws Exception Se la stringa contenuta in $_username non assume valori validi [admin/partecipante]
     * @param string $_tipologia
     *
     */
	public function setTipologia($_tipologia) {
		if (($_tipologia == 'admin') || ($_tipologia == 'partecipante')) {
		$this->tipologia = $_tipologia;
		} else {
			throw new Exception("Valore di tipologia non valido");
		}
	}
	 /**
     * 
     * @return string Stringa contenente l'username del partecipante.
     *
     */
	public function getUsername()
	{
		return $this->username;
	}
	 /**
     * 
     * @return string Stringa contenente l'email del partecipante.
     *
     */
	public function getEmail()
	{
		return $this->email;
	}
	 /**
     * 
     * @return string Stringa contenente il percorso relativo dell'immagine associata al partecipante
     *
     */
	public function getImmagine()
	{
		return $this->immagine;
	}
	 /**
     * 
     * @return string Stringa contenente la tipologia di partecipante
     *
     */
	public function getTipologia() {
		return $this->tipologia;
	}
}
?>