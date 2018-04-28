<?php
include("settings.php");
include("mysqli.php");

session_start();
$username  = $_SESSION["username"];
$userid    = $_SESSION["userid"];
$FirstName = $_SESSION["FirstName"];
$LastName  = $_SESSION["LastName"];
$Admin     = $_SESSION["Admin"];

if ($username == Null) {
    echo '<link href="' . $baseurl . 'includes/css/bootstrap.css" rel="stylesheet" type="text/css"><script src="' . $baseurl . 'includes/js/jquery-1.12.4.min.js"></script><script src="' . $baseurl . 'includes/js/bootstrap.min.js"></script>';
    echo "<META http-equiv='refresh' content='0;URL=" . $baseurl . "account/login.php'><div class='container'><div class='well'><p>Login</p></div></div>";
    include("bottom.php");
    exit;
}
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
    <link href="<?php echo $baseurl; ?>includes/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo $baseurl; ?>includes/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo $baseurl; ?>includes/js/bootstrap.min.js"></script>
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
          <ul class="nav navbar-right top-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i> <b class="caret"></b></a>
              <ul class="dropdown-menu alert-dropdown">
                <li>
                  <a href="settings/gebruikers.php">Gebruikers</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="help.php"><i class="fa fa-fw fa-question"></i></a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $FirstName . ' ' .$LastName; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="account/changepassword.php"><i class="fa fa-fw fa-user"></i> Verander wachtwoord</a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="account/logout.php"><i class="fa fa-fw fa-power-off"></i> Afmelden</a>
                </li>
              </ul>
            </li>
          </ul>
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
              <li>
                <a href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
              </li>
              <li>
                <a href="projects/projects.php"><i class="fa fa-fw fa-code-fork"></i> Projecten</a>
              </li>
              <li>
                <a href="reminders/reminders.php"><i class="fa fa-fw fa-sticky-note"></i> Herineringen</a>
              </li>
              <li>
                <a href="members/members.php"><i class="fa fa-fw fa-users"></i> Leden</a>
              </li>
              <li>
                <a href="tools/tools.php"><i class="fa fa-fw fa-wrench"></i> Gereedschap</a>
              </li>
              <li>
                <a href="departments/departments.php"><i class="fa fa-fw fa-fighter-jet"></i> Afdelingen</a>
              </li>
              <li>
                <a href="dashboard/dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard space</a>
              </li>
            </ul>
          </div>
        </nav>
        <div id="page-wrapper">
          <div class="container-fluid">