angular.module('orcamentoApp').config(function($routeProvider){
	$routeProvider.when('/resumoMensal',{
		templateUrl: '/orcamento/v/resumoMensal.html'
		,controller: 'resumoMensal'
	});
	$routeProvider.when('/contas',{
		templateUrl: '/orcamento/contas/contas.html'
		,controller: 'contas'
	});
	$routeProvider.when('/categorias',{
		templateUrl: '/orcamento/v/categorias.html'
		,controller: 'categorias'
	});

	$routeProvider.when('/contaDetalhe/:cd_conta/:cd_competencia',{
		templateUrl: '/orcamento/v/contaDetalhe.html'
		,controller: 'contaDetalhe'
	});
	$routeProvider.otherwise({redirectTo: '/resumoMensal'});
});