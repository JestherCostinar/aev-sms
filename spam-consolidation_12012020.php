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
	$guardTotal = 0;

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
	}
	$guardTotal = $guardDC + $guardHG + $guardSG + $guardLG;
		
	$spambulink = "<td class='spamlink' onclick='showSpam2(".$mainspamres['id'].")'>".$mainspamres['bu']."</td>";
	$spambulink2 = "<td class='spamlink' onclick='showSpam2(".$mainspamres['id'].")'>".$mainspamres['bu']."</td>";
	$specificspamsql = mysqli_query($conn, "SELECT * FROM spam_mst WHERE bu = ".$mainspamres['id']." ORDER BY date_saved DESC");
	$specificspamres = mysqli_fetch_assoc($specificspamsql);
	$guardtable .=	"<tr class='".$rowcolor."' align='center'>" .
						$spambulink .
						"<td >".$specificspamres['date_saved']."</td>" .
						"<td >".$guardDC."</td>" .
						"<td >".$guardHG."</td>" .
						"<td >".$guardSG."</td>" .
						"<td>".$guardLG."</td>" .
						"<td>".$guardRel."</td>" .
						"<td>".$guardTotal."</td>" .
						"<td>".($specificspamres['security_operations_center'] ? ($specificspamres['security_operations_center'] == 1 ? 'Yes' : 'No') : '')."</td>" .
					//	"<td>".($specificspamres['security_operations_center'] == 1 ? 'Yes' : 'No')."</td>" .
						"<td>".$specificspamres['shift_1st']."</td>" .
						"<td>".$specificspamres['shift_2nd']."</td>" .
						"<td>".$specificspamres['shift_3rd']."</td>" .
						"<td>".$specificspamres['shift_others']."</td>" .
					"</tr>";
					
	$grandtotalGuardDC += $guardDC;
	$grandtotalGuardHG += $guardHG;
	$grandtotalGuardSG += $guardSG;
	$grandtotalGuardLG += $guardLG;
	$grandtotalGuardRel += $guardRel;
	$grandtotalGuardTotal += $guardTotal;
	$grandtotalGuardSOC += $specificspamres['security_operations_center'];
	$grandtotalGuard1st += $specificspamres['shift_1st'];
	$grandtotalGuard2nd += $specificspamres['shift_2nd'];
	$grandtotalGuard3rd += $specificspamres['shift_3rd'];
	$grandtotalGuardOthers += $specificspamres['shift_others'];
	
	$commstable .=	"<tr class='".$rowcolor."' align='center'>" .
						$spambulink .
						"<td>".$specificspamres['date_saved']."</td>" .
						"<td>".$specificspamres['comms_base_radio']."</td>" .
						"<td>".$specificspamres['comms_hh_radio']."</td>" .
						"<td>".$specificspamres['comms_repeater']."</td>" .
						"<td>".$specificspamres['comms_mobile']."</td>" .
						"<td>".$specificspamres['comms_sat_phones']."</td>" .
						"<td>".$specificspamres['comms_others']."</td>" .
						"<td>".$specificspamres['comms_total']."</td>" .
						"<td>".$specificspamres['surv_cctv']."</td>" .
						"<td>".$specificspamres['surv_cctv_motion']."</td>" .
						"<td>".$specificspamres['surv_access_ctrl']."</td>" .
						"<td>".$specificspamres['surv_intrusion_det']."</td>" .
						"<td>".$specificspamres['surv_watchman']."</td>" .
						"<td>".$specificspamres['surv_others']."</td>" .
						"<td>".$specificspamres['surv_total']."</td>" .
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
						$spambulink .
						"<td>".$specificspamres['date_saved']."</td>" .
						"<td>".$specificspamres['fa_9mm']."</td>" .
						"<td>".$specificspamres['fa_shotgun']."</td>" .
						"<td>".$specificspamres['fa_m16']."</td>" .
						"<td>".$specificspamres['fa_m4']."</td>" .
						"<td>".$specificspamres['fa_others']."</td>" .
						"<td>".$specificspamres['fa_total']."</td>" .
						"<td>".$specificspamres['veh_bicycle']."</td>" .
						"<td>".$specificspamres['veh_2w_mc']."</td>" .
						"<td>".$specificspamres['veh_4w_atv']."</td>" .
						"<td>".$specificspamres['veh_4w_utility']."</td>" .
						"<td>".$specificspamres['veh_water_crafts']."</td>" .
						"<td>".$specificspamres['veh_ambu']."</td>" .
						"<td>".$specificspamres['veh_fire_truck']."</td>" .
						"<td>".$specificspamres['veh_others']."</td>" .
						"<td>".$specificspamres['veh_total']."</td>" .						
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
						$spambulink .
						"<td>".$specificspamres['date_saved']."</td>" .
						"<td>".$specificspamres['office_desktop']."</td>" .
						"<td>".$specificspamres['office_printer']."</td>" .
						"<td>".$specificspamres['office_internet']."</td>" .
						"<td>".$specificspamres['office_others']."</td>" .
						"<td>".$specificspamres['office_total']."</td>" .
						
					"</tr>";
					
	$grandtotalOfficeDesktop += $specificspamres['office_desktop'];
	$grandtotalOfficePrinter += $specificspamres['office_printer'];
	$grandtotalOfficeInternet += $specificspamres['office_internet'];
	$grandtotalOfficeOthers += $specificspamres['office_others'];
	$grandtotalOfficeTotal += $specificspamres['office_total'];	
	
	$otherstable .= "<tr class='".$rowcolor."' align='center'>" .
						$spambulink .
						"<td>".$specificspamres['date_saved']."</td>" .						
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
	
					
	$ratestable .= "<tr class='".$rowcolor."' align='center'>" .
						$spambulink2 .
						"<td>".$specificspamres['date_saved']."</td>" .						
						"<td>".$specificspamres['rates_daily_wage_12a']."</td>" .						
						"<td>".$specificspamres['rates_amt_due_guard_12a']."</td>" .
						"<td>".$specificspamres['rates_amt_due_guard_12b']."</td>" .
						"<td>".$specificspamres['rates_amt_due_guard_9']."</td>" .
						"<td>".$specificspamres['rates_amt_due_guard_10']."</td>" .						
						"<td>".$specificspamres['rates_agency_percent_12a']."%</td>" .
						"<td>".$specificspamres['rates_contract_per_guard_12a']."</td>" .
						"<td>".$specificspamres['rates_contract_per_guard_12b']."</td>" .
						"<td>".$specificspamres['rates_contract_per_guard_9']."</td>" .
						"<td>".$specificspamres['rates_contract_per_guard_10']."</td>" .					
						"<td>".$specificspamres['rates_tot_contract_per_month']."</td>" .
						"<td>".$specificspamres['rates_contract_per_year']."</td>" .
					"</tr>";
	
	
}

