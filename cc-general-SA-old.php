<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$ccyear =  mysqli_real_escape_string($conn, $_GET['ccyear']);
$ccmonth =  mysqli_real_escape_string($conn, $_GET['ccmonth']);
$cctext =  mysqli_real_escape_string($conn, $_GET['cctext']);
$ccbu = mysqli_real_escape_string($conn, $_GET['ccbu']);
$cctable = "";
$ccmaintable = "";
$secagencydatalist = "";
$secagencyname = "";
$secagencyemail = "";
$initialscore = "<td id='tdTotalScoreHolder' align='left' style='font-size:2em; color:blue'>100</td>";
$savebutton = "<button class='redbutton' style='width:100px;' onclick='saveScore();'>Save</button>";

$secagencysql = mysqli_query($conn,"SELECT * FROM agency_mst ORDER BY agency_name");
while($secagencyres = mysqli_fetch_assoc($secagencysql)){
	$secagencydatalist .= "<option value=\"".$secagencyres['id']."\">".$secagencyres['agency_name']."</option>";
}

$secagencysql2 = mysqli_query($conn, "SELECT * FROM agency_bu WHERE bu_id = ".$ccbu);
$secagencyres2 = mysqli_fetch_assoc($secagencysql2);

$ccagencynamesql2 = mysqli_query($conn, "SELECT * FROM agency_mst WHERE id = ".$secagencyres2['agency_id']);
$ccagencynameres2 = mysqli_fetch_assoc($ccagencynamesql2);

$cctestsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ". $ccyear ." AND month = ". $ccmonth ." AND bu = ". $ccbu)or die(mysqli_error($conn));
$cctestres = mysqli_fetch_assoc($cctestsql);

$bunamesql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$ccbu);
$bunameres = mysqli_fetch_assoc($bunamesql);
if($bunameres["bu_logo"])
{
	$logopath = $bunameres["bu_logo"];	
}
else
{
	$logopath = "images/logo_bgwhite.png";
}

$lock = "";
$nosave = "";

