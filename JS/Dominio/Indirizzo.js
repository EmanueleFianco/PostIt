//Oggetto Indirizzo
var Indirizzo=function(via,cap){
  this.via=via;
  this.cap=cap;
}

Indirizzo.prototype.getCap=function()
  {
  return this.cap;
  };

Indirizzo.prototype.getVia=function()
  {
  return this.via;
  };
