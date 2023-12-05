<?php 
session_start();
$title = "Restaurant Settings";
$menuid = "trestaurant";
$group = "settings";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$duration = 0;
$pickup_time = 0;
 
$sql = "select * from restaurant_settings order by id DESC limit 1";
$q = $con->select_query($sql);
    foreach ($q as $r)
    {
        $duration = $r['duration'];
        $pickup_time = $r['pickup_time'];
    }
?>

<script>

function SaveInsert()
{
	var datastring = $("#settingsform").serialize();
	
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
	            data: datastring,
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
                              Restaurant Settings
                          </header>
                          <div class="panel-body">
                              <form class="form" action="restaurant_settings" method="post" id="settingsform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>                                                        
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Customer Order to be Delivered Within (Mins)</label>
                                                            <input type="number" id="duration" class="form-control" value="<?php echo round($standard_delivery_fee,2)?>" name="duration">                                                            
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Customer Can Pickup Order After (Mins)</label>
                                                            <input type="number" id="pickup_time" class="form-control" value="<?php echo $standard_delivery_days?>" name="pickup_time">                                                               
                                                       </div>                                                        
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <input type="hidden" name="insert" value="restaurant_settings"/>                                               
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