var CNota = function(){
	
}

CNota.prototype.Inizializza = function(){
	
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var view = singleton.getInstance(View,"View");
	var eventi = singleton.getInstance(CEventi,"CEventi");
	
	  
	//------------------------------------------------------------------------------
	  $(".TitoloNota").keyup(function() {
	//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
		  var id = $(this).parent().attr("id");
		  var valore = $(this).text();
		  StrutturaCartelle.AggiornaNota(id,"titolo",valore);
	//-------------------------------------------------------------------------------	  	
		  });
	
	//------------------------------------------------------------------------------	
	// da risolvere!!!	  
		$("#imgadd").on( "click",function(){
				var nota =StrutturaCartelle.getNota($(".NuovaNota").attr("id"));
				var cartellaAttiva = StrutturaCartelle.getCartellaAttiva();
				html=view.setNota(cartellaAttiva,nota,Template["Nota"],"TRUE");
				$('#'+cartellaAttiva).packery( 'appended', html );
				$(".NuovaNota").remove();
				view.aggiungiNuova(Template["NuovaNota"]);
				eventi.Inizializza();
				
				$('#'+cartellaAttiva).packery('reloadItems');
				$('#'+cartellaAttiva).packery();
			
			  });

}