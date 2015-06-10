<?php
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/Utility/USingleton.php");

class Cnota {
	

	public function __construct(){
		
	}
	
	public function mux(){
		$VNota=USingleton::getInstance('VNota');
		switch ($VNota->getTask()) {
			case 'aggiorna':
				return $this->Aggiorna();
			case 'aggiornaPosizioni':
				return $this->AggiornaPosizioni();
            case 'cancella':
                return $this->Cancella();
			}
	}
	
	public function Aggiorna(){
		$VNota=USingleton::getInstance('VNota');
		$dati = $VNota->getDati();
		$fnota=USingleton::getInstance('FNota');
		$fnota->updateNota($dati);
	}
	
	public function AggiornaPosizioni() {
		$VNota=USingleton::getInstance('VNota');
		$fdb=USingleton::getInstance('Fdb');
		$fnota=USingleton::getInstance('FNota');
		$dati = $VNota->getDati();
		$dati = $dati['posizioni'];
		$max_posizione = $fnota->getMaxPosizioneNotaByCartella(136);
		$max_posizione = $max_posizione[0]["max(posizione)"];
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			foreach ($dati as $key => $value) {
				$value['posizione'] = $max_posizione - $value['posizione'];
				$fnota->updateNota($value);
			}
			$query->commit();
		} catch (Exception $e) {
			$query->rollBack();
		}
	}
        
    public function Cancella(){
        $VNota=USingleton::getInstance('VNota');
		$dati = $VNota->getDati();
		$fnota=USingleton::getInstance('FNota');
		$fcartella=USingleton::getInstance('FCartella');
		$cartella = $fcartella->getCartellaById($dati['id_cartella']);
		$nota = $fnota->getNotaById($dati['id_nota']);
		$nota_condivisa = $nota[0]['condiviso'];
		$nome_cartella = $cartella[0]['nome'];
		$tipo_cartella = $cartella[0]['tipo'];
		if ($nome_cartella == "Cestino" || $tipo_cartella == "Gruppo" || $nota_condivisa == TRUE) {
			unset($dati['id_cartella']);
			$fnota->deleteNota($dati);
		} else {
			$email_utente = $cartella[0]['email_utente'];
			$cestino = $fcartella->getCartellaByParametro($email_utente,"nome","Cestino");
			$id_cestino = $cestino[0]['id'];
			$dati = array("id_cartella" => $id_cestino,
						  "id" => $dati['id_nota']);
			$fnota->updateNota($dati);									
		}
    }
}

?>