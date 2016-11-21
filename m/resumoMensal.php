<?php	
  // URL de teste
  //localhost/orcamento/m/resumoMensal.php?cd_competencia=201611
	require('functions/getJSON.php'); 
  $query = " SELECT * FROM resumoMensal($_GET[cd_competencia])"; 
	getJSON($query);      
?>