<?php

//fetch template
function fetch_template($template) {
	$content = (addslashes(file_get_contents("templates/{$template}.tpl")));
	return $content;
}

//logbook entry
function logbook($userId, $action){

	$datetime = date('Y-m-d H:i:s');
	$row = mysqli_fetch_array(mysqli_query($conn, "select * from users_mst where id = $userId"));
	
mysqli_query($conn, "insert into system_log(uid,log,datetime,bu_id) values('".$userId."','".$action."','".$datetime."',".$row['bu'].")");

}

//function logbook($action)
//{
//	
//	mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', '".$action."', now(), ".$_SESSION['bu'].")") or die(mysqli_error());
//}

function pagenolist2($limit, $tbl_name, $adjacents, $targetpage,$page){

	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = @mysqli_fetch_array(mysqli_query($conn, $query));
	$total_pages = $total_pages['num'];
	

	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\"> previous</a>";
		else
			$pagination.= "<span class=\"disabled\"> previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "<span style='color:#993300'>...</span>";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "<span style='color:#993300'>...</span>";;
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "<span style='color:#993300'>...</span>";;
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "<span style='color:#993300'>...</span>";;
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">next </a>";
		else
			$pagination.= "<span class=\"disabled\">next </span>";
		$pagination.= "</div>\n";		
	}

	return $pagination;
}


function pagenolist3($limit, $tbl_name, $adjacents, $targetpage,$page, $bu){

	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysqli_fetch_array(mysqli_query($conn, $query));
	$total_pages = $total_pages['num'];
	

	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?bu=$bu&page=$prev\"> previous</a>";
		else
			$pagination.= "<span class=\"disabled\"> previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?bu=$bu&page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?bu=$bu&page=$counter\">$counter</a>";					
				}
				$pagination.= "<span style='color:#993300'>...</span>";
				$pagination.= "<a href=\"$targetpage?bu=$bu&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?bu=$bu&page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?bu=$bu&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?bu=$bu&page=2\">2</a>";
				$pagination.= "<span style='color:#993300'>...</span>";;
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?bu=$bu&page=$counter\">$counter</a>";					
				}
				$pagination.= "<span style='color:#993300'>...</span>";;
				$pagination.= "<a href=\"$targetpage?bu=$bu&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?bu=$bu&page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?bu=$bu&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?bu=$bu&page=2\">2</a>";
				$pagination.= "<span style='color:#993300'>...</span>";;
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?bu=$bu&page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?bu=$bu&page=$next\">next </a>";
		else
			$pagination.= "<span class=\"disabled\">next </span>";
		$pagination.= "</div>\n";		
	}

	return $pagination;
}

