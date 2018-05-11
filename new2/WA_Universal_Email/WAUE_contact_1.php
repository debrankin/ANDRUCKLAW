<?php
  $MailAttachments = "";
  $MailBCC         = "";
  $MailCC          = "";
  $MailTo          = "";
  $MailBodyFormat  = "";
  $MailBody        = "";
  $MailImportance  = "";
  $MailFrom        = "".((isset($_POST["Email_address"]))?$_POST["Email_address"]:"")  ."";
  $MailSubject     = "".($WAGLOBAL_Email_Subject)  ."";
  $_SERVER["QUERY_STRING"] = "";

  //Global Variables

  $WA_MailObject = WAUE_Definition("".($WAGLOBAL_Email_Server)  ."","25","","","","");

  if ($RecipientEmail)     {
    $WA_MailObject = WAUE_AddRecipient($WA_MailObject,$RecipientEmail);
  }
  else      {
    //To Entries
  }

  //Attachment Entries

  //BCC Entries
  $WA_MailObject = WAUE_AddBCC($WA_MailObject,"".($WAGLOBAL_Email_BCC)  ."");

  //CC Entries
  $WA_MailObject = WAUE_AddCC($WA_MailObject,"".($WAGLOBAL_Email_CC)  ."");

  //Body Format
  $WA_MailObject = WAUE_BodyFormat($WA_MailObject,2);

  //Set Importance
  $WA_MailObject = WAUE_SetImportance($WA_MailObject,"3");

  //Start Mail Body
$MailBody = $MailBody . "Contact Form Response\r\n";
$MailBody = $MailBody . "\r\n";

        foreach( $_POST as $pkey => $pval ){
		  if ($pval != "" && strpos($pkey,"Security_") !== 0 && strpos($pkey,"Submit") !== 0 && strpos($pkey,"button") !== 0)  {

$MailBody = $MailBody . "\r\n";
$MailBody = $MailBody . "  ";
$MailBody = $MailBody .  (str_replace("_"," ",$pkey));
$MailBody = $MailBody . ": ";
$MailBody = $MailBody .  ($pval);
$MailBody = $MailBody . "\r\n";

	      }
  }
