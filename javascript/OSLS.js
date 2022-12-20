// JavaScript Document
// OSLS JavaScript

$(document).on("keydown", function (e) {
    if (e.which === 8 && !$(e.target).is("input, textarea")) {
        e.preventDefault();
		
    }
});
$(document).on("keydown", function (e) {
    if (e.which === 13 && !$(e.target).is("textarea")) {
        e.preventDefault();
    }
});

// ----------------------- BIDDING ----------------------------
// JS function for Bidding
function addBiddingTemplate(id, clicktype)
{
	$( "#addBiddingDiv" ).dialog("open");
	$( "#divBiddingTemplateContent" ).load("biddingtemplate.php?id="+ id +"&click="+ clicktype);
}

// Return button for modal of Add bidding Template
function biddingback()
{
	event.preventDefault();
	$( "#addBiddingDiv" ).dialog( "close" );	
	document.getElementById("biddingTemplate").reset();
}

function showBiddingItem(id)
{
	// alert(id);
	$( "#BidReqItem" ).load("biddingtemplateitem.php?id=" + id);
	$( "#BidReqItem" ).show();
	$( "#BidReq" ).hide();

}

function addBiddingEntry() {
	var biddingcount = 1;
	if((document.getElementById("txtRequirementName").value) && (document.getElementById("txtCategory").value) && (document.getElementById("txtExpiry").value))
		{
			$( "#tblbiddingitem tbody" ).append("<tr align='center' valign='top'>" +
				"<td class='rowbiddingcount' style='display: none'>" + document.getElementById("counthide").value++ + "</td>" +
				"<td class='rowNumber'>#</td>" +
				"<td class='rowRequirementName'>" + document.getElementById("txtRequirementName").value + "</td>" +
			  	"<td class='rowCategory' style='display: none'>" + document.getElementById("txtCategory").value + "</td>" +
			  	"<td class='rowExpiry' style='display: none'>" + document.getElementById("txtExpiry").value + "</td>" +
				"<td class='rowPercentage' >" + document.getElementById("txtweightpercentage").value + "</td>" +
				"<td class='rowTotal' style='display: none'>" + document.getElementById("txttotal").value + "</td>" +
				"<td class='rowRating' style='display: none'>" + document.getElementById("txtrating").value + "</td>" +
				"<td class='rowRemarks' style='display: none'>" + document.getElementById("txtRemarks").value + "</td>" +
			  	"<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
			"</tr>" );
			document.getElementById("txtRequirementName").value = "";
			document.getElementById("txtCategory").value = "";
			document.getElementById("txtExpiry").value = "";
			document.getElementById("txtweightpercentage").value = "";
			document.getElementById("txttotal").value = "";
			document.getElementById("txtrating").value = "";
			document.getElementById("txtRemarks").value = "";
			$( "#tblbiddingitem" ).show();
			$( "#btnSaveBiddingItem" ).show();		
		}
}


function saveBiddingItem() {
	var biddingrowcount = document.getElementsByClassName("rowbiddingcount");	
	var biddingReqName = document.getElementsByClassName("rowRequirementName");	
	var biddingCat = document.getElementsByClassName("rowCategory");
	var biddingExp = document.getElementsByClassName("rowExpiry");
	var biddingPer = document.getElementsByClassName("rowPercentage");	
	var biddingTot = document.getElementsByClassName("rowTotal");
	var biddingRat = document.getElementsByClassName("rowRating");
	var biddingRem = document.getElementsByClassName("rowRemarks");

	var i;
	for (i = 0; i < biddingrowcount.length; i++)
	{
	document.getElementById("biddingName").value += "*~" + biddingReqName[i].innerHTML;
	document.getElementById("biddingCategory").value += "*~" + biddingCat[i].innerHTML;		
	document.getElementById("biddingexpiry").value += "*~" + biddingExp[i].innerHTML;
	document.getElementById("biddingPercentage").value += "*~" + biddingPer[i].innerHTML;
	document.getElementById("biddingTotal").value += "*~" + biddingTot[i].innerHTML;		
	document.getElementById("biddingRating").value += "*~" + biddingRat[i].innerHTML;
	document.getElementById("biddingRemarks").value += "*~" + biddingRem[i].innerHTML;

	}

	if((document.getElementById("biddingName").value) && (document.getElementById("biddingCategory").value) && (document.getElementById("biddingexpiry").value))
	{
		document.getElementById("formbiddingitem").submit();
	}
}


function editbiddingshow(biddingid) {
	$( "#editBiddingModalHolder" ).load("bidding_item_edit.php?id=" + biddingid);
	$( "#editBiddingModal" ).dialog("open");	
}

function editBiddingClose() {
	$( "#editBiddingModal" ).dialog("close");
}

// BIDDING DOCUMENTS
function addBiddingDocument(id, clicktype)
{
	$( "#addBiddingDocument" ).dialog("open");
	$( "#divBiddingDocument" ).load("bidding_document.php?id="+ id +"&click="+ clicktype);
}

// Return button for modal of Add bidding Template
function biddingdocumentback()
{
	event.preventDefault();
	$( "#addBiddingDocument" ).dialog( "close" );	
	document.getElementById("biddingDocument").reset();
}

// START BIDDING
function initializeBidding() {
	$("#initializeBiddingSection").dialog("open");
}

function closeInitializeBidding() {
	$("#initializeBiddingSection").dialog("close");
}

// Open Modal
function biddingSecAgencyModal(id)
{
	$("#tbodyNominatedAgency").load("getinfo.php?type=nominatedsecagency&id=" + id);
	$("#tbodyEvaluateNominatedAgency").load("getinfo.php?type=evaluatenominatedsecagency&id=" + id);
	$("#viewsecagencymodal").dialog("open");
}

function closeBiddingSecAgencyModal() {
	$("#viewsecagencymodal").dialog("close");
}

// Open Modal to Nominate Agency
function biddingAddSecAgencyModal(id)
{
	$("#tbodyPoolSecAgency").load("getinfo.php?type=nominatedpoolsecagency&id=" + id);
	$("#tbodyAddSecAgency").load("getinfo.php?type=nominatedpoolsecagency&id=" + id);
	$("#tbodypoolSecAgencyTable").load("getinfo.php?type=poolAgencyListTable&id=" + id);
	$("#addsecagencymodal").dialog("open");
}

function closeBiddingAddSecAgencyModal() {
	$("#addsecagencymodal").dialog("close");
}

function addNominatedAgencyRow()
{
	if((document.getElementById("txtaddnominatedagencyname").value) && (document.getElementById("txtaddnominatedagencyaddress").value) && (document.getElementById("txtaddnominatedagencyoic").value) && (document.getElementById("txtaddnominatedagencyemail").value) && (document.getElementById("txtaddnominatedagencyphone").value))
	{
		$( "#tblAddSecAgency tbody" ).append( "<tr align='center'>" +
		 "<td></td>" +
          "<td class='rowaddagencyname'>" + document.getElementById("txtaddnominatedagencyname").value + "</td>" +
		  "<td class='rowaddagencyaddress'>" + document.getElementById("txtaddnominatedagencyaddress").value + "</td>" +		  
         "<td class='rowaddagencyoic'>" + document.getElementById("txtaddnominatedagencyoic").value + "</td>" +
		  "<td class='rowaddagencyemail'>" + document.getElementById("txtaddnominatedagencyemail").value + "</td>" +
		  "<td class='rowaddagencyphone'>" + document.getElementById("txtaddnominatedagencyphone").value + "</td>" +
		  "<td class='rowaddbiddingid'  style='display:none;'>" + document.getElementById("txtbiddingid").value + "</td>" +		  
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
		document.getElementById("txtaddnominatedagencyname").value = "";
		document.getElementById("txtaddnominatedagencyaddress").value = "";
		document.getElementById("txtaddnominatedagencyoic").value = "";
		document.getElementById("txtaddnominatedagencyemail").value = "";
		document.getElementById("txtaddnominatedagencyphone").value = "";
		document.getElementById("txtaddnominatedagencyname").focus();
	}
	else
	{
		alert("Incomplete information");
	}
}

function saveNominatedAgencyRow()
{
	var x = document.getElementsByClassName('rowaddagencyname');
	var x2 = document.getElementsByClassName('rowaddagencyaddress');
	var x3 = document.getElementsByClassName('rowaddagencyoic');
	var x4 = document.getElementsByClassName('rowaddagencyemail');
	var x5 = document.getElementsByClassName('rowaddagencyphone');
	var x6 = document.getElementsByClassName('rowaddbiddingid');
	var i;
	for (i = 0; i < x.length; i++) {
		document.getElementById("txtaddnominatedagencynameall").value += "*~" + x[i].innerHTML;
		document.getElementById("txtaddnominatedagencyaddressall").value += "*~" + x2[i].innerHTML;
		document.getElementById("txtaddnominatedagencyoicall").value += "*~" + x3[i].innerHTML;
		document.getElementById("txtaddnominatedagencyemailall").value += "*~" + x4[i].innerHTML;
		document.getElementById("txtaddnominatedagencyphoneall").value += "*~" + x5[i].innerHTML;
		document.getElementById("txtbiddingidall").value += "*~" + x6[i].innerHTML;
	}
	if((document.getElementById("txtaddnominatedagencynameall").value) && (document.getElementById("txtaddnominatedagencyaddressall").value) && (document.getElementById("txtaddnominatedagencyoicall").value) && (document.getElementById("txtaddnominatedagencyemailall").value) && (document.getElementById("txtaddnominatedagencyphoneall").value))
	{
		document.getElementById("frmAddAgency").submit();
	}
	else
	{
		alert("No security agency to add.");
	}
}
// -------------------------- END OF BIDDING JS ----------------------------

function evaluateForm(btn){
	event.preventDefault();
	if(!(document.getElementById('txturc').value && document.getElementById('date').value && document.getElementById('time').value && document.getElementById('txtlocation').value && document.getElementById('txtguard').value && document.getElementById('remarks').value)){
		alert("A required field is empty");		
	}
//	else if(document.getElementById('urcdesc').innerHTML == 'URC not in database'){
//		alert("Incorrect URC");
//	}
//	else if ((document.getElementById("locations").innerHTML).search(document.getElementById("txtlocation").value) < 0){
//		alert("Location not in database.");
//	}
	//else if ((document.getElementById("guards").innerHTML).search(document.getElementById("txtguard").value) < 0){
//		alert("Guard not in database.");
//	}	
	else {
		btn.disabled = true;
		document.getElementById("txtactivityname").value = "";
		document.getElementById("txtincidentname").value = "";		
		document.getElementById("addForm").submit();	
	}
}

function evaluateForm2(){
	event.preventDefault();
	if(!(document.getElementById('txturc2').value && document.getElementById('date2').value && document.getElementById('time2').value && document.getElementById('txtlocation2').value && document.getElementById('txtguard2').value && document.getElementById('remarks2').value)){
		
		alert("A required field is empty");		
	}
	else if(document.getElementById('urcdesc2').innerHTML == 'URC not in database'){
		alert("Incorrect URC");
	}
	else if ((document.getElementById("locations2").innerHTML).search(document.getElementById("txtlocation2").value) < 0){
		alert("Location not in database.");
	}
	//else if ((document.getElementById("guards").innerHTML).search(document.getElementById("txtguard").value) < 0){
//		alert("Guard not in database.");
//	}	
	else {
		document.getElementById("txtactivityname").value = "";					
		document.getElementById("addIncidentForm").submit();		
	}
}

function evalAdd(tag, btn){
	if(tag == 'act'){
		if (document.getElementById("txtactivityname").value && document.getElementById("txtactivitydate").value){
			//document.getElementById("txturc").value = "";
			document.getElementById("txtincidentname").value = "";
			document.getElementById("addActivityForm").submit();
			btn.disabled = true;
		}
		else{
			event.preventDefault();
			alert("Please enter activity ticket name.");
			btn.disabled = false;
		}
	}
	else if(tag == 'inc'){
		if (document.getElementById("txtincidentname").value && document.getElementById("txtincidentdate").value){
			//document.getElementById("txturc").value = "";
			document.getElementById("txtactivityname").value = "";
			//document.getElementById("addIncidentForm").submit();
			iname2 = document.getElementById("txtincidentname").value;
			iname = $("#txtincidentname option:selected").text();
			idate = document.getElementById("txtincidentdate").value;
			GetInfo('Pending', idate, iname, iname2, 1, 'Pending', 1);
			$( "#AddActivity" ).dialog( "open");
			
		}
		else{
			alert("Please enter incident ticket name.");
		}
	}
	
}

function evalConCom()
{
	
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}



function toggleMe(section2, list2){
	var x = document.getElementsByClassName('section');
	var i;
	for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";
	}
	var x2 = document.getElementsByClassName('lists');
	var i2;
	for (i2 = 0; i2 < x2.length; i2++) {
		x2[i2].style.textDecoration = 'none';
		x2[i2].style.fontWeight = 'normal';
	}
	document.getElementById(list2).style.textDecoration = 'underline';
	document.getElementById(list2).style.fontWeight = 'bold';
	document.getElementById(section2).style.display = 'block';	
}

function toggleMe2(section2, list2, codetype, codedisplay){
	var x = document.getElementsByClassName('codediv');
	var i;
	for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";
	}
	var x2 = document.getElementsByClassName('codetab');
	var i2;
	for (i2 = 0; i2 < x2.length; i2++) {
		x2[i2].style.textDecoration = 'none';
		x2[i2].style.backgroundColor = 'initial';
		x2[i2].style.color = 'initial';
	}
	document.getElementById(list2).style.textDecoration = 'underline';
	document.getElementById(list2).style.backgroundColor = '#000000';
	document.getElementById(list2).style.color = '#FFF';
	document.getElementById(section2).style.display = 'block';
	if(codetype)
	{
		document.getElementById("txtcodetype").value = codetype;
	}
	
	if(codedisplay)
	{
		document.getElementById("txtcodetypedisplay").value = codedisplay;	
	}
}

function toggleMe3(section2, list2, usertype){
	var x = document.getElementsByClassName('accdiv');
	var i;
	for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";
	}
	var x2 = document.getElementsByClassName('acctab');
	var i2;
	for (i2 = 0; i2 < x2.length; i2++) {
		x2[i2].style.textDecoration = 'none';
		x2[i2].style.backgroundColor = 'initial';
		x2[i2].style.color = 'initial';
	}

	if(usertype == 'Admin') {
		document.getElementById("user_email_tr").style.display = "table-row";
	} else if(usertype == 'Super Admin') {
		document.getElementById("user_email_tr").style.display = "table-row";
	}else {
		document.getElementById("user_email_tr").style.display = "none";
	}
	
	document.getElementById(list2).style.textDecoration = 'underline';
	document.getElementById(list2).style.backgroundColor = '#000000';
	document.getElementById(list2).style.color = '#FFF';
	document.getElementById(section2).style.display = 'block';
	document.getElementById("txtAcctType").value = usertype;
//	document.getElementById("txtcodetypedisplay").value = codedisplay;	
}

function toggleMe4(section2, list2, usertype){
	var x = document.getElementsByClassName('accsecdiv');
	var i;
	for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";
	}
	var x2 = document.getElementsByClassName('accsectab');
	var i2;
	for (i2 = 0; i2 < x2.length; i2++) {
		x2[i2].style.textDecoration = 'none';
		x2[i2].style.backgroundColor = 'initial';
		x2[i2].style.color = 'initial';
	}
	
	document.getElementById(list2).style.textDecoration = 'underline';
	document.getElementById(list2).style.backgroundColor = '#000000';
	document.getElementById(list2).style.color = '#FFF';
	document.getElementById(section2).style.display = 'block';
//	document.getElementById("txtcodetypedisplay").value = codedisplay;	
}

function showIncClassification(tag, tag2)
{
	
}

function toggleAdd(tag, tag2){
	if(document.getElementById(tag).style.display == 'none'){
		document.getElementById(tag).style.display = 'block';
		document.getElementById(tag2).style.display = 'none';
	}
	else{
		document.getElementById(tag).style.display = 'none';
		document.getElementById(tag2).style.display = 'block';
	}
}

function toggleAdd2(tag, tag2){
	//document.getElementById("AddActivity").style.display = 'none';
	if(document.getElementById(tag).style.display == 'none'){
		document.getElementById(tag).style.display = 'block';
		document.getElementById(tag2).style.display = 'none';
	}
	else{
		document.getElementById(tag).style.display = 'none';
		document.getElementById(tag2).style.display = 'block';
	}
}

function toggleAdd3(tag, tag2){
	//document.getElementById("AddActivity").style.display = 'none';
	if(document.getElementById(tag).style.display == 'none'){
		document.getElementById(tag).style.display = 'block';
		document.getElementById(tag2).style.display = 'none';
	}
	else{
		document.getElementById(tag).style.display = 'none';
		document.getElementById(tag2).style.display = 'block';
	}
}

function toggleAdd4(tag, tag2, tag3){
	//document.getElementById("AddActivity").style.display = 'none';
	if(document.getElementById(tag).style.display == 'none'){
		document.getElementById(tag).style.display = 'block';
		document.getElementById(tag2).style.display = 'none';
		document.getElementById(tag3).style.display = 'none';
	}
	else{
		document.getElementById(tag).style.display = 'none';
		document.getElementById(tag2).style.display = 'block';
		document.getElementById(tag3).style.display = 'none';
	}
}

function toggleAdd5(tag, tag2)
{	
		document.getElementById(tag).style.display = 'block';
		document.getElementById(tag2).style.display = 'none';	
}

function toggleMenu(menuID)
{
	if(document.getElementById(menuID).style.display != "none")
	{
		$("#" + menuID).hide();
	}
	else if(document.getElementById(menuID).style.display == "none")
	{
		$("#" + menuID).show();
	}
}

function toggleTabs(tag, classtag)
{
	$("."+classtag).hide();
	$("#"+tag).show();
}

function showLogs(tag){
	if(document.getElementById(tag).style.display != 'none'){
		document.getElementById(tag).style.display = 'none';
		
	}
	else{
		document.getElementById(tag).style.display = 'initial';
		
	}
}

function showAttachments(tag)
{
	if(document.getElementById(tag).style.display == 'none')
	{
		$("#" + tag).show();
	}
	else
	{
		$("#" + tag).hide();
	}
}

function Closeticket(idNumber, type)
{
	var answer = confirm("Do you want to close this Ticket Entry " + idNumber + "?" )

	if (answer != 0 && type == 'Activities')
	{
		window.location.href = "closeticket.php?id=" + idNumber +"&type=" + type;
	}
	else if (answer != 0 && type == 'Incidents')
	{
		$( "#closeincidentmodal" ).load("close_incident.php?idnum=" + idNumber);
		$( "#closeincidentmodal" ).dialog("open");
		document.getElementById("swid").value = idNumber;
	}
}

function openUploadModal(id, type)
{
	document.getElementById("txtUploadTicketId").value = id;
	if(type == 1)
	{
		document.getElementById("uploadtobu").checked = "checked";
	}
	$( "#divUploadModal" ).dialog("open");
}

function closeUploadModal()
{
	$( "#divUploadModal" ).dialog( "close" );
	$( "#viewAuditUpload" ).dialog( "close" );
	document.getElementById("frmUpload").reset();
	openViewAttachments();
	document.getElementById("uploadChoiceUpload").checked = true;
}

function openViewAttachments()
{
	if(document.getElementById("divViewUpload").style.display == "none")
	{
		var ticket_id = document.getElementById("txtUploadTicketId").value;
		$("#divViewUpload").load("view-uploads.php?ticket_id=" + ticket_id);
		$("#divUploadFile").hide();
		$("#divViewUpload").show();
	}
	else
	{
		$("#divUploadFile").show();
		$("#divViewUpload").hide();
	}
		
	
}

function GetInfo(tid,tdate,tname,tname2,ttype,severity,orig)
{
  var dNow = new Date();
  var localdate = dNow.getFullYear() + '-' + (((dNow.getMonth()+1) < 10) ? ("0" + (dNow.getMonth()+1)) : (dNow.getMonth()+1)) + '-' + ((dNow.getDate() < 10) ? ("0" + dNow.getDate()) : dNow.getDate());
  //var localdate = (((dNow.getMonth()+1) < 10) ? ("0" + (dNow.getMonth()+1)) : (dNow.getMonth()+1)) + '/' + ((dNow.getDate() < 10) ? ("0" + dNow.getDate()) : dNow.getDate()) + '/' + dNow.getFullYear();
  var logtime = dNow.toTimeString().slice(0,8);
  //clearForm();
  document.getElementById("addForm").reset(); 
  document.getElementById("date").value = localdate;
  document.getElementById("time").value = logtime;
  document.getElementById("ticketID").innerHTML = tid;
  document.getElementById("ticketDate").innerHTML = tdate;
  document.getElementById("ticketDate2").value = tdate;
  document.getElementById("ticketName").innerHTML = tname;
  document.getElementById("ticketName2").value = tname2;
  document.getElementById("txtLogId").value = tid;
  document.getElementById("txtLogType").value = ttype;
  document.getElementById("txtOrigin").value = orig;
  if(document.getElementById("ticketSeverity"))
	  {
		document.getElementById("ticketSeverity").innerHTML = severity;  
	  }
  if(tid != 'Pending')
  {
  $("#txtguard").load("getinfo.php?type=dropdownGuard&id=" + tid);
  $("#txtlocation").load("getinfo.php?type=dropdownLocation&id=" + tid);
  }
  //document.getElementById("urcdesc").innerHTML = "URC Description";
  //document.getElementById("txtactivityname").value = "";
  //document.getElementById("txtincidentname").value = "";
  if(ttype == 1){
	  document.getElementById("back").onclick = function () {toggleAdd('AddActivity', 'Incidents')};
	  document.getElementById("logtitle").innerHTML = "Incident Name";
	  document.getElementById("sendtobu").checked = "checked";  
	  
	  $("#tblRiskFactors").show();
	  //document.getElementById("incidentdropdown").style.display = 'table-row';
  }
  else if(ttype == 2){
	  document.getElementById("back").onclick = function () {toggleAdd('AddActivity', 'Activities')};
	  document.getElementById("logtitle").innerHTML = "Activity Name";
	  $("#tblRiskFactors").hide();
	  //document.getElementById("incidentdropdown").style.display = 'none';
  }
  $( "#AddActivity" ).dialog( "open");
}

function openDeletion(id, type)
{
	document.getElementById("txtDeletionType").value = type;
	document.getElementById("txtDeletionId").value = id;
	$( "#RequestDeletionModal" ).dialog("open");
}

function openApproveDeletion(id, type, main_id, bu, requester, dtype)
{
	if(type == 'approve')
	{
		document.getElementById("lblDeletionApproval").innerHTML = "APPROVE DELETION";
				
	}
	else if(type == 'reject')
	{
		document.getElementById("lblDeletionApproval").innerHTML = "REJECT DELETION";				
	}
	document.getElementById("txtDeletionId").value = id;
	document.getElementById("txtDeletionBuId").value = bu;
	document.getElementById("txtDeletionMainId").value = main_id;
	document.getElementById("txtDeletionState").value = type;
	document.getElementById("txtDeletionRequester").value = requester;
	$( "#ApproveDeletionModal" ).dialog("open");
}


function openRetract(id, severity)
{
	document.getElementById("numRetractLevel").value = severity;
	document.getElementById("txtRetractId").value = id;
	$( "#RequestRetractModal" ).dialog("open");
}

function openApproveRetract(id, type, main_id, bu, requester, level)
{
	if(type == 'approve')
	{
		document.getElementById("lblRetractApproval").innerHTML = "APPROVE RETRACTION";
		document.getElementById("numApproveRetract").disabled = false;		
		document.getElementById("numApproveRetract").value = level;		
	}
	else if(type == 'reject')
	{
		document.getElementById("lblRetractApproval").innerHTML = "REJECT RETRACTION";
		document.getElementById("numApproveRetract").disabled = true;		
	}
	document.getElementById("txtRetractId").value = id;
	document.getElementById("txtRetractBuId").value = bu;
	document.getElementById("txtRetractMainId").value = main_id;
	document.getElementById("txtRetractState").value = type;
	document.getElementById("txtRetractRequester").value = requester;
	$( "#ApproveRetractModal" ).dialog("open");
}

function submitApproval()
{
	document.getElementById("frmApproveRetract").submit();
}

function clearForm(tag){
	//document.getElementById("addForm").reset();	
	if(tag == 'inc'){
	  if(document.getElementById("txtactivityname").value){
		  document.getElementById("txtactivityname").value = "";
	  }
	}
	else if(tag == 'act'){
	  if(document.getElementById("txtincidentname").value){
		  document.getElementById("txtincidentname").value = "";
	  }
	}
	
}

function swap(tag){
	if(tag == 'cticketa'){
		if(document.getElementById("cticketa").innerHTML == "<b>Create Ticket (Activity)</b>"){
		  document.getElementById("cticketa").innerHTML = "<b><- Back</b>";
		}
		else{
		  document.getElementById("cticketa").innerHTML = "<b>Create Ticket (Activity)</b>";		
		}
	}
	
	else if(tag == 'cticketi'){
		if(document.getElementById("cticketi").innerHTML == "<b>Create Ticket (Incident)</b>"){		
		  document.getElementById("cticketi").innerHTML = "<b><- Back</b>";
		}
		else{
		  document.getElementById("cticketi").innerHTML = "<b>Create Ticket (Incident)</b>";
		}
	}
	else if(tag == 'cConCom'){
		if(document.getElementById("cConCom").innerHTML == "<b>Create New Contract Compliance Form</b>"){		
		  document.getElementById("cConCom").innerHTML = "<b><- Back</b>";
		}
		else{
		  document.getElementById("cConCom").innerHTML = "<b>Create New Contract Compliance Form</b>";
		}
	}
	else if(tag == 'cConCom2')
	{
		if(document.getElementById("cConCom").innerHTML == "<b>Contract Compliance</b>"){		
		  document.getElementById("cConCom").innerHTML = "<b><- Back</b>";
		}
		else{
		  document.getElementById("cConCom").innerHTML = "<b>Contract Compliance</b>";
		}
	}
	else if(tag == 'cConCom3')
	{
		if(document.getElementById("cConCom").innerHTML == "<b>&lt;- Back</b>"){		
		  document.getElementById("cConCom").innerHTML = "<b>Contract Compliance</b>";
		}		
	}
	
	//clearForm();
	
}

function chkcpass(){
	if(document.getElementById('currentpass').value && document.getElementById('newpass').value && document.getElementById('newpass2').value)
	{
		hash = hex_md5(document.getElementById('currentpass').value);
		if(hash != document.getElementById('userpassword').value){
			alert("Incorrect current password.");
		}
		else if(document.getElementById('newpass').value != document.getElementById('newpass2').value){
			alert("Passwords do not match.");
		}
		else{
			//clearForm();
			document.getElementById("formcpass").submit();
		}
	}
	else
	{
		alert("A required field is empty.");
	}
}

function chkwitness(){
	if(document.getElementById("witlname").value && document.getElementById("witfname").value){
		toggleAdd('Suspectdiv', 'Witnessdiv');
	}
	else{
		alert("Please enter at least a last & first name.");
	}
}

function chksuspect(){
	if(document.getElementById("syes").checked == true){
		if(document.getElementById("susplname").value && document.getElementById("suspfname").value){
			document.getElementById("txtactivityname").value = "";
			document.getElementById("txtincidentname").value = "";
			document.getElementById("witnessForm").submit();
			
		}
		else{
			alert("Please enter at least a last & first name.");
		}
	}
	else{
		document.getElementById("txtactivityname").value = "";
		document.getElementById("txtincidentname").value = "";
		document.getElementById("witnessForm").submit();
	}
}

function chkContact(){
	if(document.getElementById("usercontactnew").value){
		document.getElementById("txtactivityname").value = "";
		document.getElementById("txtincidentname").value = "";
		document.getElementById("changecontactForm").submit();
	}
	else{
		alert("Please enter a new contact number");
	}
}

