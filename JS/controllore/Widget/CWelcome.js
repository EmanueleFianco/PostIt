
var CWelcome= function(){
	$("#sigup").leanModal();
	var clogin=singleton.getInstance(CLogin,"CLogin");

	

}

CWelcome.prototype.Inizializza= function(){
	var clogin=singleton.getInstance(CLogin,"CLogin")
	
	    $("#welcome_button").click(function(event){
		$("#signup").fadeIn();
		});
	$("#button_login").click(function(){
		clogin.logIn();
		$("#signup").fadeOut();			
	});

	$(".modal_close").click(function(){
		$("#signup").fadeOut();
	});
	$('#slider').slidesjs({
        width: 940,
        height: 528,
        play: {
          active: true,
          auto: true,
          interval: 5000,
          swap: true
        },
      effect: {
      slide: {
        
        speed:4000
          
      },
      fade: {
        speed: 2000,          
        crossfade: true
         
      }
     }
      });
	
}