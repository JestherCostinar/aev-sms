<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$ticketid = $_GET['ticket_id'];

$queryRevisions = mysqli_query($conn, "SELECT * FROM logrevision_mst WHERE ticket = ". $ticketid);
$queryRevisions2 = mysqli_query($conn, "SELECT * FROM logrevision_mst WHERE ticket = ". $ticketid ." ORDER BY revision_num DESC");
$resRevisions2 = mysqli_fetch_assoc($queryRevisions2);
$latestRevision = $resRevisions2['revision_num'];
$resRevisions = "";
$revisionlist = "";
$revisionlist2 = "";
$revisedby = "";
$daterevised = "";
$timerevised = "";
$revisionnum = "";
$displayrevisedby = "";
$displaydaterevised = "";
$displaytimerevised = "";
$displayrevisedby2 = "";
$displaydaterevised2 = "";
$displaytimerevised2 = "";
if($queryRevisions)
{	
	while($resRevisions = mysqli_fetch_assoc($queryRevisions))
	{
		$queryGuard = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = ". $resRevisions['gid']);
		$resGuard = mysqli_fetch_assoc($queryGuard);
		$queryEncoder2 = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ". $resRevisions['revised_by']);
		$resEncoder2 = mysqli_fetch_assoc($queryEncoder2);		
		$revisedby = $resEncoder2['lname'].", ".$resEncoder2['fname']." ".$resEncoder2['mi'].".";
		$daterevised = $resRevisions['date_revised'];
		$timerevised = $resRevisions['time_revised'];
		$revisionnum = $resRevisions['revision_num'];
		
		$revisionlog = "<tr align=\"center\">
							<td class=\"revisionsId\" style=\"display:none\">
								".$resRevisions['id']."
							</td>
							<td class=\"revisionsEncoder\" style=\"display:none\">
								".$resRevisions['uid']."
							</td>
							<td class=\"revisionsGuardId\" style=\"display:none\">
								".$resRevisions['gid']."
							</td>
							<td class=\"revisionsTicketId\" style=\"display:none\">
								".$resRevisions['ticket']."
							</td>
							<td class=\"revisionsLogId\" style=\"display:none\">
								".$resRevisions['log_id']."
							</td>
							<td class=\"revisionsDateCreated\">
								".$resRevisions['date_created']."
							</td>
							<td class=\"revisionsTimeCreated\">
								".$resRevisions['time_created']."
							</td>
							<td>
								".$resGuard['lname'].", ".$resGuard['fname']." ".$resGuard['mname']."
							</td>							
							<td>";
							if($latestRevision == 1)
							{									
								$revisionlog .= "<textarea rows=\"4\" class=\"revisionsLogs\" style=\"width:95%; resize:none;\">".$resRevisions['remarks']."</textarea>";
							}
							else
							{
								$revisionlog .= $resRevisions['remarks'];
							}
			$revisionlog .= "</td>
						 </tr>";
		if($revisionnum == 1)
		{
			$revisionlist .= $revisionlog;
			$displaydaterevised = $daterevised;
			$displaytimerevised = $timerevised;
			$displayrevisedby = $revisedby;
		}
		else
		{
			$revisionlist2 .= $revisionlog;
			$displaydaterevised2 = $daterevised;
			$displaytimerevised2 = $timerevised;
			$displayrevisedby2 = $revisedby;
		}
	}
}