function guardInfo(gfirst_name, gmiddle_name, glast_name, ggender, gbirthdate, gbloodtype, gcivil_status, gpresent_address, gprovincial_address, gcontact, gbu, gdate_posted, gagency_employment, gcode, gagency, gcategory, gbadge_number, gntclicense, gntclicense_start, gntclicense_end, glicense_number, glicense_issue_date, glicense_expiry_date, gperformance, gcomment, origin, gid, gstat, gpic){
	document.getElementById("txtguardid").value = gid;
	document.getElementById("txtglname").value = glast_name;
	document.getElementById("txtgfname").value = gfirst_name;
	document.getElementById("txtgmname").value = gmiddle_name;
	document.getElementById("selggender").value = ggender;
	document.getElementById("txtgbdate").value = gbirthdate;
	document.getElementById("selgbloodtype").value = gbloodtype;
	document.getElementById("selgcivstat").value = gcivil_status;
	document.getElementById("txtgpreadd").value = gpresent_address;
	document.getElementById("txtgproadd").value = gprovincial_address;
	document.getElementById("txtgcontact").value = gcontact;
	document.getElementById("txtgbu").value = gbu;
	document.getElementById("trguardstat").style.display = "table-row";
	document.getElementById("selgstat").disabled = false;
	document.getElementById("selgstat").value = gstat;
	document.getElementById("txtgposted").value = gdate_posted;
	document.getElementById("txtgempagency").value = gagency_employment;
	document.getElementById("txtgcode").value = gcode;
	// document.getElementById("selgagency").value = gagency;
	document.getElementById("txtgcategory").value = gcategory;
	document.getElementById("txtgbadge").value = gbadge_number;
	
	if(document.getElementById("txtgntclicense"))
	{
		document.getElementById("txtgntclicense").value = gntclicense;
		document.getElementById("txtgntclicenseissue").value = gntclicense_start;
		document.getElementById("txtgntclicenseexpiry").value = gntclicense_end;
	}
	document.getElementById("txtglicense").value = glicense_number;
	document.getElementById("txtglicenseissue").value = glicense_issue_date;
	document.getElementById("txtglicenseexpiry").value = glicense_expiry_date;
	document.getElementById("selgperformance").value = gperformance;
	document.getElementById("gcomment").value = gcomment.replace(/<br><br>/gi, "\n");
	if(document.getElementById("guardpicbox"))
	{
		document.getElementById("guardpicbox").src = gpic;
	}
	
	expiration();
	if(origin=='edit')
	{
		$(".addguards").prop("readonly", false);
		$("select.addguards").prop("disabled", false);
		document.getElementById("btneditguard").style.display = "initial";
		document.getElementById("btnsaveguard").style.display = "none";
		if(document.getElementById("tblupload"))
		{
			document.getElementById("tblupload").style.display = "initial";
		}
		$(".guardphototd").show();
	}
	else if(origin=='view')
	{
		$(".addguards").prop("readonly", true);
		$("select.addguards").prop("disabled", true);
		document.getElementById("btneditguard").style.display = "none";
		document.getElementById("btnsaveguard").style.display = "none";
		if(document.getElementById("tblupload"))
		{
			document.getElementById("tblupload").style.display = "none";
		}
		
		$(".guardphototd").show();
	}
	$( "#addGuard" ).dialog("open");
}

function guardInfo2(guardid, clicktype)
{
	$( "#addGuard" ).dialog("open");
	$( "#divAddGuardContent" ).load("guardinfo.php?guardid="+ guardid +"&click="+ clicktype);
	/* expiration();
	expiration2(); */
	if(document.getElementById("txtgbdate"))
	{
		getGuardAge(); 
	}
	
}

function expiration()
{
	if((document.getElementById("txtglicenseissue").value) && (document.getElementById("txtglicenseexpiry").value)){
		var gnow2 = new Date();
		var gexpiry = new Date($("#txtglicenseexpiry").val());
		var validity = gexpiry.getFullYear() - gnow2.getFullYear();
		var validity2 = 0;
		if((gnow2.getMonth() > gexpiry.getMonth()) || (gnow2.getMonth() == gexpiry.getMonth() && gnow2.getDate() > gexpiry.getDate()))
		{
			validity--;
			validity2 = (gexpiry.getMonth() + 13) - (gnow2.getMonth() + 1);
			
		}
		else if(gnow2.getMonth() < gexpiry.getMonth())
		{
			validity2 = (gexpiry.getMonth() + 1) - (gnow2.getMonth() + 1);
		}
		if(validity2 == 12)
		{
			validity++;
			validity2 = 0;
		}
		if(validity < 0)
		{
			document.getElementById("txtgremaining").value = "Expired";
		}
		else if(validity == 0)
		{
			document.getElementById("txtgremaining").value = validity2 + " mos";
		}
		else if(validity > 0)
		{
			document.getElementById("txtgremaining").value = validity + " yrs " + validity2 + " mos";
		}
		
	}
}

function expiration2()
{
	if((document.getElementById("txtgntclicenseissue").value) && (document.getElementById("txtgntclicenseexpiry").value)){
	var gnow2 = new Date();
	var gexpiry = new Date($("#txtgntclicenseexpiry").val());
	var validity = gexpiry.getFullYear() - gnow2.getFullYear();
	var validity2 = 0;
	if((gnow2.getMonth() > gexpiry.getMonth()) || (gnow2.getMonth() == gexpiry.getMonth() && gnow2.getDate() > gexpiry.getDate()))
	{
		validity--;
		validity2 = (gexpiry.getMonth() + 13) - (gnow2.getMonth() + 1);
		
	}
	else if(gnow2.getMonth() < gexpiry.getMonth())
	{
		validity2 = (gexpiry.getMonth() + 1) - (gnow2.getMonth() + 1);
	}
	if(validity2 == 12)
	{
		validity++;
		validity2 = 0;
	}
	if(validity < 0)
	{
		document.getElementById("txtntcgremaining").value = "Expired";
	}
	else if(validity == 0)
	{
		document.getElementById("txtntcgremaining").value = validity2 + " mos";
	}
	else if(validity > 0)
	{
		document.getElementById("txtntcgremaining").value = validity + " yrs " + validity2 + " mos";
	}
	
	}
}

function guardBack()
{
	event.preventDefault();
	$( "#addGuard" ).dialog( "close" );	
	document.getElementById("addguardform").reset();
}

function guardInfoCheck()
{
	event.preventDefault();
	/* if(!(document.getElementById("txtgfname").value) || !(document.getElementById("txtgmname").value) || !(document.getElementById("txtglname").value) || !(document.getElementById("selggender").value) || !(document.getElementById("txtgbdate").value) || !(document.getElementById("selgbloodtype").value) || !(document.getElementById("selgcivstat").value) || !(document.getElementById("txtgpreadd").value) || !(document.getElementById("txtgproadd").value) || !(document.getElementById("txtgcontact").value) || !(document.getElementById("txtgbu").value))
	{
		toggleTabs('guardpersonaltab', 'guardmaintabs');
		alert("Please fill up all Personal Information fields.");
	} */
	if(!(document.getElementById("txtgfname").value) || !(document.getElementById("txtglname").value) || !(document.getElementById("txtgbu").value) || !(document.getElementById("txtgposted").value))
	{
		alert("Please fill up all Personal Information fields.");
		toggleTabs('guardpersonaltab', 'guardmaintabs');
		
	}
	/* else if(!(document.getElementById("txtgcode").value) || !(document.getElementById("txtgcategory").value) || !(document.getElementById("txtgbadge").value) || !(document.getElementById("txtglicense").value) || !(document.getElementById("txtglicenseissue").value) || !(document.getElementById("txtglicenseexpiry").value) || !(document.getElementById("txtgntclicense").value) || !(document.getElementById("txtgntclicenseissue").value) || !(document.getElementById("txtgntclicenseexpiry").value) || !(document.getElementById("selgperformance").value))
	{
		toggleTabs('guardsecuritytab', 'guardmaintabs');
		alert("Please fill up all Security Information fields.");
	} */
	else if(!(document.getElementById("txtgcode").value) || !(document.getElementById("txtgcategory").value) || !(document.getElementById("txtglicense").value) || !(document.getElementById("txtglicenseissue").value) || !(document.getElementById("txtglicenseexpiry").value) || !(document.getElementById("txtgntclicense").value) || !(document.getElementById("txtgntclicenseissue").value) || !(document.getElementById("txtgntclicenseexpiry").value) || !(document.getElementById("selgperformance").value))
	{
		alert("Please fill up all Security Information fields.");
		toggleTabs('guardsecuritytab', 'guardmaintabs');
		
	}
	/* else if(!(document.getElementById("txtgposted").value) || !(document.getElementById("txtgposted").value))
	{
		toggleTabs('guardemploymenttab', 'guardmaintabs');
		alert("Please fill up all Employment History fields.");
	} */
	else
	{
		document.getElementById("addguardform").submit();
	}
	
}

function getGuardAge()
{
	var gbirthdate = new Date($("#txtgbdate").val());
	var gnow = new Date();		
	var guardage = gnow.getFullYear() - gbirthdate.getFullYear();
	if((gnow.getMonth() < gbirthdate.getMonth()) || (gnow.getMonth() == gbirthdate.getMonth() && gnow.getDate() < gbirthdate.getDate()))
	{
		guardage--;
	}
	document.getElementById("txtgage").value = "";
	if(document.getElementById("txtgbdate").value)
	{
		document.getElementById("txtgage").value = guardage;
	}
}

function addLocationRow(){
	if((document.getElementById("txtaddlocation").value) && (document.getElementById("txtaddlocationcode").value)){
		document.getElementById("locdiv").style.display = "initial";
		$( "#addlocationtable tbody" ).append( "<tr align='center'>" +
          "<td class='rowlocationcode'>" + document.getElementById("txtaddlocationcode").value + "</td>" +
          "<td class='rowlocation'>" + document.getElementById("txtaddlocation").value + "</td>" +
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
		document.getElementById("txtaddlocationcode").value = "";
		document.getElementById("txtaddlocation").value = "";
		document.getElementById("txtaddlocationcode").focus();
	}
	else
	{
		alert("Enter complete location details");
	}
}

function changeClassificationOpen(id)
{
	$( "#changeClassificationModal" ).dialog("open");
	document.getElementById("txtChangeClassificationId").value = id;
}

function changeClassificationClose()
{
	$( "#changeClassificationModal" ).dialog("close");
	document.getElementById("txtChangeClassificationId").value = "";
}

function showSpam(buspam)
{
	$("#SPAM").load("spam.php?buspam="+ buspam);
}

function showSpam2(buspam)
{
	$("#SPAM").load("spam.php?buspam="+ buspam + "&back=1");
}

function showSpam3(buspam)
{
	$("#SPAM").load("spam.php?buspam="+ buspam + "&spamdate="+ encodeURI(document.getElementById("selbuspamdate").value));
}

function showSpamCon()
{
	$("#SPAM").load("spam-consolidation.php");
}

function showStakeholder(type)
{
	if(type == "table")
	{
		$("#Stakeholder").load("stakeholder-engagement.php?gettype=" + type);
	}
	else if(type == "form")
	{
		//alert("Errrrrooooooorrrr.");
		$("#modalStakeholder").load("stakeholder-engagement.php?gettype=" + type);
		$("#modalStakeholder").dialog("open");
	}
	else if(type == "form2")
	{
		//alert("Errrrrooooooorrrr.");
		stakeyear = document.getElementById("numStakeYear").value;
		$("#modalStakeholder").load("stakeholder-engagement.php?gettype=" + type +"&stakeyear="+ stakeyear);
		$("#modalStakeholder").dialog("open");
	}
	else if(type == "form3")
	{
		//alert("Errrrrooooooorrrr.");
		stakeyear = document.getElementById("numStakeYear").value;
		$("#modalStakeholder").load("stakeholder-engagement.php?gettype=" + type +"&stakeyear="+ stakeyear);
		$("#modalStakeholder").dialog("open");
	}
	else if(type == "search")
	{
		stakeyear = document.getElementById("numStakeYear").value;
		$("#staketablebody").load("stakeholder-engagement.php?gettype=" + type +"&stakeyear="+ stakeyear);
	}
	else if(type == "search2")
	{
		stakeyear = document.getElementById("numStakeYear").value;
		$("#staketablebody").load("stakeholder-engagement.php?gettype=" + type +"&stakeyear="+ stakeyear);
	}
	else if(type == "edit")
	{
		//alert("Errrrrooooooorrrr.");
		stakeyear = document.getElementById("numStakeYear").value;
		
		$("#modalStakeholder").load("stakeholder-engagement.php?gettype=" + type +"&stakeyear="+ stakeyear);
		$("#modalStakeholder").dialog("open");
	}
	else
	{
		alert("Errrrrooooooorrrr.");
	}
	
}

function openStakeModalEdit(id)
{
	stakeyear = document.getElementById("numStakeYear").value;
	stakeid = id;
	type = "edit";
	$("#modalStakeholder").load("stakeholder-engagement.php?gettype=" + type +"&stakeyear="+ stakeyear +"&stakeid="+ stakeid);
	$("#modalStakeholder").dialog("open");
}

function openStakeModalEdit2(id)
{
	stakeyear = document.getElementById("numStakeYear").value;
	stakeid = id;
	type = "edit2";
	$("#modalStakeholder").load("stakeholder-engagement.php?gettype=" + type +"&stakeyear="+ stakeyear +"&stakeid="+ stakeid);
	$("#modalStakeholder").dialog("open");
}

function autoCalculateSpam(part)
{
	if(part == "Guards")
	{
		document.getElementById("numSpamGuardTotal").value = parseInt(document.getElementById("numSpamGuardDC").value) + parseInt(document.getElementById("numSpamGuardSIC").value) + parseInt(document.getElementById("numSpamGuardSG").value) + parseInt(document.getElementById("numSpamGuardLG").value);
	}
	else if(part == "Communications")
	{
		document.getElementById("numSpamCommTotal").value = parseInt(document.getElementById("numSpamCommBaseRadio").value) + parseInt(document.getElementById("numSpamCommHandRadio").value) + parseInt(document.getElementById("numSpamCommMobile").value) + parseInt(document.getElementById("numSpamCommSat").value) + parseInt(document.getElementById("numSpamCommRepeater").value) + parseInt(document.getElementById("numSpamCommOthers").value);
	}
	else if(part == "Surveillance")
	{
		document.getElementById("numSpamSurvTotal").value = parseInt(document.getElementById("numSpamSurvCCTV").value) + parseInt(document.getElementById("numSpamSurvCCTVMotion").value) + parseInt(document.getElementById("numSpamSurvAccess").value) + parseInt(document.getElementById("numSpamSurvIntrusion").value) + parseInt(document.getElementById("numSpamSurvWatch").value) + parseInt(document.getElementById("numSpamSurvOthers").value);
	}
	else if(part == "Firearms")
	{
		document.getElementById("numSpamFATotal").value = parseInt(document.getElementById("numSpamFA9mm").value) + parseInt(document.getElementById("numSpamFASS").value) + parseInt(document.getElementById("numSpamFAm16").value) + parseInt(document.getElementById("numSpamFAm4").value) + parseInt(document.getElementById("numSpamFAOthers").value);
	}
	else if(part == "Vehicles")
	{
		document.getElementById("numSpamVehicleTotal").value = parseInt(document.getElementById("numSpamVehicleBicycle").value) + parseInt(document.getElementById("numSpamVehicle2W").value) + parseInt(document.getElementById("numSpamVehicleATV").value) + parseInt(document.getElementById("numSpamVehicle4WPickup").value) + parseInt(document.getElementById("numSpamVehicleWatercraft").value) + parseInt(document.getElementById("numSpamVehicleAmbulance").value) + parseInt(document.getElementById("numSpamVehicleFiretruck").value) + parseInt(document.getElementById("numSpamVehicleOthers").value);
	}
	else if(part == "Office")
	{
		document.getElementById("numSpamOfficeTotal").value = parseInt(document.getElementById("numSpamOfficeDesktop").value) + parseInt(document.getElementById("numSpamOfficePrinter").value) + parseInt(document.getElementById("numSpamOfficeInternet").value) + parseInt(document.getElementById("numSpamOfficeOthers").value);
	}
	else if(part == "Others")
	{
		// document.getElementById("numSpamOthersTotal").value = parseInt(document.getElementById("numSpamOthersMetalDetector").value) + parseInt(document.getElementById("numSpamOthersMirror").value) + parseInt(document.getElementById("numSpamOthersK9").value) + parseInt(document.getElementById("numSpamOthersOthers").value);
		var ccothers = document.getElementsByClassName("spamothers");
		var i;
		var sub = 0;
		for (i = 0; i < ccothers.length; i++)
		{
			//document.getElementById("numSpamOthersTotal").value = parseInt(document.getElementById("numSpamOthersTotal").value) + parseInt(ccothers[i].value);
			sub += parseInt(ccothers[i].value);
		}
		document.getElementById("numSpamOthersTotal").value = sub;
	}
	else if(part == "Rates")
	{
		document.getElementById("numSpamRateMonthly").value = parseInt(document.getElementById("numSpamRateDailyWage").value) * 30;
		document.getElementById("numSpamRateAnnual").value = parseInt(document.getElementById("numSpamRateMonthly").value) * 12;
	}
	else if(part == "Rates2")
	{
		//transfer no. of guards to rates
		document.getElementById("txt_rates_no_of_guards_12a").value = document.getElementById("numSpamShift1st").value;
		document.getElementById("txt_rates_no_of_guards_12b").value = document.getElementById("numSpamShift2nd").value;
		
		//compute monthly salary = days per year * daily wage / 12
		document.getElementById("txt_rates_monthly_salary_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_daily_wage_12a").value) * parseFloat(document.getElementById("txt_rates_days_per_year_12a").value) / 12) * 100) / 100;
		document.getElementById("txt_rates_monthly_salary_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_daily_wage_12b").value) * parseFloat(document.getElementById("txt_rates_days_per_year_12b").value) / 12) * 100) / 100;
		document.getElementById("txt_rates_monthly_salary_9").value = Math.round((parseFloat(document.getElementById("txt_rates_daily_wage_9").value) * parseFloat(document.getElementById("txt_rates_days_per_year_9").value) / 12) * 100) / 100;
		document.getElementById("txt_rates_monthly_salary_10").value = Math.round((parseFloat(document.getElementById("txt_rates_daily_wage_10").value) * parseFloat(document.getElementById("txt_rates_days_per_year_10").value) / 12) * 100) / 100;
		
		//compute night differential = monthly salary * 0.1
		/* document.getElementById("txt_rates_night_diff_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_monthly_salary_12a").value) * 0.1) * 100) / 100;
		document.getElementById("txt_rates_night_diff_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_monthly_salary_12b").value) * 0.1) * 100) / 100;
		document.getElementById("txt_rates_night_diff_9").value = Math.round((parseFloat(document.getElementById("txt_rates_monthly_salary_9").value) * 0.1) * 100) / 100;
		document.getElementById("txt_rates_night_diff_10").value = Math.round((parseFloat(document.getElementById("txt_rates_monthly_salary_10").value) * 0.1) * 100) / 100; */
		
		//compute 5 days incentive leave = (daily wage + COLA) * 5 / 12
		/* document.getElementById("txt_rates_incentive_leave_12a").value = Math.round(((parseFloat(document.getElementById("txt_rates_daily_wage_12a").value) + parseFloat(document.getElementById("txt_rates_cola_12a").value)) * 5 / 12) * 100) / 100;
		document.getElementById("txt_rates_incentive_leave_12b").value = Math.round(((parseFloat(document.getElementById("txt_rates_daily_wage_12b").value) + parseFloat(document.getElementById("txt_rates_cola_12b").value)) * 5 / 12) * 100) / 100;
		document.getElementById("txt_rates_incentive_leave_9").value = Math.round(((parseFloat(document.getElementById("txt_rates_daily_wage_9").value) + parseFloat(document.getElementById("txt_rates_cola_9").value)) * 5 / 12) * 100) / 100;
		document.getElementById("txt_rates_incentive_leave_10").value = Math.round(((parseFloat(document.getElementById("txt_rates_daily_wage_10").value) + parseFloat(document.getElementById("txt_rates_cola_10").value)) * 5 / 12) * 100) / 100; */
		
		//compute 13th month pay = daily wage * 365 / 12 / 12
		document.getElementById("txt_rates_13th_mon_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_daily_wage_12a").value) * 365 / 12 / 12) * 100) / 100;
		document.getElementById("txt_rates_13th_mon_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_daily_wage_12b").value) * 365 / 12 / 12) * 100) / 100;
		document.getElementById("txt_rates_13th_mon_9").value = Math.round((parseFloat(document.getElementById("txt_rates_daily_wage_9").value) * 365 / 12 / 12) * 100) / 100;
		document.getElementById("txt_rates_13th_mon_10").value = Math.round((parseFloat(document.getElementById("txt_rates_daily_wage_10").value) * 365 / 12 / 12) * 100) / 100;
		
		//compute amount due to guard
		document.getElementById("txt_rates_amt_due_guard_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_monthly_salary_12a").value) + parseFloat(document.getElementById("txt_rates_night_diff_12a").value) + parseFloat(document.getElementById("txt_rates_incentive_leave_12a").value) + parseFloat(document.getElementById("txt_rates_13th_mon_12a").value) + parseFloat(document.getElementById("txt_rates_uniform_allowance_12a").value) + parseFloat(document.getElementById("txt_rates_cola_m_12a").value) + parseFloat(document.getElementById("txt_rates_overtime_12a").value)) * 100) / 100;
		document.getElementById("txt_rates_amt_due_guard_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_monthly_salary_12b").value) + parseFloat(document.getElementById("txt_rates_night_diff_12b").value) + parseFloat(document.getElementById("txt_rates_incentive_leave_12b").value) + parseFloat(document.getElementById("txt_rates_13th_mon_12b").value) + parseFloat(document.getElementById("txt_rates_uniform_allowance_12b").value) + parseFloat(document.getElementById("txt_rates_cola_m_12b").value) + parseFloat(document.getElementById("txt_rates_overtime_12b").value)) * 100) / 100;
		document.getElementById("txt_rates_amt_due_guard_9").value = Math.round((parseFloat(document.getElementById("txt_rates_monthly_salary_9").value) + parseFloat(document.getElementById("txt_rates_night_diff_9").value) + parseFloat(document.getElementById("txt_rates_incentive_leave_9").value) + parseFloat(document.getElementById("txt_rates_13th_mon_9").value) + parseFloat(document.getElementById("txt_rates_uniform_allowance_9").value) + parseFloat(document.getElementById("txt_rates_cola_m_9").value) + parseFloat(document.getElementById("txt_rates_overtime_9").value)) * 100) / 100;
		document.getElementById("txt_rates_amt_due_guard_10").value = Math.round((parseFloat(document.getElementById("txt_rates_monthly_salary_10").value) + parseFloat(document.getElementById("txt_rates_night_diff_10").value) + parseFloat(document.getElementById("txt_rates_incentive_leave_10").value) + parseFloat(document.getElementById("txt_rates_13th_mon_10").value) + parseFloat(document.getElementById("txt_rates_uniform_allowance_10").value) + parseFloat(document.getElementById("txt_rates_cola_m_10").value) + parseFloat(document.getElementById("txt_rates_overtime_10").value)) * 100) / 100;
		
		//compute government dues
		document.getElementById("txt_rates_govt_dues_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_sss_premium_12a").value) + parseFloat(document.getElementById("txt_rates_pagibig_12a").value) + parseFloat(document.getElementById("txt_rates_philhealth_12a").value) + parseFloat(document.getElementById("txt_rates_state_ins_fund_12a").value) + parseFloat(document.getElementById("txt_rates_retirement_benefit_12a").value)) * 100) / 100;
		document.getElementById("txt_rates_govt_dues_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_sss_premium_12b").value) + parseFloat(document.getElementById("txt_rates_pagibig_12b").value) + parseFloat(document.getElementById("txt_rates_philhealth_12b").value) + parseFloat(document.getElementById("txt_rates_state_ins_fund_12b").value) + parseFloat(document.getElementById("txt_rates_retirement_benefit_12b").value)) * 100) / 100;
		document.getElementById("txt_rates_govt_dues_9").value = Math.round((parseFloat(document.getElementById("txt_rates_sss_premium_9").value) + parseFloat(document.getElementById("txt_rates_pagibig_9").value) + parseFloat(document.getElementById("txt_rates_philhealth_9").value) + parseFloat(document.getElementById("txt_rates_state_ins_fund_9").value) + parseFloat(document.getElementById("txt_rates_retirement_benefit_9").value)) * 100) / 100;
		document.getElementById("txt_rates_govt_dues_10").value = Math.round((parseFloat(document.getElementById("txt_rates_sss_premium_10").value) + parseFloat(document.getElementById("txt_rates_pagibig_10").value) + parseFloat(document.getElementById("txt_rates_philhealth_10").value) + parseFloat(document.getElementById("txt_rates_state_ins_fund_10").value) + parseFloat(document.getElementById("txt_rates_retirement_benefit_10").value)) * 100) / 100;
		
		//compute total dues
		document.getElementById("txt_rates_total_dues_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_amt_due_guard_12a").value) + parseFloat(document.getElementById("txt_rates_govt_dues_12a").value)) * 100) / 100;
		document.getElementById("txt_rates_total_dues_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_amt_due_guard_12b").value) + parseFloat(document.getElementById("txt_rates_govt_dues_12b").value)) * 100) / 100;
		document.getElementById("txt_rates_total_dues_9").value = Math.round((parseFloat(document.getElementById("txt_rates_amt_due_guard_9").value) + parseFloat(document.getElementById("txt_rates_govt_dues_9").value)) * 100) / 100;
		document.getElementById("txt_rates_total_dues_10").value = Math.round((parseFloat(document.getElementById("txt_rates_amt_due_guard_10").value) + parseFloat(document.getElementById("txt_rates_govt_dues_10").value)) * 100) / 100;
		
		//compute actual agency fee
		document.getElementById("txt_rates_agency_charge_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_total_dues_12a").value) * (parseFloat(document.getElementById("txt_rates_agency_percent_12a").value) / 100)) * 100) / 100;
		document.getElementById("txt_rates_agency_charge_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_total_dues_12b").value) * (parseFloat(document.getElementById("txt_rates_agency_percent_12b").value) / 100)) * 100) / 100;
		document.getElementById("txt_rates_agency_charge_9").value = Math.round((parseFloat(document.getElementById("txt_rates_total_dues_9").value) * (parseFloat(document.getElementById("txt_rates_agency_percent_9").value) / 100)) * 100) / 100;
		document.getElementById("txt_rates_agency_charge_10").value = Math.round((parseFloat(document.getElementById("txt_rates_total_dues_10").value) * (parseFloat(document.getElementById("txt_rates_agency_percent_10").value) / 100)) * 100) / 100;
		
		//compute agency vat
		document.getElementById("txt_rates_vat_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_agency_charge_12a").value) * 0.12) * 100) / 100;
		document.getElementById("txt_rates_vat_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_agency_charge_12b").value) * 0.12) * 100) / 100;
		document.getElementById("txt_rates_vat_9").value = Math.round((parseFloat(document.getElementById("txt_rates_agency_charge_9").value) * 0.12) * 100) / 100;
		document.getElementById("txt_rates_vat_10").value = Math.round((parseFloat(document.getElementById("txt_rates_agency_charge_10").value) * 0.12) * 100) / 100;
		
		//compute agency fee + vat
		document.getElementById("txt_rates_tot_agency_fee_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_agency_charge_12a").value) + parseFloat(document.getElementById("txt_rates_vat_12a").value)) * 100) / 100;
		document.getElementById("txt_rates_tot_agency_fee_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_agency_charge_12b").value) + parseFloat(document.getElementById("txt_rates_vat_12b").value)) * 100) / 100;
		document.getElementById("txt_rates_tot_agency_fee_9").value = Math.round((parseFloat(document.getElementById("txt_rates_agency_charge_9").value) + parseFloat(document.getElementById("txt_rates_vat_9").value)) * 100) / 100;
		document.getElementById("txt_rates_tot_agency_fee_10").value = Math.round((parseFloat(document.getElementById("txt_rates_agency_charge_10").value) + parseFloat(document.getElementById("txt_rates_vat_10").value)) * 100) / 100;
		
		//compute contract rate per guard
		document.getElementById("txt_rates_contract_per_guard_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_total_dues_12a").value) + parseFloat(document.getElementById("txt_rates_tot_agency_fee_12a").value)) * 100) / 100;
		document.getElementById("txt_rates_contract_per_guard_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_total_dues_12b").value) + parseFloat(document.getElementById("txt_rates_tot_agency_fee_12b").value)) * 100) / 100;
		document.getElementById("txt_rates_contract_per_guard_9").value = Math.round((parseFloat(document.getElementById("txt_rates_total_dues_9").value) + parseFloat(document.getElementById("txt_rates_tot_agency_fee_9").value)) * 100) / 100;
		document.getElementById("txt_rates_contract_per_guard_10").value = Math.round((parseFloat(document.getElementById("txt_rates_total_dues_10").value) + parseFloat(document.getElementById("txt_rates_tot_agency_fee_10").value)) * 100) / 100;
		
		//compute contract rate per month = rate per guard * no. of guards
		document.getElementById("txt_rates_contract_per_month_12a").value = Math.round((parseFloat(document.getElementById("txt_rates_contract_per_guard_12a").value) * parseFloat(document.getElementById("txt_rates_no_of_guards_12a").value)) * 100) / 100;
		document.getElementById("txt_rates_contract_per_month_12b").value = Math.round((parseFloat(document.getElementById("txt_rates_contract_per_guard_12b").value) * parseFloat(document.getElementById("txt_rates_no_of_guards_12b").value)) * 100) / 100;
		document.getElementById("txt_rates_contract_per_month_9").value = Math.round((parseFloat(document.getElementById("txt_rates_contract_per_guard_9").value) * parseFloat(document.getElementById("txt_rates_no_of_guards_9").value)) * 100) / 100;
		document.getElementById("txt_rates_contract_per_month_10").value = Math.round((parseFloat(document.getElementById("txt_rates_contract_per_guard_10").value) * parseFloat(document.getElementById("txt_rates_no_of_guards_10").value)) * 100) / 100;
		
		//compute total contract rate per month
		document.getElementById("txt_rates_tot_contract_per_month").value = Math.round((parseFloat(document.getElementById("txt_rates_contract_per_month_12a").value) + parseFloat(document.getElementById("txt_rates_contract_per_month_12b").value) + parseFloat(document.getElementById("txt_rates_contract_per_month_9").value) + parseFloat(document.getElementById("txt_rates_contract_per_month_10").value)) * 100) / 100;
		
		//compute total contract rate per year
		document.getElementById("txt_rates_contract_per_year").value = Math.round((parseFloat(document.getElementById("txt_rates_tot_contract_per_month").value) * 12) * 100) / 100;
		
		//compute total contract rate per 3 years
		document.getElementById("txt_rates_contract_per_3yr").value = Math.round((parseFloat(document.getElementById("txt_rates_contract_per_year").value) * 3) * 100) / 100;
	}
}

