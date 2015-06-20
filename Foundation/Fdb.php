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
	 	 require_once("../includes/config.inc.php");
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
	 
	 public function queryGenerica($_column,$_paragone,$_parametri = NULL,array $_operatori = NULL) {
	 	if (preg_match('/^[^,]+$/',$this->table)) {
	 		$sql = "SELECT ".$_column." FROM ".$this->table." WHERE ";
	 		if (is_array($_parametri)) {
	 			$sql = $sql.$this->keydb[0].$_paragone[0].$this->bind[0];
	 			foreach ($this->bind as $key => $valore) {
	 				if ($key != 0) {
	 					$_operatori[$key-1] = strtoupper($_operatori[$key-1]);
	 					if ($_operatori[$key-1] != 'ORDER BY') {
	 						$sql = $sql." ".$_operatori[$key-1]." ".$this->keydb[$key].$_paragone[$key].$valore;
	 					} else {
	 						$sql = $sql." ".$_operatori[$key-1]." ".$this->keydb[$key]." ".$this->keydb[$key+1];
	 					}	 						
	 				} 				
	 			}
	 			$query=$this->db->prepare($sql);
	 			foreach ($_parametri as $key => $valore) {
	 				$query->bindValue($this->bind[$key],$valore);
	 			}
	 		} else {
	 			$sql = $sql = $sql.$this->keydb.$_paragone.$this->bind;
	 			$query=$this->db->prepare($sql);
	 			$query->bindValue($this->bind,$_parametri);
	 		}
	 	} else {
	 		$sql = "SELECT ".$_column." FROM ".$this->table." WHERE ".$this->keydb[0].$_paragone[0].$this->keydb[1];
	 		if (isset($_parametri)) {
	 			foreach ($this->bind as $key => $valore) {
	 				if ($valore == -1) {
	 					$sql = $sql." ".$_operatori[$key]." ".$this->keydb[$key+2].$_paragone[0].$this->keydb[$key+3];
	 				} else {
	 					$_operatori[$key] = strtoupper($_operatori[$key]);
	 					$sql = $sql." ".$_operatori[$key]." ".$this->keydb[$key+2].$_paragone[$key+1].$valore;	 					
	 				}
	 			}
	 			$dim_bind = count($this->bind);
	 			if (isset($_operatori[$dim_bind]) && $_operatori[$dim_bind] == 'ORDER BY') {
	 				$sql = $sql." ORDER BY ".$this->keydb[$dim_bind+2]." ".$this->keydb[$dim_bind+3];
	 			}
	 			$query=$this->db->prepare($sql);
	 			foreach ($_parametri as $key => $valore) {
	 				$query->bindValue($this->bind[$key],$valore);
	 			}	
	 		} else {
	 			$query=$this->db->prepare($sql);
	 		}
	 	}
	 	$query->execute();
	 	$result=$query->fetchAll(PDO::FETCH_ASSOC);
	 	return $result;
	 }
	 
	 public function update($_value) {
	 	$sql = "UPDATE ".$this->table." SET ".$this->keydb[0]."=".$this->bind[0]." WHERE ".$this->keydb[1]."=".$this->bind[1];
	 	if (count($_value) == 3) {
	 		$sql = $sql." AND ".$this->keydb[2]."=".$this->bind[2];
	 		$query=$this->db->prepare($sql);
	 		$query->bindValue($this->bind[0],$_value[0]);
	 		$query->bindvalue($this->bind[1],$_value[1]);
	 		$query->bindvalue($this->bind[2],$_value[2]);
	 	} else {
	 		$query=$this->db->prepare($sql);
	 		$query->bindValue($this->bind[0],$_value[0]);
	 		$query->bindvalue($this->bind[1],$_value[1]);	 		
	 	}
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
	 
	 public function getDb() {
	 	return $this->db;
	 }
}
?>
