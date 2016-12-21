angular.module("orcamentoApp").factory("stringToDateAPI", function($http){
	var _stringToDate = function(date){		
		date = 
			date.substring(6,10) // year
			+'/'+
			date.substring(3,5) // month
			+'/'+
			date.substring(0,2) // day
		;
		date = new Date(date);
		return date;	
	};	
	return {
		stringToDate: _stringToDate
	};
});