function toggleSpam(tag, tag2)
{
	$(".spamtable").hide();
	$(".tablink").css("background-color","#555");
	$("#"+tag2).css("background-color","red");
	$("#"+tag).show();
	
}

function toggleSpamByDate(token)
{
	if(token == 1)
	{
		$("#SPAM").load("spam.php?buspam="+ buspam + "&back=1");
	}
}

function toggleIDP(tag, tag2)
{
	$(".IDPtable").hide();
	$(".tablinkIDP").css("background-color","#555");
	$("#"+tag2).css("background-color","red");
	$("#"+tag).show();
	
}

function showIDP()
{
	$("#IDP").load("idp-module.php");
}

function showIDPMain()
{
	idpyear = document.getElementById("numIDPYear").value;
	$("#idptablebody").load("idp-module.php?idpyear="+ idpyear);
}

function openIDPModal()
{
	idpyear = document.getElementById("numIDPYear").value;
	$("#modalIDP").dialog("open");
	$("#modalIDP").load("idp-module.php?idpyear="+ idpyear +"&addtoken=1");
}

function closeIDPModal()
{
	$("#modalIDP").empty();
	$("#modalIDP").dialog("close");
}

function openIDPModalEdit(id)
{
	//idpyear = document.getElementById("numIDPYear").value;
	$("#modalIDP").dialog("open");
	//$("#modalIDP").load("idp-module.php?idpyear="+ idpyear + "&entryid="+ id +"&edittoken=1");
	$("#modalIDP").load("idp-module.php?entryid="+ id +"&edittoken=1");
}

function openAddIDPUserModal()
{
	$("#modalIDP").dialog("open");
	$("#modalIDP").load("idp-module.php?addtoken2=1");
}

function openAddIDPUserModalEdit(id)
{
	$("#modalIDP").dialog("open");
	$("#modalIDP").load("idp-module.php?edittoken2=1&entryid="+id);
}

function toggleIDP(tag, tag2)
{
	$(".IDPTable").hide();
	$(".tablinkIDP").css("background-color","#555");
	$("#"+tag2).css("background-color","red");
	$("#"+tag).show();
	
}

function checkCCStatus(secagency, bu, year, month, urlbase)
{
	prehash = secagency + bu + year + month;
	hashed = hex_md5(prehash);
	window.location.href = urlbase + "/checkstatus.php?to="+ hashed + "&bu=" + bu + "&ye=" + year + "&mo=" + month + "&sa=" + secagency;
}

function searchCC()
{
	$( "#tbodyNewCC" ).load("cc-template.php?year=" + document.getElementById("selCCYear").value);
	$( "#tblCCShow" ).show();
	$( "#tblNewCC" ).show();
}

function searchCCfaux()
{
	//$( "#tbodyNewCC" ).load("cc-template.php?year=" + document.getElementById("selCCYear").value);
	$( "#tblCCShow2" ).show();
	$( "#tblNewCC" ).show();
}

function searchCCCons()
{
	$( "#ccConsDisplay" ).load("cc-consolidation.php?year=" + document.getElementById("ccConsYear").value);
}

function searchCCConsSub(year, bu)
{
	$( "#ccConsDisplaySub" ).load("cc-scores-SA.php?year=" + year + "&bu=" + bu);
	$( "#ccConsDisplayMain" ).hide();
	$( "#ccConsDisplaySub" ).show();
}

function searchCCConsSA(month, txt, bu, year)
{
	$( "#ccConsDisplaySubSpecific" ).load("cc-general-SA.php?ccyear=" + year + "&ccbu=" + bu + "&cctext=" + txt + "&ccmonth=" + month);
	$( "#divskipcc" ).hide();
}

function skipAgency()
{
	window.location.href = "cc-skip.php?ccyear=" + document.getElementById("txtskipyear").value + "&ccbu=" + document.getElementById("txtskipbu").value + "&ccagency=" + document.getElementById("selskipagency").value + "&ccmonth=" + document.getElementById("txtskipmonth").value;
}

function skipAgencyShow(month)
{
	document.getElementById("txtskipmonth").value = month;
	$( "#divskipcc" ).show();
	$( "#ccConsDisplaySubSpecific" ).empty();
}

function toggleConCom()
{
	$( "#ccConsDisplaySub" ).hide();
	$( "#ccConsDisplayMain" ).show();
}

function addCCEntry()
{		
		if((document.getElementById("txtAddCCNumber").value) && (document.getElementById("txtAddCCGoal").value) && (document.getElementById("txtAddCCSubGoal").value) && (document.getElementById("txtAddCCReference").value) && (document.getElementById("txtaddCCStandard").value) && (document.getElementById("txtAddCCFrequency").value) && (document.getElementById("txtAddCCSource").value) && (document.getElementById("selCCFormula").value) && (document.getElementById("txtAddCCFactor").value))
		{
			if(((parseFloat(document.getElementById('lblCCtotalweight3').innerHTML)) + (parseFloat(document.getElementById("txtAddCCWeight").value))) <= 100)
			{
				$( "#tblAddCC tbody" ).append("<tr align='center' valign='top'>" +
				  "<td class='rowAddCCNumber' >" + document.getElementById("txtAddCCNumber").value + "</td>" +
				  "<td class='rowAddCCGoal' style='display:none;'>" + document.getElementById("txtAddCCGoal").value + "</td>" +
				  "<td>" + $("#txtAddCCGoal option:selected").text() + "</td>" +
				  "<td class='rowAddCCSubGoal' style='display:none;'>" + document.getElementById("txtAddCCSubGoal").value + "</td>" +
				  "<td >" + $("#txtAddCCSubGoal option:selected").text() + "</td>" +
				  "<td class='rowAddCCReference'>" + document.getElementById("txtAddCCReference").value + "</td>" +
				  "<td class='rowAddCCStandard' style='display:none;'>" + document.getElementById("txtaddCCStandard").value + "</td>" +
				  "<td align='left' style='padding-left:10px;6'>" + (document.getElementById("txtaddCCStandard").value).replace(/\n/gi, "<br>") + "</td>" +
				  "<td class='rowAddCCFrequency'>" + document.getElementById("txtAddCCFrequency").value + "</td>" +
				  "<td class='rowAddCCSource'>" + document.getElementById("txtAddCCSource").value + "</td>" +		  
				  "<td class='rowAddCCFormula' style='display:none;'>" + document.getElementById("selCCFormula").value + "</td>" +
				  "<td >" + $("#selCCFormula option:selected").text() + "</td>" +
				  "<td class='rowAddCCWeight'>" + document.getElementById("txtAddCCWeight").value + "</td>" +
				  "<td class='rowAddCCFactor'>" + document.getElementById("txtAddCCFactor").value + "</td>" +
				  "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
				"</tr>" );
				document.getElementById("txtAddCCReference").value = "";
				document.getElementById("txtaddCCStandard").value = "";
				document.getElementById("txtAddCCFrequency").value = "";
				document.getElementById("txtAddCCSource").value = "";
				document.getElementById('lblCCtotalweight3').innerHTML = (parseFloat(document.getElementById('lblCCtotalweight3').innerHTML) + parseFloat(document.getElementById("txtAddCCWeight").value));
				$( "#tblAddCC" ).show();
				$( "#btnsaveCC" ).show();
			}
			else
			{
				alert("Overweight.");
			}
		}
}

function addCCEntry2()
{		
		if((document.getElementById("txtAddCCGoal2").value) && (document.getElementById("txtAddCCSubGoal2").value) && (document.getElementById("txtAddCCNumber2").value) && (document.getElementById("txtAddCCReference2").value) && (document.getElementById("txtAddCCStandard2").value) && (document.getElementById("txtAddCCDetails2").value) && (document.getElementById("txtAddCCFrequency2").value) && (document.getElementById("txtAddCCSource2").value) && (document.getElementById("txtAddCCDeduction2").value))
		{
			
			$( "#tblNewCC tbody" ).append("<tr align='center' valign='top'>" +
			  "<td class='rowAddCCNumber' >" + document.getElementById("txtAddCCNumber2").value + "</td>" +
			  "<td class='rowAddCCGoal' style='display:none;'>" + document.getElementById("txtAddCCGoal2").value + "</td>" +
			  "<td>" + $("#txtAddCCGoal2 option:selected").text() + "</td>" +
			  "<td class='rowAddCCSubGoal' style='display:none;'>" + document.getElementById("txtAddCCSubGoal2").value + "</td>" +
			  "<td >" + $("#txtAddCCSubGoal2 option:selected").text() + "</td>" +
			  "<td class='rowAddCCReference'>" + document.getElementById("txtAddCCReference2").value + "</td>" +
			  "<td class='rowAddCCStandard' style='display:none;'>" + document.getElementById("txtAddCCStandard2").value + "</td>" +
			  "<td align='left' style='padding-left:10px;6'>" + (document.getElementById("txtAddCCStandard2").value).replace(/\n/gi, "<br>") + "</td>" +
			  "<td class='rowAddCCDetails' style='display:none;'>" + document.getElementById("txtAddCCDetails2").value + "</td>" +
			  "<td align='left' style='padding-left:10px;6'>" + (document.getElementById("txtAddCCDetails2").value).replace(/\n/gi, "<br>") + "</td>" +
			  "<td class='rowAddCCFrequency'>" + document.getElementById("txtAddCCFrequency2").value + "</td>" +
			  "<td class='rowAddCCSource'>" + document.getElementById("txtAddCCSource2").value + "</td>" +
			  "<td class='rowAddCCDeduction'>" + document.getElementById("txtAddCCDeduction2").value + "</td>" +			  
			  "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
			"</tr>" );
			document.getElementById("txtAddCCNumber2").value = "";
			document.getElementById("txtAddCCReference2").value = "";
			document.getElementById("txtAddCCStandard2").value = "";
			document.getElementById("txtAddCCDetails2").value = "";
			document.getElementById("txtAddCCSource2").value = "";		
			document.getElementById("txtAddCCDeduction2").value = "";
			$( "#tblNewCC" ).show();
			$( "#btnSaveNewCC" ).show();		
		}
}

function addCCEntry3()
{		
		if((document.getElementById("txtAddCCGoal2").value) && (document.getElementById("txtAddCCNumber2").value) && (document.getElementById("txtAddCCReference2").value) && (document.getElementById("txtAddCCStandard2").value) && (document.getElementById("txtAddCCDetails2").value) && (document.getElementById("txtAddCCSource2").value) && (document.getElementById("txtAddCCDeduction2").value) && (document.getElementById("txtAddCCGroup2").value))
		{
			
			$( "#tblNewCC tbody" ).append("<tr align='center' valign='top'>" +
			  "<td class='rowAddCCNumber' >" + document.getElementById("txtAddCCNumber2").value + "</td>" +
			  "<td class='rowAddCCGoal' style='display:none;'>" + document.getElementById("txtAddCCGoal2").value + "</td>" +
			  "<td>" + $("#txtAddCCGoal2 option:selected").text() + "</td>" +			  
			  "<td class='rowAddCCReference'>" + document.getElementById("txtAddCCReference2").value + "</td>" +
			  "<td class='rowAddCCStandard' style='display:none;'>" + document.getElementById("txtAddCCStandard2").value + "</td>" +
			  "<td align='left' style='padding-left:10px;6'>" + (document.getElementById("txtAddCCStandard2").value).replace(/\n/gi, "<br>") + "</td>" +
			  "<td class='rowAddCCDetails' style='display:none;'>" + document.getElementById("txtAddCCDetails2").value + "</td>" +
			  "<td align='left' style='padding-left:10px;6'>" + (document.getElementById("txtAddCCDetails2").value).replace(/\n/gi, "<br>") + "</td>" +			  
			  "<td class='rowAddCCSource'>" + document.getElementById("txtAddCCSource2").value + "</td>" +
			  "<td class='rowAddCCDeduction'>" + document.getElementById("txtAddCCDeduction2").value + "</td>" +
			  "<td class='rowAddCCGroup' style='display:none;'>" + document.getElementById("txtAddCCGroup2").value + "</td>" +
			  "<td>" + $("#txtAddCCGroup2 option:selected").text() + "</td>" +
			  "<td class='rowAddCCHover'>" + document.getElementById("txtAddCCHover2").value + "</td>" +
			  "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
			"</tr>" );
			document.getElementById("txtAddCCNumber2").value = "";
			document.getElementById("txtAddCCReference2").value = "";
			document.getElementById("txtAddCCStandard2").value = "";
			document.getElementById("txtAddCCDetails2").value = "";
			document.getElementById("txtAddCCSource2").value = "";		
			document.getElementById("txtAddCCDeduction2").value = "";
			document.getElementById("txtAddCCHover2").value = "";
			$( "#tblNewCC" ).show();
			$( "#btnSaveNewCC" ).show();		
		}
}

function addCCEntry4()
{		
		if((document.getElementById("txtAddCCGoal2").value) && (document.getElementById("txtAddCCNumber2").value) && (document.getElementById("txtAddCCSubGoal2").value) && (document.getElementById("txtAddCCStandard2").value) && (document.getElementById("txtAddCCDeduction2").value))
		{
			
			$( "#tblNewCC tbody" ).append("<tr align='center' valign='top'>" +
			  "<td class='rowAddCCNumber' >" + document.getElementById("txtAddCCNumber2").value + "</td>" +
			  "<td class='rowAddCCGoal' style='display:none;'>" + document.getElementById("txtAddCCGoal2").value + "</td>" +
			  "<td>" + $("#txtAddCCGoal2 option:selected").text() + "</td>" +			  
			  "<td class='rowAddCCSubGoal'>" + document.getElementById("txtAddCCSubGoal2").value + "</td>" +
			  "<td class='rowAddCCStandard' style='display:none;'>" + document.getElementById("txtAddCCStandard2").value + "</td>" +
			  "<td align='left' style='padding-left:10px;6'>" + (document.getElementById("txtAddCCStandard2").value).replace(/\n/gi, "<br>") + "</td>" +
			  "<td class='rowAddCCDetails' style='display:none;'>" + document.getElementById("txtAddCCDetails2").value + "</td>" +
			  "<td align='left' style='padding-left:10px;6'>" + (document.getElementById("txtAddCCDetails2").value).replace(/\n/gi, "<br>") + "</td>" +			  
			  "<td class='rowAddCCHover'>" + document.getElementById("txtAddCCHover2").value + "</td>" +
			  "<td class='rowAddCCFrequency'>" + document.getElementById("txtAddCCFrequency2").value + "</td>" +
			  "<td class='rowAddCCDeduction'>" + document.getElementById("txtAddCCDeduction2").value + "</td>" +
			  
			  
			  "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
			"</tr>" );
			document.getElementById("txtAddCCNumber2").value = (parseInt(document.getElementById("txtAddCCNumber2").value) + 1);
			//document.getElementById("txtAddCCSubGoal2").value = "";
			document.getElementById("txtAddCCStandard2").value = "";
			document.getElementById("txtAddCCDetails2").value = "";
			document.getElementById("txtAddCCFrequency2").value = "";		
			document.getElementById("txtAddCCDeduction2").value = 0;
			document.getElementById("txtAddCCHover2").value = "";
			
			$( "#tblNewCC" ).show();
			$( "#btnSaveNewCC" ).show();		
		}
}

function saveCCEntry()
{
	var ccnumber = document.getElementsByClassName("rowAddCCNumber");
	var ccgoal = document.getElementsByClassName("rowAddCCGoal");
	var ccsubgoal = document.getElementsByClassName("rowAddCCSubGoal");
	var ccreference = document.getElementsByClassName("rowAddCCReference");
	var ccstandard = document.getElementsByClassName("rowAddCCStandard");
	var ccfrequency = document.getElementsByClassName("rowAddCCFrequency");
	var ccsource = document.getElementsByClassName("rowAddCCSource");
	var ccformula = document.getElementsByClassName("rowAddCCFormula");
	var ccweight = document.getElementsByClassName("rowAddCCWeight");
	var ccfactor = document.getElementsByClassName("rowAddCCFactor");
	var i;
	for (i = 0; i < ccnumber.length; i++)
	{
		document.getElementById("addCCNumbers").value += "*~" + ccnumber[i].innerHTML;
		document.getElementById("addCCGoals").value += "*~" + ccgoal[i].innerHTML;
		document.getElementById("addCCSubGoals").value += "*~" + ccsubgoal[i].innerHTML;
		document.getElementById("addCCReferences").value += "*~" + ccreference[i].innerHTML;
		document.getElementById("addCCStandards").value += "*~" + ccstandard[i].innerHTML;
		document.getElementById("addCCFrequencies").value += "*~" + ccfrequency[i].innerHTML;
		document.getElementById("addCCSources").value += "*~" + ccsource[i].innerHTML;
		document.getElementById("addCCFormulas").value += "*~" + ccformula[i].innerHTML;
		document.getElementById("addCCWeights").value += "*~" + ccweight[i].innerHTML;
		document.getElementById("addCCFactors").value += "*~" + ccfactor[i].innerHTML;
	}
	if((document.getElementById("addCCNumbers").value) && (document.getElementById("addCCGoals").value) && (document.getElementById("addCCSubGoals").value) && (document.getElementById("addCCReferences").value) && (document.getElementById("addCCSources").value) && (document.getElementById("addCCFormulas").value) && (document.getElementById("addCCFactors").value))
	{
		document.getElementById("frmAddCCDetails").submit();
	}
	
}

function saveCCEntry2()
{
	var ccnumber = document.getElementsByClassName("rowAddCCNumber");
	var ccgoal = document.getElementsByClassName("rowAddCCGoal");
	var ccsubgoal = document.getElementsByClassName("rowAddCCSubGoal");
	var ccreference = document.getElementsByClassName("rowAddCCReference");
	var ccstandard = document.getElementsByClassName("rowAddCCStandard");
	var ccdetails = document.getElementsByClassName("rowAddCCDetails");
	var ccfrequency = document.getElementsByClassName("rowAddCCFrequency");
	var ccsource = document.getElementsByClassName("rowAddCCSource");
	var ccdeduction = document.getElementsByClassName("rowAddCCDeduction");	
	var i;
	for (i = 0; i < ccnumber.length; i++)
	{
		document.getElementById("newCCNumbers").value += "*~" + ccnumber[i].innerHTML;
		document.getElementById("newCCGoals").value += "*~" + ccgoal[i].innerHTML;
		document.getElementById("newCCSubGoals").value += "*~" + ccsubgoal[i].innerHTML;
		document.getElementById("newCCReferences").value += "*~" + ccreference[i].innerHTML;
		document.getElementById("newCCStandards").value += "*~" + ccstandard[i].innerHTML;
		document.getElementById("newCCDetails").value += "*~" + ccdetails[i].innerHTML;
		document.getElementById("newCCFrequencies").value += "*~" + ccfrequency[i].innerHTML;
		document.getElementById("newCCSources").value += "*~" + ccsource[i].innerHTML;
		document.getElementById("newCCDeductions").value += "*~" + ccdeduction[i].innerHTML;		
	}
	if((document.getElementById("newCCNumbers").value) && (document.getElementById("newCCGoals").value) && (document.getElementById("newCCSubGoals").value) && (document.getElementById("newCCReferences").value)  && (document.getElementById("newCCStandards").value) && (document.getElementById("newCCDetails").value) && (document.getElementById("newCCFrequencies").value) && (document.getElementById("newCCSources").value) && (document.getElementById("newCCDeductions").value))
	{
		document.getElementById("frmNewCCTemplate").submit();
	}
	
}

function saveCCEntry3()
{
	var ccnumber = document.getElementsByClassName("rowAddCCNumber");
	var ccgoal = document.getElementsByClassName("rowAddCCGoal");
	var ccreference = document.getElementsByClassName("rowAddCCReference");
	var ccstandard = document.getElementsByClassName("rowAddCCStandard");
	var ccdetails = document.getElementsByClassName("rowAddCCDetails");	
	var ccsource = document.getElementsByClassName("rowAddCCSource");
	var ccdeduction = document.getElementsByClassName("rowAddCCDeduction");	
	var ccgroups = document.getElementsByClassName("rowAddCCGroup");
	var cchovers = document.getElementsByClassName("rowAddCCHover");
	var i;
	for (i = 0; i < ccnumber.length; i++)
	{
		document.getElementById("newCCNumbers").value += "*~" + ccnumber[i].innerHTML;
		document.getElementById("newCCGoals").value += "*~" + ccgoal[i].innerHTML;		
		document.getElementById("newCCReferences").value += "*~" + ccreference[i].innerHTML;
		document.getElementById("newCCStandards").value += "*~" + ccstandard[i].innerHTML;
		document.getElementById("newCCDetails").value += "*~" + ccdetails[i].innerHTML;
		document.getElementById("newCCSources").value += "*~" + ccsource[i].innerHTML;
		document.getElementById("newCCDeductions").value += "*~" + ccdeduction[i].innerHTML;
		document.getElementById("newCCGroups").value += "*~" + ccgroups[i].innerHTML;
		document.getElementById("newCCHovers").value += "*~" + cchovers[i].innerHTML;
	}
	if((document.getElementById("newCCNumbers").value) && (document.getElementById("newCCGoals").value) && (document.getElementById("newCCReferences").value)  && (document.getElementById("newCCStandards").value) && (document.getElementById("newCCDetails").value) && (document.getElementById("newCCSources").value) && (document.getElementById("newCCDeductions").value) && (document.getElementById("newCCGroups").value))
	{
		document.getElementById("frmNewCCTemplate").submit();
	}
	
}

function saveCCEntry4()
{
	var ccnumber = document.getElementsByClassName("rowAddCCNumber");
	var ccgoal = document.getElementsByClassName("rowAddCCGoal");
	var ccfrequency = document.getElementsByClassName("rowAddCCFrequency");
	var ccstandard = document.getElementsByClassName("rowAddCCStandard");
	var ccdetails = document.getElementsByClassName("rowAddCCDetails");	
	
	var ccdeduction = document.getElementsByClassName("rowAddCCDeduction");	
	var ccsubgoal = document.getElementsByClassName("rowAddCCSubGoal");
	var cchovers = document.getElementsByClassName("rowAddCCHover");
	var i;
	for (i = 0; i < ccnumber.length; i++)
	{
		document.getElementById("newCCNumbers").value += "*~" + ccnumber[i].innerHTML;
		document.getElementById("newCCGoals").value += "*~" + ccgoal[i].innerHTML;		
		document.getElementById("newCCFrequencies").value += "*~" + ccfrequency[i].innerHTML;
		document.getElementById("newCCStandards").value += "*~" + ccstandard[i].innerHTML;
		document.getElementById("newCCDetails").value += "*~" + ccdetails[i].innerHTML;
		
		document.getElementById("newCCDeductions").value += "*~" + ccdeduction[i].innerHTML;
		document.getElementById("newCCSubGoals").value += "*~" + ccsubgoal[i].innerHTML;
		document.getElementById("newCCHovers").value += "*~" + cchovers[i].innerHTML;
	}
	if((document.getElementById("newCCNumbers").value) && (document.getElementById("newCCGoals").value) && (document.getElementById("newCCStandards").value) && (document.getElementById("newCCDetails").value) && (document.getElementById("newCCDeductions").value))
	{
		document.getElementById("frmNewCCTemplate").submit();
	}
	
}




function editCCFormOpen(number, goal, subgoal, reference, standard, frequency, source, formula, weight, factor, id)
{
	document.getElementById('txtEditCCNumber').value = number;
	document.getElementById('txtEditCCGoal').value = goal;
	document.getElementById('txtEditCCSubGoal').value = subgoal;
	document.getElementById('txtEditCCReference').value = reference;
	document.getElementById('txtEditCCStandard').value = standard;
	document.getElementById('txtEditCCFrequency').value = frequency;
	document.getElementById('txtEditCCSource').value = source;
	document.getElementById('selEditCCFormula').value = formula;
	document.getElementById('txtEditCCWeight').value = weight;
	document.getElementById('txtEditCCFactor').value = factor;
	document.getElementById('CCEditID').value = id;
	$( "#editCCModal" ).dialog("open");
	
}

function editCCFormSubmit()
{
	if((document.getElementById('txtEditCCNumber').value) && (document.getElementById('txtEditCCGoal').value) && (document.getElementById('txtEditCCSubGoal').value) && (document.getElementById('txtEditCCReference').value) && (document.getElementById('txtEditCCStandard').value) && (document.getElementById('txtEditCCFrequency').value) && (document.getElementById('txtEditCCSource').value) && (document.getElementById('selEditCCFormula').value) && (document.getElementById('txtEditCCFactor').value))
	{
		if(((parseFloat(document.getElementById('lblCCtotalweight3').innerHTML)) + (parseFloat(document.getElementById("txtEditCCWeight").value))) <= 100)
		{
			document.getElementById('editCCForm').submit();
		}
		else
		{
			alert("Overweight");
		}
	}
}

function editCCFormClose()
{
	$( "#editCCModal" ).dialog("close");
}

function openCC(ccid, ccbu, ccsa, ccyear, ccmonth, ccoic, ccemail, cctotalweight, ccscore, cclevel)
{
	if(cclevel == "Admin")
	{
		$('#listConCom').hide();
		$('#cc_specific').show();
		document.getElementById('txtCCYear3').innerHTML = ccyear;
		document.getElementById('selCCMonth3').value = ccmonth;
		document.getElementById('selCCBU3').value = ccbu;
		document.getElementById('selCCSecAgency3').value = ccsa;
		document.getElementById('txtCCOIC3').value = ccoic;
		document.getElementById('txtCCemail3').value = ccemail;
		document.getElementById('lblCCtotalweight3').innerHTML = cctotalweight;
		document.getElementById('lblCCscore3').innerHTML = ccscore;
		document.getElementById("addCCMasterNumber").value = ccid;
		if(document.getElementById("addCCMasterNumber2"))
		{
			document.getElementById("addCCMasterNumber2").value = ccid;
		}
		
	}
	else
	{
		$('#listConCom').hide();
		$('#cc_specific').show();
		document.getElementById('txtCCYear3').value = ccyear;
		document.getElementById('selCCMonth3').value = ccmonth;
		document.getElementById('selCCBU3').value = ccbu;
		document.getElementById('selCCSecAgency3').value = ccsa;
		document.getElementById('txtCCOIC3').value = ccoic;
		document.getElementById('txtCCemail3').value = ccemail;
		document.getElementById('lblCCtotalweight3').innerHTML = cctotalweight;
		document.getElementById('lblCCscore3').innerHTML = ccscore;
		document.getElementById("addCCMasterNumber").value = ccid;
		document.getElementById("addCCMasterNumber2").value = ccid;
	}
	
}

function changeSubGoal()
{
	if(document.getElementById('txtAddCCGoal').value == "People")
	{
		document.getElementById('txtAddCCSubGoal').innerHTML = "<option value='Attract'>Attract</option> <option value='Optimize'>Optimize</option> <option value='Retain'>Retain</option> <option value='Statutory Compliance'>Statutory Compliance</option>";
	}
	else if(document.getElementById('txtAddCCGoal').value == "Customer")
	{
		document.getElementById('txtAddCCSubGoal').innerHTML = "<option value='SLA'>SLA</option>";
	}
	else if(document.getElementById('txtAddCCGoal').value == "Process")
	{
		document.getElementById('txtAddCCSubGoal').innerHTML = "<option value='Pre'>Pre</option> <option value='Post'>Post</option> <option value='After'>After</option>";
	}
	else if(document.getElementById('txtAddCCGoal').value == "Finance")
	{
		document.getElementById('txtAddCCSubGoal').innerHTML = "<option value='Billing'>Billing</option>";
	}
	else if(document.getElementById('txtAddCCGoal').value == "Governance")
	{
		document.getElementById('txtAddCCSubGoal').innerHTML = "<option value='Deduction'>Deduction</option>";
	}
}

function changeSubGoal2()
{
	if(document.getElementById('txtEditCCGoal').value == "People")
	{
		document.getElementById('txtEditCCSubGoal').innerHTML = "<option value='Attract'>Attract</option> <option value='Optimize'>Optimize</option> <option value='Retain'>Retain</option> <option value='Statutory Compliance'>Statutory Compliance</option>";
	}
	else if(document.getElementById('txtEditCCGoal').value == "Customer")
	{
		document.getElementById('txtEditCCSubGoal').innerHTML = "<option value='SLA'>SLA</option>";
	}
	else if(document.getElementById('txtEditCCGoal').value == "Process")
	{
		document.getElementById('txtEditCCSubGoal').innerHTML = "<option value='Pre'>Pre</option> <option value='Post'>Post</option> <option value='After'>After</option>";
	}
	else if(document.getElementById('txtEditCCGoal').value == "Finance")
	{
		document.getElementById('txtEditCCSubGoal').innerHTML = "<option value='Billing'>Billing</option>";
	}
	else if(document.getElementById('txtEditCCGoal').value == "Governance")
	{
		document.getElementById('txtEditCCSubGoal').innerHTML = "<option value='Deduction'>Deduction</option>";
	}
}

