<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$dstart = $_GET['dstart'];
$dend = $_GET['dend'];
$acttype = $_GET['acttype'];
$inctype = $_GET['inctype'];
$urc = $_GET['urc'];
$location = $_GET['loc'];
$guard = $_GET['guard'];
$ticket_type = $_GET['ttype'];
$searchbu = $_GET['sbu'];
$ticket_id = $_GET['tid'];
$username = mysqli_real_escape_string($conn, $_GET['username']);
$lastname = mysqli_real_escape_string($conn, $_GET['lastname']);
$firstname = mysqli_real_escape_string($conn, $_GET['firstname']);
$involved = mysqli_real_escape_string($conn, $_GET['involved']);
$involved_type = $_GET['itype'];

$main_cat = $_GET['main_cat'];
$sub_cat = $_GET['sub_cat'];

$condacttype = "";
$condinctype = "";
$condurc = "";
$condloc = "";
$condguard = "";
$condbu = "";
$condbu2 = "";
$condusername = "";
$condlastname = "";
$condfirstname = "";
$resulttable = "";
$condmaincat = "";
$condsubcat = "";
$condmaincatarray = array();
$condmaincatarraylist = "";
$condsubcatarray = array();
$condsubcatarraylist = "";

$listOfBU = array();

if($_SESSION['multi-admin']) {
	$listOfIDQuery = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id ='" . $_SESSION['id'] . "'");
	$buCount = 0;
	while ($list = mysqli_fetch_assoc($listOfIDQuery)) {
		$listOfBU[$buCount] = $list['bu_id'];
		$buCount++;
	}
}

if(!empty($searchbu) && ($searchbu != 0))
{
	$condbu = " (t.bu = ".$searchbu.") AND ";
	$condbu2 = " (s.bu_id = ".$searchbu.") AND ";
}

if(!empty($acttype) && ($acttype != 0))
{
	$condacttype = " (t.description = ".$acttype.") AND ";
}
else
{
	if(!empty($sub_cat) && ($sub_cat != 0))
	{
		$subcatsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE sub_cat = ". $sub_cat);
		while($subcatres = mysqli_fetch_assoc($subcatsql))
		{
			$condsubcatarray[] = $subcatres['id'];
		}
		$condsubcatarraylist = implode(", ", $condsubcatarray);
		$condsubcat = "t.description IN(".$condsubcatarraylist.") AND ";
	}
	else
	{
		if(!empty($main_cat) && ($main_cat != 0))
		{
			$maincatsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE main_cat = ". $main_cat);
			while($maincatres = mysqli_fetch_assoc($maincatsql))
			{
				$condmaincatarray[] = $maincatres['id'];
			}
			$condmaincatarraylist = implode(", ", $condmaincatarray);
			$condmaincat = "t.description IN(".$condmaincatarraylist.") AND ";
		}
	}
}

if(!empty($inctype) && ($inctype != 0))
{
	$condinctype = " (t.description = ".$inctype.") AND ";
}

if(!empty($urc) && ($urc != 0))
{
	$condurc = " (l.urcid = ".$urc.") AND ";
}
if(!empty($location) && ($location != 0))
{
	$condloc = " (l.location = ".$location.") AND ";
}
if(!empty($guard) && ($guard != 0))
{
	$condguard = " (l.gid = ".$guard.") AND ";
}
if(!empty($username) && ($username != 0))
{
	$condusername = " (u.username LIKE '%".$username."%')";
}
if(!empty($lastname) && ($lastname != 0))
{
	$condlastname = " (u.lname LIKE '%".$lastname."%') ";
}
if(!empty($firstname) && ($firstname != 0))
{
	$condfirstname = " (u.fname LIKE '%".$firstname."%') ";
}
if(!empty($logs) && ($logs != 0))
{
	$condlogs = " (l.urcid = ".$logs.") AND ";
}



