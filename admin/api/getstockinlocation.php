<?php
include('../include/app_config.php');
include('../include/connection.php');
set_time_limit(5000);
$curl = curl_init();

$success = 0;
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
        //Gwarimpa
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Location/18047?page=".$i,
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
        
        //wuse
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Location/18841?page=".$i,
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
        
        $response2 = curl_exec($curl);
        $err = curl_error($curl);
        
        $result2 = json_decode($response);
        
        
        
        if($err){
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }
        
        $success = 0;
        $total_stock = 0;
        $unit = "";
        
        foreach($result as $value)
        {
            if(!empty($value->ProductStockBatches))
            {
                foreach($value->ProductStockBatches as $stock)
                {
                    $total_stock += $stock->CurrentStock;
                    $unit = !empty($stock->MeasurementDetails->StockUnit) ? $stock->MeasurementDetails->StockUnit : "";
                }
            }
            $instock = $total_stock > 0 ? 1 : 0;
            if($unit == 'g')
            {
                $total_stock = $total_stock/1000;
            }
            $sql = "update product set stock=:stock, instock=:ins where api_id=:id";
            $q = $con->update_query($sql,array(':stock'=>$total_stock,':ins'=>$instock,':id'=>$value->ProductId));
            if($q)
            {
                $insert_count++;
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