function changeSubGoal3()
{
	if(document.getElementById('txtAddCCGoal2').value == "People")
	{
		document.getElementById('txtAddCCSubGoal2').innerHTML = "<option value='Attract'>Attract</option> <option value='Optimize'>Optimize</option> <option value='Retain'>Retain</option> <option value='Statutory Compliance'>Statutory Compliance</option>";
	}
	else if(document.getElementById('txtAddCCGoal2').value == "Customer")
	{
		document.getElementById('txtAddCCSubGoal2').innerHTML = "<option value='SLA'>SLA</option>";
	}
	else if(document.getElementById('txtAddCCGoal2').value == "Process")
	{
		document.getElementById('txtAddCCSubGoal2').innerHTML = "<option value='Pre'>Pre</option> <option value='Post'>Post</option> <option value='After'>After</option>";
	}
	else if(document.getElementById('txtAddCCGoal2').value == "Finance")
	{
		document.getElementById('txtAddCCSubGoal2').innerHTML = "<option value='Billing'>Billing</option>";
	}
	else if(document.getElementById('txtAddCCGoal2').value == "Governance")
	{
		document.getElementById('txtAddCCSubGoal2').innerHTML = "<option value='Deduction'>Deduction</option>";
	}
}

function changeSubGoal4()
{
	if(document.getElementById('txtEditCCGoal2').value == "People")
	{
		document.getElementById('txtEditCCSubGoal2').innerHTML = "<option value='Attract'>Attract</option> <option value='Optimize'>Optimize</option> <option value='Retain'>Retain</option> <option value='Statutory Compliance'>Statutory Compliance</option>";
	}
	else if(document.getElementById('txtEditCCGoal2').value == "Customer")
	{
		document.getElementById('txtEditCCSubGoal2').innerHTML = "<option value='SLA'>SLA</option>";
	}
	else if(document.getElementById('txtEditCCGoal2').value == "Process")
	{
		document.getElementById('txtEditCCSubGoal2').innerHTML = "<option value='Pre'>Pre</option> <option value='Post'>Post</option> <option value='After'>After</option>";
	}
	else if(document.getElementById('txtEditCCGoal2').value == "Finance")
	{
		document.getElementById('txtEditCCSubGoal2').innerHTML = "<option value='Billing'>Billing</option>";
	}
	else if(document.getElementById('txtEditCCGoal2').value == "Governance")
	{
		document.getElementById('txtEditCCSubGoal2').innerHTML = "<option value='Deduction'>Deduction</option>";
	}
}

function publishCC()
{
	var answer = confirm("Do you want to publish?" )

	if (answer != 0)
	{
		window.location.href = "deleteitem.php?ccid=" + document.getElementById("addCCMasterNumber").value +"&type=ConComp&status=publish";
	}
}

function saveEditCC()
{
	document.getElementById('frmSaveEditCC').submit();
}

function editCCShow(ccid)
{
	$("#editCCModalHolder").load("cc-template-edit.php?id=" + ccid);
	$( "#editCCModal" ).dialog("open");	
}

function editCCClose()
{
	$( "#editCCModal" ).dialog("close");
}



function addLocationRowSA(){
	if((document.getElementById("txtaddlocation").value) && (document.getElementById("txtaddlocationcode").value) && (document.getElementById("selbuloc").value)){
		document.getElementById("locdiv").style.display = "initial";
		$( "#addlocationtable tbody" ).append( "<tr align='center'>" +
		  "<td class='rowlocationbu' style='display:none;'>" + document.getElementById("selbuloc").value + "</td>" +
		  "<td>" + $("#selbuloc option:selected").text() + "</td>" +
          "<td class='rowlocationcode'>" + document.getElementById("txtaddlocationcode").value + "</td>" +
          "<td class='rowlocation'>" + document.getElementById("txtaddlocation").value + "</td>" +
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
		document.getElementById("txtaddlocationcode").value = "";
		document.getElementById("txtaddlocation").value = "";		
		document.getElementById("txtaddlocationcode").focus();
	}
	else
	{
		alert("Enter complete location details");
	}
}

function fnExcelReport(tableid)
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById(tableid); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // removes input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
		//sa = window.open('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,' + encodeURIComponent(tab_text));

    return (sa);
}

function editLocation(code, location, id, bu){
	document.getElementById("btnaddlocationrow").style.display = "none";
	document.getElementById("btneditlocationrow").style.display = "initial";
	document.getElementById("txtaddlocationcode").value = code;
	document.getElementById("txtaddlocation").value = location;
	document.getElementById("txtaddlocationid").value = id;
	if((bu) && (document.getElementById("selbuloc")))
	{
		document.getElementById("selbuloc").value = bu;
	}
	
	$( "#addlocsmodal" ).dialog( "open");
}

function updateLocation(){
	if((document.getElementById("txtaddlocationcode").value) && (document.getElementById("txtaddlocation").value)){
		document.getElementById("addlocationform").submit();
	}
	else{
		alert("Please complete the location details.");
	}
}

function closeAddLoc(){
	document.getElementById("addlocationform").reset();
	document.getElementById("addlocstbody").innerHTML = "";
	document.getElementById("btnaddlocationrow").style.display = "initial";
	document.getElementById("btneditlocationrow").style.display = "none";
	document.getElementById("locdiv").style.display = "none";
	$( "#addlocsmodal" ).dialog( "close");
}

function addLocations(){
	var x = document.getElementsByClassName('rowlocation');
	var x2 = document.getElementsByClassName('rowlocationcode');
	var i;
	for (i = 0; i < x.length; i++) {
		document.getElementById("txtaddlocations").value += "*~" + x[i].innerHTML;
		document.getElementById("txtaddlocationcodes").value += "*~" + x2[i].innerHTML;
	}
	if((document.getElementById("txtaddlocations").value) && (document.getElementById("txtaddlocationcodes").value))
	{
		document.getElementById("txtactivityname").value = "";
		document.getElementById("txtincidentname").value = "";
		document.getElementById("addlocationform").submit();
	}
	else
	{
		alert("No locations to add.");
	}
	
}

function addLocationsSA(){
	var x = document.getElementsByClassName('rowlocation');
	var x2 = document.getElementsByClassName('rowlocationcode');
	var x3 = document.getElementsByClassName('rowlocationbu');
	var i;
	for (i = 0; i < x.length; i++) {
		document.getElementById("txtaddlocations").value += "*~" + x[i].innerHTML;
		document.getElementById("txtaddlocationcodes").value += "*~" + x2[i].innerHTML;
		document.getElementById("txtaddlocationbus").value += "*~" + x3[i].innerHTML;
	}
	if((document.getElementById("txtaddlocations").value) && (document.getElementById("txtaddlocationcodes").value) && (document.getElementById("txtaddlocationbus").value))
	{
		document.getElementById("txtactivityname").value = "";
		document.getElementById("txtincidentname").value = "";
		document.getElementById("addlocationform").submit();
	}
	else
	{
		alert("No locations to add.");
	}
	
}

function deleteItem(id,itemtype)
{
	var answer = confirm("Do you want to delete this item?" )

	if (answer != 0)
	{
		window.location.href = "deleteitem.php?id=" + id +"&type=" + itemtype;
	}
}

function deleteItem2(id,itemtype)
{
	var answer = confirm("Do you want to toggle the status of this item?" )

	if (answer != 0)
	{
		window.location.href = "deleteitem.php?id=" + id +"&type=" + itemtype +"&status=Activate";
	}
}

function deleteItem3(id,itemtype,weight,ccid)
{
	var answer = confirm("Do you want to delete this item?" )

	if (answer != 0)
	{
		window.location.href = "deleteitem.php?id=" + id +"&type=" + itemtype + "&ccweight=" + weight + "&ccid=" + ccid;
	}
}

function closeAddOic(){
	document.getElementById("oicform").reset();
	document.getElementById("btnsaveoic").style.display = "initial";
	document.getElementById("btneditoic").style.display = "none";
	$( "#addoicform" ).dialog( "close")
}

function editOic(fname, lname, eadd, id, bu, slevel){
	document.getElementById("oiclastname").value = lname;
	document.getElementById("oicfirstname").value = fname;
//	document.getElementById("oicmiddlename").value = mname;
	document.getElementById("oicemail").value = eadd;
//	document.getElementById("oiccontact").value = contact;
	document.getElementById("oicid").value = id;
	document.getElementById("oicslevel").value = slevel;
	if(bu)
	{
		document.getElementById("oicbu").value = bu;
	}	
	document.getElementById("btnsaveoic").style.display = "none";
	document.getElementById("btneditoic").style.display = "initial";	
	$( "#addoicform" ).dialog( "open")
}

function closeAddUser(){
	document.getElementById("adduserform").reset();
	document.getElementById("btnsaveuser").style.display = "initial";
	document.getElementById("btnedituser").style.display = "none";
	document.getElementById("divForgotPass").style.display = "none";
	document.getElementById("lbluserstat").innerHTML = "";
	$("#adduserdiv").dialog("close");
}

function editUser(ulname, ufname, umi, ugender, uusername, ulevel, ucontact, uuid){
	document.getElementById("userslastname").value = ulname;
	document.getElementById("usersfirstname").value = ufname;
	//document.getElementById("usersmi").value = umi;
	//document.getElementById("selugender").value = ugender;
	document.getElementById("usersusername").value = uusername;
	document.getElementById("selaccess").value = ulevel;
	//document.getElementById("userscontact").value = ucontact;
	document.getElementById("usersid").value = uuid;

	document.getElementById("btnsaveuser").style.display = "none";
	document.getElementById("btnedituser").style.display = "initial";
	document.getElementById("divForgotPass").style.display = "initial";
	$( "#adduserdiv" ).dialog( "open" );
}

function editUserSA(ulname, ufname, umi, ugender, uusername, uemail, ulevel, ucontact, uuid, ubu){
	document.getElementById("userslastname").value = ulname;
	document.getElementById("usersfirstname").value = ufname;
//	document.getElementById("usersmi").value = umi;
//	document.getElementById("selugender").value = ugender;
	document.getElementById("usersusername").value = uusername;
	document.getElementById("user_email").value = uemail;
	document.getElementById("selaccess").value = ulevel;
//	document.getElementById("userscontact").value = ucontact;
	document.getElementById("usersid").value = uuid;
	document.getElementById("seluserbu").value = ubu;
	document.getElementById("btnsaveuser").style.display = "none";
	document.getElementById("btnedituser").style.display = "initial";
	document.getElementById("divForgotPass").style.display = "initial";
	$( "#adduserdiv" ).dialog( "open" );
	if(document.getElementById("selaccess").value == "Super Admin")
	{
		document.getElementById("seluserbu").disabled = true;
	}
	else
	{
		document.getElementById("seluserbu").disabled = false;
	}
}

function openMultipleBUModal(id)
{
	$("#tblmultiplebubody").load("getinfo.php?type=multiplebu&id=" + id);
	document.getElementById("multiplebuid").value = id;
	$( "#addmultiplebudiv" ).dialog( "open" );
}