$loglist = "";
$queryLogs2 = mysqli_query($conn, "SELECT * FROM log_mst WHERE ticket = ".$ticketid." ORDER BY date_created, time_created");
while($resLogs2 = mysqli_fetch_assoc($queryLogs2))
{
	$queryGuard2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = ". $resLogs2['gid']);
	$resGuard2 = mysqli_fetch_assoc($queryGuard2);
	$queryEncoder = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ". $resLogs2['uid']);
	$resEncoder = mysqli_fetch_assoc($queryEncoder);
	$loglist .= "<tr align=\"center\">
					<td class=\"logsTicketId\" style=\"display:none\">
						".$ticketid."
					</td>
					<td class=\"logsLogId\" style=\"display:none\">
						".$resLogs2['id']."
					</td>
					<td class=\"logsDateCreated\">
						".$resLogs2['date_created']."
					</td>
					<td class=\"logsTimeCreated\">
						".$resLogs2['time_created']."
					</td>
					<td>
						".$resGuard2['lname'].", ".$resGuard2['fname']." ".$resGuard2['mname']."
					</td>
					<td class=\"logsGuardId\" style=\"display:none\">
						".$resLogs2['gid']."
					</td>
					<td>";
					if($revisionlist)
					{
						$loglist .= $resLogs2['remarks'];
					}
					else
					{
						$loglist .= "<textarea class=\"logsRemarks\" rows=\"4\" style=\"width:95%; resize:none;\">".$resLogs2['remarks']."</textarea>";
					}
	$loglist .=    "</td>
					<td>
						".$resEncoder['lname'].", ".$resEncoder['fname']." ".$resEncoder['mi'].".
					</td>
					<td class=\"logsEncoder\" style=\"display:none\">
						".$resLogs2['uid']."
					</td>
				 </tr>";
}






$revisiontable = "<div id=\"divReviseLogEntries\">" .
					"<img src=\"images/x_mark_red.png\" height=\"24px\" style=\"cursor:pointer; position:absolute; right:10px; top:5px;\" onclick=\"CloseRevisions();\" />" .
					"<table align=\"center\">".
						"<tr>" .
							"<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions(".$ticketid.");\" />Disposition</td>" .
							"<td><input type=\"radio\" name=\"editchoice\" checked=\"checked\" onClick=\"OpenRevisions2(".$ticketid.");\" />Logs</td>" .
							"<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions3(".$ticketid.");\" />Person(s) Involved</td>" .
							"<td><input type=\"radio\" name=\"editchoice\"  onClick=\"OpenRevisions4(".$ticketid.");\" />Vehicle(s) Involved</td>" .
						"</tr>" .
					"</table>" .
					"<fieldset style=\"border:none\">
					  <legend><b>Narrative</b> <i>(Original logs)</i></legend>
					  <table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
						  <thead>
							  <tr class=\"blackongray\">
								  <th>Date</th>
								  <th>Time</th>
								  <th>Guard</th>
								  <th width=\"50%\">Incident Logs</th>
								  <th>Encoder</th>
							  </tr>
						  </thead>
						  <tbody>
							  ".$loglist."
						  </tbody>
					  </table>
					</fieldset>
				  </div>";

