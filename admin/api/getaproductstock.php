<?php
include('../include/app_config.php');
include('../include/connection.php');
if(isset($_GET['id']) && $_GET['id'] != 0)
{
    $sql = "select api_id from product where api_id=:id";
    $q = $con->select_query($sql,array(':id'=>$_GET['id']));
}
else
{
    $sql = "select api_id from product where status=1";
    $q = $con->select_query($sql);
}
$insert_count = 0;
$success = 0;
$instock = 0;
foreach($q as $r)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.eposnowhq.com/api/v4/ProductStock/Product/".$r['api_id'],
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
    $total_stock = 0;
    $unit = "";
    $location_18047_stock = 0;
    $location_18841_stock = 0;
    
    foreach($result as $value)
    {
        if(!empty($value->ProductStockBatches))
        {
            foreach($value->ProductStockBatches as $stock)
            {
                if($value->LocationId == 18047 || $value->LocationId == 18841)
                {
                    $total_stock += $stock->CurrentStock;
                }
                $unit = !empty($stock->MeasurementDetails->StockUnit) ? $stock->MeasurementDetails->StockUnit : "";
                
                //update stock in locations
                if($value->LocationId == 18047)
                {
                    $location_18047_stock += $stock->CurrentStock;
                }
                else if($value->LocationId == 18841)
                {
                    $location_18841_stock += $stock->CurrentStock;
                }
            }
        }        
    }
    
    $instock = $total_stock > 0 ? 1 : 0;
    if($unit == 'g')
    {
        $total_stock = $total_stock/1000;
        $location_18047_stock = $location_18047_stock/1000;
        $location_18841_stock = $location_18841_stock/1000;
    }
    $sql = "update product set stock=:stock, instock=:ins,location_18047_stock=:loc1,location_18841_stock=:loc2 where api_id=:id";
    $q = $con->update_query($sql,array(':stock'=>$total_stock,':ins'=>$instock,':loc1'=>$location_18047_stock,':loc2'=>$location_18841_stock,':id'=>$r['api_id']));
    if($q)
    {
        $insert_count++;
    }
}
if($insert_count > 0)
{
    $success = 1;
}
echo json_encode(array('success'=>$success,'instock'=>$instock,'total_stock'=>$total_stock));
?>