angular.module("orcamentoApp").directive("editButton",function(){
	return{
		templateUrl: "cfg/js/directives/view/editButton.html"
		,scope: {
			modalId: '@'
		}
	};
});