<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$biddingID = $_GET['id'];
$bu_ID = $_GET['bu_id'];


$evaluatesql = mysqli_query($conn, "SELECT * FROM bidding_evaluation WHERE  bidding_id = '" . $biddingID . "' AND bu_id = '" . $bu_ID . "'") or die(mysqli_error($conn));
$getEvaluateData = mysqli_fetch_assoc($evaluatesql);


$evaluate_model = '<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeBiddingEvaluateSecAgencyModal();" />
        <table align="center" width="100%" border="1" style="border-collapse:collapse;">
			<tr>
				<td colspan="100%">
					<div id="evaluationHeader" name="evaluationHeader" style="padding: 10px" class="evaluationHeaderdivs">
                        <table width="100%" align="center"  width="100%" border="1" style="border-collapse:collapse; padding: 10px">
                            <tr class="whiteonblack">
                                <th>Evaluation Sheet</th>
                            </tr>
                        </table>
					</div>
                    <div id="addEvaluationDiv" name="addEvaluationDiv" class="biddingaddevaluationdiv" style="cursor:pointer;  padding: 10px">
                        <form id="frmEvaluation" name="frmEvaluation" method="post" action="user-admin.php">
                            <table border="1px" width="100%" align="center" style="border-collapse:collapse">
                                <tr>
                                    <th rowspan="3">Qualification</th>
                                    <th rowspan="3">Category</th>
                                </tr>
                                <tr>
                                    <th colspan="3">  --  </th>
                                </tr>
                                <tr>
                                    <th colspan="3">  Agency  </th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th ></th>
                                    <th>Rating</th>
                                    <th>%</th>
                                    <th>Total</th>
                                </tr>
                                <tr>
                                    <th>Technical Capabilities</th>
                                    <th>35%</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td rowspan="7">Area of Expertise</td>
                                    <td >Physical Asset Security (5)</td>
                                    <input type="hidden" name="bidding_id" style="background: #f8ffb4" value="' . $biddingID . '">
                                    <td><input type="number" name="evaluate_pas" style="background: #f8ffb4" value="' . $getEvaluateData["pas_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td>Executive Protection (5)</td>
                                    <td><input type="number" name="evaluate_ep" style="background: #f8ffb4" value="' . $getEvaluateData["ep_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td>Crisis Management (5)</td>
                                    <td><input type="number" name="evaluate_cm" style="background: #f8ffb4" value="' . $getEvaluateData["cm_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td>Occupational, Safety, Health (5)</td>
                                    <td><input type="number" name="evaluate_osh" style="background: #f8ffb4" value="' . $getEvaluateData["osh_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr> 
                                <tr>
                                    <td>Investigation (5)</td>
                                    <td><input type="number" name="evaluate_i" style="background: #f8ffb4" value="' . $getEvaluateData["i_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr> 
                                <tr>
                                    <td>Human Right (5)</td>
                                    <td><input type="number" name="evaluate_hr" style="background: #f8ffb4" value="' . $getEvaluateData["hr_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td>Community Relations (5)</td>
                                    <td><input type="number" name="evaluate_cr" style="background: #f8ffb4" value="' . $getEvaluateData["cr_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr style="background: #e3e3e3">
                                    <th colspan="100%" style="color: #e3e3e3">--</th>
                                </tr>
                                <tr>
                                    <th>Competency/Reliability</th>
                                    <th>35%</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td colspan="2">Work Experience (5)</td>
                                    <td><input type="number" name="evaluate_we" style="background: #f8ffb4" value="' . $getEvaluateData["we_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Legal Compliance (5)</td>
                                    <td><input type="number" name="evaluate_lc" style="background: #f8ffb4" value="' . $getEvaluateData["lc_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Retirement Program (5)</td>
                                    <td><input type="number" name="evaluate_rp" style="background: #f8ffb4" value="' . $getEvaluateData["rp_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Project Management (5)</td>
                                    <td><input type="number" name="evaluate_pm" style="background: #f8ffb4" value="' . $getEvaluateData["pm_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Availability of Supplies and Equipment (5)</td>
                                    <td><input type="number" name="evaluate_ase" style="background: #f8ffb4" value="' . $getEvaluateData["ase_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Site Familiarity (5)</td>
                                    <td><input type="number" name="evaluate_sf" style="background: #f8ffb4" value="' . $getEvaluateData["sf_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Power Plant (5)</td>
                                    <td><input type="number" name="evaluate_pp" style="background: #f8ffb4" value="' . $getEvaluateData["pp_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr style="background: #e3e3e3">
                                    <th colspan="100%" style="color: #e3e3e3">--</th>
                                </tr>
                                <tr>
                                    <th>Commercial</th>
                                    <th>30%</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td colspan="2"> Financial Stability</td>
                                    <td><input type="number" name="evaluate_fs" style="background: #ededed" readonly value="' . $getEvaluateData["fs_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">BID Offer *to be filled up after receiving bids</td>
                                    <td><input type="number" name="evaluate_bid_offer" style="background: #ededed" readonly value="' . $getEvaluateData["bid_offer_score"] . '"></td>
                                    <td>5%</td>
                                    <td style="background: #c7c7c7"></td>
                                </tr>
                                <tr style="background: #e3e3e3">
                                    <th colspan="100%" style="color: #e3e3e3">--</th>
                                </tr>
                                <tfoot>
                                    <tr bgcolor="#CCCCCC" align="center">
                                        <td align="center">Remarks:</td>
                                        <td align="center" colspan="4"><textarea id="evaluate_remarks"  name="evaluate_remarks" style="resize:none; background: #f8ffb4; width:100%;">' . $getEvaluateData["remarks"] . '</textarea></td>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            <table width="100%" align="center">
                                <tr>
                                    <td align="right">
                                    	<input type="submit" id="btnsaveevaluation"  class="redbutton" name="btnsaveevaluation" width="100px" style="cursor:pointer;" value="Save"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
					</div>
				</td>
			</tr>
		</table>';

if (!empty($evaluate_model)) {
    echo $evaluate_model;
} else {
    echo "<tr><td colspan='100%' align='center'>No result</td></tr>";
}
