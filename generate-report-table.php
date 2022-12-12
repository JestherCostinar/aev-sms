<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$reportbu = $_GET['bu'];
$reportincident = $_GET['inc'];
$reportactivity = $_GET['act'];
$reportlocation = $_GET['loc'];
$reportguard = $_GET['guard'];
$reporttype = $_GET['type'];
$reportstart = $_GET['dstart'];
$reportend = $_GET['dend'];
$reporturc = $_GET['urc'];

$main_cat = $_GET['main'];
$sub_cat = $_GET['sub'];

$condbu = "";
$condinc = "";
$condloc = "";
$condloc2 = "";
$condguard = "";
$condurc = "";

$condmaincat = "";
$condsubcat = "";
$condmaincatarray = array();
$condmaincatarraylist = "";
$condsubcatarray = array();
$condsubcatarraylist = "";

$listOfBU = array();

if($_SESSION['multi-admin']) {
	$listOfIDQuery = mysqli_query($conn, "SELECT * FROM users_bu WHERE login_id ='" . $_SESSION['id'] . "'");
	$buCount = 0;
	while ($list = mysqli_fetch_assoc($listOfIDQuery)) {
		$listOfBU[$buCount] = $list['bu_id'];
		$buCount++;
	}
}

if(!empty($reportbu) && ($reportbu != 0))
{
	$condbu = "(bu = ".$reportbu.") AND ";
	$condbu2 = "(t.bu = ".$reportbu.") AND ";
} else {
	if($_SESSION['multi-admin']) {
		$condbu = "(bu IN (" . implode(',', array_map('intval', $listOfBU)) . ")) AND ";
		$condbu2 = "(t.bu IN (" . implode(',', array_map('intval', $listOfBU)) . ")) AND ";
	} else {
		$condbu = "";
		$condbu2 = "";
	}
}
if(!empty($reporturc) && ($reporturc != 0))
{
	$condurc = "(urcid = ".$reporturc.") AND ";
}

if(!empty($reportincident) && ($reportincident != 0) && ($reporttype == 1))
{
	$condinc = "(description = ".$reportincident.") AND ";
	$condinc2 = "(t.description = ".$reportincident.") AND ";
	
}
elseif(!empty($reportactivity) && ($reportactivity != 0) && ($reporttype == 2))
{
	$condinc = "(description = ".$reportactivity.") AND ";
	
}
elseif(!empty($sub_cat) && ($sub_cat != 0))
{
	$subcatsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE sub_cat = ". $sub_cat);
	while($subcatres = mysqli_fetch_assoc($subcatsql))
	{
		$condsubcatarray[] = $subcatres['id'];
	}
	$condsubcatarraylist = implode(", ", $condsubcatarray);
	$condsubcat = "t.description IN(".$condsubcatarraylist.") AND ";
	$condsubcat2 = "description IN(".$condsubcatarraylist.") AND ";
}
elseif(!empty($main_cat) && ($main_cat != 0))
{
	$maincatsql = mysqli_query($conn, "SELECT * FROM entries_incident WHERE main_cat = ". $main_cat);
	while($maincatres = mysqli_fetch_assoc($maincatsql))
	{
		$condmaincatarray[] = $maincatres['id'];
	}
	$condmaincatarraylist = implode(", ", $condmaincatarray);
	$condmaincat = "t.description IN(".$condmaincatarraylist.") AND ";
	$condmaincat2 = "description IN(".$condmaincatarraylist.") AND ";
}



if(!empty($reportlocation) && ($reportlocation != 0) && ($reporttype == 1))
{
	$condloc = "(location = ".$reportlocation.") AND ";
	$condloc3 = "(t.location = ".$reportlocation.") AND ";
}
elseif(!empty($reportlocation) && ($reportlocation != 0) && ($reporttype == 2))
{
	$condloc2 = "(location = ".$reportlocation.") AND ";
}

if(!empty($reportguard) && ($reportguard != 0) && ($reporttype == 1))
{
	$condguard = "(responding_guard = ".$reportguard.") AND ";
	$condguard3 = "(t.responding_guard = ".$reportguard.") AND ";
}
elseif(!empty($reportguard) && ($reportguard != 0) && ($reporttype == 2))
{
	$condguard2 = "(gid = ".$reportguard.") AND ";
}




$bucontrol = "";
$resultform = "";
$resultformdata = "";

$countsuspect = 0;
$countwitness = 0;
$countvictim = 0;
$countcounterfeit = 0;
$personscolspan = 1;

