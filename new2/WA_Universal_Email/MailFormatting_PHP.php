<?php
function WAUE_isAttachment($attPath) {
  if ($attPath && $attPath != "" && strpos($attPath, ".") > 0) {
    return true;
  }
  return false;
}

function WAUE_isEmailAddress($testAddress) {
  $isValidEmail = true;
  if (strpos($testAddress, ";") !== false) {
      $testAddress = substr($testAddress, 0, strpos($testAddress, ";"));
  }
  if (strpos($testAddress, ",") !== false) {
      $testAddress = substr($testAddress, 0, strpos($testAddress, ","));
  }
  if (strpos($testAddress, "<") !== false && strpos($testAddress, "<") < strpos($testAddress, "@")) {
    $testAddress = substr($testAddress, strpos($testAddress, "<")+1);
    if (strpos($testAddress, ">") !== false && strpos($testAddress, ">") > strpos($testAddress, "@")) {
      $testAddress = substr($testAddress, 0, strpos($testAddress, ">"));
    }
  }
  if ($testAddress != "")  {
    $knownDomsPat = "/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/";
    $emailPat = "/^(.+)@(.+)$/";
    $accepted = "[^\s\(\)><@,;:\\\"\.\[\]]+";
    $quotedUser = "(\"[^\"]*\")";
    $ipDomainPat = "/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/";
    $section = "(".$accepted."|".$quotedUser.")";
    $userPat = "/^".$section."(\\.".$section.")*$/";
    $domainPat = "/^".$accepted."(\\.".$accepted.")*$/";
    $theMatch = preg_match($emailPat,$testAddress,$MatchVal);
    $acceptedPat = "/^" . $accepted . "$/";
    $userName = "";
    $domainName = "";
    if (!$theMatch) {
      $isValidEmail = false;
    }
    else  {
      $userName = $MatchVal[1];
      $domainName = $MatchVal[2];
      $domArr = split("\.",$domainName);
      $IPArray = preg_match($ipDomainPat,$domainName,$ipMatch);
      for ($x=0; $x < strlen($userName); $x++) {
        if ((ord(substr($userName,$x,1)) > 127 && ord(substr($userName,$x,1)) < 192) || ord(substr($userName,$x,1)) > 255) {
          $isValidEmail = false;
        }
      }
      for ($x=0; $x < strlen($domainName); $x++) {
        if ((ord(substr($domainName,$x,1)) > 127 && ord(substr($domainName,$x,1)) < 192) || ord(substr($domainName,$x,1)) > 255) {
          $isValidEmail = false;
        }
      }
      if (!preg_match($userPat,$userName)) {
        $isValidEmail = false;
      }
      if ($IPArray) {
        for ($x=1; $x <= 4; $x++) {
          if ($IPArray[x] > 255) {
            $isValidEmail = false;
          }
        }
      }
	  for ($x=0; $x<sizeof($domArr); $x++) {
        if (!preg_match($acceptedPat,$domArr[$x]) || strlen($domArr[$x]) == 0 || (strlen($domArr[$x]) < 2 && $x >= sizeof($domArr)-2)) {
          $isValidEmail = false;
        }
      }
      if (strlen($domArr[count($domArr)-1]) !=2 && !preg_match($knownDomsPat,$domArr[count($domArr)-1])) {
        $isValidEmail = false;
      }
      if (count($domArr) < 2) {
        $isValidEmail = false;
      }
    }
  }
  return $isValidEmail;
}

function WA_getEmailArray($emailStr)     {
  $retArray = array();
  $emailArr = explode(";",$emailStr);
  foreach ($emailArr AS $emailString)     {
    if (strpos($emailString,"@") > 0)     {
      $emailArr2 = explode("|WA|", $emailString);
      if (sizeof($emailArr2) == 1)     {
        $tempArray    = array(2);
        $tempArray[0] = "";
        $tempArray[1] = WA_StripSpaces($emailString);
        $retArray[]   = $tempArray;
      }
      else     {
        $tempArr = array("", "");
        $eArr0 = $emailArr2[0];
        $eArr1 = $emailArr2[1];
        if (strpos($eArr1, "@") !== false)      {
          $tempArr[0] = WA_StripSpaces($emailArr2[0]);
          $tempArr[1] = WA_StripSpaces($emailArr2[1]);
        }
        else     {
          $tempArr[0] = WA_StripSpaces($emailArr2[1]);
          $tempArr[1] = WA_StripSpaces($emailArr2[0]);
        }
        $retArray[] = $tempArr;
      }
    }
  }
  return $retArray;
}

