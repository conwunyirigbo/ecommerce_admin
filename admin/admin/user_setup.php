<?php
session_start();
$group = "security";
$menuid = "tuser";
$title = "Admin User Setup";
include('header.php');

if(!$authupdate && !$authaddnew)
{
    echo '<script>window.location="index"</script>';
}

$status="";
$email="";
$role="";
$firstname = "";
$lastname = "";
if(isset($_POST['userid']))
{
    $_SESSION['userid']=$_POST['userid'];

    $sql="select * from users where id=:id";
    $value=array(':id'=>$_SESSION['userid']);
    $r=$con->select_query($sql,$value);
    foreach($r as $value)
    {
        $status=$value['is_active'];
        $email=$value['email'];
        $role = $value['role'];
        $firstname = $value['firstname'];
        $lastname = $value['lastname'];
        $_SESSION['isEdit']=true;
    }
}
?>


<script>

function SaveInsert()
{
	$('#msg').html('<img src="img/loading.gif"/>');
	 $('#rolelist').val($('#roles').val());
	var datastring = $("#userform").serialize();

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
	            	$('html,body').animate({ scrollTop: 0 }, 'fast');
	            	$.unblockUI();
	            	if(data.success == 1)
	            	{
	                    $('#msg').html('<div class="alert alert-success">User saved successfully</div>');
	                    $("input[type='text'], textarea, input[type='password'], input[type='number']").val("");
	            	}
	            	else if(data.success == 2)
	            	{
	            		$('#msg').html('<div class="alert alert-danger">Sorry, Email already exist</div>');
	            	}
	            	else if(data.success == 3)
	            	{
	            		$('#msg').html('<div class="alert alert-danger">Error, please enter required fields</div>');
	            	}
	            	else if(data.success == 4)
	            	{
	            		$('#msg').html('<div class="alert alert-danger">Passwords must match</div>');
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
$('#rolelist').val($('#roles').val());
	var datastring = $("#userform").serialize();

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
	            	if(data.success == 1)
	            	{
	                    $('#msg').html('<div class="alert alert-success">User saved successfully</div>');
	            	}
	            	else if(data.success == 2)
	            	{
	            		$('#msg').html('<div class="alert alert-danger">Sorry, Email already exist</div>');
	            	}
	            	else if(data.success == 3)
	            	{
	            		$('#msg').html('<div class="alert alert-danger">Error, please enter required fields</div>');
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
                              <form class="form" action="change_password" method="post" id="userform">
                                            <div class="form-body">
                                                
                                                <!-- <input type="hidden" name="role" value="<?php echo ADMIN_USER_KEY?>"/> -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div id="msg"></div>
                                                        </div>
                                                       
                                                       <div class="row row-pad">
                                                            <div class="col-md-2"><label for="name">Role</label></div>
                                                            <div class="col-md-6">
                                                                <input type="hidden" id="rolelist" name="rolelist"/>
                                                            <select data-placeholder="select categories" class="chosen-select form-control" multiple name="roles" id="roles" tabindex="4">
                                                                    <?php 
                                                                    $sql = "select id,name from roles where status=1";
                                                                    $q = $con->select_query($sql);
                                                                    foreach($q as $d)
                                                                    {
                                                                    ?>
                                                                    <option value="<?php echo $d['id']?>"><?php echo $d['name']?></option>
                                                                    <?php 
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <?php 
                                                                
                                                                if($role != "")
                                                                {
                                                                    
                                                                }
                                                                ?>
                                                                
                                                            </div>
                                                       </div> 
                                                        <div class="row row-pad">
                                    <div class="col-md-2">
                                        <label for="name">First Name</label>
                                    </div>
                                    <div class="col-md-6">
                                      <input type="text" class="form-control" name="firstname" value="<?php echo $firstname?>"/>
                                    </div>
                                </div>
                                
                                <div class="row row-pad">
                                    <div class="col-md-2">
                                        <label for="name">Last Name</label>
                                    </div>
                                    <div class="col-md-6">
                                      <input type="text" class="form-control" name="lastname" value="<?php echo $lastname?>"/>
                                    </div>
                                </div>
                                
                                
                                <div class="row row-pad">
                                    <div class="col-md-2">
                                        <label for="name">Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="email" class="form-control" value="<?php echo $email;?>" required/>
                                    </div>
                                </div>
                                
                                <?php 
                                    if(!isset($_SESSION['isEdit']) || $_SESSION['isEdit'] == false)
                                    {
                                ?>
                                <div class="row row-pad">
                                    <div class="col-md-2">
                                        <label for="name">Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" name="password" class="form-control" required/>
                                    </div>
                                </div>
                                
                                <div class="row row-pad">
                                    <div class="col-md-2">
                                        <label for="name">Re-enter Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" name="repassword" class="form-control" required/>
                                    </div>
                                </div>
                                
                                
                                  <?php }?>        
                                <div class="row row-pad">
                                    <div class="col-md-2">
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label> <input type="checkbox" class="i-checks"  id="status" name="status" <?php echo ($status==1 ? "checked" : "")?>/> Active </label>
                                    </div>
                                </div>
                               
                                <div class="row row-pad">
                                    <div class="col-md-2">
                                        
                                    </div>
                                    <div class="col-md-6">
                                    <?php 
                                        if(isset($_SESSION['isEdit']) && $_SESSION['isEdit']==true){
                                            echo '
                                            <input type="hidden" name="update" value="user_setup"/>
                                            <button type="button" onclick="SaveUpdate()" class="btn btn-success">Update User</button>';
                                        } else {
                                            echo '
                                            <input type="hidden" name="insert" value="user_setup"/>
                                            <button type="button" onclick="SaveInsert()" class="btn btn-success">Add User</button>';
                                        }
                                    ?>
                                        <a href="user_list" class="btn btn-warning">Cancel</a>
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