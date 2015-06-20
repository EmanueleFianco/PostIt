
var CEventi = function(){
	
}


CEventi.prototype.Inizializza = function(){
	var colorpicker = singleton.getInstance(CColorpicker,"CColorpicker");
	var contexmenu = singleton.getInstance(CContextmenu,"CContextmenu");
	var datepicker = singleton.getInstance(CDatepicker,"CDatepicker");
	var menu = singleton.getInstance(CMenu,"CMenu");
	var packery = singleton.getInstance(CPackery,"CPackery");
	var redactor = singleton.getInstance(CRedactor,"Credactor");
	var nota = singleton.getInstance(CNota,"CNota");
	
	colorpicker.Inizializza();
	contexmenu.Inizializza();
	datepicker.Inizializza();
	menu.Inizializza();
	redactor.Inizializza();
	nota.Inizializza();
	packery.Inizializza();
  }

CEventi.prototype.InizializzaNota = function(){
	var colorpicker = singleton.getInstance(CColorpicker,"CColorpicker");
	var contexmenu = singleton.getInstance(CContextmenu,"CContextmenu");
	var datepicker = singleton.getInstance(CDatepicker,"CDatepicker");
	var packery = singleton.getInstance(CPackery,"CPackery");
	var redactor = singleton.getInstance(CRedactor,"Credactor");
	var nota = singleton.getInstance(CNota,"CNota");
	
	colorpicker.Inizializza();
	contexmenu.Inizializza();
	datepicker.Inizializza();
	redactor.Inizializza();
	nota.Inizializza();
	packery.Inizializza();
	
	
}

  CEventi.prototype.WelcomePage=function(){
    
     var welcome = singleton.getInstance(CWelcome,"CWelcome");
     welcome.Inizializza();


 }
  

  

