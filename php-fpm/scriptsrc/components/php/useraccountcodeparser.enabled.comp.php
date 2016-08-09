<?php
/*.
    require_module 'standard';
.*/
?>
<?php
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
