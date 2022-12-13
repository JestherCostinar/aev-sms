<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$biddingID = $_GET['id'];

$legaltable = "";
$technicaltable = "";
$financialtable = "";

$getBiddingTemplateQuery = mysqli_query($conn, "SELECT * FROM bidding_template WHERE id = " . $biddingID);
$getBiddingTemplate = mysqli_fetch_assoc($getBiddingTemplateQuery);

$biddingItemQuery = mysqli_query($conn, "SELECT * FROM bidding_template_item WHERE template_id = " . $biddingID);
$counter = 1;
while ($getBiddingItems = mysqli_fetch_assoc($biddingItemQuery)) {


    if ($getBiddingItems['category'] == "Legal") {
        $legaltable .= "<tr align=\"center\">" .
            "<td align=\"right\" width=\"3%\">" . $counter++ . "</td>" .
            "<td align=\"center\" style=\"background-color: #f9c8c8\">" . $getBiddingItems['requirement_name'] . "</td>" .
            "<td align=\"center\" width=\"5%\">" . $getBiddingItems['weight_percentage'] . '%' . "</td>" .
            "<td align=\"center\" width=\"5%\"><img src='images/edit2.png' height='28px' style='cursor:pointer; vertical-align:middle;' onclick='editbiddingshow(" . $getBiddingItems['id'] . ");'> <img src='images/delete.png' style='cursor:pointer; vertical-align:middle;' onclick='deleteItem(" . $getBiddingItems['id'] . ", \"Bidding Item\");'></td>" .
            "</tr>";
    } else if ($getBiddingItems['category'] == "Technical") {
        $technicaltable
            .= "<tr align=\"center\">" .
            "<td align=\"right\" width=\"3%\">" . $counter++ . "</td>" .
            "<td align=\"center\" style=\"background-color: rgb(198,217,240)\">" . $getBiddingItems['requirement_name'] . "</td>" .
            "<td align=\"center\" width=\"5%\">" . $getBiddingItems['weight_percentage'] . '%' . "</td>" .
            "<td align=\"center\" width=\"5%\"><img src='images/edit2.png' height='28px' style='cursor:pointer; vertical-align:middle;' onclick='editbiddingshow(" . $getBiddingItems['id'] . ");'> <img src='images/delete.png' style='cursor:pointer; vertical-align:middle;' onclick='deleteItem(" . $getBiddingItems['id'] . ", \"Bidding Item\");'></td>" .
            "</tr>";
    } else if ($getBiddingItems['category'] == "Financial") {
        $financialtable
            .= "<tr align=\"center\">" .
            "<td align=\"right\" width=\"3%\">" . $counter++ . "</td>" .
            "<td align=\"center\" style=\"background-color: rgb(234,241,221)\">" . $getBiddingItems['requirement_name'] . "</td>" .
            "<td align=\"center\" width=\"5%\">" . $getBiddingItems['weight_percentage'] . '%' . "</td>" .
            "<td align=\"center\" width=\"5%\"><img src='images/edit2.png' height='28px' style='cursor:pointer; vertical-align:middle;' onclick='editbiddingshow(" . $getBiddingItems['id'] . ");'> <img src='images/delete.png' style='cursor:pointer; vertical-align:middle;' onclick='deleteItem(" . $getBiddingItems['id'] . ", \"Bidding Item\");'></td>" .
            "</tr>";
    }
}
$num_rows = mysqli_num_rows($biddingItemQuery);
if ($num_rows > 0) {
    $isDisplay = 'display: ';
} else {
    $isDisplay = 'display: none;';
}


