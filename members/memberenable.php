<?php
include("../includes/php/top.php");
include("../includes/php/mysqli.php");
include("../includes/php/ldap.php");

if (!$Admin == 1 ) {
    
    exit;
    
}

$uid = $_GET["uid"];

// escape stings

$uid = mysqli_real_escape_string($dbhandle, $uid);

if ($uid == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'members/members.php">';
    exit;
}

if ($bind = ldap_bind($ldaplogin, $userldap, $passldap)) {
    
    $userold = "uid=" . $uid . ",ou=oldmembers,dc=internal,dc=ko-lab,dc=space";
    $usernew = "uid=" . $uid . "";
    $ounew   = "ou=members,dc=internal,dc=ko-lab,dc=space";
    
    $result  = ldap_rename($ldaplogin, $userold, $usernew, $ounew, true);
    
}

echo '<p>User disabled</p>';

echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'members/members.php">';

include("../includes/php/bottom.php");
?>