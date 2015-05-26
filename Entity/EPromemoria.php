<?php
class EPromemoria extends ENota {
	
	private $ora_data_avviso;
	
	public function __construct($_titolo, $_testo, $_immagine, $_posizione, $_colore,EPartecipante $_ultimo_a_modificare, $_ora_data_avviso) {
		parent::__construct($_titolo, $_testo, $_immagine, $_posizione, $_colore, $_ultimo_a_modificare);
		$this->setOraDataAvviso($_ora_data_avviso);
	}
	
	public function setOraDataAvviso(DateTime $_ora_data_avviso) {
		$this->ora_data_avviso = $_ora_data_avviso;
	}
	
	public function getOraDataAvviso() {
		return $this->ora_data_avviso;
	}
}