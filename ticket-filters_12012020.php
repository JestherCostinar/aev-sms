<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
include("class.upload.php-master/src/class.upload.php");


$budatalist = "";
$locationdatalist = "";
$guardsdatalist2 = "";

$filtertoken = $_GET['token'];

if($_SESSION['level'] == 'Super Admin' || $rowuser['level'] == 'Custom Admin')
{
	$bulistsql = mysqli_query($conn, "SELECT * FROM bu_mst ORDER BY bu");
	$budatalist = "<option value='0'>All BUs</option>";
	//$locationdatalist = "";
}
else
{
	$bulistsql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$bu);
	
	$locsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE bu = ".$bu." ORDER BY bu, location_code");
	while($locres2 = mysqli_fetch_assoc($locsql)){
		$locationdatalist .= "<option value=\"".$locres2['id']."\">".$locres2['location_code']." - ".$locres2['location']."</option>";
	}
	
	$guardsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ".$bu." ORDER BY lname");
	while($guardres2 = mysqli_fetch_assoc($guardsql)){
		$guardsdatalist2 .= "<option value=\"". $guardres2['id'] . "\">".  $guardres2['lname'] .", ". $guardres2['fname'] ."</option>";
	}
}


while($bulistres = mysqli_fetch_assoc($bulistsql))
{
	$budatalist .= "<option value=\"".$bulistres['id']."\">".$bulistres['bu']."</option>";	
}

$incidententriesdatalist = "";
$incidententriessql = mysqli_query($conn, "SELECT * FROM entries_incident ORDER BY name");
while($incidententriesres = mysqli_fetch_assoc($incidententriessql))
{
	$incidententriesdatalist .= "<option value=\"".$incidententriesres['id']."\">".$incidententriesres['name']."</option>";	
}

$urcdatalist = "";
$urcsql = mysqli_query($conn, "SELECT * FROM urc_mst ORDER BY series, codes, description");
while($urcres2 = mysqli_fetch_assoc($urcsql)){
	$urcdatalist .= "<option value=\"".$urcres2['id']."\">".$urcres2['codes']." : ". $urcres2['description'] ."</option>";;
}



//$locsql = mysqli_query($conn, "SELECT * FROM location_mst ORDER BY bu, location_code");
/* while($locres2 = mysqli_fetch_assoc($locsql)){
	$locationdatalist .= "<option value=\"".$locres2['id']."\">".$locres2['location_code']." - ".$locres2['location']."</option>";
} */

/* $guardsdatalist2 = "";
$guardsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ".$bu." ORDER BY lname");
while($guardres2 = mysqli_fetch_assoc($guardsql)){
	$guardsdatalist2 .= "<option value=\"". $guardres2['id'] . "\">".  $guardres2['lname'] .", ". $guardres2['fname'] ."</option>";
} */

$maingroupdatalist = "";
$maingropsql = mysqli_query($conn, "SELECT * FROM incident_main_cat WHERE status='Active'");
while($maingroupres = mysqli_fetch_assoc($maingropsql))
{
	$maingroupdatalist .= "<option value=\"".$maingroupres['id']."\">".$maingroupres['main_cat']."</option>";
}

date_default_timezone_set('Asia/Manila');
$logdate = date('Y-m-d');

$btnFilter =	'<td align="center" colspan="100%">
					<img src="images/Search_btn.png" width="80px" id="btnSearchIncLog" name="btnsearchIncLog" style="cursor:pointer; vertical-align:middle;" onclick="searchLogs(1);" >
				</td>';

if($filtertoken == "monitoringform")
{
	$btnFilter =	'<td align="center" colspan="100%">
						<button onclick="generateReportTable2();" class="redbutton" style="width:150px;">Generate Table</button>						
					</td>';
}

$divcontent =	'<table align="center" >
					<tr align="center">
						<td align="right">
							<strong>Date:</strong>
						</td>
						<td align="left">
							<input type="date" id="searchIncLogStart" name="searchIncLogStart" value="'.$logdate.'" />&nbsp; to &nbsp;<input type="date" id="searchIncLogEnd" name="searchActIncEnd" value="'.$logdate.'" />
						</td>
						<td align="right">
							<strong>Business Unit:</strong>							
						</td>
						<td align="left">
							<select id="txtSearchIncLogBU" name="txtSearchIncLogBU" onchange="loadLocationGuard2();">								
								'.$budatalist.'
							</select> 
						</td>						
					</tr>
					<tr align="center">
						<td align="right">							
							<strong>Main Group:</strong>
						</td>
						<td align="left">
							<select id="selSearchIncLogMain" name="selSearchIncLogMain" onchange="changeSub2();">
								<option value="0">All Types</option>
							'.$maingroupdatalist.'
							</select>
						</td>
						<td align="right">							
							<strong>Sub Group:</strong>
						</td>
						<td align="left">
							<select id="selSearchIncLogSub" name="selSearchIncLogSub">
								<option value="0">All Types</option>						
							</select>
						</td>						
					</tr>
					<tr align="center">						
						<td align="right">						
							<strong>Incident Type:</strong>
						</td>
						<td align="left">
							<select id="selSearchIncLogType" name="selSearchIncLogType">
								<option value="0">All Incidents</option>
								'.$incidententriesdatalist.'
							</select>
						</td>
						<td align="right">
							<strong>URC:</strong>
						</td>
						<td align="left">
							<select id="selSearchIncLogURC" name="selSearchIncLogURC">
								<option value="0">All URCs</option>
								'.$urcdatalist.'
							</select>
						</td>
					</tr>
					<tr align="center">						
						<td align="right">
							<strong>Location:</strong>
						</td>
						<td align="left">
							<select id="selSearchIncLogLoc" name="selSearchIncLogLoc">
								<option value="0">All Locations</option>
								'.$locationdatalist.'
							</select>
						</td>
						<td align="right">
							<strong>Guard:</strong>
						</td>
						<td align="left">
							<select id="selSearchIncLogGuard" name="selSearchIncLogGuard">
								<option value="0">All Guards</option>
								'.$guardsdatalist2.'
							</select>
						</td>
					</tr>
					<tr> 
						<td align="right">
							<strong>Ticket ID::</strong>
						</td>
						<td align="left">
							<input type="text" id="txtSearchTicketId" name="txtSearchTicketId" />
						</td>
						<td>
						</td>
						<td>
						</td>
					</tr>
					<tr>
						'.$btnFilter.'
					</tr>
				</table>';


if(!empty($divcontent))
{
	echo $divcontent;	
}
else
{	
	echo "<tr><td colspan=\"100%\" align=\"center\">Record not found</td></tr>";
}
?>