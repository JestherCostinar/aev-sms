<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$guardtable = "";
$commstable = "";
$vehicletable = "";
$officetable = "";
$otherstable = "";
$ratestable = "";

$grandtotalGuardDC = 0;
$grandtotalGuardHG = 0;
$grandtotalGuardSG = 0;
$grandtotalGuardLG = 0;
$grandtotalGuardRel = 0;
$grandtotalGuardTotal = 0;
$grandtotalGuardSOC = 0;
$grandtotalGuard1st = 0;
$grandtotalGuard2nd = 0;
$grandtotalGuard3rd = 0;
$grandtotalGuardOthers = 0;

$grandtotalCommsBaseRadio = 0;
$grandtotalCommsHHRadio = 0;
$grandtotalCommsRepeater = 0;
$grandtotalCommsMobile = 0;
$grandtotalCommsSatPhones = 0;
$grandtotalCommsOthers = 0;
$grandtotalCommsTotal = 0;
$grandtotalSurvCCTV = 0;
$grandtotalSurvCCTVMotion = 0;
$grandtotalSurvAccessCtrl = 0;
$grandtotalSurvIntrusionDet = 0;
$grandtotalSurvWatchman = 0;
$grandtotalSurvOthers = 0;
$grandtotalSurvTotal = 0;

$grandtotalFA9mm = 0;
$grandtotalFAShotgun = 0;
$grandtotalFAM16 = 0;
$grandtotalFAM4 = 0;
$grandtotalFAOthers = 0;
$grandtotalFATotal = 0;
$grandtotalVehBicycle = 0;
$grandtotalVeh2wMC = 0;
$grandtotalVeh4wATV = 0;
$grandtotalVeh4wUtiliy = 0;
$grandtotalVehWaterCrafts = 0;
$grandtotalVehAmbu = 0;
$grandtotalVehFireTruck = 0;
$grandtotalVehOthers = 0;
$grandtotalVehTotal = 0;

$grandtotalOthersMetalDet = 0;
$grandtotalOthersMirror = 0;
$grandtotalOthersK9 = 0;
$grandtotalOthersSearchlight = 0;
$grandtotalOthersBinoculars = 0;
$grandtotalOthersStungun = 0;
$grandtotalOthersFirstAid = 0;
$grandtotalOthersRainboots = 0;
$grandtotalOthersRaincoat = 0;
$grandtotalOthersGasMask = 0;
$grandtotalOthersAnalyzer = 0;
$grandtotalOthersWaterDispenser = 0;
$grandtotalOthersMegaphone = 0;
$grandtotalOthersSteelToe = 0;
$grandtotalOthersHardHat = 0;
$grandtotalOthersDigicam = 0;
$grandtotalOthersTrafficVest = 0;
$grandtotalOthersFireEquip = 0;
$grandtotalOthersOthers = 0;
$grandtotalOthersTotal = 0;

$innerspam = "";
$outerspam = "";

/* $maindropdownsql = mysqli_query($conn, "SELECT * FROM main_groups WHERE name != 'Executive Protection'");
while($maindropdownres = mysqli_fetch_assoc($maindropdownsql))
{
	// guards
	$spakRand = rand(0,1000);
	$subdropdownsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Detachment Commander' THEN 1 ELSE 0 END) AS gDC,
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Head Guard' THEN 1 ELSE 0 END) AS gHG,
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Security Guard' THEN 1 ELSE 0 END) AS gSG,
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Lady Guard' THEN 1 ELSE 0 END) AS gLG, 
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Reliever' THEN 1 ELSE 0 END) AS gRel, 
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Intel Collector' THEN 1 ELSE 0 END) AS gIn, 
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Temporary' THEN 1 ELSE 0 END) AS gTemp, 
											SUM(CASE WHEN status = 'Active' AND guard_category = 'External' THEN 1 ELSE 0 END) AS gExt, 
										FROM guard_personnel
										WHERE bu_id IN(SELECT id from bu_mst WHERE main_group = ".$maindropdownres['id'].")")or die(mysqli_error($conn));
	$subdropdownres = mysqli_fetch_assoc($subdropdownsql);
	
	$innerspam = "";
} */

