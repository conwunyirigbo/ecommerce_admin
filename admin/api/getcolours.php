<?php
include('../include/app_config.php');
include('../include/connection.php');
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Colour",
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
 
$success = 0;
$sql = "insert into colour (api_id,code,name,status,date_created) values (:id,:code,:name,:status,:date)";
$sqlupdate = "update colour set code=:code,name=:name,status=:status,date_created=:date where api_id=:id";
$insert_count = 0;
foreach($result as $value)
{
    $fields = array(':id'=>$value->Id,':code'=>$value->Name, ':name'=>$value->Name,':status'=>1,':date'=>date('d-m-y H:i A'));

    $sql0 = "select id from colour where api_id=:id";
    $sq = $con->select_query($sql0,array(':id'=>$value->Id));
    if(count($sq) > 0)
    {
        $q = $con->update_query($sqlupdate,$fields);
    }
    else
    {
        $q = $con->insert_query($sql,$fields);
    }
    $insert_count++;
}

if($insert_count > 0)
{
    $success = 1;
}
echo json_encode(array('success'=>$success));
?>