function addmultipleburow()
{
	$( "#tblmultiplebu tbody" ).append( "<tr align='center'>" +
		  "<td class='rowmultiplebu' style='display:none;'>" + document.getElementById("selmultiplebu").value + "</td>" +
		  "<td>" + $("#selmultiplebu option:selected").text() + "</td>" +          
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
}

function savemultipleburow()
{
	var x = document.getElementsByClassName("rowmultiplebu");
	var i;
	for (i = 0; i < x.length; i++) {
		document.getElementById("multiplebuall").value += "*~" + x[i].innerHTML;		
	}
	if((document.getElementById("multiplebuall").value))
	{		
		document.getElementById("addmultiplebuform").submit();
	}
	else
	{
		alert("No BUs to add.");
	}
}

function closeMultipleBUModal()
{
	$( "#addmultiplebudiv" ).dialog( "close" );
}

function changeBU()
{
	if( document.getElementById("changebusel").value)
	{
		var buid = document.getElementById("changebusel").value;
		window.location.href = "change_bu.php?buid=" + buid;
	}
}

function addAgency()
{
	document.getElementById("btnsaveagency").style.display = "initial";
	
	$("#secagencymodal").dialog("open");
}

function viewAgency(id, aname, aaddress, aoic, acontact, alicensenum, alicenseissue, alicenseexpiry, acprofile, acontractstat)
{
	
	document.getElementById("txtagencyname").innerHTML = aname;
	document.getElementById("txtagencyaddress").innerHTML = aaddress;
	document.getElementById("txtagencyoic").innerHTML = aoic;
	document.getElementById("txtagencycontact").innerHTML = acontact;
	document.getElementById("txtagencylicensenum").innerHTML = alicensenum;
	document.getElementById("txtagencylicenseissue").innerHTML = alicenseissue;
	document.getElementById("txtagencylicenseexpiry").innerHTML = alicenseexpiry;
	document.getElementById("txtagencyprofile").innerHTML = acprofile.replace(/<br><br>/gi, "\n");
	document.getElementById("selcontractstat").innerHTML = acontractstat;
	document.getElementById("txtagencyid").value = id;
	$("#tblagencybutbody").load("getinfo.php?type=agencybu&id=" + id);
	$("#tblagencyclienttbody").load("getinfo.php?type=agencyclient&id=" + id);
	$("#tblagencyremarkstbody").load("getinfo.php?type=agencyremarks&id=" + id);
	$("#tblagencylicensestbody").load("getinfo.php?type=secagencylicenses&id=" + id);
	$("#secagencymodal").dialog("open");
}

function viewAgencySA(id, aname, aaddress, aoic, acontact, alicensenum, alicenseissue, alicenseexpiry, acprofile, acontractstat)
{
	document.getElementById("btnupdateagency").style.display = "initial";
	document.getElementById("txtagencyname").value = aname;
	document.getElementById("txtagencyaddress").value = aaddress;
	document.getElementById("txtagencyoic").value = aoic;
	document.getElementById("txtagencycontact").value = acontact;
	document.getElementById("txtagencylicensenum").value = alicensenum;
	document.getElementById("txtagencylicenseissue").value = alicenseissue;
	document.getElementById("txtagencylicenseexpiry").value = alicenseexpiry;
	document.getElementById("txtagencyprofile").value = acprofile.replace(/<br><br>/gi, "\n");
	document.getElementById("selcontractstat").value = acontractstat;
	document.getElementById("txtagencyid").value = id;
	document.getElementById("txtagencyaddedit").value = "edit";
	$("#tblagencybutbody").load("getinfo.php?type=agencybu&id=" + id);
	$("#tblagencyclienttbody").load("getinfo.php?type=agencyclient&id=" + id);
	$("#tblagencyremarkstbody").load("getinfo.php?type=agencyremarks&id=" + id);
	$("#tblagencylicensestbody").load("getinfo.php?type=secagencylicenses&id=" + id);
	$("#secagencymodal").dialog("open");
}

function closeSecAgency()
{
	//document.getElementById("secagencyform").reset();
	$("#secagencymodal").dialog("close");
}

function closeSecAgencySA()
{
	document.getElementById("btnsaveagency").style.display = "none";
	document.getElementById("btnupdateagency").style.display = "none";
	document.getElementById("secagencyform").reset();
	document.getElementById("tblagencybutbody").innerHTML = "";
	document.getElementById("tblagencyclienttbody").innerHTML = "";
	document.getElementById("tblagencyremarkstbody").innerHTML = "";
	document.getElementById("txtagencyaddedit").value = "";
	$("#secagencymodal").dialog("close");
}

function addAgencyRelated()
{
	var bux = document.getElementsByClassName('rowsecagencybu');
	var bux2 = document.getElementsByClassName('rowsecagencybustart');
	var bux3 = document.getElementsByClassName('rowsecagencybuend');
	var clientx = document.getElementsByClassName('rowsecagencyclient');
	var clientx2 = document.getElementsByClassName('rowsecagencyclientstart');
	var clientx3 = document.getElementsByClassName('rowsecagencyclientend');
	var remarkx = document.getElementsByClassName('rowsecagencyremarkdate');
	var remarkx2 = document.getElementsByClassName('rowsecagencyremark');
	var licensx = document.getElementsByClassName('rowsecagencylicensetype');
	var licensx2 = document.getElementsByClassName('rowsecagencylicensenumber');
	var licensx3 = document.getElementsByClassName('rowsecagencylicensestart');
	var licensx4 = document.getElementsByClassName('rowsecagencylicenseend');
	var i;
	for (i = 0; i < bux.length; i++) {
		document.getElementById("txtagencybunameall").value += "*~" + bux[i].innerHTML;
		document.getElementById("txtagencybustartall").value += "*~" + bux2[i].innerHTML;
		document.getElementById("txtagencybuendall").value += "*~" + bux3[i].innerHTML;
	}
	for (i = 0; i < clientx.length; i++) {
		document.getElementById("txtagencyclientall").value += "*~" + clientx[i].innerHTML;
		document.getElementById("txtagencyclientstartall").value += "*~" + clientx2[i].innerHTML;
		document.getElementById("txtagencyclientendall").value += "*~" + clientx3[i].innerHTML;
	}	
	for (i = 0; i < remarkx.length; i++) {
		document.getElementById("txtagencyremarkdateall").value += "*~" + remarkx[i].innerHTML;
		document.getElementById("txtagencyremarkall").value += "*~" + remarkx2[i].innerHTML;
	}
	for (i = 0; i < licensx.length; i++) {
		document.getElementById("txtagencylicensetypeall").value += "*~" + licensx[i].innerHTML;
		document.getElementById("txtagencylicensenumall").value += "*~" + licensx2[i].innerHTML;
		document.getElementById("txtagencylicensestartall").value += "*~" + licensx3[i].innerHTML;
		document.getElementById("txtagencylicenseendall").value += "*~" + licensx4[i].innerHTML;
	}
}

function saveSecAgency()
{
	if((document.getElementById("txtagencyname").value) && (document.getElementById("txtagencyaddress").value) && (document.getElementById("txtagencyoic").value) && (document.getElementById("txtagencylicensenum").value) && (document.getElementById("txtagencylicenseissue").value) && (document.getElementById("txtagencylicenseexpiry").value) && (document.getElementById("txtagencyprofile").value) && (document.getElementById("selcontractstat").value))
	{
		addAgencyRelated();
		document.getElementById("secagencyform").submit();
	}
	else
	{
		alert("Incomplete information.");
	}
}

function openPDFadd(id, type)
{
	if(type == 2)
	{
		$("#addPDFmodal").load("getinfo.php?type=addAgencyBU&id=" + id + "&id2=" + type);
		$( "#addPDFmodal" ).dialog("open");
	}
	else if(type == 1)
	{
		$("#addPDFmodal").load("getinfo.php?type=addAgencyLicense&id=" + id + "&id2=" + type);
		$( "#addPDFmodal" ).dialog("open");
	}
	else
	{
		$("#addPDFmodal").load("getinfo.php?type=addAgencyDefault&id=" + id + "&id2=" + type);
		$( "#addPDFmodal" ).dialog("open");
		/* document.getElementById("addpdfid").value = id;
		document.getElementById("addpdftype").value = type; */
	}	
}

function closePDFadd()
{
	$( "#addPDFmodal" ).dialog("close");	
	document.getElementById("addPDFform").reset();
}

function addSAlicenserow()
{
	if((document.getElementById("txtagencylicensetype").value) && (document.getElementById("txtagencylicensenumber").value) && (document.getElementById("txtagencylicensestart").value) && (document.getElementById("txtagencylicenseend").value))
	{
		$( "#tblagencylicenses tbody" ).append( "<tr align='center'>" +
          "<td class='rowsecagencylicensetype'>" + document.getElementById("txtagencylicensetype").value + "</td>" +
		  "<td class='rowsecagencylicensenumber'>" + document.getElementById("txtagencylicensenumber").value + "</td>" +		  
          "<td class='rowsecagencylicensestart'>" + document.getElementById("txtagencylicensestart").value + "</td>" +
		  "<td class='rowsecagencylicenseend'>" + document.getElementById("txtagencylicenseend").value + "</td>" +		  
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
		document.getElementById("txtagencylicensetype").value = "";
		document.getElementById("txtagencylicensenumber").value = "";
		document.getElementById("txtagencylicensestart").value = "";
		document.getElementById("txtagencylicenseend").value = "";
	}
}

function addSAburow()
{
	if((document.getElementById("txtagencybuname").value) && (document.getElementById("txtagencybustart").value) && (document.getElementById("txtagencybuend").value))
	{
		$( "#tblagencybu tbody" ).append( "<tr align='center'>" +
          "<td class='rowsecagencybu' style='display:none;'>" + document.getElementById("txtagencybuname").value + "</td>" +
		  "<td>" + $("#txtagencybuname option:selected").text() + "</td>" +
          "<td class='rowsecagencybustart'>" + document.getElementById("txtagencybustart").value + "</td>" +
		  "<td class='rowsecagencybuend'>" + document.getElementById("txtagencybuend").value + "</td>" +
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
		document.getElementById("txtagencybuname").value = "";
		document.getElementById("txtagencybustart").value = "";
		document.getElementById("txtagencybuend").value = "";
	}
}

function addSAclientrow()
{
	if((document.getElementById("txtagencyclient").value) && (document.getElementById("txtagencyclientstart").value) && (document.getElementById("txtagencyclientend").value))
	{
		$( "#tblagencyclient tbody" ).append( "<tr align='center'>" +
          "<td class='rowsecagencyclient'>" + document.getElementById("txtagencyclient").value + "</td>" +		  
          "<td class='rowsecagencyclientstart'>" + document.getElementById("txtagencyclientstart").value + "</td>" +
		  "<td class='rowsecagencyclientend'>" + document.getElementById("txtagencyclientend").value + "</td>" +
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
	}
}

function addSAremarksrow()
{
	if((document.getElementById("txtagencyremarkdate").value) && (document.getElementById("txtagencyremark").value))
	{
		$( "#tblagencyremarks tbody" ).append( "<tr align='center'>" +
          "<td class='rowsecagencyremarkdate'>" + document.getElementById("txtagencyremarkdate").value + "</td>" +		  
          "<td class='rowsecagencyremark'>" + document.getElementById("txtagencyremark").value + "</td>" +		  
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
	}
}

function addAgencyRemarks()
{
	if((document.getElementById("txtagencyremarkdate").value) && (document.getElementById("txtagencyremark").value))
	{
		var answer = confirm("Remarks are visible to all BU heads. For remark deletion, please contact the Admin.");
		
		if (answer != 0)
		{
			document.getElementById('frmAddAgencyRemarks').submit();
		}
	}
}

function addInvolved()
{
	var tablename = "";
	var keys = "";
	if((document.getElementById("witfname").value) && (document.getElementById("witlname").value))
	{
		if(document.getElementById("witness").checked == true)
		{
			tablename = "#tblwitness tbody";
			keys = "w";
			document.getElementById("tblwitness").style.display = "table";
		}
		else if(document.getElementById("suspect").checked == true)
		{
			tablename = "#tblsuspect tbody";
			keys = "s";
			document.getElementById("tblsuspect").style.display = "table";
		}
		else if(document.getElementById("victim").checked == true)
		{
			tablename = "#tblvictim tbody";
			keys = "v"
			document.getElementById("tblvictim").style.display = "table";
		}
		$(tablename).append("<tr align='center'>" +
          "<td class='i" + keys + "fnames'>" + document.getElementById("witfname").value + "</td>" +
          "<td class='i" + keys + "mnames'>" + document.getElementById("witmname").value + "</td>" +
		  "<td class='i" + keys + "lnames'>" + document.getElementById("witlname").value + "</td>" +
		  "<td class='i" + keys + "address'>" + document.getElementById("witadd").value + "</td>" +
		  "<td class='i" + keys + "contacts'>" + document.getElementById("witcontact").value + "</td>" +
		  "<td class='i" + keys + "age'>" + document.getElementById("witage").value + "</td>" +
		  "<td class='i" + keys + "gender'>" + document.getElementById("witgender").value + "</td>" +
		  "<td class='i" + keys + "height'>" + document.getElementById("witheight").value + "</td>" +
		  "<td class='i" + keys + "weight'>" + document.getElementById("witweight").value + "</td>" +
		  "<td class='i" + keys + "idtype'>" + document.getElementById("witidtype").value + "</td>" +
		  "<td class='i" + keys + "idnumber'>" + document.getElementById("witidnumber").value + "</td>" +
		  "<td class='i" + keys + "remarks'>" + document.getElementById("witremarks").value + "</td>" +
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>");
		var x = document.getElementsByClassName('involvedrows');
		var i;
		for (i = 0; i < x.length; i++) {
			x[i].value = "";
		}
	}
}

function addInvolved2()
{
	var tablename = "";
	var keys = "";
	
	
	if((document.getElementById("witfname").value) && (document.getElementById("witlname").value) && (document.getElementById("selClassification").value))
	{
		document.getElementById("tblinvolved").style.display = "table";
		$("#tblinvolved tbody").append("<tr align='center'>" +
		  "<td class='iclassifications'>" + document.getElementById("selClassification").value + "</td>" +
          "<td class='ifnames'>" + document.getElementById("witfname").value + "</td>" +
          "<td class='imnames'>" + document.getElementById("witmname").value + "</td>" +
		  "<td class='ilnames'>" + document.getElementById("witlname").value + "</td>" +
		  ((document.getElementById("selinclocator")) ? ("<td class='ilocators' style='display:none;'>" + document.getElementById("selinclocator").value + "</td>" +
		  "<td>" + $("#selinclocator option:selected").text() + "</td>") : "") +
		  "<td class='iaddress'>" + document.getElementById("witadd").value + "</td>" +
		  "<td class='icontacts'>" + document.getElementById("witcontact").value + "</td>" +
		  "<td class='iage'>" + document.getElementById("witage").value + "</td>" +
		  "<td class='igender'>" + document.getElementById("witgender").value + "</td>" +
		  "<td class='iheight'>" + document.getElementById("witheight").value + "</td>" +
		  "<td class='iweight'>" + document.getElementById("witweight").value + "</td>" +
		  "<td class='iidtype'>" + document.getElementById("witidtype").value + "</td>" +
		  "<td class='iidnumber'>" + document.getElementById("witidnumber").value + "</td>" +
		  "<td class='iremarks'>" + document.getElementById("witremarks").value + "</td>" +
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>");
		var x = document.getElementsByClassName('involvedrows');
		var i;
		for (i = 0; i < x.length; i++) {
			x[i].value = "";
		}
	}
	else
	{
		alert("Classification, First Name, and Last Name required.");
	}
}

function addVehicle()
{
	var tablename = "";
	var keys = "";
	if(document.getElementById("txtvplateno").value)
	{
		// if(document.getElementById("witness").checked == true)
		// {
			// tablename = "#tblwitness tbody";
			// keys = "w";
			// document.getElementById("tblwitness").style.display = "table";
		// }
		// else if(document.getElementById("suspect").checked == true)
		// {
			// tablename = "#tblsuspect tbody";
			// keys = "s";
			// document.getElementById("tblsuspect").style.display = "table";
		// }
		// else if(document.getElementById("victim").checked == true)
		// {
			// tablename = "#tblvictim tbody";
			// keys = "v"
			// document.getElementById("tblvictim").style.display = "table";
		// }
		document.getElementById("tblvehicle").style.display = "table";
		$("#tblvehicle tbody").append("<tr align='center'>" +
          "<td class='vOwner'>" + document.getElementById("txtvowner").value + "</td>" +
          "<td class='vPlateNum'>" + document.getElementById("txtvplateno").value + "</td>" +
		  "<td class='vType'>" + document.getElementById("selvtype").value + "</td>" +
		  "<td class='vMake'>" + document.getElementById("txtvmake").value + "</td>" +
		  "<td class='vModel'>" + document.getElementById("txtvmodel").value + "</td>" +
		  "<td class='vColor'>" + document.getElementById("txtvcolor").value + "</td>" +
		  "<td class='vRemarks'>" + document.getElementById("txtvremarks").value + "</td>" +		  
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>");
		var x = document.getElementsByClassName('fieldsVehicle');
		var i;
		for (i = 0; i < x.length; i++) {
			x[i].value = "";
		}
	}
}

function closeCloseIncident()
{
	document.getElementById("closeincidentform").reset();
	document.getElementById("involvedsection").style.display = "initial";
	document.getElementById("otherdetails").style.display = "none";
	document.getElementById("divDisposition").style.display = "none";
	document.getElementById("tblwitness").style.display = "none";
	document.getElementById("tblsuspect").style.display = "none";
	document.getElementById("tblvictim").style.display = "none";
	document.getElementById("tblvehicle").style.display = "none";
	document.getElementById("tblwitnesstbody").innerHTML = "";
	document.getElementById("tblsuspectbody").innerHTML = "";
	document.getElementById("tblvictimtbody").innerHTML = "";
	document.getElementById("tblvehicletbody").innerHTML = "";
	$("#closeincidentmodal").dialog("close");
}

function showNext()
{
	if(document.getElementById("involvedsection").style.display != "none")
	{
		document.getElementById("involvedsection").style.display = "none";
		document.getElementById("otherdetails").style.display = "initial";
		checkOtherDetails();
	}
	else if(document.getElementById("otherdetails").style.display != "none")
	{
		document.getElementById("otherdetails").style.display = "none";
		document.getElementById("divDisposition").style.display = "initial";
		document.getElementById("txtIncidentDisposition").focus();
	}
}

function showPrev()
{
	if(document.getElementById("otherdetails").style.display != "none")
	{
		document.getElementById("involvedsection").style.display = "initial";
		document.getElementById("otherdetails").style.display = "none";
	}
	else if(document.getElementById("divDisposition").style.display != "none")
	{
		document.getElementById("otherdetails").style.display = "initial";
		document.getElementById("divDisposition").style.display = "none";
	}
}

function saveCloseIncident()
{
	if(document.getElementById("txtIncidentDisposition").value)
	{
		/* var w = document.getElementsByClassName('iwfnames');
		var w2 = document.getElementsByClassName('iwmnames');
		var w3 = document.getElementsByClassName('iwlnames');
		var w4 = document.getElementsByClassName('iwaddress');
		var w5 = document.getElementsByClassName('iwcontacts');
		var w6 = document.getElementsByClassName('iwage');
		var w7 = document.getElementsByClassName('iwgender');
		var w8 = document.getElementsByClassName('iwheight');
		var w9 = document.getElementsByClassName('iwweight');
		var w10 = document.getElementsByClassName('iwremarks');
		var w11 = document.getElementsByClassName('iwidtype');
		var w12 = document.getElementsByClassName('iwidnumber');
		
		var i;
		for (i = 0; i < w.length; i++) {
			document.getElementById("iwfnamesall").value += "*~" + w[i].innerHTML;
			document.getElementById("iwmnamesall").value += "*~" + w2[i].innerHTML;
			document.getElementById("iwlnamesall").value += "*~" + w3[i].innerHTML;
			document.getElementById("iwaddressall").value += "*~" + w4[i].innerHTML;
			document.getElementById("iwcontactsall").value += "*~" + w5[i].innerHTML;
			document.getElementById("iwageall").value += "*~" + w6[i].innerHTML;
			document.getElementById("iwgenderall").value += "*~" + w7[i].innerHTML;
			document.getElementById("iwheightall").value += "*~" + w8[i].innerHTML;
			document.getElementById("iwweightall").value += "*~" + w9[i].innerHTML;
			document.getElementById("iwremarksall").value += "*~" + w10[i].innerHTML;
			document.getElementById("iwidtypeall").value += "*~" + w11[i].innerHTML;
			document.getElementById("iwidnumberall").value += "*~" + w12[i].innerHTML;
		}
		
		var s = document.getElementsByClassName('isfnames');
		var s2 = document.getElementsByClassName('ismnames');
		var s3 = document.getElementsByClassName('islnames');
		var s4 = document.getElementsByClassName('isaddress');
		var s5 = document.getElementsByClassName('iscontacts');
		var s6 = document.getElementsByClassName('isage');
		var s7 = document.getElementsByClassName('isgender');
		var s8 = document.getElementsByClassName('isheight');
		var s9 = document.getElementsByClassName('isweight');
		var s10 = document.getElementsByClassName('isremarks');
		var s11 = document.getElementsByClassName('isidtype');
		var s12 = document.getElementsByClassName('isidnumber');
		var i2;
		for (i2 = 0; i2 < s.length; i2++) {
			document.getElementById("isfnamesall").value += "*~" + s[i2].innerHTML;
			document.getElementById("ismnamesall").value += "*~" + s2[i2].innerHTML;
			document.getElementById("islnamesall").value += "*~" + s3[i2].innerHTML;
			document.getElementById("isaddressall").value += "*~" + s4[i2].innerHTML;
			document.getElementById("iscontactsall").value += "*~" + s5[i2].innerHTML;
			document.getElementById("isageall").value += "*~" + s6[i2].innerHTML;
			document.getElementById("isgenderall").value += "*~" + s7[i2].innerHTML;
			document.getElementById("isheightall").value += "*~" + s8[i2].innerHTML;
			document.getElementById("isweightall").value += "*~" + s9[i2].innerHTML;
			document.getElementById("isremarksall").value += "*~" + s10[i2].innerHTML;
			document.getElementById("isidtypeall").value += "*~" + s11[i2].innerHTML;
			document.getElementById("isidnumberall").value += "*~" + s12[i2].innerHTML;
		}
		var v = document.getElementsByClassName('ivfnames');
		var v2 = document.getElementsByClassName('ivmnames');
		var v3 = document.getElementsByClassName('ivlnames');
		var v4 = document.getElementsByClassName('ivaddress');
		var v5 = document.getElementsByClassName('ivcontacts');
		var v6 = document.getElementsByClassName('ivage');
		var v7 = document.getElementsByClassName('ivgender');
		var v8 = document.getElementsByClassName('ivheight');
		var v9 = document.getElementsByClassName('ivweight');
		var v10 = document.getElementsByClassName('ivremarks');
		var v11 = document.getElementsByClassName('ividtype');
		var v12 = document.getElementsByClassName('ividnumber');
		var i3;
		for (i3 = 0; i3 < v.length; i3++) {
			document.getElementById("ivfnamesall").value += "*~" + v[i3].innerHTML;
			document.getElementById("ivmnamesall").value += "*~" + v2[i3].innerHTML;
			document.getElementById("ivlnamesall").value += "*~" + v3[i3].innerHTML;
			document.getElementById("ivaddressall").value += "*~" + v4[i3].innerHTML;
			document.getElementById("ivcontactsall").value += "*~" + v5[i3].innerHTML;
			document.getElementById("ivageall").value += "*~" + v6[i3].innerHTML;
			document.getElementById("ivgenderall").value += "*~" + v7[i3].innerHTML;
			document.getElementById("ivheightall").value += "*~" + v8[i3].innerHTML;
			document.getElementById("ivweightall").value += "*~" + v9[i3].innerHTML;
			document.getElementById("ivremarksall").value += "*~" + v10[i3].innerHTML;
			document.getElementById("ividtypeall").value += "*~" + v11[i3].innerHTML;
			document.getElementById("ividnumberall").value += "*~" + v12[i3].innerHTML;
		} */
		var iclassifications = document.getElementsByClassName('iclassifications');
		var ifnames = document.getElementsByClassName('ifnames');
		var imnames = document.getElementsByClassName('imnames');
		var ilnames = document.getElementsByClassName('ilnames');
		var iaddress = document.getElementsByClassName('iaddress');
		var icontacts = document.getElementsByClassName('icontacts');
		var iage = document.getElementsByClassName('iage');
		var igender = document.getElementsByClassName('igender');
		var iheight = document.getElementsByClassName('iheight');
		var iweight = document.getElementsByClassName('iweight');
		var iremarks = document.getElementsByClassName('iremarks');
		var iidtype = document.getElementsByClassName('iidtype');
		var iidnumber = document.getElementsByClassName('iidnumber');
//		if(document.getElementsByClassName('ilocators'))
//		{
//			var ilocator = document.getElementsByClassName('ilocators');
//		} 
//		var ilocator = document.getElementsByClassName('ilocators');
		var i4;
		for (i4 = 0; i4 < iclassifications.length; i4++) {
			document.getElementById("iclassificationsall").value += "*~" + iclassifications[i4].innerHTML;
			document.getElementById("ifnamesall").value += "*~" + ifnames[i4].innerHTML;
			document.getElementById("imnamesall").value += "*~" + imnames[i4].innerHTML;			
			document.getElementById("ilnamesall").value += "*~" + ilnames[i4].innerHTML;
			document.getElementById("iaddressall").value += "*~" + iaddress[i4].innerHTML;
			document.getElementById("icontactsall").value += "*~" + icontacts[i4].innerHTML;
			document.getElementById("iageall").value += "*~" + iage[i4].innerHTML;
			document.getElementById("igenderall").value += "*~" + igender[i4].innerHTML;
			document.getElementById("iheightall").value += "*~" + iheight[i4].innerHTML;
			document.getElementById("iweightall").value += "*~" + iweight[i4].innerHTML;
			document.getElementById("iremarksall").value += "*~" + iremarks[i4].innerHTML;
			document.getElementById("iidtypeall").value += "*~" + iidnumber[i4].innerHTML;
			document.getElementById("iidnumberall").value += "*~" + iidtype[i4].innerHTML;
			/* if(ilocator)
			{
				document.getElementById("ilocatorsall").value += "*~" + ilocator[i4].innerHTML;
			} */
//			document.getElementById("ilocatorsall").value += "*~" + ilocator[i4].innerHTML;
		}
		
		
		
		var vOwner = document.getElementsByClassName('vOwner');
		var vPlateNum = document.getElementsByClassName('vPlateNum');
		var vType = document.getElementsByClassName('vType');
		var vMake = document.getElementsByClassName('vMake');
		var vModel = document.getElementsByClassName('vModel');
		var vColor = document.getElementsByClassName('vColor');
		var vRemarks = document.getElementsByClassName('vRemarks');
		
		
		
		var i4;
		for (i4 = 0; i4< vPlateNum.length; i4++) {
			document.getElementById("vOwnerAll").value += "*~" + vOwner[i4].innerHTML;
			document.getElementById("vPlateNoAll").value += "*~" + vPlateNum[i4].innerHTML;
			document.getElementById("vTypeAll").value += "*~" + vType[i4].innerHTML;
			document.getElementById("vMakeAll").value += "*~" + vMake[i4].innerHTML;
			document.getElementById("vModelAll").value += "*~" + vModel[i4].innerHTML;
			document.getElementById("vColorAll").value += "*~" + vColor[i4].innerHTML;
			document.getElementById("vRemarksAll").value += "*~" + vRemarks[i4].innerHTML;			
		}
		
		// if(document.getElementById("chkboxVehicle").checked == true)
		// {
			// document.getElementById("checkVehicle").value = "Vehicle";
		// }
		if(document.getElementById("chkboxDamage").checked == true)
		{
			document.getElementById("checkDamage").value = "Damage";
		}
		if(document.getElementById("chkboxCounterfeit").checked == true)
		{
			document.getElementById("checkCF").value = "CF";
		}
		document.getElementById("closeincidentform").submit();		
	}
	else
	{
		alert("Disposition is  required.");
	}
}


function checkOtherDetails()
{
	if(document.getElementById("chkboxCounterfeit").checked == true)
	{
		$(".fieldsCounterfeit").prop("disabled", false);
		document.getElementById("checkCF").value = "CF";
	}
	else if(document.getElementById("chkboxCounterfeit").checked == false)
	{
		$(".fieldsCounterfeit").prop("disabled", true);
		$(".fieldsCounterfeit").val(function() {
        	return this.defaultValue;
    	});
		document.getElementById("checkCF").value = "";
	}
	
	if(document.getElementById("chkboxVehicle").checked == true)
	{
		$(".fieldsVehicle").prop("disabled", false);
	}
	else if(document.getElementById("chkboxVehicle").checked == false)
	{
		$(".fieldsVehicle").prop("disabled", true);
		$(".fieldsVehicle").val(function() {
        	return this.defaultValue;
    	});
	}
	
	if(document.getElementById("chkboxDamage").checked == true)
	{
		$(".fieldsDamage").prop("disabled", false);
	}
	else if(document.getElementById("chkboxDamage").checked == false)
	{
		$(".fieldsDamage").prop("disabled", true);
		$(".fieldsDamage").val(function() {
        	return this.defaultValue;
    	});
	}
}

function toggleSearch(divname)
{
	if(document.getElementById(divname).style.display == 'none')
	{
		//document.getElementById(divname).style.display = "initial";
		$('#' + divname).show();
		if(divname == "divSearchCodes")
		{
			$('#divCodeDisplay').hide();
			$('#divSearchCodeDisplay').show();
		}
		else if(divname == "divSearchUsers")
		{
			$('#divUsersDisplay').hide();
			$('#divUserDisplaySearch').show();
		}
		else if(divname == "divSearchAgency")
		{
			$('#divAgencyDisplay').hide();
			$('#divSecAgencySearch').show();
		}
	}
	else if(document.getElementById(divname).style.display != 'none')
	{
//		document.getElementById(divname).style.display = "none";
		$('#' + divname).hide();
		if(divname == "divSearchCodes")
		{
			$('#divCodeDisplay').show();
			$('#divSearchCodeDisplay').hide();
		}
		else if(divname == "divSearchUsers")
		{
			$('#divUsersDisplay').show();
			$('#divUserDisplaySearch').hide();
		}
		else if(divname == "divSearchAgency")
		{
			$('#divAgencyDisplay').show();
			$('#divSecAgencySearch').hide();
		}
	}
	
}

function searchItem(term, category, group)
{
	if(group == "guard_personnel")
	{
	  if((term) && (document.getElementById("txtSearchGuard").style.display != "none"))
	  {
		  $("#tbodyGuards").load("searchitem.php?term=" + encodeURIComponent(term) + "&category=" + category + "&group=" + group);
	  }
	  else if((document.getElementById("selSearchGuardBu")) && (document.getElementById("selSearchGuardBu").value) && (category == "bu"))
	  {
		  term = document.getElementById("selSearchGuardBu").value;
		  $("#tbodyGuards").load("searchitem.php?term=" + encodeURI(term) + "&category=" + category + "&group=" + group);
	  }
	  else if((document.getElementById("selSearchGuardAgency").value) && (category == "agency"))
	  {
		  term = document.getElementById("selSearchGuardAgency").value;
		  $("#tbodyGuards").load("searchitem.php?term=" + encodeURI(term) + "&category=" + category + "&group=" + group);
	  }
	  else
	  {
		  alert("Incomplete search data");
	  }	  
	}
	else if(group == "agency_mst")
	{
	  if((term) && (document.getElementById("txtSearchAgency").style.display != "none"))
	  {
		  $("#tbodySecAgency").load("searchitem.php?term=" + encodeURI(term) + "&category=" + category + "&group=" + group);
	  }
	  else if((document.getElementById("selSearchAgencyBu").value) && (category == "bu"))
	  {
		  term = document.getElementById("selSearchAgencyBu").value;
		  $("#tbodySecAgency").load("searchitem.php?term=" + encodeURI(term) + "&category=" + category + "&group=" + group);
	  }
	  else
	  {
		  alert("Incomplete search data");
	  }
	}
	else if(group == "urc_mst")
	{
		if(term)
		{
			$("#tbodyCodes").load("searchitem.php?term=" + encodeURI(term) + "&group=" + group);
		}
		else
		{
			alert("Incomplete search data");
		}
	}
	else if(group == "location_mst")
	{
		if((term) && (document.getElementById("txtSearchLocs").style.display != "none"))
		{
			$("#tbodyLocs").load("searchitem.php?term=" + encodeURI(term) + "&category=" + category + "&group=" + group);
		}
		else if((document.getElementById("selSearchLocsBu").value) && (category == "bu"))
		{
			term = document.getElementById("selSearchLocsBu").value;
			$("#tbodyLocs").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else
		{
			alert("Incomplete search data");
		}
	}
	else if(group == "bu_mst")
	{
		if((term) && (document.getElementById("txtSearchBUs").style.display != "none"))
		{
			$("#tbodyBUs").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else if((document.getElementById("selSearchBUGroup").value) && (category == "main_group"))
		{
			term = document.getElementById("selSearchBUGroup").value;
			$("#tbodyBUs").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else if((document.getElementById("selSearchBURegion").value) && (category == "regional_group"))
		{
			term = document.getElementById("selSearchBURegion").value;
			$("#tbodyBUs").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else
		{
			alert("Incomplete search data");
		}
	}
	else if(group == "users_mst")
	{
		if((term) && (document.getElementById("txtSearchUsers").style.display != "none"))
		{
			$("#tbodyUsers").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else if((document.getElementById("selSearchUsersLevel").value) && (category == "level"))
		{
			term = document.getElementById("selSearchUsersLevel").value;
			$("#tbodyUsers").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else if((document.getElementById("selSearchUsersBU").value) && (category == "bu"))
		{
			term = document.getElementById("selSearchUsersBU").value;
			$("#tbodyUsers").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else if((document.getElementById("selSearchUsersGender").value) && (category == "gender"))
		{
			term = document.getElementById("selSearchUsersGender").value;
			$("#tbodyUsers").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else
		{
			alert("Incomplete search data");
		}
	}
	else if(group == "oic_mst")
	{
		if((term) && (document.getElementById("txtSearchSecAlertRecipients").style.display != "none"))
		{
			$("#tbodySecAlert").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else if((document.getElementById("selSecAlertRecipientsBu")) && (document.getElementById("selSecAlertRecipientsBu").value) && (category == "bu"))
		{
			term = document.getElementById("selSecAlertRecipientsBu").value;
			$("#tbodySecAlert").load("searchitem.php?term=" + term + "&category=" + category + "&group=" + group);
		}
		else
		{
			alert("Incomplete search data");
		}
	}
	else if(group == "cc_mst")
	{
		if(term == "contract")
		{
			$("#tbodyCC").load("searchitem.php?ccyear=" + document.getElementById('txtCCYear2').value + "&ccmonth=" + document.getElementById('selCCMonth2').value + "&group=" + group + "&ccbu=" + document.getElementById('selCCBU2').value + "&ccsecagency=" + document.getElementById('selCCSecAgency2').value);
		}
		else
		{
			
		}
	}
	else if(group == "contract_compliance")
	{
		$("#tblShowCCtbody").load("searchitem.php?term=" + term + "&group=" + group);
	}
	else if(group == "ConCompAdmin")
	{
		$("#ConCompDisplay").empty();
		$("#ConCompDisplay").load("cc-general.php?ccyear=" + document.getElementById("txtCCAdminYear").value + "&ccmonth=" + term + "&cctext=" + category);
		var check = function(){
			if(document.getElementById("tdTotalRegScoreHolder")){
				if(document.getElementById("txtCCAdminYear").value >= 2019)
				{
					getScore4();
					getScore6();
				}
				// run when condition is met
			}
			else {
				setTimeout(check, 1000); // check again in a second
			}
		}

		check();
		
		
	}
	else
	{
		alert("Incomplete search data");
	}
}

function getScore(deduction, score)
{
	if(document.getElementById("numActualHolder"+score).value)
	{
		
	}
	else
	{
		document.getElementById("numActualHolder"+score).value = 0;
	}
	document.getElementById("tdScoreHolder"+score).innerHTML = deduction * document.getElementById("numActualHolder"+score).value;
	var x = document.getElementsByClassName("ccScoreHolders");
	var actualtotalscore = 0;
	for(i = 0; i < x.length; i++)
	{
		actualtotalscore = actualtotalscore + parseInt(x[i].innerHTML);
	}
	var totalscore = 100 - actualtotalscore;
	document.getElementById("tdTotalScoreHolder").innerHTML = totalscore;
	if(totalscore == 100)
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'blue';
	}
	else if((totalscore < 100) && (totalscore > 75))
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'green';
	}
	else if((totalscore <= 75) && (totalscore > 70))
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'orange';
	}
	else if(totalscore <= 70)
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'red';
	}
}

function getScore2()
{
	var boxreg = document.getElementsByClassName("chkboxRegulatory");
	var boxprof = document.getElementsByClassName("chkboxProficiency");
	var boxnone = document.getElementsByClassName("chkboxNone");
	var numdeduct = document.getElementsByClassName("ccDeductionHolders");
	var regscore = 0;
	var profscore = 0;
	var nonescore = 0;
	var deductscore = 0;
	for(i = 0; i < boxreg.length; i++)
	{
		if(boxreg[i].checked == true)
		{
			regscore += parseInt(boxreg[i].value);
		}
	}
	for(i = 0; i < boxprof.length; i++)
	{
		if(boxprof[i].checked == true)
		{
			profscore += parseInt(boxprof[i].value);
		}
	}
	for(i = 0; i < boxnone.length; i++)
	{
		if(boxnone[i].checked == true)
		{
			nonescore += parseInt(boxnone[i].value);
		}
	}
	for(i = 0; i < numdeduct.length; i++)
	{
		if(numdeduct[i].value)
		{
			deductscore += parseInt(numdeduct[i].value);
		}
	}
	if(regscore >= 40)
	{
		regscore = 40;
	}
	if(profscore >= 25)
	{
		profscore = 25;
	}
	var deductions = (parseInt(regscore) + parseInt(profscore) + parseInt(nonescore) + parseInt(deductscore));
	var totalscore = 100 - parseInt(deductions);
	document.getElementById("tdTotalScoreHolder").innerHTML = totalscore;
	if(totalscore == 100)
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'blue';
	}
	else if((totalscore < 100) && (totalscore > 75))
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'green';
	}
	else if((totalscore <= 75) && (totalscore > 70))
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'orange';
	}
	else if(totalscore <= 70)
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'red';
	}
}

function getScore3(name, deduction)
{
	document.getElementById("txtDeductionHolder"+name).value = deduction * document.getElementById("numActualHolder"+name).value;
	getScore2();
}

function getScore4()
{
	var boxreg = document.getElementsByClassName("chkboxRegulatory");
	var regscore = 0;
	for(i = 0; i < boxreg.length; i++)
	{
		if(boxreg[i].checked == true)
		{
//			regscore += parseInt(boxreg[i].value);
			tempscore = parseInt(boxreg[i].value);
			if(regscore < tempscore)
			{
				regscore = tempscore;
			}
		}
	}
	
	if(regscore > 0)
	{
		document.getElementById("tdTotalRegScoreHolder").innerHTML = "NC";
		document.getElementById("ccNCIdentifier").value = regscore;
		if(regscore == 3)
		{
			document.getElementById("tdTotalRegScoreHolder").style.backgroundColor = 'red';
			document.getElementById("tdTotalRegScoreHolder").innerHTML = "NC";
		}
		else if(regscore == 2)
		{
			document.getElementById("tdTotalRegScoreHolder").style.backgroundColor = 'orange';
			document.getElementById("tdTotalRegScoreHolder").innerHTML = "Warn";
		}
		else if(regscore == 1)
		{
			document.getElementById("tdTotalRegScoreHolder").style.backgroundColor = 'yellow';
			document.getElementById("tdTotalRegScoreHolder").innerHTML = "Cond";
		}
		else
		{
			document.getElementById("tdTotalRegScoreHolder").style.backgroundColor = 'red';
			document.getElementById("tdTotalRegScoreHolder").innerHTML = "NC";
		}
	}
	else
	{
		document.getElementById("tdTotalRegScoreHolder").innerHTML = "C";
		document.getElementById("tdTotalRegScoreHolder").style.backgroundColor = 'blue';
	}
}


function getScore5(id, ded, main) // CC 2019 Individual Operational Requirements Computation
{
	document.getElementById("ccRawScoreHolder" + id).value = parseInt(document.getElementById("selOpHolder" + id).value) * ded  * main / 10000;
	//document.getElementById("ccRawScoreLabel" + id).innerHTML = parseInt(document.getElementById("selOpHolder" + id).value) * ded  * main / 10000;
	getScore6();
}

function getScore6() // CC 2019 Total Operational Requirements Computation
{
	
	var rawSelects = document.getElementsByClassName("ccOpSelect");	
	var failIndex = 0;	
	var zeroIndex = 0;
	for(i = 0; i < rawSelects.length; i++) 
	{
		if(rawSelects[i].value == 1) // Search for failing scores (1)
		{
			failIndex = 1;
		}
		else if(rawSelects[i].value == 0) // Search for N/A
		{
			zeroIndex = 1;
			
		}
		
	}
	
	var add50Logic = 0;
	if(zeroIndex == 1)
	{
		var rawLogistics = document.getElementsByClassName("to50Logic");
		for(i = 0; i < rawLogistics.length; i++)
		{
			add50Logic += parseInt(rawLogistics[i].value) * 15 * 35 / 10000;
		}
		getScoreVisual(0);
	}
	else
	{
		getScoreVisual(1);
	}
	
	var rawScores = document.getElementsByClassName("ccRawScores");
	var totalRaw = 0;
	for(i = 0; i < rawScores.length; i++)
	{
		
			totalRaw += parseFloat(rawScores[i].value);
		
	}
	
	var subScore = 0.00;
	if(failIndex == 1)
	{
		subScore = 1.00;
	}
	else
	{
		subScore = (totalRaw + add50Logic).toFixed(2);
	}
	document.getElementById("tdOpScoreHolder").innerHTML = subScore;
	
	var totalPercentage = subScore;
	
	/* var totalPercentage = 0;
	if(subScore >= 1 && subScore <= 2)
	{
		totalPercentage = (subScore - 1) * 61;
	}
	else if(subScore > 2 && subScore <= 3)
	{
		totalPercentage = (subScore - 2) * 15 + 61;
	}
	else if(subScore > 3 && subScore <= 5)
	{
		totalPercentage = ((subScore - 3) / 2 * 24 + 76).toFixed(2);
	} */
	
	document.getElementById("tdTotalScoreHolder").innerHTML = totalPercentage;
//	if((totalPercentage <= 100) && (totalPercentage >= 90))
	if(subScore == 5)
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'purple';
	}
//	else if((totalPercentage < 90) && (totalPercentage >= 80))
	else if((subScore < 5) && (subScore >= 4))
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'blue';
	}
//	else if((totalPercentage < 80) && (totalPercentage >= 76))
	else if((subScore < 4) && (subScore >= 3))
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'green';
	}
//	else if((totalPercentage < 76) && (totalPercentage > 70))
	else if((subScore < 3) && (subScore >= 2))
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'orange';
	}
//	else if(totalPercentage <= 70)
	else if(totalPercentage < 2)
	{
		document.getElementById("tdTotalScoreHolder").style.color = 'red';
	}
	
}

function getScoreVisual(x)
{
	var Trans = document.getElementsByClassName("ccTransportation");
	var Others = document.getElementsByClassName("ccLogicOther");
	if(x == 0)
	{		
		Trans[0].innerHTML = "--%";
		for(i = 0; i < Others.length; i++)
		{
			Others[i].innerHTML = "50%";
		}
	}
	else
	{		
		Trans[0].innerHTML = "30%";
		for(i = 0; i < Others.length; i++)
		{
			Others[i].innerHTML = "35%";
		}
	}
}

function searchScores()
{
	$("#concompscores").load("cc-scores.php?year=" + document.getElementById("txtCCAdminYear").value);
}

function saveScore()
{
	getScore4();
	getScore6();
	if((document.getElementById("ccAdminAgency").value) && (document.getElementById("ccAdminAgencyEmail").value))
	{
		document.getElementById("btnccsave").disabled = true;
		document.getElementById("btnccsaveandsend").disabled = true;
		var ccActualHolders = document.getElementsByClassName("ccActualHolders");
		var ccCommentHolders = document.getElementsByClassName("ccCommentHolders");
		var ccIDHolders = document.getElementsByClassName("ccIDHolders");
		var ccEditIDHolders = document.getElementsByClassName("ccEditIDHolders");
		var i;
		var ok = 1;
		for(i = 0; i < ccActualHolders.length; i++)
		{
			if(document.getElementById("txtCCAdminYear").value > 2017)
			{
				if(ccActualHolders[i].type == "checkbox")
				{
					if(ccActualHolders[i].checked == true)
					{
						document.getElementById("ccActualList").value += "*~" + "1";
					}
					else if(ccActualHolders[i].checked == false)
					{
						document.getElementById("ccActualList").value += "*~" + "0";
					}
				}				
				else
				{
					document.getElementById("ccActualList").value += "*~" + ccActualHolders[i].value;
				}
			}
			else
			{
				document.getElementById("ccActualList").value += "*~" + ccActualHolders[i].value;
			}
			
			if(document.getElementById("ccSendToAgency").value == 1)
			{
				if(ccCommentHolders[i].value == '')
				{
					alert("All comment boxes must be filled up.");
					document.getElementById("btnccsave").disabled = false;
					document.getElementById("btnccsaveandsend").disabled = false;
					document.getElementById("ccActualList").value = "";
					document.getElementById("ccCommentList").value = "";
					document.getElementById("ccIDList").value = "";
					document.getElementById("ccEditIDList").value = "";
					return;
				}
			}
			
				
			document.getElementById("ccCommentList").value += "*~" + ccCommentHolders[i].value;
			document.getElementById("ccIDList").value += "*~" + ccIDHolders[i].value;
			if(ccEditIDHolders.length > 0)
			{
				document.getElementById("ccEditIDList").value += "*~" + ccEditIDHolders[i].value;
			}
		}
		/* if(ok == 0)
		{
			alert("All comment boxes must be filled up.");
			document.getElementById("btnccsave").disabled = false;
			document.getElementById("btnccsaveandsend").disabled = false;
			document.getElementById("ccActualList").value = "";
			document.getElementById("ccCommentList").value = "";
			document.getElementById("ccIDList").value = "";
			return;
		}
		else
		{ */
			
			document.getElementById("ccSendTotalScore").value = document.getElementById("tdTotalScoreHolder").innerHTML;
			if(document.getElementById("txtCCAdminYear").value >= 2019)
			{
//				if(document.getElementById("tdTotalRegScoreHolder").innerHTML == "NC")
//				{
//					document.getElementById("ccSendTotalScore").value = 0;
//				}
				if(document.getElementById("tdTotalRegScoreHolder").innerHTML == "NC")
				{
					if(document.getElementById("ccNCIdentifier").value == 3)
					{
						document.getElementById("ccSendTotalScore").value = 555;
					}
					else if(document.getElementById("ccNCIdentifier").value == 2)
					{
						document.getElementById("ccSendTotalScore").value = 444;
					}
					else if(document.getElementById("ccNCIdentifier").value == 1)
					{
						document.getElementById("ccSendTotalScore").value = 333;
					}
				}
				
				document.getElementById("ccSendOpScore").value = document.getElementById("tdOpScoreHolder").innerHTML;
			}
			document.getElementById("ccSendYear").value = document.getElementById("txtCCAdminYear").value;
	//		document.getElementById("ccSendMonth").value = document.getElementById("selCCAdminMonth").value;
			document.getElementById("frmCCAdmin").submit();
		// }
		
	}
	else
	{
		document.getElementById("btnccsave").disabled = false;
		document.getElementById("btnccsaveandsend").disabled = false;
		alert("Please enter agency email.");
	}
}

function saveScoreAndSend()
{
	document.getElementById("ccSendToAgency").value = 1;
	saveScore();
}

function clickOnce(disableId)
{
	document.getElementById(disableId).disabled = true;	
}

function clickAgain(enableId)
{
	document.getElementById(disableId).disabled = false;
}

function changeSearch(group)
{
	if(group == "guard_personnel")
	{
	  if(document.getElementById("selSearchGuard").value == 'bu')
	  {
		  document.getElementById("selSearchGuardBu").style.display = "initial";
		  document.getElementById("txtSearchGuard").style.display = "none";
		  document.getElementById("selSearchGuardAgency").style.display = "none";
	  }
	  else if(document.getElementById("selSearchGuard").value == 'agency')
	  {
		  document.getElementById("selSearchGuardAgency").style.display = "initial";
		  document.getElementById("txtSearchGuard").style.display = "none";
		  if(document.getElementById("selSearchGuardBu"))
		  {
		  	document.getElementById("selSearchGuardBu").style.display = "none";
		  }
	  }
	  else
	  {
		  if(document.getElementById("selSearchGuardBu"))
		  {
		  	document.getElementById("selSearchGuardBu").style.display = "none";
		  }
		  document.getElementById("selSearchGuardAgency").style.display = "none";
		  document.getElementById("txtSearchGuard").style.display = "initial";
	  }
	}
	else if(group == "agency_mst")
	{
		if(document.getElementById("selSearchAgency").value == 'bu')
		{
			document.getElementById("selSearchAgencyBu").style.display = "initial";
			document.getElementById("txtSearchAgency").style.display = "none";
		}
		else
		{
			document.getElementById("selSearchAgencyBu").style.display = "none";
			document.getElementById("txtSearchAgency").style.display = "initial";
		}
	}
	else if(group == "location_mst")
	{
		if(document.getElementById("selSearchLocs").value == 'bu')
		{
			document.getElementById("selSearchLocsBu").style.display = "initial";
			document.getElementById("txtSearchLocs").style.display = "none";
		}
		else
		{
			document.getElementById("selSearchLocsBu").style.display = "none";
			document.getElementById("txtSearchLocs").style.display = "initial";
		}
	}
	else if(group == "bu_mst")
	{
		if(document.getElementById("selSearchBUs").value == 'main_group')
		{
			document.getElementById("selSearchBUGroup").style.display = "initial";
			document.getElementById("selSearchBURegion").style.display = "none";
			document.getElementById("txtSearchBUs").style.display = "none";
		}
		else if(document.getElementById("selSearchBUs").value == 'regional_group')
		{
			document.getElementById("selSearchBURegion").style.display = "initial";
			document.getElementById("selSearchBUGroup").style.display = "none";
			document.getElementById("txtSearchBUs").style.display = "none";
		}		
		else
		{
			document.getElementById("txtSearchBUs").style.display = "initial";
			document.getElementById("selSearchBURegion").style.display = "none";
			document.getElementById("selSearchBUGroup").style.display = "none";
		}
	}
	else if(group == "users_mst")
	{
		if(document.getElementById("selSearchUsers").value == 'level')
		{
			document.getElementById("txtSearchUsers").style.display = "none";
			document.getElementById("selSearchUsersLevel").style.display = "initial";
			document.getElementById("selSearchUsersBU").style.display = "none";
			document.getElementById("selSearchUsersGender").style.display = "none";
		}
		else if(document.getElementById("selSearchUsers").value == 'bu')
		{
			document.getElementById("txtSearchUsers").style.display = "none";
			document.getElementById("selSearchUsersLevel").style.display = "none";
			document.getElementById("selSearchUsersBU").style.display = "initial";
			document.getElementById("selSearchUsersGender").style.display = "none";
		}
		else if(document.getElementById("selSearchUsers").value == 'gender')
		{
			document.getElementById("txtSearchUsers").style.display = "none";
			document.getElementById("selSearchUsersLevel").style.display = "none";
			document.getElementById("selSearchUsersBU").style.display = "none";
			document.getElementById("selSearchUsersGender").style.display = "initial";
		}
		else
		{
			document.getElementById("txtSearchUsers").style.display = "initial";
			document.getElementById("selSearchUsersLevel").style.display = "none";
			document.getElementById("selSearchUsersBU").style.display = "none";
			document.getElementById("selSearchUsersGender").style.display = "none";
		}
	}
	else if(group == "oic_mst")
	{
		if(document.getElementById("selSearchSecAlertRecipients").value == 'bu')
		{
			document.getElementById("selSecAlertRecipientsBu").style.display = "initial";
			document.getElementById("txtSearchSecAlertRecipients").style.display = "none";
		}
		else
		{
			if(document.getElementById("selSecAlertRecipientsBu"))
			{
				document.getElementById("selSecAlertRecipientsBu").style.display = "none";				
			}
			document.getElementById("txtSearchSecAlertRecipients").style.display = "initial";
		}
	}
}

function addCodeEntry()
{
	document.getElementById("btnaddcoderow").style.display = "initial";
	document.getElementById("txtaddcodeseries").value = document.getElementById("txtcodetype").value;
	document.getElementById("txtaddcodeseriesdisplay").value = document.getElementById("txtcodetypedisplay").value;
	document.getElementById("btnsavecode").style.display = "block";
	document.getElementById("btnupdatecode").style.display = "none";
	$( "#codemgtmodal" ).dialog("open");
	document.getElementById("txtaddcodecode").focus();
}

function editCodeEntry(id, code, desc)
{
	addCodeEntry();
	document.getElementById("txtaddcodeid").value = id;
	document.getElementById("txtaddcodecode").value = code;
	document.getElementById("txtaddcodedesc").value = desc;
	document.getElementById("btnaddcoderow").style.display = "none";
	document.getElementById("btnsavecode").style.display = "none";
	document.getElementById("btnupdatecode").style.display = "block";
}

function closeCodeMgt()
{
	document.getElementById("txtaddcodeid").value = "";
	document.getElementById("codemgtform").reset();
	$( "#tblcodemgt tbody" ).text("");
	$( "#codemgtmodal" ).dialog("close");	
}

function addCodeRow()
{
	if((document.getElementById("txtaddcodecode").value) && (document.getElementById("txtaddcodedesc").value))
	{
		$( "#tblcodemgt tbody" ).append( "<tr align='center'>" +
          "<td class='rowcodecodes'>" + document.getElementById("txtaddcodecode").value + "</td>" +
          "<td class='rowcodedesc'>" + document.getElementById("txtaddcodedesc").value + "</td>" +
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
		document.getElementById("txtaddcodecode").value = "";
		document.getElementById("txtaddcodedesc").value = "";
		document.getElementById("txtaddcodecode").focus();
	}
}

function saveCodeRow()
{
	addCodeRow();
	if(document.getElementById("txtaddcodeid").value)
	{
		if((document.getElementById("txtaddcodecode").value) && (document.getElementById("txtaddcodedesc").value))
		{
			document.getElementById("codemgtform").submit();
		}
		else
		{
			alert("Incomplete information");
		}
	}
	else
	{
	  var x = document.getElementsByClassName('rowcodecodes');
	  var x2 = document.getElementsByClassName('rowcodedesc');
	  var i;
	  for (i = 0; i < x.length; i++) {
		  document.getElementById("txtaddcodecodeall").value += "*~" + x[i].innerHTML;
		  document.getElementById("txtaddcodedescall").value += "*~" + x2[i].innerHTML;
	  }
	  if((document.getElementById("txtaddcodecodeall").value) && (document.getElementById("txtaddcodedescall").value))
	  {
		  document.getElementById("txtactivityname").value = "";
		  document.getElementById("txtincidentname").value = "";
		  document.getElementById("codemgtform").submit();
	  }
	  else
	  {
		  alert("No codes to add.");
	  }
	}
}

function updateCodeRow()
{
	if((document.getElementById("txtaddcodecode").value) && (document.getElementById("txtaddcodedesc").value))
	{
		document.getElementById("codemgtform").submit();
	}
}

function addBU()
{
	$("#modalBU").dialog("open");
}

function addBUrow()
{
	if((document.getElementById("txtaddbuname").value) && (document.getElementById("seladdbugroup").value) && (document.getElementById("seladdburegion").value) && (document.getElementById("selexprogroup").value))
	{
		$( "#tblBU tbody" ).append( "<tr align='center'>" +
          "<td class='rowbuname'>" + document.getElementById("txtaddbuname").value + "</td>" +
		  "<td class='rowbucode'>" + document.getElementById("txtaddbucode").value + "</td>" +		  
          "<td class='rowbugroup' style='display:none;'>" + document.getElementById("seladdbugroup").value + "</td>" +
		  "<td>" + $("#seladdbugroup option:selected").text() + "</td>" +
		  "<td class='rowburegion' style='display:none;'>" + document.getElementById("seladdburegion").value + "</td>" +
		  "<td>" + $("#seladdburegion option:selected").text() + "</td>" +
		  "<td class='rowbucluster' style='display:none;'>" + document.getElementById("seladdbucluster").value + "</td>" +
		  "<td>" + $("#seladdbucluster option:selected").text() + "</td>" +
		  "<td class='rowexprogroup' style='display:none;'>" + document.getElementById("selexprogroup").value + "</td>" +
		  "<td>" + $("#selexprogroup option:selected").text() + "</td>" +
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
		document.getElementById("txtaddbuname").value = "";
		document.getElementById("txtaddbucode").value = "";
		document.getElementById("seladdbugroup").value = "";
		document.getElementById("seladdbucluster").value = "";
		document.getElementById("seladdburegion").value = "";
		document.getElementById("txtaddbuname").focus();
	}
	else
	{
		alert("Incomplete information");
	}
}

function saveBUrow()
{
	var x = document.getElementsByClassName('rowbuname');
	var x2 = document.getElementsByClassName('rowbugroup');
	var x3 = document.getElementsByClassName('rowburegion');
	var x4 = document.getElementsByClassName('rowbucode');
	var x5 = document.getElementsByClassName('rowexprogroup');
	var x6 = document.getElementsByClassName('rowbucluster');
	var i;
	for (i = 0; i < x.length; i++) {
		document.getElementById("txtaddbunameall").value += "*~" + x[i].innerHTML;
		document.getElementById("txtaddbugroupall").value += "*~" + x2[i].innerHTML;
		document.getElementById("txtaddburegionall").value += "*~" + x3[i].innerHTML;
		document.getElementById("txtaddbucodeall").value += "*~" + x4[i].innerHTML;
		document.getElementById("txtexprogroupall").value += "*~" + x5[i].innerHTML;
		document.getElementById("txtaddbuclusterall").value += "*~" + x6[i].innerHTML;
	}
	if((document.getElementById("txtaddbunameall").value) && (document.getElementById("txtaddbugroupall").value) && (document.getElementById("txtaddburegionall").value) && (document.getElementById("txtaddbuclusterall").value) && (document.getElementById("txtexprogroupall").value))
	{
		document.getElementById("txtactivityname").value = "";
		document.getElementById("txtincidentname").value = "";
		document.getElementById("frmBU").submit();
	}
	else
	{
		alert("No codes to add.");
	}
}

function editBU(id, bu, bu_code, group, region, cluster, expro, bulogo)
{
	document.getElementById("txtaddbuid").value = id;
	document.getElementById("txtaddbuname").value = bu;
	document.getElementById("txtaddbucode").value = bu_code;
	document.getElementById("seladdbugroup").value = group;
	document.getElementById("seladdburegion").value = region;
	document.getElementById("seladdbucluster").value = cluster;
	document.getElementById("selexprogroup").value = expro;
	document.getElementById("btnaddburow").style.display = "none";
	document.getElementById("btnsavebu").style.display = "none";
	document.getElementById("btnupdatebu").style.display = "initial";
	document.getElementById("bulogoupdatediv").style.display = "initial";
	document.getElementById("bulogobox").src = bulogo;
	document.getElementById("tbodybuadd").innerHTML = "";
	$("#modalBU").dialog("open");
}

function updateBU()
{
	if((document.getElementById("txtaddbuname").value) && (document.getElementById("seladdbugroup").value) && (document.getElementById("seladdburegion").value) && (document.getElementById("seladdbucluster").value) && (document.getElementById("selexprogroup").value))	{
		document.getElementById("frmBU").submit();
	}
	else
	{
		alert("Please enter complete details.");
	}
}

function closeBU()
{
	document.getElementById("frmBU").reset();
	document.getElementById("btnaddburow").style.display = "initial";
	document.getElementById("btnsavebu").style.display = "initial";
	document.getElementById("btnupdatebu").style.display = "none";
	document.getElementById("bulogobox").src = "";
	document.getElementById("bulogoupdatediv").style.display = "none";
	$("#modalBU").dialog("close");
}

function addBUgroupregion(type)
{
	document.getElementById("txtaddbuitem").value = type;
	document.getElementById("additemtitle").innerHTML = type;
	document.getElementById("btnaddbuitem").style.display = "initial";
	document.getElementById("txtaddbuitemaction").value = "add";
	$("#modalbugroupregion").dialog("open");
}

function closeBUgroupregion()
{
	document.getElementById("frmbuitementry").reset();
	document.getElementById("tblbugroupregiontbody").innerHTML = "";
	$("#modalbugroupregion").dialog("close");
}

function addBUitemrow()
{
	if(document.getElementById("txtaddbuitementry").value)
	{
	$( "#tblbugroupregion tbody" ).append( "<tr align='center'>" +
          "<td class='rowbuitem'>" + document.getElementById("txtaddbuitementry").value + "</td>" +          
          "<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
	}
	document.getElementById("txtaddbuitementry").value = "";
	document.getElementById("txtaddbuitementry").focus();
}

function saveBUitemrow()
{
	if(document.getElementById("txtaddbuitemaction").value == 'add')
	{
		var x = document.getElementsByClassName('rowbuitem');	
		var i;
		for (i = 0; i < x.length; i++) {
			document.getElementById("txtaddbuitementryall").value += "*~" + x[i].innerHTML;
		}
		if(document.getElementById("txtaddbuitementryall").value)
		{
			document.getElementById("txtactivityname").value = "";
			document.getElementById("txtincidentname").value = "";
			document.getElementById("txtaddbuitementry").value = "";
			document.getElementById("frmbuitementry").submit();
		}
		else
		{
			alert("No items to add.");
		}
	}
	else if(document.getElementById("txtaddbuitemaction").value == 'edit')
	{
		if(document.getElementById("txtaddbuitementry").value)
		{
			document.getElementById("txtactivityname").value = "";
			document.getElementById("txtincidentname").value = "";
			document.getElementById("frmbuitementry").submit();
		}
		else

		{
			alert("Invalid entry");
		}
	}
}

function editGroup(id, content, type)
{
	document.getElementById("txtaddbuitementry").value = content;
	document.getElementById("txtaddbuitemid").value = id;
	document.getElementById("txtaddbuitem").value = type;
	document.getElementById("btnaddbuitem").style.display = "none";
	document.getElementById("txtaddbuitemaction").value = "edit";
	$("#modalbugroupregion").dialog("open");
	
}

function addInputEntries(type)
{
	document.getElementById("txtAddEntriesType").value = type;
	document.getElementById("addEntriesTitle").innerHTML = type;
	document.getElementById("btnAddEntries").style.display = "initial";
	document.getElementById("txtAddEntriesAction").value = "add";
	if(type == "Incident")
	{
		$(".severityfactors").show();
		$("#modalEntries").load("getinfo.php?type=addIncident&id=0");
	}
	else{
		$(".severityfactors").hide();
	}
	$("#modalEntries").dialog("open");
}

function addInputEntries2(type)
{
	if(type == "Incident")
	{
		$(".severityfactors").show();
		$("#modalEntries2").load("getinfo.php?type=addIncident&id=0");
	}
	else{
		$(".severityfactors").hide();
	}
	$("#modalEntries2").dialog("open");
}

function closeInputEntries(type)
{
	if(document.getElementById("frmbuitementry"))
	{
		document.getElementById("frmbuitementry").reset();
	}
	
	document.getElementById("txtAddEntries").value = "";
	document.getElementById("txtsvdefault").value = "";
	document.getElementById("txtsvinjuryminor").value = "";
	document.getElementById("txtsvinjuryserious").value = "";
	document.getElementById("txtsvpropdmgnc").value = "";
	document.getElementById("txtsvpropdmgcrit").value = "";
	document.getElementById("txtsvproplossnc").value = "";
	document.getElementById("txtsvproplosscrit").value = "";
	document.getElementById("txtsvworkstop").value = "";
	document.getElementById("txtsvdeath1").value = "";
	document.getElementById("txtsvdeath2").value = "";
	document.getElementById("txtsvdeath3").value = "";
	document.getElementById("tbltbodyEntries").innerHTML = "";
	$("#modalEntries").dialog("close");
}

function closeInputEntries2()
{
	event.preventDefault();
	$("#modalEntries2").dialog("close");
}

function addInputEntriesRow()
{
	if(document.getElementById("txtAddEntries").value)
	{
		var hideit = "";
		if(document.getElementById("txtAddEntriesType").value != "Incident")
		{
			hideit = "style='display:none;'";
		}
	$( "#tblEntries tbody" ).append( "<tr align='center'>" +
			"<td class='rowInputEntries'>" + document.getElementById("txtAddEntries").value + "</td>" +
			"<td class='rowsvdefault' "+hideit+">" + document.getElementById("txtsvdefault").value + "</td>" + 
			"<td class='rowsvinjuryminor' "+hideit+">" + document.getElementById("txtsvinjuryminor").value + "</td>" + 
			"<td class='rowsvinjuryserious' "+hideit+">" + document.getElementById("txtsvinjuryserious").value + "</td>" + 
			"<td class='rowsvpropdmgnc' "+hideit+">" + document.getElementById("txtsvpropdmgnc").value + "</td>" + 
			"<td class='rowsvpropdmgcrit' "+hideit+">" + document.getElementById("txtsvpropdmgcrit").value + "</td>" + 
			"<td class='rowsvproplossnc' "+hideit+">" + document.getElementById("txtsvproplossnc").value + "</td>" + 
			"<td class='rowsvproplosscrit' "+hideit+">" + document.getElementById("txtsvproplosscrit").value + "</td>" + 
			"<td class='rowsvworkstop' "+hideit+">" + document.getElementById("txtsvworkstop").value + "</td>" + 
			"<td class='rowsvdeath1' "+hideit+">" + document.getElementById("txtsvdeath1").value + "</td>" + 
			"<td class='rowsvdeath2' "+hideit+">" + document.getElementById("txtsvdeath2").value + "</td>" + 
			"<td class='rowsvdeath3' "+hideit+">" + document.getElementById("txtsvdeath3").value + "</td>" + 
			"<td><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)' /></td>" +
        "</tr>" );
	}
	document.getElementById("txtAddEntries").value = "";
	document.getElementById("txtsvdefault").value = "";
	document.getElementById("txtsvinjuryminor").value = "";
	document.getElementById("txtsvinjuryserious").value = "";
	document.getElementById("txtsvpropdmgnc").value = "";
	document.getElementById("txtsvpropdmgcrit").value = "";
	document.getElementById("txtsvproplossnc").value = "";
	document.getElementById("txtsvproplosscrit").value = "";
	document.getElementById("txtsvworkstop").value = "";
	document.getElementById("txtsvdeath1").value = "";
	document.getElementById("txtsvdeath2").value = "";
	document.getElementById("txtsvdeath3").value = "";
	document.getElementById("txtAddEntries").focus();
	
}

function addInputEntriesRow2()
{
	$("#tblAddIncident tbody").append($(document.createElement("p")).load("getinfo.php?type=addIncident&id=1"));
}

function saveInputEntries()
{
	if(document.getElementById("txtAddEntriesAction").value == 'add')
	{
		var x = document.getElementsByClassName('rowInputEntries');
		var x2 = document.getElementsByClassName('rowsvdefault');
		var x3 = document.getElementsByClassName('rowsvinjuryminor');
		var x4 = document.getElementsByClassName('rowsvinjuryserious');
		var x5 = document.getElementsByClassName('rowsvpropdmgnc');
		var x6 = document.getElementsByClassName('rowsvpropdmgcrit');
		var x7 = document.getElementsByClassName('rowsvproplossnc');
		var x8 = document.getElementsByClassName('rowsvproplosscrit');
		var x9 = document.getElementsByClassName('rowsvworkstop');
		var x10 = document.getElementsByClassName('rowsvdeath1');
		var x11 = document.getElementsByClassName('rowsvdeath2');
		var x12 = document.getElementsByClassName('rowsvdeath3');
		var i;
		for (i = 0; i < x.length; i++) {
			document.getElementById("txtAddEntriesAll").value += "*~" + x[i].innerHTML;
			document.getElementById("txtAddSvDefault").value += "*~" + x2[i].innerHTML;
			document.getElementById("txtAddSvInjuryMinor").value += "*~" + x3[i].innerHTML;
			document.getElementById("txtAddSvInjurySerious").value += "*~" + x4[i].innerHTML;
			document.getElementById("txtAddSvPropDmgNC").value += "*~" + x5[i].innerHTML;
			document.getElementById("txtAddSvPropDmgCrit").value += "*~" + x6[i].innerHTML;
			document.getElementById("txtAddSvPropLossNC").value += "*~" + x7[i].innerHTML;
			document.getElementById("txtAddSvPropLossCrit").value += "*~" + x8[i].innerHTML;
			document.getElementById("txtAddSvWorkStoppage").value += "*~" + x9[i].innerHTML;
			document.getElementById("txtAddSvDeath1").value += "*~" + x10[i].innerHTML;
			document.getElementById("txtAddSvDeath2").value += "*~" + x11[i].innerHTML;
			document.getElementById("txtAddSvDeath3").value += "*~" + x12[i].innerHTML;
		}
		if(document.getElementById("txtAddEntriesAll").value)
		{
			document.getElementById("txtactivityname").value = "";
			document.getElementById("txtincidentname").value = "";
			document.getElementById("txtAddEntries").value = "";
			document.getElementById("frmEntries").submit();
		}
		else
		{
			alert("No items to add.");
		}
	}
	else if(document.getElementById("txtAddEntriesAction").value == 'edit')
	{
		if(document.getElementById("txtAddEntries").value)
		{
			document.getElementById("txtactivityname").value = "";
			document.getElementById("txtincidentname").value = "";
			document.getElementById("frmEntries").submit();
		}
		else
		{
			alert("Invalid entry");
		}
	}
}

function editInputEntries(id, content, type, defaultlvl, injmin, injser, propdmgnc, propdmgcrit, proplossnc, proplosscrit, workstop, d1, d2, d3)
{
	document.getElementById("txtAddEntries").value = content;
	document.getElementById("txtAddEntriesId").value = id;
	document.getElementById("txtAddEntriesType").value = type;
	document.getElementById("btnAddEntries").style.display = "none";
	document.getElementById("txtAddEntriesAction").value = "edit";
	document.getElementById("txtsvdefault").value = defaultlvl;
	document.getElementById("txtsvinjuryminor").value = injmin;
	document.getElementById("txtsvinjuryserious").value = injser;
	document.getElementById("txtsvpropdmgnc").value = propdmgnc;
	document.getElementById("txtsvpropdmgcrit").value = propdmgcrit;
	document.getElementById("txtsvproplossnc").value = proplossnc;
	document.getElementById("txtsvproplosscrit").value = proplosscrit;
	document.getElementById("txtsvworkstop").value = workstop;
	document.getElementById("txtsvdeath1").value = d1;
	document.getElementById("txtsvdeath2").value = d2;
	document.getElementById("txtsvdeath3").value = d3;
	if(type == "Incident")
	{
		$(".severityfactors").show();
	}
	else{
		$(".severityfactors").hide();
	}
	$("#modalEntries").dialog("open");
	
}

function editInputEntries2(id)
{
	$("#modalEntries2").load("getinfo.php?type=addIncident&id=0&id2="+id);
	$("#modalEntries2").dialog("open");
}

function changeSub(id)
{
	$("#selAddSubClassId"+id).load("getinfo.php?type=changeSub&id="+ document.getElementById("selAddMainClassId"+id).value);
}

function changeSub2()
{
	$("#selSearchIncLogSub").load("getinfo.php?type=changeSub2&id="+ document.getElementById("selSearchIncLogMain").value);
}

function openLocators(type, id)
{
	$("#modaladdlocator").load("getinfo.php?type=addLocator");
	$("#modaladdlocator").dialog("open");
}

function addAnotherLocator()
{
	$("#tblAddLocator tbody").append("<tr><td><input type='text' name='txtAddLocators[]' style='text-align:center;' required><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)'></td></tr>");
}

function closeAddLocator()
{
	event.preventDefault();
	$("#modaladdlocator").dialog("close");
}

function getLocators()
{
	$("#tblLocators tbody").load("getinfo.php?type=getLocators");
}

function openIncidentClassifications(type,id)
{
	if(type == "addMain")
	{
		$("#modalincmainclass").load("getinfo.php?type=incAddMainClass");
	}
	else if(type == "editMain")
	{
		$("#modalincmainclass").load("getinfo.php?type=incEditMainClass&id="+id);
	}
	else if(type == "addSub")
	{
		$("#modalincmainclass").load("getinfo.php?type=incAddSubClass");
	}
	else if(type == "editSub")
	{
		$("#modalincmainclass").load("getinfo.php?type=incEditSubClass&id="+id);
	}
	$("#modalincmainclass").dialog("open");
}

function closeIncidentClassifications()
{
	event.preventDefault();
	$("#modalincmainclass").dialog("close");
}


function addAnotherMainClass()
{
	$("#tblAddIncMainClass tbody").append("<tr><td><input type='text' name='txtAddMainClass[]' style='text-align:center;' ><img src='images/delete.png' style='cursor:pointer;' onclick='this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode)'></td></tr>");
}

function getIncidentClassifications()
{
	$("#tblIncMainClass tbody").load("getinfo.php?type=incMainClass");
	$("#tblIncSubClass tbody").load("getinfo.php?type=incSubClass");
}

/* START Audit */

	function generateAuditDonut(data)
	{
		var rawdata = data.split("//");
		var status = rawdata[0].split(", ");
		var values = rawdata[1].split(", ").map(Number);
		var statval = [];
		for(i=0;i<status.length;i++)
		{
			statval.push([status[i], values[i]]);
		}
		var s1 = statval;	   
		var plot4 = $.jqplot('auditDonut', [s1], {
		title: 'Percentage of Completion',
		seriesDefaults: {
		  // make this a donut chart.
		  renderer:$.jqplot.DonutRenderer,
		  rendererOptions:{
			// Donut's can be cut into slices like pies.
			sliceMargin: 3,
			// Pies and donuts can start at any arbitrary angle.
			startAngle: -90,
			showDataLabels: true,
			// By default, data labels show the percentage of the donut/pie.
			// You can show the data 'value' or data 'label' instead.
			//dataLabels: 'value',
			dataLabelNudge: 45
			// "totalLabel=true" uses the centre of the donut for the total amount
			// totalLabel: true
		  }
		  
		},
		legend: { show:true, location: 'e' },
		seriesColors: ['silver', '#ffcbbd', 'yellow', 'red', 'limegreen', 'blue']
		});
	}
	
	function generateAuditStacked(data)
	{
		var rawbar = data.split("//");
		var donebar = rawbar[0].split(", ").map(Number);
		var iponbar = rawbar[1].split(", ").map(Number);
		var ipdebar = rawbar[2].split(", ").map(Number);
		var nsonbar = rawbar[3].split(", ").map(Number);
		var nsdebar = rawbar[4].split(", ").map(Number);
		var s1 = donebar;
        var s2 = iponbar;
        var s3 = ipdebar;
		var s4 = nsonbar;
		var s5 = nsdebar;
        plot3 = $.jqplot('auditStacked', [s1, s2, s3, s4, s5], {
            stackSeries: true,
			title: 'Status of Findings',
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer, 
				rendererOptions: {
                    barMargin: 25                  
                },
                pointLabels: {show: true, formatString: '%i', color: 'white'}
            },
            legend: {
                show: true,
                location: 'nw'
            },
			series: [{label: 'Done'},
					{label: 'In Progress - On Time'},
					{label: 'In Progress - Delayed'},
					{label: 'Not Started - On Time'},
					{label: 'Not Started - Delayed'}],
			seriesColors: ['limegreen', 'yellow', 'red', 'silver', '#ffcbbd'],
			axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
					ticks: ['Low', 'Medium', 'High', 'Critical']
                }
            }			
        });
	}
	
	function generateAuditBar(data)
	{
		var strticksdata = data.split("//");
		var strticks = strticksdata[0].split(",");
		var strdata = strticksdata[1].split(",").map(Number);
		
			$.jqplot.config.enablePlugins = true;
			var s1 = strdata;
			var ticks = strticks;
			plot1 = $.jqplot('auditBars', [s1], {
				// Only animate if we're not using excanvas (not in IE 7 or IE 8)..
				animate: !$.jqplot.use_excanvas,
				title: 'Categories of Findings',
				seriesColors: ["navy"],
				seriesDefaults:{
					renderer:$.jqplot.BarRenderer,
					rendererOptions: {
						barDirection: 'horizontal'  
					},
					pointLabels: { show: true, formatString: '%i' }
				},
				axes: {
					yaxis: {
						renderer: $.jqplot.CategoryAxisRenderer,					
						ticks: ticks
					}
				},
				highlighter: { show: false }
			});	
	}

	function auditShow(buid)
	{
		$("#divGraphAuditHolder").hide();
		$("#Audit").load("audit.php?bu_id=" + buid);
		$("#Audit").show();
	}

	function auditShow2()
	{
		$("#Audit").load("audit-consolidation-final.php");
		$("#Audit").show();
		$("#divGraphAuditHolder").hide();
	}
	function auditShow3()
	{
		$("#Audit").hide();
		$("#auditBars").empty();
		$("#auditStacked").empty();
		$("#auditDonut").empty();
		$.get("generate-dashboard.php?type=auditDashboardDonut", generateAuditDonut);
		$.get("generate-dashboard.php?type=auditDashboardStacked", generateAuditStacked);
		$.get("generate-dashboard.php?type=auditDashboardBarCategories", generateAuditBar);
		
		$("#tblAuditGraphHead").load("generate-dashboard.php?type=auditGenerateDashboardBack");
		
		$("#divGraphAuditHolder").show();
		
	}
	
	function auditShow4(buid)
	{
		$("#Audit").hide();
		$("#auditBars").empty();
		$("#auditStacked").empty();
		$("#auditDonut").empty();
		$.get("generate-dashboard.php?type=auditDashboardDonut&auditbu=" + buid, generateAuditDonut);
		$.get("generate-dashboard.php?type=auditDashboardStacked&auditbu=" + buid, generateAuditStacked);
		$.get("generate-dashboard.php?type=auditDashboardBarCategories&auditbu=" + buid, generateAuditBar);
		
		$("#tblAuditGraphHead").load("generate-dashboard.php?type=auditGenerateDashboardBack&auditbu=" + buid);
		
		$("#divGraphAuditHolder").show();
		
	}

	function openAuditForm(num, buid)
	{
		$("#modalAudit").load("audit-form.php?audit_id=" + num + "&bu_id=" + buid);
		$("#modalAudit").dialog("open");	
	}

	function closeAuditForm()
	{
		event.preventDefault();
		$("#modalAudit").dialog("close");
	}

	function openAuditEvidenceadd(id, type)
	{
		$( "#addAuditEvidencemodal" ).dialog("open");
		document.getElementById("addauditid").value = id;
		document.getElementById("addaudittype").value = type;
	}
	
	function openAuditFindingsadd(id, type)
	{
		$( "#addAuditEvidencemodal" ).dialog("open");
		document.getElementById("addauditid").value = id;
		document.getElementById("addaudittype").value = type;
	}
	
	function openViewAuditEvidence(auditid)
	{
		$("#viewAuditUpload").load("view-uploads.php?audit_id=" + auditid + "&audit_type=2");
		$("#viewAuditUpload").dialog("open");
	}
	
	function openViewAuditFinding(auditid)
	{
		$("#viewAuditUpload").load("view-uploads.php?audit_id=" + auditid + "&audit_type=3");
		$("#viewAuditUpload").dialog("open");
	}
	
	function testCSVUpload()
	{
		$( "#testCSV" ).dialog("open");
	}

	function openAuditDetails(id, id2)
	{
		$("#viewAuditDetails").load("getinfo.php?type=viewAuditDetails&id=" + id + "&id2=" + id2);
		$("#viewAuditDetails").dialog("open");
	}
	
	function openAuditDisposition(id, id2)
	{
		$("#viewAuditDisposition").load("getinfo.php?type=viewAuditDetails&id=" + id + "&id2=" + id2);
		$("#viewAuditDisposition").dialog("open");
	}

	function closeAuditDetails()
	{
		$( "#viewAuditDetails" ).dialog( "close" );	
	}

	function addAuditEntriesRow()
	{
		$("#divAuditPlaceholder").append($(document.createElement("p")).load("audit-form.php?marker=1"));
	}
	
	function submitAuditDisposition()
	{
		document.getElementById("frmAuditDisposition").submit();
	}

	function displayAuditText(randID)
	{
		if(document.getElementById("selAuditType" + randID).value == "External")
		{		
			$("#txtAuditType" + randID).prop("readonly", false);
			$("#txtAuditType" + randID).prop("required", true);
			$("#divAuditType" + randID).show();
		}
		else
		{
			$("#divAuditType" + randID).hide();
			$("#txtAuditType" + randID).val("");
			$("#txtAuditType" + randID).prop("readonly", true);
			$("#txtAuditType" + randID).prop("required", false);
		}
	}

	function invokeFilters(buid, risk_priority, status, progress)
	{
			$("#tblAuditMonitoringTbody").load("audit-filters.php?bu_id=" + buid + "&risk_priority=" + risk_priority + "&status=" + encodeURI(status) + "&progress=" + progress);
			//$("#tblAuditMonitoringTbody").hide();
	}
	
	function auditDropdown(rownum)
	{
		if($(".subrow" + rownum).is(":visible"))
		{
			$(".subrow" + rownum + ":visible").hide();
		}
		else
		{
			$(".subrow" + rownum).show();
		}
		
	}
	
	function otherView()
	{
		if($(".auditview1").is(":visible"))
		{
			$(".auditview1").hide();
			$(".auditview2").show();
		}
		else
		{
			$(".auditview1").show();
			$(".auditview2").hide();
		}
	}

/* END Audit */

/* START Stakeholder */

function stakeDropdown(rownum)
	{
		if($(".stakerow" + rownum).is(":visible"))
		{
			$(".stakerow" + rownum + ":visible").hide();
		}
		else
		{
			$(".stakerow" + rownum).show();
		}
		
	}

function idpDropdown(rownum)
	{
		if($(".idprow" + rownum).is(":visible"))
		{
			$(".idprow" + rownum + ":visible").hide();
		}
		else
		{
			$(".idprow" + rownum).show();
		}
		
	}

function expandStakeholders(num)
{
	if(num == 1)
	{
		$("#thStakeholder").prop("colspan", 6);
		$("#thActivity").prop("colspan", 2);
		$(".tdStakeholder").show();
		$(".tdActivity").hide();
	}
	else if(num == 2)
	{
		$("#thStakeholder").prop("colspan", 2);
		$("#thActivity").prop("colspan", 6);
		$(".tdStakeholder").hide();
		$(".tdActivity").show();
	}
}

function fnStakeholderClose()
{
	event.preventDefault();
	$( "#modalStakeholder" ).dialog( "close" );	
	document.getElementById("frmStakeholder").reset();
}

/* END Stakeholder */

/* START KPI_Dashboard */

function generateAuditDonutKPI(data)
{
	var rawdata = data.split("//");
	var status = rawdata[0].split(", ");
	var values = rawdata[1].split(", ").map(Number);
	var statval = [];
	for(i=0;i<status.length;i++)
	{
		statval.push([status[i], values[i]]);
	}
	var s1 = statval;	   
	var plot4 = $.jqplot('KPIAudit', [s1], {
	title: 'Percentage of Completion',
	seriesDefaults: {
	  // make this a donut chart.
	  renderer:$.jqplot.DonutRenderer,
	  rendererOptions:{
		// Donut's can be cut into slices like pies.
		sliceMargin: 3,
		// Pies and donuts can start at any arbitrary angle.
		startAngle: -90,
		showDataLabels: true,
		// By default, data labels show the percentage of the donut/pie.
		// You can show the data 'value' or data 'label' instead.
		//dataLabels: 'value',
		dataLabelNudge: 35
		// "totalLabel=true" uses the centre of the donut for the total amount
		// totalLabel: true
	  }
	  
	},
	legend: { show:true, location: 'e' },
	seriesColors: ['silver', '#ffcbbd', 'yellow', 'red', 'limegreen', 'blue']
	});
}

function generateStakeDonutKPI(data)
{
	var rawdata = data.split("//");
	var status = rawdata[0].split(", ");
	var values = rawdata[1].split(", ").map(Number);
	var statval = [];
	for(i=0;i<status.length;i++)
	{
		statval.push([status[i], values[i]]);
	}
	var s1 = statval;	   
	var plot4 = $.jqplot('KPIStake', [s1], {
	title: 'Engagement Activities',
	seriesDefaults: {
	  // make this a donut chart.
	  renderer:$.jqplot.DonutRenderer,
	  rendererOptions:{
		// Donut's can be cut into slices like pies.
		sliceMargin: 3,
		// Pies and donuts can start at any arbitrary angle.
		startAngle: -90,
		showDataLabels: true,
		// By default, data labels show the percentage of the donut/pie.
		// You can show the data 'value' or data 'label' instead.
		//dataLabels: 'value',
		dataLabelNudge: 45
		// "totalLabel=true" uses the centre of the donut for the total amount
		// totalLabel: true
	  }
	  
	},
	legend: { show:true, location: 'e' },
	seriesColors: ['silver', '#ffcbbd', 'yellow', 'red', 'limegreen', 'blue']
	});
}

function fillKPIDashboard()
{
	$("#KPICC").empty();
	$("#KPIAudit").empty();
	$("#KPIStake").empty();
	$("#KPIIA").empty();
	$("#KPIIDP").empty();
	
	//$.get("generate-dashboard.php?type=KPIDashboardStakeDonut", generateStakeDonutKPI);
	KPIyear = (new Date().getFullYear());
	
	$("#KPIIDP").load("idp-kpi.php?year=" + KPIyear);
	$("#KPIStake").load("stakeholder-kpi.php?year=" + KPIyear);
	
	$("#KPICC").load("cc-scores.php?year=" + KPIyear +"&kpi_token=1");
	//$("#KPICC").load("cc-scores.php?year=2019&kpi_token=1");
	$("#KPIIA").load("Incident-accuracy-kpi.php?year=" + KPIyear);
	$.get("generate-dashboard.php?type=auditDashboardDonut", generateAuditDonutKPI);
	
}

function fillKPIDashboardSA()
{
	$("#KPICC").empty();
	$("#KPIAudit").empty();
	$("#KPIStake").empty();
	$("#KPIIA").empty();
	$("#KPIIDP").empty();
	
	//$.get("generate-dashboard.php?type=KPIDashboardStakeDonut", generateStakeDonutKPI);
	KPIyear = (new Date().getFullYear());
	
	$("#KPIIDP").load("idp-kpi.php?year=" + KPIyear);
	$("#KPIStake").load("stakeholder-kpi.php?year=" + KPIyear);
	
	$("#KPICC").load("cc-scores.php?year=" + KPIyear +"&kpi_token=1");
	//$("#KPICC").load("cc-scores.php?year=2019&kpi_token=1");
	$("#KPIIA").load("Incident-accuracy-kpi.php?year=" + KPIyear);
	$.get("generate-dashboard.php?type=auditDashboardDonut", generateAuditDonutKPI);
//	$.get("generate-dashboard.php?type=auditDashboardDonut", generateAuditDonut);
	
}

/* END KPI_Dashboard */

/* START Incident_Accuracy */

function showIACons()
{
	$("#divIAdisplay").load("incident-accuracy-consolidation.php");
}

function seacchIncAcc()
{
	$("#tbodydisplayIAconso").load("incident-accuracy-scores.php");
}

/* END Incident_Accuracy */

function GenerateReport(ticket_id)
{
	$("#modalReport").load("generate-report.php?ticket_id=" + ticket_id);
	$("#modalReport").dialog("open");
}

function toggleAttachments()
{
	if(document.getElementById("attachmentWrapper").style.display == 'none')
	{
		$("#attachmentWrapper").show();
		$("#reportWrapper").hide();
		document.getElementById("reportlabel").innerHTML = "Back to Report";
	}
	else
	{
		$("#attachmentWrapper").hide();
		$("#reportWrapper").show();
		document.getElementById("reportlabel").innerHTML = "View Attachment(s)";
	}
}

function blurAll(){
 var tmp = document.createElement("input");
 document.body.appendChild(tmp);
 tmp.focus();
 document.body.removeChild(tmp);
}

function PrintReport()
{
	//$(".rDates").prop("readonly", true);	
	document.getElementById("tdSIC").innerHTML = document.getElementById("txtSIC").value;
	document.getElementById("tdSecMgr").innerHTML = document.getElementById("txtSecMgr").value;
	var divToPrint = document.getElementById('printReport');
    var popupWin = window.open();
	popupWin.document.open();
    popupWin.document.write('<html><head><link href="print-style.css" rel="stylesheet" /></head><body onload="window.print()"><div style="background:none; font-size:11px; font-family:Calibri">' + divToPrint.innerHTML + '</div></body></html>');
    popupWin.document.close();
	$(".rDates").prop("readonly", false);
}

function PrintReport2()
{
	//$(".rDates").prop("readonly", true);	
	// document.getElementById("tdSIC").innerHTML = document.getElementById("txtSIC").value;
	// document.getElementById("tdSecMgr").innerHTML = document.getElementById("txtSecMgr").value;
	var divToPrint = document.getElementById('printMIMR');
    var popupWin = window.open();
	popupWin.document.open();
    popupWin.document.write('<html><head><link href="print-style.css" rel="stylesheet" /></head><body onload="window.print()"><div style="background:none; font-size:11px; font-family:Calibri">' + divToPrint.innerHTML + '</div></body></html>');
    popupWin.document.close();
	$(".rDates").prop("readonly", false);
}

function PrintReport3(buname)
{
	//$(".rDates").prop("readonly", true);	
	// document.getElementById("tdSIC").innerHTML = document.getElementById("txtSIC").value;
	// document.getElementById("tdSecMgr").innerHTML = document.getElementById("txtSecMgr").value;
	$("#btnccprint").hide();
	var divToPrint = document.getElementById('ConCompDisplay');
    var popupWin = window.open();
	popupWin.document.open();
    popupWin.document.write('<html><head><link href="print-style.css" rel="stylesheet" /></head><body onload="window.print()"><div style="background:none; font-size:11px; font-family:Calibri">' + divToPrint.innerHTML + '</div></body></html>');
    popupWin.document.close();
	//$(".rDates").prop("readonly", false);
}

function PrintReport4(buname)
{
	//$(".rDates").prop("readonly", true);	
	// document.getElementById("tdSIC").innerHTML = document.getElementById("txtSIC").value;
	// document.getElementById("tdSecMgr").innerHTML = document.getElementById("txtSecMgr").value;
	$("#btnccprint").hide();
	var divToPrint = document.getElementById('ccConsDisplaySubSpecific');
    var popupWin = window.open();
	popupWin.document.open();
    popupWin.document.write('<html><head><link href="print-style.css" rel="stylesheet" /></head><body onload="window.print()"><div style="background:none; font-size:11px; font-family:Calibri">' + divToPrint.innerHTML + '</div></body></html>');
    popupWin.document.close();
	//$(".rDates").prop("readonly", false);
}

//function printDiv() {
//	 CloseReport();
//     var printContents = document.getElementById('modalReport').innerHTML;
//     var originalContents = document.body.innerHTML;
//
//     document.body.innerHTML = printContents;
//
//     window.print();
//
//     document.body.innerHTML = originalContents;
//}

function OpenRevisions(ticket_id)
{
	$("#modalRevisions").load("revise-disposition.php?ticket_id=" + ticket_id);
	$("#modalRevisions").dialog("open");
}

function OpenRevisions2(ticket_id)
{
	$("#modalRevisions").load("revise-logs.php?ticket_id=" + ticket_id);
	$("#modalRevisions").dialog("open");
}

function OpenRevisions3(ticket_id)
{
	$("#modalRevisions").load("edit-involved.php?ticket_id=" + ticket_id);
	$("#modalRevisions").dialog("open");
}

function OpenRevisions4(ticket_id)
{
	$("#modalRevisions").load("edit-vehicle.php?ticket_id=" + ticket_id);
	$("#modalRevisions").dialog("open");
}

function CloseReport()
{
	$("#modalReport").dialog("close");
}

function CloseRevisions()
{
	if(document.getElementById("reviselogsform"))
	{
		document.getElementById("reviselogsform").reset();
	}
	$("#modalRevisions").dialog("close");
}

function UpdateLogs()
{
	var x = document.getElementsByClassName('logsTicketId');
	var x2 = document.getElementsByClassName('logsLogId');
	var x3 = document.getElementsByClassName('logsDateCreated');
	var x4 = document.getElementsByClassName('logsTimeCreated');
	var x5 = document.getElementsByClassName('logsGuardId');
	var x6 = document.getElementsByClassName('logsRemarks');
	var x7 = document.getElementsByClassName('logsEncoder');
	var i;
	for (i = 0; i < x.length; i++) {
		document.getElementById("logsTicketIdAll").value += "*~" + x[i].innerHTML;
		document.getElementById("logsLogIdAll").value += "*~" + x2[i].innerHTML;
		document.getElementById("logsDateCreatedAll").value += "*~" + x3[i].innerHTML;
		document.getElementById("logsTimeCreatedAll").value += "*~" + x4[i].innerHTML;
		document.getElementById("logsGuardIdAll").value += "*~" + x5[i].innerHTML;
		document.getElementById("logsRemarksAll").value += "*~" + x6[i].value;
		document.getElementById("logsEncoderAll").value += "*~" + x7[i].innerHTML;
	}
	//alert(document.getElementById("logsDateCreatedAll").value)
	document.getElementById("reviselogsform").submit();
}

function UpdateRevisions()
{
	var x = document.getElementsByClassName('revisionsId');
	var x2 = document.getElementsByClassName('revisionsLogs');
	var x3 = document.getElementsByClassName('revisionsDateCreated');
	var x4 = document.getElementsByClassName('revisionsTimeCreated');
	var x5 = document.getElementsByClassName('revisionsGuardId');
	var x6 = document.getElementsByClassName('revisionsTicketId');
	var x7 = document.getElementsByClassName('revisionsEncoder');
	var x8 = document.getElementsByClassName('revisionsLogId');
	var i;
	for (i = 0; i < x.length; i++) {
		document.getElementById("revisionsIdAll").value += "*~" + x[i].innerHTML;
		document.getElementById("revisionsLogsAll").value += "*~" + x2[i].value;
		document.getElementById("revisionsDateCreatedAll").value += "*~" + x3[i].innerHTML;
		document.getElementById("revisionsTimeCreatedAll").value += "*~" + x4[i].innerHTML;
		document.getElementById("revisionsGuardIdAll").value += "*~" + x5[i].innerHTML;
		document.getElementById("revisionsTicketIdAll").value += "*~" + x6[i].innerHTML;
		document.getElementById("revisionsEncoderAll").value += "*~" + x7[i].innerHTML;
		document.getElementById("revisionsLogIdAll").value += "*~" + x8[i].innerHTML;
	
	}
	var answer = confirm("Logs can only be revised up to two (2) times. Are you sure you want to submit this revision?" )
	
	if(answer !=0)
	{
		document.getElementById("reviselogsform").submit();
	}
}

function UpdateInvolved(id, type)
{
	document.getElementById("editIPType").value = type;
	if(type == "suspect")
	{
		var prefix = "s";
	}
	else if(type == "witness")
	{
		var prefix = "w";
	}
	else if(type == "victim")
	{
		var prefix = "v";
	}
	//document.getElementById("editIPFname").value = document.getElementById(prefix + "Fname" + id).value;
	document.getElementById("editIPFName").value = $("#"+prefix+"FName"+id).val();
	document.getElementById("editIPMName").value = document.getElementById(prefix + "MName" + id).value;
	document.getElementById("editIPLName").value = document.getElementById(prefix + "LName" + id).value;
	document.getElementById("editIPAddress").value = document.getElementById(prefix + "Address" + id).value;
	document.getElementById("editIPContact").value = document.getElementById(prefix + "Contact" + id).value;
	document.getElementById("editIPAge").value = document.getElementById(prefix + "Age" + id).value;
	document.getElementById("editIPGender").value = document.getElementById(prefix + "Gender" + id).value;
	document.getElementById("editIPHeight").value = document.getElementById(prefix + "Height" + id).value;
	document.getElementById("editIPWeight").value = document.getElementById(prefix + "Weight" + id).value;
	document.getElementById("editIPIDType").value = document.getElementById(prefix + "idType" + id).value;
	document.getElementById("editIPIDNumber").value = document.getElementById(prefix + "idNumber" + id).value;
	document.getElementById("editIPRemark").value = document.getElementById(prefix + "Remarks" + id).value;
	document.getElementById("editIPIDNum").value = id;
	document.getElementById("reviseinvolvedform").submit();
	
}

function UpdateInvolved2()
{
	var fname = document.getElementsByClassName("iFName");
	var mname = document.getElementsByClassName("iMName");
	var lname = document.getElementsByClassName("iLName");
	var address = document.getElementsByClassName("iAddress");
	var contact = document.getElementsByClassName("iContact");
	var age = document.getElementsByClassName("iAge");
	var gender = document.getElementsByClassName("iGender");
	var height = document.getElementsByClassName("iHeight");
	var weight = document.getElementsByClassName("iWeight");
	var idtype = document.getElementsByClassName("iidType");
	var idnumber = document.getElementsByClassName("iidNumber");
	var remarks = document.getElementsByClassName("iRemarks");
	var number = document.getElementsByClassName("iNumber");
	var type = document.getElementsByClassName("iUpdateType");
	var i;
	for (i = 0; i < number.length; i++)
	{
		document.getElementById("editIPFName").value  += "*~" + fname[i].value;
		document.getElementById("editIPMName").value  += "*~" + mname[i].value;
		document.getElementById("editIPLName").value  += "*~" + lname[i].value;
		document.getElementById("editIPAddress").value  += "*~" + address[i].value;
		document.getElementById("editIPContact").value  += "*~" + contact[i].value;
		document.getElementById("editIPAge").value  += "*~" + age[i].value;
		document.getElementById("editIPGender").value  += "*~" + gender[i].value;
		document.getElementById("editIPHeight").value  += "*~" + height[i].value;
		document.getElementById("editIPWeight").value  += "*~" + weight[i].value;
		document.getElementById("editIPIDType").value  += "*~" + idtype[i].value;
		document.getElementById("editIPIDNumber").value  += "*~" + idnumber[i].value;
		document.getElementById("editIPRemark").value  += "*~" + remarks[i].value;
		document.getElementById("editIPIDNum").value  += "*~" + number[i].value;
		document.getElementById("editIPType").value  += "*~" + type[i].value;
	}
	document.getElementById("reviseinvolvedform").submit();
}

function UpdateVehicle()
{
	var owner = document.getElementsByClassName("veOwner");
	var plateno = document.getElementsByClassName("vePlateNo");
	var color = document.getElementsByClassName("veColor");
	var type = document.getElementsByClassName("veType");
	var make = document.getElementsByClassName("veMake");
	var model = document.getElementsByClassName("veModel");
	var remarks = document.getElementsByClassName("veRemarks");
	var idnum = document.getElementsByClassName("veNumber");
	var i;
	for (i = 0; i < plateno.length; i++)
	{
		document.getElementById("editVOwner").value  += "*~" + owner[i].value;
		document.getElementById("editVPlateNo").value  += "*~" + plateno[i].value;
		document.getElementById("editVColor").value  += "*~" + color[i].value;
		document.getElementById("editVType").value  += "*~" + type[i].value;
		document.getElementById("editVMake").value  += "*~" + make[i].value;
		document.getElementById("editVModel").value  += "*~" + model[i].value;
		document.getElementById("editVRemarks").value  += "*~" + remarks[i].value;
		document.getElementById("editVIDNumber").value  += "*~" + idnum[i].value;
	}
	document.getElementById("revisevehicleform").submit();
}

function showGraphTicketFilters()
{
	$("#divGraphSearchee").load("ticket-filters.php?token=monitoringgraph");
}

function prepareChart()
{
	document.getElementById("chartdiv").innerHTML = "";
	type = document.getElementById("searchGraph").value;
	idx = "";
	id = "";
	if(type == "y-axis_type")
	{
		id = document.getElementById("selRGBU").value;
	}
	else if(type == "y-axis_bu")
	{
		id = document.getElementById("selRGIncident").value;
		idx = document.getElementById("selRGBU4").value;
	}
	else if(type == "y-axis_location")
	{
		id = document.getElementById("selRGBU2").value;		
		idx = document.getElementById("selRGLoc").value;
	}
	else if(type == "y-axis_guard")
	{
		id = document.getElementById("selRGBU3").value;		
		idx = document.getElementById("selRGGuard").value;
	}
	else if(type == "y-axis_guard2")
	{
		id = document.getElementById("selRGBU3").value;		
		idx = document.getElementById("selRGGuard").value;
	}
	date_start = document.getElementById("txtRGDateStart").value;
	date_end = document.getElementById("txtRGDateEnd").value;
		
	$.get("generate-chart.php?id=" + id + "&type=" + type + "&dstart=" + date_start + "&dend=" + date_end + "&idx=" + idx, GenerateChart);	
}

function GenerateChart(data)
{
	
	var strticksdata = data.split("//");
	var strticks = strticksdata[0].split(",");
	var strdata = strticksdata[1].split(",").map(Number);
	
	 	$.jqplot.config.enablePlugins = true;
        var s1 = strdata;
        var ticks = strticks;
		plot1 = $.jqplot('chartdiv', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
			
			seriesColors: ["#fa9191"],
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
				rendererOptions: {
                    barDirection: 'horizontal' ,
					barWidth: 5
                },
                pointLabels: { show: true }
            },
            axes: {
                yaxis: {
					
                    renderer: $.jqplot.CategoryAxisRenderer,					
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
	// var minY = plot1.axes.yaxis.dataBounds.min;
    // var maxY = plot1.axes.yaxis.dataBounds.max;
	// plot1.axes.yaxis.min = minY;
	// plot1.axes.yaxis.max = maxY;
	var cheight = plot1.axes.yaxis._numberTicks;
	var cheight2 = cheight*10;
	 $('#chartdiv').height(cheight2);
	 plot1.replot();
}

function GenerateChart2(data)
{
	
	var strticksdata = data.split("//");
	var strticks = strticksdata[0].split(",");
	var strdata = strticksdata[1].split(",").map(Number);
	
	 	$.jqplot.config.enablePlugins = true;
        var s1 = strdata;
        var ticks = strticks;
		plot1 = $.jqplot('divTotalInc', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
			title: 'Top 5 BUs by Incident Count',
			seriesColors: ["#fa9191"],
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
				rendererOptions: {
                    barDirection: 'horizontal'  
                },
                pointLabels: { show: true }
            },
            axes: {
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,					
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });	
}

function GenerateChart3(data)
{
	var strticksdata0 = data.split("\\");
	var data1 = strticksdata0[0];
	var charttitle = 'Top 5 Locations by Incident Count';
	if(strticksdata0[1] == 1)
	{
		charttitle = "PAs with Most Logs";
	}
	var strticksdata = data1.split("//");
	var strticks = strticksdata[0].split(",");
	var strdata = strticksdata[1].split(",").map(Number);
	
	 	$.jqplot.config.enablePlugins = true;
        var s1 = strdata;
        var ticks = strticks;
		plot1 = $.jqplot('divTotalInc', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
			title: charttitle,
			seriesColors: ["#fa9191"],
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
				rendererOptions: {
                    barDirection: 'horizontal'  
                },
                pointLabels: { show: true }
            },
            axes: {
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,					
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });	
}

function GenerateChart4(data)
{	
	var strticksdata = data.split("//");
	var strticks = strticksdata[0].split(",");
	var strdata = strticksdata[1].split(",").map(Number);
	
	 	$.jqplot.config.enablePlugins = true;
        var s1 = strdata;
        var ticks = strticks;
		plot1 = $.jqplot('divTotalInc', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
			title: 'Daily Log Count',
			seriesColors: ["#fa9191"],
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
				rendererOptions: {
                    barDirection: 'vertical'  
                },
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,					
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });	
}


function toggleReportChart(header1, div1, cat1)
{
	$("#divGraphLinks").show();
	$(".rglink").removeClass("whiteonblack");
	$("#" + header1).addClass("whiteonblack");
	$(".divGraphCategory").hide();
	$("#" + div1).show();
	document.getElementById("searchGraph").value = cat1;
	document.getElementById("chartdiv").innerHTML = "";
}

function toggleReportChart2(div1, cat1)
{
	$("#divGraphLinks").hide();
	$(".divGraphCategory").hide();	
	$("#" + div1).show();
	document.getElementById("searchGraph").value = cat1;
	document.getElementById("chartdiv").innerHTML = "";
}

function loadLocation()
{
	id = document.getElementById("selRGBU2").value;
	type = "dropdownLocation2";
	$("#selRGLoc").load("getinfo.php?id=" + id + "&type=" + type);
}

function loadGuard()
{
	id = document.getElementById("selRGBU3").value;
	type = "dropdownGuard2";
	$("#selRGGuard").load("getinfo.php?id=" + id + "&type=" + type);
}

function loadLocationGuard()
{
	id = document.getElementById("selRTBU").value;
	type = "dropdownLocation2";
	type2 = "dropdownGuard2";
	$("#selRTLoc").load("getinfo.php?id=" + id + "&type=" + type);
	$("#selRTGuard").load("getinfo.php?id=" + id + "&type=" + type2);
}

function loadLocationGuard2()
{
	id = document.getElementById("txtSearchIncLogBU").value;
	type = "dropdownLocation2";
	type2 = "dropdownGuard2";
	$("#selSearchIncLogLoc").load("getinfo.php?id=" + id + "&type=" + type);
	$("#selSearchIncLogGuard").load("getinfo.php?id=" + id + "&type=" + type2);
}

function generateReportTable()
{
	dstart = document.getElementById("txtRTDateStart").value;
	dend = document.getElementById("txtRTDateEnd").value;
	bu = document.getElementById("selRTBU").value;
	loc = document.getElementById("selRTLoc").value;
	guard = document.getElementById("selRTGuard").value;
	//inctype = document.getElementById("selRTIncident").value;
	acttype = document.getElementById("selRTActivity").value;
	tag = document.getElementById("txtReportTableType").value;
	urc = document.getElementById("selRTURC").value;
	if(tag == 'incident')
	{		
		$("#modalIncMonitoring").load("generate-report-table.php?bu="+ bu +"&inc="+ inctype +"&loc="+ loc +"&guard="+ guard +"&dstart="+ dstart +"&dend="+ dend +"&type=1");		
	}
	else if(tag == 'activity')
	{		
		$("#modalIncMonitoring").load("generate-report-table.php?bu="+ bu +"&act="+ acttype +"&loc="+ loc +"&guard="+ guard +"&dstart="+ dstart +"&dend="+ dend +"&type=2" + "&urc=" + urc);		
	}
	$("#modalIncMonitoring").dialog("open");
}

function generateReportTable2()
{
	dstart = document.getElementById("searchIncLogStart").value;
	dend = document.getElementById("searchIncLogEnd").value;
	bu = document.getElementById("txtSearchIncLogBU").value;
	loc = document.getElementById("selSearchIncLogLoc").value;
	guard = document.getElementById("selSearchIncLogGuard").value;
	inctype = document.getElementById("selSearchIncLogType").value;
	acttype = document.getElementById("selRTActivity").value;
	tag = document.getElementById("txtReportTableType").value;
	urc = document.getElementById("selSearchIncLogURC").value;
	main = document.getElementById("selSearchIncLogMain").value;
	sub = document.getElementById("selSearchIncLogSub").value;
	if(tag == 'incident')
	{		
		$("#modalIncMonitoring").load("generate-report-table.php?bu="+ bu +"&inc="+ inctype +"&loc="+ loc +"&guard="+ guard +"&dstart="+ dstart +"&dend="+ dend + "&main=" + main + "&sub=" + sub + "&type=1");		
	}
	else if(tag == 'activity')
	{		
		$("#modalIncMonitoring").load("generate-report-table.php?bu="+ bu +"&act="+ acttype +"&loc="+ loc +"&guard="+ guard +"&dstart="+ dstart +"&dend="+ dend +"&type=2" + "&urc=" + urc);		
	}
	$("#modalIncMonitoring").dialog("open");
}

function removeColumn(colnum)
{
	$('#tblIncMonForm').find('td:eq('+colnum+'),th:eq('+colnum+')').remove();
}

function closeReportTable()
{
	$("#modalIncMonitoring").dialog("close");
}

function toggleReportTable(action)
{
	if(action == 'incident')
	{		
		$("#tblreportgenhead").hide();
		$("#divReportTableAct").hide();
		$("#tblreportgenfoot").hide();
		$("#divReportTableInc").load("ticket-filters.php?token=monitoringform");
		$("#divReportTableInc").show();
		$("#divIncFilters").empty();

	}
	else if(action == 'activity')
	{
		$("#divReportTableInc").hide();
		$("#tblreportgenhead").show();
		$("#tblreportgenfoot").show();
		$("#divReportTableAct").show();
	}
	document.getElementById("txtReportTableType").value = action;
}

function lockSelect()
{
	if(document.getElementById("selRGIncident").value == 0)
	{
		document.getElementById("selRGBU4").value = 0;
		document.getElementById("selRGBU4").disabled = true;
	}
	else
	{
		document.getElementById("selRGBU4").disabled = false;
	}
}

function lockSelect2()
{
	if(document.getElementById("selRGIncident").value == 0)
	{
		document.getElementById("searchGraph").value = "y-axis_type";
	}
	else
	{
		document.getElementById("searchGraph").value = "y-axis_bu";
	}
}

function loadCharts()
{
	$.get("generate-dashboard.php?type=meter", generateMeter);
	$.get("generate-dashboard.php?type=line", generateLine);
	$("#tblSecAgLicenseTbody").load("generate-dashboard.php?type=agency");
	$("#tblSecAgContractTbody").load("generate-dashboard.php?type=agency2");
	$("#tblSecAgOtherLicensesTbody").load("generate-dashboard.php?type=agency3");
	$.get("generate-dashboard.php?type=total", GenerateChart2);
}

function loadCharts2()
{
	$.get("generate-dashboard.php?type=meter", generateMeter2);
	$.get("generate-dashboard.php?type=line", generateLine);
	$("#tblSecAgLicenseTbody").load("generate-dashboard.php?type=guard");
	$("#tblSecAgContractTbody").load("generate-dashboard.php?type=agency2");
	$("#tblSecAgOtherLicensesTbody").load("generate-dashboard.php?type=agency3");
	$.get("generate-dashboard.php?type=total2", GenerateChart3);
}

function loadCharts3()
{
	
	$.get("generate-dashboard.php?type=line3", generateLineExpro);
	$("#tblSecAgLicenseTbody").load("generate-dashboard.php?type=guard");
	$("#tblSecAgContractTbody").load("generate-dashboard.php?type=agency2");
	$("#tblSecAgOtherLicensesTbody").load("generate-dashboard.php?type=agency3");
	$.get("generate-dashboard.php?type=total3", GenerateChart4);
}

function generateMeter(data)
{
	var s1 = [];
	s1.push(data);
	if(data == 0)
	{
		var zeroticks = [0, 20, 40, 60, 80, 100];
		var label1 = 0;
	}
	else
	{
		var label1 = s1[0];
	}
 
   plot3 = $.jqplot('divMeter',[s1],{
	   title: 'Total Incidents Across All BUs this month',
	   
       seriesDefaults: {		   
           renderer: $.jqplot.MeterGaugeRenderer,
           rendererOptions: {
			  tickColor: "#FF0000",
			  ticks: zeroticks,		  
			  ringColor: "#000000",
              label: label1 +' Incident(s)',
			  labelPosition: 'inside'			  
           }
       }
   });
}

function generateMeter2(data)
{
	var s1 = [];
	s1.push(data);
	if(data == 0)
	{
		var zeroticks = [0, 20, 40, 60, 80, 100];
		var label1 = 0;
	}
	else
	{
		var label1 = s1[0];
	}
 
   plot3 = $.jqplot('divMeter',[s1],{
	   title: 'TOTAL INCIDENTS THIS MONTH',
	   
       seriesDefaults: {		   
           renderer: $.jqplot.MeterGaugeRenderer,
           rendererOptions: {
			  tickColor: "#FF0000",
			  ticks: zeroticks,		  
			  ringColor: "#000000",
              label: label1 +' Incident(s)',
			  labelPosition: 'inside'			  
           }
       }
   });
}

function generateLine(data)
{
	var startdata = data.split("//");
	var strdata = startdata[0].split(",").map(Number);
	var strdata2 = startdata[2].split(",").map(Number);
	var year1 = (new Date().getFullYear());
	var year2 = ((new Date().getFullYear()) - 1);
	var year1total = startdata[1];
	var year2total = startdata[3];
	var s1 = strdata;
	var s2 = strdata2;
	var plot2 = $.jqplot ('divLine', [s1,s2], {
      // Give the plot a title.
      title: 'Monthly Incident Count Over the Past Year',
      // You can specify options for all axes on the plot at once with
      // the axesDefaults object.  Here, we're using a canvas renderer
      // to draw the axis label which allows rotated text.
      axesDefaults: {
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		tickRenderer: $.jqplot.CanvasAxisTickRenderer 
		
      },
      // Likewise, seriesDefaults specifies default options for all
      // series in a plot.  Options specified in seriesDefaults or
      // axesDefaults can be overridden by individual series or
      // axes options.
      // Here we turn on smoothing for the line.
      seriesDefaults: {
		  pointLabels: {
                show: true
            },
          rendererOptions: {
              
          }
      },
	  legend: { show: true},
	  series: [
                { label: year1 + ' (' + year1total + ')' },
				{ label: year2 + ' (' + year2total + ')' }
        ],
      // An axes object holds options for all axes.
      // Allowable axes are xaxis, x2axis, yaxis, y2axis, y3axis, ...
      // Up to 9 y axes are supported.
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
		  renderer: $.jqplot.CategoryAxisRenderer,
          
          // Turn off "padding".  This will allow data point to lie on the
          // edges of the grid.  Default padding is 1.2 and will keep all
          // points inside the bounds of the grid.
          pad: 0,
		  
		  tickOptions: {
			  
          fontFamily: 'Calibri',
          fontSize: '10pt',
          angle: -30
        },
		  ticks: ['January','February','March','April','May','June','July','August','September','October','November','December']
        },
        yaxis: {
          
		  min: 0
        }
		
      }
	  
    });
}

function generateLineExpro(data)
{
	var startdata = data.split("//");
	var strdata = startdata[0].split(",").map(Number);
	var strdata2 = startdata[2].split(",").map(Number);
	var year1 = (new Date().getFullYear());
	var year2 = ((new Date().getFullYear()) - 1);
	var year1total = startdata[1];
	var year2total = startdata[3];
	var s1 = strdata;
	var s2 = strdata2;
	var plot2 = $.jqplot ('divLine', [s1,s2], {
      // Give the plot a title.
      title: 'Monthly Activity Logs',
      // You can specify options for all axes on the plot at once with
      // the axesDefaults object.  Here, we're using a canvas renderer
      // to draw the axis label which allows rotated text.
      axesDefaults: {
        labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		tickRenderer: $.jqplot.CanvasAxisTickRenderer 
		
      },
      // Likewise, seriesDefaults specifies default options for all
      // series in a plot.  Options specified in seriesDefaults or
      // axesDefaults can be overridden by individual series or
      // axes options.
      // Here we turn on smoothing for the line.
      seriesDefaults: {
		  pointLabels: {
                show: true
            },
          rendererOptions: {
              
          }
      },
	  legend: { show: true},
	  series: [
                { label: year1 + ' (' + year1total + ')' },
				{ label: year2 + ' (' + year2total + ')' }
        ],
      // An axes object holds options for all axes.
      // Allowable axes are xaxis, x2axis, yaxis, y2axis, y3axis, ...
      // Up to 9 y axes are supported.
      axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
		  renderer: $.jqplot.CategoryAxisRenderer,
          
          // Turn off "padding".  This will allow data point to lie on the
          // edges of the grid.  Default padding is 1.2 and will keep all
          // points inside the bounds of the grid.
          pad: 0,
		  
		  tickOptions: {
			  
          fontFamily: 'Calibri',
          fontSize: '10pt',
          angle: -30
        },
		  ticks: ['January','February','March','April','May','June','July','August','September','October','November','December']
        },
        yaxis: {
          
		  min: 0
        }
		
      }
	  
    });
}

