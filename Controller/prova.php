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
$futente=USingleton::getInstance('FUtente');
$fcartella=USingleton::getInstance('FCartella');
$fnota=USingleton::getInstance('FNota');

$cartella=$fcartella->getCartelleByUtente("emanuele.fianco@gmail.com");
$note = $fnota->getNoteByCartella($cartella[0]['id']);
foreach ($note as $key => $valore) {
	foreach ($note[$key] as $keynota => $valorenota) {
		if (is_int($keynota)) {
			unset($note[$key][$keynota]);
		}
	}
}	
echo json_encode($note);
?>