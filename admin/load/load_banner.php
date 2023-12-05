<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$sql="select * from banner";

$conditions = array();
$fields=array();
if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "status=:status";
    $fields[':status']=$_GET['status'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(phototitle like :searchkey OR title like :searchkey OR buttontext like :searchkey OR url like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $fields[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by bannerorder";
$r=$con->select_query($sql,$fields);
$sn=1;
foreach($r as $value)
{
        if($value['status']==1)
        {
            $status="<button class='btn btn-success btn-xs' onclick='changeStatus(\"banner\",".$value['id'].",0)' title='click to change'>Active</button>";
        }
        else
        {
            $status="<span class='btn btn-default btn-xs' onclick='changeStatus(\"banner\",".$value['id'].",1)' title='click to change'>Inactive</span>";
        }
        $photo = '<img src="'.UPLOADS_FOLDER.$value['photo'].'" style="max-width:50px;"/>';
        
        $button = '<span class="label label-white">'.$value['buttontext'].'</span>';
        if($value['showbutton'] == 0)
        {
            $button = "<span class='label label-secondary'>No Button</span>";
        }
        
        echo '<tr>
                <td style="font-brand:12px;">'.$value['bannerorder'].'</td>
                <td>'.$photo.'</td>
                <td>'.$value['position'].'/'.$value['size'].'</td>
                <td>'.$value['title'].'</span></td>
                <td>'.$value['url'].'</td>
                <td>'.$button.'</td>
                <td>'.$status.'</td>
                <td>'.$value['date_created'].'</td>
                <td><a href="banner_setup?id='.$value['id'].'" class="btn btn-warning btn-sm">Edit</a></td>
                <td><button onclick="Delete('.$value['id'].')" class="btn btn-danger btn-sm">Delete</button></td>
             </tr>';
        $sn++;

}

?>