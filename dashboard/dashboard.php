<?php

//todo: guages: power, internetuse, wireless clients, 
//displays: active workstations, open/closed, who is in space, 
//graphs: power, internetuse, 

// open bestanden
include("../includes/php/top3.php");
include("../includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Space dashboard</h1>
    <ol class="breadcrumb">
      <li class="active">
        <i class="fa fa-dashboard"></i> Space dashboard
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
            <i class="fa fa-lightbulb-o fa-5x"></i>
          </div>
          <div class="col-xs-9 text-right">
            <div class="huge" id="power">NaN
            </div>
            <div>Watt</div>
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
            <div class="huge" id="spacestatus">
              Open
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
            <div class="huge" id="musicplayerstatus">
              <i class="fa fa-play fa-1x"></i>
            </div>
            <div>Scrolling Titel</div>
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
            <i class="fa fa-clock-o fa-5x"></i>
          </div>
          <div class="col-xs-9 text-right">
            <div class="huge" id="clock">
            </div>
            <div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

echo '<div class="row"><div class="col-lg-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bullhorn fa-fw"></i> Mededelingen</h3></div><div class="panel-body">';

$strQuery1 = "SELECT title, text FROM notices ORDER BY idnotices DESC LIMIT 5;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

while ($row = mysqli_fetch_array($result1)) {
    
    echo '<h2>' . $row['title'] . '</h2><div>' . $row['text'] . '</div>';
    
}

echo '</div></div></div>';

echo '<div class="col-lg-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bolt fa-fw"></i> Stroomteller</h3></div><div class="panel-body">';

echo "<iframe src='http://10.90.154.40/#realtime' style='width:100%;height:50vh'></iframe>";

echo '</div></div></div></div>';

?>
<script>
function updateClock ( ) {
	var currentTime = new Date ( );
	var currentHours = currentTime.getHours ( );
	var currentMinutes = currentTime.getMinutes ( );
	var currentSeconds = currentTime.getSeconds ( );

	// Convert an hours component of "0" to "12"
	currentHours = ( currentHours == 0 ) ? 12 : currentHours;

	// Compose the string for display
	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;

	$("#clock").html(currentTimeString);
}

$(document).ready(function() {
	setInterval('updateClock()', 1000);
});
</script>
<?php
include("../includes/php/bottom.php");
?>