<?php

class CNota {
	

	public function __construct(){
		
	}
	
	public function mux(){
		$VNota=USingleton::getInstance('VNota');
		switch ($VNota->getTask()) {
			case 'nuova':
				return $this->Nuova();
			case 'aggiorna':
				return $this->Aggiorna();
            case 'cancella':
                return $this->Cancella();
            case 'prendiImmagine':
            	return $this->getImmagine();
            case 'upload':
            	return $this->aggiungiImmagine();
            
			}
	}
	
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
			$max_posizione += 1;
			
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
	
	public function Aggiorna(){
		$VNota=USingleton::getInstance('VNota');
		$dati = $VNota->getDati();
		$fnota=USingleton::getInstance('FNota');
		$fnota->updateNota($dati);
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
    
    public function getImmagine(){
    	$FImmagine=USingleton::getInstance('FImmagine');
    	$image = $FImmagine->getImmagineByNome($_REQUEST['file']);
    	$handle = fopen("../tmp/".$_REQUEST['file'],"w+");
    	fwrite($handle,$image[0]['immagine_originale']);
    	$file = "../tmp/".$_REQUEST['file'];
    	header('Content-Type: image/'.basename($image[0]['type']));
    	header('Content-Length: ' . $image[0]['size']);
    	echo file_get_contents($file);
    	unlink($file);
    }
    
    public function aggiungiImmagine(){ //Da vedere con il fatto di id_nota
    	$VNota=USingleton::getInstance('VNota');
    	$FImmagine=USingleton::getInstance('FImmagine');
    	$immagine = $VNota->getImmagine();
    	move_uploaded_file($_FILES['file']['tmp_name'], $immagine['tmp_name']);
    	$img = new EImmagine(basename($immagine['tmp_name']), $immagine['size'], $immagine['type'], $immagine['tmp_name']);
    	$FImmagine->inserisciImmagine($img);
    	$array = array('filelink' => 'Controller/index.php?controller=nota&lavoro=prendiImmagine&file='.basename($immagine['tmp_name']));
    	unlink($immagine['tmp_name']);
    	return stripslashes(json_encode($array));
    }
    
}
?>
