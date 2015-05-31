	
var CHome = function(){
	var Template = new Array();
	dati= new CDati();
	eventi = new CEventi();
	view = new View();
	
	$.when(dati.getTemplate("Main"),dati.getTemplate("Nota"))
	.done(function(a1,a2){
		Template["Main"]=a1[0];
		Template["Nota"]=a2[0];
				
				view.disegna(Template["Main"]);
				
				eventi.setEventiGlobali();
					$.when(dati.getNote()).done(function(note){
						var array = $.parseJSON(note);
						$.each(array,function(i,nota){
	
								view.setNota(nota,Template["Nota"]);
						
							
						})
						
							$(function() {
							    $( "#sortable" ).sortable();
							    
							  });
						
						
						
						
					})	
			})
			
			

}

CHome.prototype.InstanziaNota = function(tmpl){

if(Number(this.numeroDiv)<9){
		this.getTmpl(tmpl,this.view.aggiungiNota);
		this.numeroDiv++;
	}

}

CHome.prototype.getTmpl = function(tmpl,Funzione){

	$.ajax({
		type: 'GET',
		url : tmpl,
		success: function(com){
			Funzione(com);
		},
// ----------------------------		
		
		error: function(){
			alert('ERRORE');
		}
	});
	
}
