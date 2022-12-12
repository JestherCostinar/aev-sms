<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$idpbusql = mysqli_query($conn,"SELECT * FROM bu_mst WHERE id = ".$bu);
$idpbures = mysqli_fetch_assoc($idpbusql);

$idpgroup = $idpbures['main_group'];

$idpyear = 0;
$idpyear = $_GET['idpyear'];

$addtoken = 0;
$addtoken = $_GET['addtoken'];
$edittoken = 0;
$edittoken = $_GET['edittoken'];

$addtoken2 = 0;
$addtoken2 = $_GET['addtoken2'];
$edittoken2 = 0;
$edittoken2 = $_GET['edittoken2'];

$idpuserlist = "";
$idpusercounter = 0;
$idpmainlist = "";

$entryid = 0;
$entryid = $_GET['entryid'];


//$idpusersql = mysqli_query($conn,"SELECT * FROM idp_users WHERE group_id = ".$idpgroup." ORDER BY name")or die(mysqli_error($conn));
//$idpusersql = mysqli_query($conn,"SELECT DISTINCT lname, fname FROM users_mst WHERE bu IN (SELECT id FROM bu_mst WHERE main_group = ".$idpgroup.") AND (level = 'Admin' OR level = 'Custom Admin')")or die(mysqli_error($conn));
//$idpusersql = mysqli_query($conn,"SELECT * FROM users_mst WHERE bu IN (SELECT id FROM bu_mst WHERE main_group = ".$idpgroup.") AND (level = 'Admin' OR level = 'Custom Admin')")or die(mysqli_error($conn));
$idpgroupchecksql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$id);
$idpgroupcheckres = mysqli_fetch_assoc($idpgroupchecksql);

/* if($idpgroupcheckres['main_group'] == 12)
{
	$idpusersql = mysqli_query($conn,"SELECT DISTINCT lname, fname FROM users_mst WHERE bu = ".$bu." AND (level = 'Admin' OR level = 'Custom Admin') AND (status = 'Active')")or die(mysqli_error($conn));
}
else
{
	$idpusersql = mysqli_query($conn,"SELECT DISTINCT lname, fname FROM users_mst WHERE bu IN (SELECT id FROM bu_mst WHERE main_group = ".$idpgroup.") AND (level = 'Admin' OR level = 'Custom Admin') AND (status = 'Active')")or die(mysqli_error($conn));
} */
$idpusersql = mysqli_query($conn,"SELECT DISTINCT lname, fname FROM users_mst WHERE bu IN (SELECT id FROM bu_mst WHERE main_group = ".$idpgroup.") AND (level = 'Admin' OR level = 'Custom Admin') AND (status = 'Active')")or die(mysqli_error($conn));

while($idpuserres = mysqli_fetch_assoc($idpusersql))
{
	$idpusercounter++;
	$idpuserlist .=	"<tr>" .
						"<td>".$idpusercounter."</td>" .
						"<td>".$idpuserres['lname'].", ".$idpuserres['fname']."</td>" .
						//"<td><a style='color:blue;' onclick='openAddIDPUserModalEdit(".$idpuserres['id'].");'>Edit</a> <a style='color:red;'>X</a></td>" .
					"</tr>";
	/* if($idpyear > 0)
	{
		
		$idpmainsql = mysqli_query($conn,"SELECT * FROM idp_mst WHERE user_id = ".$iduserres['id']." ORDER BY id");
		while($idpmainres = mysqli_fetch_assoc($idpmainsql))
		{
			$idpmainlist .=	"<tr>" .
								"<td>" . $idpmainres['name'] ."</td>" .
								"<td>" . $idpmainres['description'] ."</td>" .
								"<td>" . $idpmainres['status'] ."</td>" .
								"<td><a style='color:blue;' onclick='openIDPModalEdit(".$idpmainres['id'].");'>Edit</a> <a style='color:red;'>X</a></td>" .
							"</tr>";
		}
	} */
	$idpdropdown .= "<option value='".$idpuserres['fname']." ".$idpuserres['lname']."'>".$idpuserres['fname']." ".$idpuserres['lname']."</option>";
	
	
}

