<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$ccEditID = $_GET['id'];

$cceditsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE id = ".$ccEditID)or die(mysqli_error($conn));
$cceditres = mysqli_fetch_assoc($cceditsql);

/* $ccstandard = preg_replace( "/\n/", "<br>", $cceditres["standard"]);
$ccdetails = preg_replace( "/\n/", "<br>", $cceditres["details"]); */
$ccstandard = $cceditres["standard"];
$ccdetails = $cceditres["details"];
$cchovertext = $cceditres["hovertext"];

$ccmodal = '<form id="frmCCEdit" name="frmCCEdit" method="post" action="user-superadmin.php">
			<table id="tblCCShowEdit" name="tblCCShowEdit" width="90%" align="center" style="border-collapse:collapse;" border="1">
			<tr>
				<th colspan="100%">Edit Entry</th>
			</tr>
			<tr valign="top">
				<td>
					<table align="center">
						<tr>
							<td width="20%">Number:</td>
							<td width="80%"><input type="number" min="1" id="txtEditCCNumber2" name="txtEditCCNumber2" value="'.$cceditres["number"].'"></td>
						</tr>
						<tr>
							<td width="20%">Main Group:</td>
							<td width="80%">								
								<select id="txtEditCCGoal2" name="txtEditCCGoal2">
									<option value="'.$cceditres["goal"].'">'.$cceditres["goal"].'</option>
									<option value="Regulatory">Regulatory</option>
									<option value="Operational">Operational</option>									
								</select>
							</td>
						</tr>						
						
						<tr>
							<td width="20%">Sub Group:</td>
							<td width="80%"><input type="text" id="txtEditCCSubGoal2" name="txtEditCCSubGoal2" value="'.$cceditres["subgoal"].'"></td>
						</tr>
						<tr>
							<td width="20%">Frequency:</td>
							<td width="80%"><select id="txtEditCCFrequency2" name="txtEditCCFrequency2" >
									<option value="'.$cceditres["frequency"].'">'.$cceditres["frequency"].'</option>
									<option value="3 Years">3 Years</option>
									<option value="2 Years">2 Years</option>
									<option value="Annual">Annual</option>
									<option value="3x a Year">3x a Year</option>
									<option value="Quarterly">Quarterly</option>
									<option value="Monthly">Monthly</option>
									<option value="Weekly">Weekly</option>
									<option value="Daily">Daily</option>
									<option value="Perpetual">Perpetual</option>
									<option value="As Mandated">As Mandated</option>
								</select></td>
						</tr>
						<tr>
							<td width="20%">Percentage:</td>
							<td width="80%"><input type="number" min="0" id="txtEditCCDeduction2" name="txtEditCCDeduction2" value="'.$cceditres["deduction"].'"></td>
						</tr>
						
					</table>
				</td>
				<td width="50%" style="padding-right:10px;">
					<table width="100%">
						<tr valign="top">
							<td width="20%">Standard:</td>
							<td width="80%">
								<textarea id="txtEditCCStandard2" name="txtEditCCStandard2" style="resize:none; height:50px; width:100%;">'.$ccstandard.'</textarea>
							</td>
						</tr>
						<tr valign="top">
							<td width="20%">Metrics:</td>
							<td width="80%">
								<textarea id="txtEditCCDetails2" name="txtEditCCDetails2" style="resize:none; height:100px; width:100%;">'.$ccdetails.'</textarea>
							</td>
						</tr>
						<tr valign="top">
							<td width="20%">Details:<br>Hover Help</td>
							<td width="80%">
								<textarea id="txtEditCCHover2" name="txtEditCCHover2" style="resize:none; height:100px; width:100%;">'.$cchovertext.'</textarea>
							</td>
						</tr>
					</table>
				</td>								
			</tr>
			<tr>
				<td colspan="100%" align="center">
					<input type="hidden" id="txtCCEditID2" name="txtCCEditID2" value="'.$cceditres["id"].'">
					<input type="submit" class="redbutton" id="btnEditCCSave2" name="btnEditCCSave2" value="Edit">
					<input type="button" class="redbutton" id="btnEditCCExit2" name="btnEditCCExit2" value="Cancel" onclick="editCCClose();">
				</td>
			</tr>
		</table>
		</form>';

if(!empty($ccmodal))
{
	echo $ccmodal;
}
else
{
	echo "<tr><td colspan='100%' align='center'>Cannot Edit right now.</td></tr>";
}
?>