<?php
session_start();
if(!isset($_SESSION['id'])){
	header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$ccyear = $_GET['year'];
$cctable = "";

if($ccyear < 2019)
{
	$cctable = "<tr><td colspan='100%' align='center'>Cannot be edited anymore.</td></tr>";
}
/* else
{
	$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY number");
	while($ccyearres = mysqli_fetch_assoc($ccyearsql))
	{
		$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
		$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
		$cctable .= "<tr align='center' valign='top'>" . 
						"<td>".$ccyearres['number']."</td>" .
						"<td>".$ccyearres['goal']."</td>" . 						
						"<td>".$ccyearres['reference']."</td>" . 
						"<td align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
						"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" . 						
						"<td>".$ccyearres['source']."</td>" . 
						"<td>".$ccyearres['deduction']."</td>" . 
						"<td>".$ccyearres['score_group']."</td>" .
						"<td>".$ccyearres['hovertext']."</td>" .
						"<td><img src='images/edit2.png' height='28px' style='cursor:pointer; vertical-align:middle;' onclick='editCCShow(".$ccyearres['id'].");'> <img src='images/delete.png' style='cursor:pointer; vertical-align:middle;' onclick='deleteItem(".$ccyearres['id'].", \"ConComp\");'></td>" . 
					"</tr>";
	}
} */
else
{
	$ccyearsql = mysqli_query($conn, "SELECT * FROM cc_template WHERE year = ". $ccyear ." ORDER BY goal DESC, number");
	while($ccyearres = mysqli_fetch_assoc($ccyearsql))
	{
		$ccstandard = preg_replace( "/\n/", "<br>", $ccyearres['standard'] );
		$ccdetails = preg_replace( "/\n/", "<br>", $ccyearres['details'] );
		$cctable .= "<tr align='center' valign='top'>" . 
						"<td>".$ccyearres['number']."</td>" .
						"<td>".$ccyearres['goal']."</td>" . 						
						"<td>".$ccyearres['subgoal']."</td>" . 
						"<td align='left' style='padding-left:5px; padding-right:5px;'>".$ccstandard."</td>" . 
						"<td width='25%' align='left' style='padding-left:5px; padding-right:5px;'>".$ccdetails."</td>" .
						"<td>".$ccyearres['hovertext']."</td>" .
						"<td>".$ccyearres['frequency']."</td>" . 
						"<td>".$ccyearres['deduction']."</td>" . 					
						
						"<td><img src='images/edit2.png' height='28px' style='cursor:pointer; vertical-align:middle;' onclick='editCCShow(".$ccyearres['id'].");'> <img src='images/delete.png' style='cursor:pointer; vertical-align:middle;' onclick='deleteItem(".$ccyearres['id'].", \"ConComp\");'></td>" . 
					"</tr>";
	}
}


if(!empty($cctable))
{
	echo $cctable;
}
else
{
	echo "<tr><td colspan='100%' align='center'>No Existing Records.</td></tr>";
}
?>