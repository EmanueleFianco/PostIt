		
var View = function(){
	
	
}

View.prototype.getNota = function(nota){
	
	var Dati = new Object();
	  Dati['titolo'] = {
				controller : "nota",
				lavoro: "aggiorna",
				tipo: "titolo",
				titolo: $(nota).text(),
				id: $(nota).parent().data("id")
			};
	   
	  Dati['testo'] = {
				controller : "nota",
				lavoro: "aggiorna",
				tipo: "testo",
				testo: $(nota).find(".redactor_redactor").html(),
				id: $(nota).parent().data("id")
			};
	  Dati['colore']={
				controller : "nota",
				lavoro: "aggiorna",
				tipo: "colore",
				colore: $(nota).find('.colorInput').val(),
				id: $(nota).parent().data("id")
			};
	  Dati['posizione']={
			  
		};
	  $.each($("#sortable").find(".nota"),function(i,nota){
		  var posizione= new Object();
		  
		  posizione[$(nota).data("id")]={
				  x : $(nota).css("left"),
				  y: $(nota).css("top")
		  }
	    	//aggiungi = Dati['posizione'].push(posizione);
	    })
	  
	  

	  return Dati;
}



View.prototype.setNota = function(nota,tmpl,pos){
	var html = Mustache.to_html(tmpl,nota);
	$('#sortable').append(html);
	$("#sortable .nota").last().css('background-color',nota.colore);
}
		

View.prototype.disegna = function(tmpl){
	
	
	var html = Mustache.to_html(tmpl);
	$("body").append(html);	
	$("#menu_window").hide();
	
	
}


