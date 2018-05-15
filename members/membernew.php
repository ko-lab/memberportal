<?php
include("../includes/php/top.php");
include("../includes/php/mysqli.php");
include("../includes/php/ldap.php");

if (!$Admin == 1 ) {
    
    exit;
    
}

$firstname = $_POST["firstname"];
$lastname  = $_POST["lastname"];
$username  = $_POST["username"];

// escape stings

$firstname = mysqli_real_escape_string($dbhandle, $firstname);
$lastname  = mysqli_real_escape_string($dbhandle, $lastname);
$username  = mysqli_real_escape_string($dbhandle, $username);

if ($firstname == NULL) {
   // echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'members/members.php">';
    exit;
}
if ($lastname  == NULL) {
   // echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'members/members.php">';
    exit;
}
if ($username  == NULL) {
   // echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'members/members.php">';
    exit;
}

if ($bind = ldap_bind($ldaplogin, $userldap, $passldap)) {
    
    $newuser["cn"] = $firstname . " " . $lastname;
    $newuser["description"] = "Text";
    $newuser["displayName"] = $firstname . " " . $lastname;
    $newuser["gecos"] = $firstname . " " . $lastname;
    $newuser["gidNumber"] = "5000";
    $newuser["givenName"] = $firstname;
    $newuser["homeDirectory"] = "/home/" . $username;
    $newuser["initials"] = "II";
    $newuser["loginShell"] = "/bin/bash";
    $newuser["mail"] = $username . "@member.ko-lab.space";
    $newuser["objectClass"][0] = "inetOrgPerson";
    $newuser["objectClass"][1] = "posixAccount";
    $newuser["objectClass"][2] = "shadowAccount";
    $newuser["sn"] = $lastname;
    $newuser["uid"] = $username;
    $newuser["uidNumber"] = "1200";
    $newuser["userPassword"] = "{SSHA}pbramREHfa4cDjiJNPuMlaY2aS3mVUBi";
    
    $userfull = "uid=" . $username . ",ou=members,dc=internal,dc=ko-lab,dc=space";
    
    $result = ldap_add($ldaplogin, $userfull, $newuser);
    
}

echo '<p>User added</p>';

//echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'members/members.php">';

include("../includes/php/bottom.php");
?>