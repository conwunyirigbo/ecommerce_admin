<?php 
include('../include/connection.php');
include('../include/app_config.php');
require_once '../lib/dbconfig.php';
require_once '../lib/app_stat.php';

date_default_timezone_set('Africa/Lagos');

if(!$user->is_loggedin() || $_SESSION['user_role'] == USER_KEY)
{
    echo '<script>window.location="../login"</script>';
}
else 
{
    $username = $_SESSION['user_session'];
}
$title =(isset($title)) ? $title : "Dashboard";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title><?php echo $title?> : Bakan Gizo Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="assets/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
    <!-- Toastr style -->
    <link href="css/toastr/toastr.min.css" rel="stylesheet">
    <link href="css/iCheck/custom.css" rel="stylesheet">
    <link href="css/chosen/bootstrap-chosen.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    
    <script src="js/jquery.js"></script>
    <script src="js/jquery-1.8.3.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
            var _group = '<?php echo $group; ?>';
            var _menu = '<?php echo $menu; ?>';
            
            
            $('#' + _group).addClass('active');
            $('#' + _menu).addClass('active');
        });
</script>
    <script>
        function logout()
        {
        	$(document).ready(function(){
        		var datastring = {'id' : 1};
        		$.ajax({
        		            type: "POST",
        		            url: "../utility/logout.php",
        		            data: datastring,
        		            cache: false,
        		            success: function(data) {
        		                window.location.href="../login";
        		                //alert(data);
        		            },
        		            error: function(){
        		                  alert('error handling here');
        		            }
        		        });
        		
        	});
        }

        function getUnreadNo()
        {
        	$(document).ready(function(){
        		var datastring = {'id' : 1};
        		$.ajax({
        		            type: "POST",
        		            url: "getunreadno.php",
        		            data: datastring,
        		            cache: false,
        		            success: function(data) {
        		                $('#unreadno').html(data);
        		            },
        		            error: function(){
        		                  alert('error handling here');
        		            }
        		        });
        		
        	});
        }

        function printContent(el) {
            //var restorepage = document.body.innerHTML;
            $(".hideprint").hide();
            $(".showprint").show();
            var printcontent = document.getElementById(el).innerHTML;
            document.getElementById('holdprint').innerHTML = printcontent
            window.print();
            document.getElementById('holdprint').innerHTML = "";
            $(".hideprint").show();
            $(".showprint").hide();
        }
    </script>
    
    <script>
    $(document).ready(function(){
        $('.form-control').change(function(){
            $('#msg').html('');
        })
    });
    </script>
    

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    
    <style>
    .row-pad
    {
    	padding: 10px;
    }
.form-control {
    border: 1px solid #e2e2e4;
    box-shadow: none;
    color: #333;
}
.colour-span
{
	width: 20px;
	height: 20px;
	display: block;
}
.product-photo-wrap {
    width: 30px;
    height: 30px;
	float: left;
	margin-right: 5px;
}
.slide-photo-wrap {
    width: 118px;
    height: 35px;
}
.img-responsive {
    /* max-width: 200px; */
	width: 100%;
    height: 100%;
    margin-left: 0px!important;
    object-fit: cover!important;
    overflow: hidden!important;
    border: none!important!important;
}
.table.smaller td, .table.smaller th
{
	font-size: 12px!important;
}
.label-white
{
	background: #fff;
	color: #333!important;
	border: 1px solid #ddd!important;
}
.label-secondary, .btn-secondary
{
	background: #990066;
	color: #fff!important;
}
.btn-info-dark
{
	background: #003c77;
	color: #fff!important;
}
.table-list li
{
	
	list-style-type: disc;
	margin-left: 14px;	
	border-bottom: 1px solid #ddd;
}
.table-list li:last-child
{
	border-bottom: none;;
}
.green
{
	background: #00cc00;
}
.text-success
{
	color: #00cc00!important;
}
.value p, .value h1 {
    color: #666666!important;
}
.old-price {
    color: #ff3399;
    text-decoration: line-through;
}
.form-control.smaller
{
	font-size: 11px!important;
	padding: 3px 5px!important;
	margin-top: 5px;
	height: 25px;
}
    </style>
  </head>

  <body>
