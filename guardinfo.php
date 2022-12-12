<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
include("class.upload.php-master/src/class.upload.php");

$guardID = $_GET['guardid'];
$clicksource = $_GET['click'];

$addbtnstat = '';
$editbtnstat = '';
$photobtnstat = '';
$viewonly = "";
$disable = "";
$guardBUList = "";

$mainstatadd = "";
$mainstatedit = "";

$guardphoto = "";
$guardlname = "";
$guardfname = "";
$guardmname = "";
$guardgender = "";
$guardbirthdate = "";
$guardage = "";
$guardbloodtype = "";
$guardcivilstatus = "";
$guardpresentaddress = "";
$guardprovincialaddress = "";
$guardcontact = "";
$guardbu = "";
$guardbuname = "";
$guardstatus = "";
$guarddateposted = "";
$guardagencyemployment = "";
$guardcode = "";
$guardcategory = "";
$guardbadgenumber = "";
$guardlicensenumber = "";
$guardlicenseissuedate = "";
$guardlicenseexpirydate = "";
$guardlicenseexpiration = "";
$guardntclicense = "";
$guardntclicensestart = "";
$guardntclicenseend = "";
$guardntclicenseexpiration = "";

if($_SESSION['level'] == 'Super Admin')
{
	$guardBUListSQL = mysqli_query($conn, "SELECT * FROM bu_mst");
	while ($guardBUListRes = mysqli_fetch_assoc($guardBUListSQL))
	{
		$guardBUList .= "<option value='".$guardBUListRes['id']."'>".$guardBUListRes['bu']."</option>";
	}
}
else
{
	$guardBUList = "<option value='".$bu."'>".$headerBu."</option>";
}

if($clicksource == "Add")
{	
	$editbtnstat = 'style="display:none;"';
	$tabstat = "display:none;";
	$guardstatus = "Active";
	$mainstatadd = "Add";
}
elseif($clicksource == "Edit")
{
	$addbtnstat  = 'style="display:none;"';
	$mainstatedit = "Edit";
}
elseif($clicksource == "View")
{
	$addbtnstat  = 'style="display:none;"';
	$editbtnstat = 'style="display:none;"';
	$photobtnstat = 'style="display:none;"';
	$viewonly = "readonly";
	$disable = "disabled";
}

if(($guardID) && ($guardID != 0))
{
	$guardmainsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = ".$guardID);
	$guardmainres = mysqli_fetch_assoc($guardmainsql);
	
	$bumainsql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$guardmainres['bu']);
	$bumainres = mysqli_fetch_assoc($bumainsql);
	
	$guardphoto = $guardmainres['guard_photo'];
	$guardlname = $guardmainres['lname'];
	$guardfname = $guardmainres['fname'];
	$guardmname = $guardmainres['mname'];
	$guardgender = $guardmainres['gender'];
	$guardbirthdate = $guardmainres['birthdate'];
	$guardbloodtype = $guardmainres['blood_type'];
	$guardcivilstatus = $guardmainres['civil_status'];
	$guardpresentaddress = $guardmainres['present_address'];
	$guardprovincialaddress = $guardmainres['provincial_address'];
	$guardcontact = $guardmainres['contact'];
	$guardbu = $guardmainres['bu'];
	$guardbuname = $bumainres['bu'];
	$guardstatus = $guardmainres['status'];
	$guarddateposted = $guardmainres['date_posted'];
	$guardagencyemployment = $guardmainres['agency_employment'];
	$guardcode = $guardmainres['guard_code'];
	$guardcategory = $guardmainres['guard_category'];
	$guardbadgenumber = $guardmainres['badge_number'];
	$guardlicensenumber = $guardmainres['license_number'];
	$guardlicenseissuedate = $guardmainres['license_issue_date'];
	$guardlicenseexpirydate = $guardmainres['license_expiry_date'];
	$guardntclicense = $guardmainres['ntc_license'];
	$guardntclicensestart = $guardmainres['ntc_license_start'];
	$guardntclicenseend = $guardmainres['ntc_license_end'];
	$guardperformance = $guardmainres['performance'];
	$guardcomment = $guardmainres['comment'];
	
	date_default_timezone_set('Asia/Manila');
	$calcbdate = getdate(strtotime($guardbirthdate));
	$calcdatenow = getdate();
	$guardage = $calcdatenow['year'] - $calcbdate['year'];
	if(($calcdatenow['mon'] < $calcbdate['mon']) or (($calcdatenow['mon'] == $calcbdate['mon']) and ($calcdatenow['mday'] < $calcbdate['mday'])))
	{
		$guardage--;
	}
	
	$calcexp = getdate(strtotime($guardlicenseexpirydate));
	$calcexp2 = getdate(strtotime($guardntclicenseend));
	
	$validity = $calcexp['year'] - $calcdatenow['year'];
	$validity2 = 0;
	if(($calcdatenow['mon'] > $calcexp['mon']) or ($calcdatenow['mon'] == $calcexp['mon'] and $calcdatenow['mday'] > $calcexp['mday']))
	{
		$validity--;
		$validity2 = ($calcexp['mon'] + 13) - ($calcdatenow['mon'] + 1);
		
	}
	elseif($calcdatenow['mon'] < $calcexp['mon'])
	{
		$validity2 = ($calcexp['mon'] + 1) - ($calcdatenow['mon'] + 1);
	}
	if($validity2 == 12)
	{
		$validity++;
		$validity2 = 0;
	}
	if($validity < 0)
	{
		$guardlicenseexpiration = "Expired";
	}
	elseif($validity == 0)
	{
		$guardlicenseexpiration = $validity2." mos";
	}
	elseif($validity > 0)
	{
		$guardlicenseexpiration = $validity." yrs ".$validity2." mos";
	}
	
	$validity3 = $calcexp2['year'] - $calcdatenow['year'];
	$validity4 = 0;
	if(($calcdatenow['mon'] > $calcexp2['mon']) or ($calcdatenow['mon'] == $calcexp2['mon'] and $calcdatenow['mday'] > $calcexp2['mday']))
	{
		$validity3--;
		$validity4 = ($calcexp2['mon'] + 13) - ($calcdatenow['mon'] + 1);
		
	}
	elseif($calcdatenow['mon'] < $calcexp2['mon'])
	{
		$validity4 = ($calcexp2['mon'] + 1) - ($calcdatenow['mon'] + 1);
	}
	if($validity4 == 12)
	{
		$validity3++;
		$validity4 = 0;
	}
	if($validity3 < 0)
	{
		$guardntclicenseexpiration = "Expired";
	}
	elseif($validity3 == 0)
	{
		$guardntclicenseexpiration = $validity4." mos";
	}
	elseif($validity3 > 0)
	{
		$guardntclicenseexpiration = $validity3." yrs ".$validity4." mos";
	}
	
}