if($idpyear > 0)
{
	
	//$idpmainsql = mysqli_query($conn,"SELECT * FROM idp_mst WHERE year = ".$idpyear." AND group_id = ".$idpgroup." ORDER BY user_id");
	/* if($idpgroup == 12)
	{
		$idpmainsql = mysqli_query($conn,"SELECT * FROM idp_mst WHERE year = ".$idpyear." AND group_id = ".$idpgroup);
	} */
	
	//$idpmainsql = mysqli_query($conn,"SELECT * FROM idp_mst WHERE year = ".$idpyear." AND group_id = ".$idpgroup);
	$idpmainsql = mysqli_query($conn,"SELECT * FROM idp_mst_new WHERE year = ".$idpyear." AND bu_id = ".$bu);
	while($idpmainres = mysqli_fetch_assoc($idpmainsql))
	{
		/* $idpfetchnamesql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$idpmainres['user_id']);
		$idpfetchnameres = mysqli_fetch_assoc($idpfetchnamesql); */
		
		$datedisplay = date('Y-m-d H:i',strtotime('+8 hours',strtotime($idpmainres['date_saved'])));
		
		$idpmainlist .=	"<tr>" .
							
							"<td align='center' valign='top'>" . $idpmainres['name'] ."</td>" .
							"<td align='center' valign='top'>" . $idpmainres['score'] ."</td>" .
							"<td align='center' valign='top'>" . $idpmainres['score_description'] ."</td>" .
							"<td align='center' valign='top'><a href='" . $idpmainres['score_link'] ."'>Link</a></td>" .
							"<td align='center' valign='top'>" . $datedisplay ."</td>" .
							"<td align='center' valign='top'>" .
								//"<a style='color:blue; cursor:pointer;' onclick='openIDPModalEdit(".$idpmainres['id'].");'>Edit</a>" .
								"<img src='images/edit2.png' style='cursor:pointer; height:20px' onclick='openIDPModalEdit(".$idpmainres['id'].");'>" .
							"</td>" .
							"<td align='center' valign='top'>" .
								"<img src='images/delete.png' style='cursor:pointer; height:20px' onclick=\"deleteItem(".$idpmainres['id'].", 'IDP');\">" .
								//"<a style='color:red;'>X</a>" .
							"</td>" .
						"</tr>";
	}
	$idpmainlistfull =	"<tr>" .
							"<th class='whiteonblack'>Name</th>" .
							"<th class='whiteonblack'>Score</th>" .
							"<th class='whiteonblack' width='50%'>Summary</th>" .
							"<th class='whiteonblack'>Source File</th>" .
							"<th class='whiteonblack'>Updated On</th>" .
							"<th class='whiteonblack' colspan='2'>Controls</th>" .
						"</tr>" . $idpmainlist;
}


