<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
$cart_session_id = "";
if(isset($_SESSION['cart_session_id']))
{
    $cart_session_id = $_SESSION['cart_session_id'];
}

$cart_empty = false;
?>

	<div class="cart_section" style="padding-top: 20px;">
		<div class="container">
            <div class="row">
		      <div class="col-md-8">
		          <!-- Cart item -->
        			<div class="container-table-cart pos-relative">
        				<div class="wrap-table-shopping-cart bgwhite">
        					<table class="table-shopping-cart">
                                <tr class="table-head">
        							<th class="column-1"></th>
        							<th class="column-2">Product</th>
        							<th class="column-3">Price</th>
        							<th class="column-4">Quantity</th>
        							<th class="column-5">Total</th>
        						</tr>

<?php 
        						$grandtotal = 0;
        						  $sql = "select c.id as cart_item_id,p.id,p.name,c.price,c.quantity,co.id as colourid,co.name as colourname,si.name as sizename from cart c 
                                            left outer join product p on c.productid=p.id 
                                            left outer join colour co on c.colourid=co.id
                                            left outer join size si on c.sizeid=si.id
                                            where c.cart_session_id=:cart";
        						  $q = $con->select_query($sql,array(':cart'=>$cart_session_id));
        						  if(count($q) == 0)
        						  {
        						      echo '<tr class="table-head">
        					       <td class="column-1"></td>
        							<td class="column-2">--empty cart--</td></tr>';
        						      $cart_empty = true;
        						  }
        						  foreach($q as $r)
        						  {
        						      $totalprice = 0;
        						      $photo = UPLOADS_BASE_FOLDER.DEFAULT_PRODUCT_PHOTO;
									    $sql = "select photo from product_photos where productid=:id order by id ASC limit 1";
									    $q = $con->select_query($sql,array(':id'=>$r['id']));
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
        						      $totalprice = $r['quantity'] > 0 ? $r['price'] * $r['quantity'] : $r['price'];
        						      $grandtotal += $totalprice;
        						?>
        
        						<tr class="table-row">
        							<td class="column-1">
        								<div class="cart-img-product b-rad-4 o-f-hidden">
        									<div class="cart-photo-wrap"><img src="<?php echo $photo?>" alt="<?php echo $r['name']?>" class="img-responsive"/></div>
        								</div>
        							</td>
        							<td class="column-2">
        							     <a href="product?id=<?php echo $r['id']?>"><?php echo $r['name']?></a>
        							     <?php 
        							     if(!empty($r['colourname'])){
        							     ?> 
        							     <br/>
        							     <i><strong>Colour:</strong> <?php echo $r['colourname']?></i>
        							     <?php 
        							     }
        							     if(!empty($r['sizename'])){
        							     ?>
        							     <br/>
        							     <i><strong>Size:</strong> <?php echo $r['sizename']?></i>
        							     <?php 
        							     }
        							     ?>
        							</td>
        							<td class="column-3">&#8358;<?php echo number_format(round($r['price'],2))?></td>
        							<td class="column-4">        								
        								<div class="product_quantity clearfix">
    										<span>Quantity: </span>
    										<input type="text" id="quantity_input<?php echo $r['id']?>" pattern="[0-9]*" value="<?php echo $r['quantity']?>">
    										<div class="quantity_buttons">
    											<div id="quantity_inc_button<?php echo $r['id']?>" onclick="incQuantity(<?php echo $r['id']?>,<?php echo $r['cart_item_id']?>)" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
    											<div id="quantity_dec_button<?php echo $r['id']?>" onclick="decQuantity(<?php echo $r['id']?>,<?php echo $r['cart_item_id']?>)" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
    										</div>
    									</div>
        							</td>
        							<td class="column-5">&#8358;<?php echo number_format(round($totalprice,2))?></td>
        							<td class="column-3"><button type="button" style="cursor: pointer" onclick="removeItem(<?php echo $r['cart_item_id']?>)"><span class="fa fa-times"></span></button></td>
        						</tr>
        						<?php 
        						  }
        						?>
        						</table>
        				</div>
        			</div>
        			<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
        		
        
        				<div class="size10 trans-0-4 m-t-10 m-b-10" style="width: 300px;">
        					<!-- Button -->
        					<a class="btn btn-fill-out btn-addtocartw" href="shop">
        						Continue Shopping
        					</a>
        				</div>
        			</div>
		      </div>
		      <div class="col-md-4">
		          <!-- Total -->
    			<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
    				<h5 class="m-text20 p-b-24">
    					Cart Total
    				</h5>
    
    				<!--  -->
    				<div class="flex-w flex-sb-m p-b-12">
    					<span class="s-text18 w-size19 w-full-sm">
    						Subtotal:
    					</span>
    
    					<span class="m-text21 w-size20 w-full-sm">
    						&#8358;<?php echo number_format(round($grandtotal,2))?>
    					</span>
    				</div>
    
    				<!--  -->
    				<div class="flex-w flex-sb bo10 p-t-15 p-b-20">
    					<span class="s-text18 w-size19 w-full-sm" style="font-size: 13px">
    						Delivery Fee:
    					</span>
    
    					<span class="m-text21 w-size20 w-full-sm" style="font-size: 12px;">
    						Not added yet.
    					</span>
    				</div>
    
    				<!--  -->
    				<div class="flex-w flex-sb-m p-t-26 p-b-30">
    					<span class="m-text22 w-size19 w-full-sm">
    						Total:
    					</span>
    
    					<span class="m-text21 w-size20 w-full-sm">
    						&#8358;<?php echo number_format(round($grandtotal,2))?>
    					</span>
    				</div>
    
    <?php 
    if(!$cart_empty)
    {
    ?>
    				<div class="size15 trans-0-4">
    					<!-- Button -->
    					<a href="checkout?checkout=1" class="btn btn-fill-out btn-addtocart">
    						Proceed to Checkout
    					</a>
    				</div>
    <?php 
    }
    ?>
    			</div>
		      </div>
		  </div>
    </div>
</div>