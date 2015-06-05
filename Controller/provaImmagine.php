<?php
require_once("../Foundation/Fdb.php");
require_once("../Foundation/FImmagine.php");
require_once("../Foundation/Utility/USingleton.php");
$db=USingleton::getInstance('Fdb');
$fimmagine=USingleton::getInstance('FImmagine');
$image = $fimmagine->getImmagineById(9); //Da modificare in base all'id
$handle = fopen("/home/emanuele/public_html/Web/PostIt/Foundation/Utility/ciao.png","w+");
fwrite($handle,$image[0]['immagine']);
?>