$type = "";
$tbltype = "";
$severity = "";
if($ticket_type == 2)
{
	$type = "Activities";
	$tbltype = "entries_activity";
}
elseif($ticket_type ==1)
{
	$type = "Incidents";
	$tbltype = "entries_incident";
	$severity = " t.severity AS severity_level, a.defaultlevel AS level, ";
}

if(!empty($ticket_id) && ($ticket_id != 0))
{
	// Query for the multi admin session
	if(($_SESSION['multi-admin'])  && ($searchbu == 0)) {
		echo '1';		$sql = "SELECT DISTINCT t.*, a.name AS ticketdesc, ".$severity." b.bu AS bu_name FROM ticket t LEFT JOIN log_mst l ON t.id = l.ticket LEFT JOIN ".$tbltype." a ON t.description = a.id LEFT JOIN bu_mst b ON t.bu = b.id WHERE t.id = ".$ticket_id." AND ticket_type = ".$ticket_type." AND t.bu IN (" . implode(',', array_map('intval', $listOfBU)) . ") ORDER BY datesubmitted DESC";
	} else {
		if(!($_SESSION['level'] == "Super Admin"))
	  {
		$sql = "SELECT DISTINCT t.*, a.name AS ticketdesc, ".$severity." b.bu AS bu_name FROM ticket t LEFT JOIN log_mst l ON t.id = l.ticket LEFT JOIN ".$tbltype." a ON t.description = a.id LEFT JOIN bu_mst b ON t.bu = b.id WHERE t.id = ".$ticket_id." AND ticket_type = ".$ticket_type." ORDER BY datesubmitted DESC";
	  } else {
		$sql = "SELECT DISTINCT t.*, a.name AS ticketdesc, ".$severity." b.bu AS bu_name FROM ticket t LEFT JOIN log_mst l ON t.id = l.ticket LEFT JOIN ".$tbltype." a ON t.description = a.id LEFT JOIN bu_mst b ON t.bu = b.id WHERE t.id = ".$ticket_id." AND ticket_type = ".$ticket_type." ORDER BY datesubmitted DESC";
	  }
	}
}
else
{
	// Query for the multi admin session
	if(($_SESSION['multi-admin'])  && ($searchbu == 0)) {
		echo '4';
		$sql = "SELECT DISTINCT t.*, a.name AS ticketdesc, ".$severity." b.bu AS bu_name FROM ticket t LEFT JOIN log_mst l ON t.id = l.ticket LEFT JOIN ".$tbltype." a ON t.description = a.id LEFT JOIN bu_mst b ON t.bu = b.id WHERE ((t.dateadded BETWEEN '".$dstart."' AND '".$dend."') OR  (l.date_created BETWEEN '".$dstart."' AND '".$dend."')) AND ".$condacttype." ".$condsubcat." ".$condmaincat." ".$condurc." ".$condloc." ".$condguard." ticket_type = ".$ticket_type." AND t.bu IN (" . implode(',', array_map('intval', $listOfBU)) . ") ORDER BY datesubmitted DESC";
	} else {
		if(!($_SESSION['level'] == "Super Admin"))
	  {
		$sql = "SELECT DISTINCT t.*, a.name AS ticketdesc, ".$severity." b.bu AS bu_name FROM ticket t LEFT JOIN log_mst l ON t.id = l.ticket LEFT JOIN ".$tbltype." a ON t.description = a.id LEFT JOIN bu_mst b ON t.bu = b.id WHERE ((t.dateadded BETWEEN '".$dstart."' AND '".$dend."') OR  (l.date_created BETWEEN '".$dstart."' AND '".$dend."')) AND ".$condbu." ".$condacttype." ".$condsubcat." ".$condmaincat." ".$condurc." ".$condloc." ".$condguard." ticket_type = ".$ticket_type." ORDER BY datesubmitted DESC";
	  } else {
		$sql = "SELECT DISTINCT t.*, a.name AS ticketdesc, ".$severity." b.bu AS bu_name FROM ticket t LEFT JOIN log_mst l ON t.id = l.ticket LEFT JOIN ".$tbltype." a ON t.description = a.id LEFT JOIN bu_mst b ON t.bu = b.id WHERE ((t.dateadded BETWEEN '".$dstart."' AND '".$dend."') OR  (l.date_created BETWEEN '".$dstart."' AND '".$dend."')) AND ".$condbu." ".$condacttype." ".$condsubcat." ".$condmaincat." ".$condurc." ".$condloc." ".$condguard." ticket_type = ".$ticket_type." ORDER BY datesubmitted DESC";
	  }
	}
}


