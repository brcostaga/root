<?php	
  // URL de teste
  //localhost/orcamento/m/crud/contas/putContas.php?nm_conta=teste&cd_tipo=3
  require('../../functions/dml.php');
  $nm_conta = $_GET['nm_conta'];
  $cd_tipo  = $_GET['cd_tipo'];
  $statement = "INSERT INTO tb_contas (nm_conta,cd_tipo) VALUES('$nm_conta',$cd_tipo);";  
  dml($statement);
?>