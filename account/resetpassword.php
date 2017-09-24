<?php

   // include site files
   include("../includes/php/mysqli.php");
   include("../includes/php/top2.php");

   // get data

   if (empty($_GET)) {
      goto wrongdata;
   }

   $username = @$_GET['username'];
   $resetkey= @$_GET['resetkey'];

   // escape stings
  
   $username= mysqli_real_escape_string($dbhandle , $username );
   $resetkey= mysqli_real_escape_string($dbhandle , $resetkey);

   //check data

      //username

      if (empty($username)) {
         goto wrongdata;
      }

      // verifykey

      if (empty($resetkey)) {
         goto wrongdata;
      }

   $characters = 'abcdefghjkmnopqrstuvwxyz0123456789ABCDEFGHJKMNPQRSTUVW';
   $newpassword = '';
   for ($i = 0; $i < 11; $i++) {
      $newpassword .= $characters[rand(0, strlen($characters) - 1)];
   }

   $options = [
            'cost' => 10,
      ];
   $passwordhash= password_hash($newpassword, PASSWORD_BCRYPT, $options);

   // check db and write

   $strQuery = "UPDATE `leerkrachten` SET `Reset`= '0',`Wachtwoord`='$passwordhash' WHERE `Email` = '$username' AND `ResetKey` = '$resetkey'";
   $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
   mysqli_commit($dbhandle);

   echo "<div class='container'><div class='well'><p>Uw wachtwoord is aangepast. het nieuw wachtwoord is:";
   echo $newpassword;
   echo "</p></div></div>";
   include("includes/php/bottom.php");
   exit;

   wrongdata:
      echo "<div class='container'><div class='well'><p>Foute input</p></div></div>";
	  include("../includes/php/bottom.php");
      exit;
?>