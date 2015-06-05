<?php
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FImmagine.php");
require_once("../Foundation/FUtente.php");
require_once("../Foundation/Utility/USingleton.php");
$db=USingleton::getInstance('Fdb');
$fimmagine=USingleton::getInstance('FImmagine');
$futente=USingleton::getInstance('FUtente');
$utente = $futente->getUtenteByEmail('emanuele.fianco@gmail.com');
$image = $fimmagine->getImmagineById($utente[0]['id_immagine']); //Da modificare in base all'id
$handle = fopen("/home/emanuele/public_html/Web/PostIt/Foundation/Utility/ciao.png","w+");
fwrite($handle,$image[0]['immagine_originale']);
?>