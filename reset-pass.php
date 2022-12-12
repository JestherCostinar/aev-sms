<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$userid1 = $_GET['id'];
$userpass1 = "password" . date("Y");


$querychangepass = mysqli_query($conn, "UPDATE users_mst SET password = '".md5($userpass1)."' WHERE id = '".$userid1."'");

if($querychangepass)
{
	echo "Password has been reset.";
}
else
{
	echo "Error. Please contact IT support.";
}

?>