<?php session_start(); 
	
	$user = $_SESSION['user'];
	$pass = $_SESSION['pass'];
	$home = $_SESSION['home'];
	$current = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$_SESSION['home'] = $home; 
	$_SESSION['user'] = $user;
	$_SESSION['pass'] = $pass;
	$_SESSION['divSelect'] = "overview";
	
	$deposit = $_POST['deposit'];
	$withdraw = $_POST['withdraw'];
	
	$manage = $_POST['manage'];
	
	function distrPercent($deposit, $user) {
		$getPercent = mysql_query("select * from UserData where user = '$user'");
		$getID = mysql_query("select * from UserData where user = '$user'"); 
		if (mysql_num_rows($getPercent) == 0) { 
			return; 
		}
		else {
			while( $percentArray = mysql_fetch_assoc($getPercent) ) {
				$idArray = mysql_fetch_array($getID); 
				$addPercent = ($percentArray['b_percent'] * $deposit);
				mysql_query("update UserData set b_amount = (b_amount + '$addPercent')                  
							 where user = '$user' AND id = '$idArray[4]'") or die(mysql_error());
			}
			//die(); 
		}
	} 
	
	if(strlen($user) == 0 || strlen($pass) == 0)
	{
		header("location: http://" . $home); 
		die(); 
	}
	else
	{
		// try to figure out a way to make this info private? 
		$host = 'localhost';
		$username = '';
		$passwd = ''; 
		$database = '';
		$connect = mysql_connect($host, $username, $passwd); 
		$table = 'projSecure';
		mysql_select_db($database); 
		
		if( strlen($deposit) == 0 ) {
			$deposit = 0; 
		}
		if( strlen($withdraw) == 0 ) {
			$withdraw = 0; 
		}
		if( strlen($deposit) != 0 && $deposit != 0 ) {
			$withdraw = 0; 
		}
		
		if( strlen($deposit) != 0 && $withdraw == 0 ) {
			if( strlen( $manage ) != 0 && $manage != undistributed ) {
				mysql_query("update UserData set b_amount = b_amount + $deposit where user = '$user' AND b_type = '$manage'") or die(mysql_error());
				mysql_query("update UserFunds set total = (total + $deposit) where user = '$user'") or die(mysql_error());
			}
			else if( $manage == undistributed ) {
				mysql_query("update UserFunds set total = (total + $deposit) where user = '$user'") or die(mysql_error());
			}
			else {	
				mysql_query("update UserFunds set total = (total + $deposit) where user = '$user'") or die(mysql_error());	
				distrPercent($deposit, $user);
			}
		}
		if( strlen($withdraw) != 0 && $deposit == 0 ) {
			if( strlen($manage) != 0 && $manage != undistributed ) {
				$query = mysql_query("select b_amount from UserData where user = '$user' and b_type = '$manage'");
				$funds = mysql_fetch_array($query);
				if( $withdraw <= $funds[0] ) {
					mysql_query("update UserData set b_amount = b_amount - $withdraw where user = '$user' AND b_type = '$manage'") or die(mysql_error());
					mysql_query("update UserFunds set total = total - $withdraw where user = '$user'") or die(mysql_error());
					$query = mysql_query("select b_amount from UserData where user = '$user' AND b_type = '$manage'");
					$result = mysql_fetch_assoc( $query );
					if( $result['b_amount'] < 0) {
						mysql_query("update UserData set b_amount = 0 where user = '$user' AND b_type = '$manage'") or die(mysql_error());
					}
				}
				else {
					$_SESSION['error'] = 456;
					$_SESSION['divSelect'] = "add"; 
				}
			}
			else {
				$query = mysql_query("select total from UserFunds where user = '$user'");
				$funds = mysql_fetch_array($query);
				$envelopeTotal = mysql_query("select sum(b_amount) from UserData where user = '${user}'");
				$eTotal = mysql_fetch_array($envelopeTotal);
				$newTotal = $funds[0] - $withdraw; 
				if( $withdraw <= $funds[0]  && $newTotal >= $eTotal[0] ) {
					mysql_query("update UserFunds set total = (total - $withdraw) where user = '$user'") or die(mysql_error());
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
