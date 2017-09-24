<?php

   // include site files
   include("../includes/php/settings.php");
   include("../includes/php/mysqli.php");
   include("../includes/php/top2.php");

   // get data

   if (empty($_GET)) {
      goto wrongdata;
   }

   $username = @$_GET['username'];

   // escape stings
  
   $username= mysqli_real_escape_string($dbhandle , $username );

   //check data

      //username

      if (empty($username)) {
         goto wrongdata;
      }

   // generate random code
   
   $resetkey = mt_rand(10000, 9999999999999);

   // get account info

   $strQuery2 = "SELECT `Email`,`VoorNaam`,`AchterNaam` FROM `leerkrachten` WHERE `Email` = '$username'";
   $result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
   $response = mysqli_fetch_array($result2);
   
   $email= $response[Email];
   $firstname = $response[VoorNaam];
   $lastname = $response[AchterNaam];

   if ($response == NULL ) {
      goto wrongdata;
   } else {
      
   }
   
   // check db and write

   $strQuery = "UPDATE `leerkrachten` SET `Reset`= '1',`ResetKey`='$resetkey' WHERE `Email` = '$username'";
   $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
   $dbhandle->close();
   
   // send email
   
   $strQuery = "SELECT SettingValue FROM settings WHERE idSettings = 6;";
   $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
   $response = mysqli_fetch_array($result);
   $fromemail = $response[SettingValue];

   $msg = "<html><head><title>Reset your password.</title></head><body><p>Hi $firstname $lastname,<br><br>To reset your password open the folowing link: <a href='". $baseurl ."account/resetpassword.php?username=$username&resetkey=$resetkey'>reset</a><br><br>dezeeparel.toekomstperspectief.be </p></body></html>";
   $msg = wordwrap($msg,70);
   $headers = 'From: '.$fromemail. "\r\n" .
   'MIME-Version: 1.0' . "\r\n" .
   'Content-type:text/html;charset=UTF-8' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();
   
   mail($email,"reset uw wachtwoord.",$msg,$headers);
   echo "<p>Kijk uw email na</p>";
   include("../includes/php/bottom.php");
   exit;

   wrongdata:
      echo "<p>Invalid input</p>";
	  include("../includes/php/bottom.php");
      exit;
?>