<?php 
session_start();
$title = "Delivery Settings";
$menuid = "tdelivery";
$group = "settings";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$standard_delivery_fee = 0;
$standard_delivery_days = 0;
$weight_discount = 0;
$type = "days";
$threshold_amount = 0;
 
$sql = "select * from delivery_fee where stateid=0 AND cityid=0 order by id DESC limit 1";
    $q = $con->select_query($sql);
    foreach ($q as $r)
    {
        $standard_delivery_fee = $r['amount'];
        $standard_delivery_days = $r['days'];
        $weight_discount = $r['weight_discount'];
        $type = $r['type'];
        $threshold_amount = $r['threshold_amount'];
    }
?>

<style>
<!--
.badge
{
	padding: 6px 12px;
	font-size: 14px;
}
.badge-info
{
	background: #0099ff;
}
-->
</style>

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

function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
	 	
	return xmlhttp;
}


function loadDeliveryRules(showloading) {
	if(showloading == 1)		
	document.getElementById('load').innerHTML='<img src="img/loading.gif"/>';
	var searchkey = document.getElementById('searchkey').value;
	
	var strURL="../load/load_delivery_rule.php?searchkey="+searchkey;

	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {				
					document.getElementById('load').innerHTML=req.responseText;				
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

$(document).ready(function(){
	loadDeliveryRules(1);
	$('.filter').change(function(){
		loadDeliveryRules(1);
	})
})



function Delete(id)
{
	if(confirm("Delete Order?"))
	{
    	var datastring = {'id':id,'delete':'delivery_settings'};
    	$.ajax({
    	            type: "POST",
    	            url: "../include/delete_ajax.php",
    	            data: datastring,
    	            dataType: 'json',
    	            cache: false,
    	            success: function(data) {
    	            	if(data.success == 1)
    	            	{       
    	            		loadDeliveryRules(0);    		
    	            		setTimeout(function() {
    	                        toastr.options = {
    	                            closeButton: true,
    	                            progressBar: true,
    	                            categoryClass: "toast-top-full-width",
    	                            showMethod: 'slideDown',
    	                            timeOut: 4000
    	                        };
    	                        toastr.success('category deleted successfully');
    	                        
    	                    }, 1300);
    	            	}
    	            	else
    	            	{
    	            		setTimeout(function() {
    	                        toastr.options = {
    	                            closeButton: true,
    	                            progressBar: true,
    	                            categoryClass: "toast-top-full-width",
    	                            showMethod: 'slideDown',
    	                            timeOut: 4000
    	                        };
    	                        toastr.error('Error');
    
    	                    }, 1300);
    	            	}
    	            },
    	            error: function(){
    	                  alert('error handling here');
    	            }
    	        });
	}
}

</script>

<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Delivery Fee Settings
                          </header>
                          <div class="panel-body">
                              <form class="form" action="delivery_settings" method="post" id="settingsform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Standard Delivery Fee</label>
                                                            <input type="number" id="standard_fee" class="form-control" value="<?php echo round($standard_delivery_fee,2)?>" name="standard_fee">
                                                            
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Standard Delivery Duration</label>
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <input type="number" id="standard_days" class="form-control" value="<?php echo $standard_delivery_days?>" name="standard_days">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" name="duration-type" id="duration-type">
                                                                         <option value="days">Days</option>
                                                                         <option value="hours">Hours</option>
                                                                    </select>
                                                                    <?php 
                                                                    if(!empty($type))
                                                                    {
                                                                        echo '<script>document.getElementById("duration-type").value = "'.$type.'"</script>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>  
                                                            <i class="text-danger">The standard will be used if there is no custom rule existing for a state/city (i.e. default delivery fee and duration).</i>
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Percentage Delivery Discount for Weighted Products</label>
                                                            <input type="number" id="percentage_Discount" class="form-control" value="<?php echo round($weight_discount,2)?>" name="weight_discount">
                                                            <i class="text-danger">This discount will be deducted from the delivery fee of each weighty product a customer buys.</i>
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <label for="projectinput1">Threshold Amount for Delivery</label>
                                                            <input type="number" id="threshold_amount" class="form-control" value="<?php echo round($threshold_amount,2)?>" name="threshold_amount">
                                                            <i class="text-danger">If total amount of goods a customer is about to buy is less than the threshold amount, the customer is advised to pickup or proceed with delivery fee.</i>     
                                                        </div> 
                                                        
                                                        
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <input type="hidden" name="insert" value="delivery_settings"/>                                               
                                                            <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row row-pad">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control filter" placeholder="search city, state" id="searchkey"/>
                                                    </div>
                                                    <div class="col-md-8 table-responsive">
                                                        <a href="add_custom_delivery" class="btn btn-success pull-right">Add Custom Delivery Rule</a>
                                                    </div>
                                                </div>
                                                
                                                <div class="row row-pad">
                                                    <div class="col-md-12 table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>State/Cities</th>
                                                                    <th>Delivery Duration</th>
                                                                    <th>Delivery Fee</th>
                                                                    <th colspan="2">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="load">
                                                                
                                                            </tbody>
                                                        </table>
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