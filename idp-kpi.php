<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");
	
	if($_SESSION['level'] == 'Super Admin'){
		$superadmintest = 1;
	}
	
	$plannedIDP = 0;
	$doneIDP = 0;
	$idpyear = $_GET['year'];
	
	$fetchgroupsql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$bu)or die(mysqli_error($conn));
	$fetchgroupres = mysqli_fetch_assoc($fetchgroupsql);
	
	$setsqlPlanned = "";
	$setsqlOnGoing = "";
	$setsqlDone = "";
	
	if($$fetchgroupres['main_group'] == 12)
	{
	//	$loopusernamessql = mysqli_query($conn, "SELECT * FROM idp_mst WHERE group_id == 12 AND name IN (SELECT CONCAT(u.fname, ' ', u.lname) FROM users_mst u WHERE bu_id = ".$bu.")");
		$setsqlPlanned = "SELECT * FROM idp_mst WHERE group_id == 12 AND name IN (SELECT CONCAT(u.fname, ' ', u.lname) FROM users_mst u WHERE bu_id = ".$bu." AND status = 'Planned') AND year = ".$idpyear;
		$setsqlOnGoing = "SELECT * FROM idp_mst WHERE group_id == 12 AND name IN (SELECT CONCAT(u.fname, ' ', u.lname) FROM users_mst u WHERE bu_id = ".$bu." AND status = 'Ongoing') AND year = ".$idpyear;
		$setsqlDone = "SELECT * FROM idp_mst WHERE group_id == 12 AND name IN (SELECT CONCAT(u.fname, ' ', u.lname) FROM users_mst u WHERE bu_id = ".$bu." AND status = 'Done') AND year = ".$idpyear;
	}
	
	else
	{
		$setsqlPlanned = "SELECT * FROM idp_mst WHERE group_id = ".$fetchgroupres['main_group']." AND status = 'Planned' AND year = ".$idpyear;
		$setsqlOnGoing = "SELECT * FROM idp_mst WHERE group_id = ".$fetchgroupres['main_group']." AND status = 'Ongoing' AND year = ".$idpyear;
		$setsqlDone = "SELECT * FROM idp_mst WHERE group_id = ".$fetchgroupres['main_group']." AND status = 'Done' AND year = ".$idpyear;
	}
		
//	$countgroupIDPPlannedsql = mysqli_query($conn, "SELECT * FROM idp_mst WHERE group_id = ".$fetchgroupres['main_group']." AND status = 'Planned'")or die(mysqli_error($conn));
	$countgroupIDPPlannedsql = mysqli_query($conn, $setsqlPlanned);
	$countgroupIDPPlannedres = mysqli_fetch_assoc($countgroupIDPPlannedsql);
	$plannedIDP = mysqli_num_rows($countgroupIDPPlannedsql);
	
//	$countgroupIDPDonesql = mysqli_query($conn, "SELECT * FROM idp_mst WHERE group_id = ".$fetchgroupres['main_group']." AND status = 'Ongoing' AND year = ".$idpyear)or die(mysqli_error($conn));
	$countgroupIDPOnGoingsql = mysqli_query($conn, $setsqlOnGoing);
	$countgroupIDPOnGoingres = mysqli_fetch_assoc($countgroupIDPOnGoingsql);	
	$ongoingIDP = mysqli_num_rows($countgroupIDPOnGoingsql);
	
