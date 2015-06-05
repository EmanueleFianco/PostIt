
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
		
	
	
	  
		
		
  //-----------------------TESTO NOTA -----------------------------//
	$(".TestoNota").mouseenter(function() {
		$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
		$("#sortable1, #sortable2,#sortable3").sortable( "option", "disabled", true );
		
		
		}).mouseleave(function() {
			$(this).find(".redactor_toolbar").fadeTo("slow", 0);
			$("#sortable1, #sortable2,#sortable3").sortable("enable");
		  });
	
	//-----------------------TITOLO NOTA -----------------------------//
	$(".TitoloNota").mouseenter(function() {
		$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
		$("#sortable1, #sortable2,#sortable3").sortable( "option", "disabled", true );
		
		
		}).mouseleave(function() {
			$(this).find(".redactor_toolbar").fadeTo("slow", 0);
			$("#sortable1, #sortable2,#sortable3").sortable("enable");
		  });
	    
	//-----------------------COLOR PICKER -----------------------------//
	$('.colorPicker').tinycolorpicker();
	$('.colorPicker').bind("change", function(){		
	        var colore = $(this).find(".colorinput").val();
			$(this).parents(".nota").css('background-color',colore);
						
		 });
	
	
		$(".colorPicker").mouseenter(function(){
				$("#sortable1, #sortable2,#sortable3").sortable( "option", "disabled", true );
	    }).mouseleave(function(){
	    	$("#sortable1, #sortable2,#sortable3").sortable("enable");
	    });
 
	 //-----------------------EDIT NOTA -----------------------------//   
       
		  $.contextMenu({
		        selector: '.editnota', 
		        trigger: 'left',
		        
		        items: {
		            "note": {name: "Note", icon: "edit"},
		            "promemoria": {name: "Promemoria", icon: "cut"},
		            "gruppi": {name: "Gruppi", icon: "copy",
		                "items": {
		                	// ajax per richiedere tutti i gruppi dell utente
		                    "item1": {"name": "Nome_Gruppo"},
		                    "item2": {"name": "Nome_Gruppo"},
		                    "item3": {"name": "Nome_Gruppo"}
		            
		                }},
		                    
		            "cancella": {name: "Cancella", icon: "delete"},
		        }
		    });
		  
		  $('.editnota').on('click', function(e){
		        console.log('clicked', this);
		    })
		
	
		$(".editnota").mouseenter(function(){
				$("#sortable1, #sortable2,#sortable3").sortable( "option", "disabled", true );
	    }).mouseleave(function(){
	    	$("#sortable1, #sortable2,#sortable3").sortable("enable");
	    });
        
   // -------------------------------------------//     
        

	  
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
