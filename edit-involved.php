<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");

	$ticketid = $_GET['ticket_id'];
	
	/* $queryWitness = mysqli_query($conn, "SELECT * FROM incident_witness WHERE logId = ". $ticketid);
	if($queryWitness)
	{
		while($resWitness = mysqli_fetch_assoc($queryWitness))
		{
			$witnesslist .= "<table align='center'>
								<tr>
									<td>First Name:</td>
									<td><input type=\"text\" class=\"iFName\" id=\"wFName".$resWitness['id']."\" name=\"wFName".$resWitness['id']."\" value=\"".$resWitness['FirstName']."\"></td>
									<td>Gender:</td>
									<td><input type=\"text\" class=\"iGender\" id=\"wGender".$resWitness['id']."\" value=\"".$resWitness['Gender']."\"></td>
								</tr> 
								<tr>
									<td>Middle Name:</td>
									<td><input type=\"text\" class=\"iMName\" id=\"wMName".$resWitness['id']."\" value=\"".$resWitness['MiddleName']."\"></td>
									<td>Height:</td>
									<td><input type=\"text\" class=\"iHeight\" id=\"wHeight".$resWitness['id']."\" size=\"4\" value=\"".(($resWitness['Height'] == 0) ? '':$resWitness['Height'])."\"> cm</td>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td><input type=\"text\" class=\"iLName\" id=\"wLName".$resWitness['id']."\" value=\"".$resWitness['LastName']."\"></td>
									<td>Weight:</td>
									<td><input type=\"text\" class=\"iWeight\" id=\"wWeight".$resWitness['id']."\" size=\"4\" value=\"".(($resWitness['Weight'] == 0) ? '':$resWitness['Weight'])."\"> kg</td>
								</tr>
								<tr>
									<td>Address:</td>
									<td><input type=\"text\" class=\"iAddress\" id=\"wAddress".$resWitness['id']."\" value=\"".$resWitness['Address']."\"></td>
									<td>ID Type:</td>
									<td><input type=\"text\" class=\"iidType\" id=\"widType".$resWitness['id']."\" value=\"".$resWitness['idType']."\"></td>
								</tr>
								<tr>
									<td>Contact:</td>
									<td><input type=\"text\" class=\"iContact\" id=\"wContact".$resWitness['id']."\" value=\"".$resWitness['Contact']."\"></td>
									<td>ID Number:</td>
									<td><input type=\"text\" class=\"iidNumber\" id=\"widNumber".$resWitness['id']."\" value=\"".$resWitness['idNumber']."\"></td>
								</tr>
								<tr>
									<td>Age:</td>
									<td><input type=\"number\" class=\"iAge\" id=\"wAge".$resWitness['id']."\" value=\"".(($resWitness['Age'] == 0) ? '':$resWitness['Age'])."\"></td>
									<td>Remark:</td>
									<td><input type=\"text\" class=\"iRemarks\" id=\"wRemarks".$resWitness['id']."\" value=\"".$resWitness['Remark']."\"></td>
								</tr>
								<tr>
									<td align=\"right\" colspan=\"100%\">
										
										<input type=\"hidden\" class=\"iNumber\" value=\"".$resWitness['id']."\">
										<input type=\"hidden\" class=\"iUpdateType\" value=\"witness\">
									</td>
								</tr>
							</table><br>";
		}		
	}
	$querySuspect = mysqli_query($conn, "SELECT * FROM incident_suspect WHERE logId = ". $ticketid);
	if($querySuspect)
	{
		while($resSuspect = mysqli_fetch_assoc($querySuspect))
		{
			$suspectlist .= "<table>
								<tr>
									<td>First Name:</td>
									<td><input type=\"text\" class=\"iFName\" id=\"sFName".$resSuspect['id']."\" value=\"".$resSuspect['FirstName']."\"></td>
									<td>Gender</td>
									<td><input type=\"text\" class=\"iGender\" id=\"sGender".$resSuspect['id']."\" value=\"".$resSuspect['Gender']."\"></td>
								</tr>
								<tr>
									<td>Middle Name:</td>
									<td><input type=\"text\" class=\"iMName\" id=\"sMName".$resSuspect['id']."\" value=\"".$resSuspect['MiddleName']."\"></td>
									<td>Height:</td>
									<td><input type=\"text\" class=\"iHeight\" id=\"sHeight".$resSuspect['id']."\" size=\"4\" value=\"".(($resSuspect['Height'] == 0) ? '':$resSuspect['Height'])."\"> cm</td>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td><input type=\"text\" class=\"iLName\" id=\"sLName".$resSuspect['id']."\" value=\"".$resSuspect['LastName']."\"></td>
									<td>Weight:</td>
									<td><input type=\"text\" class=\"iWeight\"  id=\"sWeight".$resSuspect['id']."\" size=\"4\" value=\"".(($resSuspect['Weight'] == 0) ? '':$resSuspect['Weight'])."\"> kg</td>
								</tr>
								<tr>
									<td>Address:</td>
									<td><input type=\"text\" class=\"iAddress\" id=\"sAddress".$resSuspect['id']."\" value=\"".$resSuspect['Address']."\"></td>
									<td>ID Type:</td>
									<td><input type=\"text\" class=\"iidType\" id=\"sidType".$resSuspect['id']."\" value=\"".$resSuspect['idType']."\"></td>
								</tr>
								<tr>
									<td>Contact:</td>
									<td><input type=\"text\" class=\"iContact\" id=\"sContact".$resSuspect['id']."\" value=\"".$resSuspect['Contact']."\"></td>
									<td>ID Number:</td>
									<td><input type=\"text\" class=\"iidNumber\" id=\"sidNumber".$resSuspect['id']."\" value=\"".$resSuspect['idNumber']."\"></td>
								</tr>
								<tr>
									<td>Age:</td>
									<td><input type=\"number\" class=\"iAge\" id=\"sAge".$resSuspect['id']."\" value=\"".(($resSuspect['Age'] == 0) ? '':$resSuspect['Age'])."\"></td>
									<td>Remark:</td>
									<td><input type=\"text\" class=\"iRemarks\" id=\"sRemarks".$resSuspect['id']."\" value=\"".$resSuspect['Remark']."\"></td>
								</tr>
								<tr>
									<td align=\"right\" colspan=\"100%\">
										
										<input type=\"hidden\" class=\"iNumber\" value=\"".$resSuspect['id']."\">
										<input type=\"hidden\" class=\"iUpdateType\" value=\"suspect\">
									</td>
								</tr>
							</table><br>";
		}		
	}
	$queryVictim = mysqli_query($conn, "SELECT * FROM incident_victim WHERE logId = ". $ticketid);
	if($queryVictim)
	{
		while($resVictim = mysqli_fetch_assoc($queryVictim))
		{
			$victimlist .= "<table>
								<tr>
									<td>First Name:</td>
									<td><input type=\"text\" class=\"iFName\" id=\"vFName".$resVictim['id']."\" value=\"".$resVictim['FirstName']."\"></td>
									<td>Gender:</td>
									<td><input type=\"text\" class=\"iGender\" id=\"vGender".$resVictim['id']."\" value=\"".$resVictim['Gender']."\"></td>
								</tr>
								<tr>
									<td>Middle Name:</td>
									<td><input type=\"text\" class=\"iMName\" id=\"vMName".$resVictim['id']."\" value=\"".$resVictim['MiddleName']."\"></td>
									<td>Height:</td>
									<td><input type=\"text\" class=\"iHeight\" id=\"vHeight".$resVictim['id']."\" size=\"4\" value=\"".(($resVictim['Height'] == 0) ? '':$resVictim['Height'])."\"> cm</td>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td><input type=\"text\" class=\"iLName\" id=\"vLName".$resVictim['id']."\" value=\"".$resVictim['LastName']."\"></td>
									<td>Weight:</td>
									<td><input type=\"text\" class=\"iWeight\" id=\"vWeight".$resVictim['id']."\" size=\"4\" value=\"".(($resVictim['Weight'] == 0) ? '':$resVictim['Weight'])."\"> kg</td>
								</tr>
								<tr>
									<td>Address::</td>
									<td><input type=\"text\" class=\"iAddress\" id=\"vAddress".$resVictim['id']."\" value=\"".$resVictim['Address']."\"></td>
									<td>ID Type:</td>
									<td><input type=\"text\" class=\"iidType\" id=\"vidType".$resVictim['id']."\" value=\"".$resVictim['idType']."\"></td>
								</tr>
								<tr>
									<td>Contact:</td>
									<td><input type=\"text\" class=\"iContact\" id=\"vContact".$resVictim['id']."\" value=\"".$resVictim['Contact']."\"></td>
									<td>ID Number:</td>
									<td><input type=\"text\" class=\"iidNumber\" id=\"vidNumber".$resVictim['id']."\" value=\"".$resVictim['idNumber']."\"></td>
								</tr>
								<tr>
									<td>Age:</td>
									<td><input type=\"number\" class=\"iAge\" id=\"vAge".$resVictim['id']."\" value=\"".(($resVictim['Age'] == 0) ? '':$resVictim['Age'])."\"></td>
									<td>Remark:</td>
									<td><input type=\"text\"class=\"iRemarks\" id=\"vRemarks".$resVictim['id']."\" value=\"".$resVictim['Remark']."\"></td>
								</tr>
								<tr>
									<td align=\"right\" colspan=\"100%\">
										
										<input type=\"hidden\" class=\"iNumber\" value=\"".$resVictim['id']."\">
										<input type=\"hidden\" class=\"iUpdateType\" value=\"victim\">
									</td>
								</tr>
							</table><br>";
		}		
	} */
	$queryInvolved = mysqli_query($conn, "SELECT * FROM incident_involved_mst WHERE logId = ". $ticketid);	
	if($queryInvolved)
	{
		while($resInvolved = mysqli_fetch_assoc($queryInvolved))
		{
			$involvedlist = "<table>
								<tr>
									<td>First Name:</td>
									<td><input type=\"text\" class=\"iFName\" id=\"vFName".$resInvolved['id']."\" value=\"".$resInvolved['FirstName']."\"></td>
									<td>Gender:</td>
									<td><input type=\"text\" class=\"iGender\" id=\"vGender".$resInvolved['id']."\" value=\"".$resInvolved['Gender']."\"></td>
								</tr>
								<tr>
									<td>Middle Name:</td>
									<td><input type=\"text\" class=\"iMName\" id=\"vMName".$resInvolved['id']."\" value=\"".$resInvolved['MiddleName']."\"></td>
									<td>Height:</td>
									<td><input type=\"text\" class=\"iHeight\" id=\"vHeight".$resInvolved['id']."\" size=\"4\" value=\"".(($resInvolved['Height'] == 0) ? '':$resInvolved['Height'])."\"> cm</td>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td><input type=\"text\" class=\"iLName\" id=\"vLName".$resInvolved['id']."\" value=\"".$resInvolved['LastName']."\"></td>
									<td>Weight:</td>
									<td><input type=\"text\" class=\"iWeight\" id=\"vWeight".$resInvolved['id']."\" size=\"4\" value=\"".(($resInvolved['Weight'] == 0) ? '':$resInvolved['Weight'])."\"> kg</td>
								</tr>
								<tr>
									<td>Address::</td>
									<td><input type=\"text\" class=\"iAddress\" id=\"vAddress".$resInvolved['id']."\" value=\"".$resInvolved['Address']."\"></td>
									<td>ID Type:</td>
									<td><input type=\"text\" class=\"iidType\" id=\"vidType".$resInvolved['id']."\" value=\"".$resInvolved['idType']."\"></td>
								</tr>
								<tr>
									<td>Contact:</td>
									<td><input type=\"text\" class=\"iContact\" id=\"vContact".$resInvolved['id']."\" value=\"".$resInvolved['Contact']."\"></td>
									<td>ID Number:</td>
									<td><input type=\"text\" class=\"iidNumber\" id=\"vidNumber".$resInvolved['id']."\" value=\"".$resInvolved['idNumber']."\"></td>
								</tr>
								<tr>
									<td>Age:</td>
									<td><input type=\"number\" class=\"iAge\" id=\"vAge".$resInvolved['id']."\" value=\"".(($resInvolved['Age'] == 0) ? '':$resInvolved['Age'])."\"></td>
									<td>Remark:</td>
									<td><input type=\"text\"class=\"iRemarks\" id=\"vRemarks".$resInvolved['id']."\" value=\"".$resInvolved['Remark']."\"></td>
								</tr>
								<tr>
									<td align=\"right\" colspan=\"100%\">
										
										<input type=\"hidden\" class=\"iNumber\" value=\"".$resInvolved['id']."\">
										<input type=\"hidden\" class=\"iUpdateType\" value=\"victim\">
									</td>
								</tr>
							</table><br>";
			if($resInvolved['Class'] == "Victim")
			{
				$victimlist .= $involvedlist;				
			}
			elseif($resInvolved['Class'] == "Suspect")
			{
				$suspectlist .= $involvedlist;				
			}
			elseif($resInvolved['Class'] == "Witness")
			{
				$witnesslist .= $involvedlist;				
			}
			elseif($resInvolved['Class'] == "Non-compliant")
			{
				$noncomplist .= $involvedlist;				
			}
			elseif($resInvolved['Class'] == "Medical/Emergency")
			{
				$medlist .= $involvedlist;				
			}
			
		}		
	}
	$personstable = "<div id=\"divReviseInvolvedPersons\">" .
					"<img src=\"images/x_mark_red.png\" height=\"24px\" style=\"cursor:pointer; position:absolute; right:10px; top:5px;\" onclick=\"CloseRevisions();\" />" .
					"<table align=\"center\">".
						"<tr>" .
							"<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions(".$ticketid.");\" />Disposition</td>" .
							"<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions2(".$ticketid.");\" />Logs</td>" .
							"<td><input type=\"radio\" name=\"editchoice\" checked=\"checked\" onClick=\"OpenRevisions3(".$ticketid.");\" />Person(s) Involved</td>" .
							"<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions4(".$ticketid.");\" />Vehicle(s) Involved</td>" .
						"</tr>" .
					"</table>";
					
	if(($victimlist) || ($suspectlist) || ($witnesslist) || ($noncomplist) || ($medlist))
	{
		if($witnesslist)
		{
			$personstable .= 	"<center><fieldset style=\"display:inline-block; text-align:left;\">
									<legend><i>Witness(es)</i></legend>
									<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">									  
									  <tbody>
										  ".$witnesslist."
									  </tbody>
									</table>
								</fieldset></center><br>";
		}
		if($suspectlist)
		{
			$personstable .= 	"<center><fieldset style=\"display:inline-block; text-align:left;\">
									<legend><i>Suspect(s)</i></legend>
									<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">									  
									  <tbody>
										  ".$suspectlist."
									  </tbody>
									</table>
								</fieldset></center><br>";
		}
		if($victimlist)
		{
			$personstable .= 	"<center><fieldset style=\"display:inline-block; text-align:left;\">
									<legend><i>Victim(s)</i></legend>
									<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">									  
									  <tbody>
										  ".$victimlist."
									  </tbody>
									</table>
								</fieldset></center><br>";
		}
		if($noncomplist)
		{
			$personstable .= 	"<center><fieldset style=\"display:inline-block; text-align:left;\">
									<legend><i>Non-Compliant(s)</i></legend>
									<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">									  
									  <tbody>
										  ".$noncomplist."
									  </tbody>
									</table>
								</fieldset></center><br>";
		}
		if($medlist)
		{
			$personstable .= 	"<center><fieldset style=\"display:inline-block; text-align:left;\">
									<legend><i>Medical/Emergency</i></legend>
									<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">									  
									  <tbody>
										  ".$medlist."
									  </tbody>
									</table>
								</fieldset></center><br>";
		}
		$personstable .= "<table align=\"center\">
						<tr>
							<td colspan=\"100%\" align=\"center\">
								<img src=\"images/update.png\" width=\"90px\" onclick=\"UpdateInvolved2();\" style=\"cursor:pointer;\">
							</td>
						</tr>
					</table>";
	}
	else
	{
		$personstable .= "<table align=\"center\"><tr><td colspan=\"100%\" align=\"center\">No Records</td></tr></table>";
	}
	$personstable .= "</div>";
	if($_SESSION['level'] == "User")
		{
			$personstable .= "<form id=\"reviseinvolvedform\" name=\"reviseinvolvedform\" action=\"user.php\" method=\"post\">";
		}
		elseif($_SESSION['level'] == "Admin")
		{
			$personstable .= "<form id=\"reviseinvolvedform\" name=\"reviseinvolvedform\" action=\"user-admin.php\" method=\"post\">";
		}
		elseif($_SESSION['level'] == "Super Admin")
		{
			$personstable .= "<form id=\"reviseinvolvedform\" name=\"reviseinvolvedform\" action=\"user-superadmin.php\" method=\"post\">";
		}
	$personstable .= "<input type=\"hidden\" id=\"editIPType\" name=\"editIPType\">
						<input type=\"hidden\" id=\"editIPFName\" name=\"editIPFName\">
						<input type=\"hidden\" id=\"editIPMName\" name=\"editIPMName\">
						<input type=\"hidden\" id=\"editIPLName\" name=\"editIPLName\">
						<input type=\"hidden\" id=\"editIPAddress\" name=\"editIPAddress\">
						<input type=\"hidden\" id=\"editIPContact\" name=\"editIPContact\">
						<input type=\"hidden\" id=\"editIPAge\" name=\"editIPAge\">
						<input type=\"hidden\" id=\"editIPGender\" name=\"editIPGender\">
						<input type=\"hidden\" id=\"editIPHeight\" name=\"editIPHeight\">
						<input type=\"hidden\" id=\"editIPWeight\" name=\"editIPWeight\">
						<input type=\"hidden\" id=\"editIPIDType\" name=\"editIPIDType\">
						<input type=\"hidden\" id=\"editIPIDNumber\" name=\"editIPIDNumber\">
						<input type=\"hidden\" id=\"editIPRemark\" name=\"editIPRemark\">
						<input type=\"hidden\" id=\"editIPIDNum\" name=\"editIPIDNum\">
					</form>";
	
if(!empty($personstable))
{
	echo $personstable;
}
else
{	
	echo "<table><tr><td colspan=\"100%\" align=\"center\">No Records</td></tr></table>";
}
?>
