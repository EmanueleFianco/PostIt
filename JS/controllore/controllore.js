	
var Controllore = function(){
	this.view = new View();
	this.view.disegna();
	this.numeroDiv=0;
}

Controllore.prototype.InstanziaNota = function(tmpl){

if(Number(this.numeroDiv)<9){
		this.getTmpl(tmpl,this.view.aggiungiNota);
		this.numeroDiv++;
	}

}

Controllore.prototype.getTmpl = function(tmpl,Funzione){

	$.ajax({
		type: 'GET',
		url : tmpl,
		success: function(com){
			Funzione(com);
		},
// ----------------------------		
		
		error: function(){
			alert('ERRORE');
		}
	});
	
}
