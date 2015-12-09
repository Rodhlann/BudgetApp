<?php session_start(); 
	
	$user = $_SESSION['user'];
	$pass = $_SESSION['pass'];
	$home = $_SESSION['home'];
	$current = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$next = $_SESSION['next'];
	//$_SESSION['error'] = 0; 
	$_SESSION['home'] = $home; 
	$_SESSION['user'] = $user;
	$_SESSION['pass'] = $pass;
	
	//$next = "zeus.vwc.edu/~tjpepper/ResearchProj/budgetApp.php";
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
		$table = 'UserData';
		mysql_select_db($database); 
		
		$type = $_POST['newBudget'];
		$percent = $_POST['newPercent'];
		$amount = $_POST['newAmount'];
		$initialPercent = $_POST['spawnPercent'];
		$distrPercentBool = $_POST['distrPercentBool'];
		$_SESSION['divSelect'] = "overview";
		
		if( strlen($type) == 0 ) {
			header("location: http://" . $home);
			die(); 
		}
	
		$typeCheck = mysql_query("select b_type from UserData where user = '$user'");
		$typeAvailable = true;
		while($userArray = mysql_fetch_array($typeCheck)) {
			if($userArray['b_type'] == $type) {
				$typeAvailable = false;
			}
		}
		if($typeAvailable == true) {
			$_SESSION['error'] = 0;
			$query = mysql_query("select extra from UserFunds where user = '$user'");
			$extra = mysql_fetch_array($query);
			$pQuery =  mysql_query("select sum(b_percent) from UserData where user = '$user'");
			$tPercent = mysql_fetch_array($pQuery);
			if( ($tPercent[0] + $percent) > 1.0 ) {
				$_SESSION['error'] = 234;
				$_SESSION['divSelect'] = "create"; 
			}
			else {
				mysql_query("insert into UserData(user, b_type, b_percent, b_amount) 
							 values ('$user', '$type', '$percent', '$amount')") or die(mysql_error()); 
			}
			header("location: http://" . $next);
			die(mysql_error()); 
		}
		else if($typeAvailable == false ){
			$_SESSION['error'] = 123;
			$_SESSION['divSelect'] = "create"; 
			mysql_close($connect);
			header("location: http://" . $next);
			die(mysql_error());
		}
	}
	header("location: http://" . $next);
	mysql_close($connect);
	die(mysql_error());
?>
