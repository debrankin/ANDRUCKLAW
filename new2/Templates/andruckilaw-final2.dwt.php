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
?><!doctype html>
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Andrucki & Associates</title>

<!-- TemplateEndEditable -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
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
</script>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="../p7ehc/p7EHCscripts.js"></script>
<link href="http://fonts.googleapis.com/css?family=Federo" rel="stylesheet" type="text/css">
<!--[if lte IE 7]>
<style>
body {min-width: 1020px;}
.columns-wrapper, .menu-top-wrapper, .p7dmm-sub-wrapper {width: 980px;}
</style>
<![endif]-->

<!-- Accordion panels  -->
<link href="../p7ap3/p7AP3-10.css" rel="stylesheet" type="text/css" media="all">
<link href="../p7ap3/p7ap3-columns.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="../p7ap3/p7AP3scripts.js"></script>
<!-- END accordion panels -->
<!-- bootstrap -->

<!--end bootstrap -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/clara:n4:default;sofia:n4:default;allura:n4:default;lobster-two:n4:default.js" type="text/javascript"></script>
<!--end fonts   -->
<!-- DROP DOWN MENU-->
<link href="../p7mgm/p7MGM-04.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="../p7mgm/p7MGMscripts.js"></script>
<!--END DROP DOWN -->
<!-- PAGE STYLES-->
<link href="../p7affinity/p7affinity-1_03.css" rel="stylesheet" type="text/css">
<link href="../p7affinity/p7affinity_print.css" rel="stylesheet" type="text/css" media="print">
<!--end page styles  -->
<!-- jQuery library -->
<script type="text/javascript">
$(function() {
	$(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			$('#backtotop').fadeIn();	
		} else {
			$('#backtotop').fadeOut();
		}
	});
 
	$('#backtotop').click(function() {
		$('body,html').animate({scrollTop:0},800);
	});	
});
</script><script>
	$(function() {
	  $('a[href*=#]:not([href=#])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
	        $('html,body').animate({
	          scrollTop: target.offset().top
	        }, 1000);
	        return false;
	      }
	    }
	  });
	});
	</script>
<!-- end jquery lib -->
</head>

<body>
<div class="masthead">
<div class="logo"><img src="../images/logo-name-ttrans-trim-white.png" width="324" height="37"  alt=""></div><div class="address"><img src="../images/address.png" width="335" height="37" alt=""/></div>
<div class="clearfloat"></div>
</div>
  <div class="top-navigation">
    <div class="menu-top-wrapper">
      <div id="p7MGM_1" class="p7MGM-04 p7MGM p7MGMdesign-time responsive menu-centered">
        <div id="p7MGMtb_1" class="mgm-toolbar closed"><a href="#" title="Hide/Show Menu">&equiv;</a></div>
        <ul id="p7MGMu_1" class="mgm-root-list">
           <li class="mgm-root-item"><a id="p7MGMa1_1" class="mgm-root-item" href="../index.html">Our Practice</a></li>
          <li class="mgm-root-item mgm-trig"><a id="p7MGMa1_2" class="mgm-root-item mgm-trig" href="../WhoWeAre.html">Who We Are</a></li>
          <li class="mgm-root-item mgm-trig"><a id="p7MGMa1_3" class="mgm-root-item mgm-trig" href="../services.html">Our Services</a></li>
          <li class="mgm-root-item"><a id="p7MGMa1_4" class="mgm-root-item" href="../referals.html">Referals</a></li>
          <li class="mgm-root-item"><a id="p7MGMa1_5" class="mgm-root-item" href="../recognition.html">Recognition</a></li>
          <li class="mgm-root-item"><a id="p7MGMa1_6" class="mgm-root-item" href="../locations.html">Location</a></li>
          <li class="mgm-root-item"><a id="p7MGMa1_7" class="mgm-root-item" href="../contact.php">Contact Us</a></li>
        </ul>
        <div id="p7MGMs1_2" class="mgm-mega-menu width100">
          <div class="mgm-mega-content">
            <div class="p7mgm-row mgm-col-33-33-33 col-sep">
              <div class="p7mgm-Col p7mgm-percent33">
                <div class="p7mgm-ColContent p7ehc-4">
                  <p><a href="../WhoWeAre.html?apm3=#p7AP3c1_1">Judith W. Andrucki</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent33">
                <div class="p7mgm-ColContent p7ehc-4 border-left">
                  <p> <a href="../WhoWeAre.html?apm3=#p7AP3c1_2">Mara R. King</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent33">
                <div class="p7mgm-ColContent p7ehc-4 border-left">
                  <p><a href="../WhoWeAre.html?apm3=#p7AP3c1_3">Elyse B. Segovias</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="p7MGMs1_3" class="mgm-mega-menu width100">
          <div class="mgm-mega-content">
            <div class="p7mgm-row mgm-col-20-20-20-20-20 col-sep">
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-5">
                  <p><a href="../services.html#s1">Keeping You Posted</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-5 border-left">
                  <p><a href="../services.html#s2">Assembling A Team</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-5 border-left">
                  <p><a href="../services.html#s3">Collaborative Divorce</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-5 border-left">
                  <p><a href="../services.html#s4">It’s Your Case — It’s Your Family</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-5 border-left">
                  <p><a href="../services.html#s5">You’ll Get Through It</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">P7_MGMop('p7MGM_1',5,450,0,1,1,1,0,0,1,0,1,900)</script>
      </div>
    </div>
  </div>
