<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$term = mysqli_real_escape_string($conn, $_GET['term']);
$category = mysqli_real_escape_string($conn, $_GET['category']);
$group = mysqli_real_escape_string($conn, $_GET['group']);
$ccyear = mysqli_real_escape_string($conn, $_GET['ccyear']);
$ccmonth = mysqli_real_escape_string($conn, $_GET['ccmonth']);
$ccbu = mysqli_real_escape_string($conn, $_GET['ccbu']);
$ccsecagency = mysqli_real_escape_string($conn, $_GET['ccsecagency']);

$resulttable = "";
$listOfBU = array();

if($_SESSION['multi-admin']) {
	$listOfIDQuery = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id ='" . $_SESSION['id'] . "'");
	$buCount = 0;
	while ($list = mysqli_fetch_assoc($listOfIDQuery)) {
		$listOfBU[$buCount] = $list['bu_id'];
		$buCount++;
	}
}

if($group == "guard_personnel")
{
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
		if($_SESSION['multi-admin']) {
			$sqloption = "";
		} else {
			$sqloption = "AND bu NOT IN (".$exprobulist2.")";
		}
	}
	$sqlsearchcategory = "";
	if($_SESSION['level'] != 'User')
	{
		if($category == "bu")
		{
			$sqlsearchcategory = " ".$category." = ".$term." ";
		}
		else
		{  
			$sqlsearchcategory = " ".$category." LIKE '%".$term."%' ";
		}

		$guardsql2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE ".$sqlsearchcategory." ".$sqloption." ORDER BY bu, status, lname");
	
	}
	else
	{
		$guardsql2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE ".$category." LIKE '%".$term."%' AND bu = ". $bu ." ORDER BY CASE bu WHEN ". $bu ." THEN 1 ELSE 2 END, bu, status, lname");
	}  

  $guardstable = "";
  $guardnum = 1;
  $guardrow = 0;
  $csvguards = array();
  $csvguards[] = "sep=|";
  $csvguards[] = "Last Name | First Name | Middle Name | Contact | Guard Code | Status | Birthdate | Civil Status | Gender | Blood Type | Present Address | Provincial Address | Date Posted | Agency Employment | Guard Category | Badge Number | License Number | License Issue Date | License Expiry Date | NTC License | NTC License Issue Date | NTC License Expiry Date | Performance | Comment";
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
	  $gcomment2 = preg_replace( "/\r|\n/", "<br>", $guardres3['comment'] );	

	  if((($guardres3['bu'] == $bu) and ($_SESSION['level'] == 'Admin')) or ($_SESSION['level'] == 'Super Admin')){
		  // $editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". trim(str_replace("'", "\\'", str_replace('"', '&quot', $guardres3['fname']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['mname']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['lname']))) ."', '". trim($guardres3['gender']) ."', '". trim($guardres3['birthdate']) ."', '". trim($guardres3['blood_type']) ."', '". trim($guardres3['civil_status']) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['present_address']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['provincial_address']))) ."', '". trim($guardres3['contact']) ."', '". trim($guardres3['bu']) ."', '". trim($guardres3['date_posted']) ."', '". trim($guardres3['agency_employment']) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['guard_code']))) ."', '". trim($guardres3['agency']) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['guard_category']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['badge_number']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['license_number']))) ."', '". trim($guardres3['license_issue_date']) ."', '". trim($guardres3['license_expiry_date']) ."', '". trim($guardres3['performance']) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$gcomment2))) ."', 'edit', '". trim($guardres3['id']) ."', '".trim($guardres3['status'])."', '".trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['guard_photo'])))."');\" /></td>";
		  $editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo2(".$guardres3['id'].", 'Edit');\" /></td>";
		  // $editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". $gfirstname ." ". $glastname ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". $guardres3['fname'] ."', '". $guardres3['mname'] ."', '". $guardres3['lname'] ."', '". $guardres3['gender'] ."', '". $guardres3['birthdate'] ."', '". $guardres3['blood_type'] ."', '". $guardres3['civil_status'] ."', '". $guardres3['present_address'] ."', '". $guardres3['provincial_address'] ."', '". $guardres3['contact'] ."', '". $guardbures['bu'] ."', '". $guardres3['date_posted'] ."', '". $guardres3['agency_employment'] ."', '". $guardres3['guard_code'] ."', '". $guardres3['agency'] ."', '". $guardres3['guard_category'] ."', '". $guardres3['badge_number'] ."', '". $guardres3['license_number'] ."', '". $guardres3['license_issue_date'] ."', '". $guardres3['license_expiry_date'] ."', '". $guardres3['performance'] ."', '". $gcomment2 ."', 'edit', '". $guardres3['id'] ."', '".$guardres3['status']."');\" /></td>";
	  }
	  else{
		  // $editbtn = "<td><img src=\"images/Person_details.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". trim(str_replace("'", "\\'", str_replace('"', '&quot', $guardres3['fname']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['mname']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['lname']))) ."', '". trim($guardres3['gender']) ."', '". trim($guardres3['birthdate']) ."', '". trim($guardres3['blood_type']) ."', '". trim($guardres3['civil_status']) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['present_address']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['provincial_address']))) ."', '". trim($guardres3['contact']) ."', '". trim($guardbures['bu']) ."', '". trim($guardres3['date_posted']) ."', '". trim($guardres3['agency_employment']) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['guard_code']))) ."', '". trim($guardres3['agency']) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['guard_category']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['badge_number']))) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['license_number']))) ."', '". trim($guardres3['license_issue_date']) ."', '". trim($guardres3['license_expiry_date']) ."', '". trim($guardres3['performance']) ."', '". trim(str_replace("'", "\\'", str_replace('"', '&quot',$gcomment2))) ."', 'view', '". trim($guardres3['id']) ."', '".trim($guardres3['status'])."', '".trim(str_replace("'", "\\'", str_replace('"', '&quot',$guardres3['guard_photo'])))."');\" /></td>";
		  $editbtn = "<td><img src=\"images/Person_details.png\" height=\"28px\" title=\"VIEW ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo2(".$guardres3['id'].", 'View');\" /></td>";
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
	  $csvguards[] = $glastname . " | ". $gfirstname . " | ". $gmiddlename . " | ". $gcontact . " | ". $gcode . " | ". $gstatus . "| ".$guardres3['birthdate']." | ".$guardres3['civil_status']." | ".$guardres3['gender']." | ".$guardres3['blood_type']." | ".$guardres3['present_address']." | ".$guardres3['provincial_address']." | ".$guardres3['date_posted']." | ".$guardres3['agency_employment']." | ".$guardres3['guard_category']." | ".$guardres3['badge_number']." | ".$guardres3['license_number']." | ".$guardres3['license_issue_date']." | ".$guardres3['license_expiry_date']." | ".$guardres3['ntc_license']." | ".$guardres3['ntc_license_start']." | ".$guardres3['ntc_license_end']." | ".$guardres3['performance']." | ".$guardres3['comment'];
  }
  $csvstring = implode(" %0D%0A ", $csvguards);
  $guardstable .= "<tr align=''right'><td colspan='100%' align='right'><a href=\"data:application/csv;charset=utf-8, ".str_replace('"', '%22', (str_replace(" ", "%00%20", $csvstring)))."\"  target=\"_blank\" download=\"GuardPersonnel.csv\"><img style=\"vertical-align:bottom;\" height=\"30px\" src=\"images/csvbtn.png\"></a></td></tr>";
  $resulttable = $guardstable;
}
elseif($group == "agency_mst")
{
	$secagencytable = "";
	$secagencynum = 1;
	$secagencyrow = 1;
	if($category == "bu")
	{
		$secagencybulist2 = array();
		$secagencybunames2 = "";	
		$secagencysql2 = mysqli_query($conn, "SELECT * FROM agency_bu WHERE bu_id = '".$term."'");
		while($secagencybures2 = mysqli_fetch_assoc($secagencysql2))
		{
			$secagencybulist2[] = $secagencybures2['agency_id'];
		}
		$secagencybunames2 = implode(", ", $secagencybulist2);
		if(empty($secagencybunames2))
		{
			$secagencybunames2 = 0;
		}
		$secagencysql = mysqli_query($conn,"SELECT * FROM agency_mst WHERE id IN (".$secagencybunames2.") ORDER BY agency_name");
	}
	else
	{
		$secagencysql = mysqli_query($conn,"SELECT * FROM agency_mst WHERE ".$category." LIKE '%".$term."%' ORDER BY agency_name");
	}
	while($secagencyres = mysqli_fetch_assoc($secagencysql))
	{		
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
		//$secagencyprofile = $secagencyres['company_profile'];
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
		$secagencytable .= "<tr align=\"center\" ".$secagerowclass.">" .
								"<td>".$secagencynum."</td>" .
								"<td>".$secagencyname."</td>" .
								"<td>".$secagencyaddress."</td>" .
								"<td>".$secagencyoic."</td>" .
								"<td>".$secagencycontact."</td>" .
								"<td>".$secagencybunames."</td>" .
								"<td>".$secagencycontract."</td>";
		if($_SESSION['level']  == "Admin")
		{
			$secagencytable .= "<td><img src=\"images/View_Details.png\"";
		}
		elseif($_SESSION['level']  == "Super Admin")
		{
			$secagencytable .= "<td><img src=\"images/edit2.png\"";
		}
		$secagencytable .= " height=\"24px\" style=\"cursor:pointer;\" onclick=\"viewAgency('".$secagencyid."', '".str_replace("'", "\\'", str_replace('"', '&quot',$secagencyname))."', '".str_replace("'", "\\'", str_replace('"', '&quot',$secagencyaddress))."', '".str_replace("'", "\\'", str_replace('"', '&quot',$secagencyoic))."', '".str_replace("'", "\\'", str_replace('"', '&quot',$secagencycontact))."', '".str_replace("'", "\\'", str_replace('"', '&quot',$secagencyres['license_number']))."', '".$secagencyres['license_issued']."', '".$secagencyres['license_expiration']."', '".str_replace("'", "\\'", str_replace('"', '&quot',$secagencyprofile))."', '".$secagencyres['contract_status']."')\"></td>";
		$secagencynum++;					
	}
	$resulttable = $secagencytable;
}
elseif($group == "urc_mst")
{
	$codetable = "";
	$codessql = mysqli_query($conn, "SELECT * FROM urc_mst WHERE codes LIKE '%".$term."%' OR description LIKE '%".$term."%' ORDER BY series, codes");
	while($coderes = mysqli_fetch_assoc($codessql)){
		$codes = $coderes['codes'];
		$codedesc = $coderes['description'];
		$codeseries = $coderes['series'];	
		$codetable .= "<tr align=\"center\">
							<td>". $codes ."</td>
							<td align=\"center\" >". $codedesc ."</td>";
		if($_SESSION['level'] == 'Super Admin')
		{
			$codetable .= "<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editCodeEntry('".$coderes['id']."', '".$codes."', '".$codedesc."');\" /></td>
							<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem(".$coderes['id'].",'CodeMgt');\" /></td>";
		}					
		$codetable .= "</tr>";
		
	}
	$resulttable = $codetable;
}

