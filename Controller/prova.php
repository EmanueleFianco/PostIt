<?php
require_once('../Entity/ECartella.php');
require_once('../Entity/ENota.php');
require_once('../Entity/ENotaCondivisa.php');
require_once('../Entity/EPartecipante.php');
require_once('../Entity/EPromemoria.php');
require_once('../Entity/EUtente.php');
$p1=new EPartecipante("Emanuele", "/Entity/Ciao.png", "emanuele.fianco@gmail.com",'partecipante');
$p2=new EPartecipante("Gioele", "/Entity/Ciao.png", "gioele.cicchini@gmail.com",'admin');
$n1=new ENota("Prima nota", "questa è una prima nota", "/Entity/ciao.png", 3, "#ff06f1",$p1);
$n2=new ENota("seconda nota", "questa e una seconda nota", "/Entity/cia.png", 3, "#f506f1",$p2);
$b[]=$p1;
$b[]=$p2;
$n3=new ENotaCondivisa("Prima nota condivisa", "questa è una nota condivisa", "/Entity/ciao.png", 3, "#ff06f1",$p1, $b);
$n3->Push($p1);
$date = new DateTime('2015-05-24');
$date->setTime(15, 55);
$pro1=new EPromemoria("Sono un promemoria", "Sveglia", "/Entity/Ciao.png", 4, "#f506f1",$p2, $date);
$a[]=$n1;
$a[]=$n2;
$a[]=$n3;
$a[]=$pro1;
$cart=new ECartella("Note", 4, '#ffffff', $a);
$utente=new EUtente("fabss","password","fabio","di sabatino","http://127.0.0.1/postIt","prova@example.com", 'normale');

echo json_encode(array( "titolo"=>$n2->getTitolo(),
						"testo"=>$n1->getTesto(),
						"username"=>$utente->getUsername(),
						"ora"=>$pro1->getOraDataAvviso()->format('Y-m-d H:i:s')
						)); 
?>