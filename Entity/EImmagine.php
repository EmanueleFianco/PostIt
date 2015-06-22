<?php
/**
 *
 * Classe EImmagine che descrive l'entità Immagine
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class EImmagine {
	/**
	 * @var string $nome Nome dell'immagine
	 */	
	private $nome;
	/**
	 * @var int $size Dimensione dell'immagine in byte
	 */
	private $size;
	/**
	 * 
	 * @var string $type Mime-Type dell'immagine
	 */
	private $type;
	/**
	 * @var string $immagine_piccola Immagine piccola
	 */
	private $immagine_piccola;
	/**
	 * @var string $immagine_media Immagine media
	 */
	private $immagine_media;
	/**
	 * @var string $immagine_grande Immagine grande
	 */
	private $immagine_grande;
	/**
	 * @var string $immagine_originale Immagine originale
	 */
	private $immagine_originale;
	
	/**
	 * Costruisce l'oggetto immagine
	 * @param string $_nome
	 * @param int_type $_size
	 * @param string $_type
	 * @param string $_file_temp
	 */
	public function __construct($_nome,$_size,$_type,$_file_temp) {
		$this->setNome($_nome);
		$this->setSize($_size);
		$this->setType($_type);
		$this->setImmagine($_file_temp);
	}
	
	/**
	 * Setta il nome dell'immagine
	 * @param string $_nome
	 */
	public function setNome($_nome) {
			$this->nome = $_nome;
	}
	
	/**
	 * Setta la dimensione in byte dell'immagine
	 * @param int $_size
	 */
	public function setSize($_size) {
			$this->size = $_size;
	}
	/**
	 * Setta il Mime-Type passato per parametro
	 * @param string $_type 
	 */
	public function setType($_type) {
			$this->type = $_type;
	}
	
	/**
	 * Setta gli attributi dell'immagine e fa le dovute trasformazioni di dimensioni
	 * @param string $_file_temp Path temporaneo dell'immagine
	 */
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
	
	/**
	 * @return string Nome dell'immagine
	 */
	public function getNome() {
		return $this->nome;
	}
	
	/**
	 * @return int La grandezza dell'immagine in byte
	 */
	public function getSize() {
		return $this->size;
	}
	
	/**
	 * @return string Mime-Type dell'immagine
	 */
	public function getType() {
		return $this->type;
	}
	/**
	 * 
	 * @param string $_grandezza
	 * @return Ritorna l'immagine nella dimensione richiesta
	 */
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
	
	/**
	 *
	 * @return array Trasforma l'oggetto in una array associativo
	 *
	 */
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
?>