<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');

$sql = "update users set is_active=:status where id=:id";
$q = $con->update_query($sql, array(':status'=>$_GET['status'], ':id'=>$_GET['id']));
?>