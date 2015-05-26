<?php
class ENota {
	private $id;
	private $titolo;
	private $testo;
	private $immagine;
	private $posizione;
	private $colore;
	private $ultimo_a_modificare;
	
	public function __construct($_titolo, $_testo, $_immagine, $_posizione, $_colore,EPartecipante $_ultimo_a_modificare) {
		$this->setTitolo($_titolo);
		$this->setTesto($_testo);
		$this->setImmagine($_immagine);
		$this->setPosizione($_posizione);
		$this->setColore($_colore);
		$this->setUltimoAModificare($_ultimo_a_modificare);
	}
	
	public function setId($_id) {
		$this->id = $_id;
	}
	
	public function setTitolo($_titolo) {
		$pattern = '/[.]{0,40}/';   //Vedere se è meglio mettere $pattern = '/[[:alnum:]\']{0,40}/';
		if (trim($_titolo) == '') {
			$this->titolo = 'Titolo';
		} elseif (preg_match($pattern, $_titolo)) {
			$this->titolo = $_titolo;
		} else {
			throw new Exception("Titolo non valido!");
		}
	}
	
	public function setTesto($_testo) {
		$pattern = '/[.]{0,600}/';
		if (preg_match($pattern, $_testo)) {
			$this->testo = $_testo;
		} else {
			throw new Exception("Testo non valido!");
		}
	}

	public function setImmagine($_immagine) {
		$this->immagine = $_immagine;
	}

	public function setPosizione($_posizione) {
		$pattern = '/^[0-9]{0,11}$/';
		if (preg_match($pattern,$_posizione)) {
			$this->posizione = $_posizione;
		} else {
			throw new Exception("Posizione non valida!");
		}
	}
	
	public function setColore($_colore) {
	$pattern='/^#([a-f]|[0-9]){6}$/';
		if(preg_match($pattern, $_colore)){
			$this->colore=$_colore;
		} elseif (!trim($_colore)) {
			$this->colore = '#ff0000';						//SCEGLIERE IL COLORE DI DEFAULT
		} else {
			throw new Exception("Colore Cartella Non Valido!");
		}
	}
	
	public function setUltimoAModificare($_ultimo_a_modificare) {
		$this->ultimo_a_modificare = $_ultimo_a_modificare;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getTitolo() {
		return $this->titolo;
	}
	
	public function getTesto() {
		return $this->testo;
	}
	
	public function getImmagine() {
		return $this->immagine;
	}
	
	public function getColore() {
		return $this->colore;
	}
	
	public function getPosizione() {
		return $this->posizione;
	}
	
	public function getUltimoAModificare() {
		return $this->ultimo_a_modificare;
	}
}
?>