<?php
include('../include/app_config.php');
include('../include/connection.php');
set_time_limit(5000);
$curl = curl_init();

$end = 1;
$start = !empty($_GET['pagefrom']) ? $_GET['pagefrom'] : 1;
if(!empty($_GET['pageto']))
{
    $end = $_GET['pageto'];
}
else
{
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Product/Stats",
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
    $total_products =  $result->TotalProducts;
    
    $end = $total_products/200;
    
    $end = ceil($end);
}
$insert_count = 0;
if($end >= $start)
{
    for($i=$start; $i<=$end; $i++)
    {
       
    
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Product?page=".$i,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => -1, //Maximum number of redirects
        CURLOPT_TIMEOUT => 260, //Timeout for request
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_HTTPHEADER => array(
        "Authorization: Basic ".EPOS_SECRET_KEY,
        "Content-Type: application/json",
        ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        $result = json_decode($response);
        
        
        
        if($err){
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }
        
        $success = 0;
        
        $sql = "insert into product (api_id,name,brandid,description,addinfo,price,oldprice,status,isonline,instock,date_created)
                            values (:id,:name,:brand,:desc,:add,:price,:oldprice,:status,:online,:stock,:date)";
        
        $sqlupdate = "update product set name=:name,brandid=:brand,description=:desc,addinfo=:add,
                    price=:price,oldprice=:oldprice,status=:status,isonline=:online,instock=:stock,date_created=:date
                    where api_id=:id";
        
        
        $productid = 0;
        foreach($result as $value)
        {
            $fields = array(
                ':id'=>$value->Id,
                ':name'=>$value->Name,
                ':brand'=>$value->BrandId,
                ':desc'=>$value->Description,
                ':add'=>"",
                ':price'=>$value->SalePrice,
                ':oldprice'=>0,
                ':status'=>1,
                ':online'=>1,
                ':stock'=>1,
                ':date'=>date('d-m-Y H:i A')
            );
            
            $sqlp = "select id,isonline,status from product where api_id=:id";
            $sq = $con->select_query($sqlp,array(':id'=>$value->Id));
            if(count($sq) > 0)
            {
                foreach($sq as $s)
                {
                    $productid = $s['id'];
                    $fields[':status'] = $s['status'];
                    $fields[':online'] = $s['isonline'];
                }
                $q = $con->update_query($sqlupdate,$fields);
                
            }
            else
            {
                $q = $con->insert_query($sql,$fields);
                $productid = $con->lastID;
            }
                        if($q)
                        {
                            $insert_count++;
                            
                            //save photos
                            if(!empty($value->ProductImages))
                            {
                                $con->delete_query('delete from product_photos where product_api_id='.$value->Id);
                                foreach($value->ProductImages as $image)
                                {
                                    if(!empty($image))
                                    {
                                        $sql2 = "insert into product_photos (api_id,productid,photo,product_api_id) 
                                            values(:id,:pid,:img,:papi_id)";
                                        $con->insert_query($sql2,array(':id'=>$image->ProductImageId,':pid'=>$productid,':img'=>$image->ImageUrl,':papi_id'=>$value->Id));
                                    }
                                }
                            }
                            
                            //save categories
                            if(!empty($value->CategoryId))
                            {
                                $con->delete_query("delete from product_categories where productid=:id AND categoryid=".$value->CategoryId, array(':id'=>$productid));
                                $sql1 = "insert into product_categories (productid,categoryid) values (:product,:cat)";
                                $q=$con->insert_query($sql1,array(':product'=>$productid, ':cat'=>$value->CategoryId));
                            }
                            //save colors
                            if(!empty($value->ColourId))
                            {
                                $con->delete_query("delete from product_colours where productid=:id AND colourid=".$value->ColourId, array(':id'=>$productid));
                                $sql3 = "insert into product_colours (productid,colourid) values (:product,:colour)";
                                $q=$con->insert_query($sql3,array(':product'=>$productid, ':colour'=>$value->ColourId));
                            }
                        }
        }
    }
}
curl_close($curl);
if($insert_count > 0)
{
    $success = 1;
}
echo json_encode(array('success'=>$success));
?>