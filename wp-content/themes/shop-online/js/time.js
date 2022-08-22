jQuery( document ).ready(function($) {
								  
	var dateString = megashopScriptParams.dateString;
									  
	// Set the date we're counting down to
	var countDownDate = new Date(dateString).getTime();
	
	// Update the count down every 1 second
	var x = setInterval(function() {
	
	  // Get today's date and time
	  var now = new Date().getTime();
		
	  // Find the distance between now and the count down date
	  var distance = countDownDate - now;
		
	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
	  // Output the result in an element with id="demo"
	  if(document.getElementById("countdown-timer-date") != null ) {
		  var dateStr = "";
		  
		  if (megashopScriptParams.show_days  == '1' ){
		  	dateStr = dateStr +  days + " Days " ;
		  }
		  
		  if (megashopScriptParams.show_hours == '1' ){		  
		  	dateStr = dateStr + hours + " Hours ";
		  }
		  
		  dateStr = dateStr + minutes + " Minutes " + seconds + " Seconds ";
		  
		  document.getElementById("countdown-timer-date").innerHTML = dateStr;
	  
	  }
		
	  // If the count down is over, write some text 
	  if (distance < 0 && document.getElementById("countdown-timer-date")!= null ) {
		clearInterval(x);
		document.getElementById("countdown-timer-date").innerHTML = "00-00-00";
	  }
	}, 1000);


});
