<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$customer        = $_GET["customer"];
$street        = $_GET["street"];
$nr        = $_GET["nr"];
$zip        = $_GET["zip"];
$city        = $_GET["city"];

// escape stings

$street        = mysqli_real_escape_string($dbhandle, $street);
$nr        = mysqli_real_escape_string($dbhandle, $nr);
$zip        = mysqli_real_escape_string($dbhandle, $zip);
$city        = mysqli_real_escape_string($dbhandle, $city);
$customer        = mysqli_real_escape_string($dbhandle, $customer);

if ($customer == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}

function lookup($string){
 
   $string = str_replace (" ", "+", urlencode($string));
   $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";
 
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $details_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $response = json_decode(curl_exec($ch), true);
 
   // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
   if ($response['status'] != 'OK') {
    return null;
   }
   
   $geometry = $response['results'][0]['geometry'];
 
    $longitude = $geometry['location']['lng'];
    $latitude = $geometry['location']['lat'];
 
    $array = array(
        'latitude' => $geometry['location']['lat'],
        'longitude' => $geometry['location']['lng'],
        'location_type' => $geometry['location_type'],
    );
 
    return $array;
 
}
 
$adress = $street . ' ' . $nr . ',' . $zip . ' ' . $city;
 
$array = lookup($adress);
$latitude = $array[latitude];
$longitude = $array[longitude];

$strQuery2 = "INSERT INTO `customersites` (`Street`, `Number`, `City`, `ZIP`, `Customer`, `Lat`, `Lng`) VALUES ('" . $street . "', '" . $nr . "', '" . $zip . "', '" . $city . "', '" . $customer . "', '" . $latitude . "', '" . $longitude . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Customer site created</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customersedit.php?customer=' . $customer . '">';

include("../../../includes/php/bottom.php");
?>