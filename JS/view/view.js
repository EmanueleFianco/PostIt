
var View = function(){
	
}



View.prototype.aggiungiNota = function(tmpl){

	$(function (){
	var $elem = $('#nota_space');
	$.ajax({
			type: 'POST',
			url : 'Controller/prova.php',
			datatype: 'json',
			success: function(com){
				var array = jQuery.parseJSON(com);
				var html = Mustache.to_html(tmpl,array);
				$elem.append(html); 		
			},
			error: function(){
				alert('ERRORE');
			}
		});

});

}
		

View.prototype.disegna = function(){
	
	$.ajax({
		type: 'GET',
		url : 'JS/view/Template/Main.tmpl',
		success: function(tmpl){
			var html = Mustache.to_html(tmpl);
			$("body").append(html);
			
			
		// ----------------------------		
		},
		error: function(){
			alert('ERRORE');
		}
	});

	// risposta ajax asincrona per cui codice non bloccante... la 
	// risposta arriva dopo di eseguire il codice seguente per cui 
	// esso delega al body il click
	
	$('#body').delegate("#nota_space", "click", function(){
			
					control.InstanziaNota("JS/view/Template/Nota.tmpl");
			});
	
	
}


