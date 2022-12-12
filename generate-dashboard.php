<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$admintest = "";
if($_SESSION['level'] == "Admin")
{
	$admintest = " WHERE bu_id = ".$bu;
}


$graphtype = $_GET['type'];
$auditbu = $_GET['auditbu'];

if($auditbu)
{
	$admintest = " WHERE bu_id = ".$auditbu;
}

$chart_ticks = array();
$chart_data = array();
$chart_ticks2 = array();
$chart_data2 = array();
$resultdata = "";
$resultdata2 = array();
$resultdata3 = "";
$condbu = "";
$condbu2 = "";
$exprovariable = 0;
$listOfBU = array();
$overview = $_GET['multibu'];

if($_SESSION['level'] == 'Admin')
{
	$condbu = " bu = ".$bu." AND ";
	$condbu2 = " bu_id = ".$bu." AND ";
	if($overview)
	{
		$buarray = array();
		$multibusql = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id = ".$_SESSION['id']);
		while($multibures = mysqli_fetch_assoc($multibusql))
		{
			$buarray[] = $multibures['bu_id'];
		}
		if($buarray)
		{
			$buin = implode(", ", $buarray);
			$condbu = " bu IN(".$buin.") ";
		}
	}	
}

// Check if the user level have a Multi Admin access.
if($_SESSION['multi-admin']) {
	$listOfIDQuery = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id ='" . $_SESSION['id'] . "'");
	$buCount = 0;
	while ($list = mysqli_fetch_assoc($listOfIDQuery)) {
		$listOfBU[$buCount] = $list['bu_id'];
		$buCount++;
	}
}

// Dashboard - Meter
if($graphtype == "meter")
{
	$incidentcount = 0;
	if ($_SESSION['multi-admin']) {
		$incidentcountsql = mysqli_query($conn,"SELECT COUNT(ticket.id) AS Incident_Count, bu_mst.bu as bu_name FROM ticket INNER JOIN bu_mst ON ticket.bu = bu_mst.id WHERE ticket.bu IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND ticket_type = 1 AND MONTH(dateadded) = MONTH(now()) AND YEAR(dateadded) = YEAR(now()) AND description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative'));");
	} else {
		$incidentcountsql = mysqli_query($conn,"SELECT COUNT(id) AS Incident_Count FROM ticket WHERE ".$condbu." ticket_type = 1 AND MONTH(dateadded) = MONTH(now()) AND YEAR(dateadded) = YEAR(now()) AND description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative'));");
	}

	$incidentcountres = mysqli_fetch_assoc($incidentcountsql);
	$incidentcount = $incidentcountres['Incident_Count'];
	if($incidentcount)
	{
		$resultdata = $incidentcount;
	}
	else
	{
		$resultdata = 0;
	}
}

