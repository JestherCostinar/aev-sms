<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");

	$getYear = mysqli_real_escape_string($conn, $_GET['year']);
	
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
	$cc_agency_row = "";
	$cc_bu_row = "";
		
	$currentYear = date("Y"); 
	$currentMonth = date("m");
	$listOfBU = array();

	if($_SESSION['multi-admin']) {
		$listOfIDQuery = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id ='" . $_SESSION['id'] . "'");
		$buCount = 0;
		while ($list = mysqli_fetch_assoc($listOfIDQuery)) {
			$listOfBU[$buCount] = $list['bu_id'];
			$buCount++;
		}
	}

	// $startsql = mysqli_query($conn, "SELECT * FROM agency_mst WHERE contract_status = 'Active' ORDER BY agency_name");
	if($_SESSION['multi-admin']) {
		$startsql = mysqli_query($conn, "SELECT DISTINCT a.id, a.agency_name, a.contract_status FROM agency_mst a LEFT JOIN agency_bu b ON a.id = b.agency_id WHERE b.bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ") ORDER BY b.bu_id, a.id");
	} else {
		$startsql = mysqli_query($conn, "SELECT DISTINCT a.id, a.agency_name, a.contract_status FROM agency_mst a LEFT JOIN agency_bu b ON a.id = b.agency_id ORDER BY b.bu_id, a.id");
	}

	while($startres = mysqli_fetch_assoc($startsql))
	{
		$cc_bu_row = "";
		$has_score = 0;
		if($_SESSION['multi-admin']) {
			$agencybusql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND agency_id = ".$startres['id']);
		} else {
			$agencybusql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE agency_id = ".$startres['id']);
		}
		$agencybucount = mysqli_num_rows($agencybusql);
		while($agencybures = mysqli_fetch_assoc($agencybusql))
		{
			
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
			
			// Select all from cc_general and Remove from the database the date exceed in the current month.
			// For all BU's
			// $validateCompliance = mysqli_query($conn, "DELETE FROM cc_general WHERE year = " . $currentYear . " AND month > " . $currentMonth . "");
			// For Magat only
			// $validateCompliance = mysqli_query($conn, "DELETE FROM cc_general WHERE year = " . $currentYear . " AND month > " . $currentMonth . " AND bu = 33");
			// $approvedComplianceForEastAsia = mysqli_query($conn, "UPDATE cc_general SET approved = '1' WHERE year = '2022' AND month = '1' AND bu = '14'");

			$mainsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ".$getYear." AND bu = ".$agencybures['bu_id']." AND agency = ".$startres['id']." ORDER BY month, approved, id");
			while($mainres = mysqli_fetch_assoc($mainsql))
			{
				$skiptext = "";
				$existingrecord = 1;
				if($mainres['approved'] == 1)
				{
					if($getYear >= 2019)
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
								elseif(($mainres['raw_score'] < 2) && ($mainres['raw_score'] > 1))
								{
									$color = "red; color:white;";
									$color2 = "white; color:red;";
								}
							}
					//		elseif($mainres['total_score'] == 0)
							elseif(($mainres['total_score'] == 0) || ($mainres['total_score'] == 1))
							{
								$color = "red; color:white;";
							//	$skiptext = "NC" . "<br>(" .$mainres['raw_score'].")";
								$skiptext = "NC";
								$levelcounter = 0;
								$searchcolorsql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$mainres['id']." AND actual = 1");
								while($searchcolorres = mysqli_fetch_assoc($searchcolorsql))
								{
									//$searchconsecutivesql = mysqli_query($conn, "SELECT * FROM cc_specific WHERE cc_id = ".$mainres['id']." AND actual = 1");
									
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
								//$skiptext = "NC" . "<br>(" .$mainres['raw_score'].")";
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
							//	$color = "white; color:red;";
								$color = "white; color:black;";
							//	$skiptext = "SKIP";
								$skiptext = "---";
								
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
						//	$color = "white; color:red;";
						//	$skiptext = "SKIP";
							$color = "white; color:black;";
							$skiptext = "---";
							
						}
					}
					
					
					if($skiptext)
					{
//						$score = $skiptext . "<br>(" .$mainres['raw_score'].")";
						$score = $skiptext;
					}
					else
					{
						if($getYear > 2018)
						{
							$score = $mainres['raw_score'];
							//$score = $mainres['raw_score'] . "<br>(" .$mainres['total_score']."%)";
							//score = "<table align='center' width='100%'><tr align='center'><td align='right' style='background-color:".$color." cursor:pointer;'>".$mainres['raw_score']."</td><td align='left' style='background-color:".$color." cursor:pointer;'>(" .$mainres['total_score']."%)</td></tr></table>";
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
				
				
				switch ($mainres['month'])
				{
					case 1:				
						$jan = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 2:
						$feb = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 3:
						$mar = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 4:
						$apr = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 5:
						$may = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 6:
						$jun = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 7:
						$jul = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 8:
						$aug = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 9:
						$sep = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 10:
						$oct = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 11:
						$nov = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
					case 12:
						$dec = "<td style='background-color:".$color." font-weight:bold;' >".$score."</td>";
						$has_score = 1;
						break;
				}
			}
			
			$bunamesql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$agencybures['bu_id']);
			$bunameres = mysqli_fetch_assoc($bunamesql);
			
			$viewtoken = md5($getYear + $agencybures['bu_id'] + $startres['id']);
			if($_SESSION['multi-admin']) {
				$cc_bu_row .= "<td style='color:blue; cursor:pointer;' onclick=\"searchCCConsSub('".$getYear."', '".$agencybures['bu_id']."')\"><u>".$bunameres['bu']."</u></td>".$jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep.$oct.$nov.$dec."</tr><tr align='center'>";
			} else {
				$cc_bu_row .= "<td><a href='".$url_base2."/checkstatus.php?to=".$viewtoken."&bu=".$agencybures['bu_id']."&sa=".$startres['id']."&san=".$startres['agency_name']."&bun=".$bunameres['bu']."&ye=".$getYear."' target='_blank'>Status</a></td><td style='color:blue; cursor:pointer;' onclick=\"searchCCConsSub('".$getYear."', '".$agencybures['bu_id']."')\"><u>".$bunameres['bu']."</u></td>".$jan.$feb.$mar.$apr.$may.$jun.$jul.$aug.$sep.$oct.$nov.$dec."</tr><tr align='center'>";
			}
		}
//		if($has_score == 1 OR $startres['contract_status'] == "Active")
		if($has_score == 1)
		{
			$cc_agency_row .= "<tr style='font-weight:bold;' align='center'><td rowspan='".$agencybucount."' onclick='this.parentNode.parentNode.removeChild(this.parentNode)'>".$startres['agency_name']."</td>".$cc_bu_row."</tr><tr><td class='altrows' colspan='100%' style='color:white;'>-</td></tr>";
		}
	}
	
	if($_SESSION['multi-admin']) {
		$cctable =	"<table width='95%' border='1' style='border-collapse:collapse;' align='center'>" .
		"<tr style='background-color:red; color:white;'>" .
			"<th colspan='100%'>AEV-PAS Contract Compliance ".$getYear." Submission</th>" .
		"</tr>" .
		"<tr class='whiteonblack'>" .
			"<th class='altrows'></th>" .
			"<th class='altrows'></th>" .
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
		$cc_agency_row .
	"</table>";
	} else {
		$cctable =	"<table width='95%' border='1' style='border-collapse:collapse;' align='center'>" .
					"<tr style='background-color:red; color:white;'>" .
						"<th colspan='100%'>AEV-PAS Contract Compliance ".$getYear." Submission</th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th class='altrows'></th>" .
						"<th class='altrows'></th>" .
						"<th class='altrows'></th>" .
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
					$cc_agency_row .
				"</table>";
	}
	if(!empty($cctable))
	{
		echo $cctable;
	}
	else
	{
		echo "<tr><td colspan='100%' align='center'>No Existing Records.</td></tr>";
	}


?>