<?php
	require('../cfg/php/database.php');
	class contaDetalhe{
		private $cd_movimento;
		private $dt_movimento;
		private $ds_historico;
		private $cd_parcela;
		private $qt_parcelas;
		private $vl_movimento;
		private $nm_categorias;
		private $cd_competencia;
		private $cd_conta;

		public function __construct($cd_movimento,$dt_movimento,$ds_historico,$cd_parcela,$qt_parcelas,$vl_movimento,$nm_categorias,$cd_competencia,$cd_conta){
			$this->cd_movimento 	= $cd_movimento;
			$this->dt_movimento 	= $dt_movimento;
			$this->ds_historico 	= $ds_historico;
			$this->cd_parcela		= $cd_parcela;
			$this->qt_parcelas  	= $qt_parcelas;
			$this->vl_movimento 	= $vl_movimento;
			$this->nm_categorias 	= $nm_categorias;
			$this->cd_competencia 	= $cd_competencia;
			$this->cd_conta 		= $cd_conta;
		}

		public function crud($crud){
			$con = new database;
			$statement = array(
				 "c" => ""				
				,"u" => ""
				,"d" => ""
				,"r" => "
SELECT
      LPAD(EXTRACT(DAY FROM a.dt_movimento),2,0)
      ||'/'||
      LPAD(EXTRACT(MONTH FROM a.dt_movimento),2,0)
      ||'/'||
      EXTRACT(YEAR FROM a.dt_movimento)        AS DATA_MOVIMENTO
      ,a.ds_historico                          AS HISTORICO
      ,a.cd_parcela||'/'||a.qt_parcelas        AS PARCELA
      ,a.vl_movimento                          AS VALOR
      ,e.nm_categorias                         AS CATEGORIA

FROM tb_movimentos a
INNER JOIN tb_contas b ON a.cd_conta = b.cd_conta
INNER JOIN tb_categorias e ON e.cd_categoria = a.cd_categoria
WHERE
      a.cd_competencia = $this->cd_competencia
      AND b.cd_conta = $this->cd_conta
      AND b.cd_tipo > 1
ORDER BY a.dt_movimento
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

	$cd_movimento = null;
	$dt_movimento = null;
	$ds_historico = null;
	$cd_parcela = null;
	$qt_parcelas = null;
	$vl_movimento = null;
	$nm_categorias = null;
	$cd_competencia = null;
	$cd_conta = null;

	if(isset($_GET['cd_movimento']))		$cd_movimento 		= $_GET['cd_movimento'];
	if(isset($_GET['dt_movimento']))		$dt_movimento 		= $_GET['dt_movimento'];
	if(isset($_GET['ds_historico']))		$ds_historico 		= $_GET['ds_historico'];
	if(isset($_GET['cd_parcela']))			$cd_parcela 		= $_GET['cd_parcela'];
	if(isset($_GET['qt_parcelas']))			$qt_parcelas 		= $_GET['qt_parcelas'];
	if(isset($_GET['vl_movimento']))		$vl_movimento 		= $_GET['vl_movimento'];
	if(isset($_GET['nm_categorias']))		$nm_categorias 		= $_GET['nm_categorias'];
	if(isset($_GET['cd_competencia']))		$cd_competencia 	= $_GET['cd_competencia'];
	if(isset($_GET['cd_conta']))			$cd_conta 			= $_GET['cd_conta'];

	$crud = $_GET['crud'];
	$contaDetalhe = new contaDetalhe($cd_movimento,$dt_movimento,$ds_historico,$cd_parcela,$qt_parcelas,$vl_movimento,$nm_categorias,$cd_competencia,$cd_conta);
	$contaDetalhe->crud($crud);
?>