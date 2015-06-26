<?php
/**
 *
 * Classe EPromemoria che estende la classe ENota
 * @package Entity
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 * 
 */
class EPromemoria extends ENota {
	/**
     *
	 * @var DateTime $ora_data_avviso Ora e data definita per il promemoria.
	 * 
	 */
	private $ora_data_avviso;
	
	

	/**
    * Costruttore di Promemoria che eredita il costruttore della classe Enota.
    * 
    * @param string $_titolo
    * @param string $_testo
    * @param int $_posizione
    * @param string $_colore
    * @param DateTime $_ora_data_avviso
    * @param string $_immagine
    * 
    */
    public function __construct($_titolo, $_testo, $_posizione, $_colore,DateTime $_ora_data_avviso, $_immagine = NULL) {
		parent::__construct($_titolo, $_testo, $_posizione, $_colore, $_immagine);
		$this->setOraDataAvviso($_ora_data_avviso);
	}
	 /**
     * Setta $_ora_data_avviso come Ora e data definiti per il promemoria.
     * @param DateTime $_ora_data_avviso
     *
     */
	public function setOraDataAvviso(DateTime $_ora_data_avviso) {
		$this->ora_data_avviso = $_ora_data_avviso;
	}
	
	/**
	* funzione che restituisce l'ora e la data definite per il promemoria
	* @return DateTime Ora e data definiti per il promemoria.
	*
	*/
	public function getOraDataAvviso() {
		return $this->ora_data_avviso;
	}
	
	/**
	 * funzione che restituisce l'array associativo associato all'oggetto promemoria
	 * @return array Trasforma l'oggetto in una array associativo
	 *
	 */
	public function getAsArray() {
		$result = parent::getAsArray();
		$result['ora_data_avviso'] = $this->ora_data_avviso->format('Y-m-d H:i:s');
		return $result;
	}
	
}
?>