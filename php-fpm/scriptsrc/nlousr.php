<?php
////////////////////////////////////////////////
//              LGPL notice                   //
////////////////////////////////////////////////
/*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.
    You should have received a copy of the GNU Lesser General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
////////////////////////////////////////////////
//         used libraries/code modules        //
////////////////////////////////////////////////
/*
adLDAP 4.0.4 -- released under GNU LESSER GENERAL PUBLIC LICENSE, Version 2.1 by  http://adldap.sourceforge.net/
etheria config loader (custom embedded build) -- released under GNU LESSER GENERAL PUBLIC LICENSE
*/
////////////////////////////////////////////////
// 	       notes/requirements                 //
////////////////////////////////////////////////
/*
php7 with ldap support must be installed
*/
////////////////////////////////////////////////
//               Version info                 //
////////////////////////////////////////////////
/*
version 1
*/
////////////////////////////////////////////////
//               Developer Info               //
////////////////////////////////////////////////
/*
Name : James
Alias : Shadow AKA ShadowGauardian507-IRL
Contact : shadow@shadowguardian507-irl.tk
Alternate contact : shadow@etheria-software.tk
Note as an Anti-spam Measure I run graylisting on my mail servers, so new senders email will be held for some time before it
arrives in my mail box,
please ensure that the service you are sending from tolerates graylisting on target address (most normal mail systems are
perfectly happy with this)
This software is provided WITHOUT any SUPPORT or WARRANTY but bug reports and feature requests are welcome.
*/
?>
<?php
/*.
    require_module 'standard';
    require_module 'ldap';
.*/
?>
<?php
$debugenable = false;
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>

<?php
function htmldebugprint(string $stringtoprint, bool $printenable)
{
  if($printenable)
  {
    print $stringtoprint;
  }
}

function htmldebugprint_r(array $arraytoprint, bool $printenable)
{
  if($printenable)
  {
    print "<pre>";
    print_r($arraytoprint);
    print "</pre>";
  }
}
function mslogintimestamptodatecellformated($mstimestamp)
{
  $mstimestampsec   = (int)($mstimestamp / 10000000); // divide by 10 000 000 to get seconds
  $unixTimestamp = ($mstimestampsec - 11644473600); // 1.1.1600 -> 1.1.1970 difference in seconds

  if ( (isset($mstimestamp)) && ($mstimestamp != "") && ($mstimestamp != 0) ){
      print "<th>". date('Y-m-d h:i:s A', $unixTimestamp ) ." </th>";
    }
  else
    {
      print "<th> never logged in </th>";
    }
}

function closedcconnections($ADldaplinkarray)
{
  foreach ($ADldaplinkarray as $DClink) {
        $DClink->close();
      }
}

function connecttodcs($dcsarry,$ldapconf)
{
  $bdn = $ldapconf['basedn'];
  $acctsif = $ldapconf['accountsuffix'];
  $lun = $ldapconf['linkaccountname'];
  $lup = $ldapconf['linkaccountpassword'];
  $rpg = $ldapconf['realprimarygroup'];
  $rg = $ldapconf['recursivegroups'];

  $dcid = 0;
  foreach ($dcsarry as $dc) {

    $dclinkarry = array($dc);
    $LdapConOptArry = array('base_dn'=>$bdn, 'domain_controllers'=>$dclinkarry, 'account_suffix'=>$acctsif, 'admin_username'=>$lun, 'admin_password'=>$lup, 'real_primarygroup'=>$rpg, 'recursive_groups'=>$rg );

    $adldapcons[$dcid] = new adLDAP($LdapConOptArry);
    try {
        $adldapcons[$dcid]->connect();
    }
    catch (adLDAPException $e) {
        echo $e; exit();
    }
    $dcid = $dcid + 1;
  }

  return $adldapcons;
}