//$sqlmainticket = mysqli_query($conn, "SELECT DISTINCT t.*, a.name AS ticketdesc FROM ticket t LEFT JOIN log_mst l ON t.id = l.ticket LEFT JOIN ".$tbltype." a ON t.description = a.id WHERE ((t.dateadded BETWEEN '".$dstart."' AND '".$dend."') OR  (l.date_created BETWEEN '".$dstart."' AND '".$dend."')) AND ".$condbu." ".$condacttype." ".$condurc." ".$condloc." ".$condguard." ticket_type = ".$ticket_type) or die(mysqli_error());
$sqlmainticket = mysqli_query($conn, $sql);
	
  while($resmainticket = mysqli_fetch_assoc($sqlmainticket))
  {
	  
	  $sqlmainlog = mysqli_query($conn, "SELECT l.*, 
										 lc.location AS locname, 
										 u.description AS urcdesc, 
										 g.lname AS glname, g.fname AS gfname, g.mname AS gmname, 
										 e.lname AS elname, e.fname AS efname, e.mi AS emi 
										 FROM log_mst l
										 LEFT JOIN location_mst lc ON l.location = lc.id 
										 LEFT JOIN urc_mst u ON l.urcid = u.id 
										 LEFT JOIN guard_personnel g ON l.gid = g.id 
										 LEFT JOIN users_mst e ON l.uid = e.id 
										 WHERE ".$condurc." ".$condloc." ".$condguard." l.ticket =".$resmainticket['id']." ORDER BY date_created DESC, time_created DESC");
	  $actlogtable = "";
	  $lognum = mysqli_num_rows($sqlmainlog) + 1;
	  $rownum = 1;
	  $ticketdesc = "";
	   if($resmainticket['ticketdesc'])
		  {
			  $ticketdesc = $resmainticket['ticketdesc'];
		  }
		  else
		  {
			  $ticketdesc = $resmainticket['description'];
		  }
	  if($sqlmainlog)
	  {
	  while($resmainlog = mysqli_fetch_assoc($sqlmainlog))
	  {
		  $lognum -= 1;		
		  $remarksid = "remark" . $resmainlog['id'];
		  $attachmentid = "attachment". $resmainlog['id'];
		$attachmentshow = "";
		if(($resmainlog['upload1']) || ($resmainlog['upload2']) || ($resmainlog['upload3']))
		{
			//$attachmentdi = "attachment". $actlogres['id'];
			$attachmentshow .= "<table align=\"center\">";
			if($resmainlog['upload1'])
			{
			  $attachmentshow .=   "<tr>
									  <td align=\"center\"><img style=\"width:75%;\" src=\"". $resmainlog['upload1'] ."\" /></td>
								   </tr>";
			}
			if($resmainlog['upload2'])
			{
			  $attachmentshow .=   "<tr>
									  <td align=\"center\"><img style=\"width:75%;\" src=\"". $resmainlog['upload2'] ."\" /></td>
								   </tr>";
			}
			if($resmainlog['upload3'])
			{
			  $attachmentshow .=   "<tr>
									  <td align=\"center\"><img style=\"width:75%;\" src=\"". $resmainlog['upload3'] ."\" /></td>
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
			$firstfourinitial = explode(" ", $resmainlog['remarks']);
			for($i = 0; $i <= 3; $i++)
			{
				$firstfour[] = $firstfourinitial[$i];
			}
			$firstfourfinal = implode(" ", $firstfour);		 
		  $actlogtable .= "<tr align=\"center\" class='".$rowcolor."' >
							  <td width=\"5%\">". $lognum ."</td>
							  <td width=\"20%\">". $resmainlog['locname'] ."</td>
							  <td width=\"35%\" onclick=\"showLogs('". $remarksid ."')\" style=\"cursor:pointer\">". $firstfourfinal ."...</td>
							  <td width=\"10%\">". $resmainlog['date_created'] ."</td>
							  <td width=\"10%\">". $resmainlog['time_created'] ."</td>
							  <td width=\"20%\">". $resmainlog['gfname'] ." ". $resmainlog['glname'] ."</td>
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
										  <td align=\"center\" colspan=\"100%\">                                    	
											  <textarea style=\"width:95%; height:150px; resize:none\" readonly=\"readonly\" >". $resmainlog['remarks'] ."</textarea>
										  </td>
									  </tr>
									  <tr>
									  	  <td align=\"left\">
											  <label style=\"text-decoration:underline; cursor:pointer; color:#00F; display:none;\" onclick=\"showAttachments('".$attachmentid."');\" >Show Attachments</label>
										  </td>
										  <td align=\"right\">Encoded by: ".$resmainlog['elname'].", ".$resmainlog['efname']." ".$resmainlog['emi'].".</td>
									  </tr>
									  </table>
									  <div id=\"". $attachmentid ."\" style=\"display:none;\">
										  ".$attachmentshow."
									  </div>
								  </div>
							  </td>
						  </tr>";
	  }
	  }
	  if($actlogtable)
	  {		
	  }
	  else
	  {
		  $actlogtable = "<tr><td colspan=\"100%\" align=\"center\">No log entries</td></tr>";
	  }
	  $logid = "ticket" . $resmainticket['id'];
	  
	  if ($resmainticket['is_open'] == 1)
	  {
		  if(($_SESSION['level'] == "User") || ($_SESSION['level'] == "Super Admin"))
		  {
			  $stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $resmainticket['id'] ."', '". $resmainticket['dateadded'] ."', '". $ticketdesc ."', '". $resmainticket['description'] ."', '". $ticket_type ."', '".$resmainticket['severity_level']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$resmainticket['id'].", ".$resmainticket['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer;\" onclick=\"Closeticket('". $resmainticket['id'] ."', '". $type . "');\">Close Ticket</td>";
		  }
		  elseif($ticket_type == 2)
		  {
			  $stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $resmainticket['id'] ."', '". $resmainticket['dateadded'] ."', '". $ticketdesc ."', '". $resmainticket['description'] ."', '". $ticket_type ."', '".$resmainticket['severity_level']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$resmainticket['id'].", ".$resmainticket['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer;\" onclick=\"Closeticket('". $resmainticket['id'] ."', '". $type . "');\">Close Ticket</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $resmainticket['id'] ."', 'Ticket')\"></td>";
		  }
		  else
		  {			  
			  $stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $resmainticket['id'] ."', '". $resmainticket['dateadded'] ."', '". $ticketdesc ."', '". $resmainticket['description'] ."', '". $ticket_type ."', '".$resmainticket['severity_level']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$resmainticket['id'].", ".$resmainticket['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer;\" onclick=\"Closeticket('". $resmainticket['id'] ."', '". $type . "');\">Close Ticket</td><td style=\"cursor:pointer;\" onclick=\"openRetract('". $resmainticket['id'] ."', '". $resmainticket['severity'] ."');\">Retract Severity</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $resmainticket['id'] ."', 'Ticket')\"></td>";
		  }
		  
	  }
	  else
	  {
		  if($ticket_type == 1)
		  {
			  if($_SESSION['level'] == "User")
	  		  {
			  	$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$resmainticket['id'].", ".$resmainticket['ticket_type'].")\">Upload/View File(s)</td><td colspan=\"100%\">".$resmainticket['dateclosed']."</td>";
			  }
			  elseif($_SESSION['level'] == "Admin")
			  {
				  $stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$resmainticket['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$resmainticket['id'].", ".$resmainticket['ticket_type'].")\">Upload/View File(s)</td><td colspan='2' style=\"cursor:pointer\" onclick=\"GenerateReport(".$resmainticket['id'].");\">Generate Report</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $resmainticket['id'] ."', 'Ticket')\"></td>";
			  }
			  else
			  {
				  $stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"OpenRevisions(".$resmainticket['id'].");\">Edit Logs</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$resmainticket['id'].", ".$resmainticket['ticket_type'].")\">Upload/View File(s)</td><td colspan='2' style=\"cursor:pointer\" onclick=\"GenerateReport(".$resmainticket['id'].");\">Generate Report</td>";
			  }
		  }
		  else
		  {
			  if(($_SESSION['level'] == "User") || ($_SESSION['level'] == "Super Admin"))
	  		  {
				$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$resmainticket['id'].", ".$resmainticket['ticket_type'].")\">Upload/View File(s)</td><td colspan=\"100%\">".$resmainticket['dateclosed']."</td>";
			  }
			  else
			  {
				$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$resmainticket['id'].", ".$resmainticket['ticket_type'].")\">Upload/View File(s)</td><td colspan=\"2\">".$resmainticket['dateclosed']."</td><td><img src=\"images/delete.png\" height \"20px\" title=\"Request Deletion\" style=\"cursor:pointer;\" onclick=\"openDeletion('". $resmainticket['id'] ."', 'Ticket')\"></td>";
			  }
			  
		  }
	  }
	  
	  $displaybu = "";
	  if(($_SESSION['level'] == "Super Admin") || ($_SESSION['multi-admin']))
	  {
		  $displaybu = "<td>".$resmainticket['bu_name']."</td>";		  
	  }
	   
	  if((($_SESSION['level'] == "Super Admin") || ($_SESSION['level'] == "Admin")) && ($ticket_type == 1))
	  {
		  $changeclassicon = "<img src=\"images/edit icon 2.png\" align=\"right\" height=\"20px\" onclick=\"changeClassificationOpen(".$resmainticket['id'].")\" style=\"cursor:pointer\" />";
	  }
	  else
	  {
		  $changeclassicon = "";
	  }
	  
	  $severitystat = "";
	  if($ticket_type == 1)
	  {
		  $severitystat = "<td >". ($resmainticket['severity'] == 0 ? $resmainticket['level'] : $resmainticket['severity']) ."</td>";		 
	  }
	  
	//   Table for multi admin session
	  if($_SESSION['multi-admin']) {
		$resulttable .= "<tr align=\"center\" bgcolor=\"#000000\" style=\"color:#FFF\">
		<td >". $resmainticket['id'] ."</td>
		<td >". $resmainticket['dateadded'] ."</td>
		".$displaybu."	
		<td ><label onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</label>".$changeclassicon."</td>
		<td style=\"color:#090; font-weight:bold;\">Open</td
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
	  } else {
		$resulttable .= "<tr align=\"center\" bgcolor=\"#000000\" style=\"color:#FFF\">
						  <td >". $resmainticket['id'] ."</td>
						  <td >". $resmainticket['dateadded'] ."</td>
						  ".$displaybu."						  <
						  ".$severitystat."
						  <td ><label onclick=\"showLogs('". $logid ."')\" style=\"cursor:pointer\">". $ticketdesc ."</label>".$changeclassicon."</td>
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


if($resulttable)
{
	echo $resulttable;
}
else
{
	echo "<tr><td colspan=\"100%\" align=\"center\">No records found. Please check date range and filters.</td></tr>";
}