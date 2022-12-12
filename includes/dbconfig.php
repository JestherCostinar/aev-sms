<?php

$conn = mysqli_connect('localhost', 'root');

if (!$conn) { die('Not connected : ' . mysqli_error());}
//SELECT
$db = mysqli_select_db($conn, 'AEV_OSLS');
if (!$db) { die ('Can\'t use database : ' . mysqli_error());}

//mysqli_query($conn, "insert into main_groups(name) values('Executive Protection Group')");

error_reporting(E_ALL ^ E_NOTICE);	/*this will turn off all annoying error*/

//error logging
ini_set('log_errors', 1);
ini_set("error_log", "includes/temp_logs/osls-error.log");
//end error loggin
?>
