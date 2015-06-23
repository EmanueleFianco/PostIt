var CContextmenu = function(){
	
}

CContextmenu.prototype.Inizializza = function(id_nota){
	
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
            	 callback:function(){
            		 if($("#bloccata"+id_nota).css("display") != "block"){
                            var Dati={   
                                      id: id_nota,
                                      controller:"nota",
                                      lavoro:"cancella"
                                  };
                            
                            dati.setNote(Dati);
                            console.log(Dati);
                            $(this).parent(".nota").hide();
                            
            		 }
                    }},
        }
    });
	
	
	
	
}