angular.module('orcamentoApp').controller('resumoMensal', function($scope, $http, contasAPI, categoriasAPI, competenciasAPI, dateToStringAPI){	
	$scope.cd_categoria;
	$scope.cd_conta;
	$scope.vl_movimento;
	$scope.dt_movimento;
	$scope.dt_vencimento;
	$scope.cd_competencia;
	$scope.ds_historico;
	$scope.cd_parcela;
	$scope.qt_parcelas;	

	function getContas(){
		contasAPI.getContas().success(function(data){
			$scope.contas = data;				
		});
	};
	getContas();

	function getCategorias(){		
		categoriasAPI.getCategorias().success(function(data){
			$scope.categorias = data;
		});	
	};
	getCategorias();

	function getCompetenciasJson (){
		competenciasAPI.getCompetencias().success(function(data){						
			$scope.competencias = data;
		});
	};	
	getCompetenciasJson();
	
	$scope.getResumoMensalJson = function(cd_competencia){		
		$http({			
			url: "http://localhost/orcamento/resumoMensal/resumoMensal.php"
			,method: "GET"
			,params: {
				cd_competencia: cd_competencia
				,crud: 'r'
			}
		}).success(function(data){
			$scope.resumoMensal = data;
		});	
	};	

	$scope.cancel = function(){
		$scope.getResumoMensalJson($scope.cd_competencia);
		$scope.post = false;	
		$scope.cd_movimento = undefined;
		$scope.cd_categoria = undefined;
		$scope.cd_conta = undefined;
		$scope.vl_movimento = undefined;
		$scope.dt_movimento = undefined;
		$scope.dt_vencimento = undefined;		
		$scope.ds_historico = undefined;
		$scope.cd_parcela = undefined;
		$scope.qt_parcelas = undefined;			
	};

	$scope.changeForm = function(cd_movimento,cd_categoria,cd_conta,vl_movimento,dt_vencimento,cd_competencia){
		$scope.post = true;		
		$scope.cd_movimento = Number(cd_movimento);
		$scope.cd_categoria = Number(cd_categoria);
		$scope.cd_conta = Number(cd_conta);
		$scope.vl_movimento = Number(vl_movimento);		
		$scope.dt_vencimento = new Date(dt_vencimento);
		$scope.cd_competencia = cd_competencia;		
	}

	$scope.postMovimento = function(cd_movimento,cd_categoria,cd_conta,vl_movimento,dt_vencimento,cd_competencia){
		$http({
			url: "http://localhost/orcamento/resumoMensal/resumoMensal.php"
			,method: "GET"
			,params: {
				cd_movimento: cd_movimento
				,cd_categoria: cd_categoria
				,cd_conta: cd_conta
				,vl_movimento: vl_movimento				
				,dt_vencimento: dateToStringAPI.dateToString(dt_vencimento)
				,cd_competencia: cd_competencia
				,crud: 'u'
			}
		}).success(function(data){
			$scope.post = false;
			$scope.getResumoMensalJson($scope.cd_competencia);
			$scope.cd_categoria = undefined;
			$scope.cd_conta = undefined;
			$scope.vl_movimento = undefined;
			$scope.dt_movimento = undefined;
			$scope.dt_vencimento = undefined;			
			$scope.ds_historico = undefined;
			$scope.cd_parcela = undefined;
			$scope.qt_parcelas = undefined;
		});	
	}

	$scope.deleteMovimento = function(cd_movimento){					
		$http({
			url: "http://localhost/orcamento/resumoMensal/resumoMensal.php"
			,method: "GET"
			,params: {
				cd_movimento: cd_movimento
				,crud: 'd'
			}
		}).success(function(data){
			$scope.post = false;
			$scope.cd_movimento = undefined;			
			$scope.getResumoMensalJson($scope.cd_competencia);
		});						
	}

	$scope.putMovimento = function(){
		$http({			
			url: "http://localhost/orcamento/resumoMensal/resumoMensal.php"
			,method: "GET"
			,params: {
				cd_categoria: $scope.cd_categoria
				,cd_conta: $scope.cd_conta
				,vl_movimento: $scope.vl_movimento
				,dt_movimento: dateToStringAPI.dateToString($scope.dt_movimento)
				,dt_vencimento: dateToStringAPI.dateToString($scope.dt_vencimento)
				,cd_competencia: $scope.cd_competencia
				,ds_historico: $scope.ds_historico
				,cd_parcela: $scope.cd_parcela
				,qt_parcelas: $scope.qt_parcelas				
				,crud: 'c'
			}
		}).success(function(data){
			$scope.getResumoMensalJson($scope.cd_competencia);
			$scope.cd_categoria = undefined;
			$scope.cd_conta = undefined;
			$scope.vl_movimento = undefined;
			$scope.dt_movimento = undefined;
			$scope.dt_vencimento = undefined;			
			$scope.ds_historico = undefined;
			$scope.cd_parcela = undefined;
			$scope.qt_parcelas = undefined;			
		});		
	}	
});