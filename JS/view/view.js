		
var View = function(){
	
	
}

View.prototype.getNota = function(nota){
	
	var Dati = new Object();
	   Dati['titolo'] = {
				Nota : "nota",
				Lavoro: "aggiorna",
				Tipo: "Titolo",
				Titolo: $(nota).text(),
				Id: $(nota).nextAll().find(".id").text()
			};
	  Dati['testo'] = {
				Nota : "nota",
				Lavoro: "aggiorna",
				Tipo: "Testo",
				Testo: $(nota).html(),
				Id: $(nota).parent().prev().text()
			};
	  

	  return Dati;
}



View.prototype.setNota = function(nota,tmpl,pos){
	var html = Mustache.to_html(tmpl,nota);
	$('#sortable'+pos).append(html);
	
	$('#sortable'+pos+" .nota").last().css('background-color',nota.colore);
}
		

View.prototype.disegna = function(tmpl){
	
	
	var html = Mustache.to_html(tmpl);
	$("body").append(html);	
	$("#menu_window").hide();
	
	
}


