<?php
session_start();
if(!isset($_SESSION['id'])){
        header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

$ticketid = $_GET['ticket_id'];

$resulttable = "";

$sqldispomain = mysqli_query($conn, "SELECT * FROM ticket WHERE id = ".$ticketid);
$resdispomain = mysqli_fetch_assoc($sqldispomain);
$resulttable .= "<img src=\"images/x_mark_red.png\" height=\"24px\" style=\"cursor:pointer; position:absolute; right:10px; top:5px;\" onclick=\"CloseRevisions();\" />" .
                                "<table align=\"center\">".
                                        "<tr>" .
                                                "<td><input type=\"radio\" name=\"editchoice\" checked=\"checked\" onClick=\"OpenRevisions(".$ticketid.");\" />Disposition</td>" .
                                                "<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions2(".$ticketid.");\" />Logs</td>" .
                                                "<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions3(".$ticketid.");\" />Person(s) Involved</td>" .
                                                "<td><input type=\"radio\" name=\"editchoice\" onClick=\"OpenRevisions4(".$ticketid.");\" />Vehicle(s) Involved</td>" .
                                        "</tr>" .
                                "</table>" .
                                "<br>" .
                                "<fieldset style=\"border:0px;\">" .
                                "<legend><b>Original Disposition</b></legend>" .
                                        "<table width=\"90%\" align=\"center\" border=\"1\" style=\"border-collapse:collapse;\">" .
                                                "<tr>" .
                                                        "<th class=\"blackongray\" width=\"30%\">Disposition Date</th>" .
                                                        "<th class=\"blackongray\" width=\"70%\">Disposition</th>" .
                                                "</tr>" .
                                                "<tr align=\"center\">" .
                                                        "<td>".$resdispomain['dateclosed']."</td>" .
                                                        "<td>".$resdispomain['disposition']."</td>" .
                                                "</tr>" .
                                        "</table>" .
                                "</fieldset><br>";

$rev_count = 0;
$sqldispomaincount = mysqli_query($conn, "SELECT COUNT(id) AS rev_count FROM disposition_revisions WHERE ticket_id = ".$ticketid);

        $resdispomaincount = mysqli_fetch_assoc($sqldispomaincount);

$forminfo = "";
if($_SESSION['level'] == 'Admin')
{
        $forminfo = "<form id=\"revisedispoform\" name=\"reviselogsform\" action=\"user-admin.php\" method=\"post\">";
}
elseif($_SESSION['level'] == 'Super Admin')
{
        $forminfo = "<form id=\"revisedispoform\" name=\"reviselogsform\" action=\"user-superadmin.php\" method=\"post\">";
}

if($resdispomaincount['rev_count'] > 0)
{
        $resulttable .= "<fieldset style=\"border:0px;\">" .
                                        "<legend><b>Updated Disposition</b></legend>" .
                                                "<table width=\"90%\" align=\"center\" border=\"1\" style=\"border-collapse:collapse;\" >" .
                                                        "<tr>" .
                                                                "<th class=\"blackongray\" width=\"20%\">Disposition Date</th>" .
                                                                "<th class=\"blackongray\" width=\"60%\">Disposition</th>" .
                                                                "<th class=\"blackongray\" width=\"20%\">Updated by</th>" .
                                                        "</tr>";
                                                        $sqldisporev = mysqli_query($conn, "SELECT dr.*, u.lname AS ulname, u.fname AS ufname, u.mi AS umi FROM disposition_revisions dr LEFT JOIN users_mst u ON dr.user_id = u.id WHERE ticket_id = ".$ticketid);
                                                        while($resdisporev = mysqli_fetch_assoc($sqldisporev))
                                                        {
                                                                $resulttable .= "<tr align=\"center\">" .
                                                                                                        "<td>".$resdisporev['edit_date']."</td>" .
                                                                                                        "<td>".$resdisporev['disposition']."</td>" .
                                                                                                        "<td>".$resdisporev['ulname'].", ".$resdisporev['ufname']." ".$resdisporev['umi']."</td>" .
                                                                                                "</tr>";
                                                        }
        $resulttable .=         "</table>" .
                                        "</fieldset><br>";
}

if($resdispomaincount['rev_count'] <= 1)
{
        $resulttable .=         $forminfo .
                                                "<table align=\"center\">" .
                                                        "<tr>" .
                                                                "<th colspan=\"100%\">New Disposition</th>" .
                                                        "</tr>" .
                                                        "<tr>" .
                                                                "<td colspan=\"100%\" align=\"center\"><textarea id=\"txtdisporev\" name=\"txtdisporev\" rows=\"4\" style=\"width:300px; resize:none;\" required=\"required\"></textarea></td>" .
                                                        "</tr>" .
                                                        "<tr align=\"center\">" .
                                                                "<td><input type=\"hidden\" id=\"hidticketid\" name=\"hidticketid\" value=\"".$ticketid."\" /><input type=\"submit\" class=\"redbutton\" style=\"width:80px;\" id=\"btndisporev\" name=\"btndisporev\" value=\"Update\" /></td>" .
                                                        "</tr>" .
                                                "</table>" .
                                                "</form>";
}
else
{
        $resulttable .= "<fieldset style=\"border:0px;\">" .
                                                "<table align=\"center\">" .
                                                        "<tr align=\"center\">" .
                                                                "<td><label style=\"color:red\">Revision limit reached</label></td>" .
                                                        "</tr>" .
                                                "</table>" .
                                        "</fieldset>";
}

echo $resulttable;

