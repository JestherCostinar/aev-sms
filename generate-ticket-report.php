<?php 

function generateTicketPDF($ticketID) {

session_start();
if(!isset($_SESSION['id'])){
    header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");

$ticketid = $ticketID;

$queryTicket = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ". $ticketid);
$resTicket = mysqli_fetch_assoc($queryTicket);
$queryBU = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ". $resTicket['bu']);
$resBU = mysqli_fetch_assoc($queryBU);
$queryLogs = mysqli_query($conn, "SELECT * FROM log_mst WHERE ticket = ". $ticketid);
$resLogs = mysqli_fetch_assoc($queryLogs);
$queryLocation = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ". $resLogs['location']);
$resLocation = mysqli_fetch_assoc($queryLocation);
$queryGuard = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = ". $resLogs['gid']);
$resGuard = mysqli_fetch_assoc($queryGuard);
$queryIncident = mysqli_query($conn,"SELECT * FROM entries_incident WHERE id = ". $resTicket['description']);
if($queryIncident)
{
	$resIncident = mysqli_fetch_assoc($queryIncident);
}
$logopath = "";
if($resBU["bu_logo"])
{
	$logopath = $resBU["bu_logo"];	
}
else
{
	$logopath = "images/logo_bgwhite.png";
}

$reporttable = "<div id=\"printReport\">
		<div id=\"reportWrapper\">
		<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
			<tr>
				<td rowspan=\"3\" align=\"center\" width=\"20%\" height=\"30\">
					<img id=\"reportlogo\" name=\"reportlogo\" height=\"50px\" src=\"".$logopath. "\"/>
				</td>
				<td rowspan=\"3\" align=\"center\" width=\"47%\">
					<label style=\"font-size:18px; font-weight:900; \">INCIDENT REPORT</label>					
				</td>
				<td width=\"33%\">
					Document Number: SEM-FM-002
				</td>
			</tr>
			<tr>
				<td width=\"33%\">
					Effective Date: 10/17/2016
				</td>
			</tr>
			<tr>
				<td width=\"33%\">
					Version Number: 2
				</td>
			</tr>
		</table>
		<br />
		<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
			<tr>
				<td style=\"background-color:#F0F0F0;\"  class=\"blackongray reportalign\">
					Business Unit
				</td>
				<td class=\"reportalign\">
					".$resBU['bu']. "
				</td>
				<td style=\"background-color:#F0F0F0;\"  class=\"blackongray reportalign\">
					Date of Incident
				</td>
				<td class=\"reportalign\">
					".$resTicket['dateadded']."
				</td>
				<td style=\"background-color:#F0F0F0;\"  class=\"blackongray reportalign\">
					Time of Incident
				</td >
				<td class=\"reportalign\">
					".$resLogs['time_created']. "
				</td>
			</tr>
			<tr>
            <td style=\"background-color:#F0F0F0;\"  class=\"blackongray reportalign\">
                Control Number
				</td>
				<td class=\"reportalign\" colspan=\"2\" height=\"30\">
					".$resBU['bu_code']."-".str_replace("-", "", $resTicket['dateadded'])."-".$resTicket['id']. "
				</td>
				<td style=\"background-color:#F0F0F0;\" height=\"30\"  class=\"blackongray reportalign\" >
					Type of Incident
				</td>
				<td colspan=\"2\" class=\"reportalign\" height=\"30\" >";
				if($resIncident['name'])
				{
					$reporttable .= $resIncident['name'];
				}
				else
				{
					$reporttable .= $resTicket['description'];
				}
					
$reporttable .= "</td>
				
				<td >
				</td>				
			</tr>
			<tr>
                <td style=\"background-color:#F0F0F0;\" height=\"30\" class=\"blackongray reportalign\">
                    Location
				</td>
				<td class=\"reportalign\" height=\"30\">
					".$resLocation['location']. "
				</td>
				<td style=\"background-color:#F0F0F0;\" height=\"30\"  class=\"blackongray reportalign\">
					Responding Guard
				</td>
				<td class=\"reportalign\" colspan=\"3\" height=\"30\">
					".$resGuard['lname'].", ".$resGuard['fname']." ".$resGuard['mname']. "
				</td>
				<td colspan=\"100%\" height=\"30\">
				</td>							
			</tr>
			<tr>
                <td style=\"background-color:#F0F0F0;\" height=\"30\"  class=\"blackongray reportalign\">
                    Severity Level
				</td>
				<td class=\"reportalign\" height=\"30\">
					".($resTicket['severity'] == 0 ? $resIncident['defaultlevel'] : $resTicket['severity'])." ".$resTicket['factors'].
	"
				</td>
				<td style=\"background-color:#F0F0F0;\" height=\"30\" class=\"blackongray reportalign\">
                    Cost of Damage/Loss
				</td>
				<td class=\"reportalign\" height=\"30\">";
	if ($resTicket['damage_cost'] != 0) {
		$reporttable .= $resTicket['damage_cost'];
	}
	$reporttable .=	"</td>
                <td style=\"background-color:#F0F0F0;\"  class=\"blackongray reportalign\">
                    Type of Loss
				</td>
				<td colspan=\"3\" class=\"reportalign\">
					" . $resTicket['loss_type'] . "
				</td>
			</tr>
		</table>
        <br />";

$suspectlist = "";		
/* $querySuspect = mysqli_query($conn, "SELECT * FROM incident_suspect WHERE logId = ". $ticketid);
while($resSuspect = mysqli_fetch_assoc($querySuspect))
{
	$suspectlist .= "<table class=\"reportalign2\" align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
							<tr align=\"center\">
								<td class=\"blackongray2\">
									Last Name
								</td>
								<td width=\"20%\">
									".$resSuspect['LastName']."
								</td>
								<td class=\"blackongray2\">
									First Name
								</td>
								<td width=\"20%\">
									".$resSuspect['FirstName']."
								</td>
								<td class=\"blackongray2\">
									Middle Name
								</td>
								<td>
									".$resSuspect['MiddleName']."
								</td>
							</tr>
                            <tr >
								<td class=\"blackongray2\">
									Address
								</td>
								<td colspan=\"100%\">
									".$resSuspect['Address']."
								</td>
															
							</tr>
                            <tr align=\"center\">
                            	<td class=\"blackongray2\">
									Contact Number
								</td>
								<td>
									".$resSuspect['Contact']."
								</td>	
								<td class=\"blackongray2\">
									Age
								</td>
								<td>";
								if($resSuspect['Age'] != 0)
								{
								  $suspectlist .=	$resSuspect['Age'];
								}
		$suspectlist .=			"</td>
								<td class=\"blackongray2\">
									Gender
								</td>
								<td>
									".$resSuspect['Gender']."
								</td>
							</tr>
                            <tr align=\"center\">                            	
								<td class=\"blackongray2\">
									Height
								</td>
								<td>";
								if($resSuspect['Height'] != 0)
								{
								  $suspectlist .=	$resSuspect['Height'] . " cm";
								}
		$suspectlist .=			"</td>
                                <td class=\"blackongray2\">
									Weight
								</td>
								<td style=\"border-right:0px\">";
								if($resSuspect['Weight'] != 0)
								{
								  $suspectlist .=	$resSuspect['Weight'] . " kg";
								}
		$suspectlist .=			"</td>
								<td colspan=\"100%\" style=\"border-left:0px\">
								</td>
                            </tr>
							<tr>
								<td class=\"blackongray2\">
									Type of ID
								</td>
								<td width=\"20%\">
									".$resSuspect['idType']."
								</td>
								<td class=\"blackongray2\">
									ID Number
								</td>
								<td style=\"border-right:0px\">\
									".$resSuspect['idNumber']."
								</td>
								<td colspan=\"100%\" style=\"border-left:0px\">
								</td>
							</tr>
                            <tr >
                            	<td class=\"blackongray2\">
									Remarks
								</td>
								<td colspan=\"100%\">
									".$resSuspect['Remark']."
								</td>
                            </tr>
						</table><br>";
} */

$witnesslist = "";		
/* $queryWitness = mysqli_query($conn, "SELECT * FROM incident_witness WHERE logId = ". $ticketid);
while($resWitness = mysqli_fetch_assoc($queryWitness))
{
	$witnesslist .= "<table class=\"reportalign2\" align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
							<tr align=\"center\">
								<td class=\"blackongray2\">
									Last Name
								</td>
								<td width=\"20%\">
									".$resWitness['LastName']."
								</td>
								<td class=\"blackongray2\">
									First Name
								</td>
								<td width=\"20%\">
									".$resWitness['FirstName']."
								</td>
								<td class=\"blackongray2\">
									Middle Name
								</td>
								<td>
									".$resWitness['MiddleName']."
								</td>
							</tr>
                            <tr >
								<td class=\"blackongray2\">
									Address
								</td>
								<td colspan=\"100%\" >
									".$resWitness['Address']."
								</td>
															
							</tr>
                            <tr align=\"center\">
                            	<td class=\"blackongray2\">
									Contact Number
								</td>
								<td>
									".$resWitness['Contact']."
								</td>	
								<td class=\"blackongray2\">
									Age
								</td>
								<td>";
								if($resWitness['Age'] != 0)
								{
								  $witnesslist .=	$resWitness['Age'];
								}
		$witnesslist .=			"</td>
								<td class=\"blackongray2\">
									Gender
								</td>
								<td>
									".$resWitness['Gender']."
								</td>
							</tr>
                            <tr align=\"center\">                            	
								<td class=\"blackongray2\">
									Height
								</td>
								<td>";
								if($resWitness['Height'] != 0)
								{
								  $witnesslist .=	$resWitness['Height'] . " cm";
								}
		$witnesslist .=			"</td>
                                <td class=\"blackongray2\">
									Weight
								</td>
								<td style=\"border-right:0px\">";
								if($resWitness['Weight'] != 0)
								{
								  $witnesslist .=	$resWitness['Weight'] . " kg";
								}
		$witnesslist .=			"</td>
								<td colspan=\"100%\" style=\"border-left:0px\">
								</td>
                            </tr>
							<tr>
								<td class=\"blackongray2\">
									Type of ID
								</td>
								<td width=\"20%\">
									".$resWitness['idType']."
								</td>
								<td class=\"blackongray2\">
									ID Number
								</td>
								<td style=\"border-right:0px\">
									".$resWitness['idNumber']."
								</td>
								<td colspan=\"100%\" style=\"border-left:0px\">
								</td>
							</tr>
                            <tr >
                            	<td class=\"blackongray2\">
									Remarks
								</td>
								<td colspan=\"100%\" >
									".$resWitness['Remark']."
								</td>
                            </tr>
						</table><br>";
} */

$victimlist = "";		
/* $queryVictim = mysqli_query($conn, "SELECT * FROM incident_victim WHERE logId = ". $ticketid);
while($resVictim = mysqli_fetch_assoc($queryVictim))
{
	$victimlist .= "<table class=\"reportalign2\" align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
							<tr align=\"center\">
								<td class=\"blackongray2\">
									Last Name
								</td >
								<td width=\"20%\">
									".$resVictim['LastName']."
								</td>
								<td class=\"blackongray2\">
									First Name
								</td>
								<td width=\"20%\">
									".$resVictim['FirstName']."
								</td>
								<td class=\"blackongray2\">
									Middle Name
								</td>
								<td>
									".$resVictim['MiddleName']."
								</td>
							</tr>
                            <tr >
								<td class=\"blackongray2\">
									Address
								</td>
								<td colspan=\"100%\">
									".$resVictim['Address']."
								</td>
															
							</tr>
                            <tr align=\"center\">
                            	<td class=\"blackongray2\">
									Contact Number
								</td>
								<td>
									".$resVictim['Contact']."
								</td>	
								<td class=\"blackongray2\">
									Age
								</td>
								<td>";
								if($resVictim['Age'] != 0)
								{
								  $victimlist .=	$resVictim['Age'];
								}
		$victimlist .=			"</td>
								<td class=\"blackongray2\">
									Gender
								</td>
								<td>
									".$resVictim['Gender']."
								</td>
							</tr>
                            <tr align=\"center\">                            	
								<td class=\"blackongray2\">
									Height
								</td>
								<td>";
								if($resVictim['Height'] != 0)
								{
								  $victimlist .=	$resVictim['Height'] . " cm";
								}
		$victimlist .=			"</td>
                                <td class=\"blackongray2\">
									Weight
								</td>
								<td style=\"border-right:0px\">";
								if($resVictim['Weight'] != 0)
								{
								  $victimlist .=	$resVictim['Weight'] . " kg";
								}
		$victimlist .=			"</td>
								<td colspan=\"100%\" style=\"border-left:0px\">
								</td>
                            </tr>
							<tr>
								<td class=\"blackongray2\">
									Type of ID
								</td>
								<td width=\"20%\">
									".$resVictim['idType']."
								</td>
								<td class=\"blackongray2\">
									ID Number
								</td>
								<td style=\"border-right:0px\">
									".$resVictim['idNumber']."
								</td>
								<td colspan=\"100%\" style=\"border-left:0px\">
								</td>
							</tr>
                            <tr >
                            	<td class=\"blackongray2\">
									Remarks
								</td>
								<td colspan=\"100%\" >
									".$resVictim['Remark']."
								</td>
                            </tr>
						</table><br>";
} */

$involvedlist = "";
$noncompliantlist = "";
$medlist = "";
$queryInvolved = mysqli_query($conn, "SELECT * FROM incident_involved_mst WHERE logId = ". $ticketid);
while($resInvolved = mysqli_fetch_assoc($queryInvolved))
{
	$involvedlist = "<table class=\"reportalign2\" align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\" onclick=\"this.parentNode.removeChild(this);\">
							<tr align=\"center\">
								<td class=\"blackongray2\">
									Last Name
								</td >
								<td width=\"20%\">
									".$resInvolved['LastName']."
								</td>
								<td class=\"blackongray2\">
									First Name
								</td>
								<td width=\"20%\">
									".$resInvolved['FirstName']."
								</td>
								<td class=\"blackongray2\">
									Middle Name
								</td>
								<td>
									".$resInvolved['MiddleName']."
								</td>
							</tr>
                            <tr >
								<td class=\"blackongray2\">
									Address
								</td>
								<td colspan=\"100%\">
									".$resInvolved['Address']."
								</td>
															
							</tr>
                            <tr align=\"center\">
                            	<td class=\"blackongray2\">
									Contact Number
								</td>
								<td>
									".$resInvolved['Contact']."
								</td>	
								<td class=\"blackongray2\">
									Age
								</td>
								<td>";
								if($resInvolved['Age'] != 0)
								{
								  $involvedlist .=	$resInvolved['Age'];
								}
		$involvedlist .=			"</td>
								<td class=\"blackongray2\">
									Gender
								</td>
								<td>
									".$resInvolved['Gender']."
								</td>
							</tr>
                            <tr align=\"center\">                            	
								<td class=\"blackongray2\">
									Height
								</td>
								<td>";
								if($resInvolved['Height'] != 0)
								{
								  $involvedlist .=	$resInvolved['Height'] . " cm";
								}
		$involvedlist .=			"</td>
                                <td class=\"blackongray2\">
									Weight
								</td>
								<td style=\"border-right:0px\">";
								if($resInvolved['Weight'] != 0)
								{
								  $involvedlist .=	$resInvolved['Weight'] . " kg";
								}
		$involvedlist .=			"</td>
								<td colspan=\"100%\" style=\"border-left:0px\">
								</td>
                            </tr>
							<tr>
								<td class=\"blackongray2\">
									Type of ID
								</td>
								<td width=\"20%\">
									".$resInvolved['idType']."
								</td>
								<td class=\"blackongray2\">
									ID Number
								</td>
								<td style=\"border-right:0px\">
									".$resInvolved['idNumber']."
								</td>
								<td colspan=\"100%\" style=\"border-left:0px\">
								</td>
							</tr>
                            <tr >
                            	<td class=\"blackongray2\">
									Remarks
								</td>
								<td colspan=\"100%\" >
									".$resInvolved['Remark']."
								</td>
                            </tr>
						</table><br>";
	if($resInvolved['Class'] == "Suspect")
	{
		$suspectlist .= $involvedlist;
	}
	elseif($resInvolved['Class'] == "Victim")
	{
		$victimlist .= $involvedlist;
	}
	elseif($resInvolved['Class'] == "Witness")
	{
		$witnesslist .= $involvedlist;
	}
	elseif($resInvolved['Class'] == "Non-compliant")
	{
		$noncompliantlist .= $involvedlist;
	}
	elseif($resInvolved['Class'] == "Medical/Emergency")
	{
		$medlist .= $involvedlist;
	}
}

if(($suspectlist) or ($witnesslist) or ($victimlist) or ($noncompliantlist) or ($medlist))
{
	$reporttable .= 
		"<div id=\"divReportInvolved\">
			<table width=\"100%\" style=\"padding:0px;\">
				<tr>
					<th align=\"left\" colspan=\"100%\" onclick=\"this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);\">Person(s) Involved</th>
				</tr>
			</table>";
	if($suspectlist)
	{
		$reporttable .= "<div id=\"divReportSuspect\">
						 <table width=\"100%\">
						 	<tr>
								<td colspan=\"100%\" onclick=\"this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);\"><i><u>Suspect(s)</u></i></td>
							</tr>
							<tr>
								<td colspan=\"100%\">". $suspectlist ."</td>
							</tr>	
						 </table>
						 </div>";
	}
	if($witnesslist)
	{
		$reporttable .= "<div id=\"divReportWitness\">
						 <table width=\"100%\">
						 	<tr>
								<td colspan=\"100%\" onclick=\"this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);\"><i><u>Witness(es)</u></i></td>
							</tr>
							<tr>
								<td colspan=\"100%\">". $witnesslist ."</td>
							</tr>	
						 </table>
						 </div>";
	}
	if($victimlist)
	{
		$reporttable .= "<div id=\"divReportVictim\">
						 <table width=\"100%\">
						 	<tr>
								<td colspan=\"100%\" onclick=\"this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);\"><i><u>Victim(s)</u></i></td>
							</tr>
							<tr>
								<td colspan=\"100%\">". $victimlist ."</td>
							</tr>	
						 </table>
						 </div>";
	}
	if($noncompliantlist)
	{
		$reporttable .= "<div id=\"divReportNonComp\">
						 <table width=\"100%\">
						 	<tr>
								<td colspan=\"100%\" onclick=\"this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);\"><i><u>Non-compliant</u></i></td>
							</tr>
							<tr>
								<td colspan=\"100%\">". $noncompliantlist ."</td>
							</tr>	
						 </table>
						 </div>";
	}
	if($medlist)
	{
		$reporttable .= "<div id=\"divReportNonComp\">
						 <table width=\"100%\">
						 	<tr>
								<td colspan=\"100%\" onclick=\"this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);\"><i><u>Medical/Emergency</u></i></td>
							</tr>
							<tr>
								<td colspan=\"100%\">". $medlist ."</td>
							</tr>	
						 </table>
						 </div>";
	}
	$reporttable .= "</div>";
}

$counterfeitlist = "";
$queryCounterfeit = mysqli_query($conn, "SELECT * FROM incident_counterfeit WHERE ticket_id = ". $ticketid);
while($resCounterfeit = mysqli_fetch_assoc($queryCounterfeit))
{
$counterfeitlist = "<div id=\"divReportCounterfeit\">
			<table width=\"100%\">
				<tr>
					<td colspan=\"100%\"><b>Counterfeit Details</b></i></td>
				</tr>
				<tr>
					<td colspan=\"100%\">
						  <table class=\"reportalign2\" align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
							  <tr>
								  <td class=\"blackongray2\">
									  Account Name
								  </td>
								  <td align=\"center\">
									  ".$resCounterfeit['account_name']."
								  </td>
								  <td class=\"blackongray2\">
									  Account ID
								  </td>
								  <td align=\"center\">
									  ".$resCounterfeit['account_id']."
								  </td>
								  <td class=\"blackongray2\">
									  Amount
								  </td>
								  <td align=\"center\">
									  ".$resCounterfeit['amount']."
								  </td>
							  </tr>
							  <tr>
								  <td class=\"blackongray2\">
									  Counterfeit Bill Serial
								  </td>
								  <td align=\"center\">
									  ".$resCounterfeit['bill_serial']."
								  </td>
								  <td class=\"blackongray2\" colspan=\"2\">
									  Relationship of Suspect to Account Name
								  </td>
								  <td colspan=\"100%\" align=\"center\">
									  ".$resCounterfeit['relationship']."
								  </td>                      
							  </tr>
							  <tr>
								  <td class=\"blackongray2\">
									  Customer Representative
								  </td>
								  <td align=\"center\">
									  ".$resCounterfeit['customer_rep']."
								  </td>
								  <td class=\"blackongray\" >
									  Address of Incident
								  </td>
								  <td colspan=\"100%\" align=\"center\">
									  ".$resCounterfeit['address']."
								  </td>                      
							  </tr>
						  </table>
					</td>
				</tr>
			</table>
        </div>
		<br>";
}

if($counterfeitlist)
{
	$reporttable .= $counterfeitlist;
}

$vehiclelist = "";
$queryVehicle = mysqli_query($conn, "SELECT * FROM incident_vehicle WHERE ticket_id = ".$ticketid);
while($resVehicle = mysqli_fetch_assoc($queryVehicle))
{
	$vehiclelist .= "<table class=\"reportalign2\" align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
						  <tr>
								<td class=\"blackongray2\">
									Type
								</td>
								<td align=\"center\" width=\"20%\">
									".$resVehicle['type']."
								</td>
								<td class=\"blackongray2\">
									Plate Number
								</td>
								<td align=\"center\"width=\"10%\">
									".$resVehicle['plate_no']."
								</td>
								<td class=\"blackongray2\">
									Owner
								</td>
								<td align=\"center\">
									".$resVehicle['owner']."
								</td>
						  </tr>
						  <tr>
							  <td class=\"blackongray2\">
								  Color
							  </td>
							  <td align=\"center\">
								  ".$resVehicle['color']."
							  </td>
							  <td class=\"blackongray2\">
								  Make
							  </td>
							  <td align=\"center\">
								  ".$resVehicle['make']."
							  </td>
							  <td class=\"blackongray2\">
								  Model
							  </td>
							  <td align=\"center\">
								  ".$resVehicle['model']."
							  </td>
						  </tr>
						  <tr>
							  <td class=\"blackongray2\">
								 Remarks
							  </td>
							  <td colspan=\"100%\" >
								  ".$resVehicle['remarks']."
							  </td>
						  </tr>
					  </table><br />";
}

if($vehiclelist)
{
	$reporttable .= "<div id=\"divReportVehicle\">
						<table width=\"100%\">
							<tr>
								<td colspan=\"100%\"><b>Vehicle(s) Involved</b></i></td>
							</tr>
							<tr>
								<td colspan=\"100%\">".$vehiclelist."</td>
							</tr>
						</table>
						<br>
						
					</div>";
}

$loglist = "";
$attachmenttable = "";
$queryLogs2 = mysqli_query($conn, "SELECT * FROM log_mst WHERE ticket = ".$ticketid." ORDER BY date_created, time_created");
while($resLogs2 = mysqli_fetch_assoc($queryLogs2))
{
	$queryGuard2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = ". $resLogs2['gid']);
	$resGuard2 = mysqli_fetch_assoc($queryGuard2);
	$queryEncoder = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ". $resLogs2['uid']);
	$resEncoder = mysqli_fetch_assoc($queryEncoder);
	$loglist .= "<tr align=\"center\" valign=\"top\" onclick=\"this.parentNode.removeChild(this);\">
					<td width=\"10%\" style=\"padding-top:10px;\" height=\"30\">
						".$resLogs2['date_created']. "
					</td>
					<td width=\"10%\" style=\"padding-top:10px;\" height=\"30\">
						".$resLogs2['time_created']. "
					</td>
					<td width=\"20%\" style=\"padding-top:10px;\" height=\"30\">
						".$resGuard2['lname'].", ".$resGuard2['fname']." ".$resGuard2['mname']. "
					</td>
					<td width=\"40%\" align=\"left\" style=\"padding:10px;\" height=\"30\">
						".preg_replace( "/\n/", "<br>", $resLogs2['remarks']). "
					</td>
					<td width=\"20%\" style=\"padding-top:10px;\" height=\"30\">
						".$resEncoder['lname'].", ".$resEncoder['fname']." ".$resEncoder['mi'].".
					</td>
				 </tr>";
	if($resLogs2['upload1'])
	{
		$attachmenttable .= "<tr>
								<td colspan='100%' align='center' style='padding:10px;>
									<img src=\"".$resLogs2['upload1']."\" width=\"50%\"/>
									<br>Uploaded on ".$resattachments['datesubmitted']."
								</td>
							</tr>";
	}
	if($resLogs2['upload2'])
	{
		$attachmenttable .= "<tr>
								<td colspan='100%' align='center' style='padding:10px;>
									<img src=\"".$resLogs2['upload2']."\" width=\"50%\"/>
									<br>Uploaded on ".$resattachments['datesubmitted']."
								</td>
							</tr>";
	}
	if($resLogs2['upload3'])
	{
		$attachmenttable .= "<tr>
								<td colspan='100%' align='center' style='padding:10px;>
									<img src=\"".$resLogs2['upload3']."\" width=\"50%\"/>
									<br>Uploaded on ".$resattachments['datesubmitted']."
								</td>
							</tr>";
	}
}

$queryattachments = mysqli_query($conn, "SELECT * FROM upload_mst WHERE ticket_id = ".$ticketid);
while($resattachments = mysqli_fetch_assoc($queryattachments))
{
	$uploadext = substr($resattachments['upload_path'], -3);
	if(($uploadext == "jpg") || ($uploadext == "gif") || ($uploadext == "png") || ($uploadext == "peg"))
	{
		$attachmenttable .= "<tr onclick=\"this.parentNode.removeChild(this);\">
								<td colspan='100%' align='center' style='padding:10px;'>
									<img src='".$resattachments['upload_path']."' style='width:50%;'>
									<br>Uploaded on ".$resattachments['date_uploaded']."
								</td>
							</tr>";
	}
}

if($attachmenttable)
{	
}
else
{
	$attachmenttable = "<tr><td align=\"center\">No Attachments</td></tr>";
}
		
$reporttable .=
	   "<div id=\"divReportNarrative\">
			<table>
				<tr >
					<td colspan=\"100%\"><label title=\"Hide this part\" style=\"font-weight:bold; cursor:pointer;\" onclick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode.parentNode.parentNode);\">Narrative</label> <i>(Original logs)</i></td>
				</tr>
			</table>
            <table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
            	<thead>					
					<tr style=\"background-color:#F0F0F0;\"  class=\"blackongray\" >
                		<th width=\"10%\">Date</th>
						<th width=\"10%\">Time</th>
						<th width=\"20%\">Guard</th>
                    	<th width=\"40%\">Incident Logs</th>
						<th width=\"20%\">Encoder</th>
					</tr>
                </thead>
                <tbody>
					".$loglist."
                </tbody>
            </table>
          
		  <br>
        </div>";

$queryRevisions = mysqli_query($conn, "SELECT * FROM logrevision_mst WHERE ticket = ". $ticketid);
$resRevisions = "";
$revisionlist = "";
$revisionlist2 = "";
$revisedby = "";
$daterevised = "";
$timerevised = "";
$revisionnum = "";
$revisedby2 = "";
$daterevised2 = "";
$timerevised2 = "";
$revisionnum2 = "";
if($queryRevisions)
{	
	while($resRevisions = mysqli_fetch_assoc($queryRevisions))
	{
		$queryGuard = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = ". $resRevisions['gid']);
		$resGuard = mysqli_fetch_assoc($queryGuard);
		$queryEncoder2 = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ". $resRevisions['revised_by']);
		$resEncoder2 = mysqli_fetch_assoc($queryEncoder2);		
//		$revisedby = $resEncoder2['lname'].", ".$resEncoder2['fname']." ".$resEncoder2['mi'].".";
//		$daterevised = $resRevisions['date_revised'];
//		$timerevised = $resRevisions['time_revised'];
//		$revisionnum = $resRevisions['revision_num'];
		$revisionlog = "<tr align=\"center\" valign=\"top\" onclick=\"this.parentNode.removeChild(this);\">
							<td style=\"padding-top:10px;\">
								".$resRevisions['date_created']."
							</td>
							<td style=\"padding-top:10px;\">
								".$resRevisions['time_created']."
							</td>
							<td style=\"padding-top:10px;\">
								".$resGuard['lname'].", ".$resGuard['fname']." ".$resGuard['mname']."
							</td>							
							<td align=\"left\" style=\"padding:10px;\">
								".preg_replace( "/\n/", "<br>", $resRevisions['remarks'])."
							</td>
						 </tr>";
		if($resRevisions['revision_num'] == 1)
		{
			$revisedby = $resEncoder2['lname'].", ".$resEncoder2['fname']." ".$resEncoder2['mi'].".";
			$daterevised = $resRevisions['date_revised'];
			$timerevised = $resRevisions['time_revised'];
			$revisionnum = $resRevisions['revision_num'];
			$revisionlist .= $revisionlog;
		}
		else
		{
			$revisedby2 = $resEncoder2['lname'].", ".$resEncoder2['fname']." ".$resEncoder2['mi'].".";
			$daterevised2 = $resRevisions['date_revised'];
			$timerevised2 = $resRevisions['time_revised'];
			$revisionnum2 = $resRevisions['revision_num'];
			$revisionlist2 .= $revisionlog;
		}
		
	}
}

if($revisionlist)
{
	$reporttable .= "<div id=\"divReviseRevisionEntries\">
							<table>
								<tr >
									<td colspan=\"100%\"><label title=\"Hide this part\" style=\"font-weight:bold; cursor:pointer;\" onclick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode.parentNode.parentNode);\">Narrative</label> <i>(Revision #".$revisionnum.")<br><u>Revised on ".$daterevised." ".$timerevised." by ".$revisedby."</u></i></td>
								</tr>
							</table>
							<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
								<thead>
									<tr class=\"blackongray\">
										<th>Date</th>
										<th>Time</th>
										<th>Guard</th>
										<th width=\"50%\">Incident Logs</th>										
									</tr>
								</thead>
								<tbody>
									".$revisionlist."
								</tbody>
							</table>
						  <br>
						</div>";
}

if($revisionlist2)
{
	$reporttable .= "<div id=\"divReviseRevisionEntries2\">
							<table>
								<tr >
									<td colspan=\"100%\"><label title=\"Hide this part\" style=\"font-weight:bold; cursor:pointer;\" onclick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode.parentNode.parentNode);\">Narrative</label> <i>(Revision #".$revisionnum2.")<br><u>Revised on ".$daterevised2." ".$timerevised2." by ".$revisedby2."</u></i></td>
								</tr>
							</table>
							<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
								<thead>
									<tr class=\"blackongray\">
										<th>Date</th>
										<th>Time</th>
										<th>Guard</th>
										<th width=\"50%\">Incident Logs</th>										
									</tr>
								</thead>
								<tbody>
									".$revisionlist2."
								</tbody>
							</table>
						  <br>
						</div>";
}

$reporttable .=
	"<div id=\"divReportDisposition\">
			<table>
				<tr>
					<td colspan=\"100%\"><label title=\"Hide this part\" style=\"font-weight:bold; cursor:pointer;\" onclick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode.parentNode.parentNode);\">Disposition</label></td>
				</tr>
			</table>
			<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
				<tr style=\"background-color:#F0F0F0;\"  class=\"blackongray\">
					<th width=\"30%\">Date Closed</th>
					<th width=\"70%\">Disposition</th>
				</tr>
				<tr>
					<td width=\"30%\" height=\"30\" align=\"center\">".$resTicket['dateclosed']. "</td>
					<td width=\"70%\" height=\"30\" align=\"center\">".$resTicket['disposition']."</td>
				</tr>
			</table>
		<br>
		</div>";

$disporevlist = "";			
$sqldisporev = mysqli_query($conn, "SELECT d.*, u.fname as ufname, u.mi as umi, u.lname as ulname FROM disposition_revisions d LEFT JOIN users_mst u ON d.user_id = u.id WHERE d.ticket_id = ". $ticketid);
if($sqldisporev)
{
	$dispocount = 2;
	while($resdisporev = mysqli_fetch_assoc($sqldisporev))
	{
		$disporevlist .= "<div><table>
								<tr>
									<td colspan=\"100%\"><label title=\"Hide this part\" style=\"font-weight:bold; cursor:pointer;\" onclick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode.parentNode.parentNode);\">Disposition #".$dispocount."</label><br><u><i>Updated by ".$resdisporev['ulname'].", ".$resdisporev['ufname']." ".$resdisporev['umi'].".</u></i></td>
								</tr>
							</table>
							<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
								<tr class=\"blackongray\">
									<th width=\"30%\">Date Updated</th>
									<th>Disposition</th>
								</tr>
								<tr>
									<td align=\"center\">".$resdisporev['edit_date']."</td>
									<td align=\"center\">".$resdisporev['disposition']."</td>
								</tr>
							</table><br></div>";
							$dispocount++;
		// $disporevlist .= "<tr style=\"cursor:pointer;\" onclick=\"this.parentNode.removeChild(this);\">
							// <td align=\"center\">".$resdisporev['edit_date']."</td>
							// <td align=\"center\">".$resdisporev['disposition']."</td>
							// <td align=\"center\">".$resdisporev['ulname'].", ".$resdisporev['ufname']." ".$resdisporev['umi'].".</td>
						  // </tr>";
	}
}

if($disporevlist)
{
	$reporttable .= "<div>
						".$disporevlist."
					</div>";
					/* "<div>
					<table>
						<tr>
							<td colspan=\"100%\"><label title=\"Hide this part\" style=\"font-weight:bold; cursor:pointer;\" onclick=\"this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode.parentNode.parentNode);\">Updated Disposition</label></td>
						</tr>
					</table>
					<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
						<tr class=\"blackongray\">
							<th width=\"30%\">Date Updated</th>
							<th>Disposition</th>
							<th>Updated by</tth							
						</tr>
						".$disporevlist."
					  </table>
					  <br>
					  </div>"; */
}
			
$reporttable .=
	"<table align=\"center\" width=\"100%\">
			<tr>
				<td align=\"center\">
					I hereby ceritfy that the information above is true and correct to the best of my knowledge.
				</td>
			</tr>
		</table>
		<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
			<tr style=\"background-color:#F0F0F0;\"  class=\"blackongray\">
				<th width=\"33%\" colspan=\"2\">Responding Guard</th>				
				<th width=\"33%\" colspan=\"2\">Security-in-Charge</th>				
				<th width=\"33%\" colspan=\"2\">Security Manager</th>				
			</tr>
			<tr height=\"50\" align=\"center\" valign=\"bottom\" >
				<td colspan=\"2\" height=\"30\" >".$resGuard['lname'].", ".$resGuard['fname']." ".$resGuard['mname']. "</td>
				<td colspan=\"2\" height=\"30\" id=\"tdSIC\"><input id=\"txtSIC\" class=\"txtborderless rDates\" type=\"text\" style=\"text-align:center;\" /></td>
				<td colspan=\"2\" height=\"30\" id=\"tdSecMgr\"><input id=\"txtSecMgr\" class=\"txtborderless rDates\" type=\"text\" style=\"text-align:center;\" /></td>
			</tr>
			<tr>
				<td width=\"10%\" style=\"background-color:#F0F0F0;\"  class=\"blackongray \">Date</td>
				<td width=\"23%\"></td>
				<td width=\"10%\" style=\"background-color:#F0F0F0;\"  class=\"blackongray \">Date</td>
				<td width=\"23%\"></td>
				<td width=\"10%\" style=\"background-color:#F0F0F0;\"  class=\"blackongray \">Date</td>
				<td width=\"23%\"></td>
			</tr>
		</table>
		</div>
		  <div id=\"attachmentWrapper\" style=\"display:none\">
			  <table align=\"center\">
			  	<tr>
					<th align=\"center\">Attachment(s) for ".$resBU['bu_code']."-".str_replace("-", "", $resTicket['dateadded'])."-".$resTicket['id']."</td>
				</tr>
				  ".$attachmenttable."
			  </table>
		  </div>
		</div>
";
	
if(!empty($reporttable))
{
	        require('tcpdf/tcpdf.php');
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Nicola Asuni');
			$pdf->SetTitle('TCPDF Example 002');
			$pdf->SetSubject('TCPDF Tutorial');
			$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// set font
			$pdf->SetFont('aealarabiya', '', 8);

			// add a page
			$pdf->AddPage();

			$content = '';
			$content .= $reporttable;
			$content .= '</table>';

			$pdf->writeHTML($content, true, false, false, false, '');
			
			$file='incidentReport/'.time().'.pdf';
			$pdf->output(__DIR__ . '/incidentReport/' . $resBU['bu_code'] . '-' . str_replace('-', '', $resTicket['dateadded']).'-' . $resTicket['id'] . '.pdf', 'F');
            $incidentReportFile = $resBU['bu_code'] . "-" . str_replace("-", "", $resTicket['dateadded']) . "-" . $resTicket['id'];
            mysqli_query($conn, "UPDATE ticket SET report_file =  '".$incidentReportFile."' WHERE id = $ticketid");

}
}
