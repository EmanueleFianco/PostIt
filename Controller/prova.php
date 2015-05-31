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
$fpartecipante=USingleton::getInstance('FPartecipante');
$cartella=$fcartella->getCartelleByUtente("emanuele.fianco@gmail.com");
$note = $fnota->getNoteByCartella($cartella[0]['id']);

$idcart=$fcartella->getCartelleByUtente('emanuele.fianco@gmail.com');
$idcart=$idcart[0]['id'];

$part=new EPartecipante('emanuefff', 'gggg', 'emanuele.fianco@gmail.com', 'admin');
$fpartecipante->inserisciPartecipante($part->getAsArray());
$p['id_cartella']= $idcart;
$p['email_partecipante']= 'emanuele.fianco@gmail.com';
$fpartecipante->aggiungiAlGruppo($p);
$co=$fnota->getNoteByCartella($idcart);
$co=$co[0]['id'];
$con['id_nota']=$co;
$con['email_partecipante']='emanuele.fianco@gmail.com';
$fpartecipante->AggiungiAllaCondivisione($con);
$ris=$fpartecipante->getPartecipantiByIdCartella($idcart);
$ris1=$fpartecipante->getPartecipantiByIdNota($co);
echo json_encode($note);
?>
