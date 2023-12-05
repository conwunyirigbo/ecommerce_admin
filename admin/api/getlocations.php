<?php
session_start();
include('../include/app_config.php');
set_time_limit(5000);
$curl = curl_init();

curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Location",
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

foreach($result as $row)
{
    echo $row->Id.' '.$row->Name.', '.$row->Town.'<br/> ';
}
?>