<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");
	include("class.upload.php-master/src/class.upload.php");
	
	$stakeid = $_GET['id'];
	$gettype = $_GET['gettype'];
	
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
		
		
		
		$resulttable =	"<table style='margin-left:auto; margin-right:auto; width:95%;'><tr><td><img src='images/add_item.png' height='30px' onclick=\"showStakeholder('form')\" style='cursor:pointer;' /></td><td align='right' style='color:red;'>*Click headers to expand</td></tr></table>" .
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
	else
	{
		$resulttable = "Error Caught";
	}
	
	
	/* $finaltable =	"<form id='frmStakeholder' name='frmStakeholder' action='user-superadmin.php' method='post'>" .
						$resulttable .
					"</form>"; */
					
	echo $resulttable;

?>