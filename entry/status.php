<?php

// include files

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

// get variables

$customer = $_GET["customer"];
$site     = $_GET["site"];

// escape stings

$customer = mysqli_real_escape_string($dbhandle, $customer);
$site = mysqli_real_escape_string($dbhandle, $site);

$strQuery = "SELECT SettingValue FROM settings WHERE idSettings = 1;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$mapsenable = $response[SettingValue];

$strQuery = "SELECT Street, Number, ZIP, City, Lat, Lng, NagiosRemoteIp, Nagios FROM customersites WHERE idCustomerSites = $site;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$Street = $response[Street];
$Number = $response[Number];
$ZIP = $response[ZIP];
$City = $response[City];
$Lat = $response[Lat];
$Lng = $response[Lng];
$NagiosRemoteIp = $response[NagiosRemoteIp];
$Nagios = $response[Nagios];

$strQuery = "SELECT CustomerName FROM customers WHERE idCustomers = $customer;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$CustomerName = $response[CustomerName];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $CustomerName; ?> <small><?php echo $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City; ?></small></h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li>
        <i class="fa fa-user"></i> <?php echo $CustomerName; ?>
      </li>
      <li class="active">
        <i class="fa fa-map-marker"></i> <?php echo $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City; ?>
      </li>
    </ol>
  </div>
</div>
<?php

// show selection stuff

if (!$customer == NULL) {
    if (!$site == NULL) {
        
		
		$context = stream_context_create(array ('http' => array ('header' => 'Authorization: Basic ' . base64_encode("nagiosadmin:nagios"))));
        $json = file_get_contents('http://192.168.10.103/nagios/cgi-bin/statusjson.cgi?query=hostcount', false, $context);
        $obj = json_decode($json);
		
		$NagiosHostup       = $obj->data->count->up;
		$NagiosHostdown  = $obj->data->count->down;
		$NagiosHostunreachable = $obj->data->count->unreachable;
		
		$NagiosHostTotal = $NagiosHostup + $NagiosHostdown + $NagiosHostunreachable;
		$NagiosHostupperc = $NagiosHostup / $NagiosHostTotal * 100;
		$NagiosHostdownperc = $NagiosHostdown / $NagiosHostTotal * 100;
		$NagiosHostunreachableperc = $NagiosHostunreachable / $NagiosHostTotal * 100;
		
		echo '';
		
		echo '<div class="progress"><div class="progress-bar progress-bar-success" style="width: ' . $NagiosHostupperc . '%"><span class="sr-only">' . $NagiosHostupperc . '% Complete (success)</span>Up</div>
<div class="progress-bar progress-bar-warning" style="width: ' . $NagiosHostunreachableperc . '%"><span class="sr-only">' . $NagiosHostunreachableperc . '% Complete (warning)</span>Warning</div>
<div class="progress-bar progress-bar-danger" style="width: ' . $NagiosHostdownperc . '%"><span class="sr-only">' . $NagiosHostdownperc . '% Complete (danger)</span>Down</div></div>';
		
    }
}
include("../includes/php/bottom.php");
?>