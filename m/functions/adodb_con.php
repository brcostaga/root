<?php	
	include 'adodb/adodb.inc.php';
	//header("Content-Type: text/html'; charset=UTF-8",true);
	//header('Content-Type: application/json; charset=utf-8');
	$driver = 'firebird';
	$host = '127.0.0.1';
	$dbname = 'C:\xampp\firebird\ORCAMENTO.FDB';
	$user = 'SYSDBA';
	$pass = 'masterkey';
	$charset = 'charset=utf8;';
	$DSN    = "user:password@localhost/employees";
// CONNECTION METHOD 1	
	$con     = adoNewConnection($driver);	
	$con->connect($host,$user,$pass,$dbname);
	$con->setFetchMode(ADODB_FETCH_ASSOC);
	$con->setCharset('utf8');
// CONNECTION METHOD 2	
//	$db     = adoNewConnection($driver + '://' + $DSN);

// TEST STATEMENT 
/*	
	$query = 'SELECT cd_conta,nm_conta,cd_tipo FROM tb_contas WHERE cd_conta = 2';
	$rs = $con->getAll($query);
	$json = json_encode($rs, JSON_UNESCAPED_UNICODE);
	echo $json;
*/
	$SQL = "SELECT * FROM tb_contas";
	$result = $con->execute($SQL);
	$arr = array();
	$rs = array();
	while (!$result->EOF){	    
	    $result->fetchInto($arr);	    
	    $arr = array_map('htmlentities',$arr);
	    array_push($rs,$arr);
	}		
	$json = html_entity_decode(json_encode($rs));	
	echo $json;	
		
	
// URL de teste
//localhost/orcamento/m/functions/adodb_con.php
?>