<?php
	header('Content-Type'.'text/plain');
	require('functions/getJSON.php');	
	$query = "
SELECT cd_grupo, nm_grupo FROM tb_grupos
	";
	getJSON($query);
?>