$maindropdownsql = mysqli_query($conn, "SELECT * FROM main_groups WHERE name != 'Executive Protection'");
while($maindropdownres = mysqli_fetch_assoc($maindropdownsql))
{
	// guards
	$spakRand = rand(0,1000);
	$subdropdownsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Detachment Commander' THEN 1 ELSE 0 END) AS gDC,
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Head Guard' THEN 1 ELSE 0 END) AS gHG,
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Security Guard' THEN 1 ELSE 0 END) AS gSG,
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Lady Guard' THEN 1 ELSE 0 END) AS gLG, 
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Reliever' THEN 1 ELSE 0 END) AS gRel, 
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Intel Collector' THEN 1 ELSE 0 END) AS gIn, 
											SUM(CASE WHEN status = 'Active' AND guard_category = 'Temporary' THEN 1 ELSE 0 END) AS gTemp, 
											SUM(CASE WHEN status = 'Active' AND guard_category = 'External' THEN 1 ELSE 0 END) AS gExt, 
										FROM guard_personnel
										WHERE bu_id IN(SELECT id from bu_mst WHERE main_group = ".$maindropdownres['id'].")")or die(mysqli_error($conn));
	$subdropdownres = mysqli_fetch_assoc($subdropdownsql);
	
	$innerspam = "";
}

