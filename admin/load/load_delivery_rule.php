<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');

$sql = "select distinct(dc.dsid),s.name AS statename,d.* from delivery_fee d 
    left outer join state s on d.stateid=s.id
    left outer join delivery_cities dc on d.id=dc.dsid
    left outer join city c on dc.cityid=c.id";

$conditions[] = "d.stateid!=0";

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "(statename like :searchkey OR c.name like :searchkey)";
    $keyword = '%'.$_GET['searchkey'].'%';
    $fields[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= ' order by s.name';
$q = $con->select_query($sql);
$sn = 1;
foreach($q as $r)
{
    $sql = "select ds.cityid,c.name as cityname from delivery_cities ds left outer join city c on ds.cityid=c.id where ds.dsid=:id order by c.name";
    $sq = $con->select_query($sql,array(':id'=>$r['id']));
    $cities = "<i>";
    $end = 1;

    if(count($sq) > 0)
    {
        $cities = '<br/><i class="text-warning">';
    }
    foreach($sq as $d)
    {
        $cityname = $d['cityid'] == 0 ? "All Cities" : $d['cityname'];
        if(count($sq) == $end)
            $cities .= $cityname;
        else
            $cities .= $cityname.', ';
        $end++;
    }
    $cities .= '</i>';
    echo '<tr>
                                                                                 <td>'.$sn.'</td>
                                                                                 <td>'.$r['statename'].$cities.'</td>
                                                                                  <td>'.$r['days'].' '.$r['type'].'</td>
                                                                                 <td><span class="badge badge-info">&#8358;'.number_format(round($r['amount'],2)).'</span></td>
                                                                                 <td><button type="button" onclick="Delete('.$r['id'].')" class="btn btn-danger btn-sm">Delete</button></td>
                                                                             </tr>';
    $sn++;
}
?>