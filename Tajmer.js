function secondPassed() {
    var minutes = Math.round((seconds - 30)/60),
        remainingSeconds = seconds % 60;

    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;
    }

    document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
		  
	if (seconds == 30) {
		alert("OSTALO VAM JE JOS 30 SEC");
    } 
	
    if (seconds == 0) {
        clearInterval(countdownTimer);
		document.mojaforma17.submit();
    } else {
		seconds--;
		document.getElementById("skriveno").value = seconds;
    }
}

var countdownTimer = setInterval('secondPassed()', 1000);