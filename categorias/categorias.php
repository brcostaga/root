<?php
	require('../cfg/php/database.php');
	class categoria{
		private $cd_categoria;
		private $nm_categorias;
		private $cd_categoria_pai;

		public function __construct($p1,$p2,$p3){
			$this->cd_categoria = $p1;
			$this->nm_categorias = $p2;
			$this->cd_categoria_pai = $p3;
		}
		public function crud($crud){
			$con = new database;
			$statement = array(
				"c" => "
					INSERT INTO tb_categorias (nm_categorias,cd_categoria_pai) 
					VALUES('$this->nm_categorias',$this->cd_categoria_pai);
				"
				,"u" => "
					UPDATE tb_categorias 
					SET 
						nm_categorias = '$this->nm_categorias'
						,cd_categoria_pai = $this->cd_categoria_pai 
					WHERE cd_categoria=$this->cd_categoria;
					"
				,"d" => "DELETE FROM tb_categorias WHERE cd_categoria=$this->cd_categoria;"
				,"r" => "SELECT * FROM tb_categorias"
			);		 	 			
			switch ($crud) {
				case 'c': $con->dml($statement["c"]);break;	
				case 'r': $con->queryToJSON($statement["r"]);break;	
				case 'u': $con->dml($statement["u"]);break;	
				case 'd': $con->dml($statement["d"]);break;
			}
		}
	} 

	$cd_categoria = null;
	$nm_categorias = null;
	$cd_categoria_pai = null;

	$crud = $_GET['crud'];
	switch ($crud) {
		case 'c':
			$nm_categorias = $_GET['nm_categorias'];
			$cd_categoria_pai = $_GET['cd_categoria_pai'];
			break;		
		case 'u':
			$cd_categoria = $_GET['cd_categoria'];
			$nm_categorias = $_GET['nm_categorias'];
			$cd_categoria_pai = $_GET['cd_categoria_pai'];
			break;
		case 'd':
			$cd_categoria = $_GET['cd_categoria'];
			break;
	}
	$categoria = new categoria($cd_categoria,$nm_categorias,$cd_categoria_pai);
	$categoria->crud($crud);
?>