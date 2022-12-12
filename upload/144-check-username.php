<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$username1 = $_GET['uname'];

$queryusername = mysqli_query($conn, "SELECT id FROM users_mst WHERE email = '".$username1."'");
$resusername = mysqli_fetch_assoc($queryusername);

if($resusername)
{
	echo 1;
}
else
{
	echo 0;
}

?>