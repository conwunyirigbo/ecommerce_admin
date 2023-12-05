<?php
/*$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "sima";

try
{
     $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
     $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
     echo $e->getMessage();
}*/

include_once 'class.user.php';
$user = new USER($con);

include_once 'auth.class.php';
if(isset($_SESSION['user_id']) && isset($menuid))
{
    $auth = new authorize($con, $_SESSION['user_id']);

    $authview=$auth->HasView($menuid);
    $authupdate=$auth->HasUpdate($menuid);
    $authdelete=$auth->HasDelete($menuid);
    $authaddnew=$auth->HasAddNew($menuid);
    $authorize=$auth->HasAuth($menuid);


    $super_authorize = false;
    if($_SESSION['user_session'] == ADMIN_USERNAME || $_SESSION['user_session'] == "test_admin")
    {
        $authview=true;
        $authupdate=true;
        $authdelete=true;
        $authaddnew=true;
        $authorize=true;
        
        $super_authorize = true;
    }

}
?>
