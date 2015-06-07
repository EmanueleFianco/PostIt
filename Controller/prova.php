<?php
require_once('../Entity/ECartella.php');
require_once('../Entity/ENota.php');
require_once('../Entity/ENotaCondivisa.php');
require_once('../Entity/EPartecipante.php');
require_once('../Entity/EPromemoria.php');
require_once('../Entity/EUtente.php');

require_once('../Controller/CHome.php');
require_once('../Controller/CNota.php');
require_once('../View/VHome.php');
require_once('../View/VNota.php');


require_once("../Foundation/Fdb.php");
require_once("../Foundation/FUtente.php");
require_once("../Foundation/FCartella.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/FPartecipante.php");
require_once("../Foundation/FPartecipano.php");
require_once("../Foundation/FCondividono.php");
require_once("../Foundation/Utility/USingleton.php");

 


$db=USingleton::getInstance('Fdb');
$futente=USingleton::getInstance('FUtente');
$fcartella=USingleton::getInstance('FCartella');
$fnota=USingleton::getInstance('FNota');
$fpartecipante=USingleton::getInstance('FPartecipante');
$fpartecipano=USingleton::getInstance('FPartecipano');
$fcondividono=USingleton::getInstance('FCondividono');

$idcart1=$fcartella->getCartelleByUtente('emanuele.fianco@gmail.com');
foreach ($idcart1 as $key => $valore) {
	if ($valore['nome'] == "Note") {
		$idcart=$valore['id'];
	}
}
$max = $fnota->getMaxPosizioneNotaByCartella($idcart);
$max = $max[0]['max(posizione)'];
$note = $fnota->getNoteByCartella($idcart,$max);
$part=new EPartecipante('emanuefff', 'gggg', 'emanuele.fianco@gmail.com', 'admin');
$fpartecipante->inserisciPartecipante($part);
$p['id_cartella']= $idcart;
$p['email_partecipante']= 'emanuele.fianco@gmail.com';
$fpartecipano->aggiungiAlGruppo($p);
$co=$fnota->getNoteByCartella($idcart);
$co=$co[0]['id'];
$con['id_nota']=$co;
$con['email_partecipante']='emanuele.fianco@gmail.com';
$fcondividono->AggiungiAllaCondivisione($con);
$ris=$fpartecipante->getPartecipantiByIdCartella($idcart);
$ris1=$fpartecipante->getPartecipantiByIdNota($co);
$cose_da_cambiare= array('posizione' => 10,
						 'id' => $idcart);
$righeToccate=$fcartella->updateCartella($cose_da_cambiare);

/*$pos = 105;
$query = $db->db;
$query->beginTransaction();   //Si è provato anche il funzionamento delle query atomiche e funziona ;)
try{					//N.B. Si deve mettere public all'attributo db di Fdb per far funzionare questo pezzo di codice
	$fnota->deleteNota(array("posizione" => $pos));
	$query1=$query->prepare("CALL AggiornaPosizioneNote(:pos)");
	$query1->bindParam(":pos",$pos);
	$query1->execute();
	$query->commit();
} catch (Exception $e) {
	$query->rollBack();
}*/

echo json_encode($note);
?>
