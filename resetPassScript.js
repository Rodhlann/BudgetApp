function passVer() {
	if( document.pass.resetPass.value == '' && document.pass.verify.value == '' ) {
		document.getElementById("verifyTrue").style.display = "none";
		document.getElementById("verifyFalse").style.display = "none";
	}
	else if( document.pass.resetPass.value == document.pass.verify.value ) {
		document.getElementById("verifyTrue").style.display = "block";
		document.getElementById("verifyFalse").style.display = "none";
	}
	else {
		document.getElementById("verifyTrue").style.display = "none";
		document.getElementById("verifyFalse").style.display = "block";
		return false;
	}	      	 
}

function passReset() { 
		document.getElementById("verifyTrue").style.display = "none";
		document.getElementById("verifyFalse").style.display = "none";
}

function inputCheck() {
	if( document.pass.user.value == '' || document.pass.resetPass.value == '' || document.pass.verify.value == '' ) {
		alert("Please provide appropriate input.");
		document.pass.user.value = '';
		document.pass.resetPass.value = '';
		document.pass.verify.value = '';
		passReset();
		return false; 
	}
	else
		document.pass.submit(); 
		
}

$(document).ready(function() {
	$('.infoInput').keyup(function(e) {
		if(e.which == 13) {
			inputCheck(); 
		}
	});
});