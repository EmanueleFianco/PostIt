<?php
/**
 *
 * Classe EPromemoriaCondiviso che estende la classe EPromemoria
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class EPromemoriaCondiviso extends EPromemoria {
	/**
     *
	 * @var DateTime $ora_data_avviso Ora e data definita per il promemoria.
	 * 
	 */
	private $ultimo_a_modificare;
	
	/**
    * Costruttore di EPromemoriaCondiviso, eredita il costruttore di EPromemoria
    *
    * @param string $_titolo
    * @param string $_testo
    * @param int $_posizione
    * @param string $_colore
	* @param string $_ultimo_a_modificare
    * @param DateTime $_ora_data_avviso 
    * @param string $_immagine
    *
    */
    public function __construct($_titolo, $_testo, $_posizione, $_colore,$_ultimo_a_modificare,DateTime $_ora_data_avviso, $_immagine = NULL) {
		parent::__construct($_titolo, $_testo, $_posizione, $_colore, $_ora_data_avviso, $_immagine);
		$this->setUltimoAModificare($_ultimo_a_modificare);	
	}
	

   /**
	*
	*Setta la mail dell'ultimo utente che ha modificato il promemoria condiviso.
	* @param string $_ultimo_a_modificare
	*
	*/
	public function setUltimoAModificare($_ultimo_a_modificare) {
		$this->ultimo_a_modificare = $_ultimo_a_modificare;
	}
	
   /**
	*funzione che restituisce l'email dell'ultimo utente che ha modificato il promemoria
	* @return string Email dell'utente che ha modificato per ultimo il promemoria condiviso.
	*
	*/
	public function getUltimoAModificare() {
		return $this->ultimo_a_modificare;
	}	

}
?>