// <!-- ------------------ BIDDING REQUIREMENT ------------------>
$bidReqItemDiv = "<table align='left' style='padding-left:24px;'>
		<tr>
			<td align='left' style='font-weight:bold'>" . $getBiddingTemplate['bidding_name'] . " <a href=\"javascript:void(0)\" style=\"color: blue\" onclick=\"addBiddingTemplate('" . $biddingID . "', 'Edit');\" > [ Edit ] </a> <br><br></td>
		</tr>
		<tr>
			<td colspan='100%' align='left'>
				<form id='formbiddingitem' name='formbiddingitem' action='user-superadmin.php' method='post'>
					<input type='hidden' id='biddingName' name='biddingName'>
					<input type='hidden' id='biddingCategory' name='biddingCategory'>
					<input type='hidden' id='biddingexpiry' name='biddingexpiry'>
					<input type='hidden' id='biddingPercentage' name='biddingPercentage'>
					<input type='hidden' id='biddingTotal' name='biddingTotal'>
					<input type='hidden' id='biddingRating' name='biddingRating'>
					<input type='hidden' id='biddingRemarks' name='biddingRemarks'>

					<input type='hidden' id='templateid' name='templateid' value='" . $biddingID . "'>
				</form>
			</td>
		</tr>
	</table>		
	<table id='tblCCShow' name='tblCCShow' width='90%' align='center' border-collapse:collapse;' border='1'>
		<tr>
			<th colspan='100%'>Add Bidding Requirements</th>
		</tr>
		<tr valign='top' >
			<td>
				<table align='center' style=\"margin: 15px 0\">
					<tr>
						<td width='20%'>Bidding Requirements Name:</td>
						<td width='80%' style=\"display: none\"><input type='text' id='counthide' name='counthide' value='1'></td>
						<td width='80%'><input type='text' id='txtRequirementName' name='txtRequirementName'></td>
					</tr>
					<tr>
						<td width='20%'>Category:</td>
						<td width='80%'>								
							<select id='txtCategory' name='txtCategory' >
								<option value=''>-Category-</option>
								<option value='Legal'>Legal</option>
								<option value='Technical'>Technical</option>
								<option value='Financial'>Financial</option>							
							</select>
						</td>
					</tr>
					<tr>
						<td width='20%'>Expiration Date Required?:</td>
						<td width='80%'>								
							<select id='txtExpiry' name='txtExpiry' >
								<option value=''>-Option-</option>
								<option value='Yes'>Yes</option>
								<option valie='no'>No</option>									
							</select>
						</td>
					</tr>
				</table>
			</td>
			<td width='50%' style='padding-right:10px;'>
					<table width='100%'>
						<tr>
							<td width='20%'>Weight Percentage:</td>
							<td width='80%'><input type='number' min='0' id='txtweightpercentage' name='txtweightpercentage'></td>
						</tr>
						<tr>
							<td width='20%'>Rating:</td>
							<td width='80%'><input type='number' min='0' id='txtrating' name='txtrating'></td>
						</tr>
						<tr>
							<td width='20%'>Total:</td>
							<td width='80%'><input type='number' min='0' id='txttotal' name='txttotal'></td>
						</tr>
						<tr valign='top'>
							<td width='20%'>Remarks:<br>Hover Help</td>
							<td width='80%'>
								<textarea id='txtRemarks' name='txtRemarks' style='resize:none; height:100px; width:100%;'></textarea>
							</td>
						</tr>
					</table>
				</td>	
		</tr>
		<tr>
			<td colspan='100%' align='center'><button class='redbutton' onclick='addBiddingEntry();'>Add</button></td>
		</tr>
	</table>		
	<br>
	<br>
	<table width='95%' border='1' height='50px' align='center' style=' border-collapse:collapse; " . $isDisplay . "'>
		<thead >
			<tr style='background-color: #dfdfdf';>
				<th>" . $getBiddingTemplate['bidding_name'] . " </th>
				<th width=\"10%\">Weight Percentage</th>			
			</tr>
		</thead>
	</table>
	<table width='95%' border='1' align='center' style=' border-collapse:collapse; " . $isDisplay . "'>
		<thead >
			<tr style='background-color: red';>
				<th align='left'>I. LEGAL</th>														
				<th width=\"5%\">100 %</th>
				<th width=\"5%\"></th>
			</tr>
		</thead>
	</table>
	<table width='95%' border='1' align='center' style='border-collapse:collapse; " . $isDisplay . "'>
		<tbody id='tbodyNewCC' name='tbodyNewCC'>
			$legaltable
		</tbody>
	</table>
	<table width='95%' border='1' align='center' style=' border-collapse:collapse; " . $isDisplay . "'>
		<thead >
			<tr style='background-color: rgb(0,112,192)';>
				<th align='left'>II. TECHNICAL</th>														
				<th width=\"10%\">100 %</th>
			</tr>
		</thead>
	</table>
	<table width='95%' border='1' align='center' style='border-collapse:collapse; " . $isDisplay . "'>
		<tbody id='tbodyNewCC' name='tbodyNewCC'>
			$technicaltable
		</tbody>
	</table>
	<table width='95%' border='1' align='center' style=' border-collapse:collapse; " . $isDisplay . "'>
		<thead >
			<tr style='background-color: rgb(146,208,80)';>
				<th align='left'>III. FINANCIAL</th>														
				<th width=\"10%\">100 %</th>
			</tr>
		</thead>
	</table>
	<table width='95%' border='1' align='center' style='border-collapse:collapse; " . $isDisplay . "' id='tblbiddingitem' name='tblbiddingitem'>
		<tbody id='tbodyNewCC' name='tbodyNewCC'>
			$financialtable
		</tbody>
	</table>
	
	<table align='center'>
		<tr>
			<td><button class='redbutton' id='btnSaveBiddingItem' name='btnSaveBiddingItem' style='display:none;' onclick='saveBiddingItem();'>Save</button></td>
		</tr>
	</table>
	";
if (!empty($bidReqItemDiv)) {
    echo $bidReqItemDiv;
}
