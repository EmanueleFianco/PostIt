var CContextmenu = function(){
	
}

CContextmenu.prototype.Inizializza = function(id_nota){
	var dati =singleton.getInstance(CDati,"CDati");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	$.contextMenu({
        selector: '#editnota'+id_nota, 
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
            	 callback:function(key, options){
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
                    }},
        }
    });
	
	
	
	
}