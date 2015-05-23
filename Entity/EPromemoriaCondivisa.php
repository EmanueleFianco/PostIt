<?php
class EPromemoriaCondivisa extends EPromemoria {
	private $partecipanti = array();
	
	public function __construct($_titolo, $_testo, $_immagine, $_posizione, $_colore, $_ora_data_avviso, $_partecipanti) {
		parent::__construct($_titolo, $_testo, $_immagine, $_posizione, $_colore, $_ora_data_avviso);
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