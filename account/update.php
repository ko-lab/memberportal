<?php

   // include site files
   include("../includes/php/top.php");
   include("../includes/php/mysqli.php");
   
   if ($userid == Null) {
      echo "<META http-equiv='refresh' content='0;URL=/account/login.php'><div class='container'><div class='well'><p>Log in first,</p></div></div>";
	  include("../includes/php/bottom.php");
	  exit;
   }
   
   //connect to mysql

   $dbhandle = new mysqli($hostdb, $userdb, $passdb, $namedb);
   if ($dbhandle->connect_error) {
   exit("There was an error with your connection: ".$dbhandle->connect_error);
   }

   $dbhandle->set_charset('utf8mb4');
   
   // page setup
   
   echo "<div class='container'><div class='well'><h1>Account info</h1>";

   // if post is empty load form else update db

   if (empty($_POST)) {
      
      goto form;
	  
   }

   $username = @$_POST['username'];
   $email = @$_POST['email'];
   $firstname = @$_POST['firstname'];
   $lastname = @$_POST['lastname'];
   $newsletter = @$_POST['newsletter'];
   $nma = @$_POST['nma'];

   // escape stings

   $username = mysqli_real_escape_string($mysqlilink , $username );
   $email = mysqli_real_escape_string($mysqlilink , $email );
   $firstname = mysqli_real_escape_string($mysqlilink , $firstname );
   $lastname = mysqli_real_escape_string($mysqlilink , $lastname );
   $newsletter = mysqli_real_escape_string($mysqlilink , $newsletter );
   $nma = mysqli_real_escape_string($mysqlilink , $nma );

   // Validate data 
	  
   if (!preg_match("/^[a-zA-Z\s'-]+$/", $username)) {
      goto invalidusername;
   }
	  
   function valid_email($email) {
      return !!filter_var($email, FILTER_VALIDATE_EMAIL);
   }
	  
   if(! valid_email($email) ) {
      goto invalidemail;
   }
   
   if (!preg_match("/^[\p{L} \.\-]+$/u", $firstname)) {
       goto invalidfirstname;
   }
   
   if (!preg_match("/^[\p{L} \.\-]+$/u", $lastname)) {
       goto invalidlastname;
   }
   

   $UpdateQuery = "UPDATE `Skaters` SET `Username`='$username',`Email`='$email',`Firstname`='$firstname',`Lastname`='$lastname',`Newsletter`='$newsletter',`NMA`='$nma' WHERE `idSkaters` ='$userid'";
   $response = $dbhandle->query($UpdateQuery) or exit("Error code ({$dbhandle->errno})");
   mysqli_commit($dbhandle);

   echo "<div class='alert alert-success'><strong>account updated.</strong></div>";

   goto form;
   
   invalidemail:
   
      // include site layout files

      echo "<div class='alert alert-danger'><strong>Invalid Email address.</strong></div>";
      goto form;

   invalidfirstname:
   
      // include site layout files

      echo "<div class='alert alert-danger'><strong>Invalid First name.</strong></div>";
      goto form;
	  
   invalidlastname:
   
      // include site layout files

      echo "<div class='alert alert-danger'><strong>Invalid Last name.</strong></div>";
      goto form;

   invalidusername:
   
      // include site layout files

      echo "<div class='alert alert-danger'><strong>Invalid Username.</strong></div>";
      goto form;
	  
   form:
   
	  $strQuery = "SELECT Email, Username, Newsletter, Firstname, Lastname, NMA FROM Skaters WHERE idSkaters = '$userid' ";
      $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");   
      $response = mysqli_fetch_array($result);

      $username = $response[Username];
      $firstname = $response[Firstname];
      $lastname = $response[Lastname];
      $email = $response[Email];
      $newsletter = $response[newsletter];
      $nma = $response[nma];
	  
	  // page
      

      echo "<form role='form' action='update.php' method='post'><div class='form-group'><label for='email'>Email address:</label><input type='email' name='email' value='$email' class='form-control' required></div><div class='form-group'><label for='username'>Username:</label><input type='text' name='username' value='$username' class='form-control'></div><div class='form-group'><label for='firstname'>First name:</label><input type='text' name='firstname' value='$firstname' class='form-control'></div><div class='form-group'><label for='lastname'>Last name:</label><input type='text' name='lastname' value='$lastname' required class='form-control'></div><div class='form-group'><label for='nma'>Notify My Android:</label><input type='text' name='nma' value='$nma' class='form-control'></div><div class='form-group'><label for='newsletter'>Newsletter:</label></div><div class='radio'><label><input type='radio' name='newsletter' value='1' checked>Yes</label></div><div class='radio'><label><input type='radio' name='newsletter' value='0'>No</label></div><button type='submit' class='btn btn-default'>Submit</button></form>";
      echo "</br><a href='/account/changepassword.php'>Change password</a></p></div>";
   
      include("../includes/php/bottom.php");
   
      exit;
?>