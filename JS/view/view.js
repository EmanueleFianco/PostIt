		
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
	var view = singleton.getInstance(View,"View");
	var posizioni=view.getPosizioni();
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	StrutturaCartelle.AggiornaPosizioniNote(posizioni);
}

View.prototype.setNota = function(nota,tmpl,nuova){
	
	var html = Mustache.to_html(tmpl,nota);
	if(nuova == "TRUE"){
		$('#sortable').prepend(html);
		$("#sortable .nota").first().css('background-color',nota.colore);
		$("#sortable .time").first().css({
			'background-color':nota.colore,
			'border':'none',
			
		});
		
	}
	else{
	$('#sortable').append(html);
	$("#sortable .nota").last().css('background-color',nota.colore);
	$("#sortable .time").last().css({
		'background-color':nota.colore,
		'border':'none',
		
	});
	}
	return html;
}




View.prototype.setCartella = function(cartella,tmpl){
	var html = Mustache.to_html(tmpl,cartella);
	$('#menubottom').append(html);
	if(cartella.nome=="Note"){
		$("#nota_space").attr("id_cartella",cartella.id);
	}
}
		

View.prototype.disegna = function(tmplMain){

	var html = Mustache.to_html(tmplMain);
	$("body").append(html);	
	$("#menu_window").hide();
	
}

View.prototype.aggiungiNuova  = function(tmplNuovaNota){
	
	$("#NuovaNotaSpace").prepend(tmplNuovaNota);
}


