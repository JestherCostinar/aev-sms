<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

if($_SESSION['level'] == "Admin")
{
	$delbtn = "style='display:none;'";
}
elseif($_SESSION['level'] == "Super Admin")
{
	$delbtn = "";
}

$type = mysqli_real_escape_string($conn, $_GET['type']);
$id = mysqli_real_escape_string($conn, $_GET['id']);
$id2 = mysqli_real_escape_string($conn, $_GET['id2']);
$resulttable = "";
if($type == "agencybu")
{
	$result = mysqli_query($conn, "SELECT * FROM agency_bu WHERE agency_id=".$id);
	while($row = mysqli_fetch_assoc($result))
	{
		$pdf = "<label style='color:red; cursor:pointer;' onclick='openPDFadd(".$row['id'].", 3);'>Add</label>";
		if($_SESSION['level'] == "Admin")
		{
			$pdf = "<label style='color:red; cursor:pointer;' >None</label>";
		}
		if($row['pdf_file'] != "None")
		{
			$pdf = "<a href='".$row['pdf_file']."' target='_blank' style='color:blue;'>View</a>";
			if($_SESSION['level'] == "Admin")
			{
				$pdf = "<a href='".$row['pdf_file']."' target='_blank' style='color:blue;'>View</a>";
			}
		}
		$result2 = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id='".$row['bu_id']."'");
		$row2 = mysqli_fetch_assoc($result2);
		$resulttable .= "<tr align=\"center\">" .
							"<td>".$row2['bu']."</td>" .
							"<td>".$row['start']."</td>" .
							"<td>".$row['end']."</td>" .
							"<td align='center'>".$pdf."</td>" .
							"<td ".$delbtn."><img src=\"images/edit2.png\" height=\"20px\" title=\"Update\" style=\"cursor:pointer;\" onclick=\"openPDFadd(".$row['id'].", 2);\" /><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$row['id']."', 'SecAgencyBu');\" /></td>" .
						"</tr>";
	}
}
elseif($type == "agencyclient")
{
	$result = mysqli_query($conn, "SELECT * FROM agency_clients WHERE agency_id=".$id);
	while($row = mysqli_fetch_assoc($result))
	{
		$resulttable .= "<tr align=\"center\">" .
							"<td>".$row['client_name']."</td>" .
							"<td>".$row['start']."</td>" .
							"<td>".$row['end']."</td>" .
							"<td ".$delbtn."><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Client\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$row['id']."', 'SecAgencyClient');\" /></td>" .
						"</tr>";
	}
}
elseif($type == "agencyremarks")
{
	$result = mysqli_query($conn, "SELECT * FROM agency_remarks WHERE agency_id=".$id);
	while($row = mysqli_fetch_assoc($result))
	{
		$resulttable .= "<tr align=\"center\">" .
							"<td>".$row['remarks_date']."</td>" .
							"<td>".$row['remarks']."</td>" .
							"<td ".$delbtn."><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Remarks\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$row['id']."', 'SecAgencyRemarks');\" /></td>" .
						"</tr>";
	}
}
elseif($type == "dropdownGuard")
{
	$guardsdatalist = "";
	$ticketbusql = mysqli_query($conn, "SELECT * FROM ticket WHERE id =". $id);
	$resticket = mysqli_fetch_assoc($ticketbusql);
	$checkexprosql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$resticket['bu']);
	$checkexprores = mysqli_fetch_assoc($checkexprosql);
	$guardbu = $resticket['bu'];
	if($checkexprores['expro'] == 1) //if expro bu, point guard db to expro visayas, id = 24
	{
		$guardbu = 24;
	}
	$guardsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ". $guardbu ." AND status='Active' ORDER BY lname, fname, mname");
	while($guardres2 = mysqli_fetch_assoc($guardsql))
	{
		$guardsdatalist .= "<option value=\"". $guardres2['id'] . "\">".  $guardres2['guard_code'] ." - ".  $guardres2['lname'] .", ". $guardres2['fname'] ."</option>";		
	}
	$resulttable = "<option value=\"\" selected=\"selected\"></option>". $guardsdatalist;	 
}
elseif($type == "dropdownGuard2")
{
	$checkexprosql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$id);
	$checkexprores = mysqli_fetch_assoc($checkexprosql);
	$guardbu = $id;
	if($checkexprores['expro'] == 1) //if expro bu, point guard db to expro visayas, id = 24
	{
		$guardbu = 24;
	}
	$guardsdatalist = "";
	$guardsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ". $guardbu ." ORDER BY lname, fname, mname");
	while($guardres2 = mysqli_fetch_assoc($guardsql))
	{
		$guardsdatalist .= "<option value=\"". $guardres2['id'] . "\">".  $guardres2['lname'] .", ". $guardres2['fname'] ."</option>";		
	}
	$resulttable = "<option value=\"0\" selected=\"selected\">All Guards</option>". $guardsdatalist;	 
}
elseif($type == "dropdownLocation")
{
	$locationsdatalist = "";
	$ticketbusql = mysqli_query($conn, "SELECT * FROM ticket WHERE id =". $id);
	$resticket = mysqli_fetch_assoc($ticketbusql);
	$locationsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE bu = ". $resticket['bu'] ." ORDER BY location_code");
	while($locationres = mysqli_fetch_assoc($locationsql))
	{
		$locationdatalist .= "<option value=\"".$locationres['id']."\">".$locationres['location_code']." - ".$locationres['location']."</option>";		
	}
	$resulttable = "<option value=\"\" selected=\"selected\"></option>". $locationdatalist;	 
}
elseif($type == "dropdownLocation2")
{
	$locationsdatalist = "";
	$locationsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE bu = ". $id ." ORDER BY location_code");
	while($locationres = mysqli_fetch_assoc($locationsql))
	{
		$locationdatalist .= "<option value=\"".$locationres['id']."\">".$locationres['location_code']." - ".$locationres['location']."</option>";		
	}
	
		$resulttable = "<option value=\"0\" selected=\"selected\">All Locations</option>". $locationdatalist;
	
}
elseif($type == "secagencylicenses")
{
	$result = mysqli_query($conn, "SELECT * FROM license_mst WHERE agency_id = ".$id) or die(mysqli_error($conn));
	while($row = mysqli_fetch_assoc($result))
	{
		$pdf = "<label style='color:red; cursor:pointer;' onclick='openPDFadd(".$row['id'].", 0);'>Add</label>";
		if($_SESSION['level'] == "Admin")
		{
			$pdf = "<label style='color:red; cursor:pointer;' >None</label>";
		}
		if($row['pdf_file'] != "None")
		{
			$pdf = "<a href='".$row['pdf_file']."' target='_blank' style='color:blue;'>View</a>";
			if($_SESSION['level'] == "Admin")
			{
				$pdf = "<a href='".$row['pdf_file']."' target='_blank' style='color:blue;'>View</a>";
			}
		}
		$resulttable .= "<tr>
							<td align='center'>".$row['license_type']."</td>
							<td align='center'>".$row['license_number']."</td>
							<td align='center'>".$row['issue_date']."</td>
							<td align='center'>".$row['expiry_date']."</td>
							<td align='center'>".$pdf."</td>
							<td ".$delbtn."><img src=\"images/edit2.png\" height=\"20px\" title=\"Update Remarks\" style=\"cursor:pointer;\" onclick=\"openPDFadd(".$row['id'].", 1);\" /><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Remarks\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$row['id']."', 'SecAgencyLicenses');\" /></td>
						</tr>";
	}
}
elseif($type == "risklevels")
{
	
}

