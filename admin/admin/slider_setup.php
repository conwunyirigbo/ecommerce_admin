<?php 
session_start();
$title = "Slider Setup";
$menuid = "tslider";
$group = "settings";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}
$photo = "";
$smalltagline = "";
$bigtagline = "";
$url = "";
$title = "";
$status = "";
$showbutton = "";
$buttontext = "";
$slideorder="";
if(isset($_GET['id']))
{
    $sql = "select * from slider where id=:id";
    $q = $con->select_query($sql, array(':id'=>$_GET['id']));
    foreach ($q as $r)
    {
        $photo = $r['photo'];
        $smalltagline = $r['smalltagline'];
        $bigtagline = $r['bigtagline'];
        $url = $r['url'];
        $title = $r['phototitle'];
        $status = $r['status'];
        $showbutton = $r['showbutton'];
        $buttontext = $r['buttontext'];
        $slideorder = $r['slideorder'];
    }
}
?>

<script>
function SaveInsert()
{
	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }   
    
	var datastring = $("#sliderform").serializeArray();
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
	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }   
    
	var datastring = $("#sliderform").serializeArray();
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
	            	$.unblockUI();
	            	$('html,body').animate({ scrollTop: 0 }, 'fast');
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
                              Slider Setup
                          </header>
                          <div class="panel-body">
                              <form class="form" action="slider_setup" method="post" id="sliderform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Small Tag Line</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $smalltagline?>" name="smalltagline">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Big Tag Line</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $bigtagline?>" name="bigtagline">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">URL</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $url?>" name="url">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Photo</label>
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                          <div class="fileupload-new thumbnail" style="min-width: 250px; height:150px;">
                                                                          <?php 
                                                                          if(isset($_GET['id']))
                                                                          {
                                                                              echo '<img src="'.UPLOADS_FOLDER.$photo.'" alt="" />';
                                                                          }
                                                                          else 
                                                                          {
                                                                              echo '<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />';
                                                                          }
                                                                          ?>
                                                                          </div>
                                                                          <div class="fileupload-preview fileupload-exists thumbnail" style="height: 150px; line-height: 20px;"></div>
                                                                          <div>
                                                                           <span class="btn btn-white btn-file btn-xs">
                                                                           <span class="fileupload-new"><i class="icon-paper-clip"></i> Change</span>
                                                                           <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                           <input type="hidden" name="oldphoto" value="<?php echo $photo?>"/>
                                                                           <input type="file" id="photo" name="photo" class="default"/>
                                                                           </span>
                                                                              <a href="#" class="btn btn-danger fileupload-exists btn-xs" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                                                          </div>
                                                                        </div>
                                                                        <h5>Slider Dimension: <strong class="text-danger">1200 x 500px</strong></h5>
                                                                        <h5>Max Size: <strong class="text-danger">500kb</strong></h5>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Photo Title</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $title?>" name="title">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Slide Order</label>
                                                            <input type="number" id="slideorder" class="form-control" value="<?php echo $slideorder?>" name="slideorder">
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks"  id="status" name="status" <?php echo ($status==1 ? "checked" : "")?>/> </label>
                                                                <label for="input-11">Active</label>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square" id="checkbuttondiv">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks" onclick="checkButton()" id="showbutton" name="showbutton" <?php echo ($showbutton==1 ? "checked" : "")?>/> </label>
                                                                <label for="input-11">Show Call to Action Button</label>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <?php 
                                                        $display = "none";
                                                        if($showbutton == 1)
                                                        {
                                                            $display = "block";
                                                        }
                                                        ?>
                                                        <div class="form-group" id="buttontextdiv" style="display: <?php echo $display?>">
                                                            <label for="projectinput1">Button Text</label>
                                                            <input type="text" id="buttontext" class="form-control" value="<?php echo $buttontext?>" name="buttontext">
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <?php 
                                            if(isset($_GET['id']) && !empty($_GET['id']))
                                            {
                                            ?>
                                                <input type="hidden" name="update" value="slider_setup"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="slider_setup"/>                                               
                                                <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="slider_list" class="btn btn-warning mr-1">
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