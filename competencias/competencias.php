<?php
	require('../cfg/php/database.php');
	class competencia{
		private $cd_competencia;
		private $cp_ano;
		private $cp_mes;
		private $st_competencia;
		private $saldo_inicial;
		private $saldo_final;

		public function __construct($cd_competencia, $cp_ano, $cp_mes, $st_competencia, $saldo_inicial,$saldo_final){
			$this->cd_competencia 	= $cd_competencia;
			$this->cp_ano 			= $cp_ano;
			$this->cp_mes 			= $cp_mes;
			$this->st_competencia	= $st_competencia;
			$this->saldo_inicial	= $saldo_inicial;
			$this->saldo_final		= $saldo_final;
		}

		public function crud($crud){
			$con = new database;
			$statement = array(
				 "c" => ""				
				,"u" => ""
				,"d" => ""
				,"r" => "
SELECT
      a.cd_competencia
      ,b.ds ||' de '||a.cp_ano AS nm_competencia
FROM
      tb_competencias a
JOIN tb_descritiva b ON
      b.nm_tabela = 'TB_COMPETENCIAS'
      AND b.nm_campo = 'CP_MES'
      AND b.cd = a.cp_mes
				"
			);		 	 			
			switch ($crud) {
				case 'c': break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': break;	
				case 'd': break;
			}
		}
	}

	$cd_competencia = null;
	$cp_ano = null;
	$cp_mes = null;
	$st_competencia = null;
	$saldo_inicial = null;
	$saldo_final = null;

	if(isset($_GET['cd_competencia']))		$cd_competencia 		= $_GET['cd_competencia'];
	if(isset($_GET['cp_ano']))				$cp_ano 				= $_GET['cp_ano'];
	if(isset($_GET['cp_mes']))				$cp_mes 				= $_GET['cp_mes'];
	if(isset($_GET['st_competencia']))		$st_competencia 		= $_GET['st_competencia'];
	if(isset($_GET['saldo_inicial']))		$saldo_inicial 			= $_GET['saldo_inicial'];
	if(isset($_GET['saldo_final']))			$saldo_final 			= $_GET['saldo_final'];

	$crud = $_GET['crud'];
	$competencia = new competencia($cd_competencia, $cp_ano, $cp_mes, $st_competencia, $saldo_inicial,$saldo_final);
	$competencia->crud($crud);
?>