elseif($type == "multiplebu")
{
	$multiplebusql = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id = ".$id);
	while($multiplebures = mysqli_fetch_assoc($multiplebusql))
	{
		$bunamesql = mysqli_query($conn,"SELECT * from bu_mst WHERE id = ".$multiplebures['bu_id']);
		$bunameres = mysqli_fetch_assoc($bunamesql);
		
		$resulttable .= "<tr><td align='center'>".$bunameres['bu']."</td><td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Remarks\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$multiplebures['id']."', 'Users');\" /></td></tr>";
	}
}
elseif($type == "incMainClass")
{
	$activityentriesnum = 1;
	$activityentriessql = mysqli_query($conn, "SELECT * FROM incident_main_cat");
	while($activityentriesres = mysqli_fetch_assoc($activityentriessql))
	{
		$iconcolor = ($activityentriesres['status'] == 'Active') ? "green" : "red";		
		$resulttable .= "<tr align=\"center\">" .
							"<td>".$activityentriesnum."</td>" .
							"<td>".$activityentriesres['main_cat']."</td>" .
							"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"openIncidentClassifications('editMain', '".$activityentriesres['id']."');\"></td>" .
							"<td><img src=\"images/activate".$iconcolor.".png\" height=\"20px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$activityentriesres['id']."', 'IncMainClass');\" /></td>".
							// "<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$activityentriesres['id']."', 'ActivityInput');\" /></td>" .
						 "</tr>";
		$activityentriesnum++;
	}
}
elseif($type == "incSubClass")
{
	$activityentriesnum = 1;
	$activityentriessql = mysqli_query($conn, "SELECT * FROM incident_sub_cat");
	while($activityentriesres = mysqli_fetch_assoc($activityentriessql))
	{
		$incidentMainCatSql = mysqli_query($conn, "SELECT * FROM incident_main_cat WHERE id = ".$activityentriesres['main_id']);
		$incidentMainCatRes = mysqli_fetch_assoc($incidentMainCatSql);
		$iconcolor = ($activityentriesres['status'] == 'Active') ? "green" : "red";		
		$resulttable .= "<tr align=\"center\">" .
							"<td>".$activityentriesnum."</td>" .
							"<td>".$incidentMainCatRes['main_cat']."</td>" .
							"<td>".$activityentriesres['sub_cat']."</td>" .
							"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"openIncidentClassifications('editSub', '".$activityentriesres['id']."');\"></td>" .
							"<td><img src=\"images/activate".$iconcolor.".png\" height=\"20px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$activityentriesres['id']."', 'IncSubClass');\" /></td>".
							// "<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$activityentriesres['id']."', 'ActivityInput');\" /></td>" .
						 "</tr>";
		$activityentriesnum++;
	}
}
elseif($type == "incAddMainClass")
{	
	$resulttable = 	"<form id='frmAddIncMainClass' name='frmAddIncMainClass' action='user-superadmin.php' method='post'>" .
					"<table id='tblAddIncMainClass' name='tblAddIncMainClass' align='center' >" .
						"<thead>" .
							"<tr ><th >Add Main Classification</th></tr>" .
						"</thead>" .
						"<tbody>" .
							"<tr><td ><input type='text' name='txtAddMainClass[]' style='text-align:center;' required></td></tr>" .
						"</tbody>" .
						"<tfoot>" .
							"<tr><td align='right'><a style='color:#00F; text-decoration:underline; cursor:pointer;' onclick='addAnotherMainClass();'>Add Another</a></td><td></td></tr>" .
						"</tfoot>" .
					"</table>" .
					"<br>" .
					"<table align='center'>" .
						"<tr>" . 
							"<td><input type='submit' class='redbutton' name='btnSubmitClassification' value='Save' align='center'></td>" . 
							"<td><button class='redbutton' onclick='closeIncidentClassifications();'>Cancel</button></td>" .
						"</tr>" .
					"</table>" .
					"" .
					"</form>";
}
elseif($type == "incEditMainClass")
{
	$incMainSql = mysqli_query($conn, "SELECT * FROM incident_main_cat WHERE id = ".$id);
	$incMainRes = mysqli_fetch_assoc($incMainSql);
	$resulttable = 	"<form id='frmAddIncMainClass' name='frmAddIncMainClass' action='user-superadmin.php' method='post'>" .
					"<table id='tblAddIncMainClass' name='tblAddIncMainClass' align='center' >" .
						"<thead>" .
							"<tr ><th >Edit Main Classification</th></tr>" .
						"</thead>" .
						"<tbody>" .
							"<tr><td ><input type='text' name='txtEditMainClass' style='text-align:center;' required value='".$incMainRes['main_cat']."'><input type='hidden' name='txtEditMainClassId' value='".$id."'></td></tr>" .
						"</tbody>" .
					"</table>" .
					"<br>" .
					"<table align='center'>" .
						"<tr>" . 
							"<td><input type='submit' class='redbutton' name='btnSubmitClassificationEdit' value='Save' align='center'></td>" . 
							"<td><button class='redbutton' onclick='closeIncidentClassifications();'>Cancel</button></td>" .
						"</tr>" .
					"</table>" .
					"" .
					"</form>";
}
elseif($type == "incAddSubClass")
{
	$mainlist = "";
	$mainlistsql = mysqli_query($conn, "SELECT * FROM incident_main_cat");
	while($mainlistres = mysqli_fetch_assoc($mainlistsql))
	{
		$mainlist .= "<option value='".$mainlistres['id']."'>".$mainlistres['main_cat']."</option>";
	}
	$resulttable = 	"<form id='frmAddIncMainClass' name='frmAddIncMainClass' action='user-superadmin.php' method='post'>" .
					"<table id='tblAddIncMainClass' name='tblAddIncMainClass' align='center' >" .
						"<thead>" .
							"<tr ><th colspan='100%' >Add Sub Classification</th></tr>" .
						"</thead>" .
						"<tbody>" .
							"<tr><td align='right'>" .
								"Main:" .
								"</td><td>" .
								"<select id='selAddSubClass' name='selAddSubClass' required>" .
									"<option value=''></option>" .
									$mainlist .
								"</select>" .
							"</td></tr>" .
							"<tr><td align='right'>" .
								"Sub:" .
								"</td><td>" .
								"<input type='text' name='txtAddSubClass' style='text-align:center;' required>" .
							"</td></tr>" .
						"</tbody>" .
					"</table>" .
					"<br>" .
					"<table align='center'>" .
						"<tr>" . 
							"<td><input type='submit' class='redbutton' name='btnSubmitClassificationSub' value='Save' align='center'></td>" . 
							"<td><button class='redbutton' onclick='closeIncidentClassifications();'>Cancel</button></td>" .
						"</tr>" .
					"</table>" .
					"" .
					"</form>";
}
elseif($type == "incEditSubClass")
{
	$mainlist = "";
	$mainlistsql = mysqli_query($conn, "SELECT * FROM incident_main_cat");
	while($mainlistres = mysqli_fetch_assoc($mainlistsql))
	{
		$mainlist .= "<option value='".$mainlistres['id']."'>".$mainlistres['main_cat']."</option>";
	}
	
	$subclasssql = mysqli_query($conn, "SELECT * FROM incident_sub_cat WHERE id = ".$id);
	$subclassres = mysqli_fetch_assoc($subclasssql);
	
	$resulttable = 	"<form id='frmAddIncMainClass' name='frmAddIncMainClass' action='user-superadmin.php' method='post'>" .
					"<table id='tblAddIncMainClass' name='tblAddIncMainClass' align='center' >" .
						"<thead>" .
							"<tr ><th colspan='100%' >Edit Sub Classification</th></tr>" .
						"</thead>" .
						"<tbody>" .
							"<tr><td align='right'>" .
								"Main:" .
								"</td><td>" .
								"<select id='selAddSubClass' name='selAddSubClass' required>" .
									"<option value=''></option>" .
									$mainlist .
								"</select>" .
							"</td></tr>" .
							"<tr><td align='right'>" .
								"Sub:" .
								"</td><td>" .
								"<input type='text' name='txtAddSubClass' style='text-align:center;' required value='".$subclassres['sub_cat']."'><input type='hidden' name='txtEditMainClassId' value='".$id."'></td></tr>" .
							"</td></tr>" .
						"</tbody>" .
					"</table>" .
					"<br>" .
					"<table align='center'>" .
						"<tr>" . 
							"<td><input type='submit' class='redbutton' name='btnSubmitClassificationSubEdit' value='Save' align='center'></td>" . 
							"<td><button class='redbutton' onclick='closeIncidentClassifications();'>Cancel</button></td>" .
						"</tr>" .
					"</table>" .
					"" .
					"</form>";
}
elseif($type == "addLocator")
{	
	$resulttable = 	"<form id='frmAddLocator' name='frmAddLocator' action='user-admin.php' method='post'>" .
					"<table id='tblAddLocator' name='tblAddLocator' align='center' >" .
						"<thead>" .
							"<tr ><th >Add Locator</th></tr>" .
						"</thead>" .
						"<tbody>" .
							"<tr><td ><input type='text' name='txtAddLocators[]' style='text-align:center;' required></td></tr>" .
						"</tbody>" .
						"<tfoot>" .
							"<tr><td align='right'><a style='color:#00F; text-decoration:underline; cursor:pointer;' onclick='addAnotherLocator();'>Add Another</a></td><td></td></tr>" .
						"</tfoot>" .
					"</table>" .
					"<br>" .
					"<table align='center'>" .
						"<tr>" . 
							"<td><input type='submit' class='redbutton' name='btnSubmitLocator' value='Save' align='center'></td>" . 
							"<td><button class='redbutton' onclick='closeAddLocator();'>Cancel</button></td>" .
						"</tr>" .
					"</table>" .
					"" .
					"</form>";
}
elseif($type == "addIncident")
{
	$mainlist = "";
	$mainclasssql = mysqli_query($conn,"SELECT * FROM incident_main_cat WHERE status = 'Active'");
	while($mainclassres = mysqli_fetch_assoc($mainclasssql))
	{
		$mainlist .= "<option value='".$mainclassres['id']."'>".$mainclassres['main_cat']."</option>"; 
	}
	$name = "";
	$main_cat = "";
	$sub_cat = "";
	$defaultlevel = "";
	$injury_minor = "";
	$injury_serious = "";
	$propertydmg_nc = "";
	$propertydmg_crit = "";
	$propertyloss_nc = "";
	$propertyloss_crit = "";
	$workstoppage = "";
	$death_1 = "";
	$death_2 = "";
	$death_3 = "";
	$main_cat_text = "";
	
	if($id2)
	{
		$editincidentsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$id2);
		$editincidentres = mysqli_fetch_assoc($editincidentsql);
		$name = $editincidentres["name"];
		$main_cat = $editincidentres["main_cat"];
		$sub_cat = $editincidentres["sub_cat"];
		$defaultlevel = $editincidentres["defaultlevel"];
		$injury_minor = $editincidentres["injury_minor"];
		$injury_serious = $editincidentres["injury_serious"];
		$propertydmg_nc = $editincidentres["propertydmg_nc"];
		$propertydmg_crit = $editincidentres["propertydmg_crit"];
		$propertyloss_nc = $editincidentres["propertyloss_nc"];
		$propertyloss_crit = $editincidentres["propertyloss_crit"];
		$workstoppage = $editincidentres["workstoppage"];
		$death_1 = $editincidentres["death_1"];
		$death_2 = $editincidentres["death_2"];
		$death_3 = $editincidentres["death_3"];
		$maincatnamesql = mysqli_query($conn, "SELECT * FROM incident_main_cat WHERE id = ".$main_cat);
		$maincatnameres = mysqli_fetch_assoc($maincatnamesql);
		$main_cat_text = $maincatnameres["main_cat"];
		$subcatnamesql = mysqli_query($conn, "SELECT * FROM incident_sub_cat WHERE id = ".$sub_cat);
		$subcatnameres = mysqli_fetch_assoc($subcatnamesql);
		$sub_cat_text = $subcatnameres["sub_cat"];
	}
	
	$token = rand();
	$resulttable2 =	"<tr>" .
						"<td>" .
							"<table border='1' style='border-collapse:collapse;'>" .
								"<thead>" .
								"<tr>" .
									"<td class='whiteonblack' colspan='2' align='center'>Incident</td>" .
									"<td class='whiteonblack' colspan='100%' align='center'>Severity Factors</td>" .
								"</tr>" .
								"<tr>" .
									"<td align='center'>Main Classification</td>" .
									"<td align='center'><select id='selAddMainClassId".$token."' name='selAddMainClassId[]' onchange='changeSub(".$token.");' required><option value='".$main_cat."'>".$main_cat_text."</option>".$mainlist."</select></td>" .												
									"<td align='center'>Minor Injury</td>" .
									"<td align='center'><input name='txtsvinjuryminor[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$injury_minor."' required></td>" .
									"<td align='center'>Property Damage Non-Critical</td>" .
									"<td align='center'><input name='txtsvpropdmgnc[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$propertydmg_nc."' required></td>" .
									"<td align='center'>Work Stoppage</td>" .
									"<td align='center'><input name='txtsvworkstop[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$workstoppage."' required></td>" .								
								"</tr>" .
								"<tr>" .
									"<td align='center'>Sub Classification</td>" .
									"<td align='center'><select id='selAddSubClassId".$token."' name='selAddSubClassId[]' required><option value='".$sub_cat."'>".$sub_cat_text."</option></select></td>" .												
									"<td align='center'>Serious Injury</td>" .
									"<td align='center'><input name='txtsvinjuryserious[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$injury_serious."' required></td>" .
									"<td align='center'>Property Damage Critical</td>" .
									"<td align='center'><input name='txtsvpropdmgcrit[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$propertydmg_crit."' required></td>" .
									"<td align='center'>Death 1</td>" .
									"<td align='center'><input  name='txtsvdeath1[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$death_1."' required></td>" .
								"</tr>" .
								"<tr>" .
									"<td align='center'>Incident Name" .
									"<td align='center'><input type='text' name='txtAddEntries[]' value='".$name."' style='text-align:center;' required /></td>" .
									"<td></td>" .
									"<td></td>" .
									"<td align='center'>Property Loss Non-Critical</td>" .
									"<td align='center'><input  name='txtsvproplossnc[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$propertyloss_nc."' required></td>" .
									"<td align='center'>Death 2</td>" .
									"<td align='center'><input  name='txtsvdeath2[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$death_2."' required></td>" .
								"</tr>" .
								"<tr>" .
									"<td align='center'>Default Level</td>" .												
									"<td align='center'><input type='number'  name='txtsvdefault[]' min='1' max='5' style='text-align:center;' value='".$defaultlevel."' required/></td>" .
									"<td></td>" .
									"<td></td>" .
									"<td align='center'>Property Loss Critical</td>" .
									"<td align='center'><input name='txtsvproplosscrit[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$propertyloss_crit."' required></td>" .
									"<td align='center'>Death 3</td>" .
									"<td align='center'><input name='txtsvdeath3[]' type='number' min='1' max='5' align='center' style='text-align:center;' value='".$death_3."' required></td>" .
								"</tr>" .
								"</thead>" .
							"</table>" .
						"</td>";
					"</tr>";
	if($id == 0)
	{
		if($id2)
		{
			$resulttable =	"<form id='frmAddIncident' name='frmAddIncident' action='user-superadmin.php' method='post'>" .
								"<table id='tblAddIncident' name='tblAddIncident' align='center'>" .
									"<tbody>" .
										
											$resulttable2 .
										
									"</tbody>" .
									"<tfoot>" .
										"<tr><td><input type='hidden' name='hdnIncidentId' value='".$id2."' /></td></tr>" .
										"<tr><td align='center'><input type='submit' name='btnSaveEditIncident' class='redbutton' value='Save'><button class='redbutton' onclick='closeInputEntries2();'>Cancel</button></td></tr>" .
									"</tfoot>" .
								"</table>" .
							"</form>";
		}
		else
		{
			$resulttable =	"<form id='frmAddIncident' name='frmAddIncident' action='user-superadmin.php' method='post'>" .
								"<table id='tblAddIncident' name='tblAddIncident' align='center'>" .
									"<tbody>" .
										
											$resulttable2 .
										
									"</tbody>" .
									"<tfoot>" .
										"<tr><td align='right'><a style='color:#00F; text-decoration:underline; cursor:pointer;' onclick='addInputEntriesRow2();'>Add Another</a></td></tr>" .
										"<tr><td align='center'><input type='submit' name='btnSaveNewIncident' class='redbutton' value='Save'><button class='redbutton' onclick='closeInputEntries2();'>Cancel</button></td></tr>" .
									"</tfoot>" .
								"</table>" .
							"</form>";
		}
		
	}
	elseif($id == 1)
	{
		$resulttable = $resulttable2;
	}
					
}
elseif($type == "getLocators")
{
	$mainlocatornumber = 1;
	$mainlocatorlistsql = mysqli_query($conn, "SELECT * FROM bu_locators WHERE bu_id = ".$bu." ORDER BY locator_name");
	while($mainlocatorlistres = mysqli_fetch_assoc($mainlocatorlistsql))
	{
		$iconcolor = ($mainlocatorlistres['status'] == 'Active') ? "green" : "red";	
		$resulttable .=	"<tr align='center'>" .
							"<td>".$mainlocatornumber."</td>" .
							"<td>".$mainlocatorlistres['locator_name']."</td>" .
							"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"openIncidentClassifications('editLocator', '".$mainlocatorlistres['id']."');\"></td>" .
							"<td><img src=\"images/activate".$iconcolor.".png\" height=\"20px\" title=\"Activate/Deactivate\" style=\"cursor:pointer;\" onclick=\"deleteItem2('".$mainlocatorlistres['id']."', 'Locators');\" /></td>".
						"</tr>";
		$mainlocatornumber++;
	}
}
elseif($type == "changeSub")
{
	$resulttable = "";
	$sublistsql = mysqli_query($conn, "SELECT * FROM incident_sub_cat WHERE main_id = ".$id." AND status = 'Active'");
	while($sublistres = mysqli_fetch_assoc($sublistsql))
	{
		$resulttable .= "<option value='".$sublistres['id']."'>".$sublistres['sub_cat']."</option>";
	}
	
	$mainlistsql = mysqli_query($conn, "SELECT * FROM incident_main_cat WHERE id = ".$id);
	$mainlistres = mysqli_fetch_assoc($mainlistsql);
	if($resulttable == "")
	{
		$resulttable = "<option value='0'>".$mainlistres['main_cat']."</option>";
	}
}
elseif($type == "changeSub2")
{
	$resulttable = "<option value='0'>All Types</option>";
	$sublistsql = mysqli_query($conn, "SELECT * FROM incident_sub_cat WHERE main_id = ".$id." AND status = 'Active'");
	while($sublistres = mysqli_fetch_assoc($sublistsql))
	{
		$resulttable .= "<option value='".$sublistres['id']."'>".$sublistres['sub_cat']."</option>";
	}
}
elseif($type == "viewAuditDetails")
{
	$auditdetailssql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE id = ".$id);
	$auditdetailsres = mysqli_fetch_assoc($auditdetailssql);
	
	$auditdetails = "";
	if($id2 == 0)
	{
		$auditdetails = "Recommendations:<br>".$auditdetailsres['recommendations'];
	}
	elseif($id2 == 1)
	{
	//	$auditfindings = "<label style='color:blue; cursor:pointer; text-decoration:underline;' onclick='openViewAuditFinding(".$auditdetailsres['id'].");'>View</label> / <label style='color:red; cursor:pointer; text-decoration:underline;' onclick='openAuditEvidenceadd(".$auditdetailsres['id'].", 0);'>Add</label>";
		
		$auditdetails = "<table align='center' width='100%' border='1' style='border-collapse:collapse;'>" .
							"<tr>" .
								"<th>Potential Risk / Impact:</th>" .
								"<td>".$auditdetailsres['risk_impact']."</td>" .
							"</tr>" .
							"<tr>" .
								"<th width='30%'>Recommendations:</th>" .
								"<td>".$auditdetailsres['recommendations']."</td>" .
							"</tr>" .
							
						"</table>";
						//"<fieldset width='100%'>".
						//	"<legend>Potential Risk Impact:</legend>". 
						//"<br>".$auditdetailsres['recommendations']."</fieldset>" .
						//"<fieldset width='100%'>".
						//	"<legend>Potential Risk Impact:</legend>". 
						//"<br>".$auditdetailsres['risk_impact']."</fieldset>";
	}
	elseif($id2 == 2)
	{
		/* if($auditdetailsres['evidence'])
		{
			$auditevidence = "<a href='".$auditdetailsres['evidence']."' target='_blank' style='color:blue;'>View</a> / <label style='color:green; cursor:pointer; text-decoration:underline;' onclick='openAuditEvidenceadd(".$auditdetailsres['id'].", 1);'>Update</label>";
		}
		else
		{
			$auditevidence = "<label style='color:red; cursor:pointer; text-decoration:underline;' onclick='openAuditEvidenceadd(".$auditdetailsres['id'].", 0);'>Add</label>";
		} */
		
		$auditevidence = "<label style='color:blue; cursor:pointer; text-decoration:underline;' onclick='openViewAuditEvidence(".$auditdetailsres['id'].");'>View</label> / <label style='color:red; cursor:pointer; text-decoration:underline;' onclick='openAuditEvidenceadd(".$auditdetailsres['id'].", 0);'>Add</label>";
		
		if($auditdetailsres['disposition'])
		{
			$auditdisposition =	"<label style='color:green; cursor:pointer; text-decoration:underline;' onclick='submitAuditDisposition()';>Update</label>" .
								"<input type='hidden' id='txtDispositionType' name='txtDispositionType' value='Edit'>";
		}
		else
		{
			$auditdisposition =	"<label style='color:red; cursor:pointer; text-decoration:underline;' onclick='submitAuditDisposition()';>Save</label>" .
								"<input type='hidden' id='txtDispositionType' name='txtDispositionType' value='Add'>";
		}
		
		$auditdetails = "<table align='center' width='100%' border='1' style='border-collapse:collapse;'>" .
							"<tr>" .
								"<th>Disposition:</th>" .
								"<td style='padding-bottom:10px;' align='center'>" .
									"<form id='frmAuditDisposition' name='frmAuditDisposition' action='user-superadmin.php' method='post'>" .
										"<textarea style='resize:none; width:100%; height:100px;' id='txtAuditAddDisposition' name='txtAuditAddDisposition' required>".$auditdetailsres['disposition']."</textarea></br>" .
										//"<input align='center' class='redbutton' type='submit' id='btnAuditDispositon' name='btnAuditDispositon' value='Update'>" .
										$auditdisposition .
										"<input id='auditDispositionID' name='auditDispositionID' type='hidden' value='".$auditdetailsres['id']."'>" .
									"</form>" .
								"</td>" .
							"</tr>" .
							"<tr>" .
								"<th width='30%'>Evidence of Completion:</th>" .
								"<td align='center'>".$auditevidence."</td>" .
							"</tr>" .							
						"</table>";
	}
		
	$resulttable =	"<table class='auditspace' align='center' width='100%'>" .
						"<tr><td>".$auditdetails."</td></tr>" .
						"<tr><td align='center'><button class='redbutton' id='btnCloseAuditDetails' name='btnCloseAuditDetails' onclick='closeAuditDetails();'>Close</button></td></tr>" .
					"</table>";
}
elseif($type == "addAgencyDefault")
{
	$resulttable =	'<form id="addPDFform" name="addPDFform" method="post" action="user-superadmin.php" enctype="multipart/form-data">
						<table align="center">
							<tr><th>Add PDF FIle</th></tr>
							<tr>
								<td>						
									<input type="file" name="licenseattach1[]">
									<input type="hidden" id="addpdfid" name="addpdfid" value="'.$id.'">
									<input type="hidden" id="addpdftype" name="addpdftype" value="'.$id2.'">
								</td>
							</tr>
							<tr align="center">
								<td>
									<input type="submit" id="btnAddPDFlicense" name="btnAddPDFlicense" class="redbutton" value="Submit">
									<input type="button" id="btnCloseAddPDFlicense" name="btnCloseAddPDFlicense" class="redbutton" onclick="closePDFadd();" value="Close">
									
								</td>
							</tr>
						</table>
					</form>';
}
elseif($type == "addAgencyBU")
{
	$agencyClientQuery = mysqli_query($conn, "SELECT * FROM agency_bu WHERE id = " .$id);
	$agencyCLientResult = mysqli_fetch_assoc($agencyClientQuery);
	
	$resulttable =	'<form id="addPDFform" name="addPDFform" method="post" action="user-superadmin.php" enctype="multipart/form-data">
						<table align="center">							
							<tr>
								<td>Start:</td><td><input type="date" id="addAgencyClientStartDate" name="addAgencyClientStartDate" value="'.$agencyCLientResult["start"].'"></td>
							</tr>
							<tr>
								<td>End:</td><td><input type="date" id="addAgencyClientEndDate" name="addAgencyClientEndDate" value="'.$agencyCLientResult["end"].'"></td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="file" name="licenseattach1[]">
									<input type="hidden" id="addpdfid" name="addpdfid" value="'.$id.'">
									<input type="hidden" id="addpdftype" name="addpdftype" value="'.$id2.'">
								</td>
							</tr>
							<tr align="center">
								<td colspan="2">
									<input type="submit" id="btnAddPDFlicense" name="btnAddPDFlicense" class="redbutton" value="Submit">
									<input type="button" id="btnCloseAddPDFlicense" name="btnCloseAddPDFlicense" class="redbutton" onclick="closePDFadd();" value="Close">
								</td>
							</tr>
						</table>
					</form>';
}
elseif($type == "addAgencyLicense")
{
	$agencyClientQuery = mysqli_query($conn, "SELECT * FROM license_mst WHERE id = " .$id);
	$agencyCLientResult = mysqli_fetch_assoc($agencyClientQuery);
	
	$resulttable =	'<form id="addPDFform" name="addPDFform" method="post" action="user-superadmin.php" enctype="multipart/form-data">
						<table align="center">
							
							<tr>
								<td>License Number:</td><td><input type="text" id="addAgencyLicenseNumber" name="addAgencyLicenseNumber" value="'.$agencyCLientResult["license_number"].'"></td>
							</tr>
							<tr>
								<td>Issue Date:</td><td><input type="date" id="addAgencyLicenseStartDate" name="addAgencyLicenseStartDate" value="'.$agencyCLientResult["issue_date"].'"></td>
							</tr>
							<tr>
								<td>Expiry Date:</td><td><input type="date" id="addAgencyClientLicenseate" name="addAgencyClientEndDate" value="'.$agencyCLientResult["expiry_date"].'"></td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="file" name="licenseattach1[]">
									<input type="hidden" id="addpdfid" name="addpdfid" value="'.$id.'">
									<input type="hidden" id="addpdftype" name="addpdftype" value="'.$id2.'">
								</td>
							</tr>
							<tr align="center">
								<td colspan="2">
									<input type="submit" id="btnAddPDFlicense" name="btnAddPDFlicense" class="redbutton" value="Submit">
									<input type="button" id="btnCloseAddPDFlicense" name="btnCloseAddPDFlicense" class="redbutton" onclick="closePDFadd();" value="Close">
								</td>
							</tr>
						</table>
					</form>';
}