if($cctestres)
{
	
		$lock = "class='txtborderless' readonly='readonly'";
		$grayed = "altrows";
		$nosave = "display:none;";
	
	
	
	$ccagencynamesql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE id = ".$cctestres['agency']);
	$ccagencynameres = mysqli_fetch_assoc($ccagencynamesql);
	
	$secagencyname = "<td align='left'>".$ccagencynameres['agency_name']."<input type='hidden' id='ccAdminAgency' name='ccAdminAgency' value='".$cctestres['agency']."'><input type='hidden' id='ccAdminMainCCID' name='ccAdminMainCCID' value='".$cctestres['id']."'></td>";;
	
	$secagencyemail = $cctestres['agency_email'];
	
	if(($cctestres['total_score'] <= 100) && ($cctestres['total_score'] > 0))
	{
		if(($cctestres['raw_score'] <= 5) && ($cctestres['raw_score'] >= 4.2))
		{
			$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:purple'>".$cctestres['raw_score']."</td>";
		}
		elseif(($cctestres['raw_score'] < 4.2) && ($cctestres['raw_score'] >= 3.4))
		{
			$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:blue'>".$cctestres['raw_score']."</td>";
		}
		elseif(($cctestres['raw_score'] < 3.4) && ($cctestres['raw_score'] >= 3))
		{
			$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:green'>".$cctestres['raw_score']."</td>";
		}
		elseif(($cctestres['raw_score'] < 3) && ($cctestres['raw_score'] >= 2))
		{
			$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:orange'>".$cctestres['raw_score']."</td>";
		}
		elseif($cctestres['raw_score'] < 2)
		{
			$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:red'>".$cctestres['raw_score']."</td>";
		}
	}	
	else
	{
		$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:red'>SKIP</td>";
	}
	
	/* if(($cctestres['total_score'] <= 100) && ($cctestres['total_score'] >= 90))
	{
		$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:purple'>".$cctestres['total_score']."</td>";
	}
	elseif(($cctestres['total_score'] < 90) && ($cctestres['total_score'] >= 80))
	{
		$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:blue'>".$cctestres['total_score']."</td>";
	}
	elseif(($cctestres['total_score'] < 80) && ($cctestres['total_score'] >= 76))
	{
		$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:green'>".$cctestres['total_score']."</td>";
	}
	elseif(($cctestres['total_score'] <= 76) && ($cctestres['total_score'] > 70))
	{
		$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:orange'>".$cctestres['total_score']."</td>";
	}
	elseif($cctestres['total_score'] <= 70)
	{
		$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:red'>".$cctestres['total_score']."</td>";
	}
	else
	{
		$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:red'>SKIP</td>";
	} */
	
	
	
	$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY CASE goal WHEN 'People' THEN 1 WHEN 'Customer' THEN 2 WHEN 'Process' THEN 3 WHEN 'Finance' THEN 4 WHEN 'Governance' THEN 5 ELSE 6 END, CASE subgoal WHEN 'Attract' THEN 1 WHEN 'Optimize' THEN 2 WHEN 'Retain' THEN 3 WHEN 'Statutory Compliance' THEN 4 WHEN 'SLA' THEN 5 WHEN 'Pre' THEN 6 WHEN 'Post' THEN 7 WHEN 'After' THEN 8 WHEN 'After' THEN 8 WHEN 'Billing' THEN 9 WHEN 'Deduction' THEN 10 ELSE 11 END, number");
	while($ccyearres = mysqli_fetch_assoc($ccyearsql))
	{
		$ccspecificsql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE standard_id = ".$ccyearres['id']." AND cc_id = ".$cctestres['id']);
		$ccspecificres = mysqli_fetch_assoc($ccspecificsql);
		
		$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
		$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
		
		$ccrowstyle = "";
		$ccrowstyle2 = "";
		$ccrowstyle3 = "";
		$checked = "";
		if(($ccspecificres['actual'] > 0) && ($ccspecificres['actual'] < 3))
		{
			$ccrowstyle = "style='background-color:#FAD8D8;'";
			$ccrowstyle2 = "style='background-color:#F5B7B1;'";
			$ccrowstyle3 = "style='background-color:#F1948A;'";
			$checked = "checked";
		}
		
		if($ccyear >= 2019)
		{
			if($ccyearres['goal'] == "Regulatory")
			{
				$checkboxvalue = 3;
				if($ccyearres['details'] == "High" )
				{
					$checkboxvalue = 3;
				}
				elseif($ccyearres['details'] == "Medium" )
				{
					$checkboxvalue = 2;
				}
				elseif($ccyearres['details'] == "Low" )
				{
					$checkboxvalue = 1;
				}
				
				$cctablereg .= "<tr title='".$ccyearres['hovertext']."' align='center' ".$ccrowstyle.">" .
										"<td>".$ccyearres['subgoal']."</td>" . 							
										"<td>".$ccyearres['standard']."</td>" .
										"<td>".$ccyearres['frequency']."</td>" .
										"<td><input type='checkbox' class='ccActualHolders chkboxRegulatory' value='1' ".$checked." onchange='getScore4();'></td>" . 									
										//"<td>".$ccspecificres['comments']."</td>" . 
										"<td><textarea style='resize:none; height:75px; width:200px;' class='ccCommentHolders' required>".$ccspecificres['comments']."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
									"</tr>";
			}
			elseif($ccyearres['goal'] == "Operational")
			{
				$percentage = $ccyearres['deduction'];
				if($ccyearres['subgoal'] == "Logistics")
				{
					
					$cctransposql = mysqli_query($conn, "SELECT * FROM cc_template WHERE  year = ". $ccyear ." AND standard = 'Transportation'");
					$cctranspores = mysqli_fetch_assoc($cctransposql);
					$ccspecificsql2 = mysqli_query($conn, "SELECT * FROM cc_specific WHERE standard_id = ".$cctranspores['id']." AND cc_id = ".$cctestres['id']);
					$ccspecificres2 = mysqli_fetch_assoc($ccspecificsql2);
					
					if($ccspecificres2['actual'] == 0)
					{
						$percentage = 50;
						if($ccyearres['standard'] == "Transportation")
						{
							$percentage = "--";
						}
					}
				}
				$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
				$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
				$cctableop1 = "<tr title='".$ccyearres['hovertext']."' align='center' ".$ccrowstyle.">" . 
								
									//"<td>".$ccyearres['subgoal']."</td>" . 							
									"<td>".$ccstandard."</td>" .
									"<td>".$ccdetails."</td>" .
									"<td ".$changeindicator.">".$percentage."%</td>" .
									"<td>".$ccyearres['frequency']."</td>" .
									"<td>" .
										$ccspecificres['actual'] .
										//"<input type='hidden' class='ccRawScores' id='ccRawScoreHolder".$ccyearres['id']."' value='".$rawscore."'>" . 
									"</td>" .
									"<td>".$ccspecificres['comments']."<input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
								"</tr>";
				if($ccyearres['subgoal'] == "Incident Management")
				{
					$cctableopIM .= $cctableop1;
				}
				elseif($ccyearres['subgoal'] == "Logistics")
				{
					$cctableopL .= $cctableop1;
				}
				elseif($ccyearres['subgoal'] == "SG Management")
				{
					$cctableopSG .= $cctableop1;
				}
				elseif($ccyearres['subgoal'] == "Administration")
				{
					$cctableopA .= $cctableop1;
				}
			}
			$cctableop =	"<tr style='background-color:#CCC; '><th><b>Incident Management</b> - 20%</th><td></td><td></td><td></td><td></td><td></td></tr>" .
							$cctableopIM .
							"<tr style='background-color:#CCC;'><th><b>Logistics</b> - 35%</th><td></td><td></td><td></td><td></td><td></td></tr>" .
							$cctableopL .
							"<tr style='background-color:#CCC;'><th><b>SG Management</b> - 30%</th><td></td><td></td><td></td><td></td><td></td></tr>" .
							$cctableopSG .
							"<tr style='background-color:#CCC;'><th><b>Administration</b> - 15%</th><td></td><td></td><td></td><td></td><td></td></tr>" .
							$cctableopA;
			
			
			
		}
		elseif($ccyear == 2018)
		{
			$cctable .= "<tr align='center' valign='center' ".$ccrowstyle.">" . 
						
						"<td>".$ccyearres['goal']."</td>" . 
//						"<td>".$ccyearres['subgoal']."</td>" . 
						"<td>".$ccyearres['reference']."</td>" . 
						"<td align='center' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
						"<td width='30%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" . 
//						"<td>".$ccyearres['frequency']."</td>" . 
						"<td>".$ccyearres['source']."</td>" . 
						"<td ".$ccrowstyle2.">".$ccyearres['deduction']."</td>" . 
						//"<td ".$ccrowstyle2."><input ".$lock." class='ccActualHolders' id='numActualHolder".$ccyearres['id']."' name='numActualHolder".$ccyearres['id']." type='number' min='0' value='".$ccspecificres['actual']."' style='width:40px; text-align:center;' onchange='getScore(".$ccyearres['deduction'].", ".$ccyearres['id'].");'></td>" .
//						"<td ".$ccrowstyle2.">".$ccspecificres['actual']."</td>" .
						"<td><input type='checkbox' value='".$ccyearres['deduction']."' ".$checked." disabled></td>" .
//						"<td class='ccScoreHolders ".$grayed."' ".$ccrowstyle3." id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($ccyearres['deduction'] * $ccspecificres['actual'])."</td>" . 
						//"<td><textarea style='resize:none; height:100px; weight:100%;' ".$lock." class='ccCommentHolders'>".$ccspecificres['comments']."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
						"<td>".$ccspecificres['comments']."<input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
					"</tr>";
		}
		else
		{
			$cctable .= "<tr align='center' valign='top' ".$ccrowstyle.">" . 
						
						"<td>".$ccyearres['goal']."</td>" . 
						"<td>".$ccyearres['subgoal']."</td>" . 
						"<td>".$ccyearres['reference']."</td>" . 
						"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
						"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" . 
						"<td>".$ccyearres['frequency']."</td>" . 
						"<td>".$ccyearres['source']."</td>" . 
						"<td ".$ccrowstyle2.">".$ccyearres['deduction']."</td>" . 
						//"<td ".$ccrowstyle2."><input ".$lock." class='ccActualHolders' id='numActualHolder".$ccyearres['id']."' name='numActualHolder".$ccyearres['id']." type='number' min='0' value='".$ccspecificres['actual']."' style='width:40px; text-align:center;' onchange='getScore(".$ccyearres['deduction'].", ".$ccyearres['id'].");'></td>" .
						"<td ".$ccrowstyle2.">".$ccspecificres['actual']."</td>" .
						"<td class='ccScoreHolders ".$grayed."' ".$ccrowstyle3." id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($ccyearres['deduction'] * $ccspecificres['actual'])."</td>" . 
						//"<td><textarea style='resize:none; height:100px; weight:100%;' ".$lock." class='ccCommentHolders'>".$ccspecificres['comments']."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
						"<td>".$ccspecificres['comments']."<input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
					"</tr>";
		}
		
	}
}
else
{
	$secagencyname = "<td align='left'><input type='hidden' id='ccAdminAgency' name='ccAdminAgency' value='".$ccagencynameres2['id']."'>".$ccagencynameres2['agency_name']."</td>";
	$initialscore2 = 100;
	
	$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY number");
	while($ccyearres = mysqli_fetch_assoc($ccyearsql))
	{
		$default = 0;
		/* $checkquarterly = array(1, 4, 7, 10);
		$check3times = array(1, 5, 9);
		if($ccyearres['frequency'] == "Quarterly")
		{
			if(in_array($ccmonth, $checkquarterly))
			{
				$default = 0;
			}
			else
			{ */
				$quarterchecksql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ". $ccyear ." AND month = ". ($ccmonth - 1) ." AND bu = ". $ccbu);
				$quartercheckres = mysqli_fetch_assoc($quarterchecksql);
				
				
				if($quartercheckres)
				{
					$quarterchecksql2 = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$quartercheckres['id']." AND standard_id = ".$ccyearres['id']);
					$quartercheckres2 = mysqli_fetch_assoc($quarterchecksql2);
				
					$default = $quartercheckres2['actual'];
					$initialscore2 -= ($quartercheckres2['actual'] * $ccyearres['deduction']);
				}
				
				
			/* }
		}
		elseif($ccyearres['frequency'] == "3x a year")
		{
			if(in_array($ccmonth, $check3times))
			{
				$default = 0;
			}
			else
			{
				$quarterchecksql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ". $ccyear ." AND month = ". ($ccmonth - 1) ." AND bu = ". $bu);
				$quartercheckres = mysqli_fetch_assoc($quarterchecksql);
				
				$quarterchecksql2 = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$quartercheckres['id']." AND standard_id = ".$ccyearres['id']);
				$quartercheckres2 = mysqli_fetch_assoc($quarterchecksql2);
				
				$default = $quartercheckres2['actual'];
				$initialscore2 -= ($quartercheckres2['actual'] * $ccyearres['deduction']);
			}
		} */
		$ccrowstyle = "";
		if($default > 0)
		{
			$ccrowstyle = "style='background-color:#FAD8D8;'";
		}
		$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
		$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
		$cctable .= "<tr align='center' valign='top' ".$ccrowstyle.">" . 
						
						"<td>".$ccyearres['goal']."</td>" . 
						"<td>".$ccyearres['subgoal']."</td>" . 
						"<td>".$ccyearres['reference']."</td>" . 
						"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
						"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" . 
						"<td>".$ccyearres['frequency']."</td>" . 
						"<td>".$ccyearres['source']."</td>" . 
						"<td>".$ccyearres['deduction']."</td>" . 
						"<td><input class='ccActualHolders' id='numActualHolder".$ccyearres['id']."' name='numActualHolder".$ccyearres['id']." type='number' min='0' value='".$default."' style='width:40px; text-align:center;' onchange='getScore(".$ccyearres['deduction'].", ".$ccyearres['id'].");'></td>" .
						"<td class='ccScoreHolders' id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($default * $ccyearres['deduction'])."</td>" . 
						"<td><textarea style='resize:none; height:100px; weight:100%;' class='ccCommentHolders'></textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'></td>" . 
					"</tr>";
	}
	$initialscore = "<td id='tdTotalScoreHolder' align='left' style='font-size:2em; color:black'>".$initialscore2."</td>";
}

