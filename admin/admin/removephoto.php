<?php
include('../include/connection.php');
$sql = "delete from product_photos where id=:id";
$q = $con->delete_query($sql,array(':id'=>$_GET['id']));
if($q)
{
    echo '<div class="col-md-3">
                                                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                          <div class="fileupload-new thumbnail" style="min-width: 100%; height:150px;">
                                                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                                                          </div>
                                                                          <div class="fileupload-preview fileupload-exists thumbnail" style="height: 150px; line-height: 20px;"></div>
                                                                          <div>
                                                                           <span class="btn btn-white btn-file btn-xs">
                                                                           <span class="fileupload-new"><i class="icon-paper-clip"></i> Select image</span>
                                                                           <span class="fileupload-exists"><i class="icon-undo"></i> Change</span>
                                                                           <input type="file" id="photo'.$_GET['count'].'" name="photo'.$_GET['count'].'" class="default"/>
                                                                           </span>
                                                                              <a href="#" class="btn btn-danger fileupload-exists btn-xs" data-dismiss="fileupload"><i class="icon-trash"></i> Remove</a>
                                                                          </div>
                                                                        </div>
                                                                    </div>';
}
?>