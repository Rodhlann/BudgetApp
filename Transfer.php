<?php
	session_start(); 
	
	$user = $_SESSION['user'];
	$pass = $_SESSION['pass'];
	$current = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$next = $_SESSION['next'];
	$home = $_SESSION['home'];
	$_SESSION['home'] = $home; 
	$_SESSION['user'] = $user;
	$_SESSION['pass'] = $pass;
	$_SESSION['divSelect'] = "overview";
	if(strlen($user) == 0 || strlen($pass) == 0)
	{
		header("location: http://zeus.vwc.edu/~tjpepper/ResearchProj/logout.php"); 
		 die(); 
	}
	else {
		
		$host = 'localhost';
		$username = '';
		$passwd = ''; 
		$database = '';
		$connect = mysql_connect($host, $username, $passwd); 
		$table = 'projSecure';
		mysql_select_db($database); 
		
		$transferAmt = $_POST['transferAmt'];
		$from = $_POST['transferFrom'];
		$to = $_POST['transferTo'];
		
		if( strlen($transferAmt) != 0 && strlen($to) != 0 && strlen($from) != 0 ) {
			if( $from == "undistributed" ) {
				$query = mysql_query("select extra from UserFunds where user = '$user'");
				$extra = mysql_fetch_array($query);
				$value = $extra[0] - $transferAmt;
				if( $value >= 0 ) { 
					//mysql_query("update UserFunds set extra = extra - '$transferAmt' where user = '$user';") or die(mysql_error()); 
					mysql_query("update UserData set b_amount = b_amount + '$transferAmt' where b_type = '$to' and user = '$user';") or die(mysql_error()); 
				}
				else {
					$_SESSION['error'] = 456; 
					$_SESSION['divSelect'] = "add"; 
				}
			}
			else if ( $to == "undistributed" ) {
				//mysql_query("update UserFunds set extra = extra + '$transferAmt' where user = '$user';") or die(mysql_error()); 
				$query = mysql_query("select b_amount from UserData where user = '$user' and b_type = '$from'");
				$extra = mysql_fetch_array($query);
				$value = $extra[0] - $transferAmt;
				if( $value >= 0 ) { 
					mysql_query("update UserData set b_amount = b_amount - '$transferAmt' where b_type = '$from' and user = '$user';") or die(mysql_error()); 
				}
				else {
					$_SESSION['error'] = 456; 
					$_SESSION['divSelect'] = "add"; 
				}
			}
			else {
				$query = mysql_query("select b_amount from UserData where user = '$user' and b_type = '$from'");
				$extra = mysql_fetch_array($query);
				$value = $extra[0] - $transferAmt;
				if( $value >= 0 ) { 
					mysql_query("update UserData set b_amount = b_amount - '$transferAmt' where b_type = '$from' and user = '$user';") or die(mysql_error()); 
					mysql_query("update UserData set b_amount = b_amount + '$transferAmt' where b_type = '$to' and user = '$user';") or die(mysql_error()); 
				}
				else {
					$_SESSION['error'] = 456; 
					$_SESSION['divSelect'] = "add"; 
				}
			}
		}
	}
	mysql_close($connect);
	header("location: http://" . $home);
	die(); 
?>
