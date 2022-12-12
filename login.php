<?php
session_start();
if(isset($_SESSION['id'])){
	
	if($_SESSION['level'] == "Admin" && $_SESSION['bu'] != ""){
		//header("location:dashboard-admin/".$_SESSION['bu']."/");
		header("location:user-admin.php");
	}
	if($_SESSION['level'] == "User" && $_SESSION['bu'] != ""){
		//header("location:dashboard-user/".$_SESSION['bu']."/");
		header("location:user.php");
	}
	if($_SESSION['level'] == "Super Admin"){
		header("location:user-superadmin.php");
	}
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$msg =  "&nbsp;";
if($_POST['login']){
//$username = str_replace("'","`",$_POST['username']);
$username = mysqli_real_escape_string($conn,$_POST['username']);
$password = mysqli_real_escape_string($conn,md5($_POST['password']));

$result = mysqli_query($conn, "select * from users_mst where email = '".$username."' && password = '".$password."' && status = 'active'");
	
	if(mysqli_num_rows($result) == 0){
//		$userchange = mysqli_query($conn, "SELECT * FROM users_mst WHERE email = '".$username."' && changepass = 1 && status = 'active'");
		
		$msg = "Invalid Username or Password."; 
	}
	else
	{
		$resRow = mysqli_fetch_assoc($result);
		
		$_SESSION['id'] = $resRow['id'];
		$_SESSION['level'] = $resRow['level'];
		$_SESSION['bu'] = $resRow['bu'];
		$_SESSION['custom'] = 0;
		$_SESSION['hguard'] = 0;
		
		$urlBu = mysqli_query($conn, "select * from bu_mst where id ='".$_SESSION['bu']."'");
		$rowUrl = mysqli_fetch_assoc($urlBu);
		$bu_url = str_replace(" ","-",$rowUrl['bu']);
		
		//system log
		//logbook($_SESSION['id'], "Logged in");
		if($resRow['level'] == "Admin"){
//		header("location:dashboard-admin/".$bu_url."/");
		header("location:user-admin.php");
		}
		if($resRow['level'] == "User"){
		//header("location:dashboard-user/".$bu_url."/");
		//header("location:index3.php");
		header("location:user.php");
		}
		if($resRow['level'] == "Super Admin"){
		header("location:user-superadmin.php");
		}
		if($resRow['level'] == "Custom Admin")
		{
			$_SESSION['level'] = "Admin";
			$_SESSION['custom'] = 1;
			header("location:user-admin.php");
		}
		if($resRow['level'] == "Head Guard")
		{
			$_SESSION['level'] = "Admin";
			$_SESSION['hguard'] = 1;
			header("location:user-admin.php");
		}
	}
	

}


//TEMPLATES
eval('$header = "' . fetch_template('header0') . '";');
eval('$footer = "' . fetch_template('footer') . '";');
eval('$body = "' . fetch_template('login') . '";');
echo stripslashes($body);

?>