function toggleExpiry()
{
	if(document.getElementById("divSecAgencyLicense").style.display == 'none')
	{
		$("#divSecAgencyLicense").show();
		$("#divSecAgencyContract").hide();
	}
	else if(document.getElementById("divSecAgencyContract").style.display == 'none')
	{
		$("#divSecAgencyLicense").hide();
		$("#divSecAgencyContract").show();
	}
}

function toggleExpiry2(tag)
{
	$("#divSecAgencyLicense").hide();
	$("#divSecAgencyContract").hide();
	$("#divSecAgencyOtherLicenses").hide();
	$("#"+ tag).show();
}

function initialLogs(type)
{
	if(type == 'Inc')
	{
		$("#tbodyIncidentTable").load("initial-logs-revised.php?type="+type);
	}
	else if(type == 'Act')
	{
		$("#tbodyActivityTable").load("initial-logs-revised.php?type="+type);
	}
	else if(type == 'Guard')
	{
		$("#tbodyGuards").load("initial-logs.php?type="+type);
	}
	
}

function searchLogs(type)
{
	dstart = "";
	dend = "";
	sbu = "";
	acttype = "";
	urc = "";
	loc = "";
	guard = "";
	username = "";
	lastname = "";
	firstname = "";
	tid = "";
	maincat = "";
	subcat = "";
	if(type == 1)
	{
		dstart = document.getElementById("searchIncLogStart").value;
		dend = document.getElementById("searchIncLogEnd").value;
		sbu = document.getElementById("txtSearchIncLogBU").value;
		acttype = document.getElementById("selSearchIncLogType").value;
		urc = document.getElementById("selSearchIncLogURC").value;
		loc = document.getElementById("selSearchIncLogLoc").value;
		guard = document.getElementById("selSearchIncLogGuard").value;
		tid = document.getElementById("txtSearchTicketId").value;
		maincat = document.getElementById("selSearchIncLogMain").value;
		subcat = document.getElementById("selSearchIncLogSub").value;
		$("#tbodyIncidentTable").load("search-logs.php?ttype="+type+"&dstart="+dstart+"&dend="+dend+"&sbu="+sbu+"&acttype="+acttype+"&urc="+urc+"&loc="+loc+"&guard="+guard+"&tid="+tid+"&main_cat="+maincat+"&sub_cat="+subcat);
	}
	else if(type == 2)
	{
		dstart = document.getElementById("searchActLogStart").value;
		dend = document.getElementById("searchActLogEnd").value;
		sbu = document.getElementById("txtSearchActLogBU").value;
		acttype = document.getElementById("selSearchActLogType").value;
		urc = document.getElementById("selSearchActLogURC").value;
		loc = document.getElementById("selSearchActLogLoc").value;
		guard = document.getElementById("selSearchActLogGuard").value;
		tid = document.getElementById("txtSearchTicketId2").value;
		$("#tbodyActivityTable").load("search-logs.php?ttype="+type+"&dstart="+dstart+"&dend="+dend+"&sbu="+sbu+"&acttype="+acttype+"&urc="+urc+"&loc="+loc+"&guard="+guard+"&tid="+tid);
	}
	else if(type == 3)
	{
		dstart = document.getElementById("searchSysLogStart").value;
		dend = document.getElementById("searchSysLogEnd").value;
		sbu = document.getElementById("txtSearchSysLogBU").value;
		username = document.getElementById("txtSysLogUsername").value;
		lastname = document.getElementById("txtSysLogLName").value;
		firstname = document.getElementById("txtSysLogFName").value;
		$("#tbodySysLogs").load("search-syslogs.php?dstart="+dstart+"&dend="+dend+"&sbu="+sbu+"&username="+username+"&lastname="+lastname+"&firstname="+firstname);
	}
	
}

