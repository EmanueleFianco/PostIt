<?php

class EImmagine {
	
	private $nome;
	
	private $size;
	
	private $type;
	
	private $immagine;
	
	public function __construct($_nome,$_size,$_type,$_immagine) {
		$this->setNome($_nome);
		$this->setSize($_size);
		$this->setType($_type);
		$this->setImmagine($_immagine);
	}
	
	public function setNome($_nome) {
		$pattern='/[.]{0,100}/';
		if (preg_match($pattern,$_nome)) {
			$this->nome = $_nome;
		} else {
			throw new Exception("Nome immagine non valido!");
		}
	}
	
	public function setSize($_size) {
		if (is_int($_size) && $_size < 2097152) {   //2MB
			$this->size = $_size;
		} else {
			throw new Exception("Immagine troppo grande!");
		}
	}
	
	public function setType($_type) {
		$pattern='/^image\/(gif)|(jpeg)|(pjpeg)|(png)|(bmp)$/';
		if (preg_match($pattern,$_type)) {
			$this->type = $_type;
		} else {
			throw new Exception("Mime Type non accettato!");
		}
	}
	
	public function setImmagine($_immagine) {
		$this->immagine = $_immagine;
	}
	
	public function getNome() {
		return $this->nome;
	}
	
	public function getSize() {
		return $this->size;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getImmagine() {
		return $this->immagine;
	}
	
	public function getAsArray(){
		$result=array();
		foreach($this as $key => $value) {
			if (!is_array($value)) {
				$result[$key]= $value;
			}
		}
		return $result;
	}
}