<?php require_once('WA_Globals/WA_Globals.php');?>
<?php require_once("WA_ValidationToolkit/WAVT_Scripts_PHP.php"); ?>
<?php require_once("WA_ValidationToolkit/WAVT_ValidatedForm_PHP.php"); ?>
<?php require_once("WA_Universal_Email/Mail_for_Linux_PHP.php"); ?>
<?php require_once("WA_Universal_Email/MailFormatting_PHP.php"); ?>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST")  {
  $WAFV_Redirect = "";
  $_SESSION['WAVT_contact_Errors'] = "";
  if ($WAFV_Redirect == "")  {
    $WAFV_Redirect = $_SERVER["PHP_SELF"];
  }
  $WAFV_Errors = "";
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["Contact_Name"]))?$_POST["Contact_Name"]:"") . "",true,1);
  $WAFV_Errors .= WAValidateEM(((isset($_POST["Email_address"]))?$_POST["Email_address"]:"") . "",true,2);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["Comments"]))?$_POST["Comments"]:"") . "",true,3);
  $WAFV_Errors .= WAValidateLE(((isset($_POST["Security_code"]))?strtolower($_POST["Security_code"]):"") . "",((isset($_SESSION["captcha_1"]))?strtolower($_SESSION["captcha_1"]):"") . "",true,4);

  $WAFV_Errors .= WAValidateRX(((isset($_POST["addblock"]))?$_POST["addblock"]:"") . "","/^$/i",false,6);
  $WAFV_Errors .= WAValidateRX(((isset($_POST["seconddblock"]))?$_POST["seconddblock"]:"") . "","/^$/i",false,7);

  if ($WAFV_Errors != "")  {
    PostResult($WAFV_Redirect,$WAFV_Errors,"contact");
  }
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")  {
  //WA Universal Email object="Mail for Linux"
  //Send Loop Once Per Entry
  $RecipientEmail = "".($WAGLOBAL_Email_To)  ."";include("WA_Universal_Email/WAUE_contact_1.php");

  //Send Mail All Entries
  if ("index.php"!="")     {
    header("Location: thankyou.php");
  }
}
?><script type="text/javascript">
<!--
function WAtrimIt(theString,leaveLeft,leaveRight)  {
  if (!leaveLeft)  {
    while (theString.charAt(0) == " ")
      theString = theString.substring(1);
  }
  if (!leaveRight)  {
    while (theString.charAt(theString.length-1) == " ")
      theString = theString.substring(0,theString.length-1);
  }
  return theString;
}

