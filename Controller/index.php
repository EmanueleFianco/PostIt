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


$controllore=USingleton::getInstance('CHome');


?>