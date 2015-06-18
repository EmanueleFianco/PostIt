var CColorpicker = function(){
	
}

CColorpicker.prototype.Inizializza = function(){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
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
 
		$('.colorPicker').bind("change", function() {
			//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
		 var id= $(this).parent().attr("id");
		 var valore= $(this).find('.colorInput').val();
		StrutturaCartelle.AggiornaNota(id,"colore",valore);
	
			});
}