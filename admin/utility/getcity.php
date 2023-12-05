<?php
include('../include/connection.php');
?>

<select class="sizefull s-text7 p-l-22 p-r-22" mame="cityid" id="cityid" required>
<?php 
if(isset($_GET['stateid']))
{
    echo '<option value="">--select city--</option>';
    $sql = "select id,name from city where stateid=:id AND status=1";
    $q=$con->select_query($sql,array(':id'=>$_GET['stateid']));
    foreach($q as $r)
    {
        echo '<option value="'.$r['id'].'">'.$r['name'].'</option>';
    }
}
?>
</select>