<?php	
	$sgbd = 'firebird';
	$host = '127.0.0.1;';
	$dbname = 'C:\xampp\firebird\ORCAMENTO.FDB;';
	$user = 'SYSDBA';
	$pass = 'masterkey';
	$charset = 'charset=utf8;';		
	$str_conn = "$sgbd:host=$host dbname=$dbname $charset";
	try {		
		$con = new PDO($str_conn, $user, $pass);			
	} catch (PDOException $e) {
		print "Error!: ".$e->getMessage()."<br/>";
		die();
	}
?>