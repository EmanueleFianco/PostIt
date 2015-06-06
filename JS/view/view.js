		
var View = function(){
	
	
}

View.prototype.getNota = function(nota){
	
	var Dati = new Object();
	  Dati['titolo'] = {
				Controller : "nota",
				Lavoro: "aggiorna",
				Tipo: "titolo",
				Titolo: $(nota).text(),
				Id: $(nota).prevAll().text().trim()
			};
	   
	  Dati['testo'] = {
				Controller : "nota",
				Lavoro: "aggiorna",
				Tipo: "testo",
				Testo: $(nota).find(".redactor_redactor").html(),
				Id: $(nota).prevAll().text().trim()
			};
	  Dati['colore']={
				Controller : "nota",
				Lavoro: "aggiorna",
				Tipo: "colore",
				Colore: $(nota).find('.colorInput').val(),
				Id: $(nota).prevAll().text().trim()
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


