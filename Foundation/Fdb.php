<?php
/**
 *
 * Classe Fdb che gestisce i rapporti con il database
 * @package Foundation
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 *
 */
class Fdb 
{
	/**
	 * @var PDO $db Mantiene la connessione al database
	 */
	 protected $db;
	 /**
	  * @var string $table Mantiene il nome della tabella attiva
	  */
	 protected $table;
	 /**
	  * @var string|array Mantiene le chiavi della tabella attiva o le chiavi della query da eseguire
	  */
	 protected $keydb;
	 /**
	  * @var string $bind Mantiene i segnaposto per i parametri reali della query da effettuare
	  */
	 protected $bind;
	 /**
	  * @var bool $auto_incremente Indica se la tabella dove si sta lavorando utilizza id auto_increment
	  */
	 protected $auto_increment = FALSE;
	 
	 /**
	  * Costruttore di Fdb che attiva la connessione
	  */
	 public function __construct()
	 {  
	 	 require_once("../includes/config.inc.php");
	     try
	     {
	     	$attributi = array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        $col = "$dbms:host=".$config[$dbms]['host'].";dbname=".$config[$dbms]['database'];
	        $this->db = new PDO($col, $config[$dbms]['user'], $config[$dbms]['password'],$attributi);
	
	      }
	     catch(PDOException $e) {
	    	echo "Errore durante la connessione al database!: ".$e->getMessage();
	      }  
	 }
	 /**
	  * Setta i parametri per la prossima query da effettuare
	  * @param string $_table Tabella/e che sono coinvolte nella prossima query
	  * @param string|array $_keydb Campo/i che sono coinvolti nella prossima query
	  * @param string|array $_bind Segnaposti che verranno rimpiazzati dai parametri reali nella prossima query
	  */
	 public function setParam($_table,$_keydb,$_bind)
	 {
	    $this->table=$_table;
	    $this->keydb=$_keydb;
	    $this->bind=$_bind;
	 }
	 /**
	 * Inserisce nel database una tupla
	 * @param array $data Contiene come chiavi le stesse dei segnaposto e come valori i parametri reali
	 */
	 public function inserisci($data)
	 {  
	 	if ($this->auto_increment) {
	 		unset($data['id']);
	 	}
	    $query=$this->db->prepare("INSERT INTO ".$this->table."\n".$this->keydb." VALUES ".$this->bind);
	    try {
	    	$result = $query->execute($data);
	    } catch (PDOException $e) {
	    	echo 'Error: '.$e->getMessage();
	    }
	    return $result;
	
	 }
	 /**
	  * Setta i parametri per la prossima query da effettuare
	  * @param string $_column Colonne da selezionare
	  * @param string|array $_paragone Array contenente in ordine i paragoni che si vogliono effettuare nelle condizioni (=,>,<,>=,<=)
	  * @param string|array $_parametri Parametri effettivi della query
	  * @param array $_operatori Operatori logici da applicare in caso ci siano più condizioni (AND,OR,ORDER BY)
	  * @return array $result Risultato della query effettuata
	  */
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
	 	try {
	 		$query->execute();
	 		$result=$query->fetchAll(PDO::FETCH_ASSOC);
	 	} catch (PDOException $e) {
	    	echo 'Error: '.$e->getMessage();
	    }
	 	return $result;
	 }
	 /**
	  * Aggiorna nel database una tupla
	  * @param array $_value Contiene come chiavi le stesse dei segnaposto e come valori i parametri reali
	  * @return int $result 1 se andata a buon fine, 0 altrimenti
	  */
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
	 	try {
	 		$query->execute();
	 		$result=$query->rowCount();
	 	} catch (PDOException $e) {
	 		echo 'Error: '.$e->getMessage();
	 	}
	 	return $result;
	 }
	 /**
	  * Elimina nel database una tupla
	  * @param array $_value Contiene come chiavi le stesse dei segnaposto e come valori i parametri reali
	  * @return int $result 1 se andata a buon fine, 0 altrimenti
	  */
	 public function delete($_value) {
	 	$sql = "DELETE FROM ".$this->table." WHERE ".$this->keydb."=".$this->bind;
	 	$query=$this->db->prepare($sql);
	 	$query->bindValue($this->bind,$_value);
	 	try {
	 		$query->execute();
	 		$result=$query->rowCount();
	 	} catch (PDOException $e) {
	 		echo 'Error: '.$e->getMessage();
	 	}
	 	return $result;
	 }
	 /**
	  * Ritorna la maniglia al PDO
	  * @return Ritorna la maniglia al PDO
	  */
	 public function getDb() {
	 	return $this->db;
	 }
}
?>
