<?php


/**
 * This example shows sending a message using a local sendmail binary.
 */


require '../PHPMailerAutoload.php';



//Create a new PHPMailer instance

$mail = new PHPMailer;


// Set PHPMailer to use the sendmail transport

$mail->isSendmail();


//Set who the message is to be sent from

$mail->setFrom('no-reply@aboitiz.com', 'Aboitiz Foundation Team');


//Set an alternative reply-to address

//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');


//Set who the message is to be sent to

$mail->addAddress('ramon.angeles@gmail.com', 'Ramon Angeles III');



//Set the subject line

$mail->Subject = 'Project Proposal';


//Read an HTML message body from an external file, convert referenced images to embedded,

//convert HTML into a basic plain-text alternative body


$mail->msgHTML('<div style="border:1px solid #000000; width:605px; padding:5px;" align="center">
							  <table width="98%" border="0" cellspacing="2" cellpadding="2">
								<tr>
								  <td><img src="images/aboitiz-logo.jpg" alt="Aboitiz Logo" width="189" height="91"></td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								</tr>
								<tr>
								  <td>
								  <p>Dear ,</p>
								  <p>A/n  project from  in   amounting to  has been sent by  for your recommendation.</p>
								  <p>&nbsp;</p>
								  <p>Project Title: </p>
								  <p>Project Start Date: </p>
								  <p>Project End Date: </p>
								  <p>&nbsp;</p>
								  <p>To view this request please <a href="https://test.com/index.php">click here</a> to login.</p>
								  <p>&nbsp;</p>
								  <p>Thank you and for your proper disposition.</p>
								  <p>&nbsp;</p>
								  <p>Sincerely,</p>
								  <p>Your Aboitiz Foundation Team</p>
								  <p>&nbsp;</p>
								  </td>
								</tr>
							  </table>
							</div>');


//Replace the plain text body with one created manually

//$mail->AltBody = '';


//Attach an image file

//$mail->addAttachment('images/phpmailer_mini.png');



//send the message, check for errors


if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}

?>