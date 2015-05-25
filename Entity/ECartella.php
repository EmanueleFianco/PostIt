<?php

class ECartella{
	 
	 private $id; //Da accertarsi che serve realmente nel dominio e non solo nel db
	 private $nome;
	 private $posizione;
	 private $colore;
	 private $contenuto = array();
	
	
	public function __construct($_id,$_nome,$_posizione,$_colore,$_contenuto){
	   $this->setId($_id);
	   $this->setNome($_nome);
	   $this->setPosizione($_posizione);
	   $this->setColore($_colore);
	   $this->setContenuto($_contenuto);
	
	}
	
	public function setId($_id){
			$this->id=$_id;
	}
	
	public function setNome($_nome){
		$_nome = trim($_nome);
		$pattern = '/[[:alpha:] \']{2,30}/';
	if(preg_match($pattern, $_nome)){
			$this->nome=$_nome;
		}
		else {
			throw new Exception("Nome Cartella Non Valido");
		}
	}
	
	public function setPosizione($_posizione){
		$pattern='/^[0-9]{0,11}$/';
		if(preg_match($pattern, $_posizione)){
			$this->posizione=$_posizione;
		}
		else {
			throw new Exception("Posizione cartella non valida");
		}
	}
	
	public function setColore($_colore){
		$pattern='/^#([a-f]|[0-9]){6}$/';
		if(preg_match($pattern, $_colore)){
			$this->colore=$_colore;
		} elseif (!trim($_colore)) {
			$this->colore = '#ff0000';						//SCEGLIERE IL COLORE DI DEFAULT
		} else {
			throw new Exception("Colore cartella non valido!");
		}
	}
	
	public function setContenuto($_contenuto) {
		$this->contenuto = $_contenuto;
	}
	
	public function Push(ENota $_contenuto){
		$this->contenuto[]=$_contenuto;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function getPosizione(){
		return $this->posizione;
	}
	
	public function getColore(){
		return $this->colore;
	}
	
	public function getContenuto(){
		return $this->contenuto;
	}
}
?>