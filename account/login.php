<?php

// include site files
include("../includes/php/settings.php");
include("../includes/php/mysqli.php");
include("../includes/php/ldap.php");

// get data

if (empty($_POST)) {
    goto formpreload;
}

$username = @$_POST['username'];
$password = @$_POST['password'];

if (empty($username)) {
    goto wrongdata;
}

if (empty($password)) {
    goto wrongdata;
} 

$usernamecn = 'uid=' . $username . ',ou=members,dc=internal,dc=ko-lab,dc=be';

if ($bind = ldap_bind($ldaplogin, $usernamecn, $password)) {
    
	$filter = "(cn=" . $username . ")";
	$attr = array("memberof","givenname","sn","uidNumber");
	
	$result = ldap_search($ldaplogin, $memberouldap, $filter, $attr) or exit("Unable to search LDAP server");
	$entries = ldap_get_entries($ldaplogin, $result);
	$FirstName = $entries[0]['givenname'][0];
    $LastName = $entries[0]['sn'][0];
	$userid = $entries[0]['uidNumber'][0];
	
    // start session
    $Admin     = NULL ;
    
    session_start();
    $_SESSION["username"]  = $username;
    $_SESSION["userid"]    = $userid;
    $_SESSION["FirstName"] = $FirstName;
    $_SESSION["LastName"]  = $LastName;
    $_SESSION["Admin"]     = $Admin;

} else {
    
    goto wrongdata;
    
}

include("../includes/php/top2.php");
echo "<META http-equiv='refresh' content='2;URL=" . $baseurl . "'><p>Welcome back,</p>";
include("../includes/php/bottom.php");

exit;

wrongdata:

// include site layout files
include("../includes/php/top2.php");

echo "<h2>AANMELDEN</h2><div class='alert alert-danger'><strong>Account niet gevonden of niet actief.</strong></div>";

goto form;

formpreload:

include("../includes/php/top2.php");

echo '<h2>AANMELDEN</h2>';

goto form;

form:

echo '<form role="form" action="' . $baseurl . 'account/login.php" method="post"><div class="form-group"><label for="username">Gebruikersnaam:</label><input type="username" name="username" class="form-control" required></div><div class="form-group"><label for="password">Wachtwoord:</label><input type="password" name="password" class="form-control" required></div><button type="submit" class="btn btn-default">Aanmelden</button></form>';

echo "<br><p>wachtwoord vergeten? <a href='account/forgotpasswordpage.php'>Reset wachtwoord</a></p>";

include("../includes/php/bottom.php");

exit;
?>