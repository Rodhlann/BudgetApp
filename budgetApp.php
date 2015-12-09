<?php session_start(); 
	
	$user 		= $_SESSION['user'];
	$pass 		= $_SESSION['pass'];
	$previous 	= $_SESSION['previous'];
	$current 	= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$home 		= $current; 
	$error 		= $_SESSION['error'];
	$divSelect 	= $_SESSION['divSelect'];
	
	$_SESSION['next'] = $current;
	$_SESSION['home'] = $home; 
	$_SESSION['user'] = $user;
	$_SESSION['pass'] = $pass; 
	
	if(strlen( $user ) == 0 || strlen( $pass ) == 0)
	{
		header( "location: http://" . $previous ); 
		die(); 
	}
	else
	{
		$host 		= 'localhost';
		$username 	= '';
		$passwd 	= ''; 
		$database 	= '';
		$connect 	= mysql_connect($host, $username, $passwd); 
		$table 		= 'projSecure';
		mysql_select_db( $database ); 
		
		$query 		= mysql_query( "select * from $table where USER = '$user'" ); 
		$row 		= mysql_fetch_row( $query ); 
		errorMessage( $error ); 
		calculateExtra( $user );
	}
	
	function divSelect( $divSelect ) {
		echo $divSelect;
		$_SESSION['divSelect'] = ''; 
	}
	
	function createTable( $user ) {
		$query = mysql_query( "select b_type, b_percent, b_amount from UserData where user = '$user'" );
		if( mysql_num_rows( $query ) != 0 ) {
			echo '<table class="budgetTable" border=1>';
			echo '<th> Envelope Name <th> Envelope Percentage <th> Envelope Amount';
			while( $row = mysql_fetch_row( $query ) )
			{
				echo '<tr>';
				foreach ( $row as $field )
					echo "<td> $field </td> ";
				echo '</tr>';
			}
			echo '</table>';
		}
		else {
			echo '<table class="budgetTable" border=1>';
			echo '<th> Envelope Name <th> Envelope Percentage <th> Envelope Amount';
			for( $i = 1; $i > 0; $i-- ){
				echo '<tr>';
					echo "<td> <br> </td> ";
					echo "<td> <br> </td> ";
					echo "<td> <br> </td> ";
				echo '</tr>';
			}
			echo '</table>';
		}
	}
	
	function createEditDelete( $user ) {
		$query = mysql_query( "select b_type, b_percent, b_amount, id from UserData where user = '$user'" );
		if( mysql_num_rows( $query ) != 0 ) {
			echo '<table class="budgetTable" name="deleteOption" border=1>';
			echo '<th> Envelope Name <th> Envelope Percentage <th> Envelope Amount <th> Delete';
			while( $row = mysql_fetch_assoc( $query ) )
			{
				echo "<tr>";
				foreach ( $row as $key => $field ) {
					if( $key == "id" )
						continue;
					echo "<td> $field </td> ";
				}
				echo "<td><input type=checkbox class='delete' name='deleteCheckBox' row-id='${row['id']}' value='Delete'></td>";
				echo '</tr>';
			}
			echo '</table>';
		}
		else {
			echo '<table class="budgetTable" border=1>';
			echo '<th> Envelope Name <th> Envelope Percentage <th> Envelope Amount';
			for( $i = 1; $i > 0; $i-- ){
				echo '<tr>';
					echo "<td> <br> </td> ";
					echo "<td> <br> </td> ";
					echo "<td> <br> </td> ";
				echo '</tr>';
			}
			echo '</table>';
		}
	}
	
	function manageFunds( $user ) {
		$query = mysql_query( "select b_type, b_percent, b_amount, id from UserData where user = '$user'" );
		echo "<select name='manage'>";
		echo "<option selected disabled>Select</option>";
		echo "<option value=\"undistributed\">Undistributed</option>";
		while( $row = mysql_fetch_assoc( $query ) ) {
				$type = $row['b_type'];
				echo "<option value='$type'>$type</option>"; 
		}
		echo "</select>"; 
	}
	
	function createEditTable() {
			echo '<table class="budgetTable" border=1>';
			echo '<th> Envelope Name <th> Envelope Percentage'; // Change Amount';
					// <select class=\'editList\' name=\'amtEdit\'>
						// <option value=\'changeAmt\'>Change Amount</option>
						// <option value=\'addAmt\'>Add Amount</option>
						// <option value=\'subAmt\'>Subtract Amount</option>
					// </select>
			echo '<th> Submit';
			echo '<tr>';
			echo "<td> <input id='editBox' type=text name='editType' value='' placeholder='Car, Computer' maxLength = \"23\"> </td> ";
			echo "<td> <input id='editBox' type=text name='editPercent' value='' placeholder='1.0, .10'> </td> ";
			//echo "<td> <input id='editBox' type=text name='editAmount' value='' placeholder='10.00, 100.00'> </td> ";
			echo "<td> <input class='editButton' type=Button value='Edit' onclick='editSubmit();'> </td>";
			echo '</tr>';
			echo '</table>';
	}
	
	function createBudgetBoxes( $user ) {
		$query = mysql_query("select extra from UserFunds where user = '$user' ");
		$total = mysql_fetch_array($query);
		if( $total[0] <= 0 ) {
			echo '<table>';
				echo '<th>';
					echo '<tr><td>Envelope Name: </td><td><input type=text id="newBudget" name="newBudget" value="" placeholder="Car, Computer" maxLength = "23"></td></tr>';
					echo '<tr><td>Envelope Percent*: </td><td><input type=text  name="newPercent" value=""  placeholder="1.0, .10"></td></tr>';
					echo '<tr><td>Envelope Value*: </td><td><input class="noFundsCreate" type=text name="newAmount" value=""  placeholder="10.00, 100.00" readonly></td></tr>';
			echo '</table>';
		}
		else {
			echo '<table>';
				echo '<th>';
					echo '<tr><td>Envelope Name: </td><td><input type=text id="newBudget" name="newBudget" value="" placeholder="Car, Computer" maxLength = "23"></td></tr>';
					echo '<tr><td>Envelope Percent*: </td><td><input type=text  name="newPercent" value=""  placeholder="1.0, .10"></td></tr>';
					echo '<tr><td>Envelope Value*: </td><td><input type=text name="newAmount" value=""  placeholder="10.00, 100.00"></td></tr>';
			echo '</table>';
		}
	}
	
	function createList( $user ) {
		$query = mysql_query("select b_type from UserData where user = '$user'");
		//echo '<select name="editOption" class="budgetList">'; 
			echo "<option selected disabled>Select</option>";
			echo "<option value=\"undistributed\">Undistributed</option>";
			while( $row = mysql_fetch_assoc( $query ) ) {
				$type = $row['b_type'];
				echo "<option value='$type'>$type</option>"; 
			}
		echo '</select>'; 
	}
	
	function createEditList( $user ) {
		$query = mysql_query("select b_type from UserData where user = '$user'");
		//echo '<select name="editOption" class="budgetList">'; 
			echo "<option selected disabled>Select</option>";
			while( $row = mysql_fetch_assoc( $query ) ) {
				$type = $row['b_type'];
				echo "<option value='$type'>$type</option>"; 
			}
		echo '</select>'; 
	}
	
	function createRadio( $user ) {
		$query = mysql_query("select b_type from UserData where user = '$user'");
		$count = 0; 
		while( $row = mysql_fetch_assoc( $query ) ) {
			$type = $row['b_type'];
			if ( $count < 5 ) {
				$count++; 
				$count = 0; 
				echo "\n";
			}
			echo "<input type=radio value='$type' name='yes'>$type</option>"; 
		}
	}
	
	function totalAmount( $user ) {
		$query = mysql_query( "select total from UserFunds where user='$user'" ); 
		$total = mysql_fetch_array( $query ); 
		if( $total[0]==NULL ){ 
			echo '0.00'; 
		} 
		else { 
			echo $total[0]; 
		}
	} 
	
	function envelopeAmount( $user ) {
		$query = mysql_query( "select sum(b_amount) as envelopeSum from UserData where user = '$user'" ); 
		$sum = mysql_fetch_array( $query );
		if( $sum[0] == 0 ){ 
			echo '0.00'; 
		} 
		else { 
			echo $sum[0]; 
		}
	}
	
	function unusedAmount( $user ) {
		$query=mysql_query( "select extra from UserFunds where user='$user'" ); 
		$total = mysql_fetch_array( $query ); 
		if( $total[0]==NULL ){ 
			echo '0.00'; 
		} 
		else { 
			echo $total[0]; 
		}
	} 
	
	function errorMessage( $error ) {
		if( $error == 0 ){
			//print_r($_SESSION['error']);
			//echo "<script> return false; </script>";
			$_SESSION['error'] = 0; 
		}
		else if( $error == 456 ) { 
			//print_r($_SESSION['error']);
			echo "<script> alert(\"Error: Insufficient funds to perform action. \");</script>";
			$_SESSION['error'] = 0; 
		}
		else if( $error == 567 ) { 
			//print_r($_SESSION['error']);
			echo "<script> alert(\"Error: Insufficient funds. Amount set to 0.00 in new Envelope. \");</script>";
			$_SESSION['error'] = 0; 
		}
		else if( $error == 123 ) { 
			//print_r($_SESSION['error']);
			echo "<script> alert(\"Error: Envelope name is already in use.\");</script>";
			$_SESSION['error'] = 0; 
		}
		else if( $error == 234 ) { 
			//print_r($_SESSION['error']);
			echo "<script> alert(\"Error: Envelope percentages add up to                                 
						   greater than 100%. Envelope not created. \");</script>";
			$_SESSION['error'] = 0; 
		}
		else if( $error == 345 ) { 
			//print_r($_SESSION['error']);
			echo "<script> alert(\"Error: Envelope percentages add up to greater than 100%. Percentage not edited. \");</script>";
			$_SESSION['error'] = 0; 
		}
		$_SESSION['error'] = 0; 
	}

	function calculateExtra( $user ) {
		
		$query = mysql_query( "select sum(b_amount) from UserData where user = '${user}'" ) or die( mysql_error() ); 
		$totalUsed = mysql_fetch_array( $query );
		$numRows = mysql_query("select * from UserData where user = '${user}'");  
		if(mysql_num_rows($numRows) != 0) {
			mysql_query( "update UserFunds set extra = total - '$totalUsed[0]' where user = '${user}'" ) or die( mysql_error() ); 
		}
		else {
			mysql_query( "update UserFunds set extra = total where user = '${user}'" ) or die( mysql_error() ); 
		}
	}
	
