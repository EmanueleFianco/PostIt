<?php
require_once('../Entity/ECartella.php');
require_once('../Entity/ENota.php');
require_once('../Entity/ENotaCondivisa.php');
require_once('../Entity/EPartecipante.php');
require_once('../Entity/EUtente.php');
$n1=new ENota("Prima nota", "questa è una prima nota", "/Entity/ciao.png", 3, "#ff06f1");
$n2=new ENota("seconda nota", "questa e una seconda nota", "/Entity/cia.png", 3, "#f506f1");
$p1=new EPartecipante("Emanuele", "/Entity/Ciao.png", "emanuele.fianco@gmail.com");
$p2=new EPartecipante("Gioele", "/Entity/Ciao.png", "gioele.cicchini@gmail.com",TRUE);
$b[]=$p1;
$b[]=$p2;
$n3=new ENotaCondivisa("Prima nota condivisa", "questa è una nota condivisa", "/Entity/ciao.png", 3, "#ff06f1", $b);
$n3->Push($p1);
$a[]=$n1;
$a[]=$n2;
$a[]=$n3;
$cart=new ECartella(0, "Note", 4, "#f506f1", $a);
$utente=new EUtente("fabss","password","fabio","di sabatino","http://127.0.0.1/postIt","prova@example.com");


echo json_encode(array( "titolo"=>$n3->getTitolo(),
						"testo"=>$n3->getTesto(),
						"username"=>$utente->getUsername()
						)); 
?>