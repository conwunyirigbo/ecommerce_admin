<?php session_start();
$group="security";
$menu="";
$menuid="";
$submenu="";

$title="Menu Items";
include('../admin/header.php'); 

$_SESSION['isEdit']=false;
if(isset($_GET['groupcode']))
{
    $_SESSION['groupcode']=$_GET['groupcode'];
}
else 
{
    echo '<script>window.location="menu_group_list"</script>';
}
?>
<script>
function confirmDelete()
{
	if(!confirm("Are you sure you want to delete this Menu Item?"))
	{
		return false;
	}
	return true;
}
</script>
    <div class="row row-pad">
        <div class="col-lg-12">
            <section class="panel">
            <header class="panel-heading">
                              Menu Items
                   </header>
          
            <div class="row row-pad">
                   <div class="col-md-12"><small><a href="../admin/menu_group_list">Menu Groups</a> <span class="icon-angle-right"> </span> <?php echo $_GET['groupcode']; ?></small></div>
            </div>
            <div class="panel-body">
                <div class="row row-pad">
                    <div class="col-md-12"><a class="btn btn-info pull-right" href="menu_item_setup">Add new</a></div>
                </div>
                <div class="row row-pad">
                    <div class="col-md-12" style="overflow: auto">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Menu Group</th>
                                    <th>Code</th>
                                    <th>Top Menu Code</th>
                                    <th>Text</th>
                                    <th>URL</th>
                                    <th>Has Menu Item?</th>
                                    <th>Status</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql="select * from menuitem where GroupCode=:code order by MenuItemOrder";
                                    $field=array(':code'=>$_SESSION['groupcode']);
                                    $r=$con->select_query($sql,$field);
                                    
                                    foreach($r as $value)
                                    {
                                        if($value['HasMenuItems']==1)
                                        {
                                            $hasmenu="<span class='active'>Yes</span>";
                                        }
                                        else
                                        {
                                            $hasmenu="<span class='inactive'>No</span>";
                                        }
                                        if($value['status']==1)
                                        {
                                            $status="<span class='label label-success'>Active</span>";
                                        }
                                        else
                                        {
                                            $status="<span class='label label-default'>Inactive</span>";
                                        }
                                        echo '<tr>
                                                <td style="font-size:12px;">'.$value['MenuItemOrder'].'</td>
                                                <td>'.$value['GroupCode'].'</td>
                                                <td>'.$value['Code'].'</td>
                                                <td>'.$value['TopMenuCode'].'</td>
                                                <td>'.$value['Text'].'</td>
                                                <td>'.$value['Url'].'</td>
                                                <td>'.$hasmenu.'</td>
                                                <td>'.$status.'</td>
                                                <td>
                                                    <a href="../admin/submenu_item_list?menucode='.$value['Code'].'" class="btn btn-info btn-xs">Menus</a>
                                                </td>
                                                <td>
                                                    <form method="post" action="../admin/menu_item_setup">
                                                        <input type="hidden" name="menucode" value="'.$value['Code'].'"/>
                                                        <input type="submit" name="menu" value="Edit" class="btn btn-warning btn-xs"/>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="post" action="../admin/menu_item_list" onsubmit="return confirmDelete()">
                                                        <input type="hidden" name="menucode" value="'.$value['Code'].'"/>
                                                        <input type="hidden" name="delete" value="deletemenuitem"/>
                                                        <input type="submit" name="menu" value="Delete" class="btn btn-danger btn-xs"/>
                                                    </form>
                                                </td>
                                            </tr>';
                                    } 

                                    include('../include/delete.php');
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </section>
        </div>
  </div>
<?php include('../admin/footer.php'); ?>