SELECT
      b.nm_conta
      ,a.vl_movimento                                    
      ,a.dt_movimento                                    
      ,c.nm_grupo                                          
/*      
      ,CASE b.ic_tipo_receita_despesa
            WHEN 'R' THEN 'Receita'
            WHEN 'D' THEN 'Despesa'
      END                                                      AS TIPO
*/
FROM tb_movimentos a
INNER JOIN tb_contas b ON a.cd_conta = b.cd_conta
INNER JOIN tb_grupos c ON c.cd_grupo = a.cd_grupo