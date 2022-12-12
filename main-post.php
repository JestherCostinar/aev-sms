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
		/* $business_objective =  mysqli_real_escape_string($conn, $_POST["txtStakeBUObj"]);
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
		$status =  mysqli_real_escape_string($conn, $_POST["selStakeStatus"]); */
		
		/* $stakeholder_name =  mysqli_real_escape_string($conn, $_POST["txtStakeName"]);
		$engagement_activity =  mysqli_real_escape_string($conn, $_POST["txtStakeDesc"]);
		$status =  mysqli_real_escape_string($conn, $_POST["selStakeStatus"]);
		$year =  mysqli_real_escape_string($conn, $_POST["stakeyear"]); */
		
		$score =  mysqli_real_escape_string($conn, $_POST["txtStakeScore"]);
		$score_description =  mysqli_real_escape_string($conn, $_POST["txtStakeScoreDesc"]);
		$score_link =  mysqli_real_escape_string($conn, $_POST["txtStakeLink"]);
		$year =  mysqli_real_escape_string($conn, $_POST["stakeyear"]);
		
		//mysqli_query($conn, "INSERT INTO stakeholder_engagement (bu_id, business_objective, stakeholder_group, stakeholder_name, position, priority_level, current_support, target_support, engagement_activity, core_messages, frequency, target_date, budget, remarks, status) VALUES(".$bu_id.", '".$business_objective."', '".$stakeholder_group."', '".$stakeholder_name."', '".$position."', '".$priority_level."', '".$current_support."', '".$target_support."', '".$engagement_activity."', '".$core_messages."', '".$frequency."', '".$target_date."', ".$budget.", '".$remarks."', '".$status."')") or die(mysqli_error($conn));
	//	mysqli_query($conn, "INSERT INTO stakeholder_engagement (bu_id, stakeholder_name, engagement_activity, status, year) VALUES(".$bu_id.", '".$stakeholder_name."', '".$engagement_activity."', '".$status."', ".$year.")") or die(mysqli_error($conn));
	//	mysqli_query($conn, "INSERT INTO stakeholder_mst (bu_id, stakeholder_name, engagement_activity, status, year) VALUES(".$bu_id.", '".$stakeholder_name."', '".$engagement_activity."', '".$status."', ".$year.")") or die(mysqli_error($conn));
		
		mysqli_query($conn, "INSERT INTO stakeholder_mst_new (bu_id, score, score_description, score_link, year) VALUES(".$bu_id.", '".$score."', '".$score_description."', '".$score_link."', ".$year.")") or die(mysqli_error($conn));
		
		if($_SESSION['level'] == 'Super Admin')
		{
			header("location:user-superadmin.php?last=Stakeholder");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("location:user-admin.php?last=Stakeholder");
		}
		else
		{
			header("location:user-admin.php?last=Stakeholder");
		}
		
	}
	elseif(!empty($_POST['btnStakeholderEdit']))
	{
		//$bu_id = $_POST["stakeBUID"];
		$stakeid = $_POST["stakeID"];
				
		//$stakeholder_name =  mysqli_real_escape_string($conn, $_POST["txtStakeName"]);
		//$engagement_activity =  mysqli_real_escape_string($conn, $_POST["txtStakeDesc"]);
		//$status =  mysqli_real_escape_string($conn, $_POST["selStakeStatus"]);
		//$year =  mysqli_real_escape_string($conn, $_POST["stakeyear"]);
		
		$score =  mysqli_real_escape_string($conn, $_POST["txtStakeScore"]);
		$score_description =  mysqli_real_escape_string($conn, $_POST["txtStakeScoreDesc"]);
		$score_link =  mysqli_real_escape_string($conn, $_POST["txtStakeLink"]);
		
		//mysqli_query($conn, "INSERT INTO stakeholder_engagement (bu_id, business_objective, stakeholder_group, stakeholder_name, position, priority_level, current_support, target_support, engagement_activity, core_messages, frequency, target_date, budget, remarks, status) VALUES(".$bu_id.", '".$business_objective."', '".$stakeholder_group."', '".$stakeholder_name."', '".$position."', '".$priority_level."', '".$current_support."', '".$target_support."', '".$engagement_activity."', '".$core_messages."', '".$frequency."', '".$target_date."', ".$budget.", '".$remarks."', '".$status."')") or die(mysqli_error($conn));
		//mysqli_query($conn, "INSERT INTO stakeholder_engagement (bu_id, stakeholder_name, engagement_activity, status, year) VALUES(".$bu_id.", '".$stakeholder_name."', '".$engagement_activity."', '".$status."', ".$year.")") or die(mysqli_error($conn));
	//	mysqli_query($conn, "UPDATE stakeholder_engagement SET stakeholder_name = '".$stakeholder_name."', engagement_activity = '".$engagement_activity."', status = '".$status."' WHERE id = ".$stakeid) or die(mysqli_error($conn));
	//	mysqli_query($conn, "UPDATE stakeholder_mst SET stakeholder_name = '".$stakeholder_name."', engagement_activity = '".$engagement_activity."', status = '".$status."' WHERE id = ".$stakeid) or die(mysqli_error($conn));
		
		mysqli_query($conn, "UPDATE stakeholder_mst_new SET score = '".$score."', score_description = '".$score_description."', score_link = '".$score_link."' WHERE id = ".$stakeid) or die(mysqli_error($conn));
		
		if($_SESSION['level'] == 'Super Admin')
		{
			header("location:user-superadmin.php?last=Stakeholder");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("location:user-admin.php?last=Stakeholder");
		}
		else
		{
			header("location:user-admin.php?last=Stakeholder");
		}
		
	}
	elseif(!empty($_POST['btnSaveIDP']))
	{
		$idpUser = $_POST['selIDPUser'];
		$idpDesc = $_POST['txtIDPDesc'];
		$idpStatus = $_POST['selIDPStatus'];
		$idpYear = $_POST['txtIDPYear'];
		$idpGroup = $_POST['txtIDPGroup'];
		$idpToken = $_POST['txtTokenType'];
		$idpEntryId = $_POST['txtEntryID'];
		
		$idpScore = $_POST['txtIDPScore'];
		$idpLink= $_POST['txtIDPLink'];
		
		if($idpToken == 'Add')
		{
			//mysqli_query($conn, "INSERT INTO idp_mst (group_id, name, description, status, year) VALUES(".$idpGroup.", '".$idpUser."', '".$idpDesc."', '".$idpStatus."', ".$idpYear.")")or die(mysqli_error($conn));
			mysqli_query($conn, "INSERT INTO idp_mst_new (bu_id, name, score, score_description, score_link, year) VALUES(".$bu.", '".$idpUser."', '".$idpScore."', '".$idpDesc."', '".$idpLink."', ".$idpYear.")")or die(mysqli_error($conn));
		}
		elseif($idpToken == 'Edit')
		{
			//mysqli_query($conn, "UPDATE idp_mst SET name = '".$idpUser."', description = '".$idpDesc."', status = '".$idpStatus."' WHERE id = ".$idpEntryId)or die(mysqli_error($conn));
			mysqli_query($conn, "UPDATE idp_mst_new SET name = '".$idpUser."', score = '".$idpScore."', score_description = '".$idpDesc."', score_link = '".$idpLink."' WHERE id = ".$idpEntryId)or die(mysqli_error($conn));
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
	elseif(!empty($_POST['btnSaveIDPUser']))
	{
		$idpName = $_POST['txtIDPUser'];
		$idpGroup = $_POST['txtIDPGroupUser'];
		$idpToken = $_POST['txtTokenType2'];
		$idpEntryId = $_POST['txtEntryID'];
		
		if($idpToken == 'Add')
		{
			mysqli_query($conn, "INSERT INTO idp_users (group_id, name) VALUES(".$idpGroup.", '".$idpName."')")or die(mysqli_error($conn));
		}
		elseif($idpToken == 'Edit')
		{
			mysqli_query($conn, "UPDATE idp_users SET name = '".$idpName."' WHERE id = ".$idpEntryId);
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
	elseif(!empty($_POST['btnaddIA']))
	{
		$IAYear = $_POST['numaddIAyear'];
		$IABuId = $_POST['seladdIABU'];
		$IAMonth = $_POST['seladdIAmonth'];
		$IAIncidents = $_POST['numaddIAtotal'];
		$IAMiss = $_POST['numaddIAmiss'];
		
		mysqli_query($conn, "INSERT INTO incident_accuracy_mst (bu_id, year, month, miss, total) VALUES(".$IABuId.", ".$IAYear.", ".$IAMonth.", ".$IAMiss.", ".$IAIncidents.")")or die(mysqli_error($conn));
	}
	if($_SESSION['level'] == 'Super Admin')
		{
			header("Location: user-superadmin.php?last=IncAud");
		}
		elseif($_SESSION['level'] == 'Admin')
		{
			header("Location: user-admin.php");
		}
}
?>