elseif($type == "viewAuditDisposition")
{
	
}
elseif($type == "newTicketFilters")
{
	
} elseif ($type == "nominatedsecagency") {
	$biddingnum = 1;
	$result = mysqli_query($conn, "SELECT * FROM bidding_agency INNER JOIN agency_mst ON bidding_agency.agency_id = agency_mst.id WHERE bidding_agency.bidding_id = " . $id) or die(mysqli_error($conn));
	while ($row = mysqli_fetch_assoc($result)) {
		$resulttable .= "<tr>
							<td align='center'>" . $biddingnum . "</td>
							<td align='center'>" . $row['agency_name'] . "</td>
							<td align='center'>" . $row['address'] . "</td>
							<td align='center'>" . $row['oic'] . "</td>
							<td align='center'>" . $row['email'] . "</td>
							<td align='center'>" . $row['contact_number'] . "</td>
						</tr>";
		$biddingnum++;
	}
}

elseif ($type == "evaluatenominatedsecagency") {
	$biddingnum = 1;
	$result = mysqli_query($conn, "SELECT * FROM bidding_agency INNER JOIN agency_mst ON bidding_agency.agency_id = agency_mst.id WHERE bidding_agency.bidding_id = " . $id) or die(mysqli_error($conn));
	while ($row = mysqli_fetch_assoc($result)) {
		$resulttable .= "<tr>
							<td align='center'>" . $biddingnum . "</td>
							<td align='center'>" . $row['agency_name'] . "</td>
							<td align='center'>" . $row['address'] . "</td>
							<td align='center'>" . $row['oic'] . "</td>
							<td align='center'>" . $row['email'] . "</td>
							<td align='center'>" . $row['contact_number'] . "</td>
							<td  align='center'><img src=\"images/delete.png\" height=\"20px\" style=\"cursor:pointer;\" onclick=\"deleteItem(" . $row['bid_agency_id'] . ",'Add Nominated Agency');\" /></td>
						</tr>";
		$biddingnum++;
	}
}

