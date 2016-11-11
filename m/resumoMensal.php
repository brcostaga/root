<?php	
	require('functions/getJSON.php');	
	$query = "
      SELECT
            EXTRACT(DAY FROM a.dt_vencimento)        AS VENCIMENTO
            ,b.nm_conta                              AS CONTA
            ,a.vl_movimento                          AS VALOR
            ,d.nm_tipo                               AS TIPO
      FROM tb_movimentos a
      INNER JOIN tb_contas b ON a.cd_conta = b.cd_conta
      LEFT JOIN tb_grupos c ON c.cd_grupo = a.cd_grupo
      INNER JOIN tb_ds_tipo_contas d ON d.cd_tipo = b.cd_tipo
      WHERE
            a.cd_competencia = $_GET[cd_competencia]
            AND a.cd_grupo IS NULL
UNION
      SELECT
            EXTRACT(DAY FROM a.dt_vencimento)        AS VENCIMENTO
            ,b.nm_conta                              AS CONTA
            ,SUM(a.vl_movimento)                     AS VALOR
            ,'Despesa'                               AS TIPO
      FROM tb_movimentos a
      INNER JOIN tb_contas b ON a.cd_conta = b.cd_conta
      LEFT JOIN tb_grupos c ON c.cd_grupo = a.cd_grupo
      INNER JOIN tb_ds_tipo_contas d ON d.cd_tipo = b.cd_tipo
      WHERE
            a.cd_competencia = $_GET[cd_competencia]
            AND a.cd_grupo IS NOT NULL
      GROUP BY vencimento, conta
	";
	getJSON($query);      
?>