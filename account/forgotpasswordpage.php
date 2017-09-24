<?php

   // include site layout files

   include("../includes/php/top2.php");
   
   // page
   

   echo '<h2>WACHTWOORD VERGETEN</h2>';
   echo '<form role="form" action="forgotpassword.php" method="get"><div class="form-group"><label for="username">Email:</label>';
   echo '<input type="text" name="username" required class="form-control"></div><button type="submit" class="btn btn-default">Verzend</button></form>';
   
   include("../includes/php/bottom.php");
   
?>