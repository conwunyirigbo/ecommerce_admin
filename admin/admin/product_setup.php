<?php 
session_start();
$title = "Product Setup";
$menuid = "tproduct";
$group = "tproduct";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}
$description = "";
$name = "";
$status = "";
$addinfo = "";
$price = 0;
$oldprice = 0;
$isonline = "";
$instock = "";
$brand = "";
$weight = 0;
if(isset($_GET['id']))
{
    $sql = "select * from product where id=:id";
    $q = $con->select_query($sql, array(':id'=>$_GET['id']));
    foreach ($q as $r)
    {
        $name = $r['name'];
        $description = $r['description'];
        $addinfo = $r['addinfo'];
        $price = $r['price'];
        $oldprice = $r['oldprice'];
        $isonline = $r['isonline'];
        $instock = $r['instock'];
        $status = $r['status'];
        $brand = $r['brandid'];
        $weight = $r['weight'];
    }
}
?>

<script type="text/javascript" src="../tinymce/tinymce.min.js"></script>
<script type="text/javascript">
                     
                     
                        tinymce.init({
                            selector: "textarea",
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

<script>

function SaveInsert()
{
	//$('#msg').html('<img src="img/loading.gif"/>');	

	var ed = tinyMCE.get('desc-alt');
	$('#desctxt').val(ed.getContent());

	ed = tinyMCE.get('addinfo-alt');
	$('#addtxt').val(ed.getContent());

	var files;
	var data = new FormData();
	var fileUpload;
	for(var j=1; j<=<?php echo MAX_PRODUCT_PHOTO?>; j++)
	{
    	fileUpload = $("#photo"+j).get(0);           
        files = fileUpload.files;
        for (var i = 0; i < files.length; i++) {
            data.append('photo'+j,files[i],files[i].name);
        }
	}      

    $('#catlist').val($('#cats').val());
    $('#colourlist').val($('#colours').val());
    $('#sizelist').val($('#sizes').val());
    
	var datastring = $("#productform").serializeArray();
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
	var ed = tinyMCE.get('desc-alt');
	$('#desctxt').val(ed.getContent());

	ed = tinyMCE.get('addinfo-alt');
	$('#addtxt').val(ed.getContent());
	
	var files;
	var data = new FormData();
	var fileUpload;
	for(var j=1; j<=<?php echo MAX_PRODUCT_PHOTO?>; j++)
	{
    	fileUpload = $("#photo"+j).get(0);           
        files = fileUpload.files;
        for (var i = 0; i < files.length; i++) {
            data.append('photo'+j,files[i],files[i].name);
        }
	}      

    $('#catlist').val($('#cats').val());
    $('#colourlist').val($('#colours').val());
    $('#sizelist').val($('#sizes').val());
    
	var datastring = $("#productform").serializeArray();
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

function removePhoto(id,count)
{
		var datastring = {'id' : id, 'count' : count};
		$.ajax({
		            type: "GET",
		            url: "removephoto.php",
		            data: datastring,
		            dataType: 'html',
		            cache: false,
		            success: function(data) {
		                $('#photobox'+id).html(data)
		            },
		            error: function(){
		                  alert('error handling here');
		            }
		        });

}

function getProperty(property,container)
{
		var datastring = {'property' : property};
		$.ajax({
		            type: "GET",
		            url: "getproperty.php",
		            data: datastring,
		            dataType: 'html',
		            cache: false,
		            success: function(data) {
		                $('#'+container).html(data)
		            },
		            error: function(){
		                  alert('error handling here');
		            }
		        });

}
</script>

<script>

function addPrice()
{
	var count = $('#count').val();
	
		var datastring = {'count' : count};
		$.ajax({
		            type: "GET",
		            url: "addprice.php",
		            data: datastring,
		            dataType: 'json',
		            cache: false,
		            success: function(data) {
		            	$('#count').val(data.count)
		                $('#pricediv').append(data.text);
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
                              Product Setup
                          </header>
                          <div class="panel-body">
                              <form class="form" action="category_setup" method="post" id="productform" enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                                                                               
                                                        <div class="form-group">
                                                            <label for="projectinput1">Name</label>
                                                            <input type="text" id="projectinput1" class="form-control" value="<?php echo $name?>" name="name">
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Category</label>
                                                            <input type="hidden" id="catlist" name="catlist"/>
                                                            <select data-placeholder="select categories" class="chosen-select form-control" multiple name="cats" id="cats" tabindex="4">
                                                                <?php 
                                                                    $sql = "select id,name from category where status=1 order by name";
                                                                    $q=$con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        $selected = "";
                                                                        if(isset($_GET['id']) && $_GET['id'] != "")
                                                                        {
                                                                            $sql = "select id from product_categories where productid=:post AND categoryid=:id";
                                                                            $a = $con->select_query($sql,array(':post'=>$_GET['id'],':id'=>$r['id']));
                                                                            if(count($a) > 0)
                                                                                $selected = "selected";
                                                                        }
                                                                        echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Brand</label>
                                                            <select class="form-control" name="brand" id="brandid">
                                                                <option value="">--select brand--</option>
                                                                <?php 
                                                                    $sql = "select id,name from brand where status=1 order by name";
                                                                    $q=$con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                            <?php 
                                                            if(!empty($brand))
                                                            {
                                                                echo '<script>document.getElementById("brandid").value="'.$brand.'"</script>';
                                                            }
                                                            ?>
                                                        </div>
                                                        
                                                        
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Description</label>
                                                            <input type="hidden" name="description" id="desctxt"/>
                                                            <textarea class="form-control" style="min-height: 150px;" name="desc-alt" id="desc-alt"><?php echo $description?></textarea>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Additional Info</label>
                                                            <input type="hidden" name="addinfo" id="addtxt"/>
                                                            <textarea class="form-control" style="min-height: 150px;" name="addinfo-alt" id="addinfo-alt"><?php echo $addinfo?></textarea>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Colours</label>
                                                            <input type="hidden" id="colourlist" name="colourlist"/>
                                                            <select data-placeholder="select colours" class="chosen-select form-control" multiple name="colours" id="colours" tabindex="4" onclick="getProperty('colours','colours')">
                                                                <?php 
                                                                    $sql = "select id,name from colour where status=1";
                                                                    $q=$con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        $selected = "";
                                                                        if(isset($_GET['id']) && $_GET['id'] != "")
                                                                        {
                                                                            $sql = "select id from product_colours where productid=:post AND colourid=:id";
                                                                            $a = $con->select_query($sql,array(':post'=>$_GET['id'],':id'=>$r['id']));
                                                                            if(count($a) > 0)
                                                                                $selected = "selected";
                                                                        }
                                                                        echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Sizes</label>
                                                            <input type="hidden" id="sizelist" name="sizelist"/>
                                                            <select data-placeholder="select sizes" class="chosen-select form-control" multiple name="sizes" id="sizes" tabindex="4">
                                                                <?php 
                                                                    $sql = "select id,name from size where status=1";
                                                                    $q=$con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        $selected = "";
                                                                        if(isset($_GET['id']) && $_GET['id'] != "")
                                                                        {
                                                                            $sql = "select id from product_sizes where productid=:post AND sizeid=:id";
                                                                            $a = $con->select_query($sql,array(':post'=>$_GET['id'],':id'=>$r['id']));
                                                                            if(count($a) > 0)
                                                                                $selected = "selected";
                                                                        }
                                                                        echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Main (Regular) Price (NGN)</label>
                                                            <input type="number" class="form-control" value="<?php echo $price?>" name="price"/>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Old Price (NGN)</label>
                                                            <input type="number" class="form-control" value="<?php echo $oldprice?>" name="oldprice"/>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Weight (Kg)</label>
                                                            <input type="number" class="form-control" value="<?php echo $weight?>" name="weight"/>
                                                        </div>
                                                        
                                                        <hr/>
                                                        <div class="form-group skin skin-square">
                                                            <label for="projectinput1">Add Price</label>
                                                            <table class="table table-bordered table-hover">
                                                                <tbody id="pricediv">
                                                                    <?php 
                                                                        $end = 0;
                                                                        if(isset($_GET['id']))
                                                                        {
                                                                            $sql = "select * from product_prices where productid=:pid";
                                                                            $q = $con->select_query($sql,array(':pid'=>$_GET['id']));
                                                                            foreach($q as $r)
                                                                            {
                                                                                $end++;
                                                                                echo '<tr>
                                                                                <td>'.$end.'</td>
                                                                                    <td>
                                                                                        <select class="form-control" name="pricecolour'.$end.'">
                                                                                            <option value="">--Color--</option>';
                                                                                            
                                                                                            $sql = "select id,name from colour where status=1";
                                                                                            $q=$con->select_query($sql);
                                                                                            foreach($q as $d)
                                                                                            {
                                                                                                $selected = "";
                                                                                                if($r['colourid'] == $d['id'])
                                                                                                        $selected = "selected";
                                                                                                echo '<option value="'.$d['id'].'" '.$selected.'>'.$d['name'].'</option>';
                                                                                            }
                                                                                             
                                                                                            echo '</select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" class="form-control" name="productprice'.$end.'" placeholder="Price" value="'.$r['price'].'"/>
                                                                                    </td>
                                                                                </tr>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                         </div>
                                                         
                                                         <input type="hidden" id="count" name="count" value="<?php echo $end?>"/>
                                                         <a href="javascript:;" onclick="addPrice()" style="font-size: 14px; text-decoration:underline;">Add New Price</a>
                                                        <hr/>     
                                                             
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks"  id="status" name="status" <?php echo ($status==1 ? "checked" : "")?>/> </label>
                                                                <label for="input-11">Active</label>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks"  id="isonline" name="isonline" <?php echo ($isonline==1 ? "checked" : "")?>/> </label>
                                                                <label for="input-11">Push to Online Store</label>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks"  id="instock" name="instock" <?php echo ($instock==1 ? "checked" : "")?>/> </label>
                                                                <label for="input-11">Available (in stock)</label>
                                                            </fieldset>
                                                        </div>
                                                        <hr/>
                                                        <div class="form-group skin skin-square">
                                                            <fieldset>
                                                                <label for="projectinput1">Photos</label>
                                                                <h5>Photo Dimension: <strong class="text-danger">720 x 960px</strong></h5>
                                                                <h5>Max Size: <strong class="text-danger">500kb</strong></h5>
                                                                <div class="row">
                                                                <?php 
                                                                $end = 0;
                                                                if(isset($_GET['id']) && !empty($_GET['id']))
                                                                {
                                                                    $sql = "select id,photo from product_photos where productid=:id";
                                                                    $q = $con->select_query($sql,array(':id'=>$_GET['id']));
                                                                    
                                                                    foreach($q as $r)
                                                                    {
                                                                        $end++;
                                                                        
                                                                        if(strstr( $r['photo'], 'https'))
                                                                        {
                                                                            $pic = $r['photo'];
                                                                        }
                                                                        else
                                                                        {
                                                                            $pic = UPLOADS_FOLDER.$r['photo'];
                                                                        }
                                                                ?>
                                                                
                                                                    <div class="col-md-3" id="photobox<?php echo $r['id']?>">
                                                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                          <div class="fileupload-new thumbnail" style="min-width: 100%; height:150px;">
                                                                                <img src="<?php echo $pic?>" alt="" />
                                                                          </div>
                                                                          <div class="fileupload-preview fileupload-exists thumbnail" style="height: 150px; line-height: 20px;"></div>
                                                                          <div>
                                                                           <span class="btn btn-white btn-file btn-xs">
                                                                           <span class="fileupload-new"><i class="icon-paper-clip"></i> Change</span>
                                                                           <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                           <input type="hidden" name="oldphoto<?php echo $end?>" value="<?php echo $r['photo']?>"/>
                                                                           <input type="file" id="photo<?php echo $end?>" name="photo<?php echo $end?>" class="default" />
                                                                           </span>
                                                                              <a href="javascript:;" class="btn btn-danger fileupload-exists btn-xs" onclick="removePhoto(<?php echo $r['id']?>,<?php echo $end?>)" style="display: inline"><i class="icon-trash"></i> Remove</a>
                                                                          </div>
                                                                        </div>
                                                                    </div>
                                                                <?php 
                                                                
                                                                    }
                                                                }
                                                                $remaining = MAX_PRODUCT_PHOTO - $end;
                                                                
                                                                for($i=1; $i<=$remaining; $i++)
                                                                {
                                                                    $end ++;
                                                                ?>
                                                                    
                                                                    <div class="col-md-3">
                                                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                          <div class="fileupload-new thumbnail" style="min-width: 100%; height:150px;">
                                                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                                                          </div>
                                                                          <div class="fileupload-preview fileupload-exists thumbnail" style="height: 150px; line-height: 20px;"></div>
                                                                          <div>
                                                                           <span class="btn btn-white btn-file btn-xs">
                                                                           <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span>
                                                                           <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                           <input type="file" id="photo<?php echo $end?>" name="photo<?php echo $end?>" class="default" />
                                                                           </span>
                                                                              <a href="#" class="btn btn-danger fileupload-exists btn-xs" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                                                          </div>
                                                                        </div>
                                                                    </div>
                                                                <?php 
                                                                }
                                                                ?>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <?php 
                                            if(isset($_GET['id']) && !empty($_GET['id']))
                                            {
                                            ?>
                                                <input type="hidden" name="update" value="product_setup"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="product_setup"/>                                               
                                                <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="product_list" class="btn btn-warning mr-1">
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