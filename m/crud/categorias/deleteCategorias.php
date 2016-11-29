<?php	
  require('../../functions/dml.php');
  $cd_categoria = $_GET['cd_categoria'];  
  $statement = "DELETE FROM tb_categorias WHERE cd_categoria=$cd_categoria;";  
  dml($statement);
?>