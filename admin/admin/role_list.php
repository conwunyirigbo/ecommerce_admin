<?php session_start();
$group="security";
$menu="";
$title="Roles";
$menuid="role";
$submenu="";

include('../admin/header.php'); 
$_SESSION['isEdit']=false;
?>
<script>
function confirmDelete()
{
	if(!confirm("Are you sure you want to delete this Role?"))
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
                              Role Setup
                   </header>
            <div class="panel-body">
                <div class="row row-pad">
                    <div class="col-md-12">
                        <?php 
                        if($authaddnew)
                        {
                        ?>
                        <a class="btn btn-info pull-right" href="role_setup">Add new</a>
                       <?php 
                        }
                       ?> 
                    </div>
                </div>
                <div class="row row-pad">
                    <div class="col-md-12" style="overflow: auto">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql="select * from roles order by Code";
                                    $r=$con->run_select_query($sql);
                                    $sn=1;
                                    foreach($r as $value)
                                    {
                                        if($value['status']==1)
                                        {
                                            $status="<span class='active'>Active</span>";
                                        }
                                        else
                                        {
                                            $status="<span class='inactive'>Inactive</span>";
                                        }
                                       
                                        echo '<tr>
                                                <td style="font-size:12px;">'.$sn.'</td>
                                                <td>'.$value['code'].'</td>
                                                <td>'.$value['name'].'</td>
                                                <td>'.$status.'</td>
                                                <td>
                                                    <form method="post" action="../admin/role_setup">
                                                        <input type="hidden" name="roleid" value="'.$value['id'].'"/>
                                                        <input type="submit" name="role" value="Edit" class="btn btn-warning btn-xs"/>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="post" action="../admin/authorize">
                                                        <input type="hidden" name="roleid" value="'.$value['id'].'"/>
                                                        <input type="submit" name="role" value="Authorize" class="btn btn-success btn-xs"/>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method="post" action="../admin/role_list" onsubmit="return confirmDelete()">
                                                        <input type="hidden" name="roleid" value="'.$value['id'].'"/>
                                                        <input type="hidden" name="delete" value="deleterole"/>
                                                        <input type="submit" name="role" value="Delete" class="btn btn-danger btn-xs"/>
                                                    </form>
                                                </td>
                                            </tr>';
                                        $sn++;
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