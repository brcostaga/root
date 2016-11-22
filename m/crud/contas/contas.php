<?php	
  // URL de teste
  //localhost/orcamento/m/crud/contas/contas.php
  require('../../functions/getJSON.php'); 
  $query = " SELECT * FROM tb_contas"; 
  getJSON($query);
?>