var CColorpicker = function(){
	
}

CColorpicker.prototype.Inizializza = function(id_nota){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	$('#colorPicker'+id_nota).tinycolorpicker();
	$('#colorPicker'+id_nota).bind("change", function(){		
	        var colore = $(this).find(".colorInput").val();
			$(this).parents(".nota,.NuovaNota").css('background-color',colore);
						
		 });
	
		$('#colorPicker'+id_nota).mouseenter(function(){
				$("#nota"+id_nota).draggable("disable");
	    }).mouseleave(function(){
	    	$("#nota"+id_nota).draggable("enable");
	    });
 
		$('#colorPicker'+id_nota).bind("change", function() {
			//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
		 var id= $(this).parent().attr("id");
		 var valore= $(this).find('.colorInput').val();
		StrutturaCartelle.AggiornaNota(id,"colore",valore);
	
			});
}