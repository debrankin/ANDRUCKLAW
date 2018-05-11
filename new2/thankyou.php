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
<html><!-- InstanceBegin template="/Templates/andruckilaw-final.dwt" codeOutsideHTMLIsLocked="false" --><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Andrucki &amp; Associates</title>
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
<!-- InstanceEndEditable -->
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
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.css" />
<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-responsive.css" />
<script type="text/javascript" src="ScriptLibrary/jquery-latest.pack.js"></script>
<!-- InstanceEndEditable -->
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<link href='http://fonts.googleapis.com/css?family=Josefin+Slab:400,400italic|Droid+Serif:400,400italic|Handlee' rel='stylesheet' type='text/css'>
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/clara:n4:default;sofia:n4:default;allura:n4:default;lobster-two:n4:default;dynalight:n4:default;fondamento:n4:default.js" type="text/javascript"></script>
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
</script>
<script>
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
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<!-- end jquery lib -->
<script type="text/javascript" src="../p7ttm/p7TTMscripts.js"></script>
<script type="text/javascript">
P7_opTTM('id:fbtrans1','att:title','p7TTM04',8,300,5,1,1,0,0,1,300,0,1,1,0,0,0,0);
P7_opTTM('id:p7Tooltip_1','att:title','p7TTM04',8,300,5,1,1,0,0,1,300,0,1,1,0,0,0,0);
P7_opTTM('id:p7Tooltip_2','att:title','p7TTM04',8,300,9,1,1,0,0,1,300,0,1,1,0,0,0,0);
</script>
<!-- InstanceBeginEditable name="miscscripts" -->
<!-- InstanceEndEditable -->
<link href="../p7ttm/p7TTM04.css" rel="stylesheet" type="text/css" media="all">
</head>

<body onLoad="MM_preloadImages('../images/fb-red.png')">

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=269315189915408";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="masthead">
  <div class="logoaddress">
  <div class="logo"></div>
  <div class="logo-narrow"><img src="../images/Andrucki_logo_500px.png" width="300" height="74"  alt=""></div>
  <div class="address"><br>
    <div style="padding-bottom: 3px; padding-top: 3px;">Reach us at:&nbsp; (207) 777-4600 <a href="#"><img src="../images/facebook-white-trans.png" alt="" width="40" height="36" class="p7TTM_trg" id="fbtrans1" title="We are preparing our Facebook profile and will make available later this month" onMouseOver="MM_swapImage('fbtrans1','','../images/fb-red.png',1)" onMouseOut="MM_swapImgRestore()"/></a>&nbsp;</div></div>
    <div class="address-narrow">
      <img src="../images/address2.png" width="300" height="54" alt=""/><br>
    <div style="padding-bottom: 3px; padding-top: 3px;">Reach us at:&nbsp; (207) 777- 4600&nbsp;<a href="#"> <img src="../images/facebook-white-trans.png" alt="" width="40" height="36" class="p7TTM_trg" id="p7Tooltip_1" title="We are preparing our Facebook profile and will make available later this month"/></a>&nbsp;</div></div>
    <div class="clearfloat"></div>
  </div>
</div>
<div class="masthead-mobile">
<div class="logo"><img src="../images/Andrucki_logo_500px.png" width="330" height="81"  alt="" ></div>
<div class="logo-narrow"><img src="../images/Andrucki_logo_500px.png" width="300" height="74"  alt=""></div>
<div class="address">
  <img src="../images/address2.png" width="360" height="54" alt="" /><br>
  <div style="padding-bottom: 3px; padding-top: 3px;">Reach us at:&nbsp; (207) 777- 4600&nbsp; <img src="../images/facebook-white-trans.png" alt="" width="40" height="36" id="fbtrans" onMouseOver="MM_swapImage('fbtrans','','../images/fb-red.png',1)" onMouseOut="MM_swapImgRestore()"/>&nbsp;</div></div>
  <div class="address-narrow">
  <img src="../images/address2.png" width="300" height="54" alt=""/><br>
  <div style="padding-bottom: 3px; padding-top: 3px;">Reach us at:&nbsp; (207) 777- 4600&nbsp; <img src="../images/facebook-white-trans.png" width="40" height="36" alt=""/>&nbsp;</div></div><div class="assoc_name-narrow">Specializing in Family Law</div>
<div class="clearfloat"></div>
</div>

  <div class="top-navigation">
    <div class="menu-top-wrapper">
      <div id="p7MGM_1" class="p7MGM-04 p7MGM p7MGMdesign-time responsive menu-centered">
        <div id="p7MGMtb_1" class="mgm-toolbar closed"><a href="#" title="Hide/Show Menu">&equiv;</a></div>
        <ul id="p7MGMu_1" class="mgm-root-list">
          <li class="mgm-root-item"><a id="p7MGMa1_1" class="mgm-root-item" href="../index.php">Our Practice</a></li>
          <li class="mgm-root-item mgm-trig"><a id="p7MGMa1_2" class="mgm-root-item mgm-trig" href="../WhoWeAre.html">Who We Are</a></li>
          <li class="mgm-root-item mgm-trig"><a id="p7MGMa1_3" class="mgm-root-item mgm-trig" href="../services.html">Our Approach</a></li>
          <li class="mgm-root-item"><a id="p7MGMa1_4" class="mgm-root-item" href="../community.html">Supporting Our Community</a></li>
          <li class="mgm-root-item"><a id="p7MGMa1_5" class="mgm-root-item" href="../locations.html">Location</a></li>
          <li class="mgm-root-item"><a id="p7MGMa1_6" class="mgm-root-item" href="../contact.php">Contact Us</a></li>
        </ul>
        
          <div id="p7MGMs1_2" class="mgm-mega-menu width100">
          <div class="mgm-mega-content">
            <div class="p7mgm-row mgm-col-25-25-25-25-25 col-sep">
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-4">
                  <p style=""><a href="../WhoWeAre.html?apm3=#p7AP3c1_1">Judith W. Andrucki</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-4 border-left">
                  <p style=""> <a href="../WhoWeAre.html?apm3=#p7AP3c1_2">Mara R. King</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-4 border-left">
                  <p style=""><a href="../WhoWeAre.html?apm3=#p7AP3c1_3">Elyse B. Segovias</a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-4 border-left">
                  <p style=""><a href="../WhoWeAre.html?apm3=#p7AP3c1_4">Elliott L. Epstein</a></p>
                </div>
              </div>
               <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-4 border-left">
                  <p style=""><a href="../WhoWeAre.html?apm3=#p7AP3c1_5">Leonard "Lenny" Sharon</a></p>
                </div>
              </div>
					 <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-4 border-left"><p style=""><a href="../WhoWeAre.html?apm3=#p7AP3c1_6">Jaime Shorter</a></p>
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
                  <p><a href="../services.html#s5">You’ll Get Through It</a><a href="../services.html#s4"></a></p>
                </div>
              </div>
              <div class="p7mgm-Col p7mgm-percent20">
                <div class="p7mgm-ColContent p7ehc-5 border-left">
                  <p><a href="../services.html#s6">Referrals</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">P7_MGMop('p7MGM_1',5,450,1,1,1,1,0,0,1,0,1,900)</script>
      </div>
    </div>
  </div>
  <div class="assoc_name-narrow">Specializing in Family Law</div>
<div class="content-wrapper">
  <div class="columns-wrapper">
   <div class="assoc_name">Specializing in Family Law</div>
   <div class="main-content"><!-- InstanceBeginEditable name="left-content" -->
      <div class="content p7ehc-1">
        <h1>Thankyou for contacting us. We will get back to you shortly.</h1>
        <p>If you require immediate assistance, Please call our office at (207) 777 - 4600</p>
        <p>&nbsp;</p>
        <p>***need to add a disclaimer about attorney-client relationship</p>  
        <p>Disclaimer<br>
          Any communication with us in our capacity as  attornies, whether by e-mail or by other means, does not create an attorney-client relationship and is therefore not privileged until the client and the attorney have agreed upon legal representation.<br>
          For this reason, do not send confidential information to me without first directly communicating with me about the attorney-client relationship.<br>
        If you agree with these terms, please click here to email my office.</p>
      </div>
    <!-- InstanceEndEditable --></div>
    <!-- InstanceBeginEditable name="right-sidebar" -->
    <div class="sidebar">
      <div class="content p7ehc-1">
         <form action="" method="post" name="emailContact" id="emailContact" onsubmit="WAValidateRQ(document.emailContact.Contact_Name,'- Please enter your name',document.emailContact.Contact_Name,0,false,'text');WAValidateEM(document.emailContact.Email_address,document.emailContact.Email_address.value,'- Please enter your email address',document.emailContact.Email_address,0,true);WAValidateRQ(document.emailContact.Comments,'- Please provide a comment so that we know how best to assist you',document.emailContact.Comments,0,true,'textarea');WAValidateRQ(document.emailContact.Security_code,'- Please enter the text as it appears in the image above',document.emailContact.Security_code,0,false,'text');WAValidateRQ(document.emailContact.Security_question,'- Please answer the question to ensure a human is filling out this form.',document.emailContact.Security_question,0,false,'text');WAAlertErrors('The following errors were found','Correct invalid entries to continue',true,false);return document.MM_returnValue"> <div id="contactform">
        <table width="90%" border="0" cellpadding="1" cellspacing="0">
          <tr>
            <td valign="top"><span class="foodtable">Call our Office  at xx<br />
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
            <td valign="top"><span class="foodtable">Phone</span><br><input name="Phone" type="text" class="inputjoin" id="phone" size="" /></td>
            </tr>
          <tr>
            <td valign="top"><span class="foodtable">Email</span>
              <br>
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
          
          <td valign="top"><span class="foodtable">Comments</span>
              <br>
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
            </label>              <img src="WA_ValidationToolkit/WAVT_CaptchaSecurityImages.php?noisecolor=<?php echo $WAGLOBAL_Captcha_Noise; ?>&amp;bgcolor=<?php echo $WAGLOBAL_Captcha_BG; ?>&amp;textcolor=<?php echo $WAGLOBAL_Captcha_Text; ?>&amp;transparent=<?php echo $WAGLOBAL_Captcha_BG_transparent; ?>&amp;characters=<?php echo $WAGLOBAL_Captcha_Characters; ?>&amp;width=<?php echo $WAGLOBAL_Captcha_Width; ?>&amp;height=<?php echo $WAGLOBAL_Captcha_Height; ?>&amp;font=<?php echo $WAGLOBAL_Captcha_Font; ?>" alt="security code" width="90%"/><br  />
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
      </div></form>
      </div>
    </div>
    <!-- InstanceEndEditable --></div><div class="totop">
      <div id="backtotop">Scroll to Top</div>
    </div>
</div>
<div class="footer">
  <p><a href="../index.php">Home</a> | <a href="../index.php">Our Practice</a> | <a href="../WhoWeAre.html">Who We Are</a> | <a href="../services.html">Our Approach</a> | <a href="../community.html">Supporting	Our Community</a> | <a href="../locations.html">Location</a> | <a href="../contact.php">Contact Us</a><br>
    <br>
    <span class="copyright">©2017 Andrucki Law Offices - All Rights Reserved</span><br>
179 Lisbon Street, Lewsiton, Maine 04243-7120 - Phone (207) 777- 4600</p>
  <p>&nbsp;</p>
</div><script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52852820-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
<!-- InstanceEnd --></html>
