
var CDati = function(){
	
	
}

CDati.prototype.getTemplate = function(tmpl){
	// dentro tmpl si passa il nome del file template senza estenzione
	
	return $.ajax({
		type: 'POST',
		url : "JS/view/Template/"+tmpl+".tmpl",
	})
	
	
}

CDati.prototype.getNote = function(id_cartella,note_presenti,num_note,posizioni){
	
	var Data = new Object();
	
	
	
	Data = {
			controller: 'cartella',
			lavoro: 'getNote',
			note_presenti : note_presenti,
			num_note: num_note,
			id_cartella: id_cartella,
			posizioni:posizioni
	};
	
	return $.ajax({
		type: 'POST',
		url : 'Home.php',
		data : Data
	});
	
}

CDati.prototype.getCartelle = function(){
	
	return $.ajax({
		type: 'POST',
		url : 'Home.php?controller=utente&lavoro=getCartelle'
	});
	
}


CDati.prototype.setPosizioni= function(data){
	
	return $.ajax({
		type: 'POST',
		url : 'Home.php',
		data: data,
	});

}

CDati.prototype.setNote = function(data){
	
	return $.ajax({
		type: 'POST',
		url : 'Home.php',
		data: data,
	});
	
}

CDati.prototype.getInfoUtente=function(){
	return $.ajax({
		type:'POST',
		url:'Home.php',
		data:{
			  controller:'utente',
			  lavoro:'inviaInfo'
		}
	});
}