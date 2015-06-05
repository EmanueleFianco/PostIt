<?php
require_once("../Foundation/Utility/USingleton.php");

class VNota{
	
	public function getDati(){
		
		
		switch ($_POST["Tipo"]) {
			case 'Testo':
				$dati= array(
						"testo" => $_POST["Testo"],
						"id" => $_POST["Id"],
						
				);
			break;
	//----------------------------------------------------
			case 'Titolo':
				$dati= array(
						"titolo" => $_POST["Titolo"],
						"id" => $_POST["Id"],
				
				);
			break;
			
		
		}

		return $dati;
	}
	
	
	
	
	
}

?>