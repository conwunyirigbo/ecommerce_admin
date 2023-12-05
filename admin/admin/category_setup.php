<?php 
session_start();
$title = "Category";
$menuid = "tcategory";
$group = "tcategory";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$code = "";
$name = "";
$status = "";
$type = "";
$show_home = "";
$show_menu = "";
$order = "";
$icon = "";
$photo = "";
$desc = "";
if(isset($_GET['id']))
{
    $sql = "select * from category where id=:id";
    $q = $con->select_query($sql, array(':id'=>$_GET['id']));
    foreach ($q as $r)
    {
        $name = $r['name'];
        $code = $r['code'];
        $status = $r['status'];
        $type = $r['type'];
        $show_home = $r['show_home'];
        $show_menu = $r['show_menu'];
        $order = $r['categoryorder'];
        $icon = $r['icon'];
        $photo = $r['photo'];
        $desc = $r['description'];
    }
}
?>

<script>

function SaveInsert()
{
	$('html,body').animate({ scrollTop: 0 }, 'fast');
	$('#msg').html('<img src="img/loading.gif"/>');
	
	$('#subcatlist').val($('#subcats').val());
	$('#mastercatlist').val($('#mastercats').val());

	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }   
    
	var datastring = $("#categoryform").serializeArray();
	$.each(datastring,function(key,input){
        data.append(input.name,input.value);
    });	
	$.ajax({
	            type: "POST",
	            url: "../include/insert_ajax.php",
	            contentType: false,
                processData: false,
	            data: data,
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
	$('html,body').animate({ scrollTop: 0 }, 'fast');
	$('#msg').html('<img src="img/loading.gif"/>');
	$('#subcatlist').val($('#subcats').val());
	$('#mastercatlist').val($('#mastercats').val());

	var fileUpload = $("#photo").get(0);
    var files = fileUpload.files;
    var data = new FormData();
    for (var i = 0; i < files.length ; i++) {
        data.append('photo',files[i],files[i].name);
    }   
    
	var datastring = $("#categoryform").serializeArray();
	$.each(datastring,function(key,input){
        data.append(input.name,input.value);
    });		
	$.ajax({
	            type: "POST",
	            url: "../include/update_ajax.php",
	            contentType: false,
                processData: false,
	            data: data,
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

$(document).ready(function(){
	$('#ctype').change(function(){
		var type = $('#ctype').val();
		if(type == "<?php echo MASTER_CATEGORY?>")
		{
			$('#subcatsdiv').show();
			$('#mastercatsdiv').hide();
			
		}
		else if(type == "<?php echo SUB_CATEGORY?>" || type == "<?php echo TOP_MENU_CATEGORY?>")
		{
			$('#mastercatsdiv').show();
			$('#subcatsdiv').hide();
		}
	});
});


function getCode()
{
	var code = $('#categoryname').val();
	var datastring = {'code' : code};
	$.ajax({
	            type: "GET",
	            url: "../admin/getcode.php",
	            data: datastring,
	            cache: false,
	            success: function(data) {
	                $('#categorycode').val(data);
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
                              Category Setup
                          </header>
                          <div class="panel-body">
                              <form class="form" action="category_setup" method="post" id="categoryform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>  
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Name</label>
                                                            <input type="text" id="categoryname" class="form-control" onblur="getCode()" value="<?php echo $name?>" name="name">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">URL Code</label>
                                                            <input type="text" id="categorycode" class="form-control" value="<?php echo $code?>" name="code">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Category Type</label>
                                                            <select name="type" id="ctype" class="form-control">
                                                                <option value="">--select type--</option>
                                                                <option value="<?php echo TOP_MENU_CATEGORY?>">Top Menu Category</option>
                                                                <option value="<?php echo MASTER_CATEGORY?>">Master Category</option>
                                                                <option value="<?php echo SUB_CATEGORY?>">Sub Category</option>
                                                            </select>
                                                            <?php 
                                                            if(!empty($type))
                                                            {
                                                                echo '<script>document.getElementById("ctype").value="'.$type.'"</script>';
                                                            }
                                                            ?>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Icon</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $icon?>" name="icon">
                                                            <span style="font-size: 12px;">Find icons <a href="https://themify.me/themify-icons" target="_blank">here</a></span>
                                                        </div>
                                                        
                                                        <?php 
                                                        $display = "none";
                                                        if($type == MASTER_CATEGORY)
                                                        {
                                                            $display = "block";
                                                        }
                                                        ?>
                                                        
                                                        <div class="form-group" id="subcatsdiv" style="display: <?php echo $display?>">
                                                            <label for="projectinput1">Select Sub-categories</label>
                                                            <input type="hidden" id="subcatlist" name="subcatlist"/>
                                                            <select data-placeholder="select sub-categories" class="chosen-select form-control" multiple name="subcats" id="subcats" tabindex="4">
                                                                <?php 
                                                                    $sql = "select id,name from category where status=1 AND type=:sub";
                                                                    $q=$con->select_query($sql, array(':sub'=>SUB_CATEGORY));
                                                                    foreach($q as $r)
                                                                    {
                                                                        $selected = "";
                                                                        if(isset($_GET['id']) && $_GET['id'] != "")
                                                                        {
                                                                            $sql = "select id from sub_categories where mastercategoryid=:mid AND subcategoryid=:sid";
                                                                            $a = $con->select_query($sql,array(':mid'=>$_GET['id'],':sid'=>$r['id']));
                                                                            if(count($a) > 0)
                                                                                $selected = "selected";
                                                                        }
                                                                        echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <?php 
                                                        $display = "none";
                                                        if($type == SUB_CATEGORY || $type == TOP_MENU_CATEGORY)
                                                        {
                                                            $display = "block";
                                                        }
                                                        ?>
                                                        <div class="form-group" id="mastercatsdiv" style="display: <?php echo $display?>">
                                                            <label for="projectinput1">Select Master (Parent) categories</label>
                                                            <input type="hidden" id="mastercatlist" name="mastercatlist"/>
                                                            <select data-placeholder="select master-categories" class="chosen-select form-control" multiple name="mastercats" id="mastercats" tabindex="4">
                                                                <?php 
                                                                    $sql = "select id,name from category where status=1 AND type=:master";
                                                                    $q=$con->select_query($sql, array(':master'=>MASTER_CATEGORY));
                                                                    foreach($q as $r)
                                                                    {
                                                                        $selected = "";
                                                                        if(isset($_GET['id']) && $_GET['id'] != "")
                                                                        {
                                                                            if($type == SUB_CATEGORY)
                                                                            {
                                                                                $sql = "select id from sub_categories where mastercategoryid=:mid AND subcategoryid=:sid";
                                                                                $a = $con->select_query($sql,array(':mid'=>$r['id'],':sid'=>$_GET['id']));
                                                                            }
                                                                            else if($type == TOP_MENU_CATEGORY)
                                                                            {
                                                                                $sql = "select id from sub_categories where mastercategoryid=:mid AND subcategoryid=:sid";
                                                                                $a = $con->select_query($sql,array(':mid'=>$_GET['id'],':sid'=>$r['id']));
                                                                            }
                                                                            if(count($a) > 0)
                                                                                $selected = "selected";
                                                                        }
                                                                        echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Order (on menu)</label>
                                                            <input type="number" class="form-control" value="<?php echo $order?>" name="order">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Description</label>
                                                            <textarea class="form-control" name="description"><?php echo $desc?></textarea>
                                                            <span style="font-size: 12px;">Category Description shows for restuarant menu only.</span>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Menu Featured Photo</label>
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
                                                                        <h5>Max Size: <strong class="text-danger">200kb</strong></h5>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks" id="show_home" name="show_home" <?php echo $show_home == 1 ? "checked" : ""?>/>
                                                                <label for="input-11">Show on Home Page</label>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks" id="show_menu" name="show_menu" <?php echo $show_menu == 1 ? "checked" : ""?>/>
                                                                <label for="input-11">Show on Menu</label>
                                                            </fieldset>
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
                                                <input type="hidden" name="update" value="category_setup"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="category_setup"/>                                               
                                                <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="category_list" class="btn btn-warning mr-1">
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