
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
    //---- da vedere animazioni!!!!   
       var click=$(this).attr('id');
       $('body *').removeClass("note cestino promemoria gruppi").addClass(click);
        
//---------------------------
    
    });


  
} 


CEventi.prototype.setMenu=function(){


  
	function scrollY() {
		return window.pageYOffset || docElem.scrollTop;
	}

	// from http://stackoverflow.com/a/11381730/989439
	function mobilecheck() {
		var check = false;
		(function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	}

	var docElem = window.document.documentElement,
		// support transitions
		support = Modernizr.csstransitions,
		// transition end event name
		transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		docscroll = 0,
		// click event (if mobile use touchstart)
		clickevent = mobilecheck() ? 'touchstart' : 'click';

	function init() {
		var showMenu = document.getElementById( 'showMenu' ),
			perspectiveWrapper = document.getElementById( 'perspective' ),
			container = perspectiveWrapper.querySelector( '.container' ),
			contentWrapper = container.querySelector( '.wrapper' );

		showMenu.addEventListener( clickevent, function( ev ) {
			ev.stopPropagation();
			ev.preventDefault();
			docscroll = scrollY();
			// change top of contentWrapper
			contentWrapper.style.top = docscroll * -1 + 'px';
			// mac chrome issue:
			document.body.scrollTop = document.documentElement.scrollTop = 0;
			// add modalview class
			classie.add( perspectiveWrapper, 'modalview' );
			// animate..
			setTimeout( function() { classie.add( perspectiveWrapper, 'animate' ); }, 25 );
		});

		container.addEventListener( clickevent, function( ev ) {
			if( classie.has( perspectiveWrapper, 'animate') ) {
				var onEndTransFn = function( ev ) {
					if( support && ( ev.target.className !== 'container' || ev.propertyName.indexOf( 'transform' ) == -1 ) ) return;
					this.removeEventListener( transEndEventName, onEndTransFn );
					classie.remove( perspectiveWrapper, 'modalview' );
					// mac chrome issue:
					document.body.scrollTop = document.documentElement.scrollTop = docscroll;
					// change top of contentWrapper
					contentWrapper.style.top = '0px';
				};
				if( support ) {
					perspectiveWrapper.addEventListener( transEndEventName, onEndTransFn );
				}
				else {
					onEndTransFn.call();
				}
				classie.remove( perspectiveWrapper, 'animate' );
			}
		});

		perspectiveWrapper.addEventListener( clickevent, function( ev ) { return false; } );
	}

	init();

	$(".iconmenu").click(function(){
		var label=$(this).attr('id');		
		var id = ccartelle.getIdCartella(label);
		var num=cnote.countNote();
		cnote.getNoteByCartella(id,num,12);
		
		
		


	})
    


}


  
  
CEventi.prototype.setNotaEvent = function(){
	$.datepicker.regional['it'] = {
			monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
			'Luglio','Agosto','Settembre','ottobre','Novembre','Dicembre'],
			monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu',
			'Lug','Ago','Set','Ott','Nov','Dic'],
			dayNames: ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica'],
			dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
			dayNamesMin: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
			weekHeader: 'Не',
			dateFormat: 'dd.mm.yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
	
	$.datepicker.setDefaults($.datepicker.regional['it']);
	$(".time").datetimepicker({
		timeText: 'Orario',
		hourText: 'Ora',
		minuteText: 'Minuti',
		currentText: 'Ora',
		closeText: 'Chiudi'
	});
	
	
	  $(".redactor").redactor({
		  placeholder: 'Scrivi una nuova nota',
		  imageUpload: 'Controller/index.php?controller=nota&lavoro=upload'
	    });
	 
	// ------------------------TASTO ADD NOTA ---------------------//
	  
	
	  
	  

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
	
		
		 var $container = $('#sortable').packery({
			  	"rowHeight": 100,
			    "isOriginLeft": true,
			    "bindResize":true
			  });
	//   aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
	//   Aggiornamento POSIZIONI
		var $itemElems = $("#sortable").find('.nota').draggable();
		
		$("#sortable").packery( 'bindUIDraggableEvents', $itemElems );
		$("#sortable").packery("on", 'layoutComplete', view.getPosizioni );
		$("#sortable").packery("on", 'dragItemPositioned', view.setPosizioni );
	//------------------------------------------------------------------------------	
	// da risolvere!!!	  
		$("#imgadd").on( "click",function(){
				var nota =cnote.getNota($(".NuovaNota").attr("id"));
				nota["id"]=$(".NuovaNota").attr("id");
				html=view.setNota(nota,Template["Nota"],"TRUE");
				$("#sortable").packery( 'appended', html );
				$(".NuovaNota").remove();
				view.aggiungiNuova(Template["NuovaNota"]);
				eventi.setNotaEvent();
				eventi.setNotaChangeEvent();
				$container.packery('reloadItems');
				$("#sortable").packery();
			
			  });



}
  
  

