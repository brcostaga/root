<?php
	require('../cfg/php/database.php');
	class contaDetalhe{
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

			$con = new database;
			$statement = array(
				 "c" => "INSERT INTO tb_movimentos (cd_categoria,cd_conta,vl_movimento,dt_movimento,dt_vencimento,cd_competencia,cd_recurso,ds_historico,cd_parcela,qt_parcelas)	VALUES (?,?,?,?,?,?,?,?,?,?)"				
				,"u" => ""
				,"d" => "DELETE FROM tb_movimentos WHERE cd_movimento = ?"
				,"r" => "
SELECT
      LPAD(EXTRACT(DAY FROM a.dt_movimento),2,0)
      ||'/'||
      LPAD(EXTRACT(MONTH FROM a.dt_movimento),2,0)
      ||'/'||
      EXTRACT(YEAR FROM a.dt_movimento)        AS DATA_MOVIMENTO
      ,a.ds_historico                          AS HISTORICO
      ,a.cd_parcela
      ,a.qt_parcelas
      ,a.cd_parcela||'/'||a.qt_parcelas        AS PARCELA
      ,a.vl_movimento                          AS VALOR
      ,e.cd_categoria
      ,e.nm_categorias                         AS CATEGORIA
      ,a.cd_movimento

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
				case 'c': 
					$params = [$cd_categoria, $cd_conta, $vl_movimento,$dt_movimento, $dt_vencimento, $cd_competencia, $cd_recurso, $ds_historico, $cd_parcela, $qt_parcelas];
					$con->dml($statement["c"],$params);
					break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': break;	
				case 'd': 
					$params = [$cd_movimento];
					$con->dml($statement["d"],$params);
					break;
			}
		}
	}

	//http://localhost/orcamento/contaDetalhe/contaDetalhe.php?cd_categoria=4&cd_parcela=1&crud=c&ds_historico=Sonda&dt_movimento=25.10.2016&dt_vencimento=26.11.2016&qt_parcelas=2&vl_movimento=-100

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
	$contaDetalhe = new contaDetalhe($cd_movimento, $cd_categoria, $cd_conta, $vl_movimento,$dt_movimento, $dt_vencimento, $cd_competencia, $cd_recurso, $ds_historico, $cd_parcela, $qt_parcelas);
	$contaDetalhe->crud($crud);
?>