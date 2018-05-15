<?php

header('Access-Control-Allow-Origin: *');

include("settings.php");
include("mysqli.php");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="<?php echo $baseurl; ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Floris Van der krieken">
    <title>Ko-lab Member portal</title>
    <link href="<?php echo $baseurl; ?>includes/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $baseurl; ?>includes/css/kolab.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $baseurl; ?>includes/css/dashboard.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $baseurl; ?>includes/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo $baseurl; ?>includes/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $baseurl; ?>includes/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseurl; ?>includes/js/dashboard.js"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">Ko-lab Member portal</a>
          </div>
        </nav>
        <div id="page-wrapper">
          <div class="container-fluid">