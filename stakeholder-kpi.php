<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");
	
	$notstake = 0;
	$instake = 0;
	$donestake = 0;
	$totalstake = 0;
	$stakeyear = $_GET['year'];
	
	$mainstakesql = mysqli_query($conn, "SELECT * FROM stakeholder_mst_new WHERE bu_id = ".$bu." AND year = ".$stakeyear)or die(mysqli_error($conn));
	$mainstakeres = mysqli_fetch_assoc($mainstakesql);	
	$totalstake = mysqli_num_rows($mainstakesql);
	
	$completionrate = $mainstakeres['score'];
	//$completionrate = number_format((($donestake/$totalstake)*100),2,'.',',');
		
	/* $mainstakesql = mysqli_query($conn, "SELECT * FROM stakeholder_mst WHERE bu_id = ".$bu)or die(mysqli_error($conn));
	$mainstakeres = mysqli_fetch_assoc($mainstakesql);	
	$totalstake = mysqli_num_rows($mainstakesql);
	
	$notstakesql = mysqli_query($conn, "SELECT * FROM stakeholder_mst WHERE bu_id = ".$bu." AND status = 'Not Started' AND stakeyear = ".$stakeyear)or die(mysqli_error($conn));
	$notstakeres = mysqli_fetch_assoc($notstakesql);	
	$notstake = mysqli_num_rows($notstakesql);
	
	$instakesql = mysqli_query($conn, "SELECT * FROM stakeholder_mst WHERE bu_id = ".$bu." AND status = 'In Progress' AND stakeyear = ".$stakeyear)or die(mysqli_error($conn));
	$instakeres = mysqli_fetch_assoc($instakesql);	
	$instake = mysqli_num_rows($instakesql);
	
	$donestakesql = mysqli_query($conn, "SELECT * FROM stakeholder_mst WHERE bu_id = ".$bu." AND status = 'Done' AND stakeyear = ".$stakeyear)or die(mysqli_error($conn));
	$donestakeres = mysqli_fetch_assoc($donestakesql);	
	$donestake = mysqli_num_rows($donestakesql); */
	
	/* $completionformula = ($donestake/$totalstake)*100;
	$completionrate = number_format((($donestake/$totalstake)*100),2,'.',',');
	//$completionformula = 90;
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
	//$numformula = 1 + (($completionrate * (60/100))/100);
	$numrate = number_format(($numformula),2,'.',','); */
	//$numrate = $numformula;
	
	/* $IDPDisplay =	"<br><table align='center' border='1' style='border-collapse:collapse; margin-top:9px;'>" .
						"<tr>" .
							"<th class='whiteonblack'>Not Started</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='center'><label style='font-weight:bold;; font-size:1.5em;'>".$notstake."</label></td>" .							
						"</tr>" .
						"<tr>" .
							"<th class='whiteonblack'>In Progress</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='center'><label style='font-weight:bold;; font-size:1.5em;'>".$instake."</label></td>" .							
						"</tr>" .
						"<tr>" .
							"<th class='whiteonblack'>Done</th>" .
						"</tr>" .
						"<tr>" .							
							"<td align='center'><label style='font-weight:bold; font-size:1.5em;'>".$donestake."</label></td>" .
						"</tr>" .
						"<tr>" .
							"<th class='whiteonblack' colspan='100%'>Completion Rate</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='center' colspan='100%'><label style='font-weight:bold; font-size:2em; color:red;'>".$completionrate."%</label></td>" .
						"</tr>" .
					"</table>"; */
	/* if(($completionrate <= 100) && ($completionrate >= 90))
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
	} */
	
	if(($completionrate <= 5) && ($completionrate >= 4.5))
	{
		$color = "background-color:purple; color:white;";
		//$color2 = "white; color:purple;";
	}
	elseif(($completionrate < 4.5) && ($completionrate >= 4))
	{
		$color = "background-color:blue; color:white;";
		//$color2 = "white; color:blue;";
	}
	elseif(($completionrate < 4) && ($completionrate >= 3))
	{
		$color = "background-color:green; color:white;";
		//$color2 = "white; color:green;";
	}
	elseif(($completionrate < 3) && ($completionrate > 2))
	{
		$color = "background-color:orange; color:white;";
		//$color2 = "white; color:orange;";
	}
	elseif(($completionrate <= 2) && ($completionrate > 0))
	{
		$color = "background-color:red; color:white;";
		//$color2 = "white; color:red;";
	}
	
	$datedisplay = date('Y-m-d H:i',strtotime('+8 hours',strtotime($mainstakeres['date_saved'])));
	
	$IDPDisplay =	"<br><table width='95%' align='center' border='1' style='border-collapse:collapse; margin-top:9px;'>" .
						"<tr>" .
							"<th class='whiteonblack'>SCORE</th>" .
							"<th class='whiteonblack'>Last Updated On</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='center' width='50%' style='".$color."'><label style='font-weight:bold;; font-size:2em;'>".$completionrate."</label></td>" .
							"<td align='center' width='50%'><label>".$datedisplay."</label></td>" .
							/* "<td align='center' width='20%'><label style='font-weight:bold;; font-size:2em;'>".$notstake."</label></td>" .
							"<td align='center' width='20%'><label style='font-weight:bold;; font-size:2em;'>".$instake."</label></td>" .
							"<td align='center' width='20%'><label style='font-weight:bold; font-size:2em;'>".$donestake."</label></td>" . */
							//"<td align='center' width='40%' style='".$color."'><label style='font-weight:bold; font-size:3em;'>".$completionrate."%</label></td>" .
							//"<td align='center' width='40%' style='".$color."'><label style='font-weight:bold; font-size:2em;'>".$numrate." (".$completionrate."%)</label></td>" .
							//"<td align='center' width='20%' style='".$color."'><label style='font-weight:bold; font-size:2em;'>".$completionrate."%</label></td>" .
						"</tr>" .						
					"</table>";
					
	if($_SESSION['level'] == 'Super Admin')
	{
		$maingroupsql = mysqli_query($conn, "SELECT * FROM main_groups WHERE name != 'Executive Protection' ORDER BY name");
		while($maingroupres = mysqli_fetch_assoc($maingroupsql))
		{
		//	$SAmodsql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE expro = 0 ORDER BY bu");
			$idpDisplaylistdetail = "";
			$avgstake = 0.00;
			$totalstakescore = 0;
			$counter = 0;
			$SAmodsql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE main_group = ".$maingroupres['id']." ORDER BY bu");
			while($SAmodres = mysqli_fetch_assoc($SAmodsql))
			{
				$color = "";
				$completionrate = 0;
			//	$counter = 0;
			//	$totalstakescore = 0;
				$mainstakesql = mysqli_query($conn, "SELECT * FROM stakeholder_mst_new WHERE bu_id = ".$SAmodres['id']." AND year = ".$stakeyear)or die(mysqli_error($conn));
				$mainstakeres = mysqli_fetch_assoc($mainstakesql);	
				$totalstake = mysqli_num_rows($mainstakesql);
				
				$completionrate = $mainstakeres['score'];
				
				if(($completionrate <= 5) && ($completionrate >= 4.5))
				{
					$color = "background-color:purple; color:white;";
					//$color2 = "white; color:purple;";
				}
				elseif(($completionrate < 4.5) && ($completionrate >= 4))
				{
					$color = "background-color:blue; color:white;";
					//$color2 = "white; color:blue;";
				}
				elseif(($completionrate < 4) && ($completionrate >= 3))
				{
					$color = "background-color:green; color:white;";
					//$color2 = "white; color:green;";
				}
				elseif(($completionrate < 3) && ($completionrate > 2))
				{
					$color = "background-color:orange; color:white;";
					//$color2 = "white; color:orange;";
				}
				elseif(($completionrate <= 2) && ($completionrate > 0))
				{
					$color = "background-color:red; color:white;";
					//$color2 = "white; color:red;";
				}
				if($mainstakeres)
				{
					$datedisplay = date('Y-m-d H:i',strtotime('+8 hours',strtotime($mainstakeres['date_saved'])));
				}
				else
				{
					$datedisplay = "";
				}
			//	$datedisplay = date('Y-m-d H:i',strtotime('+8 hours',strtotime($mainstakeres['date_saved'])));
				/* 
				$IDPDisplay =	"<br><table width='95%' align='center' border='1' style='border-collapse:collapse; margin-top:9px;'>" .
									"<tr>" .
										"<th class='whiteonblack'>Business Unit</th>" .
										"<th class='whiteonblack'>SCORE</th>" .
										"<th class='whiteonblack'>Last Updated On</th>" .
									"</tr>" . */
				$idpDisplaylistdetail .=	"<tr class='stakerow".$maingroupres['id']."' >" .
											//	"<td align='center' ><label>".$SAmodres['bu']."</label></td>" .
											
												"<td align='left' ><a href='".$mainstakeres['score_link']."' target='_blank' title='Go to source file'>".$SAmodres['bu']."</a></td>" .
												"<td title='".$mainstakeres['score_description']."' align='center' style='".$color."'><label style='font-weight:bold;'>".$completionrate."</label></td>" .
												"<td align='center' ><label>".$datedisplay."</label></td>" .
											"</tr>";
				if($completionrate > 0)
				{
					$totalstakescore += $completionrate;
					$counter++;
				}
				
			}
			$avgstake = number_format((($totalstakescore / $counter)),2,'.',',');
			if($avgstake == 0.00)
			{
				$avgstake = "";
			}
			$idpDisplaylist .= "<tr>" .
									"<td align='center' ><label style='color:green; font-weight:bold; cursor:pointer' onclick='stakeDropdown(".$maingroupres['id'].");' >".$maingroupres['name']."</label></td>" .
									"<td align='center'>".$avgstake."</td>" .			
									"<td></td>" .
								"</tr>" . $idpDisplaylistdetail;
		}
		
		
		$IDPDisplay =	"<table width='100%' align='center' border='1' style='border-collapse:collapse;'>" .
								"<thead style='position:sticky; top:0;'>" .
								"<tr style='position:sticky; top:0;'>" .
									"<th class='whiteonblack' style='position:sticky; top:0;'>Business Unit</th>" .
									"<th class='whiteonblack' style='position:sticky; top:0;'>SCORE</th>" .
									"<th class='whiteonblack' style='position:sticky; top:0;'>Last Updated On</th>" .
								"</tr>" .
								"</thead>" .
								"<tbody>" .
								$idpDisplaylist .
								"</tbody>" .
							"</table>";
	}
					
	echo $IDPDisplay;
?>