<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$resulttable = "";
$locatorlist = "";
$locatorsql = mysqli_query($conn, "SELECT * FROM bu_locators WHERE bu_id = ".$bu." AND status = 'Active' ORDER BY locator_name");
while($locatorres = mysqli_fetch_assoc($locatorsql))
{
	$locatorlist .= "<option value='".$locatorres['id']."'>".$locatorres['locator_name']."</option>";
}
$locatorportion = "";
$locatordropdown = "";


if($locatorlist)
{
	$locatorportion =	'<table width="50%" align="center">
							<tr>
								<td valign="top">
									<fieldset>
									<legend style="font-weight:bold">Locator</legend>
										<table>
											<tr>
												<td>Locator Name:</td>
												<td>
													<select id="selinclocator" name="selinclocator"><option value=""></option>'.$locatorlist.'</select>                                    	
												</td>
											</tr>                                
										</table>
									</fieldset>
								</td>
							</tr>
						</table>';
	$locatordropdown =	'<tr>
							<td>Locator:</td>
							<td>
								<select id="selinclocator" name="selinclocator"><option value=""></option>'.$locatorlist.'</select>                                    	
							</td>
						</tr> ';
}

$actionpost = "";
if($_SESSION['level'] == "Super Admin")
{
	$actionpost = "user-superadmin.php";
}
elseif($_SESSION['level'] == "Admin")
{
	$actionpost = "user-admin.php";
}
elseif($_SESSION['level'] == "User")
{
	$actionpost = "user.php";
}

