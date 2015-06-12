<?php

class EImmagine {
	
	private $id;
	
	private $nome;
	
	private $size;
	
	private $type;
	
	private $immagine_piccola;
	
	private $immagine_media;
	
	private $immagine_grande;
	
	private $immagine_originale;
	
	public function __construct($_nome,$_size,$_type,$_file_temp) {
		$this->setNome($_nome);
		$this->setSize($_size);
		$this->setType($_type);
		$this->setImmagine($_file_temp);
		$this->setId();
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
		$pattern='/^image\/(gif)|(jpeg)|(jpg)|(pjpeg)|(png)$/';
		if (preg_match($pattern,$_type)) {
			$this->type = $_type;
		} else {
			throw new Exception("Mime Type non accettato!");
		}
	}
	
	public function setImmagine($_file_temp) {
		$this->immagine_originale = file_get_contents($_file_temp);
		if ($this->type == "image/jpeg" || $this->type == "image/jpg" || $this->type == "image/pjpeg") {
			$src = imagecreatefromjpeg($_file_temp);
		} elseif ($this->type == "image/gif") {
			$src = imagecreatefromgif($_file_temp);
		} else {
			$src = imagecreatefrompng($_file_temp);			
		}
		list($width,$height)=getimagesize($_file_temp);
		$immagine_piccola=imagecreatetruecolor(70,70);
		$immagine_grande=imagecreatetruecolor(250,275);
		$immagine_media=imagecreatetruecolor(182,114);
		imagecopyresampled($immagine_piccola,$src,0,0,0,0,70,70,$width,$height);
		imagecopyresampled($immagine_grande,$src,0,0,0,0,250,275,$width,$height);
		imagecopyresampled($immagine_media,$src,0,0,0,0,182,114,$width,$height);
		$path="../tmp/";
		if ($this->type == "image/jpeg" || $this->type == "image/jpg" || $this->type == "image/pjpeg") {
			imagejpeg($immagine_piccola,$path."piccola_".$this->nome);
			imagejpeg($immagine_media,$path."media_".$this->nome);
			imagejpeg($immagine_grande,$path."grande_".$this->nome);
		} elseif ($this->type == "image/gif") {
			imagegif($immagine_piccola,$path."piccola_".$this->nome);
			imagegif($immagine_media,$path."media_".$this->nome);
			imagegif($immagine_grande,$path."grande_".$this->nome);
		} else {
			imagepng($immagine_piccola,$path."piccola_".$this->nome);
			imagepng($immagine_media,$path."media_".$this->nome);
			imagepng($immagine_grande,$path."grande_".$this->nome);
		}
		$this->immagine_piccola = file_get_contents($path."piccola_".$this->nome);
		$this->immagine_media = file_get_contents($path."media_".$this->nome);
		$this->immagine_grande = file_get_contents($path."grande_".$this->nome);
		unlink($path."piccola_".$this->nome);
		unlink($path."media_".$this->nome);
		unlink($path."grande_".$this->nome);
	}
	
	public function setId() {
		$this->id = md5($this->immagine_piccola);
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
	
	public function getImmagine($_grandezza) {
		if ($_grandezza == "piccola") {
			return $this->immagine_piccola;
		} elseif ($_grandezza == "media") {
			return $this->immagine_media;
		} elseif ($_grandezza == "grande") {
			return $this->immagine_grande;
		} else {
			return $this->immagine_originale;
		}
	}
	
	public function getId() {
		return $this->id;
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