/* if($guardcategory != "Detachment Commander" || $guardcategory != "Head Guard" || $guardcategory != "Security Guard" || $guardcategory != "Lady Guard")
{
	$guardcategory = "";
} */

if($guardcategory == "Detachment Commander")
{
	$guardcategory2 = "DC/ADC";
}
elseif($guardcategory == "Head Guard")
{
	$guardcategory2 = "Head Guard/SIC";
}
else
{
	$guardcategory2 = $guardcategory;
}


$divcontent = '<form id="addguardform" name="addguardform" method="post" action="main-post.php" enctype="multipart/form-data">
					<table width="75%" align="center" bgcolor="#ededed" border="1px">
						<tr valign="top">
							<td class="guardphototd" style="border-width:0px; width:200px;">					
								<fieldset style="border-width:thin">					
								<legend style="font-weight:bold">Photo</legend>						
									<table align="center">
										<tr>
											<td align="center">
												<img src="'.$guardphoto.'" id="guardpicbox" style="width:150px;" alt="No Photo"/>
											</td>
										</tr>
										<tr '.$photobtnstat.'>
											<td>
												Upload / Change Photo:<br />
												<input type="file" name="guardpic"/>                             
											</td>
										</tr>
									</table>							
								</fieldset>
								<br>
								<table align="center" width="100%" border="1" style="border-collapse:collapse;">
									<tr>
										<td align="center"><label style="font-weight:bold; cursor:pointer;" onclick="toggleTabs(\'guardpersonaltab\', \'guardmaintabs\');">Personal Information</label></td>
									</tr>
									<tr>
										<td align="center"><label style="font-weight:bold; cursor:pointer;" onclick="toggleTabs(\'guardsecuritytab\', \'guardmaintabs\');">Security Information</label></td>
									</tr>
									
								</table>
								<br>
								<table align="center">
									<tr id="trguardstat">
										<td>Status:</td>
										<td>
											<select id="selgstat" name="selgstat" required="required" class="addguards" '.$disable.' >
												<option value="'.$guardstatus.'">'.$guardstatus.'</option>
												<option value="Active">Active</option>
												<option value="Inactive">Inactive</option>
											</select>
										</td>
									</tr>
								</table>
							</td>
							<td style="border-width:0px;">
								<fieldset class="guardmaintabs" id="guardpersonaltab" style="border-width:thin">					
									<legend style="font-weight:bold">Personal Information</legend>
									<table>
										<tr>
											<td>Last Name:</td>
											<td>
												<input type="text" id="txtguardid" name="txtguardid" required="required" readonly="readonly" style="display:none;" value="'.$guardID.'" />
												<input type="text" id="txtglname" name="txtglname" required="required" class="addguards" value="'.$guardlname.'" '.$viewonly.' />
											</td>
										</tr>
										<tr>
											<td>First Name:</td>
											<td><input type="text" id="txtgfname" name="txtgfname" required="required" class="addguards" value="'.$guardfname.'" '.$viewonly.' /></td>
										</tr>
										
										<tr>
											<td>Business Unit:</td>
											<td>												
												<select id="txtgbu" name="txtgbu" required="required" class="addguards" '.$disable.' >
													<option value="'.$guardbu.'">'.$guardbuname.'</option>
													'.$guardBUList.'
												</select>
											</td>
										</tr>
										<tr>
											<td>Date posted in Aboitiz Group:</td>
											<td><input type="date" id="txtgposted" name="txtgposted" required="required" class="addguards" value="'.$guarddateposted.'" '.$viewonly.' /></td>
										</tr>
									</table>
								</fieldset>						
								
								<fieldset class="guardmaintabs" id="guardsecuritytab" style="border-width:thin; display:none;">
									<legend style="font-weight:bold">Security Information</legend>
									<table>
										<tr>
											<td>Guard Code:</td>
											<td><input type="text" id="txtgcode" name="txtgcode" required="required" class="addguards" value="'.$guardcode.'" '.$viewonly.' /></td>
										</tr>
										<tr> 
											<td style="width:140px;"><label>Guard Category:</label></td>
											<td>
												<select id="txtgcategory" name="txtgcategory" required="required" class="addguards" '.$viewonly.' >
													<option value="'.$guardcategory.'">'.$guardcategory2.'</option>
													<option value="Detachment Commander">DC/ADC</option>
													<option value="Head Guard">Head Guard/SIC</option>
													<option value="Security Guard">Security Guard</option>
													<option value="Lady Guard">Regular Lady Guard</option>
													<option value="Reliever">Reliever</option>
													<option value="Intel Collector">Intel Collector</option>
													<option value="Temporary">Temporary</option>
													<option value="External">External</option>
												</select>												
											</td>
											
										</tr>										
										<tr>
											<td colspan="100%">
												<table>
													<tr>
														<th>License</th>
														<th>License No.</th>
														<th>Issue Date</th>
														<th>Expiry Date</th>
														<th>Validity</th>
													</tr>
													<tr>
														<td>License</td>
														<td><input type="text" id="txtglicense" name="txtglicense" required="required" class="addguards" value="'.$guardlicensenumber.'" '.$viewonly.' /></td>
														<td><input type="date" id="txtglicenseissue" name="txtglicenseissue" required="required" onchange="expiration();" class="addguards" value="'.$guardlicenseissuedate.'" '.$viewonly.' /></td>
														<td><input type="date" id="txtglicenseexpiry" name="txtglicenseexpiry" required="required" onchange="expiration();" class="addguards" value="'.$guardlicenseexpirydate.'" '.$viewonly.' /></td>
														<td><input type="text" id="txtgremaining" name="txtgremaining" value="'.$guardlicenseexpiration.'" readonly="readonly" /></td>
													</tr>
													<tr>
														<td>NTC License</td>
														<td><input type="text" id="txtgntclicense" name="txtgntclicense" required="required" class="addguards" value="'.$guardntclicense.'" '.$viewonly.' /></td>
														<td><input type="date" id="txtgntclicenseissue" name="txtgntclicenseissue" required="required" onchange="expiration2();" class="addguards" value="'.$guardntclicensestart.'" '.$viewonly.' /></td>
														<td><input type="date" id="txtgntclicenseexpiry" name="txtgntclicenseexpiry" required="required" onchange="expiration2();" class="addguards" value="'.$guardntclicenseend.'" '.$viewonly.'/></td>
														<td><input type="text" id="txtntcgremaining" name="txtntcgremaining" value="'.$guardntclicenseexpiration.'" readonly="readonly" /></td>
													</tr>											
												</table>
											</td>
										</tr>
										<tr>
											<td>Performance Standing:</td>
											<td width="50%">
												<select id="selgperformance" name="selgperformance" required class="addguards">
													<option value="'.$guardperformance.'">'.$guardperformance.'</option>
													<option value="Good">Good</option>
													<option value="Bad">Bad</option>
												</select>
											</td>
										</tr>
										<tr>                        	
											<td colspan="2" valign="top">Comment:<textarea id="gcomment" name="gcomment" style="resize:none; height:100px; width:100%;" class="addguards" >'.$guardcomment.'</textarea></td>
										</tr>
									</table>
								</fieldset>								
							</td>					
						</tr>
						<tr>
							<td colspan="100%" style="border-width:0px;">
								<table align="right">
									<tr>
										<td>
											<input type="hidden" id="editguardstat" name="editguardstat" value="'.$mainstatedit.'">
											<input type="hidden" id="addguardstat" name="addguardstat" value="'.$mainstatadd.'">
											<button id="btneditguard" name="btneditguard" class="redbutton" '.$editbtnstat.' onclick="guardInfoCheck();"; >Edit</buttom>
											<button id="btnsaveguard" name="btnsaveguard" class="redbutton" '.$addbtnstat .' onclick="guardInfoCheck();";>Save</button>
											<button id="gback" name="gback" class="redbutton" onclick="guardBack();">Cancel</button>											
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>';


if(!empty($divcontent))
{
	echo $divcontent;	
}
else
{	
	echo "<tr><td colspan=\"100%\" align=\"center\">Record not found</td></tr>";
}
?>