angular.module('orcamentoApp').controller('resumoMensal', function($scope, $http){	
	$scope.cd_competencia;	
	function getCompetenciasJson (){
		$http.get("http://localhost/orcamento/m/competencias.php").success(function(data){						
			$scope.competencias = data;
		});
	};	
	getCompetenciasJson();

	$scope.getResumoMensalJson = function(){		
		$http({
			url: "http://localhost/orcamento/m/resumoMensal.php"
			,method: "GET"
			,params: {cd_competencia: $scope.cd_competencia}
		}).success(function(data){
			$scope.rs = data;
		});		
	};	
});