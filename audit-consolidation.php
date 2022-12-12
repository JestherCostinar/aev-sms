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
	
	$auditsql = mysqli_query($conn, "SELECT * FROM audit_mst");
	while($auditres = mysqli_fetch_assoc($auditsql))
	{
		$auditcounter++;		
		
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
				$donecounter = $fontboldblue;
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

	$burows = "";
	$auditbusql = mysqli_query($conn, "SELECT id, bu FROM bu_mst ORDER by bu");
	while($auditbures = mysqli_fetch_assoc($auditbusql))
	{
		$buauditcounter = 0;
		$budonecounter = 0;
		$buNSOncounter = 0;
		$buNSDecounter = 0;
		$buIPOncounter = 0;
		$buIPDecounter = 0;
		$totalcloseout = 0;
		$colorbuauditcounter = "";
		$colorbudonecounter = "";
		$colorbuNSOncounter = "";
		$colorbuNSDecounter = "";
		$colorbuIPOncounter = "";
		$colorbuIPDecounter = "";
		$auditsql2 = mysqli_query($conn, "SELECT * FROM audit_mst WHERE bu_id = ".$auditbures['id']);
		while($auditres2 = mysqli_fetch_assoc($auditsql2))
		{
			
				$buauditcounter++;
				$colorbuauditcounter = $fontbold;
				if($auditres2['status'] == "Done")
				{					
					$budonecounter++;					
					$colorbudonecounter = $fontboldblue;
				}
				elseif($auditres2['status'] == "Not Started")
				{
					if($auditres2['commited_date'] >= $todayaudit)
					{						
						$buNSOncounter++;						
						$colorbuNSOncounter = $fontboldgreen;
					}
					else
					{						
						$buNSDecounter++;					
						$colorbuNSDecounter = $fontboldred;
					}
				}
				elseif($auditres2['status'] == "In Progress")
				{
					if($auditres2['commited_date'] >= $todayaudit)
					{						
						$buIPOncounter++;						
						$colorbuIPOncounter = $fontboldgreen;
					}
					else
					{						
						$buIPDecounter++;						
						$colorbuIPDecounter = $fontboldred;
					}
				}
			
		}
		
		if($buauditcounter != 0)
		{
			$totalcloseout = round(($budonecounter/$buauditcounter*100), 2);
		}
		
		$burows .=	"<tr align='center'>" .
						"<th><label style='color:blue; text-decoration:underline; cursor:pointer;' onclick='auditShow(".$auditbures['id'].");'>".$auditbures['bu']."</label></th>" .
						"<td ".$colorbuauditcounter.">".$buauditcounter."</td>" .
						"<td>".floatval($totalcloseout)."%</td>" .
						"<td ".$colorbuNSOncounter.">".$buNSOncounter."</td>" .
						"<td ".$colorbuNSDecounter.">".$buNSDecounter."</td>" .
						"<td ".$colorbuIPOncounter.">".$buIPOncounter."</td>" .
						"<td ".$colorbuIPDecounter.">".$buIPDecounter."</td>" .
						"<td ".$colorbudonecounter.">".$budonecounter."</td>" .
					"</tr>";
		
	}
	
	$audittable =	"<table class='auditspace' border='1' style='border-collapse:collapse; margin-left:5px; padding:10px;'>" .
						"<thead>" .
							"<tr><th colspan='100%'>All Business Units</th></tr>" .
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
						"<tbody align='center'>" .
							"<tr>" .
								"<th>Critical</th>" .
								"<td ".$colorcriticalcounter.">".$criticalcounter."</td>" .
								"<td ".$colorcriticalNSOn.">".$criticalNSOn."</td>" .
								"<td ".$colorcriticalNSDe.">".$criticalNSDe."</td>" .
								"<td ".$colorcriticalIPOn.">".$criticalIPOn."</td>" .
								"<td ".$colorcriticalIPDe.">".$criticalIPDe."</td>" .
								"<td ".$colorcriticaldone.">".$criticaldone."</td>" .
							"</tr>" .
							"<tr>" .
								"<th>High</th>" .
								"<td ".$colorhighcounter.">".$highcounter."</td>" .
								"<td ".$colorhighNSOn.">".$highNSOn."</td>" .
								"<td ".$colorhighNSDe."<>".$highNSDe."</td>" .
								"<td ".$colorhighIPOn.">".$highIPOn."</td>" .
								"<td ".$colorhighIPDe.">".$highIPDe."</td>" .
								"<td ".$colorhighdone.">".$highdone."</td>" .
							"</tr>" .
							"<tr>" .
								"<th>Medium</th>" .
								"<td ".$colormediumcounter.">".$mediumcounter."</td>" .
								"<td ".$colormediumNSOn.">".$mediumNSOn."</td>" .
								"<td ".$colormediumNSDe.">".$mediumNSDe."</td>" .
								"<td ".$colormediumIPOn.">".$mediumIPOn."</td>" .
								"<td ".$colormediumIPDe.">".$mediumIPDe."</td>" .
								"<td ".$colormediumdone.">".$mediumdone."</td>" .
							"</tr>" .
							"<tr>" .
								"<th>Low</th>" .
								"<td ".$colorlowcounter.">".$lowcounter."</td>" .
								"<td ".$colorlowNSOn.">".$lowNSOn."</td>" .
								"<td ".$colorlowNSDe.">".$lowNSDe."</td>" .
								"<td ".$colorlowIPOn.">".$lowIPOn."</td>" .
								"<td ".$colorlowIPDe.">".$lowIPDe."</td>" .
								"<td ".$colorlowdone.">".$lowdone."</td>" .
							"</tr>" .
							"<tr>" .
								"<th>Total</th>" .
								"<td ".$colorauditcounter.">".$auditcounter."</td>" .
								"<td ".$colorNSOncounter.">".$NSOncounter."</td>" .
								"<td ".$colorNSDecounter.">".$NSDecounter."</td>" .
								"<td ".$colorIPOncounter.">".$IPOncounter."</td>" .
								"<td ".$colorIPDecounter.">".$IPDecounter."</td>" .
								"<td ".$colordonecounter.">".$donecounter."</td>" .
							"</tr>" .
						"</tbody>" .
					"</table>" .
					"<br>" . 
					"<table width='99%' align='center' border='1' style='border-collapse:collapse;'>" .
						"<tr class='whiteonblack'>" .
							"<th>Business Unit</th>" .
							"<th>TOTAL</th>" .
							"<th>Closeout</th>" .
							"<th>Not Started<br>On Time</th>" .
							"<th>Not Started<br>Delayed</th>" .
							"<th>In Progress<br>On Time</th>" .
							"<th>In Progress<br>Delayed</th>" .
							"<th>Done</th>" .
						"</tr>" .
						"<tr>" .
							$burows .
						"</tr>" .
					"</table>";
	
	if(!empty($audittable))
	{
		echo $audittable;
	}
	else
	{
		echo "<tsble><tr><td colspan='100%' align='center'>No Existing Records.</td></tr><tr><td>".$auditbutton."</td></tr></table>";
	}


?>