// Dashboard - Line Graph
elseif($graphtype == "line")
{
	$incidentline = "";
	if ($_SESSION['multi-admin']) {
		$incidentcountsql = mysqli_query($conn,"SELECT 
		SUM(CASE MONTH(dateadded) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
		SUM(CASE MONTH(dateadded) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
		SUM(CASE MONTH(dateadded) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
		SUM(CASE MONTH(dateadded) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
		SUM(CASE MONTH(dateadded) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
		SUM(CASE MONTH(dateadded) WHEN 6 THEN 1 ELSE 0 END) AS 'June',
		SUM(CASE MONTH(dateadded) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
		SUM(CASE MONTH(dateadded) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
		SUM(CASE MONTH(dateadded) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
		SUM(CASE MONTH(dateadded) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
		SUM(CASE MONTH(dateadded) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
		SUM(CASE MONTH(dateadded) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
		SUM(CASE YEAR(dateadded) WHEN YEAR(now()) THEN 1 ELSE 0 END) AS 'TOTAL'								
		FROM
		ticket
		WHERE
		bu IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND
		YEAR(dateadded) = YEAR(now()) AND ticket_type = 1 AND description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative'))");
$incidentcountres = mysqli_fetch_assoc($incidentcountsql);
$incidentline = $incidentcountres['January'].",".$incidentcountres['February'].",".$incidentcountres['March'].",".$incidentcountres['April'].",".$incidentcountres['May'].",".$incidentcountres['June'].",".$incidentcountres['July'].",".$incidentcountres['August'].",".$incidentcountres['September'].",".$incidentcountres['October'].",".$incidentcountres['November'].",".$incidentcountres['December']."//".$incidentcountres['TOTAL'];
$incidentcountsql2 = mysqli_query($conn,"SELECT 
		SUM(CASE MONTH(dateadded) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
		SUM(CASE MONTH(dateadded) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
		SUM(CASE MONTH(dateadded) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
		SUM(CASE MONTH(dateadded) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
		SUM(CASE MONTH(dateadded) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
		SUM(CASE MONTH(dateadded) WHEN 6 THEN 1 ELSE 0 END) AS 'June',
		SUM(CASE MONTH(dateadded) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
		SUM(CASE MONTH(dateadded) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
		SUM(CASE MONTH(dateadded) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
		SUM(CASE MONTH(dateadded) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
		SUM(CASE MONTH(dateadded) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
		SUM(CASE MONTH(dateadded) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
		SUM(CASE YEAR(dateadded) WHEN (YEAR(now()) - 1) THEN 1 ELSE 0 END) AS 'TOTAL'
		FROM
		ticket
		WHERE
		bu IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND
		YEAR(dateadded) = (YEAR(now()) -1 ) AND ticket_type = 1 AND description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative'))");
} else {
	$incidentcountsql = mysqli_query($conn,"SELECT 
											SUM(CASE MONTH(dateadded) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
											SUM(CASE MONTH(dateadded) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
											SUM(CASE MONTH(dateadded) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
											SUM(CASE MONTH(dateadded) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
											SUM(CASE MONTH(dateadded) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
											SUM(CASE MONTH(dateadded) WHEN 6 THEN 1 ELSE 0 END) AS 'June',
											SUM(CASE MONTH(dateadded) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
											SUM(CASE MONTH(dateadded) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
											SUM(CASE MONTH(dateadded) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
											SUM(CASE MONTH(dateadded) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
											SUM(CASE MONTH(dateadded) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
											SUM(CASE MONTH(dateadded) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
											SUM(CASE YEAR(dateadded) WHEN YEAR(now()) THEN 1 ELSE 0 END) AS 'TOTAL'								
											FROM
											ticket
											WHERE
											".$condbu."
											YEAR(dateadded) = YEAR(now()) AND ticket_type = 1 AND description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative'))");
  $incidentcountres = mysqli_fetch_assoc($incidentcountsql);
  $incidentline = $incidentcountres['January'].",".$incidentcountres['February'].",".$incidentcountres['March'].",".$incidentcountres['April'].",".$incidentcountres['May'].",".$incidentcountres['June'].",".$incidentcountres['July'].",".$incidentcountres['August'].",".$incidentcountres['September'].",".$incidentcountres['October'].",".$incidentcountres['November'].",".$incidentcountres['December']."//".$incidentcountres['TOTAL'];
  $incidentcountsql2 = mysqli_query($conn,"SELECT 
											SUM(CASE MONTH(dateadded) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
											SUM(CASE MONTH(dateadded) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
											SUM(CASE MONTH(dateadded) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
											SUM(CASE MONTH(dateadded) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
											SUM(CASE MONTH(dateadded) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
											SUM(CASE MONTH(dateadded) WHEN 6 THEN 1 ELSE 0 END) AS 'June',
											SUM(CASE MONTH(dateadded) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
											SUM(CASE MONTH(dateadded) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
											SUM(CASE MONTH(dateadded) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
											SUM(CASE MONTH(dateadded) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
											SUM(CASE MONTH(dateadded) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
											SUM(CASE MONTH(dateadded) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
											SUM(CASE YEAR(dateadded) WHEN (YEAR(now()) - 1) THEN 1 ELSE 0 END) AS 'TOTAL'
											FROM
											ticket
											WHERE
											".$condbu."
											YEAR(dateadded) = (YEAR(now()) - 1) AND ticket_type = 1 AND description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative'))");
										}
  $incidentcountres2 = mysqli_fetch_assoc($incidentcountsql2);
  $incidentline .= "//".$incidentcountres2['January'].",".$incidentcountres2['February'].",".$incidentcountres2['March'].",".$incidentcountres2['April'].",".$incidentcountres2['May'].",".$incidentcountres2['June'].",".$incidentcountres2['July'].",".$incidentcountres2['August'].",".$incidentcountres2['September'].",".$incidentcountres2['October'].",".$incidentcountres2['November'].",".$incidentcountres2['December']."//".$incidentcountres2['TOTAL'];
  $resultdata = $incidentline;
}
elseif($graphtype == "line2")
{
	$incidentline = "";
	$incidentcountsql = mysqli_query($conn,"SELECT 
											SUM(CASE MONTH(dateadded) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
											SUM(CASE MONTH(dateadded) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
											SUM(CASE MONTH(dateadded) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
											SUM(CASE MONTH(dateadded) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
											SUM(CASE MONTH(dateadded) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
											SUM(CASE MONTH(dateadded) WHEN 6 THEN 1 ELSE 0 END) AS 'June',
											SUM(CASE MONTH(dateadded) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
											SUM(CASE MONTH(dateadded) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
											SUM(CASE MONTH(dateadded) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
											SUM(CASE MONTH(dateadded) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
											SUM(CASE MONTH(dateadded) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
											SUM(CASE MONTH(dateadded) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
											SUM(CASE YEAR(dateadded) WHEN YEAR(now()) THEN 1 ELSE 0 END) AS 'TOTAL'								
											FROM
											ticket
											WHERE
											".$condbu."
											YEAR(dateadded) = YEAR(now()) AND ticket_type = 2");
  $incidentcountres = mysqli_fetch_assoc($incidentcountsql);
  $incidentline = $incidentcountres['January'].",".$incidentcountres['February'].",".$incidentcountres['March'].",".$incidentcountres['April'].",".$incidentcountres['May'].",".$incidentcountres['June'].",".$incidentcountres['July'].",".$incidentcountres['August'].",".$incidentcountres['September'].",".$incidentcountres['October'].",".$incidentcountres['November'].",".$incidentcountres['December']."//".$incidentcountres['TOTAL'];
  $incidentcountsql2 = mysqli_query($conn,"SELECT 
											SUM(CASE MONTH(dateadded) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
											SUM(CASE MONTH(dateadded) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
											SUM(CASE MONTH(dateadded) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
											SUM(CASE MONTH(dateadded) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
											SUM(CASE MONTH(dateadded) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
											SUM(CASE MONTH(dateadded) WHEN 6 THEN 1 ELSE 0 END) AS 'June',
											SUM(CASE MONTH(dateadded) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
											SUM(CASE MONTH(dateadded) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
											SUM(CASE MONTH(dateadded) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
											SUM(CASE MONTH(dateadded) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
											SUM(CASE MONTH(dateadded) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
											SUM(CASE MONTH(dateadded) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
											SUM(CASE YEAR(dateadded) WHEN (YEAR(now()) - 1) THEN 1 ELSE 0 END) AS 'TOTAL'
											FROM
											ticket
											WHERE
											".$condbu."
											YEAR(dateadded) = YEAR(now()) AND ticket_type = 2");
  $incidentcountres2 = mysqli_fetch_assoc($incidentcountsql2);
  $incidentline .= "//".$incidentcountres2['January'].",".$incidentcountres2['February'].",".$incidentcountres2['March'].",".$incidentcountres2['April'].",".$incidentcountres2['May'].",".$incidentcountres2['June'].",".$incidentcountres2['July'].",".$incidentcountres2['August'].",".$incidentcountres2['September'].",".$incidentcountres2['October'].",".$incidentcountres2['November'].",".$incidentcountres2['December']."//".$incidentcountres2['TOTAL'];
  $resultdata = $incidentline;
}
elseif($graphtype == "line3")
{
	$incidentline = "";
	$incidentcountsql = mysqli_query($conn,"SELECT 
											SUM(CASE MONTH(date_created) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
											SUM(CASE MONTH(date_created) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
											SUM(CASE MONTH(date_created) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
											SUM(CASE MONTH(date_created) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
											SUM(CASE MONTH(date_created) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
											SUM(CASE MONTH(date_created) WHEN 6 THEN 1 ELSE 0 END) AS 'June',
											SUM(CASE MONTH(date_created) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
											SUM(CASE MONTH(date_created) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
											SUM(CASE MONTH(date_created) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
											SUM(CASE MONTH(date_created) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
											SUM(CASE MONTH(date_created) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
											SUM(CASE MONTH(date_created) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
											SUM(CASE YEAR(date_created) WHEN YEAR(now()) THEN 1 ELSE 0 END) AS 'TOTAL'								
											FROM
											log_mst
											WHERE
											ticket IN (SELECT id FROM ticket WHERE bu = ".$bu." AND YEAR(dateadded) = YEAR(now()) AND ticket_type = 2)");
  $incidentcountres = mysqli_fetch_assoc($incidentcountsql);
  $incidentline = $incidentcountres['January'].",".$incidentcountres['February'].",".$incidentcountres['March'].",".$incidentcountres['April'].",".$incidentcountres['May'].",".$incidentcountres['June'].",".$incidentcountres['July'].",".$incidentcountres['August'].",".$incidentcountres['September'].",".$incidentcountres['October'].",".$incidentcountres['November'].",".$incidentcountres['December']."//".$incidentcountres['TOTAL'];
  $incidentcountsql2 = mysqli_query($conn,"SELECT 
											SUM(CASE MONTH(date_created) WHEN 1 THEN 1 ELSE 0 END) AS 'January',
											SUM(CASE MONTH(date_created) WHEN 2 THEN 1 ELSE 0 END) AS 'February',
											SUM(CASE MONTH(date_created) WHEN 3 THEN 1 ELSE 0 END) AS 'March',
											SUM(CASE MONTH(date_created) WHEN 4 THEN 1 ELSE 0 END) AS 'April',
											SUM(CASE MONTH(date_created) WHEN 5 THEN 1 ELSE 0 END) AS 'May',
											SUM(CASE MONTH(date_created) WHEN 6 THEN 1 ELSE 0 END) AS 'June',
											SUM(CASE MONTH(date_created) WHEN 7 THEN 1 ELSE 0 END) AS 'July',
											SUM(CASE MONTH(date_created) WHEN 8 THEN 1 ELSE 0 END) AS 'August',
											SUM(CASE MONTH(date_created) WHEN 9 THEN 1 ELSE 0 END) AS 'September',
											SUM(CASE MONTH(date_created) WHEN 10 THEN 1 ELSE 0 END) AS 'October',
											SUM(CASE MONTH(date_created) WHEN 11 THEN 1 ELSE 0 END) AS 'November',
											SUM(CASE MONTH(date_created) WHEN 12 THEN 1 ELSE 0 END) AS 'December',
											SUM(CASE YEAR(date_created) WHEN (YEAR(now()) - 1) THEN 1 ELSE 0 END) AS 'TOTAL'
											FROM
											log_mst
											WHERE
											ticket IN (SELECT id FROM ticket WHERE bu = ".$bu." AND YEAR(dateadded) = YEAR(now()) AND ticket_type = 2)");
  $incidentcountres2 = mysqli_fetch_assoc($incidentcountsql2);
  $incidentline .= "//".$incidentcountres2['January'].",".$incidentcountres2['February'].",".$incidentcountres2['March'].",".$incidentcountres2['April'].",".$incidentcountres2['May'].",".$incidentcountres2['June'].",".$incidentcountres2['July'].",".$incidentcountres2['August'].",".$incidentcountres2['September'].",".$incidentcountres2['October'].",".$incidentcountres2['November'].",".$incidentcountres2['December']."//".$incidentcountres2['TOTAL'];
  $resultdata = $incidentline;
}
elseif($graphtype == 'agency')
{
	$expirytable = "";
	$sqlagency = mysqli_query($conn, "SELECT * FROM agency_mst WHERE contract_status = 'Active' AND license_expiration < DATE_ADD(now(), INTERVAL 6 MONTH) ORDER BY license_expiration");
	while($resagency = mysqli_fetch_assoc($sqlagency))
	{
		$expirytable .= "<tr align=\"center\">
							<td>".$resagency['agency_name']."</td>
							<td>".$resagency['license_expiration']."</td>
						</tr>";
	}
	if($expirytable)
	{
		$resultdata = $expirytable;
	}
	else
	{
		$resultdata = "<tr>
							<td colspan=\"100%\" align=\"center\">No licenses to expire within the next 6 months</td>
					   </tr>";
	}
}
elseif($graphtype == 'agency2')
{
	$expirytable = "";
	if ($_SESSION['multi-admin']) {
		$sqlagency = mysqli_query($conn, "SELECT a.agency_name, b.end, c.bu FROM agency_mst a LEFT JOIN agency_bu b ON b.agency_id = a.id LEFT JOIN bu_mst c ON b.bu_id = c.id WHERE b.bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND a.contract_status = 'Active' AND b.end < DATE_ADD(now(), INTERVAL 6 MONTH) ORDER BY b.end");
	} else {
		$sqlagency = mysqli_query($conn, "SELECT a.agency_name, b.end, c.bu FROM agency_mst a LEFT JOIN agency_bu b ON b.agency_id = a.id LEFT JOIN bu_mst c ON b.bu_id = c.id WHERE ".$condbu2." a.contract_status = 'Active' AND b.end < DATE_ADD(now(), INTERVAL 6 MONTH) ORDER BY b.end");
	}

	while($resagency = mysqli_fetch_assoc($sqlagency))
	{
		$expirytable .= "<tr align=\"center\">
							<td>".$resagency['agency_name']."</td>
							<td>".$resagency['bu']."</td>
							<td>".$resagency['end']."</td>
						</tr>";
	}
	if($expirytable)
	{
		$resultdata = $expirytable;
	}
	else
	{
		$resultdata = "<tr>
							<td colspan=\"100%\" align=\"center\">No contracts to expire within the next 6 months</td>
					   </tr>";
	}
}
elseif($graphtype == 'agency3')
{
	$bu_specific = "";
	$bu_choices = "";
	$bu_specific_array = array();
	if ($_SESSION['multi-admin']) {
		$buspecificsql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ")");
	} else {
		$buspecificsql = mysqli_query($conn, "SELECT * FROM agency_bu WHERE bu_id = ".$_SESSION['bu']);
	}

	while($buspecificres = mysqli_fetch_assoc($buspecificsql))
	{
		$bu_specific_array[] = $buspecificres['agency_id'];
	}
	if($bu_specific_array)
	{
		$bu_choices = implode(", ", $bu_specific_array);
		$bu_specific = " AND (agency_id IN (".$bu_choices.")) ";
	}
	$expirytable = "";
	$sqlagency = mysqli_query($conn, "SELECT * FROM license_mst WHERE (expiry_date < DATE_ADD(now(), INTERVAL 6 MONTH)) ".$bu_specific." ORDER BY expiry_date");
	while($resagency = mysqli_fetch_assoc($sqlagency))
	{
		$sqlagencyname = mysqli_query($conn, "SELECT * FROM agency_mst WHERE contract_status = 'Active' AND id = ".$resagency['agency_id']);
		$resagency2 = mysqli_fetch_assoc($sqlagencyname);
		if($resagency2)
		{
			$pdf = "None";
			if($resagency['pdf_file'] != "None")
			{				
				$pdf = "<a href='".$resagency['pdf_file']."' target='_blank' style='color:blue;'>View</a>";				
			}
			$expirytable .= "<tr align=\"center\">
							<td>".$resagency2['agency_name']."</td>
							<td>".$resagency['license_type']."</td>
							<td>".$resagency['license_number']."</td>
							<td>".$resagency['issue_date']."</td>
							<td>".$resagency['expiry_date']."</td>
							<td>".$pdf."</td>
						</tr>";
		}
		
	}
	if($expirytable)
	{
		$resultdata = $expirytable;
	}
	else
	{
		$resultdata = "<tr>
							<td colspan=\"100%\" align=\"center\">No licenses to expire within the next 6 months</td>
					   </tr>";
	}
}

elseif($graphtype == 'guard')
{
	if($condbu)
	{
		if(!isset($_SESSION['multi-admin'])) {
			$checkexprosql = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$bu);
			$checkexprores = mysqli_fetch_assoc($checkexprosql);
			
			if($checkexprores['expro'] == 1) //if expro bu, point guard db to expro visayas, id = 24
			{
				$condbu = " bu = 24 AND ";
			}
		}
	}

	$expirytable = "";
	if ($_SESSION['multi-admin']) {
		$sqlguard = mysqli_query($conn, "SELECT guard_personnel.*, bu_mst.bu as bu_name FROM guard_personnel INNER JOIN bu_mst ON guard_personnel.bu = bu_mst.id WHERE guard_personnel.bu IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND license_expiry_date < DATE_ADD(now(), INTERVAL 6 MONTH) AND status = 'Active' ORDER BY guard_personnel.license_expiry_date;");
	} else {
		$sqlguard = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE ".$condbu." license_expiry_date < DATE_ADD(now(), INTERVAL 6 MONTH) AND status = 'Active' ORDER BY license_expiry_date");
	}
	
	while($resguard = mysqli_fetch_assoc($sqlguard))
	{
		$expirytable .= "<tr align=\"center\">
							<td>".$resguard['lname'].", ".$resguard['fname']." ".$resguard['mname']."</td>
							<td>Guard License - ".$resguard['license_expiry_date']." </td>
							<td>".$resguard['bu_name']."</td>
						</tr>";
	}
	
	if ($_SESSION['multi-admin']) {
		$sqlguard2 = mysqli_query($conn, "SELECT guard_personnel.*, bu_mst.bu as bu_name FROM guard_personnel INNER JOIN bu_mst ON guard_personnel.bu = bu_mst.id WHERE guard_personnel.bu IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND ntc_license_end < DATE_ADD(now(), INTERVAL 6 MONTH) AND status = 'Active' ORDER BY ntc_license_end") or die(mysqli_error($conn));
	} else {
		$sqlguard2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE ".$condbu." ntc_license_end < DATE_ADD(now(), INTERVAL 6 MONTH) AND status = 'Active' ORDER BY ntc_license_end") or die(mysqli_error($conn));
	}

	while($resguard2 = mysqli_fetch_assoc($sqlguard2))
	{
		$expirytable .= "<tr align=\"center\">
							<td>".$resguard2['lname'].", ".$resguard2['fname']." ".$resguard2['mname']."</td>
							<td>NTC License - ".$resguard2['ntc_license_end']." </td>
							<td>".$resguard2['bu_name']."</td>
						</tr>";
	}	
	
	if($expirytable)
	{
		$resultdata = $expirytable;
	}
	else
	{
		$resultdata = "<tr>
							<td colspan=\"100%\" align=\"center\">No licenses to expire within the next 6 months</td>
					   </tr>";
	}
}
elseif($graphtype == 'total') //superadmin bar graph
{
	if ($_SESSION['multi-admin']) {
		$sqltotal = mysqli_query($conn, "SELECT b.bu, COUNT(t.id) AS incident_count FROM bu_mst b LEFT JOIN ticket t ON t.bu = b.id AND t.ticket_type = 1 AND MONTH(t.dateadded) = MONTH(now()) AND YEAR(t.dateadded) = 2020 WHERE b.id IN (" . implode(',', array_map('intval', $listOfBU)) . ") AND t.description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative')) GROUP BY b.bu ORDER BY incident_count DESC LIMIT 5");
	} else {
		$sqltotal = mysqli_query($conn, "SELECT b.bu, COUNT(t.id) AS incident_count FROM bu_mst b LEFT JOIN ticket t ON t.bu = b.id AND t.ticket_type = 1 AND MONTH(t.dateadded) = MONTH(now()) AND YEAR(t.dateadded) = 2020 WHERE t.description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative')) GROUP BY b.bu ORDER BY incident_count DESC LIMIT 5");
	}
	while($restotal = mysqli_fetch_assoc($sqltotal))
	{
		$chart_ticks[] = $restotal['bu'];
		$chart_data[] = $restotal['incident_count'];		
	}
	if($chart_ticks)
	{
		$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
	}
}
elseif($graphtype == 'total2') 
{
	$multipleAdminVariable = "";
	if ($_SESSION['multi-admin']) {
		$multipleAdminVariable = "IN (" . implode(',', array_map('intval', $listOfBU)) . ")";
		$sqlcheckexpro = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id ". $multipleAdminVariable . "");
	} else {
		$sqlcheckexpro = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$bu);
	}

	$sqlrescheckexpro = mysqli_fetch_assoc($sqlcheckexpro);
	if($sqlrescheckexpro['expro'] == 0)
	{
		if ($_SESSION['multi-admin']) {
			$sqltotal = mysqli_query($conn, "SELECT l.location, COUNT(t.id) AS incident_count FROM location_mst l LEFT JOIN ticket t ON t.location = l.id  AND t.bu ".$multipleAdminVariable." AND t.ticket_type = 1 AND MONTH(t.dateadded) = MONTH(now()) AND YEAR(t.dateadded) = 2020 WHERE t.bu ".$multipleAdminVariable." AND t.description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative')) GROUP BY l.location ORDER BY incident_count DESC LIMIT 5");
		} else {
			$sqltotal = mysqli_query($conn, "SELECT l.location, COUNT(t.id) AS incident_count FROM location_mst l LEFT JOIN ticket t ON t.location = l.id  AND t.bu = ".$bu." AND t.ticket_type = 1 AND MONTH(t.dateadded) = MONTH(now()) AND YEAR(t.dateadded) = 2020 WHERE t.bu = ".$bu." AND t.description NOT IN(SELECT id FROM entries_incident WHERE main_cat = (SELECT id FROM incident_main_cat WHERE main_cat = 'Administrative')) GROUP BY l.location ORDER BY incident_count DESC LIMIT 5");
		}

		if($sqltotal)
		{
		
			while($restotal = mysqli_fetch_assoc($sqltotal))
			{
				$chart_ticks[] = $restotal['location'];
				$chart_data[] = $restotal['incident_count'];		
			}
		}
	}
	elseif($sqlrescheckexpro['expro'] == 1)
	{
		$exprovariable = 1;
		//$sqltotal = mysqli_query($conn, "SELECT gid, COUNT(*) AS incident_number FROM log_mst WHERE (ticket IN (SELECT id FROM ticket WHERE (bu = ".$bu.") AND (ticket_type = 2))) AND (MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = YEAR(now()))  GROUP BY gid ORDER BY incident_number LIMIT 5");
		$sqltotal = mysqli_query($conn, "SELECT gid, COUNT(*) AS incident_number FROM log_mst WHERE (ticket IN (SELECT id FROM ticket WHERE (bu = ".$bu.") AND (ticket_type = 2))) AND (DAY(date_created) = DAY(now()) AND MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = YEAR(now()))  GROUP BY gid ORDER BY incident_number LIMIT 5");
		if($sqltotal)
		{
		
			while($restotal = mysqli_fetch_assoc($sqltotal))
			{
				$queryTicketDesc = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = '". mysqli_real_escape_string($conn, $restotal['gid'])."'");
				if($queryTicketDesc)
				{
					$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
					if($resTicketDesc)
					{
						$ticketdesc = $resTicketDesc['fname'] ." ". $resTicketDesc['lname'];
						
					}
					else
					{
						
						$ticketdesc =  "Others";
					}
					$chart_ticks[] = $ticketdesc;
					$chart_data[] = $restotal['incident_number'];
				}
			}
		}
	}
	
	if($chart_ticks)
	{
		$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
	}
}

elseif($graphtype == 'total3')
{
	$sqltotal = mysqli_query($conn, "SELECT gid, COUNT(*) AS incident_number FROM log_mst WHERE (ticket IN (SELECT id FROM ticket WHERE (bu = ".$bu.") AND (ticket_type = 2))) AND (DAY(date_created) = DAY(now()) AND MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = YEAR(now()))  GROUP BY gid ORDER BY incident_number LIMIT 5");
		if($sqltotal)
		{
		
			while($restotal = mysqli_fetch_assoc($sqltotal))
			{
				$queryTicketDesc = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = '". mysqli_real_escape_string($conn, $restotal['gid'])."'");
				if($queryTicketDesc)
				{
					$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
					if($resTicketDesc)
					{
						$ticketdesc = $resTicketDesc['guard_code'];
						
					}
					else
					{
						
						$ticketdesc =  "Others";				
					}
					$chart_ticks[] = $ticketdesc;
					$chart_data[] = $restotal['incident_number'];
				}
			}
		}
		if($chart_ticks)
		{
			$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
		}
}
elseif($graphtype == 'auditDashboardDonut')
{
	date_default_timezone_set('Asia/Manila');
	$todayaudit = date('Y-m-d H:i:s');

	if ($_SESSION['multi-admin']) {
		$auditsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
												SUM(CASE WHEN status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS nson,
												SUM(CASE WHEN status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS nsde,
												SUM(CASE WHEN status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS ipon,
												SUM(CASE WHEN status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS ipde,
												SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) AS done
											FROM audit_mst WHERE bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ")")or die(mysqli_error($conn));
	} else {
		$auditsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
												SUM(CASE WHEN status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS nson,
												SUM(CASE WHEN status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS nsde,
												SUM(CASE WHEN status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS ipon,
												SUM(CASE WHEN status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS ipde,
												SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) AS done
											FROM audit_mst".$admintest)or die(mysqli_error($conn));
											//WHERE bu_id IN(SELECT id from bu_mst WHERE main_group = ".$mainauditres['id'].")")or die(mysqli_error($conn));
	}
	
	$auditres = mysqli_fetch_assoc($auditsql);
	
	/* $resultdata2[] = (array("Not Yet Started, On Time", $auditres['nson']));
	$resultdata2[] = (array("Not Yet Started, Delayed", $auditres['nsde']));
	$resultdata2[]= (array("In Progress, On Time", $auditres['ipon']));
	$resultdata2[] = (array("In Progress, Delayed", $auditres['ipde']));
	$resultdata2[] = (array("Done", $auditres['done']));
	$resultdata3 = '["Not Yet Started - On Time", '.$auditres["nson"].'], ["Not Yet Started - Delayed", '.$auditres["nsde"].'], ["In Progress - On Time", '.$auditres['ipon'].'], ["In Progress - Delayed", '.$auditres['ipde'].'], ["Done", '.$auditres['done'].']'; */
	$resultdata = "Not Yet Started - On Time, Not Yet Started - Delayed, In Progress - On Time, In Progress - Delayed, Done // ".(($auditres["nson"]) ? $auditres["nson"] : 0 ).", ".(($auditres["nsde"]) ? $auditres["nsde"] : 0).", ".(($auditres['ipon']) ? $auditres["ipon"] : 0).", ".(($auditres['ipde']) ? $auditres['ipde'] : 0).", ".(($auditres['done']) ? $auditres['done'] : 0); 
	//$resultdata4 = "Not Yet Started - On Time, Not Yet Started - Delayed, In Progress - On Time, In Progress - Delayed, Done//10, 20, 25, 30, 35"; 
}
elseif($graphtype == 'KPIDashboardStakeDonut')
{
	date_default_timezone_set('Asia/Manila');
	$todayaudit = date('Y-m-d H:i:s');
	if ($_SESSION['multi-admin']) {
		$auditsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
		SUM(CASE WHEN status = 'Not Started' AND target_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS nson,
		SUM(CASE WHEN status = 'Not Started' AND target_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS nsde,
		SUM(CASE WHEN status = 'In Progress' AND target_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS ipon,
		SUM(CASE WHEN status = 'In Progress' AND target_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS ipde,
		SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) AS done
	FROM stakeholder_engagement WHERE bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ")")or die(mysqli_error($conn));
	} else {
	$auditsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
												SUM(CASE WHEN status = 'Not Started' AND target_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS nson,
												SUM(CASE WHEN status = 'Not Started' AND target_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS nsde,
												SUM(CASE WHEN status = 'In Progress' AND target_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS ipon,
												SUM(CASE WHEN status = 'In Progress' AND target_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS ipde,
												SUM(CASE WHEN status = 'Done' THEN 1 ELSE 0 END) AS done
											FROM stakeholder_engagement".$admintest)or die(mysqli_error($conn));

										}
	$auditres = mysqli_fetch_assoc($auditsql);
	$resultdata = "Not Yet Started - On Time, Not Yet Started - Delayed, In Progress - On Time, In Progress - Delayed, Done // ".(($auditres["nson"]) ? $auditres["nson"] : 0 ).", ".(($auditres["nsde"]) ? $auditres["nsde"] : 0).", ".(($auditres['ipon']) ? $auditres["ipon"] : 0).", ".(($auditres['ipde']) ? $auditres['ipde'] : 0).", ".(($auditres['done']) ? $auditres['done'] : 0);
}
elseif($graphtype == 'auditDashboardStacked')
{
	date_default_timezone_set('Asia/Manila');
	$todayaudit = date('Y-m-d H:i:s');
	// $admintest = "";
	/* if($_SESSION['level'] == "Admin")
	{
		$admintest = " WHERE bu_id = ".$bu;
	} */
	if ($_SESSION['multi-admin']) {
		$auditsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
		SUM(CASE WHEN risk_priority = 'Critical' AND status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS cnson,
		SUM(CASE WHEN risk_priority = 'Critical' AND status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS cnsde,
		SUM(CASE WHEN risk_priority = 'Critical' AND status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS cipon,
		SUM(CASE WHEN risk_priority = 'Critical' AND status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS cipde,
		SUM(CASE WHEN risk_priority = 'Critical' AND status = 'Done' THEN 1 ELSE 0 END) AS cdone,
		SUM(CASE WHEN risk_priority = 'High' AND status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS hnson,
		SUM(CASE WHEN risk_priority = 'High' AND status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS hnsde,
		SUM(CASE WHEN risk_priority = 'High' AND status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS hipon,
		SUM(CASE WHEN risk_priority = 'High' AND status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS hipde,
		SUM(CASE WHEN risk_priority = 'High' AND status = 'Done' THEN 1 ELSE 0 END) AS hdone,
		SUM(CASE WHEN risk_priority = 'Medium' AND status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS mnson,
		SUM(CASE WHEN risk_priority = 'Medium' AND status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS mnsde,
		SUM(CASE WHEN risk_priority = 'Medium' AND status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS mipon,
		SUM(CASE WHEN risk_priority = 'Medium' AND status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS mipde,
		SUM(CASE WHEN risk_priority = 'Medium' AND status = 'Done' THEN 1 ELSE 0 END) AS mdone,
		SUM(CASE WHEN risk_priority = 'Low' AND status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS lnson,
		SUM(CASE WHEN risk_priority = 'Low' AND status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS lnsde,
		SUM(CASE WHEN risk_priority = 'Low' AND status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS lipon,
		SUM(CASE WHEN risk_priority = 'Low' AND status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS lipde,
		SUM(CASE WHEN risk_priority = 'Low' AND status = 'Done' THEN 1 ELSE 0 END) AS ldone
	FROM audit_mst WHERE bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ")")or die(mysqli_error($conn));

	} else {
	$auditsql = mysqli_query($conn, "SELECT COUNT(*) AS total,
												SUM(CASE WHEN risk_priority = 'Critical' AND status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS cnson,
												SUM(CASE WHEN risk_priority = 'Critical' AND status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS cnsde,
												SUM(CASE WHEN risk_priority = 'Critical' AND status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS cipon,
												SUM(CASE WHEN risk_priority = 'Critical' AND status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS cipde,
												SUM(CASE WHEN risk_priority = 'Critical' AND status = 'Done' THEN 1 ELSE 0 END) AS cdone,
												SUM(CASE WHEN risk_priority = 'High' AND status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS hnson,
												SUM(CASE WHEN risk_priority = 'High' AND status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS hnsde,
												SUM(CASE WHEN risk_priority = 'High' AND status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS hipon,
												SUM(CASE WHEN risk_priority = 'High' AND status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS hipde,
												SUM(CASE WHEN risk_priority = 'High' AND status = 'Done' THEN 1 ELSE 0 END) AS hdone,
												SUM(CASE WHEN risk_priority = 'Medium' AND status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS mnson,
												SUM(CASE WHEN risk_priority = 'Medium' AND status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS mnsde,
												SUM(CASE WHEN risk_priority = 'Medium' AND status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS mipon,
												SUM(CASE WHEN risk_priority = 'Medium' AND status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS mipde,
												SUM(CASE WHEN risk_priority = 'Medium' AND status = 'Done' THEN 1 ELSE 0 END) AS mdone,
												SUM(CASE WHEN risk_priority = 'Low' AND status = 'Not Started' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS lnson,
												SUM(CASE WHEN risk_priority = 'Low' AND status = 'Not Started' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS lnsde,
												SUM(CASE WHEN risk_priority = 'Low' AND status = 'In Progress' AND commited_date >= '".$todayaudit."' THEN 1 ELSE 0 END) AS lipon,
												SUM(CASE WHEN risk_priority = 'Low' AND status = 'In Progress' AND commited_date < '".$todayaudit."' THEN 1 ELSE 0 END) AS lipde,
												SUM(CASE WHEN risk_priority = 'Low' AND status = 'Done' THEN 1 ELSE 0 END) AS ldone
											FROM audit_mst".$admintest)or die(mysqli_error($conn));
											//WHERE bu_id IN(SELECT id from bu_mst WHERE main_group = ".$mainauditres['id'].")")or die(mysqli_error($conn));
	}

	$auditres = mysqli_fetch_assoc($auditsql);
	$resultdata = $auditres['ldone'].", ".$auditres['mdone'].", ".$auditres['hdone'].", ".$auditres['cdone']."//".$auditres['lipon'].", ".$auditres['mipon'].", ".$auditres['hipon'].", ".$auditres['cipon']."//".$auditres['lipde'].", ".$auditres['mipde'].", ".$auditres['hipde'].", ".$auditres['cipde']."//".$auditres['lnson'].", ".$auditres['mnson'].", ".$auditres['hnson'].", ".$auditres['cnson']."//".$auditres['lnsde'].", ".$auditres['mnsde'].", ".$auditres['hnsde'].", ".$auditres['cnsde'];
}
elseif($graphtype == 'auditDashboardBarCategories')
{
		/* $admintest = "";
		if($_SESSION['level'] == "Admin")
		{
			$admintest = " WHERE bu_id = ".$bu;
		} */
		if ($_SESSION['multi-admin']) {
			$auditsql = mysqli_query($conn, "SELECT a.category, COUNT(*) as totals FROM audit_mst a INNER JOIN bu_mst b ON a.bu_id = b.id WHERE a.bu_id IN (" . implode(',', array_map('intval', $listOfBU)) . ") GROUP BY category ORDER BY totals");
		} else {
			$auditsql = mysqli_query($conn, "SELECT category, COUNT(*) as totals FROM audit_mst ".$admintest." GROUP BY category ORDER BY totals");
		}

		while($auditres = mysqli_fetch_assoc($auditsql))
		{
			$chart_ticks[] = $auditres["category"];
			$chart_data[] = $auditres["totals"];
		}
		$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
}
elseif($graphtype == 'auditGenerateDashboardBack')
{
	if($auditbu)
	{
		$resultdata =	'<tr>
							<td colspan="100%" ><label style="text-decoration:underline; color:red; cursor:pointer;" onclick="auditShow('.$auditbu.');">View Details</label></td>
						</tr>';
	}
	else
	{
		if($_SESSION['level'] == "Admin")
		{
			$resultdata =	'<tr>
							<td colspan="100%" ><label style="text-decoration:underline; color:red; cursor:pointer;" onclick="auditShow('.$bu.');">View Details</label></td>
						</tr>';
		}
		else
		{
			$resultdata =	'<tr>
							<td colspan="100%" ><label style="text-decoration:underline; color:red; cursor:pointer;" onclick="auditShow2();">View Details</label></td>
						</tr>';
		}
		
	}
}


if($resultdata)
{
	if($exprovariable == 1)
	{
		$resultdata = $resultdata . "\\" . $exprovariable;
	}	
		echo $resultdata;
	
	
}
elseif($resultdata4)
{
	echo $resultdata4;
}


?>