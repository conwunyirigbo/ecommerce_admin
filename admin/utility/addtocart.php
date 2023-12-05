<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
$success = 0;
$productname = "";

$price = $_POST['price'];
$sql = "select name,price from product where id=:id";
$q = $con->select_query($sql,array(':id'=>$_POST['productid']));
foreach($q as $r)
{
    $productname = $r['name'];
    $price = $r['price'];
}
$total_stock = 0;
$unit = "";

if(!empty($_POST['api_id']))
{
    //check if product is in stock
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.eposnowhq.com/api/v4/ProductStock/Product/".$_POST['api_id'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => -1, //Maximum number of redirects
    CURLOPT_TIMEOUT => 0, //Timeout for request
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_HTTPHEADER => array(
    "Authorization: Basic ".EPOS_SECRET_KEY,
    "Content-Type: application/json",
    ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    $result = json_decode($response);
    
    curl_close($curl);
    
    if($err){
        die('Curl returned error: ' . $err);
    }
    
    
    foreach($result as $value)
    {
        if(!empty($value->ProductStockBatches))
        {
            foreach($value->ProductStockBatches as $stock)
            {
                $total_stock += $stock->CurrentStock;
            }
        }
    }
    
    $instock = $total_stock > 0 ? true : false;
    if($unit == 'g')
    {
        $total_stock = $total_stock/1000;
    }
    
    if($total_stock <= 0)
    {
        $success = 3;
        echo json_encode(array('success'=>$success,'productname'=>$productname));
        return;
    }
}
if(isset($_SESSION['cart_session_id']))
{
    $cart_session = $_SESSION['cart_session_id'];
}
else
{
    $cart_session = rand(1000,99999);
    $maxid = 1;
    $sql = "select Max(id) as maxid from orders";
    $q = $con->select_query($sql);
    foreach ($q as $r)
    {
        $maxid = $r['maxid']+1;
    }
    $_SESSION['cart_session_id'] = $maxid.$cart_session;
}

$size = "";
$colour = "";
if(isset($_POST['colour']))
    $colour = $_POST['colour'];
if(isset($_POST['size']))
    $size = $_POST['size'];


//check variable pricing
$sql = "select price from product_prices where productid=:pid AND colourid=:id";
$q = $con->select_query($sql,array(':pid'=>$_POST['productid'],':id'=>$colour));
if(count($q) > 0)
{
    foreach($q as $p)
    {
        $price = $p['price'];
    }
}

//check if item exist in cart, if so add
$cartid = 0;
$quantity = $_POST['quantity'];

$sql = "select id,quantity from cart where cart_session_id=:cart AND productid=:pid";
$fields = array(':cart'=>$_SESSION['cart_session_id'],':pid'=>$_POST['productid']);
if(!empty($colour))
{
    $sql .= " AND colourid=:colour";
    $fields[':colour'] = $colour;
}
if(!empty($size))
{
    $sql.= " AND sizeid=:size";
    $fields[':size'] = $size;
}
$q = $con->select_query($sql,$fields);
if(count($q) > 0)
{
    foreach ($q as $r)
    {
        $cartid = $r['id'];
        $quantity = $r['quantity'] + $_POST['quantity'];
    }
    
    if($quantity > $total_stock && !empty($_POST['api_id']))
    {
        $success = 4;
        echo json_encode(array('success'=>$success,'productname'=>$productname));
        return;
    }
    $sql = "update cart set quantity=:quantity where id = :id";
    $q = $con->update_query($sql,array(':quantity'=>$quantity,':id'=>$cartid));
    $success = 1;
}
else 
{  
    $note = "";
    if(isset($_POST['note']))
    {
        $note = $_POST['note'];
    }  
    
    if($quantity > $total_stock && !empty($_POST['api_id']))
    {
        $success = 4;
        echo json_encode(array('success'=>$success,'productname'=>$productname));
        return;
    }
    
    $sql = "insert into cart (cart_session_id,productid,quantity,colourid,sizeid,price,note) values
        (:cart,:pid,:quantity,:colour,:size,:price,:note)";
    $fields = array(
        ':cart'=>$_SESSION['cart_session_id'],
        ':pid'=>$_POST['productid'],
        ':quantity'=>$_POST['quantity'],
        ':colour'=>$colour,
        ':size'=>$size,
        ':price'=>$price,
        ':note'=>$note
    );
    $q = $con->insert_query($sql,$fields);
    if($q)
    {
        $success = 1;        
    }
}

echo json_encode(array('success'=>$success,'productname'=>$productname));
?>