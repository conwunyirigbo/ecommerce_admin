<?php 
session_start();
$title = "Change Password";
$group = "security";
$menuid = "";
include('header.php');
?>

<script>
function SaveUpdate()
{
	$('#msg').html('<img src="img/loading.gif"/>');
	
	var datastring = $("#pwdform").serialize();

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
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	$('html,body').animate({ scrollTop: 0 }, 'fast');
	            	$.unblockUI();
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
</script>

<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Change Password
                          </header>
                          <div class="panel-body">
                              <form class="form" action="change_password" method="post" id="pwdform">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                        
                                                        <div class="row row-pad">
                                                            <div class="col-md-2">
                                                                <label for="code">Old Password</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="password" name="oldpassword" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row row-pad">
                                                            <div class="col-md-2">
                                                                <label for="code">New Password</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="password" name="newpassword" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row row-pad">
                                                            <div class="col-md-2">
                                                                <label for="code">Repeat Password</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="password" name="repassword" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="row row-pad">
                                                            <div class="col-md-2">
                                                                
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="hidden" name="update" value="change_password"/>
                                                                <input type="button" name="save" class="btn btn-info" value="Change" onclick="SaveUpdate()"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                               </div>
                                        </form>
                                   
                          </div>
                      </section>

                  </div>
              </div>

<?php include('footer.php');?>