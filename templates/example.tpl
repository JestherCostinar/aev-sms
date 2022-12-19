<div id="viewsecagencymodal" style="display:none; padding-top:24px;" >
    <img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeBiddingSecAgencyModal();" />
    	<table align="center" width="100%" border="1" style="border-collapse:collapse;">
			<tr>
				<th style="cursor:pointer;" onclick="toggleTabs('nominatedAgencyDiv', 'nominatedsecagencydivs');">Nominated Agencies</th>
				<th style="cursor:pointer;" onclick="toggleTabs('pollagencydiv', 'poolsecagencydivs');">Pool Agencies</th>
			</tr>
			<tr>
				<td colspan="100%">
					<div id="nominatedAgencyDiv" name="nominatedAgencyDiv" class="nominatedsecagencydivs" style="cursor:pointer; margin: 10px">
						 <table width="100%" align="center"  width="100%" border="1" style="border-collapse:collapse">
                            <thead>
                                <tr class="whiteonblack">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>President/General Manager</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="tbodyNominatedAgency">
                            </tbody>    
                            <tfoot>
                                <tr  align="center" bgcolor="#CCCCCC">
                                    <td>
                                        <input type="text" id="txtaddbuname" name="txtaddbuname" style="text-align:center" /> 
                                        <input type="hidden" id="txtaddbunameall" name="txtaddbunameall" />                       
                                    </td>
                                    <td>
                                        <input type="text" id="txtaddbucode" name="txtaddbucode" style="text-align:center" /> 
                                        <input type="hidden" id="txtaddbucodeall" name="txtaddbucodeall" />                       
                                    </td>
                                    <td>
                                        <input type="text" id="txtaddbuname" name="txtaddbuname" style="text-align:center" /> 
                                        <input type="hidden" id="txtaddbunameall" name="txtaddbunameall" />                       
                                    </td>
                                    <td>
                                        <input type="text" id="txtaddbuname" name="txtaddbuname" style="text-align:center" /> 
                                        <input type="hidden" id="txtaddbunameall" name="txtaddbunameall" />                       
                                    </td>
                                    <td>
                                        <input type="text" id="txtaddbuname" name="txtaddbuname" style="text-align:center" /> 
                                        <input type="hidden" id="txtaddbunameall" name="txtaddbunameall" />                       
                                    </td>
                                    <td>
                                        <input type="text" id="txtaddbuname" name="txtaddbuname" style="text-align:center" /> 
                                        <input type="hidden" id="txtaddbunameall" name="txtaddbunameall" />                       
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="100%" align="center">
                                        <img id="btnaddburow" name="btnaddburow" src="images/add_btn.png" width="80px" onclick="addBUrow();" style="cursor:pointer;" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
					</div>
					<div id="pollagencydiv" name="pollagencydiv" style="display:none;" class="poolsecagencydivs">
						<table id="tblagencylicenses" align="center" width="100%" border="1" style="border-collapse:collapse;">
							 <thead>
							 <tr class="whiteonblack">
								 <th>License Type</th>
								 <th>License Number</th>
								 <th>Issue Date</th>
								 <th>Expiry Date</th>
								 <th>PDF File</th>								 
								 <td></td>
							 </tr>
							 </thead>
							 <tbody id="tblagencylicensestbody">
							 
							 </tbody>
							 <tfoot>
								
							 </tfoot>
						 </table>
					</div>
					
					
				</td>
			</tr>
		</table>
          <table align="center" width="95%">
            
            <tr>
            	<td align="right" colspan="2">
                	
					
                	<img src="images/update.png" id="btnupdateagency" name="btnupdateagency" width="100px" style="display:none; cursor:pointer;" onclick="saveSecAgency();" />
                    <img src="images/save.png" id="btnsaveagency" name="btnsaveagency" width="100px" style="display:none; cursor:pointer;" onclick="saveSecAgency();" />
                    <input type="hidden" id="txtagencyid" name="txtagencyid" />
                    <input type="hidden" id="txtagencyaddedit" name="txtagencyaddedit" />
                </td>
            </tr>
          </table>
          
          
    </div>