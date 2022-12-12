<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
elseif($_SESSION['level'] != 'User'){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
include("sendmail.php");

$jsrefresh = md5(rand(0,10000));


$sqlDisplayUser = mysqli_query($conn, "SELECT u.*, b.bu AS buname FROM users_mst u LEFT JOIN bu_mst b ON u.bu = b.id WHERE u.id = ".$_SESSION['id']);
$resDisplayUser = mysqli_fetch_assoc($sqlDisplayUser);

$displayUsername = $resDisplayUser['email'];
$displayLevel = $resDisplayUser['level'];
$displayBUName = $resDisplayUser['buname'];

$urcdatalist = "";
$urcsql = mysqli_query($conn, "SELECT * FROM urc_mst ORDER BY series, codes, description");
while($urcres2 = mysqli_fetch_assoc($urcsql)){
	$urcdatalist .= "<option value=\"".$urcres2['id']."\">".$urcres2['codes']." : ". $urcres2['description'] ."</option>";;
}

$locationdatalist = "";
$locationarray = array();
$locsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE bu=$bu ORDER BY location_code");
while($locres2 = mysqli_fetch_assoc($locsql)){
	$locationdatalist .= "<option value=\"".$locres2['id']."\">".$locres2['location_code']." - ".$locres2['location']."</option>";
	$locationarray[] = $locres2['location'];
}

$guardsdatalist = "";
$guardsdatalist2 = "";
$guardsarray = array();
$checkexprosql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$bu);
$checkexprores = mysqli_fetch_assoc($checkexprosql);
$guardbu = $bu;
if($checkexprores['expro'] == 1) //if expro bu, point guard db to expro visayas, id = 24
{
	$guardbu = 24;
}
$guardsql = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu=".$guardbu." ORDER BY lname, fname, mname");
while($guardres2 = mysqli_fetch_assoc($guardsql)){
	$guardsdatalist .= "<option value=\"". $guardres2['lname'] .", ". $guardres2['fname'] . "\"></option>";
	$guardsdatalist2 .= "<option value=\"". $guardres2['id'] . "\">".  $guardres2['lname'] .", ". $guardres2['fname'] ."</option>";
	$guardsarray[] = $guardres2['lname'] .", ". $guardres2['fname'];
}

$secagencytable = "";
$secagencynum = 1;
$secagencyrow = 1;
$secagencydatalist = "";
$secagencysql = mysqli_query($conn,"SELECT * FROM agency_mst ORDER BY agency_name");
while($secagencyres = mysqli_fetch_assoc($secagencysql)){
	$secagencydatalist .= "<option value=\"".$secagencyres['id']."\">".$secagencyres['agency_name']."</option>";
	if($secagencyrow==1){
		$secagerowclass = "class=\"altrows\"";
		$secagencyrow = 0;
	}
	elseif($secagencyrow==0){
		$secagerowclass = "";
		$secagencyrow = 1;
	}
	$secagencyid = $secagencyres['id'];
	$secagencyname = $secagencyres['agency_name'];
	$secagencyaddress = $secagencyres['address'];
	$secagencyoic = $secagencyres['oic'];
	$secagencycontact = $secagencyres['contact_number'];
	$secagencylicensenum = $secagencyres['license)number'];
	$secagencylicenseissued = $secagencyres['license_issued'];
	$secagencylicenseexpiration = $secagencyres['license_expiration'];
//	$secagencyprofile = $secagencyres['company_profile'];
	$secagencyprofile = preg_replace( "/\r|\n/", "<br>", $secagencyres['company_profile'] );
	$secagencycontract = $secagencyres['contract_status'];
	$secagencybulist = array();
	$secagencybunames = "";
	$secagencybusql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE agency_id = ".$secagencyid);
	while($secagencybures = mysqli_fetch_assoc($secagencybusql))
	{
		$agencybunamesql = mysqli_query($conn, "SELECT bu FROM bu_mst WHERE id = ".$secagencybures['bu_id']);
		$agencybuname = mysqli_fetch_assoc($agencybunamesql);
		$secagencybulist[] = $agencybuname['bu'];
	}
	$secagencybunames = implode(", ", $secagencybulist);
//	$secagencybulist = implode(", ", $secagencybures);
	$secagencytable .= "<tr align=\"center\" ".$secagerowclass.">" .
							"<td>".$secagencynum."</td>" .
							"<td>".$secagencyname."</td>" .
							"<td>".$secagencyaddress."</td>" .
							"<td>".$secagencyoic."</td>" .
							"<td>".$secagencycontact."</td>" .
							"<td>".$secagencybunames."</td>" .
							"<td>".$secagencycontract."</td>" .
							"<td><img src=\"images/View_Details.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"viewAgency('".$secagencyid."', '".$secagencyname."', '".$secagencyaddress."', '".$secagencyoic."', '".$secagencycontact."', '".$secagencyres['license_number']."', '".$secagencyres['license_issued']."', '".$secagencyres['license_expiration']."', '".$secagencyprofile."', '".$secagencyres['contract_status']."')\"></td>";
	$secagencynum++;					
}

$activityentriesdatalist = "";
$activityentriestable = "";
$activityentriesnum = 1;
$exprochecksql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ". $bu);
$exprocheckres = mysqli_fetch_assoc($exprochecksql);
$activityentriessql = mysqli_query($conn, "SELECT * FROM entries_activity WHERE status = 'Active' ORDER BY name");
while($activityentriesres = mysqli_fetch_assoc($activityentriessql))
{
	if(($exprocheckres['expro'] == 1) && ($activityentriesres['expro'] == 1))
	{
		$activityentriesdatalist .= "<option value=\"".$activityentriesres['id']."\">".$activityentriesres['name']."</option>";
	}
	elseif(($exprocheckres['expro'] == 0) && ($activityentriesres['expro'] == 0))
	{
		$activityentriesdatalist .= "<option value=\"".$activityentriesres['id']."\">".$activityentriesres['name']."</option>";
	}
	
	$activityentriestable .= "<tr align=\"center\">" .
						"<td>".$activityentriesnum."</td>" .
						"<td>".$activityentriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$activityentriesres['id']."', '".$activityentriesres['name']."', 'Activity');\"></td>" .
						"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$activityentriesres['id']."', 'ActivityInput');\" /></td>" .
					 "</tr>";
	$activityentriesnum++;
}

$incidententriesdatalist = "";
$incidententriestable = "";
$incidententriesnum = 1;
$incidententriessql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE status = 'Active' ORDER BY name");
while($incidententriesres = mysqli_fetch_assoc($incidententriessql))
{
	$incidententriesdatalist .= "<option value=\"".$incidententriesres['id']."\" title=\"".$incidententriesres['id']."\">".$incidententriesres['name']."</option>";
	$incidententriestable .= "<tr align=\"center\">" .
						"<td>".$incidententriesnum."</td>" .
						"<td>".$incidententriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$incidententriesres['id']."', '".$incidententriesres['name']."', 'Incident');\"></td>" .
						"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$incidententriesres['id']."', 'IncidentInput');\" /></td>" .
					 "</tr>";
	$incidententriesnum++;
}

$exproentriesdatalist = "";
$exproentriestable = "";
$exproentriesnum = 1;
$exproentriessql = mysqli_query($conn, "SELECT * FROM entries_expro ORDER BY name");
while($exproentriesres = mysqli_fetch_assoc($exproentriessql))
{
	$exproentriesdatalist .= "<option value=\"".$exproentriesres['id']."\">".$exproentriesres['name']."</option>";
	$exproentriestable .= "<tr align=\"center\">" .
						"<td>".$exproentriesnum."</td>" .
						"<td>".$exproentriesres['name']."</td>" .
						"<td><img src=\"images/edit2.png\" height=\"24px\" style=\"cursor:pointer;\" onclick=\"editInputEntries('".$exproentriesres['id']."', '".$exproentriesres['name']."', 'EXPRO');\"></td>" .
						"<td><img src=\"images/delete.png\" height=\"20px\" title=\"Delete Location\" style=\"cursor:pointer;\" onclick=\"deleteItem('".$exproentriesres['id']."', 'EXPROInput');\" /></td>" .
					 "</tr>";
	$exproentriesnum++;
}

