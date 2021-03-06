<?php
	require('../cfg/php/database.php');
	class usuario{
		private $codigo_usuario;
		private $nome;
		private $nome_completo;
		private $senha;
		private $intruso;
		private $crc;
		private $chapa;

		public function __construct($codigo_usuario,$nome,$nome_completo,$senha,$intruso,$crc,$chapa){
			$this->codigo_usuario 	= $codigo_usuario;
			$this->nome 			= $nome;
			$this->nome_completo 	= $nome_completo;
			$this->senha 			= $senha;
			$this->intruso 			= $intruso;
			$this->crc 				= $crc;
			$this->chapa 			= $chapa;
		}
		public function crud($crud){
			$con = new database;

			$codigo_usuario 		= $this->codigo_usuario;
			$nome 					= $this->nome;
			$nome_completo 			= $this->nome_completo;
			$senha 					= $this->senha;
			$intruso 				= $this->intruso;	
			$crc 					= $this->crc;	
			$chapa 					= $this->chapa;	

			$statement = array("r" => "SELECT * FROM aac_usuarios WHERE nome = ?");		 	 			
			switch ($crud){
				case 'r': 
					$params = [$nome];
					$con->query1ToJSON($statement["r"],$params);break;				
			}
		}
		
		public function Criptografar($Texto,$Dig){
			$Codigo = 0;
			$xCRC   = 0;
			$xCont  = 0;
			$Texto  = trim($Texto);

			for($L1 = strlen($Texto); $L1 >= 1; $L1--){
			  $Codigo = $Codigo + ord($Texto[$L1-1]) * $L1;
			  $xCont  = $xCont + ord($Texto[$L1-1]);
			}

			$Nro_Final = ($xCRC + ($Codigo * $xCont));
			$xCRC = ($xCRC + ($Codigo * $xCont)) & 0xfffff;
			if($Dig < 5){
			 $Dig = mt_rand(6,19);
			}
			$xCRC = $xCRC * $Dig;
			$xCRC = $xCRC * 21 + $Dig;
			return $xCRC;
		}

		public function ChecarCriptografia($Texto, $CRC){
			$Texto = trim($Texto);
			$CRC   = trim($CRC);

			$Dig   = $CRC % 21;
			$xCRC  = $this->Criptografar($Texto,$Dig);	
			echo $xCRC;
		}
	} 	
	$codigo_usuario 		= null;
	$nome 					= null;
	$nome_completo 			= null;
	$senha 					= null;
	$intruso 				= null;
	$crc 					= null;
	$chapa 					= null;
	
	if(isset($_GET['codigo_usuario']))		$codigo_usuario 		= $_GET['codigo_usuario'];	
	if(isset($_GET['nome']))				$nome 					= $_GET['nome'];
	if(isset($_GET['nome_completo']))		$nome_completo 			= $_GET['nome_completo'];
	if(isset($_GET['senha']))				$senha 					= $_GET['senha'];
	if(isset($_GET['intruso']))				$intruso 				= $_GET['intruso'];
	if(isset($_GET['crc']))					$crc 					= $_GET['crc'];
	if(isset($_GET['chapa']))				$chapa 					= $_GET['chapa'];

	$crud = $_GET['crud'];	
	$usuario = new usuario($codigo_usuario,$nome,$nome_completo,$senha,$intruso,$crc,$chapa);
	$usuario->crud($crud);
	$usuario->ChecarCriptografia("123",$usuario->$senha);
?>