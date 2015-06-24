
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

   $("#nome").focusout(function(){
      var nam=/^[A-Za-z]{2,30}$/;
      var nome_reg=$(this).val();
      var okname=nam.test(nome_reg);
      if(okname)
      { 
        $(this).next().addClass('giusto').end().addClass('giusto');        
      }
      else
      {
        $(this).next().addClass('sbagliato').end().addClass('sbagliato');
      }
   });

   $("#nome").focusin(function(){
    $(this).next().removeClass("giusto sbagliato").end().removeClass("sbagliato");
   });

   $("#cognome").focusout(function(){
      var nam=/^[A-Za-z\s]{2,30}$/;
      var cognome_reg=$(this).val();
      var okcognome=nam.test(cognome_reg);
      if(okcognome)
      { 
        $(this).next().addClass('giusto').end().addClass('giusto');        
      }
      else
      {
        $(this).next().addClass('sbagliato').end().addClass('sbagliato');
      }
   });

   $("#cognome").focusin(function(){
    $(this).next().removeClass("giusto sbagliato").end().removeClass("sbagliato");
   });

   $("#username").focusout(function(){
      var user=/^[A-Za-z0-9]{5,15}$/;
      var username_reg=$(this).val();
      var okuser=user.test(username_reg);
      if(okuser)
      { 
        $(this).next().addClass('giusto').end().addClass('giusto');        
      }
      else
      {
        $(this).next().addClass('sbagliato').end().removeClass('sbagliato');
      }
   });

   $("#username").focusin(function(){
    $(this).next().removeClass("giusto sbagliato").end().removeClass("sbagliato");
   });

   $("#password").focusout(function(){
      var pass=/^[A-Za-z0-9]{6,20}$/;
      var password_reg=$(this).val();      
      var okpass=pass.test(password_reg);
      if(okpass)
      { 
               
      }
      else
      {
        $(this).next().addClass('sbagliato').end().addClass('sbagliato');
      }
   });

   $("#password").focusin(function(){
    $(this).next().removeClass("sbagliato").end().removeClass("sbagliato");
   });

    $("#repassword").focusout(function(){      
      var password_reg=$("#password").val(); 
      var repassword_reg=$("#repassword").val();      
      if(password_reg==repassword_reg)
      { 
        $(this).next().addClass('giusto').end().addClass('giusto');        
      }
      else
      {
        $(this).next().addClass("sbagliato").end().addClass('sbagliato');
      }
   });

   $("#repassword").focusin(function(){
    $(this).next().removeClass("giusto sbagliato").end().removeClass("sbagliato");
   });





   $("#email").focusout(function(){
     $.when(clogin.controllaEmail()).done(function(controlloemail){
          var esito= new Object();
          esito=$.parseJSON(controlloemail);
          if(esito['error']!=null)
          {
            
            $("#email").next().addClass('sbagliato').end().addClass('sbagliato');

          }
          else
          {
            
            $("#email").next().addClass('giusto');

          }

          })
   });
      $("#email").focusin(function(){
      $(this).next().removeClass("giusto sbagliato").end().removeClass("sbagliato");
     })

	 $("#accedi").click(function(event){
    $(".registrazione").fadeOut();  
		$("#signup").fadeIn();
		});

   $("#contactform").submit(function(event){
    clogin.signup(event);
    
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