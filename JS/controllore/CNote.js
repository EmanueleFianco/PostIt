
var CNote = function(note){
	  Struttura = new Object();
	
}

CNote.prototype.aggiungiNota = function(nota){

	Struttura[nota.id] = {
			id:nota.id,
			id_cartella:nota.id_cartella,
			titolo : nota.titolo,
			testo: nota.testo,
			posizione:nota.posizione,
			colore: nota.colore,
			tipo: nota.tipo,
			condiviso: nota.condiviso,
			ultimo_a_modificare: nota.ultimo_a_modificare,
			ora_data_avviso: nota.ora_data_avviso
						
		}

}

CNote.prototype.EliminaNota = function(id_nota){
	delete Struttura[id_nota];
	console.log(Struttura);
}



CNote.prototype.CreaNota = function(attributo,valore){

	Struttura["Nuova"] = {
			
			id_cartella:162,
			titolo : "Nuovo Titolo",
			testo: "Nuovo testo",
			posizione:0,
			colore: "#FF2222",
			tipo: "nota",
			condiviso: "FALSE",
			ultimo_a_modificare: 0,
			ora_data_avviso: 0
			
		}
	Struttura["Nuova"][attributo]=valore;
	var Data = new Object();
	var nota = new Array();
	var Elemento = new Object();
	nota.push(Struttura["Nuova"]);
	Data ={
			"controller":"nota",
			"lavoro":"nuova",
			"nota": nota	
	};
	$.when(dati.setNote(Data)).done(function(a1){
		var dati = $.parseJSON(a1);
		var id = dati.id;
		Elemento[id] = Struttura["Nuova"];
		cnote.EliminaNota("Nuova");
		Struttura[id]=Elemento[id];
		$(".NuovaNota").attr("id",id);
	});
	//console.log(Dati);

}


CNote.prototype.getStruttura = function(){

	return Struttura;
}
CNote.prototype.getNota = function(id_nota){

	return Struttura[id_nota];
}
CNote.prototype.getAttributo = function(id_nota,attributo){

	return Struttura[id_nota][attributo];
}

CNote.prototype.getDataAjaxPosizioni= function(){
	

	var Data= new Object();
	var Posizioni = new Array();
	  $.each(Struttura,function(i,nota){
				Posizioni.push({
					"posizione":nota.posizione,
					"id":nota.id
			})
	  });
	Data ={
			"controller":"nota",
			"lavoro":"aggiornaPosizioni",
			"posizioni":Posizioni	
	};
	return Data;
}


CNote.prototype.getDataAjaxAttributi= function(id_nota,attributo){
	var Data ={	
			controller : "nota",
			lavoro: "aggiorna"
		}
	Data[attributo]=this.getAttributo(id_nota,attributo);
	Data["id"]=id_nota;
		
	return Data;
}

CNote.prototype.AggiornaPosizioni = function(Posizioni){
	
	var id;
	var posizione;
	
	
	
	$.each(Posizioni,function(i,elemento){
		id = elemento.id;
		posizione = elemento.posizione;
		Struttura[id]["posizione"]=i;
	});
	var Data = this.getDataAjaxPosizioni();
	dati.setNote(Data);	
	
}


CNote.prototype.Aggiorna = function(id_nota,attributo,valore){
	if(id_nota === ""){
		this.CreaNota(attributo,valore);
	}
	else{
	// aggiornamento struttura dati
	Struttura[id_nota][attributo]=valore;
	//-------------------------------
	switch(attributo){
		case "id_cartella":
			
			break;
		case "titolo":	
			var Data = this.getDataAjaxAttributi(id_nota,"titolo");
			break;
		case "testo":
			var Data = this.getDataAjaxAttributi(id_nota,"testo");
			break;	
		case "colore":
			var Data = this.getDataAjaxAttributi(id_nota,"colore");
			break;
				
	}
	dati.setNote(Data);	
	}
}



