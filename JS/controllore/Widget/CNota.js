var CNota = function(){
	
}

CNota.prototype.Inizializza = function(){
	
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var view = singleton.getInstance(View,"View");
	var eventi = singleton.getInstance(CEventi,"CEventi");
	
	
	//------------------------------------------------------------------------------	
	// da risolvere!!!	  
		$("#imgadd").on( "click",function(){
				var nota =StrutturaCartelle.getNota($(".NuovaNota").attr("id"));
				var dati =singleton.getInstance(CDati,"CDati");
				nota["id_nota"] =$(".NuovaNota").attr("id");
				var cartellaAttiva = StrutturaCartelle.getCartellaAttiva();
				var nomeCartellaAttiva = Struttura[cartellaAttiva].nome;
				
				if(nota.ora_data_avviso == "" && nomeCartellaAttiva == "Note" ){
				html=view.setNota(cartellaAttiva,nota,Template["Nota"],"TRUE");
				$('#'+cartellaAttiva).packery( 'appended', html );
				}
				if(nota.ora_data_avviso != "" && nomeCartellaAttiva == "Promemoria" ){
					html=view.setNota(cartellaAttiva,nota,Template["Nota"],"TRUE");
					$('#'+cartellaAttiva).packery( 'appended', html );
					}
				
				$(".NuovaNota").remove();
				view.aggiungiNuova(Template["NuovaNota"]);
				$('#'+cartellaAttiva).packery('reloadItems');
				$('#'+cartellaAttiva).packery();
				
				
				
			
			  });

}