	
var CHome = function(){
	Template = new Array();
	dati= new CDati();
	eventi = new CEventi();
	view = new View();
	cnote = new CNote();
	ccartelle=new CCartelle();
	
	$.when(dati.getTemplate("Main"),
			dati.getTemplate("Nota"),
			dati.getTemplate("NuovaNota"),
			dati.getTemplate("Cartella"))
	.done(function(N1,N2,N3,N4){
		Template["Main"]=N1[0];
		Template["Nota"]=N2[0];
		Template["NuovaNota"]= N3[0];
		Template["Cartella"]=N4[0];
				
		view.disegna(Template["Main"],Template["NuovaNota"]);	
		
		
		eventi.setEventiGlobali();
		
		$.when(dati.getCartelle('emanuele.fianco@gmail.com')).done(function(cartelle){
			var Cartelle = $.parseJSON(cartelle);
			$.each(Cartelle,function(i,Cartella){
					// Creo Struttura Dati
					ccartelle.aggiungiCartella(Cartella);
					view.setCartella(Cartella,Template["Cartella"]);
			})
			
		
		
		
			$.when(dati.getNote()).done(function(note){

			var array = $.parseJSON(note);
				$.each(array,function(i,nota){
						view.setNota(nota,Template["Nota"]);
						// Creo Struttura Dati
						cnote.aggiungiNota(nota);
						
				})	

			eventi.setNotaEvent();
			eventi.setNotaChangeEvent();
	
			})
			
			})
			
		})
	
}


