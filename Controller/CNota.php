<?php
/**
 *
 * Classe CNota che gestisce le note
 * @package Controller
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class CNota {
	/**
	 * Smista le varie richieste delegando i metodi corrispondenti.
	 */
	public function mux(){
		$VNota=USingleton::getInstance('VNota');
		switch ($VNota->getTask()) {
			case 'nuova':
				return $this->Nuova();
			case 'aggiorna':
				return $this->Aggiorna();
            case 'cancella':
                return $this->Cancella();
            case 'setPromemoria':
            	return $this->setPromemoria();
            case 'focus':
            	return $this->focus();
            case 'prendiImmagine':
            	return $this->getImmagine();
            case 'upload':
            	return $this->aggiungiImmagine();
            
			}
	}
	/**
	 * Permette di creare una nuova nota
	 */
	public function Nuova() {
		$VNota=USingleton::getInstance('VNota');
		$dati = $VNota->getDati();
		$fraccoglitoreNote=USingleton::getInstance('FRaccoglitore_note');
		$fnota=USingleton::getInstance('FNota');
		$fcartella=USingleton::getInstance('FCartella');
		$fdb=USingleton::getInstance('Fdb');
		$session = USingleton::getInstance('USession');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$dati = $dati['nota'][0];
			$cartella = $fcartella->getCartellaById($dati['id_cartella']);
			if ($cartella[0]['tipo'] == "gruppo") {
				$dati['condiviso'] = TRUE;
			} else {
				$dati['condiviso'] = FALSE;
			}
			$dati['posizione'] = $this->getPosizioneOccupata($dati['id_cartella']);
			if ($dati['ora_data_avviso'] != "") {
				$format = 'Y-m-d H:i:s';
				$data = DateTime::createFromFormat($format,$dati['ora_data_avviso']);
				if (!$dati['condiviso']) {
					$CartellaPromemoria = $fcartella->getCartellaByNomeEAmministratore("Promemoria",$session->getValore("email"));
					$dati['id_cartella'] = $CartellaPromemoria[0]['id'];
					$dati['posizione'] = $this->getPosizioneOccupata($dati['id_cartella']);
					$nota = new EPromemoria($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'], $data);
				} else {
					$nota = new EPromemoriaCondiviso($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'],$session->getValore("email"), $data);
				}
			} else {
				if (!$dati['condiviso']) {
					$CartellaNote = $fcartella->getCartellaByNomeEAmministratore("Note",$session->getValore("email"));
					$dati['id_cartella'] = $CartellaNote[0]['id'];
					$dati['posizione'] = $this->getPosizioneOccupata($dati['id_cartella']);
					$nota = new ENota($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore']);
				} else {
					$nota = new ENotaCondivisa($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'],$session->getValore("email"));
				}
			}
			$fnota->inserisciNota($nota,$session->getValore("email"));
			$id = $query->lastInsertId();
			$parametri = array("id_nota" => $id,
							   "email_utente" => $session->getValore("email"),
							   "id_cartella" => $dati['id_cartella'],
							   "posizione" => $dati['posizione']);
			$fraccoglitoreNote->aggiungiAlRaccoglitoreNote($parametri);
			$query->commit();
		} catch (Exception $e) {
			$query->rollBack();
			throw new Exception($e->getMessage());
		}
		$dati_da_inviare= array('id' => $id);
		$VNota->invia($dati_da_inviare);
	}
	/**
	 * Permette di aggiornare lo stato di una nota
	 */
	public function Aggiorna(){
		$VNota=USingleton::getInstance('VNota');
		$dati = $VNota->getDati();
		$fnota=USingleton::getInstance('FNota');
		$fnota->updateNota($dati);
	}
	/**
	 * Permette di cancellare una nota e di mandarla nel cestino (se già si trova nel cestino si elimina
	 * totalmente) se non è condivisa altrimenti viene eliminata totalmente
	 */
    public function Cancella(){
        $VNota=USingleton::getInstance('VNota');
		$dati = $VNota->getDati();
		$fnota=USingleton::getInstance('FNota');
		$fcartella=USingleton::getInstance('FCartella');
		$fraccoglitore=USingleton::getInstance('FRaccoglitore_note');
		$session = USingleton::getInstance('USession');
		$fdb=USingleton::getInstance('Fdb');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$raccoglitore_note = $fraccoglitore->getRaccoglitoreByIdNota($dati['id_nota']);
			$cartella = $fcartella->getCartellaById($dati['id_cartella']);
			$nota = $fnota->getNotaById($dati['id_nota']);
			$id_nota = $nota[0]['id'];
			$nota_condivisa = $nota[0]['condiviso'];
			$creatore_nota = $nota[0]['creata_da'];
			$nome_cartella = $cartella[0]['nome'];
			$tipo_cartella = $cartella[0]['tipo'];
			$amministratore_cartella = $cartella[0]['amministratore'];
			$raccoglitore = $fraccoglitore->getNotaByIdEUtente($id_nota,$session->getValore("email"));
			$raccoglitore = $raccoglitore[0];
			if ($tipo_cartella == "gruppo") {
				if ($amministratore_cartella == $session->getValore("email")) {
					$fnota->deleteNota(array("id" => $id_nota));
					foreach ($raccoglitore_note as $key => $valore) {
						$this->aggiornaPosizioniRaccoglitore($valore['posizione'], $dati['id_cartella'], $valore['email_utente']);
					}
				}
			} elseif ($tipo_cartella == "privata" && $nota_condivisa == TRUE) {
				if ($amministratore_cartella == $session->getValore("email") && $creatore_nota != $session->getValore("email")) {
					$n_tuple = count($raccoglitore_note);
					if ($n_tuple == 2) {
						$aggiornamenti = array("condiviso" => FALSE,
											   "id" => $id_nota);
						$fnota->updateNota($aggiornamenti);
						$fraccoglitore->deleteRaccoglitore(array("id_nota" => $id_nota,"email_utente" => $session->getValore("email")));
					} else {
						$fraccoglitore->deleteRaccoglitore(array("id_nota" => $id_nota,"email_utente" => $session->getValore("email")));
					}
					$this->aggiornaPosizioniRaccoglitore($raccoglitore['posizione'], $dati['id_cartella']);
				} else {
					$fnota->deleteNota(array("id" => $id_nota));
					foreach ($raccoglitore_note as $key => $valore) {
						$this->aggiornaPosizioniRaccoglitore($valore['posizione'], $dati['id_cartella'], $valore['email_utente']);
					}
				}
			} elseif ($tipo_cartella == "privata" && $nota_condivisa == FALSE) {
				if ($nome_cartella == "Cestino") {
					$fnota->deleteNota(array("id" => $id_nota));
					$this->aggiornaPosizioniRaccoglitore($raccoglitore['posizione'], $dati['id_cartella']);
				} else {
					$cestino = $fcartella->getCartellaByNomeEAmministratore("Cestino",$session->getValore("email"));
					$id_cestino = $cestino[0]['id'];
					$aggiornamenti1 = array("id_cartella" => $id_cestino,"email_utente" => $session->getValore("email"),"id_nota" => $id_nota);
					$max_pos = $fraccoglitore->getMaxPosizioneNotaByCartellaEUtente($session->getValore("email"),$id_cestino);
					if ($max_pos[0]['max(posizione)']) {
						$max_pos = $max_pos[0]['max(posizione)'];
						$max_pos += 1;
					} else {
						$max_pos =0;
					}
					$aggiornamenti2 = array("posizione" => $max_pos,"email_utente" => $session->getValore("email"),"id_nota" => $id_nota);
					$fraccoglitore->updateRaccoglitore($aggiornamenti1);
					$fraccoglitore->updateRaccoglitore($aggiornamenti2);
					$this->aggiornaPosizioniRaccoglitore($raccoglitore['posizione'], $dati['id_cartella']);
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
    * Imposta la nota come un promemoria
    **/
    public function setPromemoria() {
    	$VNota=USingleton::getInstance('VNota');
    	$dati = $VNota->getDati();
    	$fnota=USingleton::getInstance('FNota');
    	$fcartella=USingleton::getInstance('FCartella');
    	$fraccoglitore=USingleton::getInstance('FRaccoglitore_note');
    	$session = USingleton::getInstance('USession');
    	$fdb=USingleton::getInstance('Fdb');
    	$aggiornamenti = array("tipo" => "promemoria",
    			  			   "id" => $dati['id']);
    	$aggiornamenti1 = array("ora_data_avviso" => $dati['ora_data_avviso'],
    						   "id" => $dati['id']);
    	$query=$fdb->getDb();
    	$query->beginTransaction();
    	try {
    		$nota = $fraccoglitore->getNotaByIdEUtente($dati['id'],$session->getValore("email"));
    		$nota = $nota[0];
    		$nota_vera = $fnota->getNotaById($dati['id']);
    		$nota_vera = $nota_vera[0];
    		$cartella = $fcartella->getCartellaById($nota['id_cartella']);
    		$cartella = $cartella[0];
    		$fnota->updateNota($aggiornamenti);
    		$fnota->updateNota($aggiornamenti1);
    		if ($nota_vera['condiviso'] == FALSE) {
    			$promemoria = $fcartella->getCartellaByNomeEAmministratore("Promemoria",$session->getValore("email"));
    			$promemoria = $promemoria[0];
    			$aggiornamenti2 = array("id_cartella" => $promemoria["id"],
    									"id_nota" => $dati['id']);
    			$max_posizione = $fraccoglitore->getMaxPosizioneNotaByCartellaEUtente($session->getValore("email"),$promemoria['id']);
    			$max_posizione = $max_posizione[0]['max(posizione)'];
    			if (isset($max_posizione)) {
    				$max_posizione += 1;
    			} else {
    				$max_posizione = 0;
    			}
    			$aggiornamenti3 = array("posizione" => $max_posizione,
    									"id_nota" => $dati['id']);
    			$fraccoglitore->updateRaccoglitore($aggiornamenti2);
    			$fraccoglitore->updateRaccoglitore($aggiornamenti3);
    			$this->aggiornaPosizioniRaccoglitore($nota['posizione'], $nota['id_cartella']);
    		} else {
    			$aggiornamenti4 = array("ultimo_a_modificare" => $session->getValore("email"),
    									"id" => $dati['id_nota']);
    			$fnota->updateNota($aggiornamenti4);
    		}
    		$query->commit();
    	} catch (Exception $e) {
    		$query->rollback();
    		throw new Exception($e->getMessage());
    	}
    }
    /**
    *Funzione utilizzata per vedere se qualcuno già sta modificando la nota e quindi nel caso inibire le modifiche a chi sta cercando di accederci per ultimo
    **/
    public function focus() {
    	$VNota=USingleton::getInstance('VNota');
    	$fnota=USingleton::getInstance('FNota');
    	$fraccoglitore=USingleton::getInstance('FRaccoglitore_note');
    	$shm=USingleton::getInstance('UShmSmart');
    	$session=USingleton::getInstance('USession');
    	$dati = $VNota->getDati();
    	$id = $dati['id'];
    	$raccoglitore = $fraccoglitore->getRaccoglitoreByIdNota($id);
    	$i=0;
    	while ($i<count($raccoglitore) && $i != -1) {
    		if ($raccoglitore[$i]['email_utente'] == $session->getValore("email")) {
    			$i=-1;
    		} else {
    			$i++;
    		}
    	}
    	if ($i == -1) {
    		$nota = $fnota->getNotaById($id);
    		$nota = $nota[0];
    		if ($dati['evento'] == "perso") {
    			if ($nota['condiviso'] == TRUE && $session->getValore("email") == $shm->get($id)) {
    				$shm->del($id);
    			}
    			$VNota->invia(array());
    		} else {
    			if ($nota['condiviso'] == TRUE) {
    				if ($shm->get($id)) {
    					$VNota->invia(array("error" => $shm->get($id)));
    				} else {
    					$shm->put($id,$session->getValore("email"));
    					$VNota->invia(array());
    				}
    			}
    			$VNota->invia(array());
    		}
    	} else {
    		throw new Exception("Permesso negato!");
    	}
    }
    
    /**
     * Restituisce un'immagine relativa ad una nota richiedente
     */
    public function getImmagine(){
    	$FImmagine=USingleton::getInstance('FImmagine');
    	$image = $FImmagine->getImmagineByNome($_REQUEST['file']);
    	$handle = fopen("./tmp/".$_REQUEST['file'],"w+");
    	fwrite($handle,$image[0]['immagine_originale']);
    	$file = "./tmp/".$_REQUEST['file'];
    	header('Content-Type: image/'.basename($image[0]['type']));
    	header('Content-Length: ' . $image[0]['size']);
    	echo file_get_contents($file);
    	unlink($file);
    }
    /**
     * Permette di aggiungere un'immagine relativa ad una nota
     */
    public function aggiungiImmagine(){ //Da vedere con il fatto di id_nota
    	$VNota=USingleton::getInstance('VNota');
    	$FImmagine=USingleton::getInstance('FImmagine');
    	$immagine = $VNota->getImmagine();
    	move_uploaded_file($_FILES['file']['tmp_name'], $immagine['tmp_name']);
    	$img = new EImmagine(basename($immagine['tmp_name']), $immagine['size'], $immagine['type'], $immagine['tmp_name']);
    	$FImmagine->inserisciImmagine($img);
    	$array = array('filelink' => 'Home.php?controller=nota&lavoro=prendiImmagine&file='.basename($immagine['tmp_name']));
    	unlink($immagine['tmp_name']);
    	return stripslashes(json_encode($array));
    }
    /**
    *Funzione che esegue l'aggiornamento delle posizioni all'interno del raccoglitore
    *@param int $_pos posizione all'interno del raccoglitore
    *@param int $_id_cartella
    *@param string $_email_utente 
    **/
    public function aggiornaPosizioniRaccoglitore($_pos,$_id_cartella,$_email_utente = NULL) {
    	$fdb=USingleton::getInstance('Fdb');
		$query=$fdb->getDb();
    	if ($_email_utente) {
    		$query1=$query->prepare("CALL AggiornaPosizioneNoteEmail(:pos,:cartella,:mail)");
    		$query1->bindParam(":pos",$_pos);
    		$query1->bindParam(":cartella",$_id_cartella);
    		$query1->bindParam(":mail",$_email_utente);
    	} else {
    		$query1=$query->prepare("CALL AggiornaPosizioneNote(:pos,:cartella)");
    		$query1->bindParam(":pos",$_pos);
    		$query1->bindParam(":cartella",$_id_cartella);
    	}
    	$query1->execute();
    }
    /**
    *Funzione che restituisce la posizione occupata dalla nota
    *@param int $_id_cartella
    *@return int posizione massima occupata
    **/
    public function getPosizioneOccupata($_id_cartella) {
    	$fraccoglitoreNote=USingleton::getInstance('FRaccoglitore_note');
    	$session=USingleton::getInstance('USession');
    	$max_posizione = $fraccoglitoreNote->getMaxPosizioneNotaByCartellaEUtente($session->getValore("email"),$_id_cartella);
    	if ($max_posizione) {
    		$max_posizione = $max_posizione[0]["max(posizione)"];
    		$max_posizione = $max_posizione +1;
    	} else {
    		$max_posizione = 0;
    	}
    	return $max_posizione;
    }
    
}
?>
