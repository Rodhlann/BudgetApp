<?php
session_start(); 
session_destroy(); 
header("Location: http://zeus.vwc.edu/~tjpepper/ResearchProj/login.php");
die(); 
?>