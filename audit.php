<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");

	$audit_bu = $_GET['bu_id'];
	//$audit_bu = 1;
	$audittable = "";
	$auditcounter = 0;
	$auditrows = "";
	
	$criticalcounter = 0;
	$criticaldone = 0;
	$criticalIPOn = 0;
	$criticalIPDe = 0;
	$criticalNSOn = 0;
	$criticalNSDe = 0;
	
	$colorcriticalcounter = "";
	$colorcriticaldone = "";
	$colorcriticalIPOn = "";
	$colorcriticalIPDe = "";
	$colorcriticalNSOn = "";
	$colorcriticalNSDe = "";	
	
	$highcounter = 0;
	$highdone = 0;
	$highIPOn = 0;
	$highIPDe = 0;
	$highNSOn = 0;
	$highNSDe = 0;
	
	$colorhighcounter = "";
	$colorhighdone = "";
	$colorhighIPOn = "";
	$colorhighIPDe = "";
	$colorhighNSOn = "";
	$colorhighNSDe = "";
	
	$mediumcounter = 0;
	$mediumdone = 0;
	$mediumIPOn = 0;
	$mediumIPDe = 0;
	$mediumNSOn = 0;
	$mediumNSDe = 0;
	
	$colormediumcounter = "";
	$colormediumdone = "";
	$colormediumIPOn = "";
	$colormediumIPDe = "";
	$colormediumNSOn = "";
	$colormediumNSDe = "";
	
	$lowcounter = 0;
	$lowdone = 0;
	$lowIPOn = 0;
	$lowIPDe = 0;
	$lowNSOn = 0;
	$lowNSDe = 0;
	
	$colorlowcounter = "";
	$colorlowdone = "";
	$colorlowIPOn = "";
	$colorlowIPDe = "";
	$colorlowNSOn = "";
	$colorlowNSDe = "";
	
	$donecounter = 0;
	$NSOncounter = 0;
	$NSDecounter = 0;
	$IPOncounter = 0;
	$IPDecounter = 0;
	
	$colordonecounter = "";
	$colorNSOncounter = "";
	$colorNSDecounter = "";
	$colorIPOncounter = "";
	$colorIPDecounter = "";
	
	$fontbold = "style='font-weight:bold;'";
	$fontboldgreen = "style='font-weight:bold; color:green;'";
	$fontboldred = "style='font-weight:bold; color:red;'";
	$fontboldblue = "style='font-weight:bold; color:blue;'";
	
	
	date_default_timezone_set('Asia/Manila');
	$todayaudit = date('Y-m-d H:i:s');
	
	$auditsql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE bu_id = ".$audit_bu." ORDER BY audit_date, commited_date");
	while($auditres = mysqli_fetch_assoc($auditsql))
	{
		$auditcounter++;
		$auditevidence = "None";
		/* if($auditres['evidence'])
		{
			$auditevidence = "<a href='".$auditres['evidence']."' target='_blank' style='color:blue;'>View</a> / <label style='color:green; cursor:pointer; text-decoration:underline;' onclick='openAuditEvidenceadd(".$auditres['id'].", 1);'>Update</label>";
		}
		else
		{
			$auditevidence = "<label style='color:red; cursor:pointer; text-decoration:underline;' onclick='openAuditEvidenceadd(".$auditres['id'].", 0);'>Add</label>";
		} */
		$auditrows .=	"<tr>" .
							"<td>".$auditcounter."</td>" .
							"<td>".$auditres['audit_type']."</td>" .
							"<td>".$auditres['audit_date']."</td>" .
							"<td>".$auditres['category']."</td>" .
							"<td>".$auditres['findings']."</td>" .
							//"<td>".$auditres['recommendations']."</td>" .
							//"<td>".$auditres['risk_impact']."</td>" .
							//"<td align='center'><label style='color:blue; cursor:pointer; text-decoration:underline;' onclick='openAuditDetails(".$auditres['id'].",0);'>Recommendations</label><br><label style='color:green; cursor:pointer; text-decoration:underline;' onclick='openAuditDetails(".$auditres['id'].",1);'>Potential Risk Impact</label></td>".
							"<td align='center'><label style='color:blue; cursor:pointer; text-decoration:underline;' onclick='openAuditDetails(".$auditres['id'].",1);'>Details</label><br><label style='color:blue; cursor:pointer; text-decoration:underline;' onclick='openViewAuditFinding(".$auditres['id'].");'>Photos</label></td>".
							"<td>".$auditres['risk_priority']."</td>" .
							"<td>".$auditres['responsible']."</td>" .
							"<td>".$auditres['commited_date']."</td>" .
							"<td>".$auditres['actual_date']."</td>" .
							//"<td align='center'>".$auditevidence."</td>" .
							"<td align='center'><label style='color:blue; cursor:pointer; text-decoration:underline;' onclick='openAuditDetails(".$auditres['id'].",2);'>View</label></td>".
							"<td>".$auditres['status']."</td>" .
							"<td><img src='images/edit2.png' width='10px' style='cursor:pointer;' onclick='openAuditForm(".$auditres['id'].", ".$audit_bu.");'></td>" .
						"</tr>";
		
		
		if($auditres['risk_priority'] == "Critical")
		{
			$criticalcounter++;
			$colorcriticalcounter = $fontbold;
			if($auditres['status'] == "Done")
			{
				$criticaldone++;
				$donecounter++;
				$colorcriticaldone = $fontboldblue;
				$colordonecounter = $fontboldblue;
			}
			elseif($auditres['status'] == "Not Started")
			{
				if($auditres['commited_date'] >= $todayaudit)
				{
					$criticalNSOn++;
					$NSOncounter++;
					$colorcriticalNSOn = $fontboldgreen;
					$colorNSOncounter = $fontboldgreen;
				}
				else
				{
					$criticalNSDe++;
					$NSDecounter++;
					$colorcriticalNSDe = $fontboldred;
					$colorNSDecounter = $fontboldred;
				}
			}
			elseif($auditres['status'] == "In Progress")
			{
				if($auditres['commited_date'] >= $todayaudit)
				{
					$criticalIPOn++;
					$IPOncounter++;
					$colorcriticalIPOn = $fontboldgreen;
					$colorIPOncounter = $fontboldgreen;
				}
				else
				{
					$criticalIPDe++;
					$IPDecounter++;
					$colorcriticalIPDe = $fontboldred;
					$colorIPDecounter = $fontboldred;
				}
			}
		}
		elseif($auditres['risk_priority'] == "High")
		{
			$highcounter++;
			$colorhighcounter = $fontbold;
			if($auditres['status'] == "Done")
			{
				$highdone++;
				$donecounter++;
				$colorhighdone = $fontboldblue;
				$colordonecounter = $fontboldblue;
			}
			elseif($auditres['status'] == "Not Started")
			{
				if($auditres['commited_date'] >= $todayaudit)
				{
					$highNSOn++;
					$NSOncounter++;
					$colorhighNSOn = $fontboldgreen;
					$colorNSOncounter = $fontboldgreen;
				}
				else
				{
					$highNSDe++;
					$NSDecounter++;
					$colorhighNSDe = $fontboldred;
					$colorNSDecounter = $fontboldred;
				}
			}
			elseif($auditres['status'] == "In Progress")
			{
				if($auditres['commited_date'] >= $todayaudit)
				{
					$highIPOn++;
					$IPOncounter++;
					$colorhighIPOn = $fontboldgreen;
					$colorIPOncounter = $fontboldgreen;
				}
				else
				{
					$highIPDe++;
					$IPDecounter++;
					$colorhighIPDe = $fontboldred;
					$colorIPDecounter = $fontboldred;
				}
			}
		}
		elseif($auditres['risk_priority'] == "Medium")
		{
			$mediumcounter++;
			$colormediumcounter = $fontbold;
			if($auditres['status'] == "Done")
			{
				$mediumdone++;
				$donecounter++;
				$colormediumdone = $fontboldblue;
				$colordonecounter = $fontboldblue;
			}
			elseif($auditres['status'] == "Not Started")
			{
				if($auditres['commited_date'] >= $todayaudit)
				{
					$mediumNSOn++;
					$NSOncounter++;
					$colormediumNSOn = $fontboldgreen;
					$colorNSOncounter = $fontboldgreen;
				}
				else
				{
					$mediumNSDe++;
					$NSDecounter++;
					$colormediumNSDe = $fontboldred;
					$colorNSDecounter = $fontboldred;
				}
			}
			elseif($auditres['status'] == "In Progress")
			{
				if($auditres['commited_date'] >= $todayaudit)
				{
					$mediumIPOn++;
					$IPOncounter++;
					$colormediumIPOn = $fontboldgreen;
					$colorIPOncounter = $fontboldgreen;
				}
				else
				{
					$mediumIPDe++;
					$IPDecounter++;
					$colormediumIPDe = $fontboldred;
					$colorIPDecounter = $fontboldred;
				}
			}
		}
		elseif($auditres['risk_priority'] == "Low")
		{
			$lowcounter++;
			$colorlowcounter = $fontbold;
			if($auditres['status'] == "Done")
			{
				$lowdone++;
				$donecounter++;
				$colorlowdone = $fontboldblue;
				$colordonecounter = $fontboldblue;
			}
			elseif($auditres['status'] == "Not Started")
			{
				if($auditres['commited_date'] >= $todayaudit)
				{
					$lowNSOn++;
					$NSOncounter++;
					$colorlowNSOn = $fontboldgreen;
					$colorNSOncounter = $fontboldgreen;
				}
				else
				{
					$lowNSDe++;
					$NSDecounter++;
					$colorlowNSDe = $fontboldred;
					$colorNSDecounter = $fontboldred;
				}
			}
			elseif($auditres['status'] == "In Progress")
			{
				if($auditres['commited_date'] >= $todayaudit)
				{
					$lowIPOn++;
					$IPOncounter++;
					$colorlowIPOn = $fontboldgreen;
					$colorIPOncounter = $fontboldgreen;
				}
				else
				{
					$lowIPDe++;
					$IPDecounter++;
					$colorlowIPDe = $fontboldred;
					$colorIPDecounter = $fontboldred;
				}
			}
		}
	}
	
	$auditbutton = "<table style='margin-left:5px;'>" .
						"<tr><td><button class='redbutton' onclick='openAuditForm(0, ".$audit_bu.");'>Add Entry</button></td></tr>" .
					"</table>";
	if($_SESSION['level'] == "Admin")
	{
		$auditbutton = "";
	}
	
	$bunamesql = mysqli_query($conn, "SELECT bu FROM bu_mst WHERE id = ".$audit_bu);
	$bunameres = mysqli_fetch_assoc($bunamesql);
	
	$admintest = "onclick='auditShow2();'";
	if($_SESSION['level'] == "Admin")
	{
		$admintest = " onclick='auditShow3();'";
	}
	
	$superadmintest = "";
	if($_SESSION['level'] == "Super Admin")
	{
		$superadmintest = "<td align='right'><label style='color:red; text-decoration:underline; cursor:pointer;' onclick='auditShow4(".$audit_bu.")'>View Graphs</label></td>";
	}
	
	
	$audittable =	"<table style='margin-left:5px;'>" .
						"<tr><td align='left'><label style='color:red; text-decoration:underline; cursor:pointer;' ".$admintest.">Go Back</label></td>".$superadmintest."</tr>" .
					"</table>" .					
					"<table class='auditspace' border='1' style='border-collapse:collapse; margin-left:5px; padding:10px;'>" .
						"<thead>" .
							"<tr><th colspan='100%'>".$bunameres['bu']."</th></tr>" .
							"<tr class='whiteonblack' style='padding:10px;'>" .
								"<th>Risk Priority</th>" .
								"<th>Total</th>" .
								"<th>Not Started<br>On Time</th>" .
								"<th>Not Started<br>Delayed</th>" .
								"<th>In Progress<br>On Time</th>" .
								"<th>In Progress<br>Delayed</th>" .
								"<th>Done</th>" .
							"</tr>" .
						"</thead>" .
						"<tbody align='center' style='cursor:pointer;'>" .
							"<tr>" .
								"<th>Critical</th>" .
								"<td ".$colorcriticalcounter." onclick=\"invokeFilters(".$audit_bu.",'Critical',0,0);\">".$criticalcounter."</label></td>" .
								"<td ".$colorcriticalNSOn." onclick=\"invokeFilters(".$audit_bu.",'Critical','Not Started','On');\">".$criticalNSOn."</td>" .
								"<td ".$colorcriticalNSDe." onclick=\"invokeFilters(".$audit_bu.",'Critical','Not Started','De');\">".$criticalNSDe."</td>" .
								"<td ".$colorcriticalIPOn." onclick=\"invokeFilters(".$audit_bu.",'Critical','In Progress','On');\">".$criticalIPOn."</td>" .
								"<td ".$colorcriticalIPDe." onclick=\"invokeFilters(".$audit_bu.",'Critical','In Progress','De');\">".$criticalIPDe."</td>" .
								"<td ".$colorcriticaldone." onclick=\"invokeFilters(".$audit_bu.",'Critical','Done',0);\">".$criticaldone."</td>" .
							"</tr>" .
							"<tr>" .
								"<th>High</th>" .
								"<td ".$colorhighcounter." onclick=\"invokeFilters(".$audit_bu.",'High',0,0);\">".$highcounter."</td>" .
								"<td ".$colorhighNSOn." onclick=\"invokeFilters(".$audit_bu.",'High','Not Started','On');\">".$highNSOn."</td>" .
								"<td ".$colorhighNSDe." onclick=\"invokeFilters(".$audit_bu.",'High','Not Started','De');\">".$highNSDe."</td>" .
								"<td ".$colorhighIPOn." onclick=\"invokeFilters(".$audit_bu.",'High','In Progress','On');\">".$highIPOn."</td>" .
								"<td ".$colorhighIPDe." onclick=\"invokeFilters(".$audit_bu.",'High','In Progress','De');\">".$highIPDe."</td>" .
								"<td ".$colorhighdone." onclick=\"invokeFilters(".$audit_bu.",'High','Done',0);\">".$highdone."</td>" .
							"</tr>" .
							"<tr>" .
								"<th>Medium</th>" .
								"<td ".$colormediumcounter." onclick=\"invokeFilters(".$audit_bu.",'Medium',0,0);\">".$mediumcounter."</td>" .
								"<td ".$colormediumNSOn." onclick=\"invokeFilters(".$audit_bu.",'Medium','Not Started','On');\">".$mediumNSOn."</td>" .
								"<td ".$colormediumNSDe." onclick=\"invokeFilters(".$audit_bu.",'Medium','Not Started','De');\">".$mediumNSDe."</td>" .
								"<td ".$colormediumIPOn." onclick=\"invokeFilters(".$audit_bu.",'Medium','In Progress','On');\">".$mediumIPOn."</td>" .
								"<td ".$colormediumIPDe." onclick=\"invokeFilters(".$audit_bu.",'Medium','In Progress','De');\">".$mediumIPDe."</td>" .
								"<td ".$colormediumdone." onclick=\"invokeFilters(".$audit_bu.",'Medium','Done',0);\">".$mediumdone."</td>" .
							"</tr>" .
							"<tr>" .
								"<th>Low</th>" .
								"<td ".$colorlowcounter." onclick=\"invokeFilters(".$audit_bu.",'Low',0,0);\">".$lowcounter."</td>" .
								"<td ".$colorlowNSOn." onclick=\"invokeFilters(".$audit_bu.",'Low','Not Started','On');\">".$lowNSOn."</td>" .
								"<td ".$colorlowNSDe." onclick=\"invokeFilters(".$audit_bu.",'Low','Not Started','De');\">".$lowNSDe."</td>" .
								"<td ".$colorlowIPOn." onclick=\"invokeFilters(".$audit_bu.",'Low','In Progress','On');\">".$lowIPOn."</td>" .
								"<td ".$colorlowIPDe." onclick=\"invokeFilters(".$audit_bu.",'Low','In Progress','De');\">".$lowIPDe."</td>" .
								"<td ".$colorlowdone." onclick=\"invokeFilters(".$audit_bu.",'Low','Done',0);\">".$lowdone."</td>" .
							"</tr>" .
							"<tr>" .
								"<th>Total</th>" .
								"<td ".$colorauditcounter." onclick=\"invokeFilters(".$audit_bu.",0,0,0);\">".$auditcounter."</td>" .
								"<td ".$colorNSOncounter." onclick=\"invokeFilters(".$audit_bu.",0,'Not Started','On');\">".$NSOncounter."</td>" .
								"<td ".$colorNSDecounter." onclick=\"invokeFilters(".$audit_bu.",0,'Not Started','De');\">".$NSDecounter."</td>" .
								"<td ".$colorIPOncounter." onclick=\"invokeFilters(".$audit_bu.",0,'In Progress','On');\">".$IPOncounter."</td>" .
								"<td ".$colorIPDecounter." onclick=\"invokeFilters(".$audit_bu.",0,'In Progress','De');\">".$IPDecounter."</td>" .
								"<td ".$colordonecounter." onclick=\"invokeFilters(".$audit_bu.",0,'Done',0);\">".$donecounter."</td>" .
							"</tr>" .
						"</tbody>" .
					"</table>" .
					"</br>" .
					$auditbutton .
					//"<table class='auditspace' width='1750px' border='1' style='overflow-x:auto; border-collapse:collapse; margin-left:30px;'>" .
					"<table id='tblAuditMonitoring' align='center' class='auditspace' width='99%' border='1' style='overflow-x:auto; border-collapse:collapse;'>" .
						"<thead>" .
							"<tr>" .
								"<th>#</th>" .
								"<th>Audit Type</th>" .
								"<th width='75px'>Audit Date</th>" .
								"<th>Category</th>" .
								"<th>Findings</th>" .
								//"<th>Recommendations</th>" .
								//"<th>Potentail Risk Impact</th>" .
								"<th>View</th>" .
								"<th>Risk Priority</th>" .
								"<th>Responsible</th>" .
								"<th width='75px'>Commited Closure Date</th>" .
								"<th width='75px'>Actual Closure Date</th>" .
								"<th>Disposition / Evidence of Completion</th>" .
								"<th>Status</th>" .
								"<th></th>" .
							"</tr>" .
						"</thead>" .
						"<tbody id='tblAuditMonitoringTbody'>" .
							$auditrows .
						"</tbody>" .
					"</table>";
	
	if(!empty($auditrows))
	{
		echo $audittable;
	}
	else
	{
		$admintest = "onclick='auditShow2();'";
		if($_SESSION['level'] == "Admin")
		{
			$admintest = " onclick='auditShow3();'";
		}
	
		echo "<table style='margin-left:5px;'><tr><td><label style='color:red; text-decoration:underline; cursor:pointer;' ".$admintest.">Go Back</label></td></tr><tr><td colspan='100%' align='center'>No Existing Records.</td></tr><tr><td>".$auditbutton."</td></tr></table>";
	}


?>