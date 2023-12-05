<?php
session_start();
$menuid = "torder";
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
include('../lib/dbconfig.php');



//pagination
$pagination = "";
$filter = array();
$sql = "select distinct(ca.cart_session_id),o.*,u.firstname,u.lastname,u.email as useremail,c.shipping_address,ci.name as cityname,s.name as statename,c.phone1,c.phone2,c.email from orders o 
    left outer join users u on o.userid=u.id 
    left outer join customer c on o.userid=c.userid
    left outer join city ci on c.cityid=ci.id
    left outer join state s on c.stateid=s.id
    left outer join cart ca on o.cart_session_id=ca.cart_session_id
    left outer join product_categories pc on ca.productid=pc.productid
    left outer join product p on ca.productid=p.id
    left outer join  order_delivery_staff os on o.id=os.order_id";

$text = "";

$conditions = array();
$fields=array();

if(isset($_GET['status']) && $_GET['status'] !="") {
    $conditions[] = "o.status=:status";
    $fields[':status']=$_GET['status'];
    $filter[] = GetOrderStatus($_GET['status']);
}
else
{
    $conditions[] = "o.status != :not";
    $fields[':not']=ORDER_NOT_COMPLETED;
}

if(isset($_GET['category']) && $_GET['category'] !="") {
    $conditions[] = "(pc.categoryid=:category)";
    $fields[':category']=$_GET['category'];
    $filter[] = GetCategoryName($_GET['category'], $con);
}

if(isset($_GET['staff']) && $_GET['staff'] !="") {
    $conditions[] = "(os.staff_id=:staff)";
    $fields[':staff']=$_GET['staff'];
    $filter[] = GetStaffName($_GET['staff'], $con);
}

if(isset($_GET['state']) && $_GET['state'] !="") {
    $conditions[] = "c.stateid=:state";
    $fields[':state']=$_GET['state'];
    $filter[] = GetStateName($_GET['state'], $con);
}

if(isset($_GET['city']) && $_GET['city'] !="") {
    $conditions[] = "c.cityid=:city";
    $fields[':city']=$_GET['city'];
    $filter[] = GetCityName($_GET['city'], $con);
}

if(isset($_GET['brand']) && $_GET['brand'] !="") {
    $conditions[] = "p.brandid=:brand";
    $fields[':brand']=$_GET['brand'];
    $filter[] = GetBrandName($_GET['brand'], $con);
}

if(isset($_GET['searchkey']) && $_GET['searchkey'] !="") {
    $conditions[] = "u.firstname like :searchkey OR u.lastname like :searchkey Or u.email like :searchkey OR c.email like :searchkey OR p.name like :searchkey Or c.shipping_address like :searchkey OR o.cart_session_id like :searchkey";
    $keyword = '%'.$_GET['searchkey'].'%';
    $fields[':searchkey'] = $keyword;
    $filter[] = $_GET['searchkey'];
}

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$r=$con->select_query($sql,$fields);
$sn=1;

$number_of_results = count($r);

$number_of_pages = $_GET['no_records'] > 0 ? ceil($number_of_results/$_GET['no_records']) : 0;
$page = $_GET['page'];
$start_from = ($page - 1) * $_GET['no_records'];

if($_GET['no_records'] > 0)
{
    $sql .= " order by o.seenstatus ASC,o.id DESC LIMIT ".$start_from.','.$_GET['no_records'];
}
else 
{
    $sql .= " order by o.seenstatus ASC,o.id DESC";
}
$r=$con->select_query($sql,$fields);
$sn=1;

