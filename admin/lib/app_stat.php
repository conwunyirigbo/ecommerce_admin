<?php 


function GetTotalAdminUsers(\database $con)
{
    $no = 0;
    $sql = "select id from users where role=:admin OR role=:order";
    $q=$con->select_query($sql,array(':admin'=>ADMIN_USER_KEY, ':order'=>ORDER_ADMIN_USER_KEY));
    $no = count($q);
    return $no;
}

function GetMenu($topmenu,\database $con,$is_side_menu = false)
{
    if($topmenu > 0)
    {
        $sql = "select c.id,c.name,c.code from category c left outer join sub_categories sc on c.id=sc.subcategoryid where sc.mastercategoryid=:topmenu AND c.type=:master AND status=1 AND show_menu=1 order by categoryorder";
        $q = $con->select_query($sql,array(':topmenu'=>$topmenu,':master'=>MASTER_CATEGORY));
    }
    else
    {
        $sql = "select id,name,code from category where type=:master AND status=1 AND show_menu=1 order by categoryorder";
        $q = $con->select_query($sql,array(':master'=>MASTER_CATEGORY));
    }
    foreach($q as $r)
    {
        $hassubs = "";
        $dropdown_icon = "";
        $sql = "select c.id,c.name,c.code from sub_categories sc inner join category c on sc.subcategoryid=c.id where sc.mastercategoryid=:masterid AND c.status=1 AND c.show_menu=1 order by categoryorder";
        $q = $con->select_query($sql,array(':masterid'=>$r['id']));
        if(count($q) > 0)
        {
            $hassubs = "hassubmenu";
            $dropdown_icon = "fas fa-chevron-right";
        }
        $icon="";
        if($is_side_menu)
        {
            $icon = " <i class='fa fa-shopping-cart'></i> ";
        }
        echo '<li class="'.$hassubs.'"><a href="shop?category='.$r['code'].'"> '.$icon.' '.$r['name'].' &nbsp;&nbsp;<span class="'.$dropdown_icon.'"></span></a>';
        if(count($q) > 0)
        {
            echo '<ul class="master-sub">';
        }
        foreach($q as $d)
        {
            echo '<li><a href="shop?category='.$d['code'].'">'.$d['name'].'</a></li>';
        }
        if(count($q) > 0)
        {
            echo '</ul>';
        }
        echo '</li>';
    }
}


function GetMobileMenu($topmenu,\database $con)
{
    if($topmenu > 0)
    {
        $sql = "select c.id,c.name,c.code from category c left outer join sub_categories sc on c.id=sc.subcategoryid where sc.mastercategoryid=:topmenu AND c.type=:master AND status=1 AND show_menu=1 order by categoryorder";
        $q = $con->select_query($sql,array(':topmenu'=>$topmenu,':master'=>MASTER_CATEGORY));
    }
    else
    {
        $sql = "select id,name,code from category where type=:master AND status=1 AND show_menu=1 order by categoryorder";
        $q = $con->select_query($sql,array(':master'=>MASTER_CATEGORY));
    }
    foreach($q as $r)
    {
        $hassubs = "";
        $dropdown_icon = "";
        $sql = "select c.id,c.name,c.code from sub_categories sc inner join category c on sc.subcategoryid=c.id where sc.mastercategoryid=:masterid AND c.status=1 AND c.show_menu=1 order by categoryorder";
        $q = $con->select_query($sql,array(':masterid'=>$r['id']));

        echo '<li><a href="shop?category='.$r['code'].'">'.$r['name'].'</a>';
        if(count($q) > 0)
        {
            echo '<ul>';
        }
        foreach($q as $d)
        {
            echo '<li><a href="shop?category='.$d['code'].'">'.$d['name'].'</a></li>';
        }
        if(count($q) > 0)
        {
            echo '</ul>';
        }
        echo '</li>';
    }
}


function GetShippingFee($stateid,$cityid,\database $con)
{
    $amount = 0;
    $no_custom = true;
    $sql = "select amount,dsid from delivery_fee df left outer join delivery_cities dc on df.id=dc.dsid where df.stateid=:state AND (dc.cityid=:city OR dc.cityid=0) order by df.id DESC limit 1";
    $q = $con->select_query($sql,array(':state'=>$stateid,':city'=>$cityid));
    if(count($q) > 0)
    {
        $no_custom = false;
        foreach($q as $r)
        {
            $amount = $r['amount'];
        }
    }
    else 
    {
        $sql = "select id,amount from delivery_fee where stateid=:state";
        $q = $con->select_query($sql,array(':state'=>$stateid));
        foreach($q as $r)
        {
            $ql = "select id from delivery_cities where dsid=".$r['id'];
            $d = $con->select_query($ql);
            if(count($d) == 0)
            {
                $amount = $r['amount'];
            }
            if(count($q) > 0 && count($d) == 0)
            {
                $no_custom = false;
            }
        }
    }
    
    if($no_custom)  //get standard shipping fee
    {
        $sql = "select amount from delivery_fee where stateid=0";
        $q = $con->select_query($sql);
        foreach($q as $r)
        {
            $amount = $r['amount'];
        }
    }
    return $amount;
}