function toggleFilters(name)
{
	if(document.getElementById(name).style.display == "none")
	{
		if(name == "divIncFilters")
		{
			$("#"+name).load("ticket-filters.php");
		}
		$("#"+name).show();
	}
	else
	{
		$("#"+name).hide();
	}
}


function refreshPage(tag, level)
{	
	window.location.href = level+".php?last="+tag;		
}

function resetPass()
{
	usersid = document.getElementById("usersid").value;
	$.get("reset-pass.php?id="+usersid, changePass)
}

function changePass(data)
{
	alert(data);
	closeAddUser();
}

function checkUsername()
{
	username = document.getElementById("usersusername").value;
	$.get("check-username.php?uname="+username, verifyUsername);
}

function verifyUsername(data)
{
	if(data == 1)
	{
		document.getElementById("btnedituser").disabled = true;
		document.getElementById("btnsaveuser").disabled = true;
		document.getElementById("lbluserstat").style.color = "#FF0000";
		document.getElementById("lbluserstat").innerHTML = "Username unavailable";
	}
	else if(data == 0)
	{
		document.getElementById("btnedituser").disabled = false;
		document.getElementById("btnsaveuser").disabled = false;
		document.getElementById("lbluserstat").style.color = "#009900";
		document.getElementById("lbluserstat").innerHTML = "Username available";
	}
}

