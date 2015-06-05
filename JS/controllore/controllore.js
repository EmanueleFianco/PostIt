	
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
							var pos=i+1;
								view.setNota(nota,Template["Nota"],pos);
								$(".nota").last().css('background-color',nota.colore);
							if(pos==2){
								pos=0;
							}
						})
						  $("#sortable1, #sortable2,#sortable3").sortable({
							  connectWith: ".connectedSortable",
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
						
					
						
						$('.colorPicker').tinycolorpicker();
						
			
						$('.colorPicker').bind("change", function(){
							
							var colore = $(this).find(".colorinput").val();
							$(this).parents(".nota").css('background-color',colore);
							
							    });
										
						var menu=[{  
   		name:'sposta',
   		img:'JS/view/Image/editnotamove.png',
   		title:'sposta in',
   		subMenu: 
   		[{

   			name:'note',
   			title:'le mie note',
   			img:'JS/view/Image/editmienote.png',
   			fun:function(){
   				alert('spostato nelle tue note')
   			}
   		},{
   			name:'promemoria',
   			title:'i miei promemoria',
   			img:'JS/view/Image/editpromemoria.jpg',
   			fun:function(){
   				alert('spostato in promemoria')
   			}
   		}, {
   			name:'gruppi',
   			title:'i miei gruppi',
   			img:'JS/view/Image/editgruppi.png',
   			fun:function(){
   				alert('spostato nei gruppi')
   			}
   		}]

	 },{
	 	    name:'cancella',
	 	    title:'cancella nota',
	 	    img:'JS/view/Image/editcancella.png',
	 	    fun:function(){
	 	    	alert('nota cancellata')
	 	}

	 }];
   
  $('.editnota').contextMenu(menu).update('sizeStyle','content').end().mouseenter(function()
  {
  	$('#sortable').sortable('option','disabled',true);
  }).mouseleave(function()
  {
  	$('#sortable').sortable("enable");
  });
						
					 
						
						
							  
						
						
					})	
			})
	
}