if(($addtoken > 0) or ($edittoken > 0))
{
//	$idpdropdown = "<option value=0>None</option>";
	/* $idpuserdropdownsql = mysqli_query($conn,"SELECT * FROM idp_users WHERE group_id = ".$idpgroup." ORDER BY id");
	while($idpuserdropdownres = mysqli_fetch_assoc($idpuserdropdownsql))
	{
		$idpdropdown .= "<option value='".$idpuserdropdownres['id']."'>".$idpuserdropdownres['name']."</option>";
	} */
	
	/* $fetchgroupsql = mysqli_query($conn, "SELECT * FROM users_mst WHERE bu IN (SELECT id FROM bu_mst WHERE main_group = ".$idpgroup.") AND (level = 'Admin' OR level = 'Custom Admin')");
	while($fetchgroupres = mysqli_fetch_assoc($fetchgroupsql))
	{
		$idpdropdown .= "<option value='".$fetchgroupres['id']."'>".$fetchgroupres['fname']." ".$fetchgroupres['mi']." ".$fetchgroupres['lname']."</option>";
	} */
	
	/* $fetchgroupsql = mysqli_query($conn, "SELECT DISTINCT lname, fname FROM users_mst WHERE bu IN (SELECT id FROM bu_mst WHERE main_group = ".$idpgroup.") AND (level = 'Admin' OR level = 'Custom Admin') AND (status = 'Active')");
	while($fetchgroupres = mysqli_fetch_assoc($fetchgroupsql))
	{
		$idpdropdown .= "<option value='".$fetchgroupres['fname']." ".$fetchgroupres['lname']."'>".$fetchgroupres['fname']." ".$fetchgroupres['lname']."</option>";
	} */
	
	/* if($addtoken > 0)
	{
		$tokentype = "Add";
		$resulttable =	"<form id='frmaddIDP' name='frmaddIDP' method='post' action='main-post.php' enctype='multipart/form-data'>" .
					"<table width='95%'>" .
						"<tr>" .
							"<th colspan='100%'>Add IDP</th>" .							
						"</tr>" .
						"<tr>" .
							"<td>Year:</td>" .
							"<td>".$idpyear."</td>" .
						"</tr>" .
						"<tr>" .
							"<td>Name:</td>" .
							"<td>" .
								"<select id='selIDPUser' name='selIDPUser'>" .
									$idpdropdown .
								"</select>" .
							"</td>" .
						"</tr>" .
						"<tr>" .
							"<td>IDP:</td>" .
							"<td><textarea style='width:500px; height:70px;' id='txtIDPDesc' name='txtIDPDesc'></textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td>Status:</td>" .
							"<td>" .
								"<select id='selIDPStatus' name='selIDPStatus'>" .
									"<option value='Planned'>Planned</option>" .
									"<option value='Ongoing'>Ongoing</option>" .
									"<option value='Done'>Done</option>" .
								"</select>" .
								
							"</td>" .							
						"</tr>" .
						"<tr>" .
							"<td>Close Date:</td>" .
							"<td>" .
								"<input type='date' name='idpclosedate' id='idpclosedate'>".
							"</td>".
						"</tr>" .
						"<tr>" .
							"<td colspan='100%' align='center'>" .
								"<input type='submit' class='redbutton' id='btnSaveIDP' name='btnSaveIDP'> <a style='color:blue;' onclick='closeIDPModal();'>Close</a>" .
								"<input type='hidden' id='txtIDPYear' name='txtIDPYear' value='". $idpyear ."'>" .
								"<input type='hidden' id='txtIDPGroup' name='txtIDPGroup' value='". $idpgroup ."'>" .
								"<input type='hidden' id='txtTokenType' name='txtTokenType' value='". $tokentype ."'>" .
								"<input type='hidden' id='txtEntryID' name='txtEntryID' value='". $entryid ."'>" .
							"</td>" .
						"</tr>" .
					"</table>" .
					"</form>";
	} */
	if($addtoken > 0)
	{
		$tokentype = "Add";
		$resulttable =	"<form id='frmaddIDP' name='frmaddIDP' method='post' action='main-post.php' enctype='multipart/form-data'>" .
					"<table width='95%'>" .
						"<tr>" .
							"<th colspan='100%'>Add IDP Summary</th>" .							
						"</tr>" .
						"<tr>" .
							"<td>Year:</td>" .
							"<td>".$idpyear."</td>" .
						"</tr>" .
						"<tr>" .
							"<td>Name:</td>" .
							"<td>" .
								"<select id='selIDPUser' name='selIDPUser'>" .
									$idpdropdown .
								"</select>" .
							"</td>" .
						"</tr>" .
						"<tr>" .
							"<td>Score:</td>" .								
							"<td><input id='txtIDPScore' name='txtIDPScore' type='number' min='0' step='.01' /></td>" .
						"</tr>" .
						"<tr>" .
							"<td>IDPs Completion Summary:</td>" .
							"<td><textarea style='width:500px; height:70px;' id='txtIDPDesc' name='txtIDPDesc'></textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td>IDP Source File:</td>" .
							"<td><input id='txtIDPLink' name='txtIDPLink' type='text' style='width:250px' /></td>" .											
						"</tr>" .
						/* "<tr>" .
							"<td>Status:</td>" .
							"<td>" .
								"<select id='selIDPStatus' name='selIDPStatus'>" .
									"<option value='Planned'>Planned</option>" .
									"<option value='Ongoing'>Ongoing</option>" .
									"<option value='Done'>Done</option>" .
								"</select>" .
								
							"</td>" .							
						"</tr>" .
						"<tr>" .
							"<td>Close Date:</td>" .
							"<td>" .
								"<input type='date' name='idpclosedate' id='idpclosedate'>".
							"</td>".
						"</tr>" . */
						"<tr>" .
							"<td colspan='100%' align='center'>" .
								"<input type='submit' class='redbutton' id='btnSaveIDP' name='btnSaveIDP'> <a style='color:blue;' onclick='closeIDPModal();'>Close</a>" .
								"<input type='hidden' id='txtIDPYear' name='txtIDPYear' value='". $idpyear ."'>" .
								"<input type='hidden' id='txtIDPGroup' name='txtIDPGroup' value='". $idpgroup ."'>" .
								"<input type='hidden' id='txtTokenType' name='txtTokenType' value='". $tokentype ."'>" .
								"<input type='hidden' id='txtEntryID' name='txtEntryID' value='". $entryid ."'>" .
							"</td>" .
						"</tr>" .
					"</table>" .
					"</form>";
	}
	elseif($edittoken > 0)
	{
		$idpfetchforeditsql = mysqli_query($conn, "SELECT * FROM idp_mst WHERE id = ".$entryid);
		$idpfetchforeditres = mysqli_fetch_assoc($idpfetchforeditsql);
		
		/* $idpfetchnamesql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$idpfetchforeditres['user_id']);
		$idpfetchnameres = mysqli_fetch_assoc($idpfetchnamesql); */
		
		$tokentype = "Edit";
		$resulttable =	"<form id='frmaddIDP' name='frmaddIDP' method='post' action='main-post.php' enctype='multipart/form-data'>" .
					"<table width='95%'>" .
						"<tr>" .
							"<th colspan='100%'>Edit IDP</th>" .
						"</tr>" .
						"<tr>" .
							"<td>Name:</td>" .
							"<td>" .								
								"<select id='selIDPUser' name='selIDPUser'>" .
									"<option value='".$idpfetchforeditres['name']."'>".$idpfetchforeditres['name']."</option>" .
									$idpdropdown .
								"</select>" .
							"</td>" .
						"</tr>" .
						"<tr>" .
							"<td>Score:</td>" .								
							"<td><input id='txtIDPScore' name='txtIDPScore' type='number' min='0' step='.01' value='".$idpfetchforeditres['score']."' /></td>" .
						"</tr>" .
						"<tr>" .
							"<td>IDP Completion Summary:</td>" .
							"<td><textarea style='width:500px; height:70px;' id='txtIDPDesc' name='txtIDPDesc'>".$idpfetchforeditres['score_description']."</textarea></td>" .
						"</tr>" .
						/* "<tr>" .
							"<td>Status:</td>" .
							"<td>" .
								"<select id='selIDPStatus' name='selIDPStatus'>" .
									"<option value='".$idpfetchforeditres['status']."'>".$idpfetchforeditres['status']."</option>" .
									"<option value='Planned'>Planned</option>" .
									"<option value='Ongoing'>Ongoing</option>" .
									"<option value='Done'>Done</option>" .
								"</select>" .
							"</td>" .
						"</tr>" . */
						"<tr>" .
							"<td>IDP Source File:</td>" .
							"<td><input id='txtIDPLink' name='txtIDPLink' type='text' style='width:250px' />".$idpfetchforeditres['score_link']."</td>" .											
						"</tr>" .
						"<tr>" .
							"<td colspan='100%' align='center'>" .
								"<input type='submit' class='redbutton' id='btnSaveIDP' name='btnSaveIDP'> <a style='color:blue;' onclick='closeIDPModal();'>Close</a>" .
								"<input type='hidden' id='txtIDPYear' name='txtIDPYear' value='". $idpyear ."'>" .
								"<input type='hidden' id='txtIDPGroup' name='txtIDPGroup' value='". $idpgroup ."'>" .
								"<input type='hidden' id='txtTokenType' name='txtTokenType' value='". $tokentype ."'>" .
								"<input type='hidden' id='txtEntryID' name='txtEntryID' value='". $entryid ."'>" .
							"</td>" .
						"</tr>" .
					"</table>" .
					"</form>";
	}
	
	
	/* $resulttable =	"<form id='frmaddIDP' name='frmaddIDP' method='post' action='main-post.php' enctype='multipart/form-data'>" .
					"<table width='95%'>" .
						"<tr>" .
							"<th colspan='100%'>ADD IDP</th>" .							
						"</tr>" .
						"<tr>" .
							"<td>Name:</td>" .
							"<td>" .
								"<select id='selIDPUser' name='selIDPUser'>" .
									$idpdropdown .
								"</select>" .
							"</td>" .
						"</tr>" .
						"<tr>" .
							"<td>IDP:</td>" .
							"<td><textarea id='txtIDPDesc' name='txtIDPDesc'></textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td>Status:</td>" .
							"<td>" .
								"<select id='selIDPStatus' name='selIDPStatus'>" .
									"<option value='Planned'>Planned</option>" .
									"<option value='Done'>Done</option>" .
								"</select>" .
							"</td>" .
						"</tr>" .
						"<tr>" .
							"<td colspan='100%'>" .
								"<input type='submit' class='redbutton' id='btnSaveIDP' name='btnSaveIDP'> <a style='color:blue;'>Close</a>" .
								"<input type='hidden' id='txtIDPYear' name='txtIDPYear' value='". $idpyear ."'>" .
								"<input type='hidden' id='txtIDPGroup' name='txtIDPGroup' value='". $idpgroup ."'>" .
								"<input type='hidden' id='txtTokenType' name='txtTokenType' value='". $tokentype ."'>" .
								"<input type='hidden' id='txtEntryID' name='txtEntryID' value='". $entryid ."'>" .
							"</td>" .
						"</tr>" .
					"</table>" .
					"</form>"; */
}

