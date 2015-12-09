
function submitForm() {
	if( document.login.user.value == "" || document.login.pass.value == "" ) {
		alert("Please provide username/password.");
		return false;
	}
	else {
		document.login.submit();
		document.login.user.value=''; 
		document.login.pass.value=''; 
	}
}

function formReset() {
	document.login.user.value=''; 
	document.login.pass.value=''; 
}

$(document).ready(function() {
	$('.infoInput').keyup(function(e) {
		if(e.which == 13) {
			submitForm(); 
		}
	});
});
