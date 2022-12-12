<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$type = $_GET['type'];
$id = $_GET['id'];

$resulttable = "";

if($type == "openAddUser")
{
	$adminoptions = "";
	if((($_SESSION['level'] == "Admin") && ($_SESSION['hguard'] != 1)) || ($_SESSION['level'] == 'Super Admin'))
	{
		$adminoptions = '<option value="Admin">BU Security Head</option>';
	}
	
	$resulttable = '<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:10px; top:5px;" onclick="closeAddUser();" />' .
					'<form id="adduserform" name="adduserform" action="main-post.php" method="post">' .
					'<fieldset>' .
					'<legend style="font-weight:bold;">Add User</legend>' .
					'<table align="center">' .
						'<tr>' .
							'<td>Last Name</td>' .
							'<td>' .
								'<input type="text" id="userslastname" name="userslastname" required="required" />' .
								'<input type="text" id="usersid" name="usersid" readonly="readonly" style="display:none;" />' .
							'</td>' .
						'</tr>' .
						'<tr>' .
							'<td>First Name</td>' .
							'<td><input type="text" id="usersfirstname" name="usersfirstname" required="required" /></td>' .
						'</tr>' .
						/* <tr>
							<td>Middle Initial</td>
							<td><input type="text" id="usersmi" name="usersmi" required="required" size="3" maxlength="1" /></td>
						</tr> */
						/* '<tr>' .
							'<td>Gender:</td>' .
							'<td>' .
								'<select id="selugender" name="selugender" required>' .
									'<option value=""></option>' .
									'<option value="Male">Male</option>' .
									'<option value="Female">Female</option>' .
								'</select>' .
							'</td>' .
						</tr> */
						'<tr>' .
							'<td>Username</td>' .
							'<td><input type="text" id="usersusername" name="usersusername" required="required" onkeyup="checkUsername();" /></td>' .
						'</tr>' .
						'<tr>' .
							'<td colspan="100%" align="center">' .
								'<label id="lbluserstat"></label>' .
							'</td>' .
						'</tr>' .
						'<tr>' .
							'<td>Access Level</td>' .
							'<td>' .
								'<select id="selaccess" name="selaccess" required>' .
									'<option value=""></option>' .
									'<option value="User">Security Guard</option>' .
									'<option value="Head Guard">Head Guard</option>' .
									$adminoptions .
								'</select>' .
							'</td>' .
						'</tr>' .
						/* <tr>
							<td>Contact</td>
							<td><input type="text" id="userscontact" name="userscontact" required="required" /></td>
						</tr> */
						/* <tr>
							<td colspan="100%">
								<div id="divForgotPass" style="display:none;">
									<label style="color:#F00; text-decoration:underline; cursor:pointer;" onclick="resetPass();">Reset Password</label>
								</div>
							</td>
						</tr> */
						'<tr>' .
							'<td colspan="2" align="center">' .
								'<input type="submit" id="btnsaveuser" name="btnsaveuser" class="redbutton" value="Save" />' .
								/* <input type="submit" id="btnedituser" name="btnedituser" class="redbutton" value="Update" style="display:none;" /> */
							'</td>' .
						'</tr>' .
					'</table>' .
					'</fieldset>' .
					'</form>';
}

if($resulttable)
{
	echo $resulttable;
}
else
{
	echo "<center>Nothing to display</center>"
}

?>