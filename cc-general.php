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
$cctable = "";
$ccmaintable = "";
$secagencydatalist = "";
$secagencyname = "";
$secagencyemail = "";
$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:blue'>100</td>";
$savebutton = "<button class='redbutton' style='width:100px;' onclick='saveScore();'>Save</button>";

$secagencysql = mysqli_query($conn,"SELECT * FROM agency_mst ORDER BY agency_name");
while($secagencyres = mysqli_fetch_assoc($secagencysql)){
	$secagencydatalist .= "<option value=\"".$secagencyres['id']."\">".$secagencyres['agency_name']."</option>";
}

$secagencysql2 = mysqli_query($conn, "SELECT * FROM agency_bu WHERE bu_id = ".$bu);
while($secagencyres2 = mysqli_fetch_assoc($secagencysql2))
{
	$ccagencynamesql2 = mysqli_query($conn, "SELECT * FROM agency_mst WHERE id = ".$secagencyres2['agency_id']." AND contract_status = 'Active'");
	$ccagencynameres2 = mysqli_fetch_assoc($ccagencynamesql2);
	if($ccagencynameres2)
	{
		break;
	}
}
$cctestsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ". $ccyear ." AND month = ". $ccmonth ." AND bu = ". $bu)or die(mysqli_error($conn));
$cctestres = mysqli_fetch_assoc($cctestsql);

$bunamesql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$bu);
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
$alreadysent = "";
$printbtn = "display:none;";