foreach($r as $value)
{
    $row_exist = true;
    $date_created = date('d-m-Y', strtotime($value['orderdate']));
    if(!empty($_GET['startdate']))
    {
        if(strtotime($date_created) <= strtotime($_GET['startdate']))
        {
            $row_exist = false;
        }
    }
    if(!empty($_GET['enddate']))
    {
        if(strtotime($date_created) > strtotime($_GET['enddate']))
        {
            $row_exist = false;
        }
    }
    
    if($row_exist)
    {    

        //get products from cart
        $total = 0;
        $grandtotal = 0;
        $sql = "select distinct(c.productid),p.name,c.*,co.name as colourname,s.name as sizename,b.name as brandname from cart c 
            left outer join product p on c.productid = p.id
            left outer join size s on c.sizeid=s.id
            left outer join colour co on c.colourid=co.id
            left outer join brand b on p.brandid=b.id
            where c.cart_session_id=:id";
        $q = $con->select_query($sql,array(':id'=>$value['cart_session_id']));
        $products = "<ul class='table-list'>";
        foreach($q as $r)
        {
            $note = !empty($r['note']) ? '<br/><strong>Customer Note: </strong>'.$r['note'] : "";
            $ssize = !empty($r['sizename']) ? ', '.$r['sizename'] : "";
            $ccolour = !empty($r['colourname']) ? ', '.$r['colourname'] : "";
            $brand = !empty($r['brandname']) ? ' ('.$r['brandname'].')' : "";
            $products .= '<li><span>'.$r['name'].$brand.'</span><br/><i>'.$r['quantity'].' x &#8358;'.number_format(round($r['price'],2)).$ssize.$ccolour.$note.'</i></li>';
            $total += $r['quantity'] * $r['price'];
        }
        $grandtotal = $total + $value['delivery_fee'];
        $products .="</ul>";
        
       
         
        
        
    $status= "";
            if($value['status'] == ORDER_PENDING_DELIVERY)
            {
                $status = '<button class="btn btn-warning btn-xs" title="Click to change" onclick="setId('.$value['id'].',\''.$value['cart_session_id'].'\')"  data-toggle="modal" href="#statusmodal">Pending Delivery</button>';
            }
            else if($value['status'] == ORDER_NOT_COMPLETED)
            {
                $status = '<span class="label label-default">Not Completed</button>';
            }
            else if($value['status'] == ORDER_SHIPPED)
            {
                $status = '<button class="btn btn-info btn-xs" title="Click to change" onclick="setId('.$value['id'].',\''.$value['cart_session_id'].'\')"  data-toggle="modal" href="#statusmodal">In Transit (Left Depot)</button>';
            }
            else if($value['status'] == ORDER_DELIVERED)
            {
                $status = '<button class="btn btn-success btn-xs" title="Click to change" onclick="setId('.$value['id'].',\''.$value['cart_session_id'].'\')"  data-toggle="modal" href="#statusmodal">Delivered</button>';
            }
            else if($value['status'] == ORDER_CANCELLED)
            {
                $status = '<button class="btn btn-danger btn-xs" title="Click to change" onclick="setId('.$value['id'].',\''.$value['cart_session_id'].'\')"  data-toggle="modal" href="#statusmodal">Cancelled</button>';
            }
            else if($value['status'] == ORDER_PROCESSING)
            {
                $status = '<button class="btn btn-secondary btn-xs" title="Click to change" onclick="setId('.$value['id'].',\''.$value['cart_session_id'].'\')"  data-toggle="modal" href="#statusmodal">Processing Order</button>';
            }
            else if($value['status'] == ORDER_READY_TO_SHIP)
            {
                $status = '<button class="btn btn-info-dark btn-xs" title="Click to change" onclick="setId('.$value['id'].',\''.$value['cart_session_id'].'\')"  data-toggle="modal" href="#statusmodal">Ready to Ship</button>';
            }
            
            $new = "";
            if($value['seenstatus'] == 0)
            {
                $new = '<span class="label label-success label-custom">New</span><br/>';
            }
            
            if($auth->HasAuth("torder") || $super_authorize)
            {
                $delivery_staff = '<br/><select class="form-control smaller" style="width:100%" id="staff" onchange="saveStaffDelivery('.$value['id'].',this.value)">';
                $delivery_staff .= '<option>--select staff--</option>';
                $sql = "select id,name from delivery_staff where status=1 order by name";
                $q = $con->select_query($sql);
                
                foreach($q as $r)
                {
                    $sql = "select id from order_delivery_staff where staff_id=:id AND order_id=:order";
                    $d = $con->select_query($sql,array(':id'=>$r['id'],':order'=>$value['id']));
                    $selected = "";
                    if(count($d) > 0)
                    {
                        $selected = "selected";
                    }
                    $delivery_staff .= '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';  
                }
                $delivery_staff .= '</select>';
            }
            else 
            {
                $staff_name = "";
                $sql = "select o.id,d.name from order_delivery_staff o left outer join delivery_staff d on o.staff_id=d.id where order_id=:order";
                $d = $con->select_query($sql,array(':order'=>$value['id']));
                $selected = "";
                foreach($d as $s)
                {
                    $staff_name = $s['name'];
                }
                $delivery_staff = '<br/><input type="text" class="form-control smaller" value="'.$staff_name.'" readonly/>';
            }
            
            if($value['type'] == PICKUP_TYPE)
            {
                $shipping = "<strong>Pickup Order</strong><br/><i><strong>Pickup Location: </strong>".$value['pickup_location']."</i>";
            }
            else 
            {
                $shipping = $value['shipping_address'].' <strong>'.$value['cityname'].' '.$value['statename'];
            }
        
        $text .= '<tr>
                                                                <td style="font-size:12px;">'.$sn.'</td>
                                                                <td>'.$new.'<br/><strong>#'.$value['cart_session_id'].'</strong></td>
                                                                <td><strong>'.$value['firstname'].' '.$value['lastname'].'</strong><br/><i>'.$value['phone1'].' '.$value['phone2'].'<br/>'.$value['email'].'</i></td>
                                                                <td>'.$shipping.'</strong>'.'</td>
                                                                <td>'.$products.'</td>
                                                                <td>&#8358;'.number_format(round($total,2)).'<br/><i>Plus Shipping Fee: &#8358;'.number_format(round($value['delivery_fee'],2)).'</i> <br/><strong>Total = &#8358;'.number_format(round($grandtotal,2)).'</strong></td>
                                                                
                                                                <td>'.$status.$delivery_staff.'</td>
                                                                <td>'.$value['orderdate'].'</td>
                                                                <td>'.$value['transactionref'].'</td>
                                                            </tr>';
        $sn++;
    }
}

