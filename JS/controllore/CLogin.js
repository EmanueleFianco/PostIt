
var CLogin = function(){    

}

CLogin.prototype.logIn=function(){

	if(this.controllaDatiLogin())
	{   var Data=this.preparaDati('login');
	    this.inviaDati(Data);
	 }
	 else
	 	alert('Nessun utente con questa e-mail...per favore registrati');
	
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
	var chome= singleton.getInstance(CHome,"CHome");
	var vista= singleton.getInstance(View,"View");
	$.ajax({ 
	  type:'POST',
	  url:'Controller/index.php',
	  data:dati,
	  success:function(){
	  		vista.smonta("#menu_welcome");
			chome.getDati();
			}
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
