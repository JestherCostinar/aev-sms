<?php
	session_start();
	if(!isset($_SESSION['id'])){
		header("location:login.php");
	}
	include("includes/dbconfig.php");
	include("includes/global.php");
	include("includes/function.php");
	
	$auditEditID = $_GET['audit_id'];
	$anothermarker = $_GET['marker'];
	$auditBUID = $_GET['bu_id'];
	
	$dataAuditType = "";
	$dataAuditText = "";
	$dataAuditDate = "";
	$dataAuditCategory = "";
	$dataAuditFindings = "";
	$dataAuditRecommendations = "";
	$dataAuditPotentialRisk = "";
	$dataAuditRiskPriority = "";
	$dataAuditRespnsible = "";
	$dataAuditCommitedDate = "";
	$dataAuditActualDate = "";
	$dataAuditStatus = "";
	$dataAuditDisposition = "";
	
	$addanotherlink = "";
	
	$displayExternal = "style='display:none;'";
	$displayExternal2 = "readonly";
	
	$displayAdmin = "";
	
	if($_SESSION['level'] == "Admin")
	{
		$displayAdmin = "readonly";
	}
	
	
	
	if($auditEditID != 0)
	{
		$auditsql = mysqli_query($conn, "SELECT * FROM audit_mst WHERE id = ". $auditEditID);
		$auditres = mysqli_fetch_assoc($auditsql);
				 
		$dataAuditType = $auditres['audit_type'];
		$dataAuditType2 = explode(" - ", $dataAuditType);
		$dataAuditDate = $auditres['audit_date'];
		$dataAuditCategory = $auditres['category'];
		$dataAuditFindings = $auditres['findings'];
		$dataAuditRecommendations = $auditres['recommendations'];
		$dataAuditPotentialRisk = $auditres['risk_impact'];
		$dataAuditRiskPriority = $auditres['risk_priority'];
		$dataAuditRespnsible = $auditres['responsible'];
		$dataAuditAccountable = $auditres['accountable'];
		$dataAuditCommitedDate = $auditres['commited_date'];
		$dataAuditActualDate = $auditres['actual_date'];
		$dataAuditStatus = $auditres['status'];
		$dataAuditDisposition = $auditres['disposition'];
		
		
		if($dataAuditType2[0] == 'External')
		{
			$displayExternal = "";
			$displayExternal2 = "required";
		}
	}
	else
	{
		$addanotherlink =	"<tr align='right'>" .
								"<td><a style='color:#00F; text-decoration:underline; cursor:pointer;' onclick='addAuditEntriesRow();'>Add Another</a></td>" .								
							"</tr>";
	}
	
	$auditRand = rand(0,1000);
	
	$auditTypeSelect = "";
	$auditCategorySelect = "";
	$auditRiskPriority = "";
	
	if($_SESSION['level'] == "Super Admin")
	{
		$auditTypeSelect = "<select id ='selAuditType".$auditRand."' name='selAuditType[]' onclick='displayAuditText(".$auditRand."); required '".$displayAdmin.">" .
								"<option value='".$dataAuditType2[0]."'>".$dataAuditType2[0]."</option>" .
								"<option value='External'>External</option>" .
								"<option value='Internal'>Internal</option>" .
							"</select>" .
							"<span id='divAuditType".$auditRand."' ".$displayExternal."> - <input type='text' id='txtAuditType".$auditRand."' name='txtAuditType[]' value='".$dataAuditType2[1]."' ".$displayExternal2." ".$displayAdmin."> (specify)</span>";
		$auditCategorySelect = "<select name='selAuditCategory[]' required ".$displayAdmin.">" .
									"<option value='".$dataAuditCategory."'>".$dataAuditCategory."</option>" .
									"<option value='Access Control'>Access Control</option>" .
									"<option value='Annual Training'>Annual Training</option>" .
									"<option value='Contract Compliance'>Contract Compliance</option>" .									
									"<option value='Core Training'>Core Training</option>" .
									"<option value='Emergency Response Planning'>Emergency Response Planning</option>" .
									"<option value='Incident Response'>Incident Response</option>" .
									"<option value='Investigation and Incident or Accident Reporting'>Investigation and Incident or Accident Reporting</option>" .
									"<option value='Organization'>Organization</option>" .									
									"<option value='Physical Security - Barriers and Fences'>Physical Security - Barriers and Fences</option>" .
									"<option value='Physical Security - CCTV'>Physical Security - CCTV</option>" .
									"<option value='Physical Security - Communications'>Physical Security - Communications</option>" .
									"<option value='Physical Security - Lighting Security'>Physical Security - Lighting Security</option>" .
									"<option value='Physical Security - Property Control'>Physical Security - Property Control</option>" .
									"<option value='Security Guard Force'>Security Guard Force</option>" .									
									"<option value='Security Policy'>Security Policy</option>" .
									"<option value='Security Risk Assessment'>Security Risk Assessment</option>" .
									"<option value='SGF Standard Equipment'>SGF Standard Equipment</option>" .
								"</select>";
		$auditRiskPriority = "<select name='selAuditRiskPriority[]' required ".$displayAdmin.">" .
									"<option value='".$dataAuditRiskPriority."'>".$dataAuditRiskPriority."</option>" .
									"<option value='Critical'>Critical</option>" .
									"<option value='High'>High</option>" .
									"<option value='Medium'>Medium</option>" .
									"<option value='Low'>Low</option>" .
								"</select>";
	}
	else
	{
		$auditTypeSelect = "<input type='text' name='selAuditType[]' value='".$dataAuditType."'>";
		$auditCategorySelect = "<input name='selAuditCategory[]' type='text' value='".$dataAuditCategory."' >";
		$auditRiskPriority = "<input type='text' name='selAuditRiskPriority[]' value='".$dataAuditRiskPriority."'>";
	}
	
	$auditcontent =	"<table border='1' width='85%' align='center' style='border-collapse:collapse;'>" .
						"<tr>" .
							"<th>Audit Type:</th>" .
							"<td>" .
								$auditTypeSelect .
							"</td>" .
						"</tr>" .
						"<tr>" .
							"<th>Audit Date:</th>" .
							"<td><input type='date' name='dateAuditDate[]' value='".$dataAuditDate."' required ".$displayAdmin."></td>" .
						"</tr>" .
						"<tr>" .
							"<th>Category:</th>" .
							"<td>" .
								$auditCategorySelect .
							"</td>" .
						"</tr>" .
						"<tr>" .
							"<th>Findings:</th>" .
							"<td><textarea name='txtAuditFindings[]' style='resize:none; height:100px; width:100%;' required ".$displayAdmin.">".$dataAuditFindings."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<th>Potential Risk / Impact:</th>" .
							"<td><textarea name='txtPotentialRiskImpact[]' style='resize:none; height:100px; width:100%;' required ".$displayAdmin.">".$dataAuditPotentialRisk."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<th>Recommendations:</th>" .
							"<td><textarea name='txtAuditRecommendations[]' style='resize:none; height:100px; width:100%;' required ".$displayAdmin.">".$dataAuditRecommendations."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<th>Disposition:</th>" .
							"<td><textarea name='txtAuditDisposition[]' style='resize:none; height:100px; width:100%;' >".$dataAuditDisposition."</textarea></td>" .
						"</tr>" .
						"<tr>" .
							"<th>Risk Priority:</th>" .
							"<td>" .
								$auditRiskPriority .
							"</td>" .
						"</tr>" .
						"<tr>" .
							"<th>Responsible:</th>" .
							"<td><input type='text' name='txtAuditResponsible[]' value='".$dataAuditRespnsible."' required ".$displayAdmin."> (email address)</td>" .
						"</tr>" .
						"<tr>" .
							"<th>Accountable:</th>" .
							"<td><input type='text' name='txtAuditAccountable[]' value='".$dataAuditAccountable."' ".$displayAdmin."> (email address)</td>" .
						"</tr>" .
						"<tr>" .
							"<th>Commited Date:</th>" .
							"<td><input type='date' name='dateAuditCommitedDate[]' value='".$dataAuditCommitedDate."' required ".$displayAdmin."></td>" .
						"</tr>" .
						"<tr>" .
							"<th>Actual Date:</th>" .
							"<td><input type='date' name='dateAuditActualDate[]' value='".$dataAuditActualDate."'></td>" .
						"</tr>" .
						"<tr>" .
							"<th>Status:</th>" .
							"<td>" .
								"<select name='selAuditStatus[]' required>" .
									"<option value='".$dataAuditStatus."'>".$dataAuditStatus."</option>" .
									"<option value='Not Started'>Not Started</option>" .
									"<option value='In Progress'>In Progress</option>" .
									"<option value='Done'>Done</option>" .									
								"</select>" .
							"</td>" .
						"</tr>" .						
					"</table>";
	
	$audittable =	"<form id='frmAudit' name='frmAudit' action='user-superadmin.php' method='post'>" .
						"<div id='divAuditPlaceholder' name='divAuditPlaceholder'>" .
							$auditcontent .
						"</div>" .
						"<table align='center' width='85%'>" .
							$addanotherlink .
							"<tr align='center'>" .
								"<td>" .
									"<input type='submit' name='btnSubmitAudit' class='redbutton' value='Save'>" .
									"<button class='redbutton' onclick='closeAuditForm();'>Cancel</button>" .
									"<input type='hidden' name='txtAuditBUID' value='".$auditBUID."'>" .
									"<input type='hidden' name='txtAuditID' value='".$auditEditID."'>" .
								"</td>" .
							"</tr>" .
						"</table>" .
					"</form>";
	
	
	if(!empty($anothermarker))
	{
		echo $auditcontent;
	}
	else
	{
		echo $audittable;
	}


?>