$sqlcount = mysqli_query($conn, "SELECT COUNT(s.id) AS suspects, COUNT(v.id) AS victims, COUNT(w.id) AS witnesses, COUNT(c.id) AS counterfeits FROM ticket t 
								 LEFT JOIN incident_suspect s ON t.id = s.logId 
								 LEFT JOIN incident_victim v ON t.id = v.logId 
								 LEFT JOIN incident_witness w ON t.id = w.logId 
								 LEFT JOIN incident_counterfeit c ON t.id = c.ticket_id
								 WHERE ".$condbu2." ".$condinc2." ".$condloc3." ".$condguard3." ".$condmaincat." ".$condsubcat." (t.ticket_type = ".$reporttype.") AND (t.dateadded BETWEEN '".$reportstart."' AND '".$reportend."')");
if($sqlcount)
{
	$rescount = mysqli_fetch_assoc($sqlcount);
	$countsuspect += $rescount['suspects'];
	$countwitness += $rescount['witnesses'];
	$countvictim += $rescount['victims'];
	$countcounterfeit += $rescount['counterfeits'];
	if($countsuspect > 0)
	{
		$personscolspan++;
	}
	if($countwitness > 0)
	{
		$personscolspan++;
	}
	if($countvictim > 0)
	{
		$personscolspan++;
	}
}

$csvarray = array();
$csvarray[] = "sep=|";
$csvarray[] = 'BU Control No.| Date| Time| Location| Type| Guard| Suspect| Witness| Victim| Narration| Disposition| Cost of Damage| Type of Loss| Account ID| Account Name| Address| Amount| Bill Serial';

$csvarray2 = array();
$csvarray2[] = "sep=|";
$csvarray2[] = "Business Unit | Date | Time | Activity Type | Location | Guard | Narrative";

$sqlmain = mysqli_query($conn, "SELECT * FROM ticket WHERE ".$condbu." ".$condinc." ".$condloc." ".$condguard." ".$condmaincat2." ".$condsubcat2." (ticket_type = ".$reporttype.") AND (dateadded BETWEEN '".$reportstart."' AND '".$reportend."')");
while($resmain = mysqli_fetch_assoc($sqlmain))
{
	
	$sqlbu = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ".$resmain['bu']);
	$resbu = mysqli_fetch_assoc($sqlbu);
	$stripdate = str_replace("-", "", $resmain['dateadded']);
	$bucontrol = $resbu['bu_code']."-".$stripdate."-".$resmain['id'];
	$splittimedate = explode(" ", $resmain['datesubmitted']);
	$splittime = $splittimedate[1];
	$splitdate = $splittimedate[0];
	$inc_location = "";
	$sqlloc = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ".$resmain['location']);
	if($sqlloc)
	{
		$resloc = mysqli_fetch_assoc($sqlloc);
		$inc_location = $resloc['location'];
	}
//	$resloc = mysqli_fetch_assoc($sqlloc);
//	$inc_location = $resloc['location'];
	$ticketdesc = "";
	if($reporttype == 1)
	{
		$sqlinctype = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = ".$resmain['description']);
	}
	elseif($reporttype == 2)
	{
		$sqlinctype = mysqli_query($conn, "SELECT * FROM entries_activity WHERE id = ".$resmain['description']);
	}
	if($sqlinctype)	
	{
		$resinctype = mysqli_fetch_assoc($sqlinctype);
		$ticketdesc = $resinctype['name'];
	}
	else
	{
		$ticketdesc = $resmain['description'];
	}
	
	$responding_guard = "";
	$responding_guard2 = "";
	$sqlguard = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = ".$resmain['responding_guard']);
	if($sqlguard)
	{
		
		$resguard = mysqli_fetch_assoc($sqlguard);
		$responding_guard = $resguard['lname'].", ".$resguard['fname']." ".$resguard['mname'];
		$responding_guard2 = $resguard['fname'].' '.$resguard['mname'].' '.$resguard['lname'];
	}
//	$resguard = mysqli_fetch_assoc($sqlguard);
//	$responding_guard = $resguard['lname'].", ".$resguard['fname']." ".$resguard['mname'];
	$suspectarray = array();
	$suspectlist = "";
	$sqlsuspect = mysqli_query($conn, "SELECT * FROM incident_suspect WHERE logId = ".$resmain['id']);
	while($ressuspect = mysqli_fetch_assoc($sqlsuspect))
	{
		$suspectarray[] = $ressuspect['FirstName']." ".$ressuspect['MiddleName']." ".$ressuspect['LastName'];
	}
	$suspectlist = implode(", ", $suspectarray);
	$suspectlist2 = implode(" - ", $suspectarray);
	$witnessarray = array();
	$witnesslist = "";
	$sqlwitness = mysqli_query($conn, "SELECT * FROM incident_witness WHERE logId = ".$resmain['id']);
	while($reswitness = mysqli_fetch_assoc($sqlwitness))
	{
		$witnessarray[] = $reswitness['FirstName']." ".$reswitness['MiddleName']." ".$reswitness['LastName'];
	}
	$witnesslist = implode(", ", $witnessarray);
	$witnesslist2 = implode(" - ", $witnessarray);
	$victimarray = array();
	$victimlist = "";
	$sqlvictim = mysqli_query($conn, "SELECT * FROM incident_victim WHERE logId = ".$resmain['id']);
	while($resvictim = mysqli_fetch_assoc($sqlvictim))
	{
		$victimarray[] = $resvictim['FirstName']." ".$resvictim['MiddleName']." ".$resvictim['LastName'];
	}
	$victimlist = implode(", ", $victimarray);
	$victimlist2 = implode(" - ", $victimarray);
	if($reporttype == 1)
	{
		$inclogarray = array();
		$inclogarray2 = array();
		$incloglist = "";
		$incloglist2 = "";
		$sqlinclogrev = mysqli_query($conn, "SELECT d1.* FROM logrevision_mst d1 LEFT OUTER JOIN logrevision_mst d2 ON (d1.ticket = d2.ticket AND d1.revision_num < d2.revision_num) WHERE d2.ticket IS null and d1.ticket = ".$resmain['id']);
		if($sqlinclogrev)
		{
			while($resinclogrev = mysqli_fetch_assoc($sqlinclogrev))
			{
				$inclogarray[] = $resinclog['date_created']." ".$resinclogrev['time_created']." <br> ".$resinclogrev['remarks']."<br>";
				$inclogarray2[] = "[".$resinclogrev['time_created']." - ".$resinclogrev['remarks']."]";
			}
			$incloglist = implode("<br />", $inclogarray);
			$incloglist2 = implode(" -- ", $inclogarray2);
		}
		if($incloglist)
		{
		}		
		else
		{
			$sqlinclog = mysqli_query($conn, "SELECT * FROM log_mst WHERE ticket = ".$resmain['id']);
			while($resinclog = mysqli_fetch_assoc($sqlinclog))
			{
				$inclogarray[] = $resinclog['date_created']." ".$resinclog['time_created']." <br> ".$resinclog['remarks']."<br>";
				$inclogarray2[] = "[".$resinclog['time_created']." - ".$resinclog['remarks']."]";
			}
			$incloglist = implode("<br />", $inclogarray);
			$incloglist2 = implode(" -- ", $inclogarray2);
		}
	}
	elseif($reporttype == 2)
	{
		$incloglist = "";
		$sqlinclog = mysqli_query($conn, "SELECT * FROM log_mst WHERE ".$condguard2." ".$condloc2." ".$condurc." ticket = ".$resmain['id']);
		while($resinclog = mysqli_fetch_assoc($sqlinclog))
		{
			$sqlurc = mysqli_query($conn, "SELECT * FROM urc_mst WHERE id = ".$resinclog['urcid']);
			$resurc = mysqli_fetch_assoc($sqlurc);
			$sqlloc2 = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = ".$resinclog['location']);
			if($sqlloc2)
			{
				$resloc2 = mysqli_fetch_assoc($sqlloc2);
				$inc_location2 = $resloc2['location'];
			}
			$sqlguard2 = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = ".$resinclog['gid']);
			if($sqlguard2)
			{
				$resguard2 = mysqli_fetch_assoc($sqlguard2);
				$guard = $resguard2['lname'].", ".$resguard2['fname']." ".$resguard2['mname'];
			}
			$incloglist .= "<tr align=\"center\">
							  <td>".$resbu['bu']."</td>
							  <td>".$resinclog['date_created']."</td>
							  <td>".$resinclog['time_created']."</td>
							  <td>".$ticketdesc."</td>
							  
							  <td>".$inc_location2."</td>
							  <td>".$guard."</td>
							  <td align=\"justify\" width=\"30%\">".$resinclog['remarks']."</td>
						    </tr>";
			$csvarray2[] = $resbu['bu']." | ".$resinclog['date_created']." | ".$resinclog['time_created']." | ".$ticketdesc." | ".$inc_location2." | ".$guard." | ".$resinclog['remarks'];
		}
							
	}
	$incdisposition = $resmain['dateclosed'] . "<br>" . $resmain['disposition'];
	$inccost = $resmain['damage_cost'];
	$inclosstype = $resmain['loss_type'];
	$sqlcounterfeit = mysqli_query($conn, "SELECT * FROM incident_counterfeit WHERE ticket_id = ".$resmain['id']);
	$rescounterfeit = mysqli_fetch_assoc($sqlcounterfeit);
	$accountname = $rescounterfeit['account_name'];
	$accountid = $rescounterfeit['account_id'];
	$counterfeitaddress = $rescounterfeit['address'];
	$counterfeitamount = $rescounterfeit['amount'];
	$counterfeitbill = $rescounterfeit['bill_serial'];
	
	if($reporttype == 1)
	{
		$resultformdata .= "<tr align=\"center\">" .
				   "<td>".$bucontrol."</td>" .
				   "<td>".$splitdate."</td>" .
				   "<td>".$splittime."</td>" .
				   "<td>".$inc_location."</td>" .
				   "<td>".$ticketdesc."</td>" .
				   "<td>".$responding_guard."</td>";
		if($countsuspect > 0)
		{
			$resultformdata .= "<td>".$suspectlist."</td>";
		}
		if($countwitness > 0)
		{
			$resultformdata .= "<td>".$witnesslist."</td>";
		}
		if($countvictim > 0)
		{
			$resultformdata .= "<td>".$victimlist."</td>";
		}
		$resultformdata .= "<td align=\"justify\">".$incloglist."</td>" .
				   "<td>".$incdisposition."</td>" .
				   "<td>".$inccost."</td>" .
				   "<td>".$inclosstype."</td>";
		if($countcounterfeit > 0)
		{
			$resultformdata .= "<td>".$accountid."</td>" .
					   "<td>".$accountname."</td>" .
					   "<td>".$counterfeitaddress."</td>" .
					   "<td>".$counterfeitamount."</td>" .
					   "<td>".$counterfeitbill."</td>";
		}
		$resultformdata .= "</tr>";
		$csvarray[] = $bucontrol."| ".$splitdate."| ".$splittime."| ".$inc_location."| ".$ticketdesc."| ".$responding_guard."| ".$suspectlist."| ".$witnesslist."| ".$victimlist."| ".$incloglist2."| ".$incdisposition."| ".$inccost."| ".$inclosstype."| ".$accountid."| ".$accountname."| ".$counterfeitaddress."| ".$counterfeitamount."| ".$counterfeitbill;
	}
	elseif($reporttype == 2)
	{
		$resultformdata .= $incloglist;
	}
	
}

if($resultformdata)
{
}
else
{
	$resultformdata = "<td colspan=\"100%\" align=\"center\">No recorded logs. Please check date range and search filters</td>";
}

$queryBU = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = ". $reportbu);
$resBU = mysqli_fetch_assoc($queryBU);
if($resBU["bu_logo"])
{
	$logopath = $resBU["bu_logo"];	
}
else
{
	$logopath = "images/logo_bgwhite.png";
}

//$csvstring = implode("\\n", $csvarray);
$csvstring = implode(" %0D%0A ", $csvarray);
$csvstring2 = implode(" %0D%0A ", $csvarray2);

if($reporttype == 1)
{
	$resultform .= "<div id=\"printMIMR\"><table align=\"center\" width=\"100%\"  border=\"1\" style=\"border-collapse:collapse;\">
			<tr>
				<td rowspan=\"3\" align=\"center\" width=\"15%\">
					<img autofocus=\"autofocus\" height=\"50px\" src=\"".$logopath."\"/>
				</td>
				<td rowspan=\"3\" align=\"center\" width=\"70%\">
					<label style=\"font-size:11px; font-weight:bold;\">INCIDENT MONITORING FORM</label>
				</td>
				<td width=\"15%\">
					Document Number: SEM-FM-003
				</td>
			</tr>
			<tr>
				<td width=\"15%\">
					Effective Date: 10/13/2014
				</td>
			</tr>
			<tr>
				<td width=\"15%\">
					Version Number: 1
				</td>
			</tr>
		</table>
        <br />
    	<table id=\"tblIncMonForm\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
            <thead class=\"blackongray\">
                <tr>
                    <th rowspan=\"2\" style='width: 10em;'>BU Control #</th>
                    <th colspan=\"2\" >WHEN</th>
                    <th rowspan=\"2\" style='width: 10em;'>Location of Incident</th>
                    <th rowspan=\"2\" style='width: 10em;'>Type of Incident</th>
                    <th colspan=\"".$personscolspan."\" >Persons Involved</th>
                    <th rowspan=\"2\" style='width: 20em;'>Brief Narration of Incident</th>
                    <th rowspan=\"2\" style='width: 20em;'>Disposition / Remarks</th>
                    <th rowspan=\"2\" style='width: 10em;'>Cost of Loss/Damage</th>
                    <th rowspan=\"2\" style='width: 10em;'>Type of Loss</th>";
	   if($countcounterfeit > 0)
	   {				
       		$resultform .= "<th colspan=\"5\">Counterfeit Details</th>";
	   }
       $resultform .= "</tr>
                <tr>
                    <th style='width: 7em;'>Date</th>
                    <th style='width: 7em;'>Time</th>
                    <th style='width: 10em;'>Responding Guard</th>";
		if($countsuspect > 0)
		{			
        	$resultform .= "<th style='width: 10em;'>Perpetrator / Suspect</th>";
		}
		if($countwitness > 0)
		{
            $resultform .= "<th style='width: 10em;'>Witness</th>";
		}
		if($countvictim > 0)
		{
            $resultform .= "<th style='width: 10em;'>Victim</th>";
		}
		if($countcounterfeit > 0)
		{
            $resultform .= "<th style='width: 10em;'>Account ID</th>
                    <th style='width: 10em;'>Account Name</th>
                    <th style='width: 10em;'>Address</th>
                    <th style='width: 10em;'>Amount</th>
                    <th style='width: 10em;'> Bill Serial</th>";
		}
            $resultform .= "</tr>
            </thead>
            <tbody id=\"tbodyIncMonForm\">
            	".$resultformdata."
            </tbody>
        </table></div>
		<table align=\"right\">
        	<tr>
            	<td>
					<input type='hidden' value='".$main_cat."'>
					<button class=\"redbutton\" style=\"cursor:pointer;\" onclick=\"fnExcelReport('tblIncMonForm');\">CSV</button>
					<button class=\"redbutton\" style=\"cursor:pointer;\" onclick=\"PrintReport2();\">Print</button>
                	<button class=\"redbutton\" onclick=\"closeReportTable();\">Close</button>
                </td>
            </tr>
        </table><iframe id=\"txtArea1\" style=\"display:none\"></iframe>";
}
//<a href=\"data:application/csv;charset=utf-8, ".str_replace('"', '%22', (str_replace(" ", "%00%20", $csvstring)))."\"  target=\"_blank\" download=\"IncidentMonitoringForm.csv\"><img style=\"vertical-align:bottom;\" height=\"30px\" src=\"images/csvbtn.png\"></a>					
elseif($reporttype == 2)
{
	$resultform .= "<div id=\"printMIMR\"><table align=\"center\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
			<tr>
				<td rowspan=\"3\" align=\"center\" width=\"15%\">
					<img autofocus=\"autofocus\" height=\"50px\" src=\"".$logopath."\"/>
				</td>
				<td rowspan=\"3\" align=\"center\" width=\"70%\">
					<label style=\"font-size:11px; font-weight:bold;\">ACTIVITY MONITORING FORM</label>
				</td>
				<td width=\"15%\">
					Document Number:<input type=\"text\" class=\"txtborderless\" size=\"10\" f />
				</td>
			</tr>
			<tr>
				<td width=\"15%\">
					Effective Date:<input type=\"text\" class=\"txtborderless\" size=\"10\" />
				</td>
			</tr>
			<tr>
				<td width=\"15%\">
					Version Number:<input type=\"text\" class=\"txtborderless\" size=\"10\" />
				</td>
			</tr>
		</table>
        <br />
    	<table id=\"tblIncMonForm\" width=\"100%\" border=\"1\" style=\"border-collapse:collapse;\">
            <thead class=\"blackongray\">
                
                <tr>
					<th>Business Unit</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Activity Type</th>
                    
                    <th>Location</th>
                    <th>Guard</th>
                    <th>Narrative</th>
                </tr>
            </thead>
            <tbody id=\"tbodyIncMonForm\">
            	".$resultformdata."
            </tbody>
        </table></div>
		<table align=\"right\">
        	<tr>
            	<td >
					
					<button class=\"redbutton\" style=\"cursor:pointer;\" onclick=\"fnExcelReport('tblIncMonForm');\">CSV</button>
					<button class=\"redbutton\" style=\"cursor:pointer;\" onclick=\"PrintReport2();\">Print</button>
                	<button class=\"redbutton\" onclick=\"closeReportTable();\">Close</button>
                </td>
            </tr>
        </table>";
}


echo $resultform;


?>