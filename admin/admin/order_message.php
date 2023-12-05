<?php 
$firstname = "";
$lastname = "";
$cart_session_id = "";
$customeremail = "";
$sql = "select o.cart_session_id,u.firstname,u.lastname,u.email as useremail,c.email from orders o left outer join customer c on o.userid=c.userid left outer join users u on o.userid=u.id where o.id=:id";
$q = $con->select_query($sql,array(':id'=>$_GET['id']));
foreach($q as $r)
{
    $firstname = $r['firstname'];
    $lastname = $r['lastname'];
    $customeremail = !empty($r['email']) ? $r['email'] : $r['useremail'];
    $cart_session_id = $r['cart_session_id'];
}

if(!empty($cart_session_id) && !empty($customeremail))
{
    $msg = '<p>Dear '.$firstname.' '.$lastname.'</p>';
    if($_GET['status'] == ORDER_SHIPPED)
    {
        $msg .= '<p>Your order on Bakan Bizo is in transit (left depot) and is on its way to you. See details below;</p><br/>';
    }
    else if($_GET['status'] == ORDER_READY_TO_SHIP)
    {
        $msg .= '<p>Your order on Bakan Bizo is ready to be shipped. See details below;</p><br/>';
    }
    else if($_GET['status'] == ORDER_PROCESSING)
    {
        $msg .= '<p>Your order on Bakan Bizo is being processed. See details below;</p><br/>';
    }
    else if($_GET['status'] == ORDER_DELIVERED)
    {
        $msg .= '<p>Your order on Bakan Bizo has been delivered. See details below;</p><br/>';
    }
    else if($_GET['status'] == ORDER_CANCELLED)
    {
        $msg .= '<p>Your order on Bakan Bizo has been cancelled. See details below;</p><br/>';
    }
    $order = "";
    $sql = "select * from orders where cart_session_id=:cart order by id DESC";
    $q = $con->select_query($sql,array(':cart'=>$cart_session_id));
    foreach($q as $r)
    {
        $order .= '<table>';
        $order .= '<tr style="border: 1px solid #ddd">
                    						                  <th colspan="4" style="border: 1px solid #ddd; padding: 10px;  margin:0">
                    						                      <p style="font-size: 13px; color: #ff3399; text-transform:uppercase; font-family: \'open sans\'">
                                							         <strong>Order No. #</strong>'.$r['cart_session_id'].' - '.$r['orderdate'].'
                                						          </p>
                    						                  </th>
                    						              </tr>';
            $grandtotal = 0;
                    						              $sql = "select c.id as cart_item_id,p.id,p.name,c.price,c.quantity from cart c left outer join product p on c.productid=p.id where c.cart_session_id=:cart";
                    						              $q = $con->select_query($sql,array(':cart'=>$cart_session_id));
    
                    						              foreach($q as $d)
                    						              {
                    						                  $totalprice = 0;
                    						                  $photo = DEFAULT_PRODUCT_PHOTO;
                    						                  $sql = "select photo from product_photos where productid=:id order by id ASC limit 1";
                    						                  $q = $con->select_query($sql,array(':id'=>$d['id']));
                    						                  foreach ($q as $v)
                    						                  {
                    						                      $photo = (!empty($v['photo']) && file_exists(UPLOADS_FOLDER.$v['photo'])) ? $v['photo'] : DEFAULT_PRODUCT_PHOTO;;
                    						                  }
                    						                  $totalprice = $d['quantity'] > 0 ? $d['price'] * $d['quantity'] : $d['price'];
                    						                  $grandtotal += $totalprice;
                    						             
                    						              $order .= '<tr>
                        						                  <td style="border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'"><img src="'.APP_URL.UPLOADS_BASE_FOLDER.$photo.'" style="width: 50px;"/></td>
                        						                  <td style="border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'">'.$d['name'].'</td>
                        						                  <td style="border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'">'.$d['quantity'].' x &#8358;'.number_format(round($d['price'],2)).'</td>
                        						                  <td style="border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'">'.GetOrderStatus($r['status']).'</td>
                        						              </tr>';
                    						              
                    						              }
                    						              $shipping_fee = $r['delivery_fee'];
                    						              $grandtotal += $shipping_fee;
                    						              
                    						            
                    						              $order .= '<tr>
                    						                  <td colspan="2" style="border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'">Delivery Fee</td>
                    						                  <td colspan="2" style="border: 1px solid #ddd; padding: 10px; margin:0; font-family: \'open sans\'">&#8358;'.number_format(round($shipping_fee,2)).'</td>
                    						              </tr>
                    						              <tr>
                    						                 
                    						                  <td colspan="2" style="border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'"><strong>Total</strong></td>
                    						                  <td colspan="2" style="border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'">&#8358;'.number_format(round($grandtotal,2)).'</td>
                    						              </tr>
                    						              <tr>                						                 
                    						                  <td colspan="4" style="border: 1px solid #ddd; padding: 10px;  margin:0; font-family: \'open sans\'"><p style="font-size: 12px; line-height: 20px">Delivered within <strong>'.$r['days'].'</strong> from '.$r['orderdate'].'.</p></td>
                    						              </tr>
    </table>';
    }
    $msg .= $order;
    
    $msg .= "<br/><p>Thanks for your patronage. <br/>Bakan Bizo Team.</p>";
    
    SendMessageToQueue(GetOrderStatusText($_GET['status']), $msg, $customeremail, "Bakan Bizo", $con);
}