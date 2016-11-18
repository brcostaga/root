<?php
	header('Content-Type'.'text/plain');
	require('functions/getJSON.php');	
	$query = "
SELECT
      a.cd_competencia
      ,b.ds ||' de '||a.cp_ano AS nm_competencia
FROM
      tb_competencias a
JOIN tb_descritiva b ON
      b.nm_tabela = 'TB_COMPETENCIAS'
      AND b.nm_campo = 'CP_MES'
      AND b.cd = a.cp_mes
	";
	getJSON($query);
?>