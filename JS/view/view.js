		
var View = function(){
	
	
}

View.prototype.getPosizioni= function(){
	
	  var note_packery = $("#sortable").packery('getItemElements');
	  var Posizioni = new Object();
	  $.each(note_packery,function(i,nota_packery){
		  var id=$(nota_packery).attr("id");
		  var valore=$(nota_packery).attr("posizione");
		  Posizioni[i]={
				 posizione: valore,
				 id: id
		  }
	  });
	  
	  return Posizioni;
}

View.prototype.setPosizioni= function(){
	var posizioni=view.getPosizioni();
	cnote.AggiornaPosizioni(posizioni);
}

View.prototype.setNota = function(nota,tmpl){
	var html = Mustache.to_html(tmpl,nota);
	$('#sortable').append(html);
	$("#sortable .nota").last().css('background-color',nota.colore);
}
		

View.prototype.disegna = function(tmplMain,tmplNuovaNota){

	var html = Mustache.to_html(tmplMain);
	$("body").append(html);	
	$("#menu_window").hide();
	
	$("#nota_space").prepend(tmplNuovaNota);
}


