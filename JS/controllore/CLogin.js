
var CLogin = function(){    

}

CLogin.prototype.logIn=function(){
	var chome=singleton.getInstance(CHome,"CHome");
	var vista = singleton.getInstance(View,"View");
if(this.controllaDatiLogin())
	{   var Data=this.preparaDati('login');
	    $.when(this.inviaDati(Data)).done(function(ricevuta){   
	    	    var esito=new Object();
 				esito=$.parseJSON(ricevuta);
 				if(esito['error']==null)//esito positivo 
 				{
 					vista.smonta("#menu_welcome");
					chome.getDati();
 				}
 				else
 				{
 					alert("Attenzione:"+(esito['error']));
 				}
	    	});
	 }
}
	


CLogin.prototype.signup=function(event){
  if(!this.controlladatiSignup())
  {
  	event.preventDefault();

  }
  



}

CLogin.prototype.controlladatiSignup=function(){
	var email =/[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
	var pas=/^[A-Za-z0-9]{6,20}$/;
	var nam=/^[A-Za-z]{2,30}$/;
	var us=/^[A-Za-z0-9]{5,15}$/;
	var email_reg=$("#email").val();
	var nome_reg=$("#nome").val();
	var cognome_reg=$("#cognome").val();
	var username_reg=$("#username").val();
	var password_reg=$("#password").val();
	var repassword_reg=$("#repassword").val();
	var check;
	var okemail=email.test(email_reg);
	var okpas=(pas.test(password_reg) && pas.test(repassword_reg) && password_reg==repassword_reg);
	var okname=nam.test(nome_reg);
	var okcognome=nam.test(cognome_reg);
	var okusername=us.test(username_reg);
	//test immagine
	check=false;
	if(okemail)
	{ if (okpas)
			{if(okname)
				{if (okcognome)
					{if (okusername)
						{var file=$("#foto")[0].files[0];
							if(file!=null)
							      {var filesize=file.size;
							       if(filesize<=2097152)
							       	  check=true;							       							       	 
							       }
							       else{
							          check=true;//non inserito immagine ma gli altri campi sono ok!!
							       }

						}
						else
						{
							//username non valida

						}

					}
					else
					{
						//cognome non valido
					}

				}
				else
				{
					//nome non valido
				}

		    }
		    else
		    {
		    	//password errata
		    }		
				
	}
	else
	{
		//email non valida
	}
	return check;
	

	



}

CLogin.prototype.controllaDatiLogin=function(){
	//valida i dati 

	 var email =/[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
	 var pas=/^[A-Za-z0-9]{6,20}$/;
	 var mypass=$("#password_input").val();
	 var val=$("#email_input").val();
	 var okemail=email.test(val);
	 var okpas=pas.test(mypass);
	 //controllo coerenza dati
	if (okemail) 
	{ if(okemail)
             if(okpas)
		          {
		          	return true;
		          	
		          } 
		          else
		          {
		          	//pass errata
		          	return false;
		          } 
    }
    else
        {
        	//email non valida
        	return false;
        }  

}


CLogin.prototype.inviaDati=function(dati){
	//invia dati
	
	return $.ajax({ 
	  type:'POST',
	  url:'Home.php',
	  data:dati
	  
	})

}


CLogin.prototype.preparaDati=function(task){
	var dati;
    switch (task){
	    case 'login':
			      dati={
					controller:'registrazione',
					lavoro:task,
					email:$("#email_input").val(),
					password:$("#password_input").val(),
			     };
			     break;


	};//end switch
	return dati;
}

CLogin.prototype.controllaEmail=function(){
	return $.ajax({
		type:'POST',
		url:'Home.php',
		data:{
            controller:'registrazione',
			lavoro:'controlla',
			email:$("#email").val(),
		}
	})

}