function get_ticketlogs($tid){
	include 'global.php';
	$count = 1;
	$q = mysqli_query($conn, "select * from log_mst where ticket = $tid order by time_created ASC");
	if(mysqli_num_rows($q)>0){
	$currentTicket = '';
		while($row = @mysqli_fetch_array($q)){
			
			$id = $row['id'];
			$uid = $row['urcid'];
			$gid = $row['gid'];
			$locid = $row['location'];
			$t_id = $row['ticket'];
			
			if(is_null($row['ticket'])){
				$rowTicket = 0;
			} else {
				$rowTicket = $row['ticket'];
			}
			/*if($currentTicket != $rowTicket) {
				$currentTicket = $row['ticket'];
				if($currentTicket > 0) {
					$tQry = mysqli_query($conn, "select * from ticket where id = $currentTicket");
					$tRow = mysqli_fetch_assoc($tQry);
					$ticketDesc = $tRow['description'];
					$ticketStatus = $tRow['is_open'] == true ? 'Open' : 'Closed';        
					$list_logs .= "
								<td>Ticket #: $currentTicket - $ticketDesc Status: $ticketStatus</td>
							   ";
				} else {
					$list_logs .= "
								<td>NO TICKET</td>
							   ";
				}        
			}*/
			
			$result1 = mysqli_query($conn, "select * from urc_mst where id = '".$uid."'");
			$row1 = mysqli_fetch_assoc($result1);
			
			$result2 = mysqli_query($conn, "select * from guard_personnel where id = '".$gid."'");
			$row2 = mysqli_fetch_assoc($result2);
			
			$result3 = mysqli_query($conn, "select * from location_mst where id = '".$locid."'");
			$row3 = mysqli_fetch_assoc($result3);
			
			$result4 = mysqli_query($conn, "select * from ticket where id = '".$t_id."'");
			$row4 = mysqli_fetch_assoc($result4);
			
			// Row color changing
			if($rowBg == 0){
			$list_logs .= '<tr class ="row">';
			$rowBg = 1;
			}
			else{
			$list_logs.= '<tr class ="row1">';
			$rowBg = 0; 
			}
			
			$time = $row['time_created'];
			//$date = $row4['dateadded'];
			$date = $row['date_created'];
		
			$target = "$url_base/view-individual-log.php";
			$list_logs .= '
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.$count.'</td>				
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.((!empty($row3['location']))? $row3['location'] : "").'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.$row1['description'].'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" align = "center" >'.date("F j, Y",strtotime("$date")).'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" align = "center" >'.date("g:i a",strtotime("$time")).'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.$row2['fname']." ".$row2['lname'].'</td>
				
				<tr>
				';



			$count++;
			
		}
	}else{
		$list_logs = '<tr><td colspan="6" align="center">No Current Record</td></tr>';
	}
	
	$logs = "<table class = 'event-table' width='100%' style='font-size:11px; margin-top:-10px; margin-bottom:20px;'>
							  <tr>
							  	<th>&nbsp;</th>
							  	<th align='left' width='50'>Location</th>
								<th>Description</th>
								<th>Date Created</th>
								<th>Time Requested</th>
								<th>Guard</th>
							  </tr>
								$list_logs
								
							</table>";
	
	return $logs;
	
}

function get_ticketlogs_admin($tid,$bu){
	include 'global.php';
	$count = 1;
	//$rowBg = 0;
	$q = mysqli_query($conn, "select * from log_mst where ticket = $tid order by time_created ASC");
	if(mysqli_num_rows($q)>0){
	$currentTicket = '';
		while($row = @mysqli_fetch_array($q)){
			
			$id = $row['id'];
			$uid = $row['urcid'];
			$gid = $row['gid'];
			$locid = $row['location'];
			$t_id = $row['ticket'];
			if(is_null($row['ticket'])){
				$rowTicket = 0;
			} else {
				$rowTicket = $row['ticket'];
			}

			
			$result1 = mysqli_query($conn, "select * from urc_mst where id = '".$uid."'");
			$row1 = mysqli_fetch_assoc($result1);
			
			$result2 = mysqli_query($conn, "select * from guard_personnel where id = '".$gid."'");
			$row2 = mysqli_fetch_assoc($result2);
			
			$result3 = mysqli_query($conn, "select * from location_mst where id = '".$locid."'");
			$row3 = mysqli_fetch_assoc($result3);
			
			$result4 = mysqli_query($conn, "select * from ticket where id = '".$t_id."'");
			$row4 = mysqli_fetch_assoc($result4);
			
			// Row color changing
			if($rowBg == 0){
			$class= 'class ="row"';
			$rowBg = 1;
			}
			else{
			$class= 'class ="row1"';
			$rowBg = 0; 
			}
			
			$time = $row['time_created'];
			//$date = $row4['dateadded'];
			$date = $row['date_created'];
		
			$target = "$url_base/view-individual-logs.php";
			$list_logs .= '<tr '.$class.'>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" align="center" width="20">'.$count.'</td>				
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" width="300">'.((!empty($row3['location']))? $row3['location'] : "").'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.$row1['description'].'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" align = "center" >'.date("F j, Y",strtotime("$date")).'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" align = "center" >'.date("g:i a",strtotime("$time")).'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.$row2['fname']." ".$row2['lname'].'</td>
				<td width="20" align="center"><a href="?do=deletelog&lid='.$id.'&id='.$bu.'&log='.$row['date_created'].'&ttype='.get_ttype($t_id).'" onClick="return confirm(\'Are you sure you want to DELETE this log?\')"><img src="images/delete.png" border = "0" alt="Delete item" title="Delete item"  /></a></td>
				</tr>';



			$count++;
			
		}
	}else{
		$list_logs = '<tr><td colspan="7" align="center">No Current Record</td></tr>';
	}
	
	$logs = "<table class = 'event-table' width='100%' style='font-size:11px; margin-top:-10px; margin-bottom:20px;'>
							  <tr>
							  	<th>&nbsp;</th>
							  	<th align='center' width='50'>Location</th>
								<th>Description</th>
								<th>Date Created</th>
								<th>Time Requested</th>
								<th>Guard</th>
								<th>&nbsp;</th>
							  </tr>
								$list_logs
								
							</table>";
	
	return $logs;
	
}

