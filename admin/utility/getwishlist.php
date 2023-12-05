<?php
session_start();
include('../include/connection.php');

$no_saved = 0;
if(isset($_SESSION['user_id']))
{
    $sql = "select id from saved_items where userid=:id";
    $q = $con->select_query($sql,array(':id'=>$_SESSION['user_id']));
    $no_saved = count($q);
}
echo json_encode(array('no_saved'=>$no_saved));
?>