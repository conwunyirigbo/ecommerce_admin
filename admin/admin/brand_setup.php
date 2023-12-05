<?php 
session_start();
$title = "Brand Setup";
$menuid = "tbrand";
$group = "tbrand";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}
    

$code = "";
$name = "";
$status = "";
$logo = "";
if(isset($_GET['id']))
{
    $sql = "select * from brand where id=:id";
    $q = $con->select_query($sql, array(':id'=>$_GET['id']));
    foreach ($q as $r)
    {
        $name = $r['name'];
        $code = $r['code'];
        $status = $r['status'];
        $logo = $r['logo'];
    }
}
?>

<script>

function SaveInsert()
{
	$('#msg').html('<img src="img/loading.gif"/>');

	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }   
    
	var datastring = $("#brandform").serializeArray();
	$.each(datastring,function(key,input){
        data.append(input.name,input.value);
    });

	$.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } });
    	
	$.ajax({
	            type: "POST",
	            url: "../include/insert_ajax.php",
	            contentType: false,
                processData: false,
	            data: data,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	$.unblockUI();
	            	$('html,body').animate({ scrollTop: 0 }, 'fast');
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

	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }   
    
	var datastring = $("#brandform").serializeArray();
	$.each(datastring,function(key,input){
        data.append(input.name,input.value);
    });

	$.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } });
	
		
	$.ajax({
	            type: "POST",
	            url: "../include/update_ajax.php",
	            contentType: false,
                processData: false,
	            data: data,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	$('html,body').animate({ scrollTop: 0 }, 'fast');
	            	$.unblockUI();
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
                              Brand Setup
                          </header>
                          <div class="panel-body">
                              <form class="form" action="brand_setup" method="post" id="brandform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Code</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $code?>" name="code">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Name</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $name?>" name="name">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Logo</label>
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                          <div class="fileupload-new thumbnail" style="min-width: 250px; height:150px;">
                                                                          <img src="<?php echo UPLOADS_FOLDER.$logo; ?>" alt="" />
                                                                          </div>
                                                                          <div class="fileupload-preview fileupload-exists thumbnail" style="height: 150px; line-height: 20px;"></div>
                                                                          <div>
                                                                           <span class="btn btn-white btn-file btn-xs">
                                                                           <span class="fileupload-new"><i class="icon-paper-clip"></i> Change</span>
                                                                           <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                           <input type="hidden" name="oldphoto" value="<?php echo $logo?>"/>
                                                                           <input type="file" id="photo" name="photo" class="default"/>
                                                                           </span>
                                                                              <a href="#" class="btn btn-danger fileupload-exists btn-xs" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                                                          </div>
                                                                        </div>
                                                                        <h5>Max Size: <strong class="text-danger">200kb</strong></h5>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks" id="input-11" name="status" <?php echo $status == 1 ? "checked" : ""?>/>
                                                                <label for="input-11">Active</label>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <?php 
                                            if(isset($_GET['id']) && !empty($_GET['id']))
                                            {
                                            ?>
                                                <input type="hidden" name="update" value="brand_setup"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="brand_setup"/>                                               
                                                <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="brand_list" class="btn btn-warning mr-1">
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