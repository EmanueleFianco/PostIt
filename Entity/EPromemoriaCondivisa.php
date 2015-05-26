<?php
class EPromemoriaCondivisa extends EPromemoria {
	private $ultimo_a_modificare;
	private $partecipanti = array();
	
	public function __construct($_titolo, $_testo, $_immagine, $_posizione, $_colore,EPartecipante $_ultimo_a_modificare, $_ora_data_avviso, $_partecipanti) {
		parent::__construct($_titolo, $_testo, $_immagine, $_posizione, $_colore, $_ora_data_avviso);
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