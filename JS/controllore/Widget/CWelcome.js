
var CWelcome= function(){
	$("#sigup").leanModal();
	

}

CWelcome.prototype.Inizializza= function(){
	
	var clogin=singleton.getInstance(CLogin,"CLogin");
	$("#welcome_button").click(function(){
		$("#signup").css({"display":"block"});
		});
	$("#button_login").click(function(){

		clogin.logIn();
		$("#signup").css({"display":"none"});

			
	})
}