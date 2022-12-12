<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");

	//$audit_bu = $_GET['bu_id'];
	$audit_bu = 1;
	$audittable = "";
	$auditcounter = 0;
	$auditrows = "";
	
	$risk_priority_filter = $_GET['risk_priority'];
	$status_filter = $_GET['status'];
	$commited_date_filter = $_GET['commited_date'];
	$audit_progress_filter = $_GET['progress'];
	
	$risk_priority_where = "";
	$status_where = "";
	$audit_progress_where = "";
	$complete_where = "";
	
	$fontbold = "style='font-weight:bold;'";
	$fontboldgreen = "style='font-weight:bold; color:green;'";
	$fontboldred = "style='font-weight:bold; color:red;'";
	$fontboldblue = "style='font-weight:bold; color:blue;'";	
	
	date_default_timezone_set('Asia/Manila');
	$todayaudit = date('Y-m-d H:i:s');
	
	if($risk_priority_filter != "0")
	{
		$risk_priority_where = " AND risk_priority = '".$risk_priority_filter."'";	
		
	}
	
	if($status_filter != "0")
	{
		$status_where = " AND status = '".$status_filter."'";
	}
	
	if($audit_progress_filter != "0")
	{
		if($audit_progress_filter == 'De') //delayed
		{
			$audit_progress_where = " AND commited_date <= '".$todayaudit."'";
		}
		elseif($audit_progress_filter == 'On') //on time
		{
			$audit_progress_where = " AND commited_date > '".$todayaudit."'";
		}	
	}
		
	$auditsql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE bu_id = ".$audit_bu." ".$risk_priority_where." ".$status_where." ".$audit_progress_where." ORDER BY audit_date, commited_date")or die(mysqli_error($conn));
	while($auditres = mysqli_fetch_assoc($auditsql))
	{
		$auditcounter++;
		$auditevidence = "None";
		if($auditres['evidence'])
		{
			$auditevidence = "<a href='".$auditres['evidence']."' target='_blank' style='color:blue;'>View</a> / <label style='color:green; cursor:pointer; text-decoration:underline;' onclick='openAuditEvidenceadd(".$auditres['id'].", 1);'>Update</label>";
		}
		else
		{
			$auditevidence = "<label style='color:red; cursor:pointer; text-decoration:underline;' onclick='openAuditEvidenceadd(".$auditres['id'].", 0);'>Add</label>";
		}
		$auditrows .=	"<tr>" .
							"<td>".$auditcounter."</td>" .
							"<td>".$auditres['audit_type']."</td>" .
							"<td>".$auditres['audit_date']."</td>" .
							"<td>".$auditres['category']."</td>" .
							"<td>".$auditres['findings']."</td>" .							
							"<td align='center'><label style='color:blue; cursor:pointer; text-decoration:underline;' onclick='openAuditDetails(".$auditres['id'].",1);'>View</label></td>".
							"<td>".$auditres['risk_priority']."</td>" .
							"<td>".$auditres['responsible']."</td>" .
							"<td>".$auditres['commited_date']."</td>" .
							"<td>".$auditres['actual_date']."</td>" .
							"<td align='center'>".$auditevidence."</td>" .
							"<td>".$auditres['status']."</td>" .
							"<td><img src='images/edit2.png' width='10px' style='cursor:pointer;' onclick='openAuditForm(".$auditres['id'].", ".$audit_bu.");'></td>" .
						"</tr>";		
	}
	
	
	if(!empty($auditrows))
	{
		echo $auditrows;
		
	}
	else
	{
		echo "<tr><td colspan='100%' align='center'>No Existing Records.</td></tr><tr><td>".$auditbutton."</td></tr></table>";
	}


?>