<?php

   // include site files
   include("../includes/php/top.php");
   include("../includes/php/mysqli.php");
   
   if ($userid == Null) {
      echo "<META http-equiv='refresh' content='0;URL=/account/login.php'><p>Log in,</p>";
      include("../includes/php/bottom.php");
   }

   // redirect to form onyl

   if (empty($_POST)) {
      goto form;
   }

   $password = @$_POST['password'];
   $newpassword = @$_POST['newpassword'];

   // escape stings

   $password = mysqli_real_escape_string($dbhandle , $password);
   $newpassword = mysqli_real_escape_string($dbhandle , $newpassword);

   if (empty($password)) {
         goto wrongpassword;
   }

   if (empty($newpassword)) {
         goto wrongpassword;
   }
   
   $passwordQuery = "SELECT `password` FROM `bakeryusers` WHERE `idbakeryusers` = '$userid'";
   $response3 = $dbhandle->query($passwordQuery) or exit("Error code ({$dbhandle->errno})");
   $response4 = mysqli_fetch_array($response3);
   $passwordhash = $response4[password];

      if (password_verify($password , $passwordhash)) {
         
         // generate salt and hash

         $options = [
            'cost' => 10,
         ];
         $passwordhashnew= password_hash($newpassword, PASSWORD_BCRYPT, $options);
         
         $passwordUpdateQuery = "UPDATE `bakeryusers` SET `password`='$passwordhashnew' WHERE `idbakeryusers` ='$userid'";
         $response5 = $dbhandle->query($passwordUpdateQuery) or exit("Error code ({$dbhandle->errno})");
         mysqli_commit($dbhandle);
      } else {
          goto wrongpassword;
      }

   echo "<div class='alert alert-success'><strong>Het wachtwoord is veranderd.</strong></div>";
   
   goto form;
   
   wrongpassword:
   
      echo "<div class='alert alert-danger'><strong>Wachtwoord incorect.</strong></div>";
      goto form;
      
   form:

   echo '<h2>VERANDER WACHTWOORD</h2>';
   echo '<form role="form" action="account/changepassword.php" method="post"><div class="form-group"><label for="password">Oud wachtwoord:</label><input type="password" class="form-control" name="password" required></div><div class="form-group"><label for="newpassword">Nieuw wachtwoord:</label><input type="password" class="form-control" name="newpassword" required></div><button type="submit" class="btn btn-default">Verzend</button></form>';
   
   include("../includes/php/bottom.php");
?>