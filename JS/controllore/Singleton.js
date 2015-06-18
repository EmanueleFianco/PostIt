

var Singleton = function(){
	SingletonObj = new Object();
}

Singleton.prototype.getInstance = function(Oggetto,instanza){
	
	if($.isEmptyObject(SingletonObj)){
		SingletonObj[instanza]= Object.create(Oggetto.prototype);
		return SingletonObj[instanza];
	}
	else{
		var Chiavi=Object.keys(SingletonObj);
		var flag="FALSE";
		$.each(Chiavi,function(i,Chiave){
			if(Chiave==instanza){
				flag="TRUE";
			}
		});
		if(flag=="TRUE"){
			return SingletonObj[instanza];
		}
		if(flag=="FALSE"){
			SingletonObj[instanza]= Object.create(Oggetto.prototype);
			return SingletonObj[instanza];
		}
	}

	
}