<div id="holdprint"></div>
<div class="hideprint">
  <section id="container">
      <!--header start-->
      <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
            <a href="index" class="logo">Bakan<span>Gizo</span></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
                    
                    
                    <!-- notification dropdown start-->
                    <li id="header_notification_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="icon-bell-alt"></i>
                            <span class="badge bg-warning" id="unreadno"></span>
                        </a>
                        
                    </li>
                    <!-- notification dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="img/default-user.jpg" style="width: 25px;">
                            <span class="username"><?php echo $username?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="javascript:;" onclick="logout()"><i class="icon-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <li>
                      <a id="dashboard" href="index">
                          <i class="icon-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li>
                      <a id="tcategory" href="category_list">
                          <i class="icon-laptop"></i>
                          <span>Categories</span>
                      </a>
                  </li>
                  <li>
                      <a id="tbrand" href="brand_list">
                          <i class="icon-check"></i>
                          <span>Brands</span>
                      </a>
                  </li>
                  <li>
                      <a id="tproduct" href="product_list">
                          <i class="icon-briefcase"></i>
                          <span>Products</span>
                      </a>
                  </li>
                  <?php 
                  if($_SESSION['user_role'] != ORDER_ADMIN_USER_KEY)
                  {
                  ?>
                  <li>
                      <a id="tbanner" href="banner_list">
                          <i class="icon-flag"></i>
                          <span>Banners</span>
                      </a>
                  </li>
                  
                  
                  <li>
                      <a id="dstaff" href="delivery_staff_list">
                          <i class="icon-user"></i>
                          <span>Delivery Staff</span>
                      </a>
                  </li>
                  <?php 
                  }
                  ?>
                  
                  <li>
                      <a id="torder" href="orders">
                          <i class="icon-book"></i>
                          <span>Orders</span>
                      </a>
                  </li>
                  
                  <li>
                      <a id="tcustomer" href="customers">
                          <i class="icon-group"></i>
                          <span>Customers</span>
                      </a>
                  </li>
                  
                  <?php 
                  if($_SESSION['user_role'] != ORDER_ADMIN_USER_KEY)
                  {
                  ?>
                  <li  class="sub-menu">
                      <a id="settings" href="javascript:;" >
                          <i class="icon-cogs"></i>
                          <span>Settings</span>
                      </a>
                      <ul class="sub">
                          <li id="tgeneral"><a href="site_settings">General Settings</a></li>
                          <li id="tcolour"><a href="colour_list">Colours</a></li>
                          <li id="tsize"><a href="size_list">Sizes</a></li>
                          <li id="tslider"><a href="slider_list">Slider</a></li>
                          <li id="tdelivery"><a href="delivery_settings">Delivery Settings</a></li>
                          <li id="tcontent"><a  href="site_content">Site Content</a></li>
                      </ul>
                  </li>
                  <?php 
                  }
                  ?>

                  <li class="sub-menu">
                      <a id="security" href="javascript:;">
                          <i class="icon-lock"></i>
                          <span>Security</span>
                      </a>
                      <ul class="sub">
                          <?php 
                          if($_SESSION['user_role'] != ORDER_ADMIN_USER_KEY)
                          {
                          ?>
                          <li><a id="tuser" href="user_list">Users</a></li>
                          <?php 
                          }
                          ?>
                          <li><a id="changepwd" href="change_password">Change Password</a></li>
                      </ul>
                  </li>
                  
                  <li>
                      <a href="javascript:;" onclick="logout()">
                          <i class="icon-power-off"></i>
                          <span>Logout</span>
                      </a>
                  </li>


              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">