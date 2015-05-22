
var Controllore = function(){
	this.view = new View();
	this.view.disegna();
	this.numeroDiv=0;
}

Controllore.prototype.Instanzia = function(){

if(Number(this.numeroDiv)<7){
	if(Number(this.numeroDiv)!=0){
		this.view.aggiungi();
		this.numeroDiv++;
	}
	else{this.numeroDiv++;}
}


};