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
$futente->inserisciUtente($utente->getAsArray());
$cart=new ECartella('Note', 1, '#ffffff');
$n1=new ENota("Prima nota", "questa è una prima nota", "/Entity/ciao.png", 3, "#ff06f1");
$n2=new ENota("seconda nota", "questa e una seconda nota", "/Entity/cia.png", 3, "#f506f1");
$n3=new ENota("Terza nota", "questa è una prima nota", "/Entity/ciao.png", 3, "#ff06f1");
$n4=new ENota("Quarta nota", "questa e una seconda nota", "/Entity/cia.png", 3, "#f506f1");
$n1=$n1->getAsArray();
$n2=$n2->getAsArray();
$n3=$n3->getAsArray();
$n4=$n4->getAsArray();
$n1['tipo'] = 'privata';
$n1['condiviso'] = FALSE;
$n1['ultimo_a_modificare'] = NULL;
$n1['ora_data_avviso'] = NULL;
$n2['tipo'] = 'privata';
$n2['condiviso'] = FALSE;
$n2['ultimo_a_modificare'] = NULL;
$n2['ora_data_avviso'] = NULL;
$n3['tipo'] = 'privata';
$n3['condiviso'] = FALSE;
$n3['ultimo_a_modificare'] = NULL;
$n3['ora_data_avviso'] = NULL;
$n4['tipo'] = 'privata';
$n4['condiviso'] = FALSE;
$n4['ultimo_a_modificare'] = NULL;
$n4['ora_data_avviso'] = NULL;
$fcartella=USingleton::getInstance('FCartella');
$cart=$cart->getAsArray();
$cart['tipo'] = 'privata';
$cart['email_utente'] = $utente->getEmail();
$fcartella->inserisciCartella($cart);
$idcart=$fcartella->getCartelleByUtente('emanuele.fianco@gmail.com');
$idcart=$idcart[0]['id'];
$n1['id_cartella'] = $idcart;
$n2['id_cartella'] = $idcart;
$n3['id_cartella'] = $idcart;
$n4['id_cartella'] = $idcart;
$fnota=USingleton::getInstance('FNota');
$fnota->inserisciNota($n1);
$fnota->inserisciNota($n2);
$fnota->inserisciNota($n3);
$fnota->inserisciNota($n4);
?>