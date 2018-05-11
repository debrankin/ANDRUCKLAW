<?php
/* contact forms mail assoc */
$mails_assoc = array(
"ContactForms3" => "dr@debrankin.com",

"ContactForms2" => "dr@debrankin.com",

"ContactForms1" => "dr@debrankin.com",


);

$phpmails_assoc = array(
"ContactForms3" => "admin@andruckilaw.com"
);

require_once 'swift_mail/swift_required.php';

// Create the Transport
$transport = Swift_MailTransport::newInstance();

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

	//specify the email address you are sending to, and the email subject
	$email = $mails_assoc[$_POST["contactForm"]];
	if(!isset($email)) { 
		echo "0";
	}
/*	$subject = 'Web Site Evaluation form ';
	
	//create a boundary for the email. This 
	$boundary = uniqid('np');
					
	//headers - specify your from email address and name here
	//and specify the boundary for the email
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "From: Your Name \r\n";
	$headers .= "To: ".$email."\r\n";
	$headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

	//here is the content body
	$message = "This is a MIME encoded message.";
	$message .= "\r\n\r\n--" . $boundary . "\r\n";
	$message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";
*/
	//Plain text body
	$plain_text_mail = '';
	$plain_text_mail = (isset($_POST["useautoresponse"]) && $_POST["useautoresponse"] === true) ?  file_get_contents('plain_text_autoresponse.php') : file_get_contents('plain_text_mail.php');
	$formdataString = "";
	$obj = $_POST["formdata"];

	foreach($obj as $prop => $value) {
		if ($prop =='name')
			$plain_text_mail = str_replace("@name",$value,$plain_text_mail);
		if ($prop =='message')
			$plain_text_mail = str_replace("@message",$value,$plain_text_mail);
		if ($prop !='captcha' && $prop !='message')
	 		$formdataString .= $prop . " : " . $value . "\r";
	}
	$plain_text_mail = str_replace("@contact_details",$formdataString,$plain_text_mail);

	//Html body
	$html_mail = '';
	$html_mail .= (isset($_POST["useautoresponse"]) && $_POST["useautoresponse"] === true) ?  file_get_contents('html_autoresponse.php') : file_get_contents('html_mail.php');
	$formdataString = "";
	foreach($obj as $prop => $value) {
		if ($prop =='name')
			$html_mail = str_replace("@name",$value,$html_mail);
		if ($prop =='message')
			$html_mail = str_replace("@message",nl2br($value),$html_mail);
		if ($prop !='captcha' && $prop !='message')
	 			 		$formdataString .= '<tr><td align="left" style="font-family: arial,sans-serif; font-size: 14px; font-weight:bold; line-height: 20px !important; color: #00C2FF; padding-bottom: 20px;border-top:1px solid #ccc;padding-top:20px;">' . $prop . ':&nbsp; <span style="color: #000000;">' . $value . '</td></tr>';
	}
	$html_mail = str_replace("@contact_details",$formdataString,$html_mail);


/*
	$message .= $plain_text_mail;
	$message .= "\r\n\r\n--" . $boundary . "\r\n";
	$message .= "Content-type: text/html;charset=utf-8\r\n\r\n";



	$message .= $html_mail;
	$message .= "\r\n\r\n--" . $boundary . "--";
*/

	$from = $phpmails_assoc[$_POST["contactForm"]];
	if(!isset($from)) { 
		
		$from = 'admin@';
		if(isset($_SERVER['HTTP_HOST'])) { 
			$from = $from . $_SERVER['HTTP_HOST'];
		} else {
			if(isset($_SERVER['SERVER_NAME'])) { 
				$from = $from . $_SERVER['SERVER_NAME'];
			} else {
				$from = $from . 'yourwebsite.com';
			}
		}
	}

// Create a message
$message = Swift_Message::newInstance('Contact form message')
  ->setFrom(array($from => 'Website Evaluation Form'))
  ->setTo(array($email))
  ->setBody($html_mail, 'text/html')
  ->addPart($plain_text_mail, 'text/plain')
  ;

if ($mailer->send($message)) {
  echo "1";
} else {
 	$from = 'admin@';
	if(isset($_SERVER['HTTP_HOST'])) { 
		$from = $from . $_SERVER['HTTP_HOST'];
	} else {
		if(isset($_SERVER['SERVER_NAME'])) { 
			$from = $from . $_SERVER['SERVER_NAME'];
		} else {
			$from = $from . 'yourwebsite.com';
		}
	}
	$message = Swift_Message::newInstance('Contact form message')
	  ->setFrom(array($from => 'Website Contact Form'))
	  ->setTo(array($email))
	  ->setBody($html_mail, 'text/html')
	  ->addPart($plain_text_mail, 'text/plain')
	  ;

	if($mailer->send($message)) { 
		echo "1";
	} else {

		echo "0";
	}
}

/*
	//check if function mail exists
	if (function_exists('mail')) {
		//check if mail was successfully && invoke the PHP mail function
		if(@mail('', $subject, $message, $headers))
		{
			if ($_POST["emailSent"] == 'firstOption')
				echo 1;
			else
				echo 1;
		}
		else
			echo 0;
	}
	else{
		echo 0;
	}
*/
?>