function get_urccode($urcid){
	$q = mysqli_query($conn, "Select * from urc_mst where id = $urcid");
	$r = @mysqli_fetch_array($q);
	
	return $r['codes'];
}

function get_urcdesc($urcid){
	$q = mysqli_query($conn, "Select * from urc_mst where id = $urcid");
	$r = @mysqli_fetch_array($q);
	
	return $r['description'];
}

function get_location($locid){
	$q = mysqli_query($conn, "Select * from location_mst where id = $locid");
	$r = @mysqli_fetch_array($q);
	
	return $r['location'];
}

function get_quard($gid){
	$q = mysqli_query($conn, "Select * from guard_personnel where id = $gid");
	$r = @mysqli_fetch_array($q);
	$list = $r['fname']." ".$r['lname'];
	return $list;
}

function get_encoder($uid){
	$q = mysqli_query($conn, "Select * from users_mst where id = $uid");
	$r = @mysqli_fetch_array($q);
	 $list = $r['fname']." ".$r['mi']." ".$r['lname'];
	return $list;
}

function get_username($uid){
	$q = mysqli_query($conn, "Select * from users_mst where id = $uid");
	$r = @mysqli_fetch_array($q);
	 $list = $r['email'];
	return $list;
}

function get_budesc($buid){
	$q = mysqli_query($conn, "Select * from bu_mst where id = $buid");
	$r = @mysqli_fetch_array($q);
	$list = $r['bu'];
	return $list;
}

function get_exportlogs($bu,$qdate1,$qdate2,$tid,$ctr){
	static $c = 1;
	$q = mysqli_query($conn, "Select * from log_mst where bu = $bu and date_created between '$qdate1' and '$qdate2' and ticket = $tid order by time_created ASC");
	$get_bu_name = mysqli_fetch_array(mysqli_query($conn, "Select * from bu_mst where id = $bu"));
	//$x=1;
	while($r = @mysqli_fetch_array($q)){
		
		$urccode = get_urccode($r['urcid']);
		$urcdesc = get_urcdesc($r['urcid']);
		$datecreated = $r['date_created'];
		$timecreated = $r['time_created'];
		$location = get_location($r['location']);
		
		$remarks = $r['remarks'];
		
		$list .= "$c , $urccode , $urcdesc , $datecreated , $timecreated , $location , ".get_quard($r['gid'])." , ".get_encoder($r['uid'])." , $remarks , ".$get_bu_name['bu']."\n";
		$c++;
	//$x++;
	}
	
	return $list;
	
}

function get_exportlogs_all($qdate1,$qdate2,$tid){
	$q = mysqli_query($conn, "Select * from log_mst where date_created between '$qdate1' and '$qdate2' and ticket = $tid order by time_created ASC");
	$x=1;
	while($r = @mysqli_fetch_array($q)){
		
		$urccode = get_urccode($r['urcid']);
		$urcdesc = get_urcdesc($r['urcid']);
		$datecreated = $r['date_created'];
		$timecreated = $r['time_created'];
		$location = get_location($r['location']);
		
		$remarks = $r['remarks'];
		
		$list .= "$x , $urccode , $urcdesc , $datecreated , $timecreated , $location , ".get_quard($r['gid'])." , ".get_encoder($r['uid'])." , $remarks \n";
	
	$x++;
	}
	
	return $list;
	
}

function get_ttype($ticket) {
	$query = mysqli_query($conn, "Select ticket_type from ticket where id = $ticket");
	
	$row = mysqli_fetch_array($query);
	
	return $row[0];
}

