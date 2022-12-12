<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Aboitiz | Security Management System</title>
    
</head>
<body style="font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;">

    <!-- start header div -->     
	<div id="topbar">
		<img src="images/header.png" alt="Aboitiz logo" style="background:black;width:100%;">		
	</div>
	<div id="separator" style="height:20px; width:100%; background-color:#CCC;"></div>
    <!-- end header div -->   
     
    <!-- start wrap div -->   
    <div id="wrap">
		<table align="center">
			<tr><th>Contract Compliance Verification Page</th></tr>
			<tr>
				<td>					
					<!-- start PHP code -->
					<?php					
						
						include("sendmail.php");
						include("includes/dbconfigcc.php");
						include("includes/linkscc.php");
						
						/* START main verification process */						
						if((isset($_GET['em']) && !empty($_GET['em']) && filter_var($_GET['em'], FILTER_VALIDATE_EMAIL)) AND (isset($_GET['cc']) && !empty($_GET['cc']) && filter_var($_GET['cc'], FILTER_VALIDATE_INT)) AND (isset($_GET['bu']) && !empty($_GET['bu']) && filter_var($_GET['bu'], FILTER_VALIDATE_INT)) AND (isset($_GET['sa']) && !empty($_GET['sa']) && filter_var($_GET['sa'], FILTER_VALIDATE_INT)) AND (isset($_GET['ye']) && !empty($_GET['ye']) && filter_var($_GET['ye'], FILTER_VALIDATE_INT)) AND (isset($_GET['mo']) && !empty($_GET['mo']) && filter_var($_GET['mo'], FILTER_VALIDATE_INT)) AND (isset($_GET['ch']) && !empty($_GET['ch']) && filter_var($_GET['ch'], FILTER_VALIDATE_INT)) AND (isset($_GET['to']) && !empty($_GET['to']) && filter_var($_GET['to'], FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[\da-fA-F]{32}/")))))
						{
							$getEmail = mysqli_real_escape_string($conn, $_GET['em']);
							$getBusinessUnit = mysqli_real_escape_string($conn, $_GET['bu']);
							$getSecurityAgency = mysqli_real_escape_string($conn, $_GET['sa']);
							$getSecurityAgencyName = mysqli_real_escape_string($conn, $_GET['san']);
							$getYear = mysqli_real_escape_string($conn, $_GET['ye']);
							$getMonth = mysqli_real_escape_string($conn, $_GET['mo']);
							$getCheck = mysqli_real_escape_string($conn, $_GET['ch']);
							$getToken = mysqli_real_escape_string($conn, $_GET['to']);
							$getAdminEmail = mysqli_real_escape_string($conn, $_GET['ae']);
							$getCCID = mysqli_real_escape_string($conn, $_GET['cc']);
							
							if(($getCheck == 1) && (isset($getAdminEmail) && !empty($getAdminEmail)) && (isset($getSecurityAgencyName) && !empty($getSecurityAgencyName)) && (filter_var($getAdminEmail, FILTER_VALIDATE_EMAIL)) && (filter_var($getSecurityAgencyName, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[\w\s]+/"))))) // Execute this if redirect is from Security Management System
							{
								//mysqli_query($conn, "INSERT INTO ccverify_mst(email, cc_id, business_unit, security_agency, security_agency_name, year, month, token, admin_email) VALUES('".$getEmail."', ".$getCCID.", ".$getBusinessUnit.", ".$getSecurityAgency.", '".$getSecurityAgencyName."', ".$getYear.", ".$getMonth.", '".$getToken."', '".$getAdminEmail."')");								
								
								$stmt = mysqli_prepare($conn, "SELECT id FROM ccverify_mst WHERE cc_id = ? AND business_unit = ? AND security_agency = ? AND year = ? AND month = ? AND approved = 0 ORDER BY id DESC");
								mysqli_stmt_bind_param($stmt, "iiiii", $getCCID, $getBusinessUnit, $getSecurityAgency, $getYear, $getMonth);
								mysqli_stmt_execute($stmt);
								mysqli_stmt_bind_result($stmt, $ccid);
								mysqli_stmt_fetch($stmt);
								mysqli_stmt_close($stmt);
								
								if($ccid)
								{
									$stmt = mysqli_prepare($conn, "UPDATE ccverify_mst SET email = ?, token = ?, admin_email =? WHERE id = ?");
									mysqli_stmt_bind_param($stmt, "sssi", $getEmail, $getToken, $getAdminEmail, $ccid);
									mysqli_stmt_execute($stmt);
									//header("Location:".$url_base."/user-admin.php?last=ConComp");
									echo '<div class="statusmsg">Score has been saved. E-mail has been sent. Go <a href="http://webapps.aboitiz.net/sms/user-admin.php?last=ConComp">BACK</a>.</div>';
								}
								else
								{
									$stmt = mysqli_prepare($conn, "INSERT INTO ccverify_mst(email, cc_id, business_unit, security_agency, security_agency_name, year, month, token, admin_email) VALUES(?,?,?,?,?,?,?,?,?)");
									mysqli_stmt_bind_param($stmt, "siiisiiss", $getEmail, $getCCID, $getBusinessUnit, $getSecurityAgency, $getSecurityAgencyName, $getYear, $getMonth, $getToken, $getAdminEmail);
									mysqli_stmt_execute($stmt);
									//header("Location:".$url_base."/user-admin.php?last=ConComp");
									echo '<div class="statusmsg">Score has been saved. E-mail has been sent. Go <a href="http://webapps.aboitiz.net/sms/user-admin.php?last=ConComp">BACK</a>.</div>';
								}
								
								
								
								
							}
							elseif($getCheck == 2) // Execute this if redirect is from Security Agency Email
							{
								date_default_timezone_set('Asia/Manila');
								$datenow = date('Y-m-d H:i:s');
								$absoluteacknowlegementlink = $url_base."/concompacknowledge.php?ccid=".$getCCID."&to=".$getToken."&now=".urlencode($datenow);
								
								/* $searchsql = mysqli_query($conn, "SELECT * FROM ccverify_mst WHERE token = '".$getToken."' AND cc_id = ".$getCCID." AND email = '".$getEmail."' AND business_unit = ".$getBusinessUnit." AND security_agency = ".$getSecurityAgency." AND year = ".$getYear." AND month = ".$getMonth." AND approved = 0");
								$searchres = mysqli_fetch_assoc($searchsql); */
								
								$stmt = mysqli_prepare($conn, "SELECT id, admin_email, security_agency_name FROM ccverify_mst WHERE token = ? AND cc_id = ? AND email = ? AND business_unit = ? AND security_agency = ? AND year = ? AND month = ? AND approved = 0");
								mysqli_stmt_bind_param($stmt, "sisiiii", $getToken, $getCCID, $getEmail, $getBusinessUnit, $getSecurityAgency, $getYear, $getMonth);
								mysqli_stmt_execute($stmt);
								mysqli_stmt_bind_result($stmt, $ccid, $ccadminemail, $ccsecagencyname);
								mysqli_stmt_fetch($stmt);
								mysqli_stmt_close($stmt);
								
								//if($searchres)
								if($ccid)
								{								
									//mysqli_query($conn, "UPDATE ccverify_mst SET approved = 1 WHERE id = ".$searchres['id']);
									
									$ccTrans = "1-".$getMonth."-".$getYear;
									$ccDisplayMonth = date('F', strtotime($ccTrans));
									
									/* ini_set("SMTP","192.168.2.16");
									ini_set("smtp_port","25");
									$admin_name = 'admin'; */
									
									//$to = $searchres['admin_email'];
									$to = $ccadminemail;
									//$subject = $searchres['security_agency_name']." Contract Compliance: ".$ccDisplayMonth." - ".$getYear;
									$subject = $ccsecagencyname." Contract Compliance: ".$ccDisplayMonth." - ".$getYear;
									$mainbody = "<table width='95%' align='center' style='font-family: Calibri, Candara, Segoe, Optima, Arial, sans-serif;'>" .
													"<tr>" .
														"<th>CONTRACT COMPLIANCE UPDATE</th>" .
													"</tr>" .
													"<tr>" .
														"<td>" .															
															$ccsecagencyname." has confirmed the score they were given for ".$ccDisplayMonth." ".$getYear.".<br>" .
															"To acknowledge, CLICK <a href='".$absoluteacknowlegementlink."' target='_blank'>HERE</a><br>" .
															"IMPORTANT NOTE: This link only works if you are connected to the Aboitiz Network.<br>" .
															"<br><br>" .															
														"</td>" .
													"</tr>" .
												"</table>";
												
									// $mail = send_mail_back($to,$subject,$mainbody, $admin_name);
									$mail = send_mail_back($to,$subject,$mainbody);
												
									echo '<div class="statusmsg">You have approved your Contract Compliance Score.</div>';
									
									$stmt = mysqli_prepare($conn, "UPDATE ccverify_mst SET approved = 1, approved_on = ? WHERE id = ?");
									mysqli_stmt_bind_param($stmt, "si", $datenow, $ccid);
									mysqli_stmt_execute($stmt);
									mysqli_stmt_close($stmt);
								}
								else
								{
									echo '<div class="statusmsg">Contract Compliance Score ERROR.<br>Possible causes:<br>a) CC Score outdated.<br>b) CC Score has already been approved.<br>c) CC Score was not found.</div>';									
								}
								
							}
							else // parameters are incomplete
							{
								echo '<div class="statusmsg">Verification link error.</div>';
							}
							
						}
						else
						{							
							echo '<div class="statusmsg">If you are here by mistake, you may now close this window.</div>';
						}
						/* END main verification process */
						 
					?>
					<!-- stop PHP Code -->
				</td>
			</tr>
		</table>        
    </div>
    <!-- end wrap div -->
	
</body>
</html>