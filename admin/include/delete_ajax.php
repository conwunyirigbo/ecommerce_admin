<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
if(isset($_POST['delete']))
{
    switch($_POST['delete'])
    {
        case 'category_list':
            $success = 0;
            $sql = "delete from category where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;                
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'colour_list':
            $success = 0;
            $sql = "delete from colour where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'size_list':
            $success = 0;
            $sql = "delete from size where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'brand_list':
            $success = 0;
            $sql = "delete from brand where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'product_list':
            $success = 0;
            $sql = "select c.id from cart c left outer join orders o on c.cart_session_id=o.cart_session_id where o.status=:pending AND c.productid=:id";
            $q = $con->select_query($sql,array(':pending'=>ORDER_PENDING_DELIVERY, ':id'=>$_POST['id']));
            if(count($q) == 0)
            {
                $sql = "delete from product where id=:id";
                $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
                if($con->num_rows > 0)
                {
                    $success = 1;
                }
            }
            else
            {
                $success = 2; //cant delete
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'delivery_staff_list':
            $success = 0;
            $sql = "delete from delivery_staff where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'delivery_settings':
            $success = 0;
            $sql = "delete from delivery_fee where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'user_list':
            $success = 0;
            $sql = "delete from users where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'slide_list':
            $success = 0;
            $sql = "delete from slider where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'banner_list':
            $success = 0;
            $sql = "delete from banner where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
            
        case 'location_list':
            $success = 0;
            $sql = "delete from location where id=:id";
            $q=$con->delete_query($sql,array(':id'=>$_POST['id']));
            if($con->num_rows > 0)
            {
                $success = 1;
            }
            echo json_encode(array('success'=>$success));
            break;
   
    }
}
?>