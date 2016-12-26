angular.module("orcamentoApp").directive("widgetHeader",function(){
	return{
		templateUrl: "cfg/js/directives/view/widgetHeader.html"
		,scope: {
			label: '@'
		}
	};
});