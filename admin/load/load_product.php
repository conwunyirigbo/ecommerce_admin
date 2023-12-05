<?php
session_start();
$menuid = "tproduct";
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
include('../lib/dbconfig.php');

$sql = "select distinct(p.id),p.name,p.price,p.oldprice,p.status,p.isonline,p.instock,p.date_created,p.api_id,p.brandid,
    b.name as brandname,p.weight,p.stock from product p
    left outer join brand b on p.brandid=b.id
    left outer join product_sizes ps on p.id=ps.productid
    left outer join product_colours pc on p.id=pc.productid
    left outer join product_categories pca on p.id=pca.productid
    left outer join sub_categories sb on pca.categoryid = sb.subcategoryid
    left outer join sub_categories msb on pca.categoryid = sb.mastercategoryid
    left outer join size s on ps.sizeid=s.id
    left outer join colour c on pc.colourid=c.id";

$conditions = array();
$fields = array();

$pagination = "";

if (isset($_GET['status']) && $_GET['status'] != "") {
    $conditions[] = "p.status=:status";
    $fields[':status'] = $_GET['status'];
}

if (isset($_GET['category']) && $_GET['category'] != "") {
    $conditions[] = "(pca.categoryid=:category OR sb.mastercategoryid=:category OR msb.mastercategoryid=:category)";
    $fields[':category'] = $_GET['category'];
}

if (isset($_GET['size']) && $_GET['size'] != "") {
    $conditions[] = "ps.sizeid=:size";
    $fields[':size'] = $_GET['size'];
}

if (isset($_GET['brand']) && $_GET['brand'] != "") {
    $conditions[] = "p.brandid=:brand";
    $fields[':brand'] = $_GET['brand'];
}

if (isset($_GET['colour']) && $_GET['colour'] != "") {
    $conditions[] = "pc.colourid=:colour";
    $fields[':colour'] = $_GET['colour'];
}

if (isset($_GET['isonline']) && $_GET['isonline'] != "") {
    $conditions[] = "p.isonline=:isonline";
    $fields[':isonline'] = $_GET['isonline'];
}

if (isset($_GET['instock']) && $_GET['instock'] != "") {
    $conditions[] = "p.instock=:instock";
    $fields[':instock'] = $_GET['instock'];
}