if($revisionlist)
{
	$revisiontable .= "<br>
					   <div id=\"divReviseRevisionEntries\">
						  <fieldset style=\"border:none\">
							<legend><b>Narrative</b> <i>(Revision #1)<br><u>Last revision on ".$displaydaterevised." ".$displaytimerevised." by ".$displayrevisedby."</u></i></legend>
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
						  </fieldset>
						</div>
						<br>";
						if($revisionlist2)
						{
							$revisiontable .= "<div id=\"divReviseRevisionEntries2\">
												  <fieldset style=\"border:none\">
													<legend><b>Narrative</b> <i>(Revision #2)<br><u>Last revision on ".$displaydaterevised2." ".$displaytimerevised2." by ".$displayrevisedby2."</u></i></legend>
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
												  </fieldset>
												</div>
												<br>";
						}
						
	$revisiontable .= "<table align=\"center\" width=\"100%\" >
							<tr align=\"center\">
								<td>";
								if($latestRevision == 1)
								{
									$revisiontable .= "<img style=\"width:100px; cursor:pointer;\" src=\"images/update.png\" onclick=\"UpdateRevisions();\" />";
								}
								else
								{
									$revisiontable .= "<label style=\"color:red\">Maximum log revision limit reached</label><br>";
								}
									
//	$revisiontable .=	"<img style=\"width:100px; cursor:pointer;\" src=\"images/cancel.png\" onclick=\"CloseRevisions();\" />";
									if($_SESSION['level'] == "User")
									{
										$revisiontable .= "<form id=\"reviselogsform\" name=\"reviselogsform\" action=\"user.php\" method=\"post\">";
									}
									elseif($_SESSION['level'] == "Admin")
									{
										$revisiontable .= "<form id=\"reviselogsform\" name=\"reviselogsform\" action=\"user-admin.php\" method=\"post\">";
									}
									elseif($_SESSION['level'] == "Super Admin")
									{
										$revisiontable .= "<form id=\"reviselogsform\" name=\"reviselogsform\" action=\"user-superadmin.php\" method=\"post\">";
									}
									
				$revisiontable .=  "<input type=\"hidden\" id=\"revisionsIdAll\" name=\"revisionsIdAll\" />
									<input type=\"hidden\" id=\"revisionsLogsAll\" name=\"revisionsLogsAll\" />
									<input type=\"hidden\" id=\"revisionsTicketIdAll\" name=\"revisionsTicketIdAll\" />
									<input type=\"hidden\" id=\"revisionsLogIdAll\" name=\"revisionsLogIdAll\" />
									<input type=\"hidden\" id=\"revisionsDateCreatedAll\" name=\"revisionsDateCreatedAll\" />
									<input type=\"hidden\" id=\"revisionsTimeCreatedAll\" name=\"revisionsTimeCreatedAll\" />
									<input type=\"hidden\" id=\"revisionsGuardIdAll\" name=\"revisionsGuardIdAll\" />									
									<input type=\"hidden\" id=\"revisionsEncoderAll\" name=\"revisionsEncoderAll\" />
									</form>
								</td>
							</tr>
						</table>";
}
else
{
	$revisiontable .= "<br>
						<table align=\"center\" width=\"100%\" >
							<tr align=\"center\">
								<td>
									<img style=\"width:100px;\" src=\"images/update.png\" onclick=\"UpdateLogs();\" />  <img style=\"width:100px;\" src=\"images/cancel.png\" onclick=\"CloseRevisions();\" />";
									if($_SESSION['level'] == "User")
									{
										$revisiontable .= "<form id=\"reviselogsform\" name=\"reviselogsform\" action=\"user.php\" method=\"post\">";
									}
									elseif($_SESSION['level'] == "Admin")
									{
										$revisiontable .= "<form id=\"reviselogsform\" name=\"reviselogsform\" action=\"user-admin.php\" method=\"post\">";
									}
									elseif($_SESSION['level'] == "Super Admin")
									{
										$revisiontable .= "<form id=\"reviselogsform\" name=\"reviselogsform\" action=\"user-superadmin.php\" method=\"post\">";
									}
									
				$revisiontable .=  "<input type=\"hidden\" id=\"logsTicketIdAll\" name=\"logsTicketIdAll\" />
									<input type=\"hidden\" id=\"logsLogIdAll\" name=\"logsLogIdAll\" />
									<input type=\"hidden\" id=\"logsDateCreatedAll\" name=\"logsDateCreatedAll\" />
									<input type=\"hidden\" id=\"logsTimeCreatedAll\" name=\"logsTimeCreatedAll\" />
									<input type=\"hidden\" id=\"logsGuardIdAll\" name=\"logsGuardIdAll\" />
									<input type=\"hidden\" id=\"logsRemarksAll\" name=\"logsRemarksAll\" />
									<input type=\"hidden\" id=\"logsEncoderAll\" name=\"logsEncoderAll\" />
									</form>
								</td>
							</tr>
						</table>";
}



if(!empty($revisiontable))
{
	echo $revisiontable;
}
else
{	
	echo "<tr><td colspan=\"100%\" align=\"center\">No Records</td></tr>";
}

?>