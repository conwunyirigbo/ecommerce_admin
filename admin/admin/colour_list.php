<?php 
session_start();
$title = "Colours";
$menuid = "tcolour";
$group = "settings";
include('header.php');
?>

<script>
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


function loadcolours(showloading) {
	if(showloading == 1)		
	document.getElementById('load').innerHTML='<img src="img/loading.gif"/>';
	var searchkey = document.getElementById('searchkey').value;
	var status =  document.getElementById('status').value;
	var strURL="../load/load_colour.php?searchkey="+searchkey+"&status="+status;

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
	loadcolours(1);
	$('.filter').change(function(){
		loadcolours(1);
	})
})

function Delete(id)
{
	if(confirm("Delete colour?"))
	{
    	var datastring = {'id':id,'delete':'colour_list'};
    	$.ajax({
    	            type: "POST",
    	            url: "../include/delete_ajax.php",
    	            data: datastring,
    	            dataType: 'json',
    	            cache: false,
    	            success: function(data) {
    	            	if(data.success == 1)
    	            	{       
    	            		loadcolours(0);    		
    	            		setTimeout(function() {
    	                        toastr.options = {
    	                            closeButton: true,
    	                            progressBar: true,
    	                            colourClass: "toast-top-full-width",
    	                            showMethod: 'slideDown',
    	                            timeOut: 4000
    	                        };
    	                        toastr.success('colour deleted successfully');
    	                        
    	                    }, 1300);
    	            	}
    	            	else
    	            	{
    	            		setTimeout(function() {
    	                        toastr.options = {
    	                            closeButton: true,
    	                            progressBar: true,
    	                            colourClass: "toast-top-full-width",
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

function getColoursApi()
{
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
		            type: "GET",
		            url: "../api/getcolours.php",
		            dataType: 'json',
		            cache: false,
		            success: function(data) {
		            	$.unblockUI();
		            	loadbrands(1);
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
                              Colours
                          </header>
                          <div class="panel-body">
                              <div class="row row-pad">
                                            <div class="col-md-3">
                                                <select class="form-control filter" id="status">
                                                    <option value="">--All--</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">In-active</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control filter" placeholder="search..." id="searchkey"/>
                                            </div>
                                            <div class="col-md-6">
                                                <a href="javascript:;" onclick="getColoursApi()" style="margin-left: 7px;" class="btn btn-info pull-right">Update Colours</a>
                                                <a href="colour_setup" class="btn btn-success pull-right">Add New</a>
                                            </div>
                                        </div>
                                        <div class="row row-pad">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Colour</th>
                                                            <th>Name</th>
                                                            <th>Status</th>
                                                            <th>Date Created</th>
                                                            <th colspan="2">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load"></tbody>
                                                </table>
                                           </div>
                                       </div>

                          </div>
                      </section>

                  </div>
              </div>


<?php 
include('footer.php');
?>