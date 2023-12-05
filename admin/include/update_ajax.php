<?php
session_start();
$menuid = "";
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
require_once '../lib/dbconfig.php';
if(isset($_POST['update']))
{
    switch ($_POST['update'])
    {   
        case 'category_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            $file_error = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            $show_home = 0;
            if(isset($_POST['show_home']))
            {
                $show_home = 1;
            }
            $show_menu = 0;
            if(isset($_POST['show_menu']))
            {
                $show_menu = 1;
            }
            if(!empty($_POST['name']) && !empty($_POST['code']) && !empty($_POST['type']))
            {
                if(!empty($_FILES['photo']['tmp_name']))
                {
                    $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= 204000;
                    if(!$isvalidsize)
                    {
                        $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Photo size cannot exceed 200kb.
                            </div>';
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        return;
                    }
                
                    $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    if(!(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0))
                    {
                        $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> Photo not in correct format (must be in jpg, png or gif)!
                            </div>';
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        return;
                    }
                }
                
                $sql = "update category set code=:code,name=:name,status=:status,type=:type,show_home=:show,show_menu=:show_menu,categoryorder=:order,description=:desc,icon=:icon where id=:id";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status, ':type'=>$_POST['type'], ':show'=>$show_home, ':show_menu'=>$show_menu,':order'=>$_POST['order'], ':desc'=>$_POST['description'],':icon'=>$_POST['icon'], ':id'=>$_POST['id']));
                if($q)
                {
                    $categoryid = $_POST['id'];
                    
                    //insert subcategories
                    if(!empty($_POST['subcatlist']))
                    {
                        $con->delete_query("delete from sub_categories where mastercategoryid=:id", array(':id'=>$categoryid));
                        $cats = explode(',', $_POST['subcatlist']);
                        foreach($cats as $cat)
                        {
                            $sql = "insert into sub_categories (mastercategoryid,subcategoryid) values (:master,:sub)";
                            $q=$con->insert_query($sql,array(':master'=>$categoryid, ':sub'=>$cat));
                        }
                    }
                    
                    //insert master categories
                    if(!empty($_POST['mastercatlist']) && $_POST['type'] == SUB_CATEGORY)
                    {
                        $con->delete_query("delete from sub_categories where subcategoryid=:id", array(':id'=>$categoryid));
                        $cats = explode(',', $_POST['mastercatlist']);
                        foreach($cats as $cat)
                        {
                            $sql = "insert into sub_categories (mastercategoryid,subcategoryid) values (:master,:sub)";
                            $q=$con->insert_query($sql,array(':master'=>$cat, ':sub'=>$categoryid));
                        }
                    }
                    else if(!empty($_POST['mastercatlist']) && $_POST['type'] == TOP_MENU_CATEGORY)
                    {
                        $con->delete_query("delete from sub_categories where mastercategoryid=:id", array(':id'=>$categoryid));
                        $cats = explode(',', $_POST['mastercatlist']);
                        foreach($cats as $cat)
                        {
                            $sql = "insert into sub_categories (mastercategoryid,subcategoryid) values (:master,:sub)";
                            $q=$con->insert_query($sql,array(':master'=>$categoryid, ':sub'=>$cat));
                        }
                    }
                    
                    //photo
                    if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                    {
                        $photo = "caegory_featured_img".$categoryid.'.jpg';
                        move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_FOLDER.$photo);
                        $sql = "update category set photo=:img where id=:id";
                        $con->update_query($sql,array(':img'=>$photo,':id'=>$categoryid));
                    }
                    else
                    {
                        $file_error = 2;
                    }
                    
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Category successfully saved.
                            </div>';
                    
                    if($file_error == 2 && empty($_POST['oldphoto']))
                    {
                        $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> No featured photo added!
                            </div>';
                    }
                    $success = 1;
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'colour_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            if(!empty($_POST['name']) && !empty($_POST['code']))
            {
                $sql = "update colour set code=:code,name=:name,status=:status where id=:id";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status, ':id'=>$_POST['id']));
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Colour successfully saved.
                            </div>';
                    $success = 1;
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'size_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            if(!empty($_POST['name']) && !empty($_POST['code']))
            {
                $sql = "update size set code=:code,name=:name,status=:status where id=:id";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status, ':id'=>$_POST['id']));
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Size successfully saved.
                            </div>';
                    $success = 1;
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'brand_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            $file_error = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            if(!empty($_POST['name']) && !empty($_POST['code']))
            {
                if(!empty($_FILES['photo']['tmp_name']))
                {
                    $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= MAX_FILE_SIZE;
                    if(!$isvalidsize)
                    {
                        $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Slider photo size cannot exceed 500kb.
                            </div>';
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        return;
                    }
                
                    $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    if(!(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "pdf") == 0))
                    {
                        $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> Photo not in correct format (must be in jpg, png or gif)!
                            </div>';
                        echo json_encode(array('success'=>$success,'msg'=>$msg));
                        return;
                    }
                }
                
                $sql = "update brand set code=:code,name=:name,status=:status where id=:id";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status, ':id'=>$_POST['id']));
                if($q)
                {
                    $brandid = $_POST['id'];
                    
                    if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                    {
                        $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                        if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0)
                        {
                            $phototitle = str_replace(" ","-",$_POST['code']);
                            $phototitle = str_replace("'", "", $phototitle);
                            $photo = $phototitle.$brandid.'.jpg';
                            move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_FOLDER.$photo);
                            $sql = "update brand set logo=:img where id=:id";
                            $con->update_query($sql,array(':img'=>$photo,':id'=>$brandid));
                        }
                        else
                        {
                            $file_error = 1;
                        }
                    }
                    else
                    {
                        $file_error = 2;
                    }
                    $msg .= '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Brand successfully saved.
                            </div>';
                    if($file_error == 2 && empty($_POST['oldphoto']))
                    {
                        $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> No brand logo added!
                            </div>';
                    }
                    $success = 1;
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'product_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            $file_error = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            $isonline = 0;
            if(isset($_POST['isonline']))
            {
                $isonline = 1;
            }
            $instock = 0;
            if(isset($_POST['instock']))
            {
                $instock = 1;
            }
            if(!empty($_POST['name']) && !empty($_POST['catlist']) && !empty($_POST['price']))
            {         
                $sql = "update product set name=:name,brandid=:brand,description=:desc,addinfo=:add,price=:price,oldprice=:oldprice,status=:status,
                    isonline=:online,instock=:stock,weight=:weight where id=:id";
                $fields = array(
                    ':name'=>$_POST['name'],
                    ':brand'=>$_POST['brand'],
                    ':desc'=>$_POST['description'],
                    ':add'=>$_POST['addinfo'],
                    ':price'=>$_POST['price'],
                    ':oldprice'=>$_POST['oldprice'],
                    ':status'=>$status,
                    ':online'=>$isonline,
                    ':stock'=>$instock,
                    ':weight'=>$_POST['weight'],
                    ':id'=>$_POST['id']
                );
                $q = $con->update_query($sql,$fields);
                if($q)
                {
                    $productid = $_POST['id'];
            
                    //insert categories
                    $con->delete_query("delete from product_categories where productid=:id", array(':id'=>$productid));
                    if(!empty($_POST['catlist']))
                    {
                        $cats = explode(',', $_POST['catlist']);
                        foreach($cats as $cat)
                        {
                            $sql = "insert into product_categories (productid,categoryid) values (:product,:cat)";
                            $q=$con->insert_query($sql,array(':product'=>$productid, ':cat'=>$cat));
                        }
                    }
            
                    //insert colours
                    $con->delete_query("delete from product_colours where productid=:id", array(':id'=>$productid));
                    if(!empty($_POST['colourlist']))
                    {
                        $colours = explode(',', $_POST['colourlist']);
                        foreach($colours as $colour)
                        {
                            $sql = "insert into product_colours (productid,colourid) values (:product,:colour)";
                            $q=$con->insert_query($sql,array(':product'=>$productid, ':colour'=>$colour));
                        }
                    }
            
                    //insert sizes
                    $con->delete_query("delete from product_sizes where productid=:id", array(':id'=>$productid));
                    if(!empty($_POST['sizelist']))
                    {
                        $sizes = explode(',', $_POST['sizelist']);
                        foreach($sizes as $size)
                        {
                            $sql = "insert into product_sizes (productid,sizeid) values (:product,:size)";
                            $q=$con->insert_query($sql,array(':product'=>$productid, ':size'=>$size));
                        }
                    }
                    
                    //insert prices
                    $con->delete_query("delete from product_prices where productid=:id", array(':id'=>$productid));
                    if($_POST['count'] > 0)
                    {
                        $end = $_POST['count'];
                        for($i = 1; $i <= $end; $i++)
                        {
                            if(!empty($_POST['pricecolour'.$i]) && !empty($_POST['productprice'.$i]))
                            {
                                $sql ="insert into product_prices (colourid,productid,price) values (:colour, :pid,:price)";
                                $con->insert_query($sql,array(':colour'=>$_POST['pricecolour'.$i], ':pid'=>$productid, ':price'=>$_POST['productprice'.$i]));
                            }
                        }
                    }
            
                    //insert photos
                    $file_error = 2;  //empty
                    for($i = 1; $i <= MAX_PRODUCT_PHOTO; $i++)
                    {
                        if(isset($_POST['oldphoto'.$i]) && !empty($_POST['oldphoto'.$i]))
                        {
                            $file_error = 0;
                        }
                        if(isset($_FILES['photo'.$i]['name']) && !empty($_FILES['photo'.$i]['name']))
                        {
                            $ext=pathinfo($_FILES['photo'.$i]['name'], PATHINFO_EXTENSION);
                            if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "pdf") == 0)
                            {
                                $photoname = "product".$i.$productid.'.jpg';
                                move_uploaded_file($_FILES['photo'.$i]['tmp_name'], UPLOADS_FOLDER.$photoname);
                                $sql = "insert into product_photos (productid,photo) values(:id,:img)";
                                $con->update_query($sql,array(':id'=>$productid,':img'=>$photoname));
                                $file_error = 0;
                            }
                            else
                            {
                                $file_error = 1;
                            }
                        }
                   }
                   
            
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                        <strong>Well done!</strong> Product successfully saved.
                        </div>';
                        if($file_error == 1)
                        {
                            $msg .= '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Warning!</strong> All photos not in correct format (must be in jpg, png or gif)!
                            </div>';
                        }
                        if($file_error == 2)
                                    {
                                    $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                        <strong>Warning!</strong> No product photo added!
                                </div>';
                        }
                        $success = 1;
                }
            }
            else
            {
                 $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'slider_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            $file_error = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            
            $showbutton = 0;
            if(isset($_POST['showbutton']))
            {
                $showbutton = 1;
            }
            if(!empty($_FILES['photo']['name']))
            {
                $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= MAX_FILE_SIZE;
                if(!$isvalidsize)
                {
                    $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Slider photo size cannot exceed 500kb.
                            </div>';
                    return;
                }
            }
            if(isset($_POST['showbutton']) && empty($_POST['buttontext']))
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
                echo json_encode(array('success'=>$success,'msg'=>$msg));
                return;
            }
            if(!empty($_POST['title'])&& !empty($_POST['slideorder']))
            {
                $sql = "update slider set smalltagline=:small,bigtagline=:big,url=:url,status=:status,phototitle=:title,showbutton=:showb,
                    buttontext=:text,slideorder=:order where id=:id";
                $fields = array(
                    ':small'=>$_POST['smalltagline'],
                    ':big'=>$_POST['bigtagline'],
                    ':url'=>$_POST['url'],
                    ':status'=>$status,
                    ':title'=>$_POST['title'],
                    ':showb'=>$showbutton,
                    ':text'=>$_POST['buttontext'],
                    ':order'=>$_POST['slideorder'],
                    ':id'=>$_POST['id']
                );
                $q = $con->insert_query($sql,$fields);
                if($q)
                {
                    $slideid = $_POST['id'];
            
                    if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                    {
                        $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                        if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "pdf") == 0)
                        {
                            $phototitle = str_replace(" ","-",$_POST['title']);
                            $phototitle = str_replace("'", "", $phototitle);
                            $photo = $phototitle.$slideid.'.jpg';
                            move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_FOLDER.$photo);
                            $sql = "update slider set photo=:img where id=:id";
                            $con->update_query($sql,array(':img'=>$photo,':id'=>$slideid));
                        }
                        else
                        {
                            $file_error = 1;
                        }
                    }
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Slide successfully saved.
                            </div>';
                    
                    if($file_error == 1)
                    {
                        $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> Photo not in correct format (must be in jpg, png or gif)!
                            </div>';
                    }
                    $success = 1;
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'banner_setup':
            $success = 0;
            $msg = "";
            $status = 0;
            $file_error = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            
            $category = "";
            if(isset($_POST['category']))
            {
                $category = $_POST['category'];
            }
            
            $showbutton = 0;
            if(isset($_POST['showbutton']))
            {
                $showbutton = 1;
            }
            if(!empty($_FILES['photo']['name']))
            {
                $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= MAX_FILE_SIZE;
                if(!$isvalidsize)
                {
                    $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Slider photo size cannot exceed 500kb.
                            </div>';
                    return;
                }
            }
            if(isset($_POST['showbutton']) && empty($_POST['buttontext']))
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
                echo json_encode(array('success'=>$success,'msg'=>$msg));
                return;
            }
            if(!empty($_POST['position']) && !empty($_POST['size']) && !empty($_POST['bannerorder']))
            {
                 $sql = "update banner set title=:title,position=:pos,size=:size,showbutton=:showb,buttontext=:text,
                     url=:url,bannerorder=:order,status=:status,phototitle=:ptitle,category=:cat where id=:id";
                $fields = array(
                    ':title'=>$_POST['title'],
                    ':pos'=>$_POST['position'],
                    ':size'=>$_POST['size'],
                    ':showb'=>$showbutton,
                    ':text'=>$_POST['buttontext'],
                    ':url'=>$_POST['url'],
                    ':order'=>$_POST['bannerorder'],
                    ':status'=>$status,
                    ':ptitle'=>$_POST['phototitle'],
                    ':cat'=>$category,
                    ':id'=>$_POST['id']
                );
                $q = $con->update_query($sql,$fields);
                if($q)
                {
                    $bannerid = $_POST['id'];
            
                    if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                    {
                        $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                        if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "pdf") == 0)
                        {
                            $phototitle = str_replace(" ","-",$_POST['title']);
                            $phototitle = str_replace("'", "", $phototitle);
                            $photo = $phototitle.$bannerid.'.jpg';
                            move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_FOLDER.$photo);
                            $sql = "update banner set photo=:img where id=:id";
                            $con->update_query($sql,array(':img'=>$photo,':id'=>$bannerid));
                        }
                        else
                        {
                            $file_error = 1;
                        }
                    }
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Banner successfully saved.
                            </div>';
            
                    if($file_error == 1)
                    {
                        $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> Photo not in correct format (must be in jpg, png or gif)!
                            </div>';
                    }
                    $success = 1;
                }
            }
            else
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'change_password':
            $success = 0;
            $msg = "";
            $status = 0;
            if(isset($_POST['status']))
            {
                $status = 1;
            }
            if($_POST['newpassword'] == $_POST['repassword'])
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
                            $msg .= '<div class="alert alert-success" id="msg">
                            <i class="fa fa-check-circle fa-fw fa-lg"></i>
                            <strong>Well done!</strong> password updated successfully.
                            </div>';
                            $success = 1;
                        }
                    }
                    else
                    {
                        $msg .= '<div class="alert alert-danger" id="msg">
                                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                        <strong>Sorry</strong> Invalid old password</a>.
                                        </div>';
                    }
                }
            
            }
            else
            {
                $msg .= '<div class="alert alert-danger" id="msg">
                                        <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                        <strong>Sorry</strong> Passwords do not match</a>.
                                        </div>';
            }
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
            case 'user_setup':
                $status=0;
                $success = 0;
                $msg = "";
                if(isset($_POST['status']))
                {
                    $status=1;
                }
            
                if($_POST['email'] != "")
                {
                    $reg = $user->updateUser($_SESSION['userid'], $_POST['email'], $status, "admin", $_POST['firstname'], $_POST['lastname']);
                    if($reg)
                    {
                        //insert roles
                        $con->delete_query("delete from user_roles where userid=:id", array(':id'=>$_SESSION['userid']));
                        if(!empty($_POST['rolelist']))
                        {
                            $roles = explode(',', $_POST['rolelist']);
                            foreach($roles as $role)
                            {
                                $sql = "insert into user_roles (userid,roleid) values (:user,:role)";
                                $q=$con->insert_query($sql,array(':user'=>$_SESSION['userid'], ':role'=>$role));
                            }
                        }
                        
                        $success = 1;  //success
                    }
                    else
                    {
                        foreach($user->errormsg as $error)
                        {
                            $msg .=$error.'.';
                        }
                        $success = 4;
                    }
                }
                else
                {
                    $success = 3;  //empty required fields
                }
                echo json_encode(array('success'=>$success,'msg'=>$msg));
                break;
                
            case 'delivery_staff_setup':
                $success = 0;
                $msg = "";
                $status = 0;
                if(isset($_POST['status']))
                {
                    $status = 1;
                }
                if(!empty($_POST['name']))
                {
                    $sql = "update delivery_staff set name=:name,status=:status where id=:id";
                    $q = $con->insert_query($sql, array(':name'=>$_POST['name'], ':status'=>$status, ':id'=>$_POST['id']));
                    if($q)
                    {
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Delivery staff successfully saved.
                            </div>';
                        $success = 1;
                    }
                }
                else
                {
                    $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
                }
                echo json_encode(array('success'=>$success,'msg'=>$msg));
                break;
                
            case 'location_setup':
                $success = 0;
                $msg = "";
                $status = 0;
                if(isset($_POST['status']))
                {
                    $status = 1;
                }
                if(!empty($_POST['desc']) && !empty($_POST['code']))
                {
                    $sql = "update location set code=:code,description=:desc,status=:status where id=:id";
                    $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':desc'=>$_POST['desc'], ':status'=>$status, ':id'=>$_POST['id']));
                    if($q)
                    {
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Location successfully saved.
                            </div>';
                        $success = 1;
                    }
                }
                else
                {
                    $msg = '<div class="alert alert-danger mb-2" role="alert">
                            <strong>Error!</strong> Enter required fields.
                        </div>';
                }
                echo json_encode(array('success'=>$success,'msg'=>$msg));
                break;
    }
}
?>