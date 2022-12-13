<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");
include("class.upload.php-master/src/class.upload.php");

$clicksource = $_GET['click'];
$biddingID = $_GET['id'];

$addbtnstat = '';
$biddingstatus = 'Active';
$editbtnstat = '';
$viewonly = "";
$disable = "";

$editstatus = '';
$editname = '';
$editcreatedate = '';
if ($clicksource == "Add") {
    $editbtnstat = 'style="display:none;"';
} elseif ($clicksource == "Edit") {
    $addbtnstat  = 'style="display:none;"';
    $getBiddingDocsQuery = mysqli_query($conn, "SELECT * FROM bidding_docs WHERE id = " . $biddingID);
    $getBiddingDocs = mysqli_fetch_assoc($getBiddingDocsQuery);

    if ($biddingID != 0) {
        $file_name =  $getBiddingDocs['file_name'];
        $type = $getBiddingDocs['type'];
        $file_path = $getBiddingDocs['file_path'];
    } else {
        $editstatus = '<option hidden>""</option>';
        $editcreatedate = '';
    }
} 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $doc_name = mysqli_real_escape_string($conn, $_POST['txtdocsname']);
    $doc_type = mysqli_real_escape_string($conn, $_POST['txtdocstype']);
    $doc_file = $_FILES['txtdocsfile']['name'];
    $doc_id = $_POST['txtdocsid'];
    $path = '';
    if(!empty($doc_file)) {
        
        $path =  "documents/" . $doc_file;
        // if (file_exists($path)) {
        //     echo '<script type="text/javascript">alert("FileName already exists")</script>';
        // } else {
        //     move_uploaded_file($_FILES['txtdocsfile']['tmp_name'], $path);
        // }
        move_uploaded_file($_FILES['txtdocsfile']['tmp_name'], $path);
    } 
    

    if (isset($_POST['btnsavedocs'])) {
        mysqli_query($conn, "INSERT INTO bidding_docs(file_name, file_path, type) values('" . $doc_name . "', '" . $path . "', '" . $doc_type . "')") or die(mysqli_error($conn));
    }

    if (isset($_POST['btneditdocs'])) {
        if (empty($doc_file)) {
            $path = $_POST['txtpreviousfile'];
        }

        mysqli_query($conn, "UPDATE bidding_docs SET file_name ='" . $doc_name . "', file_path ='" . $path . "', type ='" . $doc_type . "' WHERE id = " . $doc_id) or die(mysqli_error($conn));
    }
    header("Location: user-superadmin.php?last=BidDocs");
}

$divcontent = '<img src="images/x_mark_red.png" height="24px" style="cursor:pointer; position:absolute; right:1px; top:1px;" onclick="biddingdocumentback();" />
                <form id="biddingDocument" name="biddingDocument" method="post" action="bidding_document.php" enctype="multipart/form-data">
					<table width="75%" align="center" bgcolor="#ededed" border="1px">
						<tr valign="top">
							<td style="border-width:0px;">
								<fieldset class="biddocumenttab" id="biddocumenttab" style="border-width:thin">					
									<legend style="font-weight:bold">Bidding Document</legend>
									<table>
										<tr>
											<td>File Name:</td>
											<td>
												<input type="text" id="txtdocsid" name="txtdocsid" required="required" readonly="readonly" style="display:none;" value="' . $biddingID . '" />
                                                <input type="text" id="txtpreviousfile" name="txtpreviousfile" required="required" readonly="readonly" style="display:none;" value="' . $file_path . '" />
												<input type="text" id="txtdocsname" name="txtdocsname" required="required" size="30"  value="' . $file_name . '" />
											</td>
										</tr>
										<tr>
											<td>Document Type:</td>
											<td>
												<input type="text" id="txtdocstype" name="txtdocstype" required="required" size="30" value="' . $type . '" />
											</td>
										</tr>
										<tr>
											<td>File:</td>
											<td>
												<input type="file" id="txtdocsfile" name="txtdocsfile" size="30" />
											</td>
										</tr>
										
									</table>
								</fieldset>													
							</td>					
						</tr>
						<tr>
							<td colspan="100%" style="border-width:0px;">
								<table align="right">
									<tr>
										<td>
											<button id="btneditdocs" name="btneditdocs" class="redbutton" ' . $editbtnstat . '>Edit</buttom>
											<button id="btnsavedocs" name="btnsavedocs" class="redbutton" ' . $addbtnstat . '>Save</button>
											<button id="gback" name="gback" class="redbutton" onclick="biddingdocumentback()();">Cancel</button>											
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>';


if (!empty($divcontent)) {
    echo $divcontent;
} else {
    echo "<tr><td colspan=\"100%\" align=\"center\">Record not found</td></tr>";
}
