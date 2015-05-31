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
require_once("../Foundation/FPartecipante.php");
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
$utente=new EUtente('emanuefff', 'password', 'Emanuele', 'Fianco', 'gggg', 'emanuele.fianco@gmail.com', 'attivato', 'admin');
$idcart=$fcartella->getCartelleByUtente("emanuele.fianco@gmail.com");
$idcart=$idcart[0]['id'];

$fpartecipante=USingleton::getInstance('FPartecipante');
$part=new EPartecipante('emanuefff', 'gggg', 'emanuele.fianco@gmail.com', 'admin');
$fpartecipante->inserisciPartecipante($part->getAsArray());
$p['id_cartella']= $idcart;
$p['email_partecipante']= $utente->getEmail();
$fpartecipante->aggiungiAlGruppo($p);
$co=$fnota->getNoteByCartella($idcart);
$co=$co[0]['id'];
$con['id_nota']=$co;
$con['email_partecipante']=$utente->getEmail();
$fpartecipante->AggiungiAllaCondivisione($con);
$ris=$fpartecipante->getPartecipantiByIdCartella($idcart);
var_dump($ris);
//echo json_encode($note);
?>