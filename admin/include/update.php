<?php

if(isset($_POST['update']))
{
    switch ($_POST['update'])
    {            
        case 'customer':
            $sql = "select id from customer where userid=:id";
            $q = $con->select_query($sql,array(':id'=>$_SESSION['user_id']));
            if(count($q) > 0)
            {
                $sql = "update customer set shipping_address=:addr,cityid=:city,stateid=:state,phone1=:phone1,
                    phone2=:phone2,email=:email where userid=:id";
                $fields = array(
                    ':addr'=>$_POST['address'],
                    ':city'=>$_POST['cityid'],
                    ':state'=>$_POST['stateid'],
                    ':phone1'=>$_POST['phone1'],
                    ':phone2'=>$_POST['phone2'],
                    ':email'=>$_POST['email'],
                    ':id'=>$_SESSION['user_id']
                );
                $q = $con->update_query($sql,$fields);                
            }
            else 
            {
                $sql = "insert into customer (shipping_address,cityid,stateid,phone1,phone2,date_created,email,userid)
                    values (:addr,:city,:state,:phone1,:phone2,:date,:email,:id)";
                $fields = array(
                    ':addr'=>$_POST['address'],
                    ':city'=>$_POST['cityid'],
                    ':state'=>$_POST['stateid'],
                    ':phone1'=>$_POST['phone1'],
                    ':phone2'=>$_POST['phone2'],
                    ':date'=>date('d-m-Y H:i a'),
                    ':email'=>$_POST['email'],
                    ':id'=>$_SESSION['user_id']
                );
                $q = $con->insert_query($sql,$fields);
            }
            if($q)
            {
                $sql = "update users set firstname=:fname, lastname=:lname where id=:user";
                $con->update_query($sql,array(':fname'=>$_POST['firstname'],':lname'=>$_POST['lastname'],':user'=>$_SESSION['user_id']));
                
                $_SESSION['user_session'] = $_POST['email'];
                echo '<script>window.location="checkout"</script>';
            }
            break;
            
            
        case 'pickup_customer':
            $sql = "select id from customer where userid=:id";
            $q = $con->select_query($sql,array(':id'=>$_SESSION['user_id']));
            if(count($q) > 0)
            {
                $sql = "update customer set phone1=:phone1,
                    phone2=:phone2,email=:email where userid=:id";
                $fields = array(
                    ':phone1'=>$_POST['phone1'],
                    ':phone2'=>$_POST['phone2'],
                    ':email'=>$_POST['email'],
                    ':id'=>$_SESSION['user_id']
                );
                $q = $con->update_query($sql,$fields);
            }
            else
            {
                $sql = "insert into customer (phone1,phone2,date_created,email,userid)
                    values (:phone1,:phone2,:date,:email,:id)";
                $fields = array(
                    ':phone1'=>$_POST['phone1'],
                    ':phone2'=>$_POST['phone2'],
                    ':date'=>date('d-m-Y H:i a'),
                    ':email'=>$_POST['email'],
                    ':id'=>$_SESSION['user_id']
                );
                $q = $con->insert_query($sql,$fields);
            }
            if($q)
            {
                $sql = "update users set firstname=:fname, lastname=:lname where id=:user";
                $con->update_query($sql,array(':fname'=>$_POST['firstname'],':lname'=>$_POST['lastname'],':user'=>$_SESSION['user_id']));
            
                $_SESSION['user_session'] = $_POST['email'];
                $_SESSION['pickup_location'] = $_POST['pickup_location'];
                echo '<script>window.location="checkout"</script>';
            }
            break;
            
        case 'change_password':
            if($_POST['newpassword'] == $_POST['repeatpassword'])
            {
                $sql = "select email,pword from users where id=:id";
                $q = $con->select_query($sql,array(':id'=>$_SESSION['user_id']));
                foreach($q as $r)
                {
                    if(sha1($_POST['oldpassword']) == $r['pword'] || (password_verify($_POST['oldpassword'], $r['pword'])))
                    {
                        $reset = $user->ResetPassword($_POST['newpassword'], $r['email'], $con);
                        if($reset)
                        {
                            echo '<div class="alert alert-success">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> password updated successfully.
                            </div>';
                        }
                    }
                    else
                    {
                        echo '<div class="alert alert-danger">
                                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                        <strong>Sorry</strong> Invalid old password</a>.
                                        </div>';
                    }
                }
            
            }
            else
            {
                echo '<div class="alert alert-danger" id="msg">
                                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                        <strong>Sorry</strong> Passwords do not match</a>.
                                        </div>';
            }
            break;
            
            case 'menu_group_setup':
                $hasmenu=0;
                if(isset($_POST['hasmenu']))
                    $hasmenu=1;
                $status = 0;
                if(isset($_POST['status']))
                {
                    $status = 1;
                }
                $sql="update menugroup set Text=:text,Url=:url,HasMenuItems=:hasmenu,Icon=:icon,MenuGroupOrder=:order,status=:status where Code=:code";
                $fields=array(
                    ':text'=>$_POST['text'],
                    ':url'=>$_POST['url'],
                    ':hasmenu'=>$hasmenu,
                    ':icon'=>$_POST['icon'],
                    ':order'=>$_POST['order'],
                    ':status'=>$status,
                    ':code'=>$_POST['code']
                );
                $q=$con->insert_query($sql,$fields);
                if($q)
                {
                    echo '<script>window.location="../admin/menu_group_list"</script>';
                }
                break;
            
            case 'menu_item_setup':
                $hasmenu=0;
                if(isset($_POST['hasmenu']))
                    $hasmenu=1;
                $status = 0;
                if(isset($_POST['status']))
                {
                    $status = 1;
                }
                $sql="update menuitem set Text=:text,Url=:url,HasMenuItems=:hasmenu,TopMenuCode=:topmenu,MenuItemOrder=:order,status=:status where Code=:code";
                $fields=array(
                    ':text'=>$_POST['text'],
                    ':url'=>$_POST['url'],
                    ':hasmenu'=>$hasmenu,
                    ':topmenu'=>$_POST['topmenu'],
                    ':order'=>$_POST['order'],
                    ':status'=>$status,
                    ':code'=>$_POST['code']
                );
                $q=$con->insert_query($sql,$fields);
                if($q)
                {
                    echo '<script>window.location="../admin/menu_item_list?groupcode='.$_SESSION['groupcode'].'"</script>';
                }
                break;
            
            case 'role_setup':
                $status=0;
                if(isset($_POST['status']))
                {
                    $status=1;
                }
            
                $sql="update roles set name=:name, status=:stat where id=:id";
                $fields=array(
                    ':name'=>$_POST['name'],
                    ':stat'=>$status,
                    ':id'=>$_SESSION['roleid']
                );
                $q=$con->update_query($sql,$fields);
                if($q)
                {
                    echo '<script>window.location="../admin/role_list"</script>';
                }
                break;
            
            case 'change_password':
                if($_POST['newpassword'] == $_POST['repassword'])
                {
                    $sql = "select pword from users where userid=:id";
                    $q = $con->select_query($sql,array(':id'=>$_SESSION['user_id']));
                    foreach($q as $r)
                    {
                        if(password_verify($_POST['oldpassword'], $r['pword']))
                        {
                            $reset = $user->ResetPassword($_POST['newpassword'], $_SESSION['user_id'], $con);
                            if($reset)
                            {
                                echo '<div class="alert alert-success" id="msg">
                                                    <i class="fa fa-check-circle fa-fw fa-lg"></i>
                                                    <strong>Well done!</strong> password updated successfully.
                                                    </div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger" id="msg">
                                                <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                                <strong>Sorry</strong> Invalid password</a>.
                                                </div>';
                        }
                    }
            
                }
                else
                {
                    echo '<div class="alert alert-danger" id="msg">
                                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                        <strong>Sorry</strong> Passwords do not match</a>.
                                        </div>';
                }
                break;
    }
}
?>