function GetShippingDuration($stateid,$cityid,\database $con)
{
    $days = 0;
    $no_custom = true;
    $sql = "select df.days,df.type,dsid from delivery_fee df left outer join delivery_cities dc on df.id=dc.dsid where df.stateid=:state AND (dc.cityid=:city OR dc.cityid=0) order by df.id DESC limit 1";
    $q = $con->select_query($sql,array(':state'=>$stateid,':city'=>$cityid));
    if(count($q) > 0)
    {
        $no_custom = false;
        foreach($q as $r)
        {
            $days = $r['days'].' '.$r['type'];
        }
    }
    else
    {
        $sql = "select id,days,type from delivery_fee where stateid=:state";
        $q = $con->select_query($sql,array(':state'=>$stateid));
        foreach($q as $r)
        {
            $ql = "select id from delivery_cities where dsid=".$r['id'];
            $d = $con->select_query($ql);
            if(count($d) == 0)
            {
                $days = $r['days'].' '.$r['type'];
            }
            if(count($q) > 0 && count($d) == 0)
            {
                $no_custom = false;
            }
        }
    }

    if($no_custom)  //get standard shipping fee
    {
        $sql = "select days,type from delivery_fee where stateid=0";
        $q = $con->select_query($sql);
        foreach($q as $r)
        {
            $days = $r['days'].' '.$r['type'];
        }
    }
    return $days;
}

function GetTotalProducts(\database $con)
{
    $no = 0;
    $sql = "select id from product where status=1";
    $q=$con->select_query($sql);
    $no = count($q);
    return $no;
}

function GetTotalBrands(\database $con)
{
    $no = 0;
    $sql = "select id from brand where status=1";
    $q=$con->select_query($sql);
    $no = count($q);
    return $no;
}

function GetWeightDiscount(\database $con)
{
    $weight_discount = 0;
    $sql = "select weight_discount from delivery_fee where stateid=0";
    $q = $con->select_query($sql);
    foreach($q as $r)
    {
        $weight_discount = $r['weight_discount'];
    }
    return $weight_discount;
}

function GetOrderStatus($value)
{
    $status= "";
    if($value == ORDER_PENDING_DELIVERY)
    {
        $status = '<span class="bagde badge-warning">Pending Order</span>';
    }
    else if($value == ORDER_NOT_COMPLETED)
    {
        $status = '<span class="bagde badge-default">Not Completed</span>';
    }
    else if($value == ORDER_SHIPPED)
    {
        $status = '<span class="bagde badge-info">Item(s) in transit (Left Depot)</span>';
    }
    else if($value == ORDER_DELIVERED)
    {
        $status = '<span class="bagde badge-success">Delivered</span>';
    }
    else if($value == ORDER_CANCELLED)
    {
        $status = '<span class="bagde badge-danger">Cancelled</span>';
    }
    else if($value == ORDER_PROCESSING)
    {
        $status = '<span class="bagde badge-secondary">Processing Order</span>';
    }
    else if($value == ORDER_READY_TO_SHIP)
    {
        $status = '<span class="bagde badge-info-dark">Ready to Ship</span>';
    }
    return $status;
}

function GetOrderStatusText($value)
{
    $status= "";
    if($value == ORDER_PENDING_DELIVERY)
    {
        $status = 'Pending Order';
    }
    else if($value == ORDER_NOT_COMPLETED)
    {
        $status = 'Not Completed';
    }
    else if($value == ORDER_SHIPPED)
    {
        $status = 'Item(s) in transit (Left Depot)';
    }
    else if($value == ORDER_DELIVERED)
    {
        $status = 'Order Delivered';
    }
    else if($value == ORDER_CANCELLED)
    {
        $status = 'Order Cancelled';
    }
    else if($value == ORDER_PROCESSING)
    {
        $status = 'Processing Order';
    }
    else if($value == ORDER_READY_TO_SHIP)
    {
        $status = 'Order Ready to Ship';
    }
    return $status;
}


