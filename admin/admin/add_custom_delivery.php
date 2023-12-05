<?php 
session_start();
$title = "Custom Delivery Rules";
$menuid = "tdelivery";
$group = "settings";
include('header.php');

$code = "";
$name = "";
$status = "";
$type = "";
$show_home = "";
$show_menu = "";
$order = "";
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
    }
}
?>

<script language="javascript" type="text/javascript">
// Roshan's Ajax dropdown code with php
// This notice must stay intact for legal use
// Copyright reserved to Roshan Bhattarai - nepaliboy007@yahoo.com
// If you have any problem contact me at http://roshanbh.com.np
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
	
	function getCity(stateid,i) {		
		
		var strURL="getcity.php?stateid="+stateid+'&i='+i;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('citydiv'+i).innerHTML=req.responseText;
						$('#cityid'+i).chosen({width: "100%"});						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>

<script>

function SaveInsert()
{
	$('#msg').html('<img src="img/loading.gif"/>');
	$('#subcatlist').val($('#subcats').val());
	var datastring = $("#categoryform").serialize();	
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
	$('#subcatlist').val($('#subcats').val());
	var datastring = $("#categoryform").serialize();	
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

$(document).ready(function(){
	$('#ctype').change(function(){
		var type = $('#ctype').val();
		if(type == "<?php echo MASTER_CATEGORY?>")
		{
			$('#subcatsdiv').show();
		}
		else
		{
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
                              Delivery Fee Setup
                          </header>
                          <div class="panel-body">
                              <form class="form" action="add_custom_delivery" method="post" id="categoryform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <?php include('../include/insert.php');?>
                                                        </div> 
                                                        
                                                        <div class="form-group">
                                                            <strong><i class="text-danger">You can add atleast one custom delivery rule. Leave duration at 0 to use standard.</i></strong>
                                                        </div>  
                                                        
                                                        <div class="form-group">
                                                            <?php 
                                                                for($i = 1; $i<=5; $i++)
                                                                {
                                                            ?>
                                                                <div class="row" style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;">
                                                                    <div class="col-md-3">
                                                                        <label for="projectinput1">State <?php echo $i?></label>
                                                                        <select class="form-control" name="stateid<?php echo $i?>" id="stateid<?php echo $i?>" onchange="getCity(this.value, <?php echo $i?>)">
                                                                            <option value="">--select state--</option>
                                                                            <?php 
                                                                                $sql = "select id,name from state where status=1";
                                                                                $q=$con->select_query($sql);
                                                                                foreach($q as $r)
                                                                                {
                                                                                    $selected = "";
                                                                                    if(isset($_GET['id']) && $_GET['id'] != "")
                                                                                    {
                                                                                        $sql = "select id from delivery_fee where stateid=:state AND id=:id";
                                                                                        $a = $con->select_query($sql,array(':id'=>$_GET['id'],':state'=>$r['id']));
                                                                                        if(count($a) > 0)
                                                                                            $selected = "selected";
                                                                                    }
                                                                                    echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-3">
                                                                        <label for="projectinput1">Select Cities</label>
                                                                        <div id="citydiv<?php echo $i?>"><select data-placeholder="select city(ies)" class="chosen-select form-control" multiple name="cityid<?php echo $i?>[]" id="cityid<?php echo $i?>">
                                                                            <?php 
                                                                                $sql = "select id,name from state where stateid=:state AND status=1";
                                                                                $q=$con->select_query($sql, array(':state'=>$state));
                                                                                foreach($q as $r)
                                                                                {
                                                                                    $selected = "";
                                                                                    if(isset($_GET['id']) && $_GET['id'] != "")
                                                                                    {
                                                                                        $sql = "select id from delivery_fee where stateid=:state AND id=:id";
                                                                                        $a = $con->select_query($sql,array(':id'=>$_GET['id'],':state'=>$r['id']));
                                                                                        if(count($a) > 0)
                                                                                            $selected = "selected";
                                                                                    }
                                                                                    echo '<option value="'.$r['id'].'" '.$selected.'>'.$r['name'].'</option>';
                                                                                }
                                                                            ?>
                                                                        </select></div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">Amount</label>
                                                                            <input type="number" id="amount<?php echo $i?>" class="form-control" name="amount<?php echo $i?>"/>
                                                                        </div> 
                                                                    </div>
                                                                    
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">Duration</label>
                                                                            <input type="number" id="days<?php echo $i?>" class="form-control" name="days<?php echo $i?>"/>
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="projectinput1">Hours or Days</label>
                                                                            <select class="form-control" name="duration-type<?php echo $i?>" id="duration-type<?php echo $i?>">
                                                                                <option value="days">Days</option>
                                                                                <option value="hours">Hours</option>
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            <?php 
                                                                }
                                                            ?>
                                                            
                                                        </div>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <div class="form-group skin skin-square">
                                                            <?php 
                                            if(isset($_GET['id']) && !empty($_GET['id']))
                                            {
                                            ?>
                                                <input type="hidden" name="update" value="add_custom_delivery"/> 
                                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>                                               
                                                <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            else 
                                            {
                                            ?>
                                                <input type="hidden" name="insert" value="add_custom_delivery"/>                                               
                                                <button type="submit" class="btn btn-success">
                                                    <i class="la la-check-square-o"></i> Save
                                                </button>
                                            <?php 
                                            }
                                            ?>
                                                <a href="delivery_settings" class="btn btn-warning mr-1">
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