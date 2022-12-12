<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");
	
	$KPItoken = $_GET['kpi_token'];

	$getYear = mysqli_real_escape_string($conn, $_GET['year']);
	$targetbu = mysqli_real_escape_string($conn, $_GET['bu']);
	$getKPItoken = mysqli_real_escape_string($conn, $_GET['kpi_token']);
	
	$existingrecord = 0;

		$jan = "<td>- - -</td>";
		$feb = "<td>- - -</td>";
		$mar = "<td>- - -</td>";
		$apr = "<td>- - -</td>";
		$may = "<td>- - -</td>";
		$jun = "<td>- - -</td>";
		$jul = "<td>- - -</td>";
		$aug = "<td>- - -</td>";
		$sep = "<td>- - -</td>";
		$oct = "<td>- - -</td>";
		$nov = "<td>- - -</td>";
		$dec = "<td>- - -</td>";
		
		$jan2 = "<td>- - -</td>";
		$feb2 = "<td>- - -</td>";
		$mar2 = "<td>- - -</td>";
		$apr2 = "<td>- - -</td>";
		$may2 = "<td>- - -</td>";
		$jun2 = "<td>- - -</td>";
		$jul2 = "<td>- - -</td>";
		$aug2 = "<td>- - -</td>";
		$sep2 = "<td>- - -</td>";
		$oct2 = "<td>- - -</td>";
		$nov2 = "<td>- - -</td>";
		$dec2 = "<td>- - -</td>";
		
		$on_time = "<td>- - -</td>";

