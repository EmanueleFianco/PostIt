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
	    echo ("problem");
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
	 
	 public function loadAsArray($_column,$_value)
	 {   
	     $query=$this->db->prepare("SELECT ".$_column." FROM ".$this->table." WHERE ".$this->keydb." = ".$this->bind);
	     $query->bindValue($this->bind,$_value);
	     $query->execute();
	     $result=$query->fetchAll();
	     return $result;
	 }

}
?>