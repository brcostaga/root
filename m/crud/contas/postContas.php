<?php	
  // URL de teste
  //localhost/orcamento/m/crud/contas/postContas.php?nm_conta=teste2&cd_tipo=2&cd_conta=39
  require('../../functions/dml.php');
  $cd_conta = $_GET['cd_conta'];  
  $nm_conta = $_GET['nm_conta'];
  $cd_tipo = $_GET['cd_tipo'];
  $statement = "UPDATE tb_contas SET nm_conta = '$nm_conta', cd_tipo = $cd_tipo WHERE cd_conta=$cd_conta;";  
  dml($statement);
?>