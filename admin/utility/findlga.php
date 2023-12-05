										<?php 
										include('../include/connection.php');
                                        $state=$_GET['state'];
                                        if(isset($_GET['select']))
                                        {
                                            echo '<select id="lgaid" data-placeholder="Select LGA" multiple style="width:350px;" tabindex="4" name="lga" class="chosen-select form-control filter" required style="color:#333">';
                                        }
										    $sql="select id,name from localgovt where state_id=:state order by name";
										    $fields=array(':state'=>$state);
										    $r=$con->select_query($sql,$fields);
										    if(!isset($_GET['no-first']))
										      echo '<option value="">--Select LGA--</option>';	
										    foreach($r as $row)
										    {
										        $selected = "";
										        if(isset($_GET['setvalue']) && ($row['id'] == $_GET['setvalue']))
										        {
										            $selected = "selected";
										        }
										        else if(isset($_GET['districtid']))
										        {
										            $sql = "select lga_id from districtlga where district_id=:id AND lga_id=:lga";
										            $q=$con->select_query($sql,array(':id'=>$_GET['districtid'], ':lga'=>$row['id']));
										            if(count($q) > 0)
										            {
										                $selected = "selected";
										            }
										        }
										        else if(isset($_GET['constid']))
										        {
										            $sql = "select lga_id from constlga where const_id=:id AND lga_id=:lga";
										            $q=$con->select_query($sql,array(':id'=>$_GET['constid'], ':lga'=>$row['id']));
										            if(count($q) > 0)
										            {
										                $selected = "selected";
										            }
										        }
										        echo'<option value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
										    }
										if(isset($_GET['select']))
										{
										    echo '</select>';
										}
										?>

										