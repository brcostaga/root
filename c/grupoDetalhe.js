angular.module('orcamentoApp').controller('grupoDetalhe', function($scope, $http, $routeParams){
	$scope.cd_competencia;	
	getGrupoDetalheJson = function(){
		$http({
			url: "http://localhost/orcamento/m/movimentosGrupo.php"
			,method: "GET"
			,params: {
				cd_competencia: $routeParams.cd_competencia
				,cd_grupo: $routeParams.cd_grupo
			}
		}).success(function(data){
			$scope.movimentosGrupo = data;
		});
	};
	getGrupoDetalheJson()	
});