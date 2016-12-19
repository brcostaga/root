angular.module('orcamentoApp').controller('categorias', function($scope, $http, categoriasAPI){
	$scope.cd_categoria;
	$scope.nm_categorias;	
	$scope.cd_categoria_pai;  		
	function getCategorias(){		
		categoriasAPI.getCategorias().success(function(data){
			$scope.categorias = data;
		});	
	};
	getCategorias();

	$scope.cancel = function(){		
		$scope.post = false;
		$scope.cd_conta = undefined;
		$scope.nm_conta = undefined;	
		$scope.cd_tipo = undefined;	
		getContas();
	};

	$scope.putCategorias = function(){		
		$http({
			url: "http://localhost/orcamento/categorias/categorias.php"
			,method: "GET"
			,params: {
				nm_categorias: $scope.nm_categorias
				,cd_categoria_pai: $scope.cd_categoria_pai
				,crud: 'c'
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
			url: "http://localhost/orcamento/categorias/categorias.php"
			,method: "GET"
			,params: {
				cd_categoria: cd_categoria
				,crud: 'd'
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
			url: "http://localhost/orcamento/categorias/categorias.php"
			,method: "GET"
			,params: {
				cd_categoria: Number(cd_categoria)
				,nm_categorias: nm_categorias
				,cd_categoria_pai: Number(cd_categoria_pai)	
				,crud: 'u'		
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