function get_ttype_2($lid) {
	
	$query_ = mysqli_query($conn, "Select ticket from log_mst where id = $lid");
	$row_ = mysqli_fetch_array($query_);	
	$ticket = $row_[0];
	
	$query = mysqli_query($conn, "Select ticket_type from ticket where id = $ticket");
	$row = mysqli_fetch_array($query);
	
	return $row[0];
}

function ListLogs($ticket,$target) {
	$query = mysqli_query($conn, "Select * from log_mst where ticket = $ticket");
	$count = 1;
	$rowBg = 0;
	while ($row = @mysqli_fetch_array($query)) {
		$date = $row['date_created'];
		$time = $row['time_created'];
		$id = $row[0];
		
		//location
		$query_ = mysqli_query($conn, "Select * from location_mst where id = $row[14]");
		$row_ = @mysqli_fetch_array($query_);
		//End

		//urc
		$query_u = mysqli_query($conn, "Select * from urc_mst where id = $row[2]");
		$row_u = @mysqli_fetch_array($query_u);
		//End
		
		//Guard
		$query_a = mysqli_query($conn, "select * from guard_personnel where id = $row[5]");
		$row_a = @mysqli_fetch_array($query_a);
		//End

			if($rowBg == 0){
			$class= 'class ="row"';
			$rowBg = 1;
			}
			else{
			$class= 'class ="row1"';
			$rowBg = 0; 
			}
		
		$list .= '<tr '.$class.'>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.$count.'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" width="200" >'.((!empty($row_['location']))? $row_['location'] : "").'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.$row_u['description'].'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" align = "center" >'.date("F j, Y",strtotime("$date")).'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" align = "center" >'.date("g:i a",strtotime("$time")).'</td>
				<td onclick = "gotoLoc(\''.$target.'?id='.$id.'\')" >'.$row_a['fname']." ".$row_a['lname'].'</td>
				<td></td>
		</tr>';
	$count++;}
	
	return $list;
}

