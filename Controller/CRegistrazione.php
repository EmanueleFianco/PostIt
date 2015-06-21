<?php
/**
 * @package Controller
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 */
class CRegistrazione {
	
	/**
	 * Smista le varie richieste delegando le funzioni corrispondenti.
	 */
	public function mux(){
		$VRegistrazione=USingleton::getInstance('VRegistrazione');
		switch ($VRegistrazione->getTask()) {
			case 'login':
				return $this->autentica();
			case 'logout':
				return $this->logout();
			case 'signup':
				return $this->registra();
			case 'attiva':
				return $this->attivazione();
		}
	}
    /**
     * Controlla se l'utente è loggato
     * @return boolean
     */
    public function isUtenteRegistrato(){
        $session = USingleton::getInstance('USession');
        if ($session->getValore('email'))
            return true;
        else
            return false;
    }
    /**
     * Controlla se l'utente è amministratore o normale
     * @return boolean
     */
    public function isAdmin(){
        $session = USingleton::getInstance('USession');
        if ($session->getValore('tipo_utente') == "admin")
            return true;
        else
            return false;
        
    }
    /**
     * Autentica l'utente;in caso di errore viene impostato un messaggio di notifica
     */
    public function autentica(){
        $VRegistrazione=USingleton::getInstance('VRegistrazione');
        $login=$VRegistrazione->getDati();
        
        $futente=USingleton::getInstance('FUtente');
        $utente = $futente->getUtenteByEmail($login['email']);
        if (isset($utente)) {
        	$utente = $utente[0];
        	if ($utente['password'] == md5($login['password'])) {
        		if ($utente['stato_attivazione'] != "attivato") {
        			throw new Exception("Utente non attivato");
        		} else {
        			$session=USingleton::getInstance('USession');
        			$session->setValore('username',$utente['username']);
        			$session->setValore('nome',$utente['nome']);
        			$session->setValore('cognome',$utente['cognome']);
        			$session->setValore('email',$utente['email']);
        			$session->setValore('tipo_utente',$utente['tipo_utente']);
        			$info = array("username" => $utente['username'],
        					"nome" => $utente['nome'],
        					"cognome" => $utente['cognome'],
        					"email" => $utente['email'],
        					"tipo_utente" => $utente['tipo_utente']);
        			$VRegistrazione->invia($info);
        		}
        	}
        } else {
        	throw new Exception("Login errato");
        }
    }
    
    /**
     * Effettua la registrazione vericando la correttezza dei dati
     */
    public function registra(){
        $VRegistrazione=USingleton::getInstance('VRegistrazione');
        $dati=$VRegistrazione->getDati();
        $futente=USingleton::getInstance('FUtente');
        $ccartella=USingleton::getInstance('CCartella');
        $fdb=USingleton::getInstance('Fdb');
        $session=USingleton::getInstance('USession');
        $query=$fdb->getDb();
        $query->beginTransaction();
        if (!$futente->getUtenteByEmail($dati["email"])) { //utente non esistente
            try {
            	if (isset($_FILES['file'])) {
            		$image = $VRegistrazione->getImmagine();
            		move_uploaded_file($_FILES['file']['tmp_name'], $image['tmp_name']);
            		$immagine = new EImmagine($image['tmp_name'], $image['size'], $image['type'], $image['tmp_name']);
            		$FImmagine=USingleton::getInstance('FImmagine');
            		$FImmagine->inserisciImmagine($immagine);
            	} else {
            		$immagine = NULL;
            	}
            	$utente=new EUtente($dati["username"], $dati["password"], $dati["nome"], $dati["cognome"],$dati["email"],"nonattivato","normale");
                $utente->setCodiceAttivazione();
            	$futente->inserisciUtente($utente,$immagine);
            	$cartelle = array("Note" => '#FFFFFF',
            					  "Promemoria" => '#FFFFFF',
            					  "Archivio" => '#FFFFFF', //I colori di default sono da scegliere
            					  "Cestino" => '#FFFFFF');
            	$_REQUEST['amministratore'] = $session->getValore("email");
            	$_REQUEST['tipo'] = "privata";
            	foreach ($cartelle as $key => $valore) {
            		$_REQUEST['nome'] = $key;
            		$_REQUEST['colore'] = $valore;
            		$ccartella->Nuova();            		
            	}
                $session->setValore('username',$dati["username"]);
                $session->setValore('nome',ucwords($dati["nome"]).' '.ucwords($dati["cognome"]));
                $session->setValore('cognome',ucwords($dati["cognome"]));
                $session->setValore('tipo_utente','normale');
                $query->commit();
            } 
            catch (Exception $e) {
            	$query->rollback();
            	echo "Registrazione fallita";
            }
        }
        else {
        	throw new Exception("Email già in uso");
        }
    }
    /**
     * Disconnette l'utente distruggendo la sessione
     */ 
    public function logout(){
        $session=USingleton::getInstance('USession');
        $session->end();
    }
    /**
     * Attiva l'utente verificandone l'email data alla registrazione
     */
    public function attiva() {
    	$VRegistrazione=USingleton::getInstance('VRegistrazione');
    	$dati=$VRegistrazione->getDati();
    	$futente=USingleton::getInstance('FUtente');
    	$utente = $futente->getUtenteByEmail($dati['email']);
    	if (isset($utente)) {
    		$cod_attivazione = $utente[0]['codice_attivazione'];
    		if ($dati['cod_attivazione'] == $cod_attivazione) {
    			$aggiornamento = array("stato_attivazione" => "attivato",
    								   "email" => $dati['email']);
    			$futente->updateUtente($aggiornamento);
    			$VRegistrazione->invia(array("attivazione" => TRUE));
    		} else {
    			throw new Exception ("Codice di attivazione errato");
    		}
    	} else {
    		throw new Exception("Utente inesistente");
    	}	
    }
}
?>