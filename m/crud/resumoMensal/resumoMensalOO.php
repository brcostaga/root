<?php
	require('../cfg/php/database.php');
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

		public function __construct($p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11){
			$this->cd_movimento = 	$p1;
			$this->cd_categoria =	$p2;
			$this->cd_conta = 		$p3;
			$this->vl_movimento = 	$p4;
			$this->dt_vencimento = 	$p5;
			$this->cd_competencia = $p6;
			$this->cd_recurso =		$p7;
			$this->dt_movimento = 	$p8;
			$this->ds_historico = 	$p9;
			$this->cd_parcela = 	$p10;
			$this->qt_parcelas = 	$p11;
		}

		public function crud($crud){
			$con = new database;
			$statement = array(
				"c" => "
					INSERT INTO tb_movimentos (
					    cd_categoria
					    ,cd_conta
					    ,vl_movimento
					    ,dt_movimento
					    ,dt_vencimento
					    ,cd_competencia
					    ,cd_recurso
					    ,ds_historico
					    ,cd_parcela
					    ,qt_parcelas
					)
					VALUES (
						$this->cd_categoria
					  	,$this->cd_conta
					  	,$this->vl_movimento
					  	,'$this->dt_movimento'
					  	,'$this->dt_vencimento'
					  	,'$this->cd_competencia'
					  	,$this->cd_recurso
					  	,'$this->ds_historico'
					  	,$this->cd_parcela
					  	,$this->qt_parcelas
					)
				"
				,"u" => "
					UPDATE tb_movimentos
					SET
					      cd_categoria = $this->cd_categoria,
					      cd_conta = $this->cd_conta,
					      vl_movimento = $this->vl_movimento,      
					      dt_vencimento = '$this->dt_vencimento',
					      cd_competencia = '$this->cd_competencia'
					      cd_recurso = $this->cd_recurso
					      dt_movimento = $this->dt_movimento
					      ds_historico = '$this->ds_historico'
					      cd_parcela = $this->cd_parcela
					      qt_parcelas = $this->qt_parcelas
					WHERE cd_movimento = $this->cd_movimento	
				"
				,"d" => "DELETE FROM tb_movimentos WHERE cd_movimento = $this->cd_movimento"
				,"r" => "SELECT * FROM resumoMensal($this->cd_competencia)"
			);		 	 			
			switch ($crud) {
				case 'c': $con->dml($statement["c"]);break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': $con->dml($statement["u"]);break;	
				case 'd': $con->dml($statement["d"]);break;
			}
		}
	}

	$cd_movimento = null;
	$cd_categoria = null;
	$cd_conta = null;
	$vl_movimento = null;
	$dt_vencimento = null;
	$cd_competencia = null;
	$cd_recurso = null;
	$dt_movimento = null;
	$ds_historico = null;
	$cd_parcela = null;
	$qt_parcelas = null;

	$crud = $_GET['crud'];

	switch ($crud) {
		case 'c':			
			$cd_categoria = $_GET['cd_categoria'];
			$cd_conta = $_GET['cd_conta'];
			$vl_movimento = $_GET['vl_movimento'];	
			$dt_vencimento = $_GET['dt_vencimento'];
			$cd_competencia =  $_GET['cd_competencia'];
			$cd_recurso = $_GET['cd_recurso'];
			$dt_movimento = $_GET['dt_movimento'];
			$ds_historico = $_GET['ds_historico'];
			$cd_parcela = $_GET['cd_parcela'];
			$qt_parcelas = $_GET['qt_parcelas'];
			break;		
		case 'u':
			$cd_movimento = $_GET['cd_movimento']; 
			$cd_categoria = $_GET['cd_categoria'];
			$cd_conta = $_GET['cd_conta'];
			$vl_movimento = $_GET['vl_movimento'];	
			$dt_vencimento = $_GET['dt_vencimento'];
			$cd_competencia =  $_GET['cd_competencia'];
			$cd_recurso = $_GET['cd_recurso'];
			$dt_movimento = $_GET['dt_movimento'];
			$ds_historico = $_GET['ds_historico'];
			$cd_parcela = $_GET['cd_parcela'];
			$qt_parcelas = $_GET['qt_parcelas'];
			break;
		case 'd':
			$cd_movimento = $_GET['cd_movimento'];
			break;
	}
?>