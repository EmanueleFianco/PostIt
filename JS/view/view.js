
var View = function(){
	
}

View.prototype.aggiungi = function(){

$(function (){
	var $elem = $('#div1');
	$.ajax({
			type: 'POST',
			url : 'Controller/prova.php',
			datatype: 'json',
			success: function(com){
				var array = jQuery.parseJSON(com);
				$elem.append( "<div><p>"+array.username+" :" + array.titolo +"</p>"+array.testo+"</div>" ); 		
			},
			error: function(){
				alert('ERRORE');
			}
		});

});
}
		

View.prototype.disegna = function(){

	var $elem = $('body');
	$elem.append('<div></div>');
	$("div").attr("id", "div1");

	$("#div1").click(function(){
		control.Instanzia();
  	});

}


