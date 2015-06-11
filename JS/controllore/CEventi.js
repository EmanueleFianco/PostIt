
var CEventi = function(){
	
}

CEventi.prototype.setEventiGlobali = function(){
	
	
	$("#menu_button").click(function(event){
		$("#menubottom").fadeToggle( "slow", "linear" );
	});

	 $(".cointainerbottom").mouseover(function()
   {
        $(this).animate({marginTop:'-=15'},0,'linear');
            

   });

	$("#main").click(function()
	{
		$("#menubottom").fadeOut("slow","linear");
	});

     $(".cointainerbottom").mouseout(function()
   {
        $(this).animate({marginTop:'+=15'},0,'linear');
            

   });

   $(".cointainerbottom").click(function(){ 
             
      $(this).animate({marginTop:'-=80'},100,'linear',function(){
        	$(this).animate({marginTop:'+=80'},100,'linear',function(){
        		$(this).animate({marginTop:'-=40'},50,'linear',function(){
        			$(this).animate({marginTop:'+=40'},50,'linear',function(){
        				$(this).animate({marginTop:'-=15'},25,'linear',function(){
        					$(this).animate({marginTop:'+=15'},25,'linear')
        				})
        			})
        		  })
        	    })
        	 });
       
       var click=$(this).attr('id');
       $('body *').removeClass("note cestino promemoria gruppi").addClass(click);
        

    
    });
  
} 
  
  
CEventi.prototype.setNotaEvent = function(){
	
	  $(".redactor").redactor({
		  placeholder: 'Scrivi una nuova nota',
		  imageUpload: './Controller/upload.php'
		  
	    });
	  var $container = $('#sortable').packery({
		    rowHeight: 100,
		    "percentPosition": true,
		    "isOriginLeft": true,
		    "bindResize":true
		  });

  //-----------------------TESTO NOTA -----------------------------//
	
	
		
	$(".TestoNota").mouseenter(function() {
		$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
		$(".nota").draggable("disable");
		
		
		}).mouseleave(function() {
			$(this).find(".redactor_toolbar").fadeTo("slow", 0);
			$(".nota").draggable("enable");
		  });
	
	//-----------------------TITOLO NOTA -----------------------------//
	$(".TitoloNota").mouseenter(function() {
		$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
		$(".nota").draggable("disable");
		
		
		}).mouseleave(function() {
			$(this).find(".redactor_toolbar").fadeTo("slow", 0);
			$(".nota").draggable("enable");
		  });
	    
	//-----------------------COLOR PICKER -----------------------------//
	$('.colorPicker').tinycolorpicker();
	$('.colorPicker').bind("change", function(){		
	        var colore = $(this).find(".colorInput").val();
			$(this).parents(".nota,.NuovaNota").css('background-color',colore);
						
		 });
	
		$(".colorPicker").mouseenter(function(){
				$(".nota").draggable("disable");
	    }).mouseleave(function(){
	    	$(".nota").draggable("enable");
	    });
 
//-----------------------EDIT NOTA -----------------------------//   
       
		$.contextMenu({
		        selector: '.editnota', 
		        trigger: 'left',
                zIndex:900,
                autoHide:true,
                animation:{duration:800,show:"show",hide:"fadeOut"},
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
		             "cancella": {name: "Cancella", icon: "delete",
		            	 callback:function(){
                                    var Dati={   
                                              id: $(this).parent(".nota").attr("data-id"),
                                              controller:"nota",
                                              lavoro:"cancella"
                                          };
                                    
                                    dati.setNote(Dati);
                                    console.log(Dati);
                                    $(this).parent(".nota").hide();
                            }},
		        }
		    });
//------------------------------------------------------------------------------
	
  }
  
CEventi.prototype.setNotaChangeEvent = function(){
	
	  $('.colorPicker').bind("change", function() {
	//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
		    var id= $(this).parent().attr("id");
		    var valore= $(this).find('.colorInput').val();
		    cnote.Aggiorna(id,"colore",valore);
	//------------------------------------------------------------------------------
		  });
	  $(".TitoloNota").keyup(function() {
	//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
		  var id = $(this).parent().attr("id");
		  var valore = $(this).text();
		  cnote.Aggiorna(id,"titolo",valore);
	//-------------------------------------------------------------------------------	  	
		  });
		$(".TestoNota").keyup(function() {
	//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
			var id = $(this).parent().attr("id");
			var valore = $(this).find(".redactor_redactor").html();
			cnote.Aggiorna(id,"testo",valore);
	//-------------------------------------------------------------------------------	
			
		}).keydown(function(){
			$("#sortable").packery();
		});
	
	//   aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
	//   Aggiornamento POSIZIONI
		var $itemElems = $("#sortable").find('.nota').draggable();
		
		$("#sortable").packery( 'bindUIDraggableEvents', $itemElems );
		$("#sortable").packery("on", 'layoutComplete', view.getPosizioni );
		$("#sortable").packery("on", 'dragItemPositioned', view.setPosizioni );
	//------------------------------------------------------------------------------	
  }
  
  

