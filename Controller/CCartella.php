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
		$VCartella=USingleton::getInstance('VCartella');
		switch ($VCartella->getTask()) {
			case 'nuova':
				return $this->Nuova();
			case 'cancella':
				return $this->Cancella();
			case 'aggiornaPosizioni':
				return $this->AggiornaPosizioni();
			case 'spostaNote':
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
		$fcartella=USingleton::getInstance('FCartella');
		$VCartella=USingleton::getInstance('VCartella');
		$session = USingleton::getInstance('USession');
		$dati = $VCartella->getDati();
		$cartella = new ECartella($dati['nome'], $dati['posizione'], $dati['colore']);
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$fcartella->inserisciCartella($cartella,$dati['tipo'],$session->getValore["email"]);
			$id = $query->lastInsertId();
			$max_posizione = $fraccoglitoreCartelle->getMaxPosizioneCartellaByUtente($session->getValore("email"));
			if (isset($max[0]['max(posizione)'])) {
				$max_posizione = $max[0]['max(posizione)']+1;
			} else {
				$max_posizione = 0;
			}
			$raccoglitore = array("id_cartella" => $id,
								  "email_utente" => $session->getValore("email"),
								  "posizione" => $max_posizione);
			$fraccoglitoreCartelle->aggiungiAlRaccoglitoreNote($raccoglitore);
			$query->commit();
		} catch (Exception $e) {
			$query->rollback();
			throw new Exception($e->getMessage());
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
		$session = USingleton::getInstance('USession');
		$dati = $VCartella->getDati();
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$cartella_da_cancellare = $fcartella->getCartellaById($dati['id_cartella']);
			if (isset($cartella_da_cancellare) && $cartella_da_cancellare[0]['amministratore'] == $session->getValore("email")) { //in seguito da sostituire con la sessione
				$select = $fraccoglitoreCartelle->getTupleByIdCartella($dati['id_cartella']);
				$fcartella->deleteCartella($dati);
				foreach ($select as $key => $valore) {
					$query1=$query->prepare("CALL AggiornaPosizioneCartelle(:pos,:email_delete)");
					$query1->bindParam(":pos",$valore['posizione']);
					$query1->bindParam(":email_delete",$valore['email_utente']);
					$query1->execute();
				}
				$query->commit();
			} else {
				throw new Exception("Permessi insufficienti");
			}
		} catch (Exception $e) {
			$query->rollback();
			throw new Exception($e->getMessage());
		}
	}
	/**
	 * Permette di aggiornare il posizionamento delle cartelle
	 */
	public function AggiornaPosizioni() {
		$VNota=USingleton::getInstance('VNota');
		$fdb=USingleton::getInstance('Fdb');
		$fraccoglitoreNote=USingleton::getInstance('FRaccoglitore_note');
		$session = USingleton::getInstance('USession');
		$dati = $VNota->getDati();
		$id_cartella=$dati["id_cartella"];
		$dati = $dati['posizioni'];
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$max_posizione = $fraccoglitoreNote->getMaxPosizioneNotaByCartellaEUtente($session->getValore("email"),$id_cartella);
			if (isset($max_posizione[0]["max(posizione)"])) {
				$max_posizione = $max_posizione[0]["max(posizione)"];
				foreach ($dati as $key => $value) {
					$parametri['posizione'] = $max_posizione - $value['posizione'];
					$parametri['email_utente'] = $session->getValore("email");
					$parametri['id_nota'] = $value['id_nota'];
					$fraccoglitoreNote->updateRaccoglitore($parametri);
				}
			} else {
				throw new Exception("Cartella vuota");
			}
			$query->commit();
		} catch (Exception $e) {
			$query->rollBack();
			throw new Exception($e->getMessage());
		}
	}
	/**
	 * Permette di spostare una nota da una cartella ad un'altra
	 */
	public function spostaNote() {
		$VNota=USingleton::getInstance('VNota');
		$session=USingleton::getInstance('USession');
		$dati = $VNota->getDati();
		$cnota=USingleton::getInstance('CNota');
		$fnota=USingleton::getInstance('FNota');
		$fdb=USingleton::getInstance('Fdb');
		$fcartella=USingleton::getInstance('FCartella');
		$fraccoglitore_note=USingleton::getInstance('FRaccoglitore_note');
		$fraccoglitore_cartelle=USingleton::getInstance('FRaccoglitore_cartelle');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$cartella_partenza = $fcartella->getCartellaById($dati['partenza']);
			$cartella_partenza = $cartella_partenza[0];
			$cartella_destinazione = $fcartella->getCartellaById($dati['destinazione']);
			$cartella_destinazione = $cartella_destinazione[0];
			$nota = $fnota->getNotaById($dati['id_nota']);
			$nota = $nota[0];
			if ($cartella_partenza['tipo'] == "gruppo") {
				throw new Exception("Impossibile spostare da gruppo");
			} elseif ($cartella_destinazione['tipo'] == "gruppo" && $nota['condiviso']) {
				throw new Exception("Impossibile spostare una nota condivisa in un gruppo");
			} elseif ($cartella_partenza['amministratore'] == $session->getValore("email")) {
				if (($cartella_destinazione['nome'] == "Promemoria" && $nota['tipo'] == "nota") || ($cartella_destinazione['nome'] == "Nota" && $nota['tipo'] == "promemoria")) {
					throw new Exception("Non puoi spostare una nota/promemoria nella cartella promemoria/note");
				} else {
					$pos_iniziale = $fraccoglitore_note->getNotaByIdEUtente($nota['id'],$session->getValore("email"));
					$raccoglitore_cartella = $fraccoglitore_cartelle->getTupleByIdCartella($cartella_destinazione['id']);
					if ($cartella_destinazione['tipo'] == "gruppo") {
						$agg = array("condiviso" => TRUE,"id" => $nota['id']);
						$fnota->UpdateNota($agg);
						$max_pos = $this->cercaNelRaccoglitoreMaxPosizione($raccoglitore_cartella);
						foreach ($max_pos as $key => $valore) {
							$email = array_keys($valore);
							$email = $email[0];
							$aggiunta = array("id_nota" => $nota['id'],
											  "email_utente" => $email,
											  "id_cartella" => $cartella_destinazione['id'],
											  "posizione" => $valore[$email]);
							$fraccoglitore_note->aggiungiAlRaccoglitoreNote($aggiunta);
						}
					}
					$max_pos = $this->cercaNelRaccoglitoreMaxPosizione($raccoglitore_cartella);
					$chiave = $max_pos[0];
					$chiave = array_keys($chiave);
					$chiave = $chiave[0];
					$pos = $max_pos[0][$chiave];
					if ($cartella_destinazione['tipo'] == "gruppo") {
						$pos = $pos -1;
					}
					$aggiornamento1 = array("posizione" => $pos,"id_nota" => $nota['id'],"email_utente" => $session->getValore("email"));
					$fraccoglitore_note->updateRaccoglitore($aggiornamento1);
					$aggiornamento = array("id_cartella" => $cartella_destinazione['id'],"id_nota" => $nota['id'],"email_utente" => $session->getValore("email"));
					$fraccoglitore_note->updateRaccoglitore($aggiornamento);
					$cnota->aggiornaPosizioniRaccoglitore($pos_iniziale,$cartella_partenza['id'],$session->getValore("email"));
				}
			} else {
				throw new Exception("Permesso Negato");
			}
			$query->commit();
		} catch (Exception $e) {
			$query->rollback();
			throw new Exception($e->getMessage());
		}
	}
	/**
	 * Restituisce tutte le note appartenenti ad una determinata cartella
	 */
	public function getNote() {
		$VNota=USingleton::getInstance('VNota');
		$VCartella=USingleton::getInstance('VCartella');
		$fcartella=USingleton::getInstance('FCartella');
		$dati = $VNota->getDati();
		$fdb=USingleton::getInstance('Fdb');
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_note');
		$session = USingleton::getInstance('USession');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$max = $fraccoglitore->getMaxPosizione($session->getValore("email"),$dati['id_cartella']);
			if (isset($max[0]['posizione'])) {
				$max_posizione = $max[0]['posizione'];
				$posizione_iniziale = $max_posizione - $dati['note_presenti'];
				$note = $fraccoglitore->getNoteByCartella($dati['id_cartella'],$session->getValore("email"),$max_posizione,$posizione_iniziale);
				$sbagliato = FALSE;
				if (isset($dati['posizioni'])) {
					$note_arrivate = $dati['posizioni'];
					$i = 0;
					if (count($note_arrivate) != count($note)) {
						$sbagliato = TRUE;
					} else {
						$sbagliato = FALSE;
					}
					while ($sbagliato == FALSE && $i<count($note)) {
						foreach ($note_arrivate as $key => $valore) {
							$posizione_relativa = $max_posizione - $valore['posizione'];
							$posizioni[$posizione_relativa] = $valore['id'];
						}
						krsort($posizioni);
						foreach ($posizioni as $key => $val) {
							if ($note[$i]['posizione'] != $key || $note[$i]['id_nota'] != $val) {
								$sbagliato = TRUE;
							}
							$i+=1;
						}
					}
				}
				if ($sbagliato) {
					$posizione_finale = $max_posizione;
					$posizione_iniziale = $posizione_finale - 12;
					if ($posizione_iniziale<0) {
						$posizione_iniziale = -1;
					}
					$note=$fraccoglitore->getNoteByCartella($dati['id_cartella'],$session->getValore("email"),$posizione_finale,$posizione_iniziale);
					foreach ($note as $key => $value) {
						$note[$key]["partecipanti"] = $this->inviaPartecipanti($value['id_nota']);
					}
				} else {
					if ($max_posizione+1>$dati['note_presenti']) {
						$posizione_finale = $max_posizione - $dati['note_presenti'];
						$posizione_iniziale = $posizione_finale - $dati['num_note'];
						$note=$fraccoglitore->getNoteByCartella($dati['id_cartella'],$session->getValore("email"),$posizione_finale,$posizione_iniziale);
						foreach ($note as $key => $value) {
							$note[$key]["partecipanti"] = $this->inviaPartecipanti($value['id_nota']);
						}
					} else {
						$note = array();
					}
				}
			} else {
				$note = array();
			}
			$query->commit();
			$VCartella->invia($note);
		} catch (Exception $e) {
			$query->rollback();
			throw new Exception($e->getMessage());
		}
	}
	/**
	*Funzione che restituisce un array contenente i partecipanti alla nota con Id passato per parametro
	*@param int $_id_nota Id della nota
	*@return array Array che contiene i partecipanti 
	**/
	public function inviaPartecipanti($_id_nota) {
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_note');
		$session = USingleton::getInstance('USession');
		$futente=USingleton::getInstance('FUtente');
		$raccoglitore = $fraccoglitore->getRaccoglitoreByIdNota($_id_nota);
		$condiviso = array();
		$scala = FALSE;
		foreach ($raccoglitore as $key => $valore) {
			if ($valore['email_utente'] != $session->getValore("email")) {
				$utente = $futente->getUtenteByEmail($valore['email_utente']);
				$utente = $utente[0];
				if ($scala) {
					$condiviso[$key-1]["email"] = $valore['email_utente'];
					$condiviso[$key-1]["path"] = "Home.php?controller=utente&lavoro=getImmagine&file=".$utente['id_immagine'];
				} else {
					$condiviso[$key]["email"] = $valore['email_utente'];
					$condiviso[$key]["path"] = "Home.php?controller=utente&lavoro=getImmagine&file=".$utente['id_immagine'];
				}
			} else {
				$scala = TRUE;
			}
		}
		return $condiviso;
	}
	/**
	*Funzione che restituisce la massima posizione della cartella all'interno del raccoglitore
	*@param array $_raccoglitore
	*@return array
	**/
	public function cercaNelRaccoglitoreMaxPosizione($_raccoglitore) {
		$session=USingleton::getInstance('USession');
		$fraccoglitore = USingleton::getInstance('FRaccoglitore_note');
		$scala = FALSE;
		foreach ($_raccoglitore as $key => $valore) {
			if ($valore['email_utente'] != $session->getValore("email")) {
				$max_cartella_destinazione = $fraccoglitore->getMaxPosizioneNotaByCartellaEUtente($valore['email_utente'],$valore['id_cartella']);
				if (!is_null($max_cartella_destinazione[0]["max(posizione)"])) {
					$max_cartella_destinazione = $max_cartella_destinazione[0]['max(posizione)']+1;
				} else {
					$max_cartella_destinazione = 0;
				}
				if ($scala) {
					$ritorno[$key-1] = array($valore['email_utente'] => $max_cartella_destinazione);
				} else {
					$ritorno[$key] = array($valore['email_utente'] => $max_cartella_destinazione);
				}
			} else {
				$scala = TRUE;
			}
		}	
		return $ritorno;
	}
			
}
?>