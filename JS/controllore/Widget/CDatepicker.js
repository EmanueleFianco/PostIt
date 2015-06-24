var CDatepicker = function(){
	
}

CDatepicker.prototype.Inizializza = function(id_nota){
	var StrutturaCartelle = singleton.getInstance(CStruttura,"CStruttura");
	
	$.datepicker.regional['it'] = {
			monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
			'Luglio','Agosto','Settembre','ottobre','Novembre','Dicembre'],
			monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu',
			'Lug','Ago','Set','Ott','Nov','Dic'],
			dayNames: ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica'],
			dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
			dayNamesMin: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
			weekHeader: 'Не',
			dateFormat: 'yy-mm-dd',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: '',
			
		};
	$.datepicker.setDefaults($.datepicker.regional['it']);
	$("#time"+id_nota).datetimepicker({
		timeText: 'Orario',
		hourText: 'Ora',
		minuteText: 'Minuti',
		currentText: 'Ora',
		closeText: 'Chiudi',
		onClose  : function(dateText) {	
			if(id_nota == "Nuova"){
			var id_nota_nuova = $("#NuovaNotaSpace").find(".NuovaNota").attr("id");
			}
			else{
				id_nota_nuova = id_nota;
			}
			console.log(id_nota_nuova);
			dateText = dateText + ":00";
			if(dateText != ""){
				StrutturaCartelle.AggiornaNota(id_nota_nuova,"ora_data_avviso",dateText);
			}
			
		
		}
	});
	
	
}