function csvexport(targetarray)
{	
	var csvContent = "data:text/csv;charset=utf-8,";
	targetarray.forEach(function(infoArray, index){

	   dataString = infoArray.join(",");
	   csvContent += index < targetarray.length ? dataString+ "\n" : dataString;

	}); 
	
	var finalarrayURI = encodeURIcomponent(csvContent);
	window.open(finalarrayURI);
}


//function calcHeight(ht)
//{
//	if(ht == 'cm')
//	{
//		feet = Math.floor((document.getElementById('witheight').value/2.54)/12);
//		inches = (document.getElementById('witheight').value/2.54)%12;
//		document.getElementById('witheightft').value = feet;
//		document.getElementById('witheightin').value = inches;
//	}
//	else if(ht == 'ft')
//	{
//		centimeters = ((document.getElementById('witheightft').value * 12) + document.getElementById('witheightin').value)*2.54;
//		document.getElementById('witheight').value = centimeters;
//	}
//	var centimeters = ((document.getElementById('witheightft').value*12)+document.getElementById('witheightin').value)*2.54;
//	var feet = Math.floor((document.getElementById('wiheight').value/2.54)/12);
//	var inches = (document.getElementById('witheight').value/2.54)%12;
//	document.getElementById('wiheight').value = centimeters;
//}




//$(function(){
//	$("#txturc").keyup(function() {
//		$("#urcdesc").load("getinfo.php?choice=" + $("#txturc").val());		
//		});
//		$("#txturc2").keyup(function() {
//		$("#urcdesc2").load("getinfo.php?choice=" + $("#txturc2").val());		
//		});
//});

var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
var lineChartData = {
	labels : ["January","February","March","April","May","June","July","August","September","October","November","December"],
	datasets : [
		{
            label: "Year minus one",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
		{		
			label: "This Year",
			fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(151,187,205,1)",
			data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
		}
		
	]
}
var barChartData = {
	labels : ["Inrusion", "Vehicular Accident", "Theft", "Fire", "Tresspassing", "Counterfeit", "Workplace Violemce", "Pilfering", "Flood"],
	datasets : [
		{
            label: "Incident Types",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        }
		
	]
}
var barChartData2 = {
	labels : ["Warehouse 1", "Admin", "Plant A", "Lobby", "21st Floor"],
	datasets : [
		{
            label: "Incident Locations",
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,0.8)",
            highlightFill: "rgba(151,187,205,0.75)",
            highlightStroke: "rgba(151,187,205,1)",
            data: [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        }
		
	]
}

$(document).ready(function() {
	
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
		  .attr( "autofocus", true )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  });
 
 $(document).ready(function() {
	  // ------------------ MODAL FOR BIDDING -----------------
	$( "#addBiddingDiv" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 650,
		position: {my: "top", at: "center", of: "#topbar"}
  	});

	$( "#editBiddingModal" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 850,
		position: {my: "top", at: "center", of: "#topbar"}
  	}); 
	$( "#addBiddingDocument" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 500,
		position: {my: "top", at: "center", of: "#topbar"}
  	}); 
	$( "#initializeBiddingSection" ).dialog({
		dialogClass: "no-close",	
		width: 800,	
		maxHeight: 600,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,

  	});
	$( "#viewsecagencymodal" ).dialog({
		dialogClass: "no-close",	
		width: 1200,
		maxHeight: 800,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "center", of: "#topbar"}
  	});
	$( "#addsecagencymodal" ).dialog({
		dialogClass: "no-close",	
		width: 1400,
		maxHeight: 800,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "center", of: "#topbar"}
  	});
	$( "#AddActivity" ).dialog({
		dialogClass: "no-close",
		width: 800,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#back" ).click(function() {
		document.getElementById("addForm").reset();
		$( "#AddActivity" ).dialog( "close");
	});
	$( ".addlog" ).click(function() {
      	$( "#AddActivity" ).dialog( "open")
    });
	
    $( "#combobox" ).combobox();
	$( "#txtguard" ).combobox({
			autoFocus: true
		});
	$( "#txtlocation" ).combobox({
			autoFocus: true
		});
	$( "#txturc" ).combobox({
			autoFocus: true
		});
	
	$( "#btnchangepass" ).click(function() {
      	$( "#changepass" ).dialog({
		dialogClass: "no-close",
		width: 400,
		modal: true,
		closeOnEscape: false,
		resizable: false
  		});
		$( "#closecpass" ).click(function() {
			$( "#changepass" ).dialog( "close");
		});
    });
	
		$( "#SWdiv" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  		});
		
		$( "#closeincidentmodal" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 900,
		maxHeight: 550,
		position: {my: "top", at: "center", of: "#topbar"}
  		});
		
		$( "#modalAudit" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 650,
		maxHeight: 610,
		position: {my: "top", at: "top", of: "#topbar"}
  		});
		
		$( "#modalIDP" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 850,
		maxHeight: 610,
		position: {my: "top", at: "center", of: "#topbar"}
  		});
		
		$( "#editCCModal" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 850,
		position: {my: "top", at: "center", of: "#topbar"}
  		});
		
		$( "#addGuard" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 1100,
		position: {my: "top", at: "center", of: "#topbar"},
		open: function( event, ui ) 
		{
		if($("#txtgbdate").val())
		{
			var gbirthdate = new Date($("#txtgbdate").val());
			var gnow = new Date();
			var guardage = gnow.getFullYear() - gbirthdate.getFullYear();
			if((gnow.getMonth() < gbirthdate.getMonth()) || (gnow.getMonth() == gbirthdate.getMonth() && gnow.getDate() < gbirthdate.getDate()))
			{
				guardage--;
			}
			document.getElementById("txtgage").value = guardage;
		}
		}
  		});
	$( "#syes" ).click(function() {
      	$( ".suspform ").prop("disabled", false);
    });
	$( "#sno" ).click(function() {
      	$( ".suspform ").prop("disabled", true);
		document.getElementById("suspectForm").reset();
    });
	$( "#wback" ).click(function() {
			//document.getElementById("suspectForm").reset();
			document.getElementById("witnessForm").reset();
			$( ".suspform ").prop("disabled", true);
			$( "#SWdiv" ).dialog( "close");
		});
	$( "#editcontact" ).click(function() {
      	$( "#changeucontact" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false
  		});;
		$( "#closecontact" ).click(function() {
			document.getElementById("usercontactnew").value = "";
			$( "#changeucontact" ).dialog( "close");
		});
    });
	/* $( "#btnaddguard" ).click(function() {
		document.getElementById("btnsaveguard").style.display = "initial";
		document.getElementById("btneditguard").style.display = "none";
		document.getElementById("trguardstat").style.display = "none";
		$(".guardphototd").hide();
		document.getElementById("selgstat").disabled = true;
		$("select.addguards").prop("disabled", false);
		$( "#addGuard" ).dialog( "open" );
		}); */
	$( "#gback" ).click(function(event) {
		event.preventDefault();
		$( "#addGuard" ).dialog( "close" );	
		document.getElementById("addguardform").reset();	
	});
	$( "#btnBackRetract" ).click(function(event) {
		event.preventDefault();
		$( "#RequestRetractModal" ).dialog( "close" );	
		document.getElementById("frmRetractLevel").reset();	
	});
	$( "#btnBackDeletion" ).click(function(event) {
		event.preventDefault();
		$( "#RequestDeletionModal" ).dialog( "close" );
	});
	$( "#btnCancelUpload" ).click(function(event) {
		event.preventDefault();
		$( "#divUploadModal" ).dialog( "close" );	
		document.getElementById("frmUpload").reset();	
	});
	$( "#btnCancelUpload2" ).click(function(event) {
		event.preventDefault();
		$( "#divUploadModal" ).dialog( "close" );	
		document.getElementById("frmUpload").reset();	
	});
	$( "#btnBackApproval" ).click(function(event) {
		event.preventDefault();
		$( "#ApproveRetractModal" ).dialog( "close" );	
		document.getElementById("frmApproveRetract").reset();	
	});
	$( "#btnBackDeletionApproval" ).click(function(event) {
		event.preventDefault();
		$( "#ApproveDeletionModal" ).dialog( "close" );	
		document.getElementById("frmApproveDeletion").reset();
	});
	$( "#btnCloseAddPDFlicense" ).click(function(event) {
		event.preventDefault();
		$( "#addPDFmodal" ).dialog( "close" );	
		document.getElementById("addPDFform").reset();
	});
	$( "#btnCloseAddAuditEvidence" ).click(function(event) {
		event.preventDefault();
		$( "#addAuditEvidencemodal" ).dialog( "close" );	
		document.getElementById("addAuditEvidenceform").reset();
	});
	$( "#btnCloseAddTest" ).click(function(event) {
		event.preventDefault();
		$( "#testCSV" ).dialog( "close" );	
		document.getElementById("frmTestCSV").reset();
	});
	$( "#btnStakeholderClose" ).click(function(event) {
		event.preventDefault();
		$( "#modalStakeholder" ).dialog( "close" );	
		document.getElementById("frmStakeholder").reset();
	});
	
		
	$("#txtgbdate").change(function (){
		var gbirthdate = new Date($("#txtgbdate").val());
		var gnow = new Date();		
		var guardage = gnow.getFullYear() - gbirthdate.getFullYear();
		if((gnow.getMonth() < gbirthdate.getMonth()) || (gnow.getMonth() == gbirthdate.getMonth() && gnow.getDate() < gbirthdate.getDate()))
		{
			guardage--;
		}
		document.getElementById("txtgage").value = "";
		if(document.getElementById("txtgbdate").value){
			document.getElementById("txtgage").value = guardage;
		}
	});
	$( "#addlocsmodal" ).dialog({
		dialogClass: "no-close",
		maxHeight: 300,
		width: 400,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#btnaddlocation" ).click(function() {
		$( "#addlocsmodal" ).dialog( "open" );
		
	});
	$( "#addoicform" ).dialog({
		dialogClass: "no-close",
		
		width: 350,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#RequestDeletionModal" ).dialog({
		dialogClass: "no-close",
		
		width: 350,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#RequestRetractModal" ).dialog({
		dialogClass: "no-close",
		
		width: 350,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#ApproveRetractModal" ).dialog({
		dialogClass: "no-close",
		
		width: 350,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#ApproveDeletionModal" ).dialog({
		dialogClass: "no-close",
		
		width: 350,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#btnaddrecipient" ).click(function() {
		$( "#addoicform" ).dialog( "open" );
	});
	$( "#adduserdiv" ).dialog({
		dialogClass: "no-close",	
		width: 500,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#addmultiplebudiv" ).dialog({
		dialogClass: "no-close",	
		width: 450,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#btnadduser" ).click(function() {
		$( "#adduserdiv" ).dialog( "open" );
		$("#selaccess").val($("#txtAcctType").val());
		if(document.getElementById("selaccess").value == "Super Admin")
		{
			document.getElementById("seluserbu").disabled = true;
		}
		else
		{
			document.getElementById("seluserbu").disabled = false;
		}
	});
	$( "#secagencymodal" ).dialog({
		dialogClass: "no-close",	
		width: 900,
		maxHeight: 600,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#codemgtmodal" ).dialog({
		dialogClass: "no-close",	
		width: 400,
		maxHeight: 600,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: "#multi"}
  	});
	$( "#changeClassificationModal" ).dialog({
		dialogClass: "no-close",	
		width: 400,
		maxHeight: 600,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#divUploadModal" ).dialog({
		dialogClass: "no-close",	
		width: 900,
		maxHeight: 700,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#modalBU" ).dialog({
		dialogClass: "no-close",	
		width: 700,
		maxHeight: 600,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		
  	});
	$( "#modalbugroupregion" ).dialog({
		dialogClass: "no-close",		
		maxHeight: 600,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		
  	});
	$( "#modalincmainclass" ).dialog({
		dialogClass: "no-close",		
		maxHeight: 600,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#modaladdlocator" ).dialog({
		dialogClass: "no-close",		
		maxHeight: 600,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#modalEntries" ).dialog({
		dialogClass: "no-close",		
		height: 400,
		width: 850,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#modalEntries2" ).dialog({
		dialogClass: "no-close",		
		height: 400,
		width: 850,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#modalReport" ).dialog({
		dialogClass: "no-close",	
		width: 900,
		maxHeight: 700,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#modalRevisions" ).dialog({
		dialogClass: "no-close",	
		width: 900,
		maxHeight: 700,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$("#witheight").keyup(function() {		
		document.getElementById('witheightft').value = Math.floor((document.getElementById('witheight').value/2.54)/12);
		document.getElementById('witheightin').value = ((document.getElementById('witheight').value/2.54)%12).toFixed(2);
	});
	$("#witheightft").keyup(function() {
		document.getElementById('witheight').value = Math.round(((document.getElementById('witheightft').value * 12) * 2.54) + (document.getElementById('witheightin').value * 2.54));
	});
	$("#witheightin").keyup(function() {
		document.getElementById('witheight').value = Math.round(((document.getElementById('witheightft').value * 12) * 2.54) + (document.getElementById('witheightin').value * 2.54));
	});
	$( "#modalIncMonitoring" ).dialog({
		dialogClass: "no-close",	
		width: 1300,
		maxHeight: 650,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#addPDFmodal" ).dialog({
		dialogClass: "no-close",	
		width: 350,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#addAuditEvidencemodal" ).dialog({
		dialogClass: "no-close",	
		width: 350,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#testCSV" ).dialog({
		dialogClass: "no-close",	
		width: 350,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#viewAuditDetails" ).dialog({
		dialogClass: "no-close",	
		width: 500,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#viewAuditUpload" ).dialog({
		dialogClass: "no-close",	
		width: 900,
		maxHeight: 700,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		position: {my: "top", at: "top", of: window}
  	});
	$( "#viewAuditDisposition" ).dialog({
		dialogClass: "no-close",	
		width: 500,
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false
  	});
	$( "#modalStakeholder" ).dialog({
		dialogClass: "no-close",		
		modal: true,
		closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		width: 700,
		maxHeight: 610,
		position: {my: "top", at: "top", of: "#topbar"}
  		});
  });