function WAFV_GetValueFromInputType(formElement,inputType,trimWhite) {
  var value="";
  if (inputType == "select")  {
    if (formElement.selectedIndex != -1 && formElement.options[formElement.selectedIndex].value && formElement.options[formElement.selectedIndex].value != "") {
      value = formElement.options[formElement.selectedIndex].value;
    }
  }
  else if (inputType == "checkbox")  {
    if (formElement.length)  {
      for (var x=0; x<formElement.length ; x++)  {
        if (formElement[x].checked && formElement[x].value!="")  {
          value = formElement[x].value;
          break;
        }
      }
    }
    else if (formElement.checked)
      value = formElement.value;
  }
  else if (inputType == "radio")  {
    if (formElement.length)  {
      for (var x=0; x<formElement.length; x++)  {
        if (formElement[x].checked && formElement[x].value!="")  {
          value = formElement[x].value;
          break;
        }
      }
    }
    else if (formElement.checked)
      value = formElement.value;
  }
  else if (inputType == "radiogroup")  {
    for (var x=0; x<formElement.length; x++)  {
      if (formElement[x].checked && formElement[x].value!="")  {
        value = formElement[x].value;
        break;
      }
    }
  }
  else if (inputType == "iRite")  {
     var theEditor = FCKeditorAPI.GetInstance(formElement.name) ;
     value = theEditor.GetXHTML(true);
  }
  else  {
    var value = formElement.value;
	value=value.replace(/<p>(\&\#160\;)*<\/p>/,"");
  }
  if (trimWhite)  {
    value = WAtrimIt(value);
  }
  return value;
}

function WAAddError(formElement,errorMsg,focusIt,stopIt)  {
  if (document.WAFV_Error)  {
	  document.WAFV_Error += "\n" + errorMsg;
  }
  else  {
    document.WAFV_Error = errorMsg;
  }
  if (!document.WAFV_InvalidArray)  {
    document.WAFV_InvalidArray = new Array();
  }
  document.WAFV_InvalidArray[document.WAFV_InvalidArray.length] = formElement;
  if (focusIt && !document.WAFV_Focus)  {
	document.WAFV_Focus = focusIt;
  }

  if (stopIt == 1)  {
	document.WAFV_Stop = true;
  }
  else if (stopIt == 2)  {
	formElement.WAFV_Continue = true;
  }
  else if (stopIt == 3)  {
	formElement.WAFV_Stop = true;
	formElement.WAFV_Continue = false;
  }
}

function WAValidateRQ(formElement,errorMsg,focusIt,stopIt,trimWhite,inputType)  {
  var isValid = true;
  if (!document.WAFV_Stop && !formElement.WAFV_Stop)  {
    var value=WAFV_GetValueFromInputType(formElement,inputType,trimWhite);
    if (value == "")  {
	    isValid = false;
    }
  }
  if (!isValid)  {
    WAAddError(formElement,errorMsg,focusIt,stopIt);
  }
}
function WAValidateEM(formElement,value,errorMsg,focusIt,stopIt,required) {
  var isValid = true;
  if ((!document.WAFV_Stop && !formElement.WAFV_Stop) && !(!required && value==""))  {
    value = value.toLowerCase();
    var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/i;
    var emailPat = /^(.+)@(.+)$/i;
    var accepted = "\[^\\s\\(\\)><@,;:\\\\\\\"\\.\\[\\]\]+";
    var quotedUser = "(\"[^\"]*\")";
    var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/i;
    var section = "(" + accepted + "|" + quotedUser + ")";
    var userPat = new RegExp("^" + section + "(\\." + section + ")*$");
    var domainPat = new RegExp("^" + accepted + "(\\." + accepted +")*$");
    var theMatch = value.match(emailPat);
    var acceptedPat = new RegExp("^" + accepted + "$");
    var userName = "";
    var domainName = "";
    if (theMatch==null) {
      isValid = false;
    }
    else  {
      userName = theMatch[1];
      domainName = theMatch[2];
	  var domArr = domainName.split(".");
	  var IPArray = domainName.match(ipDomainPat);
      for (x=0; x < userName.length; x++) {
        if ((userName.charCodeAt(x) > 127 && userName.charCodeAt(x) < 192) || userName.charCodeAt(x) > 255) {
          isValid = false;
        }
      }
      for (x=0; x < domainName.length; x++) {
        if ((domainName.charCodeAt(x) > 127 && domainName.charCodeAt(x) < 192) || domainName.charCodeAt(x) > 255) {
          isValid = false;
        }
      }
      if (userName.match(userPat) == null) {
        isValid = false;
      }
      if (IPArray != null) {
        for (var x=1; x<=4; x++) {
          if (IPArray[x] > 255) {
            isValid = false;
          }
        }
      }
      for (x=0; x < domArr.length; x++) {
        if (domArr[x].search(acceptedPat) == -1 || domArr[x].length == 0 || (domArr[x].length < 2 && x >= domArr.length-2  && x > 0)) {
          isValid = false;
        }
      }
      if (domArr[domArr.length-1].length !=2 && domArr[domArr.length-1].search(knownDomsPat) == -1) {
        isValid = false;
      }
      if (domArr.length < 2) {
        isValid = false;
      }
    }
  }
  if (!isValid)  {
    WAAddError(formElement,errorMsg,focusIt,stopIt);
  }
}
function WAAlertErrors(errorHead,errorFoot,setFocus,submitForm)  { 
  if (!document.WAFV_StopAlert)  { 
	  document.WAFV_StopAlert = true;
	  if (document.WAFV_InvalidArray)  {  
	    document.WAFV_Stop = true;
        var errorMsg = document.WAFV_Error;
	    if (errorHead!="")
		  errorMsg = errorHead + "\n" + errorMsg;
		if (errorFoot!="")
		  errorMsg += "\n" + errorFoot;
		document.MM_returnValue = false;
		if (document.WAFV_Error!="")
		  alert(errorMsg.replace(/&quot;/g,'"'));
		else if (submitForm)
		  submitForm.submit();
	    if (setFocus && document.WAFV_Focus)  {
		  if (document.getElementById(document.WAFV_Focus.name+"___Config") && document.WAFV_Focus.type.toLowerCase() == "hidden")  {
	        var theEditor = FCKeditorAPI.GetInstance(document.WAFV_Focus.name);
		    theEditor.EditorWindow.focus();
			setTimeout("setTimeout('document.WAFV_Stop = false;document.WAFV_StopAlert = false;',1)",1); 
		  }
		  else  {
		    document.tempFocus = document.WAFV_Focus;
			setTimeout("document.tempFocus.focus();setTimeout('document.WAFV_Stop = false;document.WAFV_StopAlert = false;',1)",1); 
		  }
        }
        else {
          document.WAFV_Stop = false;
          document.WAFV_StopAlert = false;
        }
        for (var x=0; x<document.WAFV_InvalidArray.length; x++)  {
	      document.WAFV_InvalidArray[x].WAFV_Stop = false;
	    }
	  }
	  else  {
        document.WAFV_Stop = false;
        document.WAFV_StopAlert = false;
	    if (submitForm)  {
	      submitForm.submit();
	    }
	    document.MM_returnValue = true;
	  }
      document.WAFV_Focus = false;
	  document.WAFV_Error = false;
	  document.WAFV_InvalidArray = false;
  }
}
//-->
</script><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<div style="width:20%;padding:2px;">
  <form action="" method="post" name="emailContact" id="emailContact" onsubmit="WAValidateRQ(document.emailContact.Contact_Name,'- Please enter your name',document.emailContact.Contact_Name,0,false,'text');WAValidateEM(document.emailContact.Email_address,document.emailContact.Email_address.value,'- Please enter your email address',document.emailContact.Email_address,0,true);WAValidateRQ(document.emailContact.Comments,'- Please provide a comment so that we know how best to assist you',document.emailContact.Comments,0,true,'textarea');WAValidateRQ(document.emailContact.Security_code,'- Please enter the text as it appears in the image above',document.emailContact.Security_code,0,false,'text');WAValidateRQ(document.emailContact.Security_question,'- Please answer the question to ensure a human is filling out this form.',document.emailContact.Security_question,0,false,'text');WAAlertErrors('The following errors were found','Correct invalid entries to continue',true,false);return document.MM_returnValue"> 
    <div id="contactform">
      <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td valign="top"><span >Contact our Offices<br />
            <br />
          </span></td>
        </tr>
        <tr>
          <td valign="top"><span >Name</span>
            <input name="Contact_Name" type="text" class="inputjoin" id="Contact_Name" placeholder="Full Name" value="<?php echo(ValidatedField("contact","Contact_Name")) ?>" />
            <input name="addblock" type="text" id="addblock" style="display:none" value="" />
            <br />
            <?php
if (ValidatedField("contact","contact"))  {
  if ((strpos((",".ValidatedField("contact","contact").","), "," . "1" . ",") !== false || "1" == ""))  {
    if (!(false))  {
?>
            <p class="emailFormError">* Please provide your name</p>
          <?php //WAFV_Conditional contact.php contact(1:)
    }
  }
}?></td>
        </tr>
        <tr>
          <td valign="top"><span >Phone</span>            <input name="Phone" type="text" class="inputjoin" id="phone" placeholder="Phone" /></td>
        </tr>
        <tr>
          <td valign="top"><span >Email</span>
            <input name="Email_address" type="text" class="inputjoin" id="Email_address" placeholder="Email" value="<?php echo(ValidatedField("contact","Email_address")) ?>" />
            <input name="seconddblock" id="seconddblock" type="text" style="display:none" value="" />
            <br />
            <?php
if (ValidatedField("contact","contact"))  {
  if ((strpos((",".ValidatedField("contact","contact").","), "," . "2" . ",") !== false || "2" == ""))  {
    if (!(false))  {
?>
            <p class="emailFormError">* Please provide your email addess</p>
          <?php //WAFV_Conditional contact.php contact(2:)
    }
  }
}?></td>
        </tr>
        
        <td valign="top"><span >Comments</span>
            <textarea name="Comments" rows="10" class="inputjoin" id="Comments" placeholder="How may we help?" ><?php echo(ValidatedField("contact","Comments")) ?></textarea>
            <br />
            <?php
if (ValidatedField("contact","contact"))  {
  if ((strpos((",".ValidatedField("contact","contact").","), "," . "3" . ",") !== false || "3" == ""))  {
    if (!(false))  {
?>
            <p class="emailFormError">* Please add a quick note<br />
            </p>
          <?php //WAFV_Conditional contact.php contact(3:)
    }
  }
}?></td>
          </tr>
        <tr>
          <td valign="top"><label for="Security_code2"  >security code</label>            <img src="WA_ValidationToolkit/WAVT_CaptchaSecurityImages.php?noisecolor=<?php echo $WAGLOBAL_Captcha_Noise; ?>&amp;bgcolor=<?php echo $WAGLOBAL_Captcha_BG; ?>&amp;textcolor=<?php echo $WAGLOBAL_Captcha_Text; ?>&amp;transparent=<?php echo $WAGLOBAL_Captcha_BG_transparent; ?>&amp;characters=<?php echo $WAGLOBAL_Captcha_Characters; ?>&amp;width=<?php echo $WAGLOBAL_Captcha_Width; ?>&amp;height=<?php echo $WAGLOBAL_Captcha_Height; ?>&amp;font=<?php echo $WAGLOBAL_Captcha_Font; ?>" alt="security code" /><br  />
            <input name="Security_code" type="text" id="Security_code" class="inputValue" maxlength="40" />
            <br />
            <?php
if (ValidatedField("contact","contact"))  {
  if ((strpos((",".ValidatedField("contact","contact").","), "," . "4" . ",") !== false || "4" == ""))  {
    if (!(false))  {
?>
            <p class="emailFormError">* Your security code entry did not match the image.</p>
          <?php //WAFV_Conditional contact.php contact(4:)
    }
  }
}?></td>
        </tr>
        <tr>
          <td><input name="button" type="submit" class="inputButton" id="button"  /></td>
        </tr>
        </table>
    </div></form>
</div>
</body>
</html>