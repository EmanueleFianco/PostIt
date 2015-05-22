<?php
require_once('Entity/ECartella.php');
require_once('Entity/ENota.php');
$n1=new ENota("12 Ci'ao ", "Ciao sono Emanuele", "/Entity/ciao.png", 3, "#ff06f1");
$n2=new ENota("12 Ci'ao ", "Ciao Emanuele", "/Entity/cia.png", 3, "#f506f1");
$a[]=$n1;
$a[]=$n2;
$cart=new ECartella(0, "Prova", 4, "#f506f1", $a);
$n3=new ENota("12 Ci'ao ", "Ciao Emanuele", "/Entity/cia.png", 3, "#f506f1");
$cart->Push($n3);
var_dump($cart);
print ($n1->getColore());
print($n1->getImmagine());
print($n1->getPosizione());
print($n1->getTesto());
print($n1->getTitolo());
$n1->setId(4);
print($n1->getId());
print($cart->getId());
print($cart->getNome());
print($cart->getPosizione());
print($cart->getColore());
print_r($cart->getContenuto());

//aggiungo commento Sono Gioele!!

?>