$resulttable = "<table align='center' width='85%' border='0' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; border-top:1px;\" >" .
						"<tr>" .
							"<th colspan='100%' style='font-size:24px; text-align:left;'>Security Personnel & Assets Management Consolidation</th>" . 
						"</tr>" .
				"</table></br>";

$resulttable .= "<table align='center' width='85%' style='border-spacing:0px; padding:0px; border-collapse:ollapse;'  >" .
					"<tr>" .
						"<td><button id='btnSpamGuard' class='tablink' onclick=\"toggleSpam('tblSpamGuard', 'btnSpamGuard');\" style='background-color:red;' >Guard</button>" .
						"<button id='btnSpamCommunication' class='tablink' onclick=\"toggleSpam('tblSpamCommunication', 'btnSpamCommunication');\">Communication/Surveillance</button>" .
						"<button id='btnSpamFirearms' class='tablink' onclick=\"toggleSpam('tblSpamFirearms', 'btnSpamFirearms');\">Vehicles/Firearms</button>" .
						"<button id='btnSpamOffice' class='tablink' onclick=\"toggleSpam('tblSpamOffice', 'btnSpamOffice');\">Office/Admin</button>" .
						"<button id='btnSpamOthers' class='tablink' onclick=\"toggleSpam('tblSpamOthers', 'btnSpamOthers');\">Others</button>" .
						"<button id='btnSpamRates' class='tablink' onclick=\"toggleSpam('tblSpamRates', 'btnSpamRates');\">Rates</button></td>" .
					"</tr>" .	
				"</table>";
				
