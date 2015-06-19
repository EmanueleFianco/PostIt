<?php
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/FImmagine.php");
require_once("../Foundation/FRaccoglitore_cartelle.php");
require_once("../Entity/EImmagine.php");
require_once("../Foundation/Utility/USingleton.php");

class CCartella {
	
	public function __construct(){
	
	}
	
	public function mux(){
		$VNota=USingleton::getInstance('VCartella');
		switch ($VNota->getTask()) {
			case 'nuova':
				return $this->Nuova();
			case 'cancella':
				return $this->Cancella();
			case 'aggiornaPosizioni':
				return $this->AggiornaPosizioni();
			case 'sposta':
				return $this->spostaNote();
			case 'getNote':
				return $this->getNote();
		}
	}
	
	
	
	public function Nuova(){
		
		
	}
	public function Cancella(){
		$fdb=USingleton::getInstance('Fdb');
		$fraccoglitoreCartelle=USingleton::getInstance('FRaccoglitore_cartelle');
		$VCartella=USingleton::getInstance('VCartella');
		$dati = $VCartella->getDati();
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$select = $fraccoglitoreCartelle->getTupleByIdCartella($dati['id_cartella']);
			$fraccoglitoreCartelle->deleteRaccoglitore($dati);
			foreach ($select as $key => $valore) {
				$query1=$query->prepare("CALL AggiornaPosizioneCartelle(:pos,:email_delete)");
				$query1->bindParam(":pos",$valore['posizione']);
				$query1->bindParam(":email_delete",$valore['email_utente']);
				$query1->execute();
			}
			$query->commit();
		} catch (Exception $e) {
			$query->rollback();
		}
	}
	
	public function AggiornaPosizioni() {
		$VNota=USingleton::getInstance('VNota');
		$fdb=USingleton::getInstance('Fdb');
		$fraccoglitoreNote=USingleton::getInstance('FRaccoglitore_note');
		$dati = $VNota->getDati();
		$id_cartella=$dati["id_cartella"];
		$dati = $dati['posizioni'];
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$max_posizione = $fraccoglitoreNote->getMaxPosizioneNotaByCartellaEUtente('emanuele.fianco@gmail.com',$id_cartella);
			$max_posizione = $max_posizione[0]["max(posizione)"];
			foreach ($dati as $key => $value) {
				$value['posizione'] = $max_posizione - $value['posizione'];
				$value['email_utente'] = 'emanuele.fianco@gmail.com';
				$fraccoglitoreNote->updateRaccoglitore($value);
			}
			$query->commit();
		} catch (Exception $e) {
			$query->rollBack();
		}
	}
	
	public function spostaNote() {
		$VCartella=USingleton::getInstance('VCartella');
		$dati = $VCartella->getDati();
		$fnota=USingleton::getInstance('FNota');
		$fcartella=USingleton::getInstance('FCartella');
		$id_cartella_arrivo = $dati['id_cartella_arrivo'];
		$id_nota = $dati['id_nota'];
		$cartella = $fcartella->getCartellaById($id_cartella_arrivo);
		$nota = $fnota->getNotaById($id_nota);
		$tipo_nota = $nota[0]['tipo'];
		$tipo_cartella_arrivo = $cartella[0]['tipo'];
		//if ()
		$posizione_iniziale = $nota[0]['posizione'];
		$id_cartella_partenza = $nota[0]['id_cartella'];
		$parametri = array('id_cartella' => $id_cartella_arrivo,
						   'id' => $id_nota);
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$fnota->updateNota($parametri);
			$max_posizione_arrivo = $fnota->getMaxPosizioneNotaByCartella($id_cartella_arrivo);
			$max_posizione_arrivo = $max_posizione_arrivo[0]["max(posizione)"];
			$posizione_arrivo = $max_posizione_arrivo++;
			$parametri1 = array('posizione' => $posizione_arrivo,
					'id' => $id_nota);
			$fnota->updateNota($parametri1);
			$query1=$query->prepare("CALL AggiornaPosizioneNote(:pos,:cartella)");
			$query1->bindParam(":pos",$posizione_iniziale);
			$query1->bindParam(":cartella",$id_cartella_partenza);
			$query1->execute();
			$query->commit();
		} catch (Exception $e) {
			$query->rollback();
		}
	}
	
	public function getNote() {
		$VNota=USingleton::getInstance('VNota');
		$VCartella=USingleton::getInstance('VCartella');
		$dati = $VNota->getDati();
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_note');
		$max = $fraccoglitore->getMaxPosizioneNotaByCartellaEUtente('emanuele.fianco@gmail.com',$dati['id_cartella']);
		$max = $max[0]['max(posizione)'];
		$posizione_finale = $max - $dati['note_presenti'];
		$posizione_iniziale = $posizione_finale - $dati['num_note'];
		$note=$fraccoglitore->getNoteByCartella($dati['id_cartella'],$posizione_finale,$posizione_iniziale);
		$VCartella->invia($note);
	}
	
}

?>