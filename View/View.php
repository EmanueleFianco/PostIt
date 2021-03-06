<?php
/**
 *
 * Classe View che ha i metodi basilari delle view tra cui il recupero dei dati ricevuti
 * @package View
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class View {
	/**
	 * Invia i dati al client
	 * @param array $dati Array di dati da inviare
	 */
	public function invia($dati) {
		echo json_encode($dati);
	}
	/**
	 * Controlla se nei dati arrivati c'è un controller da richiamare
	 * @return string Stringa contenente il controllore, FALSE altrimenti
	 */
	public function getController() {
		if (isset($_REQUEST['controller']))
			return $_REQUEST['controller'];
		else
			return false;
	}
	/**
	 * Controlla se nei dati arrivati c'è un task da richiamare
	 * @return string Stringa contenente il task, FALSE altrimenti
	 */
	public function getTask() {
		if (isset($_REQUEST['lavoro']))
			return $_REQUEST['lavoro'];
		else
			return false;
	}
	/**
	 * Restituisce i dati arrivati
	 * @return array Array contenente i dati arrivati
	 */
	public function getDati(){
		unset($_REQUEST["lavoro"]);
		unset($_REQUEST["controller"]);
		foreach ($_REQUEST as $key => $valore) {
			$this::controllaInput($key, $valore);
			$dati[$key] = $valore;
		}
		return $dati;
	}
}
?>