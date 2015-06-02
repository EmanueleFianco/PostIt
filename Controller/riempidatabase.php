<?php
require_once('../Entity/ECartella.php');
require_once('../Entity/ENota.php');
require_once('../Entity/ENotaCondivisa.php');
require_once('../Entity/EPartecipante.php');
require_once('../Entity/EPromemoria.php');
require_once('../Entity/EUtente.php');
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FUtente.php");
require_once("../Foundation/FCartella.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/Utility/USingleton.php");
$db=USingleton::getInstance('Fdb');
$utente=new EUtente('emanuefff', 'password', 'Emanuele', 'Fianco', 'gggg', 'emanuele.fianco@gmail.com', 'attivato', 'admin');
$futente=USingleton::getInstance('FUtente');
$utente->setCodiceAttivazione();
$futente->inserisciUtente($utente);
$cart=new ECartella('Note', 1, '#ffffff');
$n1=new ENota("Prima nota", "questa è una prima nota", "/Entity/ciao.png", 0, "#ff06f1");
$fcartella=USingleton::getInstance('FCartella');
$fcartella->inserisciCartella($cart,'privata',$utente->getEmail());
$idcart=$fcartella->getCartelleByUtente('emanuele.fianco@gmail.com');
$idcart=$idcart[0]['id'];
$fnota=USingleton::getInstance('FNota');
for ($i=0;$i<300;$i++) {
	$n1->setPosizione($i);
	$fnota->inserisciNota($n1,$idcart,'privata',FALSE);	
}
?>