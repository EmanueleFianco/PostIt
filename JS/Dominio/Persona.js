// Oggetto Persona
var Persona=function(gender,name,indirizzo) {
  this.gender = gender;
  this.name = name;
    //Oggetto indirizzo all'interno di Persona
  this.indirizzo= indirizzo;
  
  
}

Persona.prototype.getGender=function()
    {
     return this.gender;
    };