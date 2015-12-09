<?php 
	session_start();

    $current = $_server['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$home = $_SESSION['home'];
	
	$_SESSION['home'] = $home; 
	$_SESSION['previous'] = $current; 
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="secureStyle.css">
<script src="jquery-1.11.2.js"></script>
<script src="resetPassScript.js"></script>
</head>
<body onload="passReset();">
<h1>eCashStash, A virtual savings ShoeBox built for you!</h1>
<hr>
<p id="intro">Forgot your Password? Reset it here!</p>

<form name="pass" action="newPassLoad.php" method="post">
<p><strong>Username:</strong><p>
<input type=text class="infoInput" name="user" value=''><br>
<p><strong>Change your Password</strong></p>
<input type=password class="infoInput" name="resetPass" value=''><br>
<p><strong>Verify new Password</strong></p>
<div id=verifyPass>
<input type=password class="infoInput" name="verify" value='' onkeyup="return passVer();" onblur="return passVer();">
<div id="verifyTrue"><i id="passwords">Password verified.</i></div>
<div id="verifyFalse"><i id="passwords">Passwords must match.</i></div>
<br><br>
<input type=button id="buttonSubmit" name="resetSub" value=Submit>
<input type=Reset name="reset" value=Reset onclick="return passReset();">
</form>

</div>
<br><p>You will be redirected to the login page upon successful password change. 
</p>
<hr>
<a href="http://<?php echo $home ?>">Return</a>
</body>
</html>