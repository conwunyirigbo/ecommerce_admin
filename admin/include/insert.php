<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

$date_created = date('d-m-Y');
if (isset($_POST['insert'])) {
    switch ($_POST['insert']) {
        case 'sign-up':
            if ($user->register($_POST['email'], $_POST['password'], $_POST['repeatpassword'], "", 0, USER_KEY, $_POST['firstname'], $_POST['lastname'])) {
                $id = $user->lastuser;
                $key = RandomString(12) . $id;
                $sql = "update users set reset_key=:key where id=:id";
                $con->update_query($sql, array(':key' => $key, ':id' => $id));


                $body = "<p>Thank you for signing up on Greenstore!<br/><br/>
                            We just want to confirm that your email address is correct.  
                            Please confirm your email address by clicking the button below.<br/><br/>
                            If you didn't create a Greenstore account, don't worry, it's likely someone mistyped their email address. Just ignore this email and the link will expire.
                            <br/><br/>
                            Happy Shopping,
                            <br/><br/>
                            Greenstore team.</p>";
                $body .= '<a href="' . APP_URL . 'activate_account?key=' . $key . '" style="display: inline-block; color: #fff; text-decoration:none; text-align: center; background-color: #0053a6; padding: 8px;">Activate Account</a>';
                $sent = SendMessage("Greenstore Sign Up", $_POST['email'], "Greenstore", $body, $con);
                if ($sent) {
                    echo '<div class="alert alert-success" style="width: 100%">Sign up successfull. Confirm your email address with the activation link sent to your email. Check junk/spam folder too.</div>';
                    //echo '<script>window.location="index"</script>';
                }
            } else {
                echo '<div class="alert alert-danger" style="width: 100%">';
                foreach ($user->errormsg as $error) {
                    echo "<span>" . $error . "</span>";
                }
                echo '</div>';
            }
            break;

        case 'add_custom_delivery':
            $end = 0;
            for ($i = 1; $i <= 5; $i++) {
                if (!empty($_POST['stateid' . $i])) {
                    $sql = "insert into delivery_fee (stateid,amount,days,type) values (:state,:amount,:days,:type)";
                    $q = $con->insert_query($sql, array(':state' => $_POST['stateid' . $i], ':amount' => $_POST['amount' . $i], ':days' => $_POST['days' . $i], ':type' => $_POST['duration-type' . $i]));
                    $dsid = $con->lastID;
                    if (count($_POST['cityid' . $i]) > 0) {
                        foreach ($_POST['cityid' . $i] as $city) {
                            $sql = "insert into delivery_cities (dsid,cityid,days,type) values (:id,:city,:days,:type)";
                            $q = $con->insert_query($sql, array(':id' => $dsid, ':city' => $city, ':days' => $_POST['days' . $i], ':type' => $_POST['duration-type' . $i]));
                            $end += 1;
                        }
                    }
                }
            }
            if ($end > 0) {
                echo '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Delivery rules successfully added.
                            </div>';
            }
            echo '<script>window.location="delivery_settings"</script>';
            break;

        case 'checkout':
            //save order
            $sql = "delete from orders where cart_session_id=:id AND userid=:user";
            $q = $con->delete_query($sql, array(':id' => $_SESSION['cart_session_id'], ':user' => $_SESSION['user_id']));

            $ref = RandomString(5) . time();

            $order_type = DELIVERY_TYPE;
            $pickup_location = "";

            if (isset($_SESSION['order_type']) && $_SESSION['order_type'] == PICKUP_TYPE && isset($_SESSION['pickup_location'])) {
                $order_type = PICKUP_TYPE;
                $pickup_location = $_SESSION['pickup_location'];
            }
            $sql = "insert into orders (cart_session_id,userid,status,paymentstatus,transactionref,delivery_fee,orderdate,days,type,pickup_location) values (:cart,:user,:status,:pstatus,:ref,:dfee,:date,:days,:type,:location)";
            $fields = array(
                ':cart' => $_SESSION['cart_session_id'],
                ':user' => $_SESSION['user_id'],
                ':status' => ORDER_NOT_COMPLETED,
                ':pstatus' => NOT_PAID,
                ':ref' => $ref,
                ':dfee' => $_SESSION['delivery_fee'],
                ':date' => date('d-m-Y H:i a'),
                ':days' => $_POST['delivery_days'],
                ':type' => $order_type,
                ':location' => $pickup_location
            );
            $q = $con->insert_query($sql, $fields);

            if ($q) {
                $amount_kobo = $_SESSION['amount'] * 100;
                $callbackurl = APP_URL . "customer_area";

                paystack($_POST['customername'], $amount_kobo, $_SESSION['user_session'], $callbackurl, $ref);

                //flutterwave($_POST['customername'],$amount_kobo,$_SESSION['user_session'],$callbackurl,$_SESSION['cart_session_id']);
            }
            break;

        case 'menu_group_setup':
            $hasmenu = 0;
            if (isset($_POST['hasmenu']))
                $hasmenu = 1;
            $status = 0;
            if (isset($_POST['status'])) {
                $status = 1;
            }
            $sql = "insert into menugroup (Code,Text,Url,HasMenuItems,Icon,MenuGroupOrder,status) values (:code,:text,:url,:hasmenu,:icon,:order,:status)";
            $fields = array(
                ':code' => $_POST['code'],
                ':text' => $_POST['text'],
                ':url' => $_POST['url'],
                ':hasmenu' => $hasmenu,
                ':icon' => $_POST['icon'],
                ':order' => $_POST['order'],
                ':status' => $status
            );
            $q = $con->insert_query($sql, $fields);
            if ($q) {
                if (isset($_POST['savecontinue'])) {
                    echo '<div class="alert alert-success" id="msg">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> Menu group successfully added
                            </div>';
                } else if (isset($_POST['save'])) {
                    echo '<script>window.location="../admin/menu_group_list"</script>';
                }
            }
            break;

        case 'menu_item_setup':
            $hasmenu = 0;
            if (isset($_POST['hasmenu']))
                $hasmenu = 1;
            $status = 0;
            if (isset($_POST['status'])) {
                $status = 1;
            }
            $sql = "insert into menuitem (GroupCode,Code,Text,Url,HasMenuItems,TopMenuCode,MenuItemOrder,status) values (:grpcode,:code,:text,:url,:hasmenu,:topmenu,:order,:status)";
            $fields = array(
                ':grpcode' => $_SESSION['groupcode'],
                ':code' => $_POST['code'],
                ':text' => $_POST['text'],
                ':url' => $_POST['url'],
                ':hasmenu' => $hasmenu,
                ':topmenu' => $_POST['topmenu'],
                ':order' => $_POST['order'],
                ':status' => $status
            );
            $q = $con->insert_query($sql, $fields);
            if ($q) {
                if (isset($_POST['savecontinue'])) {
                    echo '<div class="alert alert-success" id="msg">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> Menu item successfully added
                            </div>';
                } else if (isset($_POST['save'])) {
                    echo '<script>window.location="../admin/menu_item_list?groupcode=' . $_SESSION['groupcode'] . '"</script>';
                }
            }
            break;

        case 'role_setup':
            $status = 0;
            if (isset($_POST['status'])) {
                $status = 1;
            }
            $sql = "select code from roles where code=:code";
            $field = array(':code' => $_POST['code']);
            $q = $con->select_query($sql, $field);
            if (count($q) > 0) {
                echo '<div class="alert alert-danger" id="msg">
                            <i class="fa fa-times-circle fa-fw fa-lg"></i>
                            <strong>Sorry</strong> Role code \'' . $_POST['code'] . '\' already in use</a>.
                            </div>';
            } else {
                $sql = "insert into roles (code,name,status) values (:code,:name,:status)";
                $fields = array(':code' => strtoupper($_POST['code']), ':name' => $_POST['name'], ':status' => $status);
                $q = $con->insert_query($sql, $fields);
                if ($q) {
                    if (isset($_POST['savecontinue'])) {
                        echo '<div class="alert alert-success" id="msg">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> Role successfully added
                            </div>';
                    } else if (isset($_POST['save'])) {
                        echo '<script>window.location="../admin/role_list"</script>';
                    }
                }
            }

            break;

        case 'authorize':
            $new = 0;
            $update = 0;
            $delete = 0;
            $view = 0;
            $authorize = 0;
            $isempty = false;
            $sql = "delete from roleauth where roleid=:roleid";
            $field = array(':roleid' => $_SESSION['roleid']);
            $q = $con->delete_query($sql, $field);


            for ($i = 0; $i < sizeof($_SESSION['menuitem']); $i++) {
                $isempty = false;
                $menucode = $_SESSION['menuitem'][$i];
                $groupcode = GetGroupCode($menucode, $con);
                if (!isset($_POST['new' . $menucode]) && !isset($_POST['update' . $menucode]) && !isset($_POST['delete' . $menucode]) && !isset($_POST['view' . $menucode]) && !isset($_POST['auth' . $menucode])) {
                    $isempty = true;
                } else {
                    if (isset($_POST['new' . $menucode])) {
                        $new = 1;
                    } else {
                        $new = 0;
                    }

                    if (isset($_POST['update' . $menucode])) {
                        $update = 1;
                    } else {
                        $update = 0;
                    }

                    if (isset($_POST['delete' . $menucode])) {
                        $delete = 1;
                    } else {
                        $delete = 0;
                    }

                    if (isset($_POST['view' . $menucode])) {
                        $view = 1;
                    } else {
                        $view = 0;
                    }

                    if (isset($_POST['auth' . $menucode])) {
                        $authorize = 1;
                    } else {
                        $authorize = 0;
                    }
                }
                $query = "select id from roleauth where roleid=:roleid AND groupcode=:gcode AND menucode=:mcode";
                $fields = array(
                    ':roleid' => $_SESSION['roleid'],
                    ':gcode' => $groupcode,
                    ':mcode' => $_SESSION['menuitem'][$i]
                );
                $mq = $con->select_query($query, $fields);
                $id = 0;
                if (count($mq) > 0) {
                    foreach ($mq as $r) {
                        $id = $r['id'];
                    }
                    $sql = "update roleauth set roleid = :role, groupcode = :group,
                    menucode = :menu, allow_new = :new, allow_update = :update,
                    allow_delete = :delete, allow_view = :view, allow_auth = :auth where id = :id";
                    $fields = array(
                        ':role' => $_SESSION['roleid'],
                        ':group' => $groupcode,
                        ':menu' => $_SESSION['menuitem'][$i],
                        ':new' => $new,
                        ':update' => $update,
                        ':delete' => $delete,
                        ':view' => $view,
                        ':auth' => $authorize,
                        ':id' => $id
                    );
                    $r = $con->update_query($sql, $fields);
                } else if (!$isempty) {
                    $sql = "Insert Into roleauth(roleid, groupcode, menucode, allow_new, allow_update, allow_delete, allow_view, allow_auth)
                          			  values (:role, :group, :menu, :new, :update, :delete, :view, :auth)";
                    $fields = array(
                        ':role' => $_SESSION['roleid'],
                        ':group' => $groupcode,
                        ':menu' => $_SESSION['menuitem'][$i],
                        ':new' => $new,
                        ':update' => $update,
                        ':delete' => $delete,
                        ':view' => $view,
                        ':auth' => $authorize
                    );
                    $r = $con->insert_query($sql, $fields);
                }
            }
            echo '<div class="alert alert-success" id="msg">
                        <i class="fa fa-check-circle fa-fw fa-lg"></i>
                        <strong>Well done!</strong> Role authorization saved successfully.
                                    </div>';
            //}
            break;
    }
}
