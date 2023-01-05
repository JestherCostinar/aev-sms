<?php
require_once 'phpmailer/PHPMailer-master/PHPMailerAutoload.php';
require_once 'phpmailer/PHPMailer-master/class.smtp.php';
//require_once 'phpmailer/PHPMailer-master/PHPMailerAutoload.php';
function send_mail($to,$subject,$message) {	

	$mail = new PHPMailer;
	$mail->isSendmail();

	$mail->setFrom('no-reply@aboitiz.com', 'SMS Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);
	
	//$mail->AltBody = 'This is a plain-text message body';

	//Attach an image file

	//$mail->addAttachment('images/phpmailer_mini.png');

	//send the message, check for errors

	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}
}

function send_mail2($to,$subject,$message,$upload1,$upload2,$upload3)
{
	$mail = new PHPMailer;
	$mail->isSendmail();

	$mail->setFrom('no-reply@aboitiz.com', 'SMS Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	
	//$mail->AltBody = 'This is a plain-text message body';


	//Attach an image file
	if($upload1)
	{
		$mail->addAttachment($upload1);
	}
	
	if($upload2)
	{
		$mail->addAttachment($upload2);
	}
	
	if($upload2)
	{
		$mail->addAttachment($upload2);
	}
	



	//send the message, check for errors


	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}	
}

function send_mail3($to,$subject,$message,$upload1,$upload2,$upload3,$to2, $files)
{
	$mail = new PHPMailer;
	$mail->isSendmail();
	
	
	if($to2)
	{
		$to2cc = explode("*~", $to2);
	foreach($to2cc as $cc2)
	{
		$mail->addReplyTo($cc2);
	}
	}
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');
	$tocc = explode("*~", $to);
	foreach($tocc as $cc)
	{
		$mail->addCC($cc);
	}

	foreach($files as $file) {
        	$mail->addAttachment($file);
    	}
	
	//$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	
	//$mail->AltBody = 'This is a plain-text message body';


	//Attach an image file
	if($upload1)
	{
		$mail->addAttachment($upload1);
	}
	
	if($upload2)
	{
		$mail->addAttachment($upload2);
	}
	
	if($upload2)
	{
		$mail->addAttachment($upload2);
	}
	



	//send the message, check for errors


	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}	
}

function send_mail4($to,$subject,$message) {	

	$mail = new PHPMailer;
	$mail->isSendmail();

	$mail->setFrom('no-reply@aboitiz.com', 'SMS Request');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	
	//$mail->AltBody = 'This is a plain-text message body';


	//Attach an image file

	//$mail->addAttachment('images/phpmailer_mini.png');



	//send the message, check for errors


	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}
}

function send_mail5($to,$subject,$message)
{
	$mail = new PHPMailer;
	$mail->isSendmail();
	
	
	
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');
	$tocc = explode("*~", $to);
	foreach($tocc as $cc)
	{
		$mail->addCC($cc);
	}
	//$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	
	//$mail->AltBody = 'This is a plain-text message body';


	//Attach an image file
	
	



	//send the message, check for errors


	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}	
}

function send_mail6($to,$subject,$message,$uploads,$to2)
{
	$mail = new PHPMailer;
	$mail->isSendmail();
	
	
	if($to2)
	{
		$to2cc = explode("*~", $to2);
	foreach($to2cc as $cc2)
	{
		$mail->addReplyTo($cc2);
	}
	}
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');
	$tocc = explode("*~", $to);
	foreach($tocc as $cc)
	{
		$mail->addCC($cc);
	}
	//$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	
	//$mail->AltBody = 'This is a plain-text message body';


	//Attach an image file
	$toupload = explode("*~", $uploads);
	foreach($toupload as $upload)
	{
		$mail->addAttachment($upload);
	}
	
	



	//send the message, check for errors


	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}	
}

function send_mail_disposition($to,$subject,$message,$to2)
{
	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();
	$mail->Host = '192.168.2.11';
	$mail->Port = 25;

	
	
	if($to2)
	{
		$to2cc = explode("*~", $to2);
		foreach($to2cc as $cc2)
		{
			$mail->addReplyTo($cc2);
		}
	}
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');
	$tocc = explode("*~", $to);
	foreach($tocc as $cc)
	{
		$mail->addCC($cc);
	}
	//$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	
	//$mail->AltBody = 'This is a plain-text message body';

	//send the message, check for errors

	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}	
}


function send_mail_disposition_enhancement($to,$subject,$message,$to2, $reportFile)
{
	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();
	$mail->Host = '192.168.2.11';
	$mail->Port = 25;

	
	
	if($to2)
	{
		$to2cc = explode("*~", $to2);
		foreach($to2cc as $cc2)
		{
			$mail->addReplyTo($cc2);
		}
	}
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');
	$tocc = explode("*~", $to);
	foreach($tocc as $cc)
	{
		$mail->addCC($cc);
	}
	//$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	if($reportFile) {
		$mail->addAttachment('incidentReport/' . $reportFile . '.pdf');
	}

	//$mail->AltBody = 'This is a plain-text message body';

	//send the message, check for errors

	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}	
}



function send_mail_agency($to,$subject,$message,$to2)
{	

	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();
	$mail->Host = '192.168.2.11';
	$mail->Port = 25;
	

	$mail->setFrom('no-reply@aboitiz.com', 'Contract Compliance Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$mail->addAddress($to);
	
	$mail->addReplyTo($to2);
	
	$mail->Subject = $subject;
	$mail->msgHTML($message);
	
	//$mail->AltBody = 'This is a plain-text message body';


	//Attach an image file

	//$mail->addAttachment('images/phpmailer_mini.png');



	//send the message, check for errors


	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}
}

