<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$bulist = "";
$busql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE expro = 0");
while($bures = mysqli_fetch_assoc($busql))
{
	$bulist .=	"<option value='".$bures['id']."'>".$bures['bu']."</option>";
}

$resulttable =	"<div class='displayIA' id='divaddIA' name='divaddIA'>
				<form id='frmaddIA' name='frmaddIA' method='post' action='main-post.php'>
				<table align='left' style='left-margin;24px;'>
					<tr>
						<td align='left' style='font-weight:bold'>Add Incident Audit Results <br><br></td>
					</tr>					
					<tr>
						<td>Business Unit:</td>
						<td>
							<select id='seladdIABU' name='seladdIABU'>
								".$bulist."
							</select>
						</td>
					</tr>
					<tr>
						<td>Year:</td>
						<td><input type='number' id='numaddIAyear' name='numaddIAyear' min='2020' value='2020'/></td>
					</tr>
					<tr>
						<td>Month:</td>
						<td>
							<select id='seladdIAmonth' name='seladdIAmonth'>
								<option value='1'>January</option>
								<option value='2'>February</option>
								<option value='3'>March</option>
								<option value='4'>April</option>
								<option value='5'>May</option>
								<option value='6'>June</option>
								<option value='7'>July</option>
								<option value='8'>August</option>
								<option value='9'>September</option>
								<option value='10'>October</option>
								<option value='11'>November</option>
								<option value='12'>December</option>							
							</select>
						</td>
					</tr>
					<tr>
						<td>Total Incidents:</td>
						<td><input type='number' id='numaddIAtotal' name='numaddIAtotal' min='0' value='0' /></td>
					</tr>
					<tr>
						<td>Miss:</td>
						<td><input type='number' id='numaddIAmiss' name='numaddIAmiss' min='0' value='0' /></td>
					</tr>
					<tr>
						<td colspam='100%'><input type='submit' class='redbutton' name='btnaddIA' id='btnaddIA'></td>
					</tr>
				</table>
				</form>
				</div><br>";
				
$resulttable .=	"<div class='displayIA' id='divviewIA' name='divviewIA' style='display:none;'>
					<table id='tblIAconsolidation' name='tblIAconsolidation'>
						<thead>
							<tr>
								<td>Year:</td>
								<td>
									<input type='number' id='numIAsearchyear' name='numIAsearchyear' min='2020' value='2020'>
									<img src='images/Search-icon.png' height='24px' id='btnSearchIACons' name='btnSearchIACons onclick=\'searchIncAcc();\''>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan='100%'>
									<div id='tbodydisplayIAconso' name='tbodydisplayIAconso'>
									</div>
								</td>
							</rr>
						</tbody>
					</table>
				</div>";
				
if($resulttable)
{
	echo $resulttable;
}
else
{
	echo "No records";
}

?>