<?php

class ECartella{
	 
	 private $id;
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
		$pattern = '/[[:alpha:] \']{2,30}/';
	if(preg_match($pattern, $_nome)){
			$this->nome=$_nome;
		}
		else {
			throw new Exception("Nome Cartella Non Valido");
		}
	}
	
	public function setPosizione($_posizione){
		$pattern='/[0-9]{0,11}/';
		if(preg_match($pattern, $_posizione)){
			$this->posizione=$_posizione;
		}
		else {
			throw new Exception("Posizione Cartella Non Valida");
		}
	}
	
	public function setColore($_colore){
		$pattern='/^#?(([a-f]|[0-9]){3})?(([a-f]|[0-9]){3})?$/';
		if(preg_match($pattern, $_colore)){
			$this->colore=$_colore;
		}
		else {
			throw new Exception("Colore Cartella Non Valido!");
		}
	}
	
	public function setContenuto($_contenuto) {
		$this->contenuto = $_contenuto;
	}
	
	public function Push($_contenuto){
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