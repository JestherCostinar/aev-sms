<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$item_id = $_GET['id'];
$item_type = $_GET['type'];
$status = $_GET['status'];
$ccweight = $_GET['ccweight'];
$ccid = $_GET['ccid'];
$table = "";
if($status == 'Activate')
{
	if($item_type == 'Users')
	{
		$table = "users_mst";		
	}
	elseif($item_type == 'ActivityInput')
	{
		$table =  "entries_activity";
		$item_type = "Entries";
	}
	elseif($item_type == 'IncidentInput')
	{
		$table =  "entries_incident";
		$item_type = "Entries";
	}
	elseif($item_type == 'EXPROInput')
	{
		$table =  "entries_activity";
		$item_type = "Entries";
	}
	elseif($item_type == 'IncMainClass')
	{
		$table = "incident_main_cat";
		$item_type = "Entries";
	}
	elseif($item_type == 'IncSubClass')
	{
		$table = "incident_sub_cat";
		$item_type = "Entries";
	}
	elseif($item_type == 'Locators')
	{
		$table = "bu_locators";
		$item_type = "Locators";
	}
	$statsql = mysqli_query($conn, "SELECT status FROM ".$table." WHERE id=". $item_id) or die(mysqli_error($conn));
	$stat =  mysqli_fetch_assoc($statsql);
	$newstat = ($stat['status'] == "Active") ? "Inactive" : "Active";
	mysqli_query($conn, "UPDATE ".$table."  SET status ='".$newstat."' WHERE id=". $item_id) or die(mysqli_error($conn));
}
elseif($status == "publish")
{
	mysqli_query($conn, "UPDATE cc_mst SET published = 1 WHERE id = ".$ccid) or die(mysqli_error($conn));
}
else
{
	if($item_type == 'Locs')
	{
		$table = "location_mst";		
	}

	elseif($item_type == 'SecAlert')
	{
		$table =  "oic_mst";
	}

	// elseif($item_type == 'Users')
	// {
		// $table = "users_mst";
	// }
	
	elseif($item_type == 'SecAgencyBu')
	{
		$table = "agency_bu";
		$item_type = "SecAgency";
	}

	elseif($item_type == 'SecAgencyClient')
	{
		$table = "agency_clients";
		$item_type = "SecAgency";
	}

	elseif($item_type == 'SecAgencyRemarks')
	{
		$table = "agency_remarks";
		$item_type = "SecAgency";
	}
	
	elseif($item_type == 'SecAgencyLicenses')
	{
		$table = "license_mst";
		$item_type = "SecAgency";
	}

	elseif($item_type == 'CodeMgt')
	{
		$table =  "urc_mst";
	}

	elseif($item_type == 'BUs')
	{
		$table =  "bu_mst";
	}

	elseif($item_type == 'Groups')
	{
		$table =  "main_groups";
	}

	elseif($item_type == 'Regions')
	{
		$table =  "regional_group";
		$item_type = "Groups";
	}
	
	elseif($item_type == 'ConComp')
	{		
		/* $table =  "contract_compliance";
		$totalweight = "";
		$sqlsubtractweight = mysqli_query($conn, "SELECT * FROM cc_mst WHERE id = ".$ccid);
		$ressubtractweight = mysqli_fetch_assoc($sqlsubtractweight);
		$currentweight = $ressubtractweight['total_weight'];
		$totalweight = $currentweight - $ccweight;
		mysqli_query($conn, "UPDATE cc_mst SET total_weight = ".$totalweight." WHERE id = ".$ccid); */
		
		$table =  "cc_template";
		
		
	}
	
	elseif($item_type == 'Attachments')
	{
		$table =  "upload_mst";
		$unlinksql = mysqli_query($conn, "SELECT * FROM upload_mst where id = ".$item_id);
		$unlinkres = mysqli_fetch_assoc($unlinksql);
		unlink($unlinkres['upload_path']);
		$item_type == 'Incidents';
	}
	
	elseif($item_type == 'Users')
	{
		$table = "users_bu";
	}
	elseif($item_type == 'Audit_Attachments')
	{
		$table =  "audit_uploads";
		$unlinksql = mysqli_query($conn, "SELECT * FROM audit_uploads where id = ".$item_id);
		$unlinkres = mysqli_fetch_assoc($unlinksql);
		unlink($unlinkres['audit_upload_path']);
		//$item_type == 'Incidents';
	}

	// elseif($item_type == 'ActivityInput')
	// {
		// $table =  "entries_activity";
		// $item_type = "Entries";
	// }

	// elseif($item_type == 'IncidentInput')
	// {
		// $table =  "entries_incident";
		// $item_type = "Entries";
	// }

	// elseif($item_type == 'EXPROInput')
	// {
		// $table =  "entries_expro";
		// $item_type = "Entries";
	// }
	
	elseif($item_type == 'Stakeholder')
	{
	//	$table = "stakeholder_engagement";
		$table = "stakeholder_mst";
	}
	
	elseif($item_type == 'Stakeholder2')
	{
	//	$table = "stakeholder_engagement";
		$table = "stakeholder_mst_new";
		$item_type == "Stakeholder";
	}
	
	elseif($item_type == 'IDP')
	{
		$table = "idp_mst";
	}
	
	mysqli_query($conn, "DELETE FROM ". $table ." WHERE id = ". $item_id);
}
if(($_SESSION['level'] == "Admin") && !($_SESSION['multi-admin']))
{
	header("location:user-admin.php?last=" . $item_type);
}
elseif(($_SESSION['level'] == "Admin") && ($_SESSION['multi-admin']))
{
	header("location:multi-bu.php?last=" . $item_type);
}
elseif($_SESSION['level'] == "Super Admin")
{
	header("location:user-superadmin.php?last=" . $item_type);
}
?>