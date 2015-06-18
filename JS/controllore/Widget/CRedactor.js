var CRedactor = function(){
	
}

CRedactor.prototype.Inizializza = function(){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	  $(".redactor").redactor({
		  placeholder: 'Scrivi una nuova nota',
		  imageUpload: 'Controller/index.php?controller=nota&lavoro=upload'
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
		
	//----------------------------------------------------------------------//	
		$(".TestoNota").keyup(function() {
			//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
					var id = $(this).parent().attr("id");
					var valore = $(this).find(".redactor_redactor").html();
					StrutturaCartelle.AggiornaNota(id,"testo",valore);
	//-------------------------------------------------------------------------------	
					
				})
}