elseif($group == "location_mst")
{
	
	$locationstable = "";
	$locationnumber = 1;
	$locationrow = 1;
	$rowclass2 = "";
	if(($_SESSION['level']=="Super Admin") || ($_SESSION['multi-admin']))
	{
		if($category == "bu")
		{
			$locselsql = "SELECT * FROM location_mst WHERE ".$category."= ".$term." ORDER BY location_code";
		}
		else
		{
			$locselsql = "SELECT * FROM location_mst WHERE (location_code LIKE '%".$term."%' OR location LIKE '%".$term."%') ORDER BY location_code";
		}
	}
	else
	{
		echo '2';
		$locselsql = "SELECT * FROM location_mst WHERE bu=".$bu." AND (location_code LIKE '%".$term."%' OR location LIKE '%".$term."%') ORDER BY location_code";
	}
	$locsql = mysqli_query($conn, $locselsql);
	while($locres2 = mysqli_fetch_assoc($locsql)){
		if($locationrow==1){
			$rowclass2 = "class=\"altrows\"";
			$locationrow = 0;
		}
		elseif($locationrow==0){
			$rowclass2 = "";
			$locationrow = 1;
		}
		$locationbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$locres2['bu']);
		$locationbu = mysqli_fetch_assoc($locationbusql);
		if ($_SESSION['multi-admin']) {
			$locationstable .= "<tr ". $rowclass2 ." align=\"center\">" .
			"<td>". $locationnumber ."</td>" .
			"<td>". $locationbu['bu'] ."</td>" .
			"<td>".$locres2['location_code']."</td>" .
			"<td>".$locres2['location']."</td>" .
		"</tr>";	
		} else {
			$locationstable .= "<tr ". $rowclass2 ." align=\"center\">" .
			"<td>". $locationnumber ."</td>" .
			"<td>". $locationbu['bu'] ."</td>" .
			"<td>".$locres2['location_code']."</td>" .
			"<td>".$locres2['location']."</td>" .
			"<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit Location\" style=\"cursor:pointer;\" onclick=\"editLocation('".$locres2['location_code']."', '".$locres2['location']."', ".$locres2['id'].", ".$locres2['bu'].");\" /></td>" .
			"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem(".$locres2['id'].",'Locs');\" /></td>".
		"</tr>";	
		}	
		$locationnumber++;
		$resulttable = $locationstable;
	}
}

