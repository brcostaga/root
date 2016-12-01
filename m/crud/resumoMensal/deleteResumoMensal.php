<?php  
//http://localhost/orcamento/m/crud/resumoMensal/deleteResumoMensal.php?cd_movimento=40
	require('../../functions/dml.php');  
	$cd_movimento = $_GET['cd_movimento'];	
	$statement = "
DELETE FROM tb_movimentos WHERE cd_movimento = $cd_movimento
    ";
    //echo $statement;
  	dml($statement);
?>