<div class="content-wrapper">
  <div class="columns-wrapper">
   <div class="assoc_name">Specializing in Family Law</div>
    <div class="main-content"><!-- TemplateBeginEditable name="left-content" -->
      <div class="content p7ehc-1">
        <p>Andrucki & Associates represents clients in all areas of Family Law including divorce, parental rights, post-judgment matters, preparation of prenuptial agreements and alternate dispute resolution. Centrally located in Lewiston, Maine, we practice in Androscoggin, Cumberland, Sagadahoc, Kennebec, Oxford and Franklin Counties, as well as other counties at our discretion. </p>
        <p> Judith Andrucki formed this practice out of a desire to create a law firm dedicated to the practice of Family Law. The attorneys at Andrucki & Associates share the belief that family law cases, like families, are unique and require skill and attention. Given their experience, Andrucki & Associates provides in-depth and high quality service to individuals involved in domestic dispute. </p>
        <div id="p7AP3_1" class="p7AP3-10 p7AP3">
          <div class="p7AP3trig p7ap3-theme-10">
            <h3><a href="#p7AP3c1_1" id="p7AP3t1_1">Who We Are</a></h3>
          </div>
          <div id="p7AP3w1_1" class="p7AP3cwrapper p7ap3-theme-10">
            <div id="p7AP3c1_1" class="p7AP3content p7ap3-theme-10">
              <div id="p7AP3p1_1" class="p7AP3panelcontent p7ap3-theme-10">
                <div class="p7ap3-col-wrapper multi-columns">
                  <div class="p7ap3-column width-33">
                    <div class="p7ap3-column-content p7ehc-2">
                      
                        <div class="p-lead">Judith W. Andrucki</div>
                  
                      <p>Lorem ipsum dolor sit amet, ne sea vocent scripta abhorreant, facilisi explicari mel ne, ut quo vide ridens. Mei ex quodsi inciderint, quo ad quas deleniti definitionem, <br>
                      <p><a class="btn" href="#">View details &raquo;</a></p>
                      <p></p>
                    </div>
                  </div>
                  <div class="p7ap3-column width-33">
                    <div class="p7ap3-column-content border-left p7ehc-2">
                      <div class="p-lead"> Mara R. King</div>
                      <p>Lorem ipsum dolor sit amet, ne sea vocent scripta abhorreant, facilisi explicari mel ne, ut quo vide ridens. Mei ex quodsi inciderint, quo ad quas deleniti definitionem, <br>
                      <p><a class="btn" href="#">View details &raquo;</a></p>
                    </div>
                  </div>
                  <div class="p7ap3-column width-33">
                    <div class="p7ap3-column-content border-left p7ehc-2">
                      <div class="p-lead">Elyse B. Segovias</div>
                      <p>Lorem ipsum dolor sit amet, ne sea vocent scripta abhorreant, facilisi explicari mel ne, ut quo vide ridens. Mei ex quodsi inciderint, quo ad quas deleniti definitionem, <br>
                      <p><a class="btn" href="#">View details &raquo;</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--[if lte IE 7]><style>.p7AP3, .p7AP3cwrapper, .p7AP3panelcontent, .p7AP3trig a {zoom: 1;}</style><![endif]-->
          <!--[if IE 5]><style>.p7AP3cwrapper {height: auto !important;}</style><![endif]-->
          <script type="text/javascript">P7_opAP3('p7AP3_1',1,2,0,0,1,0,0,0,1,0,1000,250,1,1);</script>
        </div>
        <p>&nbsp;</p>
      </div>
    <!-- TemplateEndEditable --></div>
    <!-- TemplateBeginEditable name="right-sidebar" -->
    <div class="sidebar">
      <div class="content p7ehc-1">
        <div id="contactform">
          <table width="90%" border="0" cellpadding="1" cellspacing="0">
            <tr>
              <td valign="top"><span class="foodtable">Call our Office  at xxx<br />
                <br />
              </span></td>
            </tr>
            <tr>
              <td valign="top"><span class="foodtable">Name</span><br>
                <input name="Contact_Name" type="text" class="inputjoin" id="Contact_Name" value="<?php echo(ValidatedField("contact","Contact_Name")) ?>" size="" />
                <input name="addblock" type="text" id="addblock" style="display:none" value="" />
                <br />
                <?php
if (ValidatedField("contact","contact"))  {
  if ((strpos((",".ValidatedField("contact","contact").","), "," . "1" . ",") !== false || "1" == ""))  {
    if (!(false))  {
?>
                <p class="text-error">* Please provide your name</p>
                <?php //WAFV_Conditional contact.php contact(1:)
    }
  }
}?></td>
            </tr>
            <tr>
              <td valign="top"><span class="foodtable">Phone</span><br>
                <input name="Phone" type="text" class="inputjoin" id="phone" size="" /></td>
            </tr>
            <tr>
              <td valign="top"><span class="foodtable">Email</span> <br>
                <input name="Email_address" type="text" class="inputjoin" id="Email_address" value="<?php echo(ValidatedField("contact","Email_address")) ?>" />
                <input name="seconddblock" id="seconddblock" type="text" style="display:none" value="" />
                <br />
                <?php
if (ValidatedField("contact","contact"))  {
  if ((strpos((",".ValidatedField("contact","contact").","), "," . "2" . ",") !== false || "2" == ""))  {
    if (!(false))  {
?>
                <p class="text-error">* Please provide your email addess</p>
                <?php //WAFV_Conditional contact.php contact(2:)
    }
  }
}?></td>
            </tr>
            <td valign="top"><span class="foodtable">Comments</span> <br>
              <textarea name="Comments" style="width:80%;" id="Comments" class="inputjoin" ><?php echo(ValidatedField("contact","Comments")) ?></textarea>
              <br />
              <?php
if (ValidatedField("contact","contact"))  {
  if ((strpos((",".ValidatedField("contact","contact").","), "," . "3" . ",") !== false || "3" == ""))  {
    if (!(false))  {
?>
              <p class="text-error">* Please add a quick note<br />
              </p>
              <?php //WAFV_Conditional contact.php contact(3:)
    }
  }
}?></td>
            </tr>
            <tr>
              <td valign="top"><label for="Security_code2" class="foodtable" >security code<br>
              </label>
                <img src="WA_ValidationToolkit/WAVT_CaptchaSecurityImages.php?noisecolor=<?php echo $WAGLOBAL_Captcha_Noise; ?>&amp;bgcolor=<?php echo $WAGLOBAL_Captcha_BG; ?>&amp;textcolor=<?php echo $WAGLOBAL_Captcha_Text; ?>&amp;transparent=<?php echo $WAGLOBAL_Captcha_BG_transparent; ?>&amp;characters=<?php echo $WAGLOBAL_Captcha_Characters; ?>&amp;width=<?php echo $WAGLOBAL_Captcha_Width; ?>&amp;height=<?php echo $WAGLOBAL_Captcha_Height; ?>&amp;font=<?php echo $WAGLOBAL_Captcha_Font; ?>" alt="security code" width="90%"/><br  />
                <input name="Security_code" type="text" id="Security_code" class="inputValue" maxlength="30" />
                <br />
                <?php
if (ValidatedField("contact","contact"))  {
  if ((strpos((",".ValidatedField("contact","contact").","), "," . "4" . ",") !== false || "4" == ""))  {
    if (!(false))  {
?>
                <p class="text-error">* Your security code entry did not match the image.</p>
                <?php //WAFV_Conditional contact.php contact(4:)
    }
  }
}?></td>
            </tr>
            <tr>
              <td><input name="button" type="submit" class="inputButton" id="button"  /></td>
            </tr>
          </table>
        </div>
        <h1>&nbsp;</h1>
      </div>
    </div>
    <!-- TemplateEndEditable --></div><div class="totop">
      <div id="backtotop">Scroll to Top</div>
    </div>
</div>
<div class="footer">
  <p>Home | Our Practice | Who We Are | Our Services | Referals	 | Awards &amp; Recognition | Location | Contact Us<br>
      <span class="copyright">©2017 Andrucki Law Offices - All Rights Reserved</span><br>
      179 Lisbon Street, Lewsiton, Maine 04243-7120 - Phone (207) 777- 4600</p>
    <p><a href="#">Terms &amp; Conditions</a></p></div>
</body>
</html>
