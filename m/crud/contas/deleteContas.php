<?php	
  // URL de teste
  //localhost/orcamento/m/crud/contas/deleteContas.php?cd_conta=32
  require('../../functions/dml.php');
  $cd_conta = $_GET['cd_conta'];  
  $statement = "DELETE FROM tb_contas WHERE cd_conta=$cd_conta;";  
  dml($statement);
?>