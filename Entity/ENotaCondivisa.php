<?php
class ENotaCondivisa extends ENota {
	private $ultimo_a_modificare;
	private $partecipanti = array();
	
	public function __construct($_titolo, $_testo, $_immagine, $_posizione, $_colore,EPartecipante $_ultimo_a_modificare, $_partecipanti) {
		parent::__construct($_titolo, $_testo, $_immagine, $_posizione, $_colore);
		$this->setUltimoAModificare($_ultimo_a_modificare);
		$this->setPartecipanti($_partecipanti);
	}
	
	public function setUltimoAModificare($_ultimo_a_modificare) {
		$this->ultimo_a_modificare = $_ultimo_a_modificare;
	}
	
	public function setPartecipanti($_partecipanti) {
		$this->partecipanti = $_partecipanti;
	}
	
	public function Push(EPartecipante $_partecipante) {
		$this->partecipanti[] = $_partecipante;
	}
	
	public function getUltimoAModificare() {
		return $this->ultimo_a_modificare;
	}
	
	public function getPartecipanti() {
		return $this->partecipanti;
	}
}
?>