<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
include("class.upload.php-master/src/class.upload.php");

$clicksource = $_GET['click'];
$biddingID = $_GET['id'];

$addbtnstat = '';
$biddingstatus = 'Active';
$editbtnstat = '';
$viewonly = "";
$disable = "";
$mainstatadd = "";
$mainstatedit = "";

$editstatus = '';
$editname = '';
$editcreatedate = '';
if ($clicksource == "Add") {
    $editbtnstat = 'style="display:none;"';
    $guardstatus = "Active";
    $mainstatadd = "Add";
} elseif ($clicksource == "Edit") {
    $addbtnstat  = 'style="display:none;"';
    $mainstatedit = "Edit";

    $getBiddingTemplateQuery = mysqli_query($conn, "SELECT * FROM bidding_template WHERE id = " . $biddingID);
    $getBiddingTemplate = mysqli_fetch_assoc($getBiddingTemplateQuery);

    if ($biddingID != 0) {
        $editstatus = '<option value= "' . $getBiddingTemplate['status'] . '">' . $getBiddingTemplate['status'] . '</option>';
        $editname = $getBiddingTemplate['bidding_name'];
        $editcreatedate = 'style="display:none;"';
    } else {
        $editstatus = '<option hidden>""</option>';
        $editcreatedate = '';
    }
} elseif ($clicksource == "View") {
    $addbtnstat  = 'style="display:none;"';
    $editbtnstat = 'style="display:none;"';
    $viewonly = "readonly";
    $disable = "disabled";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bidding_name = mysqli_real_escape_string($conn, $_POST['txtbiddingname']);
    $bidding_status = $_POST['txtbiddingstatus'];
    $created_at = $_POST['txtcreateddate'];
    $id = $_POST['txtbiddingid'];

    if (isset($_POST['btnsavebidding'])) {
        mysqli_query($conn, "INSERT INTO bidding_template(bidding_name, status, created_at) values('" . $bidding_name . "', '" . $bidding_status . "', '" . $created_at . "')") or die(mysqli_error($conn));
    }

    if (isset($_POST['btneditbidding'])) {
        mysqli_query($conn, "UPDATE bidding_template SET bidding_name ='" . $bidding_name . "', status ='" . $bidding_status . "' WHERE id = " . $id) or die(mysqli_error($conn));
    }
    header("Location: user-superadmin.php?last=BidReq");
}

$divcontent = '<form id="biddingTemplate" name="biddingTemplate" method="post" action="biddingtemplate.php">
					<table width="75%" align="center" bgcolor="#ededed" border="1px">
						<tr valign="top">
							<td style="border-width:0px;">
								<fieldset class="guardmaintabs" id="guardpersonaltab" style="border-width:thin">					
									<legend style="font-weight:bold">Bidding Requirements Information</legend>
									<table>
										<tr>
											<td>Bidding Name:</td>
											<td>
												<input type="text" id="txtbiddingid" name="txtbiddingid" required="required" readonly="readonly" style="display:none;" value="' . $biddingID . '" />
												<input type="text" id="txtbiddingname" name="txtbiddingname" required="required" class="addguards" value="' . $editname . '" />
											</td>
										</tr>
										<tr>
											<td>Status:</td>
                                            <td>												
                                                <select id="txtbiddingstatus" name="txtbiddingstatus" required="required" class="addguards" ' . $disable . ' >
                                                    "' . $editstatus . '"
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </td>										
                                        </tr>
										
										<tr ' . $editcreatedate . '>
											<td>Date Created:</td>
											<td><input type="date" id="txtcreateddate" name="txtcreateddate" required="required" class="addguards" readonly value="' . date('Y-m-d') . '" ' . $viewonly . ' /></td>
										</tr>
									</table>
								</fieldset>													
							</td>					
						</tr>
						<tr>
							<td colspan="100%" style="border-width:0px;">
								<table align="right">
									<tr>
										<td>
											<input type="hidden" id="editguardstat" name="editguardstat" value="' . $mainstatedit . '">
											<input type="hidden" id="addguardstat" name="addguardstat" value="' . $mainstatadd . '">
											<button id="btneditbidding" name="btneditbidding" class="redbutton" ' . $editbtnstat . '>Edit</buttom>
											<button id="btnsavebidding" name="btnsavebidding" class="redbutton" ' . $addbtnstat . '>Save</button>
											<button id="gback" name="gback" class="redbutton" onclick="biddingback();">Cancel</button>											
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>';


if (!empty($divcontent)) {
    echo $divcontent;
} else {
    echo "<tr><td colspan=\"100%\" align=\"center\">Record not found</td></tr>";
}
