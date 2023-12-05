<?php
session_start();
$title = "Banner Setup";
$menuid = "tbanner";
$group = "tbanner";
include('header.php');

if (!$authupdate && !$authaddnew) {
    echo '<script>window.location="index"</script>';
}

$photo = "";
$title = "";
$position = SLIDER_POSITION;
$size = "";
$url = "";
$phototitle = "";
$status = "";
$showbutton = "";
$buttontext = "";
$order = "";
$category = "";
if (isset($_GET['id'])) {
    $sql = "select * from banner where id=:id";
    $q = $con->select_query($sql, array(':id' => $_GET['id']));
    foreach ($q as $r) {
        $photo = $r['photo'];
        $position = $r['position'];
        $size = $r['size'];
        $url = $r['url'];
        $title = $r['title'];
        $phototitle = $r['phototitle'];
        $status = $r['status'];
        $showbutton = $r['showbutton'];
        $buttontext = $r['buttontext'];
        $order = $r['bannerorder'];
        $category = $r['category'];
    }
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


    function getBannerSizes() {
        var position = document.getElementById('banner_position').value;
        var strURL = "getbannersizes.php?position=" + position;

        var req = getXMLHTTP();

        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        document.getElementById('banner_size').innerHTML = req.responseText;
                        var size = "<?php echo $size ?>";
                        if (size != "") {
                            document.getElementById('banner_size').value = size;
                        }
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }
    }

    function SaveInsert() {
        var fileUpload = $("#photo").get(0);
        var files = fileUpload.files;
        var data = new FormData();
        for (var i = 0; i < files.length; i++) {
            data.append('photo', files[i], files[i].name);
        }

        var datastring = $("#bannerform").serializeArray();
        $.each(datastring, function(key, input) {
            data.append(input.name, input.value);
        });

        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });

        $.ajax({
            type: "POST",
            url: "../include/insert_ajax.php",
            contentType: false,
            processData: false,
            data: data,
            dataType: 'json',
            cache: false,
            success: function(data) {
                $.unblockUI();
                $('html,body').animate({
                    scrollTop: 0
                }, 'fast');
                $('#msg').html(data.msg);
                if (data.success == 1) {
                    $("input[type='text'], textarea, input[type='password']").val("");
                }
            },
            error: function() {
                alert('error handling here');
            }
        });
    }

    function SaveUpdate() {
        var fileUpload = $("#photo").get(0);
        var files = fileUpload.files;
        var data = new FormData();
        for (var i = 0; i < files.length; i++) {
            data.append('photo', files[i], files[i].name);
        }

        var datastring = $("#bannerform").serializeArray();
        $.each(datastring, function(key, input) {
            data.append(input.name, input.value);
        });

        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });

        $.ajax({
            type: "POST",
            url: "../include/update_ajax.php",
            contentType: false,
            processData: false,
            data: data,
            dataType: 'json',
            cache: false,
            success: function(data) {
                $.unblockUI();
                $('html,body').animate({
                    scrollTop: 0
                }, 'fast');
                $('#msg').html(data.msg);
            },
            error: function() {
                alert('error handling here');
            }
        });
    }

    $(document).ready(function() {
        getBannerSizes();
    })
</script>

