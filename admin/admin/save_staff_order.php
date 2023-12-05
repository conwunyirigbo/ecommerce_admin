<?php
include('../include/connection.php');

$sql = "insert into order_delivery_staff (order_id,staff_id) values (:order,:staff)";
$con->insert_query($sql,array(':order'=>$_GET['order_id'], ':staff'=>$_GET['staff_id']));

?>