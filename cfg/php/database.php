<?php
	include 'adodb/adodb.inc.php';	
	class database{
		private $driver = 'firebird';
		private $host = '127.0.0.1';
		private $dbname = 'C:\xampp\firebird\ORCAMENTO.FDB';
		private $user = 'SYSDBA';
		private $pass = 'masterkey';
		private $connection;

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

		public function dml($statement){
			$this->connection->execute($statement);
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
			$json = html_entity_decode(json_encode($rs, JSON_UNESCAPED_UNICODE));	
			echo $json;
			$this->connection->close();
		}
	}
?>