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
			case 'nuova':
				return $this->Nuova();
			case 'aggiorna':
				return $this->Aggiorna();
			case 'aggiornaPosizioni':
				return $this->AggiornaPosizioni();
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
		$fnota=USingleton::getInstance('FNota');
		$fdb=USingleton::getInstance('Fdb');
		$query=$fdb->getDb();
		$query->beginTransaction();
		try {
			$max_posizione = $fnota->getMaxPosizioneNotaByCartella(136);
			$max_posizione = $max_posizione[0]["max(posizione)"];
			$max_posizione += 1;
			$dati = $dati['nota'][0];
			
			$dati['posizione'] = $max_posizione - $dati['posizione'];
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
			$fnota->inserisciNota($nota,136);
			$query->commit();
		} catch (Exception $e) {
			$query->rollBack();
		}
		$parametri['id_cartella'] = 136;
		$parametri['posizione'] = $max_posizione; 
		$nota = $fnota->getNotaByParametri($parametri);
		$id_nota = $nota['0']['id'];
		$dati_da_inviare= array(
					'id' => $id_nota,
						 		);
		$VNota->invia($dati_da_inviare);
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
    
    public function getImmagine(){
    	//prelevare immagine dal db
    	// ovviamente questo e un esempio e fa schifo
    	$file = '../tmp/'.$_REQUEST['file'];
    	header('Content-Type: image/jpeg');
    	header('Content-Length: ' . filesize($file));
    	echo file_get_contents($file);
  
    }
    
    public function aggiungiImmagine(){
    	// ovviamente da rifare in modo che vada sul db 
    	$VNota=USingleton::getInstance('VNota');
    	$dir = '../tmp/';
    	$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
    	
    	
    	if ($_FILES['file']['type'] == 'image/png'
    			|| $_FILES['file']['type'] == 'image/jpg'
    			|| $_FILES['file']['type'] == 'image/gif'
    			|| $_FILES['file']['type'] == 'image/jpeg'
    			|| $_FILES['file']['type'] == 'image/pjpeg')
    	{
    		// setting file's mysterious name
    		$filename = md5(date('YmdHis')).'.jpg';
    		$file = $dir.$filename;
    	
    		// copying
    		move_uploaded_file($_FILES['file']['tmp_name'], $file);
    	
    		// displaying file
    		$array = array(
    				'filelink' => 'Controller/index.php?controller=nota&lavoro=prendiImmagine&file='.$filename,
    				
    		);
    	
    		//$VNota->invia($array);
    		echo stripslashes(json_encode($array));
    	
    	}

    }
}

?>
