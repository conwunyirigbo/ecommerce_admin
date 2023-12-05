<?php session_start();
$group="security";
$menu="users";
$menuid="users";
$submenu="";

$title="User Roles";
include('../admin/header.php'); 

if(isset($_POST['username']))
{
    $_SESSION['role_username'] = $_POST['username'];
}


?>
<script>
//Roshan's Ajax dropdown code with php
//This notice must stay intact for legal use
//Copyright reserved to Roshan Bhattarai - nepaliboy007@yahoo.com
//If you have any problem contact me at http://roshanbh.com.np
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
	
	function loadRoles() {		
		
		var strURL="addrole.php";
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


function AddRole(id) {
    $(document).ready(function(){
    	//alert(id);	
    		var datastring = {'roleid' : id}
    		$.ajax({
    		            type: "POST",
    		            url: "../security/addrole.php",
    		            data: datastring,
    		            cache: false,
    		            success: function(data) {
    		                $("#load").html(data);
    		                $('#allroles').show();
    		            },
    		            error: function(){
    		                  alert('error handling here');
    		            }
    		        });
    	
    });
}


function RemoveRole(id) {
    $(document).ready(function(){
    	//alert(id);	
    		var datastring = {'remove_roleid' : id}
    		$.ajax({
    		            type: "POST",
    		            url: "../security/addrole.php",
    		            data: datastring,
    		            cache: false,
    		            success: function(data) {
    		                $("#load").html(data);
    		                $('#allroles').show();
    		            },
    		            error: function(){
    		                  alert('error handling here');
    		            }
    		        });
    	
    });
}

$(document).ready(function(){
	$('#addrolebtn').click(function(){
		$('#allroles').fadeIn('fast');
		$('#closerolebtn').fadeIn('fast');
	});

	$('#closerolebtn').click(function(){
		$('#allroles').fadeOut('fast');
		$('#closerolebtn').fadeOut('fast');
	});
	
});
</script>

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div id="content-header" class="clearfix">
                        <div class="pull-left">
                        <h1>User Roles : <span class="label label-primary"><?php echo $_SESSION['role_username'];?></span></h1>
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="row row-pad">
                   <small><a href="../security/users">Users </a> <span class="fa fa-angle-right"> </span> <?php echo $_SESSION['role_username']; ?> </small>
            </div>
            <div class="main-box clearfix">
                <div class="row row-pad">
                    <div class="col-md-5">
                        <a href="#" id="addrolebtn" class="btn btn-success btn-xs pull-right">Add Role</a>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <a href="#" class="btn btn-info btn-xs pull-right" id="closerolebtn" style="display:none">Close</a>
                    </div>
                </div>
                <div class="row" id="load">
                     <script>loadRoles();</script>
                </div>
            </div>
        </div>
  </div>
<?php include('../admin/footer.php'); ?>