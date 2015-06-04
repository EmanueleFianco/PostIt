<?php
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FNota.php");
require_once("../Foundation/Utility/USingleton.php");
$db=USingleton::getInstance('Fdb');
$fnota=USingleton::getInstance('FNota');
$dati= array(
		"testo" => $_POST["Testo"],
		"id" => $_POST["Id"]	
);
$fnota->updateNota($dati);
?>