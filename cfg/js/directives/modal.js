angular.module("orcamentoApp").directive("modal",function(){
	return{
		templateUrl: "cfg/js/directives/view/modal.html"
		,transclude: true
		,scope: {
			modalId: '@'			
		}
	};
});