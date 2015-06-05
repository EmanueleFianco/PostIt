	
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
						  $("#sortable").sortable({
				                placeholder: "highlight",
				                start: function (event, ui) {
				                        ui.item.toggleClass("highlight");
				                       var $elem = $(ui.item)
				                      $(".highlight").css('height',$elem.css('height')).css('width',$elem.css('width'))
				                      .css('background-color',$elem.css('background-color'));
				                },
				                stop: function (event, ui) {
				                        ui.item.toggleClass("highlight");
				                }
				        });
						
						var data= 0;
						$(".redactor").redactor({
					        imageUpload: '/your_image_upload_script/',
					    });
						
						
						eventi.setNotaAnimation();
						eventi.AggiornaNota();
						
					
						
						
						
			
				
						
					 
						
						
							  
						
						
					})	
			})
	
}


