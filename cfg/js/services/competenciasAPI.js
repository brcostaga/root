angular.module("orcamentoApp").factory("competenciasAPI", function($http){
	var _getCompetencias = function(){		
		return $http({
			url: "http://localhost/orcamento/competencias/competencias.php"
			,method: "GET"		
			,params: {
				crud: 'r'			
			}
		});		
	};	
	return {
		getCompetencias: _getCompetencias
	};
});