angular.module('orcamentoApp').config(function($routeProvider){
	$routeProvider.when('/resumoMensal',{
		templateUrl: '/orcamento/resumoMensal/resumoMensal.html'
		,controller: 'resumoMensal'
	});
	$routeProvider.when('/contas',{
		templateUrl: '/orcamento/contas/contas.html'
		,controller: 'contas'
	});
	$routeProvider.when('/categorias',{
		templateUrl: '/orcamento/categorias/categorias.html'
		,controller: 'categorias'
	});

	$routeProvider.when('/contaDetalhe/:cd_conta/:cd_competencia/:dt_vencimento',{
		templateUrl: '/orcamento/contaDetalhe/contaDetalhe.html'
		,controller: 'contaDetalhe'
	});	
	$routeProvider.otherwise({redirectTo: '/resumoMensal'});
});