function GetOrderStatusAdmin($value)
{
    $status= "";
    if($value == ORDER_PENDING_DELIVERY)
    {
        $status = '<span class="label label-warning">Pending Order</span>';
    }
    else if($value == ORDER_NOT_COMPLETED)
    {
        $status = '<span class="label label-default">Not Completed</span>';
    }
    else if($value == ORDER_SHIPPED)
    {
        $status = '<span class="label label-info">In Transit (Left Depot)</span>';
    }
    else if($value == ORDER_DELIVERED)
    {
        $status = '<span class="label label-success">Delivered</span>';
    }
    else if($value == ORDER_CANCELLED)
    {
        $status = '<span class="label label-danger">Cancelled</span>';
    }
    else if($value == ORDER_PROCESSING)
    {
        $status = '<span class="label label-secondary">Processing Order</span>';
    }
    else if($value == ORDER_READY_TO_SHIP)
    {
        $status = '<span class="label label-info-dark">Ready to Ship</span>';
    }
    return $status;
}

function GetTotalOrderByStatus($status,\database $con)
{
    $count = 0;
    $sql = "select id from orders where status=:status";
    $q = $con->select_query($sql,array(':status'=>$status));
    $count = count($q);
    return $count;
}

function GetTotalProductsinCart($cartno,\database $con)
{
    $count = 0;
    $sql = "select id from cart where cart_session_id=:cartno";
    $q = $con->select_query($sql,array(':cartno'=>$cartno));
    $count = count($q);
    return $count;
}

function GetCategoryName($id,\database $con)
{
    $name = "";
    $sql = "select name from category where id=:id";
    $q = $con->select_query($sql,array(':id'=>$id));
    foreach($q as $r)
    {
        $name = $r['name'];
    }
    return $name;
}

function GetStaffName($id,\database $con)
{
    $name = "";
    $sql = "select name from delivery_staff where id=:id";
    $q = $con->select_query($sql,array(':id'=>$id));
    foreach($q as $r)
    {
        $name = $r['name'];
    }
    return $name;
}

function GetBrandName($id,\database $con)
{
    $name = "";
    $sql = "select name from brand where id=:id";
    $q = $con->select_query($sql,array(':id'=>$id));
    foreach($q as $r)
    {
        $name = $r['name'];
    }
    return $name;
}

function GetSizeName($id,\database $con)
{
    $name = "";
    $sql = "select name from size where id=:id";
    $q = $con->select_query($sql,array(':id'=>$id));
    foreach($q as $r)
    {
        $name = $r['name'];
    }
    return $name;
}

function GetColourName($id,\database $con)
{
    $name = "";
    $sql = "select name from colour where id=:id";
    $q = $con->select_query($sql,array(':id'=>$id));
    foreach($q as $r)
    {
        $name = $r['name'];
    }
    return $name;
}

function GetStateName($id,\database $con)
{
    $name = "";
    $sql = "select name from state where id=:id";
    $q = $con->select_query($sql,array(':id'=>$id));
    foreach($q as $r)
    {
        $name = $r['name'];
    }
    return $name;
}

function GetCityName($id,\database $con)
{
    $name = "";
    $sql = "select name from city where id=:id";
    $q = $con->select_query($sql,array(':id'=>$id));
    foreach($q as $r)
    {
        $name = $r['name'];
    }
    return $name;
}

function GetDiscountPercentage($oldprice,$newprice)
{
    $percentage = 0;
    $diff = $oldprice - $newprice;
    $percentage = ($diff > 0 && $oldprice > 0 && $oldprice > $newprice) ? ($diff/$oldprice) * 100 : 0;
    return $percentage;
}

function GetThresholdAmount(\database $con)
{
    $amount = 0;
    $sql = "select threshold_amount from delivery_fee where stateid=0 AND cityid=0";
    $q = $con->select_query($sql);
    foreach($q as $r)
    {
        $amount = $r['threshold_amount'];
    }
    return $amount;
}

function isRestaurant($categoryid,$restaurant_id,\database $con)
{
    $is_restaurant = false;
    if($categoryid == $restaurant_id)
    {
        $is_restaurant = true;
    }
    else
    {
        $sql = "select c.is_restaurant,c.id from sub_categories sc inner join category c on sc.mastercategoryid=c.id where sc.subcategoryid=:id";
        $q = $con->select_query($sql,array(':id'=>$categoryid));
        foreach($q as $rr)
        {
            if($rr['id'] == $restaurant_id)
            {
                $is_restaurant = true;
            }
        }
    }
    return $is_restaurant;
}
?>