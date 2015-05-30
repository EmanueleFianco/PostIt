		
var View = function(){
	
	
}



View.prototype.setNota = function(nota,tmpl){
	var html = Mustache.to_html(tmpl,nota);	
	$('#sortable').append(html);

	$(".nota").last().fadeIn(200);
}
		

View.prototype.disegna = function(tmpl){
	
	
	var html = Mustache.to_html(tmpl);
	$("body").append(html);	
	$("#menu_window").hide();
	

	
	
}


