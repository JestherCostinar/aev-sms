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
		<table align="center" width="50%">
			<tr><th>Contract Compliance Status Page</th></tr>
			<tr>
				<td>					
					<!-- start PHP code -->
					<?php					
						
						include("sendmail.php");
						include("includes/dbconfigcc.php");
						include("includes/linkscc.php");
						
						/* START main verification process */						
						if((isset($_GET['bu']) && !empty($_GET['bu']) && filter_var($_GET['bu'], FILTER_VALIDATE_INT)) AND (isset($_GET['sa']) && !empty($_GET['sa']) && filter_var($_GET['sa'], FILTER_VALIDATE_INT)) AND (isset($_GET['ye']) && !empty($_GET['ye']) && filter_var($_GET['ye'], FILTER_VALIDATE_INT)) AND (isset($_GET['to']) && !empty($_GET['to']) && filter_var($_GET['to'], FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[\da-fA-F]{32}/")))))
						{
							$checkstatustable = "";
							$secagency = $_GET['sa'];
							$bunit = $_GET['bu'];
							$ccyear = $_GET['ye'];
							$checktoken =  md5($secagency + $bunit + $ccyear);
							if($checktoken == $_GET['to'])
							{
								$stmt = mysqli_prepare($conn, "SELECT email, cc_id, business_unit, security_agency_name, year, month, admin_email, approved, approved_on FROM ccverify_mst WHERE security_agency = ? AND business_unit = ? AND year = ?");
								mysqli_stmt_bind_param($stmt, "iii", $secagency, $bunit, $ccyear);
								mysqli_stmt_execute($stmt);
								mysqli_stmt_bind_result($stmt, $agency_email, $baseccid, $business_unit, $securiy_agency, $year, $month, $admin_email, $approved, $approved_on);
								while(mysqli_stmt_fetch($stmt))
								{
									if($approved == 0)
									{
										$ccstat = "Pending";
									}
									elseif($approved == 1)
									{
										$ccstat = "Approved";
									}
									$checkstatustable .= "<tr align='center'><td>".$baseccid."</td><td>".$month."</td><td>".$year."</td><td>".$agency_email."</td><td>".$admin_email."</td><td>".$ccstat."</td><td>".$approved_on."</td></tr>";
								}
								mysqli_stmt_close($stmt);
								echo '<div class="statusmsg"><table width="100%" align="center" border="1" style="border-collapse:collapse;"><tr><th>CC_ID</th><th>Month</th><th>Year</th><th>Agency Email</th><th>Admin Email</th><th>Status</th><th>Approved On</th></tr>'.$checkstatustable.'</table></div>';
							}
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