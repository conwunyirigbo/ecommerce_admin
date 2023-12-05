<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
$cart_items_count = 0;
$price = 0;
$text = "";
if(isset($_SESSION['cart_session_id']))
{
    $sql = "select c.id,c.price,quantity,p.name,productid from cart c inner join product p on c.productid=p.id where cart_session_id=:cart";
    $q = $con->select_query($sql,array(':cart'=>$_SESSION['cart_session_id']));
    $cart_items_count = count($q);
    foreach ($q as $r)
    {
        $price += $r['price']*$r['quantity'];
        
    $photo = UPLOADS_BASE_FOLDER.DEFAULT_PRODUCT_PHOTO;
									    $sql = "select photo from product_photos where productid=:id order by id ASC limit 1";
									    $q = $con->select_query($sql,array(':id'=>$r['productid']));
									    foreach ($q as $v)
									    {
									        if(strstr( $v['photo'], 'https'))
									        {
									            $photo = $v['photo'];
									        }
									        else
									        {
									            $photo = (!empty($v['photo']) && file_exists(UPLOADS_FOLDER.$v['photo'])) ? UPLOADS_BASE_FOLDER.$v['photo'] : UPLOADS_BASE_FOLDER.DEFAULT_PRODUCT_PHOTO;
									        }
									        
									    }
        
        $text .= '<li>
                      <a href="javascript:;#" onclick="removeItemHome('.$r['id'].')" class="item_remove"><i class="ion-close"></i></a>
                      <a href="product?id='.$r['productid'].'"><img src="'.$photo.'" alt="cart_thumb1">'.$r['name'].'</a>
                      <span class="cart_quantity"> '.$r['quantity'].' x <span class="cart_amount"> <span class="price_symbole">&#8358;</span></span>'.number_format(round($r['price']),2).'</span>
                  </li>';
    }
}
echo json_encode(array('count'=>$cart_items_count,'cartprice'=>number_format($price),'text'=>$text));
?>