elseif($group == "bu_mst")
{
	
	$butable = "";
	$bunumber = 1;
	$bulistsql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE ".$category." LIKE '%".$term."%' ORDER by bu");
	while($bulistres = mysqli_fetch_assoc($bulistsql))
	{
			
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
	$resulttable = $butable;
}

elseif($group == "users_mst")
{
	$userstable = "";	
	$acctdata = "";
	$usersnumber = 1;
	$userquery = "";
	if(($category == 'bu') or ($category == 'gender'))
	{
		$userquery = "SELECT * FROM users_mst WHERE ".$category."= '".$term."' ORDER BY lname";
	}
	else
	{
		$userquery = "SELECT * FROM users_mst WHERE ".$category." LIKE '%".$term."%' ORDER BY lname";
	}
	$userssql = mysqli_query($conn, $userquery);
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
			if(!$_SESSION['multi-admin']) {
				$finaldisplaybu .= " - <a style='color:blue; cursor:pointer;' onclick='openMultipleBUModal(".$usersres['id'].");'>EDIT</a>";
			}
		}
		/* $userbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$usersres['bu']);
		$userbu = mysqli_fetch_assoc($userbusql); */
		$iconcolor = ($usersres['status'] == 'Active') ? "green" : "red";
		if($_SESSION['multi-admin']) {
		$acctdata = "<tr align=\"center\">" .
							"<td>" . $usersnumber . "</td>" .
							"<td>".$usersres['lname'].", ".$usersres['fname']." ".$usersres['mi']."</td>".
							"<td>".$usersres['gender']."</td>".
							"<td>".$usersres['email']."</td>".
							"<td>".$usersres['level']."</td>".
							"<td>".$finaldisplaybu."</td>".
							"<td>".$usersres['contact']."</td>".
							"<td>".$usersres['status']."</td>".
							"<td><img src=\"images/activate".$iconcolor.".png\" height=\"32px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$usersres['id']."', 'Users');\" /></td>".
					  "</tr>";

		} else {
		$acctdata = "<tr align=\"center\">" .
							
							"<td>".$usersres['lname'].", ".$usersres['fname']." ".$usersres['mi']."</td>".
							"<td>".$usersres['gender']."</td>".
							"<td>".$usersres['email']."</td>".
							"<td>".$usersres['level']."</td>".
							"<td>".$finaldisplaybu."</td>".
							"<td>".$usersres['contact']."</td>".
							"<td>".$usersres['status']."</td>".
							"<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit User\" style=\"cursor:pointer;\" onclick=\"editUser('".$usersres['lname']."', '".$usersres['fname']."', '".$usersres['mi']."', '".$usersres['gender']."', '".$usersres['email']."', '".$usersres['level']."', '".$usersres['contact']."', '".$usersres['id']."', '".$usersres['bu']."')\" /></td>".
							"<td><img src=\"images/activate".$iconcolor.".png\" height=\"32px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$usersres['id']."', 'Users');\" /></td>".
//							"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$usersres['id']."', 'Users');\" /></td>".
					  "</tr>";
		}
		$usersnumber++;
		$userstable .= $acctdata;		
	}
	$resulttable = $userstable;
}

