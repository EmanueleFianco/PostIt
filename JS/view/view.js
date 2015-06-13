		
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
	$("#sortable .time").last().css({
		'background-color':nota.colore,
		'border':'none',
		
	});
	return html;
}

View.prototype.setCartella = function(cartella,tmpl){
	var html = Mustache.to_html(tmpl,cartella);
	$('#menubottom').append(html);
	if(cartella.nome=="Note"){
		$("#nota_space").attr("id_cartella",cartella.id);
	}
}
		

View.prototype.disegna = function(tmplMain,tmplNuovaNota){

	var html = Mustache.to_html(tmplMain);
	$("body").append(html);	
	$("#menu_window").hide();
	
	$("#NuovaNotaSpace").prepend(tmplNuovaNota);
}


