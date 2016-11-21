angular.module('orcamentoApp').controller('contaDetalhe', function($scope, $http, $routeParams){
	$scope.cd_competencia;	
	getGrupoDetalheJson = function(){
		$http({
			url: "http://localhost/orcamento/m/contaDetalhe.php"
			,method: "GET"
			,params: {
				cd_competencia: $routeParams.cd_competencia
				,cd_conta: $routeParams.cd_conta
			}
		}).success(function(data){
			$scope.movimentosGrupo = data;
		});
	};
	getGrupoDetalheJson()	
});