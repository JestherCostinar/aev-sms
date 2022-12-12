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
	$targetbu = $bu;
	if($_GET['bu'])
	{
		$targetbu =  mysqli_real_escape_string($conn, $_GET['bu']);
	}
	else
	{
		$targetbu = $bu;
	}
	
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
		
		$jan3 = "<td>- - -</td>";
		$feb3 = "<td>- - -</td>";
		$mar3 = "<td>- - -</td>";
		$apr3 = "<td>- - -</td>";
		$may3 = "<td>- - -</td>";
		$jun3 = "<td>- - -</td>";
		$jul3 = "<td>- - -</td>";
		$aug3 = "<td>- - -</td>";
		$sep3 = "<td>- - -</td>";
		$oct3 = "<td>- - -</td>";
		$nov3 = "<td>- - -</td>";
		$dec3 = "<td>- - -</td>";
		
		$on_time = "<td>- - -</td>";
		$total_miss = 0;
		$total_total = 0;

//	$mainsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ".$getYear." AND bu = ".$bu." AND approved = 1");
//	$mainsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ".$getYear." AND bu = ".$targetbu." ORDER BY month");
	$mainsql = mysqli_query($conn, "SELECT * FROM incident_accuracy_mst WHERE year = ".$getYear." AND bu_id = ".$targetbu." ORDER BY month");
	while($mainres = mysqli_fetch_assoc($mainsql))
	{
		$on_time = "<td>- - -</td>";
		$existingrecord = 1;
		$skiptext = "";
		$color = "gray; color:black;";
		$color2 = "gray; color:black;";
		$score = round(((($mainres['total'] - $mainres['miss']) / $mainres['total']) * 100), 2);
		
		$total_miss += $mainres['miss'];
		$total_total += $mainres['total'];
		
		if($mainres['miss'] > 0)
		{
			$color2 = "color:red;";
		}
		
		// if($mainres['approved'] == 1)
		// {
			// if($getYear > 2018)
			// {
				
			
				if(($score <= 100) && ($score >= 90))
				{
					$color = "purple; color:white;";
					//$color2 = "white; color:purple;";
				}
				elseif(($score < 90) && ($score >= 80))
				{
					$color = "blue; color:white;";
					//$color2 = "white; color:blue;";
				}
				elseif(($score < 80) && ($score >= 76))
				{
					$color = "green; color:white;";
					//$color2 = "white; color:green;";
				}
				elseif(($score < 76) && ($score > 70))
				{
					$color = "orange; color:white;";
					//$color2 = "white; color:orange;";
				}
				elseif(($score <= 70) && ($score > 0))
				{
					$color = "red; color:white;";
					//$color2 = "white; color:red;";
				}
				// elseif($mainres['total_score'] == 0)
				// {
					// $color = "red; color:white;";
					// $skiptext = "NC";
				// }
				// else
				// {
					// $color = "white; color:red;";
					// $skiptext = "SKIP";
					
				// }
			// }
			// else
			// {
				// if(($mainres['total_score'] <= 100) && ($mainres['total_score'] >= 95))
				// {
					// $color = "blue; color:white;";
				// }
				// elseif(($mainres['total_score'] < 95) && ($mainres['total_score'] >= 85))
				// {
					// $color = "green; color:white;";
				// }
				// elseif(($mainres['total_score'] < 85) && ($mainres['total_score'] >= 75))
				// {
					// $color = "yellow; color:black;";
				// }
				// elseif(($mainres['total_score'] < 75) && ($mainres['total_score'] > 70))
				// {
					// $color = "orange; color:white;";
				// }
				// elseif($mainres['total_score'] <= 70)
				// {
					// $color = "red; color:white;";
				// }
				// else
				// {
					// $color = "white; color:red;";
					// $skiptext = "SKIP";
				// }	
			// }
			
			// if($skiptext)
			// {
				// $score = $skiptext;
			// }
			// else
			// {
				// if($getYear > 2018)
				// {
					// $score = $mainres['raw_score'] . "<br>(" .$mainres['total_score']."%)";
				//	$score = "<table align='center' width='100%'><tr align='center'><td align='center' style='background-color:".$color." cursor:pointer;'>".$mainres['raw_score']."</td><td align='center' style='background-color:".$color." cursor:pointer;'>(" .$mainres['total_score']."%)</td></tr></table>";
				// }
				// else
				// {
					// $score = $mainres['total_score'];
				// }
				
			// }
			
		// }
		// else
		// {
			// $color = "gray; color:white;";
			// $score = "PENDING";
		// }
		
		// if($mainres['approved_on'])
		// {
			// $comparedate = $mainres['approved_on'];
			// $comparemonth = date("n", strtotime($mainres['approved_on']));
			// $displaydate = date("m.d.Y", strtotime($mainres['approved_on']));
			// if($comparemonth > ($mainres['month'] + 1))
			// {
				// $on_time = "<td style='background-color:red; color:white;'>".$displaydate."</td>";
			// }
			// else
			// {
				// $on_time = "<td >".$displaydate."</td>";
			// }			
		// }
		
		
		
		switch ($mainres['month'])
		{
			case 1:				
				$jan = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$jan2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$jan3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$feb = "<td style='cursor:pointer;' onclick=\"searchItem(2,'February','ConCompAdmin');\">+</td>";}
				$jan2 = $on_time; */
				break;
			case 2:
				$feb = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$feb2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$feb3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$mar = "<td style='cursor:pointer;' onclick=\"searchItem(3,'March','ConCompAdmin');\">+</td>";}
				$feb2 = $on_time; */
				break;
			case 3:
				$mar = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$mar2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$mar3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$apr = "<td style='cursor:pointer;' onclick=\"searchItem(4,'April','ConCompAdmin');\">+</td>";}
				$mar2 = $on_time; */
				break;
			case 4:
				$apr = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$apr2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$apr3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$may = "<td style='cursor:pointer;' onclick=\"searchItem(5,'May','ConCompAdmin');\">+</td>";}
				$apr2 = $on_time; */
				break;
			case 5:
				$may = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$may2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$may3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$jun = "<td style='cursor:pointer;' onclick=\"searchItem(6,'June','ConCompAdmin');\">+</td>";}
				$may2 = $on_time; */
				break;
			case 6:
				$jun = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$jun2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$jun3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$jul = "<td style='cursor:pointer;' onclick=\"searchItem(7,'July','ConCompAdmin');\">+</td>";}
				$jun2 = $on_time; */
				break;
			case 7:
				$jul = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$jul2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$jul3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$aug = "<td style='cursor:pointer;' onclick=\"searchItem(8,'August','ConCompAdmin');\">+</td>";}
				$jul2 = $on_time; */
				break;
			case 8:
				$aug = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$aug2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$aug3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$sep = "<td style='cursor:pointer;' onclick=\"searchItem(9,'September','ConCompAdmin');\">+</td>";}
				$aug2 = $on_time; */
				break;
			case 9:
				$sep = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$sep2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$sep3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$oct = "<td style='cursor:pointer;' onclick=\"searchItem(10,'October','ConCompAdmin');\">+</td>";}
				$sep2 = $on_time; */
				break;
			case 10:
				$oct = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$oct2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$oct3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$nov = "<td style='cursor:pointer;' onclick=\"searchItem(11,'November','ConCompAdmin');\">+</td>";}
				$oct2 = $on_time; */
				break;
			case 11:
				$nov = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$nov2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$nov3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
				/* if($mainres['approved'] == 1) {$dec = "<td style='cursor:pointer;' onclick=\"searchItem(12,'December','ConCompAdmin');\">+</td>";}
				$nov2 = $on_time; */
				break;
			case 12:
				$dec = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
				$dec2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
				$dec3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
