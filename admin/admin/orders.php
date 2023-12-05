<?php 
session_start();
$title = "Orders";
$menuid = "torder";
$group = "torder";
include('header.php');

$page = 1;
if(isset($_GET['page']))
{
    $page = $_GET['page'];
}

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

function getCity(stateid) {		
	
	var strURL="../utility/getcity.php?stateid="+stateid;
	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {						
					document.getElementById('cityid').innerHTML=req.responseText;		
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}


function loadorders(showloading,page=0) {
	if(showloading == 1)		
	document.getElementById('load').innerHTML='<img src="img/loading.gif"/>';
	var searchkey = document.getElementById('searchkey').value;
	var status =  document.getElementById('status').value;
	var brand =  document.getElementById('brandid').value;
	var city =  document.getElementById('cityid').value;
	var state =  document.getElementById('stateid').value;
	var fromdate =  document.getElementById('fromdate').value;
	var todate =  document.getElementById('todate').value;
	var category =  document.getElementById('category').value;
	var staff =  document.getElementById('staff').value;

	var no_records = document.getElementById('norecords').value;
	if(page == 0)
	{
		page = "<?php echo $page?>";
	}
	var strURL="../load/load_orders.php?dt=" + (+new Date())+"&no_records="+no_records+"&page="+page+"&status="+status+"&category="+category+"&searchkey="+searchkey+"&state="+state+"&city="+city+"&brand="+brand+"&startdate="+fromdate+"&enddate="+todate+"&brand="+brand+"&staff="+staff;

	var req = getXMLHTTP();

	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {	
					//alert(req.responseText);
					var result = JSON.parse(req.responseText);	
					document.getElementById('load').innerHTML=result.text;
					document.getElementById('pagination').innerHTML=result.pagination;
					document.getElementById('filtertext').innerHTML = result.filter;
					document.getElementById('pageno').innerHTML = "Page " + result.page;
					document.getElementById('no_results').innerHTML = result.no_results+' Orders Found';				
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
	var page = "<?php echo $page?>";
	loadorders(1,page);
	$('.filter').change(function(){
		loadorders(1,page);
	})
})

function Delete(id)
{
	if(confirm("Delete Order?"))
	{
    	var datastring = {'id':id,'delete':'order_list'};
    	$.ajax({
    	            type: "POST",
    	            url: "../include/delete_ajax.php",
    	            data: datastring,
    	            dataType: 'json',
    	            cache: false,
    	            success: function(data) {
    	            	if(data.success == 1)
    	            	{       
    	            		loadorders(0);    		
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

function changeStatus()
{
	var status = $('#cstatus').val();
	var id = $('#orderid').val();
	var datastring = {'id':id,'table': 'orders', 'status' : status, 'stock': ""};
	$.ajax({
	            type: "GET",
	            url: "changestatus.php",
	            data: datastring,
	            dataType: 'json',
	            cache: false,
	            success: function(data) {
	            	loadorders(0);
	            },
	            error: function(){
	                  alert('error handling here');
	            }
	        });
}

function saveStaffDelivery(orderid, staffid) {		
	
	var strURL="save_staff_order.php?staff_id="+staffid+"&order_id="+orderid;
	var req = getXMLHTTP();
	
	if (req) {
		
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {							
				} else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}		
}

function setId(id,orderno)
{
	$('#orderid').val(id);
	$('#orderno').val(orderno);
}
</script>
	
<style>
.text-success
{
	color: #009900!important;	
}
</style>
	<div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              <div class="row">
                                <div class="col-md-9">
                                    Orders
                                </div>
                                <div class="col-md-3">
                                          <div class="btn-group pull-right">
                                                  <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button"> Print <span class="caret"></span> </button>
                                                  <ul class="dropdown-menu">
                                                      <li><a href="../utility/exportpdf.php">Print to PDF</a></li>
                                                      <li class="divider"></li>
                                                      <li><a href="javascript:;" onclick="printContent('printcontent')">Print</a></li>
                                                      
                                                  </ul>
                                    
                                 </div>
                                </div>
                              </div>
                              
                          </header>
                          <div class="panel-body">
                              <div class="row row-pad">                                            
                                            <div class="col-md-3">
                                                <input type="text" class="form-control filter" placeholder="search order id, product, customer, " id="searchkey"/>
                                                <?php 
                                                if(isset($_GET['user']))
                                                {
                                                    echo '<script>document.getElementById("searchkey").value="'.$_GET['user'].'"</script>';
                                                }
                                                
                                                ?>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control filter" id="status">
                                                    <option value="">--All status--</option>
                                                    <option value="<?php echo ORDER_PENDING_DELIVERY?>">Pending Order</option>
                                                    <option value="<?php echo ORDER_PROCESSING?>">Processing Order</option>
                                                    <option value="<?php echo ORDER_READY_TO_SHIP?>">Ready to Ship</option>
                                                    <option value="<?php echo ORDER_SHIPPED?>">In Transit (Left Depot)</option>
                                                    <option value="<?php echo ORDER_DELIVERED?>">Delivered</option>
                                                    <option value="<?php echo ORDER_NOT_COMPLETED?>">Not Completed</option>
                                                    <option value="<?php echo ORDER_CANCELLED?>">Cancelled</option>
                                                </select>
                                                <?php 
                                                if(isset($_GET['status']))
                                                {
                                                    echo '<script>document.getElementById("status").value="'.$_GET['status'].'"</script>';
                                                }
                                                
                                                ?>
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-control filter" id="category">
                                                    <option value="">--category--</option>
                                                    <?php 
                                                    $sql = "select id,name from category order by name";
                                                    $q = $con->select_query($sql);
                                                    foreach ($q as $r)
                                                    {
                                                        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4" id="data_5">
                                                    <div class="input-daterange input-group" id="datepicker" style="width: 100%">
                                                        <input type="text" class="input-sm form-control filter" id="fromdate"/>
                                                        <span class="input-group-addon">to</span>
                                                        <input type="text" class="input-sm form-control filter" id="todate"/>
                                                    </div>
                                             </div>
                                        </div>
                                        <div class="row row-pad">
                                            <div class="col-md-3">
                                                <select class="form-control filter" id="stateid" onchange="getCity(this.value)">
                                                    <option value="">--state--</option>
                                                    <?php 
                                                    $sql = "select id,name from state where status=1 order by name";
                                                    $q = $con->select_query($sql);
                                                    foreach ($q as $r)
                                                    {
                                                        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control filter" id="cityid">
                                                    <option value="">--city--</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control filter" id="brandid">
                                                    <option value="">--All brands--</option>
                                                    <?php 
                                                                    $sql = "select id,name from brand where status=1";
                                                                    $q=$con->select_query($sql);
                                                                    foreach($q as $r)
                                                                    {
                                                                        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                                                                    }
                                                                ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-1" style="width: 4%"><span class="pull-left">Show</span></div>
                                            <div class="col-lg-2">
                                               <select id="norecords" class="form-control pull-left filter">
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                    <option value="100" selected>100</option>
                                                    <option value="200">200</option>
                                                    <option value="0">All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row row-pad">
                                            <div class="col-md-4">
                                                <select class="form-control filter" id="staff">
                                                    <option value="">--select delivery staff--</option>
                                                    <?php 
                                                    $sql = "select id,name from delivery_staff order by name";
                                                    $q = $con->select_query($sql);
                                                    foreach ($q as $r)
                                                    {
                                                        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="printcontent">
                                            <div class="row row-pad">
                                                <div class="col-md-12"><span id="filtertext" class="text-warning"></span></div>    
                                            </div>
                                            <div class="row row-pad">
                                                <div class="col-md-12 table-responsive">
                                                    <i class="text-warning" id="no_results"></i> - <i class="text-success" id="pageno"></i>
                                                    <table class="table table-bordered table-hover smaller">
                                                        <thead>
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Order ID</th>
                                                                <th>Customer</th>
                                                                <th>Shipping Address</th>
                                                                <th>Items</th>
                                                                <th>Total Paid</th>
                                                                <th>Status</th>
                                                                <th>Order Date</th>
                                                                <th>Transaction Ref</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="load"></tbody>
                                                        <tfoot>
                                                <tr>
                                                    <td colspan="11" class="footable-visible hideprint" id="pagination">
                                                        
                                                    </td>
                                                </tr>
                                                </tfoot>
                                                    </table>
                                               </div>
                                           </div>
                                </div>
                          </div>
                      </section>

                  </div>
              </div>

              <!-- Party/club Modal start -->
<div class="modal fade" id="statusmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title">Change Status <i id="orderno"></i></h4>
</div>
<div class="modal-body">
    <form method="post" action="statusform" id="statusform">     
    
     <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Select Status</label>
                <select class="form-control" id="cstatus">
                                                    <option value="">--select status--</option>
                                                    <?php 
                                                    if(($auth->HasView('pending') && $auth->HasAuth('pending')) || $super_authorize)
                                                    {
                                                    ?>
                                                    <option value="<?php echo ORDER_PENDING_DELIVERY?>">Pending Order</option>
                                                    <?php 
                                                    }
                                                    if(($auth->HasView('processing') && $auth->HasAuth('processing')) || $super_authorize)
                                                    {
                                                    ?>
                                                    <option value="<?php echo ORDER_PROCESSING?>">Processing Order</option>
                                                    <?php 
                                                    }
                                                    if(($auth->HasView('ready_to_ship') && $auth->HasAuth('ready_to_ship')) || $super_authorize)
                                                    {
                                                    ?>
                                                    <option value="<?php echo ORDER_READY_TO_SHIP?>">Ready to Ship</option>
                                                    <?php 
                                                    }
                                                    if(($auth->HasView('shipped') && $auth->HasAuth('shipped')) || $super_authorize)
                                                    {
                                                    ?>
                                                    <option value="<?php echo ORDER_SHIPPED?>">In Transit (Left Depot)</option>
                                                    <?php 
                                                    }
                                                    if(($auth->HasView('delivered') && $auth->HasAuth('delivered')) || $super_authorize)
                                                    {
                                                    ?>
                                                    <option value="<?php echo ORDER_DELIVERED?>">Delivered</option>
                                                    <?php 
                                                    }
                                                    if(($auth->HasView('cancelled') && $auth->HasAuth('cancelled')) || $super_authorize)
                                                    {
                                                    ?>
                                                    <option value="<?php echo ORDER_CANCELLED?>">Cancelled</option>
                                                    <?php 
                                                    }
                                                    ?>
                                                    
                                                </select>
            </div>
            <div class="form-group">
                <input type="button" name="changestatus" onclick="changeStatus()" value="Change Status" class="btn btn-success" data-dismiss="modal"/>
            </div>
        </div>
     </div>       
              
    <div class="modal-footer">
        <input type="hidden" id="orderid" value=""/>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
    </form>
 </div>
</div> 
</div> 
</div> 
<!-- Party/club Modal end -->

<?php 
include('footer.php');
?>