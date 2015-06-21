var CPackery = function(){
	
}

CPackery.prototype.Inizializza = function(id_nota){
	var view = singleton.getInstance(View,"View");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var cartellaAttiva = StrutturaCartelle.getCartellaAttiva();

// entra dentro l'if se il packary non è mai stato istanziato	
	
	if(StrutturaCartelle.getNumeroNoteByIdCartella(cartellaAttiva)==1){
		
		var $container = $('#'+cartellaAttiva).packery({
		  	"rowHeight": 80,
		
		    "percentPosition": true,
		    "isOriginLeft": true,
		  });
		
		$("#TestoNota"+id_nota).keydown(function(){
			$('#'+cartellaAttiva).packery();
		});
		
	
	}

var $itemElems = $('#'+cartellaAttiva).find('#'+id_nota).draggable(/*{stop: view.setPosizioni}*/);
$('#'+cartellaAttiva).packery( 'appended', $itemElems );;
$('#'+cartellaAttiva).packery( 'bindUIDraggableEvents', $itemElems );


$('#'+StrutturaCartelle.getCartellaAttiva()).packery('reloadItems');

}