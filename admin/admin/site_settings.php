<?php 
session_start();
$title = "General Site Settings";
$menuid = "tgeneral";
$group = "settings";
include('header.php');

if(!$authupdate)
{
    echo '<script>window.location="index"</script>';
}

$no_home_products = 8;
$no_shop_products = 9;
$banner_list_style = DIFFERENT_SIZED_GRID_STYLE;
$logo = DEFAULT_LOGO;
$home_display_style = GRID_PRODUCT_DISPLAY;
$show_top_sales = "";
$no_top = "";
 
$sql = "select * from site_settings order by id DESC limit 1";
    $q = $con->select_query($sql);
    foreach ($q as $r)
    {
        $no_home_products = $r['no_home_products'];
        $no_shop_products = $r['no_shop_products'];
        $banner_list_style = $r['banner_list_style'];
        $logo = $r['logo'];
        $home_display_style = $r['home_display_style'];
        $show_top_sales = $r['show_top'];
        $no_top = $r['no_top'];
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

    $('#qcatlist').val($('#qcats').val());
    $('#pcatlist').val($('#pcats').val());
    
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

<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              General Site Settings
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
                                                            <label for="projectinput1">Number of Products on Home Page <br/><small class="text-warning">(New Products Category and other Categories each)</small></label>
                                                            <select name="no_home" id="no_home" class="form-control">
                                                                <option value="4">4</option>
                                                                <option value="8">8</option>
                                                                <option value="12">12</option>
                                                                <option value="16">16</option>
                                                                <option value="20">20</option>
                                                                <option value="24">24</option>
                                                                <option value="28">28</option>
                                                            </select> 
                                                            <script>document.getElementById('no_home').value="<?php echo $no_home_products?>"</script>
                                                            
                                                        </div>
                                                        <input type="hidden" name="banner_style" id="banner_style" value="<?php echo SAME_SIZED_GRID_STYLE?>"/>
                                                        <!-- <div class="form-group">
                                                            <label for="projectinput1">Home Banners List Style <br/><small class="text-warning">Under the slider</small></label>
                                                            <select name="banner_style" id="banner_style" class="form-control" onchange="checkBanner()">
                                                                <option value="<?php echo SAME_SIZED_GRID_STYLE?>">Same Sized Grid</option>
                                                                <option value="<?php echo DIFFERENT_SIZED_GRID_STYLE?>">Differently Sized Grid</option>                                                                
                                                            </select>
                                                            <strong id="samesizespan" style="display: none"><i>Please note: <span style="color: red">You must add at least 3 banners of thesame size (<?php echo SMALL_BANNER_SIZE?>). Add banners <a href="banner_list">here.</a></span></i></strong>
                                                            <strong id="diffsizespan" style="display: none"><i>Please note: <span style="color: red">You must add at least 6 banners of different sizes (<?php echo SMALL_BANNER_SIZE?> and <?php echo LONG_BANNER_SIZE?>). Add banners <a href="banner_list">here.</a></span></i></strong> 
                                                            <script>document.getElementById('banner_style').value="<?php echo $banner_list_style?>"</script>
                                                        </div> -->
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Number of Products in Shop <br/><small class="text-warning">(Per page)</small></label>
                                                            <select name="no_shop" id="no_shop" class="form-control">
                                                                <option value="8">8</option>
                                                                <option value="16">16</option>
                                                                <option value="20">20</option>
                                                                <option value="24">24</option>
                                                                <option value="28">28</option>
                                                                <option value="32">32</option>
                                                                <option value="36">36</option>
                                                                <option value="40">40</option>
                                                                <option value="44">44</option>
                                                                <option value="48">48</option>
                                                            </select> 
                                                            <script>document.getElementById('no_shop').value="<?php echo $no_shop_products?>"</script>
                                                            
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Home Product Display Style</label>
                                                            <select name="display_style" id="display_style" class="form-control">
                                                                <option value="<?php echo SLIDE_PRODUCT_DISPLAY?>">Slide</option>
                                                                <option value="<?php echo GRID_PRODUCT_DISPLAY?>">Grid</option>
                                                            </select> 
                                                            <script>document.getElementById('display_style').value="<?php echo $home_display_style?>"</script>
                                                        </div> 
                                                                                                               
                                                        <div class="form-group skin skin-square" id="topsellingdiv">
                                                            <fieldset>
                                                                <input type="checkbox" class="i-checks" id="show_top" name="show_top" <?php echo $show_top_sales == 1 ? "checked" : ""?>/> </label>
                                                                <label for="input-11">Show Top Selling Products on Home </label>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <?php 
                                                            $display = "none";
                                                            if($show_top_sales == 1)
                                                            {
                                                                $display = "block";
                                                            }
                                                        ?>
                                                        
                                                        <div class="form-group" id="maxtopdiv" style="display: <?php echo $display?>">
                                                            <label for="projectinput1">Max Number of Top Selling Products</label>
                                                            <input type="number" id="no_top" class="form-control" value="<?php echo $no_top?>" name="no_top">
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Quick Find Categories</label>
                                                            <input type="hidden" id="qcatlist" name="qcatlist"/>
                                                            <select data-placeholder="select categories" class="chosen-select form-control" multiple name="qcats" id="qcats" tabindex="4">
                                                                <?php 
                                                                    $sql = "select id,name from category where status=1 order by name";
                                                                    $q=$con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        $selected = "";
                                                                        $sql = "select id from quickfind where categoryid=:id";
                                                                            $a = $con->select_query($sql,array(':id'=>$r['id']));
                                                                            if(count($a) > 0)
                                                                                $selected = "selected";
                                                                        echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Popular Categories</label>
                                                            <input type="hidden" id="pcatlist" name="pcatlist"/>
                                                            <select data-placeholder="select categories" class="chosen-select form-control" multiple name="pcats" id="pcats" tabindex="4">
                                                                <?php 
                                                                    $sql = "select id,name from category where status=1 order by name";
                                                                    $q=$con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        $selected = "";
                                                                        $sql = "select id from popular where categoryid=:id";
                                                                            $a = $con->select_query($sql,array(':id'=>$r['id']));
                                                                            if(count($a) > 0)
                                                                                $selected = "selected";
                                                                        echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
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
                                                                        <h5>Max Size: <strong class="text-danger">500kb</strong></h5>
                                                        </div>
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <input type="hidden" name="insert" value="site_settings"/>                                               
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