<?php
session_start();
include('../include/app_config.php');
$unreadno = 0;
include('../include/connection.php');
$sql = "select id from orders where seenstatus=0 AND status=:pending";
$q = $con->select_query($sql,array(':pending'=>ORDER_PENDING_DELIVERY));
$unreadno = count($q);
$unreadno = $unreadno == 0 ? "" : $unreadno;
echo $unreadno;
?>