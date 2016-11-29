<?php	
  require('../../functions/dml.php');
  $cd_categoria = $_GET['cd_categoria'];  
  $nm_categorias = $_GET['nm_categorias'];
  $cd_categoria_pai = $_GET['cd_categoria_pai'];
  $statement = "
  UPDATE tb_categorias 
  SET 
  	nm_categorias = '$nm_categorias'
  	,cd_categoria_pai = $cd_categoria_pai 
  WHERE cd_categoria=$cd_categoria;";  
  dml($statement);
?>