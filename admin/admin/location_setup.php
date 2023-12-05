<?php 
session_start();
$title = "Location Setup";
$group = "tlocation";
$menuid = "tlocation";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$code = "";
$name = "";
$status = "";
if(isset($_GET['id']))
{
    $sql = "select * from location where id=:id";
    $q = $con->select_query($sql, array(':id'=>$_GET['id']));
    foreach ($q as $r)
    {
        $name = $r['description'];
        $code = $r['code'];
        $status = $r['status'];
    }
}
?>

<script>

function SaveInsert()
{
	$('#msg').html('<img src="img/loading.gif"/>');
	var datastring = $("#locationform").serialize();	
	$.ajax({
	            type: "POST",
	            url: "../include/insert_ajax.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	$('#msg').html(data.msg);
	            	if(data.success == 1)
	            	{
		            	$("input[type='text'], textarea, input[type='password']").val("");
	            	}
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
}

function SaveUpdate()
{
	$('#msg').html('<img src="img/loading.gif"/>');
	var datastring = $("#locationform").serialize();	
	$.ajax({
	            type: "POST",
	            url: "../include/update_ajax.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	$('#msg').html(data.msg);
	            },
	            error: function(){
	                alert('error handling here');
	            }
	        });
}
</script>

<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Location Setup
                          </header>
                          <div class="panel-body">
                              <form class="form" action="location_setup" method="post" id="locationform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Code</label>
                                                            <input type="text" class="form-control" value="<?php echo $code?>" name="code">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Description</label>
                                                            <textarea class="form-control" name="desc"><?php echo $name?></textarea>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <input type="checkbox" id="input-11" name="status" <?php echo $status == 1 ? "checked" : ""?>/>
                                                                <label for="input-11">Active</label>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <?php 
                                            if(isset($_GET['id']) && !empty($_GET['id']))
                                            {
                                            ?>
                                                <input type="hidden" name="update" value="location_setup"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="location_setup"/>                                               
                                                <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="location_list" class="btn btn-warning mr-1">
                                                    <i class="ft-x"></i> Cancel
                                                </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                          </div>
                      </section>

                  </div>
              </div>

<?php 
include('footer.php');
?>