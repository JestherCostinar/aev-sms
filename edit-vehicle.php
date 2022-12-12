<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");

	$ticketid = $_GET['ticket_id'];
	
	$queryVehicle = mysqli_query($conn, "SELECT * FROM incident_vehicle WHERE ticket_id = ". $ticketid);
	if($queryVehicle)
	{
		while($resVehicle = mysqli_fetch_assoc($queryVehicle))
		{
			$vehiclelist .= "<table align='center'>
								<tr>
									<td>Owner:</td>
									<td><input type=\"text\" class=\"veOwner\" id=\"vOwner".$resVehicle['id']."\" value=\"".$resVehicle['owner']."\"></td>
									<td>Plate Number:</td>
									<td><input type=\"text\" class=\"vePlateNo\" id=\"vPlateNo".$resVehicle['id']."\" value=\"".$resVehicle['plate_no']."\"></td>
								</tr>
								<tr>
									<td>Color:</td>
									<td><input type=\"text\" class=\"veColor\" id=\"vColor".$resVehicle['id']."\" value=\"".$resVehicle['color']."\"></td>
									<td>Type:</td>
									<td><input type=\"text\" class=\"veType\" id=\"vType".$resVehicle['id']."\" value=\"".$resVehicle['type']."\"></td>									
								</tr>
								<tr>
									<td>Make:</td>
									<td><input type=\"text\" class=\"veMake\" id=\"vMake".$resVehicle['id']."\" value=\"".$resVehicle['make']."\"></td>
									<td>Model:</td>
									<td><input type=\"text\" class=\"veModel\" id=\"vModel".$resVehicle['id']."\" value=\"".$resVehicle['model']."\"></td>									
								</tr>								
								<tr>									
									<td>Remarks:</td>
									<td colspan=\"100%\"><input type=\"text\" size=\"50%%\" class=\"veRemarks\" id=\"wRemarks".$resVehicle['id']."\" value=\"".$resVehicle['remarks']."\"></td>
								</tr>
								<tr>
									<td align=\"right\" colspan=\"100%\">
										
										<input type=\"hidden\" class=\"veNumber\" value=\"".$resVehicle['id']."\">
										<input type=\"hidden\" class=\"veUpdateType\" value=\"vehicle\">
									</td>
								</tr>
							</table><br>";
		}
		
	}
	$vehicletable = "<div id=\"divReviseInvolvedVehicles\">" .
					"<img src=\"images/x_mark_red.png\" height=\"24px\" style=\"cursor:pointer; position:absolute; right:10px; top:5px;\" onclick=\"CloseRevisions();\" />" .
					"<table align=\"center\">".
						"<tr>" .
							"<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions(".$ticketid.");\" />Disposition</td>" .
							"<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions2(".$ticketid.");\" />Logs</td>" .
							"<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions3(".$ticketid.");\" />Person(s) Involved</td>" .
							"<td><input type=\"radio\" name=\"editchoice\" checked=\"checked\" onClick=\"OpenRevisions4(".$ticketid.");\" />Vehicle(s) Involved</td>" .
						"</tr>" .
					"</table>";
	if($vehiclelist)
	{
		$vehiclelist .= "<table align=\"center\">
						<tr>
							<td colspan=\"100%\" align=\"center\">
								<img src=\"images/update.png\" width=\"90px\" onclick=\"UpdateVehicle();\" style=\"cursor:pointer;\">
							</td>
						</tr>
					</table>";
		$vehicletable .= 	"<center><fieldset style=\"display:inline-block; text-align:left;\">
									<legend><i>Vehicle(s)</i></legend>
									<table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">									  
									  <tbody>
										  ".$vehiclelist."
									  </tbody>
									</table>
								</fieldset></center><br>";
		if($_SESSION['level'] == "User")
		{
			$vehicletable .= "<form id=\"revisevehicleform\" name=\"revisevehicleform\" action=\"user.php\" method=\"post\">";
		}
		elseif($_SESSION['level'] == "Admin")
		{
			$vehicletable .= "<form id=\"revisevehicleform\" name=\"revisevehicleform\" action=\"user-admin.php\" method=\"post\">";
		}
		elseif($_SESSION['level'] == "Super Admin")
		{
			$vehicletable .= "<form id=\"revisevehicleform\" name=\"revisevehicleform\" action=\"user-superadmin.php\" method=\"post\">";
		}
		$vehicletable .= "<input type=\"hidden\" id=\"editVOwner\" name=\"editVOwner\">
							<input type=\"hidden\" id=\"editVPlateNo\" name=\"editVPlateNo\">
							<input type=\"hidden\" id=\"editVColor\" name=\"editVColor\">
							<input type=\"hidden\" id=\"editVType\" name=\"editVType\">
							<input type=\"hidden\" id=\"editVMake\" name=\"editVMake\">
							<input type=\"hidden\" id=\"editVModel\" name=\"editVModel\">
							<input type=\"hidden\" id=\"editVRemarks\" name=\"editVRemarks\">
							<input type=\"hidden\" id=\"editVIDNumber\" name=\"editVIDNumber\">
						</form>";
	}
	else
	{
		$vehicletable .= "<table align=\"center\"><tr><td colspan=\"100%\" align=\"center\">No Records</td></tr></table>";
	}
if(!empty($vehicletable))
{
	echo $vehicletable;
}
else
{	
	echo "<table><tr><td colspan=\"100%\" align=\"center\">No Records</td></tr></table>";
}
?>