elseif ($type == "nominatedpoolsecagency") {
	$biddingnum = 1;
	$result = mysqli_query($conn, "SELECT bidding_agency.id as bid_agency_id, bidding_agency.*, agency_mst.* FROM bidding_agency INNER JOIN agency_mst ON bidding_agency.agency_id = agency_mst.id WHERE bidding_agency.bidding_id = " . $id) or die(mysqli_error($conn));
	while ($row = mysqli_fetch_assoc($result)) {
		$resulttable .= "<tr>
							<input type='hidden' id='txtbiddingid' name='txtbiddingid'  value=" . $row['bidding_id'] . " /> 
							<td align='center'>" . $biddingnum . "</td>
							<td align='center'>" . $row['agency_name'] . "</td>
							<td align='center'>" . $row['address'] . "</td>
							<td align='center'>" . $row['oic'] . "</td>
							<td align='center'>" . $row['email'] . "</td>
							<td align='center'>" . $row['contact_number'] . "</td>
							<td  align='center'><img src=\"images/delete.png\" height=\"20px\" style=\"cursor:pointer;\" onclick=\"deleteItem(" . $row['bid_agency_id'] . ",'Add Nominated Agency');\" /></td>
						</tr>";
		$biddingnum++;
	}
} 
elseif ($type == "poolAgencyListTable") {
	$result = mysqli_query($conn, "SELECT * FROM agency_mst WHERE id NOT IN (SELECT agency_mst.id FROM agency_mst INNER JOIN bidding_agency ON agency_mst.id = bidding_agency.agency_id WHERE bidding_agency.bidding_id = '" . $id . "')") or die(mysqli_error($conn));
	while ($poolSecAgency = mysqli_fetch_assoc($result)) {
		$resulttable .= "<tr align=\"center\" class=\"table-row--red\">" .
		"<input type='hidden' id='txtbiddingid' name='txtbiddingid'  value=" . $id . " /> " .
		"<td>" . $poolSecAgency['agency_name'] . "</td>" .
		"<td>" . $poolSecAgency['address'] . "</td>" .
		"<td>" . $poolSecAgency['oic'] . "</td>" .
		"<td>" . $poolSecAgency['email'] . "</td>" .
		"<td>" . $poolSecAgency['contact_number'] . "</td>" .
			"<td><input type=\"checkbox\" id=\"poolAgencyID[]\" name=\"poolAgencyID[]\" value=" . $poolSecAgency['id'] . "></td>" .
		"</tr>";
	}
}







if(empty($resulttable) && ($_SESSION['level']=="Admin")){
	echo "<tr><td colspan=\"100%\" align=\"center\">No Records</td></tr>";
	
}
else{
	echo $resulttable;
}
?>
