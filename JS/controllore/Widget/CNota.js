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
				nota["id_nota"] =$(".NuovaNota").attr("id");
				
				var cartellaAttiva = StrutturaCartelle.getCartellaAttiva();
				html=view.setNota(cartellaAttiva,nota,Template["Nota"],"TRUE");
				$('#'+cartellaAttiva).packery( 'appended', html );
				$(".NuovaNota").remove();
				view.aggiungiNuova(Template["NuovaNota"]);
				
				$('#'+cartellaAttiva).packery('reloadItems');
				$('#'+cartellaAttiva).packery();
			
			  });

}