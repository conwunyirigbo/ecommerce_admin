<?php 
session_start();
$title = "Site Content Settings";
$menuid = "tcontent";
$group = "settings";
include('header.php');

if(!$authupdate)
{
    echo '<script>window.location="index"</script>';
}

$toptext = "";
$facebook = "";
$instagram = "";
$pini = "";
$youtube = "";
$twitter = "";
$about = "";
$photo = "";
$phone = "";
$email = "";
$address = "";
 
$sql = "select * from site_content order by id DESC limit 1";
    $q = $con->select_query($sql);
    foreach ($q as $r)
    {
        $toptext = $r['toptext'];
        $facebook = $r['facebook'];
        $instagram = $r['instagram'];
        $pini = $r['pin_interest'];
        $youtube = $r['youtube'];
        $twitter = $r['twitter'];
        $about = $r['about'];
        $photo = $r['about_photo'];
        $phone = $r['phone'];
        $email = $r['email'];
        $address = $r['address'];
    }
?>

<script>

function SaveInsert()
{
	var ed = tinyMCE.get('about-alt');
	$('#abouttxt').val(ed.getContent());
	
	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }   
    
	var datastring = $("#settingsform").serializeArray();
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
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
}

function checkBanner()
{
	var style = $('#banner_style').val();
	if(style == "<?php echo SAME_SIZED_GRID_STYLE?>")
	{
		$('#samesizespan').show();
		$('#diffsizespan').hide();
	}
	else if(style == "<?php echo DIFFERENT_SIZED_GRID_STYLE?>")
	{
		$('#samesizespan').hide();
		$('#diffsizespan').show();
	}
}

$(document).ready(function(){
	checkBanner();
});
</script>

<script type="text/javascript" src="../tinymce/tinymce.min.js"></script>
<script type="text/javascript">
                     
                     
                        tinymce.init({
                            selector: ".editor",
                            theme: "modern",
                            plugins: [
                                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                "searchreplace wordcount visualblocks visualchars code fullscreen",
                                "insertdatetime media nonbreaking save table contextmenu directionality",
                                "emoticons template paste textcolor colorpicker textpattern imagetools"
                            ],
                            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                            toolbar2: "print preview media | forecolor backcolor emoticons",
                            image_advtab: true,
                            templates: [
                                {title: 'Test template 1', content: 'Test 1'},
                                {title: 'Test template 2', content: 'Test 2'}
                            ]
                        });
                        
                        </script>

<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Site Content Settings
                          </header>
                          <div class="panel-body">
                              <form class="form" action="site_settings" method="post" id="settingsform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Top Header Text</label>
                                                             <input type="text" id="toptext" class="form-control" value="<?php echo $toptext?>" name="toptext">
                                                        </div>
                                                        
                                                        <label>SOCIAL MEDIA URLs</label>
                                                        <hr/>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Facebook</label>
                                                             <input type="text" id="facebook" class="form-control" value="<?php echo $facebook?>" name="facebook">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Instagram</label>
                                                             <input type="text" id="instagram" class="form-control" value="<?php echo $instagram?>" name="instagram">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Pin Interest</label>
                                                             <input type="text" id="pini" class="form-control" value="<?php echo $pini?>" name="pini">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>Youtube</label>
                                                             <input type="text" id="youtube" class="form-control" value="<?php echo $youtube?>" name="youtube">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Twitter</label>
                                                             <input type="text" id="twitter" class="form-control" value="<?php echo $twitter?>" name="twitter">
                                                        </div>
                                                        
                                                        <hr/>
                                                        
                                                        <div class="form-group">
                                                            <label>About Us Text</label>
                                                            <input type="hidden" name="about" id="abouttxt"/>
                                                            <textarea style="min-height: 200px;" name="about-alt" id="about-alt" class="form-control editor"><?php echo $about?></textarea>
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">About Photo</label>
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                          <div class="fileupload-new thumbnail" style="min-width: 250px; height:150px;">
                                                                          <img src="<?php echo UPLOADS_FOLDER.$photo; ?>" alt="" />
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
                                                                        <h5>Max Size: <strong class="text-danger">500kb</strong></h5>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <textarea style="min-height: 150px;" name="address" class="form-control"><?php echo $address?></textarea>
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Phone Lines</label>
                                                             <input type="text" id="phone" class="form-control" value="<?php echo $phone?>" name="phone">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Email</label>
                                                             <input type="text" id="email" class="form-control" value="<?php echo $email?>" name="email">
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <input type="hidden" name="insert" value="site_content"/>                                               
                                                            <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
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