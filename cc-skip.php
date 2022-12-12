<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
elseif($_SESSION['level'] != 'Super Admin'){
	header("location:login.php");
}

include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$skip_total_score = 19110916;
$skip_bu = $_GET['ccbu'];
$skip_month = $_GET['ccmonth'];
$skip_year = $_GET['ccyear'];
$skip_agency = $_GET['ccagency'];
$skip_agency_email = "skip@email.com";
$skip_approved = 1;
$skip_sent = 1;

mysqli_query($conn, "INSERT INTO cc_general (total_score, bu, month, year, agency, agency_email, approved, sent) VALUES(".$skip_total_score.", ".$skip_bu.", ".$skip_month.", ".$skip_year.", ".$skip_agency.", '".$skip_agency_email."', ".$skip_approved.", ".$skip_sent.")")or die(mysqli_error($conn));

header("location:user-superadmin.php?last=ConCompConsolidation");
?>