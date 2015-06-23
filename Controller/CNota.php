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
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$dati = $dati['nota'][0];
			$max_posizione = $fraccoglitoreNote->getMaxPosizioneNotaByCartellaEUtente('emanuele.fianco@gmail.com',$dati["id_cartella"]);
			$max_posizione = $max_posizione[0]["max(posizione)"];
			if (isset($max_posizione)) {
				$max_posizione += 1;
			} else {
				$max_posizione = 0;
			}
			$dati['posizione'] = $max_posizione;
			if ($dati['ora_data_avviso']) {
				if ($dati['ultimo_a_modificare']) {
					$nota = new EPromemoriaCondiviso($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'], $dati['ultimo_a_modificare'], $dati['ora_data_avviso'], $dati['immagine'], $dati['partecipanti']);
				} else {
					$nota = new EPromemoria($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'], $dati['ora_data_avviso'], $dati['immagine']);
				}
			} else {
				if ($dati['ultimo_a_modificare']) {
					$nota = new ENotaCondivisa($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore'], $dati['ultimo_a_modificare'], $dati['immagine'], $dati['partecipanti']);
				} else {
					$nota = new ENota($dati['titolo'], $dati['testo'], $dati['posizione'], $dati['colore']/*, $dati['immagine']*/);
				}
			}
			$fnota->inserisciNota($nota,'emanuele.fianco@gmail.com');
			$id = $query->lastInsertId();
			$parametri = array("id_nota" => $id,
							   "email_utente" => 'emanuele.fianco@gmail.com',
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
		$fdb=USingleton::getInstance('Fdb');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$cartella = $fcartella->getCartellaById($dati['id_cartella']);
			$nota = $fnota->getNotaById($dati['id_nota']);
			$nota_condivisa = $nota[0]['condiviso'];
			$creatore_nota = $nota[0]['creata_da'];
			$nome_cartella = $cartella[0]['nome'];
			$tipo_cartella = $cartella[0]['tipo'];
			$amministratore_cartella = $cartella[0]['amministratore'];
			if ($amministratore_cartella == 'emanuele.fianco@gmail.com' || $creatore_nota == 'emanuele.fianco@gmail.com') {
				if ($nome_cartella == "Cestino" || $tipo_cartella == "gruppo" || $nota_condivisa == TRUE) {
					unset($dati['id_cartella']);
					$fnota->deleteNota($dati);
				} else {
					$email_utente = $cartella[0]['amministratore'];
					$parametri = array("amministratore" => $email_utente,
									   "nome" => "Cestino");
					$cestino = $fcartella->getCartellaByParametri($parametri);
					$id_cestino = $cestino[0]['id'];
					$dati = array("id_cartella" => $id_cestino,
							      "id_nota" => $dati['id_nota']);
					$fraccoglitore->updateRaccoglitore($dati);
					$query->commit();
				}
			} else {
				throw new Exception("Operazione non consentita");
			} 
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
    	$fdb=USingleton::getInstance('Fdb');
    	$aggiornamenti = array("tipo" => "promemoria",
    			  			   "id" => $dati['id']);
    	$aggiornamenti1 = array("ora_data_avviso" => $dati['ora_data_avviso'],
    						   "id" => $dati['id']);
    	$query=$fdb->getDb();
    	$query->beginTransaction();
    	try {
    		$nota = $fraccoglitore->getNotaByIdEUtente($dati['id'],'emanuele.fianco@gmail.com');
    		$fnota->updateNota($aggiornamenti);
    		$fnota->updateNota($aggiornamenti1);
    		$promemoria = $fcartella->getCartellaByNomeEAmministratore("Promemoria",'emanuele.fianco@gmail.com');
    		$aggiornamenti2 = array("id_cartella" => $promemoria[0]["id"],
    								"id_nota" => $dati['id']);
    		$max_posizione = $fraccoglitore->getMaxPosizioneNotaByCartellaEUtente('emanuele.fianco@gmail.com',$promemoria[0]['id']);
    		$max_posizione = $max_posizione[0]['max(posizione)'];
    		$max_posizione +=1;
    		$aggiornamenti3 = array("posizione" => $max_posizione,
    								"id_nota" => $dati['id']);
    		$fraccoglitore->updateRaccoglitore($aggiornamenti2);
    		$fraccoglitore->updateRaccoglitore($aggiornamenti3);
    		$query1=$query->prepare("CALL AggiornaPosizioneNote(:pos,:cartella)");
			$query1->bindParam(":pos",$nota[0]['posizione']);
			$query1->bindParam(":cartella",$nota[0]['id_cartella']);
			$query1->execute();
			$query->commit();
    	} catch (Exception $e) {
    		$query->rollback();
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
