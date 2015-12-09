function inputCheck() {
    if(document.signUp.newPass.value != document.signUp.verify.value) {
        alert("Passwords do not match.");
		document.signUp.newPass.value = '';
		document.signUp.verify.value = '';
		document.getElementById("verifyTrue").style.display = "none";
		document.getElementById("verifyFalse").style.display = "none";
        return false;
    }
    else if(document.signUp.firstName.value == '' || document.signUp.lastName.value == '' || document.signUp.newUser.value == '' || document.signUp.newPass.value == '') {
        alert("Please provide all personal information to continue with sign up.");
		document.signUp.newPass.value = '';
		document.signUp.verify.value = '';
		document.getElementById("verifyTrue").style.display = "none";
		document.getElementById("verifyFalse").style.display = "none";
        return false;
    }
    else {
        document.signUp.submit();
		document.signUp.newPass.value = '';
		document.signUp.verify.value = ''; 
		document.getElementById("verifyTrue").style.display = "none";
		document.getElementById("verifyFalse").style.display = "none";
	}
}

function passVer() {
	if( document.signUp.newPass.value == '' && document.signUp.verify.value == '' ) {
		document.getElementById("verifyTrue").style.display = "none";
		document.getElementById("verifyFalse").style.display = "none";
	}
	else if( document.signUp.newPass.value == document.signUp.verify.value ) {
		document.getElementById("verifyTrue").style.display = "block";
		document.getElementById("verifyFalse").style.display = "none";
	}
	else {
		document.getElementById("verifyTrue").style.display = "none";
		document.getElementById("verifyFalse").style.display = "block";
		return false;
	}	      	 
}

$(document).ready(function() {
	$('.infoInput').keyup(function(e) {
		if(e.which == 13) {
			inputCheck();
		}
	});
});