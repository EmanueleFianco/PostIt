<?php
require_once('../Entity/ECartella.php');
require_once('../Entity/ENota.php');
require_once('../Entity/ENotaCondivisa.php');
require_once('../Entity/EPartecipante.php');
require_once('../Entity/EPromemoria.php');
require_once('../Entity/EUtente.php');
require_once('../Entity/EImmagine.php');
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FUtente.php");
require_once("../Foundation/FCartella.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/FImmagine.php");
require_once("../Foundation/Utility/USingleton.php");
$db=USingleton::getInstance('Fdb');
$path="../Foundation/Utility/utenteDefault.png";
$image = new EImmagine(basename($path), filesize($path), "image/png", $path);
$fimmagine=USingleton::getInstance('FImmagine');
$fimmagine->inserisciImmagine($image);
$idimage=$image->getId();
$utente=new EUtente('emanuefff', 'password', 'Emanuele', 'Fianco', $image, 'emanuele.fianco@gmail.com', 'attivato', 'admin');
$futente=USingleton::getInstance('FUtente');
$utente->setCodiceAttivazione();
$futente->inserisciUtente($utente,$idimage);
$cart=new ECartella('Note', 1, '#FFFFFF');
$cestino=new ECartella('Cestino', 2, '#FFFFFF');
$n1=new ENota("Prima nota", "questa è una prima nota", 0, "#66FF00");
$fcartella=USingleton::getInstance('FCartella');
$fcartella->inserisciCartella($cart,'privata',$utente->getEmail());
$fcartella->inserisciCartella($cestino,'privata',$utente->getEmail());
$idcart1=$fcartella->getCartelleByUtente('emanuele.fianco@gmail.com');
foreach ($idcart1 as $key => $valore) {
	if ($valore['nome'] == "Note") {
		$idcart=$valore['id'];
	}
}
$fnota=USingleton::getInstance('FNota');
for ($i=0;$i<150;$i++) {
	$n1->setPosizione($i);
	$fnota->inserisciNota($n1,$idcart);	
}
?>