<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Banner Setup
            </header>
            <div class="panel-body">
                <form class="form" action="banner_setup" method="post" id="bannerform">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div id="msg"></div>
                                </div>

                                <div class="form-group">
                                    <label for="projectinput1">Position</label>
                                    <select name="position" id="banner_position" class="form-control" onchange="getBannerSizes()">
                                        <option value="<?php echo SLIDER_POSITION ?>">Slider Position</option>
                                        <option value="<?php echo BELOW_SLIDER_POSITION ?>">Below Slider Position</option>
                                        <option value="<?php echo MIDDLE_BANNER_POSITION ?>">Middle Position</option>
                                        <option value="<?php echo BOTTOM_BANNER_POSITION ?>">Bottom Position</option>
                                        <option value="<?php echo CATEGORY_TOP_POSITION ?>">Category Top Position</option>
                                        <option value="<?php echo POP_UP_POSITION ?>">Pop up</option>
                                    </select>
                                    <script>
                                        document.getElementById('banner_position').value = "<?php echo $position ?>"
                                    </script>
                                </div>

                                <div id="bannersizediv"></div>

                                <div class="form-group">
                                    <label for="projectinput1">Select Size</label>
                                    <select name="size" id="banner_size" class="form-control">
                                        <option value="">--select size--</option>
                                        <option value="<?php echo FOUR_SMALL_BANNER_SIZE ?>">Four/Row Small Banners (<?php echo FOUR_SMALL_BANNER_SIZE; ?>)</option>
                                        <option value="<?php echo THREE_SMALL_BANNER_SIZE ?>">Three/Row Small Banners (<?php echo THREE_SMALL_BANNER_SIZE; ?>)</option>
                                        <option value="<?php echo TWO_HALF_WIDTH_BANNER_SIZE ?>">Two/Row Half Banners (<?php echo TWO_HALF_WIDTH_BANNER_SIZE; ?>)</option>
                                        <option value="<?php echo ONE_FULL_WIDTH_BANNER_SIZE ?>">One Full Width Banner (<?php echo ONE_FULL_WIDTH_BANNER_SIZE; ?>)</option>
                                    </select>
                                    <?php
                                    if (!empty($size)) {
                                    ?>
                                        <script>
                                            document.getElementById('banner_size').value = "<?php echo $size ?>"
                                        </script>
                                    <?php
                                    }
                                    ?>
                                </div>


                                <div class="form-group">
                                    <label for="projectinput1">Banner Text</label>
                                    <input type="text" class="form-control" value="<?php echo $title ?>" name="title">
                                </div>

                                <div class="form-group">
                                    <label for="projectinput1">URL</label>
                                    <input type="text" id="projectinput1" class="form-control" value="<?php echo $url ?>" name="url">
                                </div>

                                <div class="form-group">
                                    <label for="projectinput1">Photo</label>
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="min-width: 250px; height:150px;">
                                            <?php
                                            if (isset($_GET['id'])) {
                                                echo '<img src="' . UPLOADS_FOLDER . $photo . '" alt="" />';
                                            } else {
                                                echo '<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />';
                                            }
                                            ?>
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="height: 150px; line-height: 20px;"></div>
                                        <div>
                                            <span class="btn btn-white btn-file btn-xs">
                                                <span class="fileupload-new"><i class="icon-paper-clip"></i> Change</span>
                                                <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                <input type="hidden" name="oldphoto" value="<?php echo $photo ?>" />
                                                <input type="file" id="photo" name="photo" class="default" />
                                            </span>
                                            <a href="#" class="btn btn-danger fileupload-exists btn-xs" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="projectinput1">Photo Title</label>
                                    <input type="text" id="projectinput1" class="form-control" value="<?php echo $phototitle ?>" name="phototitle">
                                    <small>(For Search Optimization)</small>
                                </div>

                                <div class="form-group">
                                    <label for="projectinput1">Banner Order</label>
                                    <input type="number" id="slideorder" class="form-control" value="<?php echo $order ?>" name="bannerorder">
                                </div>

                                <div class="form-group skin skin-square">
                                    <fieldset>
                                        <input type="checkbox" class="i-checks" id="status" name="status" <?php echo ($status == 1 ? "checked" : "") ?> /> </label>
                                        <label for="input-11">Active</label>
                                    </fieldset>
                                </div>

                                <div class="form-group skin skin-square" id="checkbuttondiv">
                                    <fieldset>
                                        <input type="checkbox" class="i-checks" onclick="checkButton()" id="showbutton" name="showbutton" <?php echo ($showbutton == 1 ? "checked" : "") ?> /> </label>
                                        <label for="input-11">Show Call to Action Button</label>
                                    </fieldset>
                                </div>

                                <?php
                                $display = "none";
                                if ($showbutton == 1) {
                                    $display = "block";
                                }
                                ?>
                                <div class="form-group" id="buttontextdiv" style="display: <?php echo $display ?>">
                                    <label for="projectinput1">Button Text</label>
                                    <input type="text" id="buttontext" class="form-control" value="<?php echo $buttontext ?>" name="buttontext">
                                </div>

                                <div class="form-group skin skin-square">
                                    <?php
                                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    ?>
                                        <input type="hidden" name="update" value="banner_setup" />
                                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />
                                        <button type="button" class="btn btn-primary" onclick="SaveUpdate()">
                                            <i class="la la-check-square-o"></i> Save
                                        </button>
                                    <?php
                                    } else {
                                    ?>
                                        <input type="hidden" name="insert" value="banner_setup" />
                                        <button type="button" class="btn btn-success" onclick="SaveInsert()">
                                            <i class="la la-check-square-o"></i> Save
                                        </button>
                                    <?php
                                    }
                                    ?>
                                    <a href="banner_list" class="btn btn-warning mr-1">
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