//	$mainsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ".$getYear." AND bu = ".$bu." AND approved = 1");
	$mainsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ".$getYear." AND bu = ".$targetbu." ORDER BY month, approved, id");
	while($mainres = mysqli_fetch_assoc($mainsql))
	{
		// echo $mainres['id'] . '<br>'; 
		// echo 'Total Score: ' . $mainres['total_score'] . '<br>'; 
		// echo 'Raw Score: ' . $mainres['raw_score'] . '<br>'; 
		// echo 'Month: ' . $mainres['month'] . '<br>'; 
		// echo 'Is approved: ' . $mainres['approved'] . '<br><br><br>';
		$existingrecord = 1;
		if($mainres['approved'] == 1)
		{
			$skiptext = "";
			if($getYear > 2018)
			{
				
			
				/* if(($mainres['total_score'] <= 100) && ($mainres['total_score'] >= 90))
				{
					$color = "purple; color:white;";
					$color2 = "white; color:purple;";
				}
				elseif(($mainres['total_score'] < 90) && ($mainres['total_score'] >= 80))
				{
					$color = "blue; color:white;";
					$color2 = "white; color:blue;";
				}
				elseif(($mainres['total_score'] < 80) && ($mainres['total_score'] >= 76))
				{
					$color = "green; color:white;";
					$color2 = "white; color:green;";
				}
				elseif(($mainres['total_score'] < 76) && ($mainres['total_score'] > 70))
				{
					$color = "orange; color:white;";
					$color2 = "white; color:orange;";
				}
				elseif(($mainres['total_score'] <= 70) && ($mainres['total_score'] > 0))
				{
					$color = "red; color:white;";
					$color2 = "white; color:red;";
				} */
				if(($mainres['total_score'] <= 100) && ($mainres['total_score'] > 1))
				{
					if(($mainres['raw_score'] <= 5) && ($mainres['raw_score'] >= 4.5))
					{
						$color = "#006400; color:white;";
						$color2 = "white; color:#006400;";
					}
					elseif(($mainres['raw_score'] < 4.5) && ($mainres['raw_score'] >= 4))
					{
						$color = "#228B22; color:white;";
						$color2 = "white; color:#228B22;";
					}
					elseif(($mainres['raw_score'] < 4) && ($mainres['raw_score'] >= 3))
					{
						$color = "#54C571; color:white;";
						$color2 = "white; color:#54C571;";
					}
					elseif(($mainres['raw_score'] < 3) && ($mainres['raw_score'] >= 2))
					{
						$color = "#DBF9DB; color:black;";
						$color2 = "black; color:#DBF9DB;";
					}
					elseif(($mainres['raw_score'] < 2) && ($mainres['raw_score'] >= 1))
					{
						$color = "red; color:white;";
						$color2 = "white; color:red;";
					}					
				}
				elseif(($mainres['total_score'] == 0) || ($mainres['total_score'] == 1))
				{
					$color = "red; color:white;";
					$skiptext = "NC";
					$levelcounter = 0;
					$searchcolorsql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$mainres['id']." AND actual = 1");
					while($searchcolorres = mysqli_fetch_assoc($searchcolorsql))
					{
						$currentcounter = 0;
						$findlevelsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE id = ".$searchcolorres['standard_id']);
						$findlevelres = mysqli_fetch_assoc($findlevelsql);
						if($findlevelres['details'] == "High")
						{
							if($levelcounter <= 3)
							{
								$levelcounter = 3;
								$color = "red; color:white;";
								$skiptext = "NC";
							}
							
						}
						elseif($findlevelres['details'] == "Medium")
						{
							if($levelcounter <= 2)
							{
								$levelcounter = 2;
								$color = "orange; color:white;";
								$skiptext = "Warn";
								$searchyear = $mainres['year'];
								$searchmonth = ($mainres['month'] - 1);
								if(($mainres['month'] == 1) && ($mainres['year'] < 2019))
								{
									$searchyear = $mainres['year'] - 1;
									$searchmonth = 12;
								}
								$searchconsecutivesql = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
								$searchconsecutiveres = mysqli_fetch_assoc($searchconsecutivesql);
								$searchsecondarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres['id']." AND standard_id = ".$searchcolorres['standard_id']);
								$searchsecondaryres = mysqli_fetch_assoc($searchsecondarysql);
								if($searchsecondaryres['actual']  == 1)
								{
									$levelcounter = 3;
									$color = "red; color:white;";
									$skiptext = "NC";
								}
							}
						}
						elseif($findlevelres['details'] == "Low")
						{										
							if($levelcounter <= 1)
							{
								$levelcounter = 1;
								$color = "yellow; color:black;";
								$skiptext = "Cond";
								$searchyear = $mainres['year'];
								$searchmonth = ($mainres['month'] - 1);
								if(($mainres['month'] == 1) && ($mainres['year'] < 2019))
								{
									$searchyear = $mainres['year'] - 1;
									$searchmonth = 12;
								}
								$searchconsecutivesql = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
								$searchconsecutiveres = mysqli_fetch_assoc($searchconsecutivesql);
								$searchsecondarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres['id']." AND standard_id = ".$searchcolorres['standard_id']);
								$searchsecondaryres = mysqli_fetch_assoc($searchsecondarysql);
								if($searchsecondaryres['actual']  == 1)
								{
									$levelcounter = 2;
									$color = "orange; color:white;";
									$skiptext = "Warn";
									$searchyear = $searchconsecutiveres['year'];
									$searchmonth = ($searchconsecutiveres['month'] - 1);
									if(($searchconsecutiveres['month'] == 1) && ($searchconsecutiveres['year'] < 2019))
									{
										$searchyear = $mainres['year'] - 1;
										$searchmonth = 12;
									}
									$searchconsecutivesql2 = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
									$searchconsecutiveres2 = mysqli_fetch_assoc($searchconsecutivesql2);
									$searchtiertarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres2['id']." AND standard_id = ".$searchcolorres['standard_id']);
									$searchtiertaryres = mysqli_fetch_assoc($searchtiertarysql);
									if($searchtiertaryres['actual']  == 1)
									{
										$levelcounter = 3;
										$color = "red; color:white;";
										$skiptext = "NC";
										
									}
								}
							}
						}
						
						if($mainres['raw_score'] == 1)
						{
							if($findlevelres['subgoal'] == "Logistics")
							{
								if($levelcounter <= 2)
								{
									$levelcounter = 2;
									$color = "orange; color:white;";
									$skiptext = "Warn";
									$searchyear = $mainres['year'];
									$searchmonth = ($mainres['month'] - 1);
									if(($mainres['month'] == 1) && ($mainres['year'] < 2019))
									{
										$searchyear = $mainres['year'] - 1;
										$searchmonth = 12;
									}
									$searchconsecutivesql = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
									$searchconsecutiveres = mysqli_fetch_assoc($searchconsecutivesql);
									$searchsecondarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres['id']." AND standard_id = ".$searchcolorres['standard_id']);
									$searchsecondaryres = mysqli_fetch_assoc($searchsecondarysql);
									if($searchsecondaryres['actual']  == 1)
									{
										$levelcounter = 3;
										$color = "red; color:white;";
										$skiptext = "NC";
									}
								}
							}
							else
							{
								if($levelcounter <= 1)
								{
									$levelcounter = 1;
									$color = "yellow; color:black;";
									$skiptext = "Cond";
									$searchyear = $mainres['year'];
									$searchmonth = ($mainres['month'] - 1);
									if(($mainres['month'] == 1) && ($mainres['year'] < 2019))
									{
										$searchyear = $mainres['year'] - 1;
										$searchmonth = 12;
									}
									$searchconsecutivesql = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
									$searchconsecutiveres = mysqli_fetch_assoc($searchconsecutivesql);
									$searchsecondarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres['id']." AND standard_id = ".$searchcolorres['standard_id']);
									$searchsecondaryres = mysqli_fetch_assoc($searchsecondarysql);
									if($searchsecondaryres['actual']  == 1)
									{
										$levelcounter = 2;
										$color = "orange; color:white;";
										$skiptext = "Warn";
										$searchyear = $searchconsecutiveres['year'];
										$searchmonth = ($searchconsecutiveres['month'] - 1);
										if(($searchconsecutiveres['month'] == 1) && ($searchconsecutiveres['year'] < 2019))
										{
											$searchyear = $mainres['year'] - 1;
											$searchmonth = 12;
										}
										$searchconsecutivesql2 = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
										$searchconsecutiveres2 = mysqli_fetch_assoc($searchconsecutivesql2);
										$searchtiertarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres2['id']." AND standard_id = ".$searchcolorres['standard_id']);
										$searchtiertaryres = mysqli_fetch_assoc($searchtiertarysql);
										if($searchtiertaryres['actual']  == 1)
										{
											$levelcounter = 3;
											$color = "red; color:white;";
											$skiptext = "NC";
											
										}
									}
								}
							}
						}
						
					}
				}
				
				elseif($mainres['total_score'] == 555)
				{
					$color = "red; color:white;";					
					$skiptext = "NC";
				}
				elseif($mainres['total_score'] == 444)
				{
					$color = "orange; color:white;";
					$skiptext = "Warn";
					$searchyear = $mainres['year'];
					$searchmonth = ($mainres['month'] - 1);
					if(($mainres['month'] == 1) && ($mainres['year'] < 2019))
					{
						$searchyear = $mainres['year'] - 1;
						$searchmonth = 12;
					}
					$searchconsecutivesql = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
					$searchconsecutiveres = mysqli_fetch_assoc($searchconsecutivesql);
					$searchsecondarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres['id']." AND standard_id = ".$searchcolorres['standard_id']);
					$searchsecondaryres = mysqli_fetch_assoc($searchsecondarysql);
					if($searchsecondaryres['actual']  == 1)
					{
						$levelcounter = 3;
						$color = "red; color:white;";
						$skiptext = "NC";
					}
				}
				elseif($mainres['total_score'] == 333)
				{
					$color = "yellow; color:black;";
					$skiptext = "Cond";
					$searchyear = $mainres['year'];
					$searchmonth = ($mainres['month'] - 1);
					if(($mainres['month'] == 1) && ($mainres['year'] < 2019))
					{
						$searchyear = $mainres['year'] - 1;
						$searchmonth = 12;
					}
					$searchconsecutivesql = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
					$searchconsecutiveres = mysqli_fetch_assoc($searchconsecutivesql);
					$searchsecondarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres['id']." AND standard_id = ".$searchcolorres['standard_id']);
					$searchsecondaryres = mysqli_fetch_assoc($searchsecondarysql);
					if($searchsecondaryres['actual']  == 1)
					{
						$levelcounter = 2;
						$color = "orange; color:white;";
						$skiptext = "Warn";
						$searchyear = $searchconsecutiveres['year'];
						$searchmonth = ($searchconsecutiveres['month'] - 1);
						if(($searchconsecutiveres['month'] == 1) && ($searchconsecutiveres['year'] < 2019))
						{
							$searchyear = $mainres['year'] - 1;
							$searchmonth = 12;
						}
						$searchconsecutivesql2 = mysqli_query($conn, "SELECT * FROM cc_general WHERE bu = ".$mainres['bu']." AND year = ".$searchyear." AND month = ".$searchmonth." AND agency = ".$mainres['agency']);
						$searchconsecutiveres2 = mysqli_fetch_assoc($searchconsecutivesql2);
						$searchtiertarysql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$searchconsecutiveres2['id']." AND standard_id = ".$searchcolorres['standard_id']);
						$searchtiertaryres = mysqli_fetch_assoc($searchtiertarysql);
						if($searchtiertaryres['actual']  == 1)
						{
							$levelcounter = 3;
							$color = "red; color:white;";
							$skiptext = "NC";
							
						}
					}
				}
				else
				{
					$color = "white; color:red;";
					$skiptext = "SKIP";
					
				}
			}
			else
			{
				if(($mainres['total_score'] <= 100) && ($mainres['total_score'] >= 95))
				{
					$color = "blue; color:white;";
				}
				elseif(($mainres['total_score'] < 95) && ($mainres['total_score'] >= 85))
				{
					$color = "green; color:white;";
				}
				elseif(($mainres['total_score'] < 85) && ($mainres['total_score'] >= 75))
				{
					$color = "yellow; color:black;";
				}
				elseif(($mainres['total_score'] < 75) && ($mainres['total_score'] > 70))
				{
					$color = "orange; color:white;";
				}
				elseif($mainres['total_score'] <= 70)
				{
					$color = "red; color:white;";
				}
				else
				{
					$color = "white; color:red;";
					$skiptext = "SKIP";
					
				}
			}
			
			
			if($skiptext)
			{
				$score = $skiptext;
			}
			else
			{
				if($getYear > 2018)
				{
					$score = $mainres['raw_score'];
					//$score = $mainres['raw_score'] . "<br>(" .$mainres['total_score']."%)";
					//$score = "<table align='center' width='100%'><tr align='center'><td align='center' style='background-color:".$color." cursor:pointer;'>".$mainres['raw_score']."</td><td align='center' style='background-color:".$color." cursor:pointer;'>(" .$mainres['total_score']."%)</td></tr></table>";
				}
				else
				{
					$score = $mainres['total_score'];
				}
				
			}
			
		}
		else
		{
			$color = "gray; color:white;";
			$score = "PENDING";
		}
		
		$part1 = "<td style='background-color:".$color." cursor:pointer; font-weight:bold;' onclick=\"searchCCConsSA(".$mainres['month'];
		$part2 = $targetbu."','".$getYear."');\" >".$score."</td>";
		$part3 = "<td style='cursor:pointer; color:red' onclick='skipAgencyShow(".($mainres['month'] + 1).");'>X</td>";
		
		switch ($mainres['month'])
		{
			case 1:				
				$jan = $part1.",'January','".$part2;
				if($mainres['approved'] == 1) {$feb = $part3;}
				break;
			case 2:
				$feb = $part1.",'February','".$part2;
				if($mainres['approved'] == 1) {$mar = $part3;}
				break;
			case 3:
				$mar = $part1.",'March','".$part2;
				if($mainres['approved'] == 1) {$apr = $part3;}
				break;
			case 4:
				$apr = $part1.",'April','".$part2;
				if($mainres['approved'] == 1) {$may = $part3;}
				break;
			case 5:
				$may = $part1.",'May','".$part2;
				if($mainres['approved'] == 1) {$jun = $part3;}
				break;
			case 6:
				$jun = $part1.",'June','".$part2;
				if($mainres['approved'] == 1) {$jul = $part3;}
				break;
			case 7:
				$jul = $part1.",'July','".$part2;
				if($mainres['approved'] == 1) {$aug = $part3;}
				break;
			case 8:
				$aug = $part1.",'August','".$part2;
				if($mainres['approved'] == 1) {$sep = $part3;}
				break;
			case 9:
				$sep = $part1.",'September','".$part2;
				if($mainres['approved'] == 1) {$oct = $part3;}
				break;
			case 10:
				$oct = $part1.",'October','".$part2;
				if($mainres['approved'] == 1) {$nov = $part3;}
				break;
			case 11:
				$nov = $part1.",'November','".$part2;
				if($mainres['approved'] == 1) {$dec = $part3;}
				break;
			case 12:
				$dec = $part1.",'December','".$part2;
				break;
		}
	}
	
	if($existingrecord == 0)
	{
		$jan = "<td style='cursor:pointer; color:red' onclick='skipAgencyShow(1);'>X</td>";
	}
	
	$busql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$targetbu);
	$bures = mysqli_fetch_assoc($busql);
	
	$secagencydatalist = "";
	$secagencysql = mysqli_query($conn,"SELECT * FROM agency_mst ORDER BY agency_name");
	while($secagencyres = mysqli_fetch_assoc($secagencysql)){
		$secagencydatalist .= "<option value=\"".$secagencyres['id']."\">".$secagencyres['agency_name']."</option>";
	}

	
	$skiptable =	"<div id='divskipcc' name='divskipcc' style='display:none;'>" .
						"<br>" .
						"<table align='center'>" .
							"<tr>" .
								"<td>" .
									"<select id='selskipagency' name='selskipagency'>" .
										"<option value=''></option>" .
										$secagencydatalist .
									"</select>" .
								"</td>" .
								"<td>" .
									"<label style='color:blue; text-decoration:underline; cursor:pointer;' onclick='skipAgency();'>Skip</label>" .
									"<input type='hidden' id='txtskipbu' name='txtskipbu' value='".$targetbu."'>" .
									"<input type='hidden' id='txtskipmonth' name='txtskipmonth' >" .
									"<input type='hidden' id='txtskipyear' name='txtskipyear' value='".$getYear."'>" .
								"</td>" .
							"</tr>" .
						"</table>" .
					"</div>";
	
	$finalstatement =	"<br>".
						"<div style='padding-left:24px;'>".
						"<b>LEGEND:</b> (hover over score for details)".
				//		"<label style='background-color:yellow; font-weight:bold;'>CON</label> = Conditional, ".
				//		"<label style='background-color:orange; color:white; font-weight:bold;'>W</label> = Warning, ".
				//		"<label style='background-color:red; color:white; font-weight:bold;'>NC</label> = Non-compliant".
						"<br>".
						"<table border='1' style='border-collapse:collapse;'>".							
								"<tr align='center'>".
									"<td class='tooltip' style='background-color:#006400; color:white; font-weight:bold; width:75px;'>4.50 - 5.00".
										"<span class='tooltiptext'>The agency was able to significantly exceed the expected minimum contractual, operational, and regulatory requirements </span>".
									"</td>".
									
									"<td class='tooltip' style='background-color:#228B22; color:white; font-weight:bold; width:75px;'>4.00 - 4.49".
										"<span class='tooltiptext'>The agency was able to exceed the expected minimum contractual, operational, and regulatory requirements </span>".
									"</td>".
									
									"<td class='tooltip' style='background-color:#54C571; color:white; font-weight:bold; width:75px;'>3.00 - 3.99".
										"<span class='tooltiptext'>The agency was able to meet the minimum contractual, operational, and regulatory requirements </span>".
									"</td>".
									
									"<td class='tooltip' style='background-color:#DBF9DB; color:black; font-weight:bold; width:75px;'>2.00 - 2.99".
										"<span class='tooltiptext'>The agency was able to partially meet the minimum contractual and operational requirements, but compliant with regulatory requirements </span>".
									"</td>".
														
									"<td class='tooltip' style='background-color:yellow; font-weight:bold; width:75px;'>Cond".
										"<span class='tooltiptext'>".
											"<label align='center'>CONDITIONAL</label>".
											"<ul style='padding-inline-start:15px;'>".												
												"<li>First instance of:</li>".
												"<ul style='padding-inline-start:15px;'>".
													"<li>failing significantly to meet any of the contractual and operational requirements, but compliant in the regulatory requirements </li>".
													"<li>non-compliance in any of the low risk regulatory requirements:".
													"<ul style='padding-inline-start:15px;'>".
														"<li>Anti-Sexual Harrassment Policy</li>".
														"<li>Posting a Copy of the Safe Spaces Act</li>".
														"<li>Guideline/policy for drug-free workplace, HIV/AIDS, HEP-B, TB, and Mental Health</li>".
														"<li>Adoption of control measures to address long hours of sitting, standing or frequent walking</li>".
														"<li>Duty Detail Order (DDO)</li>".
														"<li>NLRC</li>".
													"</ul>".
												"</ul>".
											"</ul>".
										"</span>".
									"</td>".
								
									"<td class='tooltip' style='background-color:orange; color:white; font-weight:bold; width:75px;'>Warn".
										"<span class='tooltiptext'>".
											"<label align='center'>WARNING</label>".
											"<ul style='padding-inline-start:15px;'>".												
												"<li>Succeeding instance of Conditional</li>".
												"<li>First instance of:</li>".
												"<ul style='padding-inline-start:15px;'>".
													"<li>the agency getting a score of 1 in the Logistics section of the operatinal requirements:".
													"<ul style='padding-inline-start:15px;'>".
														"<li>Weapons/Ammunition</li>".
														"<li>Communication and other Equipment (ICT equipment)</li>".
														"<li>Transportation</li>".
													"</ul>".
													"<li>non-compliance in any of the medium risk regulatory requirements:</li>".
													"<ul style='padding-inline-start:15px;'>".
														"<li>Employment Status and Contract</li>".
														"<li>Annual Report (WAIR)</li>".
														"<li>Wage Order</li>".
														"<li>Employment work accident/illness exposure data; Acident or illness record and annual medical report</li>".
														"<li>BIR and SEC annual report</li>".
														"<li>BIR registered retirement fund</li>".
														"<li>NTC Radio and User Registration</li>".
														"<li>SG Medical Clearance, Neuro Test, and Drug Test</li>".
														"<li>Manpower</li>".
														"<li>Statutory Contribution</li>".
														"<li>Performance Bond and CGLI</li>".
													"</ul>".
												"</ul>".
											"</ul>".
										"</span>".
									"</td>".
									
									"<td class='tooltip' style='background-color:red; color:white; font-weight:bold; width:75px;'>NC".
										"<span class='tooltiptext'>".
											"<label align='center'>NON-COMPLIANT</label>".
											"<ul style='padding-inline-start:15px;'>".												
												"<li>Succeeding instance of Warning</li>".
												"<li>Non-compliance in any of the high risk regulatory requirements</li>".
												"<ul style='padding-inline-start:15px;'>".
													"<li>DOLE Registration (DO174)</li>".
													"<li>Rule 1020 OSHS Registration of Establishment</li>".
													"<li>Safety Officaer deployed in the facility</li>".
													"<li>BIR and SEC - Certificate of Registration</li>".
													"<li>SSS, PAG-IBIG, PhilHealth - Certificate of Registration</li>".
													"<li>PNP LTO</li>".
													"<li>PNP LTPF and FA Registration</li>".
													"<li>LGU Business Permit</li>".
													"<li>LESP</li>".
													"<li>NPC - Certificate of Registration</li>".
												"</ul>".
											"</ul>".
										"</span".
									"</td>".
								
								"</tr>".
						"</table>".
						
					//	"<br>".
						
						"<br><b>IMPORTANT NOTE:</b> Please SAVE before clicking another month or you will lose any unsaved progress.";$finalstatement =	"<br><b>LEGEND:</b> (hover over score for details)".
				//		"<label style='background-color:yellow; font-weight:bold;'>CON</label> = Conditional, ".
				//		"<label style='background-color:orange; color:white; font-weight:bold;'>W</label> = Warning, ".
				//		"<label style='background-color:red; color:white; font-weight:bold;'>NC</label> = Non-compliant".
						"</div>".
						"<br>".
						"<table border='1' style='border-collapse:collapse;'>".							
								"<tr align='center'>".
									"<td class='tooltip' style='background-color:#006400; color:white; font-weight:bold; width:75px;'>4.50 - 5.00".
										"<span class='tooltiptext'>The agency was able to significantly exceed the expected minimum contractual, operational, and regulatory requirements </span>".
									"</td>".
									
									"<td class='tooltip' style='background-color:#228B22; color:white; font-weight:bold; width:75px;'>4.00 - 4.49".
										"<span class='tooltiptext'>The agency was able to exceed the expected minimum contractual, operational, and regulatory requirements </span>".
									"</td>".
									
									"<td class='tooltip' style='background-color:#54C571; color:white; font-weight:bold; width:75px;'>3.00 - 3.99".
										"<span class='tooltiptext'>The agency was able to meet the minimum contractual, operational, and regulatory requirements </span>".
									"</td>".
									
									"<td class='tooltip' style='background-color:#DBF9DB; color:black; font-weight:bold; width:75px;'>2.00 - 2.99".
										"<span class='tooltiptext'>The agency was able to partially meet the minimum contractual and operational requirements, but compliant with regulatory requirements </span>".
									"</td>".
														
									"<td class='tooltip' style='background-color:yellow; font-weight:bold; width:75px;'>Cond".
										"<span class='tooltiptext'>".
											"<label align='center'>CONDITIONAL</label>".
											"<ul style='padding-inline-start:15px;'>".												
												"<li>First instance of:</li>".
												"<ul style='padding-inline-start:15px;'>".
													"<li>failing significantly to meet any of the contractual and operational requirements, but compliant in the regulatory requirements </li>".
													"<li>non-compliance in any of the low risk regulatory requirements:".
													"<ul style='padding-inline-start:15px;'>".
														"<li>Anti-Sexual Harrassment Policy</li>".
														"<li>Posting a Copy of the Safe Spaces Act</li>".
														"<li>Guideline/policy for drug-free workplace, HIV/AIDS, HEP-B, TB, and Mental Health</li>".
														"<li>Adoption of control measures to address long hours of sitting, standing or frequent walking</li>".
														"<li>Duty Detail Order (DDO)</li>".
														"<li>NLRC</li>".
													"</ul>".
												"</ul>".
											"</ul>".
										"</span>".
									"</td>".
								
									"<td class='tooltip' style='background-color:orange; color:white; font-weight:bold; width:75px;'>Warn".
										"<span class='tooltiptext'>".
											"<label align='center'>WARNING</label>".
											"<ul style='padding-inline-start:15px;'>".												
												"<li>Succeeding instance of Conditional</li>".
												"<li>First instance of:</li>".
												"<ul style='padding-inline-start:15px;'>".
													"<li>the agency getting a score of 1 in the Logistics section of the operatinal requirements:".
													"<ul style='padding-inline-start:15px;'>".
														"<li>Weapons/Ammunition</li>".
														"<li>Communication and other Equipment (ICT equipment)</li>".
														"<li>Transportation</li>".
													"</ul>".
													"<li>non-compliance in any of the medium risk regulatory requirements:</li>".
													"<ul style='padding-inline-start:15px;'>".
														"<li>Employment Status and Contract</li>".
														"<li>Annual Report (WAIR)</li>".
														"<li>Wage Order</li>".
														"<li>Employment work accident/illness exposure data; Acident or illness record and annual medical report</li>".
														"<li>BIR and SEC annual report</li>".
														"<li>BIR registered retirement fund</li>".
														"<li>NTC Radio and User Registration</li>".
														"<li>SG Medical Clearance, Neuro Test, and Drug Test</li>".
														"<li>Manpower</li>".
														"<li>Statutory Contribution</li>".
														"<li>Performance Bond and CGLI</li>".
													"</ul>".
												"</ul>".
											"</ul>".
										"</span>".
									"</td>".
									
									"<td class='tooltip' style='background-color:red; color:white; font-weight:bold; width:75px;'>NC".
										"<span class='tooltiptext'>".
											"<label align='center'>NON-COMPLIANT</label>".
											"<ul style='padding-inline-start:15px;'>".												
												"<li>Succeeding instance of Warning</li>".
												"<li>Non-compliance in any of the high risk regulatory requirements</li>".
												"<ul style='padding-inline-start:15px;'>".
													"<li>DOLE Registration (DO174)</li>".
													"<li>Rule 1020 OSHS Registration of Establishment</li>".
													"<li>Safety Officaer deployed in the facility</li>".
													"<li>BIR and SEC - Certificate of Registration</li>".
													"<li>SSS, PAG-IBIG, PhilHealth - Certificate of Registration</li>".
													"<li>PNP LTO</li>".
													"<li>PNP LTPF and FA Registration</li>".
													"<li>LGU Business Permit</li>".
													"<li>LESP</li>".
													"<li>NPC - Certificate of Registration</li>".
												"</ul>".
											"</ul>".
										"</span".
									"</td>".
								
								"</tr>".
						"</table>".
					//	"<br>".
						
						"<br><b>IMPORTANT NOTE:</b> Please SAVE before clicking another month or you will lose any unsaved progress.";
	
	$cctable =	"<table width='95%' border='1' style='border-collapse:collapse;' align='center'>" .
					"<tr><td style='background-color:red; color:white; cursor:pointer;' onclick='toggleConCom();' align='center'><u><- Back</u></td><th style='background-color:red; color:white;' colspan='100%'>".$bures['bu']." - Contract Compliance ".$getYear."</th></tr>" .
					"<tr class='whiteonblack'>" .
						"<th>Month</th>" .
						"<th>January</th>" .
						"<th>February</th>" .
						"<th>March</th>" .
						"<th>April</th>" .
						"<th>May</th>" .
						"<th>June</th>" .
						"<th>July</th>" .
						"<th>August</th>" .
						"<th>September</th>" .
						"<th>October</th>" .
						"<th>November</th>" .
						"<th>December</th>" .						
					"</tr>" .
					"<tr style='font-weight:bold;' align='center'>" .
						"<td>Score</td>" .
						$jan .
						$feb .
						$mar .
						$apr .
						$may .
						$jun .
						$jul .
						$aug .
						$sep .
						$oct .
						$nov .
						$dec .						
					"</tr>" .
				"</table>".$finalstatement."<br>".$skiptable."<br><div id='ccConsDisplaySubSpecific' name='ccConsDisplaySubSpecific'></div>";

	if(!empty($cctable))
	{
		echo $cctable;
	}
	else
	{
		echo "<tr><td colspan='100%' align='center'>No Existing Records.</td></tr>";
	}


?>