$printbtn = "display:none;";

if($cctestres['approved'] == 1)
{
	$emaildisplay1 = "<b>Acknowledged:</b> <br> <b>Date:</b>";
	$printbtn = "";
	if($cctestres['approved_on'] != null)
	{
		$secagencyemail = $secagencyemail." <br> ".$cctestres['approved_on'];
	}	
}
else
{
	$emaildisplay1 = "<b>Agency E-mail:</b>";
	date_default_timezone_set('Asia/Manila');
	$datenow = date('Y-m-d H:i:s');
	$ccmaintable .= "<div align='center'><a href='".$url_base."/concompacknowledge.php?ccid=".$cctestres['id']."&to=".$cctestres['token']."&now=".urlencode($datenow)."' target='_blank'>Approve / Bypass</a></div><br>";
}

$regscore = "";
if($ccyear >= 2019)
{
	$compfactor = 0;
	$ncsql = mysqli_query($conn,"SELECT * FROM cc_specific WHERE cc_id = ".$cctestres['id']." AND standard_id IN (SELECT id FROM cc_template WHERE goal = 'Regulatory')");
	while($ncres = mysqli_fetch_assoc($ncsql))
	{
		if($ncres['actual'] == 1)
		{
			$compfactor = 1;
		}
	}
	if($compfactor == 0)
	{
		$regscore = "<td id='tdTotalRegScoreHolder' align='center' style='font-size:2em; color:white; background-color:blue;'>C</td>";
	}
	elseif($compfactor == 1)
	{
		$regscore = "<td id='tdTotalRegScoreHolder' align='center' style='font-size:2em; color:white; background-color:red;'>NC</td>";
		$subScore = $cctestres['raw_score'];
		if(($subScore >= 1) && ($subScore <= 2))
		{
			$initialscore3 = ($subScore - 1) * 61;
		}
		elseif(($subScore3 > 2) && ($subScore <= 3))
		{
			$initialscore3 = ($subScore - 2) * 15 + 61;
		}
		elseif(($subScore > 3) && ($subScore <= 5))
		{
			$initialscore3 = (($subScore - 3) / 2 * 24 + 76);
		}
		$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:black'>".$initialscore3."</td>";
	}
	
}