//				$dec2 = $on_time;
				break;
		}
	}
	
	$running = 0;
	if($total_total > 0)
	{
		$running = round(((($total_total - $total_miss) / $total_total) * 100), 2);
	}
	
	if($existingrecord == 0)
	{
		$jan = "<td style='cursor:pointer;' onclick=\"searchItem(1,'January','ConCompAdmin');\">+</td>";
		/* $feb = "<td style='cursor:pointer;' onclick=\"searchItem(2,'February','ConCompAdmin');\">+</td>";
		$mar = "<td style='cursor:pointer;' onclick=\"searchItem(3,'March','ConCompAdmin');\">+</td>";
		$apr = "<td style='cursor:pointer;' onclick=\"searchItem(4,'April','ConCompAdmin');\">+</td>";
		$may = "<td style='cursor:pointer;' onclick=\"searchItem(5,'May','ConCompAdmin');\">+</td>";
		$jun = "<td style='cursor:pointer;' onclick=\"searchItem(6,'June','ConCompAdmin');\">+</td>";
		$jul = "<td style='cursor:pointer;' onclick=\"searchItem(7,'July','ConCompAdmin');\">+</td>";
		$aug = "<td style='cursor:pointer;' onclick=\"searchItem(8,'August','ConCompAdmin');\">+</td>";
		$sep = "<td style='cursor:pointer;' onclick=\"searchItem(9,'September','ConCompAdmin');\">+</td>";
		$oct = "<td style='cursor:pointer;' onclick=\"searchItem(10,'October','ConCompAdmin');\">+</td>";
		$nov = "<td style='cursor:pointer;' onclick=\"searchItem(11,'November','ConCompAdmin');\">+</td>";
		$dec = "<td style='cursor:pointer;' onclick=\"searchItem(12,'December','ConCompAdmin');\">+</td>"; */
	}
	else
	{
		
	}
	
	/* $kpistatement =	"<tr style='font-weight:bold;' align='center'>" .
						"<td>Closed on:</td>" .
						$jan2 .
						$feb2 .
						$mar2 .
						$apr2 .
						$may2 .
						$jun2 .
						$jul2 .
						$aug2 .
						$sep2 .
						$oct2 .
						$nov2 .
						$dec2 .						
					"</tr>";
	$finalstatement = "<br><b>IMPORTANT NOTE:</b> Please SAVE before clicking another month or you will lose any unsaved progress.";
	
	if($KPItoken == 1)
	{
		$finalstatement = "";
	} */
	
	if(($running <= 100) && ($running >= 90))
	{
		$color3 = "background-color:purple; color:white;";
		//$color2 = "white; color:purple;";
	}
	elseif(($running < 90) && ($running >= 80))
	{
		$color3 = "background-color:blue; color:white;";
		//$color2 = "white; color:blue;";
	}
	elseif(($running < 80) && ($running >= 76))
	{
		$color3 = "background-color:green; color:white;";
		//$color2 = "white; color:green;";
	}
	elseif(($running < 76) && ($running > 70))
	{
		$color3 = "background-color:orange; color:white;";
		//$color2 = "white; color:orange;";
	}
	elseif(($running <= 70) && ($running > 0))
	{
		$color3 = "background-color:red; color:white;";
		//$color2 = "white; color:red;";
	}
	
	if($running <= 61)
	{
		$numformula = ($running/61) + 1;
		//$numformula = 1 + (($completionformula * (100/60))/100);
	}
	elseif($running > 61 && $running <= 76)
	{
		$numformula = (($running - 61)/15) + 2;
		//$numformula = 2 + (($completionformula * (100/76))/100);
	}
	elseif($running > 76)
	{
		$numformula = (($running - 76)/24) * 2 + 3;
	}
	$numrate = number_format(($numformula),2,'.',',');
	
	$cctable =	"<table width='100%' border='1' style='border-collapse:collapse;'>" .
					"<tr class='whiteonblack'>" .
						"<th>Month</th>" .
						"<th>Jan</th>" .
						"<th>Feb</th>" .
						"<th>Mar</th>" .
						"<th>Apr</th>" .
						"<th>May</th>" .
						"<th>Jun</th>" .
						"<th>Jul</th>" .
						"<th>Aug</th>" .
						"<th>Sep</th>" .
						"<th>Oct</th>" .
						"<th>Nov</th>" .
						"<th>Dec</th>" .
						"<th>Running Total</th>" .
					"</tr>" .
					"<tr style='font-weight:bold;' align='center'>" .
						"<td>Incidents</td>" .
						$jan2 .
						$feb2 .
						$mar2 .
						$apr2 .
						$may2 .
						$jun2 .
						$jul2 .
						$aug2 .
						$sep2 .
						$oct2 .
						$nov2 .
						$dec2 .
					//	"<td valign='center' rowspan='3' style='font-size:3em; ".$color3."'>".$running."</td>" .
						"<td valign='center' rowspan='3' style='font-size:2em; ".$color3."'>".$numrate." </br> (".$running."%)</td>" .
					"</tr>" .
					"<tr style='font-weight:bold;' align='center'>" .
						"<td>Miss</td>" .
						$jan3 .
						$feb3 .
						$mar3 .
						$apr3 .
						$may3 .
						$jun3 .
						$jul3 .
						$aug3 .
						$sep3 .
						$oct3 .
						$nov3 .
						$dec3 .						
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
					
				"</table>";

	if(!empty($cctable))
	{
		echo $cctable;
	}
	else
	{
		echo "<tr><td colspan='100%' align='center'>No Existing Records.</td></tr>";
	}


?>