$rownum = 1;
$mainspamsql = mysqli_query($conn,"SELECT * FROM bu_mst WHERE EXPRO = 0 ORDER BY bu");
while($mainspamres = mysqli_fetch_array($mainspamsql))
{
	if($rownum == 1){
		  $rowcolor = "altrows";
		  $rownum = 0;
	}
	elseif($rownum == 0){
	  $rowcolor = "";
	  $rownum = 1;
	}
	
	$guardDC = 0;
	$guardHG = 0;
	$guardSG = 0;
	$guardLG = 0;
	$guardRel = 0;
	$guardIn = 0;
	$guardTotal = 0;
	$guardExt = 0;
	$guardTemp = 0;
	$guardTotal2 = 0;

	$guardspamsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ".$mainspamres['id']." AND status = 'Active'");
	while($guardspamres = mysqli_fetch_assoc($guardspamsql))
	{
		if($guardspamres["guard_category"] == "Detachment Commander")
		{
			$guardDC++;
		}
		elseif($guardspamres["guard_category"] == "Head Guard")
		{
			$guardHG++;
		}
		elseif($guardspamres["guard_category"] == "Security Guard")
		{
			$guardSG++;
		}
		elseif($guardspamres["guard_category"] == "Lady Guard")
		{
			$guardLG++;
		}
		elseif($guardspamres["guard_category"] == "Reliever")
		{
			$guardRel++;
		}
		elseif($guardspamres["guard_category"] == "Intel Collector")
		{
			$guardIn++;
		}
		elseif($guardspamres["guard_category"] == "Temporary")
		{
			$guardTemp++;
		}
		elseif($guardspamres["guard_category"] == "External")
		{
			$guardExt++;
		}
	}
	$guardTotal = $guardDC + $guardHG + $guardSG + $guardLG;
	$guardTotal2 = $guardRel + $guardTemp + $guardExt; 
		
	$spambulink = "<td class='spamlink' onclick='showSpam2(".$mainspamres['id'].")'>".$mainspamres['bu']."</td>";
	$spambulink2 = "<td class='spamlink' onclick='showSpam2(".$mainspamres['id'].")'>".$mainspamres['bu']."</td>";
	$specificspamsql = mysqli_query($conn, "SELECT * FROM spam_mst WHERE bu = ".$mainspamres['id']." ORDER BY date_saved DESC");
	$specificspamres = mysqli_fetch_assoc($specificspamsql);
	$guardtable .=	"<tr class='".$rowcolor."' align='center'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						$spambulink .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><label style='text-decoration:underline; cursor:pointer; color:blue;' title='".$specificspamres['date_saved']."'>?</label></td>" .
						"<td style='background-color:black; padding:0;'></td>".
						"<td >".$guardDC."</td>" .
						"<td >".$guardHG."</td>" .
						"<td >".$guardSG."</td>" .
						"<td>".$guardLG."</td>" .
						"<td>".$guardIn."</td>" .
					//	"<td>".$guardRel."</td>" .
						"<td style='font-weight:bold; color:red;'>".$guardTotal."</td>" .
						"<td style='background-color:black; padding:0;'></td>".
						"<td>".$guardExt."</td>" .
						"<td>".$guardTemp."</td>" .
						"<td>".$guardRel."</td>" .
						"<td style='font-weight:bold; color:red;'>".$guardTotal2."</td>" .
						"<td style='background-color:black; padding:0;'></td>".
						"<td>".($specificspamres['security_operations_center'] ? ($specificspamres['security_operations_center'] == 1 ? 'Yes' : 'No') : '')."</td>" .
					//	"<td>".($specificspamres['security_operations_center'] == 1 ? 'Yes' : 'No')."</td>" .
						"<td>".$specificspamres['shift_1st']."</td>" .
						"<td>".$specificspamres['shift_2nd']."</td>" .
						"<td>".$specificspamres['shift_3rd']."</td>" .
						"<td>".$specificspamres['shift_others']."</td>" .
						"<td style='background-color:black; padding:0;'></td>".
					"</tr>";
					
	$grandtotalGuardDC += $guardDC;
	$grandtotalGuardHG += $guardHG;
	$grandtotalGuardSG += $guardSG;
	$grandtotalGuardLG += $guardLG;
	$grandtotalGuardRel += $guardRel;
	$grandtotalGuardTotal += $guardTotal;
	$grandtotalGuardExt += $guardExt;
	$grandtotalGuardTemp += $guardTemp;
	$grandtotalGuardTotal2 += $guardTotal2;
	$grandtotalGuardSOC += $specificspamres['security_operations_center'];
	$grandtotalGuard1st += $specificspamres['shift_1st'];
	$grandtotalGuard2nd += $specificspamres['shift_2nd'];
	$grandtotalGuard3rd += $specificspamres['shift_3rd'];
	$grandtotalGuardOthers += $specificspamres['shift_others'];
	
	$commstable .=	"<tr class='".$rowcolor."' align='center'>" .
						"<td style='background-color:black; padding:0;' ></td>".	
						$spambulink .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><label style='text-decoration:underline; cursor:pointer; color:blue;' title='".$specificspamres['date_saved']."'>?</label></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$specificspamres['comms_base_radio']."</td>" .
						"<td>".$specificspamres['comms_hh_radio']."</td>" .
						"<td>".$specificspamres['comms_repeater']."</td>" .
						"<td>".$specificspamres['comms_mobile']."</td>" .
						"<td>".$specificspamres['comms_sat_phones']."</td>" .
						"<td>".$specificspamres['comms_others']."</td>" .
						"<td>".$specificspamres['comms_total']."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$specificspamres['surv_cctv']."</td>" .
						"<td>".$specificspamres['surv_cctv_motion']."</td>" .
						"<td>".$specificspamres['surv_access_ctrl']."</td>" .
						"<td>".$specificspamres['surv_intrusion_det']."</td>" .
						"<td>".$specificspamres['surv_watchman']."</td>" .
						"<td>".$specificspamres['surv_others']."</td>" .
						"<td>".$specificspamres['surv_total']."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>";
					
	$grandtotalCommsBaseRadio += $specificspamres['comms_base_radio'];
	$grandtotalCommsHHRadio += $specificspamres['comms_hh_radio'];
	$grandtotalCommsRepeater += $specificspamres['repeater'];
	$grandtotalCommsMobile += $specificspamres['comms_mobile'];
	$grandtotalCommsSatPhones += $specificspamres['comms_sat_phones'];
	$grandtotalCommsOthers += $specificspamres['comms_others'];
	$grandtotalCommsTotal += $specificspamres['comms_total'];
	$grandtotalSurvCCTV += $specificspamres['surv_cctv'];
	$grandtotalSurvCCTVMotion += $specificspamres['surv_cctv_motion'];
	$grandtotalSurvAccessCtrl += $specificspamres['surv_access_ctrl'];
	$grandtotalSurvIntrusionDet += $specificspamres['surv_intrusion_det'];
	$grandtotalSurvWatchman += $specificspamres['surv_watchman'];
	$grandtotalSurvOthers += $specificspamres['surv_others'];
	$grandtotalSurvTotal += $specificspamres['surv_total'];
	
	$vehicletable .= "<tr class='".$rowcolor."' align='center'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						$spambulink .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><label style='text-decoration:underline; cursor:pointer; color:blue;' title='".$specificspamres['date_saved']."'>?</label></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$specificspamres['fa_9mm']."</td>" .
						"<td>".$specificspamres['fa_shotgun']."</td>" .
						"<td>".$specificspamres['fa_m16']."</td>" .
						"<td>".$specificspamres['fa_m4']."</td>" .
						"<td>".$specificspamres['fa_others']."</td>" .
						"<td>".$specificspamres['fa_total']."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$specificspamres['veh_bicycle']."</td>" .
						"<td>".$specificspamres['veh_2w_mc']."</td>" .
						"<td>".$specificspamres['veh_4w_atv']."</td>" .
						"<td>".$specificspamres['veh_4w_utility']."</td>" .
						"<td>".$specificspamres['veh_water_crafts']."</td>" .
						"<td>".$specificspamres['veh_ambu']."</td>" .
						"<td>".$specificspamres['veh_fire_truck']."</td>" .
						"<td>".$specificspamres['veh_others']."</td>" .
						"<td>".$specificspamres['veh_total']."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>";
					
	$grandtotalFA9mm += $specificspamres['fa_9mm'];
	$grandtotalFAShotgun += $specificspamres['fa_shotgun'];
	$grandtotalFAM16 += $specificspamres['fa_m16'];
	$grandtotalFAM4 += $specificspamres['fa_m4'];
	$grandtotalFAOthers += $specificspamres['fa_others'];
	$grandtotalFATotal += $specificspamres['fa_total'];
	$grandtotalVehBicycle += $specificspamres['veh_bicycle'];
	$grandtotalVeh2wMC += $specificspamres['veh_2w_mc'];
	$grandtotalVeh4wATV += $specificspamres['veh_4w_atv'];
	$grandtotalVeh4wUtiliy += $specificspamres['veh_4w_utility'];
	$grandtotalVehWaterCrafts += $specificspamres['veh_water_crafts'];
	$grandtotalVehAmbu += $specificspamres['veh_ambu'];
	$grandtotalVehFireTruck += $specificspamres['veh_fire_truck'];
	$grandtotalVehOthers += $specificspamres['veh_others'];
	$grandtotalVehTotal += $specificspamres['veh_total'];
	
	$officetable .= "<tr class='".$rowcolor."' align='center'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						$spambulink .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><label style='text-decoration:underline; cursor:pointer; color:blue;' title='".$specificspamres['date_saved']."'>?</label></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$specificspamres['office_desktop']."</td>" .
						"<td>".$specificspamres['office_printer']."</td>" .
						"<td>".$specificspamres['office_internet']."</td>" .
						"<td>".$specificspamres['office_others']."</td>" .
						"<td>".$specificspamres['office_total']."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".						
					"</tr>";
					
	$grandtotalOfficeDesktop += $specificspamres['office_desktop'];
	$grandtotalOfficePrinter += $specificspamres['office_printer'];
	$grandtotalOfficeInternet += $specificspamres['office_internet'];
	$grandtotalOfficeOthers += $specificspamres['office_others'];
	$grandtotalOfficeTotal += $specificspamres['office_total'];	
	
	$otherstable .= "<tr class='".$rowcolor."' align='center'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						$spambulink .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><label style='text-decoration:underline; cursor:pointer; color:blue;' title='".$specificspamres['date_saved']."'>?</label></td>" .
						"<td style='background-color:black; padding:0;' ></td>".						
						"<td>".$specificspamres['others_metal_det']."</td>" .
						"<td>".$specificspamres['others_mirror']."</td>" .
						"<td>".$specificspamres['others_k9']."</td>" .
						"<td>".$specificspamres['others_searchlight']."</td>" .
						"<td>".$specificspamres['others_binoculars']."</td>" .
						"<td>".$specificspamres['others_stungun']."</td>" .
						"<td>".$specificspamres['others_firstaidkit']."</td>" .
						"<td>".$specificspamres['others_rainboots']."</td>" .
						"<td>".$specificspamres['others_raincoat']."</td>" .
						"<td>".$specificspamres['others_gasmask']."</td>" .
						"<td>".$specificspamres['others_breathanalyzer']."</td>" .
						"<td>".$specificspamres['others_waterdispenser']."</td>" .
						"<td>".$specificspamres['others_megaphone']."</td>" .
						"<td>".$specificspamres['others_steeltoe']."</td>" .
						"<td>".$specificspamres['others_hardhat']."</td>" .
						"<td>".$specificspamres['others_digicam']."</td>" .
						"<td>".$specificspamres['others_trafficvest']."</td>" .
						"<td>".$specificspamres['others_fireequip']."</td>" .
						"<td>".$specificspamres['others_others']."</td>" .
						"<td>".$specificspamres['others_total']."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>";
					
	$grandtotalOthersMetalDet += $specificspamres['others_metal_det'];
	$grandtotalOthersMirror += $specificspamres['others_mirror'];
	$grandtotalOthersK9 += $specificspamres['others_k9'];
	$grandtotalOthersSearchlight += $specificspamres['others_searchlight'];
	$grandtotalOthersBinoculars += $specificspamres['others_binoculars'];
	$grandtotalOthersStungun += $specificspamres['others_stungun'];
	$grandtotalOthersFirstAid += $specificspamres['others_firstaidkit'];
	$grandtotalOthersRainboots += $specificspamres['others_rainboots'];
	$grandtotalOthersRaincoat += $specificspamres['others_raincoat'];
	$grandtotalOthersGasMask += $specificspamres['others_gasmask'];
	$grandtotalOthersAnalyzer += $specificspamres['others_breathanalyzer'];
	$grandtotalOthersWaterDispenser += $specificspamres['others_waterdispenser'];
	$grandtotalOthersMegaphone += $specificspamres['others_megaphone'];
	$grandtotalOthersSteelToe += $specificspamres['others_steeltoe'];
	$grandtotalOthersHardHat += $specificspamres['others_hardhat'];
	$grandtotalOthersDigicam += $specificspamres['others_digicam'];
	$grandtotalOthersTrafficVest += $specificspamres['others_trafficvest'];
	$grandtotalOthersFireEquip += $specificspamres['others_fireequip'];
	$grandtotalOthersOthers += $specificspamres['others_others'];
	$grandtotalOthersTotal += $specificspamres['others_total'];
	
	$formattedDailyWage = number_format(($specificspamres['rates_daily_wage_12a']),2,'.',',');
	$formattedAmtDueGuard12a = number_format(($specificspamres['rates_amt_due_guard_12a']),2,'.',',');
	$formattedAmtDueGuard12b = number_format(($specificspamres['rates_amt_due_guard_12b']),2,'.',',');
	$formattedAmtDueGuard9 = number_format(($specificspamres['rates_amt_due_guard_9']),2,'.',',');
	$formattedAmtDueGuard10 = number_format(($specificspamres['rates_amt_due_guard_10']),2,'.',',');
	$formattedContractPerGuard12a = number_format(($specificspamres['rates_contract_per_guard_12a']),2,'.',',');
	$formattedContractPerGuard12b = number_format(($specificspamres['rates_contract_per_guard_12b']),2,'.',',');
	$formattedContractPerGuard9 = number_format(($specificspamres['rates_contract_per_guard_9']),2,'.',',');
	$formattedContractPerGuard10 = number_format(($specificspamres['rates_contract_per_guard_10']),2,'.',',');
	$formattedMonthly = number_format(($specificspamres['rates_tot_contract_per_month']),2,'.',',');
	$formattedYearly = number_format(($specificspamres['rates_contract_per_year']),2,'.',',');
	
					
	$ratestable .= "<tr class='".$rowcolor."' align='center'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						$spambulink2 .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><label style='text-decoration:underline; cursor:pointer; color:blue;' title='".$specificspamres['date_saved']."'>?</label></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$formattedDailyWage."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$formattedAmtDueGuard12a."</td>" .
						"<td>".$formattedAmtDueGuard12b."</td>" .
						"<td>".$formattedAmtDueGuard9."</td>" .
						"<td>".$formattedAmtDueGuard10."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$specificspamres['rates_agency_percent_12a']."%</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$formattedContractPerGuard12a."</td>" .
						"<td>".$formattedContractPerGuard12b."</td>" .
						"<td>".$formattedContractPerGuard9."</td>" .
						"<td>".$formattedContractPerGuard10."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>". $formattedMonthly ."</td>" .						
						"<td>". $formattedYearly ."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>";
	
	
}

