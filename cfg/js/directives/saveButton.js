angular.module("orcamentoApp").directive("saveButton",function(){
	return{
		templateUrl: "cfg/js/directives/view/saveButton.html"
		,scope: {
			label: '@'
		}
	};
});