elseif(($addtoken2 > 0) || ($edittoken2 > 0))
{
	if($addtoken2 > 0)
	{
		$tokentype2 = "Add";
	}
	elseif($edittoken2 > 0)
	{
		$tokentype2 = "Edit";
	}
	
	$resulttable = "<form id='frmaddIDPUser' name='frmaddIDPUser' method='post' action='main-post.php'>" .
					"<table width='95%' align='center'>" .
						"<tr>" .
							"<th align='center' colspan='2'>Add User</th>" .
							
						"</tr>" .
						"<tr>" .
							"<td>Name:</td>" .
							"<td>" .
								"<input type='text' id='txtIDPUser' name='txtIDPUser'>" .
							"</td>" .
						"</tr>" .						
						"<tr>" .
							"<td align='center' colspan='2'>" .
								"<input type='submit' class='redbutton' id='btnSaveIDPUser' name'btnSaveIDPUser'> <a style='color:blue;' onclick='closeIDPModal();'>Close</a>" .								
								"<input type='hidden' id='txtIDPGroupUser' name='txtIDPGroupUser' value='". $idpgroup ."'>" .
								"<input type='hidden' id='txtTokenType2' name='txtTokenType2' value='". $tokentype2 ."'>" .
								"<input type='hidden' id='txtEntryID' name='txtEntryID' value='". $entryid ."'>" .
							"</td>" .
							"<td>" .
							"</td>" .
						"</tr>" .
					"</table>" .
					"</form>";
}

