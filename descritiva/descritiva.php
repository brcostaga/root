<?php
	require('../cfg/php/database.php');
	class descritiva{
		private $nm_tabela;
		private $nm_campo;
		private $cd;
		private $ds;

		public function __construct($nm_tabela, $nm_campo, $cd, $ds){
			$this->nm_tabela = $nm_tabela;
			$this->nm_campo = $nm_campo;
			$this->cd = $cd;
			$this->ds = $ds;
		}

		public function crud($crud){
			$con = new database;
			$statement = array(
				 "c" => ""				
				,"r" => "SELECT a.cd, a.ds FROM tb_descritiva a WHERE a.nm_tabela =  $this->nm_tabela AND a.nm_campo = $this->nm_campo"
				,"u" => ""
				,"d" => ""				
			);		 	 			
			switch ($crud) {
				case 'c': break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': break;	
				case 'd': break;
			}
		}
	}

	$nm_tabela = null;
	$nm_campo = null;
	$cd = null;
	$ds = null;

	if(isset($_GET['nm_tabela']))		$nm_tabela 		= $_GET['nm_tabela'];
	if(isset($_GET['nm_campo']))		$nm_campo 		= $_GET['nm_campo'];
	if(isset($_GET['cd']))				$cd 			= $_GET['cd'];
	if(isset($_GET['ds']))				$ds 			= $_GET['ds'];

	$crud = $_GET['crud'];
	$descritiva = new descritiva($nm_tabela, $nm_campo, $cd, $ds);
	$descritiva->crud($crud);
?>