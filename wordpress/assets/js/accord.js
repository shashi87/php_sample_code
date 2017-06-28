$(document).ready(function() {
	//ACCORDION BUTTON ACTION (ON CLICK DO THE FOLLOWING)
	$('.accord-btn').click(function() {

		//REMOVE THE ON CLASS FROM ALL BUTTONS
		$('.accord-btn').removeClass('active');
		  
		//NO MATTER WHAT WE CLOSE ALL OPEN SLIDES
	 	$('.accord-cont').slideUp('normal');
   
		//IF THE NEXT SLIDE WASN'T OPEN THEN OPEN IT
		if($(this).next().is(':hidden') == true) {
			
			//ADD THE ON CLASS TO THE BUTTON
			$(this).addClass('active');
			  
			//OPEN THE SLIDE
			$(this).next().slideDown('normal');
		 } 
		  
	 });
	  
	
	/*** REMOVE IF MOUSEOVER IS NOT REQUIRED ***/
	
	//ADDS THE .OVER CLASS FROM THE STYLESHEET ON MOUSEOVER 
	$('.accord-btn').mouseover(function() {
		$(this).addClass('over');
		
	//ON MOUSEOUT REMOVE THE OVER CLASS
	}).mouseout(function() {
		$(this).removeClass('over');										
	});
	
	/*** END REMOVE IF MOUSEOVER IS NOT REQUIRED ***/

});