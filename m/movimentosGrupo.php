<?php	
      // URL de teste
      //localhost/orcamento/m/movimentosGrupo.php?cd_competencia=201610&cd_grupo=2
	require('functions/getJSON.php');	
	$query = "
SELECT
      LPAD(EXTRACT(DAY FROM a.dt_movimento),2,0)
      ||'/'||
      LPAD(EXTRACT(MONTH FROM a.dt_movimento),2,0)
      ||'/'||
      EXTRACT(YEAR FROM a.dt_movimento)        AS DATA_MOVIMENTO
      ,a.ds_historico                          AS HISTORICO
      ,a.cd_parcela||'/'||a.qt_parcelas        AS PARCELA
      ,a.vl_movimento                          AS VALOR
      ,e.nm_categorias                         AS CATEGORIA
      ,c.cd_grupo
FROM tb_movimentos a
INNER JOIN tb_contas b ON a.cd_conta = b.cd_conta
INNER JOIN tb_grupos c ON c.cd_grupo = a.cd_grupo
INNER JOIN tb_ds_tipo_contas d ON d.cd_tipo = b.cd_tipo
INNER JOIN tb_categorias e ON e.cd_categoria = a.cd_categoria
WHERE
      a.cd_competencia = $_GET[cd_competencia]      
      AND c.cd_grupo = $_GET[cd_grupo]
ORDER BY a.dt_movimento
	";
	getJSON($query);    
?>