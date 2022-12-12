<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$id = $_GET['id'];
$idx = $_GET['idx'];
$type = $_GET['type'];
$date_start = $_GET['dstart'];
$date_end = $_GET['dend'];

$inc_main_type = $_GET['main'];
$inc_sub_type = $_GET['sub'];
 

$detector = "";
$counter = 0;

$chart_ticks = array();
$chart_data = array();
$resultdata = "";



$mainsql = mysqli_query($conn, "SELECT de")

if($type == "y-axis_type")
{
	$id2 = "";
	if($id != 0)
	{
		$id2 = "(bu = ".$id.") AND ";
	}
	$sqlByLocation = mysqli_query($conn, "SELECT description, COUNT(*) AS incident_number FROM ticket WHERE ".$id2." (ticket_type = 1) AND (dateadded BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY description ORDER BY incident_number") or die(mysqli_error($conn));
	while($resByLocation = mysqli_fetch_array($sqlByLocation))
	{
		//echo "first while";
		$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['description'])."'");
		if($queryTicketDesc)
		{
			$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
			if($resTicketDesc)
			{
				$ticketdesc = $resTicketDesc['name'];				
			}
			else
			{				
				$ticketdesc =  $resByLocation['description'];				
			}
		}
		
		$chart_ticks[] = $ticketdesc;
		$chart_data[] = $resByLocation[1];
		
	}
	if($chart_ticks)
	{
		$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
	}
}
elseif($type == "y-axis_bu")
{
	$id2 = "";
	if($id != 0)
	{
		$id2 = "(description = ".$id.") AND ";
	}
	if(!empty($idx) && ($idx != 0))
	{
		$sqlByLocation = mysqli_query($conn, "SELECT location, COUNT(*) AS incident_number FROM ticket WHERE ".$id2." bu = ".$idx." AND (ticket_type = 1) AND (dateadded BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY location ORDER BY incident_number") or die(mysqli_error($conn));
		while($resByLocation = mysqli_fetch_array($sqlByLocation))
		{
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['location'])."'");
			if($queryTicketDesc)
			{
				$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
				if($resTicketDesc)
				{
					$ticketdesc = $resTicketDesc['location'];
					
				}
				else
				{
					
					$ticketdesc =  "Others";				
				}
			}
			
			$chart_ticks[] = $ticketdesc;
			$chart_data[] = $resByLocation[1];
		}
	}
	else
	{
		$sqlByLocation = mysqli_query($conn, "SELECT bu, COUNT(*) AS incident_number FROM ticket WHERE ".$id2." (ticket_type = 1) AND (dateadded BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY bu ORDER BY incident_number") or die(mysqli_error($conn));
		while($resByLocation = mysqli_fetch_array($sqlByLocation))
		{
			//echo "first while";
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM bu_mst WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['bu'])."'");
			if($queryTicketDesc)
			{
				$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
				if($resTicketDesc)
				{
					$ticketdesc = $resTicketDesc['bu'];
					
				}
				else
				{
					
					$ticketdesc =  "Others";				
				}
			}
			
			$chart_ticks[] = $ticketdesc;
			$chart_data[] = $resByLocation[1];
			
		}
	}
	if($chart_ticks)
	{
		$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
	}
}
elseif($type == "y-axis_location")
{
	$id2 = "";
	if(!empty($idx) && ($idx != 0))
	{
		$id2 = "(location = ".$idx.") AND ";
		$sqlByLocation = mysqli_query($conn, "SELECT description, COUNT(*) AS incident_number FROM ticket WHERE (bu = ".$id.") AND ".$id2." (ticket_type = 1) AND (dateadded BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY description ORDER BY incident_number") or die(mysqli_error($conn));
		while($resByLocation = mysqli_fetch_array($sqlByLocation))
		{
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['description'])."'");
			if($queryTicketDesc)
			{
				$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
				if($resTicketDesc)
				{
					$ticketdesc = $resTicketDesc['name'];
					
				}
				else
				{
					
					$ticketdesc =  $resByLocation['description'];				
				}
			}
			
			$chart_ticks[] = $ticketdesc;
			$chart_data[] = $resByLocation[1];
			
		}
	}
	else
	{
		$sqlByLocation = mysqli_query($conn, "SELECT location, COUNT(*) AS incident_number FROM ticket WHERE (bu = ".$id.") AND ".$id2." (ticket_type = 1) AND (dateadded BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY location ORDER BY incident_number") or die(mysqli_error($conn));
		while($resByLocation = mysqli_fetch_array($sqlByLocation))
		{
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM location_mst WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['location'])."'");
			if($queryTicketDesc)
			{
				$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
				if($resTicketDesc)
				{
					$ticketdesc = $resTicketDesc['location'];
					
				}
				else
				{
					
					$ticketdesc =  "Others";				
				}
			}
			
			$chart_ticks[] = $ticketdesc;
			$chart_data[] = $resByLocation[1];
			
		}
	}
	if($chart_ticks)
	{
		$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
	}
}
elseif($type == "y-axis_guard")
{
	$id2 = "";
	if(!empty($idx) && ($idx != 0))
	{
		$id2 = "(responding_guard = ".$idx.") AND ";
		$sqlByLocation = mysqli_query($conn, "SELECT description, COUNT(*) AS incident_number FROM ticket WHERE (bu = ".$id.") AND ".$id2." (ticket_type = 1) AND (dateadded BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY description ORDER BY incident_number") or die(mysqli_error($conn));
		while($resByLocation = mysqli_fetch_array($sqlByLocation))
		{
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM entries_incident WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['description'])."'");
			if($queryTicketDesc)
			{
				$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
				if($resTicketDesc)
				{
					$ticketdesc = $resTicketDesc['name'];
					
				}
				else
				{
					
					$ticketdesc =  $resByLocation['description'];				
				}
			}
			
			$chart_ticks[] = $ticketdesc;
			$chart_data[] = $resByLocation[1];
			
		}
	}
	else
	{
		$sqlByLocation = mysqli_query($conn, "SELECT responding_guard, COUNT(*) AS incident_number FROM ticket WHERE (bu = ".$id.") AND ".$id2." (ticket_type = 1) AND (dateadded BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY responding_guard ORDER BY incident_number") or die(mysqli_error($conn));
		while($resByLocation = mysqli_fetch_array($sqlByLocation))
		{
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['responding_guard'])."'");
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
			}
			
			$chart_ticks[] = $ticketdesc;
			$chart_data[] = $resByLocation[1];
			
		}
	}
	if($chart_ticks)
	{
		$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
	}
}
elseif($type == "y-axis_guard2")
{
	$id2 = "";
	//$sql0 = mysqli_query($conn, "SELECT id FROM ticket WHERE (bu = ".$id.") AND (ticket_type = 2)");
//	while($res0 = mysqli_fetch_assoc($sql0))
//	{
//		
//	}
	if(!empty($idx) && ($idx != 0))
	{
		//$id2 = "(gid = ".$idx.") AND ";
		$sqlByLocation = mysqli_query($conn, "SELECT urcid, COUNT(*) AS incident_number FROM log_mst WHERE (gid = ".$idx.") AND (ticket IN (SELECT id FROM ticket WHERE (bu = ".$id.") AND (ticket_type = 2))) AND (date_created BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY urcid ORDER BY incident_number") or die(mysqli_error($conn));
		while($resByLocation = mysqli_fetch_array($sqlByLocation))
		{
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM urc_mst WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['urcid'])."'");
			if($queryTicketDesc)
			{
				$resTicketDesc = mysqli_fetch_assoc($queryTicketDesc);
				if($resTicketDesc)
				{
					$ticketdesc = $resTicketDesc['description'];
					
				}
				else
				{
					
					$ticketdesc =  "Others";				
				}
			}
			$chart_ticks[] = $ticketdesc;
			$chart_data[] = $resByLocation[1];
		}
	}
	else
	{
		$sqlByLocation = mysqli_query($conn, "SELECT gid, COUNT(*) AS incident_number FROM log_mst WHERE (ticket IN (SELECT id FROM ticket WHERE (bu = ".$id.") AND (ticket_type = 2))) AND (date_created BETWEEN '".$date_start."' AND '".$date_end."') GROUP BY gid ORDER BY incident_number") or die(mysqli_error($conn));
		while($resByLocation = mysqli_fetch_array($sqlByLocation))
		{
			$queryTicketDesc = mysqli_query($conn, "SELECT * FROM guard_personnel WHERE id = '". mysqli_real_escape_string($conn, $resByLocation['gid'])."'");
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
			}
			
			$chart_ticks[] = $ticketdesc;
			$chart_data[] = $resByLocation[1];
			
		}
	}
	if($chart_ticks)
	{
		$resultdata = implode(",", $chart_ticks)."//".implode(",", $chart_data);
	}
}
elseif($type == "auditCategories")
{
	
}

if($resultdata)
{
	echo $resultdata;
}





?>