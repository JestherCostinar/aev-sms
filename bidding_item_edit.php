<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$biddingEditID = $_GET['id'];

$biddingeditsql = mysqli_query($conn, "SELECT * FROM bidding_template_item WHERE id = " . $biddingEditID) or die(mysqli_error($conn));
$biddingitem = mysqli_fetch_assoc($biddingeditsql);

$ccmodal = '<form id="frmBiddingItemEdit" name="frmBiddingItemEdit" method="post" action="user-superadmin.php">
			<table id="frmBiddingItemEdit" name="frmBiddingItemEdit" width="90%" align="center" style="border-collapse:collapse;" border="1">
			<tr>
				<th colspan="100%">Edit Bidding Entry</th>
			</tr>
			<tr valign="top">
				<td>
					<table align="center">
						<tr>
							<td width="20%">Bidding Requirement Name:</td>
							<td width="80%"><input type="text" height="200px" id="txtEditBDRequirement" name="txtEditBDRequirement" value="' . $biddingitem["requirement_name"] . '"></td>
						</tr>
						<tr>
							<td width="20%">Category:</td>
							<td width="80%">								
								<select id="txtEditBDCategory" name="txtEditBDCategory">
									<option value="' . $biddingitem["category"] . '">' . $biddingitem["category"] . '</option>
									<option value="Legal">Legal</option>
									<option value="Technical">Technical</option>
									<option value="Financial">Financial</option>									
								</select>
							</td>
						</tr>						
						<tr>
							<td width="20%">Expiration Date Required?:</td>
							<td width="80%">								
								<select id="txtEditBDExpiry" name="txtEditBDExpiry">
									<option value="' . $biddingitem["has_expiry"] . '">' . $biddingitem["has_expiry"] . '</option>
									<option value="Yes">Yes</option>
									<option value="No">No</option>
								</select>
							</td>
						</tr>	
					</table>
				</td>
				<td width="50%" style="padding-right:10px;">
					<table width="100%">
						<tr>
							<td width="20%">Weight Percentage:</td>
							<td width="80%"><input type="number" min="0" id="txtweightpercentage" name="txtweightpercentage" value="' . $biddingitem["weight_percentage"] . '"></td>
						</tr>
						<tr>
							<td width="20%">Rating:</td>
							<td width="80%"><input type="number" min="0" id="txtrating" name="txtrating"  value="' . $biddingitem["rating"] . '"></td>
						</tr>
						<tr>
							<td width="20%">Total:</td>
							<td width="80%"><input type="number" min="0" id="txttotal" name="txttotal"  value="' . $biddingitem["total"] . '"></td>
						</tr>
						<tr valign="top">
							<td width="20%">Remarks:<br>Hover Help</td>
							<td width="80%">
								<textarea id="txtRemarks" name="txtRemarks" style="resize:none; height:100px; width:100%;">' . $biddingitem["remarks"] . '</textarea>
							</td>
						</tr>
					</table>
				</td>								
			</tr>
			<tr>
				<td colspan="100%" align="center">
					<input type="hidden" id="txtBiddingEditID" name="txtBiddingEditID" value="' . $biddingitem["id"] . '">
					<input type="submit" class="redbutton" id="btnEditBiddingSave" name="btnEditBiddingSave" value="Edit">
					<input type="button" class="redbutton" id="btnBiddingEditCancel" name="btnBiddingEditCancel" value="Cancel" onclick="editBiddingClose();">
				</td>
			</tr>
		</table>
		</form>';

if (!empty($ccmodal)) {
    echo $ccmodal;
} else {
    echo "<tr><td colspan='100%' align='center'>Cannot Edit right now.</td></tr>";
}
