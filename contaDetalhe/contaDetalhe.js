angular.module('orcamentoApp').controller('contaDetalhe', function($scope, $http, $routeParams){
	$scope.cd_competencia;	
	getGrupoDetalheJson = function(){
		$http({
			url: "http://localhost/orcamento/contaDetalhe/contaDetalhe.php"
			,method: "GET"
			,params: {
				cd_competencia: $routeParams.cd_competencia
				,cd_conta: $routeParams.cd_conta
				,crud: 'r'
			}
		}).success(function(data){
			$scope.movimentosGrupo = data;
		});
	};
	getGrupoDetalheJson()	
});