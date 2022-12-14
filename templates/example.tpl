<div id="Users" class="section">
      <table width="95%" align="center">
      	<tr>
        	        	
            <td align="right">
            	<div id="divSearchUsers" style="display:none;">
                <form id="frmSearchUsers" name="frmSearchUsers" action="user-superadmin.php" method="post">
                	<label style="text-decoration:underline; color:#00F; cursor:pointer" onclick="refreshPage('Users', 'user-superadmin');">Refresh</label>
                	<input type="text" id="txtSearchUsers" name="txtSearchUsers" />
                    <select id="selSearchUsersLevel" name="selSearchUsersLevel" style="display:none;">
                    	<option value=""></option>
                        <option value="User">User</option>
                        <option value="Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                    <select id="selSearchUsersBU" name="selSearchUsersBU" style="display:none;">
                    	<option value=""></option>
                        $budatalist
                    </select>
                    <select id="selSearchUsersGender" name="selSearchUsersGender" style="display:none;">
                    	<option value=""></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <select id="selSearchUsers" name="selSearchUsers" onchange="changeSearch('users_mst');">
                    	<option value="lname">Last Name</option>
                        <option value="fname">First Name</option>
                        <option value="level">Level</option>
                        <option value="email">Username</option>
                        <option value="gender">Gender</option>
                        <option value="contact">Contact Number</option>
                        <option value="bu">Business Unit</option>
                    </select>
                    <img src="images/Search_btn.png" width="80px" id="btnSearchUsers" name="btnSearchUsers" style="cursor:pointer; vertical-align:middle;" onclick="searchItem(document.getElementById('txtSearchUsers').value, document.getElementById('selSearchUsers').value, 'users_mst');" />
                </form>    
                </div>                
            </td>
            <td width="30px">
            	<img src="images/Search-icon.png" height="30px" id="btnShowSearchUsers" name="btnShowSearchUsers" title="Search Users" style="cursor:pointer;" onclick="toggleSearch('divSearchUsers');" />
                <!--<img src="images/refresh.png"  style="height:26px; cursor:pointer;" onclick="refreshPage('Users', 'user-superadmin');" />-->
            </td>	          
        </tr>
      </table>      
      <div id="divUsersDisplay">
        <table width="95%" border="1" align="center" style="border-collapse:collapse">
                <tr>
                    <!-- <th class="acctab" id="acctabuser" width="33%" bgcolor="#000000" style="color:#FFF; cursor:pointer" onclick="toggleMe3('divuseracc', 'acctabuser', 'User');">Users</th>
                    <th class="acctab" id="acctabadmin" width="33%" style="cursor:pointer;" onclick="toggleMe3('divadminacc', 'acctabadmin', 'Admin');">Admins</th>
                    <th class="acctab" id="acctabsuper" width="34%" style="cursor:pointer;" onclick="toggleMe3('divsuperacc', 'acctabsuper', 'Super Admin');">Super Admins</th> -->
					<th class="acctab" id="acctabuser" width="25%" bgcolor="#000000" style="color:#FFF; cursor:pointer" onclick="toggleMe3('divuseracc', 'acctabuser', 'User');">Security Guard</th>
                    <th class="acctab" id="acctabheadguard" width="25%" style="cursor:pointer;" onclick="toggleMe3('divheadguardacc', 'acctabheadguard', 'Head Guard');">Head Guard</th>
					<th class="acctab" id="acctabadmin" width="25%" style="cursor:pointer;" onclick="toggleMe3('divadminacc', 'acctabadmin', 'Admin');">BU Security Head</th>
                    <th class="acctab" id="acctabsuper" width="25%" style="cursor:pointer;" onclick="toggleMe3('divsuperacc', 'acctabsuper', 'Super Admin');">Super Admins</th>               
				</tr>
            </table>
            <table width="95%" align="center">
                  <tr>
                      <td align="left" style="font-weight:bold">Accounts</td>
                      <td align="right">
                          <label for="btnadduse" style="font-weight:bold;">Add User</label>
                          <img src="images/add_item.png" height="30px" id="btnadduser" name="btnadduser" title="Add User" style="cursor:pointer; vertical-align:middle;" />
                          <input type="hidden" id="txtAcctType" name="txtAcctType" value="User" />
                      </td>
                  </tr>
                </table>
            <div id="divuseracc" class="accdiv">        	
                <table width="95%" align="center" border="1" style="border-collapse:collapse">
                      <tr class="whiteonblack">
                          
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Username</th>
                          <th>Access Level</th>
                          <th>Business Unit</th>
                          <th>Contact</th>
                          <th>Status</th>                
                          <th colspan="2" width="5%">Controls</th>
                      </tr>
                      $userstable
                </table>
            </div>
			<div id="divheadguardacc" class="accdiv" style="display:none">
                <table width="90%" align="center" border="1" style="border-collapse:collapse">
                      <tr class="whiteonblack">
                          
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Username</th>
                          <th>Access Level</th>
                          <th>Business Unit</th>
                          <th>Contact</th>
                          <th>Status</th>                
                          <th colspan="2" width="5%">Controls</th>
                      </tr>
                      $headguardtable
                </table>
            </div>
            <div id="divadminacc" class="accdiv" style="display:none">
                <table width="90%" align="center" border="1" style="border-collapse:collapse">
                      <tr class="whiteonblack">
                          
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Username</th>
						  <th>Email</th>
                          <th>Access Level</th>
                          <th>Business Unit</th>
                          <th>Contact</th>
                          <th>Status</th>                
                          <th colspan="2" width="5%">Controls</th>
                      </tr>
                      $adminstable
                </table>
            </div>
            <div id="divsuperacc" class="accdiv" style="display:none">
                <table width="90%" align="center" border="1" style="border-collapse:collapse">
                      <tr class="whiteonblack">
                          
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Username</th>
						  <th>Email</th>
                          <th>Access Level</th>
                          <th>Business Unit</th>
                          <th>Contact</th>
                          <th>Status</th>                
                          <th colspan="2" width="5%">Controls</th>
                      </tr>
                      $superstable
                </table>
            </div>
      </div>
	  
	  <div id="divUserDisplaySearch" style="display:none;">
      	<table width="90%" align="center" border="1" style="border-collapse:collapse">
          <thead>
            <tr class="whiteonblack">                
                <th>Name</th>
                <th>Gender</th>
                <th>Username</th>
                <th>Access Level</th>
                <th>Business Unit</th>
                <th>Contact</th>
                <th>Status</th>                
                <th colspan="2" width="5%">Controls</th>
            </tr>
          </thead>
          <tbody id="tbodyUsers">
           
          </tbody>
        </table>
      </div>
    </div>