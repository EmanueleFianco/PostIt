
var CEventi = function(){
	
}

CEventi.prototype.setEventiGlobali = function(){
	
	
	$("#menu_button").click(function(event){
		$("#menubottom").fadeToggle( "slow", "linear" );
	});

	 $(".cointainerbottom").mouseover(function()
   {
        $(this).animate({marginTop:'-=25'},0,'linear');
            

   });

	$("#main").click(function()
	{
		$("#menubottom").fadeOut("slow","linear");
	});

     $(".cointainerbottom").mouseout(function()
   {
        $(this).animate({marginTop:'+=25'},0,'linear');
            

   });

   $(".cointainerbottom").click(function(){ 
             
      $(this).animate({marginTop:'-=100'},100,'linear',function(){
        	$(this).animate({marginTop:'+=100'},100,'linear',function(){
        		$(this).animate({marginTop:'-=50'},50,'linear',function(){
        			$(this).animate({marginTop:'+=50'},50,'linear',function(){
        				$(this).animate({marginTop:'-=20'},25,'linear',function(){
        					$(this).animate({marginTop:'+=20'},25,'linear')
        				})
        			})
        		  })
        	    })
        	 });
        

    
    });

  CEventi.prototype.setNotaAnimation = function(){

	 	
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
   
  $('.editnota').contextMenu(menu).update('sizeStyle','content');
										 
	$(".TestoNota").mouseenter(function() {
		$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
		$("#sortable1, #sortable2,#sortable3").sortable( "option", "disabled", true );
		
		
		}).mouseleave(function() {
			$(this).find(".redactor_toolbar").fadeTo("slow", 0);
			$("#sortable1, #sortable2,#sortable3").sortable("enable");
		  });
	
	$(".TitoloNota").mouseenter(function() {
		$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
		$("#sortable1, #sortable2,#sortable3").sortable( "option", "disabled", true );
		
		
		}).mouseleave(function() {
			$(this).find(".redactor_toolbar").fadeTo("slow", 0);
			$("#sortable1, #sortable2,#sortable3").sortable("enable");
		  });
	    
	    $(".colorPicker").mouseenter(function(){
				$("#sortable1, #sortable2,#sortable3").sortable( "option", "disabled", true );
	    }).mouseleave(function(){
	    	$("#sortable1, #sortable2,#sortable3").sortable("enable");
	    });
 
        $(".editnota").mouseenter(function(){
				$("#sortable1, #sortable2,#sortable3").sortable( "option", "disabled", true );
	    }).mouseleave(function(){
	    	$("#sortable1, #sortable2,#sortable3").sortable("enable");
	    });

	  
  }
  
  CEventi.prototype.AggiornaNota = function(){
	  
	  
		$(".redactor_redactor").keypress(function() {
			
			var datinota = {
				Testo: $(this).html(),
				Id: $(this).parent().prev().text()
			};

		    dati.setNote(datinota);
		  });
		
$	(".redactor_redactor").focusout(function() {
			
			var datinota = {
				Testo: $(this).html(),
				Id: $(this).parent().prev().text()
			};

		    dati.setNote(datinota);
		  });
		
  }
	
}
