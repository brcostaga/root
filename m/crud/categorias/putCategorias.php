<?php	
  require('../../functions/dml.php');
  $nm_categorias = $_GET['nm_categorias'];
  $cd_categoria_pai = $_GET['cd_categoria_pai'];
  $statement = "INSERT INTO tb_categorias (nm_categorias,cd_categoria_pai) VALUES('$nm_categorias',$cd_categoria_pai);";  
  dml($statement);
?>