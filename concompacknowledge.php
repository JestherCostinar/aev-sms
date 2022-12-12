<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
			<tr><th>Contract Compliance Acknowledgement Page</th></tr>
			<tr>
				<td>					
					<!-- start PHP code -->
					<?php				
						
						include("sendmail.php");
						include("includes/dbconfig.php");
						include("includes/global.php");
						include("includes/function.php");
						
						/* START main acknowledgement process */						
						if(isset($_GET['ccid']) && !empty($_GET['ccid']) && filter_var($_GET['ccid'], FILTER_VALIDATE_INT) && isset($_GET['to']) && !empty($_GET['to']) && filter_var($_GET['to'], FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/[\da-fA-F]{32}/"))))
						{
							
							$getCCID = mysqli_real_escape_string($conn, $_GET['ccid']);
							$getToken = mysqli_real_escape_string($conn, $_GET['to']);
							$getNow = mysqli_real_escape_string($conn, $_GET['now']);
							
							$ccsql = mysqli_query($conn, "SELECT * FROM cc_general WHERE id = ".$getCCID." AND approved = 0");
							$ccres = mysqli_fetch_assoc($ccsql);
							
							if($ccres)
							{
								if($ccres['token'] == $getToken)
								{
									mysqli_query($conn, "UPDATE cc_general SET approved = 1, approved_on = '".$getNow."' WHERE id = ".$getCCID);								
									echo "<div class='statusmsg'>You have acknowledged the Contract Compliance score.<br> The score will now be updated into the Security Management System.<br> Thank you.</div>";
								}
								else
								{
									echo "<div class='statusmsg'>Score mismatch/outdated. Please notify the provider that they have to approve the latest score.</div>";
								}
								
							}
							else
							{
								echo "<div class='statusmsg'>Record is either non-existent or had already been acknowledged.</div>";
							}
							
						}
						else
						{							
							echo '<div class="statusmsg">Acknowledgement link error. Please make sure to use the link that has been sent to your email.</div>';
						}
						/* END main acknowledgement process */
						 
					?>
					<!-- stop PHP Code -->
				</td>
			</tr>
		</table>        
    </div>
    <!-- end wrap div -->
	
</body>
</html>