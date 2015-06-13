var CCartelle = function(note){
	  Cartelle = new Object();
	
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

CCartelle.prototype.getCartelle = function(){
	return Cartelle;
}
CCartelle.prototype.getCartella = function(id_cartella){
	return Cartelle[id_cartella];
}