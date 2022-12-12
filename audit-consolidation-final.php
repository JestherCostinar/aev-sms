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
	$fontboldorange = "style='font-weight:bold; color:orange;'";
	$fontboldyellow = "style='font-weight:bold; color:gold;'";
	
	
	date_default_timezone_set('Asia/Manila');
	$todayaudit = date('Y-m-d H:i:s');
	
	$listOfBU = array();

	if($_SESSION['multi-admin']) {
		$listOfIDQuery = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id ='" . $_SESSION['id'] . "'");
		$buCount = 0;
		while ($list = mysqli_fetch_assoc($listOfIDQuery)) {
			$listOfBU[$buCount] = $list['bu_id'];
			$buCount++;
		}
	}
	
	if($_SESSION['multi-admin']) {
		$auditsql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ")");
	} else {
		$auditsql = mysqli_query($conn, "SELECT * FROM audit_mst");
	}	while($auditres = mysqli_fetch_assoc($auditsql))
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
	
	$innerrows = "";
	$outerrows = "";
	
	$mainGroupID = array();
	if($_SESSION['multi-admin']) {
		$listOfIDQuery = mysqli_query($conn, "SELECT main_group FROM bu_mst WHERE id IN (" . implode(',', array_map('intval', $listOfBU)) . ")");
		$buCount = 0;
		while ($list = mysqli_fetch_assoc($listOfIDQuery)) {
			$mainGroupID[$buCount] = $list['main_group'];
			$buCount++;
		}
	}
	
	if($_SESSION['multi-admin']) {
		$mainauditsql = mysqli_query($conn, "SELECT * FROM main_groups WHERE name != 'Executive Protection' AND id IN (" . implode(',', array_map('intval', $mainGroupID)) . ") ORDER BY name" );
	} else {
		$mainauditsql = mysqli_query($conn, "SELECT * FROM main_groups WHERE name != 'Executive Protection' ORDER BY name" );
	}
	
	while($mainauditres = mysqli_fetch_assoc($mainauditsql))
	{
		$auditRand = rand(0,1000);
		$subauditsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
												SUM(CASE WHEN status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS nson,
												SUM(CASE WHEN status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS nsde,
												SUM(CASE WHEN status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS ipon,
												SUM(CASE WHEN status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS ipde,
												SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) AS done,
												SUM(CASE WHEN risk_priority = 'Critical' THEN 1 ELSE 0 END) AS crit,
												SUM(CASE WHEN risk_priority = 'High' THEN 1 ELSE 0 END) AS high,
												SUM(CASE WHEN risk_priority = 'Medium' THEN 1 ELSE 0 END) AS med,
												SUM(CASE WHEN risk_priority = 'Low' THEN 1 ELSE 0 END) AS low 
											FROM audit_mst
											WHERE bu_id IN(SELECT id from bu_mst WHERE main_group = ".$mainauditres['id'].")")or die(mysqli_error($conn));
		$subauditres = mysqli_fetch_assoc($subauditsql);
		
		$innerrows = "";
		
		if($_SESSION['multi-admin']) {
			$specificauditsql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND main_group = ".$mainauditres['id'] );
		} else {
			$specificauditsql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE main_group = ".$mainauditres['id']);
		}

		while($specificauditres = mysqli_fetch_assoc($specificauditsql))
		{
			
			$closeout = 0;
			$auditTotal = 0;
			$auditnson = 0;
			$auditnsde = 0;
			$auditipon = 0;
			$auditipde = 0;
			
			$minuteauditsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
												SUM(CASE WHEN status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS nson,
												SUM(CASE WHEN status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS nsde,
												SUM(CASE WHEN status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS ipon,
												SUM(CASE WHEN status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS ipde,
												SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) AS done,
												SUM(CASE WHEN risk_priority = 'Critical' THEN 1 ELSE 0 END) AS crit,
												SUM(CASE WHEN risk_priority = 'High' THEN 1 ELSE 0 END) AS high,
												SUM(CASE WHEN risk_priority = 'Medium' THEN 1 ELSE 0 END) AS med,
												SUM(CASE WHEN risk_priority = 'Low' THEN 1 ELSE 0 END) AS low 
											FROM audit_mst
											WHERE bu_id = ".$specificauditres['id']);
			$minuteauditres = mysqli_fetch_assoc($minuteauditsql);
			
			$colortotal = "";
			$colorcloseout = "";
			$colornson = "";
			$colornsde = "";
			$coloripon = "";
			$coloripde = "";
			$colordone = "";
			$colorcrit = "";
			$colorhigh = "";
			$colormed = "";
			$colorlow = "";
			
			if($minuteauditres['total'] > 0)
			{
				$closeout = round(($minuteauditres['done']/$minuteauditres['total']*100), 2);
				$colortotal = $fontbold;				
			}
			if($minuteauditres['nson'] > 0)
			{
				$colornson = $fontboldgreen;
			}
			if($minuteauditres['nsde'] > 0)
			{
				$colornsde = $fontboldred;
			}
			if($minuteauditres['ipon'] > 0)
			{
				$coloripon = $fontboldgreen;
			}
			if($minuteauditres['ipde'] > 0)
			{
				$coloripde = $fontboldred;
			}
			if($minuteauditres['done'] > 0)
			{
				$colordone = $fontboldblue;
			}
			if($minuteauditres['crit'] > 0)
			{
				$colorcrit = $fontboldred;
			}
			if($minuteauditres['high'] > 0)
			{
				$colorhigh = $fontboldorange;
			}
			if($minuteauditres['med'] > 0)
			{
				$colormed = $fontboldyellow;
			}
			if($minuteauditres['low'] > 0)
			{
				$colorlow = $fontboldgreen;
			}
			
			$innerrows .=	"<tr align='center' class='subrow".$auditRand."' style='display:none;'>" .
								"<th><label style='color:blue; text-decoration:underline; cursor:pointer;' onclick='auditShow(".$specificauditres['id'].");'>".$specificauditres['bu']."</label></th>" .
								"<td ".$colortotal.">".$minuteauditres['total']."</td>" .
								"<td class='auditview1'>".floatval($closeout)."%</td>" .
								"<td ".$colornson." class='auditview1'>".$minuteauditres['nson']."</td>" .
								"<td ".$colornsde." class='auditview1'>".$minuteauditres['nsde']."</td>" .
								"<td ".$coloripon." class='auditview1'>".$minuteauditres['ipon']."</td>" .
								"<td ".$coloripde." class='auditview1'>".$minuteauditres['ipde']."</td>" .
								"<td ".$colordone." class='auditview1'>".$minuteauditres['done']."</td>" .
								"<td ".$colorcrit." class='auditview2'>".$minuteauditres['crit']."</td>" .
								"<td ".$colorhigh." class='auditview2'>".$minuteauditres['high']."</td>" .
								"<td ".$colormed." class='auditview2'>".$minuteauditres['med']."</td>" .
								"<td ".$colorlow." class='auditview2'>".$minuteauditres['low']."</td>" .
							"</tr>";			
			
		}
		
		$closeout = 0;
		
		$colortotal = "";
		$colorcloseout = "";
		$colornson = "";
		$colornsde = "";
		$coloripon = "";
		$coloripde = "";
		$colordone = "";
		$colorcrit = "";
		$colorhigh = "";
		$colormed = "";
		$colorlow = "";
		
		if($subauditres['total'] > 0)
		{
			$closeout = round(($subauditres['done']/$subauditres['total']*100), 2);
			$colortotal = $fontbold;				
		}
		if($subauditres['nson'] > 0)
		{	
			$colornson = $fontboldgreen;
		}
		if($subauditres['nsde'] > 0)
		{
			$colornsde = $fontboldred;
		}
		if($subauditres['ipon'] > 0)
		{
			$coloripon = $fontboldgreen;
		}
		if($subauditres['ipde'] > 0)
		{
			$coloripde = $fontboldred;
		}
		if($subauditres['done'] > 0)
		{
			$colordone = $fontboldblue;
		}
		if($subauditres['crit'] > 0)
		{
			$colorcrit = $fontboldred;
		}
		if($subauditres['high'] > 0)
		{
			$colorhigh = $fontboldorange;
		}
		if($subauditres['med'] > 0)
		{
			$colormed = $fontboldyellow;
		}
		if($subauditres['low'] > 0)
		{
			$colorlow = $fontboldgreen;
		}
		
		$outerrows .=	"<tr align='center' style='background-color:#ededed;'>" .
							"<th style='cursor:pointer;' onclick='auditDropdown(".$auditRand.");'><label style='color:green; text-decoration:underline; cursor:pointer;' >".$mainauditres['name']."</label></th>" .
							"<td ".$colortotal.">".$subauditres['total']."</td>" .
							"<td class='auditview1'>".floatval($closeout)."%</td>" .
							"<td ".$colornson." class='auditview1'>".$subauditres['nson']."</td>" .
							"<td ".$colornsde." class='auditview1'>".$subauditres['nsde']."</td>" .
							"<td ".$coloripon." class='auditview1'>".$subauditres['ipon']."</td>" .
							"<td ".$coloripde." class='auditview1'>".$subauditres['ipde']."</td>" .
							"<td ".$colordone." class='auditview1'>".$subauditres['done']."</td>" .
							"<td ".$colorcrit." class='auditview2'>".$subauditres['crit']."</td>" .
							"<td ".$colorhigh." class='auditview2'>".$subauditres['high']."</td>" .
							"<td ".$colormed." class='auditview2'>".$subauditres['med']."</td>" .
							"<td ".$colorlow." class='auditview2'>".$subauditres['low']."</td>" .
						"</tr>" . $innerrows;
	}
			
	$audittable =	"<table style='margin-left:5px;'>" .
						"<tr><td><label style='color:red; text-decoration:underline; cursor:pointer;' onclick='auditShow3();'>View Graphs</label></td></tr>" .
					"</table>" . 
					"<table class='auditspace' border='1' style='border-collapse:collapse; margin-left:5px; padding:10px;'>" .
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
					"<br>" 
					. "<table width='99%' align='center'>" .
						"<tr align='right'><td><label style='color:red; text-decoration:underline;' onclick='otherView();'>Switch View</label></td></tr>" .
					"</table>" .
					"
					<table width='99%' align='center' border='1' style='border-collapse:collapse;'>" .
						"<tr class='whiteonblack'>" .
							"<th>Business Unit</th>" .
							"<th>TOTAL</th>" .
							"<th class='auditview1'>Closeout</th>" .
							"<th class='auditview1'>Not Started<br>On Time</th>" .
							"<th class='auditview1'>Not Started<br>Delayed</th>" .
							"<th class='auditview1'>In Progress<br>On Time</th>" .
							"<th class='auditview1'>In Progress<br>Delayed</th>" .
							"<th class='auditview1'>Done</th>" .
							"<th class='auditview2'>Critical</th>" .
							"<th class='auditview2'>High</th>" .
							"<th class='auditview2'>Medium</th>" .
							"<th class='auditview2'>Low</th>" .
						"</tr>" .						
						$outerrows .						
					"</table>"
					;
	
	if(!empty($audittable))
	{
		echo $audittable;
	}
	else
	{
		echo "<tsble><tr><td colspan='100%' align='center'>No Existing Records.</td></tr><tr><td>".$auditbutton."</td></tr></table>";
	}


?>