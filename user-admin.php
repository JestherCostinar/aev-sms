<?php
ini_set("session.gc_maxlifetime", 10800);
ini_set("session.cookie_lifetime", 0);
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
elseif($_SESSION['level'] != 'Admin'){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
include("sendmail.php");
include("class.upload.php-master/src/class.upload.php");


$jsrefresh = md5(rand(0,10000));

$sqlDisplayUser = mysqli_query($conn, "SELECT u.*, b.bu AS buname FROM users_mst u LEFT JOIN bu_mst b ON u.bu = b.id WHERE u.id = ".$_SESSION['id']);
$resDisplayUser = mysqli_fetch_assoc($sqlDisplayUser);

$displayUsername = $resDisplayUser['email'];
$displayLevel = $resDisplayUser['level'];
if($displayLevel == "Admin")
{
	$displaylevel = "BU Security Head";
}
elseif($displayLevel == "Custom Admin")
{
	$displaylevel = "Admin";
}
//$displayBUName = $resDisplayUser['buname'];

$sqlDisplayBU = mysqli_query($conn, "SELECT bu FROM bu_mst WHERE id = ". $_SESSION['bu']);
$resDisplayBU = mysqli_fetch_assoc($sqlDisplayBU);

$displayBUName = $resDisplayBU['bu'];

$urcdatalist = "";
$urcsql = mysqli_query($conn, "SELECT * FROM urc_mst ORDER BY series, codes, description");
while($urcres2 = mysqli_fetch_assoc($urcsql))
{
	$urcdatalist .= "<option value=\"".$urcres2['id']."\">".$urcres2['codes']." : ". $urcres2['description'] ."</option>";
}

$locatorlink = "";
$realestatearray = array();
$realestateselect = "";
$realestatemainsql = mysqli_query($conn, "SELECT id FROM main_groups WHERE name = 'Real Estate Group'");
$realestatemainres = mysqli_fetch_assoc($realestatemainsql);
if($realestatemainres)
{
	$realestatebusql = mysqli_query($conn,"SELECT id FROM bu_mst WHERE main_group = ".$realestatemainres['id']);
	while($realestatebures = mysqli_fetch_assoc($realestatebusql))
	{
		$realestatearray[] = "'".$realestatebures['id']."'";
	}
	//$realestateselect = implode(", ", $realestatearray);
	if(in_array("'".$bu."'", $realestatearray))
	{
		$locatorlink = "<li class=\"lists\" id=\"listlocactors\" onclick=\"toggleMe('Locators', 'listlocactors'); getLocators();\">Locators</li>";
	}
}







$locationdatalist = "";
$locationstable = "";
$locationnumber = 1;
$locationrow = 1;
$rowclass2 = "";
$locationarray = array();
$locsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE bu=$bu ORDER BY location_code");
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
	$locationstable .= "<tr ". $rowclass2 ." align=\"center\">" .
							"<td>". $locationnumber ."</td>" .
							"<td>". $headerBu ."</td>" .
							"<td>".$locres2['location_code']."</td>" .
							"<td>".$locres2['location']."</td>" .
							"<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit Location\" style=\"cursor:pointer;\" onclick=\"editLocation('".$locres2['location_code']."', '".$locres2['location']."', ".$locres2['id'].");\" /></td>" .
							"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem(".$locres2['id'].",'Locs');\" /></td>".
						"</tr>";
	$locationarray[] = $locres2['location'];
	$locationnumber++;
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
$guardsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu=".$guardbu." ORDER BY lname, fname, mname");
while($guardres2 = mysqli_fetch_assoc($guardsql)){
	$guardsdatalist .= "<option value=\"". $guardres2['lname'] .", ". $guardres2['fname'] . "\"></option>";
	$guardsdatalist2 .= "<option value=\"". $guardres2['id'] . "\">".  $guardres2['lname'] .", ". $guardres2['fname'] ."</option>";
	$guardsarray[] = $guardres2['lname'] .", ". $guardres2['fname'];
}

$oictable = "";
$oicnumber = 1;
$oicrow = 1;
$oicsql = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu=$bu ORDER BY bu, lname");
while($oicres = mysqli_fetch_assoc($oicsql)){
	if($oicrow==1){
		$oicrowclass = "class=\"altrows\"";
		$oicrow = 0;
	}
	elseif($oicrow==0){
		$oicrowclass = "";
		$oicrow = 1;
	}
	$oictable .= "<tr align=\"center\" ".$oicrowclass.">
						<td>".$oicnumber."</td>
						<td>".$oicres['lname'].", ".$oicres['fname']." </td>
						<td>".$oicres['email_ad']."</td>
						
						<td>".$headerBu."</td>
						<td>".$oicres['slevel']."</td>
						<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit Recipient\" style=\"cursor:pointer;\" onclick=\"editOic('".$oicres['fname']."', '".$oicres['lname']."', '".$oicres['email_ad']."', '".$oicres['id']."', '', '".$oicres['slevel']."')\" /></td>
						<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$oicres['id']."', 'SecAlert');\" /></td>
				  </tr>";
				  		$oicnumber++;
}

$userstable = "";
$usersnumber = 1;
$userssql = mysqli_query($conn, "SELECT * FROM users_mst WHERE bu=$bu ORDER BY lname");
while($usersres = mysqli_fetch_assoc($userssql)){
	$iconcolor = ($usersres['status'] == 'Active') ? "green" : "red";
	$userstable .= "<tr align=\"center\">
						<td>".$usersnumber."</td>".
						"<td>".$usersres['lname'].", ".$usersres['fname']." ".$usersres['mi']." </td>".
						"<td>".$usersres['gender']."</td>".
						"<td>".$usersres['email']."</td>".
						"<td>".$usersres['level']."</td>".
						"<td>".$headerBu."</td>".
						"<td>".$usersres['contact']."</td>".
						"<td>".$usersres['status']."</td>".
						"<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit User\" style=\"cursor:pointer;\" onclick=\"editUser('".$usersres['lname']."', '".$usersres['fname']."', '".$usersres['mi']."', '".$usersres['gender']."', '".$usersres['email']."', '".$usersres['level']."', '".$usersres['contact']."', '".$usersres['id']."')\" /></td>".
						"<td><img src=\"images/activate".$iconcolor.".png\" height=\"32px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$usersres['id']."', 'Users');\" /></td>".
				  "</tr>";
				  		$usersnumber++;
}

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
	$secagencyname = str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyres['agency_name']));
	$secagencyaddress = str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyres['address']));
	$secagencyoic = str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyres['oic']));
	$secagencycontact = str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyres['contact_number']));
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
							"<td><img src=\"images/View_Details.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"viewAgency('".$secagencyid."', '".str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyname))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyaddress))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyoic))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencycontact))."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyres['license_number']))."', '".$secagencyres['license_issued']."', '".$secagencyres['license_expiration']."', '".str_replace("'", "\\\'", str_replace('"', '&quot',$secagencyprofile))."', '".$secagencyres['contract_status']."')\"></td>";
	$secagencynum++;					
}

$secinactiveagencytable = "";
$secagencynum = 1;
$secagencyrow = 1;
$secagencydatalist = "";
$secagencysql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE contract_status = 'Inactive' ORDER BY agency_name");
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
	$secagencyname = str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['agency_name']));
	$secagencyaddress = str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['address']));
	$secagencyoic = str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['oic']));
	$secagencycontact = str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['contact_number']));
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
	$secinactiveagencytable .= "<tr align=\"center\" " . $secagerowclass . ">" .
		"<td>" . $secagencynum . "</td>" .
		"<td>" . $secagencyname . "</td>" .
		"<td>" . $secagencyaddress . "</td>" .
		"<td>" . $secagencyoic . "</td>" .
		"<td>" . $secagencycontact . "</td>" .
		"<td>" . $secagencybunames . "</td>" .
		"<td>" . $secagencycontract . "</td>" .
		"<td><img src=\"images/View_Details.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"viewAgency('" . $secagencyid . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyname)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyaddress)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyoic)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencycontact)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['license_number'])) . "', '" . $secagencyres['license_issued'] . "', '" . $secagencyres['license_expiration'] . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyprofile)) . "', '" . $secagencyres['contract_status'] . "')\"></td>";
	$secagencynum++;
}

$secpoolagencytable = "";
$secagencynum = 1;
$secagencyrow = 1;
$secagencydatalist = "";
$secagencysql = mysqli_query($conn, "SELECT * FROM agency_mst ORDER BY agency_name");
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
	$secagencyname = str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['agency_name']));
	$secagencyaddress = str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['address']));
	$secagencyoic = str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['oic']));
	$secagencycontact = str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['contact_number']));
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
	$secpoolagencytable .= "<tr align=\"center\" " . $secagerowclass . ">" .
		"<td>" . $secagencynum . "</td>" .
		"<td>" . $secagencyname . "</td>" .
		"<td>" . $secagencyaddress . "</td>" .
		"<td>" . $secagencyoic . "</td>" .
		"<td>" . $secagencycontact . "</td>" .
		"<td>" . $secagencybunames . "</td>" .
		"<td>" . $secagencycontract . "</td>" .
		"<td><a href=\"javascript:void(0)\" style=\"color: blue\" onclick=\"poolAgency('" . $pollsecagencyid . "');\">POOL</a></td>" .
		"<td><img src=\"images/View_Details.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"viewAgency('" . $secagencyid . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyname)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyaddress)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyoic)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencycontact)) . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyres['license_number'])) . "', '" . $secagencyres['license_issued'] . "', '" . $secagencyres['license_expiration'] . "', '" . str_replace("'", "\\\'", str_replace('"', '&quot', $secagencyprofile)) . "', '" . $secagencyres['contract_status'] . "')\"></td>";
	$secagencynum++;
}

$budatalist = "";
$butable = "";
$bunumber = 1;
$bulistsql = mysqli_query($conn, "SELECT * FROM bu_mst");
while($bulistres = mysqli_fetch_assoc($bulistsql))
{
	$budatalist .= "<option value=\"".$bulistres['id']."\">".$bulistres['bu']."</option>";
	
	$bumaingroupsql = mysqli_query($conn, "SELECT * FROM main_groups WHERE id = ". $bulistres['main_group']);
	$bumaingroup = mysqli_fetch_assoc($bumaingroupsql);
	$buregionalsql = mysqli_query($conn, "SELECT * FROM regional_group WHERE id = ". $bulistres['regional_group']);
	$buregionalgroup = mysqli_fetch_assoc($buregionalsql);	
	$butable .= "<tr align=\"center\">" .
				"<td>".$bunumber."</td>" .
				"<td>".$bulistres['bu']."</td>" .
				"<td>".$bulistres['bu_code']."</td>" .
				"<td>".$bumaingroup['name']."</td>" .
				"<td>".$buregionalgroup['name']."</td>" .
				"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editBU('".$bulistres['id']."', '".$bulistres['bu']."', '".$bulistres['main_group']."', '".$bulistres['regional_group']."');\"></td>" .
				"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$bulistres['id']."', 'BUs');\" /></td>" .
				"</tr>";
	$bunumber++;
}

$multiplebudatalist = "";
$multiplebudatasel = "";
$multiplebudatalistsql = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id = ".$_SESSION['id']);
while($multiplebudatalistres = mysqli_fetch_assoc($multiplebudatalistsql))
{
	$bunamesql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$multiplebudatalistres['bu_id']);
	$bunameres = mysqli_fetch_assoc($bunamesql);
	$multiplebudatalist .= "<option value=\"".$multiplebudatalistres['bu_id']."\">".$bunameres['bu_code']."</option>";
}

$listOfIDQuery = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id ='" . $_SESSION['id'] . "'");

// Display the "ALL" option if there is multiple BU's
if(mysqli_num_rows($listOfIDQuery) > 1) {
	$multiplebudatalist .= "<option value=\"".'0'."\">".'ALL'."</option>";
}

if($multiplebudatalist)
{
//	$multiplebudatasel = "<br/><span style='padding-left:20px;'><select id='changebusel' name='changebusel'><option value=''></option>".$multiplebudatalist."</select><a style='cursor:pointer; text-decoration:underline; color:white;' onclick='changeBU();'>Switch BU</a><span>";
	$multiplebudatasel = "<br/><table width='90%' align='center' style='border-collapse:collapse; padding-right:10px;'><tr><td align='right'><select id='changebusel' name='changebusel'><option value=''></option>".$multiplebudatalist."</select></td></tr><tr><td align='right'><a style='cursor:pointer; text-decoration:underline; color:white;' onclick='changeBU();'>Switch BU</a></td></tr></table>";
}



$activityentriesdatalist = "";
$activityentriestable = "";
$activityentriesnum = 1;
$exprochecksql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ". $bu);
$exprocheckres = mysqli_fetch_assoc($exprochecksql);
$activityentriessql = mysqli_query($conn, "SELECT * FROM entries_activity WHERE status = 'Active' ORDER BY name");
while($activityentriesres = mysqli_fetch_assoc($activityentriessql))
{
	if(($exprocheckres['expro'] == 1) && ($activityentriesres['expro'] == 1))
	{
		$activityentriesdatalist .= "<option value=\"".$activityentriesres['id']."\">".$activityentriesres['name']."</option>";
	}
	elseif(($exprocheckres['expro'] == 0) && ($activityentriesres['expro'] == 0))
	{
		$activityentriesdatalist .= "<option value=\"".$activityentriesres['id']."\">".$activityentriesres['name']."</option>";
	}
	$activityentriestable .= "<tr align=\"center\">" .
						"<td>".$activityentriesnum."</td>" .
						"<td>".$activityentriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$activityentriesres['id']."', '".$activityentriesres['name']."', 'Activity');\"></td>" .
						"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$activityentriesres['id']."', 'ActivityInput');\" /></td>" .
					 "</tr>";
	$activityentriesnum++;
}

$incidententriesdatalist = "";
$incidententriestable = "";
$incidententriesnum = 1;
$incidententriessql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE status = 'Active' ORDER BY name");
while($incidententriesres = mysqli_fetch_assoc($incidententriessql))
{
	$incidententriesdatalist .= "<option title=\"Sample sample sample sample	\" value=\"".$incidententriesres['id']."\">".$incidententriesres['name']."</option>";
	$incidententriestable .= "<tr align=\"center\">" .
						"<td>".$incidententriesnum."</td>" .
						"<td>".$incidententriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$incidententriesres['id']."', '".$incidententriesres['name']."', 'Incident');\"></td>" .
						"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$incidententriesres['id']."', 'IncidentInput');\" /></td>" .
					 "</tr>";
	$incidententriesnum++;
}

/* $exproentriesdatalist = "";
$exproentriestable = "";
$exproentriesnum = 1;
$exproentriessql = mysqli_query($conn, "SELECT * FROM entries_expro WHERE status = 'Active' ORDER BY name");
while($exproentriesres = mysqli_fetch_assoc($exproentriessql))
{
	$exproentriesdatalist .= "<option value=\"".$exproentriesres['id']."\">".$exproentriesres['name']."</option>";
	$exproentriestable .= "<tr align=\"center\">" .
						"<td>".$exproentriesnum."</td>" .
						"<td>".$exproentriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$exproentriesres['id']."', '".$exproentriesres['name']."', 'EXPRO');\"></td>" .
						"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$exproentriesres['id']."', 'EXPROInput');\" /></td>" .
					 "</tr>";
	$exproentriesnum++;
} */
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