function send_alert_oic($logid,$bu,$url_base) {
	$query = mysqli_query($conn, "Select * from log_mst where id = $logid");
	$row = mysqli_fetch_array($query);
	$oic = $row[16];
	$urcid = $row[2];
	$remarks = $row[6];
	$locid = $row[14];
	$idate = $row[3];
	$itime = $row[4];
	$gid = $row[5];
	$bu = $row[10];
	
	$upload1 = '<a href="'.$url_base.'/'.$row[7].'">'.$row[7].'</a>';
	$upload2 = '<a href="'.$url_base.'/'.$row[8].'">'.$row[8].'</a>';
	$upload3 = '<a href="'.$url_base.'/'.$row[9].'">'.$row[9].'</a>';
	
	//get URC
	$query_urc = mysqli_query($conn, "Select * from urc_mst where id = $urcid");
	$row_urc = @mysqli_fetch_array($query_urc);
	$urcode = $row_urc[1];
	$urcdesc = $row_urc[2];
	//end
	
	//get Location
	$query_loc = mysqli_query($conn, "Select * from location_mst where id = $locid");
	$row_loc = @mysqli_fetch_array($query_loc);
	$location = $row_loc[1];	
	//end
	
	//get Business Unit
	$query_bu = mysqli_query($conn, "Select * from bu_mst where id = $bu");
	$row_bu = @mysqli_fetch_array($query_bu);
	$biz_unit = $row_bu[1];	
	//end
	
	//get Guard
	$query_guard = mysqli_query($conn, "Select * from guard_personnel where id = $gid");
	$row_guard = mysqli_fetch_array($query_guard);
	$guard = $row_guard[1].' '.$row_guard[2];
	//end
	
	//Suspect
	$query_sus = mysqli_query($conn, "Select * from incident_suspect where logId = $logid");
	while ($row_sus = mysqli_fetch_array($query_sus)) {
		$list_sus .= '<p>'.$row_sus[1].' '.$row_sus[2].' '.$row_sus[3].'</p>';
	}
	//end
	
	//Witness
	$query_wit = mysqli_query($conn, "Select * from incident_witness where logId = $logid");
	while ($row_wit = mysqli_fetch_array($query_wit)) {
		$list_wit .= '<p>'.$row_wit[1].' '.$row_wit[2].' '.$row_wit[3].'</p>';
	}
	//end
	
		if ($oic == 1) {
			$query_ = mysqli_query($conn, "Select * from oic_mst where bu = $bu");
			while ($row_ = mysqli_fetch_array($query_)) {
				
			$to = $row_['email_ad'];
			$subject = 'IMPORTANT: SECURITY ALERT!';
			$mainbody = '<table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid #000;">
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td colspan="3" style="background:url('.$url_base.'/images/bg-pattern.png);"><img src="'.$url_base.'/images/login-logo.png" width="297" height="89" alt="Logo"></td>
      </tr>
      <tr>
        <td height="1" colspan="3" bgcolor="#000000"></td>
      </tr>
      <tr>
        <td colspan="3"><h2>Incident Report</h2></td>
      </tr>
      <tr>
        <td width="10%" valign="top">
        <p><strong>What:</strong></p>
        </td>
        <td colspan="2">
		<p>'.$urcode.' - '.$urcdesc.'</p>
		<p>'.$remarks.'</p>
		</td>
      </tr>
      <tr>
        <td valign="top"><strong>Where:</strong></td>
        <td colspan="2">'.$location.'</td>
      </tr>
      <tr>
        <td valign="top"><strong>When:</strong></td>
        <td colspan="2">'.$itime.', '.$idate.'</td>
      </tr>
      <tr>
        <td valign="top"><strong>Who:</strong></td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td valign="top">Reported By:</td>
        <td>'.$guard.'</td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
        <td valign="top">Business Unit:</td>
        <td>'.$biz_unit.'</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td valign="top">Suspect(s):</td>
        <td>'.$list_sus.'</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="9%" valign="top">Witness(es):</td>
        <td width="81%">'.$list_wit.'</td>
      </tr>
      <tr>
        <td valign="top"><strong>Attachment(s):</strong></td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">
		'.$upload1.'<br/>'.$upload2.'<br/>'.$upload3.'
		</td>
      </tr>
    </table></td>
  </tr>
</table>
';
		
			 // To send HTML mail, the Content-type header must be set
			 $headers  = 'MIME-Version: 1.0' . "\r\n";
			 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 $headers .= 'From: INHOUSE SECURITY ALERT <no-reply@aboitiz.com>'."\r\n";
							
				 // Mail it
				if (!empty($to)) {
				ini_set("SMTP","192.168.2.54");
				ini_set("smtp_port","25");
				$mail = @mail($to, $subject, $mainbody, $headers);
				}
				
			}
		}
	
}

function send_fpass($email){
include 'global.php';
	$get_usr2 = mysqli_query($conn, "Select * from users_mst where email = '".$email."'");
	$row_usr2 = @mysqli_fetch_array($get_usr2);
	$newp = ceil(rand(0,10000000000000));
	$hp = md5($newp);
	mysqli_query($conn, "Update users_mst set password = '$hp' where email = '".$email."'");
	$to = 	$row_usr2 ['email'];	
	
    $pass      = $newp;
 
	$subject = "Online Security Logbook forgot password";
	$mainbody = '<div style="border:1px solid #000000; width:605px; padding:5px;" align="center">
  <table width="98%" border="0" cellspacing="2" cellpadding="2">
    <tr bgcolor="red">
      <td><h1>Online Security Logbook</h1></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
      <p>Dear '.$row_usr2['fname'].',</p>
	  <p>&nbsp;</p>
      <p>
		 Your new Password is:'.$pass.'<br><br>
		 <b>Please change your password after you login.</b>
	  </p>	  	  
	 
      </td>
    </tr>
	
  </table>
   <p>
	  <a href="'.$url_home.'" target="_blank">Go to Online Security Logbook</a>
	  </p>
</div>';
	 // To send HTML mail, the Content-type header must be set
	 $headers  = 'MIME-Version: 1.0' . "\r\n";
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 $headers .= 'From: Online Security Logbook <No-Reply@Aboitiz.com>'."\r\n";
	 // Mail it
		if (!empty($to)) {
			ini_set("SMTP","192.168.2.54");
			ini_set("smtp_port","25");
		$mail = @mail($to, $subject, $mainbody, $headers);
		}
}


?>