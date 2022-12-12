<?php


// $url_base = "http://dev.aboitiz.net:8080/sms";
// $url_base = "http://uat.aboitiz.net/sms";
// $url_base = "http://apps.aboitiz.net/sms";
$url_base = "http://localhost/security-logbook";

// $url_base2 = "http://uat.aboitiz.net/sms-cc";
// $url_base2 = "http://dev.aboitiz.net:8080/sms-cc";
// $url_base2 = "http://apps.aboitiz.net/sms-cc"; /* external link here for prod */
$url_base2 = "http://localhost/my-site";

date_default_timezone_set('Asia/Manila');

if ($_SESSION['bu'] == 'all') {
    $_SESSION['multi-admin'] = TRUE;
} else {
    unset($_SESSION['multi-admin']);
}

$urlBu = mysqli_query($conn, "select * from bu_mst where id = '".$_SESSION['bu']."'");
$rowUrl = mysqli_fetch_assoc($urlBu);
$bu_url = str_replace(" ","-",$rowUrl['bu']);
$headerBu = $rowUrl['bu'];
$bu = $_SESSION['bu'];

$level = $_SESSION['level'];
$userres =  mysqli_query($conn, "select * from users_mst where id ='".$_SESSION['id']."'");
$rowuser = mysqli_fetch_assoc($userres);

$user = $rowuser['fname'];
$userfull = $rowuser['fname']." ".$rowuser['mi']." ".$rowuser['lname'];

?>