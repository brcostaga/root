angular.module('orcamentoApp').controller('contaDetalhe', function($scope, $http, $routeParams, categoriasAPI, dateToStringAPI, stringToDateAPI){	
	$scope.cd_movimento;
	$scope.dt_movimento;
	$scope.ds_historico;
	$scope.cd_parcela;
	$scope.qt_parcelas;
	$scope.vl_movimento;
	$scope.cd_categoria;
	$scope.cd_competencia;
	$scope.cd_conta;	

	function getCategorias(){		
		categoriasAPI.getCategorias().success(function(data){
			$scope.categorias = data;
		});	
	};
	getCategorias();

	$scope.cancel = function(){
		getGrupoDetalheJson();
		$scope.post = false;	
		$scope.cd_movimento = undefined;
		$scope.dt_movimento = undefined;
		$scope.ds_historico = undefined;
		$scope.cd_parcela = undefined;
		$scope.qt_parcelas = undefined;
		$scope.vl_movimento = undefined;
		$scope.cd_categoria = undefined;
		$scope.cd_competencia = undefined;
		$scope.cd_conta = undefined;
	};

	var getGrupoDetalheJson = function(){
		$http({
			url: "http://localhost/orcamento/contaDetalhe/contaDetalhe.php"
			,method: "GET"
			,params: {
				cd_competencia: $routeParams.cd_competencia
				,cd_conta: $routeParams.cd_conta
				,crud: 'r'
			}
		}).success(function(data){
			$scope.movimentosGrupo = data;
		});
	};
	getGrupoDetalheJson();	

	$scope.putDetalhe = function(){		
		$http({			
			url: "http://localhost/orcamento/contaDetalhe/contaDetalhe.php"
			,method: "GET"
			,params: {
				cd_categoria: $scope.cd_categoria
				,cd_conta: $routeParams.cd_conta
				,vl_movimento: $scope.vl_movimento
				,dt_movimento: dateToStringAPI.dateToString($scope.dt_movimento)
				,dt_vencimento: dateToStringAPI.dateToString($routeParams.dt_vencimento)
				,cd_competencia: $routeParams.cd_competencia
				,ds_historico: $scope.ds_historico
				,cd_parcela: $scope.cd_parcela
				,qt_parcelas: $scope.qt_parcelas				
				,crud: 'c'
			}
		}).success(function(data){			
			getGrupoDetalheJson();
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

	$scope.deleteDetalhe = function(cd_movimento){		
		$http({
			url: "http://localhost/orcamento/contaDetalhe/contaDetalhe.php"
			,method: "GET"
			,params: {
				cd_movimento: cd_movimento
				,crud: 'd'
			}
		}).success(function(data){
			getGrupoDetalheJson();
			$scope.post = false;
			$scope.cd_movimento = undefined;			
		});							
	}

	$scope.changeForm = function(cd_movimento,dt_movimento,ds_historico,cd_parcela,qt_parcelas,vl_movimento,cd_categoria){		
		$scope.post = true;
		$scope.cd_movimento = Number(cd_movimento);		
		$scope.dt_movimento = stringToDateAPI.stringToDate(dt_movimento);
		$scope.ds_historico = ds_historico;
		$scope.cd_parcela = cd_parcela;
		$scope.qt_parcelas = qt_parcelas;
		$scope.vl_movimento = Number(vl_movimento);
		$scope.cd_categoria = Number(cd_categoria);


		
	}

	$scope.postMovimento = function(cd_movimento,dt_movimento,ds_historico,cd_parcela,qt_parcelas,vl_movimento,cd_categoria){
		$http({
			url: "http://localhost/orcamento/resumoMensal/resumoMensal.php"
			,method: "GET"
			,params: {
				cd_movimento: cd_movimento
				,dt_movimento: dateToStringAPI.dateToString(dt_movimento)
				,ds_historico: ds_historico
				,cd_parcela: cd_parcela
				,qt_parcelas: qt_parcelas
				,vl_movimento: vl_movimento				
				,cd_categoria: cd_categoria
				,cd_conta: $routeParams.cd_conta				
				,cd_competencia: $routeParams.cd_competencia
				,crud: 'u'
			}
		}).success(function(data){
			$scope.cancel();
		});	
	}
});