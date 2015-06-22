		
var View = function(){
	
	
}

View.prototype.getPosizioni= function(){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var cartellaAttiva = StrutturaCartelle.getCartellaAttiva();
	
	  var note_packery = $('#'+cartellaAttiva).packery('getItemElements');
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
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var view = singleton.getInstance(View,"View");
	var posizioni=view.getPosizioni();

	StrutturaCartelle.AggiornaPosizioniNote(posizioni);
}

View.prototype.setNota = function(id_cartella,nota,tmpl,nuova){
	var eventi = singleton.getInstance(CEventi,"CEventi");
	
	
	var html = Mustache.to_html(tmpl,nota);
	if(nuova == "TRUE"){
		$('#'+id_cartella).prepend(html);
		$("#"+id_cartella+" .nota").first().css('background-color',nota.colore);
		$("#"+id_cartella+" .time").first().css({
			'background-color':nota.colore,
			'border':'none',
			
		});
		
	}
	else{
	$('#'+id_cartella).append(html);
	$("#"+id_cartella+" .nota").last().css('background-color',nota.colore);
	$("#"+id_cartella+" .time").last().css({
		'background-color':nota.colore,
		'border':'none',
		
	});
	}
	
	
	eventi.InizializzaNota(nota.id_nota);
	return html;
}




View.prototype.setCartella = function(cartella,tmpl){
	
}


		

View.prototype.disegna = function(tmplMain,Cartelle){

	var html = Mustache.to_html(tmplMain,Cartelle);
	$("body").append(html);	
}

View.prototype.aggiungiNuova  = function(tmplNuovaNota){
	var eventi = singleton.getInstance(CEventi,"CEventi");
	$("#NuovaNotaSpace").prepend(tmplNuovaNota);
	eventi.InizializzaNota("Nuova");
}
View.prototype.smonta= function(wrap){
	$(wrap).remove();
}


