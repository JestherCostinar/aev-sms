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
include("sendmail.php");
include("class.upload.php-master/src/class.upload.php");

$jsrefresh = md5(rand(0,10000));

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

$sqlDisplayUser = mysqli_query($conn, "SELECT *FROM users_mst WHERE id = ".$_SESSION['id']);
$resDisplayUser = mysqli_fetch_assoc($sqlDisplayUser);

$displayUsername = $resDisplayUser['email'];
$displayLevel = $resDisplayUser['level'];


$urcdatalist = "";
$urcsql = mysqli_query($conn, "SELECT * FROM urc_mst ORDER BY series, codes, description");
while($urcres2 = mysqli_fetch_assoc($urcsql)){
	$urcdatalist .= "<option value=\"".$urcres2['id']."\">".$urcres2['codes']." : ". $urcres2['description'] ."</option>";;
}

$locationdatalist = "";
$locationstable = "";
$locationnumber = 1;
$locationrow = 1;
$rowclass2 = "";
$locationarray = array();
$locsql = mysqli_query($conn, "SELECT * FROM location_mst ORDER BY bu, location_code");
while($locres2 = mysqli_fetch_assoc($locsql)){
	if($locationrow==1){
		$rowclass2 = "class=\"altrows\"";
		$locationrow = 0;
	}
	elseif($locationrow==0){
		$rowclass2 = "";
		$locationrow = 1;
	}
	$locationdatalist .= "<option value=\"".$locres2['id']."\">".$locres2['location_code']." - ".$locres2['location']."</option>";
	$locationbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$locres2['bu']);
	$locationbu = mysqli_fetch_assoc($locationbusql);
	/* $locationstable .= "<tr ". $rowclass2 ." align=\"center\">" .
							"<td>". $locationnumber ."</td>" .
							"<td>". $locationbu['bu'] ."</td>" .
							"<td>".$locres2['location_code']."</td>" .
							"<td>".$locres2['location']."</td>" .
							"<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit Location\" style=\"cursor:pointer;\" onclick=\"editLocation('".$locres2['location_code']."', '".$locres2['location']."', ".$locres2['id'].", '".$locres2['bu']."');\" /></td>" .
							"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem(".$locres2['id'].",'Locs');\" /></td>".
						"</tr>"; */
	$locationarray[] = $locres2['location'];
	$locationnumber++;
}

$tblretract = "";
// $retractionsql = mysqli_query($conn, "SELECT * FROM request_mst WHERE is_open = 1");
$retractionsql = mysqli_query($conn, "SELECT * FROM request_mst ORDER BY is_open DESC");
while($retractionres = mysqli_fetch_assoc($retractionsql))
{
	$requestersql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$retractionres['requester']);
	$requesterres = mysqli_fetch_assoc($requestersql);
	$retractbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$retractionres['bu']);
	$retractbures = mysqli_fetch_assoc($retractbusql);
	$retractticketsql = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$retractionres['ticket_id']);
	$retractticketres = mysqli_fetch_assoc($retractticketsql);
	if($retractionres['is_open'] == 1)
	{
		$control = "<td align='center'><img src='images/checkgreen.png' height='24px' style='cursor:pointer;' onclick=\"openApproveRetract('".$retractionres['ticket_id']."', 'approve', ".$retractionres['id'].", ".$retractionres['bu'].", '".$requesterres['fname']." ".$requesterres['mi']." ".$requesterres['lname']."', ".$retractionres['level'].");\"></td>
						<td align='center'><img src='images/x_mark_red.png' height='24px' style='cursor:pointer;' onclick=\"openApproveRetract('".$retractionres['ticket_id']."', 'reject', ".$retractionres['id'].", ".$retractionres['bu'].", '".$requesterres['fname']." ".$requesterres['mi']." ".$requesterres['lname']."');\"></td>";
	}
	else
	{
		$control = "<td align='center' colspan='100%' style='color:red;'>Closed</td>";
	}
	$tblretract .= "<tr align='center'>
						<td>".$retractionres['id']."</td>
						<td>".$retractionres['submit_date']."</td>
						<td>".$requesterres['fname']." ".$requesterres['mi']." ".$requesterres['lname']."</td>
						<td>".$retractbures['bu']."</td>
						<td>".$retractionres['ticket_id']."</td>
						<td>".$retractticketres['severity']."</td>
						<td>".$retractionres['level']."</td>
						<td>".$retractionres['details']."</td>
						".$control."
					</tr>";
}

$tbldeletions = "";
$retractionsql = mysqli_query($conn, "SELECT * FROM deletions_mst ORDER BY is_open DESC");
while($retractionres = mysqli_fetch_assoc($retractionsql))
{
	$requestersql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$retractionres['requester']);
	$requesterres = mysqli_fetch_assoc($requestersql);
	$retractbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$retractionres['bu']);
	$retractbures = mysqli_fetch_assoc($retractbusql);
	$retractticketsql = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$retractionres['target_id']);
	$retractticketres = mysqli_fetch_assoc($retractticketsql);
	if($retractionres['is_open'] == 1)
	{
		$control = "<td align='center'><img src='images/checkgreen.png' height='24px' style='cursor:pointer;' onclick=\"openApproveDeletion('".$retractionres['target_id']."', 'approve', ".$retractionres['id'].", ".$retractionres['bu'].", '".$requesterres['fname']." ".$requesterres['mi']." ".$requesterres['lname']."', '".$retractionres['type']."');\"></td>
						<td align='center'><img src='images/x_mark_red.png' height='24px' style='cursor:pointer;' onclick=\"openApproveDeletion('".$retractionres['target_id']."', 'reject', ".$retractionres['id'].", ".$retractionres['bu'].", '".$requesterres['fname']." ".$requesterres['mi']." ".$requesterres['lname']."');\"></td>";
	}
	else
	{
		$control = "<td align='center' colspan='100%' style='color:red;'>Closed</td>";
	}
	$tbldeletions .= "<tr align='center'>
						<td>".$retractionres['id']."</td>
						<td>".$retractionres['submit_date']."</td>
						<td>".$requesterres['fname']." ".$requesterres['mi']." ".$requesterres['lname']."</td>
						<td>".$retractbures['bu']."</td>
						<td>".$retractionres['type']."</td>
						<td>".$retractionres['target_id']."</td>						
						<td>".$retractionres['details']."</td>
						".$control."
					</tr>";
}

$guardsdatalist = "";
$guardsdatalist2 = "";
$guardsarray = array();
$checkexprosql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$bu);
$checkexprores = mysqli_fetch_assoc($checkexprosql);
$guardbu = $bu;
if($checkexprores['expro'] == 1) //if expro bu, point guard db to expro visayas, id = 24
{
	$guardbu = 24;
}
$guardsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ".$guardbu);
while($guardres2 = mysqli_fetch_assoc($guardsql)){
	$guardsdatalist .= "<option value=\"". $guardres2['lname'] .", ". $guardres2['fname'] . "\"></option>";
	$guardsdatalist2 .= "<option value=\"". $guardres2['id'] . "\">".  $guardres2['lname'] .", ". $guardres2['fname'] ."</option>";
	$guardsarray[] = $guardres2['lname'] .", ". $guardres2['fname'];
}



/* $oictable = "";
$oicnumber = 1;
$oicrow = 1;
$oicsql = mysqli_query($conn, "SELECT * FROM oic_mst ORDER BY bu, lname");
while($oicres = mysqli_fetch_assoc($oicsql)){
	if($oicrow==1){
		$oicrowclass = "class=\"altrows\"";
		$oicrow = 0;
	}
	elseif($oicrow==0){
		$oicrowclass = "";
		$oicrow = 1;
	}
	$oicbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = '".$oicres['bu']."'");
	$oicbu = mysqli_fetch_assoc($oicbusql);
	$oictable .= "<tr align=\"center\" ".$oicrowclass.">
						<td>".$oicnumber."</td>
						<td>".$oicres['lname'].", ".$oicres['fname']." ".$oicres['mname']."</td>
						<td>".$oicres['email_ad']."</td>
						<td>".$oicres['mobile']."</td>
						<td>".$oicbu['bu']."</td>
						<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit Recipient\" style=\"cursor:pointer;\" onclick=\"editOic('".$oicres['fname']."', '".$oicres['mname']."', '".$oicres['lname']."', '".$oicres['email_ad']."', '".$oicres['mobile']."', '".$oicres['id']."', '".$oicres['bu']."')\" /></td>
						<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$oicres['id']."', 'SecAlert');\" /></td>
				  </tr>";
				  		$oicnumber++;
} */

$userstable = "";
$adminstable = "";
$superstable = "";
$acctdata = "";
$usersnumber = 1;
$adminsnumber = 1;
$supersnumber = 1;
$userssql = mysqli_query($conn, "SELECT * FROM users_mst ORDER BY lname");
while($usersres = mysqli_fetch_assoc($userssql))
{
	$multiplebulist = array();
	$finaldisplaybu = "None";
	$multiplebusql = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id = ".$usersres['id']);
	while($multiplebures = mysqli_fetch_assoc($multiplebusql))
	{
		$userbusql2 = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$multiplebures['bu_id']);
		$userbu2 = mysqli_fetch_assoc($userbusql2);
		$multiplebulist[] = $userbu2['bu'];
	}
	if($multiplebulist)
	{
		$finaldisplaybu = implode(", ", $multiplebulist);
	}
	else
	{
		$userbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$usersres['bu']);
		$userbu = mysqli_fetch_assoc($userbusql);
		$finaldisplaybu = $userbu['bu'];
	}
	if(($usersres['level'] == "Admin") || ($usersres['level'] == "Custom Admin"))
	{
		$finaldisplaybu .= " - <a style='color:blue; cursor:pointer;' onclick='openMultipleBUModal(".$usersres['id'].");'>EDIT</a>";
	}
	$iconcolor = ($usersres['status'] == 'Active') ? "green" : "red";
	$acctdata = "<tr align=\"center\">" .
		"<td>" . $usersres['lname'] . ", " . $usersres['fname'] . " " . $usersres['mi'] . "</td>" .
		"<td>" . $usersres['gender'] . "</td>" .
		"<td>" . $usersres['email'] . "</td>" .
		"<td>" . $usersres['level'] . "</td>" .
		"<td>" . $finaldisplaybu . "</td>" .
		"<td>" . $usersres['contact'] . "</td>" .
		"<td>" . $usersres['status'] . "</td>" .
		"<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit User\" style=\"cursor:pointer;\" onclick=\"editUserSA('" . $usersres['lname'] . "', '" . $usersres['fname'] . "', '" . $usersres['mi'] . "', '" . $usersres['gender'] . "', '" . $usersres['email'] . "', '" . $usersres['user_email'] . "', '" . $usersres['level'] . "', '" . $usersres['contact'] . "', '" . $usersres['id'] . "', '" . $usersres['bu'] . "')\" /></td>" .
		"<td><img src=\"images/activate" . $iconcolor . ".png\" height=\"32px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('" . $usersres['id'] . "', 'Users');\" /></td>" .
		"</tr>";

	$acctdataWithEmail = "<tr align=\"center\">" .
		"<td>" . $usersres['lname'] . ", " . $usersres['fname'] . " " . $usersres['mi'] . "</td>" .
		"<td>" . $usersres['gender'] . "</td>" .
		"<td>" . $usersres['email'] . "</td>" .
		"<td>" . $usersres['user_email'] . "</td>" .

		"<td>" . $usersres['level'] . "</td>" .
		"<td>" . $finaldisplaybu . "</td>" .
		"<td>" . $usersres['contact'] . "</td>" .
		"<td>" . $usersres['status'] . "</td>" .
		"<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit User\" style=\"cursor:pointer;\" onclick=\"editUserSA('" . $usersres['lname'] . "', '" . $usersres['fname'] . "', '" . $usersres['mi'] . "', '" . $usersres['gender'] . "', '" . $usersres['email'] . "', '" . $usersres['user_email'] . "', '" . $usersres['level'] . "', '" . $usersres['contact'] . "', '" . $usersres['id'] . "', '" . $usersres['bu'] . "')\" /></td>" .
		"<td><img src=\"images/activate" . $iconcolor . ".png\" height=\"32px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('" . $usersres['id'] . "', 'Users');\" /></td>" .
		"</tr>";

	if ($usersres['level'] == "User") {
		$userstable .= $acctdata;
	} elseif (($usersres['level'] == "Head Guard")) {
		$headguardtable .= $acctdata;
	} elseif (($usersres['level'] == "Admin") || ($usersres['level'] == "Custom Admin")) {
		$adminstable .= $acctdataWithEmail;
	} elseif ($usersres['level'] == "Super Admin") {
		$superstable .= $acctdataWithEmail;
	}
}

// ACTIVE AGENCY
$secactiveagencytable = "";
$secagencynum = 1;
$secagencyrow = 1;
$secagencydatalist = "";
$secagencysql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE contract_status = 'Active' ORDER BY agency_name");
while($secagencyres = mysqli_fetch_assoc($secagencysql)){
	$secagencydatalist .= "<option value=\"".$secagencyres['id']."\">".$secagencyres['agency_name']."</option>";
	if($secagencyrow==1){
		$secagerowclass = "class=\"altrows\"";
		$secagencyrow = 0;
	}
	elseif($secagencyrow==0){
		$secagerowclass = "";
		$secagencyrow = 1;
	}
	$secagencyid = $secagencyres['id'];
	$secagencyname = $secagencyres['agency_name'];
	$secagencyaddress = $secagencyres['address'];
	$secagencyoic = $secagencyres['oic'];
	$secagencycontact = $secagencyres['contact_number'];
	$secagencylicensenum = $secagencyres['license)number'];
	$secagencylicenseissued = $secagencyres['license_issued'];
	$secagencylicenseexpiration = $secagencyres['license_expiration'];
//	$secagencyprofile = $secagencyres['company_profile'];
	$secagencyprofile = preg_replace( "/\r|\n/", "<br>", $secagencyres['company_profile'] );
	$secagencycontract = $secagencyres['contract_status'];
	$secagencybulist = array();
	$secagencybunames = "";
	$secagencybusql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE agency_id = ".$secagencyid);
	while($secagencybures = mysqli_fetch_assoc($secagencybusql))
	{
		$agencybunamesql = mysqli_query($conn, "SELECT bu FROM bu_mst WHERE id = ".$secagencybures['bu_id']);
		$agencybuname = mysqli_fetch_assoc($agencybunamesql);
		$secagencybulist[] = $agencybuname['bu'];
	}
	$secagencybunames = implode(", ", $secagencybulist);
//	$secagencybulist = implode(", ", $secagencybures);
	$secactiveagencytable .= "<tr align=\"center\" ".$secagerowclass.">" .
							"<td>".$secagencynum."</td>" .
							"<td>".$secagencyname."</td>" .
							"<td>".$secagencyaddress."</td>" .
							"<td>".$secagencyoic."</td>" .
							"<td>".$secagencycontact."</td>" .
							"<td>".$secagencybunames."</td>" .
							"<td>".$secagencycontract."</td>" .
							"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"viewAgencySA('".$secagencyid."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyname))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyaddress))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyoic))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencycontact))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyres['license_number']))."', '".$secagencyres['license_issued']."', '".$secagencyres['license_expiration']."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyprofile))."', '".$secagencyres['contract_status']."')\"></td>";
	$secagencynum++;					
}

// INACTIVE AGENCY
$secinactiveagencytable = "";
$secagencynum = 1;
$secagencyrow = 1;
$secagencydatalist = "";
$secagencysql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE contract_status = 'Inactive' ORDER BY agency_name");
while($secagencyres = mysqli_fetch_assoc($secagencysql)){
	$secagencydatalist .= "<option value=\"".$secagencyres['id']."\">".$secagencyres['agency_name']."</option>";
	if($secagencyrow==1){
		$secagerowclass = "class=\"altrows\"";
		$secagencyrow = 0;
	}
	elseif($secagencyrow==0){
		$secagerowclass = "";
		$secagencyrow = 1;
	}
	$secagencyid = $secagencyres['id'];
	$secagencyname = $secagencyres['agency_name'];
	$secagencyaddress = $secagencyres['address'];
	$secagencyoic = $secagencyres['oic'];
	$secagencycontact = $secagencyres['contact_number'];
	$secagencylicensenum = $secagencyres['license)number'];
	$secagencylicenseissued = $secagencyres['license_issued'];
	$secagencylicenseexpiration = $secagencyres['license_expiration'];
//	$secagencyprofile = $secagencyres['company_profile'];
	$secagencyprofile = preg_replace( "/\r|\n/", "<br>", $secagencyres['company_profile'] );
	$secagencycontract = $secagencyres['contract_status'];
	$secagencybulist = array();
	$secagencybunames = "";
	$secagencybusql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE agency_id = ".$secagencyid);
	while($secagencybures = mysqli_fetch_assoc($secagencybusql))
	{
		$agencybunamesql = mysqli_query($conn, "SELECT bu FROM bu_mst WHERE id = ".$secagencybures['bu_id']);
		$agencybuname = mysqli_fetch_assoc($agencybunamesql);
		$secagencybulist[] = $agencybuname['bu'];
	}
	$secagencybunames = implode(", ", $secagencybulist);
	//	$secagencybulist = implode(", ", $secagencybures);
	$secinactiveagencytable .= "<tr align=\"center\" ".$secagerowclass.">" .
							"<td>".$secagencynum."</td>" .
							"<td>".$secagencyname."</td>" .
							"<td>".$secagencyaddress."</td>" .
							"<td>".$secagencyoic."</td>" .
							"<td>".$secagencycontact."</td>" .
							"<td>".$secagencybunames."</td>" .
							"<td>".$secagencycontract."</td>" .
							"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"viewAgencySA('".$secagencyid."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyname))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyaddress))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyoic))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencycontact))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyres['license_number']))."', '".$secagencyres['license_issued']."', '".$secagencyres['license_expiration']."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyprofile))."', '".$secagencyres['contract_status']."')\"></td>";
	$secagencynum++;					
}

// POOL AGENCY
$poolsecagencytable = "";
$secagencynum = 1;
$secagencyrow = 1;
$secagencydatalist = "";
$secagencysql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE contract_status = 'Active' ORDER BY agency_name");
while ($secagencyres = mysqli_fetch_assoc($secagencysql)) {
	$secagencydatalist .= "<option value=\"" . $secagencyres['id'] . "\">" . $secagencyres['agency_name'] . "</option>";
	if ($secagencyrow == 1) {
		$secagerowclass = "class=\"altrows\"";
		$secagencyrow = 0;
	} elseif ($secagencyrow == 0) {
		$secagerowclass = "";
		$secagencyrow = 1;
	}
	$secagencyid = $secagencyres['id'];
	$secagencyname = $secagencyres['agency_name'];
	$secagencyaddress = $secagencyres['address'];
	$secagencyoic = $secagencyres['oic'];
	$secagencycontact = $secagencyres['contact_number'];
	$secagencylicensenum = $secagencyres['license)number'];
	$secagencylicenseissued = $secagencyres['license_issued'];
	$secagencylicenseexpiration = $secagencyres['license_expiration'];
	//	$secagencyprofile = $secagencyres['company_profile'];
	$secagencyprofile = preg_replace("/\r|\n/", "<br>", $secagencyres['company_profile']);
	$secagencycontract = $secagencyres['contract_status'];
	$secagencybulist = array();
	$secagencybunames = "";
	$secagencybusql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE agency_id = " . $secagencyid);
	while ($secagencybures = mysqli_fetch_assoc($secagencybusql)) {
		$agencybunamesql = mysqli_query($conn, "SELECT bu FROM bu_mst WHERE id = " . $secagencybures['bu_id']);
		$agencybuname = mysqli_fetch_assoc($agencybunamesql);
		$secagencybulist[] = $agencybuname['bu'];
	}
	$secagencybunames = implode(", ", $secagencybulist);
	//	$secagencybulist = implode(", ", $secagencybures);
	$poolsecagencytable .= "<tr align=\"center\" " . $secagerowclass . ">" .
		"<td>" . $secagencynum . "</td>" .
		"<td>" . $secagencyname . "</td>" .
		"<td>" . $secagencyaddress . "</td>" .
		"<td>" . $secagencyoic . "</td>" .
		"<td>" . $secagencycontact . "</td>" .
		"<td>" . $secagencycontract . "</td>" .
		"<td><a href=\"javascript:void(0)\" style=\"color: blue\" onclick=\"poolAgency('" . $pollsecagencyid . "');\">POOL</a></td>" .
		"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"viewAgencySA('" . $secagencyid . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyname)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyaddress)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyoic)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencycontact)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['license_number'])) . "', '" . $secagencyres['license_issued'] . "', '" . $secagencyres['license_expiration'] . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyprofile)) . "', '" . $secagencyres['contract_status'] . "')\"></td>";
	$secagencynum++;
}

$contractcompliancelist = "";
$cclistsql = mysqli_query($conn, "SELECT * FROM cc_mst");


$budatalist = "";
$butable = "";
$bunumber = 1;
$exprobu = "";
$bulistsql = mysqli_query($conn, "SELECT * FROM bu_mst ORDER BY bu");
while($bulistres = mysqli_fetch_assoc($bulistsql))
{
	$budatalist .= "<option value=\"".$bulistres['id']."\">".$bulistres['bu']."</option>";	
	$bumaingroupsql = mysqli_query($conn, "SELECT * FROM main_groups WHERE id = ". $bulistres['main_group']);
	$bumaingroup = mysqli_fetch_assoc($bumaingroupsql);
	$buregionalsql = mysqli_query($conn, "SELECT * FROM regional_group WHERE id = ". $bulistres['regional_group']);
	$buregionalgroup = mysqli_fetch_assoc($buregionalsql);
	$buclustergroupsql = mysqli_query($conn, "SELECT * FROM cluster_group WHERE id = " . $bulistres['cluster_group']);
	$buclustergroup = mysqli_fetch_assoc($buclustergroupsql);
	if($bulistres['expro'] == 1)
	{
		$exprobu = "Yes";
	}
	else
	{
		$exprobu = "No";
	}
	$butable .= "<tr align=\"center\">" .
				"<td>".$bunumber."</td>" .
				"<td>".$bulistres['bu']."</td>" .
				"<td>".$bulistres['bu_code']."</td>" .
				"<td>".$bumaingroup['name']."</td>" .
				"<td>".$buregionalgroup['name']."</td>" .
				"<td>".$buclustergroup['name']."</td>" .
				"<td>".$exprobu."</td>" .
				"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editBU('" . $bulistres['id'] . "', '" . $bulistres['bu'] . "', '" . $bulistres['bu_code'] . "', '" . $bulistres['main_group'] . "', '" . $bulistres['regional_group'] . "', '" . $bulistres['cluster_group'] . "', '" . $bulistres['expro'] . "', '" . $bulistres['bu_logo'] . "');\"></td>" .				
				"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$bulistres['id']."', 'BUs');\" /></td>" .
				"</tr>";
	$bunumber++;
}

