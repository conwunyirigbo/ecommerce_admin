<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$sql="select c.*,u.is_active as userstatus,u.firstname,u.lastname,u.email as useremail from customer c inner join users u on c.userid=u.id";

$conditions = array();
$fields=array();


if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "u.is_active=:status";
    $fields[':status']=$_GET['status'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(u.firstname like :searchkey OR u.lastname like :searchkey Or u.email like :searchkey OR c.email like :searchkey OR c.shipping_address like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $fields[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by u.firstname";
$r=$con->select_query($sql,$fields);
$sn=1;
foreach($r as $value)
{
        if($value['userstatus']==1)
        {
            $status="<button class='btn btn-success btn-sm' onclick='changeStatus(\"category\",".$value['id'].",0)' title='click to change'>Active</button>";
        }
        else
        {
            $status="<span class='btn btn-default btn-sm' onclick='changeStatus(\"category\",".$value['id'].",1)' title='click to change'>Inactive</span>";
        }
        $email = $value['useremail'] == "" ? $value['email'] : $value['useremail'];  
        $phone2 = $value['phone2'] != "" ? ", ".$value['phone2'] : "";
        echo '<tr>
                <td style="font-size:12px;">'.$sn.'</td>
                <td>'.$value['firstname'].' '.$value['lastname'].'</td>
                <td>'.$value['shipping_address'].'</td>
                <td>'.$email.'</td>
                <th>'.$value['phone1'].$phone2.'</th>
                <td>'.$value['date_created'].'</td>
                <td>'.$status.'</td>                
                <td><a href="orders?user='.$email.'" class="btn btn-warning btn-sm">Orders</a></td>
             </tr>';
        $sn++;

        if($sn == 500)
        {
            break;
        }
}

?>