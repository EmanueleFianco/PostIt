var CPackery = function(){
	
}

CPackery.prototype.Inizializza = function(){
	var view = singleton.getInstance(View,"View");

	var $container = $('#sortable').packery({
	  	"rowHeight": 100,
	    "isOriginLeft": true,
	    "bindResize":true
	  });
//   aggiornamento Struttura Dati (un aggiornamento nella struttura dati chiama Ajax)
//   Aggiornamento POSIZIONI
var $itemElems = $("#sortable").find('.nota').draggable();

$("#sortable").packery( 'bindUIDraggableEvents', $itemElems );
$("#sortable").packery("on", 'layoutComplete', view.getPosizioni );
$("#sortable").packery("on", 'dragItemPositioned', view.setPosizioni );
	
$(".TestoNota").keydown(function(){
	$("#sortable").packery();
});
}