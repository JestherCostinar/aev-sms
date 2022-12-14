<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aboitiz | Security Management System</title>
<script src="javascript/jquery-1.11.3.min.js"></script>
<script src="javascript/jquery-ui.min.js"></script>
<script type="text/javascript" src="javascript/md5-min.js"></script>
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

<body onload="loadCharts2();">
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
	$multiplebudatasel
    <font color="#FFFFFF">    
    <ul>
      <li style="font-size:1.5em;">$displayBUName</li>
      <ul style="padding-left:10px">
      <li class="lists" id="listdash" onclick="loadCharts2();toggleMe('Dashboard', 'listdash');">Dashboard</li>
      <li class="lists" onclick="toggleMenu('subEntries');">Entries</li>
        <ul id="subEntries" style="display:none;">
          <li class="lists" id="listact" onclick="toggleMe('Activities', 'listact'); initialLogs('Act');">Activities</li>
          <li class="lists" id="listinc" onclick="toggleMe('Incidents', 'listinc'); initialLogs('Inc');">Incidents</li>
        </ul>
      <li class="lists" onclick="toggleMenu('subGuardManagement');">Guard Management</li>
      	<ul id="subGuardManagement" style="display:none;">
        	<li class="lists" id="listgmgt" onclick="toggleMe('GuardMgt', 'listgmgt'); initialLogs('Guard');">Guard Personnel</li>
            <li class="lists" id="listsecage" onclick="toggleMe('SecAgency', 'listsecage');">Security Agency</li>		
        </ul>
	  <li class="lists" onclick="toggleMenu('subMonitoring');">Monitoring</li>
		<ul id="subMonitoring" style="display:none;">
			<li class="lists" id="listaudit2" onclick="toggleMe('Audit', 'listaudit2'); auditShow3();">Audit Summary</li>
			<li class="lists" id="listspam" onclick="toggleMe('SPAM', 'listspam'); showSpam($bu);">SPAM</li>
			<!-- <li class="lists" id="liststakeholder" onclick="toggleMe('Stakeholder', 'liststakeholder'); showStakeholder('table');">Stakeholders</li> -->
			<!-- <li class="lists" id="listidp" onclick="toggleMe('IDP', 'listidp'); showIDP();">IDP</li> -->
			<li class="lists" id="listconcom" onclick="toggleMe('ConComp', 'listconcom');">Contract Compliance</li>
			$custom_cc_list
		</ul>
      <li class="lists" onclick="toggleMenu('subBidding');">Bidding</li>
		<ul id="subBidding" style="display:none; list-style-type:none;">
			<li class="lists" id="listbidding" onclick="toggleMe('Bidding', 'listbidding')">Nominate Agency</li>
		</ul>
      <li class="lists" onclick="toggleMenu('subTools');">Tools</li>
    	<ul id="subTools" style="display:none;">
          <li class="lists" id="listcmgt" onclick="toggleMe('CodeMgt', 'listcmgt');">Code Management</li>
          <li class="lists" id="listlocs" onclick="toggleMe('Locs', 'listlocs');">Location</li>
		  <!-- <li class="lists" id="listlocactors" onclick="toggleMe('Locators', 'listlocactors');">Locators</li> -->
		  $locatorlink
          <li class="lists" id="listsecalert" onclick="toggleMe('SecAlert', 'listsecalert');">Security Alert Recipients</li>
          <li class="lists" onclick="toggleMenu('subReportGenerator');">Report Generator</li>
          	<ul id="subReportGenerator" style="display:none;">
              <li class="lists" id="listreportgentable" onclick="toggleMe('ReportGeneratorTable', 'listreportgentable'); toggleReportTable('incident');">Monitoring Form</li>
              <li class="lists" id="listreportgengraph" onclick="toggleMe('ReportGeneratorGraph', 'listreportgengraph');">Graphs</li>
            </ul>
        </ul>
      <li class="lists" onclick="toggleMenu('subAccount');">Account</li>
        <ul id="subAccount" style="display:none;">
          <li class="lists" id="listusers" onclick="toggleMe('Users', 'listusers');">Users</li>
          <li class="lists" id="listprof" onclick="toggleMe('Profile', 'listprof');">My Profile</li>
        </ul>
        </ul>
    </ul> 
    </font>
	
  </div>
  <div class="multi">
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
					<td width="60%" rowspan="2"><label style="color:green;">Audit Summary</label><div id="KPIAudit" height="100%"></div></td>
					<td width="40%" valign="top" align="center"><label style="color:green;">Stakeholder Engagement</label><div id="KPIStake" ></div></td>
				</tr>
				<tr>
					<td width="40%" valign="top" align="center"><label style="color:green;">IDP Status</label><div id="KPIIDP" align="center"></div></td>
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
  	<div id="Dashboard" class="section">
		<table width="95%" align="center">
			<tr>
				<td><label style="color:blue; cursor:pointer;" onclick="fillKPIDashboard(); toggleMe('KPI_Dashboard', 'listdash');">Toggle KPI Dashboard</label></td>
			</tr>
		</table>
    	<table width="95%" align="center"> 
        	<tr>
            	<td align="center" valign="middle" width="50%">
                	<div id="divMeter" style="height: 250px;">
                    </div>
                	<!--<canvas id="incidentmeter" width="350" height="175">
                    	Canvas unavailable.
                    </canvas>
                    <br />
                    <label>$incidentcount Incident(s) this month</label>-->
                </td>
                <td align="center" valign="middle" width="50%">
                	<div id="divTotalInc" style="height: 250px;">
                        </div>
                </td>
            </tr>
            <tr>
            	<td align="center" width="50%">
                	<div id="divLine" style="width: 500px; height: 250px;">
                    
                    </div>
                	<!--<canvas id="chartMonthly" width="400" height="500">
                    	Canvas unavailable
                    </canvas>-->
                </td>
                <td align="center" width="50%" valign="top">
                	<table width="75%">
                    	<tr>
                        	<th>Expiry Reminders</th>
                        </tr>
                        <tr>
                        	<td align="center"><input type="radio" name="radioExpiry" onclick="toggleExpiry2('divSecAgencyContract');" />Security Agency &nbsp; &nbsp;<input type="radio" checked="checked" name="radioExpiry" onclick="toggleExpiry2('divSecAgencyLicense');" />Guard Licenses &nbsp; &nbsp;<input type="radio" name="radioExpiry" onclick="toggleExpiry2('divSecAgencyOtherLicenses');" />Other Licenses</td>                            
                        </tr>
                    </table>
                    <div id="divSecAgencyLicense">
                	<table width="75%" border="1" style="border-collapse:collapse; overflow-y: scroll; height: 150px; display: block;">
                    	<thead>
                        	<tr class="blackongray">
                            	<th>Security Guard</th>
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
								<th>PDF File</th>
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
	<!-- <div id="KPI_Dashboard" name="KPI_Dashboard">
		<table id="tblKPIDashboard" name="tblKPIDashboard" width="95%" align="center">
			<tr>
				<td width="50%"></td>
				<td width="50%"></td>
			</tr>
			<tr>
				<td colspan="100%">
					<div id="KPICC" name="KPICC">
					</div>
				</td>
			</tr>
		</table>
	</div> -->
    <div id="addGuard" style="display:none;">
		<div id="divAddGuardContent">
    	
		</div>
    </div>
    <div id="closeincidentmodal" style="padding-top:24px; display:none">
            
    </div>    
  	<div id="AddActivity" class="ui-front" style="display:none; padding-top:30px; padding-bottom:30px">
    <img id="back" src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" />
    <table width="95%" border="1" align="center" style="border-collapse:collapse; padding-top:24px;" >
      <tr bgcolor="#000000" style="color:#FFF;">
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
        <form id="addForm" method="post" action="user-admin.php" enctype="multipart/form-data">
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
                                  
                              </tr>
                             
                              <tr>
                                  <td width="30%">Date:</td>
                                  <td width="70%"><input type="text" id="date" name="date" value="$logdate" readonly="readonly" autocomplete="off" /></td>
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
                                 
                              </tr>
                              <tr>
                                  <td width="30%">Guard:</td>
                                  <td width="70%">
                                    <select id="txtguard" name="txtguard">
                                    	<option value="" selected="selected"></option>
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
    <form id="addActivityForm" method="post" action="user-admin.php">
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
            <td ><button id="btnSaveActivityTicket" class="redbutton" onclick="evalAdd('act', this);">Save</button></td>
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
            <td width="7%" align="right" style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="refreshPage('Activities', 'user-admin');">
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
    <form id="addIncidentForm" method="post" action="user-admin.php">    
    
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
            <td><input type="date" id="txtincidentdate" name="txtincidentdate" readonly="readonly" value="$logdate" size="10" /></td>            
        </tr>
        <tr>
        	<td></td>
            <td><img src="images/save.png" width="100px" onclick="evalAdd('inc'); clickOnce(this);" /></td>
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
            	<strong>Business Unit:</strong>&nbsp;<input type="text" value="$headerBu" readonly="readonly" /><input type="hidden" id="txtSearchIncLogBU" name="txtSearchIncLogBU" value="$bu" readonly="readonly" />
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
                            <strong>Ticket ID:</strong>&nbsp;
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
    <table width="95%" border="1" align="center" style="border-collapse:collapse;">
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
      
    </tbody>
    </table>
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
	<div id="RequestRetractModal" style="display:none;">
		<form id="frmRetractLevel" name="frmRetractLevel" method="post" action="user-admin.php">
		<table width="100%">
			<tr>
				<td colspan="100%">**Once submitted, your level retraction request will be sent to the SMS Admin for approval.</td>
			</tr>
			<tr>
				<td align="right">Retract to level:</td>
				<td><input type="number" id="numRetractLevel" name="numRetractLevel" min="1" max="5" required="required"></td>				
			</tr>
			<tr>
				<td valign="top" align="right">Reason:</td>
				<td><textarea id="txtRetractReason" name="txtRetractReason" style="width:95%; height:150px; resize:none;" required="required"></textarea></td>
			</tr>
			<tr>
				<td colspan="100%" align="right">
					<input type="hidden" id="txtRetractId" name="txtRetractId">
					<input type="submit" id="btnSubmitRetract" name="btnSubmitRetract" class="redbutton" value="Submit">
					<button class="redbutton" id="btnBackRetract" name="btnBackRetract" name="" >Cancel</button>
				</td>
			</tr>
		</table>
		</form>
	</div>
	<div id="RequestDeletionModal" style="display:none;">
		<form id="frmRequestDeletion" name="frmRequestDeletion" method="post" action="user-admin.php">
		<table width="100%">
			<tr>
				<td colspan="100%">**Once submitted, your deletion request will be sent to the SMS Admin for approval.</td>
			</tr>
			<tr>
				<td valign="top">Reason:</td>
				<td><textarea id="txtDeletionReason" name="txtDeletionReason" style="width:95%; height:150px; resize:none;" required="required"></textarea></td>
			</tr>
			
			<tr>
				<td colspan="100%" align="center">
					<input type="hidden" id="txtDeletionId" name="txtDeletionId">
					<input type="hidden" id="txtDeletionType" name="txtDeletionType">
					<input type="submit" id="btnSubmitDeletion" name="btnSubmitDeletion" class="redbutton" value="Submit">
					<button class="redbutton" id="btnBackDeletion" name="btnBackDeletion" name="" >Cancel</button>
				</td>
			</tr>
		</table>
		</form>
	</div>
	<div id="divUploadModal" name="divUploadModal" style="display:none;">
		<table align="center" width="35%" border="1">
			<tr>
				<td width="50%"><input type="radio" id="uploadChoiceUpload" name="uploadChoice" checked="true" onclick="openViewAttachments();">Upload</td><td width="50%"><input type="radio" id="uploadChoiceView" name="uploadChoice" onclick="openViewAttachments();">View</td>				
			</tr>
		</table>
		<br><br>
		<div id="divUploadFile" name="divUploadFile">
		<form id="frmUpload" method="post" action="user-admin.php" enctype="multipart/form-data">
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
                	<label style="text-decoration:underline; color:#00F; cursor:pointer;" onclick="refreshPage('GuardMgt', 'user-admin');">Refresh</label>
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
        	<td align="right" width="65px">            	
            	<img src="images/Search-icon.png" height="30px" id="btnshowsearchguard" name="btnshowsearchguard" title="Search Guard" style="cursor:pointer;" onclick="toggleSearch('divSearchGuard');" />
                
            	<img src="images/add_guard.png" height="30px" id="btnaddguard" name="btnaddguard" title="Add Guard" style="cursor:pointer;" onclick="guardInfo2(0,'Add');" />
            </td>
        </tr>
      </table>
      <table id="tblGuards" width="95%" border="1" align="center" style="border-collapse:collapse;">
      <thead>      
      <tr class="whiteonblack">
      	<th>#</th>
        <th>Last Name</th>
        <th>First Name</th>        
        <th>Guard Code</th>        
        <th>Business Unit</th>
        <th>Status</th>
        <td width="2%"></td>
      </tr>
      </thead>
      <tbody id="tbodyGuards">
        
      </tbody>
      </table>
    </div>
    <div id="SecAgency" class="section">
    	<table width="95%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Security Agencies</td>        	
            <td align="right">
            	<div id="divSearchAgency" style="display:none;">
                <form id="frmSearchAgency" name="frmSearchAgency" action="user-admin.php" method="post">
                	<label style="text-decoration:underline; color:#00F" onclick="refreshPage('SecAgency', 'user-admin');">Refresh</label>
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
            <td width="30px" align="right">
            	<img src="images/Search-icon.png" height="30px" id="btnShowSearchAgency" name="btnShowSearchAgency" title="Search Agency" style="cursor:pointer;" onclick="toggleSearch('divSearchAgency');" />
                
            </td>	          
        </tr>
      </table>
      <table width="95%" align="center" border="1" style="border-collapse:collapse">
      	<thead>
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
            $secagencytable
        </tbody>    
        </table>
    </div>
    <div id="secagencymodal" style="display:none; padding-top:24px;" >
    <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeSecAgency();" />
    	<table align="center" width="100%" border="1" style="border-collapse:collapse;">
			<tr>
				<th style="cursor:pointer;" onclick="toggleTabs('geninfodiv', 'secagencydivs');">General Info</th>
				<th style="cursor:pointer;" onclick="toggleTabs('otherlicensesdiv', 'secagencydivs');">Other Licenses</th>
				<th style="cursor:pointer;" onclick="toggleTabs('contractsdiv', 'secagencydivs');">Contracts/Clients</th>
				
			</tr>
			<tr>
				<td colspan="100%">
					<div id="geninfodiv" name="geninfodiv" class="secagencydivs" style="cursor:pointer;">
						
						<table width="100%" align="center">
						<tr>
						<td width="50%" valign="top" align="center">
						<fieldset>
						<legend style="font-weight:bold">General Info</legend>
						<table align="center" width="100%">
							<tr>
								<td align="right">Name of Agency:</td>
								<td><label id="txtagencyname" name="txtagencyname"></label>
								</td>
							</tr>
							<tr>
								<td align="right">Address:</td>
								<td><label id="txtagencyaddress" name="txtagencyaddress" style=" resize:none;"></label></td>
							</tr>
							<tr>
								<td align="right">President/General Manager:</td>
								<td><label id="txtagencyoic" name="txtagencyoic" required="required"></label></td>
							</tr>
							<tr>
								<td align="right">Contact:</td>
								<td><label id="txtagencycontact" name="txtagencycontact"></label></td>
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
								<td><label id="txtagencylicensenum" name="txtagencylicensenum"></label></td>
							</tr>
							<tr>
								<td align="right">Issue Date:</td>
								<td><label id="txtagencylicenseissue" name="txtagencylicenseissue"></label></td>
							</tr>
							<tr>
								<td align="right">Expiration Date:</td>
								<td><label id="txtagencylicenseexpiry" name="txtagencylicenseexpiry" required="required"></label></td>
							</tr>
						 </table>
						 </fieldset>
						 <br />
						 <table>
							<tr>
								<td align="right">Status of Contract:</td>
								<td>
									<label id="selcontractstat" name="selcontractstat"></label>
									
								</td>
							</tr>
						 </table>
						 </td>
						 </tr>
						 </table>
						 <br />
						 <fieldset>
							<legend style="font-weight:bold">Company Profile</legend>  
							
							<textarea id="txtagencyprofile" name="txtagencyprofile" style="width:100%; resize:none; height:75px;" disabled></textarea>
						 </fieldset>
						 <br />
						 <form id="frmAddAgencyRemarks" name="frmAddAgencyRemarks" action="user-admin.php" method="post">
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
										<img id="btnaddsecremarkrow" name="btnaddsecremarkrow" src="images/add_btn.png" width="80px" onclick="addAgencyRemarks();" />
										<input type="hidden" id="txtagencyid" name="txtagencyid" />
										
									</td>
								</tr>
							  </tfoot>
						  </table>
						  </fieldset>
						  </form>
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
								 <td></td>
							 </tr>
							 </thead>
							 <tbody id="tblagencybutbody">
							 
							 </tbody>
							 <tfoot>
								
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
								
							  </tfoot>
						  </table>
					</div>
					<div id="remarksdiv" name="remarksdiv" style="display:none;" class="secagencydivs">
						
					</div>
				</td>
			</tr>
		</table>
          <table align="center" width="95%">
            
            <tr>
            	<td align="right" colspan="2">
                	
					
                	<img src="images/update.png" id="btnupdateagency" name="btnupdateagency" width="100px" style="display:none; cursor:pointer;" onclick="saveSecAgency();" />
                    <img src="images/save.png" id="btnsaveagency" name="btnsaveagency" width="100px" style="display:none; cursor:pointer;" onclick="saveSecAgency();" />
                    <input type="hidden" id="txtagencyid" name="txtagencyid" />
                    <input type="hidden" id="txtagencyaddedit" name="txtagencyaddedit" />
                </td>
            </tr>
          </table>
          
          
    </div>
	
	<div id="SPAM" class="section">
	</div>
	
	<div id="Stakeholder" class="section">
	</div>
	
	<div id="modalStakeholder" style='display:none;'>
	</div>
	
	<div id="IDP" class="section">
		<!--  <table align='center' width='95%' style='border-spacing:0px; padding:0px; border-collapse:ollapse;'  >
			<tr>
				<td style="font-weight:bold">Individual Development Plans</td>
			</tr>
			<tr>   
				<td>
					<button id='btnIDPUsers' class='tablinkIDP' onclick='toggleIDP("tblIDPUsers", "btnIDPUsers");'  style='background-color:red;' >Users</button>
					<button id='btnIDPMain' class='tablinkIDP' onclick='toggleIDP("tblIDPMain", "btnIDPMain");' >Entries</button>
				</td>
			</tr>   	
		 </table>
		 <div id="divIDPDisplay" name="divIDPDisplay">
		 </div> -->
	</div>
	
	<div id="modalIDP" style='display:none;'>
	</div>
	
	<div id="ConComp" class="section">
		<table align="left" style="padding-left:24px;">
			<tr>
				<td align="left" style="font-weight:bold">Contract Compliance</td>
			</tr>
		</table>
		<br><br>
		<table align="center" id="tblConCompHeader" style="padding-left:24px;" width="100%">
			<tr>
				<td align="right" width="5%"><b>Year:</b></td>
				<td align="left" colspan="100%"><input id="txtCCAdminYear" name="txtCCAdminYear" type="number" min="2017" value="2019"><img src="images/Search-icon.png" height="24px" id="btnShowCCScores" name="btnShowCCScores" title="Search CC" style="cursor:pointer; vertical-align:middle;" onclick="searchScores();"></td>
			</tr>
			<tr>
				<td colspan="100%"><div id="concompscores" name="concompscores"></div></td>
			</tr>
			
			<tr style="display:none">
				<td></td>
				<td align="left" ><button id="btnCCGeneral" name="btnCCGeneral" class="redbutton" onclick="searchItem(1,1,'ConCompAdmin');">Open</button></td>				
			</tr>
		</table>
		<br><br>
		<div id="ConCompDisplay">
		</div>		
	</div>
	$custom_cc_cons
	
    <!-- --------------------- BID TRACKER --------------------- -->
   	<div id="Bidding" class="section">
    	<table width="95%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Automated Bidding</td>
        	<td align="right">
            	<div id="divSearchLocs" style="display:none;">
                <form id="frmSearchLocs" name="frmSearchLocs" action="user-admin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer" onclick="refreshPage('Locs', 'user-admin');">Refresh</label>
                	<input type="text" id="txtSearchLocs" name="txtSearchLocs" />                                       
                    <img src="images/Search_btn.png" width="80px" id="btnsearchlocs" name="btnsearchlocs" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchLocs').value, 'location',  'location_mst');" />
                </form>    
                </div>
            </td>
        	<td align="right" width="65px">
            	<img src="images/Search-icon.png" height="30px" id="btnshowsearchlocs" name="btnshowsearchlocs" title="Search Locations" style="cursor:pointer;" onclick="toggleSearch('divSearchLocs');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('Locs', 'user-admin');" />-->
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
					<th class="table__th" colspan="2" width="20%">Action</th>
				</tr>
            </thead>
            <tbody class="table__tbody">
				$biddingtable
            </tbody>
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
					<td colspan="100%" ><label style="text-decoration:underline; color:red; cursor:pointer;" onclick="auditShow($bu);">View Details</label></td>
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
	
	<div id="addAuditEvidencemodal" style="display:none">
		<form id="addAuditEvidenceform" name="addAuditEvidenceform" method="post" action="user-superadmin.php" enctype="multipart/form-data">
			<table align="center">
				<tr><th>Add FIle</th></tr>
				<tr>
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
	<div id="viewAuditDetails" style="display:none">
	
	</div>
	<div id="viewAuditDisposition" style="display:none">
		
	</div>
	
	<div id="viewAuditUpload" style="display:none;">
	</div>
	
    <div id="Locs" class="section">
    	<table width="90%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Locations</td>
            <td align="right">
            	<div id="divSearchLocs" style="display:none;">
                <form id="frmSearchLocs" name="frmSearchLocs" action="user-admin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer" onclick="refreshPage('Locs', 'user-admin');">Refresh</label>
                	<input type="text" id="txtSearchLocs" name="txtSearchLocs" />                                       
                    <img src="images/Search_btn.png" width="80px" id="btnsearchlocs" name="btnsearchlocs" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchLocs').value, 'location',  'location_mst');" />
                </form>    
                </div>
            </td>
        	<td align="right" width="65px">
            	<img src="images/Search-icon.png" height="30px" id="btnshowsearchlocs" name="btnshowsearchlocs" title="Search Locations" style="cursor:pointer;" onclick="toggleSearch('divSearchLocs');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('Locs', 'user-admin');" />-->
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
            <tbody id="tbodyLocs">
            	$locationstable
            </tbody>
        </table>
    </div>
    <div id="addlocsmodal" style="display:none; padding-top:24px;">
    	<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeAddLoc();" />
    	<form id="addlocationform" name="addlocationform" action="user-admin.php" method="post">
        <fieldset>
        <legend style="font-weight:bold;">Add Location</legend>
        <table align="center" width="100%">
        	<tr>
                <td align="center">
                <table>
                    <tr>
                        <td align="right">Location Code:</td>
                        <td align="left">
                        	<input type="text" id="txtaddlocationid" name="txtaddlocationid" style="display:none" readonly="readonly" />
                        	<input type="text" id="txtaddlocationcode" name="txtaddlocationcode" />
                            <input type="text" id="txtaddlocationcodes" name="txtaddlocationcodes" style="display:none" readonly="readonly" />
                            <!--<input type="text" id="txtaddlocationbu" name="txtaddlocationbu" style="display:none" readonly="readonly" value="$bu" />-->
                        </td>
                    </tr>
                    <tr>
                        <td align="right">Location:</td>
                        <td align="left">
                        	<input type="text" id="txtaddlocation" name="txtaddlocation" />
                            <input type="text" id="txtaddlocations" name="txtaddlocations" style="display:none" readonly="readonly" />
                        </td>
                    </tr>               
                </table>
                </td>
                <td>
                    <img id="btnaddlocationrow" name="btnaddlocationrow" src="images/location_add.png" style="cursor:pointer;" title="Add Row" height="36px" onclick="addLocationRow();" />
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
        		<tr>
            		<th>Code</th>
                    <th>Location</th>
                    <td></td>
            	</tr>
            </thead>
            <tbody id="addlocstbody">
            </tbody>
            <tfoot>
            	<tr >
                	<td colspan="3" align="center" style="padding:10px">
                    	<img src="images/confirm.png" width="70px" style="cursor:pointer;" onclick="addLocations();" />
                    </td>                    
                </tr>
            </tfoot>    
        </table>
        </div>
        
    </div>
	<div id="Locators" class="section">		
		<table width="90%" align="center">
			<tr>
				<td align="right">                    			
					<img id="imgaddlocator" name="imgaddlocator" src="images/add_item.png" height="32px" style="cursor:pointer; vertical-align:middle;" onclick="openLocators();" > 
				</td>
			</tr>
		</table>
		<table id="tblLocators" name="tblLocators" width="90%" align="center" border="1" style="border-collapse:collapse">
			<thead>
			<tr class="whiteonblack">
				<th>#</th>
				<th>Locators</th>
				<td colspan="2" width="5%"></td>                            
			</tr>
			</thead>
			<tbody>
			</tbody>			
		</table>		
	</div>
	<div id="modaladdlocator" style="display:none;">
		
	</div>
    <div id="CodeMgt" class="section">
    	<table width="95%" align="center">
          <tr>
              <td align="left" style="font-weight:bold">Code Management</td>        	
              <td align="right">
                  <div id="divSearchCodes" style="display:none;">
                  <form id="frmSearchCodes" name="frmSearchCodes" action="user-admin.php" method="post">
                    <label style="color:#00F; text-decoration:underline; cursor:pointer;" onclick="refreshPage('CodeMgt', 'user-admin');">Refresh</label>
                    <input type="text" id="txtSearchCodes" name="txtSearchCodes" />
                    <img src="images/Search_btn.png" width="80px" id="btnSearchCodes" name="btnSearchCodes" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchCodes').value, document.getElementById('txtcodetype').value, 'urc_mst');" />
                  </form>    
                  </div>                
              </td>
              <td width="30px" align="right">
                  <img src="images/Search-icon.png" height="30px" id="btnShowSearchCodes" name="btnShowSearchCodes" title="Search Codes" style="cursor:pointer;" onclick="toggleSearch('divSearchCodes');" />
                  <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('CodeMgt', 'user-admin');" />-->
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
    <input type="hidden" id="txtcodetype" name="txtcodetype"  value="10-00" />
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
    <div id="SecAlert" class="section">
    	<table width="90%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Security Alert Recipients</td>
			<td align="right">
            	<div id="divSearchSecAlertRecipients" style="display:none;">
                <form id="frmSearchSecAlertRecipients name="frmSearchSecAlertRecipients" action="user-admin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer;" onclick="refreshPage('SecAlert', 'user-admin');">Refresh</label>
                    &nbsp;
                	<input type="text" id="txtSearchSecAlertRecipients" name="txtSearchSecAlertRecipients" />
                    <!-- <select id="selSecAlertRecipientsBu" name="selSecAlertRecipientsBu" style="display:none;">
                    	<option value=""></option>
                        $budatalist
                    </select> -->
                    
                    <select id="selSearchSecAlertRecipients" name="selSearchSecAlertRecipients" onchange="changeSearch('oic_mst');">
                    	<option value="lname">Last Name</option>
                        <option value="fname">First Name</option>
						<option value="email_ad">E-mail address</option>
                        <!-- <option value="mobile">Contact Number</option> -->
                        <!-- <option value="bu">Business Unit</option> -->                       
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
			<tbody id="tbodySecAlert">
            $oictable
			</tbody>
        </table>
    </div>
    <div id="addoicform" style="display:none; padding-top:24px;">
    <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeAddOic();" />
    	<form id="oicform" name="oicform" action="user-admin.php" method="post">
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
               <!--  <tr>
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
                    	<input type="text" id="oicbu" name="oicbu" readonly="readonly" value="$headerBu" />
                        <input type="text" id="oicid" name="oicid" readonly="readonly" style="display:none;" />
                    </td>
                </tr>
				<tr>
					<td>Recipient Level</td>
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
    <div id="Users" class="section">
    	<table width="90%" align="center">
      	<tr>
        	<td align="left" style="font-weight:bold">Accounts</td>
        	<td align="right">
            	<img src="images/add_user.png" height="30px" id="btnadduser" name="btnadduser" title="Add User" style="cursor:pointer;" />
            </td>
        </tr>
      </table>
      <table width="90%" align="center" border="1" style="border-collapse:collapse">
        	<tr class="whiteonblack">
            	<th>#</th>
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
    <div id="adduserdiv" style="display:none; padding-top:24px;">
    	<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeAddUser();" />
    	<form id="adduserform" name="adduserform" action="user-admin.php" method="post">
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
           
            <tr>
            	<td>Username</td>
                <td><input type="text" id="usersusername" name="usersusername" required="required" onkeyup="checkUsername();" /></td>
            </tr>
            <tr>
            	<td colspan="100%" align="center">
                	<label id="lbluserstat"></label>
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
                    </select>
                </td>
            </tr>
            
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
    	<form id="changecontactForm" method="post" action="user-admin.php">
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
    <form id="formcpass" method="post" action="user-admin.php" autocomplete="off">
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
                	$custom_bu
                </td>
                <td>
                    Location:
                </td>
                <td>
                    <select id="selRTLoc" name="selRTLoc">
                    	<option value="0">All Locations</option>
                        $locationdatalist
                    </select>
                </td>
                <td>
                    Guard:
                </td>
                <td>
                    <select id="selRTGuard" name="selRTGuard">
                    	<option value="0">All Guards</option>
                        $guardsdatalist2
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
    $custom_graphs
  </div>
</div>
<script type="text/javascript">document.getElementById('$cat').style.display = 'block'; $executejs; if ("$cat" == "GuardMgt"){initialLogs('Guard');} </script>
</body>
</html>