angular.module("orcamentoApp").factory("contasAPI", function($http){
	var _getContas = function(){		
		return $http({
			url: "http://localhost/orcamento/m/crud/contas/contas.php"			
			,method: "GET"			
		});		
	};	
	return {
		getContas: _getContas
	};
});