if (isset($_GET['searchkey']) && $_GET['searchkey'] != "") {
    $conditions[] = "(p.description like :searchkey OR p.api_id like :searchkey OR p.name like :searchkey OR p.addinfo like :searchkey)";
    $keyword = '%' . $_GET['searchkey'] . '%';
    $fields[':searchkey'] = $keyword;
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$r = $con->select_query($sql, $fields);

$number_of_results = count($r);
$no_results = count($r);
$number_of_pages = ceil($number_of_results / $_GET['no_records']);
$page = $_GET['page'];
$start_from = ($page - 1) * $_GET['no_records'];

if ($_GET['no_records'] > 0) {
    $sql .= " order by id DESC LIMIT " . $start_from . ',' . $_GET['no_records'];
} else {
    $sql .= " order by id DESC";
}

$r = $con->select_query($sql, $fields);
$sn = 1;

$text = "";
foreach ($r as $value) {

    if ($value['status'] == 1) {
        $status = "<button class='btn btn-success btn-xs' onclick='changeStatus(\"product\"," . $value['id'] . ",0)' title='click to change'>Active</button>";
    } else {
        $status = "<button class='btn btn-default btn-xs' onclick='changeStatus(\"product\"," . $value['id'] . ",1)' title='click to change'>Inactive</button>";
    }

    $instock = "<button class='btn btn-info btn-xs' onclick='changeStatus(\"product\"," . $value['id'] . ",0,\"stock\")' title='click to change'>In Stock</button>";
    if ($value['instock'] == 0) {
        $instock = "<button class='btn btn-default btn-xs' onclick='changeStatus(\"product\"," . $value['id'] . ",1,\"stock\")' title='click to change'>Out of Stock</button>";
    }

    $isonline = '<button type="button" onclick="push(0, ' . $value['id'] . ')" class="btn btn-primary btn-xs" title="click to push offline">Online Store</button>';
    if ($value['isonline'] == 0) {
        $isonline = '<button type="button" onclick="push(1, ' . $value['id'] . ')" class="btn btn-default btn-xs" title="click to push online">Offline Store</button>';
    }
    $photos = "";
    $sql = "select photo from product_photos where productid=:id";
    $q = $con->select_query($sql, array(':id' => $value['id']));
    foreach ($q as $r) {
        if (strstr($r['photo'], 'https')) {
            $pic = $r['photo'];
        } else {
            $pic = UPLOADS_FOLDER . $r['photo'];
        }
        $photos .= '<div class="product-photo-wrap"><img src="' . $pic . '" class="img-responsive"/></div>';
    }

    $colours = "";
    $sql = "select c.name,co.name as api_name, co.code as api_code,c.code from product_colours pc left outer join colour c on pc.colourid=c.id left outer join colour co on pc.colourid=co.api_id where pc.productid=:id";
    $q = $con->select_query($sql, array(':id' => $value['id']));
    foreach ($q as $r) {
        $code = !empty($r['code']) ? $r['code'] : $r['api_code'];
        $colours .= '<span class="colour-span" style="background-color: ' . $code . '; float: left; margin-left: 5px; margin-top: 5px;"></span>';
    }

    $sizes = "";
    $end = 1;
    $sql = "select s.name,s.code from product_sizes ps inner join size s on ps.sizeid=s.id where ps.productid=:id";
    $q = $con->select_query($sql, array(':id' => $value['id']));
    foreach ($q as $r) {
        if ($end == count($q))
            $sizes .= $r['name'];
        else
            $sizes .= $r['name'] . ', ';
        $end++;
    }

    $prices = "";
    $end = 1;
    $sql = "select c.name,c.code,ps.price from product_prices ps inner join colour c on ps.colourid=c.id where ps.productid=:id";
    $q = $con->select_query($sql, array(':id' => $value['id']));
    foreach ($q as $r) {
        if ($end == count($q))
            $prices .= '<i>' . $r['name'] . ' - ' . number_format(round($r['price'], 2)) . '</i>';
        else
            $prices .= '<i>' . $r['name'] . ' - ' . number_format(round($r['price'], 2)) . '</i>, ';
        $end++;
    }

    $categories = "";
    $end = 1;
    $sql = "select c.name, cat.name as api_name from product_categories pc left outer join category c on pc.categoryid=c.id left outer join category cat on pc.categoryid=cat.api_id where pc.productid=:id";
    $q = $con->select_query($sql, array(':id' => $value['id']));
    foreach ($q as $r) {
        if ($end == count($q))
            $categories .= !empty($r['name']) ? $r['name'] : $r['api_name'];
        else
            $categories .= !empty($r['name']) ? $r['name'] . ', ' : $r['api_name'] . ', ';
        $end++;
    }

    $oldprice = "";
    if ($value['oldprice'] != 0) {
        $oldprice = " <span class='old-price'>" . number_format(round($value['oldprice'], 2)) . "</span>";
    }

    $weight = $value['weight'] > 0 ? '<br/><strong>Has Weight</strong> - ' . round($value['weight'], 2) . 'Kg' : "";

    $stock = $value['stock'];
    if ($stock == 0) {
        $stock = $value['stock'];
    }

    $text .= '<tr>
                <td style="font-size:12px;">' . $sn . '</td>
                <td>' . $value['name'] . '<br/><strong><span class="text-success">' . $value['brandname'] . '</span></strong><br/><i>' . $categories . '</i>' . $weight . '</td>
                <td>' . $photos . '</td>
                <td>' . $colours . '</td>
                <td>' . $sizes . '</td>
                <td><strong>' . number_format(round($value['price'], 2)) . $oldprice . '</strong><br/>' . $prices . '</td>
                <td>' . $status . '</td>
                <td>' . $isonline . '</td>
                <td><span id="row' . $value['api_id'] . '">' . $instock . '</span><br/><i><strong id="total' . $value['api_id'] . '">' . $stock . ' Available</strong></i></td>
                <td>' . $value['date_created'] . '</td>';

    if ($authupdate) {
        $text .= '<td><a href="product_setup?id=' . $value['id'] . '" class="btn btn-warning btn-sm">Edit</a>';
    } else {
        $text .= '<td>';
    }
    $text .= '</td>';
    if ($authdelete) {
        $text .= '<td><button onclick="Delete(' . $value['id'] . ')" class="btn btn-danger btn-sm">Delete</button></td>';
    }
    $text .= '</tr>';
    $sn++;
}

$prev = $page > 1 ? $page - 1 : $page;
$next = $page + 1;
$pagination = '<ul class="pagination pull-right">
                   <li class="footable-page-arrow"><a data-page="first" href="javascript:;" onclick="loadproducts(0, 1)"><span class="icon-double-angle-left"></span></a></li>
                   <li class="footable-page-arrow"><a data-page="prev" href="javascript:;" onclick="loadproducts(0, ' . $prev . ')"><span class="icon-angle-left"></span></a></li>';
$startcount = $page > 5 ? $page - 5 : 1;
for ($i = $startcount; $i <= $number_of_pages; $i++) {
    $active = "";
    if ($i == $page) {
        $active = "active";
    }
    $pagination .= '<li class="footable-page ' . $active . '" onclick="loadproducts(0, ' . $i . ')"><a data-page="0" href="javascript:;">' . $i . '</a></li>';
    if ($i == ($page + 5)) {
        break;
    }
}


$pagination .= '<li class="footable-page-arrow"><a data-page="next" href="javascript:;" onclick="loadproducts(0, ' . $next . ')"><span class="icon-angle-right"></span></a></li>
      <li class="footable-page-arrow"><a data-page="last" href="javascript:;" onclick="loadproducts(0, ' . $number_of_pages . ')"><span class="icon-double-angle-right"></span></a></li>
  </ul>';

echo json_encode(array('text' => $text, 'no_results' => $no_results, "pagination" => $pagination, 'lastrecord' => $sn, 'page' => $page));
