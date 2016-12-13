angular.module("orcamentoApp").factory("categoriasAPI", function($http){
	var _getCategorias = function(){		
		return $http({
			url: "http://localhost/orcamento/categorias/categorias.php"		
			,method: "GET"		
			,params: {
				crud: 'r'			
			}
		});		
	};	
	return {
		getCategorias: _getCategorias
	};
});