function dedupeunusedusersfromalldcs($ldaplinks,$ldapconf)
{
  foreach ($ldaplinks as $DCadldap) {
    $sr = ldap_search($DCadldap->getLdapConnection(), $ldapconf['basedn'] , '(&(!(lastlogon=*))(objectClass=user)(!(objectClass=computer)))', array('objectclass', 'distinguishedname', 'samaccountname'));
    $userentries = @ldap_get_entries($DCadldap->getLdapConnection(), $sr);

    foreach ($userentries as $auserobject) {
        if( $auserobject['samaccountname'][0] != '' )
        {
          $usernamesarry[$namearrayid][] = $auserobject['samaccountname'][0];
        }
    }
    $namearrayid = $namearrayid + 1;
  }

  $useroutputarry = array();
  foreach ($usernamesarry as $userarry) {
    $useroutputarry = array_unique(array_merge($useroutputarry,$userarry), SORT_REGULAR);
  }

  return $useroutputarry;


}
function useraccountcontroltotext($useraccountcontrolvalue)
{
  switch ($useraccountcontrolvalue) {
    case 512:
        $useraccountcontrolintp="Enabled";
        break;
    case 514:
        $useraccountcontrolintp="Disabled";
        break;
    case 66048:
        $useraccountcontrolintp="Enabled (".$useraccountcontrolvalue.")";
        break;
    case 66050:
        $useraccountcontrolintp="Disabled (".$useraccountcontrolvalue.")";
        break;
    case 544:
        $useraccountcontrolintp="Change Password";
        break;
    case 262656:
        $useraccountcontrolintp="Requires Smart Card";
        break;
    case 1:
        $useraccountcontrolintp="Locked Disabled";
        break;
    case 8388608:
	      $useraccountcontrolintp="Password Expired";
        break;
    case 66080:
        $useraccountcontrolintp="Enabled - No password expiry - Password not required (".$useraccountcontrolvalue.")";
        break;
    default:
        $useraccountcontrolintp="Unknown (".$useraccountcontrolvalue.")";
  }
  return $useraccountcontrolintp;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <title>AD never logged in accounts</title>
  <meta charset="UTF-8">
  <meta name="description" content="list of users who have never logged in to AD but have accounts">
<?php

foreach (glob("./components/php/*.enabled.comp.php") as $enabledcompname)
{
    include $enabledcompname;
}

if (!checkldapconfigexists())
  {
    echo "ldap config file missing please check that ./config.d/active/ldap.conf.php exists exists template can be found in ./config.d/template/ldap.conf.php";
    die;
  }

if(!checkthemeconfigexists())
  {
    echo "theme config file mising please check that ./config.d/active/theme.conf.php exists template can be found in ./config.d/template/theme.conf.php";
    die;
  }

foreach (glob("./config.d/active/*.conf.php") as $configfilename)
{
    include $configfilename;
}



?>

</head>
<body>
  <h1>AD never logged in accounts</h1>
<?php
require_once(dirname(__FILE__) . '/adLDAP-4.0.4/adLDAP.php');

$bdn = $ldapconf['basedn'];
$acctsif = $ldapconf['accountsuffix'];
$lun = $ldapconf['linkaccountname'];
$lup = $ldapconf['linkaccountpassword'];
$rpg = $ldapconf['realprimarygroup'];
$rg = $ldapconf['recursivegroups'];
$dcs = $ldapconf['dcarray'];

$adldap = connecttodcs($dcs,$ldapconf);

htmldebugprint_r($adldap,$debugenable);

htmldebugprint("<hr>",$debugenable);

$allunusedusersflagedonallDCs = dedupeunusedusersfromalldcs($adldap, $ldapconf);

htmldebugprint_r($allunusedusersflagedonallDCs,$debugenable);


?>
<table style="width:100%">
  <tr>
    <th style="font-weight: bold;">Account Status</th>
    <th style="font-weight: bold;">User Name</th>
    <th style="font-weight: bold;">Display Name</th>
    <th style="font-weight: bold;">When Created (year-month-day time)</th>
    <?php foreach ($dcs as $dc)
    {
      print '<th style="font-weight: bold;">Last Logon (year-month-day time)<br/> from DC '.$dc.'</th>';
    }
    ?>
    <th style="font-weight: bold;">Last Logon Timestamp (year-month-day time)<br/> synced every 15 days between DC's</th>
  </tr>

<?php

htmldebugprint_r($allunusedusersflagedonallDCs,$debugenable);

foreach ($allunusedusersflagedonallDCs as $username)
  {
      $userinfo = $adldap[0]->user()->info($username, array("displayname","lastLogonTimestamp","lastLogon","whenCreated","userAccountControl"));
      print "<tr>";
      print "<th>". useraccountcontroltotext($userinfo[0]["useraccountcontrol"][0]) ."</th>";
      print "<th>". $username ."</th>";
      print "<th>". $userinfo[0]["displayname"][0] ."</th>";
      $wcsrc = $userinfo[0]["whencreated"][0];
      $wcconvd = substr($wcsrc,0,4)."-".substr($wcsrc,4,2)."-".substr($wcsrc,6,2)." ".substr($wcsrc,8,2).":".substr($wcsrc,10,2);
      print "<th>". $wcconvd  ."</th>";
      foreach ($adldap as $DCadldap) {
          $DCuserinfo = $DCadldap->user()->info($username, array("displayname","lastLogonTimestamp","lastLogon","whenCreated"));
          mslogintimestamptodatecellformated($DCuserinfo[0]["lastlogon"][0]);
        }
      mslogintimestamptodatecellformated($userinfo[0]["lastlogontimestamp"][0]);
      print "</tr>";
  }

?>

</table>
</body>
<?php
closedcconnections($adldap);
?>
