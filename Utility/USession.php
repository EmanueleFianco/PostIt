<?php
/**
 * 
 * @package Utility
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 */
class USession {
	/**
	 * Inizializza la sessione e controlla se è già presente
	 */
    public function __construct() {
        session_start();
    }
    /**
     * Imposta un valore in sessione
     */
    function setValore($_chiave,$_valore) {
        $_SESSION[$_chiave]=$_valore;
    }
    /**
     * Cancella un valore dalla sessione
     * @param unknown $_chiave
     */
    function cancellaValore($_chiave) {
        unset($_SESSION[$_chiave]);
    }
    /**
     * Restituisce un valore dalla sessione se presente
     * @return unknown|boolean
     */
    function getValore($_chiave) {
        if (isset($_SESSION[$_chiave]))
            return $_SESSION[$_chiave];
        else
            return false;
    }
    /**
     * Termina la sessione distruggendola
     */
    function end(){
        
    	unset($_SESSION);
    	session_destroy();
    }
}
?>