$userid = $rowuser['id'];
$userlname = $rowuser['lname'];
$userfname = $rowuser['fname'];
$username = $rowuser['email'];
$userpassword = $rowuser['password'];
$usergender = $rowuser['gender'];
$usercontact = $rowuser['contact'];

if($_POST)
{
	if((isset($_POST['txturc'])) && !empty($_POST['txturc']))
	{
		if((isset($_POST['txtOrigin'])) && !empty($_POST['txtOrigin']))
		{
			$gid = $_POST['txtguard'];
			$locid = $_POST['txtlocation'];
			$origin = $_POST['txtOrigin'];
			if($origin==1){  //if incident ticket is new / create incident ticket
				$ticketdescription = mysqli_real_escape_string($conn, $_POST['ticketName2']);
				$ticketdateadded = $_POST['ticketDate2'];
				$defaultseveritysql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$ticketdescription)or die(mysqli_error($conn));
				$defaultseverityres = mysqli_fetch_assoc($defaultseveritysql);
				mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted, location, responding_guard, severity) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 1, now(), '".$locid."', '".$gid."', '".$defaultseverityres['defaultlevel']."')")or die(mysqli_error($conn));
				
				$get_last_id2 = mysqli_fetch_array(mysqli_query($conn, "Select id from ticket order by id desc"));
				$ticket = $get_last_id2['id'];

				$uploadArray = array();
				$attached_files = array();
				$i2 = 0;
				foreach ($_FILES['attach1']['name'] as $attach) {
					if ($attach == "") {
						$path = "";
					} else {
						$path =  "upload/" . $ticket . "-" . $attach;
					}

					if ($path) {
						date_default_timezone_set('Asia/Manila');
						$datenow2 = date('Y-m-d H:i:s');
						mysqli_query($conn, "INSERT INTO upload_mst(ticket_id, upload_path, uploaded_by, date_uploaded) VALUES(" . $ticket . ", '" . $path . "', " . $_SESSION['id'] . ", '" . $datenow2 . "')") or die(mysqli_error($conn));
						$uploadArray[] = $path;
						$attached_files[] = $path;
					}

					@copy($_FILES['attach1']['tmp_name'][$i2], $path);
					$i2++;
				}

				mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Created incident ticket #".$ticket."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
			}
			elseif($origin==0){ //incident ticket is existing / just add logs
				$ticket = $_POST['txtLogId'];
			}
		}
			// Determine severity start
			$severityarray = array();
			$severitysql = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$ticket);
			$severityres = mysqli_fetch_assoc($severitysql);
			if($severityres['ticket_type'] == 1)
			{
				$severityarray[] = $severityres['severity'];
				$severityfactors = $severityres['factors'];
				$inctypesql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$severityres['description']);
				$inctyperes = mysqli_fetch_assoc($inctypesql);
				$severityarray[] = $inctyperes['defaultlevel'];
				$incInjury = $_POST['txtinjury'];
				$incPropDmg = $_POST['txtpropdmg'];
				$incPropLoss = $_POST['txtproploss'];
				$incWorkStop = $_POST['txtworkstop'];
				$incDeath = $_POST['txtdeath'];
				
				if($incInjury == 1)
				{
					$severityarray[] = $inctyperes['injury_minor'];
					
					if($severityfactors)
					{
						if((strpos($severityfactors, "Minor Injury")) || (strpos($severityfactors, "Serious Injury")))
						{
							
						}
						else
						{
							$severityfactors .= ", Minor Injury";
						}
					}
					else
					{
						$severityfactors .= "- Minor Injury";
					}
					
					
				}
				elseif($incInjury == 2)
				{
					$severityarray[] = $inctyperes['injury_serious'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Serious Injury"))
						{
							
						}
						elseif(strpos($severityfactors, "Minor Injury"))
						{
							$severityfactors = str_replace("Minor Injury", "Serious Injury", $severityfactors);
						}
						else
						{
							$severityfactors .= ", Serious Injury";
						}
					}
					else
					{
						$severityfactors .= "- Serious Injury";
					}
					
				}
				
				if($incPropDmg == 1)
				{
					$severityarray[] = $inctyperes['propertydmg_nc'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Damage to Property"))
						{
							
						}
						else
						{
							$severityfactors .= ", Damage to Property";
						}
					}
					else
					{
						$severityfactors .= "- Damage to Property";
					}
				}
				elseif($incPropDmg == 2)
				{
					$severityarray[] = $inctyperes['propertydmg_crit'];
					if($severityfactors)
					{
						if(strpos($severityfactors, "Damage to Property"))
						{
							if(strpos($severityfactors, "Critical Damage to Property"))
							{
								
							}
							else
							{
								$severityfactors = str_replace("Damage to Property", "Critical Damage to Property", $severityfactors);
							}
						}
						else
						{
							$severityfactors .= ", Critical Damage to Property";
						}
					}
					else
					{
						$severityfactors .= "- Critical Damage to Property";
					}
				}
				
				if($incPropLoss == 1)
				{
					$severityarray[] = $inctyperes['propertyloss_nc'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Loss of Property"))
						{
							
						}
						else
						{
							$severityfactors .= ", Loss of Property";
						}
					}
					else
					{
						$severityfactors .= "- Loss of Property";
					}
				}
				elseif($incPropLoss == 2)
				{
					$severityarray[] = $inctyperes['propertyloss_crit'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Loss of Property"))
						{
							if(strpos($severityfactors, "Critical Loss of Property"))
							{
								
							}
							else
							{
								$severityfactors = str_replace("Loss of Property", "Critical Loss of Property", $severityfactors);
							}
						}
						else
						{
							$severityfactors .= ", Critical Loss of Property";
						}
					}
					else
					{
						$severityfactors .= "- Critical Loss of Property";
					}
				}
				
				if($incWorkStop == 1)
				{
					$severityarray[] = $inctyperes['workstoppage'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Work Stoppage"))
						{
							
						}
						else
						{
							$severityfactors .= ", Work Stoppage";
						}
					}
					else
					{
						$severityfactors .= "- Work Stoppage";
					}
				}
				
				if($incDeath == 1)
				{
					$severityarray[] = $inctyperes['death_1'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Death"))
						{
							
						}
						else
						{
							$severityfactors .= ", Death";
						}
					}
					else
					{
						$severityfactors .= "- Death";
					}
				}
				elseif($incDeath == 2)
				{
					$severityarray[] = $inctyperes['death_2'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Death"))
						{
							if(strpos($severityfactors, "Multiple Deaths"))
							{
								
							}
							else
							{
								$severityfactors = str_replace("Death", "Multiple Deaths", $severityfactors);
							}
						}
						else
						{
							$severityfactors .= ", Multiple Deaths";
						}
					}
					else
					{
						$severityfactors .= "- Multiple Deaths";
					}
				}
				elseif($incDeath == 3)
				{
					$severityarray[] = $inctyperes['death_3'];
					
					if($severityfactors)
					{
						if(strpos($severityfactors, "Death"))
						{
							if(strpos($severityfactors, "Multiple Deaths"))
							{
								
							}
							else
							{
								$severityfactors = str_replace("Death", "Multiple Deaths", $severityfactors);
							}
						}
						else
						{
							$severityfactors .= ", Multiple Deaths";
						}
					}
					else
					{
						$severityfactors .= "- Multiple Deaths";
					}
				}
				
				$severityarray[] = 0;
				$currentseverity = max($severityarray);			
			
				mysqli_query($conn, "UPDATE ticket SET severity = ".$currentseverity.", factors = '".$severityfactors."' WHERE id = ".$ticket)or die(mysqli_error($conn));
			}
			
			// Determine severity end
			
			$gid = $_POST['txtguard'];
			$locid = $_POST['txtlocation'];
			$uid = $_SESSION['id'];
			$urcid = $_POST['txturc'];
			$date_created = $_POST['date'];
			$time_created = $_POST['time'];
			$remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
			$log_type = $_POST['txtLogType'];
			$oic = (!empty($_POST['sendtobu']))? $_POST['sendtobu']:0;
			
			mysqli_query($conn, "insert into log_mst(uid, urcid, date_created, time_created, gid, remarks, bu, main_group, regional_group, location, ticket, oic, datesubmitted) values('".$uid."','".$urcid."','".$date_created."','".$time_created."','".$gid."','".$remarks."','".$bu."','".$rowUrl['main_group']."','".$rowUrl['regional_group']."','".$locid."','".$ticket."',".$oic.",now())") or die(mysqli_error($conn));
			
			
			//$lid = mysqli_insert_id();
			$get_last_id = mysqli_fetch_array(mysqli_query($conn, "Select id from log_mst order by id desc"));
			$lid = $get_last_id['id'];
			//system log
			//logbook("Added entry to logbook");
			mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added logbook entry #".$lid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
			
			$i=1;
			$i2=0;
			foreach($_FILES['attach']['name'] as $attach){
			  if($attach == ""){
			  $path = "" ;
			  }else{
			  $path =  "upload/".$lid."-".$attach;
			  }
			  mysqli_query($conn, "update log_mst set upload$i = '$path' where id = $lid");
			  @copy($_FILES['attach']['tmp_name'][$i2],$path);
			  $i++;
			  $i2++;
			}
			$mailtest = "NotApplicable";
			$alertdesc = "";
			if($oic==1)
			{
				$sqlemailticket = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$ticket);
				$resemailticket = mysqli_fetch_assoc($sqlemailticket);
				$sqlemaillog = mysqli_query($conn, "SELECT l.date_created, l.time_created, b.bu, b.bu_code, lc.location_code, lc.location, l.remarks, g.lname AS glname, g.fname AS gfname, g.mname AS gmname, l.upload1, l.upload2, l.upload3, u.fname AS ufname, u.mi AS umi, u.lname AS ulname, ur.codes AS urccode, ur.description AS urcdesc FROM log_mst l LEFT JOIN bu_mst b ON l.bu = b.id LEFT JOIN location_mst lc ON l.location = lc.id LEFT JOIN guard_personnel g ON l.gid = g.id LEFT JOIN users_mst u ON l.uid = u.id LEFT JOIN urc_mst ur ON l.urcid = ur.id WHERE l.id = ".$lid);
				$resemaillog = mysqli_fetch_assoc($sqlemaillog);
				
				if($resemailticket['ticket_type'] == 1)
				{
					$sqldesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$resemailticket['description']);
					$resdesc = mysqli_fetch_assoc($sqldesc);
					$alertdesc = "INCIDENT";
				}
				elseif($resemailticket['ticket_type'] == 2)
				{
					$sqldesc = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ".$resemailticket['description']);
					$resdesc = mysqli_fetch_assoc($sqldesc);
					$alertdesc = "ACTIVITY";
				}
				
				$what = "";
				if($resdesc['name'])
				{
					$what = $resdesc['name'];
				}
				else
				{
					$what = $resemailticket['description'];
				}
				
				$bucontrolnum = $resemaillog['bu_code'].'-'.str_replace("-", "", $resemailticket['dateadded']).'-'.$resemailticket['id'];
				$emaildatecreated = strtotime($resemaillog['date_created']);
				$emaildatecreated2 = date('j F Y', $emaildatecreated);				
				
 			/*	$upload1 = '<a href="'.$url_base.'/'.$resemaillog['upload1'].'">'.$resemaillog['upload1'].'</a>';
				$upload2 = '<a href="'.$url_base.'/'.$resemaillog['upload2'].'">'.$resemaillog['upload2'].'</a>';
				$upload3 = '<a href="'.$url_base.'/'.$resemaillog['upload3'].'">'.$resemaillog['upload3'].'</a>'; */
				$upload1 = $resemaillog['upload1'];
				$upload2 = $resemaillog['upload2'];
				$upload3 = $resemaillog['upload3'];
				
				$to = "";
				$to2 = "";
				$recipients = array();
				$escalate = array();
				$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$resemailticket['bu']);
				while($resoic = mysqli_fetch_assoc($sqloic))
				{					
					if($resoic['slevel'] <= 1)
					{
						$recipients[] = $resoic['email_ad'];
					}
					elseif($resoic['slevel'] <= $currentseverity)
					{
						$escalate[] = $resoic['email_ad'];
					}
				}
					
					$to = implode("*~", $recipients);
					$to2 = implode("*~", $escalate);
					if($alertdesc == "INCIDENT")
					{
						$subject = 'SECURITY '.$alertdesc.' LEVEL '.$currentseverity.': '.$what.' '.$bucontrolnum;
						$subheader = '<h3 style="margin-top:0px;">ALERT LEVEL '.$currentseverity.'</h3>';
						$locdisp = '-> '.$resemaillog['location'];
					}
					else
					{
						$subject = 'SECURITY '.$alertdesc.' REPORT: '.$what.' '.$bucontrolnum;
						$subheader = "";
						$locdisp = '';
					}
					
					$narrative = preg_replace( "/\r|\n/", "<br>", $resemaillog['remarks'] );
					$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
									<tr align="center">
										<td colspan="100%" align="center">
											<h2 style="margin-bottom:0px;">'.$alertdesc.' REPORT</h2>
											'.$subheader.'
										</td>
									</tr>
									<tr>
										<td colspan="100%">
											<table align="center" width="80%" style="border-collapse:collapse;" cellpadding="5px" >                                           											
												<tr>                          
													<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >WHAT:</td>
													<td style=" padding-left:20px; padding-right:20px;" >'.$what.'</td>
												</tr>
												<tr>                          
													<td width="15%" style="text-align: right; font-weight: bold;">WHERE:</td>
													<td style=" padding-left:20px; padding-right:20px;">'.$resemaillog['bu'].' '.$locdisp.'</td>
												</tr>                      
												<tr>                          
													<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
													<td style=" padding-left:20px; padding-right:20px;"> '.$resemaillog['time_created'].', '.$emaildatecreated2.'</td>
												</tr>
												<tr>
													<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">NARRATIVE:</td>
													<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($narrative).'</td>
												</tr>											  
												<tr>
													<td width="15%" style="text-decoration:underline; text-align: right;">Reported by:</td>
													<td style=" padding-left:20px; padding-right:20px;">'.$resemaillog['glname'].', '.$resemaillog['gfname'].' '.$resemaillog['gmname'].'</td>
												</tr>
												<tr>
													<td width="15%" style="text-decoration:underline; text-align: right;">Encoded by:</td>
													<td style=" padding-left:20px; padding-right:20px;">'.$resemaillog['ulname'].', '.$resemaillog['ufname'].' '.$resemaillog['umi'].'</td>
												</tr>												
											</table>
										</td>
									</tr>
								 </table>';
					
					$headers  = "MIME-Version: 1.0 " . "\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
					$headers .= "From: INHOUSE SECURITY ALERT <no-reply@aboitiz.com>";
									
					// Mail it
					
				// $sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$resemailticket['bu']);	
				// while($resoic = mysqli_fetch_assoc($sqloic))
				// {					
					//$mail = send_mail($resoic['email_ad'],$subject,$mainbody);
					//$mail = send_mail2($resoic['email_ad'],$subject,$mainbody,$upload1,$upload2,$upload3);
					$mail = send_mail3($to,$subject,$mainbody,$upload1,$upload2,$upload3, $to2, $attached_files);
					if($mail)
						{
							$mailtest = "SUCCESS";
						}
						else
						 {
							 $mailtest = "FAILED";
						 }
				//}
					// if (!empty($to))
					// {
						// ini_set("SMTP","192.168.2.54");
						// ini_set("smtp_port","25");
						// $mail = @mail($to, $subject, $mainbody, $headers);
						
						// mail($to, $subject, $mainbody, $headers);
						// if($mail)
						// {
							// $mailtest = "SUCCESS";
						// }
						// else
						// {
							// $mailtest = "FAILED";
						// }
					// }
				
			}
			if($log_type==1){				
				header("Location: user.php?last=Incidents&mail=".$mailtest);
			}
			elseif($log_type==2){
				header("Location: user.php?last=Activities&mail=".$mailtest);
			}
			
	}
	elseif((isset($_POST['txtactivityname'])) && !empty($_POST['txtactivityname']))
	{
		$ticketdescription = mysqli_real_escape_string($conn, $_POST['txtactivityname']);
		$ticketdateadded = $_POST['txtactivitydate'];
		mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 2, now())");
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Created incident ticket', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user.php?last=Activities");
	}
	//elseif((isset($_POST['txtincidentname'])) && !empty($_POST['txtincidentname']))
