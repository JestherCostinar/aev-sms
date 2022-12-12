<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$buspam = $_GET['buspam'];
$back = $_GET['back'];
$spamdate = $_GET['spamdate'];
$backlink = "";
$spambuname = "";
$toggleSpamToken = 0;
if($back)
{
	$spambunamesql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$buspam);
	$spambunameres = mysqli_fetch_assoc($spambunamesql);
	$spambuname = "<tr><th style='font-size:20px; text-align:left;'>".$spambunameres['bu']."</th></tr>";
	$backlink = "<button id='btnSpamBackLink' class='tablink' onclick=\"showSpamCon();\"><-Back</button>";
	$toggleSpamToken = 1;
}

$guardDC = 0;
$guardHG = 0;
$guardSG = 0;
$guardLG = 0;
$guardRel = 0;
$guardTotal = 0;

$guardspamsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ".$buspam." AND status = 'Active'");
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
$budatelist = "";

if($spamdate)
{
	$buspamsql = mysqli_query($conn, "SELECT * FROM spam_mst WHERE bu = ".$buspam." AND date_saved = '".$spamdate."'");
	$buspamres = mysqli_fetch_assoc($buspamsql);
	$budatelist = "<option value='".$buspamres['date_saved']."'>".$buspamres['date_saved']."</option>";
}
else
{
	$buspamsql = mysqli_query($conn, "SELECT * FROM spam_mst WHERE bu = ".$buspam." ORDER BY date_saved DESC");
	$buspamres = mysqli_fetch_assoc($buspamsql);
}


$buspamdatesql = mysqli_query($conn, "SELECT * FROM spam_mst WHERE bu = ".$buspam." ORDER BY date_saved DESC");
while($buspamdateres = mysqli_fetch_assoc($buspamdatesql))
{
	$budatelist .= "<option value='".$buspamdateres['date_saved']."'>".$buspamdateres['date_saved']."</option>";
}

$resulttable = "<table align='center' width='85%' border='0' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; border-top:1px;\" >" .
						"<tr>" .
							"<th colspan='100%' style='font-size:24px; text-align:left;'>Security Personnel & Assets Management </th>" . 
						"</tr>" .
						$spambuname .
						"<tr>" .
							"<td>Date : <select id='selbuspamdate' name='selbuspamdate' onchange='showSpam3(".$buspam.");'>".$budatelist."</select></td>" .							
						"</tr>" .
				"</table></br>";

$resulttable .=	"<table align='center' width='85%' style='border-spacing:0px; padding:0px; border-collapse:ollapse;'  >" .
					"<tr>" .
						"<td>".$backlink."<button id='btnSpamGuard' class='tablink' onclick=\"toggleSpam('tblSpamGuard', 'btnSpamGuard');\" style='background-color:red;' >Guard</button>" .
						"<button id='btnSpamCommunication' class='tablink' onclick=\"toggleSpam('tblSpamCommunication', 'btnSpamCommunication');\">Communication/Surveillance</button>" .
						"<button id='btnSpamFirearms' class='tablink' onclick=\"toggleSpam('tblSpamFirearms', 'btnSpamFirearms');\">Vehicles/Firearms</button>" .
						// "<button id='btnSpamOffice' class='tablink' onclick=\"toggleSpam('tblSpamOffice', 'btnSpamOffice');\">Office/Admin	</button>" .
						"<button id='btnSpamOthers' class='tablink' onclick=\"toggleSpam('tblSpamOthers', 'btnSpamOthers');\">Office/Admin/Others</button>" .
						"<button id='btnSpamRates' class='tablink' onclick=\"toggleSpam('tblSpamRates', 'btnSpamRates');\">Rates</button></td>" .
					"</tr>" .	
				"</table>";

