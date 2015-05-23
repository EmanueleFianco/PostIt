<?php
require_once('../Entity/ECartella.php');
require_once('../Entity/ENota.php');
require_once('../Entity/EUtente.php');
$n1=new ENota("Prima nota", "questa è una prima nota", "/Entity/ciao.png", 3, "#ff06f1");
$n2=new ENota("seconda nota", "questa e una seconda nota", "/Entity/cia.png", 3, "#f506f1");
$a[]=$n1;
$a[]=$n2;
$cart=new ECartella(0, "Note", 4, "#f506f1", $a);
$utente=new EUtente("fabss","password","fabio","di sabatino","http://127.0.0.1/postIt","prova@example.com");

echo json_encode(array( "titolo"=>$n1->getTitolo(),
						"testo"=>$n1->getTesto(),
						"username"=>$utente->getUsername()		
						)); 
?>