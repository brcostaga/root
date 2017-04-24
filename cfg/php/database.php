<?php
	include 'adodb/adodb.inc.php';	
	class database{
		
		private $driver = 'firebird';
		private $host = '127.0.0.1';
		private $dbname = 'C:\xampp\firebird\ORCAMENTO.FDB';
		private $user = 'SYSDBA';
		private $pass = 'masterkey';
		private $connection;
/*
		private $driver = 'firebird';
		private $host = '10.171.0.3';
		private $dbname = '//databases/SIAP2000_DIARIO.GDB';
		private $user = 'SYSDBA';
		private $pass = '';
		private $connection;
*/		
		public function __construct(){
			$this->connection = adoNewConnection($this->driver);
			$this->connection->connect(
					$this->host
					,$this->user
					,$this->pass
					,$this->dbname
			);
			$this->connection->setFetchMode(ADODB_FETCH_ASSOC);
			$this->connection->setCharset('utf8');			
		}		

		public function dml($statement,$params){
			echo $statement;
			print_r($params);
			$ps = $this->connection->prepare($statement);
			$this->connection->execute($ps,$params);
			$this->connection->close();
		}

		public function queryToJSON($query){			
			$result = $this->connection->execute($query);
			$arr = array();
			$rs = array();
			while (!$result->EOF){	    
			    $result->fetchInto($arr);	    
			    $arr = array_map('htmlentities',$arr);
			    array_push($rs,$arr);
			}		
			$json = html_entity_decode(json_encode($rs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES |  JSON_PRETTY_PRINT));	
			echo $json;
			$this->connection->close();
		}
		
		public function query1ToJSON($query,$params){
			$ps = $this->connection->prepare($query);			
			$result = $this->connection->execute($ps,$params);
			$arr = array();
			$rs = array();
			while (!$result->EOF){	    
			    $result->fetchInto($arr);	    
			    $arr = array_map('htmlentities',$arr);
			    array_push($rs,$arr);
			}		
			$json = html_entity_decode(json_encode($rs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES |  JSON_PRETTY_PRINT));	
			echo $json;
			$this->connection->close();
		}
	}
?>