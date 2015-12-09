<?php 
	session_start(); 

	$current = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$previous = $_SESSION['home'];
    $_SESSION['previous'] = $previous; 
	$next = "zeus.vwc.edu/~tjpepper/ResearchProj/budgetApp.php";

	if(strlen($_POST['user']) == 0 || strlen($_POST['pass']) == 0)
	{
		header("location: http://" . $home);
		die();
	}
    else {
        
    	$user = $_POST['user'];
    	$pass = $_POST['pass'];
    
        $_SESSION['user'] = $user;
    	$_SESSION['pass'] = $pass;
        $_SESSION['previous'] = $current;
        
        $host = 'localhost';
        $username = '';
	$passwd = ''; 
	$database = '';
        $connect = mysql_connect($host, $username, $passwd);
        $table = 'projSecure';
        
        mysql_select_db($database);
        
        $query = mysql_query("select * from $table where USER='$user'") or die(mysql_error());
        $row = mysql_fetch_row($query);
        if ($row[1] == $user && strlen($user) != 0) {
            $salt = $row[3];
            $hashPass = md5($pass.$salt);
            if ($hashPass == $row[2] && strlen($pass) != 0) {
				$_SESSION['pass'] = "pass";
                header("location: http://" . $next);
                die();
            }
            else {
                header("location: http://" . $home);
                die();
            }
        }
        else {
            header("location: http://" . $home);
            die();
        }
    }
    mysql_close($connect);
	header("location: http://" . $home);       
	die();
?>
