
var View = function(){
	
}

View.prototype.aggiungi = function(){

	$(function (){
	var $elem = $('#nota_space');
	$.ajax({
			type: 'POST',
			url : 'Controller/prova.php',
			datatype: 'json',
			success: function(com){
				var array = jQuery.parseJSON(com);
				$elem.append( "<div class=nota><p>"+array.username+" :" + array.ora +"</p>"+array.testo+"</div>" ); 		
			},
			error: function(){
				alert('ERRORE');
			}
		});

});

}
		

View.prototype.disegna = function(){



	var $elem = $("body");

	$elem.append('<div id=banner class=Banner></div>');
	$elem.append('<div id=main class=main></div>');

	$("#banner").append('<div id=menu_button>Menu</div>');
	$("#main").append('<div id=menu_window></div>');
	$("#main").append('<div id=nota_space></div>');


	$("#nota_space").click(function(){
		control.Instanzia();
  	});

}


