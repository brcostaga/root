<?php	
  // URL de teste
  //localhost/orcamento/m/resumoMensal.php?cd_competencia=201610
	require('functions/getJSON.php');  
	$query = "
SELECT
      EXTRACT(DAY FROM a.dt_vencimento)        AS VENCIMENTO
      ,b.nm_conta                              AS CONTA
      ,SUM(a.vl_movimento)                     AS VALOR
      ,CASE
            COALESCE(c.cd_grupo,'')
            WHEN '' THEN e.nm_categorias
      END                                      AS CATEGORIA
      ,(
        SELECT SUM(x.vl_movimento)
        FROM tb_movimentos x
        WHERE EXTRACT(DAY FROM x.dt_vencimento) <= EXTRACT(DAY FROM a.dt_vencimento)
      )                                        AS SALDO
      ,c.cd_grupo                              AS GRUPO
FROM tb_movimentos a
INNER JOIN tb_contas b ON a.cd_conta = b.cd_conta
LEFT JOIN tb_grupos c ON c.cd_grupo = a.cd_grupo
INNER JOIN tb_categorias e ON e.cd_categoria = a.cd_categoria
WHERE a.cd_competencia = $_GET[cd_competencia]
GROUP BY vencimento, conta, categoria, grupo
	";
	getJSON($query);      
?>