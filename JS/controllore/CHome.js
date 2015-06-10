	
var CHome = function(){
	var Template = new Array();
	dati= new CDati();
	eventi = new CEventi();
	view = new View();
	cnote = new CNote();
	
	$.when(dati.getTemplate("Main"),dati.getTemplate("Nota"),dati.getTemplate("NuovaNota"))
	.done(function(N1,N2,N3){
		Template["Main"]=N1[0];
		Template["Nota"]=N2[0];
		Template["NuovaNota"]= N3[0];
				
		view.disegna(Template["Main"],Template["NuovaNota"]);	
		
		
		eventi.setEventiGlobali();
		
		
		$.when(dati.getNote()).done(function(note){

			var array = $.parseJSON(note);
			var Struttura = new Object();
				$.each(array,function(i,nota){
						view.setNota(nota,Template["Nota"]);
						// Creo Struttura Dati
						cnote.aggiungiNota(nota);
						
				})	

			eventi.setNotaEvent();
			eventi.setNotaChangeEvent();
	
			})	
		})
	
}


