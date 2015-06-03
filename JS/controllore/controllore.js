	
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
							
						$('#sortable').sortable();  
						var data= 0;
						$(".redactor").redactor();
						$(".TestoNota").mouseenter(function() {
							$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
							$('#sortable').sortable( "option", "disabled", true );  
							
							}).mouseleave(function() {
								$(this).find(".redactor_toolbar").fadeTo("slow", 0);
								$('#sortable').sortable("enable");
							  });
						
						$(".redactor_redactor").focusout(function() {
						 
							var datinota = {
								Testo: $(this).html(),
								Id: $(this).parent().prev().text()
							};
				
						    dati.setNote(datinota);
						  });
						
						$('.colorPicker').tinycolorpicker();
						var box = $('#colorPicker').data("plugin_tinycolorpicker");
			
						$('.colorPicker').bind("change", function(){
							
							var colore = $(this).find(".colorinput").val();
							$(this).parents(".nota").css('background-color',colore);
							
							    });
						
					 
						
						
							  
						
						
					})	
			})
	
}


