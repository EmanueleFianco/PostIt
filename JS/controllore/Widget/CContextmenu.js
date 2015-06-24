var CContextmenu = function(){
	
}

CContextmenu.prototype.Inizializza = function(id_nota){
	var dati =singleton.getInstance(CDati,"CDati");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var contexmenu = singleton.getInstance(CContextmenu,"CContextmenu");
	
	var nomi_cartelle = new Object();
	$.each(Struttura,function(i,cartella){
		if(cartella.nome != "Note" && cartella.nome != "Promemoria" &&cartella.nome != "Archivio" &&cartella.nome != "Cestino"){
		nomi_cartelle[i] ={
			name:cartella.nome,
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
            "promemoria": {name: "Promemoria", icon: "cut"},
            "archivio" : {name: "Archivio", icon: "paste"},
            "gruppi": {name: "Gruppi", icon: "copy",
            	"items":nomi_cartelle },          
            	"sep1": "---------",
            "cancella": {name: "Cancella", icon: "delete"},
        	},
            	 callback:function(key, options){
            		 console.log(key);
            		 if(key == "cancella"){
            			 if($("#bloccata"+id_nota).css("display") != "block"){
                            var Dati={   
                                      id_nota: id_nota,
                                      id_cartella: StrutturaCartelle.getCartellaAttiva(),
                                      controller:"nota",
                                      lavoro:"cancella"
                                  };
                            
                            dati.setNote(Dati);
                            $("#"+id_nota).remove();
                            StrutturaCartelle.EliminaNota(id_nota);
                            var nota = StrutturaCartelle.getNota(id_nota)
                            $('#'+cartellaAttiva).packery('remove',nota);
                            $('#'+cartellaAttiva).packery('reloadItems');
                            $('#'+cartellaAttiva).packery();
            		 	}     
            		 }
            		 if(key == "note"){
            			
            			 if(Struttura[cartellaAttiva].nome != "Note"){
            				var id_cartella_destinazione = StrutturaCartelle.getCartellaByNome("Note");
            				 StrutturaCartelle.SpostaNota(id_nota,id_cartella_destinazione);
            				 contexmenu.Aggiorna(id_nota);
            			 }
            		 }
            		 if(key == "promemoria"){
            			 
            			 if(Struttura[cartellaAttiva].nome != "Promemoria"){
            				var id_cartella_destinazione = StrutturaCartelle.getCartellaByNome("Promemoria");
            				 StrutturaCartelle.SpostaNota(id_nota,id_cartella_destinazione); 
            				 contexmenu.Aggiorna(id_nota);
            			 }
            		 }
            		 if(key == "archivio"){
            			
            			 if(Struttura[cartellaAttiva].nome != "Archivio"){
            				var id_cartella_destinazione = StrutturaCartelle.getCartellaByNome("Archivio");
            				 StrutturaCartelle.SpostaNota(id_nota,id_cartella_destinazione); 
            				 contexmenu.Aggiorna(id_nota);
            			 }
            		 }
           
            	 }	   
    });
}
        $.contextMenu({
        selector: "#accountbotton", 
        trigger: 'left',
        events:{hide:function(){         
                $("#image_botton").removeClass("ruota90").end().addClass("ruota270");
                console.log("prova");
            }},
        zIndex:900,
        autoHide:true,
        animation:{duration:800,show:"show",hide:"fadeOut"},
        items: {
            "note": {name: "Note", icon: "edit"},
            "promemoria": {name: "Promemoria", icon: "cut"},
            "cartelle": {name: "Cartelle", icon: "copy",
            "items": {
                    // ajax per richiedere tutti i gruppi dell utente
                    "item1": {"name": "Nome_Gruppo"},
                    "item2": {"name": "Nome_Gruppo"},
                    "item3": {"name": "Nome_Gruppo"}
            
                }},          
             
        }
    });

        
CContextmenu.prototype.Aggiorna= function(id_nota){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	
	$("#"+id_nota).remove();
	 var nota = StrutturaCartelle.getNota(id_nota)
    $('#'+cartellaAttiva).packery('remove',nota);
    $('#'+cartellaAttiva).packery('reloadItems');
    $('#'+cartellaAttiva).packery();
}
	
	
	
