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
				
				if((nota.ora_data_avviso == "" && nomeCartellaAttiva == "Promemoria") ||(nota.ora_data_avviso != "" && nomeCartellaAttiva == "Note") ){
					$(".NuovaNota").remove();
					view.aggiungiNuova(Template["NuovaNota"]);
					$('#'+cartellaAttiva).packery('reloadItems');
					$('#'+cartellaAttiva).packery();
					if(nomeCartellaAttiva == "Promemoria"){
					$("#bloccata").css("display","block").text("Nota Spostata in Note");
  					$("#bloccata").fadeOut(6000);
					}
					else{
						$("#bloccata").css("display","block").text("Nota Spostata in Promemoria");
	  					$("#bloccata").fadeOut(6000);
					}
				}
				else{
					html=view.setNota(cartellaAttiva,nota,Template["Nota"],"TRUE");
					$('#'+cartellaAttiva).packery( 'appended', html );
					$(".NuovaNota").remove();
					view.aggiungiNuova(Template["NuovaNota"]);
					$('#'+cartellaAttiva).packery('reloadItems');
					$('#'+cartellaAttiva).packery();
				}
				
		
				
			
			  });

}