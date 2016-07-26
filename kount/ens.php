<?php
$log = "/tmp/ens-errors.log";
error_log(date("Y-m-d H:i:s"), 3, $log);

$xmlData = $HTTP_RAW_POST_DATA;

error_log('start', 3, $log);
error_log($xmlData, 3, $log);
?>