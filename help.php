<?php

$help=1;

// open bestanden
include("includes/php/top.php");
include("includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Help</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li class="active">
        <i class="fa fa-question"></i> Help
      </li>
    </ol>
  </div>
</div>
<div class="row">
  <div class="col-sm-2">
<ul class="nav nav-pills nav-stacked">
  <li class="active"><a data-toggle="pill" href="#about">About</a></li>
  <li><a data-toggle="pill" href="#licence">Licence</a></li>
  <li><a data-toggle="pill" href="#supportedbrowsers">Supported browsers</a></li>
</ul>
</div>
<div class="col-sm-10">
  <div class="tab-content">
    <div id="about" class="tab-pane fade in active">
      <h3>About</h3>
      <p>Ledenprotaal geschreven voor ko-lab maar open voor anderen om te gebruiken.</p>
    </div>
    <div id="licence" class="tab-pane fade">
      <h3>licence</h3>
      <p>Zie github pagina.</p>
    </div>
    <div id="supportedbrowsers" class="tab-pane fade">
      <h3>Supported browsers</h3>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Browser</th><th>Windows</th><th>Mac</th><th>GNU/Linux</th><th>Android 4.0 or higher</th><th>iOS 8.3 or higher</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Chrome</td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td></td>
            </tr>
            <tr>
              <td>Edge</td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>Firefox</td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td></td><td></td>
            </tr>
            <tr>
              <td>IE 11</td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>IE 10</td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>IE 9</td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>IE 8</td><td><span class="glyphicon glyphicon-remove" style="color:red"></span></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>IE 7</td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>IE 6</td><td><span class="glyphicon glyphicon-remove" style="color:red"></span></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
              <td>Safari</td><td></td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td><td></td><td></td><td><span class="glyphicon glyphicon-ok" style="color:green"></span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

<?php

echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

// geef footer weer

include("includes/php/bottom.php");
?>