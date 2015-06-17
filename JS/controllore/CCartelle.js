var CCartelle = function(note){
	  Cartelle = new Object();
	 var Cartella_attiva;
	
}

CCartelle.prototype.aggiungiCartella = function(cartella){

	Cartelle[cartella.id] = {
			id:cartella.id,
			email_utente:cartella.email_utente,
			tipo:cartella.tipo,
			nome:cartella.nome,
			posizione:cartella.posizione,
			colore:cartella.colore
						
		}

}
CCartelle.prototype.setCartellaAttiva=function(id_attiva){
	Cartella_attiva=id_attiva;
	$("#nota_space").attr('id',id_attiva);
	
}

CCartelle.prototype.getCartellaAttiva=function(){
	return Cartella_attiva;
}

CCartelle.prototype.getCartelle = function(){
	return Cartelle;
}
CCartelle.prototype.getCartella = function(id_cartella){
	return Cartelle[id_cartella];
}

CCartelle.prototype.getIdCartella=function(nome){
	var res;
	$.each(Cartelle,function(i,Cartella){
		if(Cartella.nome==nome)
			 {
			 	res=Cartella.id;
			 				 }
			});

	return res;
}