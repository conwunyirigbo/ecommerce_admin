<?php
session_start();
$title = "Category";
$menuid = "tcategory";
$group = "tcategory";
include('header.php');
?>

<script>
	function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp = false;
		try {
			xmlhttp = new XMLHttpRequest();
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				try {
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e1) {
					xmlhttp = false;
				}
			}
		}

		return xmlhttp;
	}


	function loadcategories(showloading) {
		if (showloading == 1)
			document.getElementById('load').innerHTML = '<img src="img/loading.gif"/>';
		var searchkey = document.getElementById('searchkey').value;
		var status = document.getElementById('status').value;
		var type = document.getElementById('type').value;
		var strURL = "../load/load_category.php?searchkey=" + searchkey + "&status=" + status + "&type=" + type;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {
						document.getElementById('load').innerHTML = req.responseText;
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}
			}
			req.open("GET", strURL, true);
			req.send(null);
		}
	}

	$(document).ready(function() {
		loadcategories(1);
		$('.filter').change(function() {
			loadcategories(1);
		})
	})

	function Delete(id) {
		if (confirm("Delete category?")) {
			var datastring = {
				'id': id,
				'delete': 'category_list'
			};
			$.ajax({
				type: "POST",
				url: "../include/delete_ajax.php",
				data: datastring,
				dataType: 'json',
				cache: false,
				success: function(data) {
					if (data.success == 1) {
						loadcategories(0);
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
					} else {
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
				error: function() {
					alert('error handling here');
				}
			});
		}
	}

	function changeStatus(table, id, status) {
		var datastring = {
			'id': id,
			'table': table,
			'status': status
		};
		$.ajax({
			type: "GET",
			url: "changestatus.php",
			data: datastring,
			dataType: 'json',
			cache: false,
			success: function(data) {
				loadcategories(0);
			},
			error: function() {
				alert('error handling here');
			}
		});
	}
</script>

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Categories
			</header>
			<div class="panel-body">
				<div class="row row-pad">
					<div class="col-md-3">
						<select class="form-control filter" id="status">
							<option value="">--All status--</option>
							<option value="1">Active</option>
							<option value="0">In-active</option>
						</select>
					</div>
					<div class="col-md-3">
						<select class="form-control filter" id="type">
							<option value="">--All types--</option>
							<option value="<?php echo TOP_MENU_CATEGORY ?>" selected>Top Menu Category</option>
							<option value="<?php echo MASTER_CATEGORY ?>">Master Category</option>
							<option value="<?php echo SUB_CATEGORY ?>">Sub Category</option>
						</select>
					</div>
					<div class="col-md-3">
						<input type="text" class="form-control filter" placeholder="search..." id="searchkey" />
					</div>

					<div class="col-md-3">
						<?php
						if ($authaddnew) {
						?>
							<a href="category_setup" class="btn btn-success pull-right">Add New</a>
						<?php
						}
						?>
					</div>
				</div>
				<div class="row row-pad">
					<div class="col-md-12">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Order</th>
									<th>Code</th>
									<th>Name</th>
									<th>Type</th>
									<th>Show</th>
									<th>Status</th>
									<th>Date Updated</th>
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