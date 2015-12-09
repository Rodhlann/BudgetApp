<?php
    session_start();
    
    $current = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $previous = $_POST['previous'];
    $next = "zeus.vwc.edu/~tjpepper/ResearchProj/login.php";
    
    if(strlen($_POST['newUser']) == 0 || strlen($_POST['newPass']) == 0)
    {
        header("location: http://" . $previous);
        die();
    }
    else {
        
	$first = $_POST['firstName'];
	$last = $_POST['lastName'];
        $user = $_POST['newUser'];
        $pass = $_POST['newPass'];
	 
	$_SESSION['first'] = $first; 
	$_SESSION['last'] = $last; 
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
		
        //create hash and salt
    
        $passSalt = rand(1000, 9999);
        $passFinal = $pass . $passSalt;
        $passHash = md5($passFinal);
       
        //check to see if duplicate user name given and submit info if not
        
        $userCheck = mysql_query("select ID from projSecure where USER = '$user'");
        if(mysql_num_rows( $userCheck ) == 0) {
            mysql_query("insert into $table (USER, HASH_PASS, SALT, REG_DATE, FIRST_NAME, LAST_NAME) values 
							('$user', '$passHash', '$passSalt', Now(), '$first', '$last');") or die(mysql_error());
			mysql_query("insert into UserFunds (user, total, extra) values ('$user', 0, 0)") or die(mysql_error());
        }
        else { 
            mysql_close($connect);
            echo '<script type="text/javascript">alert("Username unavailable."); javascript:history.back();</script>';
            header("location: http://" . $previous);
            die();
        }
        mysql_close($connect);
        header("location: http://" . $next);
        die();
    }
        
?>