if($_SESSION['custom'] == 1)
{
	
	$custom_bu = "<select id='selRTBU' name='selRTBU' onchange='loadLocationGuard();'>
                        <option value='0'>All BUs</option>
                        ".$budatalist."
                    </select>";
	$custom_rgbu = "<select id='selRGBU' name='selRGBU'>
						<option value='0'>All BUs</option>
						".$budatalist."
					</select>";
	$custom_cc_list = "<li class=\"lists\" id=\"listconcomcons\" onclick=\"toggleMe('ConCompConsolidation', 'listconcomcons')\">Contract Compliance Summary</li>";
	$custom_cc_cons = '<div id="ConCompConsolidation" class="section">
							<div id="ccConsDisplayMain" name="ccConsDisplayMain">
								<table align="left" style="padding-left:24px;">
									<tr>
										<td align="left" style="font-weight:bold">Contract Compliance Summary <br><br></td>
									</tr>
									<tr>
										<td>
											Year: <input id="ccConsYear" name="ccConsYear" type="number" min="2017" style="width:50px;" value="2017">
											<img src="images/Search-icon.png" height="24px" id="btnShowCCCons" name="btnShowCCCons" title="Search CC" style="cursor:pointer; vertical-align:middle;" onclick="searchCCCons();">
										</td>
									</tr>
								</table>
								<br>
								<div id="ccConsDisplay" name="ccConsDisplay">
								</div>
							</div>
							<div id="ccConsDisplaySub" name="ccConsDisplaySub">
								
							</div>
						</div>';
	$custom_graphs = '<div id="ReportGeneratorGraph" class="section">
						<table align="center"  width="80%">
							<tr align="center">
								<td colspan="100%">
									<input type="radio" id="radioRGIncident" name="radioRGType" checked="checked" onclick="toggleReportChart(\'linkbu\', \'divSearchTotal\', \'y-axis_type\');" />Incident &nbsp;&nbsp;<input type="radio" id="radioRGActivity" name="radioRGType" onclick="toggleReportChart2(\'divSearchGuardGraph\', \'y-axis_guard2\');" />Activity
								</td>
							</tr>
						</table>
						<div id="divGraphSearchee">
						<table align="center"  width="90%">
							<tr>
								<td colspan="100%">
									<div id="divGraphLinks">
									<table width="100%" border="1" style="border-collapse:collapse;">
										 <tr align="center">
											<td id="linkbu" class="rglink whiteonblack" style="cursor:pointer;" onclick="toggleReportChart(\'linkbu\', \'divSearchTotal\', \'y-axis_type\');">By Business Unit</td>
											<td id="linktype" class="rglink" style="cursor:pointer" onclick="toggleReportChart(\'linktype\', \'divSearchType\', \'y-axis_bu\');">By Incident Type</td>
											<td id="linkloc" class="rglink" style="cursor:pointer" onclick="toggleReportChart(\'linkloc\', \'divSearchLocation\', \'y-axis_location\');">By Location</td>
											<td id="linkguard" class="rglink" style="cursor:pointer" onclick="toggleReportChart(\'linkguard\', \'divSearchGuardGraph\', \'y-axis_guard\');">By Guard</td>
										</tr>
									</table>
									</div>
									
								</td>
							</tr>
							<tr align="center">
								<td>
									<table align="center">
										<tr>
											<td width="50%">
												<table>
													<tr>
														<td >
															Date:
														</td>
														<td >
															<input type="date" id="txtRGDateStart" name="txtRGDateStart" value="'.$logdate.'" />&nbsp; to &nbsp;<input type="date" id="txtRGDateEnd" name="txtRGDateEnd" value="'.$logdate.'" />
														</td>                                        
													</tr>
												</table>
											</td>
											<td width="50%">
												<div id="divSearchTotal" class="divGraphCategory" >
												<table align="center">
													<tr>
														<td >
															Business Unit:
														</td>
														<td>
															<select id="selRGBU" name="selRGBU">
																<option value="0">All BUs</option>
																'.$budatalist.'
															</select>
														</td>                                        
													</tr>
												</table>
												</div>
												<div id="divSearchType" class="divGraphCategory" style="display:none;">
												<table align="center">
													<tr>
														<td >
															Incident Type:
														</td>
														<td >
															<select id="selRGIncident" name="selRGIncident" onchange="lockSelect();">
																<option value="0">All Incidents</option>
																'.$incidententriesdatalist.'
															</select>
														</td>
														<td >
															Business Unit:
														</td>
														<td>
															<select id="selRGBU4" name="selRGBU4" disabled="disabled">
																<option value="0">All BUs</option>
																'.$budatalist.'
															</select>
														</td>
													</tr>
												</table>
												</div>
												<div id="divSearchLocation" class="divGraphCategory" style="display:none;">
												<table align="center">
													<tr>
														<td >
															Business Unit:
														</td>
														<td>
															<select id="selRGBU2" name="selRGBU2" onchange="loadLocation();">
																<option value=""></option>
																'.$budatalist.'
															</select>                                            
														</td>
														<td>
															Location:
														</td>
														<td>
															<select id="selRGLoc" name="selRGLoc">
															</select>
														</td>                                        
													</tr>
												</table>
												</div>
												<div id="divSearchGuardGraph" class="divGraphCategory" style="display:none;">
												<table align="center">
													<tr>
														<td >
															Business Unit:
														</td>
														<td>
															<select id="selRGBU3" name="selRGBU3" onchange="loadGuard();">
																<option value=""></option>
																'.$budatalist.'
															</select>                                            
														</td>
														<td>
															Guard:
														</td>
														<td>
															<select id="selRGGuard" name="selRGGuard">
															</select>
														</td>                                        
													</tr>
												</table>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="100%" align="center">
									<button onclick="prepareChart();" class="redbutton" style="width:150px;">Generate Chart</button>
									<input id="searchGraph" type="hidden" value="y-axis_type" />
									
									<div id="chartTicks">                    	
									</div>
									<div id="chartData">
									</div>                    
								</td>
							</tr>
						</table>
						</div>
						<div id="GraphSearchee2">
							
						</div>
						<div id="divShowGraph">        
						<table align="center" width="95%">
							<tr>
								<td>
									<div id="chartdiv" >
										
									</div>
								</td>
							</tr>
						</table>
						</div>
					</div>';
}
else
{
	$custom_bu = "<input type='text' value='".$headerBu."' readonly='readonly' />
                    <input type='hidden' id='selRTBU' name='selRTBU' value='".$bu."' />";
	$custom_rgbu = "<input type='text' value='".$headerBu."' readonly='readonly'  />
					<input type='hidden' id='selRGBU' name='selRGBU' value='".$bu."' />
					<input type='hidden' id='selRGBU4' name='selRGBU4' value='".$bu."' />";
	$custom_cc_cons = "";
	$custom_cc_list = "";
	$custom_graphs = '<div id="ReportGeneratorGraph" class="section">
						<table align="center"  width="80%">
							<tr align="center">
								<td colspan="100%">
									<input type="radio" id="radioRGIncident" name="radioRGType" checked="checked" onclick="toggleReportChart(\'linkbu\', \'divSearchTotal\', \'y-axis_type\');" />Incident &nbsp;&nbsp;<input type="radio" id="radioRGActivity" name="radioRGType" onclick="toggleReportChart2(\'divSearchGuardGraph\', \'y-axis_guard2\');" />Activity
								</td>
							</tr>
						</table>
						<div id="divGraphSearchee">
						<table align="center"  width="90%">
							<tr>
								<td colspan="100%">
									<div id="divGraphLinks">
									<table width="100%" border="1" style="border-collapse:collapse;">
										 <tr align="center">
											<td id="linkbu" class="rglink whiteonblack" style="cursor:pointer;" onclick="toggleReportChart(\'linkbu\', \'divSearchTotal\', \'y-axis_type\');">Overview</td>                            
											<td id="linkloc" class="rglink" style="cursor:pointer" onclick="toggleReportChart(\'linkloc\', \'divSearchLocation\', \'y-axis_location\');">By Location</td>
											<td id="linkguard" class="rglink" style="cursor:pointer" onclick="toggleReportChart(\'linkguard\', \'divSearchGuardGraph\', \'y-axis_guard\');">By Guard</td>
										</tr>
									</table>
									</div>
									
								</td>
							</tr>
							<tr align="center">
								<td>
									<table align="center">
										<tr>
											<td width="50%">
												<table>
													<tr>
														<td >
															Date:
														</td>
														<td >
															<input type="date" id="txtRGDateStart" name="txtRGDateStart" value="'.$logdate.'" />&nbsp; to &nbsp;<input type="date" id="txtRGDateEnd" name="txtRGDateEnd" value="'.$logdate.'" />
														</td>                                        
													</tr>
												</table>
											</td>
											<td width="50%">
												<div id="divSearchTotal" class="divGraphCategory" >
												<table align="center">
													<tr>
														<td >
															Incident Type:
														</td>
														<td >
															<select id="selRGIncident" name="selRGIncident" onchange="lockSelect2();">
																<option value="0">All Incidents</option>
																'.$incidententriesdatalist.'
															</select>
														</td>
														<td >
															Business Unit:
														</td>
														<td>
															<input type="text" value="'.$headerBu.'" readonly="readonly"  />
															<input type="hidden" id="selRGBU" name="selRGBU" value="'.$bu.'" />
															<input type="hidden" id="selRGBU4" name="selRGBU4" value="'.$bu.'" />                                           
														</td>                                     
													</tr>
												</table>
												</div>                                
												<div id="divSearchLocation" class="divGraphCategory" style="display:none;">
												<table align="center">
													<tr>
														<td >
															Business Unit:
														</td>
														<td>
															<input type="text" value="'.$headerBu.'" readonly="readonly"  />
															<input type="hidden" id="selRGBU2" name="selRGBU2" value="'.$bu.'" />                                             
														</td>
														<td>
															Location:
														</td>
														<td>
															<select id="selRGLoc" name="selRGLoc">
															  <option value="0">All Locations</option>
															  '.$locationdatalist.'
															</select>
														</td>                                        
													</tr>
												</table>
												</div>
												<div id="divSearchGuardGraph" class="divGraphCategory" style="display:none;">
												<table align="center">
													<tr>
														<td >
															Business Unit:
														</td>
														<td>
															<input type="text" value="'.$headerBu.'" readonly="readonly"  />
															<input type="hidden" id="selRGBU3" name="selRGBU3" value="'.$bu.'" />                                             
														</td>
														<td>
															Guard:
														</td>
														<td>
															<select id="selRGGuard" name="selRGGuard">
																<option value="0">All Guards</option>
																'.$guardsdatalist2.'
															</select>
														</td>                                        
													</tr>
												</table>
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="100%" align="center">
									<button onclick="prepareChart();" class="redbutton" style="width:150px;">Generate Chart</button>
									<input id="searchGraph" type="hidden" value="y-axis_type" />
									
									<div id="chartTicks">                    	
									</div>
									<div id="chartData">
									</div>                    
								</td>
							</tr>
						</table>
						</div>
						<div id="GraphSearchee2">
							
						</div>
						<div id="divShowGraph">        
						<table align="center" width="95%">
							<tr>
								<td>
									<div id="chartdiv">
										
									</div>
								</td>
							</tr>
						</table>
						</div>
					</div>';
}

