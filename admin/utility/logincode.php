<?php

if($user->is_loggedin())
{
    if($_SESSION['user_role']==ADMIN_USER_KEY || $_SESSION['user_role']==SUPER_ADMIN_USER_KEY || $_SESSION['user_role']==ORDER_ADMIN_USER_KEY)
     {
         echo '<script>window.location="'.APP_URL.'admin/index"</script>';
     }
     else if($_SESSION['user_role']==USER_KEY || $_SESSION['user_role']==USER_KEY)
     {
         echo '<script>window.location="'.APP_URL.'customer_area"</script>';
     }
}

if(isset($_POST['login']))
{
 $umail = $_POST['username'];
 $upass = $_POST['password'];
  
 if($user->login($umail,$upass))
 {
     if($_SESSION['user_role']==ADMIN_USER_KEY || $_SESSION['user_role']==SUPER_ADMIN_USER_KEY) 
     {
         echo '<script>window.location="'.APP_URL.'admin/index"</script>';
     }
     else if($_SESSION['user_role']==USER_KEY || $_SESSION['user_role']==USER_KEY)
     {
         $url = 'customer_area';
         /*if(!empty($_POST['redirect']))
         {
            $url = APP_URL.$_POST['redirect'];
            if(!empty($_POST['action']))
            {
                $url.="?pid=".$_POST['pid']."&action=".$_POST['action'];
            } 
         }*/
         if(isset($_SESSION['redirect']) && !empty($_SESSION['redirect']))
         {
             $url = $_SESSION['redirect'];
         }
         
         echo '<script>window.location="'.$url.'"</script>';
     }
     /*else if($_SESSION['user_key']==CUSTOMER_USER_KEY)
     {
         //put log activity later (viewers will be able to view, delete log under security)
         echo '<script>window.location="'.CUSTOMER_LANDING_PAGE.'"</script>';
     }*/
     
 }
 else
 {
     foreach($user->errormsg as $error)
     {
         echo "<p class='text-danger'>".$error."</p>";
     }
 } 
}

if(isset($_POST['facebook']))
{
    require_once 'vendor/autoload.php';
    $facebook = new \Facebook\Facebook([
        'app_id'      => '598989440822177',
        'app_secret'     => 'b7bbf4bf91da310155b44bfa8b05b27a',
        'default_graph_version'  => 'v2.10'
    ]);
    
    $facebook_helper = $facebook->getRedirectLoginHelper();
    
    $access_token = $facebook_helper->getAccessToken();
    
    $facebook->setDefaultAccessToken($access_token);
    
    $graph_response = $facebook->get("/me?fields=name,email", $access_token);
    
    $facebook_user_info = $graph_response->getGraphUser();
    
    print_r($facebook_user_info);
}
if(isset($_POST['no_login']))
{
    $_SESSION['user_session'] = "Anon_".RandomString(6);
    
    $user->register($_SESSION['user_session'], $_SESSION['user_session'], $_SESSION['user_session'], "", 1, USER_KEY, "", "");
    $user->login($_SESSION['user_session'], $_SESSION['user_session']);
    $_SESSION['anon'] = 1;
    echo '<script>window.location="'.$_SESSION['redirect'].'"</script>';
}
?>