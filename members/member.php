<?php

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Bestellingen</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li class="active">
        <i class="fa fa-cutlery"></i> Bestellingen
      </li>
    </ol>
  </div>
</div>
<?php

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th>Bedrag</th><th>Klant</th><th>Adres</th><th>Bestelde broden</th><th>Leverings datum</th></tr></thead><tbody>";

$strQuery1 = "SELECT breadorders.idbreadorders, breadorders.date, breadorders.totalprice, breadorders.paid, breadorders.creationtime, customers.name, customers.firstname, customers.street, customers.number, customers.zip, customers.city
FROM (customers INNER JOIN breadorders ON customers.idcustomers = breadorders.customer) INNER JOIN breadordersbread ON breadorders.idbreadorders = breadordersbread.breadorder
WHERE breadordersbread.bakery = $Bakery
GROUP BY breadorders.idbreadorders ORDER BY breadorders.date ASC;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    
    echo '<tr><td>' . $row['totalprice'] . '</td><td>' . $row['name'] . ' ' . $row['firstname'] . '</td><td>' . $row['street'] . ' ' . $row['number'] . ' ' . $row['zip'] . ' ' . $row['city'] . '</td><td>';
    
    $strQuery2 = "SELECT bread.name, bread.price FROM breadordersbread INNER JOIN bread ON breadordersbread.bread = bread.idbread WHERE breadordersbread.breadorder = " . $row['idbreadorders'] . ";";
    $result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
    
    while ($row2 = mysqli_fetch_array($result2)) {
        
        echo $row2['name'] . ', ';
        
    }
     
    echo '</td><td>' . $row['date'] . '</td></tr>';
    
}
echo "</tbody></table></div>";

include("../includes/php/bottom.php");
?>