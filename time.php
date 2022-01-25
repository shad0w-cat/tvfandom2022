<!DOCTYPE html>
<html>
<body>

<?php
//date_default_timezone_set('Asia/Kolkata');
$dd=strtotime(date("Y/m/d h:m:sa"));
echo $dd. '   ===   ' . date("Y/m/d h:m:sa", $dd) . '<br>';
$d = strtotime('now');
echo $d . '   ===   ' . date("Y/m/d h:m:sa", $d) . '<br>' ;

$days = (int)($d / ( 60 * 60 * 24));
$hours = (int)(($d % ( 60 * 60 * 24)) / (60 * 60));
$minutes = (int)(($d % (60 * 60)) / (60));
$seconds = (int)($d % (60));

echo $days . " " . $hours . " " . $minutes . " " . $seconds . '<br>';

$days = (int)($dd / ( 60 * 60 * 24));
$hours = (int)(($dd % ( 60 * 60 * 24)) / (60 * 60));
$minutes = (int)(($dd % (60 * 60)) / (60));
$seconds = (int)($dd % (60));

echo $days . " " . $hours . " " . $minutes . " " . $seconds;
?>


</body>
</html>
