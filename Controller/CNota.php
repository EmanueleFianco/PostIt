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
		$fdb=USingleton::getInstance('Fdb');
		$session = USingleton::getInstance('USession');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$dati = $dati['nota'][0];
			$max_posizione = $fraccoglitoreNote->getMaxPosizioneNotaByCartellaEUtente($session->getValore("email"),$dati["id_cartella"]);
			$max_posizione = $max_posizione[0]["max(posizione)"];
			if (isset($max_posizione)) {
				$max_posizione += 1;
			} else {
				$max_posizione = 0;
			}
			$dati['posizione'] = $max_posizione;
			if ($dati['ora_data_avviso']) {
				if ($dati['ultimo_a_modificare']) {
					$nota = new EPromemoriaCondiviso($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'], $dati['ultimo_a_modificare'], $dati['ora_data_avviso'], $dati['immagine'] = NULL);
				} else {
					$nota = new EPromemoria($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'], $dati['ora_data_avviso']);
				}
			} else {
				if ($dati['ultimo_a_modificare']) {
					$nota = new ENotaCondivisa($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'], $dati['ultimo_a_modificare'], $dati['immagine'] = NULL);
				} else {
					$nota = new ENota($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore']);
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
			$cartella = $fcartella->getCartellaById($dati['id_cartella']);
			$nota = $fnota->getNotaById($dati['id_nota']);
			$id_nota = $nota[0]['id'];
			$nota_condivisa = $nota[0]['condiviso'];
			$creatore_nota = $nota[0]['creata_da'];
			$nome_cartella = $cartella[0]['nome'];
			$tipo_cartella = $cartella[0]['tipo'];
			$amministratore_cartella = $cartella[0]['amministratore'];
			if ($tipo_cartella == "gruppo") {
				if ($amministratore_cartella == $session->getValore("email")) {
					unset($dati['id_cartella']);
					$fnota->deleteNota($dati);
					$query1=$query->prepare("CALL AggiornaPosizioneNote(:pos,:cartella)");
					$query1->bindParam(":pos",$nota['posizione']);
					$query1->bindParam(":cartella",$nota['id_cartella']);
					$query1->execute();
				}
			} elseif ($tipo_cartella == "privata" && $nota_condivisa == TRUE) {
				if ($amministratore_cartella == $session->getValore("email") && $creatore_nota != $session->getValore("email")) {
					$raccoglitore_note = $fraccoglitore->getRaccoglitoreByIdNota($id_nota);
					$n_tuple = count($raccoglitore_note);
					if ($n_tuple == 2) {
						$aggiornamenti = array("condiviso" => FALSE,
											   "id" => $id_nota);
						$fnota->updateNota($aggiornamenti);
						$raccoglitore_note->deleteRaccoglitore(array("id_nota" => $id_nota,"email_utente" => $session->getValore("email")));
					} else {
						$raccoglitore_note->deleteRaccoglitore(array("id_nota" => $id_nota,"email_utente" => $session->getValore("email")));
					}
				} else {
					$fnota->deleteNota(array("id" => $id_nota));
				}
			} elseif ($tipo_cartella == "privata" && $nota_condivisa == FALSE) {
				if ($nome_cartella == "Cestino") {
					$fnota->deleteNota(array("id" => $id_nota));
				} else {
					$cestino = $fcartella->getCartellaByNomeEAmministratore("Cestino",$session->getValore("email"));
					$id_cestino = $cestino[0]['id'];
					$aggiornamenti1 = array("id_cartella" => $id_cestino,"email_utente" => $session->getValore("email"),"id_nota" => $id_nota);
					$fraccoglitore->updateRaccoglitore($aggiornamenti1);
				}
			} else {
				//Permesso negato da concordare con gioele
			}
			$query->commit();
		} catch (Exception $e) {
			$query->rollback(); 
		}
    }
    
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
    			$query1=$query->prepare("CALL AggiornaPosizioneNote(:pos,:cartella)");
    			$query1->bindParam(":pos",$nota['posizione']);
    			$query1->bindParam(":cartella",$nota['id_cartella']);
    			$query1->execute();
    		} else {
    			$aggiornamenti4 = array("ultimo_a_modificare" => $session->getValore("email"),
    									"id" => $dati['id_nota']);
    			$fnota->updateNota($aggiornamenti4);
    		}
    		$query->commit();
    	} catch (Exception $e) {
    		$query->rollback();
    	}
    }
    
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
    			if (($nota['tipo'] == "gruppo" || $nota['condiviso'] == TRUE) && $session->getValore("email") == $shm->get($id)) {
    				$shm->del($id);
    			}
    		} else {
    			if ($nota['tipo'] == "gruppo" || $nota['condiviso'] == TRUE) {
    				if ($shm->get($id)) {
    					$VNota->invia(array("error" => $shm->get($id)));
    				} else {
    					$shm->put($id,$session->getValore("email"));
    					$VNota->invia(array());
    				}
    			}
    		}
    	} else {
    		$VNota->invia(array("error" => "Permesso negato!"));
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
    
}
?>
