angular.module("orcamentoApp").directive("createButton",function(){
	return{
		templateUrl: "cfg/js/directives/view/createButton.html"
		,scope: {
			modalId: '@'
		}
	};
});