if($cctestres)
{
	if($cctestres['approved'] == 1)
	{
		$lock = "class='txtborderless' readonly='readonly'";
		$grayed = "altrows";
		$nosave = "display:none;";
		$printbtn = "";
	}
	elseif($cctestres['sent'] == 1)
	{
		$alreadysent = "display:none;";		
	}
	else
	{
		$lock = "";
		$grayed = "";
		$nosave = "";		
	}
	
	$ccagencynamesql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE id = ".$cctestres['agency']);
	$ccagencynameres = mysqli_fetch_assoc($ccagencynamesql);
	
	$secagencyname = "<td align='left'>".$ccagencynameres['agency_name']."<input type='hidden' id='ccAdminAgency' name='ccAdminAgency' value='".$cctestres['agency']."'><input type='hidden' id='ccAdminMainCCID' name='ccAdminMainCCID' value='".$cctestres['id']."'></td>";;
	
	$secagencyemail = $cctestres['agency_email'];
	
	if(($cctestres['total_score'] <= 100) && ($cctestres['total_score'] >= 90))
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
	elseif(($cctestres['total_score'] < 76) && ($cctestres['total_score'] > 70))
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
	}
	
	if($ccyear >= 2019)
	{
		$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY number");
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
				$ccrowstyle2 = "style='background-color:#F5B7B1; padding-left:5px; padding-right:5px;'";
				$ccrowstyle3 = "style='background-color:#F1948A;'";
				$checked = "checked";
			}
			else
			{
				//$ccspecificres['actual'] = 0;
			}
			
			$asterisk = "";
					
			if($cctestres['approved'] == 1)
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
					
					$cctablereg .= 	"<tr title='".$ccyearres['hovertext']."' align='center' ".$ccrowstyle." title='".$ccyearres['hovertext']."'>" .
										"<td>".$ccyearres['subgoal']."</td>" . 							
										"<td>".$ccyearres['standard']."</td>" .
										"<td>".$ccyearres['frequency']."</td>" .
										"<td><input type='checkbox' class='ccActualHolders chkboxRegulatory' onchange='getScore4();' value='".$checkboxvalue."' ".$checked." disabled></td>" . 									
										"<td>".$ccspecificres['comments']."<input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
									"</tr>";
				}
				elseif($ccyearres['goal'] == "Operational")
				{
					$onchangeOpScore = "";
					$mainded = 0;
					$to50Logic = "";
					if($ccyearres['subgoal'] == "Incident Management")
					{
						$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 20);\"";
						$mainded = 20;
					}
					elseif($ccyearres['subgoal'] == "Logistics")
					{
						$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 35);\"";
						$mainded = 35;
						$to50Logic = "to50Logic";
					}
					elseif($ccyearres['subgoal'] == "SG Management")
					{
						$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 30);\"";
						$mainded = 30;
					}
					elseif($ccyearres['subgoal'] == "Administration")
					{
						$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 15);\"";
						$mainded = 15;
					}
					
					$changeindicator = "";
					if($ccyearres['standard'] == "Transportation")
					{
						$onchangeOpScore2 = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 35); getScoreVisual(this.value);\"";
						$scoreselect = "<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect' ".$onchangeOpScore.">".
											"<option value = '".$ccspecificres['actual']."'>".$ccspecificres['actual']."</option>".
											
										"</select>";
						$changeindicator = "class='ccTransportation'";
					}
					elseif($ccyearres['standard'] == "Agility Test")
					{
						$scoreselect = "<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect' ".$onchangeOpScore.">".
											"<option value = '".$ccspecificres['actual']."'>".$ccspecificres['actual']."</option>".
																					
										"</select>";
					}
					else
					{
						$scoreselect =	"<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect ".$to50Logic."' ".$onchangeOpScore.">".
											"<option value = '".$ccspecificres['actual']."'>".$ccspecificres['actual']."</option>".
											
										"</select>";
										
						if($to50Logic)
						{
							$changeindicator = "class='ccLogicOther'";
						}
					}
					
					$rawscore = $ccspecificres['actual'] * $ccyearres['deduction'] * $mainded / 10000;
					
					$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
					$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
					$cctableop1 = "<tr title='".$ccyearres['hovertext']."' align='center' ".$ccrowstyle.">" . 
								
										//"<td>".$ccyearres['subgoal']."</td>" . 							
										"<td>".$ccstandard."</td>" .
										"<td>".$ccdetails."</td>" .
										"<td ".$changeindicator.">".$ccyearres['deduction']."%</td>" .
										"<td>".$ccyearres['frequency']."</td>" .
										"<td>" .
											$scoreselect . 
											"<input type='hidden' class='ccRawScores' id='ccRawScoreHolder".$ccyearres['id']."' value='".$rawscore."'>" . 
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
			}
			else
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
					
					$cctablereg .= 	"<tr title='".$ccyearres['hovertext']."' align='center' ".$ccrowstyle.">" .
										"<td>".$ccyearres['subgoal']."</td>" . 							
										"<td>".$ccyearres['standard']."</td>" .
										"<td>".$ccyearres['frequency']."</td>" .
										"<td><input type='checkbox' class='ccActualHolders chkboxRegulatory' onchange='getScore4();' value='".$checkboxvalue."' ".$checked."></td>" . 									
										"<td><textarea style='resize:none; height:75px; width:200px;' class='ccCommentHolders' required>".$ccspecificres['comments']."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
									"</tr>";
				}
				elseif($ccyearres['goal'] == "Operational")
				{
					$onchangeOpScore = "";
					$mainded = 0;
					$to50Logic = "";
					if($ccyearres['subgoal'] == "Incident Management")
					{
						$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 20);\"";
						$mainded = 20;
					}
					elseif($ccyearres['subgoal'] == "Logistics")
					{
						$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 35);\"";
						$mainded = 35;
						$to50Logic = "to50Logic";
					}
					elseif($ccyearres['subgoal'] == "SG Management")
					{
						$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 30);\"";
						$mainded = 30;
					}
					elseif($ccyearres['subgoal'] == "Administration")
					{
						$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 15);\"";
						$mainded = 15;
					}
					
					$changeindicator = "";
					if($ccyearres['standard'] == "Transportation")
					{
						$onchangeOpScore2 = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 35); getScoreVisual(this.value);\"";
						$scoreselect = "<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect' ".$onchangeOpScore.">".
											"<option value = '".$ccspecificres['actual']."'>".$ccspecificres['actual']."</option>".
											"<option value = '5'>5</option>".
											"<option value = '4'>4</option>".
											"<option value = '3'>3</option>".										
											"<option value = '1'>1</option>".
											"<option value = '0'>N/A</option>".
										"</select>";
						$changeindicator = "class='ccTransportation'";
					}
					elseif($ccyearres['standard'] == "Agility Test")
					{
						$scoreselect = "<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect' ".$onchangeOpScore.">".
											"<option value = '".$ccspecificres['actual']."'>".$ccspecificres['actual']."</option>".
											"<option value = '5'>5</option>".
											"<option value = '4'>4</option>".
											"<option value = '3'>3</option>".										
											"<option value = '1'>1</option>".										
										"</select>";
					}
					else
					{
						$scoreselect =	"<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect ".$to50Logic."' ".$onchangeOpScore.">".
											"<option value = '".$ccspecificres['actual']."'>".$ccspecificres['actual']."</option>".
											"<option value = '5'>5</option>".
											"<option value = '4'>4</option>".
											"<option value = '3'>3</option>".
											"<option value = '2'>2</option>".
											"<option value = '1'>1</option>".
										"</select>";
										
						if($to50Logic)
						{
							$changeindicator = "class='ccLogicOther'";
						}
					}
					
					$rawscore = $ccspecificres['actual'] * $ccyearres['deduction'] * $mainded / 10000;
					
					$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
					$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
					$cctableop1 = "<tr title='".$ccyearres['hovertext']."' align='center' ".$ccrowstyle.">" . 
								
									//	"<td>".$ccyearres['subgoal']."</td>" . 							
										"<td>".$ccstandard."</td>" .
										"<td>".$ccdetails."</td>" .
										"<td ".$changeindicator.">".$ccyearres['deduction']."%</td>" .
									//	"<td>".$ccyearres['frequency']."<br><label id='ccRawScoreLabel".$ccyearres['id']."'>".$rawscore."</label></td>" .
										"<td>".$ccyearres['frequency']."</td>" .
										"<td>" .
											$scoreselect . 
											"<input type='hidden' class='ccRawScores' id='ccRawScoreHolder".$ccyearres['id']."' value='".$rawscore."'>" . 
										"</td>" .
										"<td><textarea style='resize:none; height:100px; width:150px;' class='ccCommentHolders' required>".$ccspecificres['comments']."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
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
		$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY number");
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
			if($ccspecificres['actual'] > 0)
			{
				$ccrowstyle = "style='background-color:#FAD8D8;'";
				$ccrowstyle2 = "style='background-color:#F5B7B1; padding-left:5px; padding-right:5px;'";
				$ccrowstyle3 = "style='background-color:#F1948A;'";
				$checked = "checked";
			}
			else
			{
				$ccspecificres['actual'] = 0;
			}
			
			$asterisk = "";
			if($ccyearres['score_group'] == "None")
			{
				$checkbox = "ccActualHolders chkboxNone";				
			}
			elseif($ccyearres['score_group'] == "Regulatory")
			{
				$checkbox = "ccActualHolders chkboxRegulatory";
				$asterisk = "*";				
			}
			elseif($ccyearres['score_group'] == "Proficiency")
			{
				$checkbox = "ccActualHolders chkboxProficiency";
				$asterisk = "**";				
			}
			elseif($ccyearres['score_group'] == "Deduction")
			{
				$checkbox = "ccActualHolders numDeduction";
			}
			
			
			
			
			if($cctestres['approved'] == 1)
			{
				if($ccyearres['score_group'] == "Deduction")
				{
					$deductbox = "<td title='".$ccyearres['hovertext']."'>".$ccspecificres['actual']."</td>";
					$optionalbox = "<td>".($ccyearres['deduction'] * $ccspecificres['actual'])."</td>";
				}
				else
				{
					$deductbox = "<td ".$ccrowstyle2.">".$ccyearres['deduction'].$asterisk."</td>";
					$optionalbox = "<td><input title='".$ccyearres['hovertext']."' type='checkbox' value='".$ccyearres['deduction']."' ".$checked." disabled></td>";
				}
				$cctable .= "<tr align='center' valign='center' ".$ccrowstyle.">" . 
							
							"<td>".$ccyearres['goal']."</td>" . 
//							"<td>".$ccyearres['subgoal']."</td>" . 
							"<td>".$ccyearres['reference']."</td>" . 
							"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
							"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" . 
//							"<td>".$ccyearres['frequency']."</td>" . 
							"<td>".$ccyearres['source']."</td>" . 
							$deductbox .
							$optionalbox . 
//							"<td ".$ccrowstyle2.">".$ccspecificres['actual']."</td>" .
//							"<td class='ccScoreHolders ".$grayed."' ".$ccrowstyle3." id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($ccyearres['deduction'] * $ccspecificres['actual'])."</td>" . 
							"<td>".$ccspecificres['comments']."<input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
						"</tr>";
			}
			else
			{
				if($ccyearres['score_group'] == "Deduction")
				{
					$deductbox = "<td><input title='".$ccyearres['hovertext']."' class='".$checkbox."' type='number' id='numActualHolder".$ccyearres['id']."' value='".$ccspecificres['actual']."' style='width:40px; text-align:center;' onchange='getScore3(".$ccyearres['id'].",".$ccyearres['deduction'].");'></td>";
					$optionalbox = "<td><input type='textbox' class='ccDeductionHolders txtborderless' id='txtDeductionHolder".$ccyearres['id']."' value='".($ccyearres['deduction'] * $ccspecificres['actual'])."' style='width:40px; text-align:center;' disabled/></td>";
				}
				else
				{
					$deductbox = "<td ".$ccrowstyle2.">".$ccyearres['deduction'].$asterisk."</td>";
					$optionalbox = "<td><input title='".$ccyearres['hovertext']."' class='".$checkbox."' type='checkbox' value='".$ccyearres['deduction']."' ".$checked." onchange='getScore2();'></td>";
				}
				$cctable .= "<tr align='center' valign='center' ".$ccrowstyle.">" . 
								
								"<td>".$ccyearres['goal']."</td>" . 
	//							"<td>".$ccyearres['subgoal']."</td>" . 
								"<td>".$ccyearres['reference']."</td>" . 
								"<td width='25%' align='center' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
								"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" . 
	//							"<td>".$ccyearres['frequency']."</td>" . 
								"<td>".$ccyearres['source']."</td>" . 
								$deductbox . 
								$optionalbox . 
	//							"<td ".$ccrowstyle2."><input type='number' min='0' ".$lock." title='Frequency of Non-Compliance' class='ccActualHolders' id='numActualHolder".$ccyearres['id']."' name='numActualHolder".$ccyearres['id']." min='0' value='".$ccspecificres['actual']."' style='width:40px; text-align:center;' onchange='getScore(".$ccyearres['deduction'].", ".$ccyearres['id'].");'></td>" .
	//							"<td class='ccScoreHolders ".$grayed."' ".$ccrowstyle3." id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($ccyearres['deduction'] * $ccspecificres['actual'])."</td>" . 
								"<td><textarea style='resize:none; height:100px; weight:100%;' ".$lock." class='ccCommentHolders' required>".$ccspecificres['comments']."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
							"</tr>";
			}
		}
	}
	elseif($ccyear == 2017)
	{
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
			if($ccspecificres['actual'] > 0)
			{
				$ccrowstyle = "style='background-color:#FAD8D8;'";
				$ccrowstyle2 = "style='background-color:#F5B7B1;'";
				$ccrowstyle3 = "style='background-color:#F1948A;'";
			}
			else
			{
				$ccspecificres['actual'] = 0;
			}
			
			if($cctestres['approved'] == 1)
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
							"<td ".$ccrowstyle2.">".$ccspecificres['actual']."</td>" .
							"<td class='ccScoreHolders ".$grayed."' ".$ccrowstyle3." id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($ccyearres['deduction'] * $ccspecificres['actual'])."</td>" . 
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
							"<td ".$ccrowstyle2."><input type='number' min='0' ".$lock." title='Frequency of Non-Compliance' class='ccActualHolders' id='numActualHolder".$ccyearres['id']."' name='numActualHolder".$ccyearres['id']." min='0' value='".$ccspecificres['actual']."' style='width:40px; text-align:center;' onchange='getScore(".$ccyearres['deduction'].", ".$ccyearres['id'].");'></td>" .
							"<td class='ccScoreHolders ".$grayed."' ".$ccrowstyle3." id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($ccyearres['deduction'] * $ccspecificres['actual'])."</td>" . 
							"<td><textarea style='resize:none; height:100px; weight:100%;' ".$lock." class='ccCommentHolders' required>".$ccspecificres['comments']."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'><input class='ccEditIDHolders' type='hidden' value='".$ccspecificres['id']."'></td>" . 
						"</tr>";
			}
		}
	}
	
}
else
{
	$secagencyname = "<td align='left'><input type='hidden' id='ccAdminAgency' name='ccAdminAgency' value='".$ccagencynameres2['id']."'>".$ccagencynameres2['agency_name']."</td>";
	$initialscore2 = "";
	
	if($ccyear >= 2019)
	{
		$cctablereg = "";
		$cctableop = "";
		$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY number");
		while($ccyearres = mysqli_fetch_assoc($ccyearsql))
		{
			$default = 3;
			$defaultcomment = "";
			
			$quarterchecksql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ". $ccyear ." AND month = ". ($ccmonth - 1) ." AND bu = ". $bu);
			$quartercheckres = mysqli_fetch_assoc($quarterchecksql);
			
			
			if($quartercheckres)
			{
				$quarterchecksql2 = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$quartercheckres['id']." AND standard_id = ".$ccyearres['id']);
				$quartercheckres2 = mysqli_fetch_assoc($quarterchecksql2);
				
				if($quartercheckres2)
				{
					$default = $quartercheckres2['actual'];
					$defaultcomment = $quartercheckres2['comments'];
					//$initialscore2 -= ($quartercheckres2['actual'] * $ccyearres['deduction']);
				}
				
			}
			
					
				
			$ccrowstyle = "";
			$checked = "";
			if(($default > 0) && ($default < 3))
			{
				$ccrowstyle = "style='background-color:#FAD8D8;'";
				$checked = "checked";
			}
			$asterisk = "";		
			
			
			if($ccyearres['goal'] == "Regulatory")
			{				
				$cctablereg .= 	"<tr title='".$ccyearres['hovertext']."' align='center' ".$ccrowstyle.">" .
									"<td>".$ccyearres['subgoal']."</td>" . 							
									"<td>".$ccyearres['standard']."</td>" .
									"<td>".$ccyearres['frequency']."</td>" .
									"<td><input type='checkbox' class='ccActualHolders chkboxRegulatory' onchange='getScore4();' value='1' ".$checked."></td>" . 									
									"<td><textarea style='resize:none; height:75px; width:200px;' class='ccCommentHolders' required>".$defaultcomment."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'></td>" . 
								"</tr>";
			}
			elseif($ccyearres['goal'] == "Operational")
			{
				$onchangeOpScore = "";
				$mainded = 0;
				$to50Logic = "";
				if($ccyearres['subgoal'] == "Incident Management")
				{
					$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 20);\"";
					$mainded = 20;
				}
				elseif($ccyearres['subgoal'] == "Logistics")
				{
					$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 35);\"";
					$mainded = 35;
					$to50Logic = "to50Logic";
				}
				elseif($ccyearres['subgoal'] == "SG Management")
				{
					$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 30);\"";
					$mainded = 30;
				}
				elseif($ccyearres['subgoal'] == "Administration")
				{
					$onchangeOpScore = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 15);\"";
					$mainded = 15;
				}
				
				$changeindicator = "";
				if($ccyearres['standard'] == "Transportation")
				{
					$onchangeOpScore2 = "onchange=\"getScore5(".$ccyearres['id'].", ".$ccyearres['deduction'].", 35); getScoreVisual(this.value);\"";
					$scoreselect = "<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect' ".$onchangeOpScore.">".
										"<option value = '".$default."'>".$default."</option>".
										"<option value = '5'>5</option>".
										"<option value = '4'>4</option>".
										"<option value = '3' >3</option>".										
										"<option value = '1'>1</option>".
										"<option value = '0'>N/A</option>".
									"</select>";
					$changeindicator = "class='ccTransportation'";
				}
				elseif($ccyearres['standard'] == "Agility Test")
				{
					$scoreselect = "<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect' ".$onchangeOpScore.">".
										"<option value = '".$default."'>".$default."</option>".
										"<option value = '5'>5</option>".
										"<option value = '4'>4</option>".
										"<option value = '3' >3</option>".										
										"<option value = '1'>1</option>".										
									"</select>";
				}
				else
				{
					$scoreselect =	"<select id='selOpHolder".$ccyearres['id']."' class='ccActualHolders ccOpSelect ".$to50Logic."' ".$onchangeOpScore.">".
										"<option value = '".$default."'>".$default."</option>".
										"<option value = '5'>5</option>".
										"<option value = '4'>4</option>".
										"<option value = '3' >3</option>".
										"<option value = '2'>2</option>".
										"<option value = '1'>1</option>".
									"</select>";
									
					if($to50Logic)
					{
						$changeindicator = "class='ccLogicOther'";
					}
				}
				
				$rawscore = $default * $ccyearres['deduction'] * $mainded / 10000;
				
				$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
				$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
				$cctableop1 = "<tr title='".$ccyearres['hovertext']."' align='center' ".$ccrowstyle.">" . 
							
									//"<td>".$ccyearres['subgoal']."</td>" . 							
									"<td>".$ccstandard."</td>" .
									"<td>".$ccdetails."</td>" .
									"<td ".$changeindicator.">".$ccyearres['deduction']."%</td>" .
									"<td>".$ccyearres['frequency']."</td>" .
									"<td>" .
										$scoreselect . 
										"<input type='hidden' class='ccRawScores' id='ccRawScoreHolder".$ccyearres['id']."' value='".$rawscore."'>" . 
									"</td>" .
									"<td><textarea style='resize:none; height:100px; width:150px;' class='ccCommentHolders' required>".$defaultcomment."</textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'></td>" . 
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
			
		}
		$cctableop =	"<tr style='background-color:#CCC; '><th><b>Incident Management</b> (20%)</th><td></td><td></td><td></td><td></td><td></td></tr>" .
						$cctableopIM .
						"<tr style='background-color:#CCC;'><th><b>Logistics</b> (35%)</th><td></td><td></td><td></td><td></td><td></td></tr>" .
						$cctableopL .
						"<tr style='background-color:#CCC;'><th><b>SG Management</b> (30%)</th><td></td><td></td><td></td><td></td><td></td></tr>" .
						$cctableopSG .
						"<tr style='background-color:#CCC;'><th><b>Administration</b> (15%)</th><td></td><td></td><td></td><td></td><td></td></tr>" .
						$cctableopA;
	}
	elseif($ccyear == 2018)
	{
		$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY number");
		while($ccyearres = mysqli_fetch_assoc($ccyearsql))
		{
			$default = 0;
			
			$quarterchecksql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ". $ccyear ." AND month = ". ($ccmonth - 1) ." AND bu = ". $bu);
			$quartercheckres = mysqli_fetch_assoc($quarterchecksql);
			
			
			if($quartercheckres)
			{
				$quarterchecksql2 = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$quartercheckres['id']." AND standard_id = ".$ccyearres['id']);
				$quartercheckres2 = mysqli_fetch_assoc($quarterchecksql2);
				
				if($quartercheckres2)
				{
					$default = $quartercheckres2['actual'];
					$initialscore2 -= ($quartercheckres2['actual'] * $ccyearres['deduction']);
				}
				
			}
			
					
				
			$ccrowstyle = "";
			$checked = "";
			if($default > 0)
			{
				$ccrowstyle = "style='background-color:#FAD8D8;'";
				$checked = "checked";
			}
			$asterisk = "";
			
			if($ccyearres['score_group'] == "None")
			{
				$checkbox = "ccActualHolders chkboxNone";
				$deductbox = "<td style='padding-left:5px; padding-right:5px;'>".$ccyearres['deduction'].$asterisk."</td>";
				$optionalbox = "<td><input title='".$ccyearres['hovertext']."' class='".$checkbox."' type='checkbox' value='".$ccyearres['deduction']."' ".$checked." onchange='getScore2();'></td>";
			}
			elseif($ccyearres['score_group'] == "Regulatory")
			{
				$checkbox = "ccActualHolders chkboxRegulatory";
				$asterisk = "*";
				$deductbox = "<td style='padding-left:5px; padding-right:5px;'>".$ccyearres['deduction'].$asterisk."</td>";
				$optionalbox = "<td><input title='".$ccyearres['hovertext']."' class='".$checkbox."' type='checkbox' value='".$ccyearres['deduction']."' ".$checked." onchange='getScore2();'></td>";
			}
			elseif($ccyearres['score_group'] == "Proficiency")
			{
				$checkbox = "ccActualHolders chkboxProficiency";
				$asterisk = "**";
				$deductbox = "<td style='padding-left:5px; padding-right:5px;'>".$ccyearres['deduction'].$asterisk."</td>";
				$optionalbox = "<td><input title='".$ccyearres['hovertext']."' class='".$checkbox."' type='checkbox' value='".$ccyearres['deduction']."' ".$checked." onchange='getScore2();'></td>";
			}
			elseif($ccyearres['score_group'] == "Deduction")
			{
				$checkbox = "ccActualHolders numDeduction";
				$deductbox = "<td><input title='".$ccyearres['hovertext']."' class='".$checkbox."' type='number' id='numActualHolder".$ccyearres['id']."' value='0' onchange='getScore3(".$ccyearres['id'].",".$ccyearres['deduction'].");' style='width:40px; text-align:center;'></td>";
				$optionalbox = "<td><input type='textbox' class='ccDeductionHolders txtborderless' id='txtDeductionHolder".$ccyearres['id']."' value='0' style='width:40px; text-align:center;' disabled/></td>";
			}
			
			
			$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
			$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
			$cctable .= "<tr align='center' ".$ccrowstyle.">" . 
							
							"<td>".$ccyearres['goal']."</td>" . 							
							"<td>".$ccyearres['reference']."</td>" .  
							"<td align='center' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
							"<td width='30%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" . 							
							"<td>".$ccyearres['source']."</td>" . 
							$deductbox . 
							$optionalbox . 
//							"<td><input type='checkbox'></td>" .
//							"<td><input type='number' min='0' class='ccActualHolders' id='numActualHolder".$ccyearres['id']."' name='numActualHolder".$ccyearres['id']." min='0' value='".$default."' style='width:40px; text-align:center;' onchange='getScore(".$ccyearres['deduction'].", ".$ccyearres['id'].");'></td>" .
//							"<td class='ccScoreHolders' id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($default * $ccyearres['deduction'])."</td>" . 
							"<td><textarea style='resize:none; height:100px; weight:100%;' class='ccCommentHolders' required></textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'></td>" . 
						"</tr>";
		}
	}
	elseif($ccyear == 2017)
	{
		$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY CASE goal WHEN 'People' THEN 1 WHEN 'Customer' THEN 2 WHEN 'Process' THEN 3 WHEN 'Finance' THEN 4 WHEN 'Governance' THEN 5 ELSE 6 END, CASE subgoal WHEN 'Attract' THEN 1 WHEN 'Optimize' THEN 2 WHEN 'Retain' THEN 3 WHEN 'Statutory Compliance' THEN 4 WHEN 'SLA' THEN 5 WHEN 'Pre' THEN 6 WHEN 'Post' THEN 7 WHEN 'After' THEN 8 WHEN 'After' THEN 8 WHEN 'Billing' THEN 9 WHEN 'Deduction' THEN 10 ELSE 11 END, number");
		while($ccyearres = mysqli_fetch_assoc($ccyearsql))
		{
			$default = 0;
			
			$quarterchecksql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ". $ccyear ." AND month = ". ($ccmonth - 1) ." AND bu = ". $bu);
			$quartercheckres = mysqli_fetch_assoc($quarterchecksql);
			
			
			if($quartercheckres)
			{
				$quarterchecksql2 = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$quartercheckres['id']." AND standard_id = ".$ccyearres['id']);
				$quartercheckres2 = mysqli_fetch_assoc($quarterchecksql2);
				
				if($quartercheckres2)
				{
					$default = $quartercheckres2['actual'];
					$initialscore2 -= ($quartercheckres2['actual'] * $ccyearres['deduction']);
				}
				
			}
			
					
				
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
							"<td align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
							"<td width='30%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" . 
							"<td>".$ccyearres['frequency']."</td>" . 
							"<td>".$ccyearres['source']."</td>" . 
							"<td>".$ccyearres['deduction']."</td>" . 
							"<td><input type='number' min='0'  title='Frequency of Non-Compliance' class='ccActualHolders' id='numActualHolder".$ccyearres['id']."' name='numActualHolder".$ccyearres['id']." min='0' value='".$default."' style='width:40px; text-align:center;' onchange='getScore(".$ccyearres['deduction'].", ".$ccyearres['id'].");'></td>" .
							"<td class='ccScoreHolders' id='tdScoreHolder".$ccyearres['id']."' name='tdScoreHolder".$ccyearres['id']."'>".($default * $ccyearres['deduction'])."</td>" . 
							"<td><textarea style='resize:none; height:100px; weight:100%;' class='ccCommentHolders' required></textarea><input class='ccIDHolders' type='hidden' value='".$ccyearres['id']."'></td>" . 
						"</tr>";
		}
	}
	
	$initialscore = "<td id='tdTotalScoreHolder' align='center' style='font-size:2em; color:black'>".$initialscore2."</td>";
}