if($_POST)
{
	/* if((!empty($_POST['addguardstat'])) and ($_POST['addguardstat'] == "Add")){
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
		$gbu = $bu;
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
//		mysqli_query($conn,"INSERT INTO guard_personnel(fname, mname, lname, gender, birthdate, blood_type, civil_status, present_address, provincial_address, contact, bu, date_posted, agency_employment, guard_code, agency, guard_category, badge_number, license_number, license_issue_date, license_expiry_date, ntc_license, ntc_license_start, ntc_license_end, performance, comment, status, date_created) values('".$gfname."', '".$gmname."', '".$glname."', '".$ggender."', '".$gbirthdate."', '".$gbloodtype."', '".$gcivstat."', '".$gpreadd."', '".$gproadd."', '".$gaddcontact."', '".$gbu."', '".$gdateposted."', '".$gempagency."', '".$gaddcode."', '".$gagency."', '".$gcategory."', '".$gbadge."', '".$glicense."', '".$glicenseissue."', '".$glicenseexpiry."', '".$gntclicense."', '".$gntclicenseissue."', '".$gntclicenseexpiry."', '".$gperformance."', '".$gcomment."', 'Active', now())") or die(mysqli_error($conn));
		mysqli_query($conn,"INSERT INTO guard_personnel(fname, lname, bu, date_posted, guard_code, guard_category, license_number, license_issue_date, license_expiry_date, ntc_license, ntc_license_start, ntc_license_end, performance, comment, status, date_created) values('".$gfname."', '".$glname."', '".$gbu."', '".$gdateposted."', '".$gaddcode."', '".$gcategory."', '".$glicense."', '".$glicenseissue."', '".$glicenseexpiry."', '".$gntclicense."', '".$gntclicenseissue."', '".$gntclicenseexpiry."', '".$gperformance."', '".$gcomment."', 'Active', now())") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added guard personnel', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
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
				mysqli_query($conn, "update guard_personnel set guard_photo = 'guardphotos/".$handle->file_dst_name."' where id = ".$lguardid) or die(mysqli_error($conn));
				$handle->clean();
				
			  } else {
				echo 'error : ' . $handle->error;
			  }
			}
		header("Location: user-admin.php?last=GuardMgt");
	} */
//	elseif(!empty($_POST['btneditguard'])){
	if((!empty($_POST['editguardstat'])) and ($_POST['editguardstat'] == "Edit")){
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
		$gbu = $bu;
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
		$gntclicense = mysqli_real_escape_string($conn, $_POST['txtgntclicense']);
		$gntclicenseissue = $_POST['txtgntclicenseissue'];
		$gntclicenseexpiry = $_POST['txtgntclicenseexpiry'];
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
		
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited guard personnel #".$gaddid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
		header("Location: user-admin.php?last=GuardMgt") ;
	}
	elseif(!empty($_POST['btnsaveoic']))
	{
		$oiclname = mysqli_real_escape_string($conn,$_POST['oiclastname']);
		$oicfname = mysqli_real_escape_string($conn,$_POST['oicfirstname']);
	//	$oicmname = mysqli_real_escape_string($conn,$_POST['oicmiddlename']);
		$oicemail = mysqli_real_escape_string($conn,$_POST['oicemail']);
	//	$oiccontact = mysqli_real_escape_string($conn,$_POST['oiccontact']);
		mysqli_query($conn, "INSERT INTO oic_mst (fname, lname, email_ad, bu, slevel) VALUES('".$oicfname."', '".$oiclname."', '".$oicemail."', '".$bu."', '".$_POST['oicslevel']."')") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added security alert recipiebt', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
		header("Location: user-admin.php?last=SecAlert");
	}
	elseif(!empty($_POST['btneditoic']))
	{
		$oiclname = mysqli_real_escape_string($conn,$_POST['oiclastname']);
		$oicfname = mysqli_real_escape_string($conn,$_POST['oicfirstname']);
	//	$oicmname = mysqli_real_escape_string($conn,$_POST['oicmiddlename']);
		$oicemail = mysqli_real_escape_string($conn,$_POST['oicemail']);
	//	$oiccontact = mysqli_real_escape_string($conn,$_POST['oiccontact']);
		$oicid = mysqli_real_escape_string($conn,$_POST['oicid']);
		mysqli_query($conn, "UPDATE oic_mst SET fname = '".$oicfname."', lname = '".$oiclname."', email_ad = '".$oicemail."', slevel = '".$_POST['oicslevel']."' WHERE id = ". $oicid);
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited security alert receipient #".$oicid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-admin.php?last=SecAlert");
	}
	elseif(!empty($_POST['btnsaveuser'])){
		$adduserlname = mysqli_real_escape_string($conn, $_POST['userslastname']);
		$adduserfname = mysqli_real_escape_string($conn, $_POST['usersfirstname']);
		$addusermi = mysqli_real_escape_string($conn, $_POST['usersmi']);
		$addusergender = $_POST['selugender'];
		$adduserusername = mysqli_real_escape_string($conn, $_POST['usersusername']);
		$adduserlevel = $_POST['selaccess'];
		$addusercontact = mysqli_real_escape_string($conn, $_POST['userscontact']);
		$adduserpass = "password" . date("Y");
		mysqli_query($conn, "INSERT INTO users_mst(fname, mi, lname, bu, level, email, status, date_created, gender, contact, changepass, password) VALUES('".$adduserfname."', '".$addusermi."', '".$adduserlname."', '".$bu."', '".$adduserlevel."', '".$adduserusername."', 'Active', now(), '".$addusergender."', '".$addusercontact."', 1, '".md5($adduserpass)."')") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added new user', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-admin.php?last=Users");
		
	}
	elseif(!empty($_POST['btnedituser'])){
		$adduserlname = mysqli_real_escape_string($conn, $_POST['userslastname']);
		$adduserfname = mysqli_real_escape_string($conn, $_POST['usersfirstname']);
		$addusermi = mysqli_real_escape_string($conn, $_POST['usersmi']);
		$addusergender = $_POST['selugender'];
		$adduserusername = mysqli_real_escape_string($conn, $_POST['usersusername']);
		$adduserlevel = $_POST['selaccess'];
		$addusercontact = mysqli_real_escape_string($conn, $_POST['userscontact']);
		$adduserid = $_POST['usersid'];
		mysqli_query($conn, "UPDATE users_mst SET fname='".$adduserfname."', mi='".$addusermi."', lname='".$adduserlname."', bu='".$bu."', level='".$adduserlevel."', email='".$adduserusername."', status='Active', date_created=now(), gender='".$addusergender."', contact='".$addusercontact."' WHERE id='".$adduserid."' ") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited user #".$adduserid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-admin.php?last=Users");
		
	}
	elseif(!empty($_POST['btndisporev'])){
		$newdisposition = mysqli_real_escape_string($conn, $_POST['txtdisporev']);
		$dispoticketid = $_POST['hidticketid'];
		date_default_timezone_set('Asia/Manila');
		$datenow = date('Y-m-d H:i:s');
		mysqli_query($conn, "INSERT INTO disposition_revisions(disposition, ticket_id, user_id, edit_date) VALUES('".$newdisposition."', '".$dispoticketid."', '".$_SESSION['id']."', '".$datenow."')") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited disposition of ticket #".$adduserid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-admin.php?last=Incidents");
	}
	elseif((isset($_POST['txturc'])) && !empty($_POST['txturc']))
	{
		if((isset($_POST['txtOrigin'])) && !empty($_POST['txtOrigin']))
		{
			$gid = $_POST['txtguard'];
			$locid = $_POST['txtlocation'];
			$origin = $_POST['txtOrigin'];
			if($origin==1){ //if incident ticket is new / create incident ticket
				$ticketdescription = mysqli_real_escape_string($conn, $_POST['ticketName2']);
				$ticketdateadded = $_POST['ticketDate2'];
				$defaultseveritysql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$ticketdescription)or die(mysqli_error($conn));
				$defaultseverityres = mysqli_fetch_assoc($defaultseveritysql);
				mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted, location, responding_guard) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 1, now(), '".$locid."', '".$gid."')");
				$get_last_id2 = mysqli_fetch_array(mysqli_query($conn, "Select id from ticket order by id desc"));
				$ticket = $get_last_id2['id'];

				$uploadArray = array();
                		$attached_files = array();
                		$i2 = 0;
                		foreach ($_FILES['attach1']['name'] as $attach) {
                   		if ($attach == "") {
                        		$path = "";
                    		} else {
                        		$path =  "upload/" . $ticket . "-" . $attach;
                    		}

                    		if ($path) {
                        		date_default_timezone_set('Asia/Manila');
                        		$datenow2 = date('Y-m-d H:i:s');
                        		mysqli_query($conn, "INSERT INTO upload_mst(ticket_id, upload_path, uploaded_by, date_uploaded) VALUES(" . $ticket . ", '" . $path . "', " . $_SESSION['id'] . ", '" . $datenow2 . "')") or die(mysqli_error($conn));
                        		$uploadArray[] = $path;
                        		$attached_files[] = $path;
                    		}

                    		@copy($_FILES['attach1']['tmp_name'][$i2], $path);
                    		$i2++;
                		}

				mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added ticket entry #".$ticket."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
			}
			elseif($origin==0){ //incident ticket is existing / just add logs
				$ticket = $_POST['txtLogId'];
			}
		}
			// Determine severity start
			$severityarray = array();
			$severitysql = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$ticket);
			$severityres = mysqli_fetch_assoc($severitysql);
			if($severityres['ticket_type'] == 1)
			{
				$severityarray[] = $severityres['severity'];
				$severityfactors = $severityres['factors'];
				$inctypesql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$severityres['description']);
				$inctyperes = mysqli_fetch_assoc($inctypesql);
				$severityarray[] = $inctyperes['defaultlevel'];			
				$incInjury = $_POST['txtinjury'];
				$incPropDmg = $_POST['txtpropdmg'];
				$incPropLoss = $_POST['txtproploss'];
				$incWorkStop = $_POST['txtworkstop'];
				$incDeath = $_POST['txtdeath'];
				
				if($incInjury == 1)
				{
					$severityarray[] = $inctyperes['injury_minor'];
					
					if($severityfactors)
					{
						if((strpos($severityfactors, "Minor Injury")) || (strpos($severityfactors, "Serious Injury")))
						{
							
						}
						else
						{
							$severityfactors .= ", Minor Injury";
						}
					}
					else
					{
						$severityfactors .= "- Minor Injury";
					}
					
					
				}
				elseif($incInjury == 2)
				{
					$severityarray[] = $inctyperes['injury_serious'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Serious Injury"))
						{
							
						}
						elseif(strpos($severityfactors, "Minor Injury"))
						{
							$severityfactors = str_replace("Minor Injury", "Serious Injury", $severityfactors);
						}
						else
						{
							$severityfactors .= ", Serious Injury";
						}
					}
					else
					{
						$severityfactors .= "- Serious Injury";
					}
					
				}
				
				if($incPropDmg == 1)
				{
					$severityarray[] = $inctyperes['propertydmg_nc'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Damage to Property"))
						{
							
						}
						else
						{
							$severityfactors .= ", Damage to Property";
						}
					}
					else
					{
						$severityfactors .= "- Damage to Property";
					}
				}
				elseif($incPropDmg == 2)
				{
					$severityarray[] = $inctyperes['propertydmg_crit'];
					if($severityfactors)
					{
						if(strpos($severityfactors, "Damage to Property"))
						{
							if(strpos($severityfactors, "Critical Damage to Property"))
							{
								
							}
							else
							{
								$severityfactors = str_replace("Damage to Property", "Critical Damage to Property", $severityfactors);
							}
						}
						else
						{
							$severityfactors .= ", Critical Damage to Property";
						}
					}
					else
					{
						$severityfactors .= "- Critical Damage to Property";
					}
				}
				
				if($incPropLoss == 1)
				{
					$severityarray[] = $inctyperes['propertyloss_nc'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Loss of Property"))
						{
							
						}
						else
						{
							$severityfactors .= ", Loss of Property";
						}
					}
					else
					{
						$severityfactors .= "- Loss of Property";
					}
				}
				elseif($incPropLoss == 2)
				{
					$severityarray[] = $inctyperes['propertyloss_crit'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Loss of Property"))
						{
							if(strpos($severityfactors, "Critical Loss of Property"))
							{
								
							}
							else
							{
								$severityfactors = str_replace("Loss of Property", "Critical Loss of Property", $severityfactors);
							}
						}
						else
						{
							$severityfactors .= ", Critical Loss of Property";
						}
					}
					else
					{
						$severityfactors .= "- Critical Loss of Property";
					}
				}
				
				if($incWorkStop == 1)
				{
					$severityarray[] = $inctyperes['workstoppage'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Work Stoppage"))
						{
							
						}
						else
						{
							$severityfactors .= ", Work Stoppage";
						}
					}
					else
					{
						$severityfactors .= "- Work Stoppage";
					}
				}
				
				if($incDeath == 1)
				{
					$severityarray[] = $inctyperes['death_1'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Death"))
						{
							
						}
						else
						{
							$severityfactors .= ", Death";
						}
					}
					else
					{
						$severityfactors .= "- Death";
					}
				}
				elseif($incDeath == 2)
				{
					$severityarray[] = $inctyperes['death_2'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Death"))
						{
							if(strpos($severityfactors, "Multiple Deaths"))
							{
								
							}
							else
							{
								$severityfactors = str_replace("Death", "Multiple Deaths", $severityfactors);
							}
						}
						else
						{
							$severityfactors .= ", Multiple Deaths";
						}
					}
					else
					{
						$severityfactors .= "- Multiple Deaths";
					}
				}
				elseif($incDeath == 3)
				{
					$severityarray[] = $inctyperes['death_3'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Death"))
						{
							if(strpos($severityfactors, "Multiple Deaths"))
							{
								
							}
							else
							{
								$severityfactors = str_replace("Death", "Multiple Deaths", $severityfactors);
							}
						}
						else
						{
							$severityfactors .= ", Multiple Deaths";
						}
					}
					else
					{
						$severityfactors .= "- Multiple Deaths";
					}
				}
				
				$severityarray[] = 0;
				$currentseverity = max($severityarray);
				
				mysqli_query($conn, "UPDATE ticket SET severity = ".$currentseverity.", factors = '".$severityfactors."' WHERE id = ".$ticket)or die(mysqli_error($conn));
			}
			// Determine severity end
		
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
			mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added logbook entry #".$lid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
			
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
				
				/* $upload1 = '<a href="'.$url_base.'/'.$resemaillog['upload1'].'">'.$resemaillog['upload1'].'</a>';
				$upload2 = '<a href="'.$url_base.'/'.$resemaillog['upload2'].'">'.$resemaillog['upload2'].'</a>';
				$upload3 = '<a href="'.$url_base.'/'.$resemaillog['upload3'].'">'.$resemaillog['upload3'].'</a>'; */
				$upload1 = $resemaillog['upload1'];
				$upload2 = $resemaillog['upload2'];
				$upload3 = $resemaillog['upload3'];
				
				$to = "";
				$to2 = "";
				$recipients = array();
				$escalate = array();
				$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$resemailticket['bu']);
				while($resoic = mysqli_fetch_assoc($sqloic))
				{
					if($resoic['slevel'] <= 1)
					{
						$recipients[] = $resoic['email_ad'];
					}
					elseif($resoic['slevel'] <= $currentseverity)
					{
						$escalate[] = $resoic['email_ad'];
					}
				}
					
					$to = implode("*~", $recipients);
					$to2 = implode("*~", $escalate);
					if($alertdesc == "INCIDENT")
					{
						$subject = 'SECURITY '.$alertdesc.' LEVEL '.$currentseverity.': '.$what.' '.$bucontrolnum;
						$subheader = '<h3 style="margin-top:0px;">ALERT LEVEL '.$currentseverity.'</h3>';
						$locdisp = '-> '.$resemaillog['location'];
					}
					else
					{
						$subject = 'SECURITY '.$alertdesc.' REPORT: '.$what.' '.$bucontrolnum;
						$subheader = '';
						$locdisp = '';
					}
					$narrative = preg_replace( "/\r|\n/", "<br>", $resemaillog['remarks'] );
					$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
									<tr align="center">
										<td colspan="100%" align="center">
											<h2 style="margin-bottom:0px;">'.$alertdesc.' REPORT</h2>
											'.$subheader.'
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
													<td style=" padding-left:20px; padding-right:20px;">'.$resemaillog['bu'].' '.$locdisp.'</td>
												</tr>                      
												<tr>                          
													<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
													<td style=" padding-left:20px; padding-right:20px;"> '.$resemaillog['time_created'].', '.$emaildatecreated2.'</td>
												</tr>
												<tr>
													<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">NARRATIVE:</td>
													<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($narrative).'</td>
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
					
				// $sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$resemailticket['bu']);	
				// while($resoic = mysqli_fetch_assoc($sqloic))
				// {					
					//$mail = send_mail($resoic['email_ad'],$subject,$mainbody);
					// $mail = send_mail2($resoic['email_ad'],$subject,$mainbody,$upload1,$upload2,$upload3);
					$mail = send_mail3($to,$subject,$mainbody,$upload1,$upload2,$upload3,$to2, $attached_files);
					if($mail)
						{
							$mailtest = "SUCCESS";
						}
						else
						 {
							 $mailtest = "FAILED";
						 }
				// }
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
				header("Location: user-admin.php?last=Incidents&mail=".$mailtest);
			}
			elseif($log_type==2){
				header("Location: user-admin.php?last=Activities&mail=".$mailtest);
			}		
	}
	elseif((isset($_POST['txtactivityname'])) && !empty($_POST['txtactivityname']))
	{
		$ticketdescription = mysqli_real_escape_string($conn, $_POST['txtactivityname']);
		$ticketdateadded = $_POST['txtactivitydate'];
		mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 2, now())");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added dropdown entry', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-admin.php?last=Activities");
	}
	elseif((isset($_POST['txtaddlocationcodes'])) && !empty($_POST['txtaddlocationcodes']))
	{
		$codes = explode("*~", $_POST['txtaddlocationcodes']);
		$locations = explode("*~", $_POST['txtaddlocations']);
		for($i=1, $count = count($codes);$i<$count;$i++) {
			mysqli_query($conn, "INSERT INTO location_mst(location_code, location, bu) VALUES('". mysqli_real_escape_string($conn,$codes[$i]) ."', '". mysqli_real_escape_string($conn, $locations[$i]) ."', ". $bu .")");
			mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added new location', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		header("Location: user-admin.php?last=Locs");
	}
	elseif((isset($_POST['txtaddlocationcode'])) && !empty($_POST['txtaddlocationcode']))
	{
		$editlocationcode = mysqli_real_escape_string($conn,$_POST['txtaddlocationcode']);
		$editlocation = mysqli_real_escape_string($conn,$_POST['txtaddlocation']);
		$editlocationid = mysqli_real_escape_string($conn,$_POST['txtaddlocationid']);
		mysqli_query($conn, "UPDATE location_mst SET location_code = '". $editlocationcode ."', location = '". $editlocation ."' WHERE id = ". $editlocationid."");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited a location', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-admin.php?last=Locs");
	}
	//elseif((isset($_POST['txtincidentname'])) && !empty($_POST['txtincidentname']))
//	{
//		$ticketdescription = mysqli_real_escape_string($conn, $_POST['txtincidentname']);
//		$ticketdateadded = $_POST['txtincidentdate'];
//		mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 1, now())");
//		header("Location: user-admin.php?last=Incidents");
//	}
	elseif(!empty($_POST['btnUpload']))
	{
		$uploadId = $_POST['txtUploadTicketId'];
		$mailok = (!empty($_POST['uploadtobu']))? $_POST['uploadtobu']:0;
		
		$uploadArray = array();
		$i2=0;
		foreach($_FILES['attach1']['name'] as $attach){
			if($attach == ""){
				$path = "" ;
			}
			else{
				$path =  "upload/".$uploadId."-".$attach;
			}
			
			if($path)
			{
				date_default_timezone_set('Asia/Manila');
				$datenow2 = date('Y-m-d H:i:s');
				mysqli_query($conn, "INSERT INTO upload_mst(ticket_id, upload_path, uploaded_by, date_uploaded) VALUES(".$uploadId.", '".$path."', ".$_SESSION['id'].", '".$datenow2."')")or die(mysqli_error($conn));
				$uploadArray[] = $path;
			}
			
			@copy($_FILES['attach1']['tmp_name'][$i2],$path);		
			$i2++;
		}
		
		if(($mailok == 1) && ($uploadArray))
		{
			$uploadinfosql = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$uploadId)or die(mysqli_error($conn));
			$uploadinfores = mysqli_fetch_assoc($uploadinfosql);
			$alertdesc = "";
			$what = "";
			if($uploadinfores['ticket_type'] == 2)
			{
				$alertdesc = "ACTIVITY";
				$whatsql = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ".$uploadinfores['description']);
				$whatres = mysqli_fetch_assoc($whatsql);
				$what = $whatres['name'];
			}
			elseif($uploadinfores['ticket_type'] == 1)
			{
				$alertdesc = "INCIDENT";
				$whatsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$uploadinfores['description']);
				$whatres = mysqli_fetch_assoc($whatsql);
				$what = $whatres['name'];
			}
			
			$to = "";
			$to2 = "";
			$recipients = array();
			$escalate = array();
			$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$uploadinfores['bu'])or die(mysqli_error($conn));
			while($resoic = mysqli_fetch_assoc($sqloic))
			{
				if($resoic['slevel'] <= 1)
				{
					$recipients[] = $resoic['email_ad'];
				}
				elseif($resoic['slevel'] <= $uploadinfores['severity'])
				{
					$escalate[] = $resoic['email_ad'];
				}
			}
			
			$uploadbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$uploadinfores['bu']);
			$uploadbures = mysqli_fetch_assoc($uploadbusql);
			
			$bucontrolnum = $uploadbures['bu_code'].'-'.str_replace("-", "", $uploadinfores['dateadded']).'-'.$uploadinfores['id'];
						
			$get_last_date = mysqli_fetch_array(mysqli_query($conn, "SELECT date_uploaded FROM upload_mst ORDER BY id DESC"));
			$lid = strtotime($get_last_date['date_uploaded']);
			$emaildatecreated2 = date('h:i:sa, j F Y', $lid);
			
			$getlocationsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ".$uploadinfores['location']);
			$getlocationres = mysqli_fetch_array($getlocationsql);
			
			$to = implode("*~", $recipients);
			$to2 = implode("*~", $escalate);
			$uploads = implode("*~", $uploadArray);			
			if($alertdesc == "INCIDENT")
			{
				$subject = 'SECURITY '.$alertdesc.' LEVEL '.$uploadinfores['severity'].': '.$what.' '.$bucontrolnum;
				$subheader = '<h3 style="margin-top:0px;">ALERT LEVEL '.$uploadinfores['severity'].'</h3>';
				$locdisp = '-> '.$getlocationres['location'];
			}
			else
			{
				$subject = 'SECURITY '.$alertdesc.' REPORT: '.$what.' '.$bucontrolnum;
				$subheader = "";
				$locdisp = '';
			}
			
			//$narrative = preg_replace( "/\r|\n/", "<br>", $resemaillog['remarks'] );
			$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
							<tr align="center">
								<td colspan="100%" align="center">
									<h2 style="margin-bottom:0px;">'.$alertdesc.' REPORT</h2>
									'.$subheader.'
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
											<td style=" padding-left:20px; padding-right:20px;">'.$uploadbures['bu'].' '.$locdisp.'</td>
										</tr>                      
										<tr>                          
											<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
											<td style=" padding-left:20px; padding-right:20px;"> '.$emaildatecreated2.'</td>
										</tr>
										<tr>
											<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">UPDATE:</td>
											<td style=" padding-left:20px; padding-right:20px;">'.count($uploadArray).' file(s) attached to ticket.</td>
										</tr>											  
										<tr>
											<td width="15%" style="text-decoration:underline; text-align: right;">Uploaded by:</td>
											<td style=" padding-left:20px; padding-right:20px;">'.$userfull.'</td>
										</tr>																					
									</table>
								</td>
							</tr>
						 </table>';
				
				$mail = send_mail6($to,$subject,$mainbody,$uploads,$to2);
					if($mail)
						{
							$mailtest = "SUCCESS";
						}
						else
						 {
							 $mailtest = "FAILED";
						 }
		}
		header("Location: user-admin.php?last=Incidents");
	}
	elseif((isset($_POST['newpass'])) && !empty($_POST['newpass']))
	{
		$newpass = mysqli_real_escape_string($conn, $_POST['newpass']);
		mysqli_query($conn, "UPDATE users_mst SET password = '". md5($newpass) ."' WHERE id = ". $userid);
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Changed password', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-admin.php?last=Profile");		
	}
	elseif((isset($_POST['usercontactnew'])) && !empty($_POST['usercontactnew']))
	{
		$newcontact = mysqli_real_escape_string($conn, $_POST['usercontactnew']);
		mysqli_query($conn, "UPDATE users_mst SET contact = '". $newcontact ."' WHERE id = ". $userid);
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Changed contact number', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user-admin.php?last=Profile");
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
//					header("Location: user-admin.php?last=Incidents");
//				}
	elseif(!empty($_POST['btnSubmitChangeClassification']))
	{
		$incidentclass = mysqli_real_escape_string($conn, $_POST['selChangeClass']);
		$incidentid = mysqli_real_escape_string($conn, $_POST['txtChangeClassificationId']);
		$incidentretractlevel = (!empty($_POST['chkboxRetractLevel']))? $_POST['chkboxRetractLevel']:0;
		
		mysqli_query($conn, "UPDATE ticket SET description = '".$incidentclass."' WHERE id = ".$incidentid)or die(mysqli_error($conn));
		if($incidentretractlevel==1)
		{
			$changebothsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$incidentclass);
			$changebothres = mysqli_fetch_assoc($changebothsql);
			
			mysqli_query($conn, "UPDATE ticket SET severity = ".$changebothres['defaultlevel']." WHERE id = ".$incidentid)or die(mysqli_error($conn));
		}
		header("Location: user-admin.php?last=Incidents");
	}
	elseif((isset($_POST['txtIncidentDisposition'])) && !empty($_POST['txtIncidentDisposition']))
	{
		$logId2 = $_POST['swid'];
		
		if((isset($_POST['ifnamesall'])) && !empty($_POST['ifnamesall']))
		{
			$iclassificationsall = explode("*~", $_POST['iclassificationsall']);
			$ifnamesall = explode("*~", $_POST['ifnamesall']);
			$imnamesall = explode("*~", $_POST['imnamesall']);
			$ilnamesall = explode("*~", $_POST['ilnamesall']);
			$iaddressall = explode("*~", $_POST['iaddressall']);
			$icontactsall = explode("*~", $_POST['icontactsall']);
			$iageall = explode("*~", $_POST['iageall']);
			$igenderall = explode("*~", $_POST['igenderall']);
			$iheightall = explode("*~", $_POST['iheightall']);
			$iweightall = explode("*~", $_POST['iweightall']);
			$iremarksall = explode("*~", $_POST['iremarksall']);
			$iidtypeall = explode("*~", $_POST['iidtypeall']);
			$iidnumberall = explode("*~", $_POST['iidnumberall']);
			$ilocatorsall = explode("*~", $_POST['ilocatorsall']);
			for($i=1, $count = count($ifnamesall);$i<$count;$i++) {
				$iage = (!empty($iageall[$i]))? mysqli_real_escape_string($conn,$iageall[$i]):0;
				$iheight = (!empty($iheightall[$i]))? mysqli_real_escape_string($conn,$iheightall[$i]):0;
				$iweight = (!empty($iweightall[$i]))? mysqli_real_escape_string($conn,$iweightall[$i]):0;
				$ilocator = (!empty($ilocatorsall[$i]))? mysqli_real_escape_string($conn,$ilocatorsall[$i]):0;
			  //mysqli_query($conn, "INSERT INTO incident_witness (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$iwfnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwmnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwlnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwaddressall[$i])."', '".mysqli_real_escape_string($conn,$iwcontactsall[$i])."', '".mysqli_real_escape_string($conn,$iwageall[$i])."', '".mysqli_real_escape_string($conn,$iwgenderall[$i])."', '".mysqli_real_escape_string($conn,$iwheightall[$i])."', '".mysqli_real_escape_string($conn,$iwweightall[$i])."', '".mysqli_real_escape_string($conn,$iwremarksall[$i])."', now())");
				mysqli_query($conn, "INSERT INTO incident_involved_mst (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated, idType, idNumber, Class, locator_id) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$ifnamesall[$i])."', '".mysqli_real_escape_string($conn,$imnamesall[$i])."', '".mysqli_real_escape_string($conn,$ilnamesall[$i])."', '".mysqli_real_escape_string($conn,$iaddressall[$i])."', '".mysqli_real_escape_string($conn,$icontactsall[$i])."', '".$iage."', '".mysqli_real_escape_string($conn,$igenderall[$i])."', '".$iheight."', '".$iweight."', '".mysqli_real_escape_string($conn,$iremarksall[$i])."', now(), '".mysqli_real_escape_string($conn,$iidtypeall[$i])."', '".mysqli_real_escape_string($conn,$iidnumberall[$i])."', '".mysqli_real_escape_string($conn,$iclassificationsall[$i])."', ".$ilocator.")");			  
			}
		  //mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added witness(es) to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
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
		  $iwidtypeall = explode("*~", $_POST['iwidtypeall']);
		  $iwidnumberall = explode("*~", $_POST['iwidnumberall']);
		  for($i=1, $count = count($iwfnamesall);$i<$count;$i++) {
			  $iwage = (!empty($iwageall[$i]))? mysqli_real_escape_string($conn,$iwageall[$i]):0;
			  $iwheight = (!empty($iwheightall[$i]))? mysqli_real_escape_string($conn,$iwheightall[$i]):0;
			  $iwweight = (!empty($iwweightall[$i]))? mysqli_real_escape_string($conn,$iwweightall[$i]):0;
			  //mysqli_query($conn, "INSERT INTO incident_witness (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$iwfnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwmnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwlnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwaddressall[$i])."', '".mysqli_real_escape_string($conn,$iwcontactsall[$i])."', '".mysqli_real_escape_string($conn,$iwageall[$i])."', '".mysqli_real_escape_string($conn,$iwgenderall[$i])."', '".mysqli_real_escape_string($conn,$iwheightall[$i])."', '".mysqli_real_escape_string($conn,$iwweightall[$i])."', '".mysqli_real_escape_string($conn,$iwremarksall[$i])."', now())");
			  mysqli_query($conn, "INSERT INTO incident_witness (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated, idType, idNumber) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$iwfnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwmnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwlnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwaddressall[$i])."', '".mysqli_real_escape_string($conn,$iwcontactsall[$i])."', '".$iwage."', '".mysqli_real_escape_string($conn,$iwgenderall[$i])."', '".$iwheight."', '".$iwweight."', '".mysqli_real_escape_string($conn,$iwremarksall[$i])."', now(), '".mysqli_real_escape_string($conn,$iwidtypeall[$i])."', '".mysqli_real_escape_string($conn,$iwidnumberall[$i])."')");			  
		  }
		  //mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added witness(es) to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
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
		  $isidtypeall = explode("*~", $_POST['isidtypeall']);
		  $isidnumberall = explode("*~", $_POST['isidnumberall']);
		  for($i=1, $count = count($isfnamesall);$i<$count;$i++) {
			  $isage = (!empty($isageall[$i]))? mysqli_real_escape_string($conn,$isageall[$i]):0;
			  $isheight = (!empty($isheightall[$i]))? mysqli_real_escape_string($conn,$isheightall[$i]):0;
			  $isweight = (!empty($isweightall[$i]))? mysqli_real_escape_string($conn,$isweightall[$i]):0;
			  //mysqli_query($conn, "INSERT INTO incident_suspect (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$isfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ismnamesall[$i])."', '".mysqli_real_escape_string($conn,$islnamesall[$i])."', '".mysqli_real_escape_string($conn,$isaddressall[$i])."', '".mysqli_real_escape_string($conn,$iscontactsall[$i])."', '".mysqli_real_escape_string($conn,$isageall[$i])."', '".mysqli_real_escape_string($conn,$isgenderall[$i])."', '".mysqli_real_escape_string($conn,$isheightall[$i])."', '".mysqli_real_escape_string($conn,$isweightall[$i])."', '".mysqli_real_escape_string($conn,$isremarksall[$i])."', now())");
			  mysqli_query($conn, "INSERT INTO incident_suspect (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated, idType, idNumber) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$isfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ismnamesall[$i])."', '".mysqli_real_escape_string($conn,$islnamesall[$i])."', '".mysqli_real_escape_string($conn,$isaddressall[$i])."', '".mysqli_real_escape_string($conn,$iscontactsall[$i])."', '".$isage."', '".mysqli_real_escape_string($conn,$isgenderall[$i])."', '".$isheight."', '".$isweight."', '".mysqli_real_escape_string($conn,$isremarksall[$i])."', now(), '".mysqli_real_escape_string($conn,$isidtypeall[$i])."', '".mysqli_real_escape_string($conn,$isidnumberall[$i])."')");
		  }
		  //mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added suspect(s) to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
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
		  $ividtypeall = explode("*~", $_POST['ividtypeall']);
		  $ividnumberall = explode("*~", $_POST['ividnumberall']);
		  for($i=1, $count = count($ivfnamesall);$i<$count;$i++) {
			  $ivage = (!empty($ivageall[$i]))? mysqli_real_escape_string($conn,$ivageall[$i]):0;
			  $ivheight = (!empty($ivheightall[$i]))? mysqli_real_escape_string($conn,$ivheightall[$i]):0;
			  $ivweight = (!empty($ivweightall[$i]))? mysqli_real_escape_string($conn,$ivweightall[$i]):0;
			  //mysqli_query($conn, "INSERT INTO incident_victim (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$ivfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivmnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivlnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivaddressall[$i])."', '".mysqli_real_escape_string($conn,$ivcontactsall[$i])."', '".mysqli_real_escape_string($conn,$ivageall[$i])."', '".mysqli_real_escape_string($conn,$ivgenderall[$i])."', '".mysqli_real_escape_string($conn,$ivheightall[$i])."', '".mysqli_real_escape_string($conn,$ivweightall[$i])."', '".mysqli_real_escape_string($conn,$ivremarksall[$i])."', now())");
			  mysqli_query($conn, "INSERT INTO incident_victim (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated, idType, idNumber) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$ivfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivmnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivlnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivaddressall[$i])."', '".mysqli_real_escape_string($conn,$ivcontactsall[$i])."', '".$ivage."', '".mysqli_real_escape_string($conn,$ivgenderall[$i])."', '".$ivheight."', '".$ivweight."', '".mysqli_real_escape_string($conn,$ivremarksall[$i])."', now(), '".mysqli_real_escape_string($conn,$ividtypeall[$i])."', '".mysqli_real_escape_string($conn,$ividnumberall[$i])."')");
		  }
		  //mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added victims to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		// if((isset($_POST['checkVehicle'])) && !empty($_POST['checkVehicle']))
		// {
			// $ivehicleowner = mysqli_real_escape_string($conn, $_POST['txtvowner']);
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
			
			mysqli_query($conn, "INSERT INTO incident_counterfeit (ticket_id, account_name, account_id, customer_rep, address, amount, bill_serial, relationship) VALUES (".$logId2.", '".$cfaccname."', '".$cfaccid."', '".$cfcrep."', '".$cfadd."', '".$cfamount."', '".$cfbill."', '".$cfrelate."')");
			//mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added counterfeit details to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		if((isset($_POST['selinclocator'])) && !empty($_POST['selinclocator']))
		{
			$locator_id = $_POST['selinclocator'];
			mysqli_query($conn, "UPDATE ticket SET locator_id = ".$locator_id." WHERE id = ". $logId2);
		}
		date_default_timezone_set('Asia/Manila');
		$datenow = date('Y-m-d H:i:s');
		mysqli_query($conn, "UPDATE ticket SET disposition = '".mysqli_real_escape_string($conn,$_POST['txtIncidentDisposition'])."', is_open = 0, dateclosed = '".$datenow."' WHERE id = ".$logId2);
		if(mysqli_affected_rows($conn) > 0 ) {
			include("generate-ticket-report.php");
			generateTicketPDF($logId2);
		}
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Closed ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		
		$uploadinfosql = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$logId2)or die(mysqli_error($conn));
		$uploadinfores = mysqli_fetch_assoc($uploadinfosql);
		$mailtest = "NotApplicable";
		
		$alertdesc = "INCIDENT";
		$whatsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$uploadinfores['description']);
		$whatres = mysqli_fetch_assoc($whatsql);
		$what = $whatres['name'];
		
		$to = "";
		$to2 = "";
		$recipients = array();
		$escalate = array();
		$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$uploadinfores['bu'])or die(mysqli_error($conn));
		while($resoic = mysqli_fetch_assoc($sqloic))
		{
			if($resoic['slevel'] <= 1)
			{
				$recipients[] = $resoic['email_ad'];
			}
			elseif($resoic['slevel'] <= $uploadinfores['severity'])
			{
				$escalate[] = $resoic['email_ad'];
			}
		}
		
		$uploadbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$uploadinfores['bu'])or die(mysqli_error($conn));
		$uploadbures = mysqli_fetch_assoc($uploadbusql);
		
		$bucontrolnum = $uploadbures['bu_code'].'-'.str_replace("-", "", $uploadinfores['dateadded']).'-'.$uploadinfores['id'];
		$datenow2 = strtotime($uploadinfores['dateclosed']);
		$emaildatecreated2 = date('h:i:sa, j F Y', $datenow2);
		
		$getlocationsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ".$uploadinfores['location']);
		$getlocationres = mysqli_fetch_array($getlocationsql);
			
		$to = implode("*~", $recipients);
		$to2 = implode("*~", $escalate);		
		
		$subject = 'SECURITY '.$alertdesc.' LEVEL '.$uploadinfores['severity'].': '.$what.' '.$bucontrolnum;
		$subheader = '<h3 style="margin-top:0px;">ALERT LEVEL '.$uploadinfores['severity'].'</h3>';
		$locdisp = '-> '.$getlocationres['location'];	
		
		$narrative = preg_replace( "/\r|\n/", "<br>", $uploadinfores['disposition'] );
		$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
						<tr align="center">
							<td colspan="100%" align="center">
								<h2 style="margin-bottom:0px;">'.$alertdesc.' REPORT</h2>
								'.$subheader.'
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
										<td style=" padding-left:20px; padding-right:20px;">'.$uploadbures['bu'].' '.$locdisp.'</td>
									</tr>                      
									<tr>                          
										<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.$emaildatecreated2.'</td>
									</tr>										
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">UPDATE:</td>
										<td style=" padding-left:20px; padding-right:20px;">Ticket closed.</td>
									</tr>
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">DISPOSITION:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($narrative).'</td>
									</tr>									
									<tr>
										<td width="15%" style="text-decoration:underline; text-align: right;">Uploaded by:</td>
										<td style=" padding-left:20px; padding-right:20px;">'.$userfull.'</td>
									</tr>																					
								</table>
							</td>
						</tr>
					 </table>';
			
			$incidentReport = '';
			$getReportFileQuery = mysqli_query($conn, "SELECT report_file FROM ticket WHERE id =  $logId2");
			while($getReportFile = mysqli_fetch_assoc($getReportFileQuery)) {
				$incidentReport = $getReportFile['report_file'];
			}

			$mail = send_mail_disposition_enhancement($to,$subject,$mainbody,$to2, $incidentReport);
			if($mail)
			{
				$mailtest = "SUCCESS";
			}
			else
			{
				 $mailtest = "FAILED";
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
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Made revisions to a revised logs', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
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
		header("Location: user-admin.php?last=Entries");
	} 
	elseif ((isset($_POST['txtaddnominatedagencynameall'])) && !empty($_POST['txtaddnominatedagencynameall'])) {
		$addagencynames = explode("*~", $_POST['txtaddnominatedagencynameall']);
		$addagencyaddress = explode("*~", $_POST['txtaddnominatedagencyaddressall']);
		$addagencyoics = explode("*~", $_POST['txtaddnominatedagencyoicall']);
		$addagencyemails = explode("*~", $_POST['txtaddnominatedagencyemailall']);
		$addagencyphones = explode("*~", $_POST['txtaddnominatedagencyphoneall']);
		$addbiddingids = explode("*~", $_POST['txtbiddingidall']);
		$notcountme = 0;		
		for ($i = 1, $count = count($addagencynames); $i < $count; $i++) {
			$emailcheckquery = mysqli_query($conn, "SELECT * FROM agency_mst WHERE email LIKE '%" .$addagencyemails[$i] . "%' " ) or die(mysqli_error($conn));
			$emailcheck = mysqli_fetch_assoc($emailcheckquery);
			if (!$emailcheck) {
				mysqli_query($conn, "INSERT INTO agency_mst (agency_name, address, oic, contact_number, email, contract_status) VALUES ('" . $addagencynames[$i] . "', '" . $addagencyaddress[$i] . "', '" . $addagencyoics[$i] . "', '" . $addagencyphones[$i] . "', '" . $addagencyemails[$i] . "', 'Active')") or die(mysqli_error());
				$get_last_agencyid = mysqli_fetch_array(mysqli_query($conn, "Select id from agency_mst order by id desc"));
				$lagencyid = $get_last_agencyid['id'];
				mysqli_query($conn, "INSERT INTO bidding_agency (agency_id, bidding_id) VALUES ('" . $lagencyid . "', '" . $addbiddingids[$i] . "')") or die(mysqli_error());
			}
		}

		$updatePass = "Password".date("Y");
		mysqli_query($conn, "UPDATE agency_mst SET password = '" . md5($updatePass) . "'") or die(mysqli_error());
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('" . $_SESSION['id'] . "', 'Nominate Security Agency', now(), 0)") or die(mysqli_error());
		header("Location: user-admin.php?last=Bidding");
	} 
	elseif ((isset($_POST['poolAgencyID'])) && !empty($_POST['poolAgencyID'])) {
		$bid_ids = $_POST['txtbiddingid'];
		for ($i = 0, $count = count($_POST['poolAgencyID']); $i < $count; $i++) {
			mysqli_query($conn, "INSERT INTO bidding_agency (agency_id, bidding_id) VALUES ('" . $_POST['poolAgencyID'][$i] . "', '" . $bid_ids . "')") or die(mysqli_error());
		}

		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('" . $_SESSION['id'] . "', 'Nominate Security Agency', now(), 0)") or die(mysqli_error());
		header("Location: user-admin.php?last=Bidding");
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
		header("Location: user-admin.php?last=Entries");
	}
	elseif((isset($_POST['txtagencyremark'])) && !empty($_POST['txtagencyremark']))
	{
		$addagencyremark = mysqli_real_escape_string($conn, $_POST['txtagencyremark']);
		$addagencyremark .= " - ".$displayUsername.", ".$displayBUName;
		$addagencyremarkdate = mysqli_real_escape_string($conn, $_POST['txtagencyremarkdate']);
		$addagencyid = mysqli_real_escape_string($conn, $_POST['txtagencyid']);
		
		mysqli_query($conn, "INSERT INTO agency_remarks (agency_id, remarks_date, remarks) VALUES('".$addagencyid."', '".$addagencyremarkdate."', '".$addagencyremark."')");
		header("Location: user-admin.php?last=SecAgency");	
	}
	// elseif((isset($_POST['editIPType'])) && !empty($_POST['editIPType']))
	// {
		// $editIPType = $_POST['editIPType'];
		// $editIPIDNum = $_POST['editIPIDNum'];
		// $editIPFName = mysqli_real_escape_string($conn, $_POST['editIPFName']);
		// $editIPMName = mysqli_real_escape_string($conn, $_POST['editIPMName']);
		// $editIPLName = mysqli_real_escape_string($conn, $_POST['editIPLName']);
		// $editIPAddress = mysqli_real_escape_string($conn, $_POST['editIPAddress']);
		// $editIPContact = mysqli_real_escape_string($conn, $_POST['editIPContact']);
		// $editIPAge = mysqli_real_escape_string($conn, $_POST['editIPAge']);
		// $editIPAge = (!empty($_POST['editIPAge'])) ? mysqli_real_escape_string($conn, $_POST['editIPAge']):0;		
		// $editIPGender = mysqli_real_escape_string($conn, $_POST['editIPGender']);		
		// $editIPHeight = mysqli_real_escape_string($conn, $_POST['editIPHeight']);
		// $editIPHeight = (!empty($_POST['editIPHeight'])) ? mysqli_real_escape_string($conn, $_POST['editIPHeight']):0;
		// $editIPWeight = mysqli_real_escape_string($conn, $_POST['editIPWeight']);
		// $editIPWeight = (!empty($_POST['editIPWeight'])) ? mysqli_real_escape_string($conn, $_POST['editIPWeight']):0;
		// $editIPIDType = mysqli_real_escape_string($conn, $_POST['editIPIDType']);
		// $editIPIDNumber = mysqli_real_escape_string($conn, $_POST['editIPIDNumber']);
		// $editIPRemark = mysqli_real_escape_string($conn, $_POST['editIPRemark']);
		// $edittable = "";
		// if($editIPType == "suspect")
		// {
			// $edittable = "incident_suspect";
		// }
		// elseif($editIPType == "witness")
		// {
			// $edittable = "incident_witness";
		// }
		// elseif($editIPType == "victim")
		// {
			// $edittable = "incident_victim";
		// }
		// mysqli_query($conn, "UPDATE ".$edittable." SET FirstName = '".$editIPFName."', MiddleName = '".$editIPMName."', LastName = '".$editIPLName."', Address = '".$editIPAddress."', Age = '".$editIPAge."', Gender = '".$editIPGender."', Height = '".$editIPHeight."', Weight = '".$editIPWeight."', Contact = '".$editIPContact."', idType = '".$editIPIDType."', idNumber = '".$editIPIDNumber."', Remark = '".$editIPRemark."' WHERE id = ".$editIPIDNum) or die(mysqli_error($conn));
		// if($_SESSION['level'] == 'User')
		// {
			// header("location:user.php?last=Incidents");
		// }
		// elseif($_SESSION['level'] == 'Admin')
		// {
			// header("location:user-admin.php?last=Incidents&test=".$editIPMName);
		// }
		// elseif($_SESSION['level'] == 'Super Admin')
		// {
			// header("location:user-superadmin.php?last=Incidents");
		// }
		
	// }
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
			/* if($editIPType[$i] == "suspect")
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
			} */
		mysqli_query($conn, "UPDATE incident_involved_mst SET FirstName = '".mysqli_real_escape_string($conn, $editIPFName[$i])."', MiddleName = '".mysqli_real_escape_string($conn, $editIPMName[$i])."', LastName = '".mysqli_real_escape_string($conn, $editIPLName[$i])."', Address = '".mysqli_real_escape_string($conn, $editIPAddress[$i])."', Age = '". ((!empty($editIPAge[$i])) ? mysqli_real_escape_string($conn, $editIPAge[$i]):0) ."', Gender = '". mysqli_real_escape_string($conn, $editIPGender[$i])."', Height = '". ((!empty($editIPHeight[$i])) ? mysqli_real_escape_string($conn, $editIPHeight[$i]):0) ."', Weight = '". ((!empty($editIPWeight[$i])) ? mysqli_real_escape_string($conn, $editIPWeight[$i]):0)."', Contact = '".mysqli_real_escape_string($conn, $editIPContact[$i])."', idType = '".mysqli_real_escape_string($conn,$editIPIDType[$i])."', idNumber = '".mysqli_real_escape_string($conn,$editIPIDNumber[$i])."', Remark = '".mysqli_real_escape_string($conn,$editIPRemark[$i])."' WHERE id = ".$editIPIDNum[$i])or die(mysqli_error($conn));
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
	elseif(!empty($_POST['btnSubmitRetract']))
	{
		$retractLevel = $_POST['numRetractLevel'];
		$retractReason = mysqli_real_escape_string($conn,$_POST['txtRetractReason']);
		$retractId = $_POST['txtRetractId'];
		
		mysqli_query($conn, "INSERT INTO request_mst(requester, bu, ticket_id, details, level, submit_date) VALUES('".$_SESSION['id']."', '".$_SESSION['bu']."', ".$retractId.", '".$retractReason."', ".$retractLevel.", now())")or die(mysqli_error($conn));
		$sqlretractbu = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$_SESSION['bu']);
		$resretractbu = mysqli_fetch_assoc($sqlretractbu);
		$sqlretractid = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$retractId);
		$resretractid = mysqli_fetch_assoc($sqlretractid);
		$sqlretractdesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$resretractid['description']);
		$resretractdesc = mysqli_fetch_assoc($sqlretractdesc);
		$sqlretractlocation = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ".$resretractid['location']);
		$resretractlocation = mysqli_fetch_assoc($sqlretractlocation);
		
		$bucontrolnum = $resretractbu['bu_code'].'-'.str_replace("-", "", $resretractid['dateadded']).'-'.$resretractid['id'];
		$narrative = preg_replace( "/\r|\n/", "<br>", $retractReason);
			
		$to = "harmone.naparota@aboitiz.com";
		$subject = "SMS Request: Alert Level Retraction ".$bucontrolnum;		
		$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
						<tr align="center">
							<td colspan="100%" align="center">
								<h2 style="margin-bottom:0px; margin-top:0px;">SMS Request</h2>								
							</td>
						</tr>
						<tr>
							<td colspan="100%">
								<table align="center" width="80%" style="border-collapse:collapse;" cellpadding="5px" >
									<tr>                          
										<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >Requester:</td>
										<td style=" padding-left:20px; padding-right:20px;" >'.$userfull.'</td>
									</tr>									
									<tr>                          
										<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >WHAT:</td>
										<td style=" padding-left:20px; padding-right:20px;" >'.$resretractdesc['name'].'</td>
									</tr>
									<tr>                          
										<td width="15%" style="text-align: right; font-weight: bold;">WHERE:</td>
										<td style=" padding-left:20px; padding-right:20px;">'.$resretractbu['bu'].' -> '.$resretractlocation['location'].'</td>
									</tr>
									<tr>                          
										<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.$resretractid['datesubmitted'].'</td>
									</tr>
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold;">Current Level:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.$resretractid['severity'].'</td>
									</tr>
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold;">Retract to Level:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.$retractLevel.'</td>
									</tr>
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">REASON:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($narrative).'</td>
									</tr>									
								</table>
							</td>
						</tr>
					 </table>';
		$mail = send_mail4($to,$subject,$mainbody);
		if($mail)
		{
			$mailtest = "SUCCESS";
		}
		else
		{
			$mailtest = "FAILED";
		}
		
		header("location:user-admin.php?last=Incidents&mail");
	}
	elseif(!empty($_POST['btnSubmitDeletion']))
	{
		$deletionType = $_POST['txtDeletionType'];
		$deletionId = $_POST['txtDeletionId'];		
		$deletionReason = mysqli_real_escape_string($conn,$_POST['txtDeletionReason']);		
		
		mysqli_query($conn, "INSERT INTO deletions_mst(requester, bu, target_id, details, type, submit_date) VALUES('".$_SESSION['id']."', '".$_SESSION['bu']."', ".$deletionId.", '".$deletionReason."', '".$deletionType."', now())")or die(mysqli_error($conn)." INSERT INTO deletions_mst(requester, bu, target_id, details, type, submit_date) VALUES('".$_SESSION['id']."', '".$_SESSION['bu']."', ".$deletionId.", '".$deletionReason."', ".$deletionType.", now())");
		
		$sqlretractbu = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$_SESSION['bu']);
		$resretractbu = mysqli_fetch_assoc($sqlretractbu);
		$sqlretractid = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$deletionId);
		$resretractid = mysqli_fetch_assoc($sqlretractid);
		$sqlretractdesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$resretractid['description']);
		$resretractdesc = mysqli_fetch_assoc($sqlretractdesc);
		$sqlretractlocation = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ".$resretractid['location']);
		$resretractlocation = mysqli_fetch_assoc($sqlretractlocation);
				
		$bucontrolnum = $resretractbu['bu_code'].'-'.str_replace("-", "", $resretractid['dateadded']).'-'.$resretractid['id'];
		$narrative = preg_replace( "/\r|\n/", "<br>", $deletionReason);
		
		$to = "harmone.naparota@aboitiz.com";
		$subject = "SMS Request: ".$deletionType." Deletion ".$bucontrolnum;		
		$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
						<tr align="center">
							<td colspan="100%" align="center">
								<h2 style="margin-bottom:0px; margin-top:0px;">SMS Request</h2>								
							</td>
						</tr>
						<tr>
							<td colspan="100%">
								<table align="center" width="80%" style="border-collapse:collapse;" cellpadding="5px" >
									<tr>                          
										<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >Requester:</td>
										<td style=" padding-left:20px; padding-right:20px;" >'.$userfull.'</td>
									</tr>									
									<tr>                          
										<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >WHAT:</td>
										<td style=" padding-left:20px; padding-right:20px;" >'.$resretractdesc['name'].'</td>
									</tr>
									<tr>                          
										<td width="15%" style="text-align: right; font-weight: bold;">WHERE:</td>
										<td style=" padding-left:20px; padding-right:20px;">'.$resretractbu['bu'].' -> '.$resretractlocation['location'].'</td>
									</tr>
									<tr>                          
										<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.$resretractid['datesubmitted'].'</td>
									</tr>									
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">REASON:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($narrative).'</td>
									</tr>									
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="100%">Check request <a href="'.$url_base.'/user-superadmin.php?last=Deletions" target="_blank">HERE</a></td>							
						</tr>
					 </table>';
		$mail = send_mail4($to,$subject,$mainbody);
		if($mail)
		{
			$mailtest = "SUCCESS";
		}
		else
		{
			$mailtest = "FAILED";
		}
		
		header("location:user-admin.php?last=Incidents&mail");
	}
	elseif((isset($_POST['editVPlateNo'])) && !empty($_POST['editVPlateNo']))
	{
		$ivehicleowner = explode("*~", $_POST['editVOwner']);
		$ivehicleplate = explode("*~", $_POST['editVPlateNo']);
		$ivehicletype = explode("*~", $_POST['editVType']);
		$ivehiclemake = explode("*~", $_POST['editVMake']);
		$ivehiclemodel = explode("*~", $_POST['editVModel']);
		$ivehiclecolor = explode("*~", $_POST['editVColor']);
		$ivehicleremarks = explode("*~", $_POST['editVRemarks']);
		$ivehicleidnumber = explode("*~", $_POST['editVIDNumber']);
		for($i=1, $count = count($ivehicleplate);$i<$count;$i++)
		{
			mysqli_query($conn, "UPDATE incident_vehicle SET owner = '".mysqli_real_escape_string($conn,$ivehicleowner[$i])."', plate_no = '".mysqli_real_escape_string($conn,$ivehicleplate[$i])."', type = '".mysqli_real_escape_string($conn,$ivehicletype[$i])."', make = '".mysqli_real_escape_string($conn,$ivehiclemake[$i])."', model = '".mysqli_real_escape_string($conn,$ivehiclemodel[$i])."', color = '".mysqli_real_escape_string($conn,$ivehiclecolor[$i])."', remarks = '".mysqli_real_escape_string($conn,$ivehicleremarks[$i])."' WHERE id = ".$ivehicleidnumber[$i]);
			//mysqli_query($conn, "INSERT INTO incident_vehicle (ticket_id, plate_no, type, make, model, color, remarks, owner) VALUES(".$logId2.", '".mysqli_real_escape_string($conn, $ivehicleplate[$i])."', '".mysqli_real_escape_string($conn,$ivehicletype[$i])."', '".mysqli_real_escape_string($conn, $ivehiclemake[$i])."', '".mysqli_real_escape_string($conn, $ivehiclemodel[$i])."', '".mysqli_real_escape_string($conn,$ivehiclecolor[$i])."', '".mysqli_real_escape_string($conn,$ivehicleremarks[$i])."', '".mysqli_real_escape_string($conn,$ivehicleowner[$i])."')");
			//mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added vehicle to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
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
	elseif(!empty($_POST['btnspam']))
	{
		$guard_dc = $_POST['numSpamGuardDC'];
		$guard_dc_remarks = $_POST['txtSpamGuardDC'];
		$guard_hg = $_POST['numSpamGuardSIC'];
		$guard_hg_remarks = $_POST['txtSpamGuardSIC'];
		$guard_sg = $_POST['numSpamGuardSG'];
		$guard_sg_remarks = $_POST['txtSpamGuardSG'];;
		$guard_lg = $_POST['numSpamGuardLG'];
		$guard_lg_remarks = $_POST['txtSpamGuardLG'];
		$guard_rel = $_POST['numSpamGuardReliever'];
		$guard_rel_remarks = $_POST['txtSpamGuardReliever'];
		$guard_total = $_POST['numSpamGuardTotal'];
		$guard_total_remarks = $_POST['txtSpamGuardTotal'];
		$shift_1st = $_POST['numSpamShift1st'];
		$shift_1st_remarks = $_POST['txtSpamShift1st'];
		$shift_2nd = $_POST['numSpamShift2nd'];
		$shift_2nd_remarks = $_POST['txtSpamShift2nd'];
		$shift_3rd = $_POST['numSpamShift3rd'];
		$shift_3rd_remarks = $_POST['txtSpamShift3rd'];
		$shift_others = $_POST['numSpamShiftOther'];
		$shift_others_remarks = $_POST['txtSpamShiftOther'];
		$security_operations_center = $_POST['selSpamSOC'];
		$security_operations_center_remarks = $_POST['txtSpamSOC'];
		$comms_base_radio = $_POST['numSpamCommBaseRadio'];
		$comms_base_radio_remarks = $_POST['txtSpamCommBaseRadio'];
		$comms_hh_radio = $_POST['numSpamCommHandRadio'];
		$comms_hh_radio_remarks = $_POST['txtSpamCommHandRadio'];
		$comms_repeater = $_POST['numSpamCommRepeater'];
		$comms_repeater_remarks = $_POST['txtSpamCommRepeater'];
		$comms_mobile = $_POST['numSpamCommMobile'];
		$comms_mobile_remarks = $_POST['txtSpamCommMobile'];
		$comms_sat_phones = $_POST['numSpamCommSat'];
		$comms_sat_phones_remarks = $_POST['txtSpamCommSat'];
		$comms_others = $_POST['numSpamCommOthers'];
		$comms_others_remarks = $_POST['txtSpamCommOthers'];
		$comms_total = $_POST['numSpamCommTotal'];
		$comms_total_remarks = $_POST['txtSpamCommTotal'];
		$surv_cctv = $_POST['numSpamSurvCCTV'];
		$surv_cctv_remarks = $_POST['txtSpamSurvCCTV'];
		$surv_cctv_motion = $_POST['numSpamSurvCCTVMotion'];
		$surv_cctv_motion_remarks = $_POST['txtSpamSurvCCTVMotion'];
		$surv_access_ctrl = $_POST['numSpamSurvAccess'];
		$surv_access_ctrl_remarks = $_POST['txtSpamSurvAccess'];
		$surv_intrusion_det = $_POST['numSpamSurvIntrusion'];
		$surv_intrusion_det_remarks = $_POST['txtSpamSurvIntrusion'];
		$surv_watchman = $_POST['numSpamSurvWatch'];
		$surv_watchman_remarks = $_POST['txtSpamSurvWatch'];
		$surv_others = $_POST['numSpamSurvOthers'];
		$surv_others_remarks = $_POST['txtSpamSurvOthers'];
		$surv_total = $_POST['numSpamSurvTotal'];
		$surv_total_remarks = $_POST['txtSpamSurvTotal'];
		$fa_9mm = $_POST['numSpamFA9mm'];
		$fa_9mm_remarks = $_POST['txtSpamFA9mm'];
		$fa_shotgun = $_POST['numSpamFASS'];
		$fa_shotgun_remarks = $_POST['txtSpamFASS'];
		$fa_m16 = $_POST['numSpamFAm16'];
		$fa_m16_remarks = $_POST['txtSpamFAm16'];
		$fa_m4 = $_POST['numSpamFAm4'];
		$fa_m4_remarks = $_POST['txtSpamFAm4'];
		$fa_others = $_POST['numSpamFAOthers'];
		$fa_others_remarks = $_POST['txtSpamFAOthers'];
		$fa_total = $_POST['numSpamFATotal'];
		$fa_total_remarks = $_POST['txtSpamFATotal'];
		$veh_bicycle = $_POST['numSpamVehicleBicycle'];
		$veh_bicycle_remarks = $_POST['txtSpamVehicleBicycle'];
		$veh_2w_mc = $_POST['numSpamVehicle2W'];
		$veh_2w_mc_remarks = $_POST['txtSpamVehicle2W'];
		$veh_4w_atv = $_POST['numSpamVehicleATV'];
		$veh_4w_atv_remarks = $_POST['txtSpamVehicleATV'];
		$veh_4w_utility = $_POST['numSpamVehicle4WPickup'];
		$veh_4w_utility_remarks = $_POST['txtSpamVehicle4WPickup'];
		$veh_water_crafts = $_POST['numSpamVehicleWatercraft'];
		$veh_water_crafts_remarks = $_POST['txtSpamVehicleWatercraft'];
		$veh_ambu = $_POST['numSpamVehicleAmbulance'];
		$veh_ambu_remarks = $_POST['txtSpamVehicleAmbulance'];
		$veh_fire_truck = $_POST['numSpamVehicleFiretruck'];
		$veh_fire_truck_remarks = $_POST['txtSpamVehicleFireTruck'];
		$veh_others = $_POST['numSpamVehicleOthers'];
		$veh_others_remarks = $_POST['txtSpamVehicleOthers'];
		$veh_total = $_POST['numSpamVehicleTotal'];
		$veh_total_remarks = $_POST['txtSpamVehicleTotal'];
		$office_desktop = $_POST['numSpamOfficeDesktop'];
		$office_desktop_remarks = $_POST['txtSpamOfficeDesktop'];
		$office_printer = $_POST['numSpamOfficePrinter'];
		$office_printer_remarks = $_POST['txtSpamOfficePrinter'];
		$office_internet = $_POST['numSpamOfficeInternet'];
		$office_internet_remarks = $_POST['txtSpamOfficeInternet'];
		$office_others = $_POST['numSpamOfficeOthers'];
		$office_others_remarks = $_POST['txtSpamOfficeOthers'];
		$office_total = $_POST['numSpamOfficeTotal'];
		$office_total_remarks = $_POST['txtSpamOfficeTotal'];
		$others_metal_det = $_POST['numSpamOthersMetalDetector'];
		$others_metal_det_remarks = $_POST['txtSpamOthersMetalDetector'];
		$others_mirror = $_POST['numSpamOthersMirror'];
		$others_mirror_remarks = $_POST['txtSpamOthersMirror'];
		$others_k9 = $_POST['numSpamOthersK9'];
		$others_k9_remarks = $_POST['txtSpamOthersK9Unit'];
		$others_searchlight = $_POST['numSpamOthersSearchlight'];
		$others_searchlight_remarks = $_POST['txtSpamOthersSearchlight'];
		$others_binoculars = $_POST['numSpamOthersBinoculars'];
		$others_binoculars_remarks = $_POST['txtSpamOthersBinoculars'];
		$others_stungun = $_POST['numSpamOthersStungun'];
		$others_stungun_remarks = $_POST['txtSpamOthersStungun'];
		$others_firstaidkit = $_POST['numSpamOthersFirstAid'];
		$others_firstaidkit_remarks = $_POST['txtSpamOthersFirstAid'];
		$others_rainboots = $_POST['numSpamOthersRainboots'];
		$others_rainboots_remarks = $_POST['txtSpamOthersRainboots'];
		$others_raincoat = $_POST['numSpamOthersRaincoat'];
		$others_raincoat_remarks = $_POST['txtSpamOthersRaincoat'];
		$others_gasmask = $_POST['numSpamOthersGasmask'];
		$others_gasmask_remarks = $_POST['txtSpamOthersGasmask'];
		$others_breathanalyzer = $_POST['numSpamOthersBreathAnalyzer'];
		$others_breathanalyzer_remarks = $_POST['txtSpamOthersBreathAnalyzer'];
		$others_waterdispenser = $_POST['numSpamOthersWaterDispenser'];
		$others_waterdispenser_remarks = $_POST['txtSpamOthersWaterDispenser'];
		$others_megaphone = $_POST['numSpamOthersMegaphone'];
		$others_megaphone_remarks = $_POST['txtSpamOthersMegaphone'];
		$others_steeltoe = $_POST['numSpamOthersSteeltoe'];
		$others_steeltoe_remarks = $_POST['txtSpamOthersSteeltoe'];
		$others_hardhat = $_POST['numSpamOthersHardhat'];
		$others_hardhat_remarks = $_POST['txtSpamOthersHardhat'];
		$others_digicam = $_POST['numSpamOthersDigicam'];
		$others_digicam_remarks = $_POST['txtSpamOthersDigicam'];
		$others_trafficvest = $_POST['numSpamOthersTrafficVest'];
		$others_trafficvest_remarks = $_POST['txtSpamOthersTrafficVest'];
		$others_fireequip = $_POST['numSpamOthersFireEquip'];
		$others_fireequip_remarks = $_POST['txtSpamOthersFireEquip'];
		$others_others = $_POST['numSpamOthersOthers'];
		$others_others_remarks = $_POST['txtSpamOthersOthers'];
		$others_total = $_POST['numSpamOthersTotal'];
		$others_total_remarks = $_POST['txtSpamOthersTotal'];
		
		/* $rates_8hr = $_POST['numSpamRate8hr'];
		$rates_8hr_remarks = $_POST['txtSpamRate8hr'];
		$rates_10hr = $_POST['numSpamRate10hr'];
		$rates_10hr_remarks = $_POST['txtSpamRate10hr'];
		$rates_12hr = $_POST['numSpamRate12hr'];
		$rates_12hr_remarks = $_POST['txtSpamRate12hr'];
		$rates_admin = $_POST['numSpamRateAdmin'];
		$rates_admin_remarks = $_POST['txtSpamRateAdmin'];
		$rates_daily = $_POST['numSpamRateDailyWage'];
		$rates_daily_remarks = $_POST['txtSpamRateDailyWage'];
		$rates_monthly = $_POST['numSpamRateMonthly'];
		$rates_monthly_remarks = $_POST['txtSpamRateMonthly'];
		$rates_annual = $_POST['numSpamRateAnnual'];
		$rates_annual_remarks = $_POST['txtSpamRateAnnual']; */
		
		$rates_no_of_guards_9 = $_POST['txt_rates_no_of_guards_9'];
		$rates_no_of_guards_10 = $_POST['txt_rates_no_of_guards_10'];
		
		$rates_tour_of_duty_12a = $_POST['txt_rates_tour_of_duty_12a'];
		$rates_tour_of_duty_12b = $_POST['txt_rates_tour_of_duty_12b'];
		$rates_tour_of_duty_9 = $_POST['txt_rates_tour_of_duty_9'];
		$rates_tour_of_duty_10 = $_POST['txt_rates_tour_of_duty_10'];
		
		$rates_days_per_week_12a = $_POST['txt_rates_days_per_week_12a'];
		$rates_days_per_week_12b = $_POST['txt_rates_days_per_week_12b'];
		$rates_days_per_week_9 = $_POST['txt_rates_days_per_week_9'];
		$rates_days_per_week_10 = $_POST['txt_rates_days_per_week_10'];
		
		$rates_days_per_year_12a = $_POST['txt_rates_days_per_year_12a'];
		$rates_days_per_year_12b = $_POST['txt_rates_days_per_year_12b'];
		$rates_days_per_year_9 = $_POST['txt_rates_days_per_year_9'];
		$rates_days_per_year_10 = $_POST['txt_rates_days_per_year_10'];
		
		$rates_daily_wage_12a = $_POST['txt_rates_daily_wage_12a'];
		$rates_daily_wage_12b = $_POST['txt_rates_daily_wage_12b'];
		$rates_daily_wage_9 = $_POST['txt_rates_daily_wage_9'];
		$rates_daily_wage_10 = $_POST['txt_rates_daily_wage_10'];
		
		$rates_cola_12a = $_POST['txt_rates_cola_12a'];
		$rates_cola_12b = $_POST['txt_rates_cola_12b'];
		$rates_cola_9 = $_POST['txt_rates_cola_9'];
		$rates_cola_10 = $_POST['txt_rates_cola_10'];
		
		$rates_monthly_salary_12a = $_POST['txt_rates_monthly_salary_12a'];
		$rates_monthly_salary_12b = $_POST['txt_rates_monthly_salary_12b'];
		$rates_monthly_salary_9 = $_POST['txt_rates_monthly_salary_9'];
		$rates_monthly_salary_10 = $_POST['txt_rates_monthly_salary_10'];
		
		$rates_night_diff_12a = $_POST['txt_rates_night_diff_12a'];
		$rates_night_diff_12b = $_POST['txt_rates_night_diff_12b'];
		$rates_night_diff_9 = $_POST['txt_rates_night_diff_9'];
		$rates_night_diff_10 = $_POST['txt_rates_night_diff_10'];
		
		$rates_incentive_leave_12a = $_POST['txt_rates_incentive_leave_12a'];
		$rates_incentive_leave_12b = $_POST['txt_rates_incentive_leave_12b'];
		$rates_incentive_leave_9 = $_POST['txt_rates_incentive_leave_9'];
		$rates_incentive_leave_10 = $_POST['txt_rates_incentive_leave_10'];
		
		$rates_13th_mon_12a = $_POST['txt_rates_13th_mon_12a'];
		$rates_13th_mon_12b = $_POST['txt_rates_13th_mon_12b'];
		$rates_13th_mon_9 = $_POST['txt_rates_13th_mon_9'];
		$rates_13th_mon_10 = $_POST['txt_rates_13th_mon_10'];
		
		$rates_uniform_allowance_12a = $_POST['txt_rates_uniform_allowance_12a'];
		$rates_uniform_allowance_12b = $_POST['txt_rates_uniform_allowance_12b'];
		$rates_uniform_allowance_9 = $_POST['txt_rates_uniform_allowance_9'];
		$rates_uniform_allowance_10 = $_POST['txt_rates_uniform_allowance_10'];
		
		$rates_cola_m_12a = $_POST['txt_rates_cola_m_12a'];
		$rates_cola_m_12b = $_POST['txt_rates_cola_m_12b'];
		$rates_cola_m_9 = $_POST['txt_rates_cola_m_9'];
		$rates_cola_m_10 = $_POST['txt_rates_cola_m_10'];
		
		$rates_overtime_12a = $_POST['txt_rates_overtime_12a'];
		$rates_overtime_12b = $_POST['txt_rates_overtime_12b'];
		$rates_overtime_9 = $_POST['txt_rates_overtime_9'];
		$rates_overtime_10 = $_POST['txt_rates_overtime_10'];
		
		$rates_amt_due_guard_12a = $_POST['txt_rates_amt_due_guard_12a'];
		$rates_amt_due_guard_12b = $_POST['txt_rates_amt_due_guard_12b'];
		$rates_amt_due_guard_9 = $_POST['txt_rates_amt_due_guard_9'];
		$rates_amt_due_guard_10 = $_POST['txt_rates_amt_due_guard_10'];
		
		$rates_sss_premium_12a = $_POST['txt_rates_sss_premium_12a'];
		$rates_sss_premium_12b = $_POST['txt_rates_sss_premium_12b'];
		$rates_sss_premium_9 = $_POST['txt_rates_sss_premium_9'];
		$rates_sss_premium_10 = $_POST['txt_rates_sss_premium_10'];
		
		$rates_pagibig_12a = $_POST['txt_rates_pagibig_12a'];
		$rates_pagibig_12b = $_POST['txt_rates_pagibig_12b'];
		$rates_pagibig_9 = $_POST['txt_rates_pagibig_9'];
		$rates_pagibig_10 = $_POST['txt_rates_pagibig_10'];
		
		$rates_philhealth_12a = $_POST['txt_rates_philhealth_12a'];
		$rates_philhealth_12b = $_POST['txt_rates_philhealth_12b'];
		$rates_philhealth_9 = $_POST['txt_rates_philhealth_9'];
		$rates_philhealth_10 = $_POST['txt_rates_philhealth_10'];
		
		$rates_state_ins_fund_12a = $_POST['txt_rates_state_ins_fund_12a'];
		$rates_state_ins_fund_12b = $_POST['txt_rates_state_ins_fund_12b'];
		$rates_state_ins_fund_9 = $_POST['txt_rates_state_ins_fund_9'];
		$rates_state_ins_fund_10 = $_POST['txt_rates_state_ins_fund_10'];
		
		$rates_retirement_benefit_12a = $_POST['txt_rates_retirement_benefit_12a'];
		$rates_retirement_benefit_12b = $_POST['txt_rates_retirement_benefit_12b'];
		$rates_retirement_benefit_9 = $_POST['txt_rates_retirement_benefit_9'];
		$rates_retirement_benefit_10 = $_POST['txt_rates_retirement_benefit_10'];
		
		$rates_govt_dues_12a = $_POST['txt_rates_govt_dues_12a'];
		$rates_govt_dues_12b = $_POST['txt_rates_govt_dues_12b'];
		$rates_govt_dues_9 = $_POST['txt_rates_govt_dues_9'];
		$rates_govt_dues_10 = $_POST['txt_rates_govt_dues_10'];
		
		$rates_total_dues_12a = $_POST['txt_rates_total_dues_12a'];
		$rates_total_dues_12b = $_POST['txt_rates_total_dues_12b'];
		$rates_total_dues_9 = $_POST['txt_rates_total_dues_9'];
		$rates_total_dues_10 = $_POST['txt_rates_total_dues_10'];
		
		$rates_agency_percent_12a = $_POST['txt_rates_agency_percent_12a'];
		$rates_agency_percent_12b = $_POST['txt_rates_agency_percent_12b'];
		$rates_agency_percent_9 = $_POST['txt_rates_agency_percent_9'];
		$rates_agency_percent_10 = $_POST['txt_rates_agency_percent_10'];
		
		$rates_agency_charge_12a = $_POST['txt_rates_agency_charge_12a'];
		$rates_agency_charge_12b = $_POST['txt_rates_agency_charge_12b'];
		$rates_agency_charge_9 = $_POST['txt_rates_agency_charge_9'];
		$rates_agency_charge_10 = $_POST['txt_rates_agency_charge_10'];
		
		$rates_vat_12a = $_POST['txt_rates_vat_12a'];
		$rates_vat_12b = $_POST['txt_rates_vat_12b'];
		$rates_vat_9 = $_POST['txt_rates_vat_9'];
		$rates_vat_10 = $_POST['txt_rates_vat_10'];
		
		$rates_tot_agency_fee_12a = $_POST['txt_rates_tot_agency_fee_12a'];
		$rates_tot_agency_fee_12b = $_POST['txt_rates_tot_agency_fee_12b'];
		$rates_tot_agency_fee_9 = $_POST['txt_rates_tot_agency_fee_9'];
		$rates_tot_agency_fee_10 = $_POST['txt_rates_tot_agency_fee_10'];
		
		$rates_contract_per_guard_12a = $_POST['txt_rates_contract_per_guard_12a'];
		$rates_contract_per_guard_12b = $_POST['txt_rates_contract_per_guard_12b'];
		$rates_contract_per_guard_9 = $_POST['txt_rates_contract_per_guard_9'];
		$rates_contract_per_guard_10 = $_POST['txt_rates_contract_per_guard_10'];
		
		$rates_contract_per_month_12a = $_POST['txt_rates_contract_per_month_12a'];
		$rates_contract_per_month_12b = $_POST['txt_rates_contract_per_month_12b'];
		$rates_contract_per_month_9 = $_POST['txt_rates_contract_per_month_9'];
		$rates_contract_per_month_10 = $_POST['txt_rates_contract_per_month_10'];
		
		$rates_tot_contract_per_month = $_POST['txt_rates_tot_contract_per_month'];
		
		$rates_contract_per_year = $_POST['txt_rates_contract_per_year'];
		
		$rates_contract_per_3yr = $_POST['txt_rates_contract_per_3yr'];
		
		date_default_timezone_set('Asia/Manila');
		$date_saved = date('Y-m-d H:i:s');
				
		mysqli_query($conn, "INSERT INTO spam_mst (bu, date_saved, user_id, guard_dc, guard_dc_remarks, guard_hg, guard_hg_remarks, guard_sg, guard_sg_remarks, guard_lg, guard_lg_remarks, guard_rel, guard_rel_remarks, guard_total, guard_total_remarks,
													shift_1st, shift_1st_remarks, shift_2nd, shift_2nd_remarks, shift_3rd, shift_3rd_remarks, shift_others, shift_others_remarks, security_operations_center, security_operations_center_remarks,
													comms_base_radio, comms_base_radio_remarks, comms_hh_radio, comms_hh_radio_remarks, comms_mobile, comms_mobile_remarks, comms_sat_phones, comms_sat_phones_remarks, comms_repeater, comms_repeater_remarks, comms_others, comms_others_remarks, comms_total, comms_total_remarks,
													surv_cctv, surv_cctv_remarks, surv_cctv_motion, surv_cctv_motion_remarks, surv_access_ctrl, surv_access_ctrl_remarks, surv_intrusion_det, surv_intrusion_det_remarks, surv_watchman, surv_watchman_remarks, surv_others, surv_others_remarks, surv_total, surv_total_remarks,
													fa_9mm, fa_9mm_remarks, fa_shotgun, fa_shotgun_remarks, fa_m16, fa_m16_remarks, fa_m4, fa_m4_remarks, fa_others, fa_others_remarks, fa_total, fa_total_remarks,
													veh_bicycle, veh_bicycle_remarks, veh_2w_mc, veh_2w_mc_remarks, veh_4w_atv, veh_4w_atv_remarks, veh_4w_utility, veh_4w_utility_remarks, veh_water_crafts, veh_water_crafts_remarks, veh_ambu, veh_ambu_remarks, veh_fire_truck, veh_fire_truck_remarks, veh_others, veh_others_remarks, veh_total, veh_total_remarks,
													office_desktop, office_desktop_remarks, office_printer, office_printer_remarks, office_internet, office_internet_remarks, office_others, office_others_remarks, office_total, office_total_remarks,
													others_metal_det, others_metal_det_remarks, others_mirror, others_mirror_remarks, others_k9, others_k9_remarks, others_searchlight, others_searchlight_remarks, others_binoculars, others_binoculars_remarks, others_stungun, others_stungun_remarks, others_firstaidkit, others_firstaidkit_remarks, others_rainboots, others_rainboots_remarks, others_raincoat, others_raincoat_remarks, others_gasmask, others_gasmask_remarks, others_breathanalyzer, others_breathanalyzer_remarks, others_waterdispenser, others_waterdispenser_remarks, others_megaphone, others_megaphone_remarks, others_steeltoe, others_steeltoe_remarks, others_hardhat, others_hardhat_remarks, others_digicam, others_digicam_remarks, others_trafficvest, others_trafficvest_remarks, others_fireequip, others_fireequip_remarks, others_others, others_others_remarks, others_total, others_total_remarks,
													rates_no_of_guards_9, rates_no_of_guards_10, rates_tour_of_duty_12a, rates_tour_of_duty_12b, rates_tour_of_duty_9, rates_tour_of_duty_10, rates_days_per_week_12a, rates_days_per_week_12b, rates_days_per_week_9, rates_days_per_week_10, rates_days_per_year_12a, rates_days_per_year_12b, rates_days_per_year_9, rates_days_per_year_10, rates_daily_wage_12a, rates_daily_wage_12b, rates_daily_wage_9, rates_daily_wage_10, rates_cola_12a, rates_cola_12b, rates_cola_9, rates_cola_10, rates_monthly_salary_12a, rates_monthly_salary_12b, rates_monthly_salary_9, rates_monthly_salary_10, rates_night_diff_12a, rates_night_diff_12b, rates_night_diff_9, rates_night_diff_10, rates_incentive_leave_12a, rates_incentive_leave_12b, rates_incentive_leave_9, rates_incentive_leave_10, rates_13th_mon_12a, rates_13th_mon_12b, rates_13th_mon_9, rates_13th_mon_10, rates_uniform_allowance_12a, rates_uniform_allowance_12b, rates_uniform_allowance_9, rates_uniform_allowance_10, rates_cola_m_12a, rates_cola_m_12b, rates_cola_m_9, rates_cola_m_10, rates_overtime_12a, rates_overtime_12b, rates_overtime_9, rates_overtime_10, rates_amt_due_guard_12a, rates_amt_due_guard_12b, rates_amt_due_guard_9, rates_amt_due_guard_10, rates_sss_premium_12a, rates_sss_premium_12b, rates_sss_premium_9, rates_sss_premium_10, rates_pagibig_12a, rates_pagibig_12b, rates_pagibig_9, rates_pagibig_10, rates_philhealth_12a, rates_philhealth_12b, rates_philhealth_9, rates_philhealth_10, rates_state_ins_fund_12a, rates_state_ins_fund_12b, rates_state_ins_fund_9, rates_state_ins_fund_10, rates_retirement_benefit_12a, rates_retirement_benefit_12b, rates_retirement_benefit_9, rates_retirement_benefit_10, rates_govt_dues_12a, rates_govt_dues_12b, rates_govt_dues_9, rates_govt_dues_10, rates_total_dues_12a, rates_total_dues_12b, rates_total_dues_9, rates_total_dues_10, rates_agency_percent_12a, rates_agency_percent_12b, rates_agency_percent_9, rates_agency_percent_10, rates_agency_charge_12a, rates_agency_charge_12b, rates_agency_charge_9, rates_agency_charge_10, rates_vat_12a, rates_vat_12b, rates_vat_9, rates_vat_10, rates_tot_agency_fee_12a, rates_tot_agency_fee_12b, rates_tot_agency_fee_9, rates_tot_agency_fee_10, rates_contract_per_guard_12a, rates_contract_per_guard_12b, rates_contract_per_guard_9, rates_contract_per_guard_10, rates_contract_per_month_12a, rates_contract_per_month_12b, rates_contract_per_month_9, rates_contract_per_month_10, rates_tot_contract_per_month, rates_contract_per_year, rates_contract_per_3yr)
										VALUES	(".$bu.", '".$date_saved."', ".$rowuser['id'].", ".$guard_dc.", '".$guard_dc_remarks."', ".$guard_hg.", '".$guard_hg_remarks."', ".$guard_sg.", '".$guard_sg_remarks."', ".$guard_lg.", '".$guard_lg_remarks."', ".$guard_rel.", '".$guard_rel_remarks."', ".$guard_total.", '".$guard_total_remarks."',
													".$shift_1st.", '".$shift_1st_remarks."', ".$shift_2nd.", '".$shift_2nd_remarks."', ".$shift_3rd.", '".$shift_3rd_remarks."', ".$shift_others.", '".$shift_others_remarks."', ".$security_operations_center.", '".$security_operations_center_remarks."',
													".$comms_base_radio.", '".$comms_base_radio_remarks."', ".$comms_hh_radio.", '".$comms_hh_radio_remarks."', ".$comms_mobile.", '".$comms_mobile_remarks."', ".$comms_sat_phones.", '".$comms_sat_phones_remarks."', ".$comms_repeater.", '".$comms_repeater_remarks."', ".$comms_others.", '".$comms_others_remarks."', ".$comms_total.", '".$comms_total_remarks."',
													".$surv_cctv.", '".$surv_cctv_remarks."', ".$surv_cctv_motion.", '".$surv_cctv_motion_remarks."', ".$surv_access_ctrl.", '".$surv_access_ctrl_remarks."', ".$surv_intrusion_det.", '".$surv_intrusion_det_remarks."', ".$surv_watchman.", '".$surv_watchman_remarks."', ".$surv_others.", '".$surv_others_remarks."', ".$surv_total.", '".$surv_total_remarks."',
													".$fa_9mm.", '".$fa_9mm_remarks."', ".$fa_shotgun.", '".$fa_shotgun_remarks."', ".$fa_m16.", '".$fa_m16_remarks."', ".$fa_m4.", '".$fa_m4_remarks."', ".$fa_others.", '".$fa_others_remarks."', ".$fa_total.", '".$fa_total_remarks."',
													".$veh_bicycle.", '".$veh_bicycle_remarks."', ".$veh_2w_mc.", '".$veh_2w_mc_remarks."', ".$veh_4w_atv.", '".$veh_4w_atv_remarks."', ".$veh_4w_utility.", '".$veh_4w_utility_remarks."', ".$veh_water_crafts.", '".$veh_water_crafts_remarks."', ".$veh_ambu.", '".$veh_ambu_remarks."', ".$veh_fire_truck.", '".$veh_fire_truck_remarks."', ".$veh_others.", '".$veh_others_remarks."', ".$veh_total.", '".$veh_total_remarks."',
													".$office_desktop.", '".$office_desktop_remarks."', ".$office_printer.", '".$office_printer_remarks."', ".$office_internet.", '".$office_internet_remarks."', ".$office_others.", '".$office_others_remarks."', ".$office_total.", '".$office_total_remarks."',
													".$others_metal_det.", '".$others_metal_det_remarks."', ".$others_mirror.", '".$others_mirror_remarks."', ".$others_k9.", '".$others_k9_remarks."', ".$others_searchlight.", '".$others_searchlight_remarks."', ".$others_binoculars.", '".$others_binoculars_remarks."', ".$others_stungun.", '".$others_stungun_remarks."', ".$others_firstaidkit.", '".$others_firstaidkit_remarks."', ".$others_rainboots.", '".$others_rainboots_remarks."',  ".$others_raincoat.", '".$others_raincoat_remarks."', ".$others_gasmask.", '".$others_gasmask_remarks."', ".$others_breathanalyzer.", '".$others_breathanalyzer_remarks."', ".$others_waterdispenser.", '".$others_waterdispenser_remarks."', ".$others_megaphone.", '".$others_megaphone_remarks."', ".$others_steeltoe.", '".$others_steeltoe_remarks."', ".$others_hardhat.", '".$others_hardhat_remarks."', ".$others_digicam.", '".$others_digicam_remarks."', ".$others_trafficvest.", '".$others_trafficvest_remarks."', ".$others_fireequip.", '".$others_fireequip_remarks."', ".$others_others.", '".$others_others_remarks."', ".$others_total.", '".$others_total_remarks."',
													".$rates_no_of_guards_9.", ".$rates_no_of_guards_10.", '".$rates_tour_of_duty_12a."', '".$rates_tour_of_duty_12b."', '".$rates_tour_of_duty_9."', '".$rates_tour_of_duty_10."', ".$rates_days_per_week_12a.", ".$rates_days_per_week_12b.", ".$rates_days_per_week_9.", ".$rates_days_per_week_10.", ".$rates_days_per_year_12a.", ".$rates_days_per_year_12b.", ".$rates_days_per_year_9.", ".$rates_days_per_year_10.", ".$rates_daily_wage_12a.", ".$rates_daily_wage_12b.", ".$rates_daily_wage_9.", ".$rates_daily_wage_10.", ".$rates_cola_12a.", ".$rates_cola_12b.", ".$rates_cola_9.", ".$rates_cola_10.", ".$rates_monthly_salary_12a.", ".$rates_monthly_salary_12b.", ".$rates_monthly_salary_9.", ".$rates_monthly_salary_10.", ".$rates_night_diff_12a.", ".$rates_night_diff_12b.", ".$rates_night_diff_9.", ".$rates_night_diff_10.", ".$rates_incentive_leave_12a.", ".$rates_incentive_leave_12b.", ".$rates_incentive_leave_9.", ".$rates_incentive_leave_10.", ".$rates_13th_mon_12a.", ".$rates_13th_mon_12b.", ".$rates_13th_mon_9.", ".$rates_13th_mon_10.", ".$rates_uniform_allowance_12a.", ".$rates_uniform_allowance_12b.", ".$rates_uniform_allowance_9.", ".$rates_uniform_allowance_10.", ".$rates_cola_m_12a.", ".$rates_cola_m_12b.", ".$rates_cola_m_9.", ".$rates_cola_m_10.", ".$rates_overtime_12a.", ".$rates_overtime_12b.", ".$rates_overtime_9.", ".$rates_overtime_10.", ".$rates_amt_due_guard_12a.", ".$rates_amt_due_guard_12b.", ".$rates_amt_due_guard_9.", ".$rates_amt_due_guard_10.", ".$rates_sss_premium_12a.", ".$rates_sss_premium_12b.", ".$rates_sss_premium_9.", ".$rates_sss_premium_10.", ".$rates_pagibig_12a.", ".$rates_pagibig_12b.", ".$rates_pagibig_9.", ".$rates_pagibig_10.", ".$rates_philhealth_12a.", ".$rates_philhealth_12b.", ".$rates_philhealth_9.", ".$rates_philhealth_10.", ".$rates_state_ins_fund_12a.", ".$rates_state_ins_fund_12b.", ".$rates_state_ins_fund_9.", ".$rates_state_ins_fund_10.", ".$rates_retirement_benefit_12a.", ".$rates_retirement_benefit_12b.", ".$rates_retirement_benefit_9.", ".$rates_retirement_benefit_10.", ".$rates_govt_dues_12a.", ".$rates_govt_dues_12b.", ".$rates_govt_dues_9.", ".$rates_govt_dues_10.", ".$rates_total_dues_12a.", ".$rates_total_dues_12b.", ".$rates_total_dues_9.", ".$rates_total_dues_10.", ".$rates_agency_percent_12a.", ".$rates_agency_percent_12b.", ".$rates_agency_percent_9.", ".$rates_agency_percent_10.", ".$rates_agency_charge_12a.", ".$rates_agency_charge_12b.", ".$rates_agency_charge_9.", ".$rates_agency_charge_10.", ".$rates_vat_12a.", ".$rates_vat_12b.", ".$rates_vat_9.", ".$rates_vat_10.", ".$rates_tot_agency_fee_12a.", ".$rates_tot_agency_fee_12b.", ".$rates_tot_agency_fee_9.", ".$rates_tot_agency_fee_10.", ".$rates_contract_per_guard_12a.", ".$rates_contract_per_guard_12b.", ".$rates_contract_per_guard_9.", ".$rates_contract_per_guard_10.", ".$rates_contract_per_month_12a.", ".$rates_contract_per_month_12b.", ".$rates_contract_per_month_9.", ".$rates_contract_per_month_10.", ".$rates_tot_contract_per_month.", ".$rates_contract_per_year.", ".$rates_contract_per_3yr.")")or die(mysqli_error($conn));
		
		/* mysqli_query($conn, "INSERT INTO spam_mst (bu, date_saved, user_id, guard_dc, guard_dc_remarks, guard_hg, guard_hg_remarks, guard_sg, guard_sg_remarks, guard_lg, guard_lg_remarks, guard_rel, guard_rel_remarks, guard_total, guard_total_remarks,
													shift_1st, shift_1st_remarks, shift_2nd, shift_2nd_remarks, shift_3rd, shift_3rd_remarks, shift_others, shift_others_remarks, security_operations_center, security_operations_center_remarks,
													comms_base_radio, comms_base_radio_remarks, comms_hh_radio, comms_hh_radio_remarks, comms_mobile, comms_mobile_remarks, comms_sat_phones, comms_sat_phones_remarks, comms_repeater, comms_repeater_remarks, comms_others, comms_others_remarks, comms_total, comms_total_remarks,
													surv_cctv, surv_cctv_remarks, surv_cctv_motion, surv_cctv_motion_remarks, surv_access_ctrl, surv_access_ctrl_remarks, surv_intrusion_det, surv_intrusion_det_remarks, surv_watchman, surv_watchman_remarks, surv_others, surv_others_remarks, surv_total, surv_total_remarks,
													fa_9mm, fa_9mm_remarks, fa_shotgun, fa_shotgun_remarks, fa_m16, fa_m16_remarks, fa_m4, fa_m4_remarks, fa_others, fa_others_remarks, fa_total, fa_total_remarks,
													veh_bicycle, veh_bicycle_remarks, veh_2w_mc, veh_2w_mc_remarks, veh_4w_atv, veh_4w_atv_remarks, veh_4w_utility, veh_4w_utility_remarks, veh_water_crafts, veh_water_crafts_remarks, veh_ambu, veh_ambu_remarks, veh_fire_truck, veh_fire_truck_remarks, veh_others, veh_others_remarks, veh_total, veh_total_remarks,
													office_desktop, office_desktop_remarks, office_printer, office_printer_remarks, office_internet, office_internet_remarks, office_others, office_others_remarks, office_total, office_total_remarks,
													others_metal_det, others_metal_det_remarks, others_mirror, others_mirror_remarks, others_k9, others_k9_remarks, others_searchlight, others_searchlight_remarks, others_binoculars, others_binoculars_remarks, others_stungun, others_stungun_remarks, others_firstaidkit, others_firstaidkit_remarks, others_rainboots, others_rainboots_remarks, others_raincoat, others_raincoat_remarks, others_gasmask, others_gasmask_remarks, others_breathanalyzer, others_breathanalyzer_remarks, others_waterdispenser, others_waterdispenser_remarks, others_megaphone, others_megaphone_remarks, others_steeltoe, others_steeltoe_remarks, others_hardhat, others_hardhat_remarks, others_digicam, others_digicam_remarks, others_trafficvest, others_trafficvest_remarks, others_fireequip, others_fireequip_remarks, others_others, others_others_remarks, others_total, others_total_remarks,
													rates_8hr, rates_8hr_remarks, rates_10hr, rates_10hr_remarks, rates_12hr, rates_12hr_remarks, rates_admin, rates_admin_remarks, rates_daily, rates_daily_remarks, rates_monthly, rates_monthly_remarks, rates_annual, rates_annual_remarks)
										VALUES	(".$bu.", '".$date_saved."', ".$rowuser['id'].", ".$guard_dc.", '".$guard_dc_remarks."', ".$guard_hg.", '".$guard_hg_remarks."', ".$guard_sg.", '".$guard_sg_remarks."', ".$guard_lg.", '".$guard_lg_remarks."', ".$guard_rel.", '".$guard_rel_remarks."', ".$guard_total.", '".$guard_total_remarks."',
													".$shift_1st.", '".$shift_1st_remarks."', ".$shift_2nd.", '".$shift_2nd_remarks."', ".$shift_3rd.", '".$shift_3rd_remarks."', ".$shift_others.", '".$shift_others_remarks."', ".$security_operations_center.", '".$security_operations_center_remarks."',
													".$comms_base_radio.", '".$comms_base_radio_remarks."', ".$comms_hh_radio.", '".$comms_hh_radio_remarks."', ".$comms_mobile.", '".$comms_mobile_remarks."', ".$comms_sat_phones.", '".$comms_sat_phones_remarks."', ".$comms_repeater.", '".$comms_repeater_remarks."', ".$comms_others.", '".$comms_others_remarks."', ".$comms_total.", '".$comms_total_remarks."',
													".$surv_cctv.", '".$surv_cctv_remarks."', ".$surv_cctv_motion.", '".$surv_cctv_motion_remarks."', ".$surv_access_ctrl.", '".$surv_access_ctrl_remarks."', ".$surv_intrusion_det.", '".$surv_intrusion_det_remarks."', ".$surv_watchman.", '".$surv_watchman_remarks."', ".$surv_others.", '".$surv_others_remarks."', ".$surv_total.", '".$surv_total_remarks."',
													".$fa_9mm.", '".$fa_9mm_remarks."', ".$fa_shotgun.", '".$fa_shotgun_remarks."', ".$fa_m16.", '".$fa_m16_remarks."', ".$fa_m4.", '".$fa_m4_remarks."', ".$fa_others.", '".$fa_others_remarks."', ".$fa_total.", '".$fa_total_remarks."',
													".$veh_bicycle.", '".$veh_bicycle_remarks."', ".$veh_2w_mc.", '".$veh_2w_mc_remarks."', ".$veh_4w_atv.", '".$veh_4w_atv_remarks."', ".$veh_4w_utility.", '".$veh_4w_utility_remarks."', ".$veh_water_crafts.", '".$veh_water_crafts_remarks."', ".$veh_ambu.", '".$veh_ambu_remarks."', ".$veh_fire_truck.", '".$veh_fire_truck_remarks."', ".$veh_others.", '".$veh_others_remarks."', ".$veh_total.", '".$veh_total_remarks."',
													".$office_desktop.", '".$office_desktop_remarks."', ".$office_printer.", '".$office_printer_remarks."', ".$office_internet.", '".$office_internet_remarks."', ".$office_others.", '".$office_others_remarks."', ".$office_total.", '".$office_total_remarks."',
													".$others_metal_det.", '".$others_metal_det_remarks."', ".$others_mirror.", '".$others_mirror_remarks."', ".$others_k9.", '".$others_k9_remarks."', ".$others_searchlight.", '".$others_searchlight_remarks."', ".$others_binoculars.", '".$others_binoculars_remarks."', ".$others_stungun.", '".$others_stungun_remarks."', ".$others_firstaidkit.", '".$others_firstaidkit_remarks."', ".$others_rainboots.", '".$others_rainboots_remarks."',  ".$others_raincoat.", '".$others_raincoat_remarks."', ".$others_gasmask.", '".$others_gasmask_remarks."', ".$others_breathanalyzer.", '".$others_breathanalyzer_remarks."', ".$others_waterdispenser.", '".$others_waterdispenser_remarks."', ".$others_megaphone.", '".$others_megaphone_remarks."', ".$others_steeltoe.", '".$others_steeltoe_remarks."', ".$others_hardhat.", '".$others_hardhat_remarks."', ".$others_digicam.", '".$others_digicam_remarks."', ".$others_trafficvest.", '".$others_trafficvest_remarks."', ".$others_fireequip.", '".$others_fireequip_remarks."', ".$others_others.", '".$others_others_remarks."', ".$others_total.", '".$others_total_remarks."',
													".$rates_8hr.", '".$rates_8hr_remarks."', ".$rates_10hr.", '".$rates_10hr_remarks."', ".$rates_12hr.", '".$rates_12hr_remarks."', ".$rates_admin.", '".$rates_admin_remarks."', ".$rates_daily.", '".$rates_daily_remarks."', ".$rates_monthly.", '".$rates_monthly_remarks."', ".$rates_annual.", '".$rates_annual_remarks."')")or die(mysqli_error($conn)); */
		
		header("location:user-admin.php?last=SPAM");
		
	}
	elseif(!empty($_POST['btnSubmitLocator']))
	{
		$locators = array();
		$locators = $_POST['txtAddLocators'];
		foreach($locators as $classification)
		{
			//mysqli_query($conn, "INSERT INTO incident_main_cat (main_cat) VALUES('". mysqli_real_escape_string($conn, $classification)."')")or die(mysqli_error($conn));
			mysqli_query($conn, "INSERT INTO bu_locators (bu_id, locator_name) VALUES(".$bu.",'". mysqli_real_escape_string($conn, $classification)."')")or die(mysqli_error($conn));
		}
		header("Location: user-admin.php?last=Locators");
	}
	
	elseif(!empty($_POST['btnSaveIDP']))
	{
		$idpName = $_POST['selIDPUser'];
		$idpDesc = $_POST['txtIDPDesc'];
		$idpStatus = $_POST['selIDPStatus'];
		$idpYear = $_POST['txtIDPYear'];
		$idpGroup = $_POST['txtIDPGroup'];
		$idpToken = $_POST['txtTokenType'];
		$idpEntryId = $_POST['txtEntryID'];
		
		if($idpToken == 'Add')
		{
			mysqli_query($conn, "INSERT INTO idp_mst (group_id, user_id, description, status, year) VALUES(".$idpGroup.", ".$idpUser.", '".$idpDesc."', ".$idpStatus.", ".$idpYear.")")or die(mysqli_error($conn));
		}
		elseif($idpToken == 'Edit')
		{
			mysqli_query($conn, "UPDATE idp_mst SET user_id = ".$idpName.", description = ".$idpDesc.", status = ".$idpStatus." WHERE id = ".$idpEntryId);
		}
		
		if($_SESSION['level'] == 'Super Admin')
		{
			header("Location: user-superadmin.php");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("Location: user-admin.php&testvalue=".$idpGroup);
		}
	}
}
//$busql = mysqli_query($conn, "select * from bu_mst where id ='".$_SESSION['bu']."'");
$logdate = date('Y-m-d');
$logtime = date('H:i:s');
//$activitysql = mysqli_query($conn, "select * from ticket where bu = $bu and ticket_type = 1 and dateadded=$logdate");
//$activitysql = mysqli_query($conn, "select * from ticket where bu = $bu and ticket_type = 2");
//$activitysql = mysqli_query($conn, "select * from ticket where MONTH(dateadded) = MONTH(now()) AND YEAR(dateadded) = YEAR(now()) AND bu = $bu order by datesubmitted desc");
/* $activitysql = mysqli_query($conn, "select * from ticket where ((dateadded > DATE_SUB(now(), INTERVAL 4 DAY)) OR (is_open = 1)) AND bu = $bu order by datesubmitted desc");
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
			$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."', '".$actres['severity']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td><td style=\"cursor:pointer;\" onclick=\"openRetract('". $actres['id'] ."', '". $actres['severity'] ."');\">Retract Severity</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $actres['id'] ."', 'Ticket')\"></td>";
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
			$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."', '".$actres['severity']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $actres['id'] ."', 'Ticket')\"></td>";
		}
		// $stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."', '".$actres['severity']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td><td>Retract Severity</td>";				
	}
	else
	{
		if($ticket_type == 1){
			$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$actres['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" colspan='2' onclick=\"GenerateReport(".$actres['id'].");\">Generate Report</td><td><img src=\"images/delete.png\" height=\"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $actres['id'] ."', 'Ticket')\"></td>";
		}
		else{
			$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td class=\"addlog\" colspan=\"2\">".$actres['dateclosed']."</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $actres['id'] ."', 'Ticket')\"></td>";
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
			$rowcolor = "altrows";
			$rownum = 0;
		}
		elseif($rownum == 0){
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
		$actlogtable .= "<tr align=\"center\" class='".$rowcolor."' >
							<td width=\"100%\" colspan=\"100%\">
								<div id=\"". $remarksid ."\" class=\"logs2\" style=\"display:none;\">
									<table width=\"70%\">
									<tr>
										<td colspan=\"100%\">
										Narration:
										</td>
									</tr>
									<tr>
										<td align=\"center\" colspan=\"100%\">                                    	
											<textarea style=\"width:95%; height:150px; resize:none\" readonly=\"readonly\" >". $actlogres['remarks'] ."</textarea>
										</td>
									</tr>
									<tr>
										<td align=\"left\">
											<label style=\"text-decoration:underline; cursor:pointer; color:#00F; display:none;\" onclick=\"showAttachments('".$attachmentid."');\" >Show Attachments</label>
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
		<td >". ($actres['severity'] == 0 ? $resTicketDesc['defaultlevel'] : $actres['severity']) ."</td>
        <td ><label onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</label><img src=\"images/edit icon 2.png\" align=\"right\" height=\"20px\" onclick=\"changeClassificationOpen(".$actres['id'].")\" style=\"cursor:pointer\" /></td>
        ". $stat ."        
		</tr>
		<tr>
		  <td colspan=\"100%\" align=\"center\">
			  <div id=\"". $logid ."\" class=\"logs\" style=\"display:none;\">
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
        <td onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</td>
        ". $stat ."        
      </tr>
	  <tr>
		<td colspan=\"100%\" align=\"center\">
			<div id=\"". $logid ."\" class=\"logs\" style=\"display:none;\">
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

/* $cat = "Dashboard";
if($_GET['last']){
	$cat = $_GET['last'];
}
 */
$cat = "Dashboard";
$executejs = "";
if($_GET['last']){
	$cat = $_GET['last'];
	if($cat == "Audit")
	{
		$executejs = "auditShow('".$_GET['audit_id']."');";
	}
	elseif($cat == 'Stakeholder')
	{
		$executejs = "showStakeholder('table')";
	}
}

$exprobulist = array();
$sqloption = "";
$exprobusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE expro = 1");
if($exprobusql)
{	
	while($exprobures = mysqli_fetch_assoc($exprobusql))
	{
		$exprobulist[] = "'".$exprobures['id']."'";
	}
	$exprobulist2 = implode(", ", $exprobulist);
}

if(in_array("'".$bu."'", $exprobulist))
{
	$sqloption = "";
}
else
{
	$sqloption = "WHERE bu NOT IN (".$exprobulist2.")";
}

/* $csvguards = array();
$csvguards[] = "sep=|";
$csvguards[] = "Last Name | First Name | Middle Name | Contact | Guard Code | Status | Birthdate | Civil Status | Gender | Blood Type | Present Address | Provincial Address | Date Posted | Agency Employment | Guard Category | Badge Number | License Number | License Issue Date | License Expiry Date | NTC License | NTC License Issue Date | NTC License Expiry Date | Performance | Comment"; */
$guardsql2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ".$bu." ORDER BY CASE bu WHEN ". $bu ." THEN 1 ELSE 2 END, bu, status, lname");
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
	$guardbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ". $guardres3['bu']);
	$guardbures = mysqli_fetch_assoc($guardbusql);
	$guardbu = $guardbures['bu'];
	$gstatus = $guardres3['status'];
//	$gcomment2 = $guardres3['comment'];
	$gcomment2 = preg_replace( "/\r|\n/", "<br>", $guardres3['comment'] );
//	$gcomment2 = nl2br($guardres3['comment']);
//	$gcomment2 = trim($gcomment2);	
//	$guarddata = array();
//	$guardarray = "";
//	foreach ($guardres3 as $gdata)
//	{
//		
//	}
	if($guardres3['bu'] == $bu){
		// $editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['fname']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['mname']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['lname']))) ."', '". trim($guardres3['gender']) ."', '". trim($guardres3['birthdate']) ."', '". trim($guardres3['blood_type']) ."', '". trim($guardres3['civil_status']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['present_address']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['provincial_address']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['contact']))) ."', '". trim($guardbures['bu']) ."', '". trim($guardres3['date_posted']) ."', '". trim($guardres3['agency_employment']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot', $guardres3['guard_code']))) ."', '". trim($guardres3['agency']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_category']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['badge_number']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['ntc_license']))) ."', '". trim($guardres3['ntc_license_start']) ."', '". trim($guardres3['ntc_license_end']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['license_number']))) ."', '". trim($guardres3['license_issue_date']) ."', '". trim($guardres3['license_expiry_date']) ."', '". trim($guardres3['performance']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$gcomment2))) ."', 'edit', '". trim($guardres3['id']) ."', '".trim($guardres3['status'])."', '".trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_photo'])))."');\" /></td>";
		$editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo2(".$guardres3['id'].", 'Edit')\" /></td>";
	}
	else{
		$editbtn = "<td><img src=\"images/Person_details.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['fname']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['mname']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['lname']))) ."', '". trim($guardres3['gender']) ."', '". trim($guardres3['birthdate']) ."', '". trim($guardres3['blood_type']) ."', '". trim($guardres3['civil_status']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['present_address']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['provincial_address']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['contact']))) ."', '". trim($guardbures['bu']) ."', '". trim($guardres3['date_posted']) ."', '". trim($guardres3['agency_employment']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_code']))) ."', '". trim($guardres3['agency']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_category']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['badge_number']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['ntc_license']))) ."', '". trim($guardres3['ntc_license_start']) ."', '". trim($guardres3['ntc_license_end']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['license_number']))) ."', '". trim($guardres3['license_issue_date']) ."', '". trim($guardres3['license_expiry_date']) ."', '". trim($guardres3['performance']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$gcomment2))) ."', 'view', '". trim($guardres3['id']) ."', '".trim($guardres3['status'])."', '".trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_photo'])))."');\" /></td>";
	}
	$guardstable .= "<tr ". $rowclass ." align=\"center\">
						<td>". $guardnum ."</td>
						<td>". $glastname . "</td>
						<td>". $gfirstname . "</td>						
						<td>". $gcode . "</td>						
						<td>". $guardbu . "</td>
						<td>". $gstatus . "</td>
						". $editbtn ."
					 </tr>";
	$guardnum++;
	//$csvguards[] = $glastname . " | ". $gfirstname . " | ". $gmiddlename . " | ". $gcontact . " | ". $gcode . " | ". $gstatus . "| ".$guardres3['birthdate']." | ".$guardres3['civil_status']." | ".$guardres3['gender']." | ".$guardres3['blood_type']." | ".$guardres3['present_address']." | ".$guardres3['provincial_address']." | ".$guardres3['date_posted']." | ".$guardres3['agency_employment']." | ".$guardres3['guard_category']." | ".$guardres3['badge_number']." | ".$guardres3['license_number']." | ".$guardres3['license_issue_date']." | ".$guardres3['license_expiry_date']." | ".$guardres3['ntc_license']." | ".$guardres3['ntc_license_start']." | ".$guardres3['ntc_license_end']." | ".$guardres3['performance']." | ".$guardres3['comment'];
}
//$csvstring = implode(" %0D%0A ", $csvguards);
//$guardstable .= "<tr align=''right'><td colspan='100%' align='right'><a href=\"data:application/csv;charset=utf-8, ".str_replace('"', '%22', (str_replace(" ", "%00%20", $csvstring)))."\"  target=\"_blank\" download=\"GuardPersonnel.csv\"><img style=\"vertical-align:bottom;\" height=\"30px\" src=\"images/csvbtn.png\"></a></td></tr>";
$guardstable .= "<tr align=''right'><td colspan='100%' align='right'><button class=\"redbutton\" style=\"cursor:pointer;\" onclick=\"fnExcelReport('tblGuards');\">CSV</button></td></tr>";

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
							<td align=\"left\" style=\"padding-left:50px\">". $codedesc ."</td>
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

