
var CLogin = function(){  

	

}

CLogin.prototype.logIn=function(){
	 
	var chome=singleton.getInstance(CHome,"CHome");
	var vista = singleton.getInstance(View,"View");
if(this.controllaDatiLogin())
	{   var Data=this.preparaDati('login');
	    $.when(this.inviaDati(Data)).done(function(ricevuta){  
	             
	    	    infoutente=$.parseJSON(ricevuta);	    	    
 				if(infoutente['error']==null)//esito positivo 
 				{   
 					localStorage.setItem('login',true);
 					vista.smonta("#menu_welcome");
					chome.getDati();

 				}
 				else
 				{
 					alert("Attenzione:"+(infoutente['error']));
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
	
if($(".textinputregistrazione").children().hasClass("sbagliato"))
	return false;
else
	return true;
	

	



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

CLogin.prototype.logout=function(){
	$.ajax({
		type:'POST',
		url:'Home.php',
		data:{
			  controller:'registrazione',
			  lavoro:'logout'		
			}
	})
}
