<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");
	
	$targetIAyear = $_GET['IAyear'];
	
	$resulttable = "";
	$burow = "";
	
	$mainIAsql = mysqli_query($conn, "SELECT DISTINCT bu_id FROM incident_accuracy_mst WHERE year = ".$targetyear" ORDER BY bu_id")
	while($mainIAres = mysqli_fetch_assoc($mainIAsql))  // BU LOOP
	{
		$bumamesql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id =".$mainIAres['bu_id']);
		$bunameres = mysqli_fetch_assoc($bunamesql);
		
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
		
		$total_miss = 0;
		$total_total = 0;
		
		$totalrow = "";
		$missrow = "";
		$percentrow = "";
		$kpirowsql = mysqli_query($conn, "SELECT * FROM incident_accuracy_mst WHERE bu_id = ".$mainIAres['bu_id']." ORDER BY month") // KPI LOOP
		while($mainres = mysqli_fetch_assoc($kpirowsql))
		{
			$score = round(((($mainres['total'] - $mainres['miss']) / $mainres['total']) * 100), 2);
		
			$total_miss += $mainres['miss'];
			$total_total += $mainres['total'];
			
			if($mainres['miss'] > 0)
			{
				$color2 = "color:red;";
			}
			
			if(($score <= 100) && ($score >= 90))
			{
				$color = "purple; color:white;";				
			}
			elseif(($score < 90) && ($score >= 80))
			{
				$color = "blue; color:white;";				
			}
			elseif(($score < 80) && ($score >= 76))
			{
				$color = "green; color:white;";				
			}
			elseif(($score < 76) && ($score > 70))
			{
				$color = "orange; color:white;";				
			}
			elseif(($score <= 70) && ($score > 0))
			{
				$color = "red; color:white;";				
			}
			
			switch ($mainres['month'])
			{
				case 1:				
					$jan = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$jan2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$jan3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 2:
					$feb = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$feb2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$feb3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 3:
					$mar = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$mar2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$mar3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 4:
					$apr = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$apr2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$apr3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 5:
					$may = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$may2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$may3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 6:
					$jun = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$jun2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$jun3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 7:
					$jul = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$jul2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$jul3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 8:
					$aug = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$aug2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$aug3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 9:
					$sep = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$sep2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$sep3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 10:
					$oct = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$oct2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$oct3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 11:
					$nov = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$nov2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$nov3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";
					break;
				case 12:
					$dec = "<td style='background-color:".$color." cursor:pointer;'>".$score."</td>";
					$dec2 = "<td style='cursor:pointer;' >".$mainres['total']."</td>";
					$dec3 = "<td style='".$color2." cursor:pointer;'>".$mainres['miss']."</td>";	//				
					break;
			}
			
		}
		
		$running = 0;
		if($total_total > 0)
		{
			$running = round(((($total_total - $total_miss) / $total_total) * 100), 2);
		}
		
		if(($running <= 100) && ($running >= 90))
		{
			$color3 = "background-color:purple; color:white;";
		}
		elseif(($running < 90) && ($running >= 80))
		{
			$color3 = "background-color:blue; color:white;";
		}
		elseif(($running < 80) && ($running >= 76))
		{
			$color3 = "background-color:green; color:white;";
		}
		elseif(($running < 76) && ($running > 70))
		{
			$color3 = "background-color:orange; color:white;";
		}
		elseif(($running <= 70) && ($running > 0))
		{
			$color3 = "background-color:red; color:white;";
		}
		
		$burow .=	"<tr style='font-weight:bold;' align='center'>
						<td rowspan='3'>".$bunameres['bu']."</td>".
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
						"<td valign='center' rowspan='3' style='font-size:3em; ".$color3."'>".$running."</td>" .
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
					"</tr>"
					"<tr>"
						"<td colspan='100%' style='background-color:#ededed;'></td>"
					"</tr>";
	}
	
	if($burow)
	{
		$resulttable =	"<table width='100%' border='1' style='border-collapse:collapse;'>" .
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
							$burow .
						"</table>";
	}
	
if($resulttable)
{
	echo $resulttable;	
}
else
{
	echo "Something went wrong.";
}
	
?>