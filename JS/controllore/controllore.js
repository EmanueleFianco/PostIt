	
var CHome = function(){
	var Template = new Array();
	dati= new CDati();
	eventi = new CEventi();
	view = new View();
	
	$.when(dati.getTemplate("Main"),dati.getTemplate("Nota"))
	.done(function(a1,a2){
		Template["Main"]=a1[0];
		Template["Nota"]=a2[0];
				
				view.disegna(Template["Main"]);
				
				eventi.setEventiGlobali();
					$.when(dati.getNote()).done(function(note){
						var array = $.parseJSON(note);
						$.each(array,function(i,nota){
	
								view.setNota(nota,Template["Nota"]);
	
						})
						var data= 0;
						$(".redactor").redactor();
						$(".redactor_redactor").focusout(function() {
				
							var datinota = {
								Testo: $(this).text(),
								Id: $(this).parent().prev().text()
							};
				
						    dati.setNote(datinota);
						  })
						
						
						//$('#sortable').sortable();   
						
						
							  
						
						
					})	
			})
			
}