$bugroupdatalist = "";
$bugrouptable = "";
$bugroupnum = 1;
$bugrouplistsql = mysqli_query($conn, "SELECT * FROM main_groups ORDER BY name");
while($bugrouplistres = mysqli_fetch_assoc($bugrouplistsql))
{
	$bugroupdatalist .= "<option value=\"".$bugrouplistres['id']."\">".$bugrouplistres['name']."</option>";
	$bugrouptable .= "<tr align=\"center\">" .
						"<td>".$bugroupnum."</td>" .
						"<td>".$bugrouplistres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editGroup('".$bugrouplistres['id']."', '".$bugrouplistres['name']."', 'Group');\"></td>" .
						"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$bugrouplistres['id']."', 'Groups');\" /></td>" .
					 "</tr>";
	$bugroupnum++;
}

$buregionaldatalist = "";
$buregionaltable = "";
$buregionalnum = 1;
$buregionallistsql = mysqli_query($conn, "SELECT * FROM regional_group ORDER BY name");
while($buregionallistres = mysqli_fetch_assoc($buregionallistsql))
{
	$buregionaldatalist .= "<option value=\"".$buregionallistres['id']."\">".$buregionallistres['name']."</option>";
	$buregionaltable .= "<tr align=\"center\">" .
						"<td>".$buregionalnum."</td>" .
						"<td>".$buregionallistres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editGroup('".$buregionallistres['id']."', '".$buregionallistres['name']."', 'Region');\"></td>" .
						"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$buregionallistres['id']."', 'Regions');\" /></td>" .
					 "</tr>";
	$buregionalnum++;
}

$buclusterdatalist = "";
$buclustertable = "";
$buclusternum = 1;
$buclusterlistsql = mysqli_query($conn, "SELECT * FROM cluster_group ORDER BY name");
while ($buclusterlistres = mysqli_fetch_assoc($buclusterlistsql)) {
	$buclusterdatalist .= "<option value=\"" . $buclusterlistres['id'] . "\">" . $buclusterlistres['name'] . "</option>";
	$buclustertable .= "<tr align=\"center\">" .
		"<td>" . $buclusternum . "</td>" .
		"<td>" . $buclusterlistres['name'] . "</td>" .
		"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editGroup('" . $buclusterlistres['id'] . "', '" . $buclusterlistres['name'] . "', 'Cluster');\"></td>" .
		"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('" . $buclusterlistres['id'] . "', 'Cluster');\" /></td>" .
		"</tr>";
	$buclusternum++;
}

$activityentriesdatalist = "";
$activityentriestable = "";
$activityentriesnum = 1;
$activityentriessql = mysqli_query($conn, "SELECT * FROM entries_activity WHERE expro = 0 ORDER BY name");
while($activityentriesres = mysqli_fetch_assoc($activityentriessql))
{
	$iconcolor = ($activityentriesres['status'] == 'Active') ? "green" : "red";
	$activityentriesdatalist .= "<option value=\"".$activityentriesres['id']."\">".$activityentriesres['name']."</option>";
	$activityentriestable .= "<tr align=\"center\">" .
						"<td>".$activityentriesnum."</td>" .
						"<td>".$activityentriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$activityentriesres['id']."', '".$activityentriesres['name']."', 'Activity');\"></td>" .
						"<td><img src=\"images/activate".$iconcolor.".png\" height=\"20px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$activityentriesres['id']."', 'ActivityInput');\" /></td>".
						// "<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$activityentriesres['id']."', 'ActivityInput');\" /></td>" .
					 "</tr>";
	$activityentriesnum++;
}

$incidententriesdatalist = "";
$incidententriestable = "";
$incidententriesnum = 1;
$incidententriessql = mysqli_query($conn, "SELECT * FROM entries_incident ORDER BY name");
while($incidententriesres = mysqli_fetch_assoc($incidententriessql))
{
	$iconcolor = ($incidententriesres['status'] == 'Active') ? "green" : "red";
	$incidententriesdatalist .= "<option value=\"".$incidententriesres['id']."\">".$incidententriesres['name']."</option>";
	$incidententriestable .= "<tr align=\"center\">" .
						"<td>".$incidententriesnum."</td>" .
						"<td>".$incidententriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries2('".$incidententriesres['id']."');\"></td>" .
						//"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$incidententriesres['id']."', '".$incidententriesres['name']."', 'Incident', '".$incidententriesres['defaultlevel']."', '".$incidententriesres['injury_minor']."', '".$incidententriesres['injury_serious']."', '".$incidententriesres['propertydmg_nc']."', '".$incidententriesres['propertydmg_crit']."', '".$incidententriesres['propertyloss_nc']."', '".$incidententriesres['propertyloss_crit']."','".$incidententriesres['workstoppage']."', '".$incidententriesres['death_1']."', '".$incidententriesres['death_2']."', '".$incidententriesres['death_3']."');\"></td>" .
						//"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$incidententriesres['id']."', 'IncidentInput');\" /></td>" .
						"<td><img src=\"images/activate".$iconcolor.".png\" height=\"20px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$incidententriesres['id']."', 'IncidentInput');\" /></td>" .
					 "</tr>";
	$incidententriesnum++;
}

$exproentriesdatalist = "";
$exproentriestable = "";
$exproentriesnum = 1;
$exproentriessql = mysqli_query($conn, "SELECT * FROM entries_activity WHERE expro = 1 ORDER BY name");
while($exproentriesres = mysqli_fetch_assoc($exproentriessql))
{
	$iconcolor = ($exproentriesres['status'] == 'Active') ? "green" : "red";
	$exproentriesdatalist .= "<option value=\"".$exproentriesres['id']."\">".$exproentriesres['name']."</option>";
	$exproentriestable .= "<tr align=\"center\">" .
						"<td>".$exproentriesnum."</td>" .
						"<td>".$exproentriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$exproentriesres['id']."', '".$exproentriesres['name']."', 'EXPRO');\"></td>" .
						//"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$exproentriesres['id']."', 'EXPROInput');\" /></td>" .
						"<td><img src=\"images/activate".$iconcolor.".png\" height=\"20px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$exproentriesres['id']."', 'EXPROInput');\" /></td>" .
					 "</tr>";
	$exproentriesnum++;
}


$userid = $rowuser['id'];
$userlname = $rowuser['lname'];
$userfname = $rowuser['fname'];
$username = $rowuser['email'];
$userpassword = $rowuser['password'];
$usergender = $rowuser['gender'];
$usercontact = $rowuser['contact'];

$processtotal_time = 0;

if($_POST)
{	
	$processtime = microtime();
	$processtime = explode(' ', $processtime);
	$processtime = $processtime[1] + $processtime[0];
	$processstart = $processtime;
	if((!empty($_POST['addguardstat'])) and ($_POST['addguardstat'] == "Add")){
		$glname = mysqli_real_escape_string($conn, $_POST['txtglname']);
		$gfname = mysqli_real_escape_string($conn, $_POST['txtgfname']);
		$gmname = mysqli_real_escape_string($conn, $_POST['txtgmname']);
		$ggender = $_POST['selggender'];
		$gbirthdate = $_POST['txtgbdate'];
		$gbloodtype = $_POST['selgbloodtype'];
		$gcivstat = $_POST['selgcivstat'];
		$gpreadd = mysqli_real_escape_string($conn, $_POST['txtgpreadd']);
		$gproadd = mysqli_real_escape_string($conn, $_POST['txtgproadd']);
		$gaddcontact = mysqli_real_escape_string($conn, $_POST['txtgcontact']);
		$gbu = $_POST['txtgbu'];		
		$gdateposted = $_POST['txtgposted'];
		$gempagency = $_POST['txtgempagency'];
		$gaddcode = mysqli_real_escape_string($conn, $_POST['txtgcode']);
		$gagency = $_POST['selgagency'];
		$gcategory = mysqli_real_escape_string($conn, $_POST['txtgcategory']);
		$gbadge = mysqli_real_escape_string($conn, $_POST['txtgbadge']);
		//$gsss = mysqli_real_escape_string($conn, $_POST['txtgsss']);
		$glicense = mysqli_real_escape_string($conn, $_POST['txtglicense']);
		$glicenseissue = $_POST['txtglicenseissue'];
		$glicenseexpiry = $_POST['txtglicenseexpiry'];
		$gntclicense = mysqli_real_escape_string($conn, $_POST['txtgntclicense']);
		$gntclicenseissue = $_POST['txtgntclicenseissue'];
		$gntclicenseexpiry = $_POST['txtgntclicenseexpiry'];
		$gperformance = $_POST['selgperformance'];
		$gcomment = mysqli_real_escape_string($conn, $_POST['gcomment']);
		mysqli_query($conn,"INSERT INTO guard_personnel(fname, mname, lname, gender, birthdate, blood_type, civil_status, present_address, provincial_address, contact, bu, date_posted, agency_employment, guard_code, agency, guard_category, badge_number, license_number, license_issue_date, license_expiry_date, ntc_license, ntc_license_start, ntc_license_end, performance, comment, status, date_created) values('".$gfname."', '".$gmname."', '".$glname."', '".$ggender."', '".$gbirthdate."', '".$gbloodtype."',  '".$gcivstat."', '".$gpreadd."', '".$gproadd."', '".$gaddcontact."', '".$gbu."', '".$gdateposted."', '".$gempagency."', '".$gaddcode."', '".$gagency."', '".$gcategory."', '".$gbadge."', '".$glicense."', '".$glicenseissue."', '".$glicenseexpiry."', '".$gntclicense."', '".$gntclicenseissue."', '".$gntclicenseexpiry."', '".$gperformance."', '".$gcomment."', 'Active', now())");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added guard ".$glname.", ".$gfname." ".$gmname."', now(), ".$gbu.")");
		$get_last_guardid = mysqli_fetch_array(mysqli_query($conn, "Select id from guard_personnel order by id desc"));
		$lguardid = $get_last_guardid['id'];			
			// foreach($_FILES['guardpic']['name'] as $guardpic){
			  // if($guardpic == ""){
			  // $guardpath = "" ;
			  // }else{
			  // $guardpath =  "guardphotos/".$lguardid."-".$guardpic;
			  // }
			  // mysqli_query($conn, "update guard_personnel set guard_photo = '$guardpath' where id = $lguardid");
			  // @copy($_FILES['guardpic']['tmp_name'][0],$guardpath);			  
			// }
		$handle = new upload($_FILES['guardpic']);
			if ($handle->uploaded) {
					$handle->file_new_name_body   = 'guardpic_'. $gaddid;
					$handle->image_resize         = true;
					$handle->image_x              = 150;
					$handle->image_ratio_y        = true;
					$handle->file_overwrite = true;
					$handle->process('guardphotos/');
					if ($handle->processed) {
					//echo 'image resized';
					mysqli_query($conn, "update guard_personnel set guard_photo = 'guardphotos/".$handle->file_dst_name."' where id = $lguardid") or die(mysqli_error($conn));
					$handle->clean();

					} else {
					echo 'error : ' . $handle->error;
					}
			}
		header("Location: user-superadmin.php?last=GuardMgt");
		;
	} 
	elseif ((!empty($_POST['bidding_name'])) and (!empty($_POST['txtbiddingCluster'])) and (!empty($_POST['txtBiddingRequirements']))) {
		$biddingName = mysqli_real_escape_string($conn, $_POST['bidding_name']);
		$biddingCluster = $_POST['txtbiddingCluster'];
		$biddingRequirements = $_POST['txtBiddingRequirements'];
		$biddingMessage = mysqli_real_escape_string($conn, $_POST['txtBiddingMessage']);

		mysqli_query($conn, "INSERT INTO bidding (bidding_name, bidding_status, created_at, cluster_id, bidding_requirement_id) VALUES('" . $biddingName . "', 'Nomination', '" . date("Y-m-d") . "', '" . $biddingCluster . "', '" . $biddingRequirements . "')");
		if (!empty($biddingMessage)) {
			$clusterReceiver = '';
			$getReceiverOfClusterQuery = mysqli_query($conn, "SELECT users_mst.user_email FROM `users_mst` INNER JOIN bu_mst ON users_mst.bu = bu_mst.id WHERE bu_mst.cluster_group = " . $biddingCluster);
			while ($getReceiverOfCluster = mysqli_fetch_assoc($getReceiverOfClusterQuery)) {
				$clusterReceiver .= $getReceiverOfCluster['user_email'] . ',';
			}

			$mail = send_bidding_invitation($clusterReceiver, $biddingMessage);
		}

		header("Location: user-superadmin.php?last=Bidding");
	}
	elseif((!empty($_POST['editguardstat'])) and ($_POST['editguardstat'] == "Edit")){
		$glname = mysqli_real_escape_string($conn, $_POST['txtglname']);
		$gfname = mysqli_real_escape_string($conn, $_POST['txtgfname']);
		$gmname = mysqli_real_escape_string($conn, $_POST['txtgmname']);
		$ggender = $_POST['selggender'];
		$gbirthdate = $_POST['txtgbdate'];
		$gbloodtype = $_POST['selgbloodtype'];
		$gcivstat = $_POST['selgcivstat'];
		$gpreadd = mysqli_real_escape_string($conn, $_POST['txtgpreadd']);
		$gproadd = mysqli_real_escape_string($conn, $_POST['txtgproadd']);
		$gaddcontact = mysqli_real_escape_string($conn, $_POST['txtgcontact']);
		$gbu = $_POST['txtgbu'];
		$gstat = $_POST['selgstat'];
		$gdateposted = $_POST['txtgposted'];
		$gempagency = $_POST['txtgempagency'];
		$gaddcode = mysqli_real_escape_string($conn, $_POST['txtgcode']);
		$gagency = $_POST['selgagency'];
		$gcategory = mysqli_real_escape_string($conn, $_POST['txtgcategory']);
		$gbadge = mysqli_real_escape_string($conn, $_POST['txtgbadge']);
		//$gsss = mysqli_real_escape_string($conn, $_POST['txtgsss']);
		$glicense = mysqli_real_escape_string($conn, $_POST['txtglicense']);
		$glicenseissue = $_POST['txtglicenseissue'];
		$glicenseexpiry = $_POST['txtglicenseexpiry'];
		$gperformance = $_POST['selgperformance'];
		$gaddid = $_POST['txtguardid'];
		$gcomment = mysqli_real_escape_string($conn, $_POST['gcomment']);
		mysqli_query($conn,"UPDATE guard_personnel SET fname = '".$gfname."', mname = '".$gmname."', lname = '".$glname."', gender = '".$ggender."', birthdate = '".$gbirthdate."', blood_type = '".$gbloodtype."', civil_status = '".$gcivstat."', present_address = '".$gpreadd."', provincial_address = '".$gproadd."', contact = '".$gaddcontact."', bu = '".$gbu."', status = '".$gstat."', date_posted = '".$gdateposted."', agency_employment = '".$gempagency."', guard_code = '".$gaddcode."', agency = '".$gagency."', guard_category = '".$gcategory."', badge_number = '".$gbadge."', license_number = '".$glicense."', license_issue_date = '".$glicenseissue."', license_expiry_date = '".$glicenseexpiry."', ntc_license = '".$gntclicense."', ntc_license_start = '".$gntclicenseissue."', ntc_license_end = '".$gntclicenseexpiry."', performance = '".$gperformance."', comment = '".$gcomment."' WHERE id = $gaddid ") or die(mysqli_error($conn));
		// foreach($_FILES['guardpic']['name'] as $guardpic){
			  // if($guardpic == ""){
			  
			  // }else{
			  // $guardpath =  "guardphotos/".$gaddid."-".$guardpic;
			  // mysqli_query($conn, "update guard_personnel set guard_photo = '$guardpath' where id = $gaddid");
			  // @copy($_FILES['guardpic']['tmp_name'][0],$guardpath);
			  // }
			  			  
			// }
		$handle = new upload($_FILES['guardpic']);
			if ($handle->uploaded) {
				  $handle->file_new_name_body   = 'guardpic_'. $gaddid;
				  $handle->image_resize         = true;
				  $handle->image_x              = 150;
				  $handle->image_ratio_y        = true;
				  $handle->file_overwrite = true;
				  $handle->process('guardphotos/');
				  if ($handle->processed) {
					//echo 'image resized';
					mysqli_query($conn, "update guard_personnel set guard_photo = 'guardphotos/".$handle->file_dst_name."' where id = $gaddid") or die(mysqli_error($conn));
					$handle->clean();
					
				  } else {
					echo 'error : ' . $handle->error;
				  }
			}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited guard ".$glname.", ".$gfname." ".$gmname."', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
		header("Location: user-superadmin.php?last=GuardMgt") ;
	}
	elseif(!empty($_POST['btnsaveoic']))
	{
		$oiclname = mysqli_real_escape_string($conn,$_POST['oiclastname']);
		$oicfname = mysqli_real_escape_string($conn,$_POST['oicfirstname']);
		$oicmname = mysqli_real_escape_string($conn,$_POST['oicmiddlename']);
		$oicemail = mysqli_real_escape_string($conn,$_POST['oicemail']);
		$oiccontact = mysqli_real_escape_string($conn,$_POST['oiccontact']);
		mysqli_query($conn, "INSERT INTO oic_mst (fname, mname, lname, email_ad, mobile, bu, slevel) VALUES('".$oicfname."', '".$oicmname."', '".$oiclname."', '".$oicemail."', '".$oiccontact."', '".$_POST['oicbu']."', '".$_POST['oicslevel']."')");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added security alert recipient ".$oiclname.", ".$oicfname." ".$oicmname."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=SecAlert");
	}
	elseif(!empty($_POST['btneditoic']))
	{
		$oiclname = mysqli_real_escape_string($conn,$_POST['oiclastname']);
		$oicfname = mysqli_real_escape_string($conn,$_POST['oicfirstname']);
		$oicmname = mysqli_real_escape_string($conn,$_POST['oicmiddlename']);
		$oicemail = mysqli_real_escape_string($conn,$_POST['oicemail']);
		$oiccontact = mysqli_real_escape_string($conn,$_POST['oiccontact']);
		$oicid = mysqli_real_escape_string($conn,$_POST['oicid']);
		mysqli_query($conn, "UPDATE oic_mst SET fname = '".$oicfname."', mname = '".$oicmname."', lname = '".$oiclname."', email_ad = '".$oicemail."', mobile = '".$oiccontact."', bu = '".$_POST['oicbu']."', slevel = '".$_POST['oicslevel']."' WHERE id = ". $oicid);
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited security alert recipient ".$oiclname.", ".$oicfname." ".$oicmname."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=SecAlert");
	} 
	elseif (!empty($_POST['btnsaveuser'])) {
		$adduserlname = mysqli_real_escape_string($conn, $_POST['userslastname']);
		$adduserfname = mysqli_real_escape_string($conn, $_POST['usersfirstname']);
		$addusermi = mysqli_real_escape_string($conn, $_POST['usersmi']);
		$addusergender = $_POST['selugender'];
		$adduserusername = mysqli_real_escape_string($conn, $_POST['usersusername']);
		$adduseremail = mysqli_real_escape_string($conn, $_POST['user_email']);
		$adduserbu = (($_POST['seluserbu']) ? $_POST['seluserbu'] : 0);
		$adduserlevel = $_POST['selaccess'];
		$addusercontact = mysqli_real_escape_string($conn, $_POST['userscontact']);
		$adduserpass = "password" . date("Y");
		mysqli_query($conn, "INSERT INTO users_mst(fname, mi, lname, bu, level, email, user_email, status, date_created, gender, contact, changepass, password) VALUES('" . $adduserfname . "', '" . $addusermi . "', '" . $adduserlname . "', '" . $adduserbu . "', '" . $adduserlevel . "', '" . $adduserusername . "', '" . $adduseremail . "', 'Active', now(), '" . $addusergender . "', '" . $addusercontact . "', 1, '" . md5($adduserpass) . "')") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('" . $_SESSION['id'] . "', 'Added user " . $adduserlname . ", " . $adduserfname . " " . $addusermi . "', now(), " . $_SESSION['bu'] . ")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Users");
	} 
	elseif (!empty($_POST['btnedituser'])) {
		$adduserlname = mysqli_real_escape_string($conn, $_POST['userslastname']);
		$adduserfname = mysqli_real_escape_string($conn, $_POST['usersfirstname']);
		$addusermi = mysqli_real_escape_string($conn, $_POST['usersmi']);
		$addusergender = $_POST['selugender'];
		$adduserusername = mysqli_real_escape_string($conn, $_POST['usersusername']);
		$adduseremail = mysqli_real_escape_string($conn, $_POST['user_email']);
		$adduserlevel = $_POST['selaccess'];
		$addusercontact = mysqli_real_escape_string($conn, $_POST['userscontact']);
		$adduserid = $_POST['usersid'];
		$adduserbu = $_POST['seluserbu'];
		mysqli_query($conn, "UPDATE users_mst SET fname='" . $adduserfname . "', mi='" . $addusermi . "', lname='" . $adduserlname . "', bu='" . $adduserbu . "', level='" . $adduserlevel . "', email='" . $adduserusername . "', user_email='" . $adduseremail . "', status='Active', date_created=now(), gender='" . $addusergender . "', contact='" . $addusercontact . "' WHERE id='" . $adduserid . "' ") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('" . $_SESSION['id'] . "', 'Updated user " . $adduserlname . ", " . $adduserfname . " " . $addusermi . "', now(), " . $_SESSION['bu'] . ")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Users");
	} 
	elseif(!empty($_POST['btndisporev'])){
		$newdisposition = mysqli_real_escape_string($conn, $_POST['txtdisporev']);
		$dispoticketid = $_POST['hidticketid'];
		date_default_timezone_set('Asia/Manila');
		$datenow = date('Y-m-d H:i:s');
		mysqli_query($conn, "INSERT INTO disposition_revisions(disposition, ticket_id, user_id, edit_date) VALUES('".$newdisposition."', '".$dispoticketid."', '".$_SESSION['id']."', '".$datenow."')") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited disposition of ticket #".$adduserid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
		header("Location: user-admin.php?last=Incidents");
	}
	elseif((isset($_POST['txturc'])) && !empty($_POST['txturc']))
	{
		if((isset($_POST['txtOrigin'])) && !empty($_POST['txtOrigin']))
		{
			$gid = $_POST['txtguard'];
			$locid = $_POST['txtlocation'];
			$origin = $_POST['txtOrigin'];
			if($origin==1){
				$ticketdescription = mysqli_real_escape_string($conn, $_POST['ticketName2']);
				$ticketdateadded = $_POST['ticketDate2'];
				mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted, location, responding_guard) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 1, now(), '".$locid."', '".$gid."')");
				$get_last_id2 = mysqli_fetch_array(mysqli_query($conn, "Select id from ticket order by id desc"));
				$ticket = $get_last_id2['id'];
				mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Created incident ticket #".$ticket."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
			}
			elseif($origin==0){
				$ticket = $_POST['txtLogId'];
			}
		}
			$gid = $_POST['txtguard'];
			$locid = $_POST['txtlocation'];
			$uid = $_SESSION['id'];
			$urcid = $_POST['txturc'];
			$date_created = $_POST['date'];
			$time_created = $_POST['time'];
			$remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
			$log_type = $_POST['txtLogType'];
			$oic = (!empty($_POST['sendtobu']))? $_POST['sendtobu']:0;
			
			mysqli_query($conn, "insert into log_mst(uid, urcid, date_created, time_created, gid, remarks, bu, main_group, regional_group, location, ticket, oic, datesubmitted) values('".$uid."','".$urcid."','".$date_created."','".$time_created."','".$gid."','".$remarks."','".$bu."','".$rowUrl['main_group']."','".$rowUrl['regional_group']."','".$locid."','".$ticket."',".$oic.",now())") or die(mysqli_error());
			
			//$lid = mysqli_insert_id();
			$get_last_id = mysqli_fetch_array(mysqli_query($conn, "Select id from log_mst order by id desc"));
			$lid = $get_last_id['id'];
			//system log
			//logbook($_SESSION['id'], "Added entry to logbook");
			mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added log entry #".$lid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
			
			$i=1;
			$i2=0;
			foreach($_FILES['attach']['name'] as $attach){
			  if($attach == ""){
			  $path = "" ;
			  }else{
			  $path =  "upload/".$lid."-".$attach;
			  }
			  mysqli_query($conn, "update log_mst set upload$i = '$path' where id = $lid");
			  @copy($_FILES['attach']['tmp_name'][$i2],$path);
			  $i++;
			  $i2++;
			}
			$mailtest = "NotApplicable";
			$alertdesc = "";
			if($oic==1)
			{
				$sqlemailticket = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$ticket);
				$resemailticket = mysqli_fetch_assoc($sqlemailticket);
				$sqlemaillog = mysqli_query($conn, "SELECT l.date_created, l.time_created, b.bu, b.bu_code, lc.location_code, lc.location, l.remarks, g.lname AS glname, g.fname AS gfname, g.mname AS gmname, l.upload1, l.upload2, l.upload3, u.fname AS ufname, u.mi AS umi, u.lname AS ulname, ur.codes AS urccode, ur.description AS urcdesc FROM log_mst l LEFT JOIN bu_mst b ON l.bu = b.id LEFT JOIN location_mst lc ON l.location = lc.id LEFT JOIN guard_personnel g ON l.gid = g.id LEFT JOIN users_mst u ON l.uid = u.id LEFT JOIN urc_mst ur ON l.urcid = ur.id WHERE l.id = ".$lid);
				$resemaillog = mysqli_fetch_assoc($sqlemaillog);
				
				if($resemailticket['ticket_type'] == 1)
				{
					$sqldesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$resemailticket['description']);
					$resdesc = mysqli_fetch_assoc($sqldesc);
					$alertdesc = "INCIDENT";
				}
				elseif($resemailticket['ticket_type'] == 2)
				{
					$sqldesc = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ".$resemailticket['description']);
					$resdesc = mysqli_fetch_assoc($sqldesc);
					$alertdesc = "ACTIVITY";
				}
				
				$what = "";
				if($resdesc['name'])
				{
					$what = $resdesc['name'];
				}
				else
				{
					$what = $resemailticket['description'];
				}
				
				$bucontrolnum = $resemaillog['bu_code'].'-'.str_replace("-", "", $resemailticket['dateadded']).'-'.$resemailticket['id'];
				$emaildatecreated = strtotime($resemaillog['date_created']);
				$emaildatecreated2 = date('j F Y', $emaildatecreated);
				
				// $upload1 = '<a href="'.$url_base.'/'.$resemaillog['upload1'].'">'.$resemaillog['upload1'].'</a>';
				// $upload2 = '<a href="'.$url_base.'/'.$resemaillog['upload2'].'">'.$resemaillog['upload2'].'</a>';
				// $upload3 = '<a href="'.$url_base.'/'.$resemaillog['upload3'].'">'.$resemaillog['upload3'].'</a>';
				$upload1 = $resemaillog['upload1'];
				$upload2 = $resemaillog['upload2'];
				$upload3 = $resemaillog['upload3'];
				
				$to = "";
				// $recipients = array();
				// $sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$resemailticket['bu']);
				// while($resoic = mysqli_fetch_assoc($sqloic))
				// {
					// $recipients[] = $resoic['email_ad'];
				// }
					
					// $to = implode(", ", $recipients);
					$subject = 'SECURITY ALERT: '.$what.' '.$bucontrolnum;
					$narrative = preg_replace( "/\r|\n/", "<br>", $resemaillog['remarks'] );
					$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
									<tr align="center">
										<td colspan="100%" align="center">
											<h2>'.$alertdesc.' REPORT</h2>
										</td>
									</tr>
									<tr>
										<td colspan="100%">
											<table align="center" width="80%" style="border-collapse:collapse;" cellpadding="5px" >                                           											
												<tr>                          
													<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >WHAT:</td>
													<td style=" padding-left:20px; padding-right:20px;" >'.$what.'</td>
												</tr>
												<tr>                          
													<td width="15%" style="text-align: right; font-weight: bold;">WHERE:</td>
													<td style=" padding-left:20px; padding-right:20px;">'.$resemaillog['bu'].' -> '.$resemaillog['location'].'</td>
												</tr>                      
												<tr>                          
													<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
													<td style=" padding-left:20px; padding-right:20px;"> '.$resemaillog['time_created'].', '.$emaildatecreated2.'</td>
												</tr>
												<tr>
													<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">NARRATIVE:</td>
													<td style=" padding-left:20px; padding-right:20px;"> '.$narrative.'</td>
												</tr>											  
												<tr>
													<td width="15%" style="text-decoration:underline; text-align: right;">Reported by:</td>
													<td style=" padding-left:20px; padding-right:20px;">'.$resemaillog['glname'].', '.$resemaillog['gfname'].' '.$resemaillog['gmname'].'</td>
												</tr>
												<tr>
													<td width="15%" style="text-decoration:underline; text-align: right;">Encoded by:</td>
													<td style=" padding-left:20px; padding-right:20px;">'.$resemaillog['ulname'].', '.$resemaillog['ufname'].' '.$resemaillog['umi'].'</td>
												</tr>												
											</table>
										</td>
									</tr>
								 </table>';
					
					$headers  = "MIME-Version: 1.0 " . "\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
					$headers .= "From: INHOUSE SECURITY ALERT <no-reply@aboitiz.com>";
									
					// Mail it
					
				$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$resemailticket['bu']);	
				while($resoic = mysqli_fetch_assoc($sqloic))
				{					
					//$mail = send_mail($resoic['email_ad'],$subject,$mainbody);
					$mail = send_mail2($resoic['email_ad'],$subject,$mainbody,$upload1,$upload2,$upload3);
					if($mail)
						{
							$mailtest = "SUCCESS";
						}
						else
						 {
							 $mailtest = "FAILED";
						 }
				}
					// if (!empty($to))
					// {
						// ini_set("SMTP","192.168.2.54");
						// ini_set("smtp_port","25");
						// $mail = @mail($to, $subject, $mainbody, $headers);
						
						// mail($to, $subject, $mainbody, $headers);
						// if($mail)
						// {
							// $mailtest = "SUCCESS";
						// }
						// else
						// {
							// $mailtest = "FAILED";
						// }
					// }
				
			}
			if($log_type==1){				
				header("Location: user-superadmin.php?last=Incidents&mail=".$mailtest);
			}
			elseif($log_type==2){
				header("Location: user-superadmin.php?last=Activities&mail=".$mailtest);
			}		
	}
	elseif((isset($_POST['txtactivityname'])) && !empty($_POST['txtactivityname']))
	{
		$ticketdescription = mysqli_real_escape_string($conn, $_POST['txtactivityname']);
		$ticketdateadded = $_POST['txtactivitydate'];
		mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 2, now())");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Created activiy ticket', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Activities");
	}
	elseif((isset($_POST['txtaddlocationcodes'])) && !empty($_POST['txtaddlocationcodes']))
	{
		$codes = explode("*~", $_POST['txtaddlocationcodes']);
		$locations = explode("*~", $_POST['txtaddlocations']);
		$bulocations = explode("*~", $_POST['txtaddlocationbus']);
		for($i=1, $count = count($codes);$i<$count;$i++) {
			mysqli_query($conn, "INSERT INTO location_mst(location_code, location, bu) VALUES('". mysqli_real_escape_string($conn,$codes[$i]) ."', '". mysqli_real_escape_string($conn, $locations[$i]) ."', ". $bulocations[$i] .")");
		}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added location', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Locs");
	}
	elseif((isset($_POST['txtaddlocationcode'])) && !empty($_POST['txtaddlocationcode']))
	{
		$editlocationcode = mysqli_real_escape_string($conn,$_POST['txtaddlocationcode']);
		$editlocation = mysqli_real_escape_string($conn,$_POST['txtaddlocation']);
		$editlocationid = mysqli_real_escape_string($conn,$_POST['txtaddlocationid']);
		mysqli_query($conn, "UPDATE location_mst SET location_code = '". $editlocationcode ."', location = '". $editlocation ."' WHERE id = ". $editlocationid."");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited a location', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Locs");
	}
	//elseif((isset($_POST['txtincidentname'])) && !empty($_POST['txtincidentname']))
