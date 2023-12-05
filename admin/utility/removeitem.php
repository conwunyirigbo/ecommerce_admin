<?php
session_start();
include('../include/connection.php');
$sql = "delete from cart where id=:id";
$q = $con->delete_query($sql,array(':id'=>$_GET['id']));
?>