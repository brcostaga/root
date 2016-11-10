angular.module('orcamentoApp').config(function($routeProvider){
	$routeProvider.when('/resumoMensal',{
		templateUrl: '/orcamento/v/resumoMensalView.html'
		,controller: 'resumoMensalCtrl'
	});
	$routeProvider.otherwise({redirectTo: '/resumoMensal'});
});