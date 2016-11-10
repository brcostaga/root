<?php
    class Database{
    	public static $connection;

        private static $dbtype   = "firebird";
        private static $host     = "127.0.0.1";
        private static $user     = "SYSDBA";
        private static $password = "masterkey";
        private static $db_name  = 'C:\xampp\firebird\ORCAMENTO.FDB';

        private function getDBType()  {return self::$dbtype;}
        private function getHost()    {return self::$host;}    
        private function getUser()    {return self::$user;}
        private function getPassword(){return self::$password;}
        private function getDBName()  {return self::$db_name;}	

    	public function __construct(){}     
        private function __clone(){}        
        public function __destruct() {        
            foreach ($this as $key => $value) {
                unset($this->$key);
            }
        }	
    	public function instance(){if(!self::$connection){self::$connection = $this->connect();}
    		return self::$connection;
    	}
    	private function connect(){
    		try{
                $sgbd = $this->getDBType();
                $host = $this->getHost();
                $user = $this->getUser();
                $dbname = $this->getDBName();
                $pass = $this->getPassword;

                $str_conn = "$sgbd:dbname=$dbname";
                $connection = new PDO($str_conn, $user, $pass);
             }
            catch (PDOException $i){            
                die("Erro: <code>" . $i->getMessage() . "</code>");
            } 
    		$connection->setAttribute(PDO::ATTR_ERRMODE, ERRMODE_EXCEPTION);
    		return $connection;
    	}    		
    }
?>