//	{
//		$ticketdescription = mysqli_real_escape_string($conn, $_POST['txtincidentname']);
//		$ticketdateadded = $_POST['txtincidentdate'];
//		mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 1, now())");
//		header("Location: user-superadmin.php?last=Incidents");
//	}
	elseif((isset($_POST['newpass'])) && !empty($_POST['newpass']))
	{
		$newpass = mysqli_real_escape_string($conn, $_POST['newpass']);
		mysqli_query($conn, "UPDATE users_mst SET password = '". md5($newpass) ."' WHERE id = ". $userid);
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Changed password', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Profile");		
	}
	elseif((isset($_POST['usercontactnew'])) && !empty($_POST['usercontactnew']))
	{
		$newcontact = mysqli_real_escape_string($conn, $_POST['usercontactnew']);
		mysqli_query($conn, "UPDATE users_mst SET contact = '". $newcontact ."' WHERE id = ". $userid);
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Changed contact number', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
		header("Location: user-superadmin.php?last=Profile");
	}
	//elseif((isset($_POST['witfname'])) && !empty($_POST['witfname']))
//				{
//				$wFirstName = mysqli_real_escape_string($conn, $_POST['witfname']);
//				$wMiddleName = mysqli_real_escape_string($conn, $_POST['witmname']);
//				$wLastName = mysqli_real_escape_string($conn, $_POST['witlname']);
//				$wRemark = mysqli_real_escape_string($conn, $_POST['witremarks']);
//				$wAddress = mysqli_real_escape_string($conn, $_POST['witadd']);
//				$wAge = mysqli_real_escape_string($conn, $_POST['witage']);
//				$wGender = mysqli_real_escape_string($conn, $_POST['witgender']);
//				$wHeight = mysqli_real_escape_string($conn, $_POST['witheight']);
//				$wWeight = mysqli_real_escape_string($conn, $_POST['witweight']);
//				$swid = $_POST['swid'];
//				$witsql = "INSERT INTO incident_witness(FirstName, MiddleName, LastName, Remark, logId, dateCreated, Address, Age, Gender, Height, Weight) values('". $wFirstName. "', '". $wMiddleName ."', '". $wLastName ."', '". $wRemark ."', ". $swid .", now(), '". $wAddress ."', ". $wAge .", '". $wGender ."', ". $wHeight .", ". $wWeight .")";
//				mysqli_query($conn, $witsql) or die(mysqli_error());
//				mysqli_query($conn, "INSERT INTO incident_witness(FirstName, MiddleName, LastName, Remark, logId, dateCreated, Address, Age, Gender, Height, Weight) values('".$wFirstName."', '".$wMiddleName."', '".$wLastName."', '".$wRemark."', ".$swid.", now(), '".$wAddress."', '".$wAge."', '".$wGender."', '".$wHeight."', '".$wWeight."')") or die(mysqli_error());
//					if($_POST['syesno'] == 1){
//						$sFirstName = mysqli_real_escape_string($conn, $_POST['suspfname']);
//						$sMiddleName = mysqli_real_escape_string($conn, $_POST['suspmname']);
//						$sLastName = mysqli_real_escape_string($conn, $_POST['susplname']);
//						$sRemark = mysqli_real_escape_string($conn, $_POST['suspremarks']);
//						$sAddress = mysqli_real_escape_string($conn, $_POST['suspadd']);
//						$sAge = mysqli_real_escape_string($conn, $_POST['suspage']);
//						$sGender = mysqli_real_escape_string($conn, $_POST['suspgender']);
//						$sHeight = mysqli_real_escape_string($conn, $_POST['suspheight']);
//						$sWeight = mysqli_real_escape_string($conn, $_POST['suspweight']);
//						mysqli_query($conn, "INSERT INTO incident_suspect(FirstName, MiddleName, LastName, Remark, logId, dateCreated, Address, Age, Gender, Height, Weight) values('$sFirstName', '$sMiddleName', '$sLastName', '$sRemark', ". $swid .", now(), '$sAddress', $sAge, '$sGender', $sHeight, $sWeight)");
//					}
//					mysqli_query($conn, "UPDATE ticket SET is_open = 0 WHERE id = ". $swid);
//					header("Location: user-superadmin.php?last=Incidents");
//				}
	//elseif($_POST['btnsaveagency'])
	elseif((isset($_POST['txtagencyname'])) && !empty($_POST['txtagencyname']))
	{
		$addagencyname = mysqli_real_escape_string($conn, $_POST['txtagencyname']);
		$addagencyaddress = mysqli_real_escape_string($conn, $_POST['txtagencyaddress']);
		$addagencyoic = mysqli_real_escape_string($conn, $_POST['txtagencyoic']);
		$addagencycontact = mysqli_real_escape_string($conn, $_POST['txtagencycontact']);
		$addagencylicensenum = mysqli_real_escape_string($conn, $_POST['txtagencylicensenum']);
		$addagencylicenseissue = $_POST['txtagencylicenseissue'];
		$addagencylicenseexpiry = $_POST['txtagencylicenseexpiry'];
		$addagencyprofile = mysqli_real_escape_string($conn, $_POST['txtagencyprofile']);
		$addagencycontractstat = $_POST['selcontractstat'];
		$addagencytype = $_POST['txtagencyaddedit'];
		$get_last_agency = mysqli_fetch_array(mysqli_query($conn, "Select id from agency_mst order by id desc"));
		
		if($addagencytype == "edit")
		{
			mysqli_query($conn, "UPDATE agency_mst SET agency_name = '".$addagencyname."', address = '".$addagencyaddress."', oic = '".$addagencyoic."', contact_number = '".$addagencycontact."', license_number = '".$addagencylicensenum."', license_issued = '".$addagencylicenseissue."', license_expiration = '".$addagencylicenseexpiry."', company_profile = '".$addagencyprofile."', contract_status = '".$addagencycontractstat."' WHERE id = '".$_POST['txtagencyid']."'");
			mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Updated agency ".$addagencyname."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
			$lastagency = $_POST['txtagencyid'];
		}
		else
		{
		  mysqli_query($conn, "INSERT INTO agency_mst(agency_name, address, oic, contact_number, license_number, license_issued, license_expiration, company_profile, contract_status) values('".$addagencyname."', '".$addagencyaddress."', '".$addagencyoic."', '".$addagencycontact."', '".$addagencylicensenum."', '".$addagencylicenseissue."', '".$addagencylicenseexpiry."', '".$addagencyprofile."', '".$addagencycontractstat."')");
		  mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added agency ".$addagencyname."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		  $lastagency = $get_last_agency['id'];
		}
						
		$addagencybuall = explode("*~", $_POST['txtagencybunameall']);
		$addagencybustartall = explode("*~", $_POST['txtagencybustartall']);
		$addagencybuendall = explode("*~", $_POST['txtagencybuendall']);
		
		if($addagencybuall)
		{
			for($i=1, $count = count($addagencybuall);$i<$count;$i++)
			{
				mysqli_query($conn, "INSERT INTO agency_bu(agency_id, bu_id, start, end) VALUES('".$lastagency."', '". mysqli_real_escape_string($conn, $addagencybuall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencybustartall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencybuendall[$i]) ."')");
			}

		}
		
		$addagencyclientall = explode("*~", $_POST['txtagencyclientall']);
		$addagencyclientstartall = explode("*~", $_POST['txtagencyclientstartall']);
		$addagencyclientendall = explode("*~", $_POST['txtagencyclientendall']);
		if($addagencyclientall)
		{
		  for($i=1, $count = count($addagencyclientall);$i<$count;$i++)
			  {
				  mysqli_query($conn, "INSERT INTO agency_clients(agency_id, client_name, start, end) VALUES('".$lastagency."', '". mysqli_real_escape_string($conn, $addagencyclientall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencyclientstartall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencyclientendall[$i]) ."')");
			  }
		}
		
		$addagencyremarkdateall = explode("*~", $_POST['txtagencyremarkdateall']);
		$addagencyremarkall = explode("*~", $_POST['txtagencyremarkall']);
		if($addagencyremarkall)
		{
		  for($i=1, $count = count($addagencyremarkall);$i<$count;$i++)
			  {
				  mysqli_query($conn, "INSERT INTO agency_remarks(agency_id, remarks_date, remarks) VALUES('".$lastagency."', '". mysqli_real_escape_string($conn, $addagencyremarkdateall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencyremarkall[$i]) ."')");
			  }
		}
		
		$addagencylicensetypeall = explode("*~", $_POST['txtagencylicensetypeall']);
		$addagencylicensenumall = explode("*~", $_POST['txtagencylicensenumall']);
		$addagencylicensestartall = explode("*~", $_POST['txtagencylicensestartall']);
		$addagencylicenseendall = explode("*~", $_POST['txtagencylicenseendall']);
		$catch = 0;
		if($addagencylicensetypeall)
		{
			/* $catch=5;
			$uploadArray = array();
			$i2=0;
			$i=1;
			if($_FILES['licenseattach']['name'])
			{
				$catch = 3;
			}
			foreach($_FILES['licenseattach']['name'] as $attach)			
			{
				$catch = 2;
				if($attach == ""){
					$path = "" ;
				}
				else{
					$path =  "licenses/".$lastagency."-".$attach;
				}
					
				if($path)
				{
					mysqli_query($conn, "INSERT INTO license_mst(agency_id, license_type, license_number, issue_date, expiry_date, pdf_file) VALUES('".$lastagency."', '". mysqli_real_escape_string($conn, $addagencylicensetypeall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencylicensenumall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencylicensestartall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencylicenseendall[$i]) ."', '".$path."')");
					
				}
				@copy($_FILES['licenseattach']['tmp_name'][$i2],$path);		
				$i2++;
				$i++;
			} */
			for($i=1, $count = count($addagencylicensetypeall);$i<$count;$i++)
			{
				mysqli_query($conn, "INSERT INTO license_mst(agency_id, license_type, license_number, issue_date, expiry_date) VALUES('".$lastagency."', '". mysqli_real_escape_string($conn, $addagencylicensetypeall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencylicensenumall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencylicensestartall[$i]) ."', '". mysqli_real_escape_string($conn, $addagencylicenseendall[$i]) ."')")  or die(mysqli_error($conn));
			}
			$catch=1;
		}
		
		header("Location: user-superadmin.php?last=SecAgency&catch=".$catch);		
	}
	elseif(!empty($_POST['btnAddPDFlicense']))
	{
		/* if($_POST['addpdftype'] == 1)
		{
			$unlinksql = mysqli_query($conn, "SELECT * FROM license_mst WHERE id = ".$_POST['addpdfid']);
			$unlinkres = mysqli_fetch_assoc($unlinksql);
			unlink($unlinkres['pdf_file']);
		} */
		$i2=0;
		$catch = "start";
		foreach($_FILES['licenseattach1']['name'] as $attach)			
		{
			if($attach == ""){
				$path = "" ;
			}
			else{
				$path =  "licenses/".$_POST['addpdfid']."-".$attach;
			}
				
			if($path)
			{
				if($_POST['addpdftype'] == 1)
				{
					$unlinksql = mysqli_query($conn, "SELECT * FROM license_mst WHERE id = ".$_POST['addpdfid']);
					$unlinkres = mysqli_fetch_assoc($unlinksql);
					unlink($unlinkres['pdf_file']);
				}
				elseif($_POST['addpdftype'] == 2)
				{
					$unlinksql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE id = ".$_POST['addpdfid']);
					$unlinkres = mysqli_fetch_assoc($unlinksql);
					unlink($unlinkres['pdf_file']);
				}
				if(@copy($_FILES['licenseattach1']['tmp_name'][$i2],$path))
				{
					if($_POST['addpdftype'] <= 1)
					{
						mysqli_query($conn, "UPDATE license_mst SET license_number = '".$_POST['addAgencyLicenseNumber']."', issue_date = '".$_POST['addAgencyLicenseStartDate']."', expiry_date = '".$_POST['addAgencyClientEndDate']."', pdf_file = '".$path."' WHERE id = ".$_POST['addpdfid']);
						$catch = "uploadsuccess";
					}
					else
					{
						mysqli_query($conn, "UPDATE agency_bu SET start = '".$_POST['addAgencyClientStartDate']."', end = '".$_POST['addAgencyClientEndDate']."', pdf_file = '".$path."' WHERE id = ".$_POST['addpdfid']);
						$catch = "uploadsuccess";
					}
				}
				else
				{					
					$catch = "uploadfail ".$_FILES['userfile']['error'];
				}
			}
			else
			{
				if($_POST['addpdftype'] == 2)
				{
					mysqli_query($conn, "UPDATE agency_bu SET start = '".$_POST['addAgencyClientStartDate']."', end = '".$_POST['addAgencyClientEndDate']."' WHERE id = ".$_POST['addpdfid']);
				}
				elseif($_POST['addpdftype'] == 1)
				{
					mysqli_query($conn, "UPDATE license_mst SET license_number = '".$_POST['addAgencyLicenseNumber']."', issue_date = '".$_POST['addAgencyLicenseStartDate']."', expiry_date = '".$_POST['addAgencyClientEndDate']."' WHERE id = ".$_POST['addpdfid']);
				}
				$catch = "catchelse";
			}
			//@copy($_FILES['licenseattach1']['tmp_name'][$i2],$path);		
			$i2++;
			$i++;
			
			header("Location: user-superadmin.php?last=SecAgency&catch=".$catch);
		}
	}
	elseif(isset($_POST['multiplebuall']) && !empty($_POST['multiplebuall']))
	{
		$addbu = explode("*~", $_POST['multiplebuall']);
		$addid = $_POST['multiplebuid'];
		for($i=1, $count = count($addbu);$i<$count;$i++)
		{
			mysqli_query($conn, "INSERT INTO users_bu(login_id, bu_id) VALUES(".$addid.", ".$addbu[$i].")") or die(mysqli_error($conn));
		}
		header("Location: user-superadmin.php?last=Users");		
	}
	elseif((isset($_POST['txtaddcodecodeall'])) && !empty($_POST['txtaddcodecodeall']))
	{
		$addcode = explode("*~", $_POST['txtaddcodecodeall']);
		$addcodedesc = explode("*~", $_POST['txtaddcodedescall']);
		$addcodeseries = $_POST['txtaddcodeseries'];
		for($i=1, $count = count($addcode);$i<$count;$i++) {
			mysqli_query($conn, "INSERT INTO urc_mst(codes, description, series) VALUES('". mysqli_real_escape_string($conn,$addcode[$i]) ."', '". mysqli_real_escape_string($conn, $addcodedesc[$i]) ."', '". $addcodeseries ."')");
		}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added code', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=CodeMgt");
	}
	elseif((isset($_POST['txtaddcodeid'])) && !empty($_POST['txtaddcodeid']))
	{
		$editcode = mysqli_real_escape_string($conn, $_POST['txtaddcodecode']);
		$editcodedesc = mysqli_real_escape_string($conn, $_POST['txtaddcodedesc']);
		$editcodeseries = $_POST['txtaddcodeseries'];
		$editcodeid = $_POST['txtaddcodeid'];
		mysqli_query($conn, "UPDATE urc_mst SET codes = '". $editcode ."', description = '". $editcodedesc ."', series = '". $editcodeseries ."' WHERE id = ".$editcodeid."");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited code', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=CodeMgt");
	}
	elseif((isset($_POST['txtaddbunameall'])) && !empty($_POST['txtaddbunameall']))
	{
		$addbunames = explode("*~", $_POST['txtaddbunameall']);
		$addbucodes = explode("*~", $_POST['txtaddbucodeall']);
		$addbugroups = explode("*~", $_POST['txtaddbugroupall']);
		$addburegions = explode("*~", $_POST['txtaddburegionall']);
		$addbucluster = explode("*~", $_POST['txtaddbuclusterall']);
		$addexprogroups = explode("*~", $_POST['txtexprogroupall']);
		for($i=1, $count = count($addbunames);$i<$count;$i++) {
			mysqli_query($conn, "INSERT INTO bu_mst(bu, bu_code, main_group, regional_group, cluster_group, expro) VALUES('" . mysqli_real_escape_string($conn, $addbunames[$i]) . "', '" . mysqli_real_escape_string($conn, $addbucodes[$i]) . "', '" . mysqli_real_escape_string($conn, $addbugroups[$i]) . "', " . mysqli_real_escape_string($conn, $addburegions[$i]) . ", " . mysqli_real_escape_string($conn, $addbucluster[$i]) . ", " . mysqli_real_escape_string($conn, $addexprogroups[$i]) . ")");
		}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added BU', now(), 0)") or die(mysqli_error());
		header("Location: user-superadmin.php?last=BUs");
	}
	elseif((isset($_POST['txtaddbuname'])) && !empty($_POST['txtaddbuname']))
	{
		if (empty($_FILES['bulogo']['name'])) {
			mysqli_query($conn, "UPDATE bu_mst SET bu = '" . $_POST['txtaddbuname'] . "', bu_code = '" . $_POST['txtaddbucode'] . "', main_group = '" . $_POST['seladdbugroup'] . "', regional_group = '" . $_POST['seladdburegion'] . "', cluster_group = '" . $_POST['seladdbucluster'] . "', expro = '" . $_POST['selexprogroup'] . "' WHERE id = '" . $_POST['txtaddbuid'] . "'");
			$catch = "catchelse";
		} else {
			foreach ($_FILES['bulogo']['name'] as $attach) {
				if ($attach == "") {
					$path = "";
				} else {
					$path =  "bulogos/" . $_POST['txtaddbuid'] . "-" . $attach;
				}

				if ($path) {
					$unlinksql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = " . $_POST['txtaddbuid']);
					$unlinkres = mysqli_fetch_assoc($unlinksql);
					unlink($unlinkres['bu_logo']);

					if (@copy($_FILES['bulogo']['tmp_name'][$i2], $path)) {
						mysqli_query($conn, "update bu_mst set bu_logo = 'bulogos/" . $handle2->file_dst_name . "' where id = '" . $_POST['txtaddbuid'] . "'") or die(mysqli_error($conn));
					} else {
						$catch = "uploadfail " . $_FILES['userfile']['error'];
					}
				} else {
				}
			}
		}
		header("Location: user-superadmin.php?last=BUs&catch=".$catch);
		/* mysqli_query($conn, "UPDATE bu_mst SET bu = '".$_POST['txtaddbuname']."', bu_code = '".$_POST['txtaddbucode']."', main_group = '".$_POST['seladdbugroup']."', regional_group = '".$_POST['seladdburegion']."', expro = '".$_POST['selexprogroup']."' WHERE id = '".$_POST['txtaddbuid']."'");
		$handle2 = new upload($_FILES['bulogo']);
			if ($handle2->uploaded) {
				  $handle2->file_new_name_body   = 'bulogo_'. $_POST['txtaddbuid'];
				  $handle2->image_resize         = true;
				  $handle2->image_x              = 150;
				  $handle2->image_ratio_y        = true;
				  $handle2->file_overwrite = true;
				  $handle2->process('bulogos/');
				  if ($handle2->processed) {
					//echo 'image resized';
					mysqli_query($conn, "update bu_mst set bu_logo = 'bulogos/".$handle2->file_dst_name."' where id = '".$_POST['txtaddbuid']."'") or die(mysqli_error($conn));
					$handle2->clean();
					
				  } else {
					echo 'error : ' . $handle2->error;
				  }
			}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited BU', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=BUs"); */
	}
	elseif((isset($_POST['txtaddbuitementryall'])) && !empty($_POST['txtaddbuitementryall']))
	{
		$addbuitem = explode("*~", $_POST['txtaddbuitementryall']);		
		$addbuitemtype = $_POST['txtaddbuitem'];		
		if($addbuitemtype == 'Group')
		{
			$buitemtbl = "main_groups";
		}
		elseif($addbuitemtype == 'Region')
		{
			$buitemtbl = "regional_group";			
		} 
		elseif ($addbuitemtype == 'Cluster') {
			$buitemtbl = "cluster_group";
		}			
		for($i=1, $count = count($addbuitem);$i<$count;$i++)
		{
			mysqli_query($conn, "INSERT INTO ". $buitemtbl ." (name) VALUES('". mysqli_real_escape_string($conn,$addbuitem[$i]) ."')");
		}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added group', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Groups");
	} 
	elseif ((isset($_POST['btnsavepoolagency']))) {
		$bid_ids = $_POST['txtbiddingid'];
		for ($i = 0, $count = count($_POST['poolAgencyID']); $i < $count; $i++) {
			mysqli_query($conn, "INSERT INTO bidding_agency (agency_id, bidding_id) VALUES ('" . $_POST['poolAgencyID'][$i] . "', '" . $bid_ids . "')") or die(mysqli_error());
		}

		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('" . $_SESSION['id'] . "', 'Nominate Security Agency', now(), 0)") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Bidding");
	} 
	elseif ((isset($_POST['btnstartbidding']))) {
		$bid_id = $_POST['txtbiddingid'];
		$req_id = $_POST['txtbiddingrequirements'];
		$clust_id = $_POST['txtbidclust'];
		
		$getBiddingTemplateQuery = mysqli_query($conn, "SELECT * FROM bidding_template WHERE id = " . $req_id);
		$getBiddingTemplate = mysqli_fetch_assoc($getBiddingTemplateQuery);

		$biddingItemQuery = mysqli_query($conn, "SELECT * FROM bidding_template_item WHERE template_id = " . $req_id);
		$counter = 1;
		while ($getBiddingItems = mysqli_fetch_assoc($biddingItemQuery)) {

			if ($getBiddingItems['category'] == "Legal") {
				$legaltable .= "<tr align=\"center\">" .
				"<td align=\"right\" width=\"3%\">" . $counter++ . "</td>" .
				"<td align=\"center\" style=\"background-color: #f9c8c8\">" . $getBiddingItems['requirement_name'] . "</td>" .
				"</tr>";
			} else if ($getBiddingItems['category'] == "Technical") {
				$technicaltable
					.= "<tr align=\"center\">" .
					"<td align=\"right\" width=\"3%\">" . $counter++ . "</td>" .
					"<td align=\"center\" style=\"background-color: rgb(198,217,240)\">" . $getBiddingItems['requirement_name'] . "</td>" .
					"</tr>";
			} else if ($getBiddingItems['category'] == "Financial") {
				$financialtable
					.= "<tr align=\"center\">" .
					"<td align=\"right\" width=\"3%\">" . $counter++ . "</td>" .
					"<td align=\"center\" style=\"background-color: rgb(234,241,221)\">" . $getBiddingItems['requirement_name'] . "</td>" .
					"</tr>";
			}
		}

		$requirementsTable = "<table width='95%' border='1' height='50px' align='center' style=' border-collapse:collapse; font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'>
		<thead >
			<tr style='background-color: #dfdfdf';>
				<th>" . $getBiddingTemplate['bidding_name'] . " </th>
			</tr>
		</thead>
		</table>
		<table width='95%' border='1' align='center' style=' border-collapse:collapse; font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'>
			<thead >
				<tr style='background-color: red';>
					<th align='left'>I. LEGAL</th>														
				</tr>
			</thead>
		</table>
		<table width='95%' border='1' align='center' style='border-collapse:collapse; font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'>
			<tbody id='tbodyNewCC' name='tbodyNewCC'>
				$legaltable
			</tbody>
		</table>
		<table width='95%' border='1' align='center' style=' border-collapse:collapse; font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'>
			<thead >
				<tr style='background-color: rgb(0,112,192)';>
					<th align='left'>II. TECHNICAL</th>														
				</tr>
			</thead>
		</table>
		<table width='95%' border='1' align='center' style='border-collapse:collapse; font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'>
			<tbody id='tbodyNewCC' name='tbodyNewCC'>
				$technicaltable
			</tbody>
		</table>
		<table width='95%' border='1' align='center' style=' border-collapse:collapse; font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'>
			<thead >
				<tr style='background-color: rgb(146,208,80)';>
					<th align='left'>III. FINANCIAL</th>														
				</tr>
			</thead>
		</table>
		<table width='95%' border='1' align='center' style='border-collapse:collapse; font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;' id='tblbiddingitem' name='tblbiddingitem'>
			<tbody id='tbodyNewCC' name='tbodyNewCC'>
				$financialtable
			</tbody>
		</table>";


		$updateStatus = mysqli_query($conn, "UPDATE bidding SET bidding_status = 'Assessment' WHERE id = " . $bid_id) or die(mysqli_error($conn));
		
		if($updateStatus){
			$getAgencyEmailQuery = mysqli_query($conn, "SELECT agency_mst.email, agency_mst.password FROM bidding_agency INNER JOIN bidding ON bidding_agency.bidding_id = bidding.id INNER JOIN agency_mst ON bidding_agency.agency_id = agency_mst.id WHERE bidding.id = " . $bid_id);
			while ($getAgencyEmail = mysqli_fetch_assoc($getAgencyEmailQuery)) {
				$passwordText = '';

				if(md5('Password2022') == $getAgencyEmail['password']) {
					$passwordText = 'Password2022';
				}

				$mainbody = "<table width='95%' align='center' style='font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'> 
                    <tr> 
                        <td>
                            Nomination of Security Agency.<br><br> 
                            To upload requirements, PLEASE CLICK <a href='http://localhost/aev-sms-agency/' target='_blank'>HERE</a>
							<br><br>
							<strong>Login Credentials:</strong><br>
							Email:  " . $getAgencyEmail['email'] . "<br>
							Password:  " . $passwordText . "
							<br><br> 
                            If you have any questions or clarifications, PLEASE REPLY TO THIS EMAIL.    
                        </td>
                    </tr>
                </table>";


				$mainbody .= $requirementsTable;

				$mail = send_bidding_requirements($getAgencyEmail['email'], $mainbody);
			}

			$resulttable = "<div style='font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'><h2>List of Participant</h2>
			<table style='width:30%; border:1px solid black;'>
				<tr >
					<th align='left' style='border:1px solid black; background: red; color: white'>Agency Name</th>
				</tr>";
			$resultQuery = mysqli_query($conn, "SELECT * FROM bidding_agency INNER JOIN agency_mst ON bidding_agency.agency_id = agency_mst.id WHERE bidding_agency.bidding_id = " . $bid_id) or die(mysqli_error($conn));
			while ($row = mysqli_fetch_assoc($resultQuery)) {
				$resulttable .= "<tr>
									<td style='border:1px solid black;'>" . $row['agency_name'] . "</td>
								</tr>";
			}
			$resulttable .= "</table>";
			$clusterReceiverForBiddingClose = '';
			$getReceiverOfClusterCloseBiddingQuery = mysqli_query($conn, "SELECT users_mst.user_email FROM `users_mst` INNER JOIN bu_mst ON users_mst.bu = bu_mst.id WHERE bu_mst.cluster_group = " . $clust_id);
			while ($getReceiverOfClusterCloseBidding = mysqli_fetch_assoc($getReceiverOfClusterCloseBiddingQuery)) {
				$clusterReceiverForBiddingClose .= $getReceiverOfClusterCloseBidding['user_email'] . ',';
			}

			$mail = send_bidding_notification($clusterReceiverForBiddingClose, $resulttable);
		}
		
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('" . $_SESSION['id'] . "', 'Start Bidding', now(), 0)") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Bidding");
	}
	elseif((isset($_POST['txtaddbuitementry'])) && !empty($_POST['txtaddbuitementry']))
	{
		$editbuitem = mysqli_real_escape_string($conn, $_POST['txtaddbuitementry']);
		$addbuitemid = $_POST['txtaddbuitemid'];
		$addbuitemtype = $_POST['txtaddbuitem'];		
		if($addbuitemtype == 'Group')
		{
			$buitemtbl = "main_groups";
		}
		elseif($addbuitemtype == 'Region')
		{
			$buitemtbl = "regional_group";			
		} 
		elseif ($addbuitemtype == 'Cluster') {
			$buitemtbl = "cluster_group";
		}	
		mysqli_query($conn, "UPDATE ". $buitemtbl ." SET name = '".$editbuitem."' WHERE id = '".$addbuitemid."'");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Updated BU', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Groups");
	}
	elseif((isset($_POST['txtAddEntriesAll'])) && !empty($_POST['txtAddEntriesAll']))
	{
		$addInputEntry = explode("*~", $_POST['txtAddEntriesAll']);
		$addSvDefault = explode("*~", $_POST["txtAddSvDefault"]);
		$addSvInjuryMinor = explode("*~", $_POST["txtAddSvInjuryMinor"]);
		$addSvInjurySerious = explode("*~", $_POST["txtAddSvInjurySerious"]);
		$addSvPropDmgNC = explode("*~", $_POST["txtAddSvPropDmgNC"]);
		$addSvPropDmgCrit = explode("*~", $_POST["txtAddSvPropDmgCrit"]);
		$addSvPropLossNC = explode("*~", $_POST["txtAddSvPropLossNC"]);
		$addSvPropLossCrit = explode("*~", $_POST["txtAddSvPropLossCrit"]);
		$addSvWorkStop = explode("*~", $_POST["txtAddSvWorkStoppage"]);
		$addSvDeath1 = explode("*~", $_POST["txtAddSvDeath1"]);
		$addSvDeath2 = explode("*~", $_POST["txtAddSvDeath2"]);
		$addSvDeath3 = explode("*~", $_POST["txtAddSvDeath3"]);
		$addInputEntryType = $_POST['txtAddEntriesType'];
		$exprocheckcol = "";
		$exprocheckentry = "";
		$severityfactors = "";
		$severityvalues = "";
		if($addInputEntryType == 'Activity')
		{
			$tblInputEntry = "entries_activity";
		}
		elseif($addInputEntryType == 'Incident')
		{
			$tblInputEntry = "entries_incident";
			$severityfactors = ", defaultlevel, injury_minor, injury_serious, propertydmg_nc, propertydmg_crit, propertyloss_nc, propertyloss_crit, workstoppage, death_1, death_2, death_3";
			//$severityvalues = ", ".$addSvDefault.", ".$addSvInjuryMinor.", ".$addSvInjurySerious.", ".$addSvPropDmgNC.", ".$addSvPropDmgCrit.", ".$addSvPropLossNC.", ".$addSvPropLossCrit.", ".$addSvWorkStop.", ".$addSvDeath1.", ".$addSvDeath2.", ".$addSvDeath3;
		}
		elseif($addInputEntryType == 'EXPRO')
		{
			$tblInputEntry = "entries_activity";
			$exprocheckcol = ", expro";
			$exprocheckentry = ", 1";			
		}			
		for($i=1, $count = count($addInputEntry);$i<$count;$i++)
		{
			if($addInputEntryType == 'Incident')
			{
				$severityvalues = ", ".$addSvDefault[$i].", ".$addSvInjuryMinor[$i].", ".$addSvInjurySerious[$i].", ".$addSvPropDmgNC[$i].", ".$addSvPropDmgCrit[$i].", ".$addSvPropLossNC[$i].", ".$addSvPropLossCrit[$i].", ".$addSvWorkStop[$i].", ".$addSvDeath1[$i].", ".$addSvDeath2[$i].", ".$addSvDeath3[$i];
			}
			mysqli_query($conn, "INSERT INTO ". $tblInputEntry ." (name".$exprocheckcol." ".$severityfactors.") VALUES('".mysqli_real_escape_string($conn,$addInputEntry[$i])."'".$exprocheckentry." ".$severityvalues.")") or die(mysqli_error($conn));			
		}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added dropdown entry', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Entries");
	}
	elseif(!empty($_POST['btnSaveNewIncident']))
	{
		$name = array();
		$main_cat = array();
		$sub_cat = array();
		$defaultlevel = array();
		$injury_minor = array();
		$injury_serious = array();
		$propertydmg_nc = array();
		$propertydmg_crit = array();
		$propertyloss_nc = array();
		$propertyloss_crit = array();
		$workstoppage = array();
		$death_1 = array();
		$death_2 = array();
		$death_3 = array();
		
		$name = $_POST["txtAddEntries"];
		$main_cat = $_POST["selAddMainClassId"];
		$sub_cat = $_POST["selAddSubClassId"];
		$defaultlevel = $_POST["txtsvdefault"];
		$injury_minor = $_POST["txtsvinjuryminor"];
		$injury_serious = $_POST["txtsvinjuryserious"];
		$propertydmg_nc = $_POST["txtsvpropdmgnc"];
		$propertydmg_crit = $_POST["txtsvpropdmgcrit"];
		$propertyloss_nc = $_POST["txtsvproplossnc"];
		$propertyloss_crit = $_POST["txtsvproplosscrit"];
		$workstoppage = $_POST["txtsvworkstop"];
		$death_1 = $_POST["txtsvdeath1"];
		$death_2 = $_POST["txtsvdeath2"];
		$death_3 = $_POST["txtsvdeath3"];
		
		for($i=0, $count  = count($name); $i < $count; $i++ )
		{
			mysqli_query($conn, "INSERT INTO entries_incident (name, main_cat, sub_cat, defaultlevel, injury_minor, injury_serious, propertydmg_nc, propertydmg_crit, propertyloss_nc, propertyloss_crit, workstoppage, death_1, death_2, death_3) VALUES('".$name[$i]."', ".$main_cat[$i].", ".$sub_cat[$i].", ".$defaultlevel[$i].", ".$injury_minor[$i].", ".$injury_serious[$i].", ".$propertydmg_nc[$i].", ".$propertydmg_crit[$i].", ".$propertyloss_nc[$i].", ".$propertyloss_crit[$i].", ".$workstoppage[$i].", ".$death_1[$i].", ".$death_2[$i].", ".$death_3[$i].")");
		}
		header("Location: user-superadmin.php?last=Entries");
		
	}
	elseif(!empty($_POST['btnSaveEditIncident']))
	{
		$incidentid = $_POST['hdnIncidentId'];
		$name = $_POST["txtAddEntries"];
		$main_cat = $_POST["selAddMainClassId"];
		$sub_cat = $_POST["selAddSubClassId"];
		$defaultlevel = $_POST["txtsvdefault"];
		$injury_minor = $_POST["txtsvinjuryminor"];
		$injury_serious = $_POST["txtsvinjuryserious"];
		$propertydmg_nc = $_POST["txtsvpropdmgnc"];
		$propertydmg_crit = $_POST["txtsvpropdmgcrit"];
		$propertyloss_nc = $_POST["txtsvproplossnc"];
		$propertyloss_crit = $_POST["txtsvproplosscrit"];
		$workstoppage = $_POST["txtsvworkstop"];
		$death_1 = $_POST["txtsvdeath1"];
		$death_2 = $_POST["txtsvdeath2"];
		$death_3 = $_POST["txtsvdeath3"];
		
		mysqli_query($conn, "UPDATE entries_incident SET name = '".$name[0]."', main_cat = ".$main_cat[0].", sub_cat = ".$sub_cat[0].", defaultlevel = ".$defaultlevel[0].", injury_minor = ".$injury_minor[0].", injury_serious = ".$injury_serious[0].", propertydmg_nc = ".$propertydmg_nc[0].", propertydmg_crit = ".$propertydmg_crit[0].", propertyloss_nc = ".$propertyloss_nc[0].", propertyloss_crit = ".$propertyloss_crit[0].", workstoppage = ".$workstoppage[0].", death_1 = ".$death_1[0].", death_2 = ".$death_2[0].", death_3 = ".$death_3[0]." WHERE id = ".$incidentid)or die(mysqli_error($conn));
		
		header("Location: user-superadmin.php?last=Entries");
	}
	elseif((isset($_POST['txtAddEntries'])) && !empty($_POST['txtAddEntries']))
	{
		$editInputEntry = mysqli_real_escape_string($conn, $_POST['txtAddEntries']);		
		$editDefaultLevel = mysqli_real_escape_string($conn, $_POST['txtsvdefault']);
		$editInjuryMinor = mysqli_real_escape_string($conn, $_POST['txtsvinjuryminor']);
		$editInjurySerious = mysqli_real_escape_string($conn, $_POST['txtsvinjuryserious']);
		$editPropDmgNC = mysqli_real_escape_string($conn, $_POST['txtsvpropdmgnc']);
		$editPropDmgCrit = mysqli_real_escape_string($conn, $_POST['txtsvpropdmgcrit']);
		$editPropLossNC = mysqli_real_escape_string($conn, $_POST['txtsvproplossnc']);
		$editPropLossCrit = mysqli_real_escape_string($conn, $_POST['txtsvproplosscrit']);
		$editWorkStop = mysqli_real_escape_string($conn, $_POST['txtsvworkstop']);
		$editDeath1 = mysqli_real_escape_string($conn, $_POST['txtsvdeath1']);
		$editDeath2 = mysqli_real_escape_string($conn, $_POST['txtsvdeath2']);
		$editDeath3 = mysqli_real_escape_string($conn, $_POST['txtsvdeath3']);
		$addInputEntryId = $_POST['txtAddEntriesId'];
		$addInputEntryType = $_POST['txtAddEntriesType'];		
		if($addInputEntryType == 'Activity')
		{
			$tblInputEntry = "entries_activity";
		}
		elseif($addInputEntryType == 'Incident')
		{
			$tblInputEntry = "entries_incident";			
		}
		elseif($addInputEntryType == 'EXPRO')
		{
			$tblInputEntry = "entries_activity";			
		}
		
		if($addInputEntryType == 'Incident')
		{
			mysqli_query($conn, "UPDATE ". $tblInputEntry ." SET name = '".$editInputEntry."', defaultlevel = '".$editDefaultLevel."', injury_minor = '".$editInjuryMinor."', injury_serious = '".$editInjurySerious."', propertydmg_nc = '".$editPropDmgNC."', propertydmg_crit = '".$editPropDmgCrit."', propertyloss_nc = '".$editPropLossNC."', propertyloss_crit = '".$editPropLossCrit."', workstoppage = '".$editWorkStop."', death_1 = '".$editDeath1."', death_2 = '".$editDeath2."', death_3 = '".$editDeath3."' WHERE id = '".$addInputEntryId."'");
		}
		else
		{
			mysqli_query($conn, "UPDATE ". $tblInputEntry ." SET name = '".$editInputEntry."' WHERE id = '".$addInputEntryId."'");
		}
		
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited dropdown entry', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-superadmin.php?last=Entries");
	}
	elseif((isset($_POST['txtIncidentDisposition'])) && !empty($_POST['txtIncidentDisposition']))
	{
		$logId2 = $_POST['swid'];
		
		if((isset($_POST['iwfnamesall'])) && !empty($_POST['iwfnamesall']))
		{
		  $iwfnamesall = explode("*~", $_POST['iwfnamesall']);
		  $iwmnamesall = explode("*~", $_POST['iwmnamesall']);
		  $iwlnamesall = explode("*~", $_POST['iwlnamesall']);
		  $iwaddressall = explode("*~", $_POST['iwaddressall']);
		  $iwcontactsall = explode("*~", $_POST['iwcontactsall']);
		  $iwageall = explode("*~", $_POST['iwageall']);
		  $iwgenderall = explode("*~", $_POST['iwgenderall']);
		  $iwheightall = explode("*~", $_POST['iwheightall']);
		  $iwweightall = explode("*~", $_POST['iwweightall']);
		  $iwremarksall = explode("*~", $_POST['iwremarksall']);
		  for($i=1, $count = count($iwfnamesall);$i<$count;$i++) {
			  mysqli_query($conn, "INSERT INTO incident_witness (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$iwfnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwmnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwlnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwaddressall[$i])."', '".mysqli_real_escape_string($conn,$iwcontactsall[$i])."', '".mysqli_real_escape_string($conn,$iwageall[$i])."', '".mysqli_real_escape_string($conn,$iwgenderall[$i])."', '".mysqli_real_escape_string($conn,$iwheightall[$i])."', '".mysqli_real_escape_string($conn,$iwweightall[$i])."', '".mysqli_real_escape_string($conn,$iwremarksall[$i])."', now())");
		  }
		  mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added witness to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		if((isset($_POST['isfnamesall'])) && !empty($_POST['isfnamesall']))
		{
		  $isfnamesall = explode("*~", $_POST['isfnamesall']);
		  $ismnamesall = explode("*~", $_POST['ismnamesall']);
		  $islnamesall = explode("*~", $_POST['islnamesall']);
		  $isaddressall = explode("*~", $_POST['isaddressall']);
		  $iscontactsall = explode("*~", $_POST['iscontactsall']);
		  $isageall = explode("*~", $_POST['isageall']);
		  $isgenderall = explode("*~", $_POST['isgenderall']);
		  $isheightall = explode("*~", $_POST['isheightall']);
		  $isweightall = explode("*~", $_POST['isweightall']);
		  $isremarksall = explode("*~", $_POST['isremarksall']);
		  for($i=1, $count = count($isfnamesall);$i<$count;$i++) {
			  mysqli_query($conn, "INSERT INTO incident_suspect (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$isfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ismnamesall[$i])."', '".mysqli_real_escape_string($conn,$islnamesall[$i])."', '".mysqli_real_escape_string($conn,$isaddressall[$i])."', '".mysqli_real_escape_string($conn,$iscontactsall[$i])."', '".mysqli_real_escape_string($conn,$isageall[$i])."', '".mysqli_real_escape_string($conn,$isgenderall[$i])."', '".mysqli_real_escape_string($conn,$isheightall[$i])."', '".mysqli_real_escape_string($conn,$isweightall[$i])."', '".mysqli_real_escape_string($conn,$isremarksall[$i])."', now())");
		  }
		  mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added suspect to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		if((isset($_POST['ivfnamesall'])) && !empty($_POST['ivfnamesall']))
		{
		  $ivfnamesall = explode("*~", $_POST['ivfnamesall']);
		  $ivmnamesall = explode("*~", $_POST['ivmnamesall']);
		  $ivlnamesall = explode("*~", $_POST['ivlnamesall']);
		  $ivaddressall = explode("*~", $_POST['ivaddressall']);
		  $ivcontactsall = explode("*~", $_POST['ivcontactsall']);
		  $ivageall = explode("*~", $_POST['ivageall']);
		  $ivgenderall = explode("*~", $_POST['ivgenderall']);
		  $ivheightall = explode("*~", $_POST['ivheightall']);
		  $ivweightall = explode("*~", $_POST['ivweightall']);
		  $ivremarksall = explode("*~", $_POST['ivremarksall']);
		  for($i=1, $count = count($ivfnamesall);$i<$count;$i++) {
			  mysqli_query($conn, "INSERT INTO incident_victim (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$ivfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivmnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivlnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivaddressall[$i])."', '".mysqli_real_escape_string($conn,$ivcontactsall[$i])."', '".mysqli_real_escape_string($conn,$ivageall[$i])."', '".mysqli_real_escape_string($conn,$ivgenderall[$i])."', '".mysqli_real_escape_string($conn,$ivheightall[$i])."', '".mysqli_real_escape_string($conn,$ivweightall[$i])."', '".mysqli_real_escape_string($conn,$ivremarksall[$i])."', now())");
		  }
		  mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added victim to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		// if((isset($_POST['checkVehicle'])) && !empty($_POST['checkVehicle']))
		// {
			// $ivehicleplate = mysqli_real_escape_string($conn, $_POST['txtvplateno']);
			// $ivehicletype = mysqli_real_escape_string($conn, $_POST['selvtype']);
			// $ivehiclemake = mysqli_real_escape_string($conn, $_POST['txtvmake']);
			// $ivehiclemodel = mysqli_real_escape_string($conn, $_POST['txtvmodel']);
			// $ivehiclecolor = mysqli_real_escape_string($conn, $_POST['txtvcolor']);
			// $ivehicleremarks = mysqli_real_escape_string($conn, $_POST['txtvremarks']);
			
			// mysqli_query($conn, "INSERT INTO incident_vehicle (ticket_id, plate_no, type, make, model, color, remarks, owner) VALUES(".$logId2.", '".$ivehicleplate."', '".$ivehicletype."', '".$ivehiclemake."', '".$ivehiclemodel."', '".$ivehiclecolor."', '".$ivehicleremarks."', '".$ivehicleowner."')");
			// mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added vehicle to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		// }
		if((isset($_POST['vPlateNoAll'])) && !empty($_POST['vPlateNoAll']))
		{
			$ivehicleowner = explode("*~", $_POST['vOwnerAll']);
			$ivehicleplate = explode("*~", $_POST['vPlateNoAll']);
			$ivehicletype = explode("*~", $_POST['vTypeAll']);
			$ivehiclemake = explode("*~", $_POST['vMakeAll']);
			$ivehiclemodel = explode("*~", $_POST['vModelAll']);
			$ivehiclecolor = explode("*~", $_POST['vColorAll']);
			$ivehicleremarks = explode("*~", $_POST['vRemarksAll']);
			for($i=1, $count = count($ivehicleplate);$i<$count;$i++)
			{
				mysqli_query($conn, "INSERT INTO incident_vehicle (ticket_id, plate_no, type, make, model, color, remarks, owner) VALUES(".$logId2.", '".mysqli_real_escape_string($conn, $ivehicleplate[$i])."', '".mysqli_real_escape_string($conn,$ivehicletype[$i])."', '".mysqli_real_escape_string($conn, $ivehiclemake[$i])."', '".mysqli_real_escape_string($conn, $ivehiclemodel[$i])."', '".mysqli_real_escape_string($conn,$ivehiclecolor[$i])."', '".mysqli_real_escape_string($conn,$ivehicleremarks[$i])."', '".mysqli_real_escape_string($conn,$ivehicleowner[$i])."')");
				mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added vehicle to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
			}
		}
		if((isset($_POST['checkDamage'])) && !empty($_POST['checkDamage']))
		{
			$idamagecost = $_POST['txtdmgcost'];
			$idamagetype = $_POST['sellosstype'];
			
			mysqli_query($conn, "UPDATE ticket SET damage_cost = ".$idamagecost.", loss_type = '".$idamagetype."' WHERE id = ". $logId2);
			mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added damage details to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		if((isset($_POST['checkCF'])) && !empty($_POST['checkCF']))
		{
			$cfaccname = mysqli_real_escape_string($conn, $_POST['txtcfaccname']);
			$cfaccid = mysqli_real_escape_string($conn, $_POST['txtcfaccid']);
			$cfcrep = mysqli_real_escape_string($conn, $_POST['txtcfcrep']);
			$cfadd = mysqli_real_escape_string($conn, $_POST['txtcfadd']);
			$cfamount = mysqli_real_escape_string($conn, $_POST['txtcfamount']);
			$cfbill = mysqli_real_escape_string($conn, $_POST['txtcfbill']);
			$cfrelate = mysqli_real_escape_string($conn, $_POST['txtcfrelate']);
			
			mysqli_query($conn, "INSERT INTO incident_counterfeit (ticket_id, account_name, account_id, customer_rep, address, amount, bill_serial, relationship) VALUES(".$logId2.", '".$cfaccname."', '".$cfaccid."', '".$cfcrep."', '".$cfadd."', '".$cfamount."', '".$cfbill."', '".$cfrelate."')");
			mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added counterfeit details to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		date_default_timezone_set('Asia/Manila');
		$datenow = date('Y-m-d H:i:s');
		mysqli_query($conn, "UPDATE ticket SET disposition = '".mysqli_real_escape_string($conn,$_POST['txtIncidentDisposition'])."', is_open = 0, dateclosed = '".$datenow."' WHERE id = ".$logId2);
		if($_SESSION['level'] == 'User')
		{
			header("location:user.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("location:user-admin.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Super Admin')
		{
			header("location:user-superadmin.php?last=Incidents");
		}
	}
	elseif((isset($_POST['logsTicketIdAll'])) && !empty($_POST['logsTicketIdAll']))
	{
		$logsTicketId = explode("*~", $_POST['logsTicketIdAll']);
		$logsLogId = explode("*~", $_POST['logsLogIdAll']);
		$logsDateCreated = explode("*~", $_POST['logsDateCreatedAll']);
		$logsTimeCreated = explode("*~", $_POST['logsTimeCreatedAll']);
		$logsGuardId = explode("*~", $_POST['logsGuardIdAll']);
		$logsRemarks = explode("*~", $_POST['logsRemarksAll']);
		$logsEncoder = explode("*~", $_POST['logsEncoderAll']);
		date_default_timezone_set('Asia/Manila');
		$datenow = date('Y-m-d H:i:s');
		for($i=1, $count = count($logsTicketId);$i<$count;$i++)
		{
			mysqli_query($conn, "INSERT INTO logrevision_mst (ticket, log_id, date_created, time_created, gid, remarks, uid, date_revised, time_revised, revised_by, revision_num) VALUES(".$logsTicketId[$i].", ".$logsLogId[$i].", '".$logsDateCreated[$i]."', '".trim($logsTimeCreated[$i])."', ".$logsGuardId[$i].", '".mysqli_real_escape_string($conn, $logsRemarks[$i])."', ".$logsEncoder[$i].", '".$datenow."', '".$datenow."', ".$_SESSION['id'].", 1)") or die(mysqli_error($conn));
		}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Made revisions to logs', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		if($_SESSION['level'] == 'User')
		{
			header("location:user.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("location:user-admin.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Super Admin')
		{
			header("location:user-superadmin.php?last=Incidents");
		}
		
	}
	elseif((isset($_POST['revisionsIdAll'])) && !empty($_POST['revisionsIdAll']))
	{
		$revisionsId = explode("*~", $_POST['revisionsIdAll']);
		$revisionsLogs = explode("*~", $_POST['revisionsLogsAll']);
		$revisionsDateCreated = explode("*~", $_POST['revisionsDateCreatedAll']);
		$revisionsTimeCreated = explode("*~", $_POST['revisionsTimeCreatedAll']);
		$revisionsGuardId = explode("*~", $_POST['revisionsGuardIdAll']);
		$revisionsTicketId = explode("*~", $_POST['revisionsTicketIdAll']);
		$revisionsEncoder = explode("*~", $_POST['revisionsEncoderAll']);
		$revisionsLogId = explode("*~", $_POST['revisionsLogIdAll']);
		date_default_timezone_set('Asia/Manila');
		$datenow = date('Y-m-d H:i:s');
		for($i=1, $count = count($revisionsId);$i<$count;$i++)
		{
//			$queryRevision = mysqli_query($conn, "SELECT * FROM logrevision_mst WHERE id = ". $revisionsId[$i]);
//			$resRevision = mysqli_fetch_assoc($queryRevision);
//			$revisionnum = $resRevision['revision_num'];
//			$revisionnum++;
//			mysqli_query($conn, "UPDATE logrevision_mst SET remarks = '".$revisionsLogs[$i]."', revision_num = ".$revisionnum.", date_revised = now(), time_revised = now()  WHERE id = ". trim($revisionsId[$i]))  or die(mysqli_error($conn));
			mysqli_query($conn, "INSERT INTO logrevision_mst (ticket, log_id, date_created, time_created, gid, remarks, uid, date_revised, time_revised, revised_by, revision_num) VALUES(".$revisionsTicketId[$i].", ".$revisionsLogId[$i].", '".$revisionsDateCreated[$i]."', '".trim($revisionsTimeCreated[$i])."', ".$revisionsGuardId[$i].", '".mysqli_real_escape_string($conn, $revisionsLogs[$i])."', ".$revisionsEncoder[$i].", '".$datenow."', '".$datenow."', ".$_SESSION['id'].", 2)") or die(mysqli_error($conn));
			
		}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Made revisions to revised logs', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		if($_SESSION['level'] == 'User')
		{
			header("location:user.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("location:user-admin.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Super Admin')
		{
			header("location:user-superadmin.php?last=Incidents");
		}
	}
	elseif((isset($_POST['editIPType'])) && !empty($_POST['editIPType']))
	{
		$editIPType = explode("*~", $_POST['editIPType']);
		$editIPIDNum = explode("*~", $_POST['editIPIDNum']);
		$editIPFName = explode("*~", $_POST['editIPFName']);
		$editIPMName = explode("*~", $_POST['editIPMName']);
		$editIPLName = explode("*~", $_POST['editIPLName']);
		$editIPAddress = explode("*~", $_POST['editIPAddress']);
		$editIPContact = explode("*~", $_POST['editIPContact']);
		$editIPAge = explode("*~", $_POST['editIPAge']);
		//$editIPAge = (!empty($_POST['editIPAge'])) ? mysqli_real_escape_string($conn, $_POST['editIPAge']):0;		
		$editIPGender = explode("*~", $_POST['editIPGender']);		
		$editIPHeight = explode("*~", $_POST['editIPHeight']);
		//$editIPHeight = (!empty($_POST['editIPHeight'])) ? mysqli_real_escape_string($conn, $_POST['editIPHeight']):0;
		$editIPWeight = explode("*~", $_POST['editIPWeight']);
		//$editIPWeight = (!empty($_POST['editIPWeight'])) ? mysqli_real_escape_string($conn, $_POST['editIPWeight']):0;
		$editIPIDType = explode("*~", $_POST['editIPIDType']);
		$editIPIDNumber = explode("*~", $_POST['editIPIDNumber']);
		$editIPRemark = explode("*~", $_POST['editIPRemark']);
		$edittable = "";
		for($i=1, $count = count($editIPIDNum);$i<$count;$i++)
		{
			if($editIPType[$i] == "suspect")
			{
				$edittable = "incident_suspect";
			}
			elseif($editIPType[$i] == "witness")
			{
				$edittable = "incident_witness";
			}
			elseif($editIPType[$i] == "victim")
			{
				$edittable = "incident_victim";
			}
		mysqli_query($conn, "UPDATE ".$edittable." SET FirstName = '".mysqli_real_escape_string($conn, $editIPFName[$i])."', MiddleName = '".mysqli_real_escape_string($conn, $editIPMName[$i])."', LastName = '".mysqli_real_escape_string($conn, $editIPLName[$i])."', Address = '".mysqli_real_escape_string($conn, $editIPAddress[$i])."', Age = '". ((!empty($editIPAge[$i])) ? mysqli_real_escape_string($conn, $editIPAge[$i]):0) ."', Gender = '". mysqli_real_escape_string($conn, $editIPGender[$i])."', Height = '". ((!empty($editIPHeight[$i])) ? mysqli_real_escape_string($conn, $editIPHeight[$i]):0) ."', Weight = '". ((!empty($editIPWeight[$i])) ? mysqli_real_escape_string($conn, $editIPWeight[$i]):0)."', Contact = '".mysqli_real_escape_string($conn, $editIPContact[$i])."', idType = '".mysqli_real_escape_string($conn,$editIPIDType[$i])."', idNumber = '".mysqli_real_escape_string($conn,$editIPIDNumber[$i])."', Remark = '".mysqli_real_escape_string($conn,$editIPRemark[$i])."' WHERE id = ".$editIPIDNum[$i])or die(mysqli_error($conn));
		}
		
		if($_SESSION['level'] == 'User')
		{
			header("location:user.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("location:user-admin.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Super Admin')
		{
			header("location:user-superadmin.php?last=Incidents");
		}
		
	}
	elseif((isset($_POST['ccActualList'])) && !empty($_POST['ccActualList']))
	{
		
		$ccMonth = $_POST['ccSendMonth'];
		$ccYear = $_POST['ccSendYear'];
		$ccTotalScore = $_POST['ccSendTotalScore'];
		$ccRawScore = $_POST['ccSendOpScore'];
		$ccAgency = $_POST['ccAdminAgency'];
		$ccAgencyEmail = mysqli_real_escape_string($conn, $_POST['ccAdminAgencyEmail']);
		
		$ccActuals = explode("*~", $_POST['ccActualList']);
		$ccComments = explode("*~", $_POST['ccCommentList']);
		$ccIDs = explode("*~", $_POST['ccIDList']);
		$ccEditIDs = explode("*~", $_POST['ccEditIDList']);		
		$ccAdminMainCCID = $_POST['ccAdminMainCCID'];
		
		$sendtoagency = $_POST['ccSendToAgency'];
		
		$lccid = "";
		
		$changed_cc_entries = "";
		
		if((count($ccEditIDs)) > 1)
		{
			mysqli_query($conn, "UPDATE cc_general SET total_score = ".$ccTotalScore.", raw_score = ".$ccRawScore.", agency_email = '".$ccAgencyEmail."' WHERE id = ".$ccAdminMainCCID)or die(mysqli_error($conn));
			
			for($i = 1, $count = count($ccActuals); $i < $count; $i++)
			{
				/* $changetest = mysqli_query($conn, "SELECT * FROM cc_specific WHERE id = ".$ccEditIDs[$i]);
				$changetestres = mysqli_fetch_assoc($changetest);
				if($changetestres)
				{
					if($changetestres['comments'] != (mysqli_real_escape_string($conn, $ccComments[$i])))
					{
						
					}
				} */
	//			$updatetest = mysqli_query($conn, "UPDATE cc_specific SET actual = ".$ccActuals[$i].", comments = '".mysqli_real_escape_string($conn, $ccComments[$i])."' WHERE id = ".$ccEditIDs[$i])or die(mysqli_error($conn));
				$updatetest = mysqli_query($conn, "UPDATE cc_specific SET actual = ".$ccActuals[$i].", comments = '".mysqli_real_escape_string($conn, $ccComments[$i])."' WHERE id = ".$ccEditIDs[$i]);
				if($updatetest)
				{
					
				}
				else
				{
	//				mysqli_query($conn, "INSERT INTO cc_specific (cc_id, actual, comments, standard_id) VALUES(".$ccAdminMainCCID.", ".$ccActuals[$i].", '".mysqli_real_escape_string($conn, $ccComments[$i])."', ".$ccIDs[$i].")")or die(mysqli_error($conn));
					mysqli_query($conn, "INSERT INTO cc_specific (cc_id, actual, comments, standard_id) VALUES(".$ccAdminMainCCID.", ".$ccActuals[$i].", '".mysqli_real_escape_string($conn, $ccComments[$i])."', ".$ccIDs[$i].")")or die("line 2310 error.");
				}
			}
			$lccid = $ccAdminMainCCID;
		}	
		else
		{
			mysqli_query($conn, "INSERT INTO cc_general (bu, month, year, total_score, raw_score, agency, agency_email) VALUES(".$bu.", ".$ccMonth.", ".$ccYear.", ".$ccTotalScore.", ".$ccRawScore.", ".$ccAgency.", '".$ccAgencyEmail."')")or die(mysqli_error($conn));
			
			$get_last_ccid = mysqli_fetch_array(mysqli_query($conn, "Select id from cc_general order by id desc"))or die(mysqli_error($conn));
			$lccid = $get_last_ccid['id'];
					
			for($i = 1, $count = count($ccActuals); $i < $count; $i++)
			{
				mysqli_query($conn, "INSERT INTO cc_specific (cc_id, actual, comments, standard_id) VALUES(".$lccid.", ".$ccActuals[$i].", '".mysqli_real_escape_string($conn, $ccComments[$i])."', ".$ccIDs[$i].")")or die(mysqli_error($conn));
			}
		}
		
		if($sendtoagency == 1)
		{
			$ccagencysql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE id = ".$ccAgency);
			$ccagencyres = mysqli_fetch_assoc($ccagencysql);
			$ccTrans = "1-".$ccMonth."-".$ccYear;
			$ccDisplayMonth = date('F', strtotime($ccTrans));
			$oics = "";
			$ccDisplayScore = "";
			$busql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$bu);
			$bures = mysqli_fetch_assoc($busql);
			if($ccYear >= 2019)
			{
				if(($ccTotalScore <= 100) && ($ccTotalScore > 0))
				{
					if($ccRawScore == 5)
					{
						$ccDisplayScore = "<td align='center' style='font-size:2em; color:purple;'>".$ccRawScore."</td>";
					}
					elseif(($ccRawScore < 5) && ($ccRawScore >= 4))
					{
						$ccDisplayScore = "<td align='center' style='font-size:2em; color:blue;'>".$ccRawScore."</td>";
					}
					elseif(($ccRawScore < 4) && ($ccRawScore >= 3))
					{
						$ccDisplayScore = "<td align='center' style='font-size:2em; color:green;'>".$ccRawScore."</td>";
					}
					elseif(($ccRawScore < 3) && ($ccRawScore >= 2))
					{
						$ccDisplayScore = "<td align='center' style='font-size:2em; color:orange;'>".$ccRawScore."</td>";
					}
					elseif(($ccRawScore < 2) && ($ccRawScore > 0))
					{
						$ccDisplayScore = "<td align='center' style='font-size:2em; color:red;'>".$ccRawScore."</td>";
					}
				}
				elseif($ccTotalScore == 0)
				{
					$ccDisplayScore = "<td align='center' style='font-size:2em; color:red;'>NC</td>";
				}
				/* if(($ccTotalScore <= 100) && ($ccTotalScore >= 90))
				{
					$ccDisplayScore = "<td align='center' style='font-size:2em; color:purple;'>".$ccRawScore." (".$ccTotalScore."%)</td>";
				}
				elseif(($ccTotalScore < 90) && ($ccTotalScore >= 80))
				{
					$ccDisplayScore = "<td align='center' style='font-size:2em; color:blue;'>".$ccRawScore." (".$ccTotalScore."%)</td>";
				}
				elseif(($ccTotalScore < 80) && ($ccTotalScore >= 76))
				{
					$ccDisplayScore = "<td align='center' style='font-size:2em; color:green;'>".$ccRawScore." (".$ccTotalScore."%)</td>";
				}
				elseif(($ccTotalScore < 76) && ($ccTotalScore > 0))
				{
					$ccDisplayScore = "<td align='center' style='font-size:2em; color:red;'>".$ccRawScore." (".$ccTotalScore."%)</td>";
				}
				elseif($ccTotalScore == 0)
				{
					$ccDisplayScore = "<td align='center' style='font-size:2em; color:red;'>NC</td>";
				} */
			}
			else
			{
				if($ccTotalScore == 100)
				{
					$ccDisplayScore = "<td align='left' style='font-size:2em; color:blue;'>100</td>";
				}
				elseif(($ccTotalScore < 100) && ($ccTotalScore > 75))
				{
					$ccDisplayScore = "<td align='left' style='font-size:2em; color:green;'>".$ccTotalScore."</td>";
				}
				elseif(($ccTotalScore <= 75) && ($ccTotalScore > 70))
				{
					$ccDisplayScore = "<td align='left' style='font-size:2em; color:orange;'>".$ccTotalScore."</td>";
				}
				elseif($ccTotalScore <= 70)
				{
					$ccDisplayScore = "<td align='left' style='font-size:2em; color:red;'>".$ccTotalScore."</td>";
				}
			}
			
			
			$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE slevel = 0 AND bu = ".$bu)or die(mysqli_error($conn));
			$resoic = mysqli_fetch_assoc($sqloic);
			if($resoic)
			{
				$oics = $resoic['email_ad'];
			}
			
			if($ccYear >= 2019)
			{
				$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccYear ." ORDER BY goal DESC, number");
			}
			else
			{
				$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccYear ." ORDER BY number");
			}
			
			while($ccyearres = mysqli_fetch_assoc($ccyearsql))
			{
				$ccspecificsql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE standard_id = ".$ccyearres['id']." AND cc_id = ".$lccid);
				$ccspecificres = mysqli_fetch_assoc($ccspecificsql);
				
				$ccrowstyle = "";
				$ccrowstyle2 = "";
				$ccrowstyle3 = "style='background-color:#ededed;'";
				$complied = "None";
				if($ccYear >= 2019)
				{
					$complied = "C";
				}
					
				//if(($ccspecificres['actual'] > 0) && ($ccspecificres['actual'] < 3))
				if($ccspecificres['actual'] > 0)
				{
					if($ccYear >= 2019)
					{
						if($ccyearres['goal'] == "Regulatory")
						{
							$ccrowstyle = "style='background-color:#FAD8D8;'";
							$ccrowstyle2 = "style='background-color:#F5B7B1;'";
							$ccrowstyle3 = "style='background-color:#F1948A;'";	
							$complied = "<b>NC</b>";
						}
						elseif($ccyearres['goal'] == "Operational")
						{
							if($ccspecificres['actual'] < 3)
							{
								$ccrowstyle = "style='background-color:#FAD8D8;'";
								$ccrowstyle2 = "style='background-color:#F5B7B1;'";
								$ccrowstyle3 = "style='background-color:#F1948A;'";
							}
							$complied = $ccspecificres['actual'];
						}
					}
					else
					{
						$ccrowstyle = "style='background-color:#FAD8D8;'";
						$ccrowstyle2 = "style='background-color:#F5B7B1;'";
						$ccrowstyle3 = "style='background-color:#F1948A;'";					
						$complied = "<b>Yes</b>";
					}
					
					
					
				}
				elseif(($ccspecificres['actual'] == 0) && ($ccYear >= 2019) && ($ccyearres['standard'] == "Transportation"))
				{
					$complied = "N/A";
				}
				
				$ccshow = "";
				if($ccyearres['score_group'] == "Deduction")
				{
					$ccshow = $ccspecificres['actual'];
				}
				else
				{
					$ccshow = $ccyearres['deduction'];
				}
				
				$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
				$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
				
				if($ccYear >= 2019)
				{
					if($ccyearres['goal'] == "Regulatory")
					{
						$cctablereg .=	"<tr align='center' valign='center' ".$ccrowstyle.">" . 								 
											"<td>".$ccyearres['subgoal']."</td>" . 
											"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" .		
											"<td ".$ccrowstyle2.">".$complied."</td>" .
											"<td>".$ccspecificres['comments']."</td>" . 
										"</tr>";
					}
					elseif($ccyearres['goal'] == "Operational")
					{
						$cctablerop1 =	"<tr align='center' valign='center' ".$ccrowstyle.">" . 								 
											"<td>".$ccyearres['subgoal']."</td>" . 
											"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" .		
											"<td ".$ccrowstyle2.">".$complied."</td>" .
											"<td>".$ccspecificres['comments']."</td>" . 
										"</tr>";
						
						if($ccyearres['subgoal'] == "Incident Management")
						{
							$cctableopIM .= $cctablerop1;
						}
						elseif($ccyearres['subgoal'] == "Logistics")
						{
							$cctableopL .= $cctablerop1;
						}
						elseif($ccyearres['subgoal'] == "SG Management")
						{
							$cctableopSG .= $cctablerop1;
						}
						elseif($ccyearres['subgoal'] == "Administration")
						{
							$cctableopA .= $cctablerop1;
						}
							
						
					}
					
					/* $cctable .= "<tr align='center' valign='center' ".$ccrowstyle.">" . 								 
								"<td>".$ccyearres['subgoal']."</td>" . 
								"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" .		
								"<td ".$ccrowstyle2.">".$complied."</td>" .
								"<td>".$ccspecificres['comments']."</td>" . 
							"</tr>"; */
				}
				elseif($ccYear < 2019)
				{
					$cctable .= "<tr align='center' valign='center' ".$ccrowstyle.">" . 								 
								"<td>".$ccyearres['reference']."</td>" . 
								"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
								"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" .								
								"<td ".$ccrowstyle2.">".$ccshow."</td>" . 
								"<td ".$ccrowstyle2.">".$complied."</td>" .
								"<td>".$ccspecificres['comments']."</td>" . 
							"</tr>";
				}
				else
				{
					$cctable .= "<tr align='center' valign='top' ".$ccrowstyle.">" . 								 
								"<td>".$ccyearres['reference']."</td>" . 
								"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
								"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" .								
								"<td ".$ccrowstyle2.">".$ccyearres['deduction']."</td>" . 
								"<td ".$ccrowstyle2.">".$ccspecificres['actual']."</td>" .
								"<td ".$ccrowstyle3."><b>".($ccyearres['deduction'] * $ccspecificres['actual'])."</b></td>" . 
								"<td>".$ccspecificres['comments']."</td>" . 
							"</tr>";
				}
				
			}
			
			$token = md5(rand(0,10000));
			
//			ini_set("SMTP","192.168.2.16");
//			ini_set("smtp_port","25");
//			$to = 'geralao.almera@yahoo.com';
//			$admin_name = 'admin';
//			$subject = 'sample sample sample';
//			$mainbody = 'mainbody';		
			
			/* link */
			$absoluteverificationlink = $url_base2."/concompverify.php?em=".trim($ccAgencyEmail)."&bu=".$bu."&sa=".$ccAgency."&ye=".$ccYear."&mo=".$ccMonth."&to=".$token."&cc=".$lccid;
		//	$absoluteverificationlink = $url_base2."concompverify.php?em=".trim($ccAgencyEmail)."&bu=".$bu."&sa=".$ccAgency."&ye=".$ccYear."&mo=".$ccMonth."&to=".$token."&cc=".$lccid;
			
			if($ccYear >= 2019)
			{
				$tableheaders = "";
				
				$cctable =	"<tr>" .
								"<td colspan='100%'>" .
									"<table width='100%' align='center'><tr><th style='font-size:1.5em;' align='left'>Regulatory Requirement</th></tr></table>" . 
									"<table width='100%' border='1' style='border-collapse:collapse;'>" .
										"<thead>" .
										"<tr style='background-color:#000; color:#FFF'>" .
											"<th>Requirement</th>" .
											"<th>Standard</th>" .
											"<th>Score</th>" .
											"<th>Comments</th>" .
										"</tr>" .
										"</thead>" .
										"<tbody>" .
											$cctablereg .
										"</tbody>" .										
									"</table>" .
									"<br>" .
									"<table width='95%' align='center'><tr><th style='font-size:1.5em;' align='left'>Operational Requirement</th></tr></table>" . 
									"<table width='100%' border='1' style='border-collapse:collapse;'>" .
										"<thead>" .
										"<tr style='background-color:#000; color:#FFF'>" .
											"<th>Requirement</th>" .
											"<th>Standard</th>" .
											"<th>Score</th>" .
											"<th>Comments</th>" .
										"</tr>" .
										"</thead>" .
										"<tbody>" .
											
											$cctableopIM .
											"<tr style='background-color:#ededed; '><th colspan='100%'>-</th></tr>" .
											$cctableopL .
											"<tr style='background-color:#ededed; '><th colspan='100%'>-</th></tr>" .
											$cctableopSG .
											"<tr style='background-color:#ededed; '><th colspan='100%'>-</th></tr>" .
											$cctableopA .
										"</tbody>" .										
									"</table>" .
								"</td>" .
							"</tr>";
				/* $tableheaders = "<th>Requirement</th>" .
								"<th>Standard</th>" .
								"<th>Score</th>" .
								"<th>Comments</th>"; */
			}
			elseif($ccYear == 2018)
			{
				$tableheaders = "<th>Reference</th>" .
								"<th>Standard</th>" .
								"<th>Details</th>" .
								"<th>%</th>" .								
								"<th>Non-<br>Compliance</th>" .
								"<th>Comments</th>";
			}
			else
			{
				$tableheaders = "<th>Reference</th>" .
								"<th>Standard</th>" .
								"<th>Details</th>" .
								"<th>Deduction</th>" .
								"<th>Frequency</th>" .
								"<th>Total<br>Deduction</th>" .
								"<th>Comments</th>";
			}
			
			$to = $ccAgencyEmail;
			$to2 = $oics;
			$subject = $ccagencyres['agency_name']." Contract Compliance - ".$bures['bu']." - ".$ccDisplayMonth." ".$ccYear;
			$mainbody ="<table width='95%' align='center' style='font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'>" .
							"<tr>" .
								"<td>" .
									"Contract Compliance Summary.<br><br>" .
									"To confirm, PLEASE CLICK <a href='".$absoluteverificationlink."&ch=2' target='_blank'>HERE</a><br><br>" .
									"If you have any questions or clarifications, PLEASE REPLY TO THIS EMAIL."	.
								"</td>" .
							"</tr>" .
							"<tr>" .
								"<td>" .
									"<table width='100%'>" .
										"<tr>" .
											"<td align='right'>Year:</td>" .
											"<td align='left'><b>".$ccYear."</b></td>" .
											"<td align='right'>Month:</td>" .
											"<td align='left'><b>".$ccDisplayMonth."</b></td>" .
											"<td align='right'>Business Unit:</td>" .
											"<td align='left'><b>".$bures['bu']."</b></td>" .
											"<td align='right'>Score:</td>" .
											$ccDisplayScore .
										"</tr>" .
									"</table>" .
								"</td>" .
							"</tr>" .
							"<tr>" .
								"<td>" .
									"<table width='100%' border='1' style='border-collapse:collapse;'>" .
										"<tr style='background-color:#000; color:#FFF'>" .
											$tableheaders .
										"</tr>" .
										$cctable .
									"</table>" .
								"</td>" .
							"</tr>" .
						"</table>";
			
			$mail = send_mail_agency($to,$subject,$mainbody,$to2); //OLD LINK
	//		$mail = send_mail_level0($to,$subject,$mainbody,$to2);
			
			mysqli_query($conn, "UPDATE cc_general SET sent = 1, token = '".$token."' WHERE id = ".$lccid);
			
			header("location:".$absoluteverificationlink."&ch=1&ae=".$oics."&san=".$ccagencyres['agency_name']);
		}
		else
		{
			header("location:user-admin.php?last=ConComp&test=".$sendtoagency);
		}
		
		// header("location:".$absoluteverificationlink."&ch=1&ae=".$oics."&san=".$ccagencyres['agency_name']);
		
		
	}
	elseif(!empty($_POST['btnNewCC']))
	{
		$CCYear = mysqli_real_escape_string($conn, $_POST['txtCCYear']);
		$CCMonth = mysqli_real_escape_string($conn, $_POST['selCCMonth']);
		$CCBU = mysqli_real_escape_string($conn, $_POST['selCCBU']);
		$CCSecAgency = mysqli_real_escape_string($conn, $_POST['selCCSecAgency']);
		$CCOIC = mysqli_real_escape_string($conn, $_POST['txtCCOIC']);
		$CCEmail = mysqli_real_escape_string($conn, $_POST['txtCCemail']);
		
		mysqli_query($conn, "INSERT INTO cc_mst (bu, agency, agency_oic, oic_email, year, month) VALUES('".$CCBU."', '".$CCSecAgency."', '".$CCOIC."', '".$CCEmail."', ".$CCYear.", '".$CCMonth."')")or die(mysqli_error($conn));
		//mysqli_query($conn, "INSERT INTO cc_mst (bu, agency, agency_oic, oic_email, year, month) VALUES('2', '2', 'asdf', 'ghjk', 2019, '4')")or die(mysqli_error($conn));
		header("location:user-superadmin.php?last=ConComp");
	}
	elseif((isset($_POST['addCCNumbers'])) && !empty($_POST['addCCNumbers']))
	{
		$CCNumbers = explode("*~", $_POST['addCCNumbers']);
		$CCGoals = explode("*~", $_POST['addCCGoals']);
		$CCSubGoals = explode("*~", $_POST['addCCSubGoals']);
		$CCReferences = explode("*~", $_POST['addCCReferences']);
		$CCStandards = explode("*~", $_POST['addCCStandards']);
		$CCFrequencies = explode("*~", $_POST['addCCFrequencies']);
		$CCSources = explode("*~", $_POST['addCCSources']);
		$CCFormulas = explode("*~", $_POST['addCCFormulas']);
		$CCWeights = explode("*~", $_POST['addCCWeights']);
		$CCFactors = explode("*~", $_POST['addCCFactors']);
		$CCID = $_POST['addCCMasterNumber'];

		$ccweightsql = mysqli_query($conn, "SELECT * FROM cc_mst WHERE id = ".$CCID);
		$ccweightres = mysqli_fetch_assoc($ccweightsql);
		$CCTotalWeight = $ccweightres['total_weight'];
		for($i=1, $count = count($CCNumbers);$i<$count;$i++)
		{
			mysqli_query($conn, "INSERT INTO contract_compliance (number, goal, subgoal, reference, standard, frequency, source, formula, factor, weight, ccid) VALUES(".$CCNumbers[$i].", '". mysqli_real_escape_string($conn, $CCGoals[$i]) ."', '". mysqli_real_escape_string($conn, $CCSubGoals[$i]) ."', '". mysqli_real_escape_string($conn, $CCReferences[$i]) ."', '". mysqli_real_escape_string($conn, $CCStandards[$i]) ."', '". mysqli_real_escape_string($conn, $CCFrequencies[$i]) ."', '". mysqli_real_escape_string($conn, $CCSources[$i]) ."', '". mysqli_real_escape_string($conn, $CCFormulas[$i]) ."', ". mysqli_real_escape_string($conn, $CCFactors[$i]) .", ". mysqli_real_escape_string($conn, $CCWeights[$i]) .", ".$CCID.")")or die(mysqli_error($conn));

			$CCTotalWeight += $CCWeights[$i];
		}
		mysqli_query($conn, "UPDATE cc_mst SET total_weight = ".$CCTotalWeight." WHERE id = ".$CCID);
		header("location:user-superadmin.php?last=ConComp");
	}
	elseif((isset($_POST['newCCNumbers'])) && !empty($_POST['newCCNumbers']))
	{
		$CCNumbers = explode("*~", $_POST['newCCNumbers']);
		$CCGoals = explode("*~", $_POST['newCCGoals']);
		$CCSubGoals = explode("*~", $_POST['newCCSubGoals']);
		//$CCReferences = explode("*~", $_POST['newCCReferences']);
		$CCStandards = explode("*~", $_POST['newCCStandards']);
		$CCDetails = explode("*~", $_POST['newCCDetails']);
		$CCFrequencies = explode("*~", $_POST['newCCFrequencies']);
		//$CCSources = explode("*~", $_POST['newCCSources']);
		$CCDeductions = explode("*~", $_POST['newCCDeductions']);
		$CCYear = $_POST['selCCYear'];
		$CCGroup = explode("*~", $_POST['newCCGroups']);
		$CCHover = explode("*~", $_POST['newCCHovers']);
		
		/* for($i=1, $count = count($CCNumbers);$i<$count;$i++)
		{
			mysqli_query($conn, "INSERT INTO cc_template (number, goal, subgoal, reference, standard, details, frequency, source, deduction, year) VALUES(".$CCNumbers[$i].", '". mysqli_real_escape_string($conn, $CCGoals[$i]) ."', '". mysqli_real_escape_string($conn, $CCSubGoals[$i]) ."', '". mysqli_real_escape_string($conn, $CCReferences[$i]) ."', '". mysqli_real_escape_string($conn, $CCStandards[$i]) ."', '". mysqli_real_escape_string($conn, $CCDetails[$i]) ."', '". mysqli_real_escape_string($conn, $CCFrequencies[$i]) ."', '". mysqli_real_escape_string($conn, $CCSources[$i]) ."', '". mysqli_real_escape_string($conn, $CCDeductions[$i]) ."', '".$CCYear."')")or die(mysqli_error($conn));
		}	 */	
		
		/* for($i=1, $count = count($CCNumbers);$i<$count;$i++)
		{
			mysqli_query($conn, "INSERT INTO cc_template (number, goal, reference, standard, details, source, deduction, score_group, year, hovertext) VALUES(".$CCNumbers[$i].", '". mysqli_real_escape_string($conn, $CCGoals[$i]) ."', '". mysqli_real_escape_string($conn, $CCReferences[$i]) ."', '". mysqli_real_escape_string($conn, $CCStandards[$i]) ."', '". mysqli_real_escape_string($conn, $CCDetails[$i]) ."', '". mysqli_real_escape_string($conn, $CCSources[$i]) ."', '". mysqli_real_escape_string($conn, $CCDeductions[$i]) ."',  '". mysqli_real_escape_string($conn, $CCGroup[$i]) ."', '".$CCYear."', '". mysqli_real_escape_string($conn, $CCHover[$i]) ."')")or die(mysqli_error($conn));
		} */
		
		for($i=1, $count = count($CCNumbers);$i<$count;$i++)
		{
			mysqli_query($conn, "INSERT INTO cc_template (number, goal, subgoal, standard, details, frequency, deduction, score_group, year, hovertext) VALUES(".$CCNumbers[$i].", '". mysqli_real_escape_string($conn, $CCGoals[$i]) ."', '". mysqli_real_escape_string($conn, $CCSubGoals[$i]) ."', '". mysqli_real_escape_string($conn, $CCStandards[$i]) ."', '". mysqli_real_escape_string($conn, $CCDetails[$i]) ."', '". mysqli_real_escape_string($conn, $CCFrequencies[$i]) ."', '". mysqli_real_escape_string($conn, $CCDeductions[$i]) ."',  '". mysqli_real_escape_string($conn, $CCGroup[$i]) ."', '".$CCYear."', '". mysqli_real_escape_string($conn, $CCHover[$i]) ."')")or die(mysqli_error($conn));
		}	
		
		header("location:user-superadmin.php?last=ConComp");
	} 
	elseif ((isset($_POST['biddingName'])) && (isset($_POST['biddingCategory'])) && (isset($_POST['biddingexpiry']))) {
		$postBiddingName = explode("*~", mysqli_real_escape_string($conn, $_POST['biddingName']));
		$postBiddingCategory = explode("*~", $_POST['biddingCategory']);
		$postBiddingExpiry = explode("*~", $_POST['biddingexpiry']);
		$postBiddingWeightPercentage = explode("*~", $_POST["biddingPercentage"]);
		$postBiddingRating = explode("*~", $_POST["biddingRating"]);
		$postBiddingTotal = explode("*~", $_POST["biddingTotal"]);
		$postBiddingRemarks = explode("*~", mysqli_real_escape_string($conn, $_POST["biddingRemarks"]));

		$postTemplateID = $_POST['templateid'];
		for ($i = 1, $count = count($postBiddingName); $i < $count; $i++) {
			mysqli_query($conn, "INSERT INTO bidding_template_item (requirement_name, category, has_expiry, weight_percentage, remarks, rating, total, template_id) VALUES('" . $postBiddingName[$i] . "', '" . $postBiddingCategory[$i] . "', '" . $postBiddingExpiry[$i] . "', '" . $postBiddingWeightPercentage[$i] . "', '" . $postBiddingRemarks[$i] . "', '" . $postBiddingRating[$i] . "', '" . $postBiddingTotal[$i] . "', '" . $postTemplateID . "')") or die(mysqli_error($conn));
		}
		header("Location: user-superadmin.php?last=BidReq");
	}
	elseif((isset($_POST['CCEditID'])) && !empty($_POST['CCEditID']))
	{
		$CCID = mysqli_real_escape_string($conn, $_POST['CCEditID']);
		$CCNumber = mysqli_real_escape_string($conn, $_POST['txtEditCCNumber']);
		$CCGoal = mysqli_real_escape_string($conn, $_POST['txtEditCCGoal']);
		$CCSubGoal = mysqli_real_escape_string($conn, $_POST['txtEditCCSubGoal']);
		$CCReference = mysqli_real_escape_string($conn, $_POST['txtEditCCReference']);
		$CCStandard = mysqli_real_escape_string($conn, $_POST['txtEditCCStandard']);
		$CCFrequency = mysqli_real_escape_string($conn, $_POST['txtEditCCFrequency']);
		$CCSource = mysqli_real_escape_string($conn, $_POST['txtEditCCSource']);
		$CCFormula = mysqli_real_escape_string($conn, $_POST['selEditCCFormula']);
		$CCWeight = mysqli_real_escape_string($conn, $_POST['txtEditCCWeight']);
		$CCFactor = mysqli_real_escape_string($conn, $_POST['txtEditCCFactor']);
		$CCInitialweight = "";
		$CCBaseID = "";
		$CCNewTotalWeight = "";
		$sqlCCweight = mysqli_query($conn, "SELECT * FROM contract_compliance WHERE id = ".$CCID);
		$resCCweight = mysqli_fetch_assoc($sqlCCweight);
		$CCInitialweight = $resCCweight['weight'];
		$CCBaseID = $resCCweight['ccid'];
		mysqli_query($conn, "UPDATE contract_compliance SET number = '".$CCNumber."', goal = '".$CCGoal."', subgoal = '".$CCSubGoal."', reference = '".$CCReference."', standard = '".$CCStandard."', frequency = '".$CCFrequency."', source = '".$CCSource."', formula = '".$CCFormula."', weight = '".$CCWeight."', factor = '".$CCFactor."' WHERE id = ".$CCID);
		if($CCWeight == $CCInitialweight)
		{
			
		}
		else
		{
			$sqlBaseTotalWeight = mysqli_query($conn, "SELECT * FROM cc_mst WHERE id = ".$CCBaseID);
			$resBaseTotalWeight = mysqli_fetch_assoc($sqlBaseTotalWeight);
			$CCNewTotalWeight = $resBaseTotalWeight['total_weight'] - $CCInitialweight + $CCWeight;
			mysqli_query($conn, "UPDATE cc_mst SET total_weight = ".$CCNewTotalWeight." WHERE id = ".$CCBaseID);
		}
		header("location:user-superadmin.php?last=ConComp");
	}
	elseif((isset($_POST['txtCCYear3'])) && !empty($_POST['txtCCYear3']))
	{
		$CCYear3 = $_POST['txtCCYear3'];
		$CCMonth3 = $_POST['selCCMonth3'];
		$CCBU3 = $_POST['selCCBU3'];
		$CCSecAgency3 = $_POST['selCCSecAgency3'];
		$CCOIC3 = $_POST['txtCCOIC3'];
		$CCemail3 = $_POST['txtCCemail3'];
		$CCID3 = $_POST['addCCMasterNumber2'];
		
		mysqli_query($conn, "UPDATE cc_mst SET year = ".$CCYear3.", month = ".$CCMonth3.", bu = ".$CCBU3.", agency = ".$CCSecAgency3.", agency_oic = '".$CCOIC3."', oic_email = '".$CCemail3."' WHERE id = ".$CCID3)or die(mysqli_error($conn));
		header("location:user-superadmin.php?last=ConComp");
	}
	elseif(!empty($_POST['btnSubmitApproval']))	
	{		
		$retractstate = $_POST['txtRetractState'];
		$retractid = $_POST['txtRetractId'];
		$retractmainid = $_POST['txtRetractMainId'];
		$retractbu = $_POST['txtRetractBuId'];
		$retractlevel = $_POST['numApproveRetract'];
		$retractrequester = $_POST['txtRetractRequester'];
		$retractcomment = mysqli_real_escape_string($conn, $_POST['txtRetractComment']);
		$statusmsg = "";
		$submsg = "";
		
		if($retractstate == "approve")
		{
			mysqli_query($conn, "UPDATE ticket SET severity = ".$retractlevel." WHERE id = ".$retractid)or die(mysqli_error($conn));
			mysqli_query($conn, "UPDATE request_mst SET is_open = 0 WHERE id = ".$retractmainid)or die(mysqli_error($conn));
			$statusmsg = "Security alert level retraction for Incident Ticket Number: ".$retractid." has been approved. Alert level has been retracted to level ".$retractlevel.".";
			$submsg = "APPROVED";
		}
		elseif($retractstate == "reject")
		{
			mysqli_query($conn, "UPDATE request_mst SET is_open = 0 WHERE id = ".$retractmainid)or die(mysqli_error($conn));
			$statusmsg = "Security alert level retraction for Incident Ticket Number: ".$retractid." has been disapproved.";
			$submsg = "DISAPPROVED";
		}
		
		$to = "";		
		$recipients = array();
		$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$retractbu." AND slevel <= 1")or die(mysqli_error($conn));
		while($resoic = mysqli_fetch_assoc($sqloic))
		{
			$recipients[] = $resoic['email_ad'];			
		}
		
		$to = implode("*~", $recipients);		
		$subject = 'SMS TICKET #'.$retractid.' ALERT LEVEL RETRACTION '.$submsg;
		$narrative = preg_replace( "/\r|\n/", "<br>", $retractcomment );
		$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
						<tr align="center">
							<td colspan="100%" align="center">
								<h2 style="margin-bottom:0px; margin-top:0px;">SMS ALERT LEVEL RETRACTION</h2>								
							</td>
						</tr>
						<tr>
							<td colspan="100%">
								<table align="center" width="80%" style="border-collapse:collapse;" cellpadding="5px" >                                           											
									<tr>                          
										<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >STATUS:</td>
										<td style=" padding-left:20px; padding-right:20px;" >'.$statusmsg.'</td>
									</tr>									
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">COMMENT:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($narrative).'</td>
									</tr>											  
									<tr>
										<td width="15%" style="text-decoration:underline; text-align: right;">Requested by:</td>
										<td style=" padding-left:20px; padding-right:20px;">'.$retractrequester.'</td>
									</tr>												
								</table>
							</td>
						</tr>
					 </table>';
					 
		$mail = send_mail5($to,$subject,$mainbody);
		if($mail)
		{
			$mailtest = "SUCCESS";
		}
		else
		{
			$mailtest = "FAILED";
		}
		header("location:user-superadmin.php?last=divRequests");
	}
	elseif(!empty($_POST['btnSubmitDeletionApproval']))	
	{		
		$deletionstate = $_POST['txtDeletionState'];
		$deletionid = $_POST['txtDeletionId'];
		$deletionmainid = $_POST['txtDeletionMainId'];
		$deletionbu = $_POST['txtDeletionBuId'];		
		$deletionrequester = $_POST['txtDeletionRequester'];
		$deletioncomment = mysqli_real_escape_string($conn, $_POST['txtDeletionComment']);
		$reasonmsg = "";
		$statusmsg = "";
		$submsg = "";
		
		if($deletionstate == "approve")
		{
			mysqli_query($conn, "DELETE FROM ticket WHERE id = ".$deletionid)or die(mysqli_error($conn));
			mysqli_query($conn, "DELETE FROM log_mst WHERE ticket = ".$deletionid)or die(mysqli_error($conn));
			
			$attachmentunlinksql = mysqli_query($conn, "SELECT * FROM upload_mst WHERE ticket_id = ".$deletionid);
			while($attachmentunlinkres = mysqli_fetch_assoc($attachmentunlinksql))
			{
				unlink($attachmentunlinkres['upload_path']);
			}
			
			mysqli_query($conn, "DELETE FROM upload_mst WHERE ticket_id = ".$deletionid)or die(mysqli_error($conn));
						
			mysqli_query($conn, "UPDATE deletions_mst SET is_open = 0 WHERE id = ".$deletionmainid)or die(mysqli_error($conn));
			
			$reasonsql = mysqli_query($conn, "SELECT * FROM deletions_mst WHERE id = ".$deletionmainid)or die(mysqli_error($conn));
			$reasonres = mysqli_fetch_assoc($reasonsql);
			
			$reasonmsg = $reasonres['details'];
			
			$statusmsg = "Deletion request for Incident Ticket Number: ".$deletionid." has been approved.";
			$submsg = "APPROVED";
		}
		elseif($deletionstate == "reject")
		{
			mysqli_query($conn, "UPDATE request_mst SET is_open = 0 WHERE id = ".$deletionmainid)or die(mysqli_error($conn));
			$statusmsg = "Deletion request for Incident Ticket Number: ".$deletionid." has been disapproved.";
			$submsg = "DISAPPROVED";
		}
		
		$to = "";		
		$recipients = array();
		$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$deletionbu." AND slevel = 0")or die(mysqli_error($conn));
		while($resoic = mysqli_fetch_assoc($sqloic))
		{
			$recipients[] = $resoic['email_ad'];			
		}
		
		$to = implode("*~", $recipients);		
		$subject = 'SMS TICKET #'.$deletionid.' DELETION REQUEST '.$submsg;
		$narrative = preg_replace( "/\r|\n/", "<br>", $deletioncomment );
		$reasonnarrative = preg_replace( "/\r|\n/", "<br>", $reasonmsg );
		$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
						<tr align="center">
							<td colspan="100%" align="center">
								<h2 style="margin-bottom:0px; margin-top:0px;">SMS ALERT TICKET DELETION REQUEST</h2>								
							</td>
						</tr>
						<tr>
							<td colspan="100%">
								<table align="center" width="80%" style="border-collapse:collapse;" cellpadding="5px" >                                           											
									<tr>                          
										<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >STATUS:</td>
										<td style=" padding-left:20px; padding-right:20px;" >'.$statusmsg.'</td>
									</tr>
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">REASON:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($reasonnarrative).'</td>
									</tr>
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">COMMENT:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($narrative).'</td>
									</tr>											  
									<tr>
										<td width="15%" style="text-decoration:underline; text-align: right;">Requested by:</td>
										<td style=" padding-left:20px; padding-right:20px;">'.$deletionrequester.'</td>
									</tr>												
								</table>
							</td>
						</tr>
					 </table>';
					 
		$mail = send_mail5($to,$subject,$mainbody);
		if($mail)
		{
			$mailtest = "SUCCESS";
		}
		else
		{
			$mailtest = "FAILED";
		}
		header("location:user-superadmin.php?last=divRequests");
	}
	elseif(!empty($_POST['btnEditCCSave2']))	
	{
		$editCCGoal = $_POST["txtEditCCGoal2"];
		$editCCSubGoal = $_POST["txtEditCCSubGoal2"];
		$editCCNumber = $_POST["txtEditCCNumber2"];
//		$editCCReference = mysqli_real_escape_string($conn, $_POST["txtEditCCReference2"]);
		$editCCStandard = mysqli_real_escape_string($conn, $_POST["txtEditCCStandard2"]);
		$editCCDetails = mysqli_real_escape_string($conn, $_POST["txtEditCCDetails2"]);
		$editCCFrequency = mysqli_real_escape_string($conn, $_POST["txtEditCCFrequency2"]);
//		$editCCSource = mysqli_real_escape_string($conn, $_POST["txtEditCCSource2"]);
		$editCCDeduction = $_POST["txtEditCCDeduction2"];
//		$editCCGroup = $_POST["txtEditCCGroup2"];
		$editCCHover = $_POST["txtEditCCHover2"];
		$editCCID = $_POST["txtCCEditID2"];
		
//		mysqli_query($conn, "UPDATE cc_template SET goal = '".$editCCGoal."', subgoal = '".$editCCSubGoal."', number = ".$editCCNumber.", reference = '".$editCCReference."', standard = '".$editCCStandard."', details = '".$editCCDetails."', frequency = '".$editCCFrequency."', source = '".$editCCSource."', deduction = ".$editCCDeduction." WHERE id = ".$editCCID)or die(mysqli_error($conn));
		
//		mysqli_query($conn, "UPDATE cc_template SET goal = '".$editCCGoal."', number = ".$editCCNumber.", reference = '".$editCCReference."', standard = '".$editCCStandard."', details = '".$editCCDetails."', source = '".$editCCSource."', deduction = ".$editCCDeduction.", score_group = '".$editCCGroup."', hovertext = '".$editCCHover."' WHERE id = ".$editCCID)or die(mysqli_error($conn));

		mysqli_query($conn, "UPDATE cc_template SET goal = '".$editCCGoal."', subgoal = '".$editCCSubGoal."', number = ".$editCCNumber.", frequency = '".$editCCFrequency."', standard = '".$editCCStandard."', details = '".$editCCDetails."', deduction = ".$editCCDeduction.", hovertext = '".$editCCHover."' WHERE id = ".$editCCID)or die(mysqli_error($conn));
		
		header("location:user-superadmin.php?last=ConComp");
	} 
	elseif (!empty($_POST['btnEditBiddingSave'])) {
		$editBiddingExpiry = $_POST["txtEditBDExpiry"];
		$editBiddingCategory = $_POST["txtEditBDCategory"];
		$editBiddingRequirements = mysqli_real_escape_string($conn, $_POST["txtEditBDRequirement"]);
		$editBiddingWeightPercentage = $_POST["txtweightpercentage"];
		$editBiddingRating = $_POST["txtrating"];
		$editBiddingTotal = $_POST["txttotal"];
		$editBiddingRemarks = mysqli_real_escape_string($conn, $_POST["txtRemarks"]);
		$editBiddingID = $_POST["txtBiddingEditID"];

		mysqli_query($conn, "UPDATE bidding_template_item SET requirement_name = '" . $editBiddingRequirements . "', category = '" . $editBiddingCategory . "', has_expiry = '" . $editBiddingExpiry . "', weight_percentage = '" . $editBiddingWeightPercentage . "', rating = '" . $editBiddingRating . "', total = '" . $editBiddingTotal . "', remarks = '" . $editBiddingRemarks . "' WHERE id = " . $editBiddingID) or die(mysqli_error($conn));

		header("Location: user-superadmin.php?last=BidReq");
	} 
	elseif(!empty($_POST['btnSubmitClassification']))
	{
		$mainclasses = array();
		$mainclasses = $_POST['txtAddMainClass'];
		foreach($mainclasses as $classification)
		{
			mysqli_query($conn, "INSERT INTO incident_main_cat (main_cat) VALUES('". mysqli_real_escape_string($conn, $classification)."')")or die(mysqli_error($conn));
		}
		header("Location: user-superadmin.php?last=Entries");
	}
	elseif(!empty($_POST['btnSubmitClassificationEdit']))
	{
		$editmainclass = mysqli_real_escape_string($conn, $_POST['txtEditMainClass']);
		$editmainclassid = $_POST['txtEditMainClassId'];
		mysqli_query($conn, "UPDATE incident_main_cat SET main_cat = '".$editmainclass."' WHERE id = ".$editmainclassid);
		header("Location: user-superadmin.php?last=Entries");
	}
	elseif(!empty($_POST['btnSubmitClassificationSub']))
	{
		$mainclass = $_POST['selAddSubClass'];
		$subclass = mysqli_real_escape_string($conn, $_POST['txtAddSubClass']);
		
		mysqli_query($conn, "INSERT INTO incident_sub_cat (main_id, sub_cat) VALUES(".$mainclass.", '".$subclass."')");
		
		header("Location: user-superadmin.php?last=Entries");
	}
	elseif(!empty($_POST['btnSubmitClassificationSubEdit']))
	{
		$mainclassid = $_POST['selAddSubClass'];
		$editsubclass = mysqli_real_escape_string($conn, $_POST['txtAddSubClass']);
		$editsubclassid = $_POST['txtEditMainClassId'];
		
		mysqli_query($conn, "UPDATE incident_sub_cat SET main_id = ".$mainclassid.", sub_cat = '".$editsubclass."' WHERE id = ".$editsubclassid);
		
		header("Location: user-superadmin.php?last=Entries");
	}
	elseif(!empty($_POST['btnSubmitAudit']))
	{
		$bu_id = "";
		$audit_type = array();
		$audit_date = array();
		$category = array();
		$findings = array();
		$recommendations = array();
		$risk_impact = array();
		$risk_priority = array();
		$responsible = array();
		$commited_date = array();
		$actual_date = array();
		$status = array();
		
		$bu_id = $_POST['txtAuditBUID'];
		$audit_type = $_POST['selAuditType'];
		//$audit_type = mysqli_real_escape_string($conn, $_POST['selAuditType']);
		$audit_external = $_POST['txtAuditType'];
		$audit_date = $_POST['dateAuditDate'];
		$category = $_POST['selAuditCategory'];
		//$category = mysqli_real_escape_string($conn, $_POST['selAuditCategory']);
		$findings = $_POST['txtAuditFindings'];
		//$findings = mysqli_real_escape_string($conn, $_POST['txtAuditFindings']);
		$recommendations = $_POST['txtAuditRecommendations'];
		//$recommendations = mysqli_real_escape_string($conn, $_POST['txtAuditRecommendations']);
		$risk_impact = $_POST['txtPotentialRiskImpact'];
		//$risk_impact = mysqli_real_escape_string($conn, $_POST['txtPotentialRiskImpact']);
		$risk_priority = $_POST['selAuditRiskPriority'];
		$responsible = $_POST['txtAuditResponsible'];
		//$responsible = mysqli_real_escape_string($conn, $_POST['txtAuditResponsible']);
		$commited_date = $_POST['dateAuditCommitedDate'];
		$actual_date = $_POST['dateAuditActualDate'];
		$status = $_POST['selAuditStatus'];
		$disposition = $_POST['txtAuditDisposition'];
		//$disposition = mysqli_real_escape_string($conn, $_POST['txtAuditDisposition']);
		
		$editID = $_POST['txtAuditID'];
		
		for($i=0, $count  = count($findings); $i < $count; $i++ )
		{
			$actual_date2 = "'".$actual_date[$i]."'";
			if(empty($actual_date[$i]))
			{
				$actual_date2 = "null";
			}
			
			$disposition2 = "'".mysqli_real_escape_string($conn, $disposition[$i])."'";
			if(empty($disposition[$i]))
			{
				$disposition2 = "null";
			}
			
			$actual_type = $audit_type[$i];
			if(!empty($audit_external[$i]))
			{
				$actual_type = $audit_type[$i] ." - ". $audit_external[$i];
			}
			if($editID != 0)
			{
				mysqli_query($conn, "UPDATE audit_mst SET audit_type = '".mysqli_real_escape_string($conn, $actual_type)."', audit_date = '".$audit_date[$i]."', category = '".mysqli_real_escape_string($conn, $category[$i])."', findings = '".mysqli_real_escape_string($conn, $findings[$i])."', recommendations = '".mysqli_real_escape_string($conn, $recommendations[$i])."', risk_impact = '".mysqli_real_escape_string($conn, $risk_impact[$i])."', risk_priority = '".mysqli_real_escape_string($conn, $risk_priority[$i])."', responsible = '".$responsible[$i]."', commited_date = '".$commited_date[$i]."', actual_date = ".$actual_date2.", disposition = ".$disposition2.", status = '".mysqli_real_escape_string($conn, $status[$i])."' WHERE id = ".$editID)or die(mysqli_error($conn));
			}
			else
			{
				mysqli_query($conn, "INSERT INTO audit_mst (bu_id, audit_type, audit_date, category, findings, recommendations, risk_impact, risk_priority, responsible, commited_date, actual_date, disposition, status) VALUES(".$bu_id.", '".mysqli_real_escape_string($conn, $actual_type)."', '".$audit_date[$i]."', '".mysqli_real_escape_string($conn, $category[$i])."', '".mysqli_real_escape_string($conn, $findings[$i])."', '".mysqli_real_escape_string($conn, $recommendations[$i])."', '".mysqli_real_escape_string($conn, $risk_impact[$i])."', '".mysqli_real_escape_string($conn, $risk_priority[$i])."', '".$responsible[$i]."', '".$commited_date[$i]."', ".$actual_date2.", ".$disposition2.", '".mysqli_real_escape_string($conn, $status[$i])."')")or die(mysqli_error($conn));
			}
			
		}
		if($_SESSION['level'] == 'Super Admin'){
			header("Location: user-superadmin.php?last=Audit&audit_id=".$bu_id);
		}
		elseif($_SESSION['level'] == 'Admin'){
			header("Location: user-admin.php?last=Audit&audit_id=".$bu_id);
		}
		
	}
	elseif(!empty($_POST['btnAddAuditEvidence']))
	{
		/* $i2=0;
		$catch = "start";
		foreach($_FILES['evidenceattach1']['name'] as $attach)			
		{
			if($attach == ""){
				$path = "" ;
			}
			else{
				$path =  "audit/".$_POST['addauditid']."-".$attach;
			}
				
			if($path)
			{
				if($_POST['addaudittype'] == 1)
				{
					$unlinksql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE id = ".$_POST['addauditid']);
					$unlinkres = mysqli_fetch_assoc($unlinksql);
					unlink($unlinkres['evidence']);
				}
				elseif($_POST['addaudittype'] == 2)
				{
					$unlinksql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE id = ".$_POST['addauditid']);
					$unlinkres = mysqli_fetch_assoc($unlinksql);
					unlink($unlinkres['evidence']);
				}
				if(@copy($_FILES['evidenceattach1']['tmp_name'][$i2],$path))
				{
					if($_POST['addaudittype'] <= 1)
					{
						mysqli_query($conn, "UPDATE audit_mst SET evidence = '".$path."' WHERE id = ".$_POST['addauditid']);
						$catch = "uploadsuccess";
					}
					else
					{
						mysqli_query($conn, "UPDATE audit_mst SET evidence = '".$path."' WHERE id = ".$_POST['addauditid']);
						$catch = "uploadsuccess";
					}
				}
				else
				{
					$catch = "uploadfail ".$_FILES['userfile']['error'];
				}
			}				
			$i2++;
			$i++;
			
			
			
		} */		
		
		$i2=0;
		foreach($_FILES['evidenceattach1']['name'] as $attach){
			if($attach == ""){
				$path = "" ;
			}
			else{
				$path =  "audit/".$_POST['addauditid']."-".$attach;
			}
			
			if($path)
			{
				date_default_timezone_set('Asia/Manila');
				$datenow2 = date('Y-m-d H:i:s');
//				mysqli_query($conn, "INSERT INTO upload_mst(ticket_id, upload_path, uploaded_by, date_uploaded) VALUES(".$uploadId.", '".$path."', ".$_SESSION['id'].", '".$datenow2."')")or die(mysqli_error($conn));
				if($_POST['addaudittype'] == 3)
				{
					mysqli_query($conn, "INSERT INTO audit_uploads(audit_id, audit_upload_path, audit_uploaded_by, audit_upload_date, audit_upload_type) VALUES(".$_POST['addauditid'].", '".$path."', ".$_SESSION['id'].", '".$datenow2."', 3)")or die(mysqli_error($conn));
				}
				else
				{
					mysqli_query($conn, "INSERT INTO audit_uploads(audit_id, audit_upload_path, audit_uploaded_by, audit_upload_date) VALUES(".$_POST['addauditid'].", '".$path."', ".$_SESSION['id'].", '".$datenow2."')")or die(mysqli_error($conn));
				}
								
			}
			
			@copy($_FILES['evidenceattach1']['tmp_name'][$i2],$path);		
			$i2++;
		}
		
		$auditbusql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE id = ".$_POST['addauditid']);
		$auditbures = mysqli_fetch_assoc($auditbusql);
		
		
		if($_SESSION['level'] == 'Super Admin')
		{
			header("Location: user-superadmin.php?last=Audit&audit_id=".$auditbures['bu_id']);
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("Location: user-admin.php?last=Audit&audit_id=".$auditbures['bu_id']);
		}
	}
	elseif(!empty($_POST['txtAuditAddDisposition']))
	{
		$auditDisposition = mysqli_real_escape_string($conn, $_POST['txtAuditAddDisposition']);
		$auditDispositionType = $_POST['txtDispositionType'];
		$auditDispositionID = $_POST['auditDispositionID'];
		
		/* if($auditDispositionType == "Edit")
		{
			mysqli_query($conn, "UPDATE audit_mst SET disposition = '".$auditDisposition."' WHERE id = ".$auditDispositionID);
		}
		elseif($auditDispositionType == "Add")
		{
			mysqli_query($conn, "INSERT INTO audit_mst (disposition) VALUES('".$auditDisposition."')")or die(mysqli_error($conn));
		} */
		
		mysqli_query($conn, "UPDATE audit_mst SET disposition = '".$auditDisposition."' WHERE id = ".$auditDispositionID);
		
		$auditbusql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE id = ".$auditDispositionID);
		$auditbures = mysqli_fetch_assoc($auditbusql);
		
		if($_SESSION['level'] == 'Super Admin')
		{
			header("Location: user-superadmin.php?last=Audit&audit_id=".$auditbures['bu_id']);
			//header("Location: user-superadmin.php?d=".$auditDisposition);
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("Location: user-admin.php?last=Audit&audit_id=".$auditbures['bu_id']);
		}
		
	}
	elseif(!empty($_POST['btnStakeholderSave']))
	{
		
	}
	
	$processtime = microtime();
	$processtime = explode(' ', $processtime);
	$processtime = $processtime[1] + $processtime[0];
	$processfinish = $processtime;
	$processtotal_time = round(($processfinish - $processstart), 4);
	
}



//$busql = mysqli_query($conn, "select * from bu_mst where id ='".$_SESSION['bu']."'");
$logdate = date('Y-m-d');
$logtime = date('H:i:s');
//$activitysql = mysqli_query($conn, "select * from ticket where bu = $bu and ticket_type = 1 and dateadded=$logdate");
//$activitysql = mysqli_query($conn, "select * from ticket where bu = $bu and ticket_type = 2");
/* $activitysql = mysqli_query($conn, "select * from ticket where dateadded > DATE_SUB(now(), INTERVAL 2 DAY) order by datesubmitted desc");
$activitytable = "";
$incidenttable = "";
while($actres = mysqli_fetch_assoc($activitysql))
{
	$logid = "ticket" . $actres['id'];
	$addlogid = "addlog" . $actres['id'];
	$ticket_type = $actres['ticket_type'];
	
	if ($actres['is_open']==1)
	{
		//document.getElementById('date').value = new Date().toLocaleTimestring($conn, navigator.language, {hour: '2-digit', minute:'2-digit'})
		if($ticket_type == 1){
			$type = "Incidents";
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ". $actres['description']);
			if($queryTicketDesc)
			{
				$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
				$ticketdesc = $resTicketDesc['name'];
			}
			else
			{
				$ticketdesc =  $actres['description'];
			}
			//$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $actres['description'] ."', '". $ticket_type ."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', 1)\">Close Ticket</td>";
		}
		else{
			$type = "Activities";
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ". $actres['description']);
			if($queryTicketDesc)
			{
				$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
				$ticketdesc = $resTicketDesc['name'];
			}
			else
			{
				$ticketdesc =  $actres['description'];
			}
			//$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $actres['description'] ."', '". $ticket_type ."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', 2)\">Close Ticket</td>";
		}
		
		$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td>";
		
		
	}
	else
	{
		if($ticket_type == 1){
			$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$actres['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td colsepan='100%' style=\"cursor:pointer\" onclick=\"GenerateReport(".$actres['id'].");\">Generate Report</td>";
		}
		else{
			$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td class=\"addlog\" colspan=\"100%\">".$actres['dateclosed']."</td>";
		}
		//$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$actres['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"GenerateReport(".$actres['id'].");\">Generate Report</td>";
	}
	$actlogssql = mysqli_query($conn, "select * from log_mst where ticket = ". $actres['id'] ." order by date_created DESC, time_created DESC");
	$actlogtable = "";
	$lognum = mysqli_num_rows($actlogssql) + 1;
	$rownum = 1;
	while($actlogres = mysqli_fetch_assoc($actlogssql))
	{
		$result1 = mysqli_query($conn, "select * from urc_mst where id = '". $actlogres['urcid'] ."'");
			$urcres = mysqli_fetch_assoc($result1);
		$result2 = mysqli_query($conn, "select * from guard_personnel where id = '". $actlogres['gid'] ."'");
			$guardres = mysqli_fetch_assoc($result2);
		$result3 = mysqli_query($conn, "select * from location_mst where id = '". $actlogres['location'] ."'");
			$locres = mysqli_fetch_assoc($result3);
		$queryEncoder = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ". $actlogres['uid']);
		$resEncoder = mysqli_fetch_assoc($queryEncoder);
		
		$lognum -= 1;
		
		$remarksid = "remark" . $actlogres['id'];
		$attachmentid = "attachment". $actlogres['id'];
		$attachmentshow = "";
		if(($actlogres['upload1']) || ($actlogres['upload2']) || ($actlogres['upload3']))
		{
			//$attachmentdi = "attachment". $actlogres['id'];
			$attachmentshow .= "<table align=\"center\">";
			if($actlogres['upload1'])
			{
			  $attachmentshow .=   "<tr>
									  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload1'] ."\" /></td>
								   </tr>";
			}
			if($actlogres['upload2'])
			{
			  $attachmentshow .=   "<tr>
									  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload2'] ."\" /></td>
								   </tr>";
			}
			if($actlogres['upload3'])
			{
			  $attachmentshow .=   "<tr>
									  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload3'] ."\" /></td>
								   </tr>";
			}
			$attachmentshow .= "</table>";
		}
		else
		{
			$attachmentshow = "<table align=\"center\">
							     <tr>
								 	<td align=\"center\">No Attachments</td>
								 </tr>
							   </table>";
		}
		if($rownum == 1){
			//$rowcolor = "style=\"background-color: #BCD9FB;\"";
			$rowcolor = "altrows";
			$rownum = 0;
		}
		elseif($rownum == 0){
			//$rowcolor = "style=\"background-color: #FFFFCC;\"";
			$rowcolor = "";
			$rownum = 1;
		}
		$firstfour = array();		
		$firstfourinitial = explode(" ", $actlogres['remarks']);
		for($i = 0; $i <= 3; $i++)
		{
			$firstfour[] = $firstfourinitial[$i];
		}
		$firstfourfinal = implode(" ", $firstfour);
		$actlogtable .= "<tr align=\"center\" class='".$rowcolor."' >
							<td width=\"5%\">". $lognum ."</td>
							<td width=\"20%\">". $locres['location'] ."</td>
							<td width=\"35%\" onclick=\"showLogs('". $remarksid ."')\" style=\"cursor:pointer\">". $firstfourfinal ."...</td>
							<td width=\"10%\">". $actlogres['date_created'] ."</td>
							<td width=\"10%\">". $actlogres['time_created'] ."</td>
							<td width=\"20%\">". $guardres['fname'] ." ". $guardres['lname'] ."</td>
						 </tr>";
		$actlogtable .= "<tr align=\"center\" class='".$rowcolor."'>
							<td width=\"100%\" colspan=\"100%\">
								<div id=\"". $remarksid ."\" class=\"logs2\" style=\"display:none;\">
									<table width=\"70%\">
									<tr>
										<td colspan=\"100%\">
										Narration:
										</td>
									</tr>
									<tr>
										<td colspan=\"100%\" align=\"center\">                                    	
											<textarea style=\"width:95%; height:150px; resize:none\" readonly=\"readonly\" >". $actlogres['remarks'] ."</textarea>
										</td>
									</tr>
									<tr>
										<td align=\"left\">
											<label style=\"text-decoration:underline; cursor:pointer; color:#00F;\" onclick=\"showAttachments('".$attachmentid."');\" >Show Attachments</label>
										</td>
										<td align=\"right\">
											Encoded by: ".$resEncoder['lname'].", ".$resEncoder['fname']." ".$resEncoder['mi'].".
										</td>
									</tr>
									</table>
									<div id=\"". $attachmentid ."\" style=\"display:none;\">
										".$attachmentshow."
									</div>
								</div>
							</td>
						</tr>";
	}
	if (empty($actlogtable)){
		$actlogtable = "<tr>
							<td align=\"center\" colspan=\"100%\">No log entries</td>
						</tr>";
	}
	$queryTicketBU = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$actres['bu']);
		$resTicketBU = mysqli_fetch_assoc($queryTicketBU);
	$activitylogs = "";
	if($ticket_type == 1){
		$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ". $actres['description']);
		if($queryTicketDesc)
		{
			$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
			$ticketdesc = $resTicketDesc['name'];
		}
		else
		{
			$ticketdesc =  $actres['description'];
		}
		$incidenttable .= "<tr align=\"center\" bgcolor=\"#000000\" style=\"color:#FFF\">
        <td >". $actres['id'] ."</td>
        <td >". $actres['dateadded'] ."</td>
		<td >". $resTicketBU['bu'] ."</td>
		<td >". ($actres['severity'] == 0 ? $resTicketDesc['defaultlevel'] : $actres['severity']) ."</td>
        <td ><label onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</label></td>
        ". $stat ."        
		</tr>
		<tr>
		  <td colspan=\"100%\" align=\"center\">
			  <div id=\"". $logid ."\" class=\"logs\" style=\"display:none\">
				  <table width=\"100%\">
				  	<tr>
						<th>#</th>
						<th>Location</th>
						<th>Narratiom</th>
						<th>Date</th>
						<th>Time</th>
						<th>Guard</th>
					</tr>
					". $actlogtable ."
				  </table>
			  </div>
			  
		  </td>
		</tr>";
	}
	else{
		$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ". $actres['description']);
		if($queryTicketDesc)
		{
			$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
			$ticketdesc = $resTicketDesc['name'];
		}
		else
		{
			$ticketdesc =  $actres['description'];
		}
		
	$activitytable .= "<tr align=\"center\" bgcolor=\"#000000\" style=\"color:#FFF\">
        <td >". $actres['id'] ."</td>
        <td >". $actres['dateadded'] ."</td>
		<td >". $resTicketBU['bu'] ."</td>
        <td ><label onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</label></td>
        ". $stat ."        
      </tr>
	  <tr>
		<td colspan=\"100%\" align=\"center\">
			<div id=\"". $logid ."\" class=\"logs\" style=\"display:none\">
				<table width=\"100%\">
					<tr>
						<th>#</th>
						<th>Location</th>
						<th>Narration</th>
						<th>Date</th>
						<th>Time</th>
						<th>Guard</th>
					</tr>
				  ". $actlogtable ."
				</table>
			</div>
			
		</td>
	  </tr>";
	}
} */
$cat = "Dashboard";
$executejs = "";
if($_GET['last']){
	$cat = $_GET['last'];
	if($cat == "Audit")
	{
		$executejs = "auditShow('".$_GET['audit_id']."');";
	}
	elseif($cat == "IncAud")
	{
		$executejs = "showIACons();";
	}
}

/* $guardsql2 = mysqli_query($conn, "SELECT * FROM guard_personnel ORDER BY CASE bu WHEN ". $bu ." THEN 1 ELSE 2 END, bu, status, lname");
$guardstable = "";
$guardnum = 1;
$guardrow = 0;
while($guardres3 = mysqli_fetch_assoc($guardsql2)){
	if($guardrow==1){
		$rowclass = "class=\"altrows\"";
		$guardrow = 0;
	}
	elseif($guardrow==0){
		$rowclass = "";
		$guardrow = 1;
	}
	$glastname = $guardres3['lname'];
	$gfirstname = $guardres3['fname'];
	$gmiddlename = $guardres3['mname'];
	$gcontact = $guardres3['contact'];
	$gcode = $guardres3['guard_code'];	
	$gcode2 =  str_replace("'", "\\\'", str_replace('"', '&quot', $guardres3["guard_code"]));
	//$gcode2 = json_encode($gcode);
	$guardbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ". $guardres3['bu']);
	$guardbures = mysqli_fetch_assoc($guardbusql);
	$guardbu = $guardbures['bu'];
	$gstatus = $guardres3['status'];
	$gcomment2 = preg_replace( "/\r|\n/", "<br>", $guardres3['comment'] );	
//	$guarddata = array();
//	$guardarray = "";
//	foreach ($guardres3 as $gdata)
//	{
//		
//	}
	
		$editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". $gfirstname ." ". $glastname ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". str_replace("'", "\\\'", str_replace('"', '&quot', $guardres3['fname'])) ."', '". str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['mname'])) ."', '". str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['lname'])) ."', '". $guardres3['gender'] ."', '". $guardres3['birthdate'] ."', '". $guardres3['blood_type'] ."', '". $guardres3['civil_status'] ."', '". str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['present_address'])) ."', '". str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['provincial_address'])) ."', '". $guardres3['contact'] ."', '". $guardres3['bu'] ."', '". $guardres3['date_posted'] ."', '". $guardres3['agency_employment'] ."', '". $gcode2 ."', '". $guardres3['agency'] ."', '". str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_category'])) ."', '". str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['badge_number'])) ."', '". str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['license_number'])) ."', '". $guardres3['license_issue_date'] ."', '". $guardres3['license_expiry_date'] ."', '". $guardres3['performance'] ."', '". str_replace("'", "\\\'", str_replace('"', '&quot',$gcomment2)) ."', 'edit', '". $guardres3['id'] ."', '".$guardres3['status']."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_photo']))."');\" /></td>";
		//$editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". $gfirstname ." ". $glastname ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". $guardres3['fname'] ."', '". $guardres3['mname'] ."', '". $guardres3['lname'] ."', '". $guardres3['gender'] ."', '". $guardres3['birthdate'] ."', '". $guardres3['blood_type'] ."', '". $guardres3['civil_status'] ."', '". $guardres3['present_address'] ."', '". $guardres3['provincial_address'] ."', '". $guardres3['contact'] ."', '". $guardres3['bu'] ."', '". $guardres3['date_posted'] ."', '". $guardres3['agency_employment'] ."', '". str_replace("'", "\\\'", $guardres3['guard_code']) ."', '". $guardres3['agency'] ."', '". $guardres3['guard_category'] ."', '". $guardres3['badge_number'] ."', '". $guardres3['license_number'] ."', '". $guardres3['license_issue_date'] ."', '". $guardres3['license_expiry_date'] ."', '". $guardres3['performance'] ."', '". $gcomment2 ."', 'edit', '". $guardres3['id'] ."', '".$guardres3['status']."', '".$guardres3['guard_photo']."');\" /></td>";
		//$editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". $gfirstname ." ". $glastname ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". $guardres3['fname'] ."', '". $guardres3['mname'] ."', '". $guardres3['lname'] ."', '". $guardres3['gender'] ."', '". $guardres3['birthdate'] ."', '". $guardres3['blood_type'] ."', '". $guardres3['civil_status'] ."', '". $guardres3['present_address'] ."', '". $guardres3['provincial_address'] ."', '". $guardres3['contact'] ."', '". $guardres3['bu'] ."', '". $guardres3['date_posted'] ."', '". $guardres3['agency_employment'] ."', '". $guardres3['guard_code'] ."', '". $guardres3['agency'] ."', '". $guardres3['guard_category'] ."', '". $guardres3['badge_number'] ."', '". $guardres3['license_number'] ."', '". $guardres3['license_issue_date'] ."', '". $guardres3['license_expiry_date'] ."', '". $guardres3['performance'] ."', '". $gcomment2 ."', 'edit', '". $guardres3['id'] ."', '".$guardres3['status']."', '".$guardres3['guard_photo']."');\" /></td>";
		//$editbtn = '<td><img src="images/edit2.png" height="28px" title="EDIT '. $gfirstname .' '. $glastname .'" id="editguard" name="editguard" style="cursor:pointer;" onclick="guardInfo("'. $guardres3['fname'] .'", "'. $guardres3['mname'] .'", "'. $guardres3['lname'] .'", "'. $guardres3['gender'] .'", "'. $guardres3['birthdate'] .'", "'. $guardres3['blood_type'] .'", "'. $guardres3['civil_status'] .'", "'. $guardres3['present_address'] .'", "'. $guardres3['provincial_address'] .'", "'. $guardres3['contact'] .'", "'. $guardres3['bu'] .'", "'. $guardres3['date_posted'] .'", "'. $guardres3['agency_employment'] .'", "'. $guardres3['guard_code'] .'", "'. $guardres3['agency'] .'", "'. $guardres3['guard_category'] .'", "'. $guardres3['badge_number'] .'", "'. $guardres3['license_number'] .'", "'. $guardres3['license_issue_date'] .'", "'. $guardres3['license_expiry_date'] .'", "'. $guardres3['performance'] .'", "'. $gcomment2 .'", "edit", "'. $guardres3['id'] .'", "'.$guardres3['status'].'", "'.$guardres3['guard_photo'].'");" /></td>';
	
	
	$guardstable .= "<tr ". $rowclass ." align=\"center\">
						<td>". $guardnum ."</td>
						<td>". $glastname . "</td>
						<td>". $gfirstname . "</td>
						<td>". $gmiddlename . "</td>
						<td>". $gcode . "</td>
						<td>". $gcontact . "</td>
						<td>". $guardbu . "</td>
						<td>". $gstatus . "</td>
						". $editbtn ."
					 </tr>";
	$guardnum++;
} */

$code10table = "";
$code11table = "";
$codedctable = "";
$codetable = "";
$codepatable = "";
$codessql = mysqli_query($conn, "SELECT * FROM urc_mst ORDER BY series, codes");
while($coderes = mysqli_fetch_assoc($codessql)){
	$codes = $coderes['codes'];
	$codedesc = $coderes['description'];
	$codeseries = $coderes['series'];
	$coderestable = "<tr align=\"center\">
							<td>". $codes ."</td>
							<td align=\"center\" >". $codedesc ."</td>
							<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editCodeEntry('".$coderes['id']."', '".$codes."', '".$codedesc."');\" /></td>
							<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem(".$coderes['id'].",'CodeMgt');\" /></td>
						 </tr>";
	if($codeseries == "10-00"){
		$code10table .= $coderestable;
	}
	elseif($codeseries == "11-00"){
		$code11table .= $coderestable;
	}
	elseif($codeseries == "disposition"){
		$codedctable .= $coderestable;
	}
	elseif($codeseries == "codes"){
		$codetable .= $coderestable;
	}
	elseif($codeseries == "phonetic"){
		$codepatable .= $coderestable;
	}
	
}

$currentyear = date("Y");
$yeardropdown = "";
for($i = ($currentyear-25), $j = ($currentyear+25); $i <= $j; $i++)
{
	if($i == $currentyear)
	{
		$yeardropdown .= "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
	}
	else
	{
		$yeardropdown .= "<option value=\"".$i."\">".$i."</option>";
	}
	
}


// BIDDING TEMPLATE
$biddingtemplatenum = 1;
$biddingtemplatetable = '';
$biddingrequirementlist = '';
$biddingtemplatesql = mysqli_query($conn, "SELECT * FROM bidding_template ORDER BY created_at");
while ($biddingtemplate = mysqli_fetch_assoc($biddingtemplatesql)) {
	$biddingrequirementlist .= "<option value=\"" . $biddingtemplate['id'] . "\">" . $biddingtemplate['bidding_name'] . "</option>";
	$biddingtemplatetable .= "<tr align=\"center\">
							<td>" . $biddingtemplatenum . "</td>
							<td align=\"center\" >" . $biddingtemplate['bidding_name'] . "</td>
							<td align=\"center\" >" . $biddingtemplate['status'] . "</td>
							<td>
								<a href=\"javascript:void(0)\" style=\"color: green\" onclick=\"showBiddingItem('" . $biddingtemplate['id'] . "');\">Edit</a> | 
								
								<a href=\"javascript:void(0)\" style=\"color: red\" onclick=\"deleteItem('" . $biddingtemplate['id'] . "','BidReq');\" >Delete</a>
							</td>
						 </tr>";
	$biddingtemplatenum++;
}

// BIDDING DOCUMENTS
$biddingdocstable = "";
$biddingdocsnum = 1;
$biddingdocssql = mysqli_query($conn, "SELECT * FROM bidding_docs");
while ($biddingdocsresult = mysqli_fetch_assoc($biddingdocssql)) {
	$biddingdocstable .= "<tr align=\"center\">" .
		"<td>" . $biddingdocsnum . "</td>" .
		"<td>" . $biddingdocsresult['file_name'] . "</td>" .
		"<td>" . strtoupper($biddingdocsresult['type']) . "</td>" .
		"<td><a target=\"_blank\" href=\"" . $biddingdocsresult['file_path'] . "\"><img src=\"images/view.png\" height=\"20px\" style=\"cursor:pointer;\" ]\"><a/></td>" .
	"<td><img src=\"images/edit2.png\" height=\"20x\" style=\"cursor:pointer;\" onclick=\"addBiddingDocument('" . $biddingdocsresult['id'] . "', 'Edit', 'Group');\"></td>" .
		"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('" . $biddingdocsresult['id'] . "', 'BidDocs');\" /></td>" .
		"</tr>";
	$biddingdocsnum++;
}

// INITIALIZE BIDDING 
$biddingnum = 1;
$biddingtable = '';
$nomination_color = '';
$nomination_style = '';
$bidding_status_style = '';
$bidding_status_color = '';
$tr_color = '';
$tr_row_start = '';
$addAgencyStatus = '';

$biddingsql = mysqli_query($conn, "SELECT bidding.*, cluster_group.name as cluster FROM bidding INNER JOIN cluster_group ON bidding.cluster_id = cluster_group.id WHERE bidding_status != 'Closed' ORDER BY bidding_status DESC");
while ($bidding = mysqli_fetch_assoc($biddingsql)) {

	if ($bidding['bidding_status'] == 'Nomination') {
		$addAgencyStatus = "<td data-column=\"Progress\" class=\"table-row__td\">
								<a href=\"javascript:void(0)\" style=\"cursor:pointer;\" onclick=\"biddingAddSecAgencyModal('" . $bidding['id'] . "');\">Add Security Agency</a>
							</td>";
		$bidding_status_style = 'status--yellow';
	
	} elseif ($bidding['bidding_status'] == 'Assessment') {
		$addAgencyStatus = "<td data-column=\"Progress\" class=\"table-row__td\">
								<a href=\"javascript:void(0)\" style=\"cursor:pointer;\" onclick=\"viewBiddingSecAgencyModal('" . $bidding['id'] . "');\">View Security Agency</a>
							</td>";
		$bidding_status_style = 'status--blue';
	}

	// 	<td align=\"center\" ><span style=\"background-color: " . $bidding_status_color . ";color: white; padding: 1px 8px;text-align: center; border-radius: 5px; font-size: 13px;\">" . $bidding['bidding_status'] . "</span></td>

	$biddingtable .= "<tr align=\"center\" height=\"15px\" style=\"font-weight: 500;\" class=\"table-row \" >
							<td  class=\"table-row__td\">" . $biddingnum . "</td>
							<td align=\"center\"  class=\"table-row__td\"><div class=\"table-row__info\"><p class=\"table-row__name\">" . $bidding['bidding_name'] . "</p></div></td>
							<td align=\"center\" class=\"table-row__td\"><div><p class=\"table-row__name\">" . $bidding['cluster'] . "</p></div></td>
							<td data-column=\"Policy status\" class=\"table-row__td\">
								<p class=\"table-row__p-status " . $bidding_status_style . " status\">" . $bidding['bidding_status'] .  "</p>
							</td>
							
							<td align=\"center\" class=\"table-row__td\">36 Points Requirement</td>
							" . $addAgencyStatus .  "
							<td data-column=\"Progress\" class=\"table-row__td\">
								<a href=\"javascript:void(0)\" style=\"cursor:pointer;\" onclick=\"viewEvaluateAgency('" . $bidding['id'] . "');\">Evaluate Documents</a>
							</td>
							<td data-column=\"Progress\" class=\"table-row__td\">
								<a href=\"\">View / Upload File(s)</a>
							</td>
						 </tr>";
	$nomination_color = '';
	$biddingnum++;
}

$incidentcount = 0;
$incidentcountsql = mysqli_query($conn,"SELECT COUNT(id) AS Incident_Count FROM ticket WHERE ticket_type = 1 AND MONTH(dateadded) = MONTH(now()) AND YEAR(dateadded) = YEAR(now());");
$incidentcountres = mysqli_fetch_assoc($incidentcountsql);
$incidentcount = $incidentcountres['Incident_Count'];


$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
$displaytotaltime =  'SQL query took '.$processtotal_time.' seconds. Page generated in '.$total_time.' seconds.';

eval('$body = "' . fetch_template('user-superadmin') . '";');

echo stripslashes($body);


?>


