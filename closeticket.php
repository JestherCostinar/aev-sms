<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
date_default_timezone_set('Asia/Manila');
$datenow = date('Y-m-d H:i:s');

$ticket_id = $_GET['id'];

mysqli_query($conn, "UPDATE ticket SET is_open = 0, dateclosed = '".$datenow."' WHERE id = ". $ticket_id);

if($_SESSION['level'] == 'User')
{
	header("location:user.php?last=" . $_GET['type']);
}
elseif($_SESSION['level'] == 'Admin')
{
	header("location:user-admin.php?last=" . $_GET['type']);
}
elseif($_SESSION['level'] == 'Super Admin')
{
	header("location:user-superadmin.php?last=" . $_GET['type']);
}

?>