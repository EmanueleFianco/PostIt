
var CLogin = function(){    

}

CLogin.prototype.logIn=function(){

	if(this.controllaDati())
	    this.inviaDati();
	 else
	 	alert('Nessun utente con questa e-mail...per favore registrati');
	
}

CLogin.prototype.controllaDati=function(){
	//valida i dati 

	 var email =/[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
	 var pas=/^[A-Za-z0-9]{6,20}$/;
	 var mypass=$("#password_input").val();
	 var val=$("#email_input").val();
	 var okemail=email.test(val);
	 var okpas=pas.test(mypass);
	 //controllo coerenza dati
	if (okemail) 
	{ if(val=="emanuele.fianco@gmail.com")
           return true;

       /*

		          if(okpas)
		          {
		          	//tutto valido
		          	
		          } 
		          else
		          {
		          	//pass errata
		          } */
    }
    else
        {
        	//email non valida
        }

    

    

}


CLogin.prototype.inviaDati=function(email_utente){
	//invia dati
	var chome= singleton.getInstance(CHome,"CHome");
	var vista= singleton.getInstance(View,"View");
	vista.smonta("#menu_welcome");
	chome.getDati();
	

}