//	{
//		$ticketdescription = mysqli_real_escape_string($conn, $_POST['txtincidentname']);
//		$ticketdateadded = $_POST['txtincidentdate'];
//		mysqli_query($conn, "INSERT INTO ticket (description, bu, is_open, dateadded, ticket_type, datesubmitted) values('".$ticketdescription."', '".$bu."', 1, '".$ticketdateadded."', 1, now())");
//		header("Location: user.php?last=Incidents");
//	}
	elseif(!empty($_POST['btnUpload']))
	{
		$uploadId = $_POST['txtUploadTicketId'];
		$mailok = (!empty($_POST['uploadtobu']))? $_POST['uploadtobu']:0;
		
		$uploadArray = array();
		$i2=0;
		foreach($_FILES['attach1']['name'] as $attach){
			if($attach == ""){
				$path = "" ;
			}
			else{
				$path =  "upload/".$uploadId."-".$attach;
			}
			
			if($path)
			{
				date_default_timezone_set('Asia/Manila');
				$datenow2 = date('Y-m-d H:i:s');
				mysqli_query($conn, "INSERT INTO upload_mst(ticket_id, upload_path, uploaded_by, date_uploaded) VALUES(".$uploadId.", '".$path."', ".$_SESSION['id'].", '".$datenow2."')")or die(mysqli_error($conn));
				$uploadArray[] = $path;
			}
			
			@copy($_FILES['attach1']['tmp_name'][$i2],$path);		
			$i2++;
		}
		$uploadinfosql = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$uploadId)or die(mysqli_error($conn));
		$uploadinfores = mysqli_fetch_assoc($uploadinfosql);
		$mailtest = "NotApllicable";
		
		if(($mailok == 1) && ($uploadArray))
		{			
			$alertdesc = "";
			$what = "";
			if($uploadinfores['ticket_type'] == 2)
			{
				$alertdesc = "ACTIVITY";
				$whatsql = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ".$uploadinfores['description']);
				$whatres = mysqli_fetch_assoc($whatsql);
				$what = $whatres['name'];
			}
			elseif($uploadinfores['ticket_type'] == 1)
			{
				$alertdesc = "INCIDENT";
				$whatsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$uploadinfores['description']);
				$whatres = mysqli_fetch_assoc($whatsql);
				$what = $whatres['name'];
			}
			
			$to = "";
			$to2 = "";
			$recipients = array();
			$escalate = array();
			$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$uploadinfores['bu'])or die(mysqli_error($conn));
			while($resoic = mysqli_fetch_assoc($sqloic))
			{
				if($resoic['slevel'] <= 1)
				{
					$recipients[] = $resoic['email_ad'];
				}
				elseif($resoic['slevel'] <= $uploadinfores['severity'])
				{
					$escalate[] = $resoic['email_ad'];
				}
			}
			
			$uploadbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$uploadinfores['bu'])or die(mysqli_error($conn));
			$uploadbures = mysqli_fetch_assoc($uploadbusql);
			
			$bucontrolnum = $uploadbures['bu_code'].'-'.str_replace("-", "", $uploadinfores['dateadded']).'-'.$uploadinfores['id'];
						
			$get_last_date = mysqli_fetch_array(mysqli_query($conn, "SELECT date_uploaded FROM upload_mst ORDER BY id DESC"));
			$lid = strtotime($get_last_date['date_uploaded']);
			$emaildatecreated2 = date('h:i:sa, j F Y', $lid);
			
			$getlocationsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ".$uploadinfores['location']);
			$getlocationres = mysqli_fetch_array($getlocationsql);
				
			$to = implode("*~", $recipients);
			$to2 = implode("*~", $escalate);
			$uploads = implode("*~", $uploadArray);
			$subject = "";
			if($alertdesc == "INCIDENT")
			{
				$subject = 'SECURITY '.$alertdesc.' LEVEL '.$uploadinfores['severity'].': '.$what.' '.$bucontrolnum;
				$subheader = '<h3 style="margin-top:0px;">ALERT LEVEL '.$uploadinfores['severity'].'</h3>';
				$locdisp = '-> '.$getlocationres['location'];
			}
			else
			{
				$subject = 'SECURITY '.$alertdesc.' REPORT: '.$what.' '.$bucontrolnum;
				$subheader = "";
				$locdisp = "";
			}
			
			//$narrative = preg_replace( "/\r|\n/", "<br>", $resemaillog['remarks'] );
			$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
							<tr align="center">
								<td colspan="100%" align="center">
									<h2 style="margin-bottom:0px;">'.$alertdesc.' REPORT</h2>
									'.$subheader.'
								</td>
							</tr>
							<tr>
								<td colspan="100%">
									<table align="center" width="80%" style="border-collapse:collapse;" cellpadding="5px" >                                           											
										<tr>                          
											<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >WHAT:</td>
											<td style=" padding-left:20px; padding-right:20px;" >'.$what.'</td>
										</tr>
										<tr>                          
											<td width="15%" style="text-align: right; font-weight: bold;">WHERE:</td>
											<td style=" padding-left:20px; padding-right:20px;">'.$uploadbures['bu'].' '.$locdisp.'</td>
										</tr>                      
										<tr>                          
											<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
											<td style=" padding-left:20px; padding-right:20px;"> '.$emaildatecreated2.'</td>
										</tr>
										<tr>
											<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">UPDATE:</td>
											<td style=" padding-left:20px; padding-right:20px;">'.count($uploadArray).' file(s) attached to ticket.</td>
										</tr>											  
										<tr>
											<td width="15%" style="text-decoration:underline; text-align: right;">Uploaded by:</td>
											<td style=" padding-left:20px; padding-right:20px;">'.$userfull.'</td>
										</tr>																					
									</table>
								</td>
							</tr>
						 </table>';
				
				$mail = send_mail6($to,$subject,$mainbody,$uploads,$to2);
					if($mail)
						{
							$mailtest = "SUCCESS";
						}
						else
						 {
							 $mailtest = "FAILED";
						 }
		}
		if($uploadinfores['ticket_type'] == 1)
		{
			header("Location: user.php?last=Incidents&mail=".$mailtest);
		}
		elseif($uploadinfores['ticket_type'] == 2)
		{
			header("Location: user.php?last=Activities&mail=".$mailtest);
		}
		
	}
	elseif((isset($_POST['newpass'])) && !empty($_POST['newpass']))
	{
		$newpass = mysqli_real_escape_string($conn, $_POST['newpass']);
		mysqli_query($conn, "UPDATE users_mst SET password = '". md5($newpass) ."' WHERE id = ". $userid);
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Changed password', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user.php?last=Profile");		
	}
	elseif((isset($_POST['usercontactnew'])) && !empty($_POST['usercontactnew']))
	{
		$newcontact = mysqli_real_escape_string($conn, $_POST['usercontactnew']);
		mysqli_query($conn, "UPDATE users_mst SET contact = '". $newcontact ."' WHERE id = ". $userid);
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Changed contact number to ".$newcontact."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		header("Location: user.php?last=Profile");
	}
	//elseif((isset($_POST['witfname'])) && !empty($_POST['witfname']))
