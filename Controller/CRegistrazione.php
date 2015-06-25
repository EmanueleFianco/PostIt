<?php
/**
 *Classe Cregistrazione che gestisce la registrazione 
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
			case 'controlla':
				return $this->controllaEmail();
			case 'inviaInfo':
				return $this->inviaInfo();
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
        if ($utente) {
        	$utente = $utente[0];
        	if ($utente['password'] == md5($login['password'])) {
        		if ($utente['stato_attivazione'] != "attivato") {
        			$VRegistrazione->invia(array("error" => "Utente non attivato"));
        		} else {
        			$session=USingleton::getInstance('USession');
        			$session->setValore('username',$utente['username']);
        			$session->setValore('nome',$utente['nome']);
        			$session->setValore('cognome',$utente['cognome']);
        			$session->setValore('email',$utente['email']);
        			$session->setValore('tipo_utente',$utente['tipo_utente']);
        			$session->setValore('path',"Home.php?controller=utente&lavoro=getImmagine&file=".$utente['id_immagine']);
        			$this->inviaInfo();
        		}
        	} else {
        		throw new Exception("Login errato");
        	}
        } else {
        	throw new Exception("Utente errato");
        }
    }
    
    /**
     * Effettua la registrazione vericando la correttezza dei dati
     */
    public function registra(){
    	unset($_REQUEST['submit']);
        $VRegistrazione=USingleton::getInstance('VRegistrazione');
        $dati=$VRegistrazione->getDati();
        $futente=USingleton::getInstance('FUtente');
        $fdb=USingleton::getInstance('Fdb');
        $query=$fdb->getDb();
        $query->beginTransaction();
        if (!$futente->getUtenteByEmail($dati["email"])) { //utente non esistente
            try {
            	if ($_FILES['file']['tmp_name']) {
            		$image = $VRegistrazione->getImmagine();
            		move_uploaded_file($_FILES['file']['tmp_name'], $image['tmp_name']);
            		$immagine = new EImmagine(basename($image['tmp_name']), $image['size'], $image['type'], $image['tmp_name']);
            		$FImmagine=USingleton::getInstance('FImmagine');
            		$FImmagine->inserisciImmagine($immagine);
            		unlink($image['tmp_name']);
            	} else {
            		$immagine = NULL;
            	}
            	$utente=new EUtente($dati["username"], $dati["password"], $dati["nome"], $dati["cognome"],$dati["email"],"nonattivato","normale");
                $utente->setCodiceAttivazione();
                if ($immagine) {
                	$futente->inserisciUtente($utente,$immagine->getNome());
                } else {
                	$futente->inserisciUtente($utente);
                }
                $query->commit();
                $this->inviaMailRegistrazione($dati['email']);
                header('Location: Templates/success.html');
                exit;
            } 
            catch (Exception $e) {
            	$query->rollback();
            	header('Location: Templates/failed.html');
                exit;
            }
        } else {
            header('Location: Templates/failed.html');
            exit;
        }
    }
    /**
     * Disconnette l'utente distruggendo la sessione
     */ 
    public function logout(){
        $session=USingleton::getInstance('USession');
        $View=USingleton::getInstance('View');
        try {
        	$session->end();
        	header('Location: index.php');
            exit;
        } catch (Exception $e) {
        	$View->invia(array("success" => FALSE));
        }
        
        exit;
    }
    /**
     * Attiva l'utente verificandone l'email data alla registrazione
     */
    public function attivazione() {
    	$VRegistrazione=USingleton::getInstance('VRegistrazione');
    	$fcartella=USingleton::getInstance('FCartella');
    	$fraccoglitore=USingleton::getInstance('FRaccoglitore_cartelle');
    	$dati=$VRegistrazione->getDati();
    	$futente=USingleton::getInstance('FUtente');
    	$utente = $futente->getUtenteByEmail($dati['email']);
    	$fdb=USingleton::getInstance('Fdb');
    	$query=$fdb->getDb();
    	$query->beginTransaction();
    	try {
    		if (isset($utente)) {
    			$utente = $utente[0];
    			$cod_attivazione = $utente['codice_attivazione'];
    			if ($dati['cod_attivazione'] == $cod_attivazione) {
    				$aggiornamento = array("stato_attivazione" => "attivato",
    						"email" => urldecode($dati['email']));
    				$futente->updateUtente($aggiornamento);
    				$cartelle = array("Note", "Promemoria", "Archivio", "Cestino");
    				$colori = array("#FFFFFF", "#FFFFFF", "#FFFFFF", "#FFFFFF");
    				foreach ($cartelle as $key => $valore) {
    					$c = new ECartella($valore, $key, $colori[$key]);
    					$fcartella->inserisciCartella($c, "privata", $dati['email']);
    					$cart = array("id_cartella" => $query->lastInsertId(),
    							"email_utente" => $dati['email'],
    							"posizione" => $key);
    					$fraccoglitore->aggiungiAlRaccoglitoreCartelle($cart);
    				}
    				$query->commit();
    				header('Location: Templates/successoAttivazione.html');
    				exit;
    			} else {
    				throw new Exception("Codice di attivazione errato");
    			}
    		} else {
    			throw new Exception("Utente inesistente");
    		}
    	} catch (Exception $e) {
    		$query->rollback();
    		throw new Exception($e->getMessage());
    	}
    }
    
    /**
     * Metodo per inviare la mail di conferma di avvenuta registrazione con il link per attivarsi.
     *
     * @param string $mail mail dell'utente
     */
    public function inviaMailRegistrazione($email) {
    	$FUtente=USingleton::getInstance('FUtente');
    	$email_url = urlencode($email);
    	$codice_attivazione=$FUtente->getUtenteByEmail($email);
    	$codice_attivazione = $codice_attivazione[0]['codice_attivazione'];
    	$url = "http://postit.altervista.org/Home.php?controller=registrazione&lavoro=attiva&codice_attivazione=".$codice_attivazione."&mail=".$email_url;
    	$to = $mail;
    	$subject = 'Benvenuto in PostIt';
    	$message = "Clicca sul seguente link per attivare il tuo account: " . $url;
    	$headers = 'From: postit@altervista.org' . "\r\n" .
    			'Reply-To: cookwithus@altervista.org' . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
    			'MIME-Version: 1.0\n' .
    			'Content-Type: text/html; charset=\"iso-8859-1\"\n' .
    			'Content-Transfer-Encoding: 7bit\n\n';
    	mail($to, $subject, $message, $headers);
    }
    /**
    *Verifica se l'email risulta già stata utilizzata in fase di registrazione
    **/
    public function controllaEmail() {
    	$VRegistrazione = USingleton::getInstance('VRegistrazione');
    	$FUtente=USingleton::getInstance('FUtente');
    	$dati = $VRegistrazione->getDati();
    	$utente = $FUtente->getUtenteByEmail($dati['email']);
    	if ($utente) {
    		throw new Exception("Email esistente");
    	} else {
    		$VRegistrazione->invia(array());
    	}
    }
    /**
    *Funzione che permette la visualizzazione delle informazioni relative all'utente
    **/
    public function inviaInfo() {
    	$session = USingleton::getInstance('USession');
    	$View = USingleton::getInstance('View');
    	$info = array("username" => $session->getValore('username'),
    			"nome" => $session->getValore("nome"),
    			"cognome" => $session->getValore("cognome"),
    			"email" => $session->getValore("email"),
    			"tipo_utente" => $session->getValore("tipo_utente"),
    			"path" => $session->getValore("path"));
    	$View->invia($info);
    }
}
?>