$resulttable = "<table align='center' width='85%' border='0' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; border-top:1px;\" >" .
						"<tr>" .
							"<th colspan='100%' style='font-size:24px; text-align:left;'>Security Personnel & Assets Management Consolidation</th>" . 
						"</tr>" .
				"</table></br>";

$resulttable .= "<table align='center' width='95%' style='border-spacing:0px; padding:0px; border-collapse:ollapse;'  >" .
					"<tr>" .
						"<td><button id='btnSpamGuard' class='tablink' onclick=\"toggleSpam('tblSpamGuard', 'btnSpamGuard');\" style='background-color:red;' >Guard</button>" .
						"<button id='btnSpamCommunication' class='tablink' onclick=\"toggleSpam('tblSpamCommunication', 'btnSpamCommunication');\">Communication/Surveillance</button>" .
						"<button id='btnSpamFirearms' class='tablink' onclick=\"toggleSpam('tblSpamFirearms', 'btnSpamFirearms');\">Vehicles/Firearms</button>" .
						"<button id='btnSpamOffice' class='tablink' onclick=\"toggleSpam('tblSpamOffice', 'btnSpamOffice');\">Office/Admin</button>" .
						"<button id='btnSpamOthers' class='tablink' onclick=\"toggleSpam('tblSpamOthers', 'btnSpamOthers');\">Others</button>" .
						"<button id='btnSpamRates' class='tablink' onclick=\"toggleSpam('tblSpamRates', 'btnSpamRates');\">Rates</button></td>" .
					"</tr>" .	
				"</table>";
				
