<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$dstart = $_GET['dstart'];
$dend = $_GET['dend'];
$searchbu = $_GET['sbu'];
$username = mysqli_real_escape_string($conn, $_GET['username']);
$lastname = mysqli_real_escape_string($conn, $_GET['lastname']);
$firstname = mysqli_real_escape_string($conn, $_GET['firstname']);

$condbu = "";
$condusername = "";
$condfirstname = "";
$condlastname = "";
$resulttable = "";

if(!empty($searchbu) && ($searchbu != 0))
{
	$condbu = " (s.bu_id = ".$searchbu.") AND ";
}
if(!empty($username))
{
	$condusername = " (u.email LIKE '%".$username."%') AND ";
}
if(!empty($lastname))
{
	$condlastname = " (u.lname LIKE '%".$lastname."%') AND ";
}
if(!empty($firstname))
{
	$condfirstname = " (u.fname LIKE '%".$firstname."%') AND ";
}
$sql1 = "SELECT s.*, u.email AS uusername, u.lname AS ulname, u.fname AS ufname, b.bu as buname 
								   FROM system_log s 
								   LEFT JOIN users_mst u ON s.uid = u.id 
								   LEFT JOIN bu_mst b ON s.bu_id = b.id
								   WHERE ".$condbu." ".$condusername." ".$condlastname." ".$condfirstname." (s.datetime BETWEEN '".$dstart."' AND DATE_ADD('".$dend."', INTERVAL 1 DAY))
								   ORDER BY datetime DESC";
$sqlsyslogs = mysqli_query($conn, $sql1);
if($sqlsyslogs)
{								  
  while($ressyslogs = mysqli_fetch_assoc($sqlsyslogs))
  {
	  $syslogdatetime = explode(" ", $ressyslogs['datetime']);
	  $syslogdate = $syslogdatetime[0];
	  $syslogtime = $syslogdatetime[1];
	  $resulttable .= "<tr>
						  <td>".$ressyslogs['id']."</td>
						  <td>".$ressyslogs['buname']."</td>
						  <td>".$ressyslogs['ulname'].", ".$ressyslogs['ufname']."</tD>
						  <td>".$ressyslogs['uusername']."</td>
						  <td>".$ressyslogs['log']."</td>
						  <td>".$syslogdate."</td>
						  <td>".$syslogtime."</td>
					   </tr>";	
  }
}

if($resulttable)
{
	echo $resulttable;
}
else
{
	echo "<tr><td colspan=\"100%\" align=\"center\">No records found. Please check date range and filters.</td></tr>";

}

?>