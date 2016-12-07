angular.module("orcamentoApp").factory("categoriasAPI", function($http){
	var _getCategorias = function(){		
		return $http({
			url: "http://localhost/orcamento/m/crud/categorias/categorias.php"		
			,method: "GET"			
		});		
	};	
	return {
		getCategorias: _getCategorias
	};
});