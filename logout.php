<?php
session_start();
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
//system log
	//logbook($_SESSION['id'], "Logged out");


unset($_SESSION['id']);
unset($_SESSION['level']);
unset($_SESSION['bu']);
session_destroy();
header("location:login.php");
?>