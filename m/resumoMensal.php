<?php	
  // URL de teste
  //localhost/orcamento/m/resumoMensal.php?cd_competencia=201611
	require('functions/getJSON.php');  
	$query = "
SELECT
      a.cd_linha                               AS LINHA
      ,EXTRACT(DAY FROM a.dt_vencimento)       AS VENCIMENTO
      ,b.cd_conta                              AS CD_CONTA
      ,b.nm_conta                              AS CONTA
      ,b.cd_tipo                               AS TIPO_CONTA
      ,SUM(a.vl_movimento)                     AS VALOR
      ,CASE b.cd_tipo
            WHEN 2 THEN ''
            ELSE e.nm_categorias
      END                                      AS CATEGORIA
      ,(
        SELECT SUM(x.vl_movimento)
        FROM tb_movimentos x
        WHERE
            EXTRACT(DAY FROM x.dt_vencimento) <= EXTRACT(DAY FROM a.dt_vencimento)
            AND x.cd_linha <= a.cd_linha
      )                                        AS SALDO

FROM tb_movimentos a
INNER JOIN tb_contas b ON a.cd_conta = b.cd_conta
INNER JOIN tb_categorias e ON e.cd_categoria = a.cd_categoria
WHERE a.cd_competencia = $_GET[cd_competencia]
GROUP BY linha, vencimento, cd_conta, conta, tipo_conta,categoria
	";
	getJSON($query);      
?>