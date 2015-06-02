
var CEventi = function(){
	
}

CEventi.prototype.setEventiGlobali = function(){
	
	
	$("#menu_button").click(function(event){
		$("#menubottom").fadeToggle( "slow", "linear" );
	});

	 $(".cointainerbottom").mouseover(function()
   {
        $(this).addClass("focusable");
            

   });

     $(".cointainerbottom").mouseout(function()
   {
        $(this).removeClass("focusable");
            

   });

	
}