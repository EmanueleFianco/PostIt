/* Validazione della form di registrazione */

$(function() {
	
	var errori=new Array();
    $('#nome').blur(function () { 
	if (!$(this).val().match(/^[a-zA-z' ]{2,30}$/)) {
		$(this).css("border", "3px solid red");
		errori[0]=true;
	}
	else{
		$(this).css("border", "2px solid green");
		errori[0]=false;
	}
	});

  
    $('#cognome').blur(function () { 
	if (!$(this).val().match(/^[a-zA-z' ]{2,30}$/)) {
		$(this).css("border", "3px solid red");
		errori[1]=true;
	}
	else{
		$(this).css("border", "2px solid green");
		errori[1]=false;
	}
	});
    

    $('#email').blur(function () {
    	$email_controll=mysql_query("SELECT email FROM Utente WHERE email=$('#email')");
    	 if ($email_controll==1){
    	 	$this.css("border","3px solid red");
    	 	errori[2]=true;
    	 }
    	 else {
    	 	$(this).css("border", "2px solid green");
    	 	errori[2]=false;
    	 })
    })
	 
	$('#username').blur(function () { 
	if (!$(this).val().match(/^[[a-zA-z0-9]{3,16}$/)) {
		$(this).css("border", "3px solid red");
		errori[3]=true;
	}
	else{
		$(this).css("border", "2px solid green");
		errori[3]=false;
	}
	});
	
	$('#password').blur(function () { 
	if (!$(this).val().match(/^[[a-zA-z0-9#!%\^&;\*\$:\{\}=\-_`~\(\)]{6,20}$/)) {
		$(this).css("border", "3px solid red");
		errori[4]=true;
	}
	else{
		$(this).css("border", "");
		errori[4]=false;
	}
	});
	
	$('#repassword').keyup(function () { 
	if ( $(this).val()==$('#password').val() && !errori[4] ) {
		$("#repassword,#password").css("border", "2px solid green");
		errori[5]=false;
	}
	else{
		$(this).css("border", "3px solid red");
		errori[5]=true;
	}
	});
	
	$('#submit').click(function (event) {
		if ( errori.indexOf(true) >= 0  ) {
			var testoerrore="";
				if (errori[0])
					testoerrore +="- Il campo nome puo contenere da 2 a 20 caratteri testuali, spazi o '\n";
				if (errori[1])
					testoerrore += "- Il campo cognome puo contenere da 2 a 20 caratteri testuali, spazi o '\n";
				if (errori[2])
					testoerrore +="- Hai inserito una email già registrata!"
				if (errori[3])
					testoerrore +="- Il campo username contiene caratteri non validi  \n";	
				if (errori[4])
					testoerrore +="- Il campo password può contenere da 6 a 20 caratteri alfanumerici e speciali \n";
				if (errori[5])
					testoerrore +="- Le password non corrispondono \n";	
			alert("Correggi i campi evidenziati in rosso !:\n" + testoerrore);
			return false;
		}
	});
	

   
  }
)