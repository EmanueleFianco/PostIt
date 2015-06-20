<?php
/**
 *
 * Classe CCartella che gestisce la cartella e il suo contenuto
 * @package Controller
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class CCartella {
	/**
	 * Smista le varie richieste delegando i metodi corrispondenti.
	 */
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
	/**
	 * Permette di creare una nuova cartella
	 */
	public function Nuova() {
		$fdb=USingleton::getInstance('Fdb');
		$fraccoglitoreCartelle=USingleton::getInstance('FRaccoglitore_cartelle');
		$fcartella=USingleton::getInstance('Fcartella');
		$VCartella=USingleton::getInstance('VCartella');
		$dati = $VCartella->getDati();
		$cartella = new ECartella($dati['nome'], $dati['posizione'], $dati['colore']);
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$fcartella->inserisciCartella($cartella,$dati['tipo'],$dati['amministratore']);
			$id = $query->lastInsertId();
			$max_posizione = $fraccoglitoreCartelle->getMaxPosizioneCartellaByUtente('emanuele.fianco@gmail.com');
			$max_posizione = $max_posizione[0]['max(posizione)'];
			$raccoglitore = array("id_cartella" => $id,
								  "email_utente" => 'emanuele.fianco@gmail.com',
								  "posizione" => $max_posizione);
			$fraccoglitoreCartelle->aggiungiAlRaccoglitoreNote($raccoglitore);
			$query->commit();
		} catch (Exception $e) {
			$query->rollback();
		}
		
	}
	/**
	 * Permette di cancellare una cartella esistente
	 */
	public function Cancella(){
		$fdb=USingleton::getInstance('Fdb');
		$fraccoglitoreCartelle=USingleton::getInstance('FRaccoglitore_cartelle');
		$fcartella=USingleton::getInstance('Fcartella');
		$VCartella=USingleton::getInstance('VCartella');
		$dati = $VCartella->getDati();
		$query=$fdb->getDb(); //Da introdurre i permessi per la cancellazione della cartella
		$query->beginTransaction();
		try {
			$select = $fraccoglitoreCartelle->getTupleByIdCartella($dati['id_cartella']);
			$fcartella->deleteCartella($dati);
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
	/**
	 * Permette di aggiornare il posizionamento delle cartelle
	 */
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
	/**
	 * Permette di spostare una nota da una cartella ad un'altra
	 */
	public function spostaNote() {
		$VNota=USingleton::getInstance('VNota');
		$dati = $VNota->getDati();
		$fnota=USingleton::getInstance('FNota');
		$fcartella=USingleton::getInstance('FCartella');
		$id_cartella_arrivo = $dati['id_cartella_arrivo'];
		$id_nota = $dati['id_nota'];
		$cartella = $fcartella->getCartellaById($id_cartella_arrivo);
		$nota = $fnota->getNotaById($id_nota);
		$tipo_nota = $nota[0]['tipo'];
		$tipo_cartella_arrivo = $cartella[0]['tipo']; 
		//if () Introdurre qui il controllo se è un promemoria o una nota (conpatibilità con la cartella di destinazione)
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
	/**
	 * Restituisce tutte le note appartenenti ad una determinata cartella
	 */
	public function getNote() {
		$VNota=USingleton::getInstance('VNota');
		$VCartella=USingleton::getInstance('VCartella');
		$dati = $VNota->getDati();
		$fdb=USingleton::getInstance('Fdb');
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_note');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$max = $fraccoglitore->getMaxPosizione('emanuele.fianco@gmail.com',$dati['id_cartella']);
			$max_posizione = $max[0]['posizione'];
			$max_id_nota = $max[0]['id_nota'];
			if (isset($dati['id_nota']) && $max_id_nota == $dati['id_nota']) {
				if ($max_posizione>=$dati['note_presenti']) {
					$posizione_finale = $max_posizione - $dati['note_presenti'];
					$posizione_iniziale = $posizione_finale - $dati['num_note'];
					$note=$fraccoglitore->getNoteByCartella($dati['id_cartella'],$posizione_finale,$posizione_iniziale);
				} else {
					$note = array();
				}				
			} else {
				$posizione_finale = $max_posizione;
				$posizione_iniziale = $posizione_finale - 12;
				if ($posizione_iniziale<0) {
					$posizione_iniziale = 0;
				}
				$note=$fraccoglitore->getNoteByCartella($dati['id_cartella'],$posizione_finale,$posizione_iniziale);
			}
			$query->commit();
			$VCartella->invia($note);
		} catch (Exception $e) {
			$query->rollback();
		}
	}
}
?>