else
{
	if($idpyear > 0)
	{
		$resulttable = $idpmainlistfull;
	}
	else
	{
		$resulttable = "<table align='center' style='margin-left:24px;' >" .
							"<tr>" .
								"<th colspan='100%' style='font-size:24px; text-align:left;'>Individual Development Plans</th>" . 
							"</tr>" .
						"</table></br>";

		$resulttable .= "<table align='center' width='95%' style='border-spacing:0px; padding:0px; border-collapse:collapse;' >" .
							"<tr>" .
								"<td>"	.
									"<button id='btnIDPUsers' class='tablinkIDP' onclick=\"toggleIDP('tblIDPUsers', 'btnIDPUsers');\" style='background-color:red;' >Users</button>" .
									"<button id='btnIDPMain' class='tablinkIDP' onclick=\"toggleIDP('tblIDPMain', 'btnIDPMain');\">IDP List</button>" .
								"</td>" .
							"</tr>" .	
						"</table>";
						
		if($idpuserlist == "")
		{
			$idpuserlist = "<tr><td colspan='100%' align='center'>No Current Records.</td></tr>";
		}
						
		$resulttable .=	"<table width='33%' id='tblIDPUsers' name='tblIDPUsers' class='IDPTable' border='1' style='margin-left:24px; border-collapse:ollapse;'>" .
							"<tr>" .
								"<th>#</th>" .
								"<th>Users</th>" .
								//"<th>Controls</th>" .
							"</tr>" .
							"<tr>" .
								$idpuserlist .
							"</tr>" .
							/* "<tr>" .
								"<td colspan='100%' align='left'><button class='redbutton' id='btnIDPAddUser' name='btnIDPAddUser' onclick='openAddIDPUserModal();'>Add User</button></td>" .
							"</tr>" . */
						"</table>";
						
		$resulttable .=	"<table id='tblIDPMain' name='tblIDPMain' class='IDPTable' border='1' align='center' style='margin-left:24px; border-spacing:0px; padding:0px; border-collapse:ollapse; display:none'>" .
							"<thead>" .
								"<tr>" .
									"<td colspan='100%'>Year:<input id='numIDPYear' name='numIDPYear' type='number' min='2020' value='2020' width='50px'><img src='images/Search-icon.png' height='24px' id='btnShowIDPMain' name='btnShowIDPMain' title='Search IDP' style='cursor:pointer; vertical-align:middle;' onclick='showIDPMain();'></td>" .
								"</tr>" .
							"</thead>" .
							"<tbody id='idptablebody' name='idptablebody'>" .
								"<tr>" .
									"<td>Use the search year function to get started.</td>" .
								"</tr>" .
							"</tbody>" .
							"<tfoot>" .
								"<tr>" .
									"<td colspan='100%' align='center'><button class='redbutton' id='btnAddIDP' name='btnAddIDP' onclick='openIDPModal();'>Add IDP</button></td>" .
								"</tr>" .
							"</tfoot>" .
						"</table>";
	}
}


echo $resulttable;
?>