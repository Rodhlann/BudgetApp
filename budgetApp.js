var showSelect;
	
$(document).ready(function() {		// side bar highlighting
	$(".sidebar").click(function() {
		$(".sidebar").css("color", "");
		$(".sidebar").css("background-color", "");
		$(this).css("color", "white");
		$(this).css("background-color", "#828282");
	});
	
	showSelected = function(i) {
		if(i == 'home') {
			document.getElementById('home').style.display="block"; 
			document.getElementById('overview').style.display="none";
			document.getElementById('edit').style.display="none";
			document.getElementById('addFunds').style.display="none";
			document.getElementById('create').style.display="none";
		}
		if(i == 'overview') {
			document.getElementById('home').style.display="none";
			document.getElementById('overview').style.display="block";
			document.getElementById('edit').style.display="none";
			document.getElementById('addFunds').style.display="none";
			document.getElementById('create').style.display="none";
		}
		if(i == 'edit') {
			document.getElementById('home').style.display="none";
			document.getElementById('overview').style.display="none";
			document.getElementById('edit').style.display="block";
			document.getElementById('addFunds').style.display="none";
			document.getElementById('create').style.display="none";
		}
		if(i == 'addFunds') {
			document.getElementById('home').style.display="none";
			document.getElementById('overview').style.display="none";
			document.getElementById('edit').style.display="none";
			document.getElementById('addFunds').style.display="block";
			document.getElementById('create').style.display="none";
		}
		if(i == 'create') {
			document.getElementById('home').style.display="none";
			document.getElementById('overview').style.display="none";
			document.getElementById('edit').style.display="none";
			document.getElementById('addFunds').style.display="none";
			document.getElementById('create').style.display="block";
		}
		if(i =='none') {
			document.getElementById('home').style.display="none";
			document.getElementById('overview').style.display="none";
			document.getElementById('edit').style.display="none";
			document.getElementById('addFunds').style.display="none";
			document.getElementById('create').style.display="none";
		}
	}
	
	$("[name = 'delete']").click(function() { 
		var form = $('<form>').attr('method', 'POST').attr('action', 'Delete.php');
		$("table[name='deleteOption'] input[name='deleteCheckBox']:checked").each(function() {
			form.append($('<input>').attr('name', 'rowsToDelete[]')
							.attr('value', this.getAttribute('row-id')) );
		});
		var box = $("table[name='deleteOption'] input[name='deleteCheckBox']:checked").val();
		if( !box ) {
			alert("Error: No Envelopes selected for deletion.");
		}
		else if( box == "Delete") {
			if( confirm('Are you sure you want to delete?') ) {
				form.submit(); 
			}
		}
	});
	
	$("[name = 'createButton']").click(function() {
		var extra = $('#undistributed').val(); 
		var amount = $("[name='newAmount']").val();
		if( document.getElementById('newBudget').value == "" ) {
			confirm("Please input new Envelope name.");
		}
		if( Number(extra) < Number(amount) ) {
			confirm("Error: Insufficient funds to perform action.");
			$("[name='newAmount']").val("");
			amount = 0;
		}
		else
			document.createBudget.submit(); 
	});
});


$(document).ready(function() {		// side bar auto highlighting
	var div = document.getElementById("divSelect").value;
	if (div == "overview") { 
		$(".navSelect").hide();
		$(".sidebar").css("color", "").css("background-color", "");
		$("#activateOverview").css("color", "white").css("background-color", "#828282");
		$("#overview").show(); 
	}
	if (div == "edit") { 
		$(".navSelect").hide();	
		$(".sidebar").css("color", "").css("background-color", "");
		$("#activateEdit").css("color", "white").css("background-color", "#828282");
		$("#edit").show(); 
	}
	if (div == "create") { 
		$(".navSelect").hide();	
		$(".sidebar").css("color", "").css("background-color", "");
		$("#activateCreate").css("color", "white").css("background-color", "#828282");
		$("#create").show(); 
	}
	if (div == "add") { 
		$(".navSelect").hide();	
		$(".sidebar").css("color", "").css("background-color", "");
		$("#activateAddFunds").css("color", "white").css("background-color", "#828282");
		$("#addFunds").show(); 
	}
	if (div == "") {
		$(".navSelect").hide();
		$(".sidebar").css("color", "");
		$(".sidebar").css("background-color", "");
		$("#activateHome").css("color", "white");
		$("#activateHome").css("background-color", "#828282");
		$("#home").show(); 
	}
});


$(document).ready(function() {		// turns negative undistributed funds red
	$("#undistributed").ready(function() {
		if( document.getElementById('undistributed').value < 0 ) {
			document.getElementById('undistributed').style.color = '#FF0000'; 
		}
	});
});

function hideEdit() {
	document.getElementById('transferFunds').style.display="none";
	document.getElementById('individualEdit').style.display="none";
}

function showInitialPercent(i) {
	if(i == 'true') {
		document.getElementById('initialPercent').style.display='';
	}
	else {
		document.getElementById('initialPercent').style.display='none';
	}
}


function negativeCheck(i) {
	if(i < 0) {
		document.getElementById('undistributed').style.color = '#FF0000'; 
	}
}

function editSubmit() {
	document.editBudget.submit(); 
}

$(document).ready(function() {		// side bar highlighting
	$(".transferButton").click(function() {
		document.transferFunds.submit();
	});
});

// $(document.ready(function() {

// });


