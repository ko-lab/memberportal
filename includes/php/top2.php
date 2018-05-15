<?php
   include("settings.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="<?php echo $baseurl; ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Floris Van der krieken">
    <title>Ko-lab Member portal</title>
    <link href="<?php echo $baseurl; ?>includes/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $baseurl; ?>includes/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo $baseurl; ?>includes/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $baseurl; ?>includes/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="">Ko-lab Member portal</a>
          </div>
	      <ul class="nav navbar-nav navbar-right">
            <li><a href="account/login.php"><span class="glyphicon glyphicon-log-in"></span> Aanmelden</a></li>
          </ul>
        </div>
      </div>
    </nav>
  <div class="container-fluid">