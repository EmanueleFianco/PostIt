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
$d=USingleton::getInstance('FUtente');
$dati= array('username' =>"fabss" ,'password'=>"cicerone",'immagine'=> "balla.png",'nome'=>"fabio",'cognome'=>"di sabatino",'email'=>'fabio.disaba@gmail.com','codice_attivazione'=> 58547,'stato_attivazione'=>'attivato','tipo_utente'=>"admin");
$d->inserisciUtente($dati);
$p1=new EPartecipante("Emanuele", "/Entity/Ciao.png", "emanuele.fianco@gmail.com",'partecipante');
$p2=new EPartecipante("Gioele", "/Entity/Ciao.png", "gioele.cicchini@gmail.com",'admin');
$n1=new ENota("Prima nota", "questa è una prima nota", "/Entity/ciao.png", 3, "#ff06f1");
$n2=new ENota("seconda nota", "questa e una seconda nota", "/Entity/cia.png", 3, "#f506f1");
$b[]=$p1;
$b[]=$p2;
$n3=new ENotaCondivisa("Prima nota condivisa", "questa è una nota condivisa", "/Entity/ciao.png", 3, "#ff06f1",$p1, $b);
$n3->Push($p1);
$date = new DateTime('2015-05-24');
$date->setTime(15, 55);
$pro1=new EPromemoria("Sono un promemoria", "Sveglia", "/Entity/Ciao.png", 4, "#f506f1", $date);
$a[]=$n1;
$a[]=$n2;
$a[]=$n3;
$a[]=$pro1;
$cart[]=new ECartella("Note", 4, '#ffffff', $a);
$utente=new EUtente("fabss","password","fabio","di sabatino","http://127.0.0.1/postIt","prova1@example.com",FALSE, 'normale',$cart);
$utente->setCodiceAttivazione();
$utente->setStatoAttivazione(TRUE);
$d->inserisciUtente($utente->getAsArray());
$d1=USingleton::getInstance('FCartella');
$cartella=$cart[0]->getAsArray();
$cartella['tipo']='privata';
$cartella['email_utente']=$utente->getEmail();
$d1->inserisciCartella($cartella);
$getCart = $d1->getCartelleByUtente($utente->getEmail());
$d2=USingleton::getInstance('FNota');
$nota = $n3->getAsArray();
$nota['ultimo_a_modificare'] = $n3->getUltimoAModificare()->getEmail();
$nota['tipo'] = 'nota';
$nota['condiviso'] = TRUE;
$nota['ora_data_avviso'] = NULL;
$nota['id_cartella'] = $getCart[0]['id'];
$d2->inserisciNota($nota);


$nota1=$n1->getAsArray();
$nota2=$n2->getAsArray();

$note = array();
$note[]=$nota1;
$note[]=$nota2;
echo json_encode($note);
?>