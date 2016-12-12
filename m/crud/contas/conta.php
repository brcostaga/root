<?php
	require('../../functions/database.php');
	class conta{
		private $cd_conta;
		private $nm_conta;
		private $cd_tipo;		
		private $statement;		
		private $con;
		private $crud;

		public function __construct($p1,$p2,$p3,$p4){
			$this->cd_conta = $p1;
			$this->nm_conta = $p2;
			$this->cd_tipo = $p3;	
			$this->crud = $p4;
			$this->con = new database;				
		}

		public function crud(){
			switch ($this->crud) {
				case 'c':
					$this->statement = 
"INSERT INTO tb_contas (nm_conta,cd_tipo) VALUES('$this->nm_conta',$this->cd_tipo);";
					$this->con->dml($this->statement);
					break;	
				case 'r':
					$this->statement = "
SELECT a.cd_conta, a.nm_conta, b.ds AS DS_TIPO FROM tb_contas a JOIN tb_descritiva b ON b.nm_tabela = 'TB_CONTAS' AND b.nm_campo = 'CD_TIPO'AND a.cd_tipo = b.cd
   					";
					$this->con->queryToJSON($this->statement);
					break;	
				case 'u':
					$this->statement = 
"UPDATE tb_contas SET nm_conta = '$this->nm_conta', cd_tipo = $this->cd_tipo WHERE cd_conta=$this->cd_conta;";
					$this->con->dml($this->statement);
					break;	
				case 'd':
					$this->statement = 
"DELETE FROM tb_contas WHERE cd_conta=$this->cd_conta;";
					$this->con->dml($this->statement);
					break;
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
		case 'r':			
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

	$conta = new conta($cd_conta,$nm_conta,$cd_tipo,$crud);
	$conta->crud();
?>