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
		
		$on_time = "<td>- - -</td>";

//	$mainsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ".$getYear." AND bu = ".$bu." AND approved = 1");
	$mainsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE year = ".$getYear." AND bu = ".$targetbu." ORDER BY month");
	while($mainres = mysqli_fetch_assoc($mainsql))
	{
		$on_time = "<td>- - -</td>";
		$existingrecord = 1;
		$skiptext = "";
		if($mainres['approved'] == 1)
		{
			if($getYear > 2018)
			{
				
			
				if(($mainres['total_score'] <= 100) && ($mainres['total_score'] >= 90))
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
				}
				elseif($mainres['total_score'] == 0)
				{
					$color = "red; color:white;";
					$skiptext = "NC";
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
					$score = $mainres['raw_score'] . "<br>(" .$mainres['total_score']."%)";
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
		
		if($mainres['approved_on'])
		{
			$comparedate = $mainres['approved_on'];
			$comparemonth = date("n", strtotime($mainres['approved_on']));
			$displaydate = date("m.d.Y", strtotime($mainres['approved_on']));
			if($comparemonth > ($mainres['month'] + 1))
			{
				$on_time = "<td style='background-color:red; color:white;'>".$displaydate."</td>";
			}
			else
			{
				$on_time = "<td >".$displaydate."</td>";
			}			
		}
		
		
		switch ($mainres['month'])
		{
			case 1:				
				$jan = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(1,'January','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$feb = "<td style='cursor:pointer;' onclick=\"searchItem(2,'February','ConCompAdmin');\">+</td>";}
				$jan2 = $on_time;
				break;
			case 2:
				$feb = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(2,'February','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$mar = "<td style='cursor:pointer;' onclick=\"searchItem(3,'March','ConCompAdmin');\">+</td>";}
				$feb2 = $on_time;
				break;
			case 3:
				$mar = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(3,'March','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$apr = "<td style='cursor:pointer;' onclick=\"searchItem(4,'April','ConCompAdmin');\">+</td>";}
				$mar2 = $on_time;
				break;
			case 4:
				$apr = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(4,'April','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$may = "<td style='cursor:pointer;' onclick=\"searchItem(5,'May','ConCompAdmin');\">+</td>";}
				$apr2 = $on_time;
				break;
			case 5:
				$may = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(5,'May','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$jun = "<td style='cursor:pointer;' onclick=\"searchItem(6,'June','ConCompAdmin');\">+</td>";}
				$may2 = $on_time;
				break;
			case 6:
				$jun = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(6,'June','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$jul = "<td style='cursor:pointer;' onclick=\"searchItem(7,'July','ConCompAdmin');\">+</td>";}
				$jun2 = $on_time;
				break;
			case 7:
				$jul = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(7,'July','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$aug = "<td style='cursor:pointer;' onclick=\"searchItem(8,'August','ConCompAdmin');\">+</td>";}
				$jul2 = $on_time;
				break;
			case 8:
				$aug = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(8,'August','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$sep = "<td style='cursor:pointer;' onclick=\"searchItem(9,'September','ConCompAdmin');\">+</td>";}
				$aug2 = $on_time;
				break;
			case 9:
				$sep = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(9,'September','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$oct = "<td style='cursor:pointer;' onclick=\"searchItem(10,'October','ConCompAdmin');\">+</td>";}
				$sep2 = $on_time;
				break;
			case 10:
				$oct = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(10,'October','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$nov = "<td style='cursor:pointer;' onclick=\"searchItem(11,'November','ConCompAdmin');\">+</td>";}
				$oct2 = $on_time;
				break;
			case 11:
				$nov = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(11,'November','ConCompAdmin');\">".$score."</td>";
				if($mainres['approved'] == 1) {$dec = "<td style='cursor:pointer;' onclick=\"searchItem(12,'December','ConCompAdmin');\">+</td>";}
				$nov2 = $on_time;
				break;
			case 12:
				$dec = "<td style='background-color:".$color." cursor:pointer;' onclick=\"searchItem(12,'December','ConCompAdmin');\">".$score."</td>";
				$dec2 = $on_time;
				break;
		}
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
	
	$kpistatement =	"<tr style='font-weight:bold;' align='center'>" .
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
	}
	
	$cctable =	"<table width='100%' border='1' style='border-collapse:collapse;'>" .
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
					$kpistatement .
				"</table>" . $finalstatement;

	if(!empty($cctable))
	{
		echo $cctable;
	}
	else
	{
		echo "<tr><td colspan='100%' align='center'>No Existing Records.</td></tr>";
	}


?>