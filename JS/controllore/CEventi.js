
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
  
 
  
  
CEventi.prototype.setNotaAnimation = function(){
	  
	  $(".redactor").redactor({
	        imageUpload: '/your_image_upload_script/',
	    });
	  
	  
	  
	  
	 
	  function orderItems()  {
		  var elems = $container.packery('getItemElements');
		  for ( var i=0, len = elems.length; i < len; i++ ) {
		      var elem = elems[i];
		      $(elem).attr("tabindex",i);
		    }
		  
		 
			  
		  
		  }
	  
	  function ordinaInvia(){
		  orderItems();
		  var elementiInvia = new Array();
		  $.each($(".nota"),function(i,fusione_element){
				
					elementiInvia.push({
						"posizione":$(fusione_element).attr("tabindex"),
						"id":$(fusione_element).data("id")
				})
				})
			var finale= new Object();
			finale ={
					"controller":"nota",
					"lavoro":"aggiornaPosizioni",
					"posizioni":elementiInvia
			}
			$.when(dati.setPosizioni(finale)).done(function(a1){
				if(a1[1]=="success"){
					console.log("mandate");
				}
				
			})
		 

	  }
	  
	  var $container = $('#sortable').packery({
		    rowHeight: 100,
		    "percentPosition": true,
		    "isOriginLeft": true,
		  });

	
		var $itemElems = $container.find('.nota');

		$itemElems.draggable();
		$container.packery( 'bindUIDraggableEvents', $itemElems );
		$container.packery("on", 'layoutComplete', orderItems );
		$container.packery("on", 'dragItemPositioned', ordinaInvia );
		
		
		//-------------------------------------------
	

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
	        var colore = $(this).find(".colorinput").val();
			$(this).parents(".nota").css('background-color',colore);
						
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

	
  }
  
CEventi.prototype.AggiornaNota = function(){
	
	  
	  $('.colorPicker').bind("change", function() {
		  	var Dati = view.getNota(this);
		    dati.setNote(Dati['colore'])
		  });
	  
	  
	  $(".TitoloNota").keypress(function() {
		  
		  	var Dati = view.getNota(this);
		    dati.setNote(Dati['titolo'])
		  }).focusout(function(){
			  var Dati = view.getNota(this);
			  dati.setNote(Dati['titolo'])
		  })
	   
		$(".TestoNota").keypress(function() {
			var Dati = view.getNota(this);
		    dati.setNote(Dati['testo'])
		  }).focusout(function(){
			  var Dati = view.getNota(this);
			  dati.setNote(Dati['testo'])
		  });
		
		
  }
  
  
	
}
