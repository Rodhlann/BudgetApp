<?php
    session_start();

    $current = $_server['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $previous = $_POST['previous'];
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="secureStyle.css">
<script src="jquery-1.11.2.js"></script>
<script src="signUpScript.js"></script>
</head>
<body onload="passVer();">
<h1>eCashStash, A virtual savings ShoeBox built for you!</h1>
<hr>
<p id="intro">Sign up here for eCashStash! Input your personal information below.</p>
<br>
<div id='signUp'>
<form name="signUp" action="loadDatabase.php" method="post">
<p><strong>Name</strong></p>
<input class="infoInput" type=text name="firstName" placeholder='First' value=''">
<input class="infoInput" type=text name="lastName" placeholder='Last' value=''">
<br>
<p><strong>Create your Username</strong></p>
<input type=text class="infoInput" name="newUser" value=''><br>
<p><strong>Create your Password</strong></p>
<input type=password class="infoInput" name="newPass" value=''><br>
<p><strong>Verify your Password</strong></p>
<div id=verifyPass>
<input type=password class="infoInput" name="verify" value='' onkeyup="return passVer();" onblur="return passVer();">
<div id="verifyTrue"><i id="passwords">Password verified.</i></div>
<div id="verifyFalse"><i id="passFail">Passwords must match.</i></div>
</div>
<br><br>
<input type="button" name="submitButton" value="Sign Up!" onclick="inputCheck(); return passVer();">
<input type="hidden" name="previous" value="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>">
<input type=Reset name="reset" value=Reset onclick="document.signUp.firstName.style.color = '#888'; document.signUp.lastName.style.color = '#888'; return passReset();">
</form>
<br>
<p>You will be redirected back to the login page after signing up.</p>
<hr>
<a href="http://zeus.vwc.edu/~tjpepper/ResearchProj/login.php">Return</a>
</div> 
</body>
</html>
