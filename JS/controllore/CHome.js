	
var CHome = function(){
	singleton = new Singleton();
	Template = new Array();
	
	var dati =singleton.getInstance(CDati,"CDati");
	var eventi = singleton.getInstance(CEventi,"CEventi");
	var view = singleton.getInstance(View,"View");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	
	StrutturaCartelle.Inizializza();
	
	
	
	$.when(dati.getTemplate("Main"),
			dati.getTemplate("Nota"),
			dati.getTemplate("NuovaNota"),
			dati.getTemplate("Cartella"))
	.done(function(N1,N2,N3,N4){
		Template["Main"]=N1[0];
		Template["Nota"]=N2[0];
		Template["NuovaNota"]= N3[0];
		Template["Cartella"]=N4[0];
				
		view.disegna(Template["Main"]);	
		view.aggiungiNuova(Template["NuovaNota"]);
		
		
		$.when(dati.getCartelle('emanuele.fianco@gmail.com')).done(function(cartelle){
			//da incapsulare dentro CCartelle
			var Cartelle = $.parseJSON(cartelle);
			
			$.each(Cartelle,function(i,Cartella){
				StrutturaCartelle.aggiungiCartella(Cartella);
				if(Cartella.nome == "Note"){
					StrutturaCartelle.setCartellaAttiva(Cartella.id);
				}
			});
			
			
				$.when(dati.getNote(StrutturaCartelle.getCartellaAttiva(),'0','12')).done(function(note){
					var Note = $.parseJSON(note);
					$.each(Note,function(i,nota){
						StrutturaCartelle.aggiungiNota(StrutturaCartelle.getCartellaAttiva(),nota);
					})
					
					eventi.Inizializza();
				})
			})
			
	
			
		})
	
}


