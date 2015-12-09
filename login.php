<? session_start(); 

$home = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$_SESSION['home'] = $home; 

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="secureStyle.css">
<script src="jquery-1.11.2.js"></script>
<script src="loginScript.js"></script>
</head>
<body>
<h1>eCashStash, A virtual savings ShoeBox built for you!</h1>
<hr>
<p>Welcome to the eCashStash Application Alpha! Please log in.</p>
<form name="login" action="accessDatabase.php" method="post">
<span id="userContainer">
	<p><input class="infoInput" type=text name="user" value='' placeholder="Username"></p>
</span>
<span id="passContainer">
	<p><input class="infoInput" type=password name="pass" value='' placeholder="Password"></p>
</span>
<input id="btnSubmit" name="btnSubmit" type=button value=Continue onclick="submitForm();">
<input type=Reset name="reset" value=Reset onclick="return formReset();">
</form>
<p><a href="signUp.php">Sign Up!</a><br>
   <a href="resetPass.php">Forgot Your Password?</a></p> 
<hr>
<a href="http://zeus.vwc.edu/~tjpepper/ResearchProj/projectHome.html">Return</a>
</body>
</html>
