<?php

class Fdb 
{
	 protected $db;
	 protected $table;
	 protected $keydb;
	 protected $bind;
	 protected $auto_increment = FALSE;
	 
	 
	  
	 public function __construct()
	 {  
	 	 require_once("Utility/config.inc.php");
	     try
	     {
	        $col = "$dbms:host=".$config[$dbms]['host'].";dbname=".$config[$dbms]['database'];
	        $this->db = new PDO($col, $config[$dbms]['user'], $config[$dbms]['password']);
	
	      }
	     catch(PDOException $e) {
	    	die("Errore durante la connessione al database!: ". $e->getMessage());
	      }
	    
	     
	        
	 }
	
	 public function setParam($_table,$_keydb,$_bind)
	 {
	    $this->table=$_table;
	    $this->keydb=$_keydb;
	    $this->bind=$_bind;
	 }
	 
	 public function inserisci($data)
	 {  
	 	if ($this->auto_increment) {
	 		unset($data['id']);
	 	}
	    $query=$this->db->prepare("INSERT INTO ".$this->table."\n".$this->keydb." VALUES ".$this->bind);
	    $query->execute($data);
	
	 }
	 
	 public function loadAsArray($_column,$_value,$_posizione_iniziale = NULL,$_posizione_finale = NULL,$_tipo_ordinamento = NULL)
	 {
	 	 $sql = "SELECT ".$_column." FROM ".$this->table." WHERE ";
	 	 if (!is_array($this->keydb)) {
	 	 	$sql = $sql.$this->keydb." = ".$this->bind;
	 	 	$query=$this->db->prepare($sql);
	 	 	$query->bindValue($this->bind,$_value);
	 	 } else {
	 	 	if (!isset($_posizione_finale)) {
	 	 		$_posizione_finale = $_posizione_iniziale + 100;
	 	 	}
	 	 	$sql = $sql.$this->keydb[0]." = ".$this->bind[0]." AND ".$this->keydb[1]." >= ".$this->bind[1]. " AND ".$this->keydb[1]." < ".$this->bind[2]." GROUP BY ".$this->keydb[1]." ORDER BY ".$this->keydb[1];
	 	 	if (isset($_tipo_ordinamento)) {
	 	 		$sql = $sql." ".$this->keydb[2];
	 	 	}
	 	 	$query=$this->db->prepare($sql);
	 	 	$query->bindValue($this->bind[0],$_value);
	 	 	$query->bindValue($this->bind[1],$_posizione_iniziale);
	 	 	$query->bindValue($this->bind[2],$_posizione_finale);
	 	 }
	     $query->execute();
	     $result=$query->fetchAll(PDO::FETCH_ASSOC);
	     return $result;
	 }
	 

	 public function queryJoin($_column,$_value) { 	
	 	$query=$this->db->prepare("SELECT ".$_column." FROM ".$this->table." WHERE ".$this->keydb[0]."=".$this->keydb[1]." AND ".$this->keydb[2]."=".$this->bind);
	 	$query->bindValue($this->bind,$_value,PDO::PARAM_INT);
	 	$query->execute();
	 	$result=$query->fetchAll(PDO::FETCH_ASSOC);
	 	return $result;
	 }
	 
	 public function update($_value) {
	 	$sql = "UPDATE ".$this->table." SET ".$this->keydb[0]."=".$this->bind[0]." WHERE ".$this->keydb[1]."=".$this->bind[1];
	 	$query=$this->db->prepare($sql);
	 	$query->bindValue($this->bind[0],$_value[0]);
	 	$query->bindvalue($this->bind[1],$_value[1]);
	 	$query->execute();
	 	$result=$query->rowCount();
	 	return $result;
	 }
	 
	 public function delete($_value) {
	 	$sql = "DELETE FROM ".$this->table." WHERE ".$this->keydb."=".$this->bind;
	 	$query=$this->db->prepare($sql);
	 	$query->bindValue($this->bind,$_value);
	 	$query->execute();
	 	$result=$query->rowCount();
	 	return $result;
	 }
}
?>
