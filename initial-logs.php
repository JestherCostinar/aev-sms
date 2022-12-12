<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$newtype = $_GET['type'];
$resulttable = "";
$activitytable = "";
$incidenttable = "";
date_default_timezone_set('Asia/Manila');

if(($newtype == "Inc") || ($newtype == "Act"))
{
	if($_SESSION['level'] == 'Super Admin')
	{
		$activitysql = mysqli_query($conn, "select * from ticket where dateadded > DATE_SUB(now(), INTERVAL 2 DAY) order by datesubmitted desc");
		while($actres = mysqli_fetch_assoc($activitysql))
		{
			$logid = "ticket" . $actres['id'];
			$addlogid = "addlog" . $actres['id'];
			$ticket_type = $actres['ticket_type'];
			
			if ($actres['is_open']==1)
			{
				//document.getElementById('date').value = new Date().toLocaleTimestring($conn, navigator.language, {hour: '2-digit', minute:'2-digit'})
				if($ticket_type == 1){
					$type = "Incidents";
					$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ". $actres['description']);
					if($queryTicketDesc)
					{
						$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
						$ticketdesc = $resTicketDesc['name'];
					}
					else
					{
						$ticketdesc =  $actres['description'];
					}
					//$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $actres['description'] ."', '". $ticket_type ."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', 1)\">Close Ticket</td>";
				}
				else{
					$type = "Activities";
					$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ". $actres['description']);
					if($queryTicketDesc)
					{
						$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
						$ticketdesc = $resTicketDesc['name'];
					}
					else
					{
						$ticketdesc =  $actres['description'];
					}
					//$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $actres['description'] ."', '". $ticket_type ."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', 2)\">Close Ticket</td>";
				}
				
				$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td>";
				
				
			}
			else
			{
				if($ticket_type == 1){
					$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$actres['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td colsepan='100%' style=\"cursor:pointer\" onclick=\"GenerateReport(".$actres['id'].");\">Generate Report</td>";
				}
				else{
					$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td class=\"addlog\" colspan=\"100%\">".$actres['dateclosed']."</td>";
				}
				//$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$actres['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"GenerateReport(".$actres['id'].");\">Generate Report</td>";
			}
			$actlogssql = mysqli_query($conn, "select * from log_mst where ticket = ". $actres['id'] ." order by date_created DESC, time_created DESC");
			$actlogtable = "";
			$lognum = mysqli_num_rows($actlogssql) + 1;
			$rownum = 1;
			while($actlogres = mysqli_fetch_assoc($actlogssql))
			{
				$result1 = mysqli_query($conn, "select * from urc_mst where id = '". $actlogres['urcid'] ."'");
					$urcres = mysqli_fetch_assoc($result1);
				$result2 = mysqli_query($conn, "select * from guard_personnel where id = '". $actlogres['gid'] ."'");
					$guardres = mysqli_fetch_assoc($result2);
				$result3 = mysqli_query($conn, "select * from location_mst where id = '". $actlogres['location'] ."'");
					$locres = mysqli_fetch_assoc($result3);
				$queryEncoder = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ". $actlogres['uid']);
				$resEncoder = mysqli_fetch_assoc($queryEncoder);
				
				$lognum -= 1;
				
				$remarksid = "remark" . $actlogres['id'];
				$attachmentid = "attachment". $actlogres['id'];
				$attachmentshow = "";
				if(($actlogres['upload1']) || ($actlogres['upload2']) || ($actlogres['upload3']))
				{
					//$attachmentdi = "attachment". $actlogres['id'];
					$attachmentshow .= "<table align=\"center\">";
					if($actlogres['upload1'])
					{
					  $attachmentshow .=   "<tr>
											  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload1'] ."\" /></td>
										   </tr>";
					}
					if($actlogres['upload2'])
					{
					  $attachmentshow .=   "<tr>
											  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload2'] ."\" /></td>
										   </tr>";
					}
					if($actlogres['upload3'])
					{
					  $attachmentshow .=   "<tr>
											  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload3'] ."\" /></td>
										   </tr>";
					}
					$attachmentshow .= "</table>";
				}
				else
				{
					$attachmentshow = "<table align=\"center\">
										 <tr>
											<td align=\"center\">No Attachments</td>
										 </tr>
									   </table>";
				}
				if($rownum == 1){
					//$rowcolor = "style=\"background-color: #BCD9FB;\"";
					$rowcolor = "altrows";
					$rownum = 0;
				}
				elseif($rownum == 0){
					//$rowcolor = "style=\"background-color: #FFFFCC;\"";
					$rowcolor = "";
					$rownum = 1;
				}
				$firstfour = array();		
				$firstfourinitial = explode(" ", $actlogres['remarks']);
				for($i = 0; $i <= 3; $i++)
				{
					$firstfour[] = $firstfourinitial[$i];
				}
				$firstfourfinal = implode(" ", $firstfour);
				$actlogtable .= "<tr align=\"center\" class='".$rowcolor."' >
									<td width=\"5%\">". $lognum ."</td>
									<td width=\"20%\">". $locres['location'] ."</td>
									<td width=\"35%\" onclick=\"showLogs('". $remarksid ."')\" style=\"cursor:pointer\">". $firstfourfinal ."...</td>
									<td width=\"10%\">". $actlogres['date_created'] ."</td>
									<td width=\"10%\">". $actlogres['time_created'] ."</td>
									<td width=\"20%\">". $guardres['fname'] ." ". $guardres['lname'] ."</td>
								 </tr>";
				$actlogtable .= "<tr align=\"center\" class='".$rowcolor."'>
									<td width=\"100%\" colspan=\"100%\">
										<div id=\"". $remarksid ."\" class=\"logs2\" style=\"display:none;\">
											<table width=\"70%\">
											<tr>
												<td colspan=\"100%\">
												Narration:
												</td>
											</tr>
											<tr>
												<td colspan=\"100%\" align=\"center\">                                    	
													<textarea style=\"width:95%; height:150px; resize:none\" readonly=\"readonly\" >". $actlogres['remarks'] ."</textarea>
												</td>
											</tr>
											<tr>
												<td align=\"left\">
													<label style=\"text-decoration:underline; cursor:pointer; color:#00F;\" onclick=\"showAttachments('".$attachmentid."');\" >Show Attachments</label>
												</td>
												<td align=\"right\">
													Encoded by: ".$resEncoder['lname'].", ".$resEncoder['fname']." ".$resEncoder['mi'].".
												</td>
											</tr>
											</table>
											<div id=\"". $attachmentid ."\" style=\"display:none;\">
												".$attachmentshow."
											</div>
										</div>
									</td>
								</tr>";
			}
			if (empty($actlogtable)){
				$actlogtable = "<tr>
									<td align=\"center\" colspan=\"100%\">No log entries</td>
								</tr>";
			}
			$queryTicketBU = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$actres['bu']);
				$resTicketBU = mysqli_fetch_assoc($queryTicketBU);
			$activitylogs = "";
			if($ticket_type == 1){
				$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ". $actres['description']);
				if($queryTicketDesc)
				{
					$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
					$ticketdesc = $resTicketDesc['name'];
				}
				else
				{
					$ticketdesc =  $actres['description'];
				}
				$incidenttable .= "<tr align=\"center\" bgcolor=\"#000000\" style=\"color:#FFF\">
				<td >". $actres['id'] ."</td>
				<td >". $actres['dateadded'] ."</td>
				<td >". $resTicketBU['bu'] ."</td>
				<td >". ($actres['severity'] == 0 ? $resTicketDesc['defaultlevel'] : $actres['severity']) ."</td>
				<td ><label onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</label></td>
				". $stat ."        
				</tr>
				<tr>
				  <td colspan=\"100%\" align=\"center\">
					  <div id=\"". $logid ."\" class=\"logs\" style=\"display:none\">
						  <table width=\"100%\">
							<tr>
								<th>#</th>
								<th>Location</th>
								<th>Narratiom</th>
								<th>Date</th>
								<th>Time</th>
								<th>Guard</th>
							</tr>
							". $actlogtable ."
						  </table>
					  </div>
					  
				  </td>
				</tr>";
			}
			else{
				$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ". $actres['description']);
				if($queryTicketDesc)
				{
					$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
					$ticketdesc = $resTicketDesc['name'];
				}
				else
				{
					$ticketdesc =  $actres['description'];
				}
				
			$activitytable .= "<tr align=\"center\" bgcolor=\"#000000\" style=\"color:#FFF\">
				<td >". $actres['id'] ."</td>
				<td >". $actres['dateadded'] ."</td>
				<td >". $resTicketBU['bu'] ."</td>
				<td ><label onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</label></td>
				". $stat ."        
			  </tr>
			  <tr>
				<td colspan=\"100%\" align=\"center\">
					<div id=\"". $logid ."\" class=\"logs\" style=\"display:none\">
						<table width=\"100%\">
							<tr>
								<th>#</th>
								<th>Location</th>
								<th>Narration</th>
								<th>Date</th>
								<th>Time</th>
								<th>Guard</th>
							</tr>
						  ". $actlogtable ."
						</table>
					</div>
					
				</td>
			  </tr>";
			}
		}
	}
	elseif($_SESSION['level'] == 'Admin')
	{
		$activitysql = mysqli_query($conn, "select * from ticket where ((dateadded > DATE_SUB(now(), INTERVAL 4 DAY)) OR (is_open = 1)) AND bu = $bu order by datesubmitted desc");
		$activitytable = "";
		$incidenttable = "";
		while($actres = mysqli_fetch_assoc($activitysql))
		{
			$logid = "ticket" . $actres['id'];
			$addlogid = "addlog" . $actres['id'];
			$ticket_type = $actres['ticket_type'];
			
			if ($actres['is_open']==1)
			{
				//document.getElementById('date').value = new Date().toLocaleTimestring($conn, navigator.language, {hour: '2-digit', minute:'2-digit'})
				if($ticket_type == 1){
					$type = "Incidents";
					$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ". $actres['description']);
					if($queryTicketDesc)
					{
						$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
						$ticketdesc = $resTicketDesc['name'];
					}
					else
					{
						$ticketdesc =  $actres['description'];
					}
					//$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $actres['description'] ."', '". $ticket_type ."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', 1)\">Close Ticket</td>";
					$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."', '".$actres['severity']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td><td style=\"cursor:pointer;\" onclick=\"openRetract('". $actres['id'] ."', '". $actres['severity'] ."');\">Retract Severity</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $actres['id'] ."', 'Ticket')\"></td>";
				}
				else{
					$type = "Activities";
					$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ". $actres['description']);
					if($queryTicketDesc)
					{
						$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
						$ticketdesc = $resTicketDesc['name'];
					}
					else
					{
						$ticketdesc =  $actres['description'];
					}
					//$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $actres['description'] ."', '". $ticket_type ."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', 2)\">Close Ticket</td>";
					$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."', '".$actres['severity']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $actres['id'] ."', 'Ticket')\"></td>";
				}
				// $stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."', '".$actres['severity']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td><td>Retract Severity</td>";				
			}
			else
			{
				if($ticket_type == 1){
					$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$actres['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" colspan='2' onclick=\"GenerateReport(".$actres['id'].");\">Generate Report</td><td><img src=\"images/delete.png\" height=\"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $actres['id'] ."', 'Ticket')\"></td>";
				}
				else{
					$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td class=\"addlog\" colspan=\"2\">".$actres['dateclosed']."</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $actres['id'] ."', 'Ticket')\"></td>";
				}
				//$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$actres['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"GenerateReport(".$actres['id'].");\">Generate Report</td>";
			}
			$actlogssql = mysqli_query($conn, "select * from log_mst where ticket = ". $actres['id'] ." order by date_created DESC, time_created DESC");
			$actlogtable = "";
			$lognum = mysqli_num_rows($actlogssql) + 1;
			$rownum = 1;
			while($actlogres = mysqli_fetch_assoc($actlogssql))
			{
				$result1 = mysqli_query($conn, "select * from urc_mst where id = '". $actlogres['urcid'] ."'");
					$urcres = mysqli_fetch_assoc($result1);
				$result2 = mysqli_query($conn, "select * from guard_personnel where id = '". $actlogres['gid'] ."'");
					$guardres = mysqli_fetch_assoc($result2);
				$result3 = mysqli_query($conn, "select * from location_mst where id = '". $actlogres['location'] ."'");
					$locres = mysqli_fetch_assoc($result3);
				$queryEncoder = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ". $actlogres['uid']);
				$resEncoder = mysqli_fetch_assoc($queryEncoder);
				$lognum -= 1;
				
				$remarksid = "remark" . $actlogres['id'];
				$attachmentid = "attachment". $actlogres['id'];
				$attachmentshow = "";
				if(($actlogres['upload1']) || ($actlogres['upload2']) || ($actlogres['upload3']))
				{
					//$attachmentdi = "attachment". $actlogres['id'];
					$attachmentshow .= "<table align=\"center\">";
					if($actlogres['upload1'])
					{
					  $attachmentshow .=   "<tr>
											  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload1'] ."\" /></td>
										   </tr>";
					}
					if($actlogres['upload2'])
					{
					  $attachmentshow .=   "<tr>
											  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload2'] ."\" /></td>
										   </tr>";
					}
					if($actlogres['upload3'])
					{
					  $attachmentshow .=   "<tr>
											  <td align=\"center\"><img style=\"width:75%;\" src=\"". $actlogres['upload3'] ."\" /></td>
										   </tr>";
					}
					$attachmentshow .= "</table>";
				}
				else
				{
					$attachmentshow = "<table align=\"center\">
										 <tr>
											<td align=\"center\">No Attachments</td>
										 </tr>
									   </table>";
				}
				
				if($rownum == 1){
					$rowcolor = "altrows";
					$rownum = 0;
				}
				elseif($rownum == 0){
					$rowcolor = "";
					$rownum = 1;
				}
				$firstfour = array();		
				$firstfourinitial = explode(" ", $actlogres['remarks']);
				for($i = 0; $i <= 3; $i++)
				{
					$firstfour[] = $firstfourinitial[$i];
				}
				$firstfourfinal = implode(" ", $firstfour);
				$actlogtable .= "<tr align=\"center\" class='".$rowcolor."' >
									<td width=\"5%\">". $lognum ."</td>
									<td width=\"20%\">". $locres['location'] ."</td>
									<td width=\"35%\" onclick=\"showLogs('". $remarksid ."')\" style=\"cursor:pointer\">". $firstfourfinal ."...</td>
									<td width=\"10%\">". $actlogres['date_created'] ."</td>
									<td width=\"10%\">". $actlogres['time_created'] ."</td>
									<td width=\"20%\">". $guardres['fname'] ." ". $guardres['lname'] ."</td>
								 </tr>";
				$actlogtable .= "<tr align=\"center\" class='".$rowcolor."' >
									<td width=\"100%\" colspan=\"100%\">
										<div id=\"". $remarksid ."\" class=\"logs2\" style=\"display:none;\">
											<table width=\"70%\">
											<tr>
												<td colspan=\"100%\">
												Narration:
												</td>
											</tr>
											<tr>
												<td align=\"center\" colspan=\"100%\">                                    	
													<textarea style=\"width:95%; height:150px; resize:none\" readonly=\"readonly\" >". $actlogres['remarks'] ."</textarea>
												</td>
											</tr>
											<tr>
												<td align=\"left\">
													<label style=\"text-decoration:underline; cursor:pointer; color:#00F; display:none;\" onclick=\"showAttachments('".$attachmentid."');\" >Show Attachments</label>
												</td>
												<td align=\"right\">
													Encoded by: ".$resEncoder['lname'].", ".$resEncoder['fname']." ".$resEncoder['mi'].".
												</td>
											</tr>
											</table>
											<div id=\"". $attachmentid ."\" style=\"display:none;\">
												".$attachmentshow."
											</div>
										</div>
									</td>
								</tr>";
			}
			if (empty($actlogtable)){
				$actlogtable = "<tr>
									<td align=\"center\" colspan=\"100%\">No log entries</td>
								</tr>";
			}
			$activitylogs = "";
			if($ticket_type == 1){
				$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ". $actres['description']);
				if($queryTicketDesc)
				{
					$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
					$ticketdesc = $resTicketDesc['name'];
				}
				else
				{
					$ticketdesc =  $actres['description'];
				}
				$incidenttable .= "<tr align=\"center\" bgcolor=\"#000000\" style=\"color:#FFF\">
				<td >". $actres['id'] ."</td>
				<td >". $actres['dateadded'] ."</td>
				<td >". ($actres['severity'] == 0 ? $resTicketDesc['defaultlevel'] : $actres['severity']) ."</td>
				<td ><label onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</label><img src=\"images/edit icon 2.png\" align=\"right\" height=\"20px\" onclick=\"changeClassificationOpen(".$actres['id'].")\" style=\"cursor:pointer\" /></td>
				". $stat ."        
				</tr>
				<tr>
				  <td colspan=\"100%\" align=\"center\">
					  <div id=\"". $logid ."\" class=\"logs\" style=\"display:none;\">
						  <table width=\"100%\">
							<tr>
								<th>#</th>
								<th>Location</th>
								<th>Narration</th>
								<th>Date</th>
								<th>Time</th>
								<th>Guard</th>
							</tr>
							". $actlogtable ."
						  </table>
					  </div>
					  
				  </td>
				</tr>";
			}
			else{
				$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ". $actres['description']);
				if($queryTicketDesc)
				{
					$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
					$ticketdesc = $resTicketDesc['name'];
				}
				else
				{
					$ticketdesc =  $actres['description'];
				}
			$activitytable .= "<tr align=\"center\" bgcolor=\"#000000\" style=\"color:#FFF\">
				<td >". $actres['id'] ."</td>
				<td >". $actres['dateadded'] ."</td>
				<td onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</td>
				". $stat ."        
			  </tr>
			  <tr>
				<td colspan=\"100%\" align=\"center\">
					<div id=\"". $logid ."\" class=\"logs\" style=\"display:none;\">
						<table width=\"100%\">
							<tr>
								<th>#</th>
								<th>Location</th>
								<th>Narration</th>
								<th>Date</th>
								<th>Time</th>
								<th>Guard</th>
							</tr>
						  ". $actlogtable ."
						</table>
					</div>
					
				</td>
			  </tr>";
			}
		}
	}
}
elseif($newtype == "Guard")
{
	if(($_SESSION['level'] == 'Admin') && (!$_SESSION['multi-admin']))
	{
		$guardsql2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = ".$bu." ORDER BY CASE bu WHEN ". $bu ." THEN 1 ELSE 2 END, bu, status, lname");
		$guardstable = "";
		$guardnum = 1;
		$guardrow = 0;
		while($guardres3 = mysqli_fetch_assoc($guardsql2)){
			if($guardrow==1){
				$rowclass = "class=\"altrows\"";
				$guardrow = 0;
			}
			elseif($guardrow==0){
				$rowclass = "";
				$guardrow = 1;
			}
			$glastname = $guardres3['lname'];
			$gfirstname = $guardres3['fname'];
			$gmiddlename = $guardres3['mname'];
			$gcontact = $guardres3['contact'];
			$gcode = $guardres3['guard_code'];
			$guardbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ". $guardres3['bu']);
			$guardbures = mysqli_fetch_assoc($guardbusql);
			$guardbu = $guardbures['bu'];
			$gstatus = $guardres3['status'];
		
			$gcomment2 = preg_replace( "/\r|\n/", "<br>", $guardres3['comment'] );
		
			if($guardres3['bu'] == $bu){
				
				$editbtn = "<td><img src=\"images/edit2.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo2(".$guardres3['id'].", 'Edit')\" /></td>";
			}
			else{
				$editbtn = "<td><img src=\"images/Person_details.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['fname']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['mname']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['lname']))) ."', '". trim($guardres3['gender']) ."', '". trim($guardres3['birthdate']) ."', '". trim($guardres3['blood_type']) ."', '". trim($guardres3['civil_status']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['present_address']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['provincial_address']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['contact']))) ."', '". trim($guardbures['bu']) ."', '". trim($guardres3['date_posted']) ."', '". trim($guardres3['agency_employment']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_code']))) ."', '". trim($guardres3['agency']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_category']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['badge_number']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['ntc_license']))) ."', '". trim($guardres3['ntc_license_start']) ."', '". trim($guardres3['ntc_license_end']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['license_number']))) ."', '". trim($guardres3['license_issue_date']) ."', '". trim($guardres3['license_expiry_date']) ."', '". trim($guardres3['performance']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$gcomment2))) ."', 'view', '". trim($guardres3['id']) ."', '".trim($guardres3['status'])."', '".trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_photo'])))."');\" /></td>";
			}
			$guardstable .= "<tr ". $rowclass ." align=\"center\">
								<td>". $guardnum ."</td>
								<td>". $glastname . "</td>
								<td>". $gfirstname . "</td>						
								<td>". $gcode . "</td>						
								<td>". $guardbu . "</td>
								<td>". $gstatus . "</td>
								". $editbtn ."
							 </tr>";
			$guardnum++;
			
		}	
		$guardstable .= "<tr align=''right'><td colspan='100%' align='right'><button class=\"redbutton\" style=\"cursor:pointer;\" onclick=\"fnExcelReport('tblGuards');\">CSV</button></td></tr>";
	}
}

if($newtype == 'Inc')
{
	$resulttable = $incidenttable;
}
elseif($newtype == 'Act')
{
	$resulttable = $activitytable;
}
elseif($newtype == 'Guard')
{
	$resulttable = $guardstable;
}


if($resulttable)
{
	echo $resulttable;
}
else
{
	echo "<tr><td colspan=\"100%\" align=\"center\">No records found. Please check date range and filters.</td></tr>";
}
	


?>