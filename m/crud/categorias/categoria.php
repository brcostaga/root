<?php
  require('../cfg/php/database.php');
  $query = "
SELECT * FROM tb_categorias
   "; 
  getJSON($query);
?>