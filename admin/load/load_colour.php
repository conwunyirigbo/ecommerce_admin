<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$sql="select * from colour";

$conditions = array();
$fields=array();
if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "status=:status";
    $fields[':status']=$_GET['status'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(code like :searchkey OR name like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $fields[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by name";
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
        
        
        echo '<tr>
                <td style="font-size:12px;">'.$sn.'</td>
                <td><span class="colour-span" style="background-color: '.$value['code'].'"></span></td>
                <td>'.$value['name'].'</td>
                <td>'.$status.'</td>
                <td>'.$value['date_created'].'</td>
                <td><a href="colour_setup?id='.$value['id'].'" class="btn btn-warning btn-sm">Edit</a></td>
                <td><button onclick="Delete('.$value['id'].')" class="btn btn-danger btn-sm">Delete</button></td>
             </tr>';
        $sn++;

}

?>