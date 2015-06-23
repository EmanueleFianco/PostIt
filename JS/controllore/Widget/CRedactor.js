var CRedactor = function(){
	
}

CRedactor.prototype.Inizializza = function(id_nota){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var dati =singleton.getInstance(CDati,"CDati");
	flag = "FALSE";
	
	  $("#redactor"+id_nota).redactor({
		  imageLink: false,  
		  imageUpload : "Home.php?controller=nota&lavoro=upload", 
		  imageUploadCallback: function()
		    {
			  var delay=200; //1 seconds

			  setTimeout(function(){
	     
				  $('#'+StrutturaCartelle.getCartellaAttiva()).packery();
			  }, delay);

		    },
	
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
					var valore = $(this).find(".redactor_").html();
					StrutturaCartelle.AggiornaNota(id,"testo",valore);
				});
		
		
		$("#"+id_nota).focusin(function(event){
			
			if(flag == "FALSE"){
				flag="TRUE";
					  var Data ={	
								controller : "nota",
								lavoro: "focus",
								id: id_nota,
								evento: "acquisito"
							} 
					  
					 $.when(dati.setNote(Data)).done(function(DatiArrivati){
						 DatiArrivati= $.parseJSON(DatiArrivati);
						 if(Object.keys(DatiArrivati).length >0){
						 $("#bloccata"+id_nota).css("display","block").text("Nota Bloccata da:"+DatiArrivati.error);
						 }
					 });
					  
			}
				  }).focusout(function(){
					  $("#bloccata"+id_nota).css("display","none").text("Nota Bloccata");
					  flag="FALSE";
					  var Data ={	
								controller : "nota",
								lavoro: "focus",
								id: id_nota,
								evento: "perso"
							} 
					  dati.setNote(Data);  
				  });
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
		  imageUpload: 'Home.php?controller=nota&lavoro=upload',
		  imageLink: false,  
		  
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