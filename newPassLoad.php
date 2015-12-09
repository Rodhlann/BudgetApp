<?php
	session_start();
	
	$previous = $_SESSION['previous'];
	$home = $_SESSION['home'];

    if(strlen($_POST['user']) == 0 || strlen($_POST['resetPass']) == 0)
    {
        header("location: http://" . $previous);
        die();
    }
    else {
	$user = $_POST['user'];
        $pass = $_POST['resetPass'];
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
        
        // work on all of this ( do want new salt for remade password )
        $query = mysql_query("select user from projSecure where user = '$user'");
		$userCheck = mysql_fetch_assoc($query);
        if($userCheck != NULL) {
			mysql_query("update projSecure set HASH_PASS = '$passHash', SALT = $passSalt where user = '$user';") or die(mysql_error());
			mysql_close($connect);
			header("location: http://" . $home);
			die();
		}
		else {
			mysql_close($connect);
			header("location: http://" . $previous);
			die();
		}
    }
	mysql_close($connect);
    header("location: http://" . $previous);
    die();
        
?>