$resulttable .=	"<table id='tblSpamGuard' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='2'></th>" .
						"<th colspan='6'>Guards</th>" .
						"<th colspan='5'>Shifts</th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th >Business Unit</th>" .
						"<th >Date Saved</th>" .
						"<th>DC/ADC</th>" .
						"<th>HG/SIC</th>" .
						"<th>SG</th>" .
						"<th>LG</th>" .
						"<th>Rel</th>" .
						"<th>Total</th>" .
						"<th>SOC</th>" .
						"<th>1st</th>" .
						"<th>2nd</th>" .
						"<th>3rd</th>" .
						"<th>Others</th>" .
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
						"<td >".$grandtotalGuardDC."</td>" .
						"<td >".$grandtotalGuardHG."</td>" .
						"<td >".$grandtotalGuardSG."</td>" .
						"<td>".$grandtotalGuardLG."</td>" .
						"<td>".$grandtotalGuardRel."</td>" .
						"<td>".$grandtotalGuardTotal."</td>" .
						"<td>".$grandtotalGuardSOC."</td>" .					
						"<td>".$grandtotalGuard1st."</td>" .
						"<td>".$grandtotalGuard2nd."</td>" .
						"<td>".$grandtotalGuard3rd."</td>" .
						"<td>".$grandtotalGuardOthers."</td>" .
					"</tr>" .
					$guardtable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
						"<td >".$grandtotalGuardDC."</td>" .
						"<td >".$grandtotalGuardHG."</td>" .
						"<td >".$grandtotalGuardSG."</td>" .
						"<td>".$grandtotalGuardLG."</td>" .
						"<td>".$grandtotalGuardRel."</td>" .
						"<td>".$grandtotalGuardTotal."</td>" .
						"<td>".$grandtotalGuardSOC."</td>" .					
						"<td>".$grandtotalGuard1st."</td>" .
						"<td>".$grandtotalGuard2nd."</td>" .
						"<td>".$grandtotalGuard3rd."</td>" .
						"<td>".$grandtotalGuardOthers."</td>" .
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamCommunication' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='2'></th>" .
						"<th colspan='7'>Communications</th>" .
						"<th colspan='7'>Electronic Srveillance</th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th>Business Unit</th>" .
						"<th>Date Saved</th>" .
						"<th>Base Radio</th>" .
						"<th>Handheld Radio</th>" .
						"<th>Repeater</th>" .
						"<th>Mobile Phones</th>" .
						"<th>Satellite Phones</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .
						"<th>CCTV</th>" .
						"<th>CCTV w/ Motion Detectors</th>" .
						"<th>Access Control</th>" .
						"<th>Intrusion Detection</th>" .
						"<th>Watchman's Clock</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
						"<td >".$grandtotalCommsBaseRadio."</td>" .
						"<td >".$grandtotalCommsHHRadio."</td>" .
						"<td >".$grandtotalCommsRepeater."</td>" .
						"<td >".$grandtotalCommsMobile."</td>" .
						"<td >".$grandtotalCommsSatPhones."</td>" .
						"<td >".$grandtotalCommsOthers."</td>" .
						"<td >".$grandtotalCommsTotal."</td>" .					
						"<td >".$grandtotalSurvCCTV."</td>" .
						"<td >".$grandtotalSurvCCTVMotion."</td>" .
						"<td >".$grandtotalSurvAccessCtrl."</td>" .
						"<td >".$grandtotalSurvIntrusionDet."</td>" .
						"<td >".$grandtotalSurvWatchman."</td>" .
						"<td >".$grandtotalSurvOthers."</td>" .
						"<td >".$grandtotalSurvTotal."</td>" .
					"</tr>" .
					$commstable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
						"<td >".$grandtotalCommsBaseRadio."</td>" .
						"<td >".$grandtotalCommsHHRadio."</td>" .
						"<td >".$grandtotalCommsRepeater."</td>" .
						"<td >".$grandtotalCommsMobile."</td>" .
						"<td >".$grandtotalCommsSatPhones."</td>" .
						"<td >".$grandtotalCommsOthers."</td>" .
						"<td >".$grandtotalCommsTotal."</td>" .					
						"<td >".$grandtotalSurvCCTV."</td>" .
						"<td >".$grandtotalSurvCCTVMotion."</td>" .
						"<td >".$grandtotalSurvAccessCtrl."</td>" .
						"<td >".$grandtotalSurvIntrusionDet."</td>" .
						"<td >".$grandtotalSurvWatchman."</td>" .
						"<td >".$grandtotalSurvOthers."</td>" .
						"<td >".$grandtotalSurvTotal."</td>" .
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamFirearms' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='2'></th>" .
						"<th colspan='6'>Firearms</th>" .
						"<th colspan='9'>Vehicles</th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th>Business Unit</th>" .
						"<th>Date Saved</th>" .
						"<th>9mm Pistol</th>" .
						"<th>Shotgun</th>" .
						"<th>M16</th>" .
						"<th>M4</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .
						"<th>Bicycle</th>" .
						"<th>2w MC</th>" .
						"<th>4w ATV</th>" .
						"<th>4w Utility</th>" .
						"<th>Water Crafts</th>" .
						"<th>Ambulance</th>" .
						"<th>Fire Truck</th>" .						
						"<th>Others</th>" .
						"<th>Total</th>" .
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
						"<td >".$grandtotalFA9mm."</td>" .
						"<td >".$grandtotalFAShotgun."</td>" .
						"<td >".$grandtotalFAM16."</td>" .
						"<td >".$grandtotalFAM4."</td>" .
						"<td >".$grandtotalFAOthers."</td>" .
						"<td >".$grandtotalFATotal."</td>" .
						"<td >".$grandtotalVehBicycle."</td>" .
						"<td >".$grandtotalVeh2wMC."</td>" .					
						"<td >".$grandtotalVeh4wATV."</td>" .
						"<td >".$grandtotalVeh4wUtiliy."</td>" .
						"<td >".$grandtotalVehWaterCrafts."</td>" .
						"<td >".$grandtotalVehAmbu."</td>" .
						"<td >".$grandtotalVehFireTruck."</td>" .
						"<td >".$grandtotalVehOthers."</td>" .
						"<td >".$grandtotalVehTotal."</td>" .
					"</tr>" .
					$vehicletable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
						"<td >".$grandtotalFA9mm."</td>" .
						"<td >".$grandtotalFAShotgun."</td>" .
						"<td >".$grandtotalFAM16."</td>" .
						"<td >".$grandtotalFAM4."</td>" .
						"<td >".$grandtotalFAOthers."</td>" .
						"<td >".$grandtotalVehBicycle."</td>" .
						"<td >".$grandtotalVeh2wMC."</td>" .					
						"<td >".$grandtotalVeh4wATV."</td>" .
						"<td >".$grandtotalVeh4wUtiliy."</td>" .
						"<td >".$grandtotalVehWaterCrafts."</td>" .
						"<td >".$grandtotalVehAmbu."</td>" .
						"<td >".$grandtotalVehFireTruck."</td>" .
						"<td >".$grandtotalVehOthers."</td>" .
						"<td >".$grandtotalVehTotal."</td>" .
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamOffice' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='2'></th>" .
						"<th colspan='5'>Office/Admin</th>" .
						
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th>Business Unit</th>" .
						"<th>Date Saved</th>" .
						"<th>Desktop Computer</th>" .
						"<th>Printer</th>" .
						"<th>Internet</th>" .
						"<th>Others</th>" .
						"<th>Total</th>" .												
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
						"<td >".$grandtotalOfficeDesktop."</td>" .						
						"<td >".$grandtotalOfficePrinter."</td>" .
						"<td >".$grandtotalOfficeInternet."</td>" .
						"<td >".$grandtotalOfficeOthers."</td>" .
						"<td >".$grandtotalOfficeTotal."</td>" .						
					"</tr>" .
					$officetable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
						"<td >".$grandtotalOfficeDesktop."</td>" .
						"<td >".$grandtotalOfficePrinter."</td>" .
						"<td >".$grandtotalOfficePrinter."</td>" .
						"<td >".$grandtotalOfficeInternet."</td>" .
						"<td >".$grandtotalOfficeOthers."</td>" .
						"<td >".$grandtotalOfficeTotal."</td>" .						
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamOthers' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='2'></th>" .
						"<th colspan='100%'>Others</th>" .						
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th>Business Unit</th>" .
						"<th>Date Saved</th>" .
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
					"</tr>" .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
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
					"</tr>" .
					$otherstable .
					"<tr align='center' style='background-color:#FAD8D8;'>" .
						"<td ><b>TOTAL</b></td>" .
						"<td ></td>" .
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
					"</tr>" .
				"</table>";
				
$resulttable .=	"<table id='tblSpamRates' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; display:none; \" >" .
					"<tr class='whiteonblack'>" .
						"<th colspan='2'></th>" .
						"<th colspan='12'>Rates</th>" .						
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th colspan='2'></th>" .
						"<th></th>" .
						"<th colspan='4'>Amount Due to Guard</th>" .
						"<th></th>" .
						"<th colspan='4'>Contract Rate per Guard</th>" .
						"<th colspan='2'></th>" .
					"</tr>" .
					"<tr class='whiteonblack'>" .
						"<th>Business Unit</th>" .
						"<th>Date Saved</th>" .
						"<th>Daily Wage</th>" .
						"<th>12H (1st)</th>" .
						"<th>12H (2nd)</th>" .
						"<th>9H</th>" .
						"<th>10H</th>" .
						"<th>Agency Fee</th>" .
						"<th>12H (1st)</th>" .
						"<th>12H (2nd)</th>" .
						"<th>9H</th>" .
						"<th>10H</th>" .
						"<th>Monthly</th>" .
						"<th>Annual</th>" .								
					"</tr>" .
					$ratestable .
				"</table>";
				
echo $resulttable;
?>