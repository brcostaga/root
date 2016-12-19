<?php
	require('../../../cfg/php/database.php');
	class resumoMensal{
		private $cd_movimento;
		private $cd_categoria;
		private $cd_conta;
		private $vl_movimento;
		private $dt_vencimento;
		private $cd_competencia;
		private $cd_recurso;
		private $dt_movimento;
		private $ds_historico;
		private $cd_parcela;
		private $qt_parcelas;

		public function __construct($cd_movimento, $cd_categoria, $cd_conta, $vl_movimento,$dt_movimento, $dt_vencimento, $cd_competencia, $cd_recurso, $ds_historico, $cd_parcela, $qt_parcelas){
			$this->cd_movimento 	= $cd_movimento;
			$this->cd_categoria 	= $cd_categoria;
			$this->cd_conta 		= $cd_conta;
			$this->vl_movimento 	= $vl_movimento;
			$this->dt_vencimento 	= $dt_vencimento;
			$this->cd_competencia 	= $cd_competencia;
			$this->cd_recurso 		= $cd_recurso;
			$this->dt_movimento 	= $dt_movimento;
			$this->ds_historico 	= $ds_historico;
			$this->cd_parcela 		= $cd_parcela;
			$this->qt_parcelas 		= $qt_parcelas;
		}

		public function crud($crud){
			$con = new database;

			$cd_movimento 	= $this->cd_movimento;
			$cd_categoria 	= $this->cd_categoria;
			$cd_conta 		= $this->cd_conta;
			$vl_movimento 	= $this->vl_movimento;
			$dt_vencimento 	= $this->dt_vencimento;
			$cd_competencia = $this->cd_competencia;
			$cd_recurso 	= $this->cd_recurso;
			$dt_movimento 	= $this->dt_movimento;
			$ds_historico 	= $this->ds_historico;
			$cd_parcela 	= $this->cd_parcela;
			$qt_parcelas 	= $this->qt_parcelas;

			$statement = array(
				"c" => "INSERT INTO tb_movimentos (cd_categoria,cd_conta,vl_movimento,dt_movimento,dt_vencimento,cd_competencia,cd_recurso,ds_historico,cd_parcela,qt_parcelas)	VALUES (?,?,?,?,?,?,?,?,?,?)"
				,"u" => "
					UPDATE tb_movimentos
					SET
						cd_categoria = ?
						,cd_conta = ?
						,vl_movimento = ?
						,dt_vencimento = ?
						,cd_competencia = ?
						,cd_recurso = ?
						,dt_movimento = ?
						,ds_historico = ?
						,cd_parcela = ?
						,qt_parcelas = ?
					WHERE cd_movimento = ?
				"
				,"d" => "DELETE FROM tb_movimentos WHERE cd_movimento = ?"
				,"r" => "SELECT * FROM resumoMensal($this->cd_competencia)"
			);		 	 			
			switch ($crud) {
				case 'c':
					$params = [$cd_categoria, $cd_conta, $vl_movimento,$dt_movimento, $dt_vencimento, $cd_competencia, $cd_recurso, $ds_historico, $cd_parcela, $qt_parcelas];
					$con->dml($statement["c"],$params);break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': 
					$params = [$cd_movimento, $cd_categoria, $cd_conta, $vl_movimento,$dt_movimento, $dt_vencimento, $cd_competencia, $cd_recurso, $ds_historico, $cd_parcela, $qt_parcelas];
					$con->dml($statement["u"],$params);break;	
				case 'd': 
					$params = [$cd_movimento];
					$con->dml($statement["d"],$params);break;
			}
		}
	}

	$cd_movimento 	= null;
	$cd_categoria 	= null;
	$cd_conta 		= null;
	$vl_movimento 	= null;
	$dt_movimento 	= null;
	$dt_vencimento 	= null;
	$cd_competencia = null;
	$cd_recurso 	= null;	
	$ds_historico	= null;
	$cd_parcela 	= null;
	$qt_parcelas 	= null;

	if(isset($_GET['cd_movimento']))		$cd_movimento 		= $_GET['cd_movimento'];	
	if(isset($_GET['cd_categoria']))		$cd_categoria 		= $_GET['cd_categoria'];
	if(isset($_GET['cd_conta']))			$cd_conta 			= $_GET['cd_conta'];
	if(isset($_GET['vl_movimento']))		$vl_movimento 		= $_GET['vl_movimento'];	
	if(isset($_GET['dt_movimento']))		$dt_movimento 		= $_GET['dt_movimento'];
	if(isset($_GET['dt_vencimento']))		$dt_vencimento 		= $_GET['dt_vencimento'];
	if(isset($_GET['cd_competencia']))		$cd_competencia 	= $_GET['cd_competencia'];	
	if(isset($_GET['cd_recurso']))			$cd_recurso 		= $_GET['cd_recurso'];
	if(isset($_GET['ds_historico']))		$ds_historico 		= $_GET['ds_historico'];
	if(isset($_GET['cd_parcela']))			$cd_parcela 		= $_GET['cd_parcela'];	
	if(isset($_GET['qt_parcelas']))			$qt_parcelas 		= $_GET['qt_parcelas'];	

	$crud = $_GET['crud'];
	$resumoMensal = new resumoMensal($cd_movimento, $cd_categoria, $cd_conta, $vl_movimento,$dt_movimento, $dt_vencimento, $cd_competencia, $cd_recurso, $ds_historico, $cd_parcela, $qt_parcelas);
	$resumoMensal->crud($crud);	
?>