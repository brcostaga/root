angular.module('orcamentoApp').controller('categorias', function($scope, $http, categoriasAPI){

	$scope.create = function(){		
		$http({
			url: "http://localhost/orcamento/categorias/categorias.php"
			,method: "GET"
			,params: {
				nm_categorias: $scope.nm_categorias
				,cd_categoria_pai: $scope.cd_categoria_pai
				,crud: 'c'
			}
		}).success(function(data){
			$scope.refresh();
		});
	};

	function read(){		
		categoriasAPI.getCategorias().success(function(data){
			$scope.categorias = data;
		});	
	};

	$scope.update = function(cd_categoria,nm_categorias,cd_categoria_pai){		
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
			$scope.refresh();
		});	
	};

	$scope.delete = function(cd_categoria){		
		$http({
			url: "http://localhost/orcamento/categorias/categorias.php"
			,method: "GET"
			,params: {
				cd_categoria: cd_categoria
				,crud: 'd'
			}
		}).success(function(data){
			$scope.refresh();
		});				
	};

	$scope.setScope = function(cd_categoria,nm_categorias,cd_categoria_pai){		
		$scope.cd_categoria = Number(cd_categoria);
		$scope.nm_categorias = nm_categorias;	
		$scope.cd_categoria_pai = Number(cd_categoria_pai);
	};

	$scope.refresh = function(){		
		$scope.cd_categoria = undefined;
		$scope.nm_categorias = undefined;	
		$scope.cd_categoria_pai = undefined;			
		read();
	};
	$scope.refresh();
});