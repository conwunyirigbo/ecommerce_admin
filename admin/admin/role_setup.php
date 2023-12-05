<?php 
session_start();
$group="security";
$menu="";
$menuid="role";
$submenu="";

$title="Role Setup";
include('../admin/header.php'); 

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$status="";
$name="";
$code="";
$readonly="";
if(isset($_POST['roleid']))
{
    $_SESSION['roleid']=$_POST['roleid'];

   $sql="select * from roles where id=:id";
   $value=array(':id'=>$_SESSION['roleid']);
   $r=$con->select_query($sql,$value);
   foreach($r as $value)
   { 
       $status=$value['status'];
       $code=$value['code'];
       $name=$value['name'];
       $readonly="readonly";
       $_SESSION['isEdit']=true;  
   }
}
?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
            <header class="panel-heading">
                             Role Setup
                   </header>
            <div class="panel-body">
            <form method="post" action="role_setup">
            <div class="row row-pad">
                <div class="col-lg-12">
                    <?php 
                    if($_SESSION['isEdit']==true){
                        include('../include/update.php');
                    } else {
                        include('../include/insert.php');
                    }
                    ?>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="name">Code</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="code" class="form-control" value="<?php echo $code;?>" <?php echo $readonly;?>/>
                </div>
            </div>
            
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" value="<?php echo $name;?>" required/>
                </div>
            </div>
                      
            <div class="row row-pad">
                <div class="col-md-2">
                    
                </div>
                <div class="col-md-6">
                    <input type="checkbox" name="status" <?php echo ($status==1 ? "checked" : "")?>/> Active
                </div>
            </div>
           
            <div class="row row-pad">
                <div class="col-md-2">
                    
                </div>
                <div class="col-md-6">
                <?php 
                    if($_SESSION['isEdit']==true){
                        echo '
                        <input type="hidden" name="update" value="role_setup"/>
                        <input type="submit" name="save" class="btn btn-info" value="Save"/>';
                    } else {
                        echo '
                        <input type="hidden" name="insert" value="role_setup"/>
                        <input type="submit" name="save" class="btn btn-info" value="save"/>
                        <input type="submit" name="savecontinue" class="btn btn-info" value="Save and Continue"/>';
                    }
                ?>
                    <a href="role_list" class="btn btn-warning">Cancel</a>
                </div>
            </div>
            </form>
        </div>
        </section>
     </div>
  </div>
<?php include('../admin/footer.php'); ?>