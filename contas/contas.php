<?php
	require('../cfg/php/database.php');
	class conta{
		private $cd_conta;
		private $nm_conta;
		private $cd_tipo;

		public function __construct($p1,$p2,$p3){
			$this->cd_conta = $p1;
			$this->nm_conta = $p2;
			$this->cd_tipo = $p3;
		}
		public function crud($crud){
			$con = new database;
			$statement = array(
				"c" => "INSERT INTO tb_contas (nm_conta,cd_tipo) VALUES('$this->nm_conta',$this->cd_tipo);"			
				,"u" => "UPDATE tb_contas SET nm_conta = '$this->nm_conta', cd_tipo = $this->cd_tipo WHERE cd_conta=$this->cd_conta;" 
				,"d" => "DELETE FROM tb_contas WHERE cd_conta=$this->cd_conta;"
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
				case 'c': $con->dml($statement["c"]);break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': $con->dml($statement["u"]);break;	
				case 'd': $con->dml($statement["d"]);break;
			}
		}		
	}
	$cd_conta = null;
	$nm_conta = null;
	$cd_tipo = null;

	$crud = $_GET['crud'];
	switch ($crud) {
		case 'c':
			$nm_conta = $_GET['nm_conta'];
			$cd_tipo = $_GET['cd_tipo'];
			break;		
		case 'u':
			$cd_conta = $_GET['cd_conta'];
			$nm_conta = $_GET['nm_conta'];
			$cd_tipo = $_GET['cd_tipo'];
			break;
		case 'd':
			$cd_conta = $_GET['cd_conta'];
			break;
	}
	$conta = new conta($cd_conta,$nm_conta,$cd_tipo);
	$conta->crud($crud);
?>