<?php
	function dml($statement){
		require('pdo_con.php');		
		header("Content-Type: text/html'; charset=UTF-8",true);		
		$ps = $con->prepare($statement);
		$ps->execute();
	};
?>