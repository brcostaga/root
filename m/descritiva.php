<?php
      // URL de teste
      //http://localhost/orcamento/m/descritiva.php?nm_tabela='TB_CONTAS'&nm_campo='CD_TIPO'
	header('Content-Type'.'text/plain');
	require('functions/getJSON.php');	
	$query = "
SELECT
      a.cd
      ,a.ds
FROM
      tb_descritiva a
WHERE
      a.nm_tabela =  $_GET[nm_tabela] 
      AND a.nm_campo = $_GET[nm_campo]
	";
	getJSON($query);
?>