elseif($group == "oic_mst")
{
	$oictable = "";
	$oicnumber = 1;
	$oicrow = 1;
	if(($_SESSION['level']=="Super Admin") || ($_SESSION['multi-admin']))
	{
		$oicsql = mysqli_query($conn, "SELECT * FROM oic_mst WHERE ".$category." LIKE '%".$term."%' ORDER BY bu, lname");
	}
	else
	{
		$oicsql = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu=$bu AND ".$category." LIKE '%".$term."%' ORDER BY bu, lname");
	}
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

		if($_SESSION['multi-admin']) {
			$oictable .= "<tr align=\"center\" ".$oicrowclass.">
			<td>".$oicnumber."</td>
			<td>".$oicres['lname'].", ".$oicres['fname']."</td>
			<td>".$oicres['email_ad']."</td>
			
			<td>".$oicbu['bu']."</td>
			<td>".$oicres['slevel']."</td>
				  </tr>";
		} else {
			$oictable .= "<tr align=\"center\" ".$oicrowclass.">
			<td>".$oicnumber."</td>
			<td>".$oicres['lname'].", ".$oicres['fname']."</td>
			<td>".$oicres['email_ad']."</td>
			
			<td>".$oicbu['bu']."</td>
			<td>".$oicres['slevel']."</td>
			<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit Recipient\" style=\"cursor:pointer;\" onclick=\"editOic('".$oicres['fname']."', '".$oicres['lname']."', '".$oicres['email_ad']."', '".$oicres['id']."', '".$oicres['bu']."', '".$oicres['slevel']."')\" /></td>
			<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$oicres['id']."', 'SecAlert');\" /></td>
	  </tr>";
		}
						$oicnumber++;
	}
	$resulttable = $oictable;
}
elseif($group == "cc_mst")
{	
	$condition = "";
	$condition2 = "";	
	$ccrow = 1;
	$conditionarray = array();	
	if(($ccyear) && ($ccyear != 0))
	{
		$conditionarray[] = " year = ".$ccyear." ";
	}
	if(($ccmonth) && ($ccmonth != 0))
	{
		$conditionarray[] = " month = ".$ccmonth." ";
	}
	if(($ccbu) && ($ccbu != 0))
	{
		$conditionarray[] = " bu = ".$ccbu." ";
	}
	if(($ccsecagency) && ($ccsecagency != 0))
	{
		$conditionarray[] = " agency = ".$ccsecagency." ";
	}
	if($_SESSION['level'] == "Admin")
	{
		$conditionarray[] = " published = 1 ";
	}
	$conditioncc = implode("AND", $conditionarray);
	if($conditioncc)
	{
		$conditioncc2 = "WHERE ". $conditioncc;
	}
	$cclist = "";
	$ccsql = mysqli_query($conn, "SELECT * FROM cc_mst ".$conditioncc2." ORDER BY year, month")or die(mysqli_error($conn));
	while($ccres = mysqli_fetch_assoc($ccsql))
	{
		if($ccrow==1){
			$ccrowclass = "class=\"altrows\"";
			$ccrow = 0;
		}
		elseif($ccrow==0){
			$ccrowclass = "";
			$ccrow = 1;
		}
		
		if($ccres['month'] == 1)
		{
			$ccmonth2 = "January";
		}
		elseif($ccres['month'] == 2)
		{
			$ccmonth2 = "February";
		}
		elseif($ccres['month'] == 3)
		{
			$ccmonth2 = "March";
		}
		elseif($ccres['month'] == 4)
		{
			$ccmonth2 = "April";
		}
		elseif($ccres['month'] == 5)
		{
			$ccmonth2 = "May";
		}
		elseif($ccres['month'] == 6)
		{
			$ccmonth2 = "June";
		}
		elseif($ccres['month'] == 7)
		{
			$ccmonth2 = "July";
		}
		elseif($ccres['month'] == 8)
		{
			$ccmonth2 = "August";
		}
		elseif($ccres['month'] == 9)
		{
			$ccmonth2 = "September";
		}
		elseif($ccres['month'] == 10)
		{
			$ccmonth2 = "October";
		}
		elseif($ccres['month'] == 11)
		{
			$ccmonth2 = "November";
		}
		elseif($ccres['month'] == 12)
		{
			$ccmonth2 = "December";
		}
		
		$ccbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$ccres['bu']);
		$ccbures = mysqli_fetch_assoc($ccbusql);
		
		$ccsecagencysql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE id = ".$ccres['agency']);
		$ccsecagencyres = mysqli_fetch_assoc($ccsecagencysql);
		
		if($_SESSION['level'] == "Super Admin")
		{
			$ccswap = "swap('cConCom')";
		}
		elseif($_SESSION['level'] == "Admin")
		{
			$ccswap = "swap('cConCom2')";
		}
		
		$cclist .= "<tr align=\"center\" ".$ccrowclass.">
							<td>".$ccres['id']."</td>
							<td>".$ccbures['bu']."</td>
							<td>".$ccsecagencyres['agency_name']."</td>
							<td>".$ccres['year']."</td>
							<td>".$ccmonth2."</td>
							<td colspan=\"100%\"><label style=\"text-decoration:underline; color:#00F; cursor:pointer;\" onclick=\"openCC('".$ccres['id']."', '".$ccres['bu']."', '".$ccres['agency']."', '".$ccres['year']."', '".$ccres['month']."', '".$ccres['agency_oic']."', '".$ccres['oic_email']."', '".$ccres['total_weight']."', '".$ccres['score']."', '".$_SESSION['level']."'); ".$ccswap."; searchItem('".$ccres['id']."', 'ccdetails', 'contract_compliance');\">Open</label></td>
					  </tr>";
							$ccnumber++;
	}
	$resulttable = $cclist;	
}
elseif($group=="contract_compliance")
{
	$showcclist = "";
	$showccrow = 1;
	$showccformula = "";
	$showccsql = mysqli_query($conn, "SELECT * FROM contract_compliance WHERE ccid = ". $term ." ORDER BY number");
	if($showccsql)
	{
		while($showccres = mysqli_fetch_assoc($showccsql))
		{
			if($showccrow==1){
				$showccrowclass = "class=\"altrows\"";
				$showccrow = 0;
			}
			elseif($showccrow==0){
				$showccrowclass = "";
				$showccrow = 1;
			}
			
			if($showccres['formula'] == 1)
			{
				$showccformula = "(Actual*Wt)/Planned";
			}
			elseif($showccres['formula'] == 2)
			{
				$showccformula = "Wt less Factor per Non Compliance";
			}
			elseif($showccres['formula'] == 3)
			{
				$showccformula = "Deduction";
			}
			
			if($_SESSION['level'] == "Admin")
			{
				$showcclist .= "<tr align=\"center\" ".$showccrowclass.">
								<td>".$showccres['number']."</td>
								<td>".$showccres['goal']."</td>
								<td>".$showccres['subgoal']."</td>
								<td>".$showccres['reference']."</td>
								<td>".$showccres['standard']."</td>
								<td>".$showccres['frequency']."</td>
								<td>".$showccres['source']."</td>
								<td>".$showccformula."</td>
								<td>".$showccres['weight']."</td>
								<td>".$showccres['factor']."</td>
								<td><input type='text' size='3'></td>
								<td><input type='text' size='3'></td>
								<td><textarea width='150'></textarea></tD>
							</tr>";
			}
			elseif($_SESSION['level'] == "Super Admin")
			{
				$showcclist .= "<tr align=\"center\" ".$showccrowclass.">
								<td>".$showccres['number']."</td>
								<td>".$showccres['goal']."</td>
								<td>".$showccres['subgoal']."</td>
								<td>".$showccres['reference']."</td>
								<td>".$showccres['standard']."</td>
								<td>".$showccres['frequency']."</td>
								<td>".$showccres['source']."</td>
								<td>".$showccformula."</td>
								<td>".$showccres['weight']."</td>
								<td>".$showccres['factor']."</td>
								<td><img src=\"images/edit2.png\" height=\"28px\" title=\"Edit\" style=\"cursor:pointer;\" onclick=\"editCCFormOpen('".$showccres['number']."', '".$showccres['goal']."', '".$showccres['subgoal']."', '".$showccres['reference']."', '".$showccres['standard']."', '".$showccres['frequency']."', '".$showccres['source']."', '".$showccres['formula']."', '".$showccres['weight']."', '".$showccres['factor']."', '".$showccres['id']."');\"></td>
								<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Entry\" style=\"cursor:pointer;\" onclick=\"deleteItem3(".$showccres['id'].", 'ConComp', ".$showccres['weight'].", ".$showccres['ccid'].");\"></td>
							</tr>";
			}
			
		}
	}
	$resulttable = $showcclist;
}
elseif($group=="incident_classification")
{
	
}


if(!empty($resulttable))
{
	echo $resulttable;	
}
else
{	
	echo "<tr><td colspan=\"100%\" align=\"center\">No Records ".$_GET['term']."</td></tr>";
}

?>