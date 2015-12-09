<?php 
	session_start(); 

	$user = $_SESSION['user'];
	$pass = $_SESSION['pass'];
	$home = $_SESSION['home'];
	$current = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$_SESSION['home'] = $home; 
	$_SESSION['user'] = $user;
	$_SESSION['pass'] = $pass;
	$_SESSION['divSelect'] = "edit";
	
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

		$rows = $_POST['rowsToDelete'];
		if( strlen($rows[0]) != 0 ) {
			forEach($rows as $value) {
				mysql_query("delete from UserData where id = '$value' 
							 and user = '$user'") or die(mysql_error()); 
			}
		}
			else {
			mysql_close($connect);
			header("location: http://" . $home);
			die();
		}
	}
	mysql_close($connect);
	header("location: http://" . $home);
    die();
?>
