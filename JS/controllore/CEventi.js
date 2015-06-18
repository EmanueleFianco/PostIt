
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
	packery.Inizializza();
	redactor.Inizializza();
	nota.Inizializza();
  }
  

  