?>
	<html>
	<head>
	<link rel="stylesheet" type="text/css" href="budgetStyle.css">
	</head>
	<body>
    <script src="jquery-1.11.2.js"></script>
	<script src="budgetApp.js"></script> 
	<div class="header">
	<h1 class="h1">eCashStash, A virtual savings ShoeBox built for you!</h1>
    <span class="welcome"><?php echo "Welcome, " . $row[5] . " " . $row[6];?>. <a href="http://zeus.vwc.edu/~tjpepper/ResearchProj/logout.php">Logout</a></span>
    </div>
    <hr>
	<div class="navigate">
		<div class="sidebar" id="activateHome" onclick="showSelected('home');">
		Home
		</div>
		<div class="sidebar" id="activateOverview" onclick="showSelected('overview');">
		ShoeBox Overview
		</div>
		<div class="sidebar" id="activateAddFunds" onclick="showSelected('addFunds');">
		Manage ShoeBox
		</div>
		<div class="sidebar" id="activateCreate" onclick="showSelected('create');">
		Create Envelopes
		</div>
		<div class="sidebar" id="activateEdit" onclick="showSelected('edit');">
		Edit Envelopes
		</div>
	</div>
	<div class="navSelect" id="home">
	<div class='welcomeText'> 
		<p id="entroP">Struggling with financial self-discipline and using credit when it comes to 

			buying nice-to-haves or "toys"?  What about practical everyday needs like 

			clothes or car maintenance?  Living under the black cloud of haunting 

			credit card bills and paying inordinate amounts of interest is no way to live. 

			STOP THE MADNESS! Use self-discipline - be prepared and save thousands in interest 
			
			by paying cash on the spot! eCashStash is here to 

			help you do just that!</p>

		<p id="entroP">Stashing cash away in an empty shoebox is an old-school way of 

			exercising financial self-discipline. Want a new computer, big-screen TV, 

			car, boat or motorcycle? Tired of getting caught off guard when your car 

			breaks down unexpectedly or you suddenly need new clothes? 

			eCashStash is the new-school web-tool that will help you budget and save 

			with an online ShoeBox!</p>

		<p id="entroP">Inside the eCashStash ShoeBox, you designate "Envelopes" for each toy 

			or potential need you want to save up for.<br><br>Here's how it works:</p>
		<ol>
			<li id="entroP">Keep your actual cash savings in a designated savings account in a 

				real bank. (There is no connection between your real bank and 

				eCashStash; it is a stand-alone budgeting tool.)</li><br>

			<li id="entroP">Create an eCashStash user profile. This will be your ShoeBox.</li><br>

			<li id="entroP">Decide on what you want to save up for!</li><br>

			<li id="entroP">"Deposit" (simulate depositing) the savings you want to keep in your 

				ShoeBox.</li><br>

			<li id="entroP">Within your ShoeBox, you can manage Envelopes for each toy or 

				need. You can add or delete as many envelopes as you like, 

				manually or auto-distribute cash into Envelopes, and transfer cash 

				between Envelopes.</li><br>
				
			<li id="entroP">Finally, when a savings goal is met, "withdraw" an Envelope from the 

				ShoeBox and pay CASH for that toy or need!</li><br>

			<li id="entroP">You did it!  You were ready! NO new debt, NO stress!</li><br>
		</ol>
	</div>
	</div>
	<div class="navSelect" id="overview">                                                                
	<table class="fundsTable">
		<th>
		<tr><td>Total Funds in Your ShoeBox:</td><td><input type=text name="currentBal" 
							value="<?php totalAmount( $user ); ?>" readonly></td></tr>
		<tr><td>Total Funds in Your Envelopes:</td><td><input id="envelopeBal" 
							value="<?php envelopeAmount( $user ); ?>" readonly></td></tr>
		<tr><td>Undistributed Funds in Your ShoeBox:</td><td><input id="undistributed" type=text 
							name="availableBal" value="<?php unusedAmount( $user ); ?>" readonly></td></tr>
	</table><br>
	Envelopes: <br>
	<?php createTable( $user ); ?>
	</div>
	<div class="navSelect" id="addFunds">
	<form name="add" action="manageFunds.php" method="post">
	<table class="createTable">
		<th>
			<tr><td>Deposit Funds: </td><td><input type=text name="deposit" value='' placeholder='100.00'></td></tr>
			<tr><td>Withdraw Funds: </td><td><input type=text name="withdraw" value='' placeholder='100.00'></td></tr>
	</table>
	<table class="createSubTable">
	<tr><td>Select Envelope to Manage:</td><td><?php manageFunds($user); ?></td></tr>
	<tr><td><input type=Submit value=Submit><br></td></tr>
	</table>
	</form>
	<form name="transferFunds" action="Transfer.php" method="post">
	<table>
		<tr><td>Transfer Funds:</td><td><input type=text name="transferAmt" placeholder="$100.00"></td></tr>
	</table>
	<table class="transferTable">
		<tr><td>From: <select name="transferFrom" class="budgetList"> <?php createList($user);?></td>
			<td>To: <select name="transferTo" class="budgetList"> <?php createList($user); ?></td></tr>
	</table>
	<input class='transferButton' type=Button value='Transfer Funds' onclick='transferFunds();'></td></tr>
	</form> 
	<br> 
	*Leaving an option blank will have no effect on your Funds.
	</div>
	<div class="navSelect" id="create">
	<form name="createBudget" action="createBudget.php" method="post">
	<?php createBudgetBoxes( $user ) ?>
	<input type=Button value=Submit name="createButton">
	</form>
	<br>
	*Envelope Percent will decide how much of your future deposits will be allocated to <br> this Envelope. 
	<br>
	*Envelope Value will decide how much money this Envelope will be created with. 
	<br>
	*Cannot add funds to new Envelope if there are no Undistributed Funds available. 
	</div>
	<div class="navSelect" id="edit">
	<form name="editBudget" action="editBudget.php" method="post">
	Envelopes: 
	<?php createEditDelete($user); ?>
	<input type=button id="deleteButton" name="delete" value="Delete"> <br><br>
	<br>
	<div id="individualEdit">
	Edit Envelope: 
	<select name="editOption" class="budgetList">
	<?php createEditList($user); ?>
	<br>
	<?php createEditTable(); ?>
	<br>
	* You may leave text areas blank that you do not want to edit. <br>
	<br><br>
	</div>
	</form>
	</div>	
	<input type=hidden id="divSelect" name="divSelect" value="<?php divSelect($divSelect); ?>">
	</body>
	</html>
