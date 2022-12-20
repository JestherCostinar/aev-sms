<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<base href="$url_base/" />
-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aboitiz | Security Management System</title>
<script src="javascript/jquery-1.11.3.min.js"></script>
<script src="javascript/jquery-ui.min.js"></script>
<script src="javascript/md5-min.js"></script>
<script type="text/javascript" src="javascript/speedometer.js"></script>
<script src="javascript/Chart.js"></script>
<link rel="stylesheet" href="jquery-ui.css" />
<script language="javascript" type="text/javascript" src="jqplot/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="jqplot/jquery.jqplot.css" />
<script type="text/javascript" src="jqplot/plugins/jqplot.pieRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.donutRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.barRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.categoryAxisRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.pointLabels.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.meterGaugeRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.canvasAxisLabelRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.LogAxisRenderer.js"></script>
<script type="text/javascript" src="jqplot/plugins/jqplot.canvasAxisTickRenderer.js"></script>

<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
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
  .jqplot-meterGauge-label {
    font-size: 1em;
    color: #FF0000;
}
</style>
<link href="styles.css" rel="stylesheet" />
<link href="biddingtable.css" rel="stylesheet" />

<script src="javascript/OSLS.js?v=$jsrefresh"></script>
</head>

<body onload="loadCharts();">
<div class="container">
	<div id="topbar">
		<table height="80px" width="100%" bgcolor="#000000">
		  <tr>
			<td width="20%"><img src="images/header3.png" alt="Aboitiz logo" style="background:black; width:100%"/></td>
			<td width="80%" align="right" valign="top" style="color:#FFF">Logged in as $displayUsername<br /><a href="logout.php" style="color:#FFF">Logout</a></td>
		  </tr>
		</table>
	</div>
	<div style="height:20px; width:100%; background-color:#CCC;">
		<span>$displaytotaltime</span>
	</div>
	<div class="sidebar1">
		<font color="#FFFFFF">    
		<ul style="list-style-type:none;">
			<li style="font-size:1.5em;"><b>$displayLevel</b></li>
			<ul style="padding-left:10px; list-style-type:none;">
				<li class="lists" id="listdash" onclick="loadCharts();toggleMe('Dashboard', 'listdash');"><img src="images/dashboard.png" style="height:18px; vertical-align:middle;">  Dashboard</li>
				<li class="lists" onclick="toggleMenu('subEntries');">Entries</li>
					<ul id="subEntries" style="display:none; list-style-type:none;">
						<li class="lists" id="listact" onclick="toggleMe('Activities', 'listact'); initialLogs('Act');">Activities</li>
						<li class="lists" id="listinc" onclick="toggleMe('Incidents', 'listinc'); initialLogs('Inc');">Incidents</li>
					</ul>
				<li class="lists" onclick="toggleMenu('subGuardManagement');">Guard Management</li>
					<ul id="subGuardManagement" style="display:none; list-style-type:none;">
						<li class="lists" id="listgmgt" onclick="toggleMe('GuardMgt', 'listgmgt')">Guard Personnel</li>
						<li class="lists" id="listsecage" onclick="toggleMe('SecAgency', 'listsecage')">Security Agency</li>
						
						
					</ul>
				<li class="lists" onclick="toggleMenu('subMonitoring');">Monitoring</li>
					<ul id="subMonitoring" style="display:none; list-style-type:none;">
						<!-- <li class="lists" id="listaudit" onclick="toggleMe('Audit', 'listaudit'); auditShow($bu);">Audit</li> -->
						<li class="lists" id="listaudit2" onclick="toggleMe('Audit', 'listaudit2'); auditShow3();">Audit Summary</li>
						<li class="lists" id="listspam" onclick="toggleMe('SPAM', 'listspam'); showSpamCon();">SPAM</li>
						<!-- <li class="lists" id="liststakeholder" onclick="toggleMe('Stakeholder', 'liststakeholder'); showStakeholder('table');">Stakeholders</li> -->
						<li class="lists" onclick="toggleMenu('subContractCompliance');">Contract Compliance</li>
						<ul id="subContractCompliance" style="display:none; list-style-type:none;">
							<li class="lists" id="listconcom" onclick="toggleMe('ConComp', 'listconcom')">Create Template</li>
							<li class="lists" id="listconcomcons" onclick="toggleMe('ConCompConsolidation', 'listconcomcons')">Summary</li>
						</ul>
					</ul>
				<li class="lists" onclick="toggleMenu('subBidding');">Bidding</li>
					<ul id="subBidding" style="display:none; list-style-type:none;">
						<li class="lists" id="listbidreq" onclick="toggleMe('BidReq', 'listbidreq')">Bidding Template</li>
						<li class="lists" id="listbiddoc" onclick="toggleMe('BidDocs', 'listbiddoc')">Documents</li>
						<li class="lists" id="listbidding" onclick="toggleMe('Bidding', 'listbidding')">Bidding</li>
					</ul>
				<li class="lists" onclick="toggleMenu('subRequests');">Requests</li>
					<ul id="subRequests" style="display:none; list-style-type:none;">
						<li class="lists" id="listretractions" onclick="toggleMe('divRequests', 'listretractions')">Retractions</li>
						<li class="lists" id="listdeletions" onclick="toggleMe('divDeletions', 'listdeletions')">Deletions</li>
					</ul>
				<li class="lists" onclick="toggleMenu('subTools');">Tools</li>
					<ul id="subTools" style="display:none; list-style-type:none;">
						<li class="lists" id="listincaud" onclick="toggleMe('IncAud', 'listincaud'); showIACons();">Incident Audit</li>
						<li class="lists" id="listcmgt" onclick="toggleMe('CodeMgt', 'listcmgt')">Code Management</li>
						<li class="lists" id="listlocs" onclick="toggleMe('Locs', 'listlocs')">Location</li>
						<li class="lists" id="listbus" onclick="toggleMe('BUs', 'listbus')">Business Unit</li>
							<ul style="list-style-type:none;">
								<li class="lists" id="listgroup" onclick="toggleMe('Groups', 'listgroup')" >Groups / Regions / Cluster</li>
								<!--<li class="lists" id="listregion" onclick="toggleMe('Regions', 'listregion')" >Region</li>-->
							</ul>
						<li class="lists" id="listsecalert" onclick="toggleMe('SecAlert', 'listsecalert')">Security Alert Recipients</li>          
						<li class="lists" id="listentries" onclick="toggleMe('Entries', 'listentries')">Entries</li>
						<li class="lists" onclick="toggleMenu('subReportGenerator');">Report Generator</li>
							<ul id="subReportGenerator" style="display:none;">
								<li class="lists" id="listreportgentable" onclick="toggleMe('ReportGeneratorTable', 'listreportgentable'); toggleReportTable('incident');">Monitoring Form</li>
								<li class="lists" id="listreportgengraph" onclick="toggleMe('ReportGeneratorGraph', 'listreportgengraph'); showGraphTicketFilters();">Graphs</li>
							</ul>
					</ul>
				<li class="lists" onclick="toggleMenu('subAccount');">Account</li>
					<ul id="subAccount" style="display:none; list-style-type:none;">
						<li class="lists" id="listusers" onclick="toggleMe('Users', 'listusers')">Users, Admins, Super Admins</li>         
						<li class="lists" id="listprof" onclick="toggleMe('Profile', 'listprof')">My Profile</li>
					</ul>
				<li class="lists" id="listlogs" onclick="toggleMe('SysLogs', 'listlogs')">Logs</li>
				<!-- <li class="lists" onclick="testCSVUpload();">Test Upload</li> -->
			</ul>
		</ul> 
		</font>
	</div>
  <div id="multi" class="multi">
  	<div id="Dashboard" class="section">
		<table width="95%" align="center">
			<tr>
				<td><label style="color:blue; cursor:pointer;" onclick="fillKPIDashboardSA(); toggleMe('KPI_Dashboard', 'listdash');">Toggle KPI Dashboard</label></td>
			</tr>
		</table>
    	<table width="100%" align="center" >
        	<tr style="max-height:50%;">

            	<td width="50%" align="center" valign="middle">
				
				<div style="width: 470px; margin-left: 0px;">
                	<div id="divMeter" style="width: 400px; height: 250px; overflow: hidden;">
                    
                    </div>
				</div>
				
                </td>
                <td width="50%" align="center">
                	
                        <div id="divTotalInc" style="height: 250px;">
                        </div>
                    
                </td>
            </tr>
            <tr>
            	<td width="50%" align="center">
                	<div id="divLine" style="width: 500px; height: 250px;">
                    
                    </div>
                </td>
                <td width="50%" align="center" valign="top">
                	<table width="75%">
                    	<tr>
                        	<th>Expiry Reminders</th>
                        </tr>
                        <tr>
                        	<td align="center"><input type="radio" name="radioExpiry" onclick="toggleExpiry2('divSecAgencyContract');" />Contracts &nbsp; &nbsp;<input type="radio" checked="checked" name="radioExpiry" onclick="toggleExpiry2('divSecAgencyLicense');" />License to Operate &nbsp; &nbsp;<input type="radio" name="radioExpiry" onclick="toggleExpiry2('divSecAgencyOtherLicenses');" />Other Licenses</td>                            
                        </tr>
                    </table>
                    <div id="divSecAgencyLicense">
                	<table width="75%" border="1" style="border-collapse:collapse;">
                    	<thead>
                        	<tr class="blackongray">
                            	<th>Security Agency</th>
                                <th>License Expiry</th>
                            </tr>
                        </thead>
                        <tbody id="tblSecAgLicenseTbody"> 
                        	<tr>                       
                        		<td colspan="100%" align="center">No Records</td>
                            </tr>
                        </tbody>                        
                    </table>
                    </div>
                    <div id="divSecAgencyContract" style="display:none;">
                	<table width="75%" border="1" style="border-collapse:collapse;">
                    	<thead>
                        	<tr class="blackongray">
                            	<th>Security Agency</th>
                                <th>Business Unit</th>
                                <th>Contract Expiry</th>
                            </tr>
                        </thead>
                        <tbody id="tblSecAgContractTbody"> 
                        	<tr>                       
                        		<td colspan="100%" align="center">No Records</td>
                            </tr>
                        </tbody>                        
                    </table>
                    </div>
					<div id="divSecAgencyOtherLicenses" style="display:none;">
                	<table width="100%" border="1" style="border-collapse:collapse;">
                    	<thead>
                        	<tr class="blackongray">
                            	<th>Security Agency</th>
                                <th>License Type</th>
                                <th>License Number</th>
								<th>Issue Date</th>
								<th>Expiry Date</th>
								<th>PDF</th>
                            </tr>
                        </thead>
                        <tbody id="tblSecAgOtherLicensesTbody"> 
                        	<tr>                       
                        		<td colspan="100%" align="center">No Records</td>
                            </tr>
                        </tbody>                        
                    </table>
                    </div>
                </td>
            </tr>
        </table>
        
    </div>
	<div id="KPI_Dashboard" class="section">
		<table width="100%" height="100%">
			<tr>
				<td width="30%"><label style="color:blue; cursor:pointer; text-decoration:underline;" onclick="loadCharts2(); toggleMe('Dashboard', 'listdash');">Toggle Dashboard</label></td>
				<td width="40%" align="center"><label style="font-size:20px; font-weight:bold;" >KPI Dashboard</label></td>
				<td width="30%"></tD>
			</tr>
		</table>		
		<table width="100%" height="100%" >
			<thead id="tblKPIDashboardHead" name="tblKPIDashboardHead">
			</thead>
			<!-- <tbody>				 -->
				<tr>
					<td width="50%" rowspan="2"><label style="color:green; font-weight:bold;">Audit Summary</label><div id="KPIAudit" height="100%"></div></td>
					<td width="50%" valign="top" align="center"><label style="color:green; font-weight:bold;">Stakeholder Engagement</label><div id="KPIStake" style="height:200px; overflow-y:auto; border: 2px solid black;"></div></td>
				</tr>
				<tr>
					<td width="40%" valign="top" align="center"><br><label style="color:green; font-weight:bold;">IDP Status</label><div id="KPIIDP" align="center" style="height:200px; overflow-y:auto; border: 2px solid black;"></div></td>
				</tr>
			</table>
			<table width="100%" height="100%">
				<tr>
					<td colspan="100%"><label style="color:green;">Contract Compliance</label><div id="KPICC" width="100%" height="100%"></div></td>
				</tr>
				<tr>
					<td colspan="100%"></br></td>
				</tr>
				<tr>
					<td colspan="100%"><label style="color:green;">Incident Accuracy</label><div id="KPIIA" width="100%" height="100%"></div></td>
				</tr>
			<!-- </tbody> -->
		</table>		
	</div>	
    <div id="addGuard" style="display:none;">
		<div id="divAddGuardContent">
    	
		</div>
    </div>  	
    <div id="closeincidentmodal" style="padding-top:24px; display:none">
    <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeCloseIncident();" />
    <form id="closeincidentform" name="closeincidentform" method="post" action="user-superadmin.php">
    	  <div id="involvedsection">
    	  <center>
          <fieldset style="display:inline-block; ">
          <legend style="font-weight:bold" >Person(s) Involved</legend>
          <table align="center">
            <tr>
                <td colspan="2">
                  <input type="radio" id="witness" name="involved" checked="checked" />Witness
                  <input type="radio" id="suspect" name="involved" />Suspect
                  <input type="radio" id="victim" name="involved" />Victim
                  <input type="hidden" id="iwfnamesall" name="iwfnamesall" />
                  <input type="hidden" id="isfnamesall" name="isfnamesall" />
                  <input type="hidden" id="ivfnamesall" name="ivfnamesall" />
                  <input type="hidden" id="iwmnamesall" name="iwmnamesall" />
                  <input type="hidden" id="ismnamesall" name="ismnamesall" />
                  <input type="hidden" id="ivmnamesall" name="ivmnamesall" />
                  <input type="hidden" id="iwlnamesall" name="iwlnamesall" />
                  <input type="hidden" id="islnamesall" name="islnamesall" />
                  <input type="hidden" id="ivlnamesall" name="ivlnamesall" />
                  <input type="hidden" id="iwaddressall" name="iwaddressall" />
                  <input type="hidden" id="isaddressall" name="isaddressall" />
                  <input type="hidden" id="ivaddressall" name="ivaddressall" />
                  <input type="hidden" id="iwcontactsall" name="iwcontactsall" />
                  <input type="hidden" id="iscontactsall" name="iscontactsall" />
                  <input type="hidden" id="ivcontactsall" name="ivcontactsall" />
                  <input type="hidden" id="iwageall" name="iwageall" />
                  <input type="hidden" id="isageall" name="isageall" />
                  <input type="hidden" id="ivageall" name="ivageall" />
                  <input type="hidden" id="iwgenderall" name="iwgenderall" />
                  <input type="hidden" id="isgenderall" name="isgenderall" />
                  <input type="hidden" id="ivgenderall" name="ivgenderall" />
                  <input type="hidden" id="iwheightall" name="iwheightall" />
                  <input type="hidden" id="isheightall" name="isheightall" />
                  <input type="hidden" id="ivheightall" name="ivheightall" />
                  <input type="hidden" id="iwweightall" name="iwweightall" />
                  <input type="hidden" id="isweightall" name="isweightall" />
                  <input type="hidden" id="ivweightall" name="ivweightall" />
                  <input type="hidden" id="iwremarksall" name="iwremarksall" />
                  <input type="hidden" id="isremarksall" name="isremarksall" />
                  <input type="hidden" id="ivremarksall" name="ivremarksall" />
                  <input type="hidden" id="checkVehicle" name="checkVehicle" />
                  <input type="hidden" id="checkDamage" name="checkDamage" />
                  <input type="hidden" id="checkCF" name="checkCF" />
                </td>
            </tr>                		
            <tr>
                <td>First Name:</td>
                <td align="left"><input type="text" id="witfname" name="witfname" class="involvedrows" /></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td align="left">
                  <input type="text" id="witmname" name="witmname" class="involvedrows" />
                  <input type="text" id="swid" name="swid" readonly="readonly" style="display:none;" />
                </td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td align="left"><input type="text" id="witlname" name="witlname" class="involvedrows" /></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td align="left"><textarea id="witadd" name="witadd" style="resize:none" class="involvedrows"></textarea></td>
            </tr>
            <tr>
                <td>Contact Number:</td>
                <td align="left"><input type="text" id="witcontact" name="witcontact" class="involvedrows"/></td>
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
                <td>Remarks:</td>
                <td align="left"><textarea id="witremarks" name="witremarks" style="resize:none" class="involvedrows"></textarea></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><img src="images/add_btn.png" width="90px" onclick="addInvolved();" style="cursor:pointer;" /></td>
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
                  <th>Remarks</th>
                  <th></th>
              </tr>
              </thead>
              <tbody id="tblvictimtbody">
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
                          <legend style="font-weight:bold; text-align:left"><input type="checkbox" id="chkboxVehicle" name="chkboxVehicle" value="1" onclick="checkOtherDetails();" />Vehicle Involved</legend>
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
                                    	<!--<input type="text" id="txtvtype" name="txtvtype" title="ex: car, motorcycle, etc." />-->
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
                                  	<td><textarea id="txtvremarks" name="txtvremarks" class="fieldsVehicle" disabled="disabled"></textarea></td>
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
    </form>          
    </div>
  	<div id="AddActivity" class="ui-front" style="display:none; padding-top:30px; padding-bottom:30px">
    <img id="back" src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" />
    <table width="95%" border="1" align="center" style="border-collapse:collapse; padding-top:24px;" >
      <tr bgcolor="#000000" style="color:#FFF;">
        <th width="10%">Ticket ID</th>
        <th width="15%">Date</th>        
        <th id="logtitle">Activity Name</th>
        <th width="10%">Status</th>
        <!--<th width="20%" colspan="2">Controls</th>-->
      </tr>
      <tr align="center">
        <td id="ticketID">TESTID</td>
        <td id="ticketDate">TestDate</td>
        <td id="ticketName">Test Description</td>
        <td style="color:#090">Open</td>
        <!--<td></td>
        <td id="back" width="10%" style="cursor:pointer;">Back</td>-->
      </tr>
      <tr>
      	<td colspan="6" align="center">
        <div class="logs2" style="display:block;">
        <form id="addForm" method="post" action="user-superadmin.php" enctype="multipart/form-data">
        	<table width="100%">
                  <tr>
                      <td width="40%" valign="top" style="padding-top:25px;">
                          <table width="100%">                              
                              <tr>                               
                                  <td width="30%">URC:</td>
                                  <td width="70%">
                                    <select id="txturc" name="txturc">
                                    	<option selected="selected" value=""></option>
                                        $urcdatalist
                                    </select>
                                  </td> 
                                  <!--<td width="70%"><input type="text" id="txturc" name="txturc" autocomplete="off" autofocus="autofocus" /></td>-->
                              </tr>
                              <!--<tr>                               
                                  <td width="30%"></td>
                                  <td width="70%"><label id="urcdesc" name="urcdesc">URC Description</label></td>
                              </tr>-->
                              <tr>
                                  <td width="30%">Date:</td>
                                  <td width="70%"><input type="date" id="date" name="date" value="$logdate" autocomplete="off" /></td>
                              </tr>
                              <tr>
                                  <td width="30%">Time:</td>
                                  <td width="70%"><input type="text" id="time" name="time" value="$logtime" autocomplete="off"/></td>
                              </tr>
                              <tr>
                                  <td width="30%">Location:</td>
                                  <td width="70%">
                                    <select id="txtlocation" name="txtlocation">
                                    	<option value="" selected="selected"></option>
                                        $locationdatalist
                                    </select>
                                  </td> 
                                  <!--<td width="70%"><input type="text" id="txtlocation" name="txtlocation" list="locations" autocomplete="off" />
                                  <datalist id="locations">
                                  $locationdatalist
                                  </datalist>
                                  </td>-->
                              </tr>
                              <tr>
                                  <td width="30%">Guard:</td>
                                  <td width="70%">
                                    <select id="txtguard" name="txtguard">
                                    	<option value="" selected="selected"></option>
                                        $guardsdatalist2
                                    </select>
                                  </td>                                  
                                  <!--<td width="70%"><input type="text" id="txtguard" name="txtguard" list="guards" autocomplete="off" />
                                  <datalist id="guards">                                  
                                  $guardsdatalist
                                  </datalist>
                                  </td>-->
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
                                        <td>
                                        Attachments:<br />
                                        <input type="file" name="attach[]"/>
                                        <input type="file" name="attach[]"/>
                                        <input type="file" name="attach[]"/>
                                        </td>
                                        <td align="right" width="40%">
                                          Send to BU / OIC:
                                          <input type="checkbox" id="sendtobu" name="sendtobu" value="1"  /><br /><br /><br />
                                          <img id="btnsave" name="btnsave" src="images/save3.png" onclick="evaluateForm();" />                                     
                                        </td>
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
    <form id="addActivityForm" method="post" action="user-superadmin.php">
    <table align="center">
    	<tr>
        	<td>Activity Type:</td>
            <td>
            	<!--<input type="text" id="txtactivityname" name="txtactivityname" size="30" />-->
                <select id="txtactivityname" name="txtactivityname">
                	<option value=""></option>
                    $activityentriesdatalist
                </select>
            </td>
        </tr>
        <tr>
        	<td>Date:</td>
            <td><input type="date" id="txtactivitydate" name="txtactivitydate" value="$logdate"/></td>            
        </tr>
        <tr>
        	<td></td>
            <td><img src="images/save.png" width="100px" onclick="evalAdd('act');" /></td>
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
            <td width="7%" align="right" style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="refreshPage('Activities', 'user-superadmin');">
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
            	<strong>Business Unit:</strong>&nbsp;
                <select id="txtSearchActLogBU" name="txtSearchActLogBU">
                	<option value="0">All BUs</option>
                    $budatalist
                </select>                
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
                            <strong>URC:</strong>&nbsp;
                            <select id="selSearchActLogURC" name="selSearchActLogURC">
                                <option value="0">All URCs</option>
                                $urcdatalist
                            </select>
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
      <th width="15%">Business Unit</th>
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
    <form id="addIncidentForm" method="post" action="user-superadmin.php">    
    
    <table align="center">
    	<tr>
        	<td>Incident Type:</td>
            <td>
            	<!--<input type="text" id="txtincidentname" name="txtincidentname" size="30" />-->
                <select id="txtincidentname" name="txtincidentname">
                	<option value=""></option>
                    $incidententriesdatalist
                </select>
            </td>
        </tr>
        <tr>
        	<td>Date:</td>
            <td><input type="date" id="txtincidentdate" name="txtincidentdate" value="$logdate" /></td>            
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
            <td width="7%" align="right" style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="refreshPage('Incidents', 'user-admin');">
            	Refresh
            </td>
        </tr>
    </table>
    <div id="divIncFilters" style="display:none">
    <!-- <table align="center" >
    	<tr align="center">
        	<td >
            	<strong>Date:</strong>&nbsp;<input type="date" id="searchIncLogStart" name="searchIncLogStart" value="$logdate" />&nbsp; to &nbsp;<input type="date" id="searchIncLogEnd" name="searchActIncEnd" value="$logdate" />
            </td>
            <td>
            	<strong>Business Unit:</strong>&nbsp;
                <select id="txtSearchIncLogBU" name="txtSearchIncLogBU">
                	<option value="0">All BUs</option>
                    $budatalist
                </select> 
            </td>
            <td>
            	
            	<strong>Incident Type:</strong>&nbsp;
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
    </table> -->
    </div>
    <table width="95%" border="1" align="center" style="border-collapse:collapse;" >
    <thead>
    <tr style="line-height:32px" style="background-color:#F00; color:#FFF;">
      <th width="10%" style="background-color:#F00; color:#FFF;">Ticket ID</th>
      <th width="15%" style="background-color:#F00; color:#FFF;">Date</th>
      <th width="15%" style="background-color:#F00; color:#FFF;">Business Unit</th>
	  <th width="5%" style="background-color:#F00; color:#FFF;">Level</th>
      <th style="background-color:#F00; color:#FFF;">Incident Name</th>
      <th width="10%" style="background-color:#F00; color:#FFF;">Status</th>
      <th width="20%" colspan="100%" style="background-color:#F00; color:#FFF;">Controls</th>
    </tr>
    </thead>
    <tbody id="tbodyIncidentTable">
      <!-- $incidenttable -->
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
		<form id="frmUpload" method="post" action="user-superadmin.php" enctype="multipart/form-data">
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
	<div id="changeClassificationModal" style="display:none;">
		<form id="frmChangeClassification" name="frmChangeClassification" method="post" action="user-admin.php">
		<table align="center">
			<tr>
				<td align="center" colspan="100%"><b>Change/Update Incident Classification</b></td>
			</tr>
			<tr>
				<td align="center">
					<select id="selChangeClass" name="selChangeClass" required="required">
						<option value=""></option>
						$incidententriesdatalist
					</select>
				</td>				
			</tr>
			<tr>
				<td align="center">
					<input type="checkbox" id="chkboxRetractLevel" name="chkboxRetractLevel" value="1" checked />Reset to default severity level
				</td>
			</tr>
			<tr>
				<td align="center" colspan="100%">
					<input type="hidden" id="txtChangeClassificationId" name="txtChangeClassificationId"/>
					<input type="submit" id="btnSubmitChangeClassification" name="btnSubmitChangeClassification" class="redbutton" value="Submit"/>
					<input type="button" id="btnCloseChangeClassification" name="btnCloseChangeClassification" class="redbutton" value="Cancel" onclick="changeClassificationClose();"/>
				</td>
			</tr>
		</table>
		</form>
	</div>
    <div id="GuardMgt" class="section">
      <table width="95%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Guard Personnel</td>
            <td align="right">
            	<div id="divSearchGuard" style="display:none;">
                <form id="frmSearchGuard" name="frmSearchGuard" action="user-superadmin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer;" onclick="refreshPage('GuardMgt', 'user-superadmin');">Refresh</label>
                    &nbsp;
                	<input type="text" id="txtSearchGuard" name="txtSearchGuard" />
                    <select id="selSearchGuardBu" name="selSearchGuardBu" style="display:none;">
                    	<option value=""></option>
                        $budatalist
                    </select>
                    <select id="selSearchGuardAgency" name="selSearchGuardAgency" style="display:none;">
                    	<option value=""></option>
                        $secagencydatalist
                    </select>
                    <select id="selSearchGuard" name="selSearchGuard" onchange="changeSearch('guard_personnel');">
                    	<option value="lname">Last Name</option>
                        <option value="fname">First Name</option>
                        <!-- <option value="mname">Middle Name</option> -->
                        <option value="guard_code">Guard Code</option>
                        <!-- <option value="contact">Contact Number</option> -->
                        <option value="bu">Business Unit</option>
                        <option value="agency">Security Agency</option>
                        <!-- <option value="gender">Gender</option> -->
                        <!-- <option value="blood_type">Blood Type</option> -->
                    </select>
                    <img src="images/Search_btn.png" width="80px" id="btnsearchguard" name="btnsearchguard" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchGuard').value, document.getElementById('selSearchGuard').value, 'guard_personnel');" />
                </form>    
                </div>
            </td>
        	<td align="right" width="65px" align="right">
            	<img src="images/Search-icon.png" height="30px" id="btnshowsearchguard" name="btnshowsearchguard" title="Search Guard" style="cursor:pointer;" onclick="toggleSearch('divSearchGuard');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('GuardMgt', 'user-superadmin');" />-->
            	<img src="images/add_guard.png" height="30px" id="btnaddguard" name="btnaddguard" title="Add Guard" style="cursor:pointer;" onclick="guardInfo2(0,'Add');" />
            </td>
        </tr>
      </table>
      <table width="95%" border="1" align="center" style="border-collapse:collapse;">
      <thead>      
      <tr class="whiteonblack">
      	<th>#</th>
        <th>Last Name</th>
        <th>First Name</th>
        <!-- <th>Middle Name</th> -->
        <th>Guard Code</th>
        <!-- <th>Contact Number</th> -->
        <th>Business Unit</th>
        <th>Status</th>
        <td width="2%"></td>
      </tr>
      </thead>
      <!-- <tbody id="tbodyGuards">
        $guardstable
      </tbody> -->
	  <tbody id="tbodyGuards">
        <tr>
			<td colspan="100%" align="center">Use the search function to view guards</td>			
		</tr>
      </tbody>
      </table>
    </div>
    <div id="SecAgency" class="section">
    	<table width="95%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Security Agencies</td>
            <td align="right">
            	<div id="divSearchAgency" style="display:none;">
                <form id="frmSearchAgency" name="frmSearchAgency" action="user-superadmin.php" method="post">
                <label style="text-decoration:underline; color:#00F" onclick="refreshPage('SecAgency', 'user-superadmin');">Refresh</label>
                	<input type="text" id="txtSearchAgency" name="txtSearchAgency" />
                    <select id="selSearchAgencyBu" name="selSearchAgencyBu" style="display:none;">
                    	<option value=""></option>
                        $budatalist
                    </select>                    
                    <select id="selSearchAgency" name="selSearchAgency" onchange="changeSearch('agency_mst');">
                    	<option value="agency_name">Name</option>
                        <option value="address">Address</option>
                        <option value="oic">President / General Manager</option>
                        <option value="contact_number">Contact Number</option>
                        <option value="bu">Business Unit</option>                        
                    </select>
                    <img src="images/Search_btn.png" width="80px" id="btnSearchAgency" name="btnSearchAgency" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchAgency').value, document.getElementById('selSearchAgency').value, 'agency_mst');" />
                </form>    
                </div>
                
            </td>
        	<td align="right" width="65px" align="right">
            	<img src="images/Search-icon.png" height="30px" id="btnShowSearchAgency" name="btnShowSearchAgency" title="Search Agency" style="cursor:pointer;" onclick="toggleSearch('divSearchAgency');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('SecAgency', 'user-superadmin');" />-->
            </td>
        </tr>
      </table>
	  <div id="divAgencyDisplay">
        <table width="95%" border="1" align="center" style="border-collapse:collapse">
                <tr>
					<th class="acctab" id="acctabuser" width="25%" bgcolor="#000000" style="color:#FFF; cursor:pointer" onclick="toggleMe3('divactiveagency', 'acctabuser', 'User');">Active</th>
                    <th class="acctab" id="acctabheadguard" width="25%" style="cursor:pointer;" onclick="toggleMe3('divinactiveagency', 'acctabheadguard', 'Head Guard');">Inactive</th>
					<th class="acctab" id="acctabadmin" width="25%" style="cursor:pointer;" onclick="toggleMe3('divpoolagency', 'acctabadmin', 'Admin');">Pool</th>
				</tr>
            </table>
            <table width="95%" align="center">
                  <tr>
                      <td align="right">
                        <img src="images/add_guard.png" height="30px" id="btnaddsecagency" name="btnaddsecagency" title="Add Security Agency" style="cursor:pointer;" onclick="addAgency();" />
                      </td>
                  </tr>
                </table>
            <div id="divactiveagency" class="accdiv">        	
                <table width="95%" align="center" border="1" style="border-collapse:collapse">
					<thead
					<tr class="whiteonblack">
						<th>#</th>
						<th>Name</th>
						<th>Address</th>
						<th>President/General Manager</th>
						<th>Contact Number</th>
						<th>Business Unit(s)</th>
						<th>Status</th>
						<td></td>
					</tr>
					</thead>
					<tbody >
						$secactiveagencytable
					</tbody>
				</table>
            </div>
			<div id="divinactiveagency" class="accdiv" style="display:none">
                <table width="95%" align="center" border="1" style="border-collapse:collapse">
					<thead
					<tr class="whiteonblack">
						<th>#</th>
						<th>Name</th>
						<th>Address</th>
						<th>President/General Manager</th>
						<th>Contact Number</th>
						<th>Business Unit(s)</th>
						<th>Status</th>
						<td></td>
					</tr>
					</thead>
					<tbody>
						$secinactiveagencytable
					</tbody>
				</table>
            </div>
            <div id="divpoolagency" class="accdiv" style="display:none">
                <table width="95%" align="center" border="1" style="border-collapse:collapse">
					<thead
					<tr class="whiteonblack">
						<th>#</th>
						<th>Name</th>
						<th>Address</th>
						<th>President/General Manager</th>
						<th>Contact Number</th>
						<th>Status</th>
						<td></td>
						<td></td>
					</tr>
					</thead>
					<tbody>
						$poolsecagencytable
					</tbody>
				</table>
            </div>
      </div>
	  	  
	  	<div id="divSecAgencySearch" style="display:none;">
			<table width="95%" align="center" border="1" style="border-collapse:collapse">
				<thead
				<tr class="whiteonblack">
					<th>#</th>
					<th>Name</th>
					<th>Address</th>
					<th>President/General Manager</th>
					<th>Contact Number</th>
					<th>Business Unit(s)</th>
					<th>Status</th>
					<td></td>
				</tr>
				</thead>
				<tbody id="tbodySecAgency">
				</tbody>
			</table>
		</div>
    </div>
	<div id="secagencymodal" style="display:none; padding-top:28px;" >
	<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeSecAgencySA();" />
		<table align="center" width="100%" border="1" style="border-collapse:collapse;">
			<tr>
				<th style="cursor:pointer;" onclick="toggleTabs('geninfodiv', 'secagencydivs');">General Info</th>
				<th style="cursor:pointer;" onclick="toggleTabs('otherlicensesdiv', 'secagencydivs');">Other Licenses</th>
				<th style="cursor:pointer;" onclick="toggleTabs('contractsdiv', 'secagencydivs');">Contracts/Clients</th>
				<!-- <th style="cursor:pointer;" onclick="toggleTabs('remarksdiv', 'secagencydivs');">Remarks</th> -->
			</tr>
			<tr>
				<td colspan="100%">
					<div id="geninfodiv" name="geninfodiv" class="secagencydivs" style="cursor:pointer;">
						<form id="secagencyform" name="secagencyform" method="post" action="user-superadmin.php" enctype="multipart/form-data">
						<table width="100%" align="center">
						<tr>
						<td width="50%" valign="top" align="center">
						<fieldset>
						<legend style="font-weight:bold">General Info</legend>
						<table align="center" width="100%">
							<tr>
								<td align="right">Name of Agency:</td>
								<td><input type="text" id="txtagencyname" name="txtagencyname" required="required"/>
								</td>
							</tr>
							<tr>
								<td align="right">Address:</td>
								<td><textarea id="txtagencyaddress" name="txtagencyaddress" style=" resize:none;" required="required" ></textarea></td>
							</tr>
							<tr>
								<td align="right">President/General Manager:</td>
								<td><input type="text" id="txtagencyoic" name="txtagencyoic" required="required" /></td>
							</tr>
							<tr>
								<td align="right">Contact:</td>
								<td><input type="text" id="txtagencycontact" name="txtagencycontact" required="required" /></td>
							</tr>
						 </table>
						 </fieldset>
						 </td>
						 <td width="50%" valign="top" align="center">
						 <fieldset>
						 <legend style="font-weight:bold">License to Operate</legend>
						 <table align="center" width="100%">                    
							<tr>
								<td align="right">License Number:</td>
								<td><input type="text" id="txtagencylicensenum" name="txtagencylicensenum" required="required" /></td>
							</tr>
							<tr>
								<td align="right">Issue Date:</td>
								<td><input type="date" id="txtagencylicenseissue" name="txtagencylicenseissue" required="required" /></td>
							</tr>
							<tr>
								<td align="right">Expiration Date:</td>
								<td><input type="date" id="txtagencylicenseexpiry" name="txtagencylicenseexpiry" required="required"  /></td>
							</tr>
						 </table>
						 </fieldset>
						 <br />
						 <table>
							<tr>
								<td align="right">Status of Contract:</td>
								<td>
									<select id="selcontractstat" name="selcontractstat" required >
										<option value=""></option>
										<option value="Active">Active</option>
										<option value="Inactive">Inactive</option>
									</select>
								</td>
							</tr>
						 </table>
						 </td>
						 </tr>
						 </table>
						 <br />
						 <fieldset>
						 <legend style="font-weight:bold">Company Profile</legend>           
							<textarea id="txtagencyprofile" name="txtagencyprofile" style="width:95%; resize:none; height:75px;" required="required" ></textarea>
						 </fieldset>
						 <br />
						 <fieldset>
						  <legend style="font-weight:bold">Business Unit Security Head Remarks</legend>
						  <table id="tblagencyremarks" border="1" style="border-collapse:collapse;" align="center" width="100%">
							  <thead>
							  <tr class="whiteonblack">
								  <th width="20%">Date</th>
								  <th>Remarks</th>
								  <td width="5%"></td>
							  </tr>
							  </thead>
							  <tbody id="tblagencyremarkstbody">
							  
							  </tbody>
							  <tfoot>
								<tr bgcolor="#CCCCCC" align="center">
									<td align="center"><input type="date" id="txtagencyremarkdate" name="txtagencyremarkdate" value="$logdate" /></td>
									<td align="center"><textarea id="txtagencyremark" name="txtagencyremark" style="resize:none; width:100%;"></textarea></td>
									<td></td>
								</tr>
								<tr>                	
									<td align="center" colspan="3">
										<img id="btnaddsecremarkrow" name="btnaddsecremarkrow" src="images/add_btn.png" width="80px" onclick="addSAremarksrow();" />
										<input type="hidden" id="txtagencyremarkdateall" name="txtagencyremarkdateall" />
										<input type="hidden" id="txtagencyremarkall" name="txtagencyremarkall" />
									</td>
								</tr>
							  </tfoot>
						  </table>
						  </fieldset>
					</div>
					<div id="otherlicensesdiv" name="otherlicensesdiv" style="display:none;" class="secagencydivs">
						<table id="tblagencylicenses" align="center" width="100%" border="1" style="border-collapse:collapse;">
							 <thead>
							 <tr class="whiteonblack">
								 <th>License Type</th>
								 <th>License Number</th>
								 <th>Issue Date</th>
								 <th>Expiry Date</th>
								 <th>PDF File</th>								 
								 <td></td>
							 </tr>
							 </thead>
							 <tbody id="tblagencylicensestbody">
							 
							 </tbody>
							 <tfoot>
								<tr bgcolor="#CCCCCC">
									<td align="center">
										<input type="text" id="txtagencylicensetype" name="txtagencylicensetype" ></input>               	
									</td>
									<td align="center">
										<input type="text" id="txtagencylicensenumber" name="txtagencylicensenumber" ></input>	
									</td>
									<td align="center"><input type="date" id="txtagencylicensestart" name="txtagencylicensestart" /></td>
									<td align="center"><input type="date" id="txtagencylicenseend" name="txtagencylicenseend" /></td>
									<td></td>
								</tr>
								<tr>									
									<td align="center" colspan="4">
										<img id="btnaddseclicenserow" name="btnaddseclicenserow" src="images/add_btn.png" width="80px" onclick="addSAlicenserow();" />										
										<input type="hidden" id="txtagencylicensetypeall" name="txtagencylicensetypeall" />
										<input type="hidden" id="txtagencylicensenumall" name="txtagencylicensenumall" />
										<input type="hidden" id="txtagencylicensestartall" name="txtagencylicensestartall" />
										<input type="hidden" id="txtagencylicenseendall" name="txtagencylicenseendall" />
									</td>
								</tr>
							 </tfoot>
						 </table>
					</div>
					<div id="contractsdiv" name="contractsdiv" style="display:none;" class="secagencydivs">
						<table id="tblagencybu" align="center" width="100%" border="1" style="border-collapse:collapse;">
							 <thead>
							 <tr class="whiteonblack">
								 <th>Business Unit(s)</th>
								 <th>Start Contract Date</th>
								 <th>End Contract Date</th>
								 <th>PDF File</th>
								 <td></td>
							 </tr>
							 </thead>
							 <tbody id="tblagencybutbody">
							 
							 </tbody>
							 <tfoot>
								<tr bgcolor="#CCCCCC">
									<td align="center">
										<select id="txtagencybuname" name="txtagencybuname">
											<option value=""></option>
											$budatalist
										</select>                    	
									</td>
									<td align="center"><input type="date" id="txtagencybustart" name="txtagencybustart" /></td>
									<td align="center"><input type="date" id="txtagencybuend" name="txtagencybuend" /></td>
									<td></td>
								</tr>
								<tr>									
									<td align="center" colspan="4">
										<img id="btnaddsecburow" name="btnaddsecburow" src="images/add_btn.png" width="80px" onclick="addSAburow();" />
										<input type="hidden" id="txtagencybunameall" name="txtagencybunameall" />
										<input type="hidden" id="txtagencybustartall" name="txtagencybustartall" />
										<input type="hidden" id="txtagencybuendall" name="txtagencybuendall" />
									</td>
								</tr>
							 </tfoot>
						 </table>
						 <br />
						 
						  <table id="tblagencyclient" border="1" style="border-collapse:collapse;" align="center" width="100%">
							  <thead>
							  <tr class="whiteonblack">
								  <th>Other Client(s)</th>
								  <th>Start Contract Date</th>
								  <th>End Contract Date</th>
								  <td></td>
							  </tr>
							  </thead>
							  <tbody id="tblagencyclienttbody">
							  
							  </tbody>
							  <tfoot>
								<tr bgcolor="#CCCCCC">
									<td align="center"><input type="text" id="txtagencyclient" name="txtagencyclient" /></td>
									<td align="center"><input type="date" id="txtagencyclientstart" name="txtagencyclientstart" /></td>
									<td align="center"><input type="date" id="txtagencyclientend" name="txtagencyclientend" /></td>
									<td></td>
								</tr>
								<tr>
									
									<td align="center" colspan="4">
										<img id="btnaddsecclientrow" name="btnaddsecclientrow" src="images/add_btn.png" width="80px" onclick="addSAclientrow();" />
										<input type="hidden" id="txtagencyclientall" name="txtagencyclientall" />
										<input type="hidden" id="txtagencyclientstartall" name="txtagencyclientstartall" />
										<input type="hidden" id="txtagencyclientendall" name="txtagencyclientendall" />
									</td>
								</tr>
							  </tfoot>
						  </table>
					</div>
					<div id="remarksdiv" name="remarksdiv" style="display:none;" class="secagencydivs">
						<!-- <fieldset>
						  <legend style="font-weight:bold">Business Unit Security Head Remarks</legend>
						  <table id="tblagencyremarks" border="1" style="border-collapse:collapse;" align="center" width="100%">
							  <thead>
							  <tr class="whiteonblack">
								  <th width="20%">Date</th>
								  <th>Remarks</th>
								  <td width="5%"></td>
							  </tr>
							  </thead>
							  <tbody id="tblagencyremarkstbody">
							  
							  </tbody>
							  <tfoot>
								<tr bgcolor="#CCCCCC" align="center">
									<td align="center"><input type="date" id="txtagencyremarkdate" name="txtagencyremarkdate" value="$logdate" /></td>
									<td align="center"><textarea id="txtagencyremark" name="txtagencyremark" style="resize:none; width:100%;"></textarea></td>
									<td></td>
								</tr>
								<tr>                	
									<td align="center" colspan="3">
										<img id="btnaddsecremarkrow" name="btnaddsecremarkrow" src="images/add_btn.png" width="80px" onclick="addSAremarksrow();" />
										<input type="hidden" id="txtagencyremarkdateall" name="txtagencyremarkdateall" />
										<input type="hidden" id="txtagencyremarkall" name="txtagencyremarkall" />
									</td>
								</tr>
							  </tfoot>
						  </table>
						  </fieldset> -->
					</div>
				</td>
			</tr>
		</table>
          <table align="center" width="95%">
            
            <tr>
            	<td align="right" colspan="2">
                	<!--<input type="submit" id="btnsaveagency" name="btnsaveagency" class="redbutton" value="Save Agency" onclick="addAgencyRelated();" />-->
                	<img src="images/update.png" id="btnupdateagency" name="btnupdateagency" width="100px" style="display:none; cursor:pointer;" onclick="saveSecAgency();" />
                    <img src="images/save.png" id="btnsaveagency" name="btnsaveagency" width="100px" style="display:none; cursor:pointer;" onclick="saveSecAgency();" />
                    <input type="hidden" id="txtagencyid" name="txtagencyid" />
                    <input type="hidden" id="txtagencyaddedit" name="txtagencyaddedit" />
                </td>
            </tr>
          </table>
          </form>
	</div>
	<div id="addPDFmodal" style="display:none">
		<!-- <form id="addPDFform" name="addPDFform" method="post" action="user-superadmin.php" enctype="multipart/form-data">
			<table align="center">
				<tr><th>Add PDF FIle</th></tr>
				<tr>
					<td>						
						<input type="file" name="licenseattach1[]">
						<input type="hidden" id="addpdfid" name="addpdfid">
						<input type="hidden" id="addpdftype" name="addpdftype">
					</td>
				</tr>
				<tr align="center">
					<td>
						<input type="submit" id="btnAddPDFlicense" name="btnAddPDFlicense" class="redbutton" value="Submit">
						<button class="redbutton" id="btnCloseAddPDFlicense" name="btnCloseAddPDFlicense">Close</button>
					</td>
				</tr>
			</table>
		</form> -->
	</div>    
	
	<div id="SPAM" class="section">
	</div>
	
	<div id="Stakeholder" class="section">
	</div>
	
	<div id="modalStakeholder" style='display:none;'>
	</div>
	
	<div id="ConComp3" class="section">
		<table width="95%" border="1" align="center" style="border-collapse:collapse;">
			<tr>
				<td width="100%" align="left">
				<a href="#" style="color:#000;" onclick="toggleAdd4('listConCom', 'addConCom', 'cc_specific'); swap('cConCom');" id="cConCom"><b>Create New Contract Compliance Form</b></a>
				</td>
			</tr>
		</table>
		<div id="addConCom" style="display:none;">
			<form id="frmAddCC" name="frmAddCC" method="post" action="user-superadmin.php">
			<table align="center" style="padding-left:10px;">	
				<tr>				
					<td align="right">Year:</td>
					<!-- <td align="left"><input type="text" size="5" id="txtCCYear" name="txtCCYear" required="required"></td> -->
					<td align="left">
						<select id="txtCCYear" name="txtCCYear" required="required">
							<option value="0">All</option>
							$yeardropdown
						</select>
					</td>					
				</tr>
				<tr>
					<td align="right">Month:</td>
					<td align="left" >
						<select id="selCCMonth" name="selCCMonth">
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Business Unit:</td>
					<td align="left">
						<select id="selCCBU" name="selCCBU" required="required">
							<option value=""></option>
							$budatalist
						</select> 
					</td>
				</tr>	
				<tr>
					<td align="right">Security Agency:</td>
					<td align="left">
						<select id="selCCSecAgency" name="selCCSecAgency" required="required">
							<option value=""></option>
							$secagencydatalist
						</select> 
					</td>
				</tr>
				<tr>
					<td align="right">Person-in-charge:</td><td align="left"><input type="text" id="txtCCOIC" name="txtCCOIC"></td>
				</tr>
				<tr>
					<td align="right">E-mail address:</td><td align="left"><input type="text" id="txtCCemail" name="txtCCemail"></td>
					<!-- <td>
						<button class="redbutton">Search</button>
					</td> -->
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" class="redbutton" id="btnNewCC" name="btnNewCC" value="Add">
					</td>
				</tr>
			</table>
			</form>
		</div>
		<div id="listConCom" style="display:block;">
			<br>
			<table align="center" style="padding-left:10px;">	
				<tr>				
					<td align="right">Year:</td>
					<!-- <td align="left"><input type="text" size="5" id="txtCCYear2" name="txtCCYear2" required="required"></td> -->
					<td align="left">
						<select id="txtCCYear2" name="txtCCYear2" required="required">
							<option value="0">All</option>
							$yeardropdown
						</select>
					</td>
					<td align="right">Month:</td>
					<td align="left" >
						<select id="selCCMonth2" name="selCCMonth2">
							<option value="0">All</option>
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
					</td>
				
					<td align="right">Business Unit:</td>
					<td align="left">
						<select id="selCCBU2" name="selCCBU2" required="required">
							<option value="0">All BUs</option>
							$budatalist
						</select> 
					</td>
				
					<td align="right">Security Agency:</td>
					<td align="left">
						<select id="selCCSecAgency2" name="selCCSecAgency2" required="required">
							<option value="0">All Security Agencies</option>
							$secagencydatalist
						</select> 
					</td>
					<td>
						<img src="images/Search_btn.png" width="80px" id="btnsearchcc" name="btnsearchcc" style="cursor:pointer; vertical-align:middle;" onclick="searchItem('contract', 'compliance', 'cc_mst');">
					</td>
				</tr>
				</table>
			<br>			
			<table align="center" width="60%" border="1" style="border-collapse:collapse;">
				<thead>
				<tr class="whiteonblack">
					<th>#</th>
					<th>Business Unit</th>
					<th>Security Agency</th>
					<th>Year</th>
					<th>Month</th>
					<th>Controls</th>
				</tr>
				</thead>
				<tbody id="tbodyCC">
					<tr>
						<td colspan="100%" align="center">Contract Compliance List</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="cc_specific" style="display:none;">
			<br>
			<form id="frmSaveEditCC" name="frmSaveEditCC" action="user-superadmin.php" method="post">
			<table align="center" border="1" style="border-collapse:collapse;">
				<tr class="whiteonblack">
					<th>Year</th>
					<th>Month</th>
					<th>Business Unit</th>
					<th>Security Agency</th>
					<th>Person-in-charge</th>
					<th>Agency E-mail</th>
					<th>Total Weight</th>
					<th>Score</th>
				</tr>
				<tr>
					<td><select id="txtCCYear3" name="txtCCYear3" required="required">							
							$yeardropdown
						</select></td>
					<td><select id="selCCMonth3" name="selCCMonth3" required="required">							
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select></td>
					<td><select id="selCCBU3" name="selCCBU3" required="required">							
							$budatalist
						</select>
					</td>
					<td><select id="selCCSecAgency3" name="selCCSecAgency3" required="required">							
							$secagencydatalist
						</select>
					</td>
					<td align="center">
						<input type="text" id="txtCCOIC3" name="txtCCOIC3" style="text-align:center;">
					</td>
					<td align="center">
						<input type="text" id="txtCCemail3" name="txtCCemail3" style="text-align:center;">
					</td>
					<td align="center">
						<label id="lblCCtotalweight3" name="lblCCtotalweight3"></label>
					</td>
					<td align="center">
						<label id="lblCCscore3" name="lblCCscore3"></label>
						<input type="hidden" id="addCCMasterNumber2" name="addCCMasterNumber2">
					</td>
				</tr>
			</table>			
			</form>
			<table align="center">
				<tr valign="top">
					<td align="right" valign="top">
						<button class="redbutton" onclick="saveEditCC();";>Save Edit</button>						
					</td>				
					<td align="left" valign="top">
						<button class="redbutton" onclick="publishCC();";>Publish</button>						
					</td>
				</tr>
			</table>
			<br>
			<br>
			<table align="center" style="border-collapse:collapse; max-width:90%;" >
				<tr>
					<td align="right">Number:</td>
					<td align="left"><input type="number" id="txtAddCCNumber" name="txtAddCCNumber" min="1" max="100"></td>
					<td rowspan="4" valign="top">Standard:</td>
					<td rowspan="4" align="left" width="40%"><textarea id="txtaddCCStandard" name="txtaddCCStandard" style="resize:none; width:95%; height:100%;"></textarea></td>
					<td align="right">Frequency:</td>
					<td align="left">
						<!-- <input type="text" id="txtAddCCFrequency" name="txtAddCCFrequency"> -->
						<select id="txtAddCCFrequency" name="txtAddCCFrequency">
							<option value=""></option>
							<option value="As Determined">As Determined</option>
							<option value="Weekly">Weekly</option>
							<option value="Monthly">Monthly</option>
							<option value="Bi-Monthly">Bi-Monthly</option>
							<option value="Quarterly">Quarterly</option>
							<option value="Annually">Annually</option>
						</select>
					</td>					
				</tr>
				<tr>
					<td align="right">Goal:</td>
					<!-- <td align="left"><input type="text" id="txtAddCCGoal" name="txtAddCCGoal"></td> -->
					<td align="left">
						<select id="txtAddCCGoal" name="txtAddCCGoal" onchange="changeSubGoal();">
							<option value=""></option>
							<option value="People">People</option>
							<option value="Customer">Customer</option>
							<option value="Process">Process</option>							
							<option value="Finance">Finance</option>
							<option value="Governance">Governance</option>
						</select>
					</td>
					<td align="right">Source:</td>
					<td align="left"><input type="text" id="txtAddCCSource" name="txtAddCCSource"></td>
				</tr>
				<tr>
					<td align="right">SubGoal:</td>
					<!-- <td align="left"><input type="text" id="txtAddCCSubGoal" name="txtAddCCSubGoal"></td> -->	
					<td align="left">
						<select id="txtAddCCSubGoal" name="txtAddCCSubGoal" >
							<option></option>
							<option value="Attract">Attract</option>
							<option value="Optimize">Optimize</option>
							<option value="Retain">Retain</option>
							<option value="Statutory Compliance">Statutory Compliance</option>
						</select>
					</td>
					<td align="right">Formula:</td>
					<td align="left">
						<select id="selCCFormula" name="selCCFormula">
							<option value="1">(Actual*Wt)/Planned</option>
							<option value="2">Wt less Factor per Non Compliance</option>
							<option value="3">Deduction</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Reference:</td>
					<td align="left"><input type="text" id="txtAddCCReference" name="txtAddCCReference"></td>
					<td align="right">Weight:</td>
					<td align="left"><input type="number" id="txtAddCCWeight" name="txtAddCCWeight" min="1" max="100">&nbsp;Factor:<input type="number" id="txtAddCCFactor" name="txtAddCCFactor" min="1" max="100" step="0.5"></td>
				</tr>
				<tr>
					<td align="right" colspan="100%"><button class="redbutton" onclick="addCCEntry();">Add</button></td>
				</tr>
			</table>
			
			<br>
			<table width="90%" align="center" border="1" style="border-collapse:collapse;" id="tblShowCC" name="tblShowCC">
				<thead>
					<tr class="whiteonblack">
						<th>#</th>
						<th>Goal</th>
						<th>Subgoal</th>
						<th>Reference</th>
						<th>Standard</th>
						<th>Frequency</th>
						<th>Source</th>
						<th>Formula</th>
						<th>Weight</th>
						<th>Factor</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody id="tblShowCCtbody" name="tblShowCCtbody">					
				</tbody>				
			</table>
			<br>
			<table width="90%" align="center" border="1" style="border-collapse:collapse; display:none;" id="tblAddCC" name="tblAddCC">
				<thead>
					<tr class="whiteonblack">
						<th>#</th>
						<th>Goal</th>
						<th>Subgoal</th>
						<th>Reference</th>
						<th>Standard</th>
						<th>Frequency</th>
						<th>Source</th>
						<th>Formula</th>
						<th>Weight</th>
						<th>Factor</th>
						<th></th>
					</tr>
				</thead>
				<tbody>				
				</tbody>				
			</table>
			<table align="center" width="90%">
				<tr>
					<td colspan="100%" align="center">
						<form id="frmAddCCDetails" name="frmAddCCDetails" method="post" action="user-superadmin.php">
							<input type="hidden" id="addCCMasterNumber" name="addCCMasterNumber">
							<input type="hidden" id="addCCNumbers" name="addCCNumbers">
							<input type="hidden" id="addCCGoals" name="addCCGoals">
							<input type="hidden" id="addCCSubGoals" name="addCCSubGoals">
							<input type="hidden" id="addCCReferences" name="addCCReferences">
							<input type="hidden" id="addCCStandards" name="addCCStandards">
							<input type="hidden" id="addCCFrequencies" name="addCCFrequencies">
							<input type="hidden" id="addCCSources" name="addCCSources">
							<input type="hidden" id="addCCFormulas" name="addCCFormulas">
							<input type="hidden" id="addCCWeights" name="addCCWeights">
							<input type="hidden" id="addCCFactors" name="addCCFactors">
						</form>
						<button id="btnsaveCC" name="btnsaveCC" class="redbutton" style="display:none;" onclick="saveCCEntry();">Confirm Add</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="ConComp" class="section">
		<table align="left" style="padding-left:24px;">
			<tr>
				<td align="left" style="font-weight:bold">Contract Compliance Templates <br><br></td>
			</tr>
			<tr>
				<td colspan="100%" align="left">
					<form id="frmNewCCTemplate" name="frmNewCCTemplate" action="user-superadmin.php" method="post">
						Year: <select id="selCCYear" name="selCCYear"><option value="0">All</option>$yeardropdown</select>
						<img src="images/Search-icon.png" height="24px" id="btnShowCCResults" name="btnShowCCResults" title="Search CC" style="cursor:pointer; vertical-align:middle;" onclick="searchCC();">
						<input type="hidden" id="newCCNumbers" name="newCCNumbers">
						<input type="hidden" id="newCCGoals" name="newCCGoals">
						<input type="hidden" id="newCCSubGoals" name="newCCSubGoals">
						<input type="hidden" id="newCCReferences" name="newCCReferences">
						<input type="hidden" id="newCCStandards" name="newCCStandards">
						<input type="hidden" id="newCCDetails" name="newCCDetails">
						<input type="hidden" id="newCCFrequencies" name="newCCFrequencies">
						<input type="hidden" id="newCCSources" name="newCCSources">
						<input type="hidden" id="newCCDeductions" name="newCCDeductions">
						<input type="hidden" id="newCCGroups" name="newCCGroups">
						<input type="hidden" id="newCCHovers" name="newCCHovers">
					</form>
					
				</td>
			</tr>
		</table>		
		<table id="tblCCShow" name="tblCCShow" width="90%" align="center" style="display:none; border-collapse:collapse;" border="1">
			<tr>
				<th colspan="100%">Add New Entry</th>
			</tr>
			<tr valign="top">
				<td>
					<table align="center">
						<tr>
							<td width="20%">Number:</td>
							<td width="80%"><input type="number" min="1" id="txtAddCCNumber2" name="txtAddCCNumber2"></td>
						</tr>
						<tr>
							<td width="20%">Main Group:</td>
							<td width="80%">								
								<select id="txtAddCCGoal2" name="txtAddCCGoal2" >
									<option value=""></option>
									<option value="Regulatory">Regulatory</option>
									<option value="Operational">Operational</option>									
								</select>
							</td>
						</tr>
						<tr>
							<td width="20%">Sub Group:</td>
							<td width="80%"><input type="text" id="txtAddCCSubGoal2" name="txtAddCCSubGoal2"></td>
						</tr>
						<tr>
							<td width="20%">Frequency:</td>
							<td width="80%">								
								<select id="txtAddCCFrequency2" name="txtAddCCFrequency2" >
									<option value=""></option>
									<option value="3 Years">3 Years</option>
									<option value="2 Years">2 Years</option>
									<option value="Annual">Annual</option>
									<option value="3x a Year">3x a Year</option>
									<option value="Quarterly">Quarterly</option>
									<option value="Monthly">Monthly</option>
									<option value="Weekly">Weekly</option>
									<option value="Daily">Daily</option>
									<option value="Perpetual">Perpetual</option>
									<option value="As Mandated">As Mandated</option>
								</select>
							</td>
						</tr>
						
						<tr>
							<td width="20%">Percentage:</td>
							<td width="80%"><input type="number" min="0" id="txtAddCCDeduction2" name="txtAddCCDeduction2" value="0"></td>
						</tr>
						
					</table>
				</td>
				<td width="50%" style="padding-right:10px;">
					<table width="100%">
						<tr valign="top">
							<td width="20%">Standard:</td>
							<td width="80%">
								<textarea id="txtAddCCStandard2" name="txtAddCCStandard2" style="resize:none; height:20px; width:100%;"></textarea>
							</td>
						</tr>
						<tr valign="top">
							<td width="20%">Metrics:</td>
							<td width="80%">
								<textarea id="txtAddCCDetails2" name="txtAddCCDetails2" style="resize:none; height:80px; width:100%;"></textarea>
							</td>
						</tr>
						<tr valign="top">
							<td width="20%">Details:<br>(Hover Help)</td>
							<td width="80%">
								<textarea id="txtAddCCHover2" name="txtAddCCHover2" style="resize:none; height:50px; width:100%;"></textarea>
							</td>
						</tr>
					</table>
				</td>
							
			</tr>
			<tr>
				<td colspan="100%" align="center"><button class="redbutton" onclick="addCCEntry4();">Add</button></td>
			</tr>
		</table>		
		<br>
		<br>
		<table width="95%" border="1" align="center" style="border-collapse:collapse; display:none;" id="tblNewCC" name="tblNewCC">
			<thead>
				<tr class="whiteonblack">
					<th>Number</th>
					<th>Main Group</th>										
					<th>Sub Group</th>
					<th>Standard</th>
					<th width="20%">Metrics</th>					
					<th>Details</th>
					<th>Frequency</th>
					<th>Percentage</th>					
					<th></th>
				</tr>
			</thead>
			<tbody id="tbodyNewCC" name="tbodyNewCC">
			</tbody>
		</table>
		<table align="center">
			<tr>
				<td><button class="redbutton" id="btnSaveNewCC" name="btnSaveNewCC" style="display:none;" onclick="saveCCEntry4();">Save</button></td>
			</tr>
		</table>
	</div>
	<div id="IncAud" class="section">
		<table>
			<tr>
				<th colspan="100%">Incident Accuracy</th>
			</tr>
			<tr>
				<td></td>
			</tr>			
		</table>
		<div id="divIAdisplay" name="divIAdisplay">
		</div>
	</div>
	<div id="editCCModal" style="display:none;">
		<div id="editCCModalHolder" name="editCCModalHolder">
		
		</div>
	</div>
	
	<div id="ConCompConsolidation" class="section">
		<div id="ccConsDisplayMain" name="ccConsDisplayMain">
			<table align="left" style="padding-left:24px;">
				<tr>
					<td align="left" style="font-weight:bold">Contract Compliance Summary <br><br></td>
				</tr>
				<tr>
					<td>
						Year: <input id="ccConsYear" name="ccConsYear" type="number" min="2017" style="width:50px;" value="2017">
						<img src="images/Search-icon.png" height="24px" id="btnShowCCCons" name="btnShowCCCons" title="Search CC" style="cursor:pointer; vertical-align:middle;" onclick="searchCCCons();">
					</td>
				</tr>
			</table>
			<br>
			<div id="ccConsDisplay" name="ccConsDisplay">
			</div>
		</div>
		<div id="ccConsDisplaySub" name="ccConsDisplaySub">
			
		</div>
	</div>
	
	<!-- -------------------- BIDDING REQUIREMENT TEMPLATES ----------------- -->
	<div id="BidReq" class="section">
      <table width="95%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Bidding Requirements</td>
        	<td align="right" width="65px" align="right">
            	<img src="images/add_item.png" height="30px" id="btnaddbiddingtemplate" name="btnaddbiddingtemplate" title="Add Bidding Template" style="cursor:pointer;" onclick="addBiddingTemplate('0', 'Add');" />
            </td>
        </tr>
      </table>
      <table width="95%" border="1" align="center" style="border-collapse:collapse;">
      <thead>      
      <tr class="whiteonblack">
      	<th width="5%">#</th>
        <th>Bidding Requirements Name</th>
        <th width="15%">Status</th>
        <td width="10%">Action</td>
      </tr>
      </thead>
      <tbody>
        $biddingtemplatetable
      </tbody>
      </table>
    </div>

	<!-- ------------------ BIDDING REQUIREMENT ---------------- -->
	<div id="BidReqItem" class="section">

	</div>

	<!-- ------------------- Add Bidding -------------------- -->
	<div id="addBiddingDiv" style="display:none;">
		<div id="divBiddingTemplateContent">

		</div>
    </div> 

	<!-- ------------------- Edit Bidding Item -------------------- -->
	<div id="editBiddingModal" style="display:none;">
		<div id="editBiddingModalHolder" name="editBiddingModalHolder">

		</div>
	</div>

	<!-- ------------------- BIDDING DOCUMENTS -------------------- -->
	<div id="BidDocs" class="section">
    	<table width="100%" align="center">
        	<tr>                
            	<td width="100%" valign="top">
                	<table width="95%" align="center" >
                		<tr>
							<td align="left" style="font-weight:bold">Documents</td>
                        	<td align="right">                    			
                    			<img id="imgaddnda" name="imgaddnda" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="addBiddingDocument(0, 'Add');" /> 
                			</td>
                        </tr>
                    </table>
                	<table width="95%" align="center" border="1" style="border-collapse:collapse">
                    	<tr class="whiteonblack">
                        	<th width="5%">#</th>
                        	<th>Document</th>
							<th width="10%">Type</th>
                            <td colspan="3" width="8%"></td>                            
                        </tr>
                        $biddingdocstable                        
                    </table>                    
                </td>
            </tr>
        </table>
    </div>

	<!-- ------------------- Add Bidding Documents-------------------- -->
	<div id="addBiddingDocument" style="display:none;">
		<div id="divBiddingDocument">

		</div>
    </div> 

	<!-- -------------------------------------- BIDDING MODULE -------------------------- -->
	<div id="Bidding" class="section">
    	<table width="95%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Automated Bidding</td>
        	<td align="right" width="200px" align="right">
				<a href="javascript:void(0)" style="font-weight: 700; color: #2b68f1; line-height: 2rem; margin-right: 5px" onclick="initializeBidding();"> Search </a> |
				<a href="javascript:void(0)" style="font-weight: 700; color: red; line-height: 2rem; margin-left: 5px" onclick="initializeBidding();"> Start a bidding </a>
            </td>
        </tr>
      </table>
	  
      <table class="table" width="95%" align="center" border="1" style="border-collapse:collapse; border: 1px solid #ccc;">
      		<thead class="table__thead" style="background-color: #e0e0e0; " height="30px">
				<tr >
					<th class="table__th" width="5%">#</th>
					<th class="table__th">Bidding Name</th>
					<th class="table__th" width="15%">Cluster</th>
					<th class="table__th" width="8%">Nomination Status</th>
					<th class="table__th" width="10%">Bidding Requirement</th>
					<th class="table__th" width="8%">Bidding Status</th>
					<th class="table__th" colspan="3" width="30%">Action</th>
					<th class="table__th" width="5%"></th>
				</tr>
            </thead>
            <tbody class="table__tbody">
				$biddingtable
            </tbody>
        </table>
    </div>

	<!-- ------------------------- INITIALIZE BIDDING  -------------------------- -->
	<div id="initializeBiddingSection" style="display:none;">
		<form id="biddingStart" name="biddingStart" method="post" action="user-superadmin.php">
			<table width="75%" align="center" bgcolor="#ededed" border="1px">
				<tr valign="top">
					<td style="border-width:0px;">
						<fieldset class="guardmaintabs" id="guardpersonaltab" style="border-width:thin">					
							<legend style="font-weight:bold">Bidding Requirements Information</legend>
							<table>
								<tr>
									<tr>
										<td width='20%'>Bidding Name:</td>
										<td width='80%'><input type='text' id='bidding_name' name='bidding_name'></td>
									</tr>
								</tr>
								<tr>
									<td width="20%">Cluster:</td>
									<td width="80%">								
										<select id="txtbiddingCluster" name="txtbiddingCluster" >
											<option value="None">- Cluster -</option>
											"' . $buclusterdatalist . '"
										</select>
									</td>
								</tr>
								<tr>
									<td width="20%">Requirements template:</td>
									<td width="80%">								
										<select id="txtBiddingRequirements" name="txtBiddingRequirements" >
											<option value="None">- Requirements template -</option>
											"' . $biddingrequirementlist . '"
										</select>
									</td>
								</tr>
								<tr>
									<td width="20%">Bidding Proposal Message:</td>
									<td width="50%"><textarea id="txtBiddingMessage" row="100" style="height: 150px" cols="80" name="txtBiddingMessage"></textarea></td>
								</tr>
							</table>
						</fieldset>													
					</td>					
				</tr>
				<tr>
					<td colspan="100%" style="border-width:0px;">
						<table align="right">
							<tr>
								<td colspan="100%" align="center"><button onclick="closeInitializeBidding()" name="gback" id="gback" class="redbutton" >Cancel</button></td>
								<td colspan="100%" align="center"><button type="submit" name="btn_bidding_start" id="btn_bidding_start" class="redbutton" >Send</button></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<div id="addsecagencymodal" style="display:none; padding-top:24px;" >
    	<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeBiddingAddSecAgencyModal();" />
        <table align="center" width="100%" border="1" style="border-collapse:collapse;">
			<tr>
				<th onclick="toggleTabs('poolSecAgencyDiv', 'biddingaddsecagencydivs');">Nominated Security Agency</th>
			</tr>
			<tr>
				<td colspan="100%">
					<div id="poolSecAgencyDiv" name="poolSecAgencyDiv" style="padding: 10px" class="biddingaddsecagencydivs">
                        <form id="frmPoolAgency" name="frmPoolAgency" method="post" action="user-superadmin.php">
						<table width="100%" align="center" border="1" style="border-collapse:collapse; padding: 10px">
                            <thead>
                                <tr class="whiteonblack">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>President/General Manager</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="tbodyAddSecAgency">
                            </tbody>    
                        </table>
                        
                        <br>
                        <table width="100%" align="center"  width="100%" border="1" style="border-collapse:collapse; padding: 10px">
                            <tr style="background: #ffffd4">
                                <th>List of Security Agency available to Pool</th>
                            </tr>
                        </table>

                        <table width="100%" align="center"  width="100%" border="1" style="border-collapse:collapse; padding: 10px">
                            <tbody id="tbodypoolSecAgencyTable">
                                $poolSecAgencyTable
                            </tbody>    
                        </table>
                        <table width="100%" align="center">
                            <tr>
                                <td align="right">
									<input type="submit" id="btnstartbidding" name="btnstartbidding" class="redbutton" value="Start" />
                                    <input type="submit" id="btnsavepoolagency" name="btnsavepoolagency" class="redbutton" value="Save" />
                                </td>
                            </tr>
                        </table>
                        </form>
					</div>               
				</td>
			</tr>
		</table>
    </div>

	<div id="Audit" class="section" style="overflow-x:auto;">
	
	</div>
	
	<div id="modalAudit" class="section">
		
	</div>
	
	<div id="divGraphAuditHolder" class="section">
		<table width="100%" height="100%">
			<thead id="tblAuditGraphHead" name="tblAuditGraphHead">
				<tr>
					<td colspan="100%" ><label style="text-decoration:underline; color:red; cursor:pointer;" onclick="auditShow2();">View Details</label></td>
				</tr>
			</thead>
			<tbody>
				<tr>				
					<td colspan="100%"><div id="auditBars" width="100%" height="100%"></div></td>
				</tr>
				<tr>
					<td width="50%"><div id="auditStacked" width="100%" height="100%"></div></td>
					<td width="50%"><div id="auditDonut" width="100%" height="100%"></div></td>
				</tr>
			</tbody>
		</table>		
	</div>
	
	<div id="viewAuditUpload" style="display:none;">
	</div>
	
	<div id="addAuditEvidencemodal" style="display:none">
		<form id="addAuditEvidenceform" name="addAuditEvidenceform" method="post" action="user-superadmin.php" enctype="multipart/form-data">
			<table align="center">
				<tr><th>Add File</th></tr>
				<tr align='center'>
					<td>
						<input type="file" name="evidenceattach1[]">
						<input type="file" name="evidenceattach1[]">
						<input type="file" name="evidenceattach1[]">
						<input type="file" name="evidenceattach1[]">
						<input type="file" name="evidenceattach1[]">
						<input type="hidden" id="addauditid" name="addauditid">
						<input type="hidden" id="addaudittype" name="addaudittype">
					</td>
				</tr>
				<tr align="center">
					<td>
						<input type="submit" id="btnAddAuditEvidence" name="btnAddAuditEvidence" class="redbutton" value="Submit">
						<button class="redbutton" id="btnCloseAddAuditEvidence" name="btnCloseAddAuditEvidence">Close</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="testCSV" style="display:none;">
		<form id="frmTestCSV" name="frmTestCSV" method="post" action="main-post.php" enctype="multipart/form-data">
			<table align="center">
				<tr><th>Test File</th></tr>
				<tr>
					<td>
						<input type="file" name="testattach1[]">						
					</td>
				</tr>
				<tr align="center">
					<td>
						<input type="submit" id="btnAddTest" name="btnAddTest" class="redbutton" value="Submit">
						<button class="redbutton" id="btnCloseAddTest" name="btnCloseAddTest">Close</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="viewAuditDetails" style="display:none">
	
	</div>
	<div id="viewAuditDisposition" style="display:none">
		
	</div>
	
    <div id="Locs" class="section">
    	<table width="90%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Locations</td>
            <td align="right">
            	<div id="divSearchLocs" style="display:none;">
                <form id="frmSearchLocs" name="frmSearchLocs" action="user-superadmin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer" onclick="refreshPage('Locs', 'user-superadmin');">Refresh</label>
                	<input type="text" id="txtSearchLocs" name="txtSearchLocs" />
                    <select id="selSearchLocsBu" name="selSearchLocsBu" style="display:none;">
                    	<option value=""></option>
                        $budatalist
                    </select> 
                    <select id="selSearchLocs" name="selSearchLocs" onchange="changeSearch('location_mst');">                    	
                        <option value="location_code">Location Name/Code</option>
                        <option value="bu">Business Unit</option>
                    </select>                     
                    <img src="images/Search_btn.png" width="80px" id="btnsearchlocs" name="btnsearchlocs" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchLocs').value, document.getElementById('selSearchLocs').value,  'location_mst');" />
                </form>    
                </div>
            </td>
        	<td align="right" width="65px" align="right">
                <img src="images/Search-icon.png" height="30px" id="btnshowsearchlocs" name="btnshowsearchlocs" title="Search Locations" style="cursor:pointer;" onclick="toggleSearch('divSearchLocs');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('Locs', 'user-superadmin');" />-->
            	<img src="images/location_add.png" height="30px" id="btnaddlocation" name="btnaddlocation" title="Add Location" style="cursor:pointer;" />
            </td>
        </tr>
      </table>
    	<table width="90%" align="center" border="1" style="border-collapse:collapse">
        	<thead>
        	<tr class="whiteonblack">
            	<th>#</th>
                <th>Business Unit</th>
                <th>Location Code</th>
                <th>Location Name</th>
                <th colspan="2" width="5%">Controls</th>
            </tr>
            </thead>
            <!-- <tbody id="tbodyLocs">
            	$locationstable
            </tbody> -->
			<tbody id="tbodyLocs">
            	<tr><td colspan="100%" align="center">Use the search function to view locations</td></tr>
            </tbody>
        </table>
    </div>
    <div id="addlocsmodal" style="display:none; padding-top:24px;">
    	<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeAddLoc();" />
    	<form id="addlocationform" name="addlocationform" action="user-superadmin.php" method="post">
        <fieldset>
        <legend style="font-weight:bold;">Add Location</legend>
        <table align="center" width="100%">
        	<tr>
                <td align="center">
                <table>
                	<tr>
                    	<td align="right">Business Unit:</td>
                        <td>
                        	<select id="selbuloc" name="selbuloc">
                            	<option value=""></option>
                                $budatalist
                            </select>
                            <input type="hidden" id="txtaddlocationbus" name="txtaddlocationbus" />
                        </td>
                    </tr>
                    <tr>
                        <td align="right">Location Code:</td>
                        <td align="left">
                        	<input type="hidden" id="txtaddlocationid" name="txtaddlocationid" />
                        	<input type="text" id="txtaddlocationcode" name="txtaddlocationcode" />
                            <input type="hidden" id="txtaddlocationcodes" name="txtaddlocationcodes" />
                            <!--<input type="text" id="txtaddlocationbu" name="txtaddlocationbu" style="display:none" readonly="readonly" value="$bu" />-->
                        </td>
                    </tr>
                    <tr>
                        <td align="right">Location:</td>
                        <td align="left">
                        	<input type="text" id="txtaddlocation" name="txtaddlocation" />
                            <input type="hidden" id="txtaddlocations" name="txtaddlocations" />
                        </td>
                    </tr>               
                </table>
                </td>
                <td>
                    <img id="btnaddlocationrow" name="btnaddlocationrow" src="images/location_add.png" style="cursor:pointer;" title="Add Row" height="36px" onclick="addLocationRowSA();" />
                    <img id="btneditlocationrow" name="btneditlocationrow" src="images/saveit.png" width="50px" style="cursor:pointer; display:none;" onclick="updateLocation();" />
                </td>
            </tr>
        </table>
        </fieldset>
        </form>
        <br />
        <div id="locdiv" style="display:none;">
        <table id="addlocationtable" width="100%" border="1" style="border-collapse:collapse;">
        	<thead>
        		<tr class="whiteonblack">
                	<th>Business Unit</th>
            		<th>Code</th>
                    <th>Location</th>
                    <td width="1%"></td>
            	</tr>
            </thead>
            <tbody id="addlocstbody">
            </tbody>
            <tfoot>
            	<tr >
                	<td colspan="4" align="center" style="padding:10px">
                    	<img src="images/confirm.png" width="70px" style="cursor:pointer;" onclick="addLocationsSA();" />
                    </td>                    
                </tr>
            </tfoot>    
        </table>
        </div>
        
    </div>
    <div id="codemgtmodal" style="display:none; padding-top:25px;">
    	<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:1px; top:1px;" onclick="closeCodeMgt();" />
        <form id="codemgtform" name="codemgtform" method="post" action="user-superadmin.php">
    	<table id="tblcodemgt" width="95%" align="center" border="1" style="border-collapse:collapse;">
        	<thead>
              <tr>
                  <td colspan="3" style="font-weight:bold" align="center">Series:
                  	<input type="hidden" id="txtaddcodeseries" name="txtaddcodeseries" />
                    <input type="text" id="txtaddcodeseriesdisplay" name="txtaddcodeseriesdisplay" readonly="readonly" style="text-align:center" />
                  </td>
                  
              </tr>
              <tr class="whiteonblack">            	
                  <th>Code</th>
                  <th>Description</th>
                  <td></td>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            	<tr  align="center" bgcolor="#CCCCCC">
                	<td>
                    	<input type="text" id="txtaddcodecode" name="txtaddcodecode" style="text-align:center" />
                        <input type="hidden" id="txtaddcodecodeall" name="txtaddcodecodeall" />
                    </td>
                    <td>
                    	<input type="text" id="txtaddcodedesc" name="txtaddcodedesc" style="text-align:center" />
                        <input type="hidden" id="txtaddcodedescall" name="txtaddcodedescall" />
                    </td>
                    <td></td>
                </tr>
                <tr>
                	<td colspan="3" align="center">
                    	<img id="btnaddcoderow" name="btnaddcoderow" src="images/add_btn.png" width="80px" onclick="addCodeRow();" />
                    </td>
                </tr>
            </tfoot>
        </table>
        <table width="95%">
        	<tr>
            	<td align="right">
                	<img id="btnsavecode" name="btnsavecode" src="images/confirm_btn.png" width="80px" onclick="saveCodeRow();" />
                    <img id="btnupdatecode" name="btnupdatecode" src="images/confirm_btn.png" width="80px" onclick="updateCodeRow();" style="display:none;" />
                    <input type="hidden" id="txtaddcodeid" name="txtaddcodeid"/>
                </td>
            </tr>
        </table>
        </form>
    </div>
	<div id="divRequests" class="section">
		<table width="95%" align="center">
			<tr>
				<td align="left" style="font-weight:bold">Retraction Requests</td>				
			</tr>
		</table>
		<table width="95%" border="1" align="center" style="border-collapse:collapse;">
			<thead>      
				<tr class="whiteonblack">
					<th>#</th>
					<th>Date & Time</th>
					<th>Requester</th>
					<th>Business<br>Unit</th>
					<th>Ticket<br>Number</th>
					<th>Current<br>Level</th>
					<th>Retraction<br>Level</th>
					<th width="30%">Details</th>
					<th colspan="100%">Controls</th>
				</tr>
			</thead>			
			<tbody id="tbodyRetractions">				
				$tblretract
			</tbody>
		</table>
	</div>
	<div id="divDeletions" class="section">
		<table width="95%" align="center">
			<tr>
				<td align="left" style="font-weight:bold">Deletion Requests</td>				
			</tr>
		</table>
		<table width="95%" border="1" align="center" style="border-collapse:collapse;">
			<thead>      
				<tr class="whiteonblack">
					<th>#</th>
					<th>Date & Time</th>
					<th>Requester</th>
					<th>Business<br>Unit</th>					
					<th>Type</th>
					<th>Target ID</th>
					<th width="30%">Reason</th>
					<th colspan="100%">Controls</th>
				</tr>
			</thead>			
			<tbody id="tbodyRetractions">				
				$tbldeletions
			</tbody>
		</table>
	</div>
	<div id="ApproveRetractModal" style="display:none;">
		<form id="frmApproveRetract" name="frmApproveRetract" method="post" action="user-superadmin.php">
			<table width="100%">
				<tr>
					<td></td>
					<td align="center"><label id="lblRetractApproval" name="lblRetractApproval" style="font-weight:bold;">APPROVE RETRACTION</label></td>
				</tr>
				<tr>
					<td align="right">Retract to level:</td>
					<td><input type="number" id="numApproveRetract" name="numApproveRetract" min="1" max="5" required="required"></td>				
				</tr>
				<tr>
					<td valign="top" align="right">Comment:</td>
					<td><textarea id="txtRetractComment" name="txtRetractComment" style="width:95%; height:150px; resize:none;" required="required"></textarea></td>
				</tr>
				<tr>
					<td colspan="100%" align="right">
						<input type="hidden" id="txtRetractId" name="txtRetractId">
						<input type="hidden" id="txtRetractBuId" name="txtRetractBuId">
						<input type="hidden" id="txtRetractMainId" name="txtRetractMainId">
						<input type="hidden" id="txtRetractState" name="txtRetractState">
						<input type="hidden" id="txtRetractRequester" name="txtRetractRequester">					
						<input type="submit" id="btnSubmitApproval" name="btnSubmitApproval" class="redbutton" value="Submit">
						<!-- <img src='images/checkgreen.png' height='24px' style='cursor:pointer;' onclick='submitApproval();'> -->
						<button class="redbutton" id="btnBackApproval" name="btnBackApproval" name="" >Cancel</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="ApproveDeletionModal" style="display:none;">
		<form id="frmApproveDeletion" name="frmApproveDeletion" method="post" action="user-superadmin.php">
			<table width="100%">
				<tr>
					<td></td>
					<td align="center"><label id="lblDeletionApproval" name="lblDeletionApproval" style="font-weight:bold;">APPROVE DELETION</label></td>
				</tr>				
				<tr>
					<td valign="top" align="right">Comment:</td>
					<td><textarea id="txtDeletionComment" name="txtDeletionComment" style="width:95%; height:150px; resize:none;" required="required"></textarea></td>
				</tr>
				<tr>
					<td colspan="100%" align="right">
						<input type="hidden" id="txtDeletionId" name="txtDeletionId">
						<input type="hidden" id="txtDeletionBuId" name="txtDeletionBuId">
						<input type="hidden" id="txtDeletionMainId" name="txtDeletionMainId">
						<input type="hidden" id="txtDeletionState" name="txtDeletionState">
						<input type="hidden" id="txtDeletionRequester" name="txtDeletionRequester">					
						<input type="submit" id="btnSubmitDeletionApproval" name="btnSubmitDeletionApproval" class="redbutton" value="Submit">
						<!-- <img src='images/checkgreen.png' height='24px' style='cursor:pointer;' onclick='submitApproval();'> -->
						<button class="redbutton" id="btnBackDeletionApproval" name="btnBackDeletionApproval" name="" >Cancel</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
    <div id="CodeMgt" class="section">
   	  <table width="95%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Code Management</td>        	
            <td align="right">
            	<div id="divSearchCodes" style="display:none;">
                <form id="frmSearchCodes" name="frmSearchCodes" action="user-superadmin.php" method="post">
                	<label style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="refreshPage('CodeMgt', 'user-superadmin');">Refresh</label>
                	<input type="text" id="txtSearchCodes" name="txtSearchCodes" />
                    <img src="images/Search_btn.png" width="80px" id="btnSearchCodes" name="btnSearchCodes" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchCodes').value, document.getElementById('txtcodetype').value, 'urc_mst');" />
                </form>    
                </div>                
            </td>
            <td width="30px">
            	<img src="images/Search-icon.png" height="30px" id="btnShowSearchCodes" name="btnShowSearchCodes" title="Search Codes" style="cursor:pointer;" onclick="toggleSearch('divSearchCodes');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('CodeMgt', 'user-superadmin');" />-->
            </td>	          
        </tr>
      </table>
      <div id="divCodeDisplay">
        <table width="95%" border="1" align="center" style="border-collapse:collapse">
            <tr>
                <th class="codetab" id="codetab10" bgcolor="#000000" style="color:#FFF" onclick="toggleMe2('10codes', 'codetab10', '10-00', '10-00 Series');">10-00 Series</th>
                <th class="codetab" id="codetab11" onclick="toggleMe2('11codes', 'codetab11', '11-00', '11-00 Series');">11-00 Series</th>
                <th class="codetab" id="codetabdc" onclick="toggleMe2('disposition', 'codetabdc', 'disposition', 'Disposition Codes');">Disposition Codes</th>
                <th class="codetab" id="codetabc" onclick="toggleMe2('codes', 'codetabc', 'codes', 'CODE-Series');">Codes</th>
                <th class="codetab" id="codetabpa" onclick="toggleMe2('phonetic', 'codetabpa', 'phonetic', 'Phonetic Alphabet');">Phonetic Alphabet</th>
            </tr>
        </table>
        <br />
        <table width="60%" align="center">
                <tr>
                    <td align="right" valign="middle" >
                        <input type="hidden" id="txtcodetype" name="txtcodetype"  value="10-00" />
                        <input type="hidden" id="txtcodetypedisplay" name="txtcodetypedisplay" value="10-00 Series" />
                        
                        <img id="imgaddcode" name="imgaddcode" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="addCodeEntry();" />                  
                    </td>
                </tr>
            </table>
        <div id="10codes" class="codediv">
            <table width="60%" align="center" border="1" style="border-collapse:collapse">
                <tr>
                  <th width="30%">10-00 Code</th>
                  <th width="70%">Description</th>
                  <td width="5%" colspan="2"></td>
                </tr>
                $code10table
            </table>
        </div>
        <div id="11codes" class="codediv" style="display:none;">
            <table width="60%" align="center" border="1" style="border-collapse:collapse">
                <tr>
                  <th width="30%">11-00 Code</th>
                  <th width="70%">Description</th>
                  <td width="5%" colspan="2"></td>
                </tr>
                $code11table
            </table>
        </div>
        <div id="disposition" class="codediv" style="display:none;">
            <table width="60%" align="center" border="1" style="border-collapse:collapse">
                <tr>
                  <th width="30%">Disposition Code</th>
                  <th width="70%">Description</th>
                  <td width="5%" colspan="2"></td>
                </tr>
                $codedctable
            </table>
        </div>
        <div id="codes" class="codediv" style="display:none;">
            <table width="60%" align="center" border="1" style="border-collapse:collapse">
                <tr>
                  <th width="30%">Code</th>
                  <th width="70%">Description</th>
                  <td width="5%" colspan="2"></td>
                </tr>
                $codetable
            </table>
        </div>
        <div id="phonetic" class="codediv" style="display:none;">
            <table width="60%" align="center" border="1" style="border-collapse:collapse">
                <tr>
                  <th width="30%">Phonetic Alphabet</th>
                  <th width="70%">Description</th>
                  <td width="5%" colspan="2"></td>
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
                <td width="5%" colspan="2"></td>
              </tr>
              </thead>
              <tbody id="tbodyCodes">
              </tbody>
          </table>
      </div>
    </div>
    <div id="BUs" class="section">
    	<table width="90%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Business Units</td>
            <td align="right">
            	<div id="divSearchBUs" style="display:none;">
                <form id="frmSearchBUs" name="frmSearchBUs" action="user-superadmin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer" onclick="refreshPage('BUs', 'user-superadmin');">Refresh</label>
                	<input type="text" id="txtSearchBUs" name="txtSearchBUs" />
                    <select id="selSearchBUGroup" name="selSearchBUGroup" style="display:none;">
                    	<option value=""></option>
                        $bugroupdatalist
                    </select>
                    <select id="selSearchBURegion" name="selSearchBURegion" style="display:none;">
                    	<option value=""></option>
                        $buregionaldatalist
                    </select>
                    <select id="selSearchBUs" name="selSearchBUs" onchange="changeSearch('bu_mst');">
                    	<option value="bu">BU Name</option>
                        <option value="bu_code">BU Code</option>
                        <option value="main_group">Group</option>
                        <option value="regional_group">Region</option>                        
                    </select>
                    <img src="images/Search_btn.png" width="80px" id="btnsearchbus" name="btnsearchbus" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchBUs').value, document.getElementById('selSearchBUs').value, 'bu_mst');" />
                </form>    
                </div>
            </td>
        	<td align="right" width="70px">
            	<img src="images/Search-icon.png" height="30px" id="btnShowSearchBUs" name="btnShowSearchBUs" title="Search Business Units" style="cursor:pointer;" onclick="toggleSearch('divSearchBUs');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('BUs', 'user-superadmin');" />-->
                <img id="imgaddbu" name="imgaddbu" src="images/add_item.png" height="32px" style="cursor:pointer;" onclick="addBU();" /> 
            	
            </td>
        </tr>
      </table>
      <table width="90%" align="center" border="1" style="border-collapse:collapse">
      	<thead>
        	<tr class="whiteonblack">
            	<th>#</th>
                <th>Business Unit</th>
                <th>BU Code</th>
                <th>Group</th>
                <th>Region</th>
				<th>Cluster</th>
                <th>EXPRO</th>
                <th colspan="2" width="5%"></th>
            </tr>
        </thead>
        <tbody id="tbodyBUs">
        	$butable
        </tbody>
      </table>
    </div>
    <div id="modalBU" style="display:none; padding-top:25px;">
    <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:1px; top:1px;" onclick="closeBU();" />
        <form id="frmBU" name="frmBU" enctype="multipart/form-data" method="post" action="user-superadmin.php">
    	<table id="tblBU" width="95%" align="center" border="1" style="border-collapse:collapse;">
        	<thead>
              <!--<tr>
                  <td colspan="4" style="font-weight:bold" align="center">Add Business Unit
                  </td>                  
              </tr>-->
              <tr class="whiteonblack">            	
                  <th>Business Unit</th>
                  <th>BU Code</th>
                  <th>Group</th>
                  <th>Region</th>
				  <th>Cluster</th>
                  <th>EXPRO</th>
                  <td></td>
              </tr>
            </thead>
            <tbody id="tbodybuadd">
            </tbody>
            <tfoot>
            	<tr  align="center" bgcolor="#CCCCCC">
                	<td>
                    	<input type="text" id="txtaddbuname" name="txtaddbuname" style="text-align:center" /> 
                        <input type="hidden" id="txtaddbunameall" name="txtaddbunameall" />                       
                    </td>
                    <td>
                    	<input type="text" id="txtaddbucode" name="txtaddbucode" style="text-align:center" /> 
                        <input type="hidden" id="txtaddbucodeall" name="txtaddbucodeall" />                       
                    </td>
                    <td>
                    	<select id="seladdbugroup" name="seladdbugroup">
                        	<option value=""></option>
                            $bugroupdatalist
                        </select>
                        <input type="hidden" id="txtaddbugroupall" name="txtaddbugroupall" />
                    </td>
                    <td>
                    	<select id="seladdburegion" name="seladdburegion">
                        	<option value=""></option>
                            $buregionaldatalist
                        </select>
                        <input type="hidden" id="txtaddburegionall" name="txtaddburegionall" />
                    </td>
					<td>
                    	<select id="seladdbucluster" name="seladdbucluster">
                        	<option value=""></option>
                            $buclusterdatalist
                        </select>
                        <input type="hidden" id="txtaddbuclusterall" name="txtaddbuclusterall" />
                    </td>
                    <td>
                    	<select id="selexprogroup" name="selexprogroup">
                        	<option value=""></option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        <input type="hidden" id="txtexprogroupall" name="txtexprogroupall" />
                    </td>
                    <td></td>
                </tr>
                <tr>
                	<td colspan="100%" align="center">
                    	<img id="btnaddburow" name="btnaddburow" src="images/add_btn.png" width="80px" onclick="addBUrow();" style="cursor:pointer;" />
                    </td>
                </tr>
            </tfoot>
        </table>
        <table width="95%" align="center">
        	<tr>
				<td align="left" valign="middle">
					<div id="bulogoupdatediv" name="bulogoupdatediv" style="display:none;">
					Update logo:
					<input type="file" name="bulogo"><br>
					
					<img id="bulogobox" height="50px" alt="No BU Logo yet">								
					</div>
				</td>
            	<td align="right">
                	<img id="btnsavebu" name="btnsavebu" src="images/confirm_btn.png" width="100px" onclick="saveBUrow();" style="cursor:pointer;" />
                    <img id="btnupdatebu" name="btnupdatebu" src="images/update.png" width="100px" onclick="updateBU();" style="cursor:pointer; display:none;" />
                    <input type="hidden" id="txtaddbuid" name="txtaddbuid" />
                </td>
            </tr>
        </table>
        </form>
    	
    </div>
    <div id="modalbugroupregion" style="display:none; padding-top:24px;">
    <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:1px; top:1px;" onclick="closeBUgroupregion();" />
    <form id="frmbuitementry" name="frmbuitementry" action="user-superadmin.php" method="post">
    	<table width="90%" id="tblbugroupregion" align="center" border="1" style="border-collapse:collapse;">
        	<thead>            	               
                <tr class="whiteonblack">                	
                    <th id="additemtitle">Group</th>
                    <td width="5%"></td>
                </tr>
            </thead>
            <tbody id="tblbugroupregiontbody">
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" align="center" bgcolor="#CCCCCC">
                    	<input type="text" id="txtaddbuitementry" name="txtaddbuitementry" style="text-align:center;" />
                        <input type="hidden" id="txtaddbuitem" name="txtaddbuitem" />
                        <input type="hidden" id="txtaddbuitementryall" name="txtaddbuitementryall" />
                        <input type="hidden" id="txtaddbuitemid" name="txtaddbuitemid" />
                        <input type="hidden" id="txtaddbuitemaction" name="txtaddbuitemaction" />
                    </td>
                </tr>
                <tr>
                	<td colspan="2" align="center"><img id="btnaddbuitem" name="btnaddbuitem" src="images/add_btn.png" width="80px" onclick="addBUitemrow();" /></td>
                </tr>
            </tfoot>
        </table>
        <table width="90%" align="center">
        	<tr>
            	<td align="right"><img src="images/confirm_btn.png" width="80px" onclick="saveBUitemrow();" /></td>
            </tr>
        </table>
    </form>
    </div>
    <div id="Groups" class="section">
    	<table width="90%" align="center">
        	<tr>                
            	<td width="33%" valign="top">
                	<table width="90%" align="center" >
                		<tr>
                        	<td align="right">                    			
                    			<img id="imgaddbugroup" name="imgaddbugroup" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="addBUgroupregion('Group');" /> 
                			</td>
                        </tr>
                    </table>
                	<table width="90%" align="center" border="1" style="border-collapse:collapse">
                    	
                    	<tr class="whiteonblack">
                        	<th>#</th>
                        	<th>Groups</th>
                            <td colspan="2" width="5%"></td>                            
                        </tr>
                        $bugrouptable                        
                    </table>                    
                </td>
                <td width="33%" valign="top">
                	<table width="90%" align="center" >
                		<tr>
                        	<td align="right">
                    			
                    			<img id="imgaddburegion" name="imgaddburegion" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="addBUgroupregion('Region');" /> 
                			</td>
                        </tr>
                    </table>
                	<table width="90%" align="center" border="1" style="border-collapse:collapse">
                    	<tr class="whiteonblack">
                        	<th>#</th>
                        	<th>Regions</th>
                            <td colspan="2" width="5%"></td>                            
                        </tr>
                        $buregionaltable
                    </table>
                </td>
				<td width="34%" valign="top">
                	<table width="90%" align="center" >
                		<tr>
                        	<td align="right">

                    			<img id="imgaddburegion" name="imgaddburegion" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="addBUgroupregion('Cluster');" /> 
                			</td>
                        </tr>
                    </table>
                	<table width="90%" align="center" border="1" style="border-collapse:collapse">
                    	<tr class="whiteonblack">
                        	<th>#</th>
                        	<th>Cluster</th>
                            <td colspan="2" width="5%"></td>                            
                        </tr>
                        $buclustertable
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div id="SecAlert" class="section">
    	<table width="90%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Security Alert Recipients</td>
			<td align="right">
            	<div id="divSearchSecAlertRecipients" style="display:none;">
                <form id="frmSearchSecAlertRecipients name="frmSearchSecAlertRecipients" action="user-superadmin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer;" onclick="refreshPage('SecAlert', 'user-superadmin');">Refresh</label>
                    &nbsp;
                	<input type="text" id="txtSearchSecAlertRecipients" name="txtSearchSecAlertRecipients" />
                    <select id="selSecAlertRecipientsBu" name="selSecAlertRecipientsBu" style="display:none;">
                    	<option value=""></option>
                        $budatalist
                    </select>                    
                    <select id="selSearchSecAlertRecipients" name="selSearchSecAlertRecipients" onchange="changeSearch('oic_mst');">
                    	<option value="lname">Last Name</option>
                        <option value="fname">First Name</option>
						<option value="email_ad">E-mail address</option>
                        <!-- <option value="mobile">Contact Number</option> -->
                        <option value="bu">Business Unit</option>                       
                    </select>
                    <img src="images/Search_btn.png" width="80px" id="btnsearchsecalertrecipiemts" name="btnsearchsecalertrecipiemts" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchSecAlertRecipients').value, document.getElementById('selSearchSecAlertRecipients').value, 'oic_mst');" />
                </form>    
                </div>
            </td>
        	<td align="right">
			<img src="images/Search-icon.png" height="30px" id="btnshowsearchsecalertrecipients" name="btnshowsearchsecalertrecipients" title="Search SecAlert Recipients" style="cursor:pointer;" onclick="toggleSearch('divSearchSecAlertRecipients');" />
            	<img src="images/mail_add.png" height="30px" id="btnaddrecipient" name="btnaddrecipient" title="Add Recipient" style="cursor:pointer;" />
            </td>
        </tr>
      </table>
      <table width="90%" align="center" border="1" style="border-collapse:collapse">
			<thead>
        	<tr class="whiteonblack">
            	<th>#</th>
                <th>Name</th>
                <th>E-Mail Address</th>
                <!-- <th>Contact Number</th> -->
                <th>Business Unit</th>
				<th>Recipient Level</th>
                <th colspan="2" width="5%">Controls</th>
            </tr>
			</thead>
			<!-- <tbody id="tbodySecAlert">
            $oictable
			</tbody> -->
			<tbody id="tbodySecAlert">
				<tr><td colspan="100%" align="center">Use the search function to view Security Alert Recipients</td></tr>
			</tbody>
        </table>
    </div>
    <div id="addoicform" style="display:none; padding-top:24px;">
    <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeAddOic();" />
    	<form id="oicform" name="oicform" action="user-superadmin.php" method="post">
        <fieldset>
        <legend style="font-weight:bold">Add Security Alert Recipients</legend>
            <table width="100%" align="center">
                <tr>
                	<td>Last Name</td>
                    <td><input type="text" id="oiclastname" name="oiclastname" required="required" /></td>
                </tr>
                <tr>
                	<td>First Name</td>
                    <td><input type="text" id="oicfirstname" name="oicfirstname" required="required" /></td>
                </tr>
                <!-- <tr>
                	<td>Middle Name</td>
                    <td><input type="text" id="oicmiddlename" name="oicmiddlename" required="required" /></td>
                </tr> -->
                <tr>
                	<td>E-mail Address</td>
                    <td><input type="text" id="oicemail" name="oicemail" required="required" /></td>
                </tr>
                <!-- <tr>
                	<td>Contact Number</td>
                    <td><input type="text" id="oiccontact" name="oiccontact" required="required" /></td>
                </tr> -->
                <tr>
                	<td>Business Unit</td>
                    <td>
                    	<select id="oicbu" name="oicbu" required>
                        	<option value=""></option>
                            $budatalist
                        </select>
                    	<!--<input type="text" id="oicbu" name="oicbu" readonly="readonly" value="$headerBu" />-->
                        <input type="text" id="oicid" name="oicid" readonly="readonly" style="display:none;" />
                    </td>
                </tr>
				<tr>
					<td>Recipient Level:</td>
					<td>
						<select id="oicslevel" name="oicslevel">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
					</td>
				</tr>
                <tr>
                	<td colspan="2" align="center">
                    	<input type="submit" id="btnsaveoic" name="btnsaveoic" class="redbutton" value="Save" />
                        <input type="submit" id="btneditoic" name="btneditoic" class="redbutton" value="Update" style="display:none;" />
                    </td>
                </tr>
            </table>
        </fieldset>
        </form>
    </div>
    <div id="Entries" class="section">
		<div id="divClassicEntries" name="divClassicEntries">
			<table width="95%" align="center">
				<tr>
					<td colspan="100%" align="left">
						<label style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="toggleAdd('divClassicEntries', 'divIncidentClassification'); getIncidentClassifications();">Incident Classification</label>
					</td>
				</tr>
				<tr>
					<td width="33%" valign="top">
						<table width="95%" align="center" >
							<tr>
								<td align="right">                    			
									<img id="imgaddactivity" name="imgaddactivity" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="addInputEntries('Activity')" /> 
								</td>
							</tr>
						</table>
						<table width="95%" align="center" border="1" style="border-collapse:collapse">                    	
							<tr class="whiteonblack">
								<th>#</th>
								<th>Activity</th>
								<td colspan="2" width="5%"></td>                            
							</tr>
							$activityentriestable                                                
						</table> 
					</td>
					<td width="33%" valign="top">
						<table width="95%" align="center" >
							<tr>
								<td align="right">                    			
									<img id="imgaddincident" name="imgaddincident" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="addInputEntries2('Incident')" /> 
								</td>
							</tr>
						</table>
						<table width="95%" align="center" border="1" style="border-collapse:collapse">                    	
							<tr class="whiteonblack">
								<th>#</th>
								<th>Incident</th>
								<td colspan="2" width="5%"></td>                            
							</tr>
							$incidententriestable                                                
						</table>
					</td>
					<td width="33%" valign="top">
						<table width="95%" align="center" >
							<tr>
								<td align="right">
									
									<img id="imgaddactivity" name="imgaddactivity" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="addInputEntries('EXPRO')" /> 
								</td>
							</tr>
						</table>
						<table width="95%" align="center" border="1" style="border-collapse:collapse">                    	
							<tr class="whiteonblack">
								<th>#</th>
								<th>EXPRO</th>
								<td colspan="2" width="5%"></td>                            
							</tr>
							$exproentriestable                                                
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div id="divIncidentClassification" name="divIncidentClassification" style="display:none;">
			<table width="95%" align="center">
				<tr>
					<td colspan="100%" align="left">
						<label style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="toggleAdd('divClassicEntries', 'divIncidentClassification');">Back</label>
					</td>
				</tr>
				<tr>
					<td width="50%" valign="top">
						<table width="95%" align="center" >
							<tr>
								<td align="right">                    			
									<img id="imgAddIncMainClass" name="imgAddIncMainClass" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="openIncidentClassifications('addMain');" /> 
								</td>
							</tr>
						</table>
						<table id="tblIncMainClass" name="tblIncMainClass" width="95%" align="center" border="1" style="border-collapse:collapse">     
							<thead>
								<tr class="whiteonblack">
									<th>#</th>
									<th>Main Classification</th>
									<td colspan="2" width="5%"></td>                            
								</tr>
							</thead>
							<tbody>
							
							</tbody>							                                              
						</table> 
					</td>
					<td width="50%" valign="top">
						<table width="95%" align="center" >
							<tr>
								<td align="right">                    			
									<img id="imgAddIncSubClass" name="imgAddIncSubClass" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="openIncidentClassifications('addSub');" /> 
								</td>
							</tr>
						</table>
						<table id="tblIncSubClass" name="tblIncSubClass" width="95%" align="center" border="1" style="border-collapse:collapse">
							<thead>
								<tr class="whiteonblack">
									<th>#</th>
									<th>Main Classification</th>
									<th>Sub Classification</th>
									<td colspan="2" width="5%"></td>                            
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table> 
					</td>
				</tr>
			</table>
		</div>
		<div id="modalincmainclass" name="modalincmainclass" style="display:none;" >
		</div>
    </div>
	<div id="modalEntries2" style="display:none; padding-top:24px;">
	</div>
    <div id="modalEntries" style="display:none; padding-top:24px;">
    <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:1px; top:1px;" onclick="closeInputEntries();" />
    <form id="frmEntries" name="frmEntries" action="user-superadmin.php" method="post">
    	<table width="90%" id="tblEntries" align="center" border="1" style="border-collapse:collapse;">
        	<thead>            	               
                <tr class="whiteonblack">                	
                    <th id="addEntriesTitle">Activity</th>
					<th class="severityfactors" style="display:none;">Default Level</th>
					<th class="severityfactors" style="display:none;">Injury Minor</th>
					<th class="severityfactors" style="display:none;">Injury Serious</th>
					<th class="severityfactors" style="display:none;">Property Damage Non-Crit</th>
					<th class="severityfactors" style="display:none;">Property Damage Critical</th>
					<th class="severityfactors" style="display:none;">Property Loss Non-Crit</th>
					<th class="severityfactors" style="display:none;">Property Loss Critical</th>
					<th class="severityfactors" style="display:none;">Work Stoppage</th>
					<th class="severityfactors" style="display:none;">Death 1</th>
					<th class="severityfactors" style="display:none;">Death 2</th>
					<th class="severityfactors" style="display:none;">Death 3+</th>
                    <td width="5%"></td>
                </tr>
            </thead>
            <tbody id="tbltbodyEntries">
            </tbody>
            <tfoot>
                <tr>
                    <td align="center" bgcolor="#CCCCCC">
                    	<input type="text" id="txtAddEntries" name="txtAddEntries" style="text-align:center;" />
                        <input type="hidden" id="txtAddEntriesType" name="txtAddEntriesType" />
                        <input type="hidden" id="txtAddEntriesAll" name="txtAddEntriesAll" />
                        <input type="hidden" id="txtAddEntriesId" name="txtAddEntriesId" />
                        <input type="hidden" id="txtAddEntriesAction" name="txtAddEntriesAction" />
						<input type="hidden" id="txtAddSvDefault" name="txtAddSvDefault" />
						<input type="hidden" id="txtAddSvInjuryMinor" name="txtAddSvInjuryMinor" />
						<input type="hidden" id="txtAddSvInjurySerious" name="txtAddSvInjurySerious" />
						<input type="hidden" id="txtAddSvPropDmgNC" name="txtAddSvPropDmgNC" />
						<input type="hidden" id="txtAddSvPropDmgCrit" name="txtAddSvPropDmgCrit" />
						<input type="hidden" id="txtAddSvPropLossNC" name="txtAddSvPropLossNC" />
						<input type="hidden" id="txtAddSvPropLossCrit" name="txtAddSvPropLossCrit" />
						<input type="hidden" id="txtAddSvWorkStoppage" name="txtAddSvWorkStoppage" />
						<input type="hidden" id="txtAddSvDeath1" name="txtAddSvDeath1" />
						<input type="hidden" id="txtAddSvDeath2" name="txtAddSvDeath2" />
						<input type="hidden" id="txtAddSvDeath3" name="txtAddSvDeath3" />
                    </td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvdefault" name="txtsvdefault" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvinjuryminor" name="txtsvinjuryminor" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvinjuryserious" name="txtsvinjuryserious" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvpropdmgnc" name="txtsvpropdmgnc" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvpropdmgcrit" name="txtsvpropdmgcrit" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvproplossnc" name="txtsvproplossnc" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvproplosscrit" name="txtsvproplosscrit" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvworkstop" name="txtsvworkstop" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvdeath1" name="txtsvdeath1" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvdeath2" name="txtsvdeath2" type="number" min="1" max="5" align="center"></td>
					<td class="severityfactors" style="display:none;" align="center"><input id="txtsvdeath3" name="txtsvdeath3" type="number" min="1" max="5" align="center"></td>
					<td></td>
                </tr>
                <tr>
                	<td colspan="100%" align="center"><img id="btnAddEntries" name="btnAddEntries" src="images/add_btn.png" width="80px" onclick="addInputEntriesRow();" /></td>
                </tr>
            </tfoot>
        </table>
        <table width="90%" align="center">
        	<tr>
            	<td align="right"><img src="images/confirm_btn.png" width="80px" onclick="saveInputEntries();" /></td>
            </tr>
        </table>
    </form>
    </div>
    <div id="Users" class="section">
      <table width="95%" align="center">
      	<tr>
        	        	
            <td align="right">
            	<div id="divSearchUsers" style="display:none;">
                <form id="frmSearchUsers" name="frmSearchUsers" action="user-superadmin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer" onclick="refreshPage('Users', 'user-superadmin');">Refresh</label>
                	<input type="text" id="txtSearchUsers" name="txtSearchUsers" />
                    <select id="selSearchUsersLevel" name="selSearchUsersLevel" style="display:none;">
                    	<option value=""></option>
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                    <select id="selSearchUsersBU" name="selSearchUsersBU" style="display:none;">
                    	<option value=""></option>
                        $budatalist
                    </select>
                    <select id="selSearchUsersGender" name="selSearchUsersGender" style="display:none;">
                    	<option value=""></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <select id="selSearchUsers" name="selSearchUsers" onchange="changeSearch('users_mst');">
                    	<option value="lname">Last Name</option>
                        <option value="fname">First Name</option>
                        <option value="level">Level</option>
                        <option value="email">Username</option>
                        <option value="gender">Gender</option>
                        <option value="contact">Contact Number</option>
                        <option value="bu">Business Unit</option>
                    </select>
                    <img src="images/Search_btn.png" width="80px" id="btnSearchUsers" name="btnSearchUsers" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchUsers').value, document.getElementById('selSearchUsers').value, 'users_mst');" />
                </form>    
                </div>                
            </td>
            <td width="30px">
            	<img src="images/Search-icon.png" height="30px" id="btnShowSearchUsers" name="btnShowSearchUsers" title="Search Users" style="cursor:pointer;" onclick="toggleSearch('divSearchUsers');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('Users', 'user-superadmin');" />-->
            </td>	          
        </tr>
      </table>      
      <div id="divUsersDisplay">
        <table width="95%" border="1" align="center" style="border-collapse:collapse">
                <tr>
                    <!-- <th class="acctab" id="acctabuser" width="33%" bgcolor="#000000" style="color:#FFF; cursor:pointer" onclick="toggleMe3('divuseracc', 'acctabuser', 'User');">Users</th>
                    <th class="acctab" id="acctabadmin" width="33%" style="cursor:pointer;" onclick="toggleMe3('divadminacc', 'acctabadmin', 'Admin');">Admins</th>
                    <th class="acctab" id="acctabsuper" width="34%" style="cursor:pointer;" onclick="toggleMe3('divsuperacc', 'acctabsuper', 'Super Admin');">Super Admins</th> -->
					<th class="acctab" id="acctabuser" width="25%" bgcolor="#000000" style="color:#FFF; cursor:pointer" onclick="toggleMe3('divuseracc', 'acctabuser', 'User');">Security Guard</th>
                    <th class="acctab" id="acctabheadguard" width="25%" style="cursor:pointer;" onclick="toggleMe3('divheadguardacc', 'acctabheadguard', 'Head Guard');">Head Guard</th>
					<th class="acctab" id="acctabadmin" width="25%" style="cursor:pointer;" onclick="toggleMe3('divadminacc', 'acctabadmin', 'Admin');">BU Security Head</th>
                    <th class="acctab" id="acctabsuper" width="25%" style="cursor:pointer;" onclick="toggleMe3('divsuperacc', 'acctabsuper', 'Super Admin');">Super Admins</th>               
				</tr>
            </table>
            <table width="95%" align="center">
                  <tr>
                      <td align="left" style="font-weight:bold">Accounts</td>
                      <td align="right">
                          <label for="btnadduse" style="font-weight:bold;">Add User</label>
                          <img src="images/add_item.png" height="30px" id="btnadduser" name="btnadduser" title="Add User" style="cursor:pointer; vertical-align:middle;" />
                          <input type="hidden" id="txtAcctType" name="txtAcctType" value="User" />
                      </td>
                  </tr>
                </table>
            <div id="divuseracc" class="accdiv">        	
                <table width="95%" align="center" border="1" style="border-collapse:collapse">
                      <tr class="whiteonblack">
                          
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Username</th>
                          <th>Access Level</th>
                          <th>Business Unit</th>
                          <th>Contact</th>
                          <th>Status</th>                
                          <th colspan="2" width="5%">Controls</th>
                      </tr>
                      $userstable
                </table>
            </div>
			<div id="divheadguardacc" class="accdiv" style="display:none">
                <table width="90%" align="center" border="1" style="border-collapse:collapse">
                      <tr class="whiteonblack">
                          
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Username</th>
                          <th>Access Level</th>
                          <th>Business Unit</th>
                          <th>Contact</th>
                          <th>Status</th>                
                          <th colspan="2" width="5%">Controls</th>
                      </tr>
                      $headguardtable
                </table>
            </div>
            <div id="divadminacc" class="accdiv" style="display:none">
                <table width="90%" align="center" border="1" style="border-collapse:collapse">
                      <tr class="whiteonblack">
                          
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Username</th>
						  <th>Email</th>
                          <th>Access Level</th>
                          <th>Business Unit</th>
                          <th>Contact</th>
                          <th>Status</th>                
                          <th colspan="2" width="5%">Controls</th>
                      </tr>
                      $adminstable
                </table>
            </div>
            <div id="divsuperacc" class="accdiv" style="display:none">
                <table width="90%" align="center" border="1" style="border-collapse:collapse">
                      <tr class="whiteonblack">
                          
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Username</th>
						  <th>Email</th>
                          <th>Access Level</th>
                          <th>Business Unit</th>
                          <th>Contact</th>
                          <th>Status</th>                
                          <th colspan="2" width="5%">Controls</th>
                      </tr>
                      $superstable
                </table>
            </div>
      </div>
	  
	  <div id="divUserDisplaySearch" style="display:none;">
      	<table width="90%" align="center" border="1" style="border-collapse:collapse">
          <thead>
            <tr class="whiteonblack">                
                <th>Name</th>
                <th>Gender</th>
                <th>Username</th>
                <th>Access Level</th>
                <th>Business Unit</th>
                <th>Contact</th>
                <th>Status</th>                
                <th colspan="2" width="5%">Controls</th>
            </tr>
          </thead>
          <tbody id="tbodyUsers">
           
          </tbody>
        </table>
      </div>
    </div>
	<div id="addmultiplebudiv" style="display:none; padding-top:24px;">
		<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeMultipleBUModal();" />
		<form id="addmultiplebuform" name="addmultiplebuform" action="user-superadmin.php" method="post">
			<table width="90%" id="tblmultiplebu" align="center" border="1" style="border-collapse:collapse;">
        	<thead>
                <tr class="whiteonblack">           	
                    <th>Multiple BUs</th>
                    <td width="5%"></td>
                </tr>
            </thead>
            <tbody id="tblmultiplebubody">
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="100%" align="center" bgcolor="#CCCCCC">
                    	<select id="selmultiplebu" name="selmultiplebu">
							$budatalist
						</select>
						<input type="hidden" id="multiplebuid" name="multiplebuid" />
						<input type="hidden" id="multiplebuall" name="multiplebuall" />
                    </td>
                </tr>
                <tr>
                	<td colspan="2" align="center"><img id="btnaddbuitem" name="btnaddbuitem" src="images/add_btn.png" width="80px" onclick="addmultipleburow();" /></td>
                </tr>
            </tfoot>
        </table>
        <table width="90%" align="center">
        	<tr>
            	<td align="right"><img src="images/confirm_btn.png" width="80px" onclick="savemultipleburow();" /></td>
            </tr>
        </table>
		</form>
	</div>
    <div id="adduserdiv" style="display:none; padding-top:24px;">
    	<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeAddUser();" />
    	<form id="adduserform" name="adduserform" action="user-superadmin.php" method="post">
        <fieldset>
        <legend style="font-weight:bold;">Add User</legend>
    	<table align="center">
        	<tr>
            	<td>Last Name</td>
                <td>
                	<input type="text" id="userslastname" name="userslastname" required="required" />
                    <input type="text" id="usersid" name="usersid" readonly="readonly" style="display:none;" />
                </td>
            </tr>
            <tr>
            	<td>First Name</td>
                <td><input type="text" id="usersfirstname" name="usersfirstname" required="required" /></td>
            </tr>
            <!-- <tr>
            	<td>Middle Initial</td>
                <td><input type="text" id="usersmi" name="usersmi" required="required" size="3" maxlength="1" /></td>
            </tr>
            <tr>
            	<td>Gender:</td>
                <td>
                	<select id="selugender" name="selugender" required>
                                	<option value=""></option>
                                	<option value="Male">Male</option>
                                    <option value="Female">Female</option>
                            	</select>
                </td>
            </tr> -->
            <tr>
            	<td>Username</td>
                <td><input type="text" id="usersusername" name="usersusername" required="required" onkeyup="checkUsername();" /></td>
            </tr>
            <tr>
            	<td colspan="100%" align="center">
                	<label id="lbluserstat"></label>
                </td>
            </tr>
			<tr id="user_email_tr" name="user_email_tr" style="display: none">
            	<td>Email</td>
                <td><input type="text" id="user_email" name="user_email" required="required" /></td>
			</tr>
            <tr>
            	<td>Business Unit</td>
                <td>
                	<select id="seluserbu" name="seluserbu" required>
                    	<option value=""></option>
                    	$budatalist
                    </select>
                </td>
            </tr>
            <tr>
            	<td>Access Level</td>
                <td>
                	<select id="selaccess" name="selaccess" required>
                    	<option value=""></option>
                    	<option value="User">Security Guard</option>
						<option value="Head Guard">Head Guard</option>
                        <option value="Admin">BU Security Head</option>
						<option value="Custom Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                </td>
            </tr>
            <!-- <tr>
            	<td>Contact</td>
                <td><input type="text" id="userscontact" name="userscontact" required="required" /></td>
            </tr> -->
            <tr>
            	<td colspan="100%">
                	<div id="divForgotPass" style="display:none;">
                    	<label style="color:#F00; text-decoration:underline; cursor:pointer;" onclick="resetPass();">Reset Password</label>
                    </div>
                </td>
            </tr>
            <tr>
            	<td colspan="2" align="center">
                	<input type="submit" id="btnsaveuser" name="btnsaveuser" class="redbutton" value="Save" />
                    <input type="submit" id="btnedituser" name="btnedituser" class="redbutton" value="Update" style="display:none;" />
                </td>
            </tr>            
        </table>
        </fieldset>
        </form>
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
    	<form id="changecontactForm" method="post" action="user-superadmin.php">
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
    <form id="formcpass" method="post" action="user-superadmin.php" autocomplete="off">
    <table id="tblchangepass" align="center" border="1" style="border-collapse:collapse; border-color:#999; border-style:groove;">
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
    <div id="modalRevisions">
    
    </div>
    <div id="ReportGeneratorTable" class="section" >
    	<table align="center"  width="80%">
        	<tr align="center">
            	<td colspan="100%">
                	<input type="radio" id="radioRTIncident" name="radioRTType" checked="checked" onclick="toggleReportTable('incident');" />Incident &nbsp;&nbsp;<input type="radio" id="radioRTActivity" name="radioRTType" onclick="toggleReportTable('activity');"/>Activity
                    <input type="hidden" id="txtReportTableType" name="txtReportTableType" value="incident" />
                </td>
            </tr>
        </table>
        <table id="tblreportgen" name="tblreportgen" style="margin:0 auto;">
			<thead id="tblreportgenhead" name="tblreportgenhead">
        	<tr align="center">                
                <td colspan="100%">
                    Date: &nbsp;<input type="date" id="txtRTDateStart" name="txtRTDateStart" value="$logdate" />&nbsp; to &nbsp;<input type="date" id="txtRTDateEnd" name="txtRTDateEnd" value="$logdate" />
                </td>                                        
            </tr>
        	<tr align="center">
            	<td>
                	Business Unit:
                </td>
                <td>
                    <select id="selRTBU" name="selRTBU" onchange="loadLocationGuard();">
                        <option value="0">All BUs</option>
                        $budatalist
                    </select>
                </td>
                <td>
                    Location:
                </td>
                <td>
                    <select id="selRTLoc" name="selRTLoc">
                    </select>
                </td>
                <td>
                    Guard:
                </td>
                <td>
                    <select id="selRTGuard" name="selRTGuard">
                    </select>
                </td>
            </tr>
			</thead>
			<tbody>
            <tr align="center">
            	<td align="center" colspan="100%">
                	<div id="divReportTableInc" >
                	<table align="center">
                    	<tr >
                            <td >
                                Incident Type:
                            </td>
                            <td >
                                <select id="selRTIncident" name="selRTIncident">
                                    <option value="0">All Incidents</option>
                                    $incidententriesdatalist
                                </select>
                            </td>
                        </tr>
                    </table>
                    </div>
                    <div id="divReportTableAct" style="display:none">
                	<table align="center">
                    	<tr >
                            <td >
                                Activity Type:
                            </td>
                            <td >
                                <select id="selRTActivity" name="selRTActivity">
                                    <option value="0">All Activities</option>
                                    $activityentriesdatalist
                                </select>
                            </td>
							<td>
								URC:
							</td>
							<td>
								<select id="selRTURC" name="selRTURC">
                                    <option value="0">All URCs</option>
                                    $urcdatalist
                                </select>
							</td>
                        </tr>
                    </table>
                    </div>
                </td>
            </tr>
			</tbody>
			<tfoot id="tblreportgenfoot" name="tblreportgenfoot">
            <tr align="center">
            	<td colspan="100%">
                	<button onclick="generateReportTable();" class="redbutton" style="width:150px;">Generate Table</button>
                </td>
            </tr>
			</tfoot>
        </table>
        
    </div>
    <div id="modalIncMonitoring" style="font-size:10px; display:none;">
    </div>
    
    <div id="ReportGeneratorGraph" class="section">
    	<table align="center"  width="80%">
        	<tr align="center">
            	<td colspan="100%">
                	<input type="radio" id="radioRGIncident" name="radioRGType" checked="checked" onclick="toggleReportChart('linkbu', 'divSearchTotal', 'y-axis_type');" />Incident &nbsp;&nbsp;<input type="radio" id="radioRGActivity" name="radioRGType" onclick="toggleReportChart2('divSearchGuardGraph', 'y-axis_guard2');" />Activity
                </td>
            </tr>
        </table>
    	<div id="divGraphSearchee">
    	<table align="center"  width="90%">
        	<tr>
            	<td colspan="100%">
                	<div id="divGraphLinks">
                	<table width="100%" border="1" style="border-collapse:collapse;">
                    	 <tr align="center">
                            <td id="linkbu" class="rglink whiteonblack" style="cursor:pointer;" onclick="toggleReportChart('linkbu', 'divSearchTotal', 'y-axis_type');">By Business Unit</td>
                            <td id="linktype" class="rglink" style="cursor:pointer" onclick="toggleReportChart('linktype', 'divSearchType', 'y-axis_bu');">By Incident Type</td>
                            <td id="linkloc" class="rglink" style="cursor:pointer" onclick="toggleReportChart('linkloc', 'divSearchLocation', 'y-axis_location');">By Location</td>
                            <td id="linkguard" class="rglink" style="cursor:pointer" onclick="toggleReportChart('linkguard', 'divSearchGuardGraph', 'y-axis_guard');">By Guard</td>
                        </tr>
                    </table>
                    </div>
                    
                </td>
            </tr>
            <tr align="center">
            	<td>
                	<table align="center">
                    	<tr>
                        	<td width="50%">
                            	<table>
                                	<tr>
                                    	<td >
                                            Date:
                                        </td>
                                        <td >
                                            <input type="date" id="txtRGDateStart" name="txtRGDateStart" value="$logdate" />&nbsp; to &nbsp;<input type="date" id="txtRGDateEnd" name="txtRGDateEnd" value="$logdate" />
                                        </td>                                        
                                    </tr>
                                </table>
                            </td>
                            <td width="50%">
                            	<div id="divSearchTotal" class="divGraphCategory" >
                            	<table align="center">
                                	<tr>
                                    	<td >
                                            Business Unit:
                                        </td>
                                        <td>
                                            <select id="selRGBU" name="selRGBU">
                                                <option value="0">All BUs</option>
                                                $budatalist
                                            </select>
                                        </td>                                        
                                    </tr>
                                </table>
                                </div>
                                <div id="divSearchType" class="divGraphCategory" style="display:none;">
                                <table align="center">
                                	<tr>
                                    	<td >
                                            Incident Type:
                                        </td>
                                        <td >
                                            <select id="selRGIncident" name="selRGIncident" onchange="lockSelect();">
                                                <option value="0">All Incidents</option>
                                                $incidententriesdatalist
                                            </select>
                                        </td>
                                        <td >
                                            Business Unit:
                                        </td>
                                        <td>
                                            <select id="selRGBU4" name="selRGBU4" disabled="disabled">
                                                <option value="0">All BUs</option>
                                                $budatalist
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <div id="divSearchLocation" class="divGraphCategory" style="display:none;">
                            	<table align="center">
                                	<tr>
                                    	<td>
                                            Business Unit:
                                        </td>
                                        <td>
                                            <select id="selRGBU2" name="selRGBU2" onchange="loadLocation();">
                                            	<option value=""></option>
                                                $budatalist
                                            </select>
                                        </td>
                                        <td>
                                        	Location:
                                        </td>
                                        <td>
                                        	<select id="selRGLoc" name="selRGLoc">
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                                <div id="divSearchGuardGraph" class="divGraphCategory" style="display:none;">
                            	<table align="center">
                                	<tr>
                                    	<td >
                                            Business Unit:
                                        </td>
                                        <td>
                                            <select id="selRGBU3" name="selRGBU3" onchange="loadGuard();">
                                            	<option value=""></option>
                                                $budatalist
                                            </select>
                                        </td>
                                        <td>
                                        	Guard:
                                        </td>
                                        <td>
                                        	<select id="selRGGuard" name="selRGGuard">
                                            </select>
                                        </td>                                        
                                    </tr>
                                </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td colspan="100%" align="center">
                	<button onclick="prepareChart();" class="redbutton" style="width:150px;">Generate Chart</button>
                    <input id="searchGraph" type="hidden" value="y-axis_type" />
                    
                    <div id="chartTicks">                    	
                    </div>
                    <div id="chartData">
                    </div>                    
                </td>
            </tr>
        </table>
        </div>
        <div id="GraphSearchee2">
        	
        </div>
        <div id="divShowGraph">        
        <table align="center" width="95%">
        	<tr>
            	<td>
                    <div id="chartdiv" >
                        
                    </div>
                </td>
            </tr>
        </table>
        </div>
    </div>
    <div id="SysLogs" class="section">
    	<table align="center" >
            <tr align="center">
                <td >
                    <strong>Date:</strong>&nbsp;<input type="date" id="searchSysLogStart" name="searchSysLogStart" value="$logdate" />&nbsp; to &nbsp;<input type="date" id="searchSysLogEnd" name="searchSysLogEnd" value="$logdate" />
                </td>
                <td>
                    <strong>Business Unit:</strong>&nbsp;
                    <select id="txtSearchSysLogBU" name="txtSearchSysLogBU">
                        <option value="0">All BUs</option>
                        $budatalist
                    </select>           
                </td>                
            </tr>
            <tr> 
                <td colspan="100%">
                    <table align="center">       
                        <tr>                            
                            <td>
                                <strong>Username:</strong>&nbsp;
                                <input type="text" id="txtSysLogUsername" name="txtSysLogUsername" />
                            </td>
                            <td>
                                <strong>Last Name:</strong>&nbsp;
                                <input type="text" id="txtSysLogLName" name="txtSysLogLName" />
                            </td>
                            <td>
                                <strong>First Name:</strong>&nbsp;
                                <input type="text" id="txtSysLogFName" name="txtSysLogFName" />
                            </td>
                        </tr>                    
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="100%">
                    <img src="images/Search_btn.png" width="80px" style="cursor:pointer; vertical-align:middle;" onclick="searchLogs(3);" >
                </td>
            </tr>
        </table>
    	<table width="95%" align="center" border="1" style="border-collapse:collapse;">
        	<thead>
        	<tr class="whiteonblack">
            	<th>#</th>
                <th>Business Unit</th>
                <th>Full Name</th>
                <th>Username</th>                
                <th>System Log</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody id="tbodySysLogs">
            	<tr>
                	<td colspan="100%" align="center">
                    	Welcome to System Logs.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>   
  </div>
	
</div>
<script type="text/javascript">document.getElementById('$cat').style.display = 'block'; $executejs</script>
</body>
</html>