<?php
class ENotaCondivisa extends ENota {
	private $amministratore;
	private $partecipanti = array();
	
	public function __construct($_titolo, $_testo, $_immagine, $_posizione, $_colore,Epartecipanti $_amministratore, $_partecipanti) {
		parent::__construct($_titolo, $_testo, $_immagine, $_posizione, $_colore);
		$this->setAmministratore($_amministratore);
		$this->setPartecipanti($_partecipanti);
	}
	
	public function setAmministratore(EPartecipanti $_amministratore) {
		$this->amministratore = $_amministratore;
	}
	
	public function setPartecipanti($_partecipanti) {
		$this->partecipanti = $_partecipanti;
	}
	
	public function Push(EPartecipanti $_partecipanti) {
		$this->partecipanti[] = $_partecipanti;
	}
	
	public function getAmministratore() {
		return $this->amministratore;
	}
	
	public function getPartecipanti() {
		return $this->partecipanti;
	}
}
?>