$resulttable .=	"<form id='frmspam' name='frmspam' method='post' action='user-admin.php'>" .
					"<table id='tblSpamGuard' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; border-spacing:0px; padding:0px; \" >" .
						"<tr>" .
							"<th colspan='3' width='50%' class='whiteonblack' style='font-size:18px;'>Guards <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Breakdown the number of guards by rank//position. If DC or HG is female, please indicate in the remarks'></th>" .
							"<th colspan='3' width='50%' class='whiteonblack' style='font-size:16px;' >Shifts <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate number of guards per shift'></th>" .
						"</tr>" .
						
						"<tr>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'><b>Detachment Commander/<br>Asst. Detachment Commander</b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamGuardDC' name='numSpamGuardDC' value='".$guardDC."' readonly onchange=\"autoCalculateSpam('Guards');\"/></td>" .
							"<td align='center'><textarea id='txtSpamGuardDC' name='txtSpamGuardDC'>".($buspamres['guard_dc_remarks'] ? $buspamres['guard_dc_remarks']: '')."</textarea></td>" .
							"<td align='left' class='spamformat'><b>1st Shift </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' onchange=\"autoCalculateSpam('Rates2');\" id='numSpamShift1st' name='numSpamShift1st' value='".($buspamres['shift_1st'] ? $buspamres['shift_1st']: 0)."'/></td>" .
							"<td align='center'><textarea id='txtSpamShift1st' name='txtSpamShift1st'>".($buspamres['shift_1st_remarks'] ? $buspamres['shift_1st_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'><b>Head Guard/<br>Security-in-Charge</b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamGuardSIC' name='numSpamGuardSIC' value='".$guardHG."' readonly onchange=\"autoCalculateSpam('Guards');\"/></td>" .
							"<td align='center'><textarea id='txtSpamGuardSIC' name='txtSpamGuardSIC'>".($buspamres['guard_hg_remarks'] ? $buspamres['guard_hg_remarks']: '')."</textarea></td>" .							
							"<td align='left' class='spamformat'><b>2nd Shift</b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' onchange=\"autoCalculateSpam('Rates2');\" id='numSpamShift2nd' name='numSpamShift2nd' value='".($buspamres['shift_2nd'] ? $buspamres['shift_2nd']: 0)."'/></td>" .
							"<td align='center'><textarea id='txtSpamShift2nd' name='txtSpamShift2nd'>".($buspamres['shift_2nd_remarks'] ? $buspamres['shift_2nd_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'><b>Security Guard</b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamGuardSG' name='numSpamGuardSG' value='".$guardSG."' readonly onchange=\"autoCalculateSpam('Guards');\"/></td>" .
							"<td align='center'><textarea id='txtSpamGuardSG' name='txtSpamGuardSG'>".($buspamres['guard_sg_remarks'] ? $buspamres['guard_sg_remarks']: '')."</textarea></td>" .
							"<td align='left' class='spamformat'><b>3rd Shift</b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamShift3rd' name='numSpamShift3rd' value='".($buspamres['shift_3rd'] ? $buspamres['shift_3rd']: 0)."' /></td>" .
							"<td align='center'><textarea id='txtSpamShift3rd' name='txtSpamShift3rd'>".($buspamres['shift_3rd_remarks'] ? $buspamres['shift_3rd_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'><b>Lady Guard</b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamGuardLG' name='numSpamGuardLG' value='".$guardLG."' readonly onchange=\"autoCalculateSpam('Guards');\"/></td>" .
							"<td align='center'><textarea id='txtSpamGuardLG' name='txtSpamGuardLG'>".($buspamres['guard_lg_remarks'] ? $buspamres['guard_lg_remarks']: '')."</textarea></td>" .
							"<td align='left' class='spamformat'><b>Others</b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamShiftOther' name='numSpamShiftOther' value='".($buspamres['shift_others'] ? $buspamres['shift_others']: 0)."' /></td>" .
							"<td align='center'><textarea id='txtSpamShiftOther' name='txtSpamShiftOther'>".($buspamres['shift_others_remarks'] ? $buspamres['shift_others_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .							
							"<td align='left' class='spamformat'><b>Reliever</b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamGuardReliever' name='numSpamGuardReliever' value='".$guardRel."' readonly /></td>" .
							"<td align='center'><textarea id='txtSpamGuardReliever' name='txtSpamGuardReliever'>".($buspamres['guard_rel_remarks'] ? $buspamres['guard_rel_remarks']: '')."</textarea></td>" .
							"<td align='left' class='spamformat'><b>Security Operations Center</b></td>" .
							"<td align='center'>" . 
								"<select id='selSpamSOC' name='selSpamSOC'>" .
									"<option value = '".($buspamres['security_operations_center'] ? $buspamres['security_operations_center']: 0)."'>".($buspamres['security_operations_center'] ? ($buspamres['security_operations_center'] == 1 ? 'Yes' : 'No'): 'No')."</option>" .
									"<option value = '1'>Yes</option>" .
									"<option value = '0'>No</option>" .
								"</select></td>" .
							"<td align='center'><textarea id='txtSpamSOC' name='txtSpamSOC'>".($buspamres['security_operations_center_remarks'] ? $buspamres['security_operations_center_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .							
							"<td align='left' class='spamformat'><b>TOTAL: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamGuardTotal' name='numSpamGuardTotal' value='".$guardTotal."' readonly /></td>" .
							"<td align='center'><textarea id='txtSpamGuardTotal' name='txtSpamGuardTotal'>".($buspamres['guard_total_remarks'] ? $buspamres['guard_total_remarks']: '')."</textarea></td>" .
							
						"</tr>" .
					"</table>";
	$resulttable .=	"<table id='tblSpamCommunication' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; display:none; border-spacing:0px; padding:0px;\" >" .						
						"<tr>" .
							"<th colspan='3' width='50%' class='whiteonblack' >Communications <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the number of agency/company-owned equipment. If there are company owned, please indicate in the remarks portion how many'></th>" .
							"<th colspan='3' width='50%' class='whiteonblack' >Electronic Surveillance <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the number of agency/company-owned equipment. If there are company owned, please indicate in the remarks portion how many'></th>" .
						"</tr>" .
						
						"<tr>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Base Radio: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamCommBaseRadio' name='numSpamCommBaseRadio' value='".($buspamres['comms_base_radio'] ? $buspamres['comms_base_radio']: 0)."' onchange=\"autoCalculateSpam('Communications');\" /></td>" .
							"<td align='center'><textarea id='txtSpamCommBaseRadio' name='txtSpamCommBaseRadio'>".($buspamres['comms_base_radio_remarks'] ? $buspamres['comms_base_radio_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>CCTV Cameras: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;'id='numSpamSurvCCTV' name='numSpamSurvCCTV' value='".($buspamres['surv_cctv'] ? $buspamres['surv_cctv']: 0)."' onchange=\"autoCalculateSpam('Surveillance');\" /></td>" .
							"<td align='center'><textarea id='txtSpamSurvCCTV' name='txtSpamSurvCCTV'>".($buspamres['surv_cctv_remarks'] ? $buspamres['surv_cctv_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Handheld Radio: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamCommHandRadio' name='numSpamCommHandRadio' value='".($buspamres['comms_hh_radio'] ? $buspamres['comms_hh_radio']: 0)."' onchange=\"autoCalculateSpam('Communications');\" /></td>" .
							"<td align='center'><textarea id='txtSpamCommHandRadio' name='txtSpamCommHandRadio'>".($buspamres['comms_hh_radio_remarks'] ? $buspamres['comms_hh_radio_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>CCTV Cameras w/ motion detection: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamSurvCCTVMotion' name='numSpamSurvCCTVMotion' value='".($buspamres['surv_cctv_motion'] ? $buspamres['surv_cctv_motion']: 0)."' onchange=\"autoCalculateSpam('Surveillance');\" /></td>" .
							"<td align='center'><textarea id='txtSpamSurvCCTVMotion name='txtSpamSurvCCTVMotion'>".($buspamres['surv_cctv_motion_remarks'] ? $buspamres['surv_cctv_motion_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Repeater: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamCommRepeater' name='numSpamCommRepeater' value='".($buspamres['comms_repeater'] ? $buspamres['comms_repeater']: 0)."' onchange=\"autoCalculateSpam('Communications');\" /></td>" .
							"<td align='center'><textarea id='txtSpamCommRepeater' name='txtSpamCommRepeater'>".($buspamres['comms_repeater_remarks'] ? $buspamres['comms_repeater_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Access Control Devices: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamSurvAccess' name='numSpamSurvAccess' value='".($buspamres['surv_access_ctrl'] ? $buspamres['surv_access_ctrl']: 0)."' onchange=\"autoCalculateSpam('Surveillance');\"/></td>" .
							"<td align='center'><textarea id='txtSpamSurvAccess' name='txtSpamSurvAccess'>".($buspamres['surv_access_ctrl_remarks'] ? $buspamres['surv_access_ctrl_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Mobile Phones: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamCommMobile' name='numSpamCommMobile' value='".($buspamres['comms_mobile'] ? $buspamres['comms_mobile']: 0)."' onchange=\"autoCalculateSpam('Communications');\" /></td>" .
							"<td align='center'><textarea id='txtSpamCommMobile' name='txtSpamCommMobile'>".($buspamres['comms_mobile_remarks'] ? $buspamres['comms_mobile_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Intrusion Detection Devices: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamSurvIntrusion' name='numSpamSurvIntrusion' value='".($buspamres['surv_intrusion_det'] ? $buspamres['surv_intrusion_det']: 0)."' onchange=\"autoCalculateSpam('Surveillance');\" /></td>" .
							"<td align='center'><textarea id='txtSpamSurvIntrusion' name='txtSpamSurvIntrusion'>".($buspamres['surv_intrusion_det_remarks'] ? $buspamres['surv_intrusion_det_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Satellite Phones: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamCommSat' name='numSpamCommSat' value='".($buspamres['comms_sat_phones'] ? $buspamres['comms_sat_phones']: 0)."' onchange=\"autoCalculateSpam('Communications');\" /></td>" .
							"<td align='center'><textarea id='txtSpamCommSat' name='txtSpamCommSat'>".($buspamres['comms_sat_phones_remarks'] ? $buspamres['comms_sat_phones_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Watchman's Clock/EPS: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamSurvWatch' name='numSpamSurvWatch' value='".($buspamres['surv_watchman'] ? $buspamres['surv_watchman']: 0)."' onchange=\"autoCalculateSpam('Surveillance');\" /></td>" .
							"<td align='center'><textarea id='txtSpamSurvWatch' name='txtSpamSurvWatch'>".($buspamres['surv_watchman_remarks'] ? $buspamres['surv_watchman_remarks']: '')."</textarea></td>" .							
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Others: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamCommOthers' name='numSpamCommOthers' value='".($buspamres['comms_others'] ? $buspamres['comms_others']: 0)."' onchange=\"autoCalculateSpam('Communications');\" /></td>" .
							"<td align='center'><textarea id='txtSpamCommOthers' name='txtSpamCommOthers'>".($buspamres['comms_others_remarks'] ? $buspamres['comms_others_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Others: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamSurvOthers' name='numSpamSurvOthers' value='".($buspamres['surv_others'] ? $buspamres['surv_others']: 0)."' onchange=\"autoCalculateSpam('Surveillance');\" /></td>" .
							"<td align='center'><textarea id='txtSpamSurvOthers' name='txtSpamSurvOthers'>".($buspamres['surv_others_remarks'] ? $buspamres['surv_others_remarks']: '')."</textarea></td>" .													
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>TOTAL: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamCommTotal' name='numSpamCommTotal' value='".($buspamres['comms_total'] ? $buspamres['comms_total']: 0)."' readonly /></td>" .
							"<td align='center'><textarea id='txtSpamCommTotal' name='txtSpamCommTotal'>".($buspamres['comms_total_remarks'] ? $buspamres['comms_total_remarks']: '')."</textarea></td>" .
							
							"<td align='right' class='spamformat'><b>TOTAL: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamSurvTotal' name='numSpamSurvTotal' value='".($buspamres['surv_total'] ? $buspamres['surv_total']: 0)."' readonly /></td>" .
							"<td align='center'><textarea id='txtSpamSurvTotal' name='txtSpamSurvTotal'>".($buspamres['surv_total_remarks'] ? $buspamres['surv_total_remarks']: '')."</textarea></td>" .													
						"</tr>" .
					"</table>";
	$resulttable .=	"<table id='tblSpamFirearms' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; display:none; border-spacing:0px; padding:0px;\" >" .
						"<tr>" .
							"<th colspan='3' width='50%' class='whiteonblack' >Firearms <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the number of agency/company-owned equipment. If there are company owned, please indicate in the remarks portion how many'></th>" .
							"<th colspan='3' width='50%' class='whiteonblack' >Vehicles <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the number of agency/company-owned equipment. If there are company owned, please indicate in the remarks portion how many'></th>" .
						"</tr>" .
						
						"<tr>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>9mm Pistol: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamFA9mm' name='numSpamFA9mm' value='".($buspamres['fa_9mm'] ? $buspamres['fa_9mm']: 0)."' onchange=\"autoCalculateSpam('Firearms');\" /></td>" .
							"<td align='center'><textarea id='txtSpamFA9mm' name='txtSpamFA9mm'>".($buspamres['fa_9mm_remarks'] ? $buspamres['fa_9mm_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Bicycle: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;'id='numSpamVehicleBicycle' name='numSpamVehicleBicycle' value='".($buspamres['veh_bicycle'] ? $buspamres['veh_bicycle']: 0)."' onchange=\"autoCalculateSpam('Vehicles');\"/></td>" .
							"<td align='center'><textarea id='txtSpamVehicleBicycle' name='txtSpamVehicleBicycle'>".($buspamres['veh_bicycle_remarks'] ? $buspamres['veh_bicycle_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>12-gauge Shotgun: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamFASS' name='numSpamFASS' value='".($buspamres['fa_shotgun'] ? $buspamres['fa_shotgun']: 0)."' onchange=\"autoCalculateSpam('Firearms');\" /></td>" .
							"<td align='center'><textarea id='txtSpamFASS' name='txtSpamFASS'>".($buspamres['fa_shotgun_remarks'] ? $buspamres['fa_shotgun_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>2-wheel Motorcycle: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;'id='numSpamVehicle2W' name='numSpamVehicle2W' value='".($buspamres['veh_2w_mc'] ? $buspamres['veh_2w_mc']: 0)."' onchange=\"autoCalculateSpam('Vehicles');\"/></td>" .
							"<td align='center'><textarea id='txtSpamVehicle2W' name='txtSpamVehicle2W'>".($buspamres['veh_2w_mc_remarks'] ? $buspamres['veh_2w_mc_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>M16: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamFAm16' name='numSpamFAm16' value='".($buspamres['fa_m16'] ? $buspamres['fa_m16']: 0)."' onchange=\"autoCalculateSpam('Firearms');\" /></td>" .
							"<td align='center'><textarea id='txtSpamFAm16' name='txtSpamFAm16'>".($buspamres['fa_m16_remarks'] ? $buspamres['fa_m16_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>4-wheel ATV: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamVehicleATV' name='numSpamVehicleATV' value='".($buspamres['veh_4w_atv'] ? $buspamres['veh_4w_atv']: 0)."' onchange=\"autoCalculateSpam('Vehicles');\" /></td>" .
							"<td align='center'><textarea id='txtSpamVehicleATV' name='txtSpamVehicleATV'>".($buspamres['veh_4w_atv_remarks'] ? $buspamres['veh_4w_atv_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>M4: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamFAm4' name='numSpamFAm4' value='".($buspamres['fa_m4'] ? $buspamres['fa_m4']: 0)."' onchange=\"autoCalculateSpam('Firearms');\" /></td>" .
							"<td align='center'><textarea id='txtSpamFAm4' name='txtSpamFAm4'>".($buspamres['fa_m4_remarks'] ? $buspamres['fa_m4_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>4-wheel Utility/Pick-up: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamVehicle4WPickup' name='numSpamVehicle4WPickup' value='".($buspamres['veh_4w_utility'] ? $buspamres['veh_4w_utility']: 0)."' onchange=\"autoCalculateSpam('Vehicles');\" /></td>" .
							"<td align='center'><textarea id='txtSpamVehicle4WPickup' name='txtSpamVehicle4WPickup'>".($buspamres['veh_4w_utility_remarks'] ? $buspamres['veh_4w_utility_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Others: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamFAOthers' name='numSpamFAOthers' value='".($buspamres['fa_others'] ? $buspamres['fa_others']: 0)."' onchange=\"autoCalculateSpam('Firearms');\" /></td>" .
							"<td align='center'><textarea id='txtSpamFAOthers' name='txtSpamFAOthers'>".($buspamres['fa_others_remarks'] ? $buspamres['fa_others_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Water Crafts: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamVehicleWatercraft' name='numSpamVehicleWatercraft' value='".($buspamres['veh_water_crafts'] ? $buspamres['veh_water_crafts']: 0)."' onchange=\"autoCalculateSpam('Vehicles');\" /></td>" .
							"<td align='center'><textarea id='txtSpamVehicleWatercraft' name='txtSpamVehicleWatercraft'>".($buspamres['veh_water_crafts_remarks'] ? $buspamres['veh_water_crafts_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td ></td>" .
							"<td ></td>" .
							"<td ></td>" .
							"<td align='right' class='spamformat'><b>Ambulance: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamVehicleAmbulance' name='numSpamVehicleAmbulance' value='".($buspamres['veh_ambu'] ? $buspamres['veh_ambu']: 0)."' onchange=\"autoCalculateSpam('Vehicles');\" /></td>" .
							"<td align='center'><textarea id='txtSpamVehicleAmbulance' name='txtSpamVehicleAmbulance'>".($buspamres['veh_ambu_remarks'] ? $buspamres['veh_ambu_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td ></td>" .
							"<td ></td>" .
							"<td ></td>" .
							"<td align='right' class='spamformat'><b>Fire Truck: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamVehicleFiretruck' name='numSpamVehicleFiretruck' value='".($buspamres['veh_fire_truck'] ? $buspamres['veh_fire_truck']: 0)."' onchange=\"autoCalculateSpam('Vehicles');\" /></td>" .
							"<td align='center'><textarea id='txtSpamVehicleFireTruck' name='txtSpamVehicleFireTruck'>".($buspamres['veh_fire_truck_remarks'] ? $buspamres['veh_fire_truck_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td ></td>" .
							"<td ></td>" .
							"<td ></td>" .
							"<td align='right' class='spamformat'><b>Others: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamVehicleOthers' name='numSpamVehicleOthers' value='".($buspamres['veh_others'] ? $buspamres['veh_others']: 0)."' onchange=\"autoCalculateSpam('Vehicles');\" /></td>" .
							"<td align='center'><textarea id='txtSpamVehicleOthers' name='txtSpamVehicleOthers'>".($buspamres['veh_others_remarks'] ? $buspamres['veh_others_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>TOTAL: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamFATotal' name='numSpamFATotal' value='".($buspamres['fa_total'] ? $buspamres['fa_total']: 0)."' readonly /></td>" .
							"<td align='center'><textarea id='txtSpamFATotal' name='txtSpamFATotal'>".($buspamres['fa_total_remarks'] ? $buspamres['fa_total_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>TOTAL: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamVehicleTotal' name='numSpamVehicleTotal' value='".($buspamres['veh_total'] ? $buspamres['veh_total']: 0)."' readonly /></td>" .
							"<td align='center'><textarea id='txtSpamVehicleTotal' name='txtSpamVehicleTotal'>".($buspamres['veh_total_remarks'] ? $buspamres['veh_total_remarks']: '')."</textarea></td>" .
						"</tr>" .
					"</table>";
	// $resulttable .=	"<table id='tblSpamOffice' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; display:none; border-spacing:0px; padding:0px;\" >" .						
						// "<tr>" .
							// "<th colspan='3' width='50%' class='whiteonblack' >Office/Admin <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the number of agency/company-owned equipment. If there are company owned, please indicate in the remarks portion how many'></th>" .
							// "<th colspan='3' width='50%' class='whiteonblack' >Others <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the number of agency/company-owned equipment. If there are company owned, please indicate in the remarks portion how many'></th>" .
						// "</tr>" .
						
						// "<tr>" .
							// "<th></th>" .
							// "<th>#</th>" .
							// "<th>Remarks</th>" .
							// "<th></th>" .
							// "<th>#</th>" .
							// "<th>Remarks</th>" .
						// "</tr>" .
						// "<tr>" .
							// "<td align='right' class='spamformat'><b>Laptop/Desktop Computer: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficeDesktop' name='numSpamOfficeDesktop' value='".($buspamres['office_desktop'] ? $buspamres['office_desktop']: 0)."' onchange=\"autoCalculateSpam('Office');\" /></td>" .
							// "<td align='center'><textarea id='txtSpamOfficeDesktop' name='txtSpamOfficeDesktop'>".($buspamres['office_desktop_remarks'] ? $buspamres['office_desktop_remarks']: '')."</textarea></td>" .
							// "<td align='right' class='spamformat'><b>Metal Detectors: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;'id='numSpamOthersMetalDetector' name='numSpamOthersMetalDetector' value='".($buspamres['others_metal_det'] ? $buspamres['others_metal_det']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							// "<td align='center'><textarea id='txtSpamOthersMetalDetector' name='txtSpamOthersMetalDetector'>".($buspamres['others_metal_det_remarks'] ? $buspamres['others_metal_det_remarks']: '')."</textarea></td>" .
						// "</tr>" .
						// "<tr>" .
							// "<td align='right' class='spamformat'><b>Printer: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficePrinter' name='numSpamOfficePrinter' value='".($buspamres['office_printer'] ? $buspamres['office_printer']: 0)."' onchange=\"autoCalculateSpam('Office');\" /></td>" .
							// "<td align='center'><textarea id='txtSpamOfficePrinter' name='txtSpamOfficePrinter'>".($buspamres['office_printer_remarks'] ? $buspamres['office_printer_remarks']: '')."</textarea></td>" .
							// "<td align='right' class='spamformat'><b>Under-chassis Mirror: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOthersMirror' name='numSpamOthersMirror' value='".($buspamres['others_mirror'] ? $buspamres['others_mirror']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							// "<td align='center'><textarea id='txtSpamOthersMirror' name='txtSpamOthersMirror'>".($buspamres['others_mirror_remarks'] ? $buspamres['others_mirror_remarks']: '')."</textarea></td>" .
						// "</tr>" .
						// "<tr>" .
							// "<td align='right' class='spamformat'><b>Internet Connection: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficeInternet' name='numSpamOfficeInternet' value='".($buspamres['office_internet'] ? $buspamres['office_internet']: 0)."' onchange=\"autoCalculateSpam('Office');\" /></td>" .
							// "<td align='center'><textarea id='txtSpamOfficeInternet' name='txtSpamOfficeInternet'>".($buspamres['office_internet_remarks'] ? $buspamres['office_internet_remarks']: '')."</textarea></td>" .
							// "<td align='right' class='spamformat'><b>K9 Unit: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOthersK9' name='numSpamOthersK9' value='".($buspamres['others_k9'] ? $buspamres['others_k9']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							// "<td align='center'><textarea id='txtSpamOthersK9Unit' name='txtSpamOthersK9Unit'>".($buspamres['others_k9_remarks'] ? $buspamres['others_k9_remarks']: '')."</textarea></td>" .
						// "</tr>" .
						// "<tr>" .
							// "<td align='right' class='spamformat'><b>Others: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficeOthers' name='numSpamOfficeOthers' value='".($buspamres['office_others'] ? $buspamres['office_others']: 0)."' onchange=\"autoCalculateSpam('Office');\" /></td>" .
							// "<td align='center'><textarea id='txtSpamOfficeOthers name='txtSpamOfficeOthers'>".($buspamres['office_others_remarks'] ? $buspamres['office_others_remarks']: '')."</textarea></td>" .
							// "<td align='right' class='spamformat'><b>Others: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOthersOthers' name='numSpamOthersOthers' value='".($buspamres['others_others'] ? $buspamres['others_others']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							// "<td align='center'><textarea id='txtSpamOthersOthers' name='txtSpamOthersOthers'>".($buspamres['others_others_remarks'] ? $buspamres['others_others_remarks']: '')."</textarea></td>" .
						// "</tr>" .
						// "<tr>" .
							// "<td align='right' class='spamformat'><b>TOTAL: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficeTotal' name='numSpamOfficeTotal' value='".($buspamres['office_total'] ? $buspamres['office_total']: 0)."' readonly /></td>" .
							// "<td align='center'><textarea id='txtSpamOfficeTotal name='txtSpamOfficeTotal'>".($buspamres['office_total_remarks'] ? $buspamres['office_total_remarks']: '')."</textarea></td>" .
							// "<td align='right' class='spamformat'><b>TOTAL: </b></td>" .
							// "<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOthersTotal' name='numSpamOthersTotal' value='".($buspamres['others_total'] ? $buspamres['others_total']: 0)."' readonly /></td>" .
							// "<td align='center'><textarea id='txtSpamOthersTotal' name='txtSpamOthersTotal'>".($buspamres['others_total_remarks'] ? $buspamres['others_total_remarks']: '')."</textarea></td>" .
						// "</tr>" .	
					// "</table>";
	$resulttable .=	"<table id='tblSpamOthers' class='spamtable' align='center' width='85%' border='1' style=\"border-collapse:collapse; display:none; border-spacing:0px; padding:0px;\" >" .						
						"<tr>" .
							"<th colspan='3' width='30%' class='whiteonblack' >Office/Admin <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the number of agency/company-owned equipment. If there are company owned, please indicate in the remarks portion how many'></th>" .
							"<th colspan='6' width='70%' class='whiteonblack' >Others <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the number of agency/company-owned equipment. If there are company owned, please indicate in the remarks portion how many'></th>" .
						"</tr>" .
						
						"<tr>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
							"<th></th>" .
							"<th>#</th>" .
							"<th>Remarks</th>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Laptop/Desktop Computer: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficeDesktop' name='numSpamOfficeDesktop' value='".($buspamres['office_desktop'] ? $buspamres['office_desktop']: 0)."' onchange=\"autoCalculateSpam('Office');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOfficeDesktop' name='txtSpamOfficeDesktop'>".($buspamres['office_desktop_remarks'] ? $buspamres['office_desktop_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Metal Detectors: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;'id='numSpamOthersMetalDetector' name='numSpamOthersMetalDetector' value='".($buspamres['others_metal_det'] ? $buspamres['others_metal_det']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersMetalDetector' name='txtSpamOthersMetalDetector'>".($buspamres['others_metal_det_remarks'] ? $buspamres['others_metal_det_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Alcohol Breath Analyzer: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersBreathAnalyzer' name='numSpamOthersBreathAnalyzer' value='".($buspamres['others_breathanalyzer'] ? $buspamres['others_breathanalyzer']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersBreathAnalyzer' name='txtSpamOthersBreathAnalyzer'>".($buspamres['others_breathanalyzer_remarks'] ? $buspamres['others_breathanalyzer_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Printer: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficePrinter' name='numSpamOfficePrinter' value='".($buspamres['office_printer'] ? $buspamres['office_printer']: 0)."' onchange=\"autoCalculateSpam('Office');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOfficePrinter' name='txtSpamOfficePrinter'>".($buspamres['office_printer_remarks'] ? $buspamres['office_printer_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Under-chassis Mirror: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersMirror' name='numSpamOthersMirror' value='".($buspamres['others_mirror'] ? $buspamres['others_mirror']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersMirror' name='txtSpamOthersMirror'>".($buspamres['others_mirror_remarks'] ? $buspamres['others_mirror_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Water Dispenser: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersWaterDispenser' name='numSpamOthersWaterDispenser' value='".($buspamres['others_waterdispenser'] ? $buspamres['others_waterdispenser']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersWaterDispenser' name='txtSpamOthersWaterDispenser'>".($buspamres['others_waterdispenser_remarks'] ? $buspamres['others_waterdispenser_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Internet Connection: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficeInternet' name='numSpamOfficeInternet' value='".($buspamres['office_internet'] ? $buspamres['office_internet']: 0)."' onchange=\"autoCalculateSpam('Office');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOfficeInternet' name='txtSpamOfficeInternet'>".($buspamres['office_internet_remarks'] ? $buspamres['office_internet_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>K9 Unit: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersK9' name='numSpamOthersK9' value='".($buspamres['others_k9'] ? $buspamres['others_k9']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersK9Unit' name='txtSpamOthersK9Unit'>".($buspamres['others_k9_remarks'] ? $buspamres['others_k9_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Bullhorn / Megaphone: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersMegaphone' name='numSpamOthersMegaphone' value='".($buspamres['others_megaphone'] ? $buspamres['others_megaphone']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersMegaphone' name='txtSpamOthersMegaphone'>".($buspamres['others_megaphone_remarks'] ? $buspamres['others_megaphone_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>Others: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficeOthers' name='numSpamOfficeOthers' value='".($buspamres['office_others'] ? $buspamres['office_others']: 0)."' onchange=\"autoCalculateSpam('Office');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOfficeOthers name='txtSpamOfficeOthers'>".($buspamres['office_others_remarks'] ? $buspamres['office_others_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Portable Searchlight: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersSearchlight' name='numSpamOthersSearchlight' value='".($buspamres['others_searchlight'] ? $buspamres['others_searchlight']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersSearchlight' name='txtSpamOthersSearchlight'>".($buspamres['others_searchlight_remarks'] ? $buspamres['others_searchlight_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Steel-toed Shoes: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersSteeltoe' name='numSpamOthersSteeltoe' value='".($buspamres['others_steeltoe'] ? $buspamres['others_steeltoe']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersSteeltoe' name='txtSpamOthersSteeltoe'>".($buspamres['others_steeltoe_remarks'] ? $buspamres['others_steeltoe_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td></td>" .
							"<td></td>" .
							"<td></td>" .
							"<td align='right' class='spamformat'><b>Binoculars: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersBinoculars' name='numSpamOthersBinoculars' value='".($buspamres['others_binoculars'] ? $buspamres['others_binoculars']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersBinoculars' name='txtSpamOthersBinoculars'>".($buspamres['others_binoculars_remarks'] ? $buspamres['others_binoculars_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Hard Hat: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersHardhat' name='numSpamOthersHardhat' value='".($buspamres['others_hardhat'] ? $buspamres['others_hardhat']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersHardhat' name='txtSpamOthersHardhat'>".($buspamres['others_hardhat_remarks'] ? $buspamres['others_hardhat_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td></td>" .
							"<td></td>" .
							"<td></td>" .
							"<td align='right' class='spamformat'><b>Stun Gun: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersStungun' name='numSpamOthersStungun' value='".($buspamres['others_stungun'] ? $buspamres['others_stungun']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersStungun' name='txtSpamOthersStungun'>".($buspamres['others_stungun_remarks'] ? $buspamres['others_stungun_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Digital Camera: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersDigicam' name='numSpamOthersDigicam' value='".($buspamres['others_digicam'] ? $buspamres['others_digicam']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersDigicam' name='txtSpamOthersDigicam'>".($buspamres['others_digicam_remarks'] ? $buspamres['others_digicam_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td></td>" .
							"<td></td>" .
							"<td></td>" .
							"<td align='right' class='spamformat'><b>Trauma / First Aid Kit: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersFirstAid' name='numSpamOthersFirstAid' value='".($buspamres['others_firstaidkit'] ? $buspamres['others_firstaidkit']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersFirstAid' name='txtSpamOthersFirstAid'>".($buspamres['others_firstaidkit_remarks'] ? $buspamres['others_firstaidkit_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Traffic Vest: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersTrafficVest' name='numSpamOthersTrafficVest' value='".($buspamres['others_trafficvest'] ? $buspamres['others_trafficvest']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersTrafficVest' name='txtSpamOthersTrafficVest'>".($buspamres['others_trafficvest_remarks'] ? $buspamres['others_trafficvest_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td></td>" .
							"<td></td>" .
							"<td></td>" .
							"<td align='right' class='spamformat'><b>Rainboots: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersRainboots' name='numSpamOthersRainboots' value='".($buspamres['others_rainboots'] ? $buspamres['others_rainboots']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersRainboots' name='txtSpamOthersRainboots'>".($buspamres['others_rainboots_remarks'] ? $buspamres['others_rainboots_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Fire Equipment: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersFireEquip' name='numSpamOthersFireEquip' value='".($buspamres['others_fireequip'] ? $buspamres['others_fireequip']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersFireEquip' name='txtSpamOthersFireEquip'>".($buspamres['others_fireequip_remarks'] ? $buspamres['others_fireequip_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td></td>" .
							"<td></td>" .
							"<td></td>" .
							"<td align='right' class='spamformat'><b>Raincoat: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersRaincoat' name='numSpamOthersRaincoat' value='".($buspamres['others_raincoat'] ? $buspamres['others_raincoat']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersRaincoat' name='txtSpamOthersRaincoat'>".($buspamres['others_raincoat_remarks'] ? $buspamres['others_raincoat_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Others: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersOthers' name='numSpamOthersOthers' value='".($buspamres['others_others'] ? $buspamres['others_others']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersOthers' name='txtSpamOthersOthers'>".($buspamres['others_others_remarks'] ? $buspamres['others_others_remarks']: '')."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat'><b>TOTAL: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOfficeTotal' name='numSpamOfficeTotal' value='".($buspamres['office_total'] ? $buspamres['office_total']: 0)."' readonly /></td>" .
							"<td align='center'><textarea id='txtSpamOfficeTotal name='txtSpamOfficeTotal'>".($buspamres['office_total_remarks'] ? $buspamres['office_total_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>Gas Mask: </b></td>" .
							"<td align='center'><input type='number' class='spamothers' style='width:40px; text-align:center;' id='numSpamOthersGasmask' name='numSpamOthersGasmask' value='".($buspamres['others_gasmask'] ? $buspamres['others_gasmask']: 0)."' onchange=\"autoCalculateSpam('Others');\" /></td>" .
							"<td align='center'><textarea id='txtSpamOthersGasmask' name='txtSpamOthersGasmask'>".($buspamres['others_gasmask_remarks'] ? $buspamres['others_gasmask_remarks']: '')."</textarea></td>" .
							"<td align='right' class='spamformat'><b>TOTAL: </b></td>" .
							"<td align='center'><input type='number' style='width:40px; text-align:center;' id='numSpamOthersTotal' name='numSpamOthersTotal' value='".($buspamres['others_total'] ? $buspamres['others_total']: 0)."' readonly /></td>" .
							"<td align='center'><textarea id='txtSpamOthersTotal' name='txtSpamOthersTotal'>".($buspamres['others_total_remarks'] ? $buspamres['others_total_remarks']: '')."</textarea></td>" .
						"</tr>" .	
					"</table>";
	$resulttable .=	"<table id='tblSpamRates' class='spamtable' align='center' width='90%' style=\" border:1px solid black; display:none;\" >" .						
						"<tr>" .
							"<th colspan='100%' class='whiteonblack' >Rates <img src='images/help-icon.png' height='15px' style='vertical-align:middle; cursor:pointer;' title='Indicate the current rates in the following items.'></th>" .
							
						"</tr>" .
						
						"<tr>" .
							"<th></th>" .
							"<th>12-hours (Day)</th>" .
							"<th>12-hours (Night)</th>" .
							"<th>9-hours</th>" .
							"<th>10-hours</th>" .
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='left' class='spamformat'>No. of Guards: </td>" .
							"<td align='center'><input type='number' style='text-align:center;' readonly id='txt_rates_no_of_guards_12a' name='txt_rates_no_of_guards_12a' value='".($buspamres['shift_1st'] ? $buspamres['shift_1st']: 0)."' /></td>" .
							"<td align='center'><input type='number' style='text-align:center;' readonly id='txt_rates_no_of_guards_12b' name='txt_rates_no_of_guards_12b' value='".($buspamres['shift_2nd'] ? $buspamres['shift_2nd']: 0)."' /></td>" .
							"<td align='center'><input type='number' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_no_of_guards_9' name='txt_rates_no_of_guards_9' value='".($buspamres['rates_no_of_guards_9'] ? $buspamres['rates_no_of_guards_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_no_of_guards_10' name='txt_rates_no_of_guards_10' value='".($buspamres['rates_no_of_guards_10'] ? $buspamres['rates_no_of_guards_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='lrft' class='spamformat'>Tour of Duty:* <i>(ex: 0600H-1800H)</i></td>" .
							"<td align='center'><input type='text' style='text-align:center; background-color:#f8ffb4;' id='txt_rates_tour_of_duty_12a' name='txt_rates_tour_of_duty_12a' value='".($buspamres['rates_tour_of_duty_12a'] ? $buspamres['rates_tour_of_duty_12a']: '-')."' /></td>" .
							"<td align='center'><input type='text' style='text-align:center; background-color:#f8ffb4;' id='txt_rates_tour_of_duty_12b' name='txt_rates_tour_of_duty_12b' value='".($buspamres['rates_tour_of_duty_12b'] ? $buspamres['rates_tour_of_duty_12b']: '-')."' /></td>" .
							"<td align='center'><input type='text' style='text-align:center; background-color:#f8ffb4;' id='txt_rates_tour_of_duty_9' name='txt_rates_tour_of_duty_9' value='".($buspamres['rates_tour_of_duty_9'] ? $buspamres['rates_tour_of_duty_9']: 'N/A')."' /></td>" .
							"<td align='center'><input type='text' style='text-align:center; background-color:#f8ffb4;' id='txt_rates_tour_of_duty_10' name='txt_rates_tour_of_duty_10' value='".($buspamres['rates_tour_of_duty_10'] ? $buspamres['rates_tour_of_duty_10']: 'N/A')."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>No. of days worked per week:* </td>" .
							"<td align='center'><input type='number' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_days_per_week_12a' name='txt_rates_days_per_week_12a' value='".($buspamres['rates_days_per_week_12a'] ? $buspamres['rates_days_per_week_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_days_per_week_12b' name='txt_rates_days_per_week_12b' value='".($buspamres['rates_days_per_week_12b'] ? $buspamres['rates_days_per_week_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_days_per_week_9' name='txt_rates_days_per_week_9' value='".($buspamres['rates_days_per_week_9'] ? $buspamres['rates_days_per_week_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_days_per_week_10' name='txt_rates_days_per_week_10' value='".($buspamres['rates_days_per_week_10'] ? $buspamres['rates_days_per_week_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>No. of days/year:* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_days_per_year_12a' name='txt_rates_days_per_year_12a' value='".($buspamres['rates_days_per_year_12a'] ? $buspamres['rates_days_per_year_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_days_per_year_12b' name='txt_rates_days_per_year_12b' value='".($buspamres['rates_days_per_year_12b'] ? $buspamres['rates_days_per_year_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_days_per_year_9' name='txt_rates_days_per_year_9' value='".($buspamres['rates_days_per_year_9'] ? $buspamres['rates_days_per_year_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_days_per_year_10' name='txt_rates_days_per_year_10' value='".($buspamres['rates_days_per_year_10'] ? $buspamres['rates_days_per_year_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>Daily Wage:* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_daily_wage_12a' name='txt_rates_daily_wage_12a' value='".($buspamres['rates_daily_wage_12a'] ? $buspamres['rates_daily_wage_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_daily_wage_12b' name='txt_rates_daily_wage_12b' value='".($buspamres['rates_daily_wage_12b'] ? $buspamres['rates_daily_wage_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_daily_wage_9' name='txt_rates_daily_wage_9' value='".($buspamres['rates_daily_wage_9'] ? $buspamres['rates_daily_wage_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_daily_wage_10' name='txt_rates_daily_wage_10' value='".($buspamres['rates_daily_wage_10'] ? $buspamres['rates_daily_wage_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>Cost of Living Allowance (COLA):* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_cola_12a' name='txt_rates_cola_12a' value='".($buspamres['rates_cola_12a'] ? $buspamres['rates_cola_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_cola_12b' name='txt_rates_cola_12b' value='".($buspamres['rates_cola_12b'] ? $buspamres['rates_cola_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_cola_9' name='txt_rates_cola_9' value='".($buspamres['rates_cola_9'] ? $buspamres['rates_cola_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_cola_10' name='txt_rates_cola_10' value='".($buspamres['rates_cola_10'] ? $buspamres['rates_cola_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td colspan='100%'><br></td>" .
						"</tr>" .
						"<tr>" .
							"<td colspan='100%'><b>Rate Distribution</b></td>" .
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='left' class='spamformat'>Basic Average Monthly Salary: </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center;' readonly id='txt_rates_monthly_salary_12a' name='txt_rates_monthly_salary_12a' value='".($buspamres['rates_monthly_salary_12a'] ? $buspamres['rates_monthly_salary_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center;' readonly id='txt_rates_monthly_salary_12b' name='txt_rates_monthly_salary_12b' value='".($buspamres['rates_monthly_salary_12b'] ? $buspamres['rates_monthly_salary_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center;' readonly id='txt_rates_monthly_salary_9' name='txt_rates_monthly_salary_9' value='".($buspamres['rates_monthly_salary_9'] ? $buspamres['rates_monthly_salary_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center;' readonly id='txt_rates_monthly_salary_10' name='txt_rates_monthly_salary_10' value='".($buspamres['rates_monthly_salary_10'] ? $buspamres['rates_monthly_salary_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>Night Differential Pay:* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_night_diff_12a' name='txt_rates_night_diff_12a' value='".($buspamres['rates_night_diff_12a'] ? $buspamres['rates_night_diff_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_night_diff_12b' name='txt_rates_night_diff_12b' value='".($buspamres['rates_night_diff_12b'] ? $buspamres['rates_night_diff_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_night_diff_9' name='txt_rates_night_diff_9' value='".($buspamres['rates_night_diff_9'] ? $buspamres['rates_night_diff_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_night_diff_10' name='txt_rates_night_diff_10' value='".($buspamres['rates_night_diff_10'] ? $buspamres['rates_night_diff_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>5 Days Incentive Leave Pay:* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_incentive_leave_12a' name='txt_rates_incentive_leave_12a' value='".($buspamres['rates_incentive_leave_12a'] ? $buspamres['rates_incentive_leave_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_incentive_leave_12b' name='txt_rates_incentive_leave_12b' value='".($buspamres['rates_incentive_leave_12b'] ? $buspamres['rates_incentive_leave_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_incentive_leave_9' name='txt_rates_incentive_leave_9' value='".($buspamres['rates_incentive_leave_9'] ? $buspamres['rates_incentive_leave_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_incentive_leave_10' name='txt_rates_incentive_leave_10' value='".($buspamres['rates_incentive_leave_10'] ? $buspamres['rates_incentive_leave_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='left' class='spamformat'>13th Month Pay: </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center;' readonly id='txt_rates_13th_mon_12a' name='txt_rates_13th_mon_12a' value='".($buspamres['rates_13th_mon_12a'] ? $buspamres['rates_13th_mon_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center;' readonly id='txt_rates_13th_mon_12b' name='txt_rates_13th_mon_12b' value='".($buspamres['rates_13th_mon_12b'] ? $buspamres['rates_13th_mon_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center;' readonly id='txt_rates_13th_mon_9' name='txt_rates_13th_mon_9' value='".($buspamres['rates_13th_mon_9'] ? $buspamres['rates_13th_mon_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center;' readonly id='txt_rates_13th_mon_10' name='txt_rates_13th_mon_10' value='".($buspamres['rates_13th_mon_10'] ? $buspamres['rates_13th_mon_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>Uniform Allowance (R.A. 5487):* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_uniform_allowance_12a' name='txt_rates_uniform_allowance_12a' value='".($buspamres['rates_uniform_allowance_12a'] ? $buspamres['rates_uniform_allowance_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_uniform_allowance_12b' name='txt_rates_uniform_allowance_12b' value='".($buspamres['rates_uniform_allowance_12b'] ? $buspamres['rates_uniform_allowance_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_uniform_allowance_9' name='txt_rates_uniform_allowance_9' value='".($buspamres['rates_uniform_allowance_9'] ? $buspamres['rates_uniform_allowance_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_uniform_allowance_10' name='txt_rates_uniform_allowance_10' value='".($buspamres['rates_uniform_allowance_10'] ? $buspamres['rates_uniform_allowance_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>Monthly Cost of Living Allowance (COLA):* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_cola_m_12a' name='txt_rates_cola_m_12a' value='".($buspamres['rates_cola_m_12a'] ? $buspamres['rates_cola_m_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_cola_m_12b' name='txt_rates_cola_m_12b' value='".($buspamres['rates_cola_m_12b'] ? $buspamres['rates_cola_m_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_cola_m_9' name='txt_rates_cola_m_9' value='".($buspamres['rates_cola_m_9'] ? $buspamres['rates_cola_m_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_cola_m_10' name='txt_rates_cola_m_10' value='".($buspamres['rates_cola_m_10'] ? $buspamres['rates_cola_m_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>Overtime Pay (4hrs/day):* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_overtime_12a' name='txt_rates_overtime_12a' value='".($buspamres['rates_overtime_12a'] ? $buspamres['rates_overtime_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_overtime_12b' name='txt_rates_overtime_12b' value='".($buspamres['rates_overtime_12b'] ? $buspamres['rates_overtime_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_overtime_9' name='txt_rates_overtime_9' value='".($buspamres['rates_overtime_9'] ? $buspamres['rates_overtime_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_overtime_10' name='txt_rates_overtime_10' value='".($buspamres['rates_overtime_10'] ? $buspamres['rates_overtime_10']: 0)."' /></td>" .
							
						"</tr>" .						
						"<tr class='altrows'>" .
							"<td align='right' class='spamformat' style='text-align:right;'><b>Amount due to Guard:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_amt_due_guard_12a' name='txt_rates_amt_due_guard_12a' value='".($buspamres['rates_amt_due_guard_12a'] ? $buspamres['rates_amt_due_guard_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_amt_due_guard_12b' name='txt_rates_amt_due_guard_12b' value='".($buspamres['rates_amt_due_guard_12b'] ? $buspamres['rates_amt_due_guard_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_amt_due_guard_9' name='txt_rates_amt_due_guard_9' value='".($buspamres['rates_amt_due_guard_9'] ? $buspamres['rates_amt_due_guard_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_amt_due_guard_10' name='txt_rates_amt_due_guard_10' value='".($buspamres['rates_amt_due_guard_10'] ? $buspamres['rates_amt_due_guard_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td colspan='100%'><br></td>" .
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>SSS Premium:* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_sss_premium_12a' name='txt_rates_sss_premium_12a' value='".($buspamres['rates_sss_premium_12a'] ? $buspamres['rates_sss_premium_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_sss_premium_12b' name='txt_rates_sss_premium_12b' value='".($buspamres['rates_sss_premium_12b'] ? $buspamres['rates_sss_premium_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_sss_premium_9' name='txt_rates_sss_premium_9' value='".($buspamres['rates_sss_premium_9'] ? $buspamres['rates_sss_premium_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_sss_premium_10' name='txt_rates_sss_premium_10' value='".($buspamres['rates_sss_premium_10'] ? $buspamres['rates_sss_premium_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>PAG-IBIG Contribution:* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_pagibig_12a' name='txt_rates_pagibig_12a' value='".($buspamres['rates_pagibig_12a'] ? $buspamres['rates_pagibig_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_pagibig_12b' name='txt_rates_pagibig_12b' value='".($buspamres['rates_pagibig_12b'] ? $buspamres['rates_pagibig_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_pagibig_9' name='txt_rates_pagibig_9' value='".($buspamres['rates_pagibig_9'] ? $buspamres['rates_pagibig_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_pagibig_10' name='txt_rates_pagibig_10' value='".($buspamres['rates_pagibig_10'] ? $buspamres['rates_pagibig_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>PhilHealth:* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_philhealth_12a' name='txt_rates_philhealth_12a' value='".($buspamres['rates_philhealth_12a'] ? $buspamres['rates_philhealth_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_philhealth_12b' name='txt_rates_philhealth_12b' value='".($buspamres['rates_philhealth_12b'] ? $buspamres['rates_philhealth_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_philhealth_9' name='txt_rates_philhealth_9' value='".($buspamres['rates_philhealth_9'] ? $buspamres['rates_philhealth_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_philhealth_10' name='txt_rates_philhealth_10' value='".($buspamres['rates_philhealth_10'] ? $buspamres['rates_philhealth_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>State Insurance Fund:* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_state_ins_fund_12a' name='txt_rates_state_ins_fund_12a' value='".($buspamres['rates_state_ins_fund_12a'] ? $buspamres['rates_state_ins_fund_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_state_ins_fund_12b' name='txt_rates_state_ins_fund_12b' value='".($buspamres['rates_state_ins_fund_12b'] ? $buspamres['rates_state_ins_fund_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_state_ins_fund_9' name='txt_rates_state_ins_fund_9' value='".($buspamres['rates_state_ins_fund_9'] ? $buspamres['rates_state_ins_fund_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_state_ins_fund_10' name='txt_rates_state_ins_fund_10' value='".($buspamres['rates_state_ins_fund_10'] ? $buspamres['rates_state_ins_fund_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='left' class='spamformat'>Retirement Benefit (R.A.7641):* </td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_retirement_benefit_12a' name='txt_rates_retirement_benefit_12a' value='".($buspamres['rates_retirement_benefit_12a'] ? $buspamres['rates_retirement_benefit_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_retirement_benefit_12b' name='txt_rates_retirement_benefit_12b' value='".($buspamres['rates_retirement_benefit_12b'] ? $buspamres['rates_retirement_benefit_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_retirement_benefit_9' name='txt_rates_retirement_benefit_9' value='".($buspamres['rates_retirement_benefit_9'] ? $buspamres['rates_retirement_benefit_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_retirement_benefit_10' name='txt_rates_retirement_benefit_10' value='".($buspamres['rates_retirement_benefit_10'] ? $buspamres['rates_retirement_benefit_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='right' class='spamformat' style='text-align:right;'><b>Government dues:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_govt_dues_12a' name='txt_rates_govt_dues_12a' value='".($buspamres['rates_govt_dues_12a'] ? $buspamres['rates_govt_dues_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_govt_dues_12b' name='txt_rates_govt_dues_12b' value='".($buspamres['rates_govt_dues_12b'] ? $buspamres['rates_govt_dues_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_govt_dues_9' name='txt_rates_govt_dues_9' value='".($buspamres['rates_govt_dues_9'] ? $buspamres['rates_govt_dues_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_govt_dues_10' name='txt_rates_govt_dues_10' value='".($buspamres['rates_govt_dues_10'] ? $buspamres['rates_govt_dues_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td colspan='100%'><br></td>" .
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='right' class='spamformat' style='text-align:right;'><b>Total Govt dues and due to Guard:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_total_dues_12a' name='txt_rates_total_dues_12a' value='".($buspamres['rates_total_dues_12a'] ? $buspamres['rates_total_dues_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_total_dues_12b' name='txt_rates_total_dues_12b' value='".($buspamres['rates_total_dues_12b'] ? $buspamres['rates_total_dues_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_total_dues_9' name='txt_rates_total_dues_9' value='".($buspamres['rates_total_dues_9'] ? $buspamres['rates_total_dues_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_total_dues_10' name='txt_rates_total_dues_10' value='".($buspamres['rates_total_dues_10'] ? $buspamres['rates_total_dues_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td align='right' class='spamformat' style='text-align:right;'><b>Percentage Agency Admin Charge:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_agency_percent_12a' name='txt_rates_agency_percent_12a' value='".($buspamres['rates_agency_percent_12a'] ? $buspamres['rates_agency_percent_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_agency_percent_12b' name='txt_rates_agency_percent_12b' value='".($buspamres['rates_agency_percent_12b'] ? $buspamres['rates_agency_percent_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_agency_percent_9' name='txt_rates_agency_percent_9' value='".($buspamres['rates_agency_percent_9'] ? $buspamres['rates_agency_percent_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold; background-color:#f8ffb4;' onchange=\"autoCalculateSpam('Rates2');\" id='txt_rates_agency_percent_10' name='txt_rates_agency_percent_10' value='".($buspamres['rates_agency_percent_10'] ? $buspamres['rates_agency_percent_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='right' class='spamformat' style='text-align:right;'><b>Security Agency Charge:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_agency_charge_12a' name='txt_rates_agency_charge_12a' value='".($buspamres['rates_agency_charge_12a'] ? $buspamres['rates_agency_charge_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_agency_charge_12b' name='txt_rates_agency_charge_12b' value='".($buspamres['rates_agency_charge_12b'] ? $buspamres['rates_agency_charge_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_agency_charge_9' name='txt_rates_agency_charge_9' value='".($buspamres['rates_agency_charge_9'] ? $buspamres['rates_agency_charge_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_agency_charge_10' name='txt_rates_agency_charge_10' value='".($buspamres['rates_agency_charge_10'] ? $buspamres['rates_agency_charge_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='right' class='spamformat' style='text-align:right;'><b>VAT:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_vat_12a' name='txt_rates_vat_12a' value='".($buspamres['rates_vat_12a'] ? $buspamres['rates_vat_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_vat_12b' name='txt_rates_vat_12b' value='".($buspamres['rates_vat_12b'] ? $buspamres['rates_vat_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_vat_9' name='txt_rates_vat_9' value='".($buspamres['rates_vat_9'] ? $buspamres['rates_vat_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_vat_10' name='txt_rates_vat_10' value='".($buspamres['rates_vat_10'] ? $buspamres['rates_vat_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='right' class='spamformat' style='text-align:right;'><b>Total Agency Fee:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_tot_agency_fee_12a' name='txt_rates_tot_agency_fee_12a' value='".($buspamres['rates_tot_agency_fee_12a'] ? $buspamres['rates_tot_agency_fee_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_tot_agency_fee_12b' name='txt_rates_tot_agency_fee_12b' value='".($buspamres['rates_tot_agency_fee_12b'] ? $buspamres['rates_tot_agency_fee_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_tot_agency_fee_9' name='txt_rates_tot_agency_fee_9' value='".($buspamres['rates_tot_agency_fee_9'] ? $buspamres['rates_tot_agency_fee_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_tot_agency_fee_10' name='txt_rates_tot_agency_fee_10' value='".($buspamres['rates_tot_agency_fee_10'] ? $buspamres['rates_tot_agency_fee_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr>" .
							"<td colspan='100%'><br></td>" .
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='left' class='spamformat'><b>Contract Rate per Guard:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_guard_12a' name='txt_rates_contract_per_guard_12a' value='".($buspamres['rates_contract_per_guard_12a'] ? $buspamres['rates_contract_per_guard_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_guard_12b' name='txt_rates_contract_per_guard_12b' value='".($buspamres['rates_contract_per_guard_12b'] ? $buspamres['rates_contract_per_guard_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_guard_9' name='txt_rates_contract_per_guard_9' value='".($buspamres['rates_contract_per_guard_9'] ? $buspamres['rates_contract_per_guard_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_guard_10' name='txt_rates_contract_per_guard_10' value='".($buspamres['rates_contract_per_guard_10'] ? $buspamres['rates_contract_per_guard_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='left' class='spamformat'><b>Contract Rate per Month:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_month_12a' name='txt_rates_contract_per_month_12a' value='".($buspamres['rates_contract_per_month_12a'] ? $buspamres['rates_contract_per_month_12a']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_month_12b' name='txt_rates_contract_per_month_12b' value='".($buspamres['rates_contract_per_month_12b'] ? $buspamres['rates_contract_per_month_12b']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_month_9' name='txt_rates_contract_per_month_9' value='".($buspamres['rates_contract_per_month_9'] ? $buspamres['rates_contract_per_month_9']: 0)."' /></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_month_10' name='txt_rates_contract_per_month_10' value='".($buspamres['rates_contract_per_month_10'] ? $buspamres['rates_contract_per_month_10']: 0)."' /></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='left' class='spamformat'><b>Total Contract Rate per Month:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_tot_contract_per_month' name='txt_rates_tot_contract_per_month' value='".($buspamres['rates_tot_contract_per_month'] ? $buspamres['rates_tot_contract_per_month']: 0)."' /></td>" .
							"<td colspan='100%'></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='left' class='spamformat'><b>Contract Rate for 1 Year:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_year' name='txt_rates_contract_per_year' value='".($buspamres['rates_contract_per_year'] ? $buspamres['rates_contract_per_year']: 0)."' /></td>" .
							"<td colspan='100%'></td>" .
							
						"</tr>" .
						"<tr class='altrows'>" .
							"<td align='left' class='spamformat'><b>Contract Rate for 3 Years:</b></td>" .
							"<td align='center'><input type='number' step='0.01' style='text-align:center; font-weight:bold;' readonly id='txt_rates_contract_per_3yr' name='txt_rates_contract_per_3yr' value='".($buspamres['rates_contract_per_3yr'] ? $buspamres['rates_contract_per_3yr']: 0)."' /></td>" .
							"<td colspan='100%'></td>" .
							
						"</tr>" .
						
					"</table>";	
					if(!$_SESSION['multi-admin']) {


	$resulttable .=	"<table align='center' width='85%' style=\"border-collapse:collapse; border-spacing:0px; padding:0px;\" >" .
						
						"<tr>" .
							"<td align='center'><input id='btnspam' name='btnspam' type='submit' value='Save' class='redbutton'></td>" .							
						"</tr>" .
												
					"</table>" .
				"</form>";
			} 

echo $resulttable;
?>