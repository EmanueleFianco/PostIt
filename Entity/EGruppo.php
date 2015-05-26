<?php
class EGruppo extends ECartella {
	private $partecipanti = array();
	
	public function __construct($_nome,$_posizione,$_colore,$_contenuto,$_partecipanti) {
		parent::__construct($_nome,$_posizione,$_colore,$_contenuto);
		$this->setPartecipanti($_partecipanti);
	}
	
	public function setPartecipanti($_partecipanti) {
		$this->partecipanti = $_partecipanti;
	}
	
	public function Push(EPartecipante $_partecipante) {
		$this->partecipanti[] = $_partecipante;
	}
	
	
	public function getPartecipanti() {
		return $this->partecipanti;
	}
	
}