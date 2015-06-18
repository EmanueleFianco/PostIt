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
				nota["id"]=$(".NuovaNota").attr("id");
				html=view.setNota(nota,Template["Nota"],"TRUE");
				$("#sortable").packery( 'appended', html );
				$(".NuovaNota").remove();
				view.aggiungiNuova(Template["NuovaNota"]);
				eventi.Inizializza();
				
				$('#sortable').packery('reloadItems');
				$("#sortable").packery();
			
			  });

}