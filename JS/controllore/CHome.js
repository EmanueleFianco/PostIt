	
var CHome = function(){
	singleton = new Singleton();
	Template = new Array();
	infoutente=new Object();
	var dati =singleton.getInstance(CDati,"CDati");
	var eventi = singleton.getInstance(CEventi,"CEventi");
	var view = singleton.getInstance(View,"View");

	if($.cookie('PHPSESSID')!=null)
	{   var vista=singleton.getInstance(View,"View");
        vista.smonta("#menu_welcome"); 
        $.when(dati.getTemplate("Main"),
			dati.getTemplate("Nota"),
			dati.getTemplate("NuovaNota"),
			dati.getTemplate("Cartella"))
        .done(function(N1,N2,N3,N4,N5){
		Template["Main"]=N1[0];
		Template["Nota"]=N2[0];
		Template["NuovaNota"]= N3[0];
		Template["Cartella"]=N4[0]});
		this.getDati();
	   

	}
	else
	{
	
	$.when(dati.getTemplate("Main"),
			dati.getTemplate("Nota"),
			dati.getTemplate("NuovaNota"),
			dati.getTemplate("Cartella"),
	        dati.getTemplate("Welcome"))
	.done(function(N1,N2,N3,N4,N5){
		Template["Main"]=N1[0];
		Template["Nota"]=N2[0];
		Template["NuovaNota"]= N3[0];
		Template["Cartella"]=N4[0];
		Template["Welcome"]=N5[0];
		view.disegna(Template["Welcome"]);	
		eventi.WelcomePage();		   			
		})//fine getTemplate
	 }
}

	

CHome.prototype.getDati=function(){
	
	var dati =singleton.getInstance(CDati,"CDati");
	var eventi = singleton.getInstance(CEventi,"CEventi");
	var view = singleton.getInstance(View,"View");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	StrutturaCartelle.Inizializza();		
    $.when(dati.getCartelle()).done(function(cartelle){
    var Cartelle = new Object();
	//controlla dati arrivati 

/*********************login a buon fine******************************/
			 Cartelle['Cartelle'] = $.parseJSON(cartelle);			
		
			 view.disegna(Template["Main"],Cartelle);
			$.each(Cartelle['Cartelle'],function(i,Cartella){
				StrutturaCartelle.aggiungiCartella(Cartella);
				if(Cartella.nome == "Note"){				
					StrutturaCartelle.setCartellaAttiva(Cartella.id_cartella);
				}
			
			});
			
			view.aggiungiNuova(Template["NuovaNota"]);
			
			
				$.when(dati.getNote(StrutturaCartelle.getCartellaAttiva(),'0','12')).done(function(note){
					var Note = $.parseJSON(note);
					if(Object.keys(Note).length >0){
					$.each(Note,function(i,nota){
						console.log(nota.partecipanti);
						StrutturaCartelle.aggiungiNota(StrutturaCartelle.getCartellaAttiva(),nota);
					})
					
					}
					console.log(Struttura);
					eventi.InizializzaMenu();
				})
/***********************************************************************/


})//end getDati
			
	
			
		
	


	

}


