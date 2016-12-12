<?php    
  require('../../functions/database.php');
  //require('../../functions/getJSON.php');
  $query = "
SELECT
      a.cd_conta,
      a.nm_conta,
      b.ds AS DS_TIPO
FROM
      tb_contas a  
JOIN tb_descritiva b ON b.nm_tabela = 'TB_CONTAS' AND b.nm_campo = 'CD_TIPO' AND a.cd_tipo = b.cd
   "; 
  //getJSON($query);
   $con = new database;
   $con->queryToJSON($query); 
?>