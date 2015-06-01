	
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
								$(".nota").last().css('background-color',nota.colore);
						})
							
						var data= 0;
						$(".redactor").redactor();
						$(".nota").mouseenter(function() {
							$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
							//$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeIn('slow');
							
							}).mouseleave(function() {
								$(this).find(".redactor_toolbar").fadeTo("slow", 0);
							  });
						
						$(".redactor_redactor").focusout(function() {
				
							var datinota = {
								Testo: $(this).html(),
								Id: $(this).parent().prev().text()
							};
				
						    dati.setNote(datinota);
						  })
						
						//$('#sortable').sortable();   
						
						
							  
						
						
					})	
			})
	
}


