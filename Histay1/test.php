<?php
$check_in = "2021-09-26";
$check_out = "2021-09-28";

$diff_days = round((strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24));
for($d=0;$d<$diff_days;$d++)
{
    echo "<br>";
    echo date('Y-m-d', strtotime($check_in. " + $d days"));
}
?>