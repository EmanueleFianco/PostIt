var CStruttura = function(note){
	  
}
CStruttura.prototype.Inizializza = function(cartella){
	Struttura = new Object();
	cartellaAttiva= new Object();
}

CStruttura.prototype.aggiungiCartella = function(cartella){

	Struttura[cartella.id] = {
			id:cartella.id,
			email_utente:cartella.email_utente,
			tipo:cartella.tipo,
			nome:cartella.nome,
			posizione:cartella.posizione,
			colore:cartella.colore,
			note: new Object()
		}

}

CStruttura.prototype.aggiungiNota = function(id_cartella,nota){
	
	var view = singleton.getInstance(View,"View");

	Struttura[id_cartella]["note"][nota.id] = nota;
	view.setNota(nota,Template["Nota"]);
	
}

CStruttura.prototype.setCartellaAttiva = function(id_cartella){
	cartellaAttiva=id_cartella;
	$("#nota_space").attr("id_cartella",id_cartella);
}

CStruttura.prototype.getCartellaAttiva = function(){
	return cartellaAttiva;
}
CStruttura.prototype.getNota = function(id_nota){
	var cartella_attiva=this.getCartellaAttiva();
	return Struttura[cartella_attiva]["note"][id_nota];
}

CStruttura.prototype.EliminaNota = function(id_nota){
	var cartella_attiva=this.getCartellaAttiva();
	delete Struttura[cartella_attiva]["note"][id_nota];
}

CStruttura.prototype.CreaNota = function(attributo,valore){
	var dati =singleton.getInstance(CDati,"CDati");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	
	var cartella_attiva=this.getCartellaAttiva();
	
	Struttura[cartella_attiva]["note"]["Nuova"] = {
			
			id_cartella:$("#nota_space").attr("id_cartella"),
			titolo : "Nuovo Titolo",
			testo: "Nuovo testo",
			posizione:0,
			colore: "#FF2222",
			tipo: "nota",
			condiviso: "FALSE",
			ultimo_a_modificare: 0,
			ora_data_avviso: 0
			
		}
	Struttura[cartella_attiva]["note"]["Nuova"][attributo]=valore;
	var Data = new Object();
	var nota = new Array();
	var Elemento = new Object();
	nota.push(Struttura[cartella_attiva]["note"]["Nuova"]);
	Data ={
			"controller":"nota",
			"lavoro":"nuova",
			"nota": nota	
	};
	$.when(dati.setNote(Data)).done(function(a1){
		var dati = $.parseJSON(a1);
		var id = dati.id;
		Elemento[id] = Struttura[cartella_attiva]["note"]["Nuova"];
		StrutturaCartelle.EliminaNota("Nuova");
		Struttura[cartella_attiva]["note"][id]=Elemento[id];
		$(".NuovaNota").attr("id",id);
	});
	

}

CStruttura.prototype.getAttributo = function(id_nota,attributo){
	var cartella_attiva=this.getCartellaAttiva();
	return Struttura[cartella_attiva]["note"][id_nota][attributo];
}

CStruttura.prototype.getDataAjaxAttributi= function(id_nota,attributo){
	var Data ={	
			controller : "nota",
			lavoro: "aggiorna"
		}
	Data[attributo]=this.getAttributo(id_nota,attributo);
	Data["id"]=id_nota;
		
	return Data;
}
CStruttura.prototype.getDataAjaxPosizioni= function(){
	var cartella_attiva=this.getCartellaAttiva();

	var Data= new Object();
	var Posizioni = new Array();
	  $.each(Struttura[cartella_attiva]["note"],function(i,nota){
				Posizioni.push({
					"posizione":nota.posizione,
					"id":nota.id
			})
	  });
	Data ={
			"controller":"nota",
			"lavoro":"aggiornaPosizioni",
			"id_cartella":$("#nota_space").attr("id_cartella"),
			"posizioni":Posizioni	
	};
	return Data;
}


CStruttura.prototype.AggiornaPosizioniNote = function(Posizioni){
	var cartella_attiva=this.getCartellaAttiva();
	var dati =singleton.getInstance(CDati,"CDati");
	var id;
	var posizione;
	
	$.each(Posizioni,function(i,elemento){
		id = elemento.id;
		posizione = elemento.posizione;
		Struttura[cartella_attiva]["note"][id]["posizione"]=i;
	});
	var Data = this.getDataAjaxPosizioni();
	dati.setNote(Data);	
	
}

CStruttura.prototype.AggiornaNota = function(id_nota,attributo,valore){
	var dati =singleton.getInstance(CDati,"CDati");
	
	var cartella_attiva=this.getCartellaAttiva();
	
	if(id_nota === ""){
		this.CreaNota(attributo,valore);
	}
	else{
	// aggiornamento struttura dati
	Struttura[cartella_attiva]["note"][id_nota][attributo]=valore;
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



