$resulttable = '<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeCloseIncident();" />
		<form id="closeincidentform" name="closeincidentform" method="post" action="'.$actionpost.'">
    	  <div id="involvedsection">
    	  <center>
          <fieldset style="display:inline-block; ">
          <legend style="font-weight:bold" >Person(s) Involved</legend>
          <table align="center">
            <tr>
                <td colspan="2">
                  <!-- <input type="radio" id="witness" name="involved" checked="checked" />Witness
                  <input type="radio" id="suspect" name="involved" />Suspect
                  <input type="radio" id="victim" name="involved" />Victim -->
				  <input type="hidden" id="iclassificationsall" name="iclassificationsall" />
				  
                  <input type="hidden" id="iwfnamesall" name="iwfnamesall" />
                  <input type="hidden" id="isfnamesall" name="isfnamesall" />
                  <input type="hidden" id="ivfnamesall" name="ivfnamesall" />
				  <input type="hidden" id="ifnamesall" name="ifnamesall" />
				  
                  <input type="hidden" id="iwmnamesall" name="iwmnamesall" />
                  <input type="hidden" id="ismnamesall" name="ismnamesall" />
                  <input type="hidden" id="ivmnamesall" name="ivmnamesall" />
				  <input type="hidden" id="imnamesall" name="imnamesall" />
				  
                  <input type="hidden" id="iwlnamesall" name="iwlnamesall" />
                  <input type="hidden" id="islnamesall" name="islnamesall" />
                  <input type="hidden" id="ivlnamesall" name="ivlnamesall" />
				  <input type="hidden" id="ilnamesall" name="ilnamesall" />
				  
				  <input type="hidden" id="iwlocatorsall" name="iwlocatorsall" />
                  <input type="hidden" id="islocatorsall" name="islocatorsall" />
                  <input type="hidden" id="ivlocatorsall" name="ivlocatorsall" />
				  <input type="hidden" id="ilocatorsall" name="ilocatorsall" />
				  
                  <input type="hidden" id="iwaddressall" name="iwaddressall" />
                  <input type="hidden" id="isaddressall" name="isaddressall" />
                  <input type="hidden" id="ivaddressall" name="ivaddressall" />
				  <input type="hidden" id="iaddressall" name="iaddressall" />
				  
                  <input type="hidden" id="iwcontactsall" name="iwcontactsall" />
                  <input type="hidden" id="iscontactsall" name="iscontactsall" />
                  <input type="hidden" id="ivcontactsall" name="ivcontactsall" />
				  <input type="hidden" id="icontactsall" name="icontactsall" />				  
				  
                  <input type="hidden" id="iwageall" name="iwageall" />
                  <input type="hidden" id="isageall" name="isageall" />
                  <input type="hidden" id="ivageall" name="ivageall" />
				  <input type="hidden" id="iageall" name="iageall" />
				  
                  <input type="hidden" id="iwgenderall" name="iwgenderall" />
                  <input type="hidden" id="isgenderall" name="isgenderall" />
                  <input type="hidden" id="ivgenderall" name="ivgenderall" />
				  <input type="hidden" id="igenderall" name="igenderall" />
				  
                  <input type="hidden" id="iwheightall" name="iwheightall" />
                  <input type="hidden" id="isheightall" name="isheightall" />
                  <input type="hidden" id="ivheightall" name="ivheightall" />
				  <input type="hidden" id="iheightall" name="iheightall" />
				  
                  <input type="hidden" id="iwweightall" name="iwweightall" />
                  <input type="hidden" id="isweightall" name="isweightall" />
                  <input type="hidden" id="ivweightall" name="ivweightall" />
				  <input type="hidden" id="iweightall" name="iweightall" />
				  
				  <input type="hidden" id="iwidtypeall" name="iwidtypeall" />
				  <input type="hidden" id="isidtypeall" name="isidtypeall" />
				  <input type="hidden" id="ividtypeall" name="ividtypeall" />
				  <input type="hidden" id="iidtypeall" name="iidtypeall" />
				  
				  <input type="hidden" id="iwidnumberall" name="iwidnumberall" />
				  <input type="hidden" id="isidnumberall" name="isidnumberall" />
				  <input type="hidden" id="ividnumberall" name="ividnumberll" />
				  <input type="hidden" id="iidnumberall" name="iidnumberll" />
				  
                  <input type="hidden" id="iwremarksall" name="iwremarksall" />
                  <input type="hidden" id="isremarksall" name="isremarksall" />
                  <input type="hidden" id="ivremarksall" name="ivremarksall" />
				  <input type="hidden" id="iremarksall" name="iremarksall" />
				  
                  <input type="hidden" id="checkVehicle" name="checkVehicle" />
                  <input type="hidden" id="checkDamage" name="checkDamage" />
                  <input type="hidden" id="checkCF" name="checkCF" />
                </td>
            </tr>
			<tr>
				<td>Classification:*</td>
				<td>
					<select id="selClassification" name="selClassification" class="involvedrows">
						<option value=""></option>
						<option value="Suspect">Suspect</option>
						<option value="Victim">Victim</option>
						<option value="Witness">Witness</option>
						<option value="Non-compliant">Non-compliant</option>
						<option value="Medical/Emergency">Medical/Emergency</option>
					</select>
				</td>
			</tr>
            <tr>
                <td>First Name:*</td>
                <td align="left"><input type="text" id="witfname" name="witfname" class="involvedrows" /></td>
            </tr>
            <tr>
                <td>Middle Name:</td>
                <td align="left">
                  <input type="text" id="witmname" name="witmname" class="involvedrows" />
                  <input type="text" id="swid" name="swid" value="'.$_GET['idnum'].'" readonly="readonly" style="display:none;" />
                </td>
            </tr>
            <tr>
                <td>Last Name:*</td>
                <td align="left"><input type="text" id="witlname" name="witlname" class="involvedrows" /></td>
            </tr>
			'.$locatordropdown.'
            <tr>
                <td>Address:</td>
                <td align="left"><textarea id="witadd" name="witadd" style="resize:none" class="involvedrows"></textarea></td>
            </tr>
            <tr>
                <td>Contact Number:</td>
                <td align="left"><input type="text" id="witcontact" name="witcontact" class="involvedrows"/></td>
            </tr>
            <tr>
                <td>Age:</td>
                <td align="left"><input type="number" id="witage" name="witage" style="width:4em" class="involvedrows"/></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td align="left">
                    <select id="witgender" name="witgender" class="involvedrows">
                    	<option value=""></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Height:</td>
                <td align="left">
                	<input type="number" id="witheight" name="witheight" style="width:5em" class="involvedrows" /> cm / 
                    <input type="text" id="witheightft" name="witheightft" size="3" class="involvedrows" /> ft. 
                    <input type="text" id="witheightin" name="witheightin" size="3" class="involvedrows" /> in.
                </td>
            </tr>
            <tr>
                <td>Weight:</td>
                <td align="left"><input type="text" id="witweight" name="witweight" size="3" class="involvedrows"/> kg</td>
            </tr>
			<tr>
                <td>ID Type:</td>
                <td align="left">
                    <select id="witidtype" name="witidtype" class="involvedrows">
                    	<option value=""></option>
                        <option value="Passport">Passport</option>
                        <option value="Driver\'s License">Driver\'s License</option>
						<option value="PRC ID">PRC ID</option>
						<option value="Postal ID">Postal ID</option>
						<option value="Voter\'s ID">Voter\'s ID</option>
						<option value="GSIS ID">GSIS ID</option>
						<option value="SSS ID">SSS ID</option>
						<option value="IBP ID">IBP ID</option>
						<option value="Senior Citizen\'s ID">Senior Citizen\'s ID</option>
						<option value="Unified Multi Purpose ID">Unified Multi Purpose ID</option>
                    </select>
                </td>
            </tr>
			<tr>
				<td>ID Number:</td>
				<td align="left"><input type="text" id="witidnumber" name="witidnumber" class="involvedrows"/></td>
			</tr>
            <tr>
                <td>Remarks:</td>
                <td align="left"><textarea id="witremarks" name="witremarks" style="resize:none" class="involvedrows"></textarea></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><img src="images/add_btn.png" width="90px" onclick="addInvolved2();" style="cursor:pointer;" /></td>
			  <!-- <td colspan="2" align="center"><img src="images/add_btn.png" width="90px" onclick="addInvolved();" style="cursor:pointer;" /></td> -->
            </tr>                 
        </table>
        </fieldset>
        </center>
        <br />
      
          <table id="tblwitness" align="center" border="1" width="95%" style="border-collapse:collapse; display:none;">
          	  <thead>
              <tr>
                  <th colspan="100%">Witnesses</th>
              </tr>
              <tr class="whiteonblack">
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>Height</th>
                  <th>Weight</th>
				  <th>ID Type</th>
				  <th>ID Number</th>
                  <th>Remarks</th>
                  <th></th>
              </tr>
              </thead>
              <tbody id="tblwitnesstbody">
              </tbody>
              
          </table>
          <br />
          <table id="tblsuspect" align="center" border="1" width="95%" style="border-collapse:collapse; display:none;">
          	  <thead>
              <tr>
                  <th colspan="100%">Suspects</th>
              </tr>
              <tr class="whiteonblack">
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>Height</th>
                  <th>Weight</th>
				  <th>ID Type</th>
				  <th>ID Number</th>
                  <th>Remarks</th>
                  <th></th>
              </tr>
              </thead>
              <tbody id="tblsuspectbody">
              </tbody>
              
          </table>
          <br />
          <table id="tblvictim" align="center" border="1" width="95%" style="border-collapse:collapse; display:none;">
          	  <thead>
              <tr>
                  <th colspan="100%">Victims</th>
              </tr>
              <tr class="whiteonblack">
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th>Height</th>
                  <th>Weight</th>
				  <th>ID Type</th>
				  <th>ID Number</th>
                  <th>Remarks</th>
                  <th></th>
              </tr>
              </thead>
              <tbody id="tblvictimtbody">
              </tbody>
              
          </table>
		   <br />
          <table id="tblinvolved" align="center" border="1" width="95%" style="border-collapse:collapse; display:none;">
          	  <thead>
				  <tr>
					  <th colspan="100%">Involved Persons</th>
				  </tr>
				  <tr class="whiteonblack">
					  <th>Classification</th>
					  <th>First Name</th>
					  <th>Middle Name</th>
					  <th>Last Name</th>
					  <th>Locator</th>
					  <th>Address</th>
					  <th>Contact</th>
					  <th>Age</th>
					  <th>Gender</th>
					  <th>Height</th>
					  <th>Weight</th>
					  <th>ID Type</th>
					  <th>ID Number</th>
					  <th>Remarks</th>
					  <th></th>
				  </tr>
              </thead>
              <tbody id="tblinvolvedtbody">
              </tbody>
              
          </table>
          <table width="95%">
          	<tr>
            	<td align="right"><img src="images/next_btn.png" width="90px" style="cursor:pointer;" onclick="showNext();" /></td>
            </tr>
          </table>
          </div>
          <div id="otherdetails" style="display:none">
              <table align="center">
                  <tr>
                      <td valign="top">
                          <fieldset>
                          <legend style="font-weight:bold; text-align:left"><input type="checkbox" id="chkboxVehicle" name="chkboxVehicle" value="1" onclick="checkOtherDetails();" />Vehicle Used</legend>
								<table>
									<tr>
										<td>Owner:</td>
										<td><input type="text" id="txtvowner" name="txtvowner" class="fieldsVehicle" disabled="disabled" /></td>
									</tr>
									<tr>
										<td>Plate Number:</td>
										<td><input type="text" id="txtvplateno" name="txtvplateno" class="fieldsVehicle" disabled="disabled" /></td>
									</tr>
									<tr>
										<td>Type:</td>
										<td>
											<!--<input type="text" id="txtvtype" name="txtvtype" title="ex: car, motorcycle, etc." />-->
											<select id="selvtype" name="selvtype" class="fieldsVehicle" disabled="disabled">
												<option value=""></option>
												<option value="Bicycle">Bicycle</option>
												<option value="Motorcycle">Motorcycle</option>
												<option value="Tricycle">Tricycle</option>
												<option value="4-wheeled Vehicle">4-wheeled Vehicle</option>
												<option value="Delivery Truck">Delivery Truck</option>
												<option value="Others">Others</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Make:</td>
										<td><input type="text" id="txtvmake" name="txtvmake" title="ex: Toyota, Isuzu, etc." class="fieldsVehicle" disabled="disabled" /></td>
									</tr>
									<tr>
										<td>Model:</td>
										<td><input type="text" id="txtvmodel" name="txtvmodel" class="fieldsVehicle" disabled="disabled" /></td>
									</tr>
                                  <tr>
                                  	<td>Color:</td>
                                  	<td><input type="text" id="txtvcolor" name="txtvcolor" class="fieldsVehicle" disabled="disabled" /></td>
                                  </tr>
                                  <tr>
                                  	<td>Remarks:</td>
                                  	<td><textarea id="txtvremarks" name="txtvremarks" class="fieldsVehicle" disabled="disabled" style="resize:none;"></textarea></td>
                                  </tr>
								   <tr>
										<td colspan="2" align="center">
											<img src="images/add_btn.png" width="90px" onclick="addVehicle();" style="cursor:pointer;" />
											<input type="hidden" id="vOwnerAll" name="vOwnerAll" />
											<input type="hidden" id="vPlateNoAll" name="vPlateNoAll" />
											<input type="hidden" id="vTypeAll" name="vTypeAll" />
											<input type="hidden" id="vMakeAll" name="vMakeAll" />
											<input type="hidden" id="vModelAll" name="vModelAll" />
											<input type="hidden" id="vColorAll" name="vColorAll" />
											<input type="hidden" id="vRemarksAll" name="vRemarksAll" />
										</td>
									</tr>
                              </table>
                          </fieldset>
                          
                      </td>
                      <td valign="top">
                      	<fieldset>
                        <legend style="font-weight:bold"><input type="checkbox" id="chkboxCounterfeit" name="chkboxCounterfeit" value="1" onclick="checkOtherDetails();" />Counterfeit Details</legend>
                        	<table>
                            	<tr>
                                	<td>Account Name:</td>
                                    <td>
                                    	<input type="text" id="txtcfaccname" name="txtcfaccname" class="fieldsCounterfeit" disabled="disabled" />
                                    </td>
                                </tr>
                                <tr>
                                	<td>Account ID:</td>
                                    <td><input type="text" id="txtcfaccid" name="txtcfaccid" class="fieldsCounterfeit" disabled="disabled" /></td>
                                </tr>
                                <tr>
                                	<td>Customer Representative:</td>
                                    <td><input type="text" id="txtcfcrep" name="txtcfcrep" class="fieldsCounterfeit" disabled="disabled" /></td>
                                </tr>
                                <tr>
                                	<td>Address of Incident:</td>
                                    <td><input type="text" id="txtcfadd" name="txtcfadd" class="fieldsCounterfeit" disabled="disabled" /></td>
                                </tr>                                
                                <tr>
                                	<td>Amount:</td>
                                    <td><input type="number" id="txtcfamount" name="txtcfamount" class="fieldsCounterfeit" disabled="disabled" /></td>
                                </tr>
                                <tr>
                                	<td>Counterfeit Bill Serial:</td>
                                    <td><input type="text" id="txtcfbill" name="txtcfbill" class="fieldsCounterfeit" disabled="disabled" /></td>
                                </tr>
                                <tr>
                                	<td>Relationship:</td>
                                    <td><input type="text" id="txtcfrelate" name="txtcfrelate" class="fieldsCounterfeit" disabled="disabled" /></td>
                                </tr>
                            </table>
                        </fieldset>
						<fieldset>
                            <legend style="font-weight:bold"><input type="checkbox" id="chkboxDamage" name="chkboxDamage" value="1" onclick="checkOtherDetails();" />Damage</legend>
                                <table>
                                    <tr>
                                        <td>Cost of Damage:</td>
                                        <td><input type="number" id="txtdmgcost" name="txtdmgcost" class="fieldsDamage" disabled="disabled" /></td>
                                    </tr>
                                    <tr>
                                        <td>Type of Loss:</td>
                                        <td>
                                            <select id="sellosstype" name="sellosstype" class="fieldsDamage" disabled="disabled">
                                                <option value=""></option>
                                                <option value="Loss Recovered">Loss Recovered</option>
                                                <option value="Loss Unrecovered">Loss Unrecovered</option>
                                                <option value="Loss Prevented">Loss Prevented</option>
                                                <option value="Not Applicable">Not Applicable</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                      </td>
                  </tr>
                                  
              </table>
			  <br />
          <table id="tblvehicle" align="center" border="1" width="95%" style="border-collapse:collapse; display:none; ">
          	  <thead>
              <tr>
                  <th colspan="100%">Vehicles</th>
              </tr>
              <tr class="whiteonblack">
                  <th>Owner</th>
                  <th width="12%">Plate Number</th>
                  <th width="12%">Type</th>
                  <th width="12%">Make</th>
                  <th width="12%">Model</th>
                  <th width="12%">Color</th>                  
                  <th>Remarks</th>
                  <th></th>
              </tr>
              </thead>
              <tbody id="tblvehicletbody">
              </tbody>
              
          </table>
		  <br />
			<table align="center">
				<tr>
					<td colspan="2" align="right"><img src="images/back_btn.png" width="85px" style="cursor:pointer;" onclick="showPrev();" /><img src="images/next_btn.png" width="85px" style="cursor:pointer;" onclick="showNext();" /></td>
                </tr>
			</table>				  
          </div>
          <div id="divDisposition" style="display:none">			
          	<table width="50%" align="center">
            	<tr>
                	<td>
                    	<fieldset>
                        	<legend style="font-weight:bold">Disposition</legend>
                            <textarea id="txtIncidentDisposition" name="txtIncidentDisposition" style="resize:none; width:100%"></textarea>
                        </fieldset>
                    </td>
                </tr>                
                <tr>
                	<td align="right">
                    	<img src="images/back_btn.png" width="85px" style="cursor:pointer;" onclick="showPrev();" />
                        <img src="images/confirm_btn.png" width="85px" style="cursor:pointer;" onclick="saveCloseIncident();" />
                    </td>
                </tr>
            </table>
          </div>
    </form>';
	
echo $resulttable;
?>