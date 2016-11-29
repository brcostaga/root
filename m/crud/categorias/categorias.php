<?php    
  require('../../functions/getJSON.php'); 
  $query = "
SELECT * FROM tb_categorias
   "; 
  getJSON($query);
?>