$prev = $page > 1 ? $page - 1 : $page;
$next = $page + 1;
$pagination = '<ul class="pagination pull-right">
                   <li class="footable-page-arrow"><a data-page="first" href="javascript:;" onclick="loadorders(0, 1)"><span class="icon-double-angle-left"></span></a></li>
                   <li class="footable-page-arrow"><a data-page="prev" href="javascript:;" onclick="loadorders(0, '.$prev.')"><span class="icon-angle-left"></span></a></li>';
for($i=1; $i<=$number_of_pages; $i++)
{
    $active = "";
    if($i == $page)
    {
        $active = "active";
    }
    $pagination .= '<li class="footable-page '.$active.'" onclick="loadorders(0, '.$i.')"><a data-page="0" href="javascript:;">'.$i.'</a></li>';
}
                                                        
        
$pagination .= '<li class="footable-page-arrow"><a data-page="next" href="javascript:;" onclick="loadorders(0, '.$next.')"><span class="icon-angle-right"></span></a></li>
      <li class="footable-page-arrow"><a data-page="last" href="javascript:;" onclick="loadorders(0, '.$number_of_pages.')"><span class="icon-double-angle-right"></span></a></li>
  </ul>';
$filtertext = implode(' > ',$filter);
$_SESSION['report'] = '<i>'.$filtertext.'</i>';
$_SESSION['report'] .= '<table class="table table-bordered table-hover smaller">
                                                        <thead>
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Order ID</th>
                                                                <th>Customer</th>
                                                                <th>Shipping Address</th>
                                                                <th>Items</th>
                                                                <th>Total Paid</th>
                                                                <th>Status</th>
                                                                <th>Order Date</th>
                                                                <th>Transaction Ref</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
$_SESSION['report'] .= $text;

$_SESSION['report'] .= '</tbody></table>';

$_SESSION['filename'] = "bakangizo-orders";
$text = iconv('UTF-8', 'UTF-8//IGNORE', $text);

if(isset($_GET['status']) && $_GET['status'] == ORDER_PENDING_DELIVERY)
{
    $con->update_query("update orders set seenstatus=1");
}

echo json_encode(array('text'=>$text, "pagination"=>$pagination, 'lastrecord'=>$sn, 'filter'=>$filtertext, 'no_results'=>$number_of_results, 'page'=>$page));
?>