<?php
class ENotaCondivisa extends ENota {
	private $partecipanti = array();
	
	public function __construct($_titolo, $_testo, $_immagine, $_posizione, $_colore,EPartecipante $_ultimo_a_modificare, $_partecipanti) {
		parent::__construct($_titolo, $_testo, $_immagine, $_posizione, $_colore, $_ultimo_a_modificare);
		$this->setPartecipanti($_partecipanti);
	}
	
	public function setPartecipanti($_partecipanti) {
		$this->partecipanti = $_partecipanti;
	}
	
	public function Push(EPartecipante $_partecipanti) {
		$this->partecipanti[] = $_partecipanti;
	}

	
	public function getPartecipanti() {
		return $this->partecipanti;
	}
}
?>