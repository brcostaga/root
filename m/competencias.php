<?php
	header('Content-Type'.'text/plain');
	require('functions/getJSON.php');	
	$query = "
SELECT
      a.cd_competencia
      ,b.ds_cp_mes ||' de '||a.cp_ano AS nm_competencia
FROM
      tb_competencias a
JOIN tb_ds_cp_mes b ON a.cp_mes = b.cp_mes
	";
	getJSON($query);
?>