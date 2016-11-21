<?php
	function getJSON($query){
		require('pdo_con.php');
		header("Content-Type: text/html; charset=UTF-8",true);
		
		$ps = $con->prepare($query);
		$ps->execute();
		$rs = $ps->fetchAll(PDO::FETCH_OBJ);			
		$json = json_encode($rs, JSON_UNESCAPED_UNICODE);
		echo $json;
	};
?>