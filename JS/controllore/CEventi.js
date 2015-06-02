
var CEventi = function(){
	
}

CEventi.prototype.setEventiGlobali = function(){
	
	
	$("#menu_button").click(function(event){
		$("#menubottom").fadeToggle( "slow", "linear" );
	});

	 $(".cointainerbottom").mouseover(function()
   {
        $(this).animate({marginTop:'-=25'},0,'linear');
            

   });

     $(".cointainerbottom").mouseout(function()
   {
        $(this).animate({marginTop:'+=25'},0,'linear');
            

   });

   $(".cointainerbottom").click(function(){ 
             
      $(this).animate({marginTop:'-=100'},100,'linear',function(){
        	$(this).animate({marginTop:'+=100'},100,'linear',function(){
        		$(this).animate({marginTop:'-=50'},50,'linear',function(){
        			$(this).animate({marginTop:'+=50'},50,'linear',function(){
        				$(this).animate({marginTop:'-=20'},25,'linear',function(){
        					$(this).animate({marginTop:'+=20'},25,'linear')
        				})
        			})
        		  })
        	    })
        	 });
        

    
    });


	
}