<?php
	session_start();
	unset($_SESSION["auth"]); 
	header("Location: http://localhost/manage/login.php");

?>