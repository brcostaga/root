<?php
	function dml($statement){		
		require('adodb_con.php');
		$con->execute($statement);
	};
?>