<?php
	function getJSON($query){
		require('pdo_con.php');		
		$ps = $con->prepare($query);
		$ps->execute();
		$rs = $ps->fetchAll(PDO::FETCH_OBJ);
		$json = json_encode($rs);
		echo $json;
	};
?>