function send_mail_level0($to,$subject,$message,$to2)
{	

	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();
	$mail->Host = '192.168.2.11';
	$mail->Port = 25;
	

	$mail->setFrom('no-reply@aboitiz.com', 'Contract Compliance Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$mail->addAddress($to2);
	
//	$mail->addReplyTo($to2);
	
	$mail->Subject = $subject;
	$mail->msgHTML($message);
	
	//$mail->AltBody = 'This is a plain-text message body';


	//Attach an image file

	//$mail->addAttachment('images/phpmailer_mini.png');



	//send the message, check for errors


	if (!$mail->send())
	{
		echo "Error"; 
	}
	else
	{
		echo "Yes";
	}
}

function send_mail_back($to,$subject,$message) {	

	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = '192.168.2.16';
	$mail->Port = 25; 

	$mail->setFrom('no-reply@aboitiz.com', 'Contract Compliance Alert');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$mail->addAddress($to);
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;

	
	if(!$mail->send()) {
	    $error = 'Message could not be sent. Not sent<br/>';
	     $error = 'Mailer Error: ' . $mail->ErrorInfo.' Not sent<br/>';
	} else {
	     $error = 'Message has been sent';
	}

	return $to;
}

function send_bidding_invitation($to,$message)
{
	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();

	//Set the SMTP server to send through
	$mail->Host = 'smtp.mailtrap.io';

	//Enable SMTP authentication
	$mail->SMTPAuth = true;

	//SMTP username
	$mail->Username = 'aea8de017e2e93';

	//SMTP password
	$mail->Password = '489459a07fba68';


	//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	$mail->Port = 2525;

	//Recipients
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Bidding Initialization');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$tocc = explode(",", $to);
	foreach ($tocc as $cc) {
		$mail->addAddress($cc);
	}

	$mail->IsHTML(false);
	$mail->Subject = 'SMS Bidding Initialization';
	$message = str_replace('\n', '<br>', $message);
	$message = str_replace('\r', '', $message);
	$mail->msgHTML($message);


	if (!$mail->send()) {
		echo "Error";
	} else {
		echo "Yes";
	}
}

function send_bidding_requirements($to, $message)
{
	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();

	//Set the SMTP server to send through
	$mail->Host = 'smtp.mailtrap.io';

	//Enable SMTP authentication
	$mail->SMTPAuth = true;

	//SMTP username
	$mail->Username = 'aea8de017e2e93';

	//SMTP password
	$mail->Password = '489459a07fba68';


	//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	$mail->Port = 2525;

	//Recipients
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Bidding Invitation');

	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$mail->addAddress($to);

	$mail->Subject = 'Invitation to Bidding';
	$mail->msgHTML($message);


	if (!$mail->send()) {
		echo "Error";
	} else {
		echo "Yes";
	}
}

function send_bidding_notification($to, $message)
{
	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();

	//Set the SMTP server to send through
	$mail->Host = 'smtp.mailtrap.io';

	//Enable SMTP authentication
	$mail->SMTPAuth = true;

	//SMTP username
	$mail->Username = 'aea8de017e2e93';

	//SMTP password
	$mail->Password = '489459a07fba68';


	//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	$mail->Port = 2525;

	//Recipients
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Bidding Update');

	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$tocc = explode(",", $to);
	foreach ($tocc as $cc) {
		$mail->addAddress($cc);
	}

	$mail->Subject = 'Nomination of Security Agency Closed';
	$mail->msgHTML($message);


	if (!$mail->send()) {
		echo "Error";
	} else {
		echo "Yes";
	}
}

function send_pre_bidding($to, $message, $attachment)
{
	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();

	//Set the SMTP server to send through
	$mail->Host = 'smtp.mailtrap.io';

	//Enable SMTP authentication
	$mail->SMTPAuth = true;

	//SMTP username
	$mail->Username = 'aea8de017e2e93';

	//SMTP password
	$mail->Password = '489459a07fba68';


	//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	$mail->Port = 2525;

	//Recipients
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Bidding Update');

	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$tocc = explode(",", $to);
	foreach ($tocc as $cc) {
		$mail->addAddress($cc);
	}


	$mail->Subject = 'Pre-Bid Invitation';
	$mail->msgHTML($message);
	$mail->addAttachment($attachment);


	if (!$mail->send()) {
		echo "Error";
	} else {
		echo "Yes";
	}
}

function send_bidding_documents($to, $message, $attachment)
{
	$mail = new PHPMailer;
	//$mail->isSendmail();
	$mail->isSMTP();

	//Set the SMTP server to send through
	$mail->Host = 'smtp.mailtrap.io';

	//Enable SMTP authentication
	$mail->SMTPAuth = true;

	//SMTP username
	$mail->Username = 'aea8de017e2e93';

	//SMTP password
	$mail->Password = '489459a07fba68';


	//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	$mail->Port = 2525;

	//Recipients
	$mail->setFrom('no-reply@aboitiz.com', 'SMS Bidding Documents');
	//$mail->addReplyTo('no-reply@aboitiz.com', 'Aboitiz Foundation Team');

	$tocc = explode(",", $to);
	foreach ($tocc as $cc) {
		$mail->addAddress($cc);
	}

	$mail->IsHTML(true);
	$mail->Subject = 'SMS Bidding Documents';
	$message = str_replace('\n', '<br>', $message);
	$message = str_replace('\r', '', $message);
	$mail->msgHTML($message);
	$mail->addAttachment($attachment);


	if (!$mail->send()) {
		echo "Error";
	} else {
		echo "Yes";
	}
}
?>