//	$countgroupIDPDonesql = mysqli_query($conn, "SELECT * FROM idp_mst WHERE group_id = ".$fetchgroupres['main_group']." AND status = 'Done' AND year = ".$idpyear)or die(mysqli_error($conn));
	$countgroupIDPDonesql = mysqli_query($conn, $setsqlDone);
	$countgroupIDPDoneres = mysqli_fetch_assoc($countgroupIDPDonesql);	
	$doneIDP = mysqli_num_rows($countgroupIDPDonesql);
	
	$totalIDP = $plannedIDP + $ongoingIDP + $doneIDP;
	$completionformula = ($doneIDP/$totalIDP)*100;
	$completionrate = number_format((($doneIDP/$totalIDP)*100),2,'.',',');
	
	if($completionformula <= 61)
	{
		$numformula = ($completionformula/61) + 1;
		//$numformula = 1 + (($completionformula * (100/60))/100);
	}
	elseif($completionformula > 61 && $completionformula <= 76)
	{
		$numformula = (($completionformula - 61)/15) + 2;
		//$numformula = 2 + (($completionformula * (100/76))/100);
	}
	elseif($completionformula > 76)
	{
		$numformula = (($completionformula - 76)/24) * 2 + 3;
	}
	$numrate = number_format(($numformula),2,'.',',');
	
	
	/* $IDPDisplay =	"<br><table align='center' border='1' style='border-collapse:collapse; margin-top:9px;'>" .
						"<tr>" .
							"<th class='whiteonblack'>IDPs Planned</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='center'><label style='font-weight:bold;; font-size:1.5em;'>".$totalIDP."</label></td>" .							
						"</tr>" .
						"<tr>" .
							"<th class='whiteonblack'>Done</th>" .
						"</tr>" .
						"<tr>" .							
							"<td align='center'><label style='font-weight:bold; font-size:1.5em;'>".$doneIDP."</label></td>" .
						"</tr>" .
						"<tr>" .
							"<th class='whiteonblack' colspan='100%'>Completion Rate</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='center' colspan='100%'><label style='font-weight:bold; font-size:2em; color:red;'>".$completionrate."%</label></td>" .
						"</tr>" .
					"</table>"; */
	if(($completionrate <= 100) && ($completionrate >= 90))
	{
		$color = "background-color:purple; color:white;";
		//$color2 = "white; color:purple;";
	}
	elseif(($completionrate < 90) && ($completionrate >= 80))
	{
		$color = "background-color:blue; color:white;";
		//$color2 = "white; color:blue;";
	}
	elseif(($completionrate < 80) && ($completionrate >= 76))
	{
		$color = "background-color:green; color:white;";
		//$color2 = "white; color:green;";
	}
	elseif(($completionrate < 76) && ($completionrate > 70))
	{
		$color = "background-color:orange; color:white;";
		//$color2 = "white; color:orange;";
	}
	elseif(($completionrate <= 70) && ($completionrate > 0))
	{
		$color = "background-color:red; color:white;";
		//$color2 = "white; color:red;";
	}
					
	$IDPDisplay =	"<br><table width='95%' align='center' border='1' style='border-collapse:collapse; margin-top:9px;'>" .
						"<tr>" .
							"<th class='whiteonblack'>Total IDPs</th>" .
							"<th class='whiteonblack'>Done</th>" .
							"<th class='whiteonblack'>Completion Rate</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='center' width='30%'><label style='font-weight:bold;; font-size:2em;'>".$totalIDP."</label></td>" .
							"<td align='center' width='30%'><label style='font-weight:bold; font-size:2em;'>".$doneIDP."</label></td>" .
							"<td align='center' style='".$color."'><label style='font-weight:bold; font-size:2em;'>".$numrate." (".$completionrate."%)</label></td>" .
							//"<td align='center'  style='".$color."'><label style='font-weight:bold; font-size:2em;'>".$completionrate."%</label></td>" .
						"</tr>" .						
					"</table>";
	
	$idptotal = 0;
	$idpcounter = 0;
	if($superadmintest == 1)
	{
		$maingroupsql = mysqli_query($conn, "SELECT * FROM main_groups WHERE name != 'Executive Protection' ORDER BY name");
		while($maingroupres = mysqli_fetch_assoc($maingroupsql))
		{
			
		//	$idpmainbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE expro = 0 ORDER BY bu");
			$idpmainlistfulllistdetails = "";
			$idpavgcounter = 0;
			$idpavgtotal = 0;
			$idpmainbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE main_group = ".$maingroupres['id']." ORDER BY bu");
			while($idpmainbures = mysqli_fetch_assoc($idpmainbusql))
			{
				$idpdisplay = 0;
				$color = "";
				$idptotal = 0;
				$idpcounter = 0;
				$idpmainlist = "";
				$idpmainsql = mysqli_query($conn,"SELECT * FROM idp_mst_new WHERE year = ".$idpyear." AND bu_id = ".$idpmainbures['id']);
				while($idpmainres = mysqli_fetch_assoc($idpmainsql))
				{
					/* $idpfetchnamesql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$idpmainres['user_id']);
					$idpfetchnameres = mysqli_fetch_assoc($idpfetchnamesql); */
					
					$datedisplay = date('Y-m-d H:i',strtotime('+8 hours',strtotime($idpmainres['date_saved'])));
					
					$idpmainlist .=	"<tr>" .							
										"<td align='center' valign='top'><a href='".$idpmainres['score_link']."' target='_blank' title='Go to source file'>" . $idpmainres['name'] ."</a></td>" .
										"<td align='center' valign='top' title='".$idpmainres['score_description']."'>" . $idpmainres['score'] ."</td>" .							
										"<td align='center' valign='top'>" . $datedisplay ."</td>" .							
									"</tr>";
					$idptotal = ($idptotal + $idpmainres['score']);
					$idpcounter++;
					
				}
				
				$idpdisplay = number_format((($idptotal / $idpcounter)),2,'.',',');
				if($idpdisplay > 0)
				{
					$idpavgtotal += $idpdisplay;
					$idpavgcounter++;
				}
				
				if(($idpdisplay <= 5) && ($idpdisplay >= 4.5))
				{
					$color = "background-color:purple; color:white;";
					//$color2 = "white; color:purple;";
				}
				elseif(($idpdisplay < 4.5) && ($idpdisplay >= 4))
				{
					$color = "background-color:blue; color:white;";
					//$color2 = "white; color:blue;";
				}
				elseif(($idpdisplay < 4) && ($idpdisplay >= 3))
				{
					$color = "background-color:green; color:white;";
					//$color2 = "white; color:green;";
				}
				elseif(($idpdisplay < 3) && ($idpdisplay > 2))
				{
					$color = "background-color:orange; color:white;";
					//$color2 = "white; color:orange;";
				}
				elseif(($idpdisplay <= 2) && ($idpdisplay > 0))
				{
					$color = "background-color:red; color:white;";
					//$color2 = "white; color:red;";
				}
				
				$trlinkname = "idpdetails" . $idpmainbures['id'];
				
				$idpmainlist .=	"<tr>" .							
									"<td align='center' valign='top' colspan='100%'><label style='text-decoration:underline; color:blue; font-weight:bold; cursor:pointer;' onclick='showAttachments(\"".$trlinkname."\");'>^</label></td>" .											
								"</tr>";
				$idpdatesql = mysqli_query($conn,"SELECT * FROM idp_mst_new WHERE year = ".$idpyear." AND bu_id = ".$idpmainbures['id']." ORDER BY date_saved DESC");
				$idpdateres = mysqli_fetch_assoc($idpdatesql);
				
				if($idpdateres)
				{
					$datedisplay2 = date('Y-m-d H:i',strtotime('+8 hours',strtotime($idpdateres['date_saved'])));
				}
				else
				{
					$datedisplay2 = "";
				}
				
		//		$datedisplay2 = date('Y-m-d H:i',strtotime('+8 hours',strtotime($idpdateres['date_saved'])));
				
				
				
				if($idpdisplay == 0)
				{
					$idpdisplay = "";
				}
				$idpmainlistfulllistdetails .=	"<tr class='idprow".$maingroupres['id']."'>" .
			//	$idpmainlistfulllistdetails .=	"<tr>" .
													"<td align='left'><label>". $idpmainbures['bu'] ."</label></td>" .
													"<td align='center'  style='".$color."'><label style='font-weight:bold;;'>" . $idpdisplay ."</label></td>" .							
													"<td align='center' ><label>". $datedisplay2 ."</label></td>" .
													"<td align='center' width='5%'><label style='text-decoration:underline; color:blue; font-weight:bold; cursor:pointer;' onclick='showAttachments(\"".$trlinkname."\");'>></label></td>" .
												"</tr>";
									
				$idpmainlistfulllistdetails .=	"<tr id='".$trlinkname."' name='".$trlinkname."' style='display:none;'>" .
											"<td colspan='100%'>" .
												"<table id='tblidpkpidetails' name='tblidpkpidetails' width='100%' align='center' border='1' style='border-collapse:collapse;'>" .
													"<tr>" .
														"<th class='whiteonblack'>Name</th>" .
														"<th class='whiteonblack'>Score</th>" .							
														"<th class='whiteonblack'>Last Updated On</th>" .							
													"</tr>" . $idpmainlist .
												"</table>" .
											"</td>" .
										"</tr>";
			}
			$idpavgdisplay = number_format((($idpavgtotal / $idpavgcounter)),2,'.',',');
			if($idpavgdisplay == 0.00)
			{
				$idpavgdisplay = "";
			}
			$idpmainlistfulllist .=	"<tr>" .
										"<td align='center'><label style='color:green; font-weight:bold; cursor:pointer;' onclick='idpDropdown(".$maingroupres['id'].");'>". $maingroupres['name'] ."</label></td>" .
										"<td align='center'>".$idpavgdisplay."</td>" .
										"<td></td>" .
										"<td></td>" .
									"</tr>" . $idpmainlistfulllistdetails;
		}
		$idpmainlistfull =	"<table id='tblidpkpigeneral' name='tblidpkpigeneral' width='100%' align='center' border='1' style='border-collapse:collapse;'>" .
									"<thead style='position:sticky; top:0;'>" .
									"<tr style='position:sticky; top:0;'>" .
										"<th class='whiteonblack' style='position:sticky; top:0;'>Business Unit</th>" .
										"<th class='whiteonblack' style='position:sticky; top:0;'>Avg Score</th>" .
										"<th class='whiteonblack' style='position:sticky; top:0;'>Last Updated On</th>" .
										"<th class='whiteonblack' style='position:sticky; top:0;'></th>" .
									"</tr>" .
									"</thead>" .
									"<tbody>" .
										$idpmainlistfulllist .
									"</tbody>" .
								"</table>";
	}
	else
	{
		
	
		$idpmainsql = mysqli_query($conn,"SELECT * FROM idp_mst_new WHERE year = ".$idpyear." AND bu_id = ".$bu);
		while($idpmainres = mysqli_fetch_assoc($idpmainsql))
		{
			/* $idpfetchnamesql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$idpmainres['user_id']);
			$idpfetchnameres = mysqli_fetch_assoc($idpfetchnamesql); */
			
			$datedisplay = date('Y-m-d H:i',strtotime('+8 hours',strtotime($idpmainres['date_saved'])));
			
			$idpmainlist .=	"<tr>" .							
								"<td align='center' valign='top'>" . $idpmainres['name'] ."</td>" .
								"<td align='center' valign='top'>" . $idpmainres['score'] ."</td>" .							
								"<td align='center' valign='top'>" . $datedisplay ."</td>" .							
							"</tr>";
			$idptotal = ($idptotal + $idpmainres['score']);
			$idpcounter++;		
		}
		
		$idpdisplay = number_format((($idptotal / $idpcounter)),2,'.',',');
		
		if(($idpdisplay <= 5) && ($idpdisplay >= 4.5))
		{
			$color = "background-color:purple; color:white;";
			//$color2 = "white; color:purple;";
		}
		elseif(($idpdisplay < 4.5) && ($idpdisplay >= 4))
		{
			$color = "background-color:blue; color:white;";
			//$color2 = "white; color:blue;";
		}
		elseif(($idpdisplay < 4) && ($idpdisplay >= 3))
		{
			$color = "background-color:green; color:white;";
			//$color2 = "white; color:green;";
		}
		elseif(($idpdisplay < 3) && ($idpdisplay > 2))
		{
			$color = "background-color:orange; color:white;";
			//$color2 = "white; color:orange;";
		}
		elseif(($idpdisplay <= 2) && ($idpdisplay > 0))
		{
			$color = "background-color:red; color:white;";
			//$color2 = "white; color:red;";
		}
		
		$idpmainlist .=	"<tr>" .							
							"<td align='center' valign='top' colspan='100%'><label style='text-decoration:underline; color:blue; font-weight:bold; cursor:pointer;' onclick='showAttachments(\"tblidpkpigeneral\"); showAttachments(\"tblidpkpidetails\");'>^</label></td>" .											
						"</tr>";
		$idpdatesql = mysqli_query($conn,"SELECT * FROM idp_mst_new WHERE year = ".$idpyear." AND bu_id = ".$bu." ORDER BY date_saved DESC");
		$idpdateres = mysqli_fetch_assoc($idpdatesql);
		
		$datedisplay2 = date('Y-m-d H:i',strtotime('+8 hours',strtotime($idpdateres['date_saved'])));
		
		$idpmainlistfull =	"<table id='tblidpkpigeneral' name='tblidpkpigeneral' width='95%' align='center' border='1' style='border-collapse:collapse; margin-top:9px;'>" .
								"<tr>" .								
									"<th class='whiteonblack'>Avg Score</th>" .							
									"<th class='whiteonblack'>Last Updated On</th>" .
									"<th class='whiteonblack'></th>" .
								"</tr>" .
								"<tr>" .								
									"<td align='center' width='45%' style='".$color."'><label style='font-weight:bold;; font-size:2em;'>" . $idpdisplay ."</label></td>" .							
									"<td align='center' width='45%'><label>". $datedisplay2 ."</label></td>" .
									"<td align='center' width='10%'><img src='images/View_Details.png' height='24px' style='cursor:pointer;' onclick='showAttachments(\"tblidpkpidetails\"); showAttachments(\"tblidpkpigeneral\");' /></td>" .
								"</tr>";
							"</table>";
		$idpmainlistfull .=	"<table id='tblidpkpidetails' name='tblidpkpidetails' width='95%' align='center' border='1' style='border-collapse:collapse; margin-top:9px; display:none;'>" .
								"<tr>" .
									"<th class='whiteonblack'>Name</th>" .
									"<th class='whiteonblack'>Score</th>" .							
									"<th class='whiteonblack'>Last Updated On</th>" .							
								"</tr>" . $idpmainlist .
							"</table>";
	}				
	echo $idpmainlistfull;
?>