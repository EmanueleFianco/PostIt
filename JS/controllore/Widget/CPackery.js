var CPackery = function(){
	
}

CPackery.prototype.Inizializza = function(){
	var view = singleton.getInstance(View,"View");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var cartellaAttiva = StrutturaCartelle.getCartellaAttiva();
	
	var $container = $('#'+cartellaAttiva).packery({
	  	"rowHeight": 100,
	    "isOriginLeft": true,
	    "bindResize":true
	  });
//   aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
//   Aggiornamento POSIZIONI
var $itemElems = $('#'+cartellaAttiva).find('.nota').draggable();

$('#'+cartellaAttiva).packery( 'bindUIDraggableEvents', $itemElems );
$('#'+cartellaAttiva).packery("on", 'layoutComplete', view.getPosizioni );
$('#'+cartellaAttiva).packery("on", 'dragItemPositioned', view.setPosizioni );
	
$(".TestoNota").keydown(function(){
	$('#'+cartellaAttiva).packery();
});
}