// NOMINATE AGENCY IN BIDDING 
$biddingnum = 1;
$biddingtable = '';
$nomination_color = '';
$nomination_style = '';
$bidding_status_style = '';
$bidding_status_color = '';
$tr_color = '';
$statusText = '';
$getClusterQuery = mysqli_query($conn, "SELECT bu_mst.cluster_group FROM `users_mst` INNER JOIN bu_mst ON users_mst.bu = bu_mst.id WHERE users_mst.id = " . $_SESSION['id']);
$getCluster = mysqli_fetch_assoc($getClusterQuery);
$addAgencyStatus = '';
$biddingsql = mysqli_query($conn, "SELECT bidding.*, cluster_group.name as cluster FROM bidding INNER JOIN cluster_group ON bidding.cluster_id = cluster_group.id WHERE bidding.cluster_id = " . $getCluster['cluster_group'] . " ORDER BY bidding_status DESC");
while ($bidding = mysqli_fetch_assoc($biddingsql)) {

	
	if ($bidding['bidding_status'] == 'Nomination') {
		$addAgencyStatus = "<td data-column=\"Progress\" class=\"table-row__td\">
								<a href=\"javascript:void(0)\" style=\"cursor:pointer;\" onclick=\"biddingAddSecAgencyModal('" . $bidding['id'] . "');\">Add Security Agency</a>
							</td>";
		$bidding_status_style = 'status--green';
		$statusText = 'Ongoing';
	} elseif ($bidding['bidding_status'] == 'Assessment') {
		$addAgencyStatus = "<td data-column=\"Progress\" class=\"table-row__td\">
								<a href=\"javascript:void(0)\" style=\"cursor:pointer;\" onclick=\"viewBiddingSecAgencyModal('" . $bidding['id'] . "');\">View Security Agency</a>
							</td>";
		$bidding_status_style = 'status--red';
		$statusText = 'Closed';
	} elseif ($bidding['bidding_status'] == 'Prebid') {
		$addAgencyStatus = "<td data-column=\"Progress\" class=\"table-row__td\">
								<a href=\"javascript:void(0)\" style=\"cursor:pointer;\" onclick=\"viewBiddingSecAgencyModal('" . $bidding['id'] . "');\">View Security Agency</a>
							</td>";
		$bidding_status_style = 'status--red';
		$statusText = 'Closed';
	}
	// 	<td align=\"center\" ><span style=\"background-color: " . $bidding_status_color . ";color: white; padding: 1px 8px;text-align: center; border-radius: 5px; font-size: 13px;\">" . $bidding['bidding_status'] . "</span></td>

	$biddingtable .= "<tr align=\"center\" height=\"25px\" style=\"font-weight: 500;\" class=\"table-row \" >
							<td  class=\"table-row__td\">" . $biddingnum . "</td>
							<td align=\"center\"  class=\"table-row__td\"><div class=\"table-row__info\"><p class=\"table-row__name\">" . $bidding['bidding_name'] . "</p></div></td>
							<td align=\"center\" class=\"table-row__td\"><div><p class=\"table-row__policy\">" . $bidding['cluster'] . "</p></div></td>
							<td data-column=\"Policy status\" class=\"table-row__td\">
								<p class=\"table-row__p-status " . $bidding_status_style . " status\">" . $statusText .  "</p>
							</td>
							<td align=\"center\" class=\"table-row__td\">36 Points Requirement</td>
							" . $addAgencyStatus .  "
							<td data-column=\"Progress\" class=\"table-row__td\">
								<a href=\"javascript:void(0)\" style=\"cursor:pointer;\" onclick=\"biddingSecAgencyModal('" . $bidding['id'] . "');\">Evaluate Agency</a>
							</td>
							
						 </tr>";
	$nomination_color = '';
	$biddingnum++;
}

$incidentcount = 0;
$incidentcountsql = mysqli_query($conn,"SELECT COUNT(id) AS Incident_Count FROM ticket WHERE ticket_type = 1 AND bu = $bu AND MONTH(dateadded) = MONTH(now()) AND YEAR(dateadded) = YEAR(now());");
$incidentcountres = mysqli_fetch_assoc($incidentcountsql);
$incidentcount = $incidentcountres['Incident_Count'];
$incidentcountsql2 = mysqli_query($conn,"SELECT * FROM ticket WHERE ticket_type = 1 AND YEAR(dateadded) = YEAR(now());");



$sqldetermineexpro = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$_SESSION['bu']);
$sqldetermineexprores = mysqli_fetch_assoc($sqldetermineexpro);
if($sqldetermineexprores['expro'] == 1)
{
	eval('$body = "' . fetch_template('user-exproadmin') . '";');
}
elseif($_SESSION['hguard'] == 1)
{
	eval('$body = "' . fetch_template('head-guard') . '";');
}
else
{
	eval('$body = "' . fetch_template('user-admin') . '";');
}


echo stripslashes($body);

?>

