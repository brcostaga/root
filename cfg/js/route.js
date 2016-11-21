angular.module('orcamentoApp').config(function($routeProvider){
	$routeProvider.when('/resumoMensal',{
		templateUrl: '/orcamento/v/resumoMensal.html'
		,controller: 'resumoMensal'
	});
	$routeProvider.when('/contaDetalhe/:cd_conta/:cd_competencia',{
		templateUrl: '/orcamento/v/contaDetalhe.html'
		,controller: 'contaDetalhe'
	});
	$routeProvider.otherwise({redirectTo: '/resumoMensal'});
});