<?php
include('../include/connection.php');
$sql = "update product set isonline=:val where id=:id";
$con->update_query($sql,array(':val'=>$_GET['value'],':id'=>$_GET['id']));
?>