//				{
//				$wFirstName = mysqli_real_escape_string($conn, $_POST['witfname']);
//				$wMiddleName = mysqli_real_escape_string($conn, $_POST['witmname']);
//				$wLastName = mysqli_real_escape_string($conn, $_POST['witlname']);
//				$wRemark = mysqli_real_escape_string($conn, $_POST['witremarks']);
//				$wAddress = mysqli_real_escape_string($conn, $_POST['witadd']);
//				$wAge = mysqli_real_escape_string($conn, $_POST['witage']);
//				$wGender = mysqli_real_escape_string($conn, $_POST['witgender']);
//				$wHeight = mysqli_real_escape_string($conn, $_POST['witheight']);
//				$wWeight = mysqli_real_escape_string($conn, $_POST['witweight']);
//				$swid = $_POST['swid'];
//				$witsql = "INSERT INTO incident_witness(FirstName, MiddleName, LastName, Remark, logId, dateCreated, Address, Age, Gender, Height, Weight) values('". $wFirstName. "', '". $wMiddleName ."', '". $wLastName ."', '". $wRemark ."', ". $swid .", now(), '". $wAddress ."', ". $wAge .", '". $wGender ."', ". $wHeight .", ". $wWeight .")";
//				mysqli_query($conn, $witsql) or die(mysqli_error());
//				mysqli_query($conn, "INSERT INTO incident_witness(FirstName, MiddleName, LastName, Remark, logId, dateCreated, Address, Age, Gender, Height, Weight) values('".$wFirstName."', '".$wMiddleName."', '".$wLastName."', '".$wRemark."', ".$swid.", now(), '".$wAddress."', '".$wAge."', '".$wGender."', '".$wHeight."', '".$wWeight."')") or die(mysqli_error());
//					if($_POST['syesno'] == 1){
//						$sFirstName = mysqli_real_escape_string($conn, $_POST['suspfname']);
//						$sMiddleName = mysqli_real_escape_string($conn, $_POST['suspmname']);
//						$sLastName = mysqli_real_escape_string($conn, $_POST['susplname']);
//						$sRemark = mysqli_real_escape_string($conn, $_POST['suspremarks']);
//						$sAddress = mysqli_real_escape_string($conn, $_POST['suspadd']);
//						$sAge = mysqli_real_escape_string($conn, $_POST['suspage']);
//						$sGender = mysqli_real_escape_string($conn, $_POST['suspgender']);
//						$sHeight = mysqli_real_escape_string($conn, $_POST['suspheight']);
//						$sWeight = mysqli_real_escape_string($conn, $_POST['suspweight']);
//						mysqli_query($conn, "INSERT INTO incident_suspect(FirstName, MiddleName, LastName, Remark, logId, dateCreated, Address, Age, Gender, Height, Weight) values('$sFirstName', '$sMiddleName', '$sLastName', '$sRemark', ". $swid .", now(), '$sAddress', $sAge, '$sGender', $sHeight, $sWeight)");
//					}
//					mysqli_query($conn, "UPDATE ticket SET is_open = 0 WHERE id = ". $swid);
//					header("Location: user.php?last=Incidents");
//				}
	elseif((isset($_POST['txtIncidentDisposition'])) && !empty($_POST['txtIncidentDisposition']))
	{
		$logId2 = $_POST['swid'];
		
		if((isset($_POST['ifnamesall'])) && !empty($_POST['ifnamesall']))
		{
			$iclassificationsall = explode("*~", $_POST['iclassificationsall']);
			$ifnamesall = explode("*~", $_POST['ifnamesall']);
			$imnamesall = explode("*~", $_POST['imnamesall']);
			$ilnamesall = explode("*~", $_POST['ilnamesall']);
			$iaddressall = explode("*~", $_POST['iaddressall']);
			$icontactsall = explode("*~", $_POST['icontactsall']);
			$iageall = explode("*~", $_POST['iageall']);
			$igenderall = explode("*~", $_POST['igenderall']);
			$iheightall = explode("*~", $_POST['iheightall']);
			$iweightall = explode("*~", $_POST['iweightall']);
			$iremarksall = explode("*~", $_POST['iremarksall']);
			$iidtypeall = explode("*~", $_POST['iidtypeall']);
			$iidnumberall = explode("*~", $_POST['iidnumberall']);
			$ilocatorsall = explode("*~", $_POST['ilocatorsall']);
			for($i=1, $count = count($ifnamesall);$i<$count;$i++) {
				$iage = (!empty($iageall[$i]))? mysqli_real_escape_string($conn,$iageall[$i]):0;
				$iheight = (!empty($iheightall[$i]))? mysqli_real_escape_string($conn,$iheightall[$i]):0;
				$iweight = (!empty($iweightall[$i]))? mysqli_real_escape_string($conn,$iweightall[$i]):0;
				$ilocator = (!empty($ilocatorsall[$i]))? mysqli_real_escape_string($conn,$ilocatorsall[$i]):0;
			  //mysqli_query($conn, "INSERT INTO incident_witness (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$iwfnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwmnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwlnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwaddressall[$i])."', '".mysqli_real_escape_string($conn,$iwcontactsall[$i])."', '".mysqli_real_escape_string($conn,$iwageall[$i])."', '".mysqli_real_escape_string($conn,$iwgenderall[$i])."', '".mysqli_real_escape_string($conn,$iwheightall[$i])."', '".mysqli_real_escape_string($conn,$iwweightall[$i])."', '".mysqli_real_escape_string($conn,$iwremarksall[$i])."', now())");
				mysqli_query($conn, "INSERT INTO incident_involved_mst (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated, locator_id, idType, idNumber,  Class) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$ifnamesall[$i])."', '".mysqli_real_escape_string($conn,$imnamesall[$i])."', '".mysqli_real_escape_string($conn,$ilnamesall[$i])."', '".mysqli_real_escape_string($conn,$iaddressall[$i])."', '".mysqli_real_escape_string($conn,$icontactsall[$i])."', '".$iage."', '".mysqli_real_escape_string($conn,$igenderall[$i])."', '".$iheight."', '".$iweight."', '".mysqli_real_escape_string($conn,$iremarksall[$i])."', now(), ".$ilocator.", '".mysqli_real_escape_string($conn,$iidtypeall[$i])."', '".mysqli_real_escape_string($conn,$iidnumberall[$i])."',  '".mysqli_real_escape_string($conn,$iclassificationsall[$i])."')") or die(mysqli_error($conn));			  
			}
		  //mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added witness(es) to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		
		if((isset($_POST['iwfnamesall'])) && !empty($_POST['iwfnamesall']))
		{
		  $iwfnamesall = explode("*~", $_POST['iwfnamesall']);
		  $iwmnamesall = explode("*~", $_POST['iwmnamesall']);
		  $iwlnamesall = explode("*~", $_POST['iwlnamesall']);
		  $iwaddressall = explode("*~", $_POST['iwaddressall']);
		  $iwcontactsall = explode("*~", $_POST['iwcontactsall']);
		  $iwageall = explode("*~", $_POST['iwageall']);
		  $iwgenderall = explode("*~", $_POST['iwgenderall']);
		  $iwheightall = explode("*~", $_POST['iwheightall']);
		  $iwweightall = explode("*~", $_POST['iwweightall']);
		  $iwremarksall = explode("*~", $_POST['iwremarksall']);
		  $iwidtypeall = explode("*~", $_POST['iwidtypeall']);
		  $iwidnumberall = explode("*~", $_POST['iwidnumberall']);
		  for($i=1, $count = count($iwfnamesall);$i<$count;$i++) {
			  $iwage = (!empty($iwageall[$i]))? mysqli_real_escape_string($conn,$iwageall[$i]):0;
			  $iwheight = (!empty($iwheightall[$i]))? mysqli_real_escape_string($conn,$iwheightall[$i]):0;
			  $iwweight = (!empty($iwweightall[$i]))? mysqli_real_escape_string($conn,$iwweightall[$i]):0;
			  //mysqli_query($conn, "INSERT INTO incident_witness (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$iwfnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwmnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwlnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwaddressall[$i])."', '".mysqli_real_escape_string($conn,$iwcontactsall[$i])."', '".mysqli_real_escape_string($conn,$iwageall[$i])."', '".mysqli_real_escape_string($conn,$iwgenderall[$i])."', '".mysqli_real_escape_string($conn,$iwheightall[$i])."', '".mysqli_real_escape_string($conn,$iwweightall[$i])."', '".mysqli_real_escape_string($conn,$iwremarksall[$i])."', now())");
			  //mysqli_query($conn, "INSERT INTO incident_witness (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$iwfnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwmnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwlnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwaddressall[$i])."', '".mysqli_real_escape_string($conn,$iwcontactsall[$i])."', '".$iwage."', '".mysqli_real_escape_string($conn,$iwgenderall[$i])."', '".$iwheight."', '".$iwweight."', '".mysqli_real_escape_string($conn,$iwremarksall[$i])."', now())");
			  mysqli_query($conn, "INSERT INTO incident_witness (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated, idType, idNumber) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$iwfnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwmnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwlnamesall[$i])."', '".mysqli_real_escape_string($conn,$iwaddressall[$i])."', '".mysqli_real_escape_string($conn,$iwcontactsall[$i])."', '".$iwage."', '".mysqli_real_escape_string($conn,$iwgenderall[$i])."', '".$iwheight."', '".$iwweight."', '".mysqli_real_escape_string($conn,$iwremarksall[$i])."', now(), '".mysqli_real_escape_string($conn,$iwidtypeall[$i])."', '".mysqli_real_escape_string($conn,$iwidnumberall[$i])."')");
		  }
		  //mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added witness(es) to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());		  
		}
		if((isset($_POST['isfnamesall'])) && !empty($_POST['isfnamesall']))
		{
		  $isfnamesall = explode("*~", $_POST['isfnamesall']);
		  $ismnamesall = explode("*~", $_POST['ismnamesall']);
		  $islnamesall = explode("*~", $_POST['islnamesall']);
		  $isaddressall = explode("*~", $_POST['isaddressall']);
		  $iscontactsall = explode("*~", $_POST['iscontactsall']);
		  $isageall = explode("*~", $_POST['isageall']);
		  $isgenderall = explode("*~", $_POST['isgenderall']);
		  $isheightall = explode("*~", $_POST['isheightall']);
		  $isweightall = explode("*~", $_POST['isweightall']);
		  $isremarksall = explode("*~", $_POST['isremarksall']);
		  $isidtypeall = explode("*~", $_POST['isidtypeall']);
		  $isidnumberall = explode("*~", $_POST['isidnumberall']);
		  for($i=1, $count = count($isfnamesall);$i<$count;$i++) {
			  $isage = (!empty($isageall[$i]))? mysqli_real_escape_string($conn,$isageall[$i]):0;
			  $isheight = (!empty($isheightall[$i]))? mysqli_real_escape_string($conn,$isheightall[$i]):0;
			  $isweight = (!empty($isweightall[$i]))? mysqli_real_escape_string($conn,$isweightall[$i]):0;
			  //mysqli_query($conn, "INSERT INTO incident_suspect (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$isfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ismnamesall[$i])."', '".mysqli_real_escape_string($conn,$islnamesall[$i])."', '".mysqli_real_escape_string($conn,$isaddressall[$i])."', '".mysqli_real_escape_string($conn,$iscontactsall[$i])."', '".$isage."', '".mysqli_real_escape_string($conn,$isgenderall[$i])."', '".$isheight."', '".$isweight."', '".mysqli_real_escape_string($conn,$isremarksall[$i])."', now())");
			  mysqli_query($conn, "INSERT INTO incident_suspect (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated, idType, idNumber) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$isfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ismnamesall[$i])."', '".mysqli_real_escape_string($conn,$islnamesall[$i])."', '".mysqli_real_escape_string($conn,$isaddressall[$i])."', '".mysqli_real_escape_string($conn,$iscontactsall[$i])."', '".$isage."', '".mysqli_real_escape_string($conn,$isgenderall[$i])."', '".$isheight."', '".$isweight."', '".mysqli_real_escape_string($conn,$isremarksall[$i])."', now(), '".mysqli_real_escape_string($conn,$isidtypeall[$i])."', '".mysqli_real_escape_string($conn,$isidnumberall[$i])."')");
		  }
		  //mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added suspect(s) to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		if((isset($_POST['ivfnamesall'])) && !empty($_POST['ivfnamesall']))
		{
		  $ivfnamesall = explode("*~", $_POST['ivfnamesall']);
		  $ivmnamesall = explode("*~", $_POST['ivmnamesall']);
		  $ivlnamesall = explode("*~", $_POST['ivlnamesall']);
		  $ivaddressall = explode("*~", $_POST['ivaddressall']);
		  $ivcontactsall = explode("*~", $_POST['ivcontactsall']);
		  $ivageall = explode("*~", $_POST['ivageall']);
		  $ivgenderall = explode("*~", $_POST['ivgenderall']);
		  $ivheightall = explode("*~", $_POST['ivheightall']);
		  $ivweightall = explode("*~", $_POST['ivweightall']);
		  $ivremarksall = explode("*~", $_POST['ivremarksall']);
		  $ividtypeall = explode("*~", $_POST['ividtypeall']);
		  $ividnumberall = explode("*~", $_POST['ividnumberall']);
		  for($i=1, $count = count($ivfnamesall);$i<$count;$i++) {
			  $ivage = (!empty($ivageall[$i]))? mysqli_real_escape_string($conn,$ivageall[$i]):0;
			  $ivheight = (!empty($ivheightall[$i]))? mysqli_real_escape_string($conn,$ivheightall[$i]):0;
			  $ivweight = (!empty($ivweightall[$i]))? mysqli_real_escape_string($conn,$ivweightall[$i]):0;
			  //mysqli_query($conn, "INSERT INTO incident_victim (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$ivfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivmnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivlnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivaddressall[$i])."', '".mysqli_real_escape_string($conn,$ivcontactsall[$i])."', '".$ivage."', '".mysqli_real_escape_string($conn,$ivgenderall[$i])."', '".$ivheight."', '".$ivweight."', '".mysqli_real_escape_string($conn,$ivremarksall[$i])."', now())");
			  mysqli_query($conn, "INSERT INTO incident_victim (logId, FirstName, MiddleName, LastName, Address, Contact, Age, Gender, Height, Weight, Remark, dateCreated, idType, idNumber) VALUES(".$logId2.", '".mysqli_real_escape_string($conn,$ivfnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivmnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivlnamesall[$i])."', '".mysqli_real_escape_string($conn,$ivaddressall[$i])."', '".mysqli_real_escape_string($conn,$ivcontactsall[$i])."', '".$ivage."', '".mysqli_real_escape_string($conn,$ivgenderall[$i])."', '".$ivheight."', '".$ivweight."', '".mysqli_real_escape_string($conn,$ivremarksall[$i])."', now(), '".mysqli_real_escape_string($conn,$ividtypeall[$i])."', '".mysqli_real_escape_string($conn,$ividnumberall[$i])."')");
		  }
		  //mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added victims to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		// if((isset($_POST['checkVehicle'])) && !empty($_POST['checkVehicle']))
		// {
			// $ivehicleowner = mysqli_real_escape_string($conn, $_POST['txtvowner']);
			// $ivehicleplate = mysqli_real_escape_string($conn, $_POST['txtvplateno']);
			// $ivehicletype = mysqli_real_escape_string($conn, $_POST['selvtype']);
			// $ivehiclemake = mysqli_real_escape_string($conn, $_POST['txtvmake']);
			// $ivehiclemodel = mysqli_real_escape_string($conn, $_POST['txtvmodel']);
			// $ivehiclecolor = mysqli_real_escape_string($conn, $_POST['txtvcolor']);
			// $ivehicleremarks = mysqli_real_escape_string($conn, $_POST['txtvremarks']);
			
			// mysqli_query($conn, "INSERT INTO incident_vehicle (ticket_id, plate_no, type, make, model, color, remarks, owner) VALUES(".$logId2.", '".$ivehicleplate."', '".$ivehicletype."', '".$ivehiclemake."', '".$ivehiclemodel."', '".$ivehiclecolor."', '".$ivehicleremarks."', '".$ivehicleowner."')");
			// mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added vehicle to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		// }
		if((isset($_POST['vPlateNoAll'])) && !empty($_POST['vPlateNoAll']))
		{
			$ivehicleowner = explode("*~", $_POST['vOwnerAll']);
			$ivehicleplate = explode("*~", $_POST['vPlateNoAll']);
			$ivehicletype = explode("*~", $_POST['vTypeAll']);
			$ivehiclemake = explode("*~", $_POST['vMakeAll']);
			$ivehiclemodel = explode("*~", $_POST['vModelAll']);
			$ivehiclecolor = explode("*~", $_POST['vColorAll']);
			$ivehicleremarks = explode("*~", $_POST['vRemarksAll']);
			for($i=1, $count = count($ivehicleplate);$i<$count;$i++)
			{
				mysqli_query($conn, "INSERT INTO incident_vehicle (ticket_id, plate_no, type, make, model, color, remarks, owner) VALUES(".$logId2.", '".mysqli_real_escape_string($conn, $ivehicleplate[$i])."', '".mysqli_real_escape_string($conn,$ivehicletype[$i])."', '".mysqli_real_escape_string($conn, $ivehiclemake[$i])."', '".mysqli_real_escape_string($conn, $ivehiclemodel[$i])."', '".mysqli_real_escape_string($conn,$ivehiclecolor[$i])."', '".mysqli_real_escape_string($conn,$ivehicleremarks[$i])."', '".mysqli_real_escape_string($conn,$ivehicleowner[$i])."')");
				mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added vehicle to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
			}
		}
		if((isset($_POST['checkDamage'])) && !empty($_POST['checkDamage']))
		{
			$idamagecost = $_POST['txtdmgcost'];
			$idamagetype = $_POST['sellosstype'];
			
			mysqli_query($conn, "UPDATE ticket SET damage_cost = ".$idamagecost.", loss_type = '".$idamagetype."' WHERE id = ". $logId2);
			//mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added damage details to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		if((isset($_POST['checkCF'])) && !empty($_POST['checkCF']))
		{
			$cfaccname = mysqli_real_escape_string($conn, $_POST['txtcfaccname']);
			$cfaccid = mysqli_real_escape_string($conn, $_POST['txtcfaccid']);
			$cfcrep = mysqli_real_escape_string($conn, $_POST['txtcfcrep']);
			$cfadd = mysqli_real_escape_string($conn, $_POST['txtcfadd']);
			$cfamount = mysqli_real_escape_string($conn, $_POST['txtcfamount']);
			$cfbill = mysqli_real_escape_string($conn, $_POST['txtcfbill']);
			$cfrelate = mysqli_real_escape_string($conn, $_POST['txtcfrelate']);
			
			mysqli_query($conn, "INSERT INTO incident_counterfeit (ticket_id, account_name, account_id, customer_rep, address, amount, bill_serial, relationship) VALUES (".$logId2.", '".$cfaccname."', '".$cfaccid."', '".$cfcrep."', '".$cfadd."', '".$cfamount."', '".$cfbill."', '".$cfrelate."')");
			//mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added counterfeit details to ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		}
		/* if((isset($_POST['selinclocator'])) && !empty($_POST['selinclocator']))
		{
			$locator_id = $_POST['selinclocator'];
			mysqli_query($conn, "UPDATE ticket SET locator_id = ".$locator_id." WHERE id = ". $logId2);
		} */
		date_default_timezone_set('Asia/Manila');
		$datenow = date('Y-m-d H:i:s');
		mysqli_query($conn, "UPDATE ticket SET disposition = '".mysqli_real_escape_string($conn,$_POST['txtIncidentDisposition'])."', is_open = 0, dateclosed = '".$datenow."' WHERE id = ".$logId2);
		if(mysqli_affected_rows($conn) > 0 ) {
			include("generate-ticket-report.php");
			generateTicketPDF($logId2);
		}
		//mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Closed ticket #".$logId2."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
		
		$uploadinfosql = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$logId2)or die(mysqli_error($conn));
		$uploadinfores = mysqli_fetch_assoc($uploadinfosql);
		$mailtest = "NotApplicable";
		
		$alertdesc = "INCIDENT";
		$whatsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$uploadinfores['description']);
		$whatres = mysqli_fetch_assoc($whatsql);
		$what = $whatres['name'];
		
		$to = "";
		$to2 = "";
		$recipients = array();
		$escalate = array();
		$sqloic = mysqli_query($conn, "SELECT * FROM oic_mst WHERE bu = ".$uploadinfores['bu'])or die(mysqli_error($conn));
		while($resoic = mysqli_fetch_assoc($sqloic))
		{
			if($resoic['slevel'] <= 1)
			{
				$recipients[] = $resoic['email_ad'];
			}
			elseif($resoic['slevel'] <= $uploadinfores['severity'])
			{
				$escalate[] = $resoic['email_ad'];
			}
		}
		
		$uploadbusql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$uploadinfores['bu'])or die(mysqli_error($conn));
		$uploadbures = mysqli_fetch_assoc($uploadbusql);
		
		$bucontrolnum = $uploadbures['bu_code'].'-'.str_replace("-", "", $uploadinfores['dateadded']).'-'.$uploadinfores['id'];
		$datenow2 = strtotime($uploadinfores['dateclosed']);
		$emaildatecreated2 = date('h:i:sa, j F Y', $datenow2);
		
		$getlocationsql = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ".$uploadinfores['location']);
		$getlocationres = mysqli_fetch_array($getlocationsql);
			
		$to = implode("*~", $recipients);
		$to2 = implode("*~", $escalate);		
		
		$subject = 'SECURITY '.$alertdesc.' LEVEL '.$uploadinfores['severity'].': [Closed] '.$what.' '.$bucontrolnum;
		$subheader = '<h3 style="margin-top:0px;">ALERT LEVEL '.$uploadinfores['severity'].'</h3>';
		$locdisp = '-> '.$getlocationres['location'];	
		
		$narrative = preg_replace( "/\r|\n/", "<br>", $uploadinfores['disposition'] );
		$mainbody = '<table border="1" width="75%" align="center" style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif; border-collapse:collapse;">
						<tr align="center">
							<td colspan="100%" align="center">
								<h2 style="margin-bottom:0px;">'.$alertdesc.' REPORT</h2>
								'.$subheader.'
							</td>
						</tr>
						<tr>
							<td colspan="100%">
								<table align="center" width="80%" style="border-collapse:collapse;" cellpadding="5px" >                                           											
									<tr>                          
										<td width="15%" valign="top" style="text-align: right; font-weight: bold;" >WHAT:</td>
										<td style=" padding-left:20px; padding-right:20px;" >'.$what.'</td>
									</tr>
									<tr>                          
										<td width="15%" style="text-align: right; font-weight: bold;">WHERE:</td>
										<td style=" padding-left:20px; padding-right:20px;">'.$uploadbures['bu'].' '.$locdisp.'</td>
									</tr>                      
									<tr>                          
										<td width="15%" style="text-align: right; font-weight: bold;">WHEN:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.$emaildatecreated2.'</td>
									</tr>										
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">UPDATE:</td>
										<td style=" padding-left:20px; padding-right:20px;">Ticket closed.</td>
									</tr>
									<tr>
										<td width="15%" style="text-align: right; font-weight: bold; vertical-align:top">DISPOSITION:</td>
										<td style=" padding-left:20px; padding-right:20px;"> '.utf8_decode($narrative).'</td>
									</tr>									
									<tr>
										<td width="15%" style="text-decoration:underline; text-align: right;">Uploaded by:</td>
										<td style=" padding-left:20px; padding-right:20px;">'.$userfull.'</td>
									</tr>																					
								</table>
							</td>
						</tr>
					 </table>';
			
			$incidentReport = '';
			$getReportFileQuery = mysqli_query($conn, "SELECT report_file FROM ticket WHERE id =  $logId2");
			while($getReportFile = mysqli_fetch_assoc($getReportFileQuery)) {
				$incidentReport = $getReportFile['report_file'];
			}

			$mail = send_mail_disposition_enhancement($to,$subject,$mainbody,$to2, $incidentReport);
			if($mail)
			{
				$mailtest = "SUCCESS";
			}
			else
			{
				 $mailtest = "FAILED";
			}
	
		
		
		if($_SESSION['level'] == 'User')
		{
			header("location:user.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("location:user-admin.php?last=Incidents");
		}
		elseif($_SESSION['level'] == 'Super Admin')
		{
			header("location:user-superadmin.php?last=Incidents");
		}
	}
}
//$busql = mysqli_query($conn, "select * from bu_mst where id ='".$_SESSION['bu']."'");
$logdate = date('Y-m-d');
$logtime = date('H:i:s');
//$activitysql = mysqli_query($conn, "select * from ticket where bu = $bu and ticket_type = 1 and dateadded=$logdate");
//$activitysql = mysqli_query($conn, "select * from ticket where bu = $bu and ticket_type = 2");
$activitysql = mysqli_query($conn, "select * from ticket where bu = $bu and ((dateadded > DATE_SUB(now(), INTERVAL 4 DAY)) or (is_open = 1)) order by datesubmitted desc");
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
		$stat = "<td style=\"color:#090; font-weight:bold;\">Open</td><td class=\"addlog\" onclick=\"GetInfo('". $actres['id'] ."', '". $actres['dateadded'] ."', '". $ticketdesc ."', '". $actres['description'] ."', '". $ticket_type ."', '".$actres['severity']."');\" style=\"cursor:pointer\" >Add Log</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td style=\"cursor:pointer\" onclick=\"Closeticket('". $actres['id'] ."', '". $type . "')\">Close Ticket</td>";
		
		
	}
	else
	{
		// if($ticket_type == 1){
			// $stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td></td><td style=\"cursor:pointer\" onclick=\"GenerateReport(".$actres['id'].");\">Generate Report</td>";
		// }
		// else{
			$stat = "<td  style=\"color:#F00; font-weight:bold;\">Closed</td><td style=\"cursor:pointer\" onclick=\"openUploadModal(".$actres['id'].", ".$actres['ticket_type'].")\">Upload/View File(s)</td><td colspan=\"100%\">".$actres['dateclosed']."</td>";
		//}
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
		$result4 = mysqli_query($conn, "select * from users_mst where id = '". $actlogres['uid'] ."'");
			$encoder = mysqli_fetch_assoc($result4);
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
		$testdatecreated = strtotime($resemaillog['date_created']);
				$testdatecreated2 = date('j F Y', $testdatecreated);
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
										<td align=\"center\" colspan=\"100%\">                                    	
											<textarea style=\"width:95%; height:150px; resize:none\" readonly=\"readonly\" >". $actlogres['remarks'] ."</textarea>
										</td>
									</tr>
									<tr>
										<td align=\"left\">
											<label style=\"text-decoration:underline; cursor:pointer; color:#00F; display:none;\" onclick=\"showAttachments('".$attachmentid."');\" >Show Attachments</label>
										</td>
										<td align=\"right\">Encoded by: ".$encoder['lname'].", ".$encoder['fname']." ".$encoder['mi'].".</td>
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
$cat = "Activities";
if($_GET['last']){
	$cat = $_GET['last'];
}

$guardsql2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE bu = $bu ORDER BY status, lname");
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
	//$editbtn = "<td><img src=\"images/Person_details.png\" height=\"28px\" title=\"EDIT ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo('". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['fname']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['mname']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['lname']))) ."', '". trim($guardres3['gender']) ."', '". trim($guardres3['birthdate']) ."', '". trim($guardres3['blood_type']) ."', '". trim($guardres3['civil_status']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['present_address']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['provincial_address']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['contact']))) ."', '". trim($guardbures['bu']) ."', '". trim($guardres3['date_posted']) ."', '". trim($guardres3['agency_employment']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_code']))) ."', '". trim($guardres3['agency']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_category']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['badge_number']))) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['ntc_license']))) ."', '". trim($guardres3['ntc_license_start']) ."', '". trim($guardres3['ntc_license_end']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['license_number']))) ."', '". trim($guardres3['license_issue_date']) ."', '". trim($guardres3['license_expiry_date']) ."', '". trim($guardres3['performance']) ."', '". trim(str_replace("'", "\\\'", str_replace('"', '&quot',$gcomment2))) ."', 'view', '".trim($guardres3['id'])."', '".trim($guardres3['status'])."', '".trim(str_replace("'", "\\\'", str_replace('"', '&quot',$guardres3['guard_photo'])))."');\" /></td>";
	$editbtn = "<td><img src=\"images/Person_details.png\" height=\"28px\" title=\"VIEW ". trim($gfirstname) ." ". trim($glastname) ."\" id=\"editguard\" name=\"editguard\" style=\"cursor:pointer;\" onclick=\"guardInfo2(".$guardres3['id'].", 'View');\" /></td>";
	$guardstable .= "<tr ". $rowclass .">
						<td>". $guardnum ."</td>
						<td>". $glastname . "</td>
						<td>". $gfirstname . "</td>
						<td>". $gmiddlename . "</td>
						<td>". $gcode . "</td>
						<td>". $gcontact . "</td>
						<td>". $guardbu . "</td>
						<td>". $gstatus . "</td>
						". $editbtn ."
					 </tr>";
	$guardnum++;
}
$code10table = "";
$code11table = "";
$codedctable = "";
$codetable = "";
$codepatable = "";
$codessql = mysqli_query($conn, "SELECT * FROM urc_mst ORDER BY series, codes");
while($coderes = mysqli_fetch_assoc($codessql)){
	$codes = $coderes['codes'];
	$codedesc = $coderes['description'];
	$codeseries = $coderes['series'];
	if($codeseries == "10-00"){
		$code10table .= "<tr align=\"center\">
							<td>". $codes ."</td>
							<td align=\"left\" style=\"padding-left:50px\">". $codedesc ."</td>
						 </tr>";
	}
	elseif($codeseries == "11-00"){
		$code11table .= "<tr align=\"center\">
							<td>". $codes ."</td>
							<td align=\"left\" style=\"padding-left:50px\">". $codedesc ."</td>
						 </tr>";
	}
	elseif($codeseries == "disposition"){
		$codedctable .= "<tr align=\"center\">
							<td>". $codes ."</td>
							<td align=\"left\" style=\"padding-left:50px\">". $codedesc ."</td>
						 </tr>";
	}
	elseif($codeseries == "codes"){
		$codetable .= "<tr align=\"center\">
							<td>". $codes ."</td>
							<td align=\"left\" style=\"padding-left:50px\">". $codedesc ."</td>
						 </tr>";
	}
	elseif($codeseries == "phonetic"){
		$codepatable .= "<tr align=\"center\">
							<td>". $codes ."</td>
							<td align=\"left\" style=\"padding-left:50px\">". $codedesc ."</td>
						 </tr>";
	}
	
}



eval('$body = "' . fetch_template('user') . '";');

echo stripslashes($body);

?>


