angular.module('orcamentoApp').controller('categorias', function($scope, $http){
	$scope.cd_categoria;
	$scope.nm_categorias;	
	$scope.cd_categoria_pai;  		
	function getCategorias(){		
		$http({
			url: "http://localhost/orcamento/m/crud/categorias/categorias.php"			
			,method: "GET"			
		}).success(function(data){
			$scope.categorias = data;
		});	
	};
	getCategorias();

	$scope.putCategorias = function(){		
		$http({
			url: "http://localhost/orcamento/m/crud/categorias/putCategorias.php"			
			,method: "GET"
			,params: {
				nm_categorias: $scope.nm_categorias
				,cd_categoria_pai: $scope.cd_categoria_pai
			}
		}).success(function(data){
			$scope.cd_categoria = undefined;
			$scope.nm_categoria = undefined;	
			$scope.cd_categoria_pai = undefined;	
			getCategorias();
		});		
	}
	$scope.deleteCategorias = function(cd_categoria){
		$http({
			url: "http://localhost/orcamento/m/crud/categorias/deleteCategorias.php"			
			,method: "GET"
			,params: {
				cd_categoria: cd_categoria				
			}
		}).success(function(data){
			$scope.post = false;
			$scope.cd_categoria = undefined;
			$scope.nm_categorias = undefined;	
			$scope.cd_categoria_pai = undefined;	
			getCategorias();
		});				
	}

	$scope.changeForm = function(cd_categoria,nm_categorias,cd_categoria_pai){
		$scope.post = true;
		$scope.cd_categoria = Number(cd_categoria);
		$scope.nm_categorias = nm_categorias;	
		$scope.cd_categoria_pai = Number(cd_categoria_pai);
	}

	$scope.postCategorias = function(cd_categoria,nm_categorias,cd_categoria_pai){		
		$http({
			url: "http://localhost/orcamento/m/crud/categorias/postCategorias.php"			
			,method: "GET"
			,params: {
				cd_categoria: Number(cd_categoria)
				,nm_categorias: nm_categorias
				,cd_categoria_pai: Number(cd_categoria_pai)			
			}
		}).success(function(data){
			$scope.post = false;
			$scope.cd_categoria = undefined;
			$scope.nm_categorias = undefined;	
			$scope.cd_categoria_pai = undefined;	
			getCategorias();
		});	
	}
});