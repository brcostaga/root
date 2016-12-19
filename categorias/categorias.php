<?php
	require('../cfg/php/database.php');
	class categoria{
		private $cd_categoria;
		private $nm_categorias;
		private $cd_categoria_pai;

		public function __construct($cd_categoria,$nm_categorias,$cd_categoria_pai){
			$this->cd_categoria 	= $cd_categoria;
			$this->nm_categorias 	= $nm_categorias;
			$this->cd_categoria_pai = $cd_categoria_pai;
		}
		public function crud($crud){
			$con = new database;

			$cd_categoria 		= $this->cd_categoria;
			$nm_categorias 		= $this->nm_categorias;
			$cd_categoria_pai 	= $this->cd_categoria_pai;			

			$statement = array(
				 "c" => "INSERT INTO tb_categorias (nm_categorias,cd_categoria_pai) VALUES(?,?)"
				,"r" => "SELECT * FROM tb_categorias"
				,"u" => "UPDATE tb_categorias SET nm_categorias = ?,cd_categoria_pai = ? WHERE cd_categoria=?"
				,"d" => "DELETE FROM tb_categorias WHERE cd_categoria=?"
			);		 	 			
			switch ($crud) {
				case 'c':
					$params = [$nm_categorias,$cd_categoria_pai];
					$con->dml($statement["c"],$params);break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': 
					$params = [$nm_categorias,$cd_categoria_pai,$cd_categoria];
					$con->dml($statement["u"],$params);break;	
				case 'd': 
					$params = [$cd_categoria];
					$con->dml($statement["d"],$params);break;
			}
		}
	} 	
	$cd_categoria 		= null;
	$nm_categorias 		= null;
	$cd_categoria_pai 	= null;

	if(isset($_GET['cd_categoria']))		$cd_categoria 		= $_GET['cd_categoria'];	
	if(isset($_GET['nm_categorias']))		$nm_categorias 		= $_GET['nm_categorias'];
	if(isset($_GET['cd_categoria_pai']))	$cd_categoria_pai 	= $_GET['cd_categoria_pai'];

	$crud = $_GET['crud'];	
	$categoria = new categoria($cd_categoria,$nm_categorias,$cd_categoria_pai);
	$categoria->crud($crud);
?>