$MailBody = $MailBody . "<multipartbreak><html><head>\r\n";
$MailBody = $MailBody . "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
$MailBody = $MailBody . "<title>Email Contact Form</title>\r\n";
$MailBody = $MailBody . "<style type=\"text/css\" media=\"all\">\r\n";
$MailBody = $MailBody . "<!--\r\n";
$MailBody = $MailBody . "html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6 {\r\n";
$MailBody = $MailBody . "  margin: 0;\r\n";
$MailBody = $MailBody . "  padding: 0;\r\n";
$MailBody = $MailBody . "  border: 0;\r\n";
$MailBody = $MailBody . "  outline: 0;\r\n";
$MailBody = $MailBody . "  font-size: 100%;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "body {\r\n";
$MailBody = $MailBody . "  background-color: #000000;\r\n";
$MailBody = $MailBody . "  color: #2e2d2c;\r\n";
$MailBody = $MailBody . "  font-family: Arial, Helvetica, sans-serif;\r\n";
$MailBody = $MailBody . "  font-size: 11px;\r\n";
$MailBody = $MailBody . "  line-height: 14px;\r\n";
$MailBody = $MailBody . "  margin: 0 0 0 0;\r\n";
$MailBody = $MailBody . "  padding: 0 0 0 0;\r\n";
$MailBody = $MailBody . "  text-align: center;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "h1 {\r\n";
$MailBody = $MailBody . "  color: #000000;\r\n";
$MailBody = $MailBody . "  font-size: 14px;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  line-height: 14px;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "h2 {\r\n";
$MailBody = $MailBody . "  color: #000000;\r\n";
$MailBody = $MailBody . "  font-size: 12px;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  line-height: 14px;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "a,  a:link {\r\n";
$MailBody = $MailBody . "  color: #333333;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  text-decoration: none;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "a:visited {\r\n";
$MailBody = $MailBody . "  color: #cccccc;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  text-decoration: none;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "a:hover {\r\n";
$MailBody = $MailBody . "  color: #cccccc;\r\n";
$MailBody = $MailBody . "  text-decoration: underline;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "a:focus {\r\n";
$MailBody = $MailBody . "  color: #bf1c1c;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "a:active {\r\n";
$MailBody = $MailBody . "  color: #702922;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper {\r\n";
$MailBody = $MailBody . "  background-color: #fff;\r\n";
$MailBody = $MailBody . "  margin: 0 auto 0 auto;\r\n";
$MailBody = $MailBody . "  text-align: left;\r\n";
$MailBody = $MailBody . "  width: 70em;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #header {\r\n";
$MailBody = $MailBody . "  background-color: #ddd;\r\n";
$MailBody = $MailBody . "  border-bottom: solid 1px #000000;\r\n";
$MailBody = $MailBody . "  font-size: 18px;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  line-height: 15px;\r\n";
$MailBody = $MailBody . "  padding: 10px 10px 10px 10px;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #header h1 {\r\n";
$MailBody = $MailBody . "  color: #000;\r\n";
$MailBody = $MailBody . "  font-size: 14px;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  line-height: 14px;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #header h2 {\r\n";
$MailBody = $MailBody . "  color: #000;\r\n";
$MailBody = $MailBody . "  font-size: 12px;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  line-height: 14px;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #header a, #outerWrapper #header a:link {\r\n";
$MailBody = $MailBody . "  color: #000;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  text-decoration: none;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #header a:visited {\r\n";
$MailBody = $MailBody . "  color: #000;\r\n";
$MailBody = $MailBody . "  font-weight: bold;\r\n";
$MailBody = $MailBody . "  text-decoration: none;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #header a:hover {\r\n";
$MailBody = $MailBody . "  color: #000;\r\n";
$MailBody = $MailBody . "  text-decoration: underline;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #header a:focus {\r\n";
$MailBody = $MailBody . "  color: #000;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #header a:active {\r\n";
$MailBody = $MailBody . "  color: #000;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #contentWrapper #content {\r\n";
$MailBody = $MailBody . "  padding: 10px 10px 10px 10px;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "#outerWrapper #footer {\r\n";
$MailBody = $MailBody . "  background-color: #dddddd;\r\n";
$MailBody = $MailBody . "  border-top: solid 1px #000000;\r\n";
$MailBody = $MailBody . "  padding: 10px 10px 10px 10px;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "-->\r\n";
$MailBody = $MailBody . "</style>\r\n";
$MailBody = $MailBody . "<style type=\"text/css\" media=\"print\">\r\n";
$MailBody = $MailBody . "<!--\r\n";
$MailBody = $MailBody . "body {\r\n";
$MailBody = $MailBody . "  background-color: #fff;\r\n";
$MailBody = $MailBody . "  background-image: none;\r\n";
$MailBody = $MailBody . "  border-color: #000;\r\n";
$MailBody = $MailBody . "  color: #000;\r\n";
$MailBody = $MailBody . "}\r\n";
$MailBody = $MailBody . "-->\r\n";
$MailBody = $MailBody . "</style>\r\n";
$MailBody = $MailBody . "</head>\r\n";
$MailBody = $MailBody . "\r\n";
$MailBody = $MailBody . "<body>\r\n";
$MailBody = $MailBody . "\r\n";
$MailBody = $MailBody . "<div id=\"outerWrapper\">\r\n";
$MailBody = $MailBody . "  <div id=\"header\"></div>\r\n";
$MailBody = $MailBody . "  <div id=\"contentWrapper\">\r\n";
$MailBody = $MailBody . "    <div id=\"content\">\r\n";
$MailBody = $MailBody . "      <h1>Contact Form Response</h1>\r\n";
$MailBody = $MailBody . "      <hr />\r\n";
$MailBody = $MailBody . "<p>\r\n";
$MailBody = $MailBody . "      ";


        foreach( $_POST as $pkey => $pval ){
		  if ($pval != "" && strpos($pkey,"Security_") !== 0 && strpos($pkey,"Submit") !== 0 && strpos($pkey,"button") !== 0)  {
	  
$MailBody = $MailBody . "\r\n";
$MailBody = $MailBody . "      <strong>";
$MailBody = $MailBody .  (str_replace("_"," ",$pkey));
$MailBody = $MailBody . ": </strong> ";
$MailBody = $MailBody .  (str_replace("\n","<BR />",$pval));
$MailBody = $MailBody . "</a><br/>\r\n";
$MailBody = $MailBody . "      ";

	      }
	    }
	  
$MailBody = $MailBody . "\r\n";
$MailBody = $MailBody . "      </p>\r\n";
$MailBody = $MailBody . "      \r\n";
$MailBody = $MailBody . "      \r\n";
$MailBody = $MailBody . "      </div>\r\n";
$MailBody = $MailBody . "  </div>\r\n";
$MailBody = $MailBody . "  <div id=\"footer\"></div>\r\n";
$MailBody = $MailBody . "</div>\r\n";
$MailBody = $MailBody . "\r\n";
$MailBody = $MailBody . "</body>\r\n";
$MailBody = $MailBody . "</html>";
  //End Mail Body

  $WA_MailObject = WAUE_SendMail($WA_MailObject,$MailAttachments,$MailBCC,$MailCC,$MailTo,$MailImportance,$MailFrom,$MailSubject,$MailBody);

  $WA_MailObject = null;
?>