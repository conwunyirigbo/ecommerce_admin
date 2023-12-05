<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$sql="select * from category";

$conditions = array();
$fields=array();


if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "status=:status";
    $fields[':status']=$_GET['status'];
}

if(isset($_GET['type']) && $_GET['type'] !="") {
    $conditions[] = "type=:type";
    $fields[':type']=$_GET['type'];
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(code like :searchkey OR name like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $fields[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " order by categoryorder";
$r=$con->select_query($sql,$fields);
$sn=1;
foreach($r as $value)
{
        if($value['status']==1)
        {
            $status="<button class='btn btn-success btn-xs' onclick='changeStatus(\"category\",".$value['id'].",0)' title='click to change'>Active</button>";
        }
        else
        {
            $status="<span class='btn btn-default btn-xs' onclick='changeStatus(\"category\",".$value['id'].",1)' title='click to change'>Inactive</span>";
        }
        
        $show_home = "";
        if($value['show_home']==1)
        {
            $show_home="<span class='label label-info' style='display:block; margin-bottom: 5px;'>Show on Home</span>";
        }
        
        $show_menu = "";
        if($value['show_menu']==1)
        {
            $show_menu="<span class='label label-primary' style='display:block'>Show on Menu</span>";
        }
        
        $restuarant = "";
        if($value['is_restaurant'] == 1)
        {
            $restuarant .= "<br/><span class='label label-info'>Restaurant Menu</span>";
        }
        
        $subcats = "";        
        $end = 1;
        $sql = "select c.name,c.code from sub_categories sc inner join category c on sc.subcategoryid=c.id where sc.mastercategoryid=:id";
        $q = $con->select_query($sql,array(':id'=>$value['id']));
        foreach ($q as $r)
        {
            if($end == count($q))
                $subcats .= $r['name'];
            else
                $subcats .= $r['name'].', ';
            $end++;
        }
        
        echo '<tr>
                <td style="font-size:12px;">'.$value['categoryorder'].'</td>
                <td>'.$value['code'].$restuarant.'</td>
                <td>'.$value['name'].'<br/><span class="text-warning">'.$subcats.'</span></td>
                <td>'.strtoupper($value['type']).'</td>
                <th>'.$show_home.$show_menu.'</th>
                <td>'.$status.'</td>
                <td>'.$value['date_created'].'</td>
                <td><a href="category_setup?id='.$value['id'].'" class="btn btn-warning btn-sm">Edit</a></td>';
        if($value['is_restaurant'] == 1)
        {
            echo '<td><button class="btn btn-danger btn-sm disabled">Delete</button></td>';
        }
        else
        {
            echo '<td><button onclick="Delete('.$value['id'].')" class="btn btn-danger btn-sm">Delete</button></td>';
        }           
            echo '</tr>';
        $sn++;

}

?>