$ccmaintable .=  "<form id='frmCCAdmin' name='frmCCAdmin' method='post' action='user-admin.php'>" .
				"<table width='95%' align='center' border='1' style='border-collapse:collapse;'>" .
					"<tr>" .
						"<td rowspan='3' align='center' width='15%'><img height='50px' src='".$logopath."'/></td>" .
						//"<td rowspan='3' align='center' width='70%'><label style='font-size:20px; font-weight:bold;'>CONTRACT COMPLIANCE for ".$bunameres['bu']."</label></td>" .
						"<td rowspan='3' align='center' width='65%'><label style='font-size:20px; font-weight:bold;'>Security Agency Contract Compliance<br>& Performance Evaluation</label></td>" .
						"<td width='20%' align='left'>Document Number: SEM-FM-017</td>" .
					"</tr>" .
					"<tr>"	.
						"<td width='20%' align='left'>Effective Date: March 22, 2019</td>" .
					"</tr>" .
					"<tr>"	.
						"<td width='20%' align='left'>Version Number: 1.00</td>" .
					"</tr>" .
				"</table>" .
				"<table width='95%' align='center'>" .
					"<tr>" .
						"<td>".
							"<table>".
								"<tr>".
									"<td align='left'><b>Year:</b></td>" .
									"<td align='left'>".$ccyear."</td>" .
								"</tr>".
								"<tr>".
									"<td align='Left'><b>Month:</b></td>" .
									"<td align='left'>".$cctext."</td>" .
								"</tr>".
							"</table>" .
						"</td>" .
						
						"<td>".
							"<table>" .
								"<tr>".
									"<td align='Left'><b>Business Unit:</b></td>" .
									"<td align='left'>".$bunameres['bu']."</td>" .
								"</tr>"	.
								"<tr>" .
									"<td align='left'><b>Agency:</b></td>" .
									$secagencyname .
								"</tr>".
							"</table>".
						"</td>".
					
						"<td align='left'>".$emaildisplay1."</td>" .
						"<td align='left'>".$secagencyemail."</td>" .
					
						"<td align='right'><b>Total Score:</b></td>" .
						$regscore .
						$initialscore .
					"</tr>" .
					"<tr>" .
						"<td>" .
							"<input id='ccActualList' name='ccActualList' type='hidden'>" .
							"<input id='ccCommentList' name='ccCommentList' type='hidden'>" .
							"<input id='ccIDList' name='ccIDList' type='hidden'>" .
							"<input id='ccEditIDList' name='ccEditIDList' type='hidden'>" .
							"<input id='ccSendTotalScore' name='ccSendTotalScore' type='hidden'>" .
							"<input id='ccNCIdentifier' name='ccNCIdentifier' type='hidden'>" .
							"<input id='ccSendMonth' name='ccSendMonth' type='hidden' value='".$ccmonth."'>" .
							"<input id='ccSendYear' name='ccSendYear' type='hidden'>" .
							"<input id='ccSendToAgency' name='ccSendToAgency' type='hidden' value='0'>" .
						"</td>" .						
						"</td>" .
					"</tr>" .
			   "</table>" .
			   "</form>";

