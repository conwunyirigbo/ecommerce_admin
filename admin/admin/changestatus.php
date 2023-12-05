<?php
include('../include/connection.php');
include('../include/app_config.php');
require_once '../lib/app_stat.php';
require_once '../lib/custom.php';

$success = 0;

if(isset($_GET['stock']) && $_GET['stock'] == "stock")
{
    $sql = "update product set instock=:status where id=:id";
    $q = $con->update_query($sql,array(':status'=>$_GET['status'],':id'=>$_GET['id']));
    if($q)
    {
        $success = 1;
    }
}
else 
{
    $sql = "update ".$_GET['table']." set status=:status where id=:id";
    $q = $con->update_query($sql,array(':status'=>$_GET['status'],':id'=>$_GET['id']));
    if($q)
    {
        $success = 1;        
        if($_GET['table'] == "orders")
        {
            //send message to customer
            include('order_message.php');
        }
    }
}
echo json_encode(array('success'=>$success));
?>