$resulttable .=	"<table id='tblSpamGuard' class='spamtable' align='center' width='95%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='4'></th>" .
						"<th colspan='13'>Guards</th>" .
						"<th colspan='6'>Shifts</th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th colspan='4'></th>" .
						"<th colspan='8'>Regular</th>" .
						"<th colspan='5'>Irregular</th>" .
						"<th colspan='6'>Shifts</th>" .
					"</tr>" .					
					"<tr class='whiteonblack'>" .
						"<th style='padding:0; width:3px'></th>".
						"<th >Business Unit</th>" .
						"<th style='padding:0; width:3px'></th>".
						"<th ></th>" . //date saved
						"<th style='padding:0; width:3px'></th>".
						"<th>DC/ADC</th>" .
						"<th>HG/SIC</th>" .
						"<th>SG</th>" .
						"<th>LG</th>" .
						"<th>In</th>" .
					//	"<th>Rel</th>" .
						"<th>Total</th>" .
						"<th style='padding:0; width:3px'></th>".
						"<th>Ext</th>" .
						"<th>Temp</th>" .
						"<th>Rel</th>" .
						"<th>Total</th>" .
						"<th style='padding:0; width:3px'></th>".
						"<th>SOC</th>" .
						"<th>1st</th>" .
						"<th>2nd</th>" .
						"<th>3rd</th>" .
						"<th>Others</th>" .
						"<th style='padding:0; width:3px'></th>".
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalGuardDC."</td>" .
						"<td >".$grandtotalGuardHG."</td>" .
						"<td >".$grandtotalGuardSG."</td>" .
						"<td>".$grandtotalGuardLG."</td>" .
						"<td>".$grandtotalGuardIn."</td>" .
					//	"<td>".$grandtotalGuardRel."</td>" .
						"<td style='font-weight:bold; color:red;'>".$grandtotalGuardTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$grandtotalGuardExt."</td>" .
						"<td>".$grandtotalGuardTemp."</td>" .
						"<td>".$grandtotalGuardRel."</td>" .
						"<td style='font-weight:bold; color:red;'>".$grandtotalGuardTotal2."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$grandtotalGuardSOC."</td>" .					
						"<td>".$grandtotalGuard1st."</td>" .
						"<td>".$grandtotalGuard2nd."</td>" .
						"<td>".$grandtotalGuard3rd."</td>" .
						"<td>".$grandtotalGuardOthers."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					$guardtable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;'></td>".
						"<td >".$grandtotalGuardDC."</td>" .
						"<td >".$grandtotalGuardHG."</td>" .
						"<td >".$grandtotalGuardSG."</td>" .
						"<td>".$grandtotalGuardLG."</td>" .
						"<td>".$grandtotalGuardIn."</td>" .
					//	"<td>".$grandtotalGuardRel."</td>" .
						"<td style='font-weight:bold; color:red;'>".$grandtotalGuardTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$grandtotalGuardExt."</td>" .
						"<td>".grandtotalGuardTemp."</td>" .
						"<td>".$grandtotalGuardRel."</td>" .
						"<td style='font-weight:bold; color:red;'>".$grandtotalGuardTotal2."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td>".$grandtotalGuardSOC."</td>" .					
						"<td>".$grandtotalGuard1st."</td>" .
						"<td>".$grandtotalGuard2nd."</td>" .
						"<td>".$grandtotalGuard3rd."</td>" .
						"<td>".$grandtotalGuardOthers."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					"<tr>" .
						"<td colspan='100%' style='background-color:black; padding:0; height:3px;' ></td>".
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamCommunication' class='spamtable' align='center' width='95%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='4'></th>" .
						"<th colspan='9'>Communications</th>" .
						"<th colspan='8'>Electronic Surveillance</th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Business Unit</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th></th>" . //date saved
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Base Radio</th>" .
						"<th>Handheld Radio</th>" .
						"<th>Repeater</th>" .
						"<th>Mobile Phones</th>" .
						"<th>Satellite Phones</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>CCTV</th>" .
						"<th>CCTV w/ Motion Detectors</th>" .
						"<th>Access Control</th>" .
						"<th>Intrusion Detection</th>" .
						"<th>Watchman's Clock</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .
						"<td style='padding:0; width:3px;' ></td>".
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalCommsBaseRadio."</td>" .
						"<td >".$grandtotalCommsHHRadio."</td>" .
						"<td >".$grandtotalCommsRepeater."</td>" .
						"<td >".$grandtotalCommsMobile."</td>" .
						"<td >".$grandtotalCommsSatPhones."</td>" .
						"<td >".$grandtotalCommsOthers."</td>" .
						"<td >".$grandtotalCommsTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalSurvCCTV."</td>" .
						"<td >".$grandtotalSurvCCTVMotion."</td>" .
						"<td >".$grandtotalSurvAccessCtrl."</td>" .
						"<td >".$grandtotalSurvIntrusionDet."</td>" .
						"<td >".$grandtotalSurvWatchman."</td>" .
						"<td >".$grandtotalSurvOthers."</td>" .
						"<td >".$grandtotalSurvTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					$commstable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalCommsBaseRadio."</td>" .
						"<td >".$grandtotalCommsHHRadio."</td>" .
						"<td >".$grandtotalCommsRepeater."</td>" .
						"<td >".$grandtotalCommsMobile."</td>" .
						"<td >".$grandtotalCommsSatPhones."</td>" .
						"<td >".$grandtotalCommsOthers."</td>" .
						"<td >".$grandtotalCommsTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalSurvCCTV."</td>" .
						"<td >".$grandtotalSurvCCTVMotion."</td>" .
						"<td >".$grandtotalSurvAccessCtrl."</td>" .
						"<td >".$grandtotalSurvIntrusionDet."</td>" .
						"<td >".$grandtotalSurvWatchman."</td>" .
						"<td >".$grandtotalSurvOthers."</td>" .
						"<td >".$grandtotalSurvTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					"<tr>" .
						"<td colspan='100%' style='background-color:black; padding:0; height:3px;' ></td>".
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamFirearms' class='spamtable' align='center' width='95%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='4'></th>" .
						"<th colspan='8'>Firearms</th>" .
						"<th colspan='10'>Vehicles</th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Business Unit</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th></th>" . //date saved
						"<td style='padding:0; width:3px;' ></td>".
						"<th>9mm Pistol</th>" .
						"<th>Shotgun</th>" .
						"<th>M16</th>" .
						"<th>M4</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Bicycle</th>" .
						"<th>2w MC</th>" .
						"<th>4w ATV</th>" .
						"<th>4w Utility</th>" .
						"<th>Water Crafts</th>" .
						"<th>Ambulance</th>" .
						"<th>Fire Truck</th>" .						
						"<th>Others</th>" .
						"<th>Total</th>" .
						"<td style='padding:0; width:3px;' ></td>".
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalFA9mm."</td>" .
						"<td >".$grandtotalFAShotgun."</td>" .
						"<td >".$grandtotalFAM16."</td>" .
						"<td >".$grandtotalFAM4."</td>" .
						"<td >".$grandtotalFAOthers."</td>" .
						"<td >".$grandtotalFATotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalVehBicycle."</td>" .
						"<td >".$grandtotalVeh2wMC."</td>" .					
						"<td >".$grandtotalVeh4wATV."</td>" .
						"<td >".$grandtotalVeh4wUtiliy."</td>" .
						"<td >".$grandtotalVehWaterCrafts."</td>" .
						"<td >".$grandtotalVehAmbu."</td>" .
						"<td >".$grandtotalVehFireTruck."</td>" .
						"<td >".$grandtotalVehOthers."</td>" .
						"<td >".$grandtotalVehTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					$vehicletable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .						
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalFA9mm."</td>" .
						"<td >".$grandtotalFAShotgun."</td>" .
						"<td >".$grandtotalFAM16."</td>" .
						"<td >".$grandtotalFAM4."</td>" .
						"<td >".$grandtotalFAOthers."</td>" .
						"<td >".$grandtotalFATotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalVehBicycle."</td>" .
						"<td >".$grandtotalVeh2wMC."</td>" .					
						"<td >".$grandtotalVeh4wATV."</td>" .
						"<td >".$grandtotalVeh4wUtiliy."</td>" .
						"<td >".$grandtotalVehWaterCrafts."</td>" .
						"<td >".$grandtotalVehAmbu."</td>" .
						"<td >".$grandtotalVehFireTruck."</td>" .
						"<td >".$grandtotalVehOthers."</td>" .
						"<td >".$grandtotalVehTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					"<tr>" .
						"<td colspan='100%' style='background-color:black; padding:0; height:3px;' ></td>".
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamOffice' class='spamtable' align='center' width='95%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='4'></th>" .
						"<th colspan='9'>Office/Admin</th>" .
						
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Business Unit</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th></th>" . //date saved
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Desktop Computer</th>" .
						"<th>Printer</th>" .
						"<th>Internet</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .
						"<td style='padding:0; width:3px;' ></td>".
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalOfficeDesktop."</td>" .						
						"<td >".$grandtotalOfficePrinter."</td>" .
						"<td >".$grandtotalOfficeInternet."</td>" .
						"<td >".$grandtotalOfficeOthers."</td>" .
						"<td >".$grandtotalOfficeTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					$officetable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalOfficeDesktop."</td>" .						
						"<td >".$grandtotalOfficePrinter."</td>" .
						"<td >".$grandtotalOfficeInternet."</td>" .
						"<td >".$grandtotalOfficeOthers."</td>" .
						"<td >".$grandtotalOfficeTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					"<tr>" .
						"<td colspan='100%' style='background-color:black; padding:0; height:3px;' ></td>".
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamOthers' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='4'></th>" .
						"<th colspan='100%'>Others</th>" .						
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Business Unit</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th></th>" . //date saved
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Metal Detectors</th>" .
						"<th>Under-chassis Mirror</th>" .
						"<th>K9 Unit</th>" .
						"<th>Portable Searchlight</th>" .
						"<th>Binoculars</th>" .
						"<th>Stun Gun</th>" .
						"<th>First Aid Kit</th>" .
						"<th>Rainboots</th>" .
						"<th>Raincoat</th>" .
						"<th>Gas Mask</th>" .
						"<th>Breath Analyzer</th>" .
						"<th>Water Dispenser</th>" .
						"<th>Megaphone</th>" .
						"<th>Steel-Toe Shoew</th>" .
						"<th>Hard Hat</th>" .
						"<th>Digicam</th>" .
						"<th>Traffic Vest</th>" .
						"<th>Fire Equip</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .
						"<td style='padding:0; width:3px;' ></td>".
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalOthersMetalDet."</td>" .
						"<td >".$grandtotalOthersMirror."</td>" .
						"<td >".$grandtotalOthersK9."</td>" .
						"<td >".$grandtotalOthersSearchlight."</td>" .
						"<td >".$grandtotalOthersBinoculars."</td>" .
						"<td >".$grandtotalOthersStungun."</td>" .
						"<td >".$grandtotalOthersFirstAid."</td>" .					
						"<td >".$grandtotalOthersRainboots."</td>" .
						"<td >".$grandtotalOthersRaincoat."</td>" .
						"<td >".$grandtotalOthersGasMask."</td>" .
						"<td >".$grandtotalOthersAnalyzer."</td>" .
						"<td >".$grandtotalOthersWaterDispenser."</td>" .
						"<td >".$grandtotalOthersMegaphone."</td>" .
						"<td >".$grandtotalOthersSteelToe."</td>" .
						"<td >".$grandtotalOthersHardHat."</td>" .
						"<td >".$grandtotalOthersDigicam."</td>" .
						"<td >".$grandtotalOthersTrafficVest."</td>" .
						"<td >".$grandtotalOthersFireEquip."</td>" .
						"<td >".$grandtotalOthersOthers."</td>" .
						"<td >".$grandtotalOthersTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					$otherstable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ><b>TOTAL</b></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td ></td>" .
						"<td style='background-color:black; padding:0;' ></td>".
						"<td >".$grandtotalOthersMetalDet."</td>" .
						"<td >".$grandtotalOthersMirror."</td>" .
						"<td >".$grandtotalOthersK9."</td>" .
						"<td >".$grandtotalOthersSearchlight."</td>" .
						"<td >".$grandtotalOthersBinoculars."</td>" .
						"<td >".$grandtotalOthersStungun."</td>" .
						"<td >".$grandtotalOthersFirstAid."</td>" .					
						"<td >".$grandtotalOthersRainboots."</td>" .
						"<td >".$grandtotalOthersRaincoat."</td>" .
						"<td >".$grandtotalOthersGasMask."</td>" .
						"<td >".$grandtotalOthersAnalyzer."</td>" .
						"<td >".$grandtotalOthersWaterDispenser."</td>" .
						"<td >".$grandtotalOthersMegaphone."</td>" .
						"<td >".$grandtotalOthersSteelToe."</td>" .
						"<td >".$grandtotalOthersHardHat."</td>" .
						"<td >".$grandtotalOthersDigicam."</td>" .
						"<td >".$grandtotalOthersTrafficVest."</td>" .
						"<td >".$grandtotalOthersFireEquip."</td>" .
						"<td >".$grandtotalOthersOthers."</td>" .
						"<td >".$grandtotalOthersTotal."</td>" .
						"<td style='background-color:black; padding:0;' ></td>".
					"</tr>" .
					"<tr>" .
						"<td colspan='100%' style='background-color:black; padding:0; height:3px;' ></td>".
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamRates' class='spamtable' align='center' width='95%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='4'></th>" .
						"<th colspan='18'>Rates</th>" .						
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th colspan='4'></th>" .
						"<th colspan='3'></th>" .
						"<th colspan='4'>Amount Due to Guard</th>" .
						"<th colspan='3'></th>" .
						"<th colspan='4'>Contract Rate per Guard</th>" .
						"<th colspan='4'></th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Business Unit</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th></th>" . //date saved
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Daily Wage</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>12H (1st)</th>" .
						"<th>12H (2nd)</th>" .
						"<th>9H</th>" .
						"<th>10H</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Agency Fee</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>12H (1st)</th>" .
						"<th>12H (2nd)</th>" .
						"<th>9H</th>" .
						"<th>10H</th>" .
						"<td style='padding:0; width:3px;' ></td>".
						"<th>Monthly</th>" .
						"<th>Annual</th>" .
						"<td style='padding:0; width:3px;' ></td>".
					"</tr>" .
					$ratestable .
					"<tr>" .
						"<td colspan='100%' style='background-color:black; padding:0; height:3px;' ></td>".
					"</tr>" .
				"</table>";
				
echo $resulttable;
?>