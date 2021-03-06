angular.module('orcamentoApp').controller('contas', function($scope, $http, contasAPI){
	$scope.cd_conta;
	$scope.nm_conta;	
	$scope.cd_tipo;  		
	function getContas(){
		contasAPI.getContas().success(function(data){
			$scope.contas = data;				
		});
	};
	getContas();

	$scope.cancel = function(){		
		$scope.post = false;
		$scope.cd_conta = undefined;
		$scope.nm_conta = undefined;	
		$scope.cd_tipo = undefined;	
		getContas();
	};
	$scope.putContas = function(){
		$http({
			url: "http://localhost/orcamento/contas/contas.php"			
			,method: "GET"
			,params: {
				nm_conta: $scope.nm_conta
				,cd_tipo: $scope.cd_tipo
				,crud: "c"
			}
		}).success(function(data){
			$scope.cd_conta = undefined;
			$scope.nm_conta = undefined;
			$scope.cd_tipo = undefined;
			getContas();
		});		
	}

	$scope.deleteContas = function(cd_conta){
		$http({
			url: "http://localhost/orcamento/contas/contas.php"			
			,method: "GET"
			,params: {
				cd_conta: cd_conta
				,crud: "d"
			}
		}).success(function(data){
			$scope.post = false;
			$scope.cd_conta = undefined;
			$scope.nm_conta = undefined;	
			$scope.cd_tipo = undefined;	
			getContas();
		});				
	}
	$scope.changeForm = function(cd_conta,nm_conta,cd_tipo){
		$scope.post = true;
		$scope.cd_conta = Number(cd_conta);
		$scope.nm_conta = nm_conta;	
		$scope.cd_tipo = Number(cd_tipo);		
	}

	$scope.postContas = function(cd_conta,nm_conta,cd_tipo){
		
		$http({
			url: "http://localhost/orcamento/contas/contas.php"			
			,method: "GET"
			,params: {
				cd_conta: Number(cd_conta)
				,nm_conta: nm_conta
				,cd_tipo: Number(cd_tipo)
				,crud: "u"		
			}
		}).success(function(data){
			$scope.post = false;
			$scope.cd_conta = undefined;
			$scope.nm_conta = undefined;	
			$scope.cd_tipo = undefined;	
			getContas();	
		});	
	}

	function getDescritiva (){
		$http({
			url: "http://localhost/orcamento/descritiva/descritiva.php"
			,method: "GET"
			,params:{
				nm_tabela: "'TB_CONTAS'"
				,nm_campo: "'CD_TIPO'"
				,crud: 'r'
			}
		}).success(function(data){						
			$scope.tipos = data;
		});
	};	
	getDescritiva();
});