<?php
/*.
    require_module 'standard';
.*/
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
?>
