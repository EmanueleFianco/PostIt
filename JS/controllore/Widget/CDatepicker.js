var CDatepicker = function(){
	
}

CDatepicker.prototype.Inizializza = function(id_nota){
	$.datepicker.regional['it'] = {
			monthNames: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno',
			'Luglio','Agosto','Settembre','ottobre','Novembre','Dicembre'],
			monthNamesShort: ['Gen','Feb','Mar','Apr','Mag','Giu',
			'Lug','Ago','Set','Ott','Nov','Dic'],
			dayNames: ['Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica'],
			dayNamesShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
			dayNamesMin: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
			weekHeader: 'Не',
			dateFormat: 'dd.mm.yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
	
	$.datepicker.setDefaults($.datepicker.regional['it']);
	$("#time"+id_nota).datetimepicker({
		timeText: 'Orario',
		hourText: 'Ora',
		minuteText: 'Minuti',
		currentText: 'Ora',
		closeText: 'Chiudi'
	});
	
	
}