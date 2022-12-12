<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
include("sendmail.php");
include("class.upload.php-master/src/class.upload.php");

if($_POST)
{
	if((!empty($_POST['addguardstat'])) and ($_POST['addguardstat'] == "Add")){
		$glname = mysqli_real_escape_string($conn, $_POST['txtglname']);
		$gfname = mysqli_real_escape_string($conn, $_POST['txtgfname']);
		$gmname = mysqli_real_escape_string($conn, $_POST['txtgmname']);
		$ggender = $_POST['selggender'];
		$gbirthdate = $_POST['txtgbdate'];
		$gbloodtype = $_POST['selgbloodtype'];
		$gcivstat = $_POST['selgcivstat'];
		$gpreadd = mysqli_real_escape_string($conn, $_POST['txtgpreadd']);
		$gproadd = mysqli_real_escape_string($conn, $_POST['txtgproadd']);
		$gaddcontact = mysqli_real_escape_string($conn, $_POST['txtgcontact']);
		$gbu = $_POST['txtgbu'];
		$gdateposted = $_POST['txtgposted'];
		$gempagency = $_POST['txtgempagency'];
		$gaddcode = mysqli_real_escape_string($conn, $_POST['txtgcode']);
		$gagency = $_POST['selgagency'];
		$gcategory = mysqli_real_escape_string($conn, $_POST['txtgcategory']);
		$gbadge = mysqli_real_escape_string($conn, $_POST['txtgbadge']);
		//$gsss = mysqli_real_escape_string($conn, $_POST['txtgsss']);
		$glicense = mysqli_real_escape_string($conn, $_POST['txtglicense']);
		$glicenseissue = $_POST['txtglicenseissue'];
		$glicenseexpiry = $_POST['txtglicenseexpiry'];
		$gntclicense = mysqli_real_escape_string($conn, $_POST['txtgntclicense']);
		$gntclicenseissue = $_POST['txtgntclicenseissue'];
		$gntclicenseexpiry = $_POST['txtgntclicenseexpiry'];
		$gperformance = $_POST['selgperformance'];
		$gcomment = mysqli_real_escape_string($conn, $_POST['gcomment']);
//		mysqli_query($conn,"INSERT INTO guard_personnel(fname, mname, lname, gender, birthdate, blood_type, civil_status, present_address, provincial_address, contact, bu, date_posted, agency_employment, guard_code, agency, guard_category, badge_number, license_number, license_issue_date, license_expiry_date, ntc_license, ntc_license_start, ntc_license_end, performance, comment, status, date_created) values('".$gfname."', '".$gmname."', '".$glname."', '".$ggender."', '".$gbirthdate."', '".$gbloodtype."', '".$gcivstat."', '".$gpreadd."', '".$gproadd."', '".$gaddcontact."', '".$gbu."', '".$gdateposted."', '".$gempagency."', '".$gaddcode."', '".$gagency."', '".$gcategory."', '".$gbadge."', '".$glicense."', '".$glicenseissue."', '".$glicenseexpiry."', '".$gntclicense."', '".$gntclicenseissue."', '".$gntclicenseexpiry."', '".$gperformance."', '".$gcomment."', 'Active', now())") or die(mysqli_error($conn));
		mysqli_query($conn,"INSERT INTO guard_personnel(fname, lname, bu, date_posted, guard_code, guard_category, license_number, license_issue_date, license_expiry_date, ntc_license, ntc_license_start, ntc_license_end, performance, comment, status, date_created) values('".$gfname."', '".$glname."', '".$gbu."', '".$gdateposted."', '".$gaddcode."', '".$gcategory."', '".$glicense."', '".$glicenseissue."', '".$glicenseexpiry."', '".$gntclicense."', '".$gntclicenseissue."', '".$gntclicenseexpiry."', '".$gperformance."', '".$gcomment."', 'Active', now())") or die(mysqli_error($conn));
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Added guard personnel', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
		$get_last_guardid = mysqli_fetch_array(mysqli_query($conn, "Select id from guard_personnel order by id desc"));
		$lguardid = $get_last_guardid['id'];			
			// foreach($_FILES['guardpic']['name'] as $guardpic){
			  // if($guardpic == ""){
			  // $guardpath = "" ;
			  // }else{
			  // $guardpath =  "guardphotos/".$lguardid."-".$guardpic;
			  // }
			  // mysqli_query($conn, "update guard_personnel set guard_photo = '$guardpath' where id = $lguardid");
			  // @copy($_FILES['guardpic']['tmp_name'][0],$guardpath);			  
			// }
		$handle = new upload($_FILES['guardpic']);
			if ($handle->uploaded) {
			  $handle->file_new_name_body   = 'guardpic_'. $gaddid;
			  $handle->image_resize         = true;
			  $handle->image_x              = 150;
			  $handle->image_ratio_y        = true;
			  $handle->file_overwrite = true;
			  $handle->process('guardphotos/');
			  if ($handle->processed) {
				//echo 'image resized';
				mysqli_query($conn, "update guard_personnel set guard_photo = 'guardphotos/".$handle->file_dst_name."' where id = ".$lguardid) or die(mysqli_error($conn));
				$handle->clean();
				
			  } else {
				echo 'error : ' . $handle->error;
			  }
			}
		header("Location: user-admin.php?last=GuardMgt");
	}
	elseif((!empty($_POST['editguardstat'])) and ($_POST['editguardstat'] == "Edit")){
		$glname = mysqli_real_escape_string($conn, $_POST['txtglname']);
		$gfname = mysqli_real_escape_string($conn, $_POST['txtgfname']);
		$gmname = mysqli_real_escape_string($conn, $_POST['txtgmname']);
		$ggender = $_POST['selggender'];
		$gbirthdate = $_POST['txtgbdate'];
		$gbloodtype = $_POST['selgbloodtype'];
		$gcivstat = $_POST['selgcivstat'];
		$gpreadd = mysqli_real_escape_string($conn, $_POST['txtgpreadd']);
		$gproadd = mysqli_real_escape_string($conn, $_POST['txtgproadd']);
		$gaddcontact = mysqli_real_escape_string($conn, $_POST['txtgcontact']);
		$gbu = $_POST['txtgbu'];
		$gstat = $_POST['selgstat'];
		$gdateposted = $_POST['txtgposted'];
		$gempagency = $_POST['txtgempagency'];
		$gaddcode = mysqli_real_escape_string($conn, $_POST['txtgcode']);
		$gagency = $_POST['selgagency'];
		$gcategory = mysqli_real_escape_string($conn, $_POST['txtgcategory']);
		$gbadge = mysqli_real_escape_string($conn, $_POST['txtgbadge']);
		//$gsss = mysqli_real_escape_string($conn, $_POST['txtgsss']);
		$glicense = mysqli_real_escape_string($conn, $_POST['txtglicense']);
		$glicenseissue = $_POST['txtglicenseissue'];
		$glicenseexpiry = $_POST['txtglicenseexpiry'];
		$gntclicense = mysqli_real_escape_string($conn, $_POST['txtgntclicense']);
		$gntclicenseissue = $_POST['txtgntclicenseissue'];
		$gntclicenseexpiry = $_POST['txtgntclicenseexpiry'];
		$gperformance = $_POST['selgperformance'];		
		$gaddid = $_POST['txtguardid'];
		$gcomment = mysqli_real_escape_string($conn, $_POST['gcomment']);
//		mysqli_query($conn,"UPDATE guard_personnel SET fname = '".$gfname."', mname = '".$gmname."', lname = '".$glname."', gender = '".$ggender."', birthdate = '".$gbirthdate."', blood_type = '".$gbloodtype."', civil_status = '".$gcivstat."', present_address = '".$gpreadd."', provincial_address = '".$gproadd."', contact = '".$gaddcontact."', bu = '".$gbu."', status = '".$gstat."', date_posted = '".$gdateposted."', agency_employment = '".$gempagency."', guard_code = '".$gaddcode."', agency = '".$gagency."', guard_category = '".$gcategory."', badge_number = '".$gbadge."', license_number = '".$glicense."', license_issue_date = '".$glicenseissue."', license_expiry_date = '".$glicenseexpiry."', ntc_license = '".$gntclicense."', ntc_license_start = '".$gntclicenseissue."', ntc_license_end = '".$gntclicenseexpiry."', performance = '".$gperformance."', comment = '".$gcomment."' WHERE id = $gaddid ") or die(mysqli_error($conn));
		mysqli_query($conn,"UPDATE guard_personnel SET fname = '".$gfname."', lname = '".$glname."', bu = '".$gbu."', status = '".$gstat."', date_posted = '".$gdateposted."', guard_code = '".$gaddcode."', guard_category = '".$gcategory."', license_number = '".$glicense."', license_issue_date = '".$glicenseissue."', license_expiry_date = '".$glicenseexpiry."', ntc_license = '".$gntclicense."', ntc_license_start = '".$gntclicenseissue."', ntc_license_end = '".$gntclicenseexpiry."', performance = '".$gperformance."', comment = '".$gcomment."' WHERE id = $gaddid ") or die(mysqli_error($conn));
		// foreach($_FILES['guardpic']['name'] as $guardpic){
			  // if($guardpic == ""){
			  
			  // }else{
			  // $guardpath =  "guardphotos/".$gaddid."-".$guardpic;
			  // mysqli_query($conn, "update guard_personnel set guard_photo = '$guardpath' where id = $gaddid");
			  // @copy($_FILES['guardpic']['tmp_name'][0],$guardpath);
			  // }
			  			  
			// }
		
			$handle = new upload($_FILES['guardpic']);
			if ($handle->uploaded) {
			  $handle->file_new_name_body   = 'guardpic_'. $gaddid;
			  $handle->image_resize         = true;
			  $handle->image_x              = 150;
			  $handle->image_ratio_y        = true;
			  $handle->file_overwrite = true;
			  $handle->process('guardphotos/');
			  if ($handle->processed) {
				//echo 'image resized';
				mysqli_query($conn, "update guard_personnel set guard_photo = 'guardphotos/".$handle->file_dst_name."' where id = $gaddid") or die(mysqli_error($conn));
				$handle->clean();
				
			  } else {
				echo 'error : ' . $handle->error;
			  }
			}
		
		mysqli_query($conn, "INSERT INTO system_log (uid, log, datetime, bu_id) VALUES ('".$_SESSION['id']."', 'Edited guard personnel #".$gaddid."', now(), ".$_SESSION['bu'].")") or die(mysqli_error($conn));
		if($_SESSION['level'] == "Admin")
		{
			header("Location: user-admin.php?last=GuardMgt") ;
		}
		elseif($_SESSION['level'] == "Super Admin")
		{
			header("Location: user-superadmin.php?last=GuardMgt") ;
		}
		
	}
	elseif(!empty($_POST['btnAddTest']))
	{
		
		$i2=0;
		$catch = "start";
		foreach($_FILES['testattach1']['name'] as $attach)			
		{
			if($attach == ""){
				$path = "" ;
			}
			else{
				$path =  "csvuploads/".$attach;
			}
				
			if($path)
			{				
				if(@copy($_FILES['testattach1']['tmp_name'][$i2],$path))
				{
					mysqli_query($conn, "INSERT INTO csvuploads_mst (csvpath) VALUES('".$path."')");
					$catch = "uploadsuccess";
				}
				else
				{
					$catch = "uploadfail ".$_FILES['userfile']['error'];
				}
				
				$lastidsql = mysqli_query($conn, "SELECT * FROM csvuploads_mst ORDER BY id DESC LIMIT 1");
				$lastidres = mysqli_fetch_assoc($lastidsql);
				
				//mysqli_query($conn, "LOAD DATA LOCAL INFILE '".$lastidres['csvpath']."`' INTO TABLE bu_locators FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' IGNORE 1 LINES") or die(mysqli_error($conn));
				
				$array_check = array("Business Objectives", "Stakeholder Groups", "Stakeholder Name", "Position", "Current Level of Support", "Target Level of Support", "Engagement Activity", "Core Messages", "Frequency", "Target Date", "Budget", "Status", "Remarks");
				$array_include = array();
				$f_pointer=fopen($lastidres['csvpath'],"r"); // file pointer
				$first_line="T";

				while(! feof($f_pointer))
				{
					if($first_line=='T')
					{
						
					}
					elseif($first_line<>'T')
					{
						$ar=fgetcsv($f_pointer);
						$sql="INSERT INTO bu_locators(bu_id,locator_name,status)values('$ar[0]','$ar[1]','$ar[2]')";
						mysqli_query($conn, $sql);
					}
					$first_line='F';
				}
				
				
			}
			//@copy($_FILES['licenseattach1']['tmp_name'][$i2],$path);		
			$i2++;
			$i++;
			
			
			
		}
				
		
		
		if($_SESSION['level'] == 'Super Admin')
		{
			header("Location: user-superadmin.php");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("Location: user-admin.php");
		}
	}
	elseif(!empty($_POST['btnStakeholderSave']))
	{
		$bu_id = $_POST["stakeBUID"];
		$business_objective =  mysqli_real_escape_string($conn, $_POST["txtStakeBUObj"]);
		$stakeholder_group =  mysqli_real_escape_string($conn, $_POST["txtStakeStakeGroup"]);
		$stakeholder_name =  mysqli_real_escape_string($conn, $_POST["txtStakeStakeName"]);
		$position =  mysqli_real_escape_string($conn, $_POST["txtStakePosition"]);
		$priority_level =  mysqli_real_escape_string($conn, $_POST["selStakePriority"]);
		$current_support =  mysqli_real_escape_string($conn, $_POST["selStakeCurSupLvl"]);
		$target_support =  mysqli_real_escape_string($conn, $_POST["selStakeTgtSupLvl"]);
		$engagement_activity =  mysqli_real_escape_string($conn, $_POST["txtStakeEngAct"]);
		$core_messages =  mysqli_real_escape_string($conn, $_POST["txtStakeCoreMsg"]);
		$frequency =  mysqli_real_escape_string($conn, $_POST["txtStakeFrequency"]);
		$target_date = $_POST["txtStakeTgtDate"];
		$budget =  mysqli_real_escape_string($conn, $_POST["txtStakeBudget"]);
		$remarks =  mysqli_real_escape_string($conn, $_POST["txtStakeRemarks"]);
		$status =  mysqli_real_escape_string($conn, $_POST["selStakeStatus"]);
		
		mysqli_query($conn, "INSERT INTO stakeholder_engagement (bu_id, business_objective, stakeholder_group, stakeholder_name, position, priority_level, current_support, target_support, engagement_activity, core_messages, frequency, target_date, budget, remarks, status) VALUES(".$bu_id.", '".$business_objective."', '".$stakeholder_group."', '".$stakeholder_name."', '".$position."', '".$priority_level."', '".$current_support."', '".$target_support."', '".$engagement_activity."', '".$core_messages."', '".$frequency."', '".$target_date."', ".$budget.", '".$remarks."', '".$status."')") or die(mysqli_error($conn));
		
		if($_SESSION['level'] == 'Super Admin')
		{
			header("Location: user-superadmin.php");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("Location: user-admin.php");
		}
		
	}
}
?>