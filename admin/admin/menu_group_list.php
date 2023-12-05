<?php session_start();
$group="security";
$menu="";
$menuid="";
$submenu="";

$title="Menu Groups";
include('../admin/header.php'); 

$_SESSION['isEdit']=false;
?>
<script>
function confirmDelete()
{
	if(!confirm("Are you sure you want to delete this Menu Group?"))
	{
		return false;
	}
	return true;
}
</script>
    <div class="row">
        <div class="col-lg-12">
             <section class="panel">
                <header class="panel-heading">
                              Menu Groups
                   </header>
            <div class="panel-body">
                <div class="row row-pad">
                    <div class="col-md-12"><a class="btn btn-info pull-right" href="menu_group_setup">Add new</a></div>
                </div>
                <div class="row row-pad">
                    <div class="col-md-12" style="overflow: auto">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Code</th>
                                    <th>Text</th>
                                    <th>URL</th>
                                    <th>Has Menu Item?</th>
                                    <th>Status</th>
                                    <th>Icon</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql="select * from menugroup order by MenuGroupOrder";
                                    $r=$con->run_select_query($sql);
                                    
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
                                                <td style="font-size:12px;">'.$value['MenuGroupOrder'].'</td>
                                                <td>'.$value['Code'].'</td>
                                                <td>'.$value['Text'].'</td>
                                                <td>'.$value['Url'].'</td>
                                                <td>'.$hasmenu.'</td>
                                                <td>'.$status.'</td>
                                                <td>'.$value['Icon'].'</td>
                                                <td>
                                                    <a href="../admin/menu_item_list?groupcode='.$value['Code'].'" class="btn btn-info btn-xs">Menus</a>
                                                </td>
                                                <td>
                                                    <form method="post" action="../admin/menu_group_setup">
                                                        <input type="hidden" name="groupcode" value="'.$value['Code'].'"/>
                                                        <input type="submit" name="menu" value="Edit" class="btn btn-warning btn-xs"/>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="post" action="../admin/menu_group_list" onsubmit="return confirmDelete()">
                                                        <input type="hidden" name="groupcode" value="'.$value['Code'].'"/>
                                                        <input type="hidden" name="delete" value="deletemenugroup"/>
                                                        <input type="submit" name="group" value="Delete" class="btn btn-danger btn-xs"/>
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