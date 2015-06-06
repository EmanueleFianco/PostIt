<?php
require_once("../Foundation/Utility/USingleton.php");
require_once("View.php");

class VNota extends View {
	
	public function getDati(){
		
		
		switch ($_REQUEST["Tipo"]) {
			case 'Testo':
				$dati= array(
						"testo" => $_REQUEST["Testo"],
						"id" => $_REQUEST["Id"],
						
				);
			break;
	//----------------------------------------------------
			case 'Titolo':
				$dati= array(
						"titolo" => $_REQUEST["Titolo"],
						"id" => $_REQUEST["Id"],
				
				);
			break;
			
		
		}

		return $dati;
	}
	
	
	
	
	
}

?>