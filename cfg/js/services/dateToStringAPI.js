angular.module("orcamentoApp").factory("dateToStringAPI", function($http){
	var _dateToString = function(d){		
		var date = new Date(d);
		date = date.getDate()+'.'+(Number(date.getMonth())+1)+'.'+date.getFullYear();
		return date;	
	};	
	return {
		dateToString: _dateToString
	};
});