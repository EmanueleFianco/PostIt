
var CWelcome= function(){
	$("#sigup").leanModal();
	var clogin=singleton.getInstance(CLogin,"CLogin");

	

}

CWelcome.prototype.Inizializza= function(){
	var clogin=singleton.getInstance(CLogin,"CLogin")
   
   $("#registrati").click(function(){
    $("#signup").fadeOut();
    $(".registrazione").fadeIn();    
   });

	 $("#accedi").click(function(event){
    $(".registrazione").fadeOut();  
		$("#signup").fadeIn();
		});

   $("#contactform").submit(function(event){
    clogin.signup(event);
    $(".registrazione").fadeOut();
   })

	$("#button_login").click(function(){
		clogin.logIn();
		$("#signup").fadeOut();			
	});

  $("#clos_reg").click(function(){
    $(".registrazione").fadeOut();
  });

	$("#clos_log").click(function(){
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