<?php  
  require('../../functions/getJSON.php'); 
  $query = " SELECT * FROM resumoMensal($_GET[cd_competencia])"; 
  getJSON($query);      
?>