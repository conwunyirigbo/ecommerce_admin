<?php
session_start();
include('../include/connection.php');

$success = 0;
$productname = "";
if(!isset($_SESSION['user_session']))
{
    $_SESSION['redirect'] = $_SESSION['url'];
    $success = 3; // not logged in
    echo json_encode(array('success'=>$success, 'productname'=>$productname));
    return;
}
else 
{
    $sql = "delete from saved_items where userid=:id AND productid=:pid";
    $con->delete_query($sql,array(':id'=>$_SESSION['user_id'], ':pid'=>$_GET['productid']));
    
    $sql = "insert into saved_items (userid,productid) values (:id,:pid)";
    $q = $con->insert_query($sql, array(':id'=>$_SESSION['user_id'], ':pid'=>$_GET['productid']));
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
}

?>