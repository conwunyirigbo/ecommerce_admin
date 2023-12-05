<?php
include('../include/connection.php');


$sql = "select id from orders where seenstatus=0";
$q = $con->select_query($sql);
$order_count = count($q);

echo json_encode(array('count'=>$order_count));
?>