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
	 * @var string $ora_data_avviso Ora e data definita per il promemoria.
	 * 
	 */
	private $ora_data_avviso;
	
	

	/**
    * Costruttore di Promemoria che eredita il costruttore della classe Enota.
    * 
    * @param string $_titolo
    * @param string $_testo
    * @param string $_colore
    * @param string $_immagine
    * @param int $_posizione
    * @param string $_colore
    * @param DateTime $_ora_data_avviso
    * 
    */
    public function __construct($_titolo, $_testo, $_posizione, $_colore,DateTime $_ora_data_avviso, $immagine = NULL) {
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
	*
	* @return string Ora e data definiti per il promemoria.
	*
	*/
	public function getOraDataAvviso() {
		return $this->ora_data_avviso;
	}
	
	public function getAsArray() {
	$result=array();
    	foreach($this as $key => $value) {
    		if (!is_array($value) && !is_object($value)) {
    			$result[$key] = $value;
    		} elseif (is_object($value)) {
    			if (get_class($value) == 'DateTime') {
    				$result[$key] = $value->format('Y-m-d H:i:s');
    			}
    		}
    	}
    	return $result;
	}
	
}