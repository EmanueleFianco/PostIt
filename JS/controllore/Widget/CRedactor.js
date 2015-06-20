var CRedactor = function(){
	
}

CRedactor.prototype.Inizializza = function(id_nota){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	  $("#redactor"+id_nota).redactor({
		  placeholder: 'Scrivi una nuova nota',
		  imageUpload: 'Controller/index.php?controller=nota&lavoro=upload'
	    });
	  
	//-----------------------TESTO NOTA -----------------------------//
		
		$("#TestoNota"+id_nota).mouseenter(function() {
			$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
		
			$("#"+id_nota).draggable("disable");
			
			
			}).mouseleave(function() {
				$(this).find(".redactor_toolbar").fadeTo("slow", 0);
				$("#"+id_nota).draggable("enable");
				$("#"+id_nota).draggable({
					containment: '#sortable'
				})
			  });
		
	//-----------------------TITOLO NOTA -----------------------------//
		
		$("#TitoloNota"+id_nota).mouseenter(function() {
			$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
			$("#"+id_nota).draggable("disable");
			
			
			}).mouseleave(function() {
				$(this).find(".redactor_toolbar").fadeTo("slow", 0);
				$("#"+id_nota).draggable("enable");
				$("#"+id_nota).draggable({
					containment: '#sortable'
				})
			  });
		
	//----------------------------------------------------------------------//	
		$("#TestoNota"+id_nota).keyup(function() {
			//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
					var id = $(this).parent().attr("id");
					var valore = $(this).find(".redactor_redactor").html();
					StrutturaCartelle.AggiornaNota(id,"testo",valore);
	//-------------------------------------------------------------------------------	
					
				})
	//------------------------------------------------------------------------------
		$("#TitoloNota"+id_nota).keyup(function() {
	//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
					var id = $(this).parent().attr("id");
					var valore = $(this).text();
					 StrutturaCartelle.AggiornaNota(id,"titolo",valore);
				//-------------------------------------------------------------------------------	  	
			    });
}

CRedactor.prototype.InizializzaNuova = function(){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	
	 $("#redactorNuova").redactor({
		  placeholder: 'Scrivi una nuova nota',
		  imageUpload: 'Controller/index.php?controller=nota&lavoro=upload'
	    });
	 
	 $("#TestoNotaNuova").mouseenter(function() {
			$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
			}).mouseleave(function() {
				$(this).find(".redactor_toolbar").fadeTo("slow", 0);
			  });
	 $("#TitoloNotaNuova").mouseenter(function() {
			$(this).find(".redactor_toolbar").css('visibility','visible').hide().fadeTo("slow", 1).css('visibility','visible');
			}).mouseleave(function() {
				$(this).find(".redactor_toolbar").fadeTo("slow", 0);
			  });
		
	 $("#TestoNotaNuova").keyup(function() {
			//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
					var id = $(this).parent().attr("id");
					var valore = $(this).find(".redactor_redactor").html();
					StrutturaCartelle.AggiornaNota(id,"testo",valore);
	 })
	 
	 $("#TitoloNotaNuova").keyup(function() {
	//  aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
					var id = $(this).parent().attr("id");
					var valore = $(this).text();
					StrutturaCartelle.AggiornaNota(id,"titolo",valore);
	 })
}