if($cctestres['approved'] == 1)
{
	$emaildisplay1 = "<b>Acknowledged:</b> <br> <b>Date:</b>";
	if($cctestres['approved_on'] != null)
	{
		$emaildisplay2 = $secagencyemail." <br> ".$cctestres['approved_on'];
	}
	else
	{
		$emaildisplay2 = $secagencyemail;
	}
	
}
else
{
	$emaildisplay1 = "<b>Agency E-mail:</b>";
	$emaildisplay2 = "<input ".$lock." id='ccAdminAgencyEmail' name='ccAdminAgencyEmail' type='text' value='".$secagencyemail."'>";
}

$regscore = "";
if($ccyear >= 2019)
{
	$regscore = "<td id='tdTotalRegScoreHolder' align='center' style='font-size:2em; color:white; background-color:blue;'>C</td>";
}

$ccmaintable =  "<form id='frmCCAdmin' name='frmCCAdmin' method='post' action='user-admin.php'>" .
				"<table width='95%' align='center' border='1' style='border-collapse:collapse;'>" .
					"<tr>" .
						"<td rowspan='3' align='center' width='15%' style='padding:15px;'><img height='50px' src='".$logopath."'/></td>" .
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
						"<td align='left'>".$emaildisplay2."</td>" .
					
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
							"<input id='ccSendOpScore' name='ccSendOpScore' type='hidden'>" .
							"<input id='ccSendMonth' name='ccSendMonth' type='hidden' value='".$ccmonth."'>" .
							"<input id='ccSendYear' name='ccSendYear' type='hidden'>" .
							"<input id='ccSendToAgency' name='ccSendToAgency' type='hidden' value='0'>" .
						"</td>" .						
						"</td>" .
					"</tr>" .
			   "</table>" .
			   "</form>";


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
					"<table width='95%' align='center'><tr><th style='font-size:1.5em;' align='left'>Operational Requirement</th><th  style='font-size:1.5em;' align='right'>Score:</th><th id='tdOpScoreHolder' style='font-size:2em;'>3</th></tr></table>" . 
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
elseif($ccyear == 2018)
{
	$ccmaintable .= "<table width='95%' border='1' align='center' style='border-collapse:collapse;'>" .
					"<thead>" .
						"<tr class='whiteonblack'>" .							
							"<th>Goal</th>" .							
							"<th>Reference</th>" .
							"<th >Standard</th>" .
							"<th >Details</th>" .							
							"<th>Source</th>" .
							"<th>%</th>" .
							"<th>Non-<br>Compliance</th>" .
							"<th>Comments</th>" .
						"</tr>" .
					"</thead>" .
					"<tbody>" .						
						$cctable .
						"<tr><td colspan='100%' align='left'>* - Deductions capped at 40% for this category<br>** - Deductions capped at 25% for this category</td></tr>" . 
					"</tbody>" .	
				"</table>";
}
elseif($ccyear <= 2017)
{
	$ccmaintable .= "<table width='95%' border='1' align='center' style='border-collapse:collapse;'>" .
					"<thead>" .
						"<tr class='whiteonblack'>" .							
							"<th>Goal</th>" .
							"<th>Subgoal</th>" .
							"<th>Reference</th>" .
							"<th >Standard</th>" .
							"<th >Details</th>" .
							"<th>Period</th>" .
							"<th>Source</th>" .
							"<th>Weight<br>Deduction</th>" .
							"<th style='white-space: nowrap;'>Frequency of<br><span style='font-size:12px;'>Non-Compliance</span></th>" .
							"<th>Total<br>Deduction</th>" .
							"<th>Comments</th>" .
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
							"<button id='btnccsave' class='redbutton' style='width:100px; ".$nosave." ".$alreadysent."' onclick='saveScore();'>Save</button>" .
							"<button id='btnccsaveandsend' class='redbutton' style='width:120px; ".$nosave."' onclick='saveScoreAndSend();'>Save and Send</button>" .
							"<button id='btnccprint' class='redbutton' style='cursor:pointer; ".$printbtn."' onclick='PrintReport3(\"".$headerBu."\");'>Print</button>" .
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