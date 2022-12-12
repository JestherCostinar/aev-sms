<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aboitiz | Security Management System</title>
<script src="javascript/jquery-1.11.3.min.js"></script>
<script src="javascript/jquery-ui.min.js"></script>
<script type="text/javascript" src="javascript/md5-min.js"></script>
<link rel="stylesheet" href="jquery-ui.css" />

<style>
  .no-close .ui-dialog-titlebar-close {
  display: none;
}
	.ui-autocomplete {
    max-height: 100px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
</style>
<link href="styles.css" rel="stylesheet" />
<script src="javascript/OSLS.js?v=$jsrefresh"></script>
</head>

<body>
<div class="container">
  <div id="topbar">
    <table height="80px" width="100%" bgcolor="#000000">
      <tr>
        <td width="20%"><img src="images/header3.png" alt="Aboitiz logo" style="background:black; width:100%"/></td>
        <td width="80%" align="right" valign="top" style="color:#FFF">Logged in as $displayUsername ($displayLevel)<br /><a href="logout.php" style="color:#FFF">Logout</a></td>
      </tr>
    </table>
  </div>
  <div style="height:20px; width:100%; background-color:#CCC;">
  	
  </div>
  <div class="sidebar1">
    <font color="#FFFFFF">
    <ul>
      <li style="font-size:1.5em;">$displayBUName</li>
      <ul style="padding-left:10px">
      <li class="lists" onclick="toggleMenu('subEntries');">Entries</li>
        <ul id="subEntries" style="display:none;">
          <li class="lists" id="listact" style="text-decoration:underline; font-weight:bold" onclick="toggleMe('Activities', 'listact');">Activities</li>
          <li class="lists" id="listinc" onclick="toggleMe('Incidents', 'listinc')">Incidents</li>
        </ul>
      <li class="lists" id="listgmgt" onclick="toggleMe('GuardMgt', 'listgmgt')">Guard Management</li>
      <li class="lists" onclick="toggleMenu('subTools');">Tools</li>
    	<ul id="subTools" style="display:none;">
          <li class="lists" id="listcmgt" onclick="toggleMe('CodeMgt', 'listcmgt')">Code Management</li>
        </ul>
      <li class="lists" onclick="toggleMenu('subAccount');">Account</li>
        <ul id="subAccount" style="display:none;">
          <li class="lists" id="listprof" onclick="toggleMe('Profile', 'listprof')">My Profile</li>
        </ul>
        </ul>
    </ul> 
    </font>
  </div>
  <div class="multi">
  	<div id="addGuard" style="display:none;">
		<div id="divAddGuardContent">
    	
		</div>
    </div>
  	<div id="closeincidentmodal" style="padding-top:24px; display:none">
		<!-- <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeCloseIncident();" />
		<form id="closeincidentform" name="closeincidentform" method="post" action="user.php">
			  <div id="involvedsection">
			  <center>
			  <fieldset style="display:inline-block; ">
			  <legend style="font-weight:bold" >Person(s) Involved</legend>
			  <table align="center">
				<tr>
					<td colspan="2">
					  
					  <input type="hidden" id="iclassificationsall" name="iclassificationsall" />
					  
					  <input type="hidden" id="iwfnamesall" name="iwfnamesall" />
					  <input type="hidden" id="isfnamesall" name="isfnamesall" />
					  <input type="hidden" id="ivfnamesall" name="ivfnamesall" />
					  <input type="hidden" id="ifnamesall" name="ifnamesall" />
					  
					  <input type="hidden" id="iwmnamesall" name="iwmnamesall" />
					  <input type="hidden" id="ismnamesall" name="ismnamesall" />
					  <input type="hidden" id="ivmnamesall" name="ivmnamesall" />
					  <input type="hidden" id="imnamesall" name="imnamesall" />
					  
					  <input type="hidden" id="iwlnamesall" name="iwlnamesall" />
					  <input type="hidden" id="islnamesall" name="islnamesall" />
					  <input type="hidden" id="ivlnamesall" name="ivlnamesall" />
					  <input type="hidden" id="ilnamesall" name="ilnamesall" />
					  
					  <input type="hidden" id="iwaddressall" name="iwaddressall" />
					  <input type="hidden" id="isaddressall" name="isaddressall" />
					  <input type="hidden" id="ivaddressall" name="ivaddressall" />
					  <input type="hidden" id="iaddressall" name="iaddressall" />
					  
					  <input type="hidden" id="iwcontactsall" name="iwcontactsall" />
					  <input type="hidden" id="iscontactsall" name="iscontactsall" />
					  <input type="hidden" id="ivcontactsall" name="ivcontactsall" />
					  <input type="hidden" id="icontactsall" name="icontactsall" />				  
					  
					  <input type="hidden" id="iwageall" name="iwageall" />
					  <input type="hidden" id="isageall" name="isageall" />
					  <input type="hidden" id="ivageall" name="ivageall" />
					  <input type="hidden" id="iageall" name="iageall" />
					  
					  <input type="hidden" id="iwgenderall" name="iwgenderall" />
					  <input type="hidden" id="isgenderall" name="isgenderall" />
					  <input type="hidden" id="ivgenderall" name="ivgenderall" />
					  <input type="hidden" id="igenderall" name="igenderall" />
					  
					  <input type="hidden" id="iwheightall" name="iwheightall" />
					  <input type="hidden" id="isheightall" name="isheightall" />
					  <input type="hidden" id="ivheightall" name="ivheightall" />
					  <input type="hidden" id="iheightall" name="iheightall" />
					  
					  <input type="hidden" id="iwweightall" name="iwweightall" />
					  <input type="hidden" id="isweightall" name="isweightall" />
					  <input type="hidden" id="ivweightall" name="ivweightall" />
					  <input type="hidden" id="iweightall" name="iweightall" />
					  
					  <input type="hidden" id="iwidtypeall" name="iwidtypeall" />
					  <input type="hidden" id="isidtypeall" name="isidtypeall" />
					  <input type="hidden" id="ividtypeall" name="ividtypeall" />
					  <input type="hidden" id="iidtypeall" name="iidtypeall" />
					  
					  <input type="hidden" id="iwidnumberall" name="iwidnumberall" />
					  <input type="hidden" id="isidnumberall" name="isidnumberall" />
					  <input type="hidden" id="ividnumberall" name="ividnumberll" />
					  <input type="hidden" id="iidnumberall" name="iidnumberll" />
					  
					  <input type="hidden" id="iwremarksall" name="iwremarksall" />
					  <input type="hidden" id="isremarksall" name="isremarksall" />
					  <input type="hidden" id="ivremarksall" name="ivremarksall" />
					  <input type="hidden" id="iremarksall" name="iremarksall" />
					  
					  <input type="hidden" id="checkVehicle" name="checkVehicle" />
					  <input type="hidden" id="checkDamage" name="checkDamage" />
					  <input type="hidden" id="checkCF" name="checkCF" />
					</td>
				</tr>
				<tr>
					<td>Classification:*</td>
					<td>
						<select id="selClassification" name="selClassification" class="involvedrows">
							<option value=""></option>
							<option value="Suspect">Suspect</option>
							<option value="Victim">Victim</option>
							<option value="Witness">Witness</option>
							<option value="Non-compliant">Non-compliant</option>
							<option value="Medical/Emergency">Medical/Emergency</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>First Name:*</td>
					<td align="left"><input type="text" id="witfname" name="witfname" class="involvedrows" />*</td>
				</tr>
				<tr>
					<td>Middle Name:</td>
					<td align="left">
					  <input type="text" id="witmname" name="witmname" class="involvedrows" />
					  <input type="text" id="swid" name="swid" readonly="readonly" style="display:none;" />
					</td>
				</tr>
				<tr>
					<td>Last Name:*</td>
					<td align="left"><input type="text" id="witlname" name="witlname" class="involvedrows" />*</td>
				</tr>
				<tr>
					<td>Address:</td>
					<td align="left"><textarea id="witadd" name="witadd" style="resize:none" class="involvedrows"></textarea></td>
				</tr>
				<tr>
					<td>Contact Number:</td>
					<td align="left"><input type="text" id="witcontact" name="witcontact"  class="involvedrows"></td>
				</tr>
				<tr>
					<td>Age:</td>
					<td align="left"><input type="number" id="witage" name="witage" style="width:4em" class="involvedrows"/></td>
				</tr>
				<tr>
					<td>Gender:</td>
					<td align="left">
						<select id="witgender" name="witgender" class="involvedrows">
							<option value=""></option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Height:</td>
					<td align="left">
						<input type="number" id="witheight" name="witheight" style="width:5em" class="involvedrows" /> cm / 
						<input type="text" id="witheightft" name="witheightft" size="3" class="involvedrows" /> ft. 
						<input type="text" id="witheightin" name="witheightin" size="3" class="involvedrows" /> in.
					</td>
				</tr>
				<tr>
					<td>Weight:</td>
					<td align="left"><input type="text" id="witweight" name="witweight" size="3" class="involvedrows"/> kg</td>
				</tr>
				<tr>
					<td>ID Type:</td>
					<td align="left">
						<select id="witidtype" name="witidtype" class="involvedrows">
							<option value=""></option>
							<option value="Passport">Passport</option>
							<option value="Driver's License">Driver's License</option>
							<option value="PRC ID">PRC ID</option>
							<option value="Postal ID">Postal ID</option>
							<option value="Voter's ID">Voter's ID</option>
							<option value="GSIS ID">GSIS ID</option>
							<option value="SSS ID">SSS ID</option>
							<option value="IBP ID">IBP ID</option>
							<option value="Senior Citizen's ID">Senior Citizen's ID</option>
							<option value="Unified Multi Purpose ID">Unified Multi Purpose ID</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>ID Number:</td>
					<td align="left"><input type="text" id="witidnumber" name="witidnumber" class="involvedrows"/></td>
				</tr>
				<tr>
					<td>Remarks:</td>
					<td align="left"><textarea id="witremarks" name="witremarks" style="resize:none" class="involvedrows"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><img src="images/add_btn.png" width="90px" onclick="addInvolved2();" style="cursor:pointer;" /></td>
					
				</tr>                 
			</table>
			</fieldset>
			</center>
			<br />
		  
			  <table id="tblwitness" align="center" border="1" width="95%" style="border-collapse:collapse; display:none;">
				  <thead>
				  <tr>
					  <th colspan="100%">Witnesses</th>
				  </tr>
				  <tr class="whiteonblack">
					  <th>First Name</th>
					  <th>Middle Name</th>
					  <th>Last Name</th>
					  <th>Address</th>
					  <th>Contact</th>
					  <th>Age</th>
					  <th>Gender</th>
					  <th>Height</th>
					  <th>Weight</th>
					  <th>ID Type</th>
					  <th>ID Number</th>
					  <th>Remarks</th>
					  <th></th>
				  </tr>
				  </thead>
				  <tbody id="tblwitnesstbody">
				  </tbody>
				  
			  </table>
			  <br />
			  <table id="tblsuspect" align="center" border="1" width="95%" style="border-collapse:collapse; display:none;">
				  <thead>
				  <tr>
					  <th colspan="100%">Suspects</th>
				  </tr>
				  <tr class="whiteonblack">
					  <th>First Name</th>
					  <th>Middle Name</th>
					  <th>Last Name</th>
					  <th>Address</th>
					  <th>Contact</th>
					  <th>Age</th>
					  <th>Gender</th>
					  <th>Height</th>
					  <th>Weight</th>
					  <th>ID Type</th>
					  <th>ID Number</th>
					  <th>Remarks</th>
					  <th></th>
				  </tr>
				  </thead>
				  <tbody id="tblsuspectbody">
				  </tbody>
				  
			  </table>
			  <br />
			  <table id="tblvictim" align="center" border="1" width="95%%" style="border-collapse:collapse; display:none;">
					<thead>
						<tr>
							<th colspan="100%">Victims</th>
						</tr>
						<tr class="whiteonblack">
							<th>First Name</th>
							<th>Middle Name</th>
							<th>Last Name</th>
							<th>Address</th>
							<th>Contact</th>
							<th>Age</th>
							<th>Gender</th>
							<th>Height</th>
							<th>Weight</th>
							<th>ID Type</th>
							<th>ID Number</th>
							<th>Remarks</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="tblvictimtbody">
					</tbody>              
				</table>
				<table id="tblinvolved" align="center" border="1" width="95%" style="border-collapse:collapse; display:none;">
				  <thead>
					  <tr>
						  <th colspan="100%">Involved Persons</th>
					  </tr>
					  <tr class="whiteonblack">
						  <th>Classification</th>
						  <th>First Name</th>
						  <th>Middle Name</th>
						  <th>Last Name</th>
						  <th>Address</th>
						  <th>Contact</th>
						  <th>Age</th>
						  <th>Gender</th>
						  <th>Height</th>
						  <th>Weight</th>
						  <th>ID Type</th>
						  <th>ID Number</th>
						  <th>Remarks</th>
						  <th></th>
					  </tr>
				  </thead>
				  <tbody id="tblinvolvedtbody">
				  </tbody>
				  
			  </table>
				<table width="95%">
					<tr>
						<td align="right"><img src="images/next_btn.png" width="90px" style="cursor:pointer;" onclick="showNext();" /></td>
					</tr>
				</table>
				</div>
				<div id="otherdetails" style="display:none">
					<table align="center">
						<tr>
							<td valign="top">
								<fieldset>
									<legend style="font-weight:bold; text-align:left"><input type="checkbox" id="chkboxVehicle" name="chkboxVehicle" value="1" onclick="checkOtherDetails();" />Vehicle Used</legend>
									<table>
										<tr>
											<td>Owner:</td>
											<td><input type="text" id="txtvowner" name="txtvowner" class="fieldsVehicle" disabled="disabled" /></td>
										</tr>
										<tr>
											<td>Plate Number:</td>
											<td><input type="text" id="txtvplateno" name="txtvplateno" class="fieldsVehicle" disabled="disabled" /></td>
										</tr>
										<tr>
											<td>Type:</td>
											<td>
												
												<select id="selvtype" name="selvtype" class="fieldsVehicle" disabled="disabled">
													<option value=""></option>
													<option value="Bicycle">Bicycle</option>
													<option value="Motorcycle">Motorcycle</option>
													<option value="Tricycle">Tricycle</option>
													<option value="4-wheeled Vehicle">4-wheeled Vehicle</option>
													<option value="Delivery Truck">Delivery Truck</option>
													<option value="Others">Others</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>Make:</td>
											<td><input type="text" id="txtvmake" name="txtvmake" title="ex: Toyota, Isuzu, etc." class="fieldsVehicle" disabled="disabled" /></td>
										</tr>
										<tr>
											<td>Model:</td>
											<td><input type="text" id="txtvmodel" name="txtvmodel" class="fieldsVehicle" disabled="disabled" /></td>
										</tr>
										<tr>
											<td>Color:</td>
											<td><input type="text" id="txtvcolor" name="txtvcolor" class="fieldsVehicle" disabled="disabled" /></td>
										</tr>
										<tr>
											<td>Remarks:</td>
											<td><textarea id="txtvremarks" name="txtvremarks" class="fieldsVehicle" disabled="disabled" style="resize:none;"></textarea></td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<img src="images/add_btn.png" width="90px" onclick="addVehicle();" style="cursor:pointer;" />
												<input type="hidden" id="vOwnerAll" name="vOwnerAll" />
												<input type="hidden" id="vPlateNoAll" name="vPlateNoAll" />
												<input type="hidden" id="vTypeAll" name="vTypeAll" />
												<input type="hidden" id="vMakeAll" name="vMakeAll" />
												<input type="hidden" id="vModelAll" name="vModelAll" />
												<input type="hidden" id="vColorAll" name="vColorAll" />
												<input type="hidden" id="vRemarksAll" name="vRemarksAll" />
											</td>
										</tr>
									</table>
								</fieldset>
								
						  </td>
						  <td valign="top">
							<fieldset>
							<legend style="font-weight:bold"><input type="checkbox" id="chkboxCounterfeit" name="chkboxCounterfeit" value="1" onclick="checkOtherDetails();" />Counterfeit Details</legend>
								<table>
									<tr>
										<td>Account Name:</td>
										<td>
											<input type="text" id="txtcfaccname" name="txtcfaccname" class="fieldsCounterfeit" disabled="disabled" />
										</td>
									</tr>
									<tr>
										<td>Account ID:</td>
										<td><input type="text" id="txtcfaccid" name="txtcfaccid" class="fieldsCounterfeit" disabled="disabled" /></td>
									</tr>
									<tr>
										<td>Customer Representative:</td>
										<td><input type="text" id="txtcfcrep" name="txtcfcrep" class="fieldsCounterfeit" disabled="disabled" /></td>
									</tr>
									<tr>
										<td>Address of Incident:</td>
										<td><input type="text" id="txtcfadd" name="txtcfadd" class="fieldsCounterfeit" disabled="disabled" /></td>
									</tr>                                
									<tr>
										<td>Amount:</td>
										<td><input type="number" id="txtcfamount" name="txtcfamount" class="fieldsCounterfeit" disabled="disabled" /></td>
									</tr>
									<tr>
										<td>Counterfeit Bill Serial:</td>
										<td><input type="text" id="txtcfbill" name="txtcfbill" class="fieldsCounterfeit" disabled="disabled" /></td>
									</tr>
									<tr>
										<td>Relationship:</td>
										<td><input type="text" id="txtcfrelate" name="txtcfrelate" class="fieldsCounterfeit" disabled="disabled" /></td>
									</tr>
								</table>
							</fieldset>
							<fieldset>
								<legend style="font-weight:bold"><input type="checkbox" id="chkboxDamage" name="chkboxDamage" value="1" onclick="checkOtherDetails();" />Damage</legend>
									<table>
										<tr>
											<td>Cost of Damage:</td>
											<td><input type="number" id="txtdmgcost" name="txtdmgcost" class="fieldsDamage" disabled="disabled" /></td>
										</tr>
										<tr>
											<td>Type of Loss:</td>
											<td>
												<select id="sellosstype" name="sellosstype" class="fieldsDamage" disabled="disabled">
													<option value=""></option>
													<option value="Loss Recovered">Loss Recovered</option>
													<option value="Loss Unrecovered">Loss Unrecovered</option>
													<option value="Loss Prevented">Loss Prevented</option>
													<option value="Not Applicable">Not Applicable</option>
												</select>
											</td>
										</tr>
									</table>
								</fieldset>
						  </td>
					  </tr>
										
				  </table>
				  <br />
			  <table id="tblvehicle" align="center" border="1" width="95%" style="border-collapse:collapse; display:none; ">
				  <thead>
				  <tr>
					  <th colspan="100%">Vehicles</th>
				  </tr>
				  <tr class="whiteonblack">
					  <th>Owner</th>
					  <th width="12%">Plate Number</th>
					  <th width="12%">Type</th>
					  <th width="12%">Make</th>
					  <th width="12%">Model</th>
					  <th width="12%">Color</th>                  
					  <th>Remarks</th>
					  <th></th>
				  </tr>
				  </thead>
				  <tbody id="tblvehicletbody">
				  </tbody>
				  
			  </table>
			  <br />
			  <table align="center">
					<tr>
						<td colspan="2" align="right"><img src="images/back_btn.png" width="85px" style="cursor:pointer;" onclick="showPrev();" /><img src="images/next_btn.png" width="85px" style="cursor:pointer;" onclick="showNext();" /></td>
					</tr>
				</table>
			  </div>
			  <div id="divDisposition" style="display:none">
				<table width="50%" align="center">
					<tr>
						<td>
							<fieldset>
								<legend style="font-weight:bold">Disposition</legend>
								<textarea id="txtIncidentDisposition" name="txtIncidentDisposition" style="resize:none; width:100%"></textarea>
							</fieldset>
						</td>
					</tr>                
					<tr>
						<td align="right">
							<img src="images/back_btn.png" width="85px" style="cursor:pointer;" onclick="showPrev();" />
							<img src="images/confirm_btn.png" width="85px" style="cursor:pointer;" onclick="saveCloseIncident();" />
						</td>
					</tr>
				</table>
			  </div>
		</form>  -->         
    </div>
  	<div id="AddActivity" class="ui-front" style="display:none; padding-top:30px; padding-bottom:30px">
    <img id="back" src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" />
    <table width="95%" border="1" align="center" style="border-collapse:collapse; padding-top:24px;" >
      <tr bgcolor="#000" style="color:#FFF;">
        <th width="10%">Ticket ID</th>
        <th width="15%">Date</th>
        <th id="logtitle">Activity Name</th>
		<th width="10%">Severity</th>
        
      </tr>
      <tr align="center">
        <td id="ticketID">TESTID</td>
        <td id="ticketDate">TestDate</td>
        <td id="ticketName">Test Description</td>
		<td id="ticketSeverity">Pending</td>
        
      </tr>
      <tr>
      	<td colspan="6" align="center">
        <div class="logs2" style="display:block;">
        <form id="addForm" method="post" action="user.php" enctype="multipart/form-data">
        	<table width="100%">
                  <tr>
                      <td width="40%" valign="top" style="padding-top:25px;">
							<table width="100%">                              
								<tr>                               
									<td width="30%">URC:</td>
									<td width="70%">
										<select id="txturc" name="txturc">
											$urcdatalist
										</select>
									</td> 
								  
								</tr>
								
								<tr>
									<td width="30%">Date:</td>
									
									<td width="70%"><input type="date" id="date" name="date" value="$logdate" /></td>
								</tr>
								<tr>
									<td width="30%">Time:</td>
									<td width="70%"><input type="text" id="time" name="time" value="$logtime" autocomplete="off"/></td>
								</tr>
								<tr>
									<td width="30%">Location:</td>
									<td width="70%">
										<select id="txtlocation" name="txtlocation">
											$locationdatalist
										</select>
									</td> 
                                 
								</tr>
								<tr>
									<td width="30%">Guard:</td>
									<td width="70%">
										<select id="txtguard" name="txtguard">
											$guardsdatalist2
										</select>
									</td>                                  
                                  
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%" id="tblRiskFactors">
											<tr>
												<td >Injury:</td>
												<td >
													<select id="txtinjury" name="txtinjury" style="width:100px;">
														<option value="0">None</option>
														<option value="1">Minor</option>
														<option value="2">Serious</option>
													</select>
												</td>                                  
											</tr>
											<tr>
												<td >Damage to Property:</td>
												<td >
													<select id="txtpropdmg" name="txtpropdmg" style="width:100px;">
														<option value="0">None</option>
														<option value="1">Non-critical</option>
														<option value="2">Critical</option>
													</select>
												</td>                                  
											</tr>
											<tr>
												<td >Loss of Property:</td>
												<td >
													<select id="txtproploss" name="txtproploss" style="width:100px;">
														<option value="0">None</option>
														<option value="1">Non-critical</option>
														<option value="2">Critical</option>
													</select>
												</td>                                  
											</tr>
											<tr>
												<td >Work Stoppage:</td>
												<td >
													<select id="txtworkstop" name="txtworkstop" style="width:100px;">
														<option value="0">No</option>
														<option value="1">Yes</option>											
													</select>
												</td>                                  
											</tr>
											<tr>
												<td >Death:</td>
												<td >
													<select id="txtdeath" name="txtdeath" style="width:100px;">
														<option value="0">None</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3+</option>
													</select>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>                    
                      </td>
                      <td width="60%" valign="top">
                          <table width="100%">
                              <tr>
                                  <td>
                                  Narration: <input type="text" id="txtLogId" name="txtLogId" readonly="readonly" style="display:none" />
                                  <input type="text" id="txtLogType" name="txtLogType" readonly="readonly" style="display:none" />
                                  <input type="text" id="txtOrigin" name="txtOrigin" readonly="readonly" style="display:none" />
                                  <input type="text" id="ticketName2" name="ticketName2" readonly="readonly" style="display:none" />
                                  <input type="text" id="ticketDate2" name="ticketDate2" readonly="readonly" style="display:none" />
                                  </td>
                              </tr>
                              <tr>
                                  <td align="center">                                    	
                                      <textarea id="remarks" name="remarks" style="width:95%; height:150px; resize:none" ></textarea>
                                  </td>
                              </tr>
                              <tr>
                                  <td> 
                                    <table width="100%"> 
                                      <tr>
                                            <tr>
                                                <td style="text-align: left; font-weight: 400; padding-right: 0; padding-left: 0">Files Upload: </td>
                                                <td style="text-align: right; padding-right: 0; padding-left: 0"><input type="checkbox" id="sendtobu" name="sendtobu" value="1"  />Send to BU / OIC:</td>
                                            </tr>
                                            <tr>
                                                <td><input type="file" name="attach1[]"  multiple="multiple"> </td>
                                                <td style="float: right"><button id="btnsave" name="btnsave" style="width:46px; height:21px;" onclick="evaluateForm(this);">Save</button></td>
                                            </tr>  
					                    </tr>
                                    </table>
                                  </td>
                              </tr>
                          </table>
                      </td>
                  </tr>
              </table>
        </form>
        </div>
        </td>        
      </tr>
    </table>
    </div>
    
    <div id="Activities" class="section">
    <table width="95%" border="1" align="center" style="border-collapse:collapse;">
    	<tr>
        	<td width="100%" align="left">
            <a href="#" style="color:#000;" onclick="toggleAdd2('createActivity','ActLogs'); swap('cticketa');" id="cticketa"><b>Create Ticket (Activity)</b></a>
            </td>
        </tr>
	</table>
    
    
    <div id="createActivity" style="display:none">
    <form id="addActivityForm" method="post" action="user.php">
    <table align="center">
    	<tr>
        	<td>Activity Type:</td>
            <td>
            	
                <select id="txtactivityname" name="txtactivityname">
                	<option value=""></option>
                    $activityentriesdatalist
                </select>
            </td>
        </tr>
        <tr>
        	<td>Date:</td>
            <td><input type="date" id="txtactivitydate" name="txtactivitydate" value="$logdate" /></td>            
        </tr>
        <tr>
        	<td></td>
            <td><button id="btnSaveActivityTicket" class="redbutton" onclick="evalAdd('act', this);">Save</button></td>
        </tr>
    </table>
    </form>
    </div>
    <div id="ActLogs" style="display:block">
    <table align="center" width="95%">
    	<tr>
        	<td>
            </td>
        	<td width="10%" align="right" style="color:#F00; text-decoration:underline; cursor:pointer;" onclick="toggleFilters('divActFilters');">
            	Search
            </td>
            <td width="7%" align="right" style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="refreshPage('Activities', 'user');">
            	Refresh
            </td>
        </tr>
    </table>
    <div id="divActFilters" style="display:none">
    <table align="center" >
    	<tr align="center">
        	<td >
            	<strong>Date:</strong>&nbsp;<input type="date" id="searchActLogStart" name="searchActLogStart" value="$logdate" />&nbsp; to &nbsp;<input type="date" id="searchActLogEnd" name="searchActLogEnd" value="$logdate" />
            </td>
            <td>
            	<strong>Business Unit:</strong>&nbsp;<input type="text" value="$headerBu" readonly="readonly" /><input type="hidden" id="txtSearchActLogBU" name="txtSearchActLogBU" value="$bu" readonly="readonly" />
            </td>
            <td>
            	
            	<strong>Activity Type:</strong>&nbsp;
                <select id="selSearchActLogType" name="selSearchActLogType">
                	<option value="0">All Activities</option>
                    $activityentriesdatalist
                </select>
            </td>
        </tr>
        <tr> 
            <td colspan="100%">
                <table>       
                    <tr>
                        <td>
							<td>
								<strong>Ticket ID:</strong>&nbsp;
								<input type="text" id="txtSearchTicketId2" name="txtSearchTicketId2" />
							</td>
							<td>
                            <strong>URC:</strong>&nbsp;
                            <select id="selSearchActLogURC" name="selSearchActLogURC">
                                <option value="0">All URCs</option>
                                $urcdatalist
                            </select>
							</td>
                        </td>
                        <td>
                            <strong>Location:</strong>&nbsp;
                            <select id="selSearchActLogLoc" name="selSearchActLogLoc">
                                <option value="0">All Locations</option>
                                $locationdatalist
                            </select>
                        </td>
                        <td>
                            <strong>Guard:</strong>&nbsp;
                            <select id="selSearchActLogGuard" name="selSearchActLogGuard">
                                <option value="0">All Guards</option>
                                $guardsdatalist2
                            </select>
                        </td>
                    </tr>                    
                </table>
            </td>
        </tr>
        <tr>
        	<td align="center" colspan="100%">
            	<img src="images/Search_btn.png" width="80px" id="btnSearchActLog" name="btnsearchActLog" style="cursor:pointer; vertical-align:middle;" onclick="searchLogs(2);" >
            </td>
        </tr>
    </table>
    </div>
    <table width="95%" border="2" align="center" style="border-collapse:collapse;" class="logtables">
    <thead>
    <tr style="line-height:32px">
      <th width="10%">Ticket ID</th>
      <th width="15%">Date</th>
      <th>Activity Name</th>
      <th width="10%">Status</th>
      <th width="20%" colspan="100%">Controls</th>      
    </tr>
    </thead>
    <tbody id="tbodyActivityTable">
      $activitytable
    </tbody>
    </table>
    </div>
    </div>
    <div id="Incidents" class="section">
    <table width="95%" border="1" align="center" style="border-collapse:collapse;">
    	<tr>
        	<td width="100%" align="left">
            <a href="#" style="color:#000;" onclick="toggleAdd2('createIncident','IncLogs'); swap('cticketi');" id="cticketi"><b>Create Ticket (Incident)</b></a>
            </td>
        </tr>
	</table>
    
    
    <div id="createIncident" style="display:none">
    <form id="addIncidentForm" method="post" action="user.php">
    
    
    <table align="center">
    	<tr>
        	<td>Incident Type:</td>
            <td>
            	
                <select id="txtincidentname" name="txtincidentname">
                	<option value=""></option>
                    $incidententriesdatalist
                </select>
            </td>
        </tr>
        <tr>
        	<td>Date:</td>
            
			<td><input type="date" id="txtincidentdate" name="txtincidentdate" value="$logdate"  /></td>
        </tr>
        <tr>
        	<td></td>
            <td><img src="images/save.png" width="100px" onclick="evalAdd('inc');" /></td>
        </tr>
        
    </table>
   
    
    
    </form>
    </div>
    <div id="IncLogs" style="display:block">
    <table align="center" width="95%">
    	<tr>
        	<td>
            </td>
        	<td width="10%" align="right" style="color:#F00; text-decoration:underline; cursor:pointer;" onclick="toggleFilters('divIncFilters');">
            	Search
            </td>
            <td width="7%" align="right" style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="refreshPage('Incidents', 'user');">
            	Refresh
            </td>
        </tr>
    </table>
    <div id="divIncFilters" style="display:none">
    <table align="center" >
    	<tr align="center">
        	<td >
            	<strong>Date:</strong>&nbsp;
			</td>
			<td colpan="3">
				<input type="date" id="searchIncLogStart" name="searchIncLogStart" value="$logdate" />&nbsp; to &nbsp;<input type="date" id="searchIncLogEnd" name="searchActIncEnd" value="$logdate" />
            </td>
            <td>
            	<strong>Business Unit:</strong>&nbsp;
			</td>
			<td>
				<input type="text" value="$headerBu" readonly="readonly" /><input type="hidden" id="txtSearchIncLogBU" name="txtSearchIncLogBU" value="$bu" readonly="readonly" />
            </td>
            <td>            	
            	<strong>Incident Type:</strong>&nbsp;
			</td>
			<td>
                <select id="selSearchIncLogType" name="selSearcIncLogType">
                	<option value="0">All Incidents</option>
                    $incidententriesdatalist
                </select>
            </td>
        </tr>
        <tr> 
            <td colspan="100%">
                <table>       
                    <tr>
						<td>
                            <strong>Ticket ID::</strong>&nbsp;
                            <input type="text" id="txtSearchTicketId" name="txtSearchTicketId" />
                        </td>
                        <td>
                            <strong>URC:</strong>&nbsp;
                            <select id="selSearchIncLogURC" name="selSearchIncLogURC">
                                <option value="0">All URCs</option>
                                $urcdatalist
                            </select>
                        </td>
                        <td>
                            <strong>Location:</strong>&nbsp;
                            <select id="selSearchIncLogLoc" name="selSearchIncLogLoc">
                                <option value="0">All Locations</option>
                                $locationdatalist
                            </select>
                        </td>
                        <td>
                            <strong>Guard:</strong>&nbsp;
                            <select id="selSearchIncLogGuard" name="selSearchIncLogGuard">
                                <option value="0">All Guards</option>
                                $guardsdatalist2
                            </select>
                        </td>
                    </tr>                    
                </table>
            </td>
        </tr>
        <tr>
        	<td align="center" colspan="100%">
            	<img src="images/Search_btn.png" width="80px" id="btnSearchIncLog" name="btnsearchIncLog" style="cursor:pointer; vertical-align:middle;" onclick="searchLogs(1);" >
            </td>
        </tr>
    </table>
    </div>
    <table width="95%" border="1" align="center" style="border-collapse:collapse;" >
    <thead>
    <tr style="line-height:32px">
      <th width="10%" style="background-color:#F00; color:#FFF;">Ticket ID</th>
      <th width="15%" style="background-color:#F00; color:#FFF;">Date</th>
	  <th width="5%" style="background-color:#F00; color:#FFF;">Level</th>
      <th style="background-color:#F00; color:#FFF;">Incident Name</th>
      <th width="10%" style="background-color:#F00; color:#FFF;">Status</th>
      <th width="20%" colspan="100%" style="background-color:#F00; color:#FFF;">Controls</th>
    </tr>
    </thead>
    <tbody id="tbodyIncidentTable">
      $incidenttable
    </tbody>
    </table>
    </div>
    </div>
	<div id="divUploadModal" name="divUploadModal" style="display:none;">
		<table align="center" width="35%" border="1">
			<tr>
				<td width="50%"><input type="radio" id="uploadChoiceUpload" name="uploadChoice" checked="true" onclick="openViewAttachments();">Upload</td><td width="50%"><input type="radio" id="uploadChoiceView" name="uploadChoice" onclick="openViewAttachments();">View</td>				
			</tr>
		</table>
		<br><br>
		<div id="divUploadFile" name="divUploadFile">
		<form id="frmUpload" method="post" action="user.php" enctype="multipart/form-data">
			<table align="center">
				<tr>
					<th>File Upload</th>
				</tr>
				<tr>
					<td align="center"><input type="file" name="attach1[]"></td>
				</tr>
				<tr>
					<td align="center"><input type="file" name="attach1[]"></td>
				</tr>
				<tr>
					<td align="center"><input type="file" name="attach1[]"></td>
				</tr>
				<tr>
					<td align="center"><input type="file" name="attach1[]"></td>
				</tr>
				<tr>
					<td align="center"><input type="file" name="attach1[]"></td>
				</tr>
				<tr>
					<td><input type="checkbox" id="uploadtobu" name="uploadtobu" value="1">Send to BU / OIC</td>
				</tr>
				<tr>
					<td align="center">
						<input type="hidden" id="txtUploadTicketId" name="txtUploadTicketId">
						<input type="submit" class="redbutton" id="btnUpload" name="btnUpload" value="Upload">
						<button class="redbutton" id="btnCancelUpload" name="btnCancelUpload">Cancel</button>
					</td>
				</tr>
			</table>
		</form>
		</div>
		<div id="divViewUpload" name="divViewUpload" style="display:none;">		
		</div>
	</div>
    <div id="GuardMgt" class="section">
		<table width="95%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Guard Personnel</td>
            <td align="right">
            	<div id="divSearchGuard" style="display:none;">
                <form id="frmSearchGuard" name="frmSearchGuard" action="user-admin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer;" onclick="refreshPage('GuardMgt', 'user');">Refresh</label>
                    &nbsp;
                	<input type="text" id="txtSearchGuard" name="txtSearchGuard" />                    
                    <select id="selSearchGuardAgency" name="selSearchGuardAgency" style="display:none;">
                    	<option value=""></option>
                        $secagencydatalist
                    </select>
                    <select id="selSearchGuard" name="selSearchGuard" onchange="changeSearch('guard_personnel');">
                    	<option value="lname">Last Name</option>
                        <option value="fname">First Name</option>
                        <option value="mname">Middle Name</option>
                        <option value="guard_code">Guard Code</option>
                        <option value="contact">Contact Number</option>
                        <option value="agency">Security Agency</option>
                        <option value="gender">Gender</option>
                        <option value="blood_type">Blood Type</option>
                    </select>
                    <img src="images/Search_btn.png" width="80px" id="btnsearchguard" name="btnsearchguard" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchGuard').value, document.getElementById('selSearchGuard').value, 'guard_personnel');" />
                </form>    
                </div>
            </td>
        	<td align="right" width="30px">            	
            	<img src="images/Search-icon.png" height="30px" id="btnshowsearchguard" name="btnshowsearchguard" title="Search Guard" style="cursor:pointer;" onclick="toggleSearch('divSearchGuard');" />
                
            </td>
        </tr>
        </table>
        <table width="95%" border="1" align="center" style="border-collapse:collapse;">
			<thead>
				<tr class="whiteonblack">
					<th>#</th>
					<th>Last Name</th>
					<th>First Name</th>
					<th>Middle Name</th>
					<th>Guard Code</th>
					<th>Contact Number</th>
					<th>Business Unit</th>
					<th>Status</th>
					<td></td>
				</tr>
			</thead>
			<tbody id="tbodyGuards">
				$guardstable
			</tbody>
        </table>
    </div>
    <div id="CodeMgt" class="section">
    	<table width="95%" align="center">
          <tr>
              <td align="left" style="font-weight:bold">Code Management</td>        	
              <td align="right">
                  <div id="divSearchCodes" style="display:none;">
                  <form id="frmSearchCodes" name="frmSearchCodes" action="user-admin.php" method="post">
                  	  <label style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="refreshPage('CodeMgt', 'user');">Refresh</label>
                      <input type="text" id="txtSearchCodes" name="txtSearchCodes" />
                      <img src="images/Search_btn.png" width="80px" id="btnSearchCodes" name="btnSearchCodes" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchCodes').value, 'code', 'urc_mst');" />
                  </form>    
                  </div>                
              </td>
              <td width="30px" align="right">
                  <img src="images/Search-icon.png" height="30px" id="btn ShowSearchCodes" name="btnShowSearchCodes" title="Search Codes" style="cursor:pointer;" onclick="toggleSearch('divSearchCodes');" />
                  
              </td>	          
          </tr>
      	</table>
        <div id="divCodeDisplay">
          <table width="95%" border="1" align="center" style="border-collapse:collapse">
              <tr>
                  <th class="codetab" id="codetab10" bgcolor="#000000" style="color:#FFF" onclick="toggleMe2('10codes', 'codetab10')">10-00 Series</th>
                  <th class="codetab" id="codetab11" onclick="toggleMe2('11codes', 'codetab11')">11-00 Series</th>
                  <th class="codetab" id="codetabdc" onclick="toggleMe2('disposition', 'codetabdc')">Disposition Codes</th>
                  <th class="codetab" id="codetabc" onclick="toggleMe2('codes', 'codetabc')">Codes</th>
                  <th class="codetab" id="codetabpa" onclick="toggleMe2('phonetic', 'codetabpa')">Phonetic Alphabet</th>
              </tr>
          </table>    
          <br />
          <div id="10codes" class="codediv">
              <table width="60%" align="center" border="1" style="border-collapse:collapse">
                  <tr>
                    <th width="30%">10-00 Code</th>
                    <th width="70%">Description</th>
                  </tr>
                  $code10table
              </table>
          </div>
          <div id="11codes" class="codediv" style="display:none;">
              <table width="60%" align="center" border="1" style="border-collapse:collapse">
                  <tr>
                    <th width="30%">11-00 Code</th>
                    <th width="70%">Description</th>
                  </tr>
                  $code11table
              </table>
          </div>
          <div id="disposition" class="codediv" style="display:none;">
              <table width="60%" align="center" border="1" style="border-collapse:collapse">
                  <tr>
                    <th width="30%">Disposition Code</th>
                    <th width="70%">Description</th>
                  </tr>
                  $codedctable
              </table>
          </div>
          <div id="codes" class="codediv" style="display:none;">
              <table width="60%" align="center" border="1" style="border-collapse:collapse">
                  <tr>
                    <th width="30%">Code</th>
                    <th width="70%">Description</th>
                  </tr>
                  $codetable
              </table>
          </div>
          <div id="phonetic" class="codediv" style="display:none;">
              <table width="60%" align="center" border="1" style="border-collapse:collapse">
                  <tr>
                    <th width="30%">Phonetic Alphabet</th>
                    <th width="70%">Description</th>
                  </tr>
                  $codepatable
              </table>
          </div>
        </div>
        <div id="divSearchCodeDisplay" style="display:none;">
          <table width="60%" align="center" border="1" style="border-collapse:collapse">
              <thead>
              <tr>
                <th width="30%">Code</th>
                <th width="70%">Description</th>
              </tr>
              </thead>
              <tbody id="tbodyCodes">
              </tbody>
          </table>
      </div>
    </div>
    <div id="Profile" class="section">
    <table align="center" border="1" style="border-collapse:collapse; border-color:#CCC">
    	<tr>
        	<td colspan="2" align="center" bgcolor="#000000" style="color:#FFF">My Profile</td>
        </tr>
        <tr>
        	<td align="right">User Level:</td>
            <td align="left"><input type="text" id="userlevel" value="$level" class="txtborderless" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td align="right">Last Name:</td>
            <td align="left"><input type="text" id="userlname" value="$userlname" class="txtborderless" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td align="right">First Name:</td>
            <td align="left"><input type="text" id="userfname" value="$userfname" class="txtborderless" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td align="right">Username:</td>
            <td align="left"><input type="text" id="username" value="$username" class="txtborderless" readonly="readonly" /></td>
        </tr>
        <tr>
        	<td align="right">Gender:</td>
            <td align="left"><input type="text" id="usergender" value="$usergender" class="txtborderless" readonly="readonly" /></td>
        </tr>
        <tr valign="middle">
        	<td align="right">Mobile Number:</td>
            <td align="left"><input type="text" id="usercontact" name="usercontact" value="$usercontact" readonly="readonly" size="10" />
            	<img src="images/edit icon.png" height="16px" title="Edit Contact" id="editcontact" name="editcontact" />
            	<input type="text" id="userpassword" style="display:none" value="$userpassword" />
                <input type="text" id="userid" name="userid" style="display:none" value="$userid" />
            </td>
        </tr>
        <tr> 
        	<td id="btnchangepass" align="right" style="text-decoration:underline; color:#F00; cursor:pointer" colspan="2">Change Password</td>            
        </tr>
    </table>
    </div>
    <div id="changeucontact" style="display:none" >
    	<form id="changecontactForm" method="post" action="user.php">
    	<table align="center" style="padding-top:20px;">
        	<tr>
            	<th colspan="2">Change Contact Number</th>
            </tr>
        	<tr>
            	<td>Current Number:</td>
                <td><input type="text" value="$usercontact" readonly="readonly" size="10" /></td>
            </tr>
            <tr>
            	<td>New Number:</td>
                <td><input type="text" id="usercontactnew" name="usercontactnew" size="10" /></td>
            </tr>
            <tr>
        	<td colspan="2" align="right"><img id="confirmnewcontact" src="images/check.png" height="24px" style="cursor:pointer" onclick="chkContact();" />   <img id="closecontact" src="images/x_mark.png" height="24px" style="cursor:pointer" /></td>
        </tr>
        </table>
        </form>
    </div>
    <div id="changepass" style=" padding:20px; background-color:#CCC; display:none;">
    <form id="formcpass" method="post" action="user.php" autocomplete="off">
    <table id="tblchangepass" align="center" border="1" style="border-collapse:collapse; border-color:#999; border-style:groove">
    	<tr bgcolor="#000000" style="color:#FFF">
        	<td colspan="2">Change Password</td>
        </tr>
        <tr>
        	<td>Current Password:</td>
            <td><input type="password" id="currentpass" name="currentpass" class="txtborderless" /></td>
        </tr>
        <tr>
        	<td>New Password:</td>
            <td><input type="password" id="newpass" name="newpass" class="txtborderless" /></td>
        </tr>
        <tr>
        	<td>Re-type New Password</td>
            <td><input type="password" id="newpass2" name="newpass2" class="txtborderless" /></td>
        </tr>
        <tr>
        	<td colspan="2" align="right"><img src="images/check.png" height="24px" style="cursor:pointer" onclick="chkcpass();" />&nbsp;&nbsp;&nbsp;<img id="closecpass" src="images/x_mark.png" height="24px" style="cursor:pointer" onclick="document.getElementById('formcpass').reset();" /></td>
        </tr>
    </table>
    </form>
    </div>
    <div id="modalReport">
    
	</div>
    
  </div>
</div>
<script type="text/javascript">document.getElementById('$cat').style.display = 'block';</script>
</body>
</html>