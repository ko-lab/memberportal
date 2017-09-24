<?php

   session_start();
   // remove all session variables
   session_unset(); 
   // destroy the session 
   session_destroy(); 

   // include site files
   include("../includes/php/top2.php");

   echo "<META http-equiv='refresh' content='2;URL=" . $baseurl . "'><p>Je bent afgemeld.</p>";
   
   include("../includes/php/bottom.php");

?>