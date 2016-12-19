<?php
	require('../cfg/php/database.php');
	class conta{
		private $cd_conta;
		private $nm_conta;
		private $cd_tipo;

		public function __construct($cd_conta,$nm_conta,$cd_tipo){
			$this->cd_conta = $cd_conta;
			$this->nm_conta = $nm_conta;
			$this->cd_tipo = $cd_tipo;
		}
		public function crud($crud){
			$con = new database;

			$cd_conta = $this->cd_conta;
			$nm_conta = $this->nm_conta;
			$cd_tipo = $this->cd_tipo;

			$statement = array(
				"c" => "INSERT INTO tb_contas (nm_conta,cd_tipo) VALUES(?,?)"			
				,"u" => "UPDATE tb_contas SET nm_conta = ?, cd_tipo = ? WHERE cd_conta=?" 
				,"d" => "DELETE FROM tb_contas WHERE cd_conta=?"
				,"r" => "
					SELECT 
						a.cd_conta
						, a.nm_conta
						, a.cd_tipo
						, b.ds 			AS DS_TIPO 
					FROM tb_contas a 
					JOIN tb_descritiva b ON b.nm_tabela = 'TB_CONTAS' AND b.nm_campo = 'CD_TIPO'AND a.cd_tipo = b.cd
				"
			);		 	 			
			switch ($crud) {
				case 'c':
					$params = [$nm_conta,$cd_tipo];
					$con->dml($statement["c"],$params);break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': 
					$params = [$nm_conta,$cd_tipo,$cd_conta];
					$con->dml($statement["u"],$params);break;	
				case 'd': 
					$params = [$cd_conta];
					$con->dml($statement["d"],$params);break;
			}
		}		
	}
	$cd_conta = null;
	$nm_conta = null;
	$cd_tipo = null;

	if(isset($_GET['cd_conta']))		$cd_conta 		= $_GET['cd_conta'];	
	if(isset($_GET['nm_conta']))		$nm_conta 		= $_GET['nm_conta'];
	if(isset($_GET['cd_tipo']))			$cd_tipo 		= $_GET['cd_tipo'];
	
	$crud = $_GET['crud'];
	$conta = new conta($cd_conta,$nm_conta,$cd_tipo);
	$conta->crud($crud);
?>