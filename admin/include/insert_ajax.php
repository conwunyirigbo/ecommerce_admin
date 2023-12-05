<?php
session_start();
include('../include/connection.php');
include('../include/app_config.php');
include('../lib/app_stat.php');
require_once '../lib/dbconfig.php';

if(isset($_POST['insert']))
{
    switch ($_POST['insert'])
    {
        case 'category_setup':
            $success = 0;
            $msg = "";
            $file_error = 0;
            $status = 0;
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
                
                $sql = "insert into category (code,name,status,type,show_home,show_menu,categoryorder,description,icon,date_created) values (:code,:name,:status,:type,:show,:show_menu,:order,:desc,:icon,:date)";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status,':type'=>$_POST['type'],':show'=>$show_home,':show_menu'=>$show_menu,':order'=>$_POST['order'],':desc'=>$_POST['description'],':icon'=>$_POST['icon'],':date'=>date('d-m-Y H:i A')));
                if($q)
                {
                    $categoryid = $con->lastID;
                    
                    //insert subcategories
                    if(!empty($_POST['subcatlist']))
                    {
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
                        $cats = explode(',', $_POST['mastercatlist']);
                        foreach($cats as $cat)
                        {
                            $sql = "insert into sub_categories (mastercategoryid,subcategoryid) values (:master,:sub)";
                            $q=$con->insert_query($sql,array(':master'=>$cat, ':sub'=>$categoryid));
                        }
                    }
                    else if(!empty($_POST['mastercatlist']) && $_POST['type'] == TOP_MENU_CATEGORY)
                    {
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
                                <strong>Well done!</strong> Category successfully added.
                            </div>';
                    
                    if($file_error == 2)
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
                $sql = "insert into colour (code,name,status,date_created) values (:code,:name,:status,:date)";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status,':date'=>date('d-m-Y H:i A')));
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Colour successfully added.
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
                $sql = "insert into size (code,name,status,date_created) values (:code,:name,:status,:date)";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status,':date'=>date('d-m-Y H:i A')));
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Size successfully added.
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
                    $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= 204000;
                    if(!$isvalidsize)
                    {
                        $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Brand logo size cannot exceed 200kb.
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
                $sql = "insert into brand (code,name,status,date_created) values (:code,:name,:status,:date)";
                $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':name'=>$_POST['name'], ':status'=>$status,':date'=>date('d-m-Y H:i A')));
                if($q)
                {
                    $brandid = $con->lastID;
                    
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
                                <strong>Well done!</strong> Brand successfully added.
                            </div>';
                    
                    if($file_error == 2)
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
            $file_error_big = 0;
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
                $max_serial = 1;
                $sql = "select MAX(sn) as max_serial from product";
                $q = $con->select_query($sql);
                foreach($q as $r)
                {
                    $max_serial = $r['max_serial'] + 1;
                }
                
                $sql = "insert into product (sn,name,brandid,description,addinfo,price,oldprice,status,isonline,instock,weight,date_created)
                    values (:sn,:name,:brand,:desc,:add,:price,:oldprice,:status,:online,:stock,:weight,:date)";
                $fields = array(
                    ':sn'=>$max_serial,
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
                    ':date'=>date('d-m-Y H:i A')
                );
                $q = $con->insert_query($sql,$fields);
                if($q)
                {
                    $productid = $con->lastID;
                    
                    //insert categories
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
                    if(!empty($_POST['sizelist']))
                    {
                        $sizes = explode(',', $_POST['sizelist']);
                        foreach($sizes as $size)
                        {
                            $sql = "insert into product_sizes (productid,sizeid) values (:product,:size)";
                            $con->insert_query($sql,array(':product'=>$productid, ':size'=>$size));
                        }
                    }
                    
                    //insert prices
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
                        if(isset($_FILES['photo'.$i]['name']) && !empty($_FILES['photo'.$i]['name']))
                        {
                            $isvalidsize = filesize($_FILES['photo'.$i]['tmp_name']) <= MAX_FILE_SIZE;
                            if(!$isvalidsize)
                            {
                                $file_error_big += 1; //size is big
                            }
                            else 
                            {
                                $ext=pathinfo($_FILES['photo'.$i]['name'], PATHINFO_EXTENSION);
                                if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "pdf") == 0)
                                {
                                    $photoname = "product".$i.$productid.'.jpg';
                                    move_uploaded_file($_FILES['photo'.$i]['tmp_name'], UPLOADS_FOLDER.$photoname);
                                    $sql = "insert into product_photos (productid,photo) values(:id,:img)";
                                    $con->insert_query($sql,array(':id'=>$productid,':img'=>$photoname));
                                    $file_error = 0;
                                }
                                else
                                {
                                    $file_error = 1;
                                }
                            }
                        }
                    }
                    
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Product successfully added.
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
                    if($file_error_big > 0)
                    {
                        $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Photo size cannot exceed 500kb. Large photos not uploaded!
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
            if(empty($_FILES['photo']['name']))
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Please select slide photo for upload.
                            </div>';
                echo json_encode(array('success'=>$success,'msg'=>$msg));
                return;
            }
            else 
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
                $sql = "insert into slider (smalltagline,bigtagline,url,status,phototitle,showbutton,buttontext,slideorder,date_created) values 
                    (:small,:big,:url,:status,:title,:showb,:text,:order,:date)";
                $fields = array(
                    ':small'=>$_POST['smalltagline'],
                    ':big'=>$_POST['bigtagline'],
                    ':url'=>$_POST['url'],
                    ':status'=>$status,
                    ':title'=>$_POST['title'],
                    ':showb'=>$showbutton,
                    ':text'=>$_POST['buttontext'],
                    ':order'=>$_POST['slideorder'],
                    ':date'=>date('d-m-Y H:i A')
                );
                $q = $con->insert_query($sql,$fields);
                if($q)
                {
                    $slideid = $con->lastID;            
                    
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
                    else
                    {
                        $file_error = 2;
                    }
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Slide successfully added.
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
            
        case 'site_settings':
            $success = 0;
            $msg = "";
            $show_top = 0;
            $file_error = 0;
            if(isset($_POST['show_top']))
            {
                $show_top = 1;
            }
            if(!empty($_FILES['photo']['name']))
            {
                $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= MAX_FILE_SIZE;
                if(!$isvalidsize)
                {
                    $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Logo size cannot exceed 500kb.
                            </div>';
                    return;
                }
            }
            $con->delete_query("delete from site_settings",array());
            $sql = "insert into site_settings (no_home_products,banner_list_style,no_shop_products,home_display_style,show_top,no_top)
                values (:no_home,:banner_style,:no_shop,:home_display,:show_top,:no_top)";
            $fields = array(
                ':no_home'=>$_POST['no_home'],
                ':banner_style'=>$_POST['banner_style'],
                ':no_shop'=>$_POST['no_shop'],
                ':home_display'=>$_POST['display_style'],
                ':show_top'=>$show_top,
                ':no_top'=>$_POST['no_top']
            );
            
            $q = $con->insert_query($sql,$fields);
            if($q)
            {
                $id = $con->lastID;
                $photo = $_POST['oldphoto'];
                
                if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                {
                    $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0)
                    {
                        $photo = LOGO_NAME.$id.'.jpg';
                        move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_FOLDER.$photo);                        
                    }
                    else
                    {
                        $file_error = 1;
                    }
                }
                $sql = "update site_settings set logo=:img where id=:id";
                $q = $con->update_query($sql,array(':img'=>$photo,':id'=>$id));
                
                //insert quickfind
                if(!empty($_POST['qcatlist']))
                {
                    $con->delete_query("delete from quickfind");
                    $cats = explode(',', $_POST['qcatlist']);
                    foreach($cats as $cat)
                    {
                        $sql = "insert into quickfind (categoryid) values (:cat)";
                        $q=$con->insert_query($sql,array(':cat'=>$cat));
                    }
                }
                
                //insert popular categories
                
                if(!empty($_POST['pcatlist']))
                {
                    $con->delete_query("delete from popular");
                    $cats = explode(',', $_POST['pcatlist']);
                    foreach($cats as $cat)
                    {
                        $sql = "insert into popular (categoryid) values (:cat)";
                        $q=$con->insert_query($sql,array(':cat'=>$cat));
                    }
                }
               
                
                $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Settings successfully saved.
                            </div>';
                if($file_error == 1)
                {
                    $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> Logo not in correct format (must be in jpg, png or gif)!
                            </div>';
                }
                $success = 1;
            }
            
            
            
            echo json_encode(array('success'=>$success,'msg'=>$msg));
            break;
            
        case 'site_content':
            $success = 0;
            $msg = "";
            $file_error = 0;
            if(!empty($_FILES['photo']['name']))
            {
                $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= MAX_FILE_SIZE;
                if(!$isvalidsize)
                {
                    $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> About photo size cannot exceed 500kb.
                            </div>';
                    echo json_encode(array('success'=>$success,'msg'=>$msg));
                    return;
                }
                
                $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                if(!(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "pdf") == 0))
                {
                    $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> Photo not in correct format (must be in jpg, png or gif)!
                            </div>';
                    echo json_encode(array('success'=>$success,'msg'=>$msg));
                    return;
                }
            }
            
            $con->delete_query("delete from site_content",array());
            
            $sql = "insert into site_content (toptext,facebook,instagram,pin_interest,youtube,twitter,about,phone,email,address) values
                (:top,:fbook,:ins,:pini,:youtube,:twitter,:about,:phone,:email,:addr)";
            $fields = array(
                ':top'=>$_POST['toptext'],
                ':fbook'=>$_POST['facebook'],
                ':ins'=>$_POST['instagram'],
                ':pini'=>$_POST['pini'],
                ':youtube'=>$_POST['youtube'],
                ':twitter'=>$_POST['twitter'],
                ':about'=>$_POST['about'],
                ':phone'=>$_POST['phone'],
                ':email'=>$_POST['email'],
                ':addr'=>$_POST['address']
            );
            $q = $con->insert_query($sql,$fields);
            if($q)
            {
                $id = $con->lastID;
                $photo = $_POST['oldphoto'];
            
                if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                {
                    $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0)
                    {
                        $photo = ABOUT_PHOTO.$id.'.jpg';
                        move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_FOLDER.$photo);
                    }
                    else
                    {
                        $file_error = 1;
                    }
                }
                $sql = "update site_content set about_photo=:img where id=:id";
                $con->update_query($sql,array(':img'=>$photo,':id'=>$id));
                 
            
                $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Site content settings successfully saved.
                            </div>';
                if($file_error == 1)
                {
                    $msg .= '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Warning!</strong> Photo not in correct format (must be in jpg, png or gif)!
                            </div>';
                }
                $success = 1;
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
            if(empty($_FILES['photo']['name']))
            {
                $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Please select banner photo for upload.
                            </div>';
                return;
            }
            else
            {
                $isvalidsize = filesize($_FILES['photo']['tmp_name']) <= MAX_FILE_SIZE;
                if(!$isvalidsize)
                {
                    $msg = '<div class="alert alert-danger mb-2" role="alert">
                                <strong>Error!</strong> Banner photo size cannot exceed 500kb.
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
                $sql = "insert into banner (title,position,size,showbutton,buttontext,url,bannerorder,status,phototitle,category,date_created) values
                    (:title,:pos,:size,:showb,:text,:url,:order,:status,:ptitle,:cat,:date)";
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
                    ':date'=>date('d-m-Y H:i A')
                );
                $q = $con->insert_query($sql,$fields);
                if($q)
                {
                    $bannerid = $con->lastID;
            
                    if(isset($_FILES['photo']) && !empty($_FILES['photo']))
                    {
                        $ext=pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                        if(strcasecmp($ext, "jpeg") == 0 || strcasecmp($ext, "jpg") == 0 || strcasecmp($ext, "png") == 0 || strcasecmp($ext, "pdf") == 0)
                        {
                            $phototitle = str_replace(" ","-",$_POST['phototitle']);
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
                    else
                    {
                        $file_error = 2;
                    }
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Banner successfully added.
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
            
        case 'delivery_settings':
            $success = 0;
            $msg = "";
            $sql = "delete from delivery_fee where stateid=0 AND cityid=0";
            $con->delete_query($sql);
            
            $sql = "insert into delivery_fee (stateid,cityid,amount,days,weight_discount,type,threshold_amount) values (0,0,:amount,:days,:wd,:type,:tamount)";
            $q = $con->insert_query($sql,array(':amount'=>$_POST['standard_fee'],':days'=>$_POST['standard_days'],':wd'=>$_POST['weight_discount'],':type'=>$_POST['duration-type'],':tamount'=>$_POST['threshold_amount']));
            if($q)
            {
                $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> standard delivery settings saved successfully.
                            </div>';
                $success = 1;
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
                $sql = "select id from users where email=:email";
                $q=$con->select_query($sql,array(':email'=>$_POST['email']));
                if(count($q) > 0)
                {
                    $success = 2;  //code exist
                    echo json_encode(array('success'=>$success));
                    return;
                }
            
                if($_POST['email'] != "" && $_POST['password'] != "" && $_POST['repassword'] != "")
                {
                    $reg = $user->register($_POST['email'], $_POST['password'], $_POST['repassword'], "", $status, "admin", $_POST['firstname'], $_POST['lastname']);
                    if($reg)
                    {
                        //insert roles
                        if(!empty($_POST['rolelist']))
                        {
                            $roles = explode(',', $_POST['rolelist']);
                            foreach($roles as $role)
                            {
                                $sql = "insert into user_roles (userid,roleid) values (:user,:role)";
                                $q=$con->insert_query($sql,array(':user'=>$user->lastuser, ':role'=>$role));
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
                    $sql = "insert into delivery_staff (name,status,date_created) values (:name,:status,:date)";
                    $q = $con->insert_query($sql, array(':name'=>$_POST['name'], ':status'=>$status,':date'=>date('d-m-Y H:i A')));
                    if($q)
                    {
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Delivery staff successfully added.
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
                    $sql = "insert into location (code,description,status,date_created) values (:code,:desc,:status,:date)";
                    $q = $con->insert_query($sql, array(':code'=>$_POST['code'], ':desc'=>$_POST['desc'], ':status'=>$status,':date'=>date('d-m-Y H:i A')));
                    if($q)
                    {
                        $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Location successfully added.
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
                
            case 'restaurant_settings':
                $success = 0;
                $msg = "";
                $sql = "delete from restaurant_settings";
                $con->delete_query($sql);
                
                $sql = "insert into restaurant_settings (duration,pickup_time) values (:dur,:time)";
                $q = $con->insert_query($sql,array(':dur'=>$_POST['duration'],':time'=>$_POST['pickup_time']));
                if($q)
                {
                    $msg = '<div class="alert alert-success mb-2" role="alert">
                                <strong>Well done!</strong> Restaurant settings saved successfully.
                            </div>';
                    $success = 1;
                }
                echo json_encode(array('success'=>$success,'msg'=>$msg));
                break;
    }
}
