<?php
include('../include/app_config.php');
include('../include/connection.php');
set_time_limit(5000);
$curl = curl_init();

$end = 1;
$success = 0;
$locations = array(18047, 18841);

$start = !empty($_GET['pagefrom']) ? $_GET['pagefrom'] : 1;
if(!empty($_GET['pageto']))
{
    $end = $_GET['pageto'];
}
else
{
    $end = 250;
}
$insert_count = 0;
if($end >= $start)
{
    for($i=$start; $i<=$end; $i++)
    {
        foreach($locations as $location)
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.eposnowhq.com/api/v4/ProductStock/location/".$location."?page=".$i,
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
            
            if(!empty($result))
            {
                $success = 0;
                $total_stock = 0;
                $unit = "";
                
                foreach($result as $value)
                {
                    $location_18047_stock = 0;
                    $location_18841_stock = 0;
                    $total_stock = 0;
                    if(!empty($value->ProductStockBatches))
                    {
                        foreach($value->ProductStockBatches as $stock)
                        {
                            $total_stock += $stock->CurrentStock;
                            $unit = !empty($stock->MeasurementDetails->StockUnit) ? $stock->MeasurementDetails->StockUnit : "";
                        }
                    }
                    $instock = $total_stock > 0 ? 1 : 0;
                    
                    //update stock in locations
                    if($value->LocationId == 18047)
                    {
                        $location_18047_stock = $total_stock;
                    }
                    else if($value->LocationId == 18841)
                    {
                        $location_18841_stock = $total_stock;
                    }
                    
                    if($unit == 'g')
                    {
                        $total_stock = $total_stock/1000;
                        $location_18047_stock = $location_18047_stock/1000;
                        $location_18841_stock = $location_18841_stock/1000;
                    }
                    
                    
                    if($i > 0)
                    {
                        $sql = "update product set stock=stock+:stock, instock=:ins, location_18047_stock=:loc1,location_18841_stock=:loc2 where api_id=:id";
                    }
                    else
                    {
                        $sql = "update product set stock=:stock, instock=:ins,location_18047_stock=:loc1,location_18841_stock=:loc2 where api_id=:id";
                    }
                    
                    $q = $con->update_query($sql,array(':stock'=>$total_stock,':ins'=>$instock,':loc1'=>$location_18047_stock,':loc2'=>$location_18841_stock,':id'=>$value->ProductId));
                    if($q)
                    {
                        $insert_count++;
                    }
                }
            }
            $i++;
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