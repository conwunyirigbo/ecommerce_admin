<?php
include('../include/app_config.php');
include('../include/connection.php');
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.eposnowhq.com/api/v4/Category",
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
$sql = "insert into category (id,api_id,code,name,status,type,show_home,show_menu,categoryorder,date_created) values (:id,:aid,:code,:name,:status,:type,:show,:show_menu,:order,:date)";
$sqlupdate = "update category set id=:id,code=:code,name=:name,status=:status,type=:type,
    show_home=:show,show_menu=:show_menu,categoryorder=:order,date_created=:date where api_id=:aid";
$insert_count = 0;
foreach($result as $value)
{
    $show_home = 0;
    $type = TOP_MENU_CATEGORY;
    $order = $value->SortPosition != null ? $value->SortPosition : 0;
    $fields = array(':id'=>$value->Id,':aid'=>$value->Id,':code'=>$value->Name, ':name'=>$value->Name, ':status'=>1,':type'=>$type,':show'=>0,':show_menu'=>1,':order'=>$order,':date'=>date('d-m-Y H:i A'));
    
    $sql0 = "select id,show_home,type from category where api_id=:id";
    $sq = $con->select_query($sql0,array(':id'=>$value->Id));
    if(count($sq) > 0)
    {        
        foreach($sq as $s)
        {
            $show_home = $s['show_home'];
            $type = $s['type'];
        }
        $fields[':show'] = $show_home;
        $fields[':type'] = $type;
        $q = $con->update_query($sqlupdate,$fields);
    }
    else
    {
        $q = $con->insert_query($sql,$fields);
    }
    
    if($q)
    {
        if(isset($value->Children) && !empty($value->Children))
        {
            $con->delete_query("delete from sub_categories where mastercategoryid=:id", array(':id'=>$value->Id));
            foreach ($value->Children as $child)
            {
                //insert sub categories
                $type = MASTER_CATEGORY;
                
                $code = strip_tags(strtolower($child->Name));
                $code = str_replace(' ', '-', $code);
                $code = str_replace(',', '', $code);
                $code = str_replace('\'', '', $code);
                $code = str_replace('&', '', $code);
                $code = str_replace('(', '', $code);
                $code = str_replace(')', '', $code);
                $code = str_replace('.', '', $code);
                $code = str_replace('/', '-', $code);
                $code = str_replace('+', '', $code);
                $code = str_replace('*', '', $code);
                $code = str_replace('#', '', $code);
                $code = str_replace(':', '', $code);
                $code = str_replace(';', '', $code);
                $code = iconv('UTF-8', 'UTF-8//IGNORE', $code);
                if(strlen($code) > 100)
                {
                    $code = substr($code, 0, 99);
                }
                
                $order = $child->SortPosition != null ? $child->SortPosition : 0;
                $fields = array(
                    ':id'=>$child->Id,
                    ':aid'=>$child->Id,
                    ':code'=>$code,
                    ':name'=>$child->Name,
                    ':status'=>1,
                    ':type'=>$type,
                    ':show'=>$show_home,
                    ':show_menu'=>1,
                    ':order'=>$order,
                    ':date'=>date('d-m-Y H:i A')
                );
                
                $sql0 = "select id,show_home,type from category where api_id=:id";
                $sq = $con->select_query($sql0,array(':id'=>$child->Id));
                if(count($sq) > 0)
                {            
                    foreach($sq as $s)
                    {
                        $show_home = $s['show_home'];
                        $type = $s['type'];
                    }
                    $fields[':show'] = $show_home;
                    $fields[':type'] = $type;
                    $con->update_query($sqlupdate,$fields);
                }
                else
                {
                    $con->insert_query($sql,$fields);
                }
                
                $sqlsub = "insert into sub_categories (mastercategoryid,subcategoryid) values (:master,:sub)";
                $con->insert_query($sqlsub,array(':master'=>$child->ParentId, ':sub'=>$child->Id));
            }
        }
        $insert_count++;
    }
}

if($insert_count > 0)
{
    $success = 1;
}
echo json_encode(array('success'=>$success));
?>