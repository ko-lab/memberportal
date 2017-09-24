<?php

// open bestanden
include("includes/php/top.php");
include("includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Home</h1>
    <ol class="breadcrumb">
      <li class="active">
        <i class="fa fa-home"></i> Home
      </li>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-lg-2 col-md-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3">
            <i class="fa fa-money fa-5x"></i>
          </div>
          <div class="col-xs-9 text-right">
            <div class="huge">
<?php

//$strQuery = "SELECT COUNT(customer) AS COUNT FROM breadorders;";
//$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
//$response = mysqli_fetch_array($result);
//$customerstotal = $response[COUNT];

//echo $customerstotal;

echo 12;

?>
            </div>
            <div>Credit</div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="col-lg-2 col-md-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3">
            <i class="fa fa-home fa-5x"></i>
          </div>
          <div class="col-xs-9 text-right">
            <div class="huge">
<?php

//$strQuery = "SELECT COUNT(customer) AS COUNT FROM breadorders;";
//$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
//$response = mysqli_fetch_array($result);
//$customerstotal = $response[COUNT];

//echo $customerstotal;

echo 'Open';

?>
            </div>
            <div> </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="col-lg-4 col-md-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3">
            <i class="fa fa-music fa-5x"></i>
          </div>
          <div class="col-xs-9 text-right">
            <div class="huge">
<?php

//$strQuery = "SELECT COUNT(idbakeryusers) AS COUNT FROM bakeryusers WHERE bakery = $Bakery;";
//$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
//$response = mysqli_fetch_array($result);
//$userstotal = $response[COUNT];

//echo $userstotal;

echo '<i class="fa fa-play fa-1x"></i>';

?>
            </div>
            <div>Rick Astley - Never Gonna Give You Up</div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="col-lg-2 col-md-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3">
            <i class="fa fa-comments fa-5x"></i>
          </div>
          <div class="col-xs-9 text-right">
            <div class="huge">
<?php

//$strQuery = "SELECT COUNT(idbakeryusers) AS COUNT FROM bakeryusers WHERE bakery = $Bakery;";
//$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
//$response = mysqli_fetch_array($result);
//$userstotal = $response[COUNT];

//echo $userstotal;

echo 5;

?>
            </div>
            <div>Ongelezen berichten</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-2 col-md-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3">
            <i class="fa fa-users fa-5x"></i>
          </div>
          <div class="col-xs-9 text-right">
            <div class="huge">
<?php

//$strQuery = "SELECT COUNT(idbakeryusers) AS COUNT FROM bakeryusers WHERE bakery = $Bakery;";
//$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
//$response = mysqli_fetch_array($result);
//$userstotal = $response[COUNT];

//echo $userstotal;

echo 5;

?>
            </div>
            <div>Taken</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

echo '<div class="row"><div class="col-lg-9"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bullhorn fa-fw"></i> Mededelingen</h3></div><div class="panel-body">';

$strQuery1 = "SELECT title, text FROM notices ORDER BY idnotices DESC LIMIT 5;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

while ($row = mysqli_fetch_array($result1)) {
    
    echo '<h2>' . $row['title'] . '</h2><div>' . $row['text'] . '</div>';
    
}

echo '</div></div></div>';

echo '<div class="col-lg-3"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-sticky-note fa-fw"></i> Herineringen</h3></div><div class="panel-body">';

$strQuery1 = "SELECT title, text FROM reminders WHERE username = '" . $username . "' ORDER BY idreminders DESC LIMIT 5;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

while ($row = mysqli_fetch_array($result1)) {
    
    echo '<h2>' . $row['title'] . '</h2><div>' . $row['text'] . '</div>';
    
}

echo '</div></div></div></div>';

include("includes/php/bottom.php");
?>