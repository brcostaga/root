<?php  
//http://localhost/orcamento/m/crud/resumoMensal/postResumoMensal.php?cd_movimento=39&cd_categoria=8&cd_competencia=201611&cd_conta=19&cd_parcela=0&ds_historico=teste&dt_movimento=10.11.2016&dt_vencimento=10.11.2016&qt_parcelas=0&vl_movimento=67.49
	require('../../functions/dml.php'); 
  $cd_movimento = $_GET['cd_movimento']; 
	$cd_categoria = $_GET['cd_categoria'];
	$cd_conta = $_GET['cd_conta'];
	$vl_movimento = $_GET['vl_movimento'];	
	$dt_vencimento = $_GET['dt_vencimento'];
	$cd_competencia =  $_GET['cd_competencia'];	
	$statement = "
UPDATE tb_movimentos
SET
      cd_categoria = $cd_categoria,
      cd_conta = $cd_conta,
      vl_movimento = $vl_movimento,      
      dt_vencimento = '$dt_vencimento',
      cd_competencia = '$cd_competencia'
WHERE cd_movimento = $cd_movimento
    ";
    //echo $statement;
  	dml($statement);
?>