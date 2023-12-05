<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$sql="select * from slider";

$conditions = array();
$fields=array();
if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "status=:status";
    $fields[':status']=$_GET['status'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(phototitle like :searchkey OR smalltagline like :searchkey OR bigtagline like :searchkey OR buttontext like :searchkey OR url like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $fields[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by slideorder";
$r=$con->select_query($sql,$fields);
$sn=1;
foreach($r as $value)
{
        if($value['status']==1)
        {
            $status="<span class='label label-success'>Active</span>";
        }
        else
        {
            $status="<span class='label label-secondary'>Inactive</span>";
        }
        $photo = '<div class="slide-photo-wrap"><img src="'.UPLOADS_FOLDER.$value['photo'].'" class="img-responsive"/></div>';
        
        $button = '<span class="label label-white">'.$value['buttontext'].'</span>';
        if($value['showbutton'] == 0)
        {
            $button = "<span class='label label-secondary'>No Button</span>";
        }
        
        $tagline = '<span style="font-size:11px">'.$value['smalltagline'].'</span><br/>'.$value['bigtagline'];
        $tagline = !empty($value['smalltagline']) && !empty($value['bigtagline']) ? $tagline : "";
        echo '<tr>
                <td style="font-brand:12px;">'.$value['slideorder'].'</td>
                <td>'.$photo.'</td>
                <td>'.$value['phototitle'].'</td>
                <td>'.$tagline.'</span></td>
                <td>'.$value['url'].'</td>
                <td>'.$button.'</td>
                <td>'.$status.'</td>
                <td>'.$value['date_created'].'</td>
                <td><a href="slider_setup?id='.$value['id'].'" class="btn btn-warning btn-sm">Edit</a></td>
                <td><button onclick="Delete('.$value['id'].')" class="btn btn-danger btn-sm">Delete</button></td>
             </tr>';
        $sn++;

}

?>