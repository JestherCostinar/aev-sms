<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aboitiz Security Management System</title>

<link href="styles.css" rel="stylesheet" />
</head>

<body>

<!-- $header login-logo.png -->
<img src="images/header.png" alt="Aboitiz logo" style="background:black;width:100%;"/>

<div id="content-wrapper">
<div id="content">


<div id = "login-wrapper">
<div style="background:url(images/login-top.png) no-repeat; height:36px"></div>
<div style="background:url(images/login-back.png)">
<div id="login-content">
<div style="float:left; width:300px">
<h3 style="margin-bottom:0">Security Login</h3>
<div style="color:#FF0000;"><small>$msg</small></div>
<form method="post" name="form1" autocomplete="off">
<table width="470">
<tr>
<td>Username</td>
</tr>
<tr>
<td><input type="text" class = "txtField" name="username" /></td>
</tr>
<tr>
<td>Password</td>
</tr>
<tr>
<td><input type="password" class = "txtField" name="password" />
<!-- <br /><a href="forgotpass.php" style="text-decoration:none;">forgot password</a> --></td>
</tr>
<tr>
<td align="center">
<input type="hidden" value="login" name="login" />
<input type="image" src="images/loginBtn.png"  />
</td></tr>
</table>
</form>
</div>
<div style="float:left; width:30px">
	<img src="images/login-logo2.png" width="170px" />
</div>        
    <div style="clear:both"></div>

		</div>
</div>
 <div style="background:url(images/login-bottom.png) no-repeat; height:36px;"></div>
	</div>
   <div style="clear:both"></div>
</div>

</div><hr />
$footer
</body>
</html>
