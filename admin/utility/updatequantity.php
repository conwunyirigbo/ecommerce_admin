<?php
include('../include/connection.php');
$sql = "update cart set quantity=:quantity where id=:id";
$con->update_query($sql,array(':quantity'=>$_GET['quantity'],':id'=>$_GET['cartid']));
?>