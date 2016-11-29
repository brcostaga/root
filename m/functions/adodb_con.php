<?php	
	include 'adodb/adodb.inc.php';	
	$driver = 'firebird';
	$host = '127.0.0.1';
	$dbname = 'C:\xampp\firebird\ORCAMENTO.FDB';
	$user = 'SYSDBA';
	$pass = 'masterkey';	
	$con     = adoNewConnection($driver);	
	$con->connect($host,$user,$pass,$dbname);
	$con->setFetchMode(ADODB_FETCH_ASSOC);
	$con->setCharset('utf8');
?>