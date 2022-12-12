<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
//system log
	//logbook($_SESSION['id'], "Logged out");

$changebuid = $_GET['buid'];
if ($changebuid == 0) {
	$_SESSION['bu'] = 'all';
	header("location:multi-bu.php");

} else {
	$_SESSION['bu'] = $changebuid;
	$bu = $changebuid;
	header("location:user-admin.php");
}
?>