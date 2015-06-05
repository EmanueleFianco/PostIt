		
var View = function(){
	
	
}



View.prototype.setNota = function(nota,tmpl,pos){
	var html = Mustache.to_html(tmpl,nota);
	$('#sortable'+pos).append(html);
	$(".nota").last().fadeIn(200);
}
		

View.prototype.disegna = function(tmpl){
	
	
	var html = Mustache.to_html(tmpl);
	$("body").append(html);	
	$("#menu_window").hide();
	

	
	
}


