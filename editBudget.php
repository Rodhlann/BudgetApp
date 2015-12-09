<?php session_start(); 

	$user = $_SESSION['user'];
	$pass = $_SESSION['pass'];
	$current = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$next = $_SESSION['next'];
	$home = $_SESSION['home'];
	$_SESSION['home'] = $home; 
	$_SESSION['user'] = $user;
	$_SESSION['pass'] = $pass;
	$_SESSION['divSelect'] = "edit";
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
		
		$oldType = $_POST['editOption'];
		$newType = $_POST['editType'];
		$newPercent = $_POST['editPercent'];
			
		if( strlen($newType) != 0 && strlen($newPercent) != 0) {
			$pQuery =  mysql_query("select sum(b_percent) from UserData where user = '$user'");
			$tPercent = mysql_fetch_array($pQuery);
			if( ($tPercent[0] + $newPercent) > 1.0 ) {
				$_SESSION['error'] = 345;
				mysql_query("update UserData set b_type = '$newType' where b_type = '$oldType' 
							 and user = '$user';") or die(mysql_error());
			}
			else {
				mysql_query("update UserData set b_type = '$newType', b_percent = '$newPercent' 
							 where b_type = '$oldType' and user = '$user';") or die(mysql_error());
			}
		}
		else if( strlen($newType) == 0 && strlen($newPercent) != 0) {
			$pQuery =  mysql_query("select sum(b_percent) from UserData where user = '$user'");
			$tPercent = mysql_fetch_array($pQuery);
			if( ($tPercent[0] + $newPercent) > 1.0 ) {
				$_SESSION['error'] = 345;
			}
			else {
				mysql_query("update UserData set b_percent = '$newPercent' 
							 where b_type = '$oldType' and user = '$user';") or die(mysql_error());
			}
		}
		else if( strlen($newType) != 0 && strlen($newPercent) == 0 ) {
			mysql_query("update UserData set b_type = '$newType' where b_type = '$oldType' 
						 and user = '$user';") or die(mysql_error());
		}
		else {}	
		mysql_close($connect);
		header("location: http://" . $home);
		die(); 
	}
	mysql_close($connect);
	header("location: http://" . $home);
	die(); 

?>

	
