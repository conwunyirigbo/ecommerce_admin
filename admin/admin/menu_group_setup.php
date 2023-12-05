<?php 
session_start();
$group="security";
$menu="";
$menuid="";
$submenu="";

$title="Menu Group Setup";
include('../admin/header.php'); 

$code="";
$text="";
$url="";
$hasmenu="";
$icon="";
$order="";
$readonly="";
$status = 0;
if(!isset($_SESSION['isEdit']))
{
    $_SESSION['isEdit']=false;
}
if(isset($_POST['groupcode']))
{
    
   $readonly="readonly";
   $sql="select * from menugroup where Code=:code";
   $value=array(':code'=>$_POST['groupcode']);
   $r=$con->select_query($sql,$value);
   foreach($r as $value)
   {
       $_SESSION["groupcode"]=$_POST['groupcode'];
       $code=$value['Code'];
       $text=$value['Text'];
       $url=$value['Url'];
       $hasmenu=$value['HasMenuItems'];
       $order=$value['MenuGroupOrder'];
       $icon=$value['Icon'];
       $status = $value['status'];
       $_SESSION['isEdit']=true;
       
   }
}
?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                              Menu Group Setup
                   </header>
           <div class="panel-body">
            <form method="post" action="menu_group_setup">
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
                    <label for="code">Code</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="code" class="form-control" maxlength="20" value="<?php echo $code;?>" <?php echo $readonly; ?> required/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="name">Text</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="text" class="form-control" maxlength="255" required value="<?php echo $text;?>"/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="capacity">Icon</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="icon" class="form-control" value="<?php echo $icon;?>" required/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="capacity">URL</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="url" class="form-control" value="<?php echo $url;?>"/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    <label for="capacity">Menu Group Order</label>
                </div>
                <div class="col-md-6">
                    <input type="number" name="order" class="form-control" value="<?php echo $order;?>" required/>
                </div>
            </div>
            <div class="row row-pad">
                <div class="col-md-2">
                    
                </div>
                <div class="col-md-6">
                    <input type="checkbox" name="hasmenu" <?php echo ($hasmenu==1 ? "checked" : "")?>/> Has Menu Items
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
                        <input type="hidden" name="update" value="menu_group_setup"/>
                        <input type="submit" name="save" class="btn btn-info" value="Save"/>';

                    } else {
                        echo '
                        <input type="hidden" name="insert" value="menu_group_setup"/>
                        <input type="submit" name="save" class="btn btn-info" value="save"/>
                        <input type="submit" name="savecontinue" class="btn btn-info" value="Save and Continue"/>';

                    }
                ?>
                    <a href="menu_group_list.php" class="btn btn-warning">Cancel</a>
                </div>
            </div>
            </form>
        </div>
     </div>
  </div>
<?php include('../admin/footer.php'); ?>