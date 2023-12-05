<?php
include('../include/app_config.php');
include('../include/connection.php');

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Webhook",
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

print_r($response);
?>