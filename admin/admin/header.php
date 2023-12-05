<?php
include('../include/connection.php');
include('../include/app_config.php');
require_once '../lib/dbconfig.php';
require_once '../lib/app_stat.php';
require_once '../lib/custom.php';

date_default_timezone_set('Africa/Lagos');

if (!$authview && $menuid != "dashboard" && $menuid != "") {
    echo '<script>window.location="index"</script>';
}


if (!$user->is_loggedin() || $_SESSION['user_role'] == USER_KEY) {
    echo '<script>window.location="../login"</script>';
} else {
    $username = $_SESSION['user_session'];
}
$title = (isset($title)) ? $title : "Dashboard";
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

    <title><?php echo $title ?> : Greenstore Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <link href="assets/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
    <!-- Toastr style -->
    <link href="css/toastr/toastr.min.css" rel="stylesheet">
    <link href="css/iCheck/custom.css" rel="stylesheet">
    <link href="css/chosen/bootstrap-chosen.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />


    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var _group = '<?php echo $group; ?>';
            var _menu = '<?php echo $menuid; ?>';


            $('#' + _group).addClass('active');
            $('#' + _menu).addClass('active');
        });
    </script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "1b382dce-f5b4-4c73-832e-587575946ab2",
                notifyButton: {
                    enable: true,
                },
            });
        });
    </script>
    <script>
        function logout() {
            $(document).ready(function() {
                var datastring = {
                    'id': 1
                };
                $.ajax({
                    type: "POST",
                    url: "../utility/logout.php",
                    data: datastring,
                    cache: false,
                    success: function(data) {
                        window.location.href = "../login";
                        //alert(data);
                    },
                    error: function() {
                        alert('error handling here');
                    }
                });

            });
        }

        function getUnreadNo() {
            $(document).ready(function() {
                var datastring = {
                    'id': 1
                };
                $.ajax({
                    type: "POST",
                    url: "getunreadno.php",
                    data: datastring,
                    cache: false,
                    success: function(data) {
                        $('#unreadno').html(data);
                    },
                    error: function() {
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
        $(document).ready(function() {
            $('.form-control').change(function() {
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
        .row-pad {
            padding: 10px;
        }

        .form-control {
            border: 1px solid #e2e2e4;
            box-shadow: none;
            color: #333;
        }

        .colour-span {
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
            margin-left: 0px !important;
            object-fit: cover !important;
            overflow: hidden !important;
            border: none !important !important;
        }

        .table.smaller td,
        .table.smaller th {
            font-size: 12px !important;
        }

        .label-white {
            background: #fff;
            color: #333 !important;
            border: 1px solid #ddd !important;
        }

        .label-secondary,
        .btn-secondary {
            background: #990066;
            color: #fff !important;
        }

        .btn-info-dark {
            background: #003c77;
            color: #fff !important;
        }

        .table-list li {

            list-style-type: disc;
            margin-left: 14px;
            border-bottom: 1px solid #ddd;
        }

        .table-list li:last-child {
            border-bottom: none;
            ;
        }

        .green {
            background: #00cc00;
        }

        .text-success {
            color: #00cc00 !important;
        }

        .value p,
        .value h1 {
            color: #666666 !important;
        }

        .old-price {
            color: #ff3399;
            text-decoration: line-through;
        }

        .form-control.smaller {
            font-size: 11px !important;
            padding: 3px 5px !important;
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
                <a href="index" class="logo">Green<span>Store</span></a>
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
                                <span class="username"><?php echo $username ?></span>
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
                <div id="sidebar" class="nav-collapse ">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a id="dashboard" href="index">
                                <i class="icon-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <?php

                        $sql = "select * from menugroup where status=1 AND MenuGroupOrder > 0 order by MenuGroupOrder";
                        $q = $con->run_select_query($sql);
                        foreach ($q as $r) {
                            if ($auth->HasGroupView($r['Code']) || $_SESSION['user_session'] == ADMIN_USERNAME || $_SESSION['user_session'] == "test_admin") {
                                $class = "";
                                if ($r['HasMenuItems'] == 1) {
                                    $class = "sub-menu";
                                }
                                echo '<li class="' . $class . '">
                                <a href="' . $r['Url'] . '" id="' . $r['Code'] . '">
                                    <i class="' . $r['Icon'] . '"></i>
                                    <span>' . $r['Text'] . '</span>';
                                if ($r['HasMenuItems'] == 1) {
                                    // echo '<i class="fa fa-angle-right drop-icon"></i></a>';

                                    echo '</a>';
                                    $sq = "select * from menuitem where GroupCode=:code AND TopMenuCode='' AND MenuItemOrder > 0 AND status=1 Order by MenuItemOrder";
                                    $f = $con->select_query($sq, array(':code' => $r['Code']));
                                    if (count($f) > 0) {
                                        echo '<ul class="sub">';
                                        foreach ($f as $v) {
                                            if ($auth->HasView($v['Code']) || $_SESSION['user_session'] == ADMIN_USERNAME || $_SESSION['user_session'] == "test_admin") {
                                                echo '<li id="' . $v['Code'] . '">';
                                                if ($v['Code'] == "inbox") {
                                                    $num_unread_notify = $notify;
                                                } else {
                                                    $num_unread_notify = "";
                                                }
                                                if ($v['HasMenuItems'] == 1) {
                                                    echo '<a href="' . $v['Url'] . '" id="' . $v['Code'] . '"  class="dropdown-toggle">
                                                ' . $v['Text'] . $num_unread_notify;
                                                    echo '<i class="fa fa-angle-right drop-icon"></i>
                                                 </a>';
                                                    $query = "select * from menuitem where TopMenuCode=:code AND status=1 MenuGroupOrder > 0 Order by MenuItemOrder";
                                                    $h = $con->select_query($query, array(':code' => $v['Code']));
                                                    if (count($h) > 0) {
                                                        echo '<ul class="submenu">';
                                                        foreach ($h as $k) {
                                                            if ($auth->HasView($k['Code']) || $_SESSION['user_session'] == ADMIN_USERNAME || $_SESSION['user_session'] == "test_admin") {
                                                                echo '<li>
                        									<a href="' . $k['Url'] . '" id="' . $k['Code'] . '">
                        										' . $k['Text'] . $num_unread_notify . '
                        									</a>
                        								</li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    }
                                                } else {
                                                    echo '<a href="' . $v['Url'] . '" id="' . $v['Code'] . '">
                                               ' . $v['Text'] . $num_unread_notify;
                                                    echo '</a>';
                                                }
                                                echo '</li>';
                                            }
                                        }
                                        echo '</ul>';
                                    }
                                } else {
                                    echo '</a>';
                                }

                                echo '</li>';
                            }
                        }
                        ?>

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