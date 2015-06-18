var CContextmenu = function(){
	
}

CContextmenu.prototype.Inizializza = function(){
	
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
	
	
	
}