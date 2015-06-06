<?php
require_once("../Foundation/Utility/USingleton.php");
require_once("View.php");

class VNota extends View {
	
	static function controllaInput($_chiave, $_valore) {
		$titolo = '/[.]{0,40}/';
		if (!preg_match($$_chiave, $_valore)) {
				throw new Exception(ucwords($_chiave)." errato!");
		}
	}
	
	public function getDati(){
		if (isset($_REQUEST["Tipo"])) {
			$tipo = $_REQUEST["Tipo"];
			self::controllaInput($tipo, $_REQUEST[ucwords($tipo)]);
			$dati = array($tipo => $_REQUEST[ucwords($tipo)],
						  "id" => $_REQUEST["Id"]);
		}
		
		/*switch ($_REQUEST["Tipo"]) {
			case 'testo':
				$dati = array("testo" => $_REQUEST["Testo"],
							  "id" => $_REQUEST["Id"]);
			break;
			case 'titolo':
				$dati = array("titolo" => $_REQUEST["Titolo"],
							  "id" => $_REQUEST["Id"]);
			break;
			case 'colore':
				$dati = array("colore" => $_REQUEST["Colore"],
							  "id" => $_REQUEST["Id"]);
			break;
			case 'tipo':
				$dati = array("tipo" => $_REQUEST["Tipo"],
							  "id" => $_REQUEST["Id"]);
			break;
			case 'condiviso':
				$dati = array("condiviso" => $_REQUEST["Condiviso"],
							  "id" => $_REQUEST["Id"]);
			break;
			case 'ultimo_a_modificare':
				$dati = array("ultimo_a_modificare" => $_REQUEST["Ultimo_a_modificare"],
							  "id" => $_REQUEST["Id"]);
			break;
			case 'ora_data_avviso':
				$dati = array("ora_data_avviso" => $_REQUEST["Ora_data_avviso"],
							  "id" => $_REQUEST["Id"]);
			break;				
		}*/

		return $dati;
	}
	
	
	
	
	
}

?>