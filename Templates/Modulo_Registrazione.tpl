<head>
<link rel="stylesheet" type="text/css" href="templates/templates/css/registrazione.css"  />
<script src="js/registrazione_controllo.js"></script>
</head>
<div class="form">
<h2>Modulo di Registrazione</h2> 
    <form method="post" id="contactform" 
         action="index.php"> 
    	<p class="contact"><label for="nome">Nome</label></p> 
    	<input id="nome" name="nome" placeholder="" required tabindex="1" type="text"> 
				
		<p class="contact"><label for="cognome">Cognome</label></p> 
    	<input id="cognome" name="cognome" placeholder="" required tabindex="2" type="text"> 
    			 
		<p class="contact"><label for="email">Email</label></p> 
    	<input id="email" name="email" placeholder="" required tabindex="4" type="email"> 
                
        <p class="contact"><label for="username">Username</label></p> 
    	<input id="username" name="username" placeholder="" required tabindex="5" type="text"> 
    			 
        <p class="contact"><label for="password">Password</label></p> 
    	<input type="password" id="password" name="password" required tabindex="6" > 
        <p class="contact"><label for="repassword">Conferma la tua password</label></p> 
    	<input type="password" id="repassword" name="repassword" required tabindex="7" > <br>
		
		<input type="hidden" name="controller" value="registrazione" />
        <input type="hidden" name="task" value="signup" />
		<label>Tutti i campi sono obbligatori</label><br><br>
		<input class="buttom" name="submit" id="submit" tabindex="8" value="Registrati Adesso!" type="submit"  > 	 
		</form> 
</div>