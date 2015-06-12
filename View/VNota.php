<?php
require_once("../Foundation/Utility/USingleton.php");
require_once("View.php");

class VNota extends View {
	
	static function controllaInput($_chiave, $_valore) {
		if ($_chiave == 'posizioni') {
			foreach ($_valore as $key => $val) {
				$posizioni[] = $val['posizione'];
			}
			sort($posizioni);
			foreach ($posizioni as $key => $val) {
				if ($key != $val) {
					throw new Exception("Valori delle posizioni sbagliati");
				}
			}
		} elseif ($_chiave == 'nota') {
			foreach ($_valore as $key => $val) {
				self::controllaInput($key, $_valore);
			}						
		} else {
			$id = '/^[[:digit:]]{1,11}$/';
			$id_cartella = '/^[[:digit:]]{1,11}$/';
			$titolo = '/[.]{0,40}/';
			$testo = '/[.]{0,3000}/';
			$colore = '/^#([A-F]|[0-9]){6}$/';
			$tipo = '^(nota|promemoria)$/';
			$condiviso = '^(TRUE|FALSE)$/';
			//$ora_data_avviso = Da vedere in futuro con il lato client
			if (!preg_match($$_chiave, $_valore)) {
				throw new Exception(ucwords($_chiave)." errato!");
			}
			if($_chiave == "ultimo_a_modificare" && !filter_var($_chiave,FILTER_VALIDATE_EMAIL)) {
				throw new Exception(ucwords($_chiave)." errato!");
			}
		}
		
	}
	
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
	
	public function getDati(){
		unset($_REQUEST["lavoro"]);
		unset($_REQUEST["controller"]);
		foreach ($_REQUEST as $key => $valore) {
			self::controllaInput($key, $valore);
			$dati[$key] = $valore;
		}
		return $dati;
	}
	
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