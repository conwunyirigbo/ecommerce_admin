<?php
session_start();
$title = "Product";
$menuid = "tproduct";
$group = "tproduct";
include('header.php');

$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
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


    function loadproducts(showloading, page = 0) {
        if (showloading == 1)
            document.getElementById('load').innerHTML = '<img src="img/loading.gif"/>';
        var searchkey = document.getElementById('searchkey').value;
        var status = document.getElementById('status').value;
        var brand = document.getElementById('brandid').value;
        var instock = document.getElementById('instock').value;
        var isonline = document.getElementById('isonline').value;
        var size = document.getElementById('size').value;
        var colour = document.getElementById('colour').value;
        var category = document.getElementById('category').value;

        var no_records = document.getElementById('norecords').value;
        if (page == 0) {
            page = document.getElementById('page_no').value;
        }


        var strURL = "../load/load_product.php?dt=" + (+new Date()) + "&no_records=" + no_records + "&page=" + page + "&searchkey=" + searchkey + "&status=" + status + "&brand=" + brand + "&instock=" + instock + "&isonline=" + isonline + "&size=" + size + "&colour=" + colour + "&category=" + category;
        var req = getXMLHTTP();

        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        // alert(req.responseText);
                        var result = JSON.parse(req.responseText);
                        document.getElementById('load').innerHTML = result.text;
                        document.getElementById('no_results').innerHTML = result.no_results + ' Products Found';
                        document.getElementById('pagination').innerHTML = result.pagination;
                        document.getElementById('pageno').innerHTML = "Page " + result.page;
                        document.getElementById('page_no').value = result.page;

                    } else {
                        //alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }
    }

    $(document).ready(function() {
        loadproducts(1);
        $('.filter').change(function() {
            loadproducts(1);
        })
    })

    function Delete(id) {
        if (confirm("Delete Product?")) {
            var datastring = {
                'id': id,
                'delete': 'product_list'
            };
            $.ajax({
                type: "POST",
                url: "../include/delete_ajax.php",
                data: datastring,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data.success == 1) {
                        loadproducts(0);
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                categoryClass: "toast-top-full-width",
                                showMethod: 'slideDown',
                                timeOut: 4000
                            };
                            toastr.success('Product deleted successfully');

                        }, 1300);
                    } else if (data.success == 2) {
                        setTimeout(function() {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                                categoryClass: "toast-top-full-width",
                                showMethod: 'slideDown',
                                timeOut: 6000
                            };
                            toastr.error('Product cannot be deleted. A customer has already purchased the product and it has not yet been delivered.');

                        }, 3000);
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
                    // alert('error handling here');
                }
            });
        }
    }

    function push(value, id) {
        var datastring = {
            'id': id,
            'value': value
        };
        $.ajax({
            type: "GET",
            url: "pushonline.php",
            data: datastring,
            dataType: 'html',
            cache: false,
            success: function(data) {
                loadproducts(0);
            },
            error: function() {
                // alert('error handling here');
            }
        });

    }

    function changeStatus(table, id, status, stock = "") {
        var datastring = {
            'id': id,
            'table': table,
            'status': status,
            'stock': stock
        };
        $.ajax({
            type: "GET",
            url: "changestatus.php",
            data: datastring,
            dataType: 'json',
            cache: false,
            success: function(data) {
                loadproducts(0);
            },
            error: function() {
                //alert('error handling here');
            }
        });
    }
</script>

<style>
    .text-success {
        color: #009900 !important;
    }
</style>
<input type="hidden" id="page_no" value="1" />
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <div class="row">
                    <div class="col-md-2">
                        Products
                    </div>
                    <div class="col-md-10">
                    </div>
                </div>

            </header>
            <div class="panel-body">
                <div class="row row-pad">
                    <div class="col-md-3">
                        <input type="text" class="form-control filter" placeholder="search..." id="searchkey" />
                    </div>
                    <div class="col-md-3">
                        <select class="form-control filter" id="status">
                            <option value="">--All--</option>
                            <option value="1">Active</option>
                            <option value="0">In-active</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control filter" id="colour">
                            <option value="">--All Colours--</option>
                            <?php
                            $sql = "select id,name from colour order by name";
                            $q = $con->select_query($sql);
                            foreach ($q as $r) {
                                echo '<option value="' . $r['id'] . '">' . $r['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control filter" id="size">
                            <option value="">--All Sizes--</option>
                            <?php
                            $sql = "select id,name from size order by name";
                            $q = $con->select_query($sql);
                            foreach ($q as $r) {
                                echo '<option value="' . $r['id'] . '">' . $r['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row row-pad">
                    <div class="col-md-3">
                        <select class="form-control filter" id="isonline">
                            <option value="">--All (online/offline)--</option>
                            <option value="1">Online Store</option>
                            <option value="0">Offline Store</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control filter" id="instock">
                            <option value="">--All (in stock/out of stock)--</option>
                            <option value="1">In stock</option>
                            <option value="0">Out of stock</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control filter" id="brandid">
                            <option value="">--All brands--</option>
                            <?php
                            $sql = "select id,name from brand where status=1";
                            $q = $con->select_query($sql);
                            foreach ($q as $r) {
                                echo '<option value="' . $r['id'] . '">' . $r['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control filter" id="category">
                            <option value="">--category--</option>
                            <?php
                            $sql = "select id,name from category order by name";
                            $q = $con->select_query($sql);
                            foreach ($q as $r) {
                                echo '<option value="' . $r['id'] . '">' . $r['name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="row row-pad">
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

                    <div class="col-lg-3">
                        <input type="number" class="form-control" onchange="loadproducts(1, this.value)" placeholder="Enter page number" id="spageno" />
                    </div>

                    <div class="col-md-6">
                        <?php
                        if ($authaddnew) {
                        ?>
                            <a href="product_setup" style="min-width: 200px" class="btn btn-success pull-right">Add New</a>
                        <?php
                        }
                        ?>
                        <a href="javascript:;" onclick="loadproducts(1)" class="btn btn-info pull-right" style="margin-right: 10px" title="Refresh"><i class="icon-refresh"></i> Refresh</a>
                    </div>

                </div>
                <div class="row row-pad">
                    <div class="col-md-12 table-responsive">
                        <i class="text-warning" id="no_results"></i> - <i class="text-success" id="pageno"></i>
                        <table class="table table-bordered table-hover smaller">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Product</th>
                                    <th>Photos</th>
                                    <th>Colours</th>
                                    <th>Sizes</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Online/Offline</th>
                                    <th>Availability</th>
                                    <th>Date Created</th>
                                    <?php
                                    if ($_SESSION['user_role'] != ORDER_ADMIN_USER_KEY) {
                                    ?>
                                        <th colspan="3">Actions</th>
                                    <?php
                                    }
                                    ?>
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
                        <span><strong>Note:</strong> <i style="color: #ff0000">Stock level comes from only 2 locations (Wuse and Gwarimpa)</i></span>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>


<?php
include('footer.php');
?>