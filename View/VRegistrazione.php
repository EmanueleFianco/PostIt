<?php
class VRegistrazione extends View{
	/**
	 * Controlla i dati arrivati
	 * @param string $_chiave Chiave da controllare
	 * @param string $_valore Valore associato alla chiave
	 * @throws Exception $e Se i parametri non sono conformi alle aspettative
	 */
	static function controllaInput($_chiave, $_valore) {
		if($_chiave == "email") {
			if (!filter_var($_valore,FILTER_VALIDATE_EMAIL)) {
				throw new Exception(ucwords($_chiave)." errato!");
			}
		} else {
			$nome = '/^[[:alpha:] \']{2,30}$/';
			$cognome = '/^[[:alpha:] \']{2,30}$/';
			$username = '/^[[:alnum:]_\.-]{5,15}$/';
			$password = '/^[[:alnum:][:punct:]]{6,20}$/';
			$repassword = $password;
			$cod_attivazione = '/^[[:alnum:]]{13}$/'; 
			if (!preg_match($$_chiave, $_valore)) {
				throw new Exception(ucwords($_chiave)." errato!");
			}
		}
	}
	/**
	 * Controlla l'immagine arrivata
	 * @param array $_immagine Array contenente tutti i campi dell'immagine
	 * @throws Exception $e Se i parametri non sono conformi alle aspettative
	 */
	static function controllaImmagine($_immagine) {
		if (is_int($_immagine['size']) && $_immagine['size'] < 2097152) {
			$type = '/^image\/(gif)|(jpeg)|(jpg)|(pjpeg)|(png)$/';
			if (!preg_match($type,$_immagine['type'])) {
				throw new Exception("Mime Type non accettato!");
			}
		} else {
			throw new Exception("Immagine troppo grande!");
		}
	}
	/**
	 * Ritorna l'immagine appena ricevuta
	 */
	public function getImmagine() {
		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
		$dir = "../tmp/";
		$immagine['size'] = $_FILES['file']['size'];
		$immagine['type'] = $_FILES['file']['type'];
		$type = substr($immagine['type'],6);
		$filename = md5(date('YmdHis')).'.'.$type;
		self::controllaImmagine($immagine);
		$immagine['tmp_name'] = $dir.$filename;
		return $immagine;
	}
}
?>