<?php  
//http://localhost/orcamento/m/crud/resumoMensal/putResumoMensal.php?cd_categoria=8&cd_conta=19&vl_movimento=67.49&dt_movimento='10.11.2016'&dt_vencimento='10.11.2016'&cd_competencia='201611'&ds_historico='teste'&cd_parcela=0&qt_parcelas=0

//http://localhost/orcamento/m/crud/resumoMensal/putResumoMensal.php?cd_categoria=8&cd_competencia=201611&cd_conta=19&cd_parcela=0&ds_historico=teste&dt_movimento=10.11.2016&dt_vencimento=10.11.2016&qt_parcelas=0&vl_movimento=67.49
	require('../../functions/dml.php');  
  	$cd_categoria = $_GET['cd_categoria'];
  	$cd_conta = $_GET['cd_conta'];
  	$vl_movimento = $_GET['vl_movimento'];
  	$dt_movimento = $_GET['dt_movimento'];
  	$dt_vencimento = $_GET['dt_vencimento'];
  	$cd_competencia = $_GET['cd_competencia'];
  	$ds_historico = $_GET['ds_historico'];
  	$cd_parcela = $_GET['cd_parcela'];
  	$qt_parcelas = $_GET['qt_parcelas'];
	$statement = "
INSERT INTO tb_movimentos (
    cd_categoria
    ,cd_conta
    ,vl_movimento
    ,dt_movimento
    ,dt_vencimento
    ,cd_competencia
    ,ds_historico
    ,cd_parcela
    ,qt_parcelas
)
VALUES (
	$cd_categoria
  	,$cd_conta
  	,$vl_movimento
  	,'$dt_movimento'
  	,'$dt_vencimento'
  	,'$cd_competencia'
  	,'$ds_historico'
  	,$cd_parcela
  	,$qt_parcelas
)
    ";
    //echo $statement;
  	dml($statement);
?>