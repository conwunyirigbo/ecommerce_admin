<?php
session_start();
include('../include/connection.php');

$success = 0;
$productname = "";
$sql = "delete from saved_items where userid=:id AND productid=:pid";
$q = $con->delete_query($sql,array(':id'=>$_SESSION['user_id'], ':pid'=>$_GET['productid']));
    
    if($q)
    {
        $success = 1;
        $sql = "select name from product where id=:id";
        $q = $con->select_query($sql,array(':id'=>$_GET['productid']));
        foreach($q as $r)
        {
            $productname = $r['name'];
        }
    }
    echo json_encode(array('success'=>$success, 'productname'=>$productname));

?>