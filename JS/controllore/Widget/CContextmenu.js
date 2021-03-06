var CContextmenu = function(){
	
}

CContextmenu.prototype.Inizializza = function(id_nota){
	var dati =singleton.getInstance(CDati,"CDati");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var contexmenu = singleton.getInstance(CContextmenu,"CContextmenu");
	
	var nomi_cartelle_gruppo = new Object();
	var nomi_cartelle_private = new Object();
	

	
	$.each(Struttura,function(i,cartella){
		if(cartella.nome != "Note" && cartella.nome != "Promemoria" &&cartella.nome != "Archivio" &&cartella.nome != "Cestino"){
			if(cartella.tipo == "gruppo"){
				nomi_cartelle_gruppo[cartella.nome] ={
						name:cartella.nome,
				}
			}
			if(cartella.tipo == "privata"){
				nomi_cartelle_private[cartella.nome] ={
				name:cartella.nome,
				}
			}
		
		}
		
	});
	
	$.contextMenu({
        selector: '#editnota'+id_nota, 
        trigger: 'left',
        zIndex:900,
        autoHide:true,
        animation:{duration:800,show:"show",hide:"fadeOut"},
        items: {
            "note": {name: "Note", icon: "edit"},
            "archivio" : {name: "Archivio", icon: "paste"},
            "private" : {name : "Private",
            	"items":nomi_cartelle_private},
            "gruppi": {name: "Gruppi", icon: "copy",
            	"items":nomi_cartelle_gruppo },          
            	"sep1": "---------",
            "cancella": {name: "Cancella", icon: "delete"},
        	},
            	 callback:function(key, options){
            		 if(key == "cancella"){
            			 if($("#bloccata"+id_nota).css("display") != "block"){
                            var Dati={   
                                      id_nota: id_nota,
                                      id_cartella: StrutturaCartelle.getCartellaAttiva(),
                                      controller:"nota",
                                      lavoro:"cancella"
                                  };
                            
                            $.when(dati.setNote(Dati)).done(function(dati){
                            	var data = $.parseJSON(dati);
                            	if(Object.keys(data).length == 0){
                            		  $("#"+id_nota).remove();
                                      StrutturaCartelle.EliminaNota(id_nota);
                                      var nota = StrutturaCartelle.getNota(id_nota)
                                      $('#'+cartellaAttiva).packery('remove',nota);
                                      $('#'+cartellaAttiva).packery('reloadItems');
                                      $('#'+cartellaAttiva).packery();
                            	}
                            	else{
                            	$("#bloccata"+id_nota).css("display","block").text("Non hai i permessi per cancellare la nota");
               					 $("#bloccata"+id_nota).fadeOut(6000);
                            	}	
                            });
                          
            		 	}     
            		 }
            		 if(key == "note"){
            			
            			 if(Struttura[cartellaAttiva].nome != "Note"){
            				
            				 if(Struttura[cartellaAttiva].tipo != "gruppo"){
            					 var id_cartella_destinazione = StrutturaCartelle.getCartellaByNome("Note");
            					 StrutturaCartelle.SpostaNota(id_nota,id_cartella_destinazione);
            					 contexmenu.Aggiorna(id_nota);
            				 }
            				 else{
            					 $("#bloccata"+id_nota).css("display","block").text("Non puoi spostare una nota da un Gruppo a Note");
            					 $("#bloccata"+id_nota).fadeOut(6000);
            				 }
            			 }
            		 }
            		 if(key == "archivio"){
            			
            			 if(Struttura[cartellaAttiva].nome != "Archivio"){
            				 if(Struttura[cartellaAttiva].tipo != "gruppo"){
            					 var id_cartella_destinazione = StrutturaCartelle.getCartellaByNome("Archivio");
            					 StrutturaCartelle.SpostaNota(id_nota,id_cartella_destinazione); 
            					 contexmenu.Aggiorna(id_nota);
            				 }
            				 else{
            					 $("#bloccata"+id_nota).css("display","block").text("Non puoi spostare una nota da un Gruppo ad Archivio");
            					 $("#bloccata"+id_nota).fadeOut(6000);
            				 }
            			 }
            		 }
            		 if(key != "archivio" && key != "note" && key != "cancella" && key != "promemoria"){
            			
            			 
            			 if(Struttura[cartellaAttiva].tipo != "gruppo"){
            			 var id_cartella_destinazione = StrutturaCartelle.getCartellaByNome(key);
            			 StrutturaCartelle.SpostaNota(id_nota,id_cartella_destinazione);
            			 contexmenu.Aggiorna(id_nota);
            			 }
            			 else{
        					 $("#bloccata"+id_nota).css("display","block").text("Non puoi spostare una nota da un Gruppo a Privata");
        					 $("#bloccata"+id_nota).fadeOut(6000);
        				 }
            		 }
            		 
           
            	 }	   
    });

        $.contextMenu({
        selector: "#accountbotton", 
        trigger: 'left',
        events:{hide:function(){         
                $("#image_botton").removeClass("ruota90").end().addClass("ruota270");

            }},
        zIndex:900,
        autoHide:true,
        animation:{duration:800,show:"show",hide:"fadeOut"},
        items: {
            "logout":{name:"logout",icon:"door"}    

             
        },
        callback:function(key,opt){
            if(key=="logout")
            {
                $.jStorage.flush();
                location.replace('Home.php?controller=registrazione&lavoro=logout');

                    
                
            }
        }
    });
        
     

        $.contextMenu({
        selector: "#condividi"+id_nota, 
        trigger: 'left',
       
        zIndex:900,
        autoHide:false,
        animation:{duration:800,show:"show",hide:"fadeOut"},
        items: {
        	   email: {
                   name: "Condividi Con Email:", 
                   
                   type: 'text', 
                   value: "", 
                 
               },
              
               button: {   name: "Condividi", 
                   callback: function(){
                	 
                   }   
                   
               }
        },
        events: {
        	 hide: function(opt) {
                 var $this = this;
                 $.contextMenu.getInputValues(opt, $this.data());
                 var Data = {
                		 controller:"nota",
                		 lavoro: "condividi",
                		 id_nota: id_nota,
                		 email_utente: $this.data().email 		 
                 }
               dati.setNote(Data);
                 
             }
        	
        }
    });    
        
}


        
CContextmenu.prototype.Aggiorna= function(id_nota){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	
	$("#"+id_nota).remove();
	 var nota = StrutturaCartelle.getNota(id_nota)
    $('#'+cartellaAttiva).packery('remove',nota);
    $('#'+cartellaAttiva).packery('reloadItems');
    $('#'+cartellaAttiva).packery();
}

CContextmenu.prototype.GestioneCartelle= function(){
	var dati =singleton.getInstance(CDati,"CDati");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var eventi = singleton.getInstance(CEventi,"CEventi");
	
	$.contextMenu({
        selector: "#CreaCartella", 
        trigger: 'left',
       
        zIndex:900,
        autoHide:false,
        animation:{duration:800,show:"show",hide:"fadeOut"},
        items: {
        	nome : {name:"Nome",
                	type: 'text', 
                	value: ""}
        	,
        	gruppi: {
                name: "Gruppi", 
                type: 'checkbox', 
                selected: false
            },
            inserisici: {
            	name: "Inserisci",
            	callback : function(key){
            		
            	}
            
            }},
            events: {
           	 hide: function(opt) {
                    var $this = this;
                    $.contextMenu.getInputValues(opt, $this.data());
                    var Tipo;
                    if($this.data().gruppi){
                    	Tipo = "gruppo"
                    }
                    else{
                    	Tipo = "privata"
                    }
                    
                    var Data = {
                   		 controller:"cartella",
                   		 lavoro: "nuova",
                   		 nome_cartella: $this.data().nome,
                   		 tipo : Tipo,
                   		 colore: "#FFFFFF"
                    };
                    
                  dati.setNote(Data);
                	  
             
                 
                   
                }
           	
           
        }
        });
	
	var nomi_cartelle_gruppo = new Object();
	var nomi_cartelle_private = new Object();
	$.each(Struttura,function(i,cartella){
		if(cartella.nome != "Note" && cartella.nome != "Promemoria" &&cartella.nome != "Archivio" &&cartella.nome != "Cestino"){
			if(cartella.tipo == "gruppo"){
				nomi_cartelle_gruppo[cartella.nome] ={
						name:cartella.nome,
				}
			}
			if(cartella.tipo == "privata"){
				nomi_cartelle_private[cartella.nome] ={
				name:cartella.nome,
				}
			}
		
		}
		
	});
	
	
	
	$.contextMenu({
        selector: "#EliminaCartella", 
        trigger: 'left',
       
        zIndex:900,
        autoHide:false,
        animation:{duration:800,show:"show",hide:"fadeOut"},
        items: {
        	"private" : {name : "Private",
            	"items":nomi_cartelle_private},
            "gruppi": {name: "Gruppi", icon: "copy",
            	"items":nomi_cartelle_gruppo },          
            	"sep1": "---------",
        	},
        callback:function(key, options){
            
        var id_cartella_elimina = StrutturaCartelle.getCartellaByNome(key);
                   
        		var Data = {
                   		 controller:"cartella",
                   		 lavoro: "elimina",
                   		 id: id_cartella_elimina
                    }
        		
                  dati.setNote(Data);
                    
                }
           	
           
        
        });
        
        
        //******************************************************
	
       $.contextMenu({
        selector: "#aggiungiPartecipante", 
        trigger: 'left',
       
        zIndex:900,
        autoHide:false,
        animation:{duration:800,show:"show",hide:"fadeOut"},
        items:{
     	   email: {
                name: "Condividi Con Email:", 
                type: 'text', 
                value: "", 
              
            },
           
            button: {   name: "Condividi", 
                callback: function(){
             	 
                }   
                
            }
        	},
        	events: {
        		hide: function(opt) {
        			var $this = this;
        			$.contextMenu.getInputValues(opt, $this.data());
        			var Data = {
        					controller:"cartella",
        					lavoro: "aggiungiPartecipante",
        					email_utente: $this.data().email,
        					id_cartella: StrutturaCartelle.getCartellaAttiva()
        			}
        			dati.setNote(Data);
              
          }
     	
     } 
        
        }) 
        
   //************************************************************     
        $.contextMenu({
            selector: "#eliminaPartecipante", 
            trigger: 'left',
            zIndex:900,
            autoHide:false,
            animation:{duration:800,show:"show",hide:"fadeOut"},
            items:{
         	   email: {
                    name: "Elimina Partecipante:", 
                    type: 'text', 
                    value: "", 
                  
                },
               
                button: {   name: "Elimina", 
                    callback: function(){
                 	 
                    }   
                    
                }
            	},
            	events: {
            		hide: function(opt) {
            			var $this = this;
            			$.contextMenu.getInputValues(opt, $this.data());
            			var Data = {
            					controller:"cartella",
            					lavoro: "rimuoviPartecipante",
            					email_utente: $this.data().email,
            					id_cartella: StrutturaCartelle.getCartellaAttiva()
            			}
            			dati.setNote(Data);
                  
              }
         	
         }
        });
           
            
}
	
	
	
