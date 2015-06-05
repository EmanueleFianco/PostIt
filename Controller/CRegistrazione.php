<?php
/**
 * @package Controller
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 */
class CRegistrazione{
    /**
     * Controlla se l'utente è loggato
     * @return boolean
     */
    public function isUtenteRegistrato(){
        $session = USingleton::getInstance('USession');
        if ( $session->getValore('nome_cognome') )
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
        if ( $session->getValore('tipoutente') == "admin" || $session->getValore('tipoutente') == "normale")
            return true;
        else
            return false;
        
    }
    /**
     * Autentica l'utente;in caso di errore viene impostato un messaggio di notifica
     */
    public function autentica(){
        $PReg=USingleton::getInstance('PRegistrazione');
        $login=$PReg->getLogin();
        
        $fuser=USingleton::getInstance('FUtente');
        if (!$user=$fuser->load($login['username']))
            $PReg->setErrore();
        else {
            if ( md5($login['password']) == $user->getPassword() ){
                $session=USingleton::getInstance('USession');
                $session->setValore('username',$user->getUsername());
                $session->setValore('nome_cognome',$user->getNome().' '.$user->getCognome());
                $session->setValore('tipoutente',$user->getTipoUtente());
            }
            else
                $PReg->setErrore();
        }
    }
    
    /**
     * Effettua la registrazione vericando la correttezza dei dati
     */
    public function registra(){
        $PReg=USingleton::getInstance('PRegistrazione');
        $dati=$PReg->getDatiRegistrazione();
        $fuser=USingleton::getInstance('FUtente');
        if (!$fuser->load($dati["username"])) { //utente non esistente
            try {
                $user=new EUtente($dati["username"], $dati["password"], $dati["nome"], $dati["cognome"], "registrato", $dati["email"]);
                $fuser->store($user);
                $session=USingleton::getInstance('USession');
                $session->setValore('username',$dati["username"]);
                $session->setValore('nome_cognome',ucwords($dati["nome"]).' '.ucwords($dati["cognome"]));
                $session->setValore('tipoutente','registrato');
            } 
            catch (Exception $e) {
                return $PReg->showErrore("regdatierrati");
            }
        }
        else 
            return $PReg->showErrore("regusernameinuso");
    }
    /**
     * Disconnette l'utente distruggendo la sessione
     */ 
    public function logout(){
        $session=USingleton::getInstance('USession');
        $session->end();
    }
    
    /**
     * Smista le varie richieste delegando le funzioni corrispondenti.
     */
    public function smista(){
        $PRegistrazione=USingleton::getInstance('PRegistrazione');
        switch ($PRegistrazione->getTask()) {
            case 'login':
                return $this->autentica();
            case 'logout':
                return $this->logout();
            case 'signup':
                return $this->registra();
        }
    }

}
?>