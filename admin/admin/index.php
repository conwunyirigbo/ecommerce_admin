<?php 
$menuid = "dashboard";
$group = "dashboard";
session_start();
include('header.php');?>
              <div class="row state-overview">
              
                  <div class="col-lg-3 col-sm-6">
                      <a href="orders?status=<?php echo ORDER_PENDING_DELIVERY?>"><section class="panel">
                          <div class="symbol red">
                              <i class="icon-tags"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count2">
                                  <?php echo GetTotalOrderByStatus(ORDER_PENDING_DELIVERY, $con);?>
                              </h1>
                              <p>Pending Orders</p>
                          </div>
                      </section></a>
                  </div>
                  
                  <div class="col-lg-3 col-sm-6">
                      <a href="orders?status=<?php echo ORDER_PROCESSING?>"><section class="panel">
                          <div class="symbol blue">
                              <i class="icon-cog"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count4">
                                  <?php echo GetTotalOrderByStatus(ORDER_PROCESSING, $con);?>
                              </h1>
                              <p>Orders Processed</p>
                          </div>
                      </section></a>
                  </div>
                  
                  <div class="col-lg-3 col-sm-6">
                      <a href="orders?status=<?php echo ORDER_READY_TO_SHIP?>"><section class="panel">
                          <div class="symbol terques">
                              <i class="icon-plane"></i>
                          </div>
                          <div class="value">
                              <h1 class="count">
                                  <?php echo GetTotalOrderByStatus(ORDER_READY_TO_SHIP, $con);?>
                              </h1>
                              <p>Orders Ready to Ship</p>
                          </div>
                      </section></a>
                  </div>
                  
                  
                  
                  <div class="col-lg-3 col-sm-6">
                      <a href="orders?status=<?php echo ORDER_SHIPPED?>"><section class="panel">
                          <div class="symbol terques">
                              <i class="icon-briefcase"></i>
                          </div>
                          <div class="value">
                              <h1 class="count">
                                  <?php echo GetTotalOrderByStatus(ORDER_SHIPPED, $con);?>
                              </h1>
                              <p>Shipped Orders</p>
                          </div>
                      </section></a>
                  </div>
                  
                  <div class="col-lg-3 col-sm-6">
                      <a href="orders?status=<?php echo ORDER_DELIVERED?>"><section class="panel">
                          <div class="symbol green">
                              <i class="icon-shopping-cart"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count3">
                                  <?php echo GetTotalOrderByStatus(ORDER_DELIVERED, $con);?>
                              </h1>
                              <p>Delivered Orders</p>
                          </div>
                      </section></a>
                  </div>
                  
                  <div class="col-lg-3 col-sm-6">
                      <a href="product_list"><section class="panel">
                          <div class="symbol red">
                              <i class="icon-building"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count4">
                                  <?php echo GetTotalProducts($con)?>
                              </h1>
                              <p>Total Active Products</p>
                          </div>
                      </section></a>
                  </div>
                  
                  <div class="col-lg-3 col-sm-6">
                      <a href="user_list"><section class="panel">
                          <div class="symbol blue">
                              <i class="icon-user"></i>
                          </div>
                          <div class="value">
                              <h1 class=" count4">
                                  <?php echo GetTotalAdminUsers($con)?>
                              </h1>
                              <p>Admin Users</p>
                          </div>
                      </section></a>
                  </div>
                  
                  <div class="col-lg-3 col-sm-6">
                      <a href="brand_list"><section class="panel">
                          <div class="symbol green">
                              <i class="icon-plane"></i>
                          </div>
                          <div class="value">
                              <h1 class="count">
                                  <?php echo GetTotalBrands($con);?>
                              </h1>
                              <p>Brands</p>
                          </div>
                      </section></a>
                  </div>
              </div>
              <!--state overview end-->

              
              <div class="row">
                  <div class="col-lg-4">
                      <!--user info table start-->
                      <section class="panel">
                          <div class="panel-body">
                              <div class="task-thumb-details">
                                  <h1><a href="#">Top Categories</a></h1>
                                  <p>Most Ordered</p>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                                <?php 
                                $sql = "SELECT distinct(pc.categoryid),ca.code,ca.name,SUM(quantity) AS nopurchased from cart c 
                                        left outer join product_categories pc on c.productid=pc.productid 
                                        left outer join category ca on pc.categoryid=ca.id  
                                        left outer join orders o on c.cart_session_id=o.cart_session_id
                                        where o.status != :not_completed
                                        GROUP BY pc.categoryid
                                        order by nopurchased DESC limit 8";
                                $q = $con->select_query($sql,array(':not_completed'=>ORDER_NOT_COMPLETED));
                                foreach($q as $r)
                                {
                                ?>
                                <tr>
                                    <td><?php echo $r['name']?></td>
                                    <td class="text-success"> <?php echo $r['nopurchased']?> Sold</td>
                                </tr>
                                <?php 
                                }
                                ?>
                                
                              </tbody>
                          </table>
                      </section>
                      <!--user info table end-->
                  </div>
                  <div class="col-lg-8">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Recent Orders</h1>
                                  <p>Pending</p>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                              <?php 
                                $sql = "select u.firstname,u.lastname,o.status,o.cart_session_id,o.orderdate from orders o left outer join customer c on o.userid=c.userid inner join users u on c.userid=u.id where o.status=:pending ORDER BY o.id DESC limit 8";
                                $q = $con->select_query($sql,array(':pending'=>ORDER_PENDING_DELIVERY));
                                foreach($q as $r)
                                {
                              ?>
                              <tr>
                                  <td>#<?php echo $r['cart_session_id']?></td>
                                  <td>
                                      <?php echo $r['firstname'].' '.$r['lastname']?>
                                  </td>
                                  <td>
                                      <span class="badge bg-info"><?php echo GetTotalProductsinCart($r['cart_session_id'], $con)?> Products</span>
                                  </td>
                                  <td>
                                    <?php echo GetOrderStatusAdmin($r['status'])?>
                                  </td>
                              </tr>
                              <?php 
                                }
                              ?>
                              <tr>
                                <td style="text-align: left"><a href="orders?status=<?php echo ORDER_PENDING_DELIVERY?>">See all</a></td>
                              </tr>
                              </tbody>
                          </table>
                      </section>
                      <!--work progress end-->
                  </div>
              </div>
              
          <?php include('footer.php')?>