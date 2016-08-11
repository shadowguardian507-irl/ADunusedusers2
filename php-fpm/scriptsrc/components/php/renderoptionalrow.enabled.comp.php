<?php

function renderoptionalrow($message,$enable)
{
  print "<tr>";
  print '<td style="border-right:none;">';
  print "⤷";
  print "</td>";
  print '<td style="border-left:none;" colspan="6" >';
  print $message;
  print "</td>";
  print "</tr>";
}

?>
