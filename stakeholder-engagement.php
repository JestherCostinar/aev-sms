<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");
	include("class.upload.php-master/src/class.upload.php");
	
	$stakeid = $_GET['stakeid'];
	$gettype = $_GET['gettype'];
	$stakeyear = $_GET['stakeyear'];
	
	$resulttable = "";
	
	if($gettype == "form")
	{
		
		$resulttable =	"<form id='frmStakeholder' name='frmStakeholder' action='main-post.php' method='post'>" .
						"<table align='center' >" .
							"<tr>" .
								"<td>" .
									"<fieldset>" .
									"<legend>Stakeholder Assignment</legend>" .
										"<table>" .
											"<tr>" .
												"<td>Business Objective:</td>" .
												"<td><input id='txtStakeBUObj' name='txtStakeBUObj' type='text' /></td>" .
											"</tr>" .		
											"<tr>" .
												"<td>Stakeholder Group/Org:</td>" .
												"<td><input id='txtStakeStakeGroup' name='txtStakeStakeGroup' type='text' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Stakeholder Name:</td>" .
												"<td><input id='txtStakeStakeName' name='txtStakeStakeName' type='text' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Position:</td>" .
												"<td><input id='txtStakePosition' name='txtStakePosition' type='text' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Priority Level:</td>" .
												"<td>" .
													"<select id='selStakePriority' name='selStakePriority' >" .
														"<option></option>" .
														"<option value='Q1'>Q1</option>" .
														"<option value='Q2'>Q2</option>" .
														"<option value='Q3'>Q3</option>" .
														"<option value='Q4'>Q4</option>" .													
													"</select>" .
												"</td>" .
											"</tr>" .
											"<tr>" .
												"<td>Current Level of Support:</td>" .	
												"<td>" .
													"<select id='selStakeCurSupLvl' name='selStakeCurSupLvl' >" .
														"<option></option>" .
														"<option value='Very Low Support'>Very Low Support</option>" .
														"<option value='Low Support'>Low Support</option>" .
														"<option value='Neutral Support'>Neutral Support</option>" .
														"<option value='High Support'>High Support</option>" .
														"<option value='Very High Support'>Very High Support</option>" .
													"</select>" .
												"</td>" .
											"</tr>" .										
										"</table>" .
									"</fieldset>" .
								"</td>" .
								"<td>" .
									"<fieldset>" .
									"<legend>Engagement Activity</legend>" .
										"<table>" .
											"<tr>" .
												"<td>Target Level of Support:</td>" .
												"<td>" .
													"<select id='selStakeTgtSupLvl' name='selStakeTgtSupLvl' >" .
														"<option></option>" .
														"<option value='Very Low Support'>Very Low Support</option>" .
														"<option value='Low Support'>Low Support</option>" .
														"<option value='Neutral Support'>Neutral Support</option>" .
														"<option value='High Support'>High Support</option>" .
														"<option value='Very High Support'>Very High Support</option>" .
													"</select>" .
												"</td>" .
											"</tr>" .
											"<tr>" .
												"<td>Engagement Activity:</td>" .
												"<td><input id='txtStakeEngAct' name='txtStakeEngAct' type='text' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Core Messages:</td>" .
												"<td><input id='txtStakeCoreMsg' name='txtStakeCoreMsg' type='text' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Frequency:</td>" .
												"<td><input id='txtStakeFrequency' name='txtStakeFrequency' type='text' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Target Date:</td>" .
												"<td><input id='txtStakeTgtDate' name='txtStakeTgtDate' type='date' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Budget:</td>" .
												"<td><input id='txtStakeBudget' name='txtStakeBudget' type='text' /></td>" .
											"</tr>" .										
										"</table>" .
									"</fieldset>" .
								"</td>" .
							"</tr>" .
							"<tr>" .
								"<td>" .								
									"Status: <select id='selStakeStatus' name='selStakeStatus'>" .
										"<option value='Not Started'>Not Started</option>" .
										"<option value='In Progress'>In Progress</option>" .
										"<option value='Done'>Done</option>" .										
									"</select></br>" . 
									"Remarks:<br><textarea id='txtStakeRemarks' name='txtStakeRemarks' style='resize:none; width:100%;'></textarea>" .
								"</td>" .
								"<td valign='bottom' align='center'>" .
									"<input type='submit' class='redbutton' id='btnStakeholderSave' name='btnStakeholderSave' value='Save' />" .									
									"<button class='redbutton' id='btnStakeholderClose' name='btnStakeholderClose' onclick='fnStakeholderClose();'>Close</button>" .
									
									"<input id='stakeBUID' name='stakeBUID' type='hidden' value='1'>" .
								"</td>" .
							"</tr>" .							
						"</table>" .
						"</form>";
	}
	elseif($gettype == "table")
	{
		$resulttable .=	"<table align='center' style='margin-left:24px; max-width:500px;' >" .
							"<tr>" .
								"<th colspan='100%' style='font-size:24px; text-align:left;'>Stakeholder Engagements</th>" . 
							"</tr>" .
						"</table></br>" .
						"<table id='tblStakeMain' name='tblStakeMain' border='1' align='center' style='margin-left:24px; border-collapse:collapse; max-width:800px;'>" .
							"<thead>" .
								"<tr>" .
									"<td colspan='100%'>" .
										"Year:" .
										"<input id='numStakeYear' name='numStakeYear' type='number' min='2020' value='2020' width='50px'>" .
					
							//			"<img src='images/Search-icon.png' height='24px' id='btnShowStakeMain' name='btnShowStakeMain' title='Search Engagements' style='cursor:pointer; vertical-align:middle;' onclick=\"showStakeholder('search');\"></td>" .
										"<img src='images/Search-icon.png' height='24px' id='btnShowStakeMain' name='btnShowStakeMain' title='Search Engagements' style='cursor:pointer; vertical-align:middle;' onclick=\"showStakeholder('search2');\"></td>" .
								"</tr>" .
							"</thead>" .
							"<tbody id='staketablebody' name='staketablebody'>" .
								"<tr>" .
									"<td>Use the search year function to get started.</td>" .
								"</tr>" .
							"</tbody>" .
							"<tfoot>" .
								"<tr>" .
							//		"<td colspan='100%' align='center'><button class='redbutton' id='btnAddStake' name='btnAddStake' onclick=\"showStakeholder('form2');\">Add Activity</button></td>" .
									"<td colspan='100%' align='center'><button class='redbutton' id='btnAddStake' name='btnAddStake' onclick=\"showStakeholder('form3');\">Add Score</button></td>" .
								"</tr>" .
							"</tfoot>" .
						"</table>";
	}
	elseif($gettype == "tableold")
	{
		$stakerows = "";
		//$stakesql = mysqli_query($conn, "SELECT * FROM stakeholder_engagement WHERE bu_id = ".$stakeid);
		$stakesql = mysqli_query($conn, "SELECT * FROM stakeholder_engagement WHERE bu_id = 1");
		while($stakeres = mysqli_fetch_assoc($stakesql))
		{
			$stakerows .=	"<tr>" .
								"<td class='tdStakeholder' style='display:none;'>".$stakeres['business_objective']."</td>" .
								"<td>".$stakeres['stakeholder_group']."</td>" .
								"<td>".$stakeres['stakeholder_name']."</td>" .
								"<td class='tdStakeholder' style='display:none;'>".$stakeres['position']."</td>" .
								"<td class='tdStakeholder' style='display:none;'>".$stakeres['priority_level']."</td>" .
								"<td class='tdStakeholder' style='display:none;'>".$stakeres['current_support']."</td>" .
								"<td class='tdActivity'>".$stakeres['target_support']."</td>" .
								"<td>".$stakeres['engagement_activity']."</td>" .
								"<td class='tdActivity'>".$stakeres['core_messages']."</td>" .
								"<td class='tdActivity'>".$stakeres['frequency']."</td>" .
								"<td>".$stakeres['target_date']."</td>" .
								"<td class='tdActivity'>".$stakeres['budget']."</td>" .
								"<td>".$stakeres['remarks']."</td>" .
								"<td>".$stakeres['status']."</td>" .
							"</tr>";
		}
		
		if(!($stakerows))
		{
			$stakerows = "<tr><td colspan='100%' align='center'>No records to show</td></tr>";
		}
		
		
		
		$resulttable =	"<table style='margin-left:auto; margin-right:auto; width:95%;'><tr><td><img src='images/add_item.png' height='30px' onclick=\"showStakeholder('form2')\" style='cursor:pointer;' /></td><td align='right' style='color:red;'>*Click headers to expand</td></tr></table>" .
						"<table border='1' style='border-collapse:collapse; margin-left:auto; margin-right:auto; width:95%;'>" .
							"<thead>" .
								"<tr>" .
									"<th id='thStakeholder' name='thStakeholder' colspan='2' style='background-color:orange; color:white; cursor:pointer;' onclick='expandStakeholders(1);'>Stakeholder</th>" .
									"<th id='thActivity' name='thActivity' colspan='6' style='background-color:blue; color:white; cursor:pointer;' onclick='expandStakeholders(2);'>Engagement Activity</th>" .
									"<th id='thRemarks' namee='thRemarks' colspan='2' style='background-color:red; color:white;'>Remarks</th>" .
								"</tr>" .
								"<tr>" .
									"<th class='tdStakeholder' style='background-color:orange; color:white; display:none;'>Business<br>Objective</th>" .
									"<th style='background-color:orange; color:white;'>Group</th>" .
									"<th style='background-color:orange; color:white;'>Name</th>" .
									"<th class='tdStakeholder' style='background-color:orange; color:white; display:none;'>Position</th>" .
									"<th class='tdStakeholder' style='background-color:orange; color:white; display:none;'>Priority<br>Level</th>" .
									"<th class='tdStakeholder' style='background-color:orange; color:white; display:none;'>Current Level<br>of Support</th>" .
									"<th class='tdActivity' style='background-color:blue; color:white;'>Target Level<br>of Support</th>" .
									"<th style='background-color:blue; color:white;'>Engagement Avtivity</th>" .
									"<th class='tdActivity' style='background-color:blue; color:white;'>Core Messages</th>" .
									"<th class='tdActivity' style='background-color:blue; color:white;'>Frequency</th>" .
									"<th style='background-color:blue; color:white;'>Target Date</th>" .
									"<th class='tdActivity' style='background-color:blue; color:white;'>Budget</th>" .
									"<th style='background-color:red; color:white;'>Remarks</th>" .
									"<th style='background-color:red; color:white;'>Status</th>" .
								"</tr>" .
							"</thead>" .
							"<tbody>" .
								$stakerows .
							"</tbody>" .							
						"</table>";
	}
	elseif($gettype == "form2")
	{
		$resulttable =	"<form id='frmStakeholder' name='frmStakeholder' action='main-post.php' method='post'>" .
						"<table align='center' >" .
							"<tr>" .								
								"<td>" .
									"<fieldset>" .
									"<legend>Engagement Activities</legend>" .
										"<table>" .											
											"<tr>" .
												"<td>Stakeholder:</td>" .
												"<td><input id='txtStakeName' name='txtStakeName' type='text' style='width:250px' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Description of Activity:</td>" .
												"<td><textarea id='txtStakeDesc' name='txtStakeDesc' style='width:475px; height:70px;' ></textarea></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Status:</td>" .
												"<td>" .
													"<select id='selStakeStatus' name='selStakeStatus'>" .
														"<option value='Not Started'>Not Started</option>" .
														"<option value='In Progress'>In Progress</option>" .
														"<option value='Done'>Done</option>" .
													"</select>" .
												"</td>" .
											"</tr>" .
										"</table>" .
									"</fieldset>" .
								"</td>" .
							"</tr>" .
							"<tr>" .								
								"<td valign='bottom' align='center'>" .
									"<input type='submit' class='redbutton' id='btnStakeholderSave' name='btnStakeholderSave' value='Save' />" .									
									"<button class='redbutton' id='btnStakeholderClose' name='btnStakeholderClose' onclick='fnStakeholderClose();'>Close</button>" .
									
									"<input id='stakeBUID' name='stakeBUID' type='hidden' value='".$bu."'>" .
									"<input id='stakeyear' name='stakeyear' type='hidden' value='".$stakeyear."'>" .
								"</td>" .
							"</tr>" .							
						"</table>" .
						"</form>";
	}
	elseif($gettype == "form3")
	{
		$resulttable =	"<form id='frmStakeholder' name='frmStakeholder' action='main-post.php' method='post'>" .
						"<table align='center' >" .
							"<tr>" .								
								"<td>" .
									"<fieldset>" .
									"<legend>Summary of Engagement Activities</legend>" .
										"<table>" .
											"<tr>" .
												"<td>Year:</td>" .
			//									"<td><input id='txtStakeName' name='txtStakeName' type='text' style='width:250px' /></td>" .
												"<td>".$stakeyear."</td>" .
											"</tr>" .
											"<tr>" .
												"<td>Score:</td>" .
			//									"<td><input id='txtStakeName' name='txtStakeName' type='text' style='width:250px' /></td>" .
												"<td><input id='txtStakeScore' name='txtStakeScore' type='number' min='0' step='.01' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Summary / Description</td>" .
												"<td><textarea id='txtStakeScoreDesc' name='txtStakeScoreDesc' style='width:475px; height:70px;' ></textarea></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Source File:</td>" .
												"<td><input id='txtStakeLink' name='txtStakeLink' type='text' style='width:250px' /></td>" .											
											"</tr>" .
										"</table>" .
									"</fieldset>" .
								"</td>" .
							"</tr>" .
							"<tr>" .								
								"<td valign='bottom' align='center'>" .
									"<input type='submit' class='redbutton' id='btnStakeholderSave' name='btnStakeholderSave' value='Save' />" .									
									"<button class='redbutton' id='btnStakeholderClose' name='btnStakeholderClose' onclick='fnStakeholderClose();'>Close</button>" .
									
									"<input id='stakeBUID' name='stakeBUID' type='hidden' value='".$bu."'>" .
									"<input id='stakeyear' name='stakeyear' type='hidden' value='".$stakeyear."'>" .
								"</td>" .
							"</tr>" .							
						"</table>" .
						"</form>";
	}
	elseif($gettype == "search")
	{
		
	//	$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_engagement WHERE year = ".$stakeyear." AND bu_id = ".$bu);
		$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_mst WHERE year = ".$stakeyear." AND bu_id = ".$bu);
		while($stakemainres = mysqli_fetch_assoc($stakemainsql))
		{
			/* $idpfetchnamesql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$idpmainres['user_id']);
			$idpfetchnameres = mysqli_fetch_assoc($idpfetchnamesql); */
			
			
			$stakemainlist .=	"<tr>" .
									"<td valign='top' align='center'>" . $stakemainres['stakeholder_name'] ."</td>" .
									"<td valign='top' align='center'>" . $stakemainres['engagement_activity'] ."</td>" .
									"<td valign='top' align='center'>" . $stakemainres['status'] ."</td>" .
									"<td valign='top' align='center'>" .
										//	"<a style='color:blue; cursor:pointer;' onclick='openStakeModalEdit(".$stakemainres['id'].");'>Edit</a>" .
											"<img src='images/edit2.png' style='cursor:pointer; height:20px' onclick='openStakeModalEdit(".$stakemainres['id'].");'>" .
									"</td>" .
									"<td valign='top' align='center'>" .
											"<img src='images/delete.png' style='cursor:pointer; height:20px'  onclick=\"deleteItem(".$stakemainres['id'].", 'Stakeholder');\">" .
									"</td>" .
								"</tr>";
		}
			$resulttable =	"<tr>" .
									"<th class='whiteonblack'>Name</th>" .
									"<th class='whiteonblack' width='60%'>Description</th>" .
									"<th class='whiteonblack'>Status</th>" .
									"<th class='whiteonblack' colspan='2'>Controls</th>" .
								"</tr>" . $stakemainlist;
		
	}
	elseif($gettype == "search2")
	{
		
	//	$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_engagement WHERE year = ".$stakeyear." AND bu_id = ".$bu);
	//	$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_mst WHERE year = ".$stakeyear." AND bu_id = ".$bu);
		$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_mst_new WHERE year = ".$stakeyear." AND bu_id = ".$bu);
		while($stakemainres = mysqli_fetch_assoc($stakemainsql))
		{
			/* $idpfetchnamesql = mysqli_query($conn, "SELECT * FROM users_mst WHERE id = ".$idpmainres['user_id']);
			$idpfetchnameres = mysqli_fetch_assoc($idpfetchnamesql); */
			
			//$datedisplay = date_add($stakemainres['date_saved'], date_interval_create_from_date_string('8 hours'));
			$datedisplay = date('Y-m-d H:i',strtotime('+8 hours',strtotime($stakemainres['date_saved'])));
			$stakemainlist .=	"<tr>" .
									"<td valign='top' align='center'>" . $stakemainres['score'] ."</td>" .
									"<td valign='top' align='center'>" . $stakemainres['score_description'] ."</td>" .
									"<td valign='top' align='center'><a href='" . $stakemainres['score_link'] ."' target='_blank'>Link</a></td>" .
									"<td valign='top' align='center'>" . $datedisplay ."</td>" .
									"<td valign='top' align='center'>" .
										//	"<a style='color:blue; cursor:pointer;' onclick='openStakeModalEdit(".$stakemainres['id'].");'>Edit</a>" .
											"<img src='images/edit2.png' style='cursor:pointer; height:20px' onclick='openStakeModalEdit2(".$stakemainres['id'].");'>" .
									"</td>" .
									"<td valign='top' align='center'>" .
										//	"<img src='images/delete.png' style='cursor:pointer; height:20px'  onclick=\"deleteItem(".$stakemainres['id'].", 'Stakeholder');\">" .
											"<img src='images/delete.png' style='cursor:pointer; height:20px'  onclick=\"deleteItem(".$stakemainres['id'].", 'Stakeholder2');\">" .
									"</td>" .
								"</tr>";
		}
			$resulttable =	"<tr>" .
									"<th class='whiteonblack'>Score</th>" .
									"<th class='whiteonblack' width='60%'>Summary / Description</th>" .
									"<th class='whiteonblack'>Source File</th>" .
									"<th class='whiteonblack'>Last Modified On</th>" .
									"<th class='whiteonblack' colspan='2'>Controls</th>" .
								"</tr>" . $stakemainlist;
		
	}
	elseif($gettype == "edit")
	{
	//	$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_engagement WHERE id = ".$stakeid);
		$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_mst WHERE id = ".$stakeid);
		$stakemainres = mysqli_fetch_assoc($stakemainsql);
		
			
		$resulttable =	"<form id='frmStakeholder' name='frmStakeholder' action='main-post.php' method='post'>" .
						"<table align='center' >" .
							"<tr>" .								
								"<td>" .
									"<fieldset>" .
									"<legend>Engagement Activities</legend>" .
										"<table>" .											
											"<tr>" .
												"<td>Stakeholder:</td>" .
												"<td><input id='txtStakeName' name='txtStakeName' type='text' style='width:250px' value='".$stakemainres['stakeholder_name']."' /></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Description of Activity:</td>" .
												"<td><textarea id='txtStakeDesc' name='txtStakeDesc' style='width:475px; height:70px; resize:none;' >".$stakemainres['engagement_activity']."</textarea></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Status:</td>" .
												"<td>" .
													"<select id='selStakeStatus' name='selStakeStatus'>" .
														"<option value='".$stakemainres['status']."'>".$stakemainres['status']."</option>" .
														"<option value='Not Started'>Not Started</option>" .
														"<option value='In Progress'>In Progress</option>" .
														"<option value='Done'>Done</option>" .
													"</select>" .
												"</td>" .
											"</tr>" .
										"</table>" .
									"</fieldset>" .
								"</td>" .
							"</tr>" .
							"<tr>" .								
								"<td valign='bottom' align='center'>" .
									"<input type='submit' class='redbutton' id='btnStakeholderEdit' name='btnStakeholderEdit' value='Save' />" .									
									"<button class='redbutton' id='btnStakeholderClose' name='btnStakeholderClose' onclick='fnStakeholderClose();'>Close</button>" .									
									/* "<input id='stakeBUID' name='stakeBUID' type='hidden' value='".$bu."'>" .
									"<input id='stakeyear' name='stakeyear' type='hidden' value='".$stakeyear."'>" . */
									"<input id='stakeID' name='stakeID' type='hidden' value='".$stakeid."'>" .
								"</td>" .
							"</tr>" .							
						"</table>" .
						"</form>";
	}
	elseif($gettype == "edit2")
	{
	//	$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_engagement WHERE id = ".$stakeid);
		$stakemainsql = mysqli_query($conn,"SELECT * FROM stakeholder_mst_new WHERE id = ".$stakeid);
		$stakemainres = mysqli_fetch_assoc($stakemainsql);
		
			
		$resulttable =	"<form id='frmStakeholder' name='frmStakeholder' action='main-post.php' method='post'>" .
						"<table align='center' >" .
							"<tr>" .								
								"<td>" .
									"<fieldset>" .
									"<legend>Summary of Engagement Activities</legend>" .
										"<table>" .
											"<tr>" .
												"<td>Score:</td>" .
			//									"<td><input id='txtStakeName' name='txtStakeName' type='text' style='width:250px' /></td>" .
												"<td><input id='txtStakeScore' name='txtStakeScore' type='number' min='0' step='.01' value='".$stakemainres['score']."'/></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Summary / Description</td>" .
												"<td><textarea id='txtStakeScoreDesc' name='txtStakeScoreDesc' style='width:475px; height:70px;' >".$stakemainres['score_description']."</textarea></td>" .
											"</tr>" .
											"<tr>" .
												"<td>Link:</td>" .
												"<td><input id='txtStakeLink' name='txtStakeLink' type='text' style='width:250px' value='".mysqli_real_escape_string($conn, $stakemainres['score_link'])."' /></td>" .											
											"</tr>" .											
										"</table>" .
									"</fieldset>" .
								"</td>" .
							"</tr>" .
							"<tr>" .								
								"<td valign='bottom' align='center'>" .
									"<input type='submit' class='redbutton' id='btnStakeholderEdit' name='btnStakeholderEdit' value='Save' />" .									
									"<button class='redbutton' id='btnStakeholderClose' name='btnStakeholderClose' onclick='fnStakeholderClose();'>Close</button>" .									
									/* "<input id='stakeBUID' name='stakeBUID' type='hidden' value='".$bu."'>" .
									"<input id='stakeyear' name='stakeyear' type='hidden' value='".$stakeyear."'>" . */
									"<input id='stakeID' name='stakeID' type='hidden' value='".$stakeid."'>" .
								"</td>" .
							"</tr>" .							
						"</table>" .
						"</form>";
	}
	else
	{
		$resulttable = "Error Caught";
	}
	
	
	/* $finaltable =	"<form id='frmStakeholder' name='frmStakeholder' action='user-superadmin.php' method='post'>" .
						$resulttable .
					"</form>"; */
					
	echo $resulttable;

?>