function WA_FormatColumn($align,$numspaces,$content)     {
  $WA_FormatColumn_return = "";
  $numspaces = intval($numspaces);
  if (strlen($content) > $numspaces)     {
    $WA_FormatColumn_return = substr($content,0,$numspaces);
  }
  else     {
    switch (strtolower($align)) {
      case "right":
        $WA_FormatColumn_return = WA_RightAlign($numspaces,$content);
        break;
      case "left":
        $WA_FormatColumn_return = WA_LeftAlign($numspaces,$content);
        break;
    }
    if (strtolower($align) == "center")     {
      $WA_FormatColumn_return = WA_CenterAlign($numspaces,$content);
    }
  }

  return $WA_FormatColumn_return;
}

function WA_RightAlign($numspaces, $content)     {
  $WA_RightAlign_return = $content;
  while (strlen($WA_RightAlign_return) < $numspaces)     {
    $WA_RightAlign_return = " ".$WA_RightAlign_return;
  }
  return $WA_RightAlign_return;
}

function WA_LeftAlign($numspaces, $content)     {
  $WA_LeftAlign_return = $content;
  while (strlen($WA_LeftAlign_return) < $numspaces)     {
    $WA_LeftAlign_return = $WA_LeftAlign_return." ";
  }
  return $WA_LeftAlign_return;
}

function WA_CenterAlign($numspaces, $content)     {
  $WA_CenterAlign_return = $content;
  for ($n=strlen($content); $n<$numspaces; $n++)     {
    if (($n%2) == 1)     {
      $WA_CenterAlign_return = $WA_CenterAlign_return." ";
    }
    else     {
      $WA_CenterAlign_return = " ".$WA_CenterAlign_return;
    }
  }
  return $WA_CenterAlign_return;
}

function WA_StripSpaces($inStr)     {
  $outStr = $inStr;
  $firstchar = substr($outStr, 0, 1);
  while ($firstchar == " ")     {
    $outStr = substr($outStr,1);
    $firstchar = substr($outStr, 0, 1);
  }
  $firstchar = substr($outStr, strlen($outStr)-1, 1);
  while ($firstchar == " ")     {
    $outStr = substr($outStr, 0, strlen($outStr)-1);
    $firstchar = substr($outStr, strlen($outStr)-1, 1);
  }
  return $outStr;
}

function WA_TrimLeadingSpaces($inStr)     {
  $outStr = $inStr;
  $firstchar = substr($outStr, 0, 1);
  while ($firstchar == " ")     {
    $outStr = substr($outStr,1);
    $firstchar = substr($outStr, 0, 1);
  }
  $firstchar = substr($outStr, strlen($outStr)-1, 1);
  while ($firstchar == " ")     {
    $outStr = substr($outStr, 0, strlen($outStr)-1);
    $firstchar = substr($outStr, strlen($outStr)-1, 1);
  }
  return $outStr;
}

function WA_StripTags($bodytext)  {
  if (strpos($bodytext,"<body") !== false)
    $bodytext = substr($bodytext,strpos($bodytext,"<body"));
  $bodytext = preg_replace("/\s{1,}/"," ",$bodytext); 
  $bodytext = preg_replace("/ {1,}/"," ",$bodytext);
  $bodytext = preg_replace("/<(p|br|tr)>/i","\r\n",$bodytext);
  $bodytext = preg_replace("/<(p |br |tr )([^>]*>)/i","\r\n",$bodytext); 
  $bodytext = preg_replace("/<(li|td|th)>/i","\t",$bodytext);
  $bodytext = preg_replace("/<(li |td |th )([^>]*>)/i","\t",$bodytext);
  $bodytext = preg_replace("/(<\/?)(\w+)([^>]*>)/","",$bodytext);
  return $bodytext;
}
?>