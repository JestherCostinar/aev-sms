<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$auditid = $_GET['audit_id'];

$ticketid = $_GET['ticket_id'];
$uploadlist = "";
$uploadlist2 = "";
$uploadtable = "";
if($auditid)
{
	$ticketid = $auditid;
	$uploadmstsql = mysqli_query($conn, "SELECT * FROM audit_uploads WHERE audit_id = ".$ticketid);
	while($uploadmstres = mysqli_fetch_assoc($uploadmstsql))
	{
		$uploadersql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$uploadmstres['audit_uploaded_by']);
		$uploaderres = mysqli_fetch_assoc($uploadersql);
		
		$uploadtext1 = substr(trim($uploadmstres['audit_upload_path']), -3);
		$uploadtext = mb_strtolower($uploadtext1);
		if(($uploadtext == "jpg") || ($uploadtext == "gif") || ($uploadtext == "png") || ($uploadtext == "peg"))
		{
			$uploadlist .= "<tr>
								<td colspan='100%' align='center' style='padding:10px;'>
									<img src='".$uploadmstres['audit_upload_path']."' style='width:100%;'>								
									<br>Uploaded on ".$uploadmstres['audit_upload_date']." by ".$uploaderres['fname']." ".$uploaderres['mi']." ".$uploaderres['lname']."
									<br><label style=\"color:red; cursor:pointer;\" onclick=\"deleteItem('".$uploadmstres['id']."', 'Attachments');\">Delete</label>
								</td>							
							</tr>";
		}
		else
		{
			$uploadlink = ltrim($uploadmstres['audit_upload_path'], "audit/");
			$uploadlist2 .= "<tr>
								<td align='right'>Download attachment:</td>
								<td><a href='".$uploadmstres['audit_upload_path']."'>".$uploadlink."</a></td>
							</tr>";
		}
	}
}
else
{
	

	$uploadmstsql = mysqli_query($conn, "SELECT * FROM upload_mst WHERE ticket_id = ".$ticketid);
	while($uploadmstres = mysqli_fetch_assoc($uploadmstsql))
	{
		$uploadersql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$uploadmstres['uploaded_by']);
		$uploaderres = mysqli_fetch_assoc($uploadersql);
		
		$uploadtext1 = substr(trim($uploadmstres['upload_path']), -3);
		$uploadtext = mb_strtolower($uploadtext1);
		if(($uploadtext == "jpg") || ($uploadtext == "gif") || ($uploadtext == "png") || ($uploadtext == "PNG") || ($uploadetxt == "peg"))
		{
			$uploadlist .= "<tr>
								<td colspan='100%' align='center' style='padding:10px;'>
									<img src='".$uploadmstres['upload_path']."' style='width:100%;'>								
									<br>Uploaded on ".$uploadmstres['date_uploaded']." by ".$uploaderres['fname']." ".$uploaderres['mi']." ".$uploaderres['lname']."
									<br><label style=\"color:red; cursor:pointer;\" onclick=\"deleteItem('".$uploadmstres['id']."', 'Attachments');\">Delete</label>
								</td>							
							</tr>";
		}
		else
		{
			$uploadlink = ltrim($uploadmstres['upload_path'], "upload/");
			$uploadlist2 .= "<tr>
								<td align='right'>Download attachment:</td>
								<td><a href='".$uploadmstres['upload_path']."'>".$uploadlink."</a></td>
							</tr>";
		}
	}

	$olduploadsql = mysqli_query($conn, "SELECT * FROM log_mst WHERE ticket = ".$ticketid);
	while($olduploadres = mysqli_fetch_assoc($olduploadsql))
	{
		$uploadersql2 = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$olduploadres['gid']);
		$uploaderres2 = mysqli_fetch_assoc($uploadersql2);
		
		if($olduploadres['upload1'])
		{
			$uploadlist .= "<tr>
								<td colspan='100%' align='center' style='padding:10px;'>
									<img src='".$olduploadres['upload1']."' style='width:100%;'>
									<br>Uploaded on ".$olduploadres['datesubmitted']." by ".$uploaderres2['fname']." ".$uploaderres2['mi']." ".$uploaderres2['lname']."
								</td>
							</tr>";
		}
		if($olduploadres['upload2'])
		{
			$uploadlist .= "<tr>
								<td colspan='100%' align='center' style='padding:10px;'>
									<img src='".$olduploadres['upload2']."' style='width:100%;'>
									<br>Uploaded on ".$olduploadres['datesubmitted']." by ".$uploaderres2['fname']." ".$uploaderres2['mi']." ".$uploaderres2['lname']."
								</td>
							</tr>";
		}
		if($olduploadres['upload3'])
		{
			$uploadlist .= "<tr>
								<td colspan='100%' align='center' style='padding:10px;'>
									<img src='".$olduploadres['upload3']."' style='width:100%;'>
									<br>Uploaded on ".$olduploadres['datesubmitted']." by ".$uploaderres2['fname']." ".$uploaderres2['mi']." ".$uploaderres2['lname']."
								</td>
							</tr>";
		}
	}
}

if(($uploadlist) || ($uploadlist2))
{
	if($uploadlist)
	{
		$uploadtable .= "<table width='80%' align='center' border='1'>
							<tr>
								<th colspan='100%'>Picture Attachments</th>
							</tr>
							".$uploadlist."
						</table>";
	}
	if($uploadlist2)
	{
		$uploadtable .= "<br>
						<table width='80%' align='center'>
							<tr>
								<th colspan='100%'>Other Attachments</th>
							</tr>
							".$uploadlist2."
						</table>";
	}
	$uploadtable .= "<br>
						<table width='80%' align='center'>
							<tr>
								<td colspan='100%'><button class='redbutton' id='btnCancelUpload2' name='btnCancelUpload2' onclick='closeUploadModal();'>Close</button></td>
							</tr>
							
						</table>";
	
}
else
{
	$uploadtable = "<table width='80%' align='center'>
						<tr align='center'>
							<td colspan='100%'>No Attachments</td>
						</tr>
						<tr align='center'>
							<td colspan='100%'><button class='redbutton' id='btnCancelUpload2' name='btnCancelUpload2' onclick='closeUploadModal();'>Close</button></td>
						</tr>
					</table>";
}


if(!empty($uploadtable))
{
	echo $uploadtable;
}
else
{
	echo "<table width='80%' align='center'><tr><td colspan='100%' align='center'>No Attachments</td></tr></table>";
}



?>
