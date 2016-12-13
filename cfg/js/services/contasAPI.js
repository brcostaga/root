angular.module("orcamentoApp").factory("contasAPI", function($http){
	var _getContas = function(){		
		return $http({
			url: "http://localhost/orcamento/contas/contas.php"			
			,method: "GET"	
			,params: {
				crud: "r"
			}		
		});		
	};	
	return {
		getContas: _getContas
	};
});