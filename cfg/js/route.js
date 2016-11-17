angular.module('orcamentoApp').config(function($routeProvider){
	$routeProvider.when('/resumoMensal',{
		templateUrl: '/orcamento/v/resumoMensal.html'
		,controller: 'resumoMensal'
	});
	$routeProvider.when('/grupoDetalhe/:cd_grupo/:cd_competencia',{
		templateUrl: '/orcamento/v/grupoDetalhe.html'
		,controller: 'grupoDetalhe'
	});
	$routeProvider.otherwise({redirectTo: '/resumoMensal'});
});