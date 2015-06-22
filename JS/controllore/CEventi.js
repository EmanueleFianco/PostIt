
var CEventi = function(){
	
}

CEventi.prototype.InizializzaMenu = function(id_nota){
	var menu = singleton.getInstance(CMenu,"CMenu");
	var packery = singleton.getInstance(CPackery,"CPackery");
	menu.Inizializza();
	packery.Ricarica();
}
CEventi.prototype.InizializzaNota = function(id_nota){
	
	var redactor = singleton.getInstance(CRedactor,"Credactor");
	var packery = singleton.getInstance(CPackery,"CPackery");
	var colorpicker = singleton.getInstance(CColorpicker,"CColorpicker");
	var contexmenu = singleton.getInstance(CContextmenu,"CContextmenu");
	var datepicker = singleton.getInstance(CDatepicker,"CDatepicker");
	var nota = singleton.getInstance(CNota,"CNota");
	
	if(id_nota=="Nuova"){
		redactor.InizializzaNuova()
		colorpicker.Inizializza(id_nota);
		contexmenu.Inizializza(id_nota);
		datepicker.Inizializza(id_nota);
		nota.Inizializza();
	}
	else{
	packery.Inizializza(id_nota);
	redactor.Inizializza(id_nota);
	colorpicker.Inizializza(id_nota);
	contexmenu.Inizializza(id_nota);
	datepicker.Inizializza(id_nota);
	console.log("qui");
	}
	
	
	
}


CEventi.prototype.WelcomePage=function(){ 
     var welcome = singleton.getInstance(CWelcome,"CWelcome");
     welcome.Inizializza();

 }
  

  