if($ccyear > 2017)
{
	$ccheaderlist = "<th>Goal</th>" .					
					"<th>Reference</th>" .
					"<th>Standard</th>" .
					"<th>Details</th>" .					
					"<th>Source</th>" .
					"<th>%</th>" .					
					"<th>Non-<br>Compliance</th>" .
					"<th>Comments</th>";
}
else
{
	$ccheaderlist = "<th>Goal</th>" .
							"<th>Subgoal</th>" .
							"<th>Reference</th>" .
							"<th>Standard</th>" .
							"<th>Details</th>" .
							"<th>Period</th>" .
							"<th>Source</th>" .
							"<th>Weight<br>Deduction</th>" .
							"<th title='Frequency of Non-Compliance' style='white-space: nowrap;'>Frequency of<br><span style='font-size:12px;'>Non-Compliance</span></th>" .
							"<th>Total<br>Deduction</th>" .
							"<th>Comments</th>";
}

if($ccyear >= 2019)
{
	$ccmaintable .= "<table width='95%' align='center'><tr><th style='font-size:1.5em;' align='left'>Regulatory Requirement</th></tr></table>" . 
					"<table width='95%' border='1' align='center' style='border-collapse:collapse;'>" .
					"<thead>" .						
						"<tr class='whiteonblack'>" .							
							"<th width='20%'>Requirement</th>" .							
							"<th width='20%'>Details</th>" .
							"<th width='20%'>Frequency</th>" .
							"<th width='20%'>Non-<br>Compliance</th>" .
							"<th width='20%'>Comments</th>" .
						"</tr>" .
					"</thead>" .
					"<tbody>" .						
							$cctablereg .
					"</tbody>" .	
					"</table>" .
					"<br>" .
					"<table width='95%' align='center'><tr><th style='font-size:1.5em;' align='left'>Operational Requirement</th><th  style='font-size:1.5em;' align='right'>Score:</th><th id='tdOpScoreHolder' style='font-size:2em;'>".$cctestres['raw_score']."</th></tr></table>" . 
					"<table width='95%' border='1' align='center' style='border-collapse:collapse;'>" .
					"<thead>" .						
						"<tr class='whiteonblack'>" .							
							//"<th></th>" .							
							"<th></th>" .
							"<th>Metrics</th>" .
							"<th>Percentage</th>" .
							"<th>Frequency</th>" .
							"<th>Score</th>" .
							"<th>Comments</th>" .
						"</tr>" .
					"</thead>" .
					"<tbody>" .						
							$cctableop .
					"</tbody>" .
					"</table>";
	$cctable = 1;
}
else
{
	$ccmaintable .= "<table width='95%' border='1' align='center' style='border-collapse:collapse;'>" .
						"<thead>" .
							"<tr class='whiteonblack'>" .							
								$ccheaderlist .
							"</tr>" .
						"</thead>" .
						"<tbody>" .						
							$cctable .
						"</tbody>" .	
					"</table>";
}	

				
$ccmaintable .= "<table width='95%' align='center'>" .
					"<tr>" .
						"<td colspan='100%' align='center'>" . 
							"<button class='redbutton' style='width:100px; ".$nosave."' onclick='saveScore();'>Save</button>" .
						//	"<button class='redbutton' style='width:120px; ".$nosave."' onclick='saveScoreAndSend();'>Save and Send</button>" .
							"<button class='redbutton' style='width:120px; onclick='saveScoreAndSend();'>Edit and Send</button>" .
							"<button id='btnccprint' class='redbutton' style='cursor:pointer; ".$printbtn."' onclick='PrintReport4(\"".$bunameres['bu']."\");'>Print</button>" .
						"</td>" .
					"</tr>" .					
				"</table>";






if(!empty($cctable))
{
	echo $ccmaintable;
}
else
{
	echo "<table align='center'><tr><td colspan='100%' align='center'>Not yet available</td></tr></table>";
}
?>