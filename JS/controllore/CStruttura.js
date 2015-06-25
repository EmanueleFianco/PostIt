var CStruttura = function(note){
	  
}
CStruttura.prototype.Inizializza = function(cartella){
	Struttura = new Object();
	cartellaAttiva= new Object();
	cartellaAttiva= 0;
	Buffer=0;
}

CStruttura.prototype.aggiungiCartella = function(cartella){

	Struttura[cartella.id_cartella] = {
			id:cartella.id_cartella,
			email_utente:cartella.email_utente,
			tipo:cartella.tipo,
			nome:cartella.nome,
			posizione:cartella.posizione,
			colore:cartella.colore,
			partecipanti:cartella.partecipanti,
			note: new Object()
		}
	//view.setCartella(cartella);

}
CStruttura.prototype.SpostaNota = function(id_nota,id_cartella_destinazione){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var dati =singleton.getInstance(CDati,"CDati");
	
	var cartellaAttiva = StrutturaCartelle.getCartellaAttiva();
	var nota = Struttura[cartellaAttiva]["note"][id_nota];
	StrutturaCartelle.EliminaNota[id_nota];
	
	
	var Data = {
			controller : "cartella",
			lavoro: "spostaNote",
			id_nota : id_nota,
			destinazione : id_cartella_destinazione,
			partenza : cartellaAttiva
	}
	dati.setNote(Data);
	
}

CStruttura.prototype.aggiungiNota = function(id_cartella,nota){
	
	var view = singleton.getInstance(View,"View");

	Struttura[id_cartella]["note"][nota.id_nota] = nota;
	view.setNota(id_cartella,nota,Template["Nota"]);
	
}

CStruttura.prototype.setCartellaAttiva = function(id_cartella){
	$("#"+this.getCartellaAttiva()).css("display","none");
	cartellaAttiva=id_cartella;
	$("#"+id_cartella).css("display","block");
	
}

CStruttura.prototype.getCartellaAttiva = function(){
	return cartellaAttiva;
}
CStruttura.prototype.getCartellaByNome = function(nome){
	var id_cartella_nome;
	$.each(Struttura,function(i,Cartella){
		if(Cartella.nome === nome){
		id_cartella_nome = Cartella.id;	
		}
	})
	return id_cartella_nome;
}

CStruttura.prototype.EliminaNoteByIdCartella = function(id_cartella){
	delete Struttura[id_cartella].note;
	Struttura[id_cartella]['note']= new Object;
	
	
	
}

CStruttura.prototype.getNumeroNoteByIdCartella = function(id_cartella){
	return Object.keys(Struttura[id_cartella]["note"]).length
	
}

CStruttura.prototype.getNota = function(id_nota){
	var cartella_attiva=this.getCartellaAttiva();
	return Struttura[cartella_attiva]["note"][id_nota];
}



CStruttura.prototype.EliminaNota = function(id_nota){
	var cartella_attiva=this.getCartellaAttiva();
	delete Struttura[cartella_attiva]["note"][id_nota];

}

CStruttura.prototype.CreaNota = function(attributo,valore,ricevuto){
	var dati =singleton.getInstance(CDati,"CDati");
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	var datepicker = singleton.getInstance(CDatepicker,"CDatepicker");
	
	if(this.getBuffer()==1){

	var cartella_attiva=this.getCartellaAttiva();
	
	Struttura[cartella_attiva]["note"]["Nuova"] = {
			
			id_cartella:cartella_attiva,
			titolo : "Nuovo Titolo",
			testo: "Nuovo testo",
			posizione:0,
			colore: "#FF2222",
			tipo: "nota",
			ora_data_avviso: ""
			
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
		StrutturaCartelle.setBuffer(0);
	});
	
	}
}

CStruttura.prototype.getAttributo = function(id_nota,attributo){
	var cartella_attiva=this.getCartellaAttiva();
	return Struttura[cartella_attiva]["note"][id_nota][attributo];
}

CStruttura.prototype.getDataAjaxAttributi= function(id_nota,attributo){
	if(attributo=="ora_data_avviso" && $("#time"+id_nota).attr("id") != "timeNuova" ){
		var Data ={	
				controller : "nota",
				lavoro: "setPromemoria"
			}
		}
	else{
		var Data ={	
				controller : "nota",
				lavoro: "aggiorna"
			}
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
					"id_nota":nota.id_nota
			})
	  });
	Data ={
			"controller":"cartella",
			"lavoro":"aggiornaPosizioni",
			"id_cartella":this.getCartellaAttiva(),
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
CStruttura.prototype.getBuffer = function(){
	return Buffer;
}
CStruttura.prototype.setBuffer = function(valore){
	 if(valore==0){
		 Buffer=0;
	 }
	 if(valore==1){
		 Buffer=1;
	 }
}


CStruttura.prototype.AggiornaNota = function(id_nota,attributo,valore){
	var dati =singleton.getInstance(CDati,"CDati");
	
	if($("#bloccata"+id_nota).css("display") != "block"){
	var cartella_attiva=this.getCartellaAttiva();
	
	if(id_nota === "Nuova" && this.getBuffer() == 0){
		this.setBuffer(1);
		this.CreaNota(attributo,valore);
	}
	if(id_nota != "Nuova"){
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
		case "ora_data_avviso":
			var Data = this.getDataAjaxAttributi(id_nota,"ora